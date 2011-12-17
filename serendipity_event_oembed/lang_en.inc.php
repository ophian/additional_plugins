<?php # $Id: lang_en.inc.php,v 1.1 2006/08/16 04:49:12 elf2000 Exp $

/**
 *  @version $Revision: 1.1 $
 *  @author Translator Name <yourmail@example.com>
 *  EN-Revision: Revision of lang_en.inc.php
 */

@define('PLUGIN_EVENT_OEMBED_NAME',      'oEmbed Plugin');
@define('PLUGIN_EVENT_OEMBED_DESC',      'oEmbed is a format for allowing an embedded representation of a URL on your blog. It allows blog articles to display embedded content (such as tweets, photos or videos) when a user posts a link to that resource, without having to parse the resource directly.');

@define('PLUGIN_EVENT_OEMBED_MAXWIDTH',      'Max width of replacements');
@define('PLUGIN_EVENT_OEMBED_MAXWIDTH_DESC', 'This is the max width the service should produce when providing a replacement. Not all services supports this but most.');
@define('PLUGIN_EVENT_OEMBED_MAXHEIGHT',     'Max height of replacements');
@define('PLUGIN_EVENT_OEMBED_MAXHEIGHT_DESC','This is the max height the service should produce when providing a replacement. Not all services supports this but most.');

@define('PLUGIN_EVENT_OEMBED_INFO',      '<h3>oEmbed Plugin</h3>' .
'<p>'.
'This plugin expands URLs to pages of known services to a representation of that URL. It shows i.e. the video for a youtube URL or the image instead of a flickr URL.<br/>' .
'The syntax of this plugin is <b>[embed <i>link</i>]</b> (or <b>[e <i>link</i>]</b> if you like it shorter).<br/>'.
'If the link is not supported by the plugin at the moment, it will replace the URL by a link pointing to that URL.<br/>'.
'</p><p>'.
'Please put this plugin at the top of your plugins list, so no other plugin can change this syntax (by adding a href i.e.)'.
'</p><p>'.
'The plugin supports representations of the following link types:%s'.
'</p>');
