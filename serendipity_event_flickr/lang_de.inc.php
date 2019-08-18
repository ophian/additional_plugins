<?php

/**
 *  @version
 *  @author Thomas Hochstein <thh@inter.net>
 */

@define('PLUGIN_EVENT_FLICKR_NAME', 'Aus Flickr importieren');
@define('PLUGIN_EVENT_FLICKR_DESC', 'Bilder von flickr.com in die Mediendatenbank importieren.');
@define('PLUGIN_EVENT_FLICKR_APIKEY', 'API-Key');
@define('PLUGIN_EVENT_FLICKR_APIKEY_INVALID', 'Der Schl�ssel muss 32 Zeichen lang sein und darf nur Ziffern und [a-f] enthalten.');
@define('PLUGIN_EVENT_FLICKR_APIKEY_DESC', 'API-Key von http://www.flickr.com/services/api/');
@define('PLUGIN_EVENT_FLICKR_IMPORT', 'Bilder aus flickr.com importieren');
@define('PLUGIN_EVENT_FLICKR_IMPORT2', 'Bilder aus flickr.com importieren (Schritt 2)');
@define('PLUGIN_EVENT_FLICKR_TAGS', 'Tags');
@define('PLUGIN_EVENT_FLICKR_KEYWORDS', 'Schl�selw�rter');

@define('PLUGIN_EVENT_FLICKR_IMPORT_BLAHBLAH', 'Das Plugin kann nur "�ffentliche" Fotos von flickr.com abrufen. /!\ Beachten Sie das Urheberrecht!');
@define('PLUGIN_EVENT_FLICKR_INSTALL', '<strong>/!\</ strong> Bei einigen Providern ist es nicht m�glich, den Include-Pfad mit der Anweisung ini_set() zu �ndern (z.B. bei free.fr). Das Plugin kann dann nicht ausgef�hrt werden, da einige Klassen nicht instanziiert werden k�nnen. <br /><br />In diesem Fall haben Sie wahrscheinlich einen speziellen Ort in Ihrem Account, an dem Sie allgemein verwendete PHP-Dateien ablegen k�nnen (fragen Sie Ihren Provider). Erstellen Sie auf free.fr einfach ein Verzeichnis mit dem Namen "include" im Stammverzeichnis Ihres Accounts. Kopieren Sie dann alles im phpFlickr/PEAR-Unterverzeichnis des Plugins in dieses Verzeichnis.');

