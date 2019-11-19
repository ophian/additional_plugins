<?php

/**
 *  @file lang_en.inc.php 1.4.20 2017-08-18 Ian
 *  @version 1.4.20
 *  @author Translator Name <yourmail@example.com>
 *  EN-Revision: Revision of lang_en.inc.php
 */

@define('PLUGIN_EVENT_CKEDITOR_NAME', 'CKEditor Plus');
@define('PLUGIN_EVENT_CKEDITOR_DESC', 'Uses CKEditor as the default WYSIWYG editor. For any JS-Editor usage: Recommended! After installation, go to the configuration screen of this plugin for further instructions.');
@define('PLUGIN_EVENT_CKEDITOR_REVISION_TITLE', '<h3>This Plugin includes:</h3>');
@define('PLUGIN_EVENT_CKEDITOR_INSTALL', '<h2>Installation</h2>
<p class="msg_notice">
    <span class="icon-attention" aria-hidden="true"></span> <strong>Dependencies:</strong> Disable global body, extended and nugget parsing in the <strong>NL2BR</strong> plugin, <strong>OR</strong> by entry with entryproperties event plugin <strong>and/or</strong> for staticpages by entry "Perform Markup Transformations" option!<br><strong>Since Serendipity 2.0</strong> the entryproperties plugin detects CKEditor automatically as to that!
</p>
<ol style="line-height: 1.6">
    <li>To allow other plugins to use or hook into the editor, place this (CKEditor) plugin near the end of your plugin list.</li>
    <li>Make sure to enable WYSIWYG mode in your personal preferences.</li>
</ol>
<div class="cke_config_block msg_dialogue">
    <h3>Manually extending with CKEDITOR Plugins</h3>
    <ol style="line-height: 1.6">
        <li>Define manually added Plugins (analog to <em>{ name: \'mediaembed\' },</em>) to the <em>CKEDITOR.config.toolbarGroups = [...]</em> definition, in the cke_config.js.</li>
        <li>Add (append) the plugin name (analog to mediaembed) to <em>var extraPluginList = \'...\'</em> definition, in the cke_plugin.js.</li>
    </ol>

    <h3>Upgrading</h3>
    <p>This Plugin will provide Updates via Spartacus close to new CKEDITOR releases.</p>
    <p><strong>PLEASE NOTE</strong>: Do <strong>not</strong> use the Spartacus automatic plugin "Update All" button, if already available with your S9y version. Upgrade the CKEditor plugin singulary in list, to allow the internal routines to immediately fall back into this configuration, to run and deflate the ZIP-installer operations. Else you will have to force the deflation yourself after each CKEditor (library) upgrade by this plugins "Force install process (in emergencies)" option.</p>
    <p>It is generally not advised to use or install any "customized" CKEDITOR releases, since this will lead to undesirable side effects with this Plugins configuration.</p>
</div>');
@define('PLUGIN_EVENT_CKEDITOR_CONFIG', '');
@define('PLUGIN_EVENT_CKEDITOR_INSTALL_PLUGPATH', 'HTTP path to s9y plugins directory');
@define('PLUGIN_EVENT_CKEDITOR_CKEACF_OPTION', 'Disable Advanced-Content-Filter (ACF)?');
@define('PLUGIN_EVENT_CKEDITOR_TOOLBAR_OPTION', 'Use CKE-default toolbar-group linebreak?');

@define('PLUGIN_EVENT_CKEDITOR_CODEBUTTON_OPTION', 'Allow "codesnippet" toolbar-button?');
@define('PLUGIN_EVENT_CKEDITOR_PRETTIFY_OPTION', 'Allow additional prettify css/js in frontend?');
@define('PLUGIN_EVENT_CKEDITOR_PRETTIFY_OPTION_DESC', 'For upgraders only! Keeps backward compatibility for very old entries with code-blocks.');
@define('PLUGIN_EVENT_CKEDITOR_OPTION_DESC', 'Usually: ');

@define('PLUGIN_EVENT_CKEDITOR_FORCEINSTALL_OPTION', 'Force install process (in emergencies)');
@define('PLUGIN_EVENT_CKEDITOR_FORCEINSTALL_OPTION_DESC', 'Only on upgrade failures: Force the immediate zip deflation of ');

@define('PLUGIN_EVENT_CKEDITOR_CKEACF_OPTION_DESC', 'The CKEDITOR built-in "Housekeeper" filter restricts custom html markup to follow its rules! Normally this is good and you will want to keep it working in the backyard and use the already built-in workarounds for certain markup, like "iframe"d media via the "Embed Media"-button, or "audio" and "other Serendipity" tags via the "Sourcecode-view"-mode. Please also read: "http://docs.ckeditor.com/?_escaped_fragment_=/guide/dev_advanced_content_filter#!/guide/dev_advanced_content_filter".');

@define('PLUGIN_EVENT_CKEDITOR_SETTOOLBAR_OPTION', 'Choose preset toolbars');

@define('PLUGIN_EVENT_CKEDITOR_CKEIBN_OPTION', 'Disable CKE-default "image" toolbar-button?');
@define('PLUGIN_EVENT_CKEDITOR_CKEIBN_OPTION_DESC', 'The toolbar built-in image button follows its own rules for stylings and markup! Since we recommend to use the Serendipity "Media Library" button only, this is disabled by default. Allow with "No" here and use at own risk.');

@define('PLUGIN_EVENT_CKEDITOR_SCAYTLANG_OPTION', 'Set lang for Scayt and online web spell checker');
@define('PLUGIN_EVENT_CKEDITOR_SCAYT', '<h2>Scayt/wsc</h2>
<p class="msg_notice">
    <span class="icon-attention" aria-hidden="true"></span> As long as not purchased a license, you may only use the "SpellCheckAsYouType" (SCAYT-plugin) [ABC]-button over the free online service "Check Spelling" dialog option, or define a custom dictionary, which first is stored to a cookie, later to the browsers localStorage and start from scratch.
</p>');

@define('PLUGIN_EVENT_CKEDITOR_OEMBED_OPTION', 'Allow "oEmbed" toolbar-button?');
@define('PLUGIN_EVENT_CKEDITOR_OEMBED_OPTION_DESC', 'The "oEmbed" button widget allows to embed all kind of resources (videos, images, tweets, etc.) hosted by other services (called the "content providers") in the editors configuration.
To our own disadvantage, "oEmbed" does have to use an external "proxy" service to properly work and make sense at all.
The default CKEditor configuration uses an anonymized endpoint provided by Iframely, however, it does not include several features such as Google Maps without additional API key.
This "//ckeditor.iframe.ly/api/oembed?url={url}&callback={callback}" endpoint is used and set here. There are a lot more, see "http://oembed.com/#section7.1".
It is recommended by the CKEditor documentation, to set up an account on the "https://iframely.com/" service for better control over embedded content, or to set up your own private host, see "http://docs.ckeditor.com/#!/guide/dev_media_embed-section-embedding-media-demo".
If you don\'t need to use all this, you better stick to the simple mediaembed already included and keep this option set false.');
@define('PLUGIN_EVENT_CKEDITOR_OEMBEDTYPE_OPTION', 'Type of "oEmbed" button');
@define('PLUGIN_EVENT_CKEDITOR_OEMBEDTYPE_OPTION_DESC', 'The difference between "Media Embed" and "Semantic Media Embed" is that the first will include the entire HTML needed to display the resource in the data, while the latter will only include an <oembed> tag with the URL to the resource.
This difference makes the Media Embed plugin perfect for systems where the embedding feature should work out of the box.
The Semantic Media Embed plugin is useful for rich content management systems that store only pure, semantic content ready for further processing.
For instance using different results in different browser screen or print types of a website. Also it is much shorter and clearer and less prone to automatic corrections of the editor. It does show the embedded content in the editor in your first include session, but you have to use an output-filter to transform the <oembed> tag to the frontpage and backend entry recalls on render to make it actually work.
Test on your own and make your choice.');
@define('PLUGIN_EVENT_CKEDITOR_OEMBEDTYPE_SEMANTIC_OPTION', 'Semantic Media Embed');
@define('PLUGIN_EVENT_CKEDITOR_OEMBEDTYPE_MARKUP_OPTION', 'Media Embed');

@define('PLUGIN_EVENT_CKEDITOR_OPHANDLER', '<b>Please note:</b> After each CKEditor upgrade and due to a plugin change improvement placing javascript constants in the backends context, you need to manually <u>hard reload</u> your browsers cache (eg. by <b>F5</b>) <b>once</b> (<em>on some wysiwyg editor textarea form page</em>) after having changed this CKEditor plugin option configurator. Else your <em>unchanged</em> change will be cached-lazyloaded by the serendipity_admin.js file up for an hour.');

