<?php

/**
 *  @version 1.17
 *  EN-Revision: Revision of lang_en.inc.php
 *  @author Konrad Bauckmeier <kontakt@dd4kids.de>
 *  @revisionDate 2009/08/20
 */

@define('PLUGIN_EVENT_GRAVATAR_NAME',               'Avatar Plugin');
@define('PLUGIN_EVENT_GRAVATAR_DESC',               'Avatare bei Kommentaren anzeigen. Unterstützt werden Gravatare, Pavatare, Favatare, Wavatare, Monster ID, Identicon, Twitter und Identica Avatare');

@define('PLUGIN_EVENT_GRAVATAR_USE_SMARTY',         'Smarty Tag erzeugen');
@define('PLUGIN_EVENT_GRAVATAR_USE_SMARTY_DESC',    'Wenn diese Option eingeschaltet ist, so wird das Avatar Bild nicht direkt in den Kommentar geschrieben, sondern es wird ein Smarty Tag {$comment.avatar} erzeugt, in dem der HTML Code des Images steht. Sie sollten diese Option nur einschalten, wenn sie wissen, dass ihr Template dieses Smarty Tag unterstützt. Ob das der Fall ist, sollten Sie einfach ausprobieren.');

@define('PLUGIN_EVENT_GRAVATAR_DEFAULTAVATAR',      'Standard-Avatar');
@define('PLUGIN_EVENT_GRAVATAR_SIZE',               'Bildgröße');
@define('PLUGIN_EVENT_GRAVATAR_RATING',             'Gravatar Indizierung');
@define('PLUGIN_EVENT_GRAVATAR_RATING_NO',          'Keine Indizierung benutzen');
@define('PLUGIN_EVENT_GRAVATAR_RATING_G',           'General (G)');
@define('PLUGIN_EVENT_GRAVATAR_RATING_R',           'Restricted (R)');
@define('PLUGIN_EVENT_GRAVATAR_RATING_PG',          'Parental Guidance (PG)');
@define('PLUGIN_EVENT_GRAVATAR_RATING_X',           'Explicit (X)');

@define('PLUGIN_EVENT_GRAVATAR_METHOD_DEFAULT',     'Standard-Avatar');
@define('PLUGIN_EVENT_GRAVATAR_DEFAULTAVATAR_DESC', 'URL zu ihrem Standard-Avatar. Hier müssen Sie den relativen oder absoluten Pfad bezogen auf ihre Server URL zu ihrem Standard-Avatar angeben. ACHTUNG: Damit es benutzt wird, muss eine Methode auf "' . PLUGIN_EVENT_GRAVATAR_METHOD_DEFAULT . '" stehen!');
@define('PLUGIN_EVENT_GRAVATAR_SIZE_DESC',          'Maximal dargestellte Größe des Avatar-Bildes in Pixeln');
@define('PLUGIN_EVENT_GRAVATAR_RATING_DESC',        'Kinderschutz :)');

@define('PLUGIN_EVENT_GRAVATAR_CACHING',            'Cache Zeit');
@define('PLUGIN_EVENT_GRAVATAR_CACHING_DESC',       'Wenn Avatare zwischengespeichert werden sollen (empfohlen!), muss hier die Anzahl der Stunden eingetragen werden, die Bilder vom eigenen Server anstatt vom externen Service abgeholt werden sollen. Dies wird ein wenig mehr Traffic auf diesem Blog Server verursachen, dafür macht es die Avatar Darstellung unabhängiger vom externen, zentralen Servern. "0" stellt das Zwischenspeichern ab.');

@define('PLUGIN_EVENT_GRAVATAR_ALIGN',              'Ausrichtung');
@define('PLUGIN_EVENT_GRAVATAR_ALIGN_DESC',         'Mit dieser Option kann die Ausrichtung des Avatars im Kommentar konfiguriert werden, falls Sie nicht die Smarty Tag Option verwenden. Bei der Smarty Tag Option muss die Ausrichtung über die entsprechende CSS Klasse im Stylesheet konfiguriert werden.');
@define('PLUGIN_EVENT_GRAVATAR_ALIGN_LEFT',         'links');
@define('PLUGIN_EVENT_GRAVATAR_ALIGN_RIGHT',        'rechts');
@define('PLUGIN_EVENT_GRAVATAR_ALIGN_NONE',         'keine Ausrichtung');

@define('PLUGIN_EVENT_GRAVATAR_RECENT_ENTRIES',     'In der Seitenleiste anzeigen');
@define('PLUGIN_EVENT_GRAVATAR_RECENT_ENTRIES_DESC','Sollen Avatar Bilder auch in der Seitenleiste (des "letzte Kommentare" Plugins) angezeigt werden?');

@define('PLUGIN_EVENT_GRAVATAR_INFOLINE',           'Avatar Typ anzeigen');
@define('PLUGIN_EVENT_GRAVATAR_INFOLINE_DESC',      'Wenn angeschaltet, wird eine Zeile unterhalb des Kommentar Editors ausgegeben, die angibt, welche Avatar Typen aktuell unterstützt werden.');

@define('PLUGIN_EVENT_GRAVATAR_METHOD',             'Avatar laden über');
@define('PLUGIN_EVENT_GRAVATAR_SUPPORTED',          '%s Autoren-Bilder werden unterstützt.');

@define('PLUGIN_EVENT_GRAVATAR_AUTOR_ALT',          'Autorenname im ALT Attribut');
@define('PLUGIN_EVENT_GRAVATAR_AUTOR_ALT_DESC',     'Normalerweise wird der Autorenname im TITLE Attribut des Avatar Bildes angegeben, das ALT Attribut wird mit einem * gefüllt, um das Seitenlayout nicht zu zerstören, wenn der Browser das Bild nicht laden kann. Allerdings wird blinden Lesern das ALT Attribut vorgelesen. Falls Sie diese Leser unterstützen wollen, sollten Sie diese Option einschalten.');

@define('PLUGIN_EVENT_GRAVATAR_LONG_DESCRIPTION',   '<b><a href="https://www.gravatar.com" target="_blank" rel="noopener">Gravatare</a></b> werden von einem zentralen Server anhand der EMail Information des Kommentators abgeholt, ' .
        '<b><a href="https://web.archive.org/web/20120118023537/http://www.peej.co.uk/projects/favatars.html" target="_blank" rel="noopener">Favatare</a></b> und <b><a href="http://www.pavatar.com" target="_blank" rel="noopener">Pavatare</a></b> sind die favicons, bzw eigene größere Bilder auf der Homepage, die der Kommentator angegeben hat, ' .
        '<b><a href="https://twitter.com" target="_blank" rel="noopener">Twitter</a></b> lädt Bilder aus Twitter Profilen, ' .
        '<b><a href="https://identi.ca" target="_blank" rel="noopener">Identica</a></b> lädt Bilder aus Identica Profilen, ' .
        '<b><a href="https://www.splitbrain.org/go/monsterid" target="_blank" rel="noopener">Monster ID</a></b>, <b><a href="http://scott.sherrillmix.com/blog/blogger/wp_identicon/" target="_blank" rel="noopener">Identicon</a></b> und <b><a href="http://www.shamusyoung.com/twentysidedtale/?p=1462" target="_blank" rel="noopener">Wavatar</a></b> Avatare sind lokal erstellte und für jeden Schreiber einzigartige Bilder.');
@define('PLUGIN_EVENT_GRAVATAR_EXTLING_WARNING',    '<span class="msg_notice"><strong>ACHTUNG!</strong> Dieses Plugin muss vor allen Plugins ausgeführt werden, die Links verändern (wie z.B. das Exit Tracking, oder das Allgemeine Datenschutzverordnung (dgsvo) Plugin)!<br/>' .
        'Ansonsten werden Pavatare, Favatare und Wavatar Avatare nicht funktionieren!</span>');

@define('PLUGIN_EVENT_GRAVATAR_FALLBACK',           'Gravatar Fallback');
@define('PLUGIN_EVENT_GRAVATAR_FALLBACK_DESC',      'Gravatar implementiert eigene Fallback Methoden für den Fall, dass kein Gravatar für den Benutzer gefunden wurde. Es implementiert ebenfalls Monster ID, Identicon und Wavatar. Wenn Sie einen dieser Fallbacks einstellen, werden keine weitere Methoden nach Gravatar versucht, falls der Benutzer eine EMail angegeben hat.');
@define('PLUGIN_EVENT_GRAVATAR_FALLBACK_ALLWAYS',   'Gravatar Fallback immer benutzen');
@define('PLUGIN_EVENT_GRAVATAR_FALLBACK_ALLWAYS_DESC', 'Gravatar Fallbacks auch dann benutzen, wenn der Benutzer keine EMail (aber eine URL oder einen Namen) eingegeben hat.');

// Next lines were translated on 2009/08/20
@define('PLUGIN_EVENT_GRAVATAR_METHOD_DESC',        'Wenn die vorherigen Methoden fehlschlagen, versuche diese. Der Typ "' . PLUGIN_EVENT_GRAVATAR_METHOD_DEFAULT . '", "Monster ID", "Wavatar", "Identicon" und  "---" wird niemals fehlschlagen. Alles unterhalb dieser Methoden wird nicht versucht.');

