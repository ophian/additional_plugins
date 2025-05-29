<?php

/**
 *  @version
 *  @author Translator Name <yourmail@example.com>
 *  EN-Revision: Revision of lang_en.inc.php
 */

@define('PLUGIN_EVENT_GRAVATAR_NAME',               'Avatar Plugin');
@define('PLUGIN_EVENT_GRAVATAR_DESC',               'Show Avatars inside comments. Gravatars, Pavatars, Favatars, Wavatars, Monster ID, Identicon, Twitter and Identica Avatars are supported.');

@define('PLUGIN_EVENT_GRAVATAR_USE_SMARTY',         'Produce Smarty tag');
@define('PLUGIN_EVENT_GRAVATAR_USE_SMARTY_DESC',    'If this option is switched ON, the Avatar images are not written directly into the comment output but a Smarty tag {$comment.avatar} is produced. Only templates, that support this Smarty tag, will display the Avatar, if this option is set to true. The best way is to try it, if your template supports this Smarty tag.');

@define('PLUGIN_EVENT_GRAVATAR_DEFAULTAVATAR',      'Default Avatar image');
@define('PLUGIN_EVENT_GRAVATAR_SIZE',               'Image size');
@define('PLUGIN_EVENT_GRAVATAR_RATING',             'Gravatar rating');
@define('PLUGIN_EVENT_GRAVATAR_RATING_NO',          'No rating');
@define('PLUGIN_EVENT_GRAVATAR_RATING_G',           'General (G)');
@define('PLUGIN_EVENT_GRAVATAR_RATING_R',           'Restricted (R)');
@define('PLUGIN_EVENT_GRAVATAR_RATING_PG',          'Parental Guidance (PG)');
@define('PLUGIN_EVENT_GRAVATAR_RATING_X',           'Explicit (X)');

@define('PLUGIN_EVENT_GRAVATAR_METHOD_DEFAULT',     'Default Avatar');
@define('PLUGIN_EVENT_GRAVATAR_DEFAULTAVATAR_DESC', 'What is the URL to your default Avatar image? Please enter here the absolute or relative URL based from your servers URL. ATTENTION! To have the default Avatar displayed, one method has to be set to "' . PLUGIN_EVENT_GRAVATAR_METHOD_DEFAULT . '".');
@define('PLUGIN_EVENT_GRAVATAR_SIZE_DESC',          'Maximum size of the Avatar picture (in pixels)');
@define('PLUGIN_EVENT_GRAVATAR_RATING_DESC',        'Picture Rating');

@define('PLUGIN_EVENT_GRAVATAR_CACHING',            'Caching time');
@define('PLUGIN_EVENT_GRAVATAR_CACHING_DESC',       'If you want to cache the Avatars (recommended!), enter the amount of hours the images will be fetched from your own host instead of contacting the external service. Bear in mind that this will cause traffic on your host. The advantage of caching is to relax traffic for the external service and to be a bit more independent of this central service. "0" disables caching.');

@define('PLUGIN_EVENT_GRAVATAR_ALIGN',              'Alignment');
@define('PLUGIN_EVENT_GRAVATAR_ALIGN_DESC',         'This option configures the alignment of the Avatar, if the Smarty tag option is not used. For Smarty tags you have to do the alignment using the CSS class of the Avatar.');
@define('PLUGIN_EVENT_GRAVATAR_ALIGN_LEFT',         'left');
@define('PLUGIN_EVENT_GRAVATAR_ALIGN_RIGHT',        'right');
@define('PLUGIN_EVENT_GRAVATAR_ALIGN_NONE',         'no alignment');

@define('PLUGIN_EVENT_GRAVATAR_RECENT_ENTRIES',     'Use in sidebar');
@define('PLUGIN_EVENT_GRAVATAR_RECENT_ENTRIES_DESC','Should Avatar images be shown in the recent comments sidebar, too?');

@define('PLUGIN_EVENT_GRAVATAR_INFOLINE',           'Show Avatar type info');
@define('PLUGIN_EVENT_GRAVATAR_INFOLINE_DESC',      'If switched ON, an infoline is displayed below the comment box which types of Avatars are supported at the moment.');

@define('PLUGIN_EVENT_GRAVATAR_METHOD',             'Load Avatar via');
@define('PLUGIN_EVENT_GRAVATAR_METHOD_DESC',        'If previous fails, try this one. The types "' . PLUGIN_EVENT_GRAVATAR_METHOD_DEFAULT . '", "Monster ID", "Wavatar", "Identicon" and "---" will never fail. Everything below this methods won\'t be tried!');
@define('PLUGIN_EVENT_GRAVATAR_SUPPORTED',          '%s author images supported.');

@define('PLUGIN_EVENT_GRAVATAR_AUTOR_ALT',          'Authorname in ALT attribute');
@define('PLUGIN_EVENT_GRAVATAR_AUTOR_ALT_DESC',     'Normally the authors name is displayed in the TITLE attribute of the Avatar image, the ALT attribute is filled with an *. This prevents destroying the layout, when the browser is not able to load the image. But for blind people the ALT attribute is read, so if you want to support them, switch this option ON.');

@define('PLUGIN_EVENT_GRAVATAR_LONG_DESCRIPTION',   '<b><a href="https://www.gravatar.com" target="_blank" rel="noopener">Gravatars</a></b> are central-served Avatar images by email, ' .
        '<b><a https://web.archive.org/web/20120118023537/http://www.peej.co.uk/projects/favatars.html" target="_blank" rel="noopener">Favatars</a></b> are favicons of the writer\'s site, ' .
        '<b><a href="http://www.pavatar.com" target="_blank" rel="noopener">Pavatars</a></b> are images at the writer\'s site, ' .
        '<b><a href="https://twitter.com" target="_blank" rel="noopener">Twitter</a></b> loads twitter profile images, ' .
        '<b><a href="https://identi.ca" target="_blank" rel="noopener">Identica</a></b> loads identi.ca profile images and ' .
        '<b><a href="http://www.splitbrain.org/go/monsterid" target="_blank" rel="noopener">Monster ID</a></b>, <b><a href="http://scott.sherrillmix.com/blog/blogger/wp_identicon/" target="_blank" rel="noopener">Identicon</a></b> and <b><a href="http://www.shamusyoung.com/twentysidedtale/?p=1462" target="_blank" rel="noopener">Wavatar</a></b> Avatars are locally created monster images, unique for each writer.');
@define('PLUGIN_EVENT_GRAVATAR_EXTLING_WARNING',    '<span class="msg_notice"><strong>CAUTION!</strong> This plugin has to be executed before any plugin changing links (like i.e. the exit tracking, or the General Data Protection Regulation (dgsvo) plugin)! ' .
        'Else Pavatars, Favatars and Wavatar Avatars won\'t work!</span>');

@define('PLUGIN_EVENT_GRAVATAR_FALLBACK',           'Gravatar fallback');
@define('PLUGIN_EVENT_GRAVATAR_FALLBACK_DESC',      'Gravatar implements some fallback methods in case, no Gravatar is known for the user. It implements also Monster ID, Identicon and Wavatar. If you choose one of these, no further method after Gravatar is evaluated, if the user entered an email.');
@define('PLUGIN_EVENT_GRAVATAR_FALLBACK_ALLWAYS',   'Gravatar always fallback');
@define('PLUGIN_EVENT_GRAVATAR_FALLBACK_ALLWAYS_DESC', 'Use Gravatar fallbacks even if the user didn\'t enter an email (but an URL or a name)');

