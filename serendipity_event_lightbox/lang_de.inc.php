<?php

/**
 *  @version
 *  @author Translator Name <yourmail@example.com>
 *  DE-Revision: Revision of lang_de.inc.php
 */

@define('PLUGIN_EVENT_LIGHTBOX_NAME', 'Lightbox für Blog Einträge mit Bildern');
@define('PLUGIN_EVENT_LIGHTBOX_DESC', 'Lightbox JS ist ein Skript, mit dem Bilder der aktuellen Seite (via Modal Overlay pattern) überlagert angezeigt werden können. Es lässt sich schnell einrichten, um Popup-Bilder für den Benutzer ansprechend oder gemeinsam karusselartig über Javascripte zu präsentieren. Dieses Plugin durchsucht Ihre Einträge und fügt jedem Bild-verweisenden Link ein HTML "rel-Attribut" hinzu, um die lightbox Anzeige verwenden zu können. Wenn Sie also möchten, dass Ihre Vorschaubilder groß angezeigt werden, müssen Sie Ihre Bilder als Links zur großen Version einfügen.');
@define('PLUGIN_EVENT_LIGHTBOX_TYPE', 'Wählen Sie ihren Leuchtkasten');
@define('PLUGIN_EVENT_LIGHTBOX_TYPE_DESC', 'Um auch versteckte Bilder mit display:none anzuzeigen, nutzen Sie das Lightbox2 Script. Bis auf PhotoSwipe sind diese Leuchtkasten Scripte alle jQuery basiert. Sie unterstützen nicht allein nur Bildtypen, sondern möglicherweise auch anderes, wie Ajax, Videos, Flash, YouTube, iFrame, Inline oder modale Felder. Dieses Plugin nutzt sie nur für Fotografie-Leuchtkästen, aber Sie können leicht andere Typen ihren Blog-Einträgen manuell hinzufügen und eine lightbox entsprechend für diesen Zweck initiieren, so wie es den jeweiligen Online-Dokumentationen beschrieben wird.');
@define('PLUGIN_EVENT_LIGHTBOX_PATH', 'Pfad zu den Skripten');
@define('PLUGIN_EVENT_LIGHTBOX_PATH_DESC', 'Geben Sie hier den kompletten HTTP Pfad ein (alles nach ihrem Domain Namen), der das Verzeichnis des Plugins angibt.');

@define('PLUGIN_EVENT_LIGHTBOX_JQUERY', 'Nutze Plugin jQuery lib (veraltet)');
@define('PLUGIN_EVENT_LIGHTBOX_JQUERY_DESC', 'Aktivieren Sie dies nur, wenn ihr Theme im header oder footer nicht schon das "default" jquery.js lädt.');
@define('PLUGIN_EVENT_LIGHTBOX_OPTIMIZATION', 'Seiten Lade-Optimierung');
@define('PLUGIN_EVENT_LIGHTBOX_OPTIMIZATION_DESC', 'Wenn sie diese Option anschalten, so werden die Skript- und CSS-Dateien von Lightbox nur geladen, wenn auch ein Bild auf der aktuellen Seite dargestellt wird. Dies kann die Ladezeit von Seiten ohne Lightbox fähige Bilder verkürzen.');
@define('PLUGIN_EVENT_LIGHTBOX_GALLERY', 'Galerie-Erzeugung');
@define('PLUGIN_EVENT_LIGHTBOX_GALLERY_NONE', 'Nur einzelnes Bild');
@define('PLUGIN_EVENT_LIGHTBOX_GALLERY_ENTRY', 'nur Fotos eines Artikels');
@define('PLUGIN_EVENT_LIGHTBOX_GALLERY_PAGE', 'alle Fotos der Seite');

@define('PLUGIN_EVENT_LIGHTBOX_INIT_JS', 'Optionale JavaScript Start Konfiguration');
@define('PLUGIN_EVENT_LIGHTBOX_INIT_JS_DESC', 'Einige Lightbox-Typen erlauben die Übergabe von benutzerdefinierten Konfigurationsobjekten, sodass Sie z.B. "{social_tools: false}" eingeben können (nur in prettyPhoto).
Andere wie "PhotoSwipe" sind pingelig bei der Auswahl des Selektors, um nur Eintrags-Galerien zu erfassen. Der Standard-Build erfasst diese anhand des ["pure"] Standard-Theme entries → DIV-Klassenselektors « class="post_content" » und bei statischen Seiten durch die Namen "page_content".
Überprüfen Sie den Klassennamen, den Ihr Theme verwendet, und fügen Sie ihn hier ein, z.B. für ein Garland-Theme: « gallery: ".garland_entry", » (ohne « »).');

