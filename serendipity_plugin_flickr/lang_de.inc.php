<?php

@define('PLUGIN_SIDEBAR_FLICKR', 'flickr Fotostream');
@define('PLUGIN_SIDEBAR_FLICKR_DESC', 'Zeigt die aktuellen Bilder von FLICKR-Fotostreams an.');
@define('PLUGIN_EVENT_FLICKRCSS', 'flickr Fotostream CSS');
@define('PLUGIN_EVENT_FLICKRCSS_DESC', 'Dieses Plugin ist eine Ergänzung zum flickr Fotostream-Seitenleistenplugin und sorgt für ein ansprechendes Aussehen der Bilddarstellung.');

@define('PLUGIN_SIDEBAR_FLICKR_TITLE_TITLE', 'Titel');
@define('PLUGIN_SIDEBAR_FLICKR_TITLE_BLAHBLAH', 'Titel der Seitenleiste. Kann leer sein.');
@define('PLUGIN_SIDEBAR_FLICKR_USER_TITLE', 'flickr-Account');
@define('PLUGIN_SIDEBAR_FLICKR_USER_TITLE_BLAHBLAH', 'Benutzername oder Email');

@define('PLUGIN_SIDEBAR_FLICKR_IMG_SQUARE', 'Quadratisch');
@define('PLUGIN_SIDEBAR_FLICKR_IMG_THUMBNAIL', 'Vorschaubild');
@define('PLUGIN_SIDEBAR_FLICKR_IMG_SMALL', 'Klein');
@define('PLUGIN_SIDEBAR_FLICKR_IMG_MEDIUM', 'Mittlere Bildgröße');
@define('PLUGIN_SIDEBAR_FLICKR_IMG_LARGE', 'Großes Bild');
@define('PLUGIN_SIDEBAR_FLICKR_IMG_ORIGINAL', 'Originalgröße');

@define('PLUGIN_SIDEBAR_FLICKR_LIGHTBOX_TITLE', 'Lightbox Bildanzeige');
@define('PLUGIN_SIDEBAR_FLICKR_LIGHTBOX_BLAHBLAH', 'Um das Lightbox-Plugin auch für die flickr-Bilder zu nutzen, kann hier die Art des "rel"-Tags eingetragen werden. Das setzt voraus, dass die Bildverlinkung auf JPG eingestellt ist. Standard: lightbox[lightbox_group_entry_flickr]');

@define('PLUGIN_SIDEBAR_FLICKR_SRCIMG_TITLE', 'Vorschaubildgröße');
@define('PLUGIN_SIDEBAR_FLICKR_TGTIMG_TITLE', 'Bildgröße der Bildverlinkung');

@define('PLUGIN_SIDEBAR_FLICKR_SHOWDATE', 'Aufnahmezeitpunkt anzeigen');
@define('PLUGIN_SIDEBAR_FLICKR_SHOWTITLE', 'Bildtitel anzeigen');

@define('PLUGIN_SIDEBAR_FLICKR_TGTLINK_TITLE', 'Art der Bildverlinkung');
@define('PLUGIN_SIDEBAR_FLICKR_TGTLINK_JPG', 'JPG');
@define('PLUGIN_SIDEBAR_FLICKR_TGTLINK_FLICKR', 'flickr');

@define('PLUGIN_SIDEBAR_FLICKR_NUM_TITLE', 'Anzahl der darzustellenden Bilder');
@define('PLUGIN_SIDEBAR_FLICKR_NUM_BLAHBLAH', 'Min: 1, Max: 500');

@define('PLUGIN_SIDEBAR_FLICKR_APIKEY_TITLE', 'flickr API Key');
@define('PLUGIN_SIDEBAR_FLICKR_APIKEY_BLAHBLAH', 'Zur Nutzung dieses Plugins wird ein flickr Services API Key benötigt (http://www.flickr.com/services/api/key.gne).');

@define('PLUGIN_SIDEBAR_FLICKR_APISECRET_TITLE', 'flickr API Secret');
@define('PLUGIN_SIDEBAR_FLICKR_APISECRET_DESC', 'Diese Angabe dient zur sicheren Übertragung und ist optional. Das API Secret erhält man auf der flickr-Profilseite.');

@define('PLUGIN_SIDEBAR_FLICKR_CACHE_TITLE', 'Zwischenspeicher');
@define('PLUGIN_SIDEBAR_FLICKR_CACHE_DESC', 'Gibt den zeitlichen Abstand der Abfragen auf neue flickr-Bilder in Sekunden an. So werden unnötige Seitenaufrufe vermieden. Standard: 3600 Sekunden = 1 Stunde.');

@define('PLUGIN_SIDEBAR_FLICKR_SHOWRSS', 'RSS-Link anzeigen');
@define('PLUGIN_SIDEBAR_FLICKR_SHOWPHOTOSTREAM', 'Link zum flickr-Fotostream anzeigen');

@define('PLUGIN_SIDEBAR_FLICKR_LINK_SHOWRSS', 'flickr RSS Stream');
@define('PLUGIN_SIDEBAR_FLICKR_LINK_PHOTOSTREAM', 'flickr Fotostream');

@define('PLUGIN_SIDEBAR_FLICKR_NUMBEROFCHOICES', 'Anzahl der Auswahlbilder');
@define('PLUGIN_SIDEBAR_FLICKR_USECHOICES','Zufällige Bilder anzeigen?');

/* Errors */
@define('PLUGIN_SIDEBAR_FLICKR_ERROR_WRONGUSER', 'Der flickr-Account existiert nicht oder der API-Key ist falsch.');
@define('PLUGIN_SIDEBAR_FLICKR_ERROR_NOIMG', 'Es sind keine Bilder vorhanden.');

