<?php

/**
 *  @version
 *  @author Translator Name <yourmail@example.com>
 *  DE-Revision: Revision of lang_de.inc.php
 *  Revised by
 */

@define('PLUGIN_EVENT_IMAGESELECTORPLUS_NAME', 'Erweiterte Optionen für Bildauswahl');
@define('PLUGIN_EVENT_IMAGESELECTORPLUS_DESC', 'Ermöglicht erweiterte Optionen beim Einfügen von Bildern aus der Mediathek.');
@define('PLUGIN_EVENT_IMAGESELECTORPLUS_TARGET', 'Ziel des Links');
@define('PLUGIN_EVENT_IMAGESELECTORPLUS_TARGET_JS', 'Popup (via JavaScript, angepasste Größe)');
@define('PLUGIN_EVENT_IMAGESELECTORPLUS_TARGET_ENTRY', 'Isolierter Eintrag');
@define('PLUGIN_EVENT_IMAGESELECTORPLUS_TARGET_BLANK', 'Popup (via target=_blank)');
@define('PLUGIN_EVENT_IMAGESELECTORPLUS_QUICKBLOG', 'QuickBlog');
@define('PLUGIN_EVENT_IMAGESELECTORPLUS_QUICKBLOG_DESC', 'Wenn Sie bei den folgenden Feldern mindestens einen Titel eintragen, wird das Bild sofort als neuer Blog-Artikel eingestellt. Das Ausgabedesign kann über die Datei quickblog.tpl eingestellt werden.');
@define('PLUGIN_EVENT_IMAGESELECTORPLUS_MAXWIDTH', 'Maximale Breite des Vorschaubildes (verwirft die Höhenangabe)');
@define('PLUGIN_EVENT_IMAGESELECTORPLUS_MAXHEIGHT', 'Maximale Höhe des Vorschaubildes (verwirft die Breitenangabe)');
@define('PLUGIN_EVENT_IMAGESELECTORPLUS_AUTORESIZE', 'Ändert die Bildgröße anhand der Breiten - und Höhenangabe');
@define('PLUGIN_EVENT_IMAGESELECTORPLUS_AUTORESIZE_DESC', 'Sendet automatische Größen Ihrer Bilder an den Browser, basierend auf der Breiten/Höhenangabe des IMG-Tag. Dies kann Ihr Leben erleichtern, außerdem die Downloadzeiten verringern und die Serverseitige Performance verbessern. (Hinweis: Die Seitenverhältnisse bleiben erhalten)');

@define('PLUGIN_EVENT_IMAGESELECTORPLUS_UNZIP_FILES', 'ZIP-Archive entpackt');
@define('PLUGIN_EVENT_IMAGESELECTORPLUS_UNZIP_FILES_BLABLAH', 'Hochgeladene ZIP-Archive entpacken? - Vorgabe für das Formular auf der Bilder-Upload-Seite.');
@define('PLUGIN_EVENT_IMAGESELECTORPLUS_UNZIP_FILES_DESC', 'Hochgeladene ZIP-Archive entpacken?');
@define('PLUGIN_EVENT_IMAGESELECTORPLUS_UNZIP_OK', 'ZIP-Archive erfolgreich entpackt!');
@define('PLUGIN_EVENT_IMAGESELECTORPLUS_UNZIP_FAILED', 'Fehler beim entpacken der ZIP-Archive!');
@define('PLUGIN_EVENT_IMAGESELECTORPLUS_UNZIP_IMAGE_FROM_ARCHIVE', 'Bild aus einem ZIP-Archive');
@define('PLUGIN_EVENT_IMAGESELECTORPLUS_UNZIP_ADD_TO_DB', 'zur Datenbank hinzugefügt');

@define('PLUGIN_EVENT_IMAGESELECTORPLUS_JHEAD', 'jhead nutzen, um EXIF-Daten zu erhalten');
@define('PLUGIN_EVENT_IMAGESELECTORPLUS_JHEAD_DESC', 'Überschreibt das Standardverhalten und benutzt externe Funktionen (Calls), um per jhead EXIF-Daten zu erhalten. Nutzen Sie diese Option nur, wenn jhead installiert ist und auch ausgeführt werden kann!');

@define('PLUGIN_EVENT_IMAGESELECTORPLUS_IMAGE_SIZE_DESC', 'Wenn Sie die voreingestellte $serendipity[\'thumbSize\'] Größe hier ändern, wird ein zusätzliches Bild in der genannten Größe in der Mediathek erstellt. Diese Image Instanz wird dann im Frontend als Bildvorschau mit entsprechendem Link zum Original Bild in ihrem Blogeintrag benutzt.');
@define('PLUGIN_EVENT_IMAGESELECTORPLUS_ASOBJECT', 'Objekt-Type ist kein Bild?');

@define('PLUGIN_EVENT_IMAGESELECTORPLUS_THUMBRESIZE_DESC', 'Die Default Einstellung für beide MAX Felder ist 0 und wird als fallback für die normale Thumbnailgenerierung benutzt! Setzt man hier andere Werte, wird die $serendipity[\'thumbSize\'] Einstellung, die in der globalen Blog Einstellung, in "Konfiguration" - "Bildkonvertierung", definiert wird, überschrieben! Möchte man nur die zu erstellende Thumb Größe in der Mediathek beeinflussen, sollte man entweder die globale "Bildkonvertierung" benutzen, oder, je nach gewünschter Gewichtung nach Quer- und Hochformat Verhältnissen, eine dieser beiden Max-Einstellungen verändern. Setzt man hier beide Werte gleich, hat dies denselben Effekt.');

@define('PLUGIN_EVENT_IMAGESELECTORPLUS_EXAMPLE_READMEHINT', 'Bitte lesen Sie die Plugin Documentation über obigen Link sorgfältig durch!');
@define('PLUGIN_EVENT_IMAGESELECTORPLUS_EXAMPLETEXT', 'ACHTUNG: Die Kern-Konfigurations-Options für die Bilder Größenanpassung via Javascript/Ajax verhindert die ordentliche Ausführung mancher hier gegebenen Optionen, wie Quickblog-Einträge und Quickblog bearbeitete "Vorschaubilder". Wenn Sie dieses nutzen wollen, müssen Sie die genannte Kern-Konfiguration zurücksetzen! Außerdem müssen Sie die "Dynamische Bildgrößenanpassung..." Option in der globalen, wie der Plugin Konfiguration erlauben, um die Größenänderung von Bildern zu gestatten.');
@define('PLUGIN_EVENT_IMAGESELECTORPLUS_EXAMPLE_QUICKBLOG', 'ACHTUNG: Hochgeladene und per <b>Quickblog</b> <u>größenveränderte</u> Bilddateien werden als <u>zusätzliche</u> Mediendateien gespeichert, zB. <em>"imagename.quickblog.jpg"</em>. Da solch ein unabhängiges Bildmaterial nicht zusätzlich synchronisiert, siehe automatische Datei- und Datenbank-Räumarbeiten, oder ein weiteres Auto-Vorschaubild generiert werden soll, wurde in der Serendipity <b>Styx Edtion 2.4+</b> bereits Vorsorge getragen, dass solche Dateien von der Synchronisierung und Anzeige in der Mediathek ausgenommen bleiben. Sie können Sie nur durch einen zusätzlichen Aktionsbutton neben dem Löschen Button beim normalen Vorschaubild erkennen.');

@define('PLUGIN_EVENT_IMAGESELECTORPLUS_ALLOW_QUICKBLOG', 'Verwende das QuickBlog Formular');
@define('PLUGIN_EVENT_IMAGESELECTORPLUS_ALLOW_QUICKBLOG_DESC', 'Quickblog ist ein spezieller Generator, um Blog Eintrags unmittelbar im Formular von "Medien hinzufügen" beim Upload zu erstellen. Wenn Sie ein einzelnes Bild hochladen, können sie zeitgleich einen assoziierten Blogeintrag erstellen. Sie sollten sich dessen Einsatz aber gut überlegen, da sich solche Blogeinträge, auch in der Medienauszeichnung, in Aussehen, Ablage und Handhabung von den normalen Einträgen unterscheiden.');

@define('PLUGIN_EVENT_IMAGESELECTORPLUS_ZIP_WARNING', '<b>Für das Entzippen:</b> Laden Sie nur Zip-Dateien hoch die folgendem Namensschema entsprechen:<ul><li>Nur valides ASCII verwenden [A-Za-z0-9_-] ohne Leerzeichen</li><li>Kleinschreibung von Ordnernamen (Empfohlen)</li><li>Keine Datei-Namens-Duplikate in rekursiven Ordnern</li><li>Bilder benötigen eine valide Datei.extension</li></ul>Auch die ZIP-Datei selbst muss diesem Schema entsprechen. Anderenfalls wird die Zip-Deflation entweder abgebrochen, oder kann zu Fehlern und unvorhergesehenen Folge-Verhalten führen, das Ihre Mediathek schädigt.');

