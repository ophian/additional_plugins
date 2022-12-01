<?php

/**
 * @version
 * @author Translator Name <yourmail@example.com>
 * EN-Revision: Revision of lang_en.inc.php
 */

@define('PLUGIN_PODCAST_NAME', 'Easy Podcasting Plugin');
@define('PLUGIN_PODCAST_DESC', 'Adds "podcasting" capabilities (RSS enclosure, Video/Sound-Player)');
@define('PLUGIN_PODCAST_EASY', 'Simple settings:');
@define('PLUGIN_PODCAST_USEPLAYER', 'Show Player');
@define('PLUGIN_PODCAST_USEPLAYER_DESC', 'Should HTML code for playing podcasts be generated instead of just having the link to the mediafile?');
@define('PLUGIN_PODCAST_AUTOSIZE', 'Adjust players size');
@define('PLUGIN_PODCAST_AUTOSIZE_DESC', 'Tries to detect the size of a video and adjusts the dimension of the player. The width and height settings will be ignored then.');
@define('PLUGIN_PODCAST_WIDTH', 'Width');
@define('PLUGIN_PODCAST_WIDTH_DESC', 'Width of the player to be shown.');
@define('PLUGIN_PODCAST_HEIGHT', 'Height');
@define('PLUGIN_PODCAST_HEIGHT_DESC', 'Height of the player to be shown.');
@define('PLUGIN_PODCAST_ALIGN', 'Alignment');
@define('PLUGIN_PODCAST_ALIGN_DESC', 'Alignment of the player inside of the text.');
@define('PLUGIN_PODCAST_ALIGN_LEFT', 'left');
@define('PLUGIN_PODCAST_ALIGN_RIGHT', 'right');
@define('PLUGIN_PODCAST_ALIGN_CENTER', 'centered');
@define('PLUGIN_PODCAST_ALIGN_NONE', 'nothing');
@define('PLUGIN_PODCAST_FIRSTMEDIAONLY', 'Embed first media only as RSS enclosure');
@define('PLUGIN_PODCAST_FIRSTMEDIAONLY_DESC', 'The RSS specification supports only one enclosure per entry. If this option is enabled, the RSS specification is respected and only the first media file found will be enclosured into the RSS feed.');
@define('PLUGIN_PODCAST_NOPODCASTING_CLASS', 'Ignore by CSS class');
@define('PLUGIN_PODCAST_NOPODCASTING_CLASS_DESC', 'When media links do have this class style, they will be ignored (won\'t be replaced by players and won\'t show up in RSS).');

@define('PLUGIN_PODCAST_EXTATTRSETTINGS', 'Podcasting using extended article attributes:');
@define('PLUGIN_PODCAST_EXTATTR', 'Extended article attributes');
@define('PLUGIN_PODCAST_EXTATTR_DESC', 'You can define, what extended attributes should be interpreted as media file attachments and therefor be added as enclosure to RSS feeds. This has to be a comma separated list of attribute names. The plugin "Extended article attributes" is needed for this to work.');

@define('PLUGIN_PODCAST_EXTPOS', 'Position of media files found in ext. article attr.');
@define('PLUGIN_PODCAST_EXTPOS_DESC', 'Define how media files found in extended article attributes should be embedded into the article.');
@define('PLUGIN_PODCAST_EXTPOS_NONE', 'Don\'t embed into article');
@define('PLUGIN_PODCAST_EXTPOS_BT', 'Top of the article');
@define('PLUGIN_PODCAST_EXTPOS_BB', 'Below the article');
@define('PLUGIN_PODCAST_EXTPOS_ET', 'Top of ext. article');
@define('PLUGIN_PODCAST_EXTPOS_EB', 'Below of ext. article');

@define('PLUGIN_PODCAST_EXPERT', 'Expert settings:');
@define('PLUGIN_PODCAST_EXPERT_HINT', 
'<b>HINT</b>: You can customize ANY player with the HTML markup, so you can create a list of your own player variants depending on filetype! 
Remember that if you once saved the plugin configuration, the static markup will always be used <strong>instead</strong> of what the 
plugin provides through the <strong>podcast_player.php</strong> file. If you ever want to reset your settings to the default, 
simply delete all content in the markup textarea and save the plugin.');

@define('PLUGIN_PODCAST_QTEXT', 'Quicktime extensions');
@define('PLUGIN_PODCAST_QTEXT_DESC', 'Extensions the Quicktimeplayer is able to play.');
@define('PLUGIN_PODCAST_QTEXT_HTML', 'Quicktime player markup');

@define('PLUGIN_PODCAST_WMEXT', 'WindowsMediaPlayer extensions');
@define('PLUGIN_PODCAST_WMEXT_DESC', 'Extensions the Windows Media Player is able to play.');
@define('PLUGIN_PODCAST_WMEXT_HTML', 'Windows Media Player markup');

@define('PLUGIN_PODCAST_MFEXT', 'Flash extensions');
@define('PLUGIN_PODCAST_MFEXT_DESC', 'Extensions the Flash player is able to play.');
@define('PLUGIN_PODCAST_MFEXT_HTML', 'Flash player markup');

@define('PLUGIN_PODCAST_AUEXT', 'Quicktime miniplayer audio extensions');
@define('PLUGIN_PODCAST_AUEXT_DESC', 'Audio extensions the quicktime miniplayer is able to play.');
@define('PLUGIN_PODCAST_AUEXT_HTML', 'Quicktime markup.');

@define('PLUGIN_PODCAST_HTML5_AUDIO', 'HTML5 audio extensions');
@define('PLUGIN_PODCAST_HTML5_AUDIO_DESC', 'Modern browsers support HTML5 player widgets, native to the browser.');
@define('PLUGIN_PODCAST_HTML5_AUDIO_HTML', 'HTML5 audio markup');

@define('PLUGIN_PODCAST_HTML5_VIDEO', 'HTML5 video extensions');
@define('PLUGIN_PODCAST_HTML5_VIDEO_DESC', 'Modern browsers support HTML5 player widgets, native to the browser.');
@define('PLUGIN_PODCAST_HTML5_VIDEO_HTML', 'HTML5 video markup');

@define('PLUGIN_PODCAST_USECACHE', 'Caching');
@define('PLUGIN_PODCAST_USECACHE_DESC', 'Should caching be enabled for remembering informations about the detected podcasts? With caching media files have to analyzed only once.(Recommended!)');
@define('PLUGIN_PODCAST_JS_OPTIMIZATION', 'JavaScript optimization');
@define('PLUGIN_PODCAST_JS_OPTIMIZATION_DESC','If switched on, extra javascripts are only added to the page if needed. I your entries are cached, this option HAS to be switched off!');

@define('PLUGIN_PODCAST_ASURE_FEEDENC', 'Ensure feed enclosure');
@define('PLUGIN_PODCAST_ASURE_FEEDEENC_DESC', 'Ensure media is added as "enclosure" to the feed even if not shown in the entry');

@define('PLUGIN_PODCAST_HTTPREL', 'Relative HTTP path of the plugin');
@define('PLUGIN_PODCAST_HTTPREL_DESC', 'This defines the HTTP path of the plugin relative to the base server URL. If you didn\'t change the permalink structure for plugins and your blog is not running in a subdirectory of the server, you are fine with the default setting.');

@define('PLUGIN_PODCAST_USAGE', 
'Scans entries for links showing to media files (Video, Audio) and replaces them with HTML code displaying a player for the media file. This makes it easy creating player objects in the article by just inserting a media file like a video from the media database into the article.
Additional to that the plugin adds the media files to the RSS feed in this way a RSS reader can interpret them as podcasts. (Keyword: Enclosure Tags).');

@define('PLUGIN_PODCAST_USAGE_RSS', '
To get RSS feeds of only specific filetypes, you can access/advertise a feed with a URL like ' . $serendipity['baseURL'] . 'rss.php?version=2.0&podcast_format=ogg.
This will only put files with an "ogg" extension inside a feed. You can specify multiple formats separated by ",".
');

@define('PLUGIN_PODCAST_ITUNES', 'iTunes XML markup');
@define('PLUGIN_PODCAST_ITUNES_DESC', 'Enter the XML that is put into your RSS-Feed to be shown within iTunes (see https://www.apple.com/itunes/podcasts/specs.html).');

@define('PLUGIN_PODCAST_MERGEMULTI', 'Merge multiple HTML5 player elements');
@define('PLUGIN_PODCAST_DOWNLOADLINK', 'Always add download link');
@define('PLUGIN_PODCAST_DOWNLOADLINK_DESC', 'If disabled, you can add your own customized download link within the player\'s markup.');

