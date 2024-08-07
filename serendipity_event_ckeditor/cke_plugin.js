/**
 * @license Copyright (c) from 2013, Author: Ian Styx. All rights reserved. Last Modified date: 2021-11-05.
 */

/**
 * @fileOverview A Serendipity serendipity_event_ckeditor custom CKEDITOR additional plugin creator file: cke_plugin.js, v. 1.20, 2021-11-05.
 */

if (typeof CKECONFIG_USEAUTOSAVE === 'undefined' || CKECONFIG_USEAUTOSAVE === null) CKECONFIG_USEAUTOSAVE = false;

// define array for hooked s9y plugins
var s9ymediabuttons  = [];
var s9ypluginbuttons = [];

/*
 * Get the instance ready event and set global instance var
 * This is read by serendipity_editor.js | [styx >= 3.1] serendipity_styx.js and in case of serendipity_html_nugget_plugin by below serendipity_imageSelector_addToBody()
 */
CKEDITOR.on( 'instanceReady', function( event ) {
    event.editor.on( 'focus', function() {
        isinstance = this;
    });
});

/*
 * Create a prototype foreach array function
 * This is faster than using ckeditor.js internal forEach() implementation or even using plain for()
 **/
if (!Array.prototype.forEach) {
    Array.prototype.forEach = function (fn, scope) {
        'use strict';
        var i, len;
        for (i = 0, len = this.length; i < len; ++i) {
            if (i in this) {
                fn.call(scope, this[i], i, this);
            }
        }
    };
}

/*
 * ExecutionCommand string replacement function
 * Used in CKEDITOR.plugins.add(), to get ready to execute (eval) the button command passed by Serendipity plugins
 * @param   string  string
 * @return  string  string
 **/
function ecfit(str) {
    str = str.replace('function() { ', '');
    str = str.replace(' }', '');
    str = str.replace(window.location.protocol + "//" + window.location.host, ''); // amazonchooser only
    return str;
}

/*
 * This was previously a nugget only area, spawned by head! (textareas of staticpage nuggets, html nugget plugins, etc.)
 * called via Spawnnugget(), set by real plugins like staticpages and cores functions_plugins_admin.inc in case of $ev['skip_nuggets'] === false
 *
 * NOW it is used by all textareas!
 *
 * @param string        $eventData['item']
 * @param string        $eventData['jsname']
 * @param array/object  jsEventData/json_encode($eventData['buttons'])
 **/
function Spawnnuggets(item, addEP, jsED) {

    if (!item)  var item  = null;
    if (!addEP) var addEP = null;
    if (!jsED)  var jsED  = null;

    var $this  = !isNaN(item) ? 'nuggets' + item : item;
    var area   = item.replace('serendipity[','').replace(']','');
    var $nugID = 'nuggets'+area; // plugin nugget textareas (eg. staticpages)
    var nugget = ''; // nugget id for hooked s9ypluginbuttons

    // global defines
    s9ymediabuttons.push('s9yML'+area);
    s9ymediabuttons.push('styxMLG'+area);

    // INIT CKEDITOR added plugins
    // Separate by comma, no whitespace allowed, and keep last comma, since later on concatenated with Serendipity hooked plugins, eg. MediaLibrary!
    // (Since v.4.10.0 this newly supports array and whitespace in between too.)
    //
    // 'codesnippet' is an official CKEDITOR plugin.
    //    Plugin Dependencies: 'codesnippet' Add-on Dependencies: 'widget'
    //    Plugin Dependencies: 'widget'      Add-on Dependencies: 'Line Utilities' and 'Clipboard'
    // 'embed' and 'embedsemantic' are official CKEDITOR plugins.
    //    Plugin Dependencies: Add-on Dependencies: 'embedbase'
    // 'emoji' is an official CKEDITOR plugin, which is an implementation of the Autocomplete feature.
    //    Plugin Dependencies: 'emoji' Add-on Dependencies: 'Autocomplete', 'Button', 'FloatPanel', 'PanelButton', 'Text Match', 'Ajax Data Loading',
    //    which have Add-on Helper Dependencies themselves: 'textwatcher' for autocomplete and 'xml' for the ajax Add-on.
    // 'mediaembed' is a fast and simple YouTube code/markup CKEditor-Plugin: v. 0.5+ (https://github.com/frozeman/MediaEmbed, 2013-09-12) to avoid ACF restrictions
    //
    // Enable 'embed' and 'embedsemantic' plugins with their dependency 'embedbase' plugin by option.
    // Though we should NOT allow and add the 'autoembed' and the 'autolink' Add-on like this eg. 'notification,autolink,notificationaggregator,autoembed', since we don't want to paste and convert directly.
    //
    // Both 'procurator' and 'cheatsheet' are Serendipity added only plugins.
    //
    var name_extraPlugins = (addEP !== null) ? addEP : $this;
    var jsEventData       = (jsED  !== null) ? jsED  : window.jsEventData; // global set by the 'backend_wysiwyg_finish' hook
    var extraPluginACF    = (typeof CKECONFIG_ACF_OFF !== 'undefined' && CKECONFIG_ACF_OFF === true) ? name_extraPlugins+', ajax, autocomplete, autogrow, button, cheatsheet, emoji, floatpanel, mediaembed, panelbutton, textmatch, textwatcher, xml' : name_extraPlugins+', ajax,autocomplete, autogrow, button, cheatsheet, emoji, floatpanel, mediaembed, panelbutton, procurator, textmatch, textwatcher, xml';
    var extraPluginList   = (CKECONFIG_CODE_ON === true) ? extraPluginACF+', codesnippet' : extraPluginACF;
        extraPluginList   = (CKECONFIG_OEMBED_ON === true) ? extraPluginList+', embedbase, embed' : extraPluginList;
        extraPluginList   = (CKECONFIG_OEMBED_SMT_ON === true) ? extraPluginList+', embedbase, embedsemantic' : extraPluginList;
    var customConfigPath  = CKEDITOR_PLUGPATH+'serendipity_event_ckeditor/cke_config.js?v='+CKECONFIG_FORCE_LOAD;
    var useAutoSave       = (CKECONFIG_USEAUTOSAVE === true && Modernizr.indexeddb === true) ? 'on' : null;

    // case hooked s9ypluginbuttons, since we want the unique id
    if (typeof window.jsEventData !== 'undefined') {
        var nugget = area;
        jsEventData.forEach( function(k, i) {
            s9ypluginbuttons.push(jsEventData[i].id+nugget);
            //console.log(jsEventData[i].id+nugget);
        });
    }

    if (document.getElementById($this)) {
        CKEDITOR.replace($this, {
            toolbar : CKECONFIG_TOOLBAR,

            // Load our specific configuration file.
            customConfig : customConfigPath,

            // Disable security notifications up from July 2024.
            versionCheck: false,

            // or do and set
            // Reset toolbar Groups settings
            // toolbarGroups: null,
            // or any other configuration option here
            // uiColor : '#AADC6E', // light green example
            // language: 'fr', // lang set example

            // set all plugins at once - no spaces allowed!
            extraPlugins: extraPluginList,

            // Set the startup mode view [OK]
            // startupMode: 'source',

            // listen on load - for mediainsert imageselectorplus plugin galleries
            on: {
                loaded: function( evt ) {
                    var editor = evt.editor,
                        rules = {
                            elements: {
                                mediainsert: function( element ) {
                                    if (CKECONFIG_ACF_OFF !== true) {
                                        // XHTML output instead of HTML - but this does not react on trailing slash eg <media "blah" />
                                        // editor.dataProcessor.writer.selfClosingEnd = ' />';

                                        // avoid line breaks with special block elements
                                        var tags = ['mediainsert', 'gallery', 'media'];

                                        for (var key in tags) {
                                            editor.dataProcessor.writer.setRules(tags[key],
                                            {
                                                // Indicates that this tag causes indentation on line breaks inside of it.
                                                indent : true,
                                                // Inserts a line break before the element opening tag.
                                                breakBeforeOpen : true,
                                                // Inserts a line break after the element opening tag.
                                                breakAfterOpen : false,
                                                // Inserts a line break before the element closing tag.
                                                breakBeforeClose : true,
                                                // Inserts a line break after the element closing tag.
                                                breakAfterClose : false
                                            });
                                        }
                                    }
                                },
                                // Output dimensions of w/h images, since we either need an unchanged MediaLibrary image code for responsive templates or tweak some replacements!
                                img: function( element ) {
                                    var style = element.attributes.style;

                                    if ( style )
                                    {
                                        // Get the height from the style.
                                        var  match = /(?:^|\s)height\s*:\s*(\d+)px/i.exec( style );
                                        var height = match && match[1];

                                        if ( height )
                                        {
                                            element.attributes.style = element.attributes.style.replace( /(?:^|\s)height\s*:\s*(\d+)px;?/i , '' );
                                            //element.attributes.height = height;
                                            // Do not add to element attribute height, since then the height will be automatically (re-) added to style again by ckeditor or image js
                                            // The current result is now: img alt class src style{width}. That is the only working state to get around this issue in a relative simple way!
                                            // Remember: Turning ACF OFF, will leave code alone, but still removes the height="" attribute! (workaround in extraAllowedContent added img[height]!)
                                        }
                                    }
                                }
                            }
                        };

                    // It's good to set both filters - dataFilter is used when loading data and htmlFilter when retrieving.
                    editor.dataProcessor.htmlFilter.addRules( rules );
                    editor.dataProcessor.dataFilter.addRules( rules );

                },

                // allow the Serendipity autosaver refill to work with this plugin instances
                instanceReady: function( ev ) {
                    //console.log('IS instanceReady');
                    var iseditor = ev.editor;
                    //console.log(iseditor);

                    if (useAutoSave) {
                        // check for 'nuggetsID' (only) autosaver caches, since these are not defined in Serendipity editor.js
                        serendipity.getCached($this,  function(res) {
                            if ($this === $nugID && res && res !== null && res != 'null') {
                                // don't ever do this with existing nugget entry data!!
                                if (iseditor.getData() == '') {
                                    iseditor.setData(res);
                                }
                            }
                        });
                    }
                }
            }
        });

        CKEDITOR.plugins.add(name_extraPlugins, {
            init: function(editor) {
                if (typeof jsEventData !== 'undefined') {
                    jsEventData.forEach( function(k, i) {
                        var execcom = ecfit(jsEventData[i].javascript);
                        editor.addCommand( jsEventData[i].id+nugget, {
                            exec: function( editor ) {
                                eval(execcom);
                            }
                        });
                        editor.ui.addButton(jsEventData[i].id+nugget, {
                            label:    jsEventData[i].name,
                            title:    jsEventData[i].name+' Plugin',
                            icon:     jsEventData[i].img_url,
                            iconName: jsEventData[i].id+nugget+'_icon',
                            command:  jsEventData[i].id+nugget
                        });
                    });
                }
                editor.addCommand( 's9yML'+area, {
                    exec : function( editor ) {
                        serendipity.openPopup('serendipity_admin.php?serendipity[adminModule]=media&serendipity[noBanner]=true&serendipity[noSidebar]=true&serendipity[noFooter]=true&serendipity[showMediaToolbar]=false&serendipity[showUpload]=true&serendipity[textarea]='+$this);
                    }
                });
                editor.ui.addButton('s9yML'+area, {
                    label:    'S9yMedia',
                    title:    'Styx Media Library',
                    icon:     CKEDITOR_PLUGPATH+'serendipity_event_ckeditor/img/mls9y.png',
                    iconName: 's9yML'+area+'_icon',
                    command:  's9yML'+area
                });
                editor.addCommand( 'styxMLG'+area, {
                    exec : function( editor ) {
                        serendipity.openPopup('serendipity_admin.php?serendipity[adminModule]=media&serendipity[noBanner]=true&serendipity[noSidebar]=true&serendipity[noFooter]=true&serendipity[showMediaToolbar]=false&serendipity[showGallery]=true&serendipity[textarea]='+$this);
                    }
                });
                editor.ui.addButton('styxMLG'+area, {
                    label:    'StyxMediaGallery',
                    title:    'Styx Media Gallery',
                    icon:     CKEDITOR_PLUGPATH+'serendipity_event_ckeditor/img/mlgallery.png',
                    iconName: 'styxMLG'+area+'_icon',
                    command:  'styxMLG'+area
                });
            }
        });
    }
}

/*
 * Textarea nuggets autosave event listener
 * We need to wait for fully available objects (document.load will be triggered later than document.ready).
 * We run this on any possible CKEDITOR instance - even on blogentry instances.
 * Refill from cache is done per instance inside Spawnnuggets CKEDITOR.replace.
 */
$(window).on('load', function() {

    if (CKECONFIG_USEAUTOSAVE === true && Modernizr.indexeddb === true) {

        nuggets = [];
        for(var name in CKEDITOR.instances) {
            //console.log(name);
            //if (false === (name.indexOf('nuggets') !== -1)) continue; // un-comment, to only use 'nuggetsID' nuggets
            nuggets.push(name);
        }
        //console.log(nuggets);

        if (nuggets != null) {
            nuggets.forEach( function(e) {
                //console.log(e);
                var editor = CKEDITOR.instances[e];
                var lastSaveTime = 0;
                var currentTime = 0;
                // Set key event per nugget
                editor.on( 'key', autosave);

                function autosave() {
                    window.setTimeout(
                        function() {
                            currentTime = new Date().getTime();
                            if ((currentTime - lastSaveTime) > 15000 || lastSaveTime == 0) {
                                serendipity.cache(e, editor.getData());
                                console.log('SAVED NUGGET '+e);
                                lastSaveTime = new Date().getTime();
                            }
                        },
                        15000
                    );
                }
            });
        }
    }
});
