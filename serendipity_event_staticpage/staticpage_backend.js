/***
 * Staticpage event backend js
 * Last modified: 2015-06-28
 **/

/**
 * setLocalStorage function to store 'remember option' states with modern browsers
 * param: item name
 * param: item value
 **/
setLocalStorage = (function(name, value) {
    var storage, fail, uid;
    try {
        uid = new Date;
        (storage = window.localStorage).setItem(uid, uid);
        fail = storage.getItem(uid) != uid;
        storage.removeItem(uid);
        fail && (storage = false);
    } catch(e) {}

    // Remove old items first
    localStorage.removeItem(name);

    // Put the string/array/object into storage
    localStorage.setItem(name, JSON.stringify(value));
});

/**
 * setTabBar function to hide top tab navigation bar
 * param: object button
 **/
setTabBar = (function(b) {
    if ($('#serendipityStaticpagesNav').is(":visible")) {
        $('#serendipityStaticpagesNav').fadeOut(function(){
            $('#sp_navigator').css({'margin-top' : '1.54em'});
            $(b).text('Show TabBar').removeClass('icon-up-dir').addClass('icon-down-dir');
            setLocalStorage('staticpageTabBar', true);
        }); return false;
    } else {
        $('#serendipityStaticpagesNav').fadeIn(function(){
            $('#sp_navigator').removeAttr('style');
            $(b).text('Hide TabBar').removeClass('icon-down-dir').addClass('icon-up-dir');
            localStorage.removeItem('staticpageTabBar');
        }); return false;
    }
});

/**
 * saveNewOrder function to save moved sequencers order ids
 **/
saveNewOrder = (function() {
    var a = [];
    $('#sequence').children().each(function (i) {
        a.push($(this).attr('id'));
    });
    var s = a.join(',');
    $.ajax({
        url: '?serendipity[adminModule]=staticpages&serendipity[moveto]=move&serendipity[pagemoveorder]='+s+'&serendipity[adminModule]=event_display&serendipity[adminAction]=staticpages&serendipity[staticpagecategory]=pageorder',
        context: document.body,
        success: function() {
            $('#splistorder').html('<span class=\"icon-ok\"></span> New staticpage pageorder list '+s+' successfully saved');
        }
    });
});

/**
 * staticpage entrieslist simplePagination executor
 **/
$(function() {

    var items    = $('#step > .sp_entries_pane');
    var numItems = items.length;
    var perPage  = (typeof(spconfig_listPerPage) != 'undefined') ? spconfig_listPerPage : 6;
    var sp_class = { 'border-bottom' : '1px solid #CCC', 'margin-bottom' : '1em' };

    $('.sp_entries_pane').hide();
    $('#step').css(sp_class);

    // only show the first 6 items initially and hide the rest
    items.show().slice(perPage).hide();

    if (numItems == 0) return;
    // now setup pagination
    $('#sp_entry_pagination').pagination({
        items: numItems,
        itemsOnPage: perPage,
        cssStyle: 'light-theme',
        onPageClick: function(pageNumber) { // this is where the magic happens
            // someone changed page, lets hide/show entries appropriately
            var showFrom = perPage * (pageNumber - 1);
            var showTo = showFrom + perPage;

            // first hide everything, then show for the new page
            items.hide().slice(showFrom, showTo).show();
            if (pageNumber == Math.ceil(numItems / perPage)) {
                $('#step').css({'border-bottom' : '', 'margin-bottom' : ''});
            } else {
                $('#step').css(sp_class);
            }
        }
    });
});

/**
 * add dialog to change page selector, to avoid page changes before saving current page
 **/
$(function() {
    var prev_value;
    $('#staticpage_dropdown').focus(function() {
        prev_value = $(this).val();
    }).change(function(){
        $(this).unbind('focus');
        if (!confirm(dropdown_dialog)){
            $(this).val(prev_value);
            $(this).bind('focus');
            return false;
        } else {
            $(this.form.elements['serendipity[staticSubmit]']).click();
        }
    });
});

/**
 * collapsible box executor for staticpage entry forms
 **/
Object.keys(localStorage).forEach(function(key) {
    if (/^(staticpage_mobileform_)|(staticpage_defaultform_)/.test(key)) {
        var k   = key.split('_');
        var $id = '#'+k[2];
        var $el = $id.replace('option','');
        if (localStorage.getItem(key) !== null) {
            $($id + ' > .icon-right-dir').removeClass('icon-right-dir').addClass('icon-down-dir');
            $($el).removeClass('additional_info');
        }
    }
});

/**
 * overwrite CKE save button in all nugget instances, see extending smarty note in backend_staticpage.tpl
 **/
if (typeof(CKEDITOR) != 'undefined' && CKEDITOR.plugins.registered['save']) {
    CKEDITOR.plugins.registered['save'] = {
        init: function (editor) {
            var command = editor.addCommand('save',
            {
                modes: { wysiwyg: 1, source: 1 }
            });
        }
    }
}

/**
 * pageorder drag and drop handler
 **/
$(function() {
    $('#sp_sequencer form').submit(function(event) {
        event.preventDefault();
        event.stopPropagation();
        saveNewOrder();
        $('html, body').animate({
             scrollTop: $("#splistorder").offset().top
        }, 1000);
        return false;
    });
});
