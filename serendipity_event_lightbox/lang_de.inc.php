<?php

/**
 *  @version
 *  @author Translator Name <yourmail@example.com>
 *  DE-Revision: Revision of lang_de.inc.php
 */

@define('PLUGIN_EVENT_LIGHTBOX_NAME', 'Lightbox f�r Blog Eintr�ge mit Bildern');
@define('PLUGIN_EVENT_LIGHTBOX_DESC', 'Lightbox JS ist ein Skript, mit dem Bilder der aktuellen Seite (via Modal Overlay pattern) �berlagert angezeigt werden k�nnen. Es l�sst sich schnell einrichten, um Popup-Bilder f�r den Benutzer ansprechend oder gemeinsam karusselartig �ber Javascripte zu pr�sentieren. Dieses Plugin durchsucht Ihre Eintr�ge und f�gt jedem Bild-verweisenden Link ein HTML "rel-Attribut" hinzu, um die lightbox Anzeige verwenden zu k�nnen. Wenn Sie also m�chten, dass Ihre Vorschaubilder gro� angezeigt werden, m�ssen Sie Ihre Bilder als Links zur gro�en Version einf�gen.');
@define('PLUGIN_EVENT_LIGHTBOX_TYPE', 'W�hlen Sie ihren Leuchtkasten');
@define('PLUGIN_EVENT_LIGHTBOX_TYPE_DESC', 'Um auch versteckte Bilder mit display:none anzuzeigen, nutzen Sie das Lightbox2 Script. Diese Leuchtkasten Scripte sind alle jQuery basiert. Sie unterst�tzen nicht allein nur Bildtypen, sondern m�glicherweise auch anderes, wie Ajax, Videos, Flash, YouTube, iFrame, Inline oder modale Felder. Dieses Plugin nutzt sie nur f�r Fotografie-Leuchtk�sten, aber Sie k�nnen leicht andere Typen ihren Blog-Eintr�gen manuell hinzuf�gen und eine lightbox entsprechend f�r diesen Zweck initiieren, so wie es den jeweiligen Online-Dokumentationen beschrieben wird.');
@define('PLUGIN_EVENT_LIGHTBOX_PATH', 'Pfad zu den Skripten');
@define('PLUGIN_EVENT_LIGHTBOX_PATH_DESC', 'Geben Sie hier den kompletten HTTP Pfad ein (alles nach ihrem Domain Namen), der das Verzeichnis des Plugins angibt.');

@define('PLUGIN_EVENT_LIGHTBOX_JQUERY', 'Nutze Plugin jQuery lib');
@define('PLUGIN_EVENT_LIGHTBOX_JQUERY_DESC', 'Aktivieren Sie dies nur, wenn ihr Theme im header oder footer nicht schon das "default" jquery.js l�dt.');
@define('PLUGIN_EVENT_LIGHTBOX_OPTIMIZATION', 'Seiten Lade-Optimierung');
@define('PLUGIN_EVENT_LIGHTBOX_OPTIMIZATION_DESC', 'Wenn sie diese Option anschalten, so werden die Skript- und CSS-Dateien von Lightbox nur geladen, wenn auch ein Bild auf der aktuellen Seite dargestellt wird. Dies kann die Ladezeit von Seiten ohne Lightbox f�hige Bilder verk�rzen.');
@define('PLUGIN_EVENT_LIGHTBOX_GALLERY', 'Galerie-Erzeugung');
@define('PLUGIN_EVENT_LIGHTBOX_GALLERY_NONE', 'Nur einzelnes Bild');
@define('PLUGIN_EVENT_LIGHTBOX_GALLERY_ENTRY', 'nur Fotos eines Artikels');
@define('PLUGIN_EVENT_LIGHTBOX_GALLERY_PAGE', 'alle Fotos der Seite');

@define('PLUGIN_EVENT_LIGHTBOX_INIT_JS', 'Optionale JavaScript Start Konfiguration');
@define('PLUGIN_EVENT_LIGHTBOX_INIT_JS_DESC', 'Manche Lightbox Typen erlauben bestimmte Konfigurationsparameter einzuf�gen, so dass man beispielsweise "{social_tools: false}" einf�gen kann. Dies ist zur Zeit nur mit prettyPhoto m�glich.');
