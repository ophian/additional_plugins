/*
 * jQuery Autocomplete plugin 2.0.0 https://github.com/onigoetz/jquery.autocomplete
 * jQuery Autocomplete plugin 1.2.3 https://github.com/agarzola/jQueryAutocompletePlugin
 *
 * Copyright (c) 2009 Jörn Zaefferer
 *
 * Dual licensed under the MIT and GPL licenses:
 *   http://www.opensource.org/licenses/mit-license.php
 *   http://www.gnu.org/licenses/gpl.html
 *
 * With small modifications by Alfonso Gómez-Arzola.
 * See changelog for details.
 *
 */
/* 07/2023 - fix size() is not a function issue, while deprecated in JQuery version: 1.8 and removed in: 3.0. Replaced by .length property. */
/* 08/2025 - fix jQuery.isArray() is not a function issue, while deprecated in JQuery version: 3.0 and removed in: 4.0. Replaced by Array.isArray(). */

;
(function ($) {
    "use strict";
var Autocompleter = {
    data_key: "ac-data",
    key: "autocomplete",
    defaults: {
        appendTo: null,
        autoFocus: false,
        delay: 300,
        minLength: 1,
        position: {
            my: "left top",
            at: "left bottom",
            collision: "none"
        },
        source: null,

        // callbacks
        change: null,
        close: null,
        focus: null,
        open: null,
        response: null,
        search: null,
        select: null,

        //TODO :: Extensions
        //_renderItem( ul, item )
        //_renderMenu( ul, items )
        //_resizeMenu()

        //fill the rest of the field while typing
        //autoFill: false,

        //make the menu scrollable
        scroll: true,
        scrollHeight: 180
    }
};
$.Autocompleter = function (input, options) {
    if($(input).data(Autocompleter.key)) {
        return;
    }

    var keys = {UP: 38, DOWN: 40,DEL: 46, TAB: 9, ENTER: 13, ESCAPE: 27, PGUP: 33, PGDN: 34, BACKSPACE: 8},
        cancelBlur, selectedItem, previous, isMultiLine, valueMethod, searching, term, source, xhr, cancelSearch,
        class_input = "ac-input", class_disabled = "ac-disabled", class_loading = "ac-loading",
        that = this, requestIndex = 0, pending = 0,
        eventNamespace = ".autocomplete",

        $input = $(input).data(Autocompleter.key, this),
        menu = Menu(options, input);

    _create();

    function _create() {
        // Some browsers only repeat keydown events, not keypress events,
        // so we use the suppressKeyPress flag to determine if we've already
        // handled the keydown event. #7269
        // Unfortunately the code for & in keypress is the same as the up arrow,
        // so we use the suppressKeyPressRepeat flag to avoid handling keypress
        // events when we know the keydown event was used to modify the
        // search term. #7799
        var suppressKeyPress, suppressKeyPressRepeat, suppressInput,
            nodeName = $input[ 0 ].nodeName.toLowerCase(),
            isTextarea = nodeName === "textarea",
            isInput = nodeName === "input";

        isMultiLine =
            // Textareas are always multi-line
            isTextarea ? true :
                // Inputs are always single-line, even if inside a contentEditable element
                // IE also treats inputs as contentEditable
                isInput ? false :
                    // All other element types are determined by whether or not they're contentEditable
                    $input.prop("isContentEditable");

        valueMethod = $input[ isTextarea || isInput ? "val" : "text" ];

        $input
            .addClass(class_input)
            .attr("autocomplete", "off");

        _on($input, {
            keydown: function (event) {
                if ($input.prop("readOnly")) {
                    suppressKeyPress = true;
                    suppressInput = true;
                    suppressKeyPressRepeat = true;
                    return;
                }

                suppressKeyPress = false;
                suppressInput = false;
                suppressKeyPressRepeat = false;
                switch (event.keyCode) {
                    case keys.PGUP:
                        suppressKeyPress = true;
                        _move("previousPage", event);
                        break;
                    case keys.PGDN:
                        suppressKeyPress = true;
                        _move("nextPage", event);
                        break;
                    case keys.UP:
                        suppressKeyPress = true;
                        _keyEvent("previous", event);
                        break;
                    case keys.DOWN:
                        suppressKeyPress = true;
                        _keyEvent("next", event);
                        break;
                    case keys.ENTER:
                        // when menu is open and has focus
                        if (menu.active) {
                            // #6055 - Opera still allows the keypress to occur
                            // which causes forms to submit
                            suppressKeyPress = true;
                            event.preventDefault();
                            menu.select(event);
                        }
                        break;
                    case keys.TAB:
                        if (menu.active) {
                            menu.select(event);
                        }
                        break;
                    case keys.ESCAPE:
                        if (menu.visible()) {
                            _value(term);
                            close(event);
                            // Different browsers have different default behavior for escape
                            // Single press can mean undo or clear
                            // Double press in IE means clear the whole form
                            event.preventDefault();
                        }
                        break;
                    default:
                        suppressKeyPressRepeat = true;
                        // search timeout should be triggered before the input value is changed
                        _searchTimeout(event);
                        break;
                }
            },
            keypress: function (event) {
                if (suppressKeyPress) {
                    suppressKeyPress = false;
                    if (!isMultiLine || menu.visible()) {
                        event.preventDefault();
                    }
                    return;
                }
                if (suppressKeyPressRepeat) {
                    return;
                }

                // replicate some key handlers to allow them to repeat in Firefox and Opera
                switch (event.keyCode) {
                    case keys.PGUP:
                        _move("previousPage", event);
                        break;
                    case keys.PGDN:
                        _move("nextPage", event);
                        break;
                    case keys.UP:
                        _keyEvent("previous", event);
                        break;
                    case keys.DOWN:
                        _keyEvent("next", event);
                        break;
                }
            },
            input: function (event) {
                if (suppressInput) {
                    suppressInput = false;
                    event.preventDefault();
                    return;
                }
                _searchTimeout(event);
            },
            focus: function () {
                selectedItem = null;
                previous = _value();
            },
            blur: function (event) {
                if (cancelBlur) {
                    cancelBlur = false;
                    return;
                }

                clearTimeout(searching);
                close(event);
                _change(event);
            }
        });

        _initSource();

        menu.element.on({
            mousedown: function (event) {
                // prevent moving focus out of the text field
                event.preventDefault();

                // IE doesn't prevent moving focus even with event.preventDefault()
                // so we set a flag to know when we should ignore the blur event
                cancelBlur = true;
                setTimeout(function () {
                    cancelBlur = false;
                }, 0);

                // clicking on the scrollbar causes focus to shift to the body
                // but we can't detect a mouseup or a click immediately afterward
                // so we have to track the next mousedown and close the menu if
                // the user clicks somewhere outside of the autocomplete
                var menuElement = menu.element[ 0 ];
                if (!$(event.target).closest(".ac-item").length) {
                    setTimeout(function () {
                        $(document).one("mousedown", function (event) {
                            if (event.target !== $input[ 0 ] &&
                                event.target !== menuElement && !$.contains(menuElement, event.target)) {
                                close();
                            }
                        });
                    }, 0);
                }
            },
            menufocus: function( event, ui ) {
                var item;

                item = ui.item.data(Autocompleter.data_key);
                if ( false !== _trigger( "focus", event, { item: item } ) ) {
                    // use value to match what will end up in the input, if it was a key event
                    if ( event.originalEvent && /^key/.test( event.originalEvent.type ) ) {
                        _value( item.value );
                    }
                }
            },
            menuselect: function (event, ui) {
                var item = ui.item.data(Autocompleter.data_key),
                    internalPrevious = previous;

                // only trigger when focus was lost (click on menu)
                if ($input[ 0 ] != document.activeElement) {
                    $input.focus();
                    previous = internalPrevious;
                    // #6109 - IE triggers two focus events and the second
                    // is asynchronous, so we need to reset the previous
                    // term synchronously and asynchronously :-(
                    setTimeout(function () {
                        previous = internalPrevious;
                        selectedItem = item;
                    }, 0);
                }

                if (false !== _trigger("select", event, { item: item })) {
                    _value(item.value);
                }
                // reset the term after the select event
                // this allows custom select handling to work properly
                term = _value();

                close(event);
                selectedItem = item;
            }
        });

        // turning off autocomplete prevents the browser from remembering the
        // value when navigating through history, so we re-enable autocomplete
        // if the page is unloaded before the widget is destroyed. #7790
        $(window).on('beforeunload', function () {
            $input.removeAttr("autocomplete");
        });
    }

    /**
     * Bind events with namespace
     *
     * @param element the elements to bind events to
     * @param events an object with events to bind
     * @private
     */
    function _on(element, events) {
        for (var i in events) {
            if (events.hasOwnProperty(i)) {
                element.on(i + eventNamespace, events[i]);
            }
        }
    }

    function _initSource() {
        var array, url;
        if (Array.isArray(options.source)) {
            array = options.source;
            source = function (request, response) {
                response($.ui.autocomplete.filter(array, request.term));
            };
        } else if (typeof options.source === "string") {
            url = options.source;
            source = function (request, response) {
                if (xhr) {
                    xhr.abort();
                }
                xhr = $.ajax({
                    url: url,
                    data: request,
                    dataType: "json",
                    success: function (data) {
                        response(data);
                    },
                    error: function () {
                        response([]);
                    }
                });
            };
        } else {
            source = options.source;
        }
    }

    function _searchTimeout(event) {
        clearTimeout(searching);
        searching = setTimeout(function () {
            // only search if the value has changed
            if (term !== _value()) {
                selectedItem = null;
                search(null, event);
            }
        }, options.delay);
    }

    function search(value, event) {
        value = value !== null ? value : _value();

        // always save the actual value, not the one passed as an argument
        term = _value();

        if (value.length < options.minLength) {
            return close(event);
        }

        if (_trigger("search", event) === false) {
            return;
        }

        return _search(value);
    }

    function _search(value) {
        pending++;
        $input.addClass(class_loading);
        cancelSearch = false;

        source({ term: value }, _response());
    }

    function _response() {
        var index = ++requestIndex;

        return function (content) {
            if (index === requestIndex) {
                __response(content);
            }

            pending--;
            if (!pending) {
                $input.removeClass(class_loading);
            }
        };
    }

    function __response(content) {
        if (content) {
            content = _normalize(content);
        }
        _trigger("response", null, { content: content });
        if (!options.disabled && content && content.length && !cancelSearch) {
            menu.suggest(content);
            _trigger("open");
        } else {
            // use _close() instead of close() so we don't cancel future searches
            _close();
        }
    }

    function close(event) {
        cancelSearch = true;
        _close(event);
    }

    function _close(event) {
        if (menu.visible()) {
            menu.hide();
            _trigger("close", event);
        }
    }

    function _change(event) {
        if (previous !== _value()) {
            _trigger("change", event, { item: selectedItem });
        }
    }

    function _normalize(items) {
        // assume all items have the right format when the first item is complete
        if (items.length && items[ 0 ].label && items[ 0 ].value) {
            return items;
        }
        return $.map(items, function (item) {
            if (typeof item === "string") {
                return {
                    label: item,
                    value: item
                };
            }
            return $.extend({}, item, {
                label: item.label || item.value,
                value: item.value || item.label
            });
        });
    }

    function _move(direction, event) {
        if (!menu.visible()) {
            search(null, event);
            return;
        }
        menu[ direction ](event);
    }

    function _value() {
        return valueMethod.apply($input, arguments);
    }

    function _keyEvent(keyEvent, event) {
        if (!isMultiLine || menu.visible()) {
            _move(keyEvent, event);

            // prevents moving cursor to beginning/end of the text field in some browsers
            event.preventDefault();
        }
    }

    function _trigger(type, event, data) {
        var prop, orig, callback = options[ type ];

        data = data || {};
        event = $.Event(event);
        event.type = type;

        // the original event may come from any element
        // so we need to reset the target on the new event
        event.target = input;

        // copy original event properties over to the new event
        orig = event.originalEvent;
        if (orig) {
            for (prop in orig) {
                if (event.hasOwnProperty(prop) && !(prop in event)) {
                    event[ prop ] = orig[ prop ];
                }
            }
        }

        $input.trigger(event, data);
        return !( $.isFunction(callback) &&
            callback.apply(input, [ event ].concat(data)) === false ||
            event.isDefaultPrevented() );
    }


    function _setOptions(options) {
        var key;

        for (key in options) {
            _setOption(key, options[ key ]);
        }

        return that;
    }

    function _setOption(key, value) {
        options[key] = value;
        if (key === "source") {
            _initSource();
        }

        if (key === "appendTo") {
            menu.reappend();
        }

        if (key === "disabled") {
            if (value && xhr) {
                xhr.abort();
            }

            $input.toggleClass(class_disabled, !!value);
        }

        return that;
    }

    // Public API
    this.search = search;
    this.close = close;

    this.option = function (key, value) {
        if (arguments.length === 0) {
            return $.extend(true, {}, options);
        }

        if (arguments.length === 1) {
            return options[ key ] === undefined ? null : options[ key ];
        }

        _setOptions(key);

        return this;
    };

    this.enable = function () {
        return _setOption('disabled', false);
    };

    this.disable = function () {
        return _setOption('disabled', true);
    };

    this.widget = function () {
        return $input;
    };

    this.destroy = function () {
        clearTimeout(searching);
        $input
            .data('autocomplete', null)
            .removeClass(class_input)
            .removeAttr("autocomplete")
            .off(eventNamespace);

        menu.destroy();
    };
};

//jQuery UI Compatibility
$.ui = $.ui || {};
$.ui.autocomplete = $.ui.autocomplete || {};

$.ui.autocomplete.filter = function (array, term) {
    var matcher = new RegExp($.ui.autocomplete.escapeRegex(term), "i");
    return $.grep(array, function (value) {
        return matcher.test(value.label || value.value || value);
    });
};

$.ui.autocomplete.escapeRegex = function (value) {
    return value.replace(/[\-\[\]{}()*+?.,\\\^$|#\s]/g, "\\$&");
};
var Menu = function (options, input) {
    var listItems, api,
        class_hover = "ac-over", class_results = "ac-results",
        activeIndex = -1,
        element = $("<div>")
            .hide()
            .addClass(class_results)
            .appendTo(_appendTo())
            .hover(onHover),
        list = $("<ul>").appendTo(element)
            .bind("mouseover", 'li', onMouseOver)
            .bind("click", 'li', onClick);

    function _appendTo() {
        //specified element ?
        var el = options.appendTo;

        //if there is something, try to get the jQuery representation
        if (el) {
            el = el.jquery || el.nodeType ?
                $(el) : $(document).find(el).eq(0);
        }

        //fallback to body
        if (!el || !el.length) {
            el = document.body;
        }

        return el;
    }

    function onHover() {
        // Browsers except FF do not fire mouseup event on scrollbars, resulting in mouseDownOnSelect remaining true, and results list not always hiding.
        if ($(this).is(":visible")) {
            input.focus();
        }
    }

    function onClick(event) {
        $(event.target).addClass(class_results);
        element.trigger('menuselect', {item: $(event.target)});
        return false;
    }

    function onMouseOver(event) {
        var target = event.target;
        if (target.nodeName && target.nodeName.toUpperCase() == 'LI') {
            setActive($(event.target));
            activeIndex = $("li", list).index(target);
        }
    }

    function moveSelect(step, event) {
        movePosition(step, event);
        if (hasScroll()) {
            var offset = 0;
            listItems.slice(0, activeIndex).each(function () {
                offset += this.offsetHeight;
            });
            if ((offset + api.active[0].offsetHeight - list.scrollTop()) > list[0].clientHeight) {
                list.scrollTop(offset + api.active[0].offsetHeight - list.innerHeight());
            } else if (offset < list.scrollTop()) {
                list.scrollTop(offset);
            }
        }
    }

    function movePosition(step, event) {
        if (!((step < 0 && activeIndex === 0) || (step > 0 && activeIndex == listItems.length - 1))) {
            activeIndex += step;
            if (activeIndex < 0) {
                activeIndex = listItems.length - 1;
            } else if (activeIndex >= listItems.length) {
                activeIndex = 0;
            }
        }

        setActive($(listItems.get(activeIndex)), event);
    }

    function setActive(item, event) {
        if (api.active) {
            api.active.removeClass(class_hover);
        }
        api.active = item.addClass(class_hover);

        event = $.Event(event);
        event.type = 'menufocus';
        element.trigger(event, {item: api.active});

        return api.active;
    }

    function getExtended(key) {
        return $.proxy(api[key], api);
    }

    function hasScroll() {
        if (options.scroll) {
            return true;
        }

        var maxHeight = options.scrollHeight || list[0].innerHeight();
        return list[0].scrollHeight > maxHeight;
    }

    api = {
        element: element,
        show: function () {
            var offset = $(input).offset();
            element.css({
                width: $(input).outerWidth(),
                top: offset.top + input.offsetHeight,
                left: offset.left
            }).show();

            //return to the start of the list
            if (hasScroll()) {
                list
                    .css({
                        maxHeight: options.scrollHeight,
                        overflow: 'auto'
                    })
                    .scrollTop(0);
            }
        },
        hide: function () {
            element && element.hide();
            listItems && listItems.removeClass(class_results);
            activeIndex = -1;
        },
        visible: function () {
            return element && element.is(":visible");
        },
        suggest: function (items) {
            list.empty();
            getExtended('_renderMenu')(list, items);
            listItems = list.find('li');

            // size and position menu
            api.show();
            getExtended('_resizeMenu');
            element.position($.extend({of: $(input)}, options.position));

            if (options.autoFocus) {
                moveSelect(1);
            }
        },
        next: function (event) {
            moveSelect(1, event);
        },
        previous: function (event) {
            moveSelect(-1, event);
        },
        nextPage: function (event) {
            if (activeIndex != listItems.length - 1 && activeIndex + 8 > listItems.length) {
                moveSelect(listItems.length - 1 - activeIndex, event);
            } else {
                moveSelect(8, event);
            }
        },
        previousPage: function (event) {
            if (activeIndex !== 0 && activeIndex - 8 < 0) {
                moveSelect(-activeIndex, event);
            } else {
                moveSelect(-8, event);
            }
        },
        select: function (event) {
            $(element).trigger('menuselect', {item: api.active});
        },
        reappend: function () {
            element.appendTo(_appendTo());
        },
        destroy: function () {
            element && element.remove();
        },
        _renderItemData: function (ul, item) {
            return getExtended('_renderItem')(ul, item).data(Autocompleter.data_key, item);
        },

        //Extension points
        _renderMenu: options._renderMenu || function (ul, items) {
            var that = this;
            $.each(items, function (index, item) {
                that._renderItemData(ul, item);
            });
        },

        _renderItem: options._renderItem || function (ul, item) {
            return $("<li>").addClass("ac-item").text(item.label).appendTo(ul);
        },

        _resizeMenu: options._resizeMenu || function () {
            element.outerWidth(
                Math.max(
                    // Firefox wraps long text (possibly a rounding bug)
                    // so we add 1px to avoid the wrapping (#7513)
                    element.width("").outerWidth() + 1,
                    $(input).outerWidth()
                )
            );
        }
    };

    return api;
};
$.fn.autocomplete = function (options) {
    if (typeof options == 'string') {
        var returnValue = this, args = Array.prototype.slice.call(arguments, 1);

        this.each(function () {
            var instance = $.data(this, Autocompleter.key);

            if (typeof instance == 'object' && $.isFunction(instance[options])) {
                var methodValue = instance[ options ].apply(instance, args);

                if (methodValue !== instance && methodValue !== undefined) {
                    returnValue = methodValue && methodValue.jquery ?
                        returnValue.pushStack(methodValue.get()) :
                        methodValue;
                    return false;
                }
            }
        });

        return returnValue;
    }

    options = $.extend({}, Autocompleter.defaults, options);
    return this.each(function () {
        new $.Autocompleter(this, options);
    });
};

//TODO :: re-enable autofill
/*$.fn.selection = function (start, end) {
    if (start !== undefined) {
        return this.each(function () {
            if (this.createTextRange) {
                var selRange = this.createTextRange();
                if (end === undefined || start == end) {
                    selRange.move("character", start);
                    selRange.select();
                } else {
                    selRange.collapse(true);
                    selRange.moveStart("character", start);
                    selRange.moveEnd("character", end);
                    selRange.select();
                }
            } else if (this.setSelectionRange) {
                this.setSelectionRange(start, end);
            } else if (this.selectionStart) {
                this.selectionStart = start;
                this.selectionEnd = end;
            }
        });
    }
    var field = this[0];
    if (field.createTextRange) {
        var range = document.selection.createRange(),
            orig = field.value,
            teststring = "<->",
            textLength = range.text.length;
        range.text = teststring;
        var caretAt = field.value.indexOf(teststring);
        field.value = orig;
        this.selection(caretAt, caretAt + textLength);
        return {
            start: caretAt,
            end: caretAt + textLength
        };
    } else if (field.selectionStart !== undefined) {
        return {
            start: field.selectionStart,
            end: field.selectionEnd
        };
    }
};*/
})(jQuery);
