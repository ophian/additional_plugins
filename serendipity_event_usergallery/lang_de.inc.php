<?php

@define('PLUGIN_EVENT_USERGALLERY_TITLE', 'Bildergalerie');
@define('PLUGIN_EVENT_USERGALLERY_DESC', 'Erm�glicht es den Besuchern, die Mediendatenbank anzusehen');
@define('PLUGIN_EVENT_USERGALLERY_NUMCOLS_TWO', '2');
@define('PLUGIN_EVENT_USERGALLERY_NUMCOLS_THREE', '3');
@define('PLUGIN_EVENT_USERGALLERY_NUMCOLS_FOUR', '4');
@define('PLUGIN_EVENT_USERGALLERY_NUMCOLS_FIVE', '5');
@define('PLUGIN_EVENT_USERGALLERY_NUMCOLS_DESC', 'Anzahl der Spalten f�r die Galerie-Ansicht');
@define('PLUGIN_EVENT_USERGALLERY_NUMCOLS_NAME', 'Anzahl der Spalten');
@define('PLUGIN_EVENT_USERGALLERY_PERMALINK_NAME', 'Permalink f�r die Anzeige der Galerie');
@define('PLUGIN_EVENT_USERGALLERY_PERMALINK_DESC', 'Geben Sie den Permalink ein, den Sie f�r die Galerie benutzen m�chten.');
@define('PLUGIN_EVENT_USERGALLERY_SUBNAME_NAME', 'Name der Unterseite f�r die Galerie');
@define('PLUGIN_EVENT_USERGALLERY_SUBNAME_DESC', 'Geben Sie einen eindeutigen Namen f�r die Unterseite ein, den Sie f�r die Galerie verwenden m�chten (die Galerie wird unter index.php?serendipity[subpage]=IhrUnterseitenname erreichbar sein).');
@define('PLUGIN_EVENT_USERGALLERY_DIRECTORY_NAME', 'Standardverzeichnis');
@define('PLUGIN_EVENT_USERGALLERY_DIRECTORY_DESC', 'W�hlen Sie das Standardverzeichnis, dessen Bilder in der Galerie angezeigt werden sollen.'); // Pick the default directory you would like the gallery to be restricted to');
@define('PLUGIN_EVENT_USERGALLERY_STYLE_NAME', 'Art der Galeriedarstellung');
@define('PLUGIN_EVENT_USERGALLERY_STYLE_DESC', 'W�hlen Sie aus, wie die Galerie dargestellt werden soll. "Medienbibliothek" stellt eine Ordnernavigation sowie eine Suchfunktion zur Verf�gung. Wenn Sie "Seite mit Vorschaubildern" w�hlen, werden die Vorschaubilder eines bestimmten Ordners angezeigt; in diesem Fall k�nnen Sie �ber die Option "Verzeichnisbaum anzeigen" den zur Navigation verwendbaren Verzeichnisbaum ein- oder ausblenden sowie die Option "Nur Bilder des aktuellen Verzeichnisses anzeigen" ein- oder ausschalten.'); // give a thumbnail display of a folder and opens images in a new window');
@define('PLUGIN_EVENT_USERGALLERY_STYLE_SERENDIPITY', 'Medienbibliothek');
@define('PLUGIN_EVENT_USERGALLERY_STYLE_THUMBPAGE', 'Seite mit Vorschaubildern');
@define('PLUGIN_EVENT_USERGALLERY_PRETTY_NAME', 'Anzeigename');
@define('PLUGIN_EVENT_USERGALLERY_PRETTY_DESC', 'Geben Sie den Namen ein, den Sie als Galerietitel verwenden m�chten.');
       
@define('PLUGIN_EVENT_USERGALLERY_INTRO', 'Einleitungstext (optional)');
@define('PLUGIN_EVENT_USERGALLERY_FIXED_WIDTH', 'Feste Bildgr��e');
@define('PLUGIN_EVENT_USERGALLERY_FIXED_DESC', 'Setzt die Bildh�he und -breite aller Bilder auf einen einheitlichen Wert. Auf "0" setzen, um die Standard-Thumbnails zu verwenden.'); // e height and width to a fixed proportion.  Set to zero to use standard thumbnail.');
@define('PLUGIN_EVENT_USERGALLERY_FILESIZE', 'Dateigr��e');
@define('PLUGIN_EVENT_USERGALLERY_DIMENSION', 'Ausma�');
@define('PLUGIN_EVENT_USERGALLERY_IMAGEDISPLAY_NAME', 'Einzelbildanzeige');
@define('PLUGIN_EVENT_USERGALLERY_IMAGEDISPLAY_DESC', 'Sie k�nnen die Bilder entweder entsprechend der Seitengr��e skaliert (bei der Gro�ansicht wird ein Pop-up-Fenster in passender Gr��e angezeigt) oder direkt in einem Pop-up-Fenster anzeigen lassen.');
@define('PLUGIN_EVENT_USERGALLERY_IMAGEDISPLAY_INPAGE', 'In Seite einpassen');
@define('PLUGIN_EVENT_USERGALLERY_IMAGEDISPLAY_POPUP', 'In Popup-Fenster zeigen');
@define('PLUGIN_EVENT_USERGALLERY_DIRLIST_NAME', 'Verzeichnisbaum anzeigen');
@define('PLUGIN_EVENT_USERGALLERY_DIRLIST_DESC', 'Wenn auf "Ja" gesetzt, wird eine Liste aller Verzeichnisse, die sich unterhalb des Standardverzeichnisses befinden, in der Galerie angezeigt.');
@define('PLUGIN_EVENT_USERGALLERY_IMAGESTRICT_NAME', 'Nur Bilder des aktuellen Verzeichnisses anzeigen');
@define('PLUGIN_EVENT_USERGALLERY_IMAGESTRICT_DESC', 'Wenn auf "Ja" gesetzt, werden nur Bilder angezeigt, die sich im aktuellen Verzeichnis befinden. Wenn auf "Nein" gesetzt, wird die Galerie alle Bilder aus allen Unterverzeichnissen ausgeben.');
@define('PLUGIN_EVENT_USERGALLERY_IMAGEORDER_NAME', 'Reihenfolge der Bilder');
@define('PLUGIN_EVENT_USERGALLERY_IMAGEORDER_DESC', 'W�hlen Sie das Kriterium, nach dem die Bilder sortiert werden sollen.');
@define('PLUGIN_EVENT_USERGALLERY_IMAGEORDER_NAMEACS', 'Name (aufsteigend)');
@define('PLUGIN_EVENT_USERGALLERY_IMAGEORDER_NAMEDESC', 'Name (absteigend)');
@define('PLUGIN_EVENT_USERGALLERY_IMAGEORDER_DATEACS', 'Datum (aufsteigend)');
@define('PLUGIN_EVENT_USERGALLERY_IMAGEORDER_DATEDESC', 'Datum (absteigend)');
@define('PLUGIN_EVENT_USERGALLERY_DISPLAYDIR_NAME', 'Gesamten Verzeichnisbaum zeigen');
@define('PLUGIN_EVENT_USERGALLERY_DISPLAYDIR_DESC', 'Wenn auf "Ja" gesetzt, wird der vollst�ndige Verzeichnisbaum auf jeder Seite angezeigt. Wenn auf "Nein" gesetzt, werden nur die jeweiligen Unterverzeichnisse angezeigt. (Dieses Verhalten ist auch vom Template, das f�r die Anzeige der Galerie verwendet wird, abh�ngig.)');
@define('PLUGIN_EVENT_USERGALLERY_1SUBLVL_NAME','Nur eine tiefere Verzeichnisebene anzeigen');
@define('PLUGIN_EVENT_USERGALLERY_1SUBLVL_DESC','Hierdurch wird unterhalb des aktuellen Verzeichnisses nur eine tiefere Verzeichnisebene angezeigt. Die Anzahl aller Bilder, die sich in weiteren Unterebenen befinden, wird aufsummiert. Dies funktioniert nicht, wenn Sie den gesamten Verzeichnisbaum anzeigen lassen.');
@define('PLUGIN_EVENT_USERGALLERY_IMAGESPERPAGE_NAME', 'Bilder pro Seite');
@define('PLUGIN_EVENT_USERGALLERY_IMAGESPERPAGE_DESC', 'Geben Sie die Anzahl der Bilder ein, die pro Seite angezeigt werden sollen. Wenn "0", wird es nur eine Seite geben, auf der sich alle Bilder befinden.');
@define('PLUGIN_EVENT_USERGALLERY_PREVIOUS', 'zur�ck');
@define('PLUGIN_EVENT_USERGALLERY_NEXT', 'weiter');
@define('PLUGIN_EVENT_USERGALLERY_UPONELEVEL','Eine Ebene h�her');
@define('PLUGIN_EVENT_USERGALLERY_BACK', 'zur�ck');
@define('PLUGIN_EVENT_USERGALLERY_FRONTPAGE_NAME', 'Mache diese Seite zur Startseite f�r Serendipity');
@define('PLUGIN_EVENT_USERGALLERY_FRONTPAGE_DESC', 'Anstelle der normalen Startseite wird diese Galerie gezeigt. Die normale Startseite ist dann unter "index.php?frontpage" zu erreichen. Es sollte daf�r gesorgt werden, da� kein anderes Plugin mit Permalink-Feature (wie voting, guestbook) vor dem User-Gallery-Plugin in der Serendipity-Plugin-Konfiguration steht.');

//Exif data tags
@define('PLUGIN_EVENT_USERGALLERY_EXIFDATA_SHOW_NAME', 'EXIF-Tags anzeigen?');
@define('PLUGIN_EVENT_USERGALLERY_EXIFDATA_SHOW_DESC', 'EXIF-Tags sind Zusatzinformationen �ber das Bild und werden, wenn m�glich, automatisch erzeugt. Bitte beachten: Nicht alle Kameras (insbesondere nicht �ltere) unterst�tzen dieses Feature!');
@define('PLUGIN_EVENT_USERGALLERY_EXIFDATA_CAMERA', 'Unterst�tze Kameras: Agfa, Canon, Casio, Epson, Fujifilm, Konica Minolta, Kyocera, Nikon, Olympus, Panasonic, Pentax, Ricoh, Sony.');
@define('PLUGIN_EVENT_USERGALLERY_EXIFDATA_NAME', 'EXIF-Daten');
@define('PLUGIN_EVENT_USERGALLERY_EXIFDATA_DESC', 'In der untenstehenden Liste sind alle verf�gbaren EXIF-Parameter, die von Kameras gesetzt werden k�nnen, aufgef�hrt. Es kann sein, da� Ihre Kamera einige davon nicht liefert, da nicht jede Kamera jede Variable unterst�tzt.');
@define('PLUGIN_EVENT_USERGALLERY_EXIFDATA_ADDITIONALDATA', 'Zusatzinformationen');
@define('PLUGIN_EVENT_USERGALLERY_EXIFDATA_NOADDITIONALDATA', 'Keine Zusatzinformationen verf�gbar.');

@define('PLUGIN_EVENT_USERGALLERY_RSS_FEED', 'Bildausma�e f�r RSS-Feed');
@define('PLUGIN_EVENT_USERGALLERY_RSS_FEED_DESC', 'Dieses Plugin bietet einen RSS-Feed mit den zuletzt hinzugef�gten Bildern. Er ist wie jeder andere Feed erreichbar, �ber die URL: %s. Die URL-Variable "gallery=true" ist wichtig, um die Galerie-Bilder anzuzeigen. Mit der URL-Variable "limit=XX" kann die Anzahl der Bilder vorgegeben werden - ansonsten wird die Standard-Einstellung f�r alle Feeds verwendet. Die URL-Variable "picdir=XXX" kann den Feed auf ein spezielles Verzeichnis beschr�nken. Mit Hilfe von "hide_title=true" ist es m�glich, die Dateinamen auszublenden. Mit der URL-Variable "feed_width=XXX" k�nnen Sie eine optionale Gr��e der Ziel-Bilder bestimmen (nur m�glich ab Serendipity 1.1). Geben Sie hier an, wie lang die l�ngste Seite (Breite oder H�he) der Bilder in Ihren Feeds sein darf.');

@define('PLUGIN_EVENT_USERGALLERY_RSS_FEED_LINKONLY', 'Nur verlinkte Bilder im RSS-Feed?');
@define('PLUGIN_EVENT_USERGALLERY_RSS_FEED_LINKONLY_DESC', 'Hiermit werden nur die Bilder in den Feed �bernommen, die auch in einem Blog-Eintrag verlinkt sind.');

@define('USERGALLERY_SEE_FULLSIZED','Auf das Bild klicken f�r Vollansicht');
@define('USERGALLERY_DOWNLOAD_HERE','Download der Datei');
@define('USERGALLERY_LINKED_ENTRIES', 'Artikel, die dieses Bild verwenden:');
@define('USERGALLERY_LINKED_STATICPAGES','Statische Seiten, die dieses Bild verwenden:');
@define('PLUGIN_EVENT_USERGALLERY_DIRTAB_NAME','Einr�ckung der Unterverzeichnisse im Baum');
@define('PLUGIN_EVENT_USERGALLERY_DIRTAB_DESC','Anzahl Pixel, um die Unterverzeichnisse im Verzeichnisbaum einger�ckt werden.');
@define('PLUGIN_EVENT_USERGALLERY_IMAGE_WIDTH_NAME','Max. Bildbreite in der Seite.');
@define('PLUGIN_EVENT_USERGALLERY_IMAGE_WIDTH_DESC','Maximale Breite, in der ein Bild angezeigt werden kann, wenn "In Seite einpassen" gew�hlt wurde. Die Einstellung "0" bewirkt, dass Bilder in voller Gr��e angezeigt werden.');
@define('PLUGIN_EVENT_USERGALLERY_SHOW_LINKED_ENTRY', 'Soll ein Link zu den Eintr�gen/statischen Seiten gezeigt werden, die auf das Bild verlinken?');

//Media properties
@define('PLUGIN_EVENT_USERGALLERY_MEDIA_PROPERTIES_SHOW_NAME', 'Medien-Eigenschaften zeigen?');
@define('PLUGIN_EVENT_USERGALLERY_MEDIA_PROPERTIES_SHOW_DESC', 'Medien-Eigenschaften zeigen, die einzelnen Elementen der Mediendatenbank zugeordnet sind?');
@define('PLUGIN_EVENT_USERGALLERY_MEDIA_PROPERTIES_NAME', 'Liste der Medien-Eigenschaften');
@define('PLUGIN_EVENT_USERGALLERY_MEDIA_PROPERTIES_DESC', 'Dies ist eine Liste der Medien-Eigenschaften und der Namen, die Sie f�r jede Eigenschaft auf der Seite anzeigen m�chten. Das Format der Liste ist: "ITEM1:Item1;ITEM2:Item2", wobei die Eigenschaft durch Semikolons getrennt sind. F�r jede Eigenschaft wird zuerst der Name (wie in den Konfigurationseinstellungen aufgelistet) angegeben, danach folgen ein Doppelpunkt sowie der jeweilige Anzeigename.');

//Several constants used in the template
@define('PLUGIN_EVENT_USERGALLERY_IMAGES', 'Bilder');
@define('PLUGIN_EVENT_USERGALLERY_PAGINATION', 'Seite %s von %s, insgesamt %s Bilder');
@define('PLUGIN_EVENT_USERGALLERY_RSS_FEED_BODY', 'Use original blog entry for the picture in RSS-Feed?');
@define('PLUGIN_EVENT_USERGALLERY_RSS_FEED_BODY_DESC', 'Falls ausgew�hlt, wird zu einem Bild aus der Mediendatenbank, das in einem Blog-Eintrag verlinkt wurde, im RSS-Feed auch der Inhalt des Blog-Eintrages ausgegebn, anstatt (Standard) nur einen Link zum Blog-Eintrag und dem urspr�nglichen Platz des Bildes.');

@define('PLUGIN_EVENT_USERGALLERY_SHOWLIGHTBOX_NAME', 'Nutze Lightbox Ausgabe');
@define('PLUGIN_EVENT_USERGALLERY_SHOWLIGHTBOX_DESC', 'Ben�tigt ein installiertes Lightbox-Plugin und obige Option: "Einzelbildanzeige" gesetzt als "In Seite einpassen"! Wenn das Lightbox Plugin nur f�r Usergalerieseiten benutzt werden soll, installiere und verschiebe es anschlie�end in der Pluginliste in das Inaktiv (hidden) event Feld!');
@define('PLUGIN_EVENT_USERGALLERY_LIGHTBOXTYPE_NAME', 'W�hle Lightbox-Plugin-Typ');
@define('PLUGIN_EVENT_USERGALLERY_LIGHTBOXTYPE_DESC', 'W�hlen Sie den selben Typ wie im lightbox Plugin. Man kann kein anderes lightbox-widget hier anw�hlen.');

@define('PLUGIN_EVENT_USERGALLERY_SHOWOBJECTS_NAME', 'Zeige alle Nicht-Bild Dateien');
@define('PLUGIN_EVENT_USERGALLERY_SHOWOBJECTS_DESC', 'Erweitere das Galerie Array mit allen Nicht-Bild Dateien aus der Mediendatendank, zB. *.pdf Dateien.');

@define('PLUGIN_EVENT_USERGALLERY_LIGHTBOX_PATH', 'Pfad zum Lightbox Plugin Verzeichnis');

