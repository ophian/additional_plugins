/**
 * @license Copyright (c) from 2013, Author: Ian Styx. All rights reserved.
 */

/**
 * @fileOverview A Serendipity Styx serendipity_event_ckeditor CKEDITOR custom config file: cke_config.js, v. 2.27, 2023-07-15
 */

 /**
 * Substitute every config option to CKE in here
 */
CKEDITOR.editorConfig = function( config ) {

    // Up from v.4.22 EOL the ckeditor script is checking "3rd" party for "security", see https://github.com/ckeditor/ckeditor4/commit/b7b2f4748be71eb01c2f99afefaff002f5061a3e.
    // We don't want this for privacy, since that is easily usable as a logger! See https://ckeditor.com/docs/ckeditor4/latest/api/CKEDITOR_config.html#cfg-versionCheck
    config.versionCheck = false;

    // Allow dark mode
    if (typeof STYX_DARKMODE === 'undefined' || STYX_DARKMODE === null) STYX_DARKMODE = false;
    config.skin = (STYX_DARKMODE === true ? 'moonodark,' + CKEDITOR_PLUGPATH + 'serendipity_event_ckeditor/moonodark/' : 'moono-lisa');
    //https://cdn.ckeditor.com/#skins for local skins and also local plugins (WHOW! this enables us to to separate all custom builds!)

    // set Serendipity default lang
    config.language = CKECONFIG_LANG; // IETF standard unicode language 4-letter tag, using a dash

    /** SECTION: ACF
        Advanced Content Filter works in two modes:
            automatic - the filter is configured by editor features (like plugins, buttons, and commands) that are enabled with configuration options
                        such as CKEDITOR.config.plugins, CKEDITOR.config.extraPlugins, and CKEDITOR.config.toolbar,
            custom    - the filter is configured by the CKEDITOR.config.allowedContent option and only features that match this setting are activated.
        In both modes it is possible to extend the filter configuration by using the CKEDITOR.config.extraAllowedContent setting.
        If you want to disable Advanced Content Filter, set CKEDITOR.config.allowedContent to true.
        All available editor features will be activated and input data will not be filtered.
        Allowed content rules. This setting is used when instantiating CKEDITOR.editor.filter.
        The following values are accepted:
            CKEDITOR.filter.allowedContentRules - defined rules will be added to the CKEDITOR.editor.filter.
            true    - will disable the filter (data will not be filtered, all features will be activated).
            default - the filter will be configured by loaded features (toolbar items, commands, etc.).
            http://docs.ckeditor.com/?_escaped_fragment_=/guide/dev_allowed_content_rules-section-string-format#!/guide/dev_allowed_content_rules-section-string-format
        In all cases filter configuration may be extended by extraAllowedContent. This option may be especially useful,
        when you want to use the default allowedContent value along with some additional rules.
        Read more of this here:
            http://docs.ckeditor.com/?_escaped_fragment_=/guide/dev_acf#!/guide/dev_acf
    */


    /**
     Set ACF by serendipity_event_ckeditor plugin option - default (false)
     The automatic mode is on (false) when the CKEDITOR.config.allowedContent option is not set in your editor configuration.
     This is the default setting which means that from now on by default all CKEditor contents will be filtered.
    */
    if (CKECONFIG_ACF_OFF === true) {
        config.allowedContent = CKECONFIG_ACF_OFF;
        // <i (awesome icon tags) need a special care for emptiness!
        CKEDITOR.dtd.$removeEmpty['i'] = false; // dtd seems to have NO effect and is not in need, when using config.allowedContent, config.protectedSource.push and config.extraAllowedContent !
    } else { // this is ACF ON by default

        //CKEDITOR.dtd.$removeEmpty['i'] = false; // special case, since <i> is internally as well recognized as italic and parsed to <em> tag if not excluded in procurator !
        /** List of regular expressions to be executed on ***input HTML***, indicating HTML source code, that, when matched, must not be available in the WYSIWYG mode for editing. */

        // allow <script> tags
        //config.protectedSource.push( /<(script)[^>]*>.*<\/script>/ig ); // already set as default in ckeditor.js [/<script[\s\S]*?<\/script>/gi,/<noscript[\s\S]*?<\/noscript>/gi]
        // allow imageselectorplus mediainsert tag codes
        config.protectedSource.push( /<(mediainsert)[^>]*>[\s\S]*?<\/mediainsert>/img );
        // allow a Smarty like {} tag syntax without inner whitespace, which would be some other code part.
        //config.protectedSource.push( /\{[a-zA-Z\$].*?\}/gi ); // Smarty markup protection disabled, since now being usable w/o setting ACF OFF
        // allow WP like [[mytag]] [[{$mytag}]] widget tags with >= 4.4.1 for an imaginable markup replacements S9y plugin
        //config.protectedSource.push(/\[\[([^\[\]])+\]\]/g); // WP-Smarty like markup protection disabled, since now being usable w/o setting ACF OFF
        // allow font awesome <i></i> tags to be protected against ACF by switching mode !
        config.protectedSource.push( /<i[^>]*><\/i>/g );

        /**
         CKEDITOR.protectedSource patterns used regex Escape sequences
                \s any whitespace character;
                \S any character that is not a whitespace character
                \t tab (hex 09);
                \r carriage return (hex 0D);
                \n newline (hex 0A);
         Pattern Modifiers
                /i caseless, match both upper and lower case letters
                /m treat as multiline
                /g be greedy
        */

        /** SECTION: Extra Allowed Content [EAC]
            Set placeholder tag cases - elements [attributes]{styles}(classes) to protect ACF suspensions.
              - Allowed <mediainsert>, <gallery>, <media> tags (imageselectorplus galleries) - which tells ACF to not touch the code!
              - Allowed <picture> element and the <source> tag for viewport client access - which tells ACF to not touch the code!
              - Allowed <figure> styles and classes, <figcaption> classes for image comments
              - Allowed <div> is a need for Media Library inserts - which tells ACF to not touch the code!
              - Allowed <p> custom classes - to easier style certain paragraphs!
              - Allowed <q> custom lang classes - to easier style quotations by language!
              - Allowed <ul> listing for styles & classes, <dl> styles and classes, <dt>, <dd>, full <audio> and <video> and <source> attributes, <i> attributes & classes for font-awesome icons and full <span> to make life a bit easier!
              - Allowed <a> link tag attributes and classes for having to add data-* attributes (see picture element) - which tells ACF to not touch the code!
              - Reset <img[height,width,loading]> Could as well be [*]. Media Library image inserts to avoid ACF OFF suspension of height attributes. (Dependency in cke_plugin.js)
              - Allow <pre[*attributes](*classes)> and <code(*classes)> for custom attributes/classes in codesnippet code blocks
              - Allow <oembed> tag using Semantic Media Embed
              - Allow (pseudo) [lang] attribute in p and ul elements, see @https://www.w3.org/International/questions/qa-css-lang.en
        */
        // protect tags
        config.extraAllowedContent = 'mediainsert[*]{*}(*);gallery[*]{*}(*);media[*]{*}(*);script[*]{*}(*);audio[*]{*}(*);video[*];figure{*}(*);figcaption(*);div[*]{*}(*);p[lang](*);q[lang](*);ul[lang]{*}(*);dl{*}(*);dt;dd;a[*](*);span[*]{*}(*);picture;source[*]{*}(*);img[height,width,loading];pre[*](*);code(*);i[*](*);oembed;';

        // do not use auto paragraphs added to these allowed tags.
        config.autoParagraph = false;
    }

    /** SECTION: Other behaviour config rules

    // Prevent filler nodes in all empty blocks. - case switching source and wysiwyg mode multiple times
    //config.fillEmptyBlocks = false; // default (true) - switches <p>&nbsp;</p> to <p></p>
    //config.ignoreEmptyParagraph = false; // default(true) - Whether the editor must output an empty value ('') if it's contents is made by an empty paragraph only. (Extends to config.fillEmptyBlocks)
    // It will still generate an empty <p></p> though.
    //config.autoParagraph = false; // defaults(true)
    // DEV NOTES: Please note that since CKEditor 4.4.5 the config.autoParagraph configuration option was marked deprecated, since changing the default value might introduce unpredictable usability issues and so it is highly unrecommended.

    // The configuration setting that controls the ENTER mode is "config.enterMode" and it offers three options:
    // (1) The default creates a paragraph element each time the "enter" key is pressed:
    //config.enterMode = CKEDITOR.ENTER_P; // inserts <p></p>
    // (2) You can choose to create a "div" element instead of a paragraph:
    //config.enterMode = CKEDITOR.ENTER_DIV; // inserts <div></div>
    // (3) If you prefer to not wrap the text in anything, you can choose to insert a line break tag:
    //config.enterMode = CKEDITOR.ENTER_BR; // inserts <br />
    // You can always use SHIFT+ENTER to set a br in the P-mode default option or change the SHIFT-mode to something else
    //config.shiftEnterMode = CKEDITOR.ENTER_BR;
    // Better learn to do this via keyboard commands, see 'cheatsheet' toolbar button.
    */

    /**
      Whether to use HTML entities in storing and in the output.
      With v. 4.7.0, strictly let S9y handle this, since we need it for search result terms!
      Storing html entities to the database is no good for this case! You may only be hit by this if using Umlauts or very specialized chars.
      If you really are subjected to this search result issue for previous entries stored by this plugin editor,
      you will have to call and re-submit these entries again. Sorry!
    */
    config.entities = false; // defaults(true)
    config.htmlEncodeOutput = false; // defaults(true)


    /** SECTION: UI configurations
    config.uiColor = 'transparent'; // standard, but better disable config.uiColor at all
    // just some examples
    config.uiColor = '#CFD1CF'; // standard grey
    config.uiColor = '#f5f5f5'; // standard light grey
    config.uiColor = '#E6EDF3'; // extreme light blue
    config.uiColor = '#DFE8F6'; // very light blue
    config.uiColor = '#9AB8F3'; // light blue/violet
    config.uiColor = '#AADC6E'; // light green
    config.uiColor = '#FFDC6E'; // light gold
    config.uiColor = '#FF8040'; // mango
    config.uiColor = '#FF2400'; // scarlet red
    config.uiColor = '#14B8C4'; // light turquoise

    config.skin    = 'moono-lisa'; // this is default (see on top)
    config.height  = 400; // dito
    */

    /**
     The previously used PBCKCODE CODE Editor was replaced by the codesnippet plugin , which was developed and enhanced during the development of the CKEDITOR 4 Series.
     It supports by default more code types, does not need any CDN, and uses less resources being better integrated. But it uses a different highlighter js file (highlighter.pack.js).
     PLEASE NOTE: If having used the prettify output already in your entries, your need to set the new compat mode option to allow both.
    */


    /** SECTION: Custom Config Content Styles
        We can not use templates/xxx/admin/ as a path here, since we would need template and userTemplate path parts as dynamic vars
    */
    // Add custom Serendipity styles to ckeditor content wysiwyg-mode, to respect S9y CSS image floats.
    // If set here, we have to include the default styles, and this even since CKE 4.4. Else it isn't loaded!
    // Add Styx specific styles
    if (STYX_DARKMODE === true) {
        config.contentsCss = [ CKEDITOR_PLUGPATH + 'serendipity_event_ckeditor/dark_contents.min.css', CKEDITOR_PLUGPATH + 'serendipity_event_ckeditor/wysiwyg-style.css' ];
    } else {
        config.contentsCss = [ CKEDITOR_PLUGPATH + 'serendipity_event_ckeditor/ckeditor/contents.css', CKEDITOR_PLUGPATH + 'serendipity_event_ckeditor/wysiwyg-style.css' ];
    }


    /** SECTION: Web-Spellchecker (wsc) and SCAYT plug-in for CKEditor
    // evaluate SCAYT on startup
    // config.scayt_autoStartup = true;
    // Native spell check functionality is by default disabled in the editor, use this to enable it.
    // Do not wonder if this is not working on demand, since Browsers need to match spell checker settings, etc., you need to hit the correct place/word, and so on.
    //config.disableNativeSpellChecker = false;
    // See full list of supported languages here: http://docs.ckeditor.com/#!/guide/dev_howtos_scayt
    */
    config.wsc_lang = CKECONFIG_SLANG; // The default wsc (spell checker language), eg. "de_DE", or "fr_FR", using POSIX underscore. Defaults to: 'en_US'.
    config.scayt_sLang = CKECONFIG_SLANG; // The default SCAYT language, eg. "de_DE", or "fr_FR", using POSIX underscore. Defaults to: 'en_US'.
    // enable/disable the "More Suggestions" sub-menu in the context menu.
    // The possible values are "on" or "off".
    config.scayt_moreSuggestions = 'off';
    // set the visibility of the SCAYT tabs in the settings dialog and toolbar
    // button. The value must contain a "1" (enabled) or "0" (disabled) number for
    // each of the following entries, in this precise order, separated by a
    // comma (","): "Options", "Languages" and "Dictionary".
    // As long as not purchased a license, the "languages"-options wont work. You may only use the online spell checker from the Scayt-button last select option. Which isn't really fun to use.
    // Visit http://wiki.webspellchecker.net/doku.php?id=installationandconfiguration:hostedscayt for more
    config.scayt_uiTabs = '1,0,1'; // we disable the language tab option, since it does not work in this context, getting a list of languages and this breaking the popup-layer!


    /** SECTION: Embed Media [oEmbed] semantically or via URL
    // This description is a copy from http://docs.ckeditor.com/#!/guide/dev_media_embed-section-embedding-media-demo
    //
    // Both widgets allow to embed resources (videos, images, tweets, etc.) hosted by other services (called the "content providers") in the editor.
    // In order to use the widget, you need to set up the content provider in your editor configuration first. We recommend to use the Iframely proxy
    // service which supports over 1800 content providers such as YouTube, Vimeo, Twitter, Instagram, Imgur, GitHub, or Google Maps.
    //
    // Media Embed vs Semantic Media Embed
    // The difference between Media Embed and Semantic Media Embed is that the first will include the entire HTML needed to display the resource in the data,
    // while the latter will only include an <oembed> tag with the URL to the resource. See the following examples:
    // Media Embed:
    //
    // <div data-oembed-url="https://twitter.com/reinmarpl/status/573118615274315776">
    //     <blockquote class="twitter-tweet">
    //         <p>Coding session with <a href="https://twitter.com/fredck">@fredck</a>, <a href="https://twitter.com/anowodzinski">@anowodzinski</a> and Mr Carrot. <a href="http://t.co/FLV5UXpfaT">pic.twitter.com/FLV5UXpfaT</a></p>
    //         &mdash; Piotrek Koszulinski (@reinmarpl) <a href="https://twitter.com/reinmarpl/status/573118615274315776">March 4, 2015</a>
    //     </blockquote>
    //     <script async="" charset="utf-8" src="//platform.twitter.com/widgets.js"></script>
    // </div>
    //
    // Semantic Media Embed:
    // <oembed>https://twitter.com/reinmarpl/status/573118615274315776</oembed>
    //
    // This difference makes the Media Embed plugin perfect for systems where the embedding feature should work out of the box.
    // The Semantic Media Embed plugin is useful for rich content managment systems that store only pure, semantic content ready for further processing.
    // For instance, a CMS may display a different result in desktop browsers, different in mobile ones and different for the print version of a website.
    //
    // Configuring the Content Provider
    //
    // Since CKEditor 4.7 the content provider URL is set to empty by default. The former default URL (1) is still available, although it is recommended
    // to set up an account on the Iframely service for better control over embedded content.
    //
    // The default CKEditor configuration up till version 4.7 was using an anonymized endpoint provided by Iframely, however,
    // it did not include several features such as Google Maps. It is still possible to use it by setting the CKEDITOR.config.embed_provider in the following way: (1)
    //
    // However, for better control of API usage it is recommended to set up an account at Iframely. The free "Developer" tier does not have this restriction.
    // Some examples for different personal endpoints are:
    //      Iframely  - //ckeditor.iframe.ly/api/oembed?url={url}&callback={callback}&api_key=MYAPITOKEN
    //      Noembed   - //noembed.com/embed?url={url}&callback={callback}
    //      embed.ly  - //api.embed.ly/1/oembed?url={url}&callback={callback}&key=MYAPITOKEN
    // There are a lot more, see "http://oembed.com/#section7.1".
    //
    // Iframely can also be configured to be hosted on your server � you can read more about it in the "Self-host Iframely APIs" article.
    //
    // At the same time both widgets can be easily configured to use another oEmbed provider or custom services.
    //
    // PLEASE NOTE: There is another CKEditor AddOn plugin available, so called: Automatic Embedding on Paste.
    //              It allows pasting the resource URL directly into the editing area and will result in embedding its content.
    //              THIS IS NOT want we want to have!
    //
    // NOTE: Plugin names are always lower case, while widget names are not, so widget names do not have to equal plugin names.
    //       For example, there is the 'embedsemantic' plugin and the 'embedSemantic' widget.

    */
    if (CKECONFIG_OEMBED_ON === true || CKECONFIG_OEMBED_SMT_ON === true) {
        config.embed_provider = '//ckeditor.iframe.ly/api/oembed?url={url}&callback={callback}'; // (1)
    }

    /** SECTION: Custom Plugin and Button behaviour configurations
    // [CRTL + right mouse click] gives access to Browsers contextmenu, else you need to disable and set these
    // The general idea is that you would need to remove all plugins that depend on the "contextmenu" one for removing the "contextmenu" one itself to work. But this has other side effects!
    //config.removePlugins = 'wsc, scayt, menubutton, liststyle, tabletools, contextmenu';
    //config.browserContextMenuOnCtrl = true;
    */


    /**
    // ALLOW certain font sizes, eg.
    //config.fontSize_sizes = '8/8px;9/9px;10/10px;11/11px;12/12px;14/14px;15/15px;16/16px;18/18px;20/20px;22/22px;24/24px;26/26px;28/28px;36/36px;48/48px;72/72px' ;
    // Allow one(!) default font label, eg.
    //config.font_defaultLabel = 'Arial';
    // Add other font names to the list of fonts names to be displayed in the Font combo in the toolbar. - eg.
    //config.font_names = config.font_names +
    //    'Arial/Arial, Helvetica, sans-serif;' +
    //    'Times New Roman/Times New Roman, Times, serif;' +
    //    'Verdana';
    */


    // REMOVE custom toolbar buttons and plugins from all toolbars
    // A list of plugins that must not be loaded. This setting makes it possible to avoid loading some plugins defined in the CKEDITOR.config.plugins setting, without having to touch it and potentially break it.
    config.removePlugins = 'flash, iframe, forms'; // possible strict suggestions: 'flash, iframe, elementspath, save, font, showblocks, div, liststyle, pagebreak, smiley, specialchar, horizontalrule, indentblock, justify, pastefromword, newpage, preview, print, stylescombo'
    config.removeButtons = 'Preview, Styles, JustifyLeft'; // these buttons are useless or preset in Serendipity and therefore not set. Without, even the toolbar Groups break better on screens.

    /**
     * Customizing CodeSnippet AddOn
     * Changes the theme
     * Add extra languages for CodeSnippet default and added ['Go'] and ['Rust']
     */

    // Default theme of CKEDITOR 'codesnippet' plugin - else use 'default' or 'monokai_sublime' or 'pojoaque' or any of those described at https://highlightjs.org/static/test.html
    config.codeSnippet_theme = 'github'; // write as exists, since can be case sensitive when loading!
    // Extend or remove the default selection
    config.codeSnippet_languages = {
                        apache: 'Apache',
                        bash: 'Bash',
                        coffeescript: 'CoffeeScript',
                        cpp: 'C++',
                        cs: 'C#',
                        css: 'CSS',
                        diff: 'Diff',
                        go: 'Go',
                        html: 'HTML',
                        http: 'HTTP',
                        ini: 'INI',
                        java: 'Java',
                        javascript: 'JavaScript',
                        json: 'JSON',
                        makefile: 'Makefile',
                        markdown: 'Markdown',
                        nginx: 'Nginx',
                        objectivec: 'Objective-C',
                        perl: 'Perl',
                        php: 'PHP',
                        python: 'Python',
                        ruby: 'Ruby',
                        rust: 'Rust',
                        sql: 'SQL',
                        vbscript: 'VBScript',
                        xhtml: 'XHTML',
                        xml: 'XML'
    };

    // Plugin: Autogrow textareas configuration
    config.autoGrow_minHeight = 120;
    config.autoGrow_maxHeight = 420;
    config.autoGrow_bottomSpace = 50;
    config.autoGrow_onStartup = true;

    /**
     PLEASE NOTE:
        Its default toolbar group changed away from 'insert' to new 'snippet' group name.
        The preset github.css theme was copied to this plugins serendipity_event_ckeditor directory and named highlighter.css for frontend binding.
    */

    /** SECTION: Certain Plugin Buttons
        We cheat ckeditor instances by adding all available button names (in s9ypluginbuttons) to "both" toolbar instances, in case of having two textareas.
        The instanciation will only take the ones being currently initiated in form pages source code, or in serendipity.admin.js in a 2.0 environment.
        The hooked and added extraPlugins in the cke_plugin.js file, do not become automatically true for preset toolbars (Basic, Standard, Full) like this, but will do for the fallback toolbarGroups later on.
    */
    // concat button arrays
    var s9ypluginbuttonsAll = s9ymediabuttons.concat(s9ypluginbuttons);


    /** SECTION: Build Preset Toolbars

        BASIC: Serendipity (basic)
        STANDARD: Serendipity (standard)
        FULL: Serendipity (full)

        PLEASE NOTE:
        1. In order to work properly within all toolbars, please do not remove the eg. { name: 'insert', items: [ 'Image' ] }, group and Image button, since then the s9ymediabutton does not properly insert!
           This ckeditor image widget is disabled/hidden by css (htmlarea/s9y_cketoolbar.css) and is only presented in the CKE PRESET toolbar.
        2. If you really configure your own toolbar, choose the named and selected toolbar which comes near to your idea and edit the one.
    */

    // in case of Serendipity toolbar : "Basic"
    config.toolbar_Basic = [
        { name: 'styles',      items : [ 'Format', ] },
        { name: 'basicstyles', items : [ 'Bold','Italic','Underline','Superscript' ] },
        { name: 'paragraph',   items : [ 'NumberedList', 'BulletedList', 'Blockquote' ] },
        { name: 's9yml',       items : s9ymediabuttons },
        { name: 'insert',      items : [ 'Image' ] },
        { name: 'links',       items : [ 'Link','Unlink' ] },
        { name: 'snippet',     items : [ 'CodeSnippet' ] },
        { name: 'emoji',       items : [ 'EmojiPanel' ] },
        { name: 'oembed',      items : [ 'MediaEmbed', 'Embed', 'EmbedSemantic' ] },
        { name: 'others',      items : s9ypluginbuttons },
        { name: 'document',    items : [ 'Source' ] }
    ];
//    console.log(JSON.stringify(config.toolbar_Basic));

    // in case of Serendipity toolbar : "Full"
    // Breaks apart long paragraph group to better float
    // Moved 'Source' and removed 'Font' buttons; 'Styles', 'Preview' and 'JustifyLeft' are disabled overall.
    if (CKECONFIG_TOOLBAR_BREAK) {
      config.toolbar_Full = [
        { name: 'styles',      items : [ 'Styles','Format',/*'Font',*/'FontSize' ] },
        { name: 'basicstyles', items : [ 'Bold','Italic','Underline','Strike','Subscript','Superscript','-','RemoveFormat' ] },
        { name: 'colors',      items : [ 'TextColor','BGColor' ] },
        { name: 'paragraph',   items : [ 'NumberedList','BulletedList','-','Outdent','Indent','-','Blockquote','-','CreateDiv' ] },
        { name: 'blocks',      items : [ 'JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock' ] },
        { name: 'bidi',        items : [ 'BidiLtr','BidiRtl' ] },
        { name: 'links',       items : [ 'Link','Unlink','Anchor' ] },
        CKECONFIG_TOOLBAR_BREAK,
        { name: 's9yml', items : s9ymediabuttons },
        { name: 'insert',      items : [ 'Image','Flash','Table','HorizontalRule','Smiley','SpecialChar','PageBreak' ] },
        { name: 'document',    items : [ /*'Source','-',*/'Save','NewPage','DocProps','Preview','Print','-','Templates' ] },
        { name: 'clipboard',   items : [ 'Cut','Copy','Paste','PasteText','PasteFromWord','-','Undo','Redo' ] },
        { name: 'editing',     items : [ 'Find','Replace','-','SelectAll','-','SpellChecker', 'Scayt' ] },
        { name: 'forms',       items : [ 'Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton', 'HiddenField' ] },
        CKECONFIG_TOOLBAR_BREAK,
        { name: 'snippet', groups : [ 'snippet' ], items : [ 'CodeSnippet' ] },
        { name: 'emoji',       items : [ 'EmojiPanel' ] },
        { name: 'oembed', groups : [ 'oembed' ], items : [ 'MediaEmbed', 'Embed', 'EmbedSemantic' ] },
        { name: 'others',      items : s9ypluginbuttons },
        { name: 'document', groups : [ 'mode', 'document', 'doctools' ], items : [ 'Source' ] },
        { name: 'tools',       items : [ 'Maximize', 'ShowBlocks','-','About' ] },
        { name: 'cheatsheet',  items : ['CheatSheet'] }
      ];
    } else {
      config.toolbar_Full = [
        { name: 'styles',      items : [ 'Styles','Format',/*'Font',*/'FontSize' ] },
        { name: 'basicstyles', items : [ 'Bold','Italic','Underline','Strike','Subscript','Superscript','-','RemoveFormat' ] },
        { name: 'clipboard',   items : [ 'Cut','Copy','Paste','PasteText','PasteFromWord','-','Undo','Redo' ] },
        { name: 'document',    items : [ /*'Source','-',*/'Save','NewPage','DocProps','Preview','Print','-','Templates' ] },
        { name: 'editing',     items : [ 'Find','Replace','-','SelectAll','-','SpellChecker', 'Scayt' ] },
        { name: 'forms',       items : [ 'Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton', 'HiddenField' ] },
        { name: 'paragraph',   items : [ 'NumberedList','BulletedList','-','Outdent','Indent','-','Blockquote','-','CreateDiv' ] },
        { name: 'blocks',      items : [ 'JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock' ] },
        { name: 'bidi',        items : [ 'BidiLtr','BidiRtl' ] },
        { name: 'links',       items : [ 'Link','Unlink','Anchor' ] },
        { name: 's9yml',       items : s9ymediabuttons },
        { name: 'insert',      items : [ 'Image','Flash','Table','HorizontalRule','Smiley','SpecialChar','PageBreak' ] },
        { name: 'colors',      items : [ 'TextColor','BGColor' ] },
        { name: 'snippet', groups : [ 'snippet' ], items : [ 'CodeSnippet' ] },
        { name: 'emoji',       items : [ 'EmojiPanel' ] },
        { name: 'oembed', groups : [ 'oembed' ], items : [ 'MediaEmbed', 'Embed', 'EmbedSemantic' ] },
        { name: 'others',      items : s9ypluginbuttons },
        { name: 'tools',       items : [ 'Maximize', 'ShowBlocks','-','About' ] },
        { name: 'document', groups : [ 'mode', 'document', 'doctools' ], items : [ 'Source' ] },
        { name: 'cheatsheet',  items : ['CheatSheet'] }
      ];
    }
//    console.log(JSON.stringify(config.toolbar_Full));

    // in case of Serendipity toolbar : "Standard"
    config.toolbar_Standard = [
        { name: 'basicstyles', items : [ 'Format','-','Bold','Italic','Underline','Strike','Subscript','Superscript','-','RemoveFormat' ] },
        { name: 'paragraph', groups: [ 'list', 'blocks', 'align' ], items: [ 'NumberedList', 'BulletedList', '-', 'Blockquote' ] },
        { name: 'blocks',      items : [ 'JustifyCenter','JustifyRight','JustifyBlock' ] },
        { name: 's9yml',       items : s9ymediabuttons },
        { name: 'insert',      items : [ 'Image', '-', 'Table', 'HorizontalRule', 'SpecialChar'] },
        { name: 'links',       items : [ 'Link','Unlink','Anchor' ] },
        CKECONFIG_TOOLBAR_BREAK,
        { name: 'clipboard',   items : [ 'Cut', 'Copy', 'Paste', 'PasteText', '-', 'Undo', 'Redo'] },
        { name: 'editing', groups: [ 'find', 'selection', 'spellchecker' ], items: [ 'Scayt' ] },
        { name: 'snippet',     items : [ 'CodeSnippet' ] },
        { name: 'emoji',       items : [ 'EmojiPanel' ] },
        { name: 'oembed', groups : [ 'oembed' ], items : [ 'MediaEmbed', 'Embed', 'EmbedSemantic' ] },
        { name: 'others',      items : s9ypluginbuttons },
        { name: 'document', groups: [ 'mode', 'document', 'doctools' ], items: [ 'Source' ] },
        { name: 'about',       items : [ 'About', ] },
        { name: 'cheatsheet',  items : ['CheatSheet'] },
        { name: 'tools',       items : [ 'Maximize' ] }
    ];
//    console.log(JSON.stringify(config.toolbar_Standard));


    // set the serendipity_event_ckeditor custom toolbar group
    // Note: Groups indent and forms are disabled, while mediaembed and codesnippet plugins are set. The procurator placeholders for "protected Source" is buttonless.
    //       when plugins config options denies codebutton, there is no need to disable it in here too (this is possibly done automatically if not set in extraPlugins list)
    // This is a tweaked toolbarGroups fallback, which does not need any extras manually filled in 'others', since done automatically by ckeditor.js or by the other named toolbars
    config.toolbarGroups = [
        { name: 'styles' },
        { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
//        { name: 'forms' },
        { name: 'colors' },
        { name: 'paragraph', groups: [ 'list', /*'indent', */'blocks', 'align', 'bidi' ] },
        { name: 'links' },

        { name: 's9yml' },
        { name: 'insert' },
//        { name: 'ident' },
        { name: 'document', groups: [ /*'mode', */'document', 'doctools' ] },
        { name: 'clipboard', groups: [ 'clipboard', 'undo' ] },
        { name: 'editing', groups: [ 'find', 'selection', 'spellchecker' ] },

        { name: 'snippet', groups: [ 'codesnippet', 'snippet' ] },
        { name: 'emoji', groups : [ 'emoji' ] },
        { name: 'oembed' },
        { name: 'others' },
        { name: 'tools' },
        { name: 'about' },
        { name: 'mode' },
        { name: 'cheatsheet' }
    ];

    /** SECTION: Howto add Custom Plugins into toolbars
        1. Adding additional CKEDITOR Plugins to the config
           Download the Plugin, check version matching to this ckeditor version and drop the plugin to the /ckeditor/plugins directory.
           Copy the directories plugin name, eg 'mediaembed'.
           Add the plugin name to the "extraPlugins" string.
           Now add this name to this files upper config.toolbarGroup, wherever you like it to have, eg. "{ name: 'mediaembed' }," if that plugin emits a button to be placed into the toolbar.
           Or as { name: 'pluginname', items: 'PluginName' } eg { name: 'mediaembed', items: 'MediaEmbed' } in one of the upper toolbars, if that plugin emits a button to be placed into the toolbar.
           The ckeditor plugin download procedure will give information about dependency plugins and naming conventions.
           After a browser reload, the newly added plugin should load into your textareas toolbars.
        2. PLEASE NOTE:
           Do not use any customized CKEditor Downloads, since this will only work with CKE PRESET toolbars!
    */
};
