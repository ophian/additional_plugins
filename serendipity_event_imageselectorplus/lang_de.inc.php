<?php

/**
 *  @version
 *  @author Translator Name <yourmail@example.com>
 *  DE-Revision: Revision of lang_de.inc.php
 *  Revised by
 */

@define('PLUGIN_EVENT_IMAGESELECTORPLUS_NAME', 'Erweiterte Optionen f�r Bildauswahl');
@define('PLUGIN_EVENT_IMAGESELECTORPLUS_DESC', 'Erm�glicht erweiterte Optionen beim Einf�gen von Bildern aus der Mediathek.');
@define('PLUGIN_EVENT_IMAGESELECTORPLUS_TARGET', 'Ziel des Links');
@define('PLUGIN_EVENT_IMAGESELECTORPLUS_TARGET_JS', 'Popup (via JavaScript, angepasste Gr��e)');
@define('PLUGIN_EVENT_IMAGESELECTORPLUS_TARGET_ENTRY', 'Isolierter Eintrag');
@define('PLUGIN_EVENT_IMAGESELECTORPLUS_TARGET_BLANK', 'Popup (via target=_blank)');
@define('PLUGIN_EVENT_IMAGESELECTORPLUS_QUICKBLOG', 'QuickBlog');
@define('PLUGIN_EVENT_IMAGESELECTORPLUS_QUICKBLOG_DESC', 'Wenn Sie bei den folgenden Feldern mindestens einen Titel eintragen, wird das Bild sofort als neuer Blog-Artikel eingestellt. Das Ausgabedesign kann �ber die Datei quickblog.tpl eingestellt werden.');
@define('PLUGIN_EVENT_IMAGESELECTORPLUS_MAXWIDTH', 'Maximale Breite des Vorschaubildes (verwirft die H�henangabe)');
@define('PLUGIN_EVENT_IMAGESELECTORPLUS_MAXHEIGHT', 'Maximale H�he des Vorschaubildes (verwirft die Breitenangabe)');
@define('PLUGIN_EVENT_IMAGESELECTORPLUS_AUTORESIZE', '�ndert die Bildgr��e anhand der Breiten - und H�henangabe');
@define('PLUGIN_EVENT_IMAGESELECTORPLUS_AUTORESIZE_DESC', 'Sendet automatische Gr��en Ihrer Bilder an den Browser, basierend auf der Breiten/H�henangabe des IMG-Tag. Dies kann Ihr Leben erleichtern, au�erdem die Downloadzeiten verringern und die Serverseitige Performance verbessern. (Hinweis: Die Seitenverh�ltnisse bleiben erhalten)');

@define('PLUGIN_EVENT_IMAGESELECTORPLUS_UNZIP_FILES', 'ZIP-Archive entpackt');
@define('PLUGIN_EVENT_IMAGESELECTORPLUS_UNZIP_FILES_BLABLAH', 'Hochgeladene ZIP-Archive entpacken? - Vorgabe f�r das Formular auf der Bilder-Upload-Seite.');
@define('PLUGIN_EVENT_IMAGESELECTORPLUS_UNZIP_FILES_DESC', 'Hochgeladene ZIP-Archive entpacken?');
@define('PLUGIN_EVENT_IMAGESELECTORPLUS_UNZIP_OK', 'ZIP-Archive erfolgreich entpackt!');
@define('PLUGIN_EVENT_IMAGESELECTORPLUS_UNZIP_FAILED', 'Fehler beim entpacken der ZIP-Archive!');
@define('PLUGIN_EVENT_IMAGESELECTORPLUS_UNZIP_IMAGE_FROM_ARCHIVE', 'Bild aus einem ZIP-Archive');
@define('PLUGIN_EVENT_IMAGESELECTORPLUS_UNZIP_ADD_TO_DB', 'zur Datenbank hinzugef�gt');

@define('PLUGIN_EVENT_IMAGESELECTORPLUS_JHEAD', 'jhead nutzen, um EXIF-Daten zu erhalten');
@define('PLUGIN_EVENT_IMAGESELECTORPLUS_JHEAD_DESC', '�berschreibt das Standardverhalten und benutzt externe Funktionen (Calls), um per jhead EXIF-Daten zu erhalten. Nutzen Sie diese Option nur, wenn jhead installiert ist und auch ausgef�hrt werden kann!');

@define('PLUGIN_EVENT_IMAGESELECTORPLUS_IMAGE_SIZE_DESC', 'Wenn Sie die voreingestellte $serendipity[\'thumbSize\'] Gr��e hier �ndern, wird ein zus�tzliches Bild in der genannten Gr��e in der Mediathek erstellt. Diese Image Instanz wird dann im Frontend als Bildvorschau mit entsprechendem Link zum Original Bild in ihrem Blogeintrag benutzt.');
@define('PLUGIN_EVENT_IMAGESELECTORPLUS_ASOBJECT', 'Objekt-Type ist kein Bild?');

@define('PLUGIN_EVENT_IMAGESELECTORPLUS_THUMBRESIZE_DESC', 'Die Default Einstellung f�r beide MAX Felder ist 0 und wird als fallback f�r die normale Thumbnailgenerierung benutzt! Setzt man hier andere Werte, wird die $serendipity[\'thumbSize\'] Einstellung, die in der globalen Blog Einstellung, in "Konfiguration" - "Bildkonvertierung", definiert wird, �berschrieben! M�chte man nur die zu erstellende Thumb Gr��e in der Mediathek beeinflussen, sollte man entweder die globale "Bildkonvertierung" benutzen, oder, je nach gew�nschter Gewichtung nach Quer- und Hochformat Verh�ltnissen, eine dieser beiden Max-Einstellungen ver�ndern. Setzt man hier beide Werte gleich, hat dies denselben Effekt.');

@define('PLUGIN_EVENT_IMAGESELECTORPLUS_EXAMPLE_READMEHINT', 'Bitte lesen Sie die Plugin Documentation �ber obigen Link sorgf�ltig durch!');
@define('PLUGIN_EVENT_IMAGESELECTORPLUS_EXAMPLETEXT', 'ACHTUNG: Die Kern-Konfigurations-Options f�r die Bilder Gr��enanpassung via Javascript/Ajax verhindert die ordentliche Ausf�hrung mancher hier gegebenen Optionen, wie Quickblog-Eintr�ge und Quickblog bearbeitete "Vorschaubilder". Wenn Sie dieses nutzen wollen, m�ssen Sie die genannte Kern-Konfiguration zur�cksetzen! Au�erdem m�ssen Sie die "Dynamische Bildgr��enanpassung..." Option in der globalen, wie der Plugin Konfiguration erlauben, um die Gr��en�nderung von Bildern zu gestatten.');
@define('PLUGIN_EVENT_IMAGESELECTORPLUS_EXAMPLE_QUICKBLOG', 'ACHTUNG: Hochgeladene und per <b>Quickblog</b> <u>gr��enver�nderte</u> Bilddateien werden als <u>zus�tzliche</u> Mediendateien gespeichert, zB. <em>"imagename.quickblog.jpg"</em>. Da solch ein unabh�ngiges Bildmaterial nicht zus�tzlich synchronisiert, siehe automatische Datei- und Datenbank-R�umarbeiten, oder ein weiteres Auto-Vorschaubild generiert werden soll, wurde in der Serendipity <b>Styx Edtion 2.4+</b> bereits Vorsorge getragen, dass solche Dateien von der Synchronisierung und Anzeige in der Mediathek ausgenommen bleiben. Sie k�nnen Sie nur durch einen zus�tzlichen Aktionsbutton neben dem L�schen Button beim normalen Vorschaubild erkennen.');

@define('PLUGIN_EVENT_IMAGESELECTORPLUS_ALLOW_QUICKBLOG', 'Verwende das QuickBlog Formular');
@define('PLUGIN_EVENT_IMAGESELECTORPLUS_ALLOW_QUICKBLOG_DESC', 'Quickblog ist ein spezieller Generator, um Blog Eintrags unmittelbar im Formular von "Medien hinzuf�gen" beim Upload zu erstellen. Wenn Sie ein einzelnes Bild hochladen, k�nnen sie zeitgleich einen assoziierten Blogeintrag erstellen. Sie sollten sich dessen Einsatz aber gut �berlegen, da sich solche Blogeintr�ge, auch in der Medienauszeichnung, in Aussehen, Ablage und Handhabung von den normalen Eintr�gen unterscheiden.');

@define('PLUGIN_EVENT_IMAGESELECTORPLUS_ZIP_WARNING', '<b>F�r das Entzippen:</b> Laden Sie nur Zip-Dateien hoch die folgendem Namensschema entsprechen:<ul><li>Nur valides ASCII verwenden [A-Za-z0-9_-] ohne Leerzeichen</li><li>Kleinschreibung von Ordnernamen (Empfohlen)</li><li>Keine Datei-Namens-Duplikate in rekursiven Ordnern</li><li>Bilder ben�tigen eine valide Datei.extension</li></ul>Auch die ZIP-Datei selbst muss diesem Schema entsprechen. Anderenfalls wird die Zip-Deflation entweder abgebrochen, oder kann zu Fehlern und unvorhergesehenen Folge-Verhalten f�hren, das Ihre Mediathek sch�digt.');

