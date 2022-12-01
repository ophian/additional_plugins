<?php

/**
 * @version
 * @author Translator Name <yourmail@example.com>
 * DE-Revision: Revision of lang_de.inc.php
 */

@define('PLUGIN_PODCAST_NAME', 'Easy Podcasting Plugin');
@define('PLUGIN_PODCAST_DESC', 'F�gt "Podcasting" F�higkeiten hinzu (RSS enclosure, Video/Sound-Player)');
@define('PLUGIN_PODCAST_EASY', 'Einfache Einstellungen:');
@define('PLUGIN_PODCAST_USEPLAYER', 'Player anzeigen');
@define('PLUGIN_PODCAST_USEPLAYER_DESC', 'Soll Code f�r einen Player anstatt eines Links auf Mediadateien erzeugt werden?');
@define('PLUGIN_PODCAST_AUTOSIZE', 'Player Gr��e anpassen');
@define('PLUGIN_PODCAST_AUTOSIZE_DESC', 'Versucht, die Gr��e eines Videos zu ermitteln, und passt dann die Gr��e des Players entsprechend an. Die Einstellung f�r Breite und H�he wird dann ignoriert.');
@define('PLUGIN_PODCAST_WIDTH', 'Breite');
@define('PLUGIN_PODCAST_WIDTH_DESC', 'Wie breit soll der eingef�gte Player sein?');
@define('PLUGIN_PODCAST_HEIGHT', 'H�he');
@define('PLUGIN_PODCAST_HEIGHT_DESC', 'Wie hoch soll der eingef�gte Player sein?');
@define('PLUGIN_PODCAST_ALIGN', 'Ausrichtung');
@define('PLUGIN_PODCAST_ALIGN_DESC', 'Wie soll die Ausrichtung des eingef�gten Player zum Text sein?');
@define('PLUGIN_PODCAST_ALIGN_LEFT', 'links');
@define('PLUGIN_PODCAST_ALIGN_RIGHT', 'rechts');
@define('PLUGIN_PODCAST_ALIGN_CENTER', 'zentriert');
@define('PLUGIN_PODCAST_ALIGN_NONE', 'keine');
@define('PLUGIN_PODCAST_FIRSTMEDIAONLY', 'Erste Mediendatei an den Feed Eintrag h�ngen');
@define('PLUGIN_PODCAST_FIRSTMEDIAONLY_DESC', 'Die RSS Spezifikation unterst�tzt nur einen Medienanhang pro Eintrag. Wird diese Option angeschaltet, so wird nur die erste gefundene Mediendatei pro Artikel an den Feed Eintrag angeh�ngt.');
@define('PLUGIN_PODCAST_NOPODCASTING_CLASS', 'Ignorieren �ber CSS class');
@define('PLUGIN_PODCAST_NOPODCASTING_CLASS_DESC', 'Wenn ein Medien Link dieses Class Style bekommt, dann wird er ignoriert (kein Player und kein Eintrag im RSS).');

@define('PLUGIN_PODCAST_EXTATTRSETTINGS', 'Podcasting �ber die erweiterten Artikel Attribute:');
@define('PLUGIN_PODCAST_EXTATTR', 'Erweiterte Artikel Attribute');
@define('PLUGIN_PODCAST_EXTATTR_DESC', 'Hier k�nnen Sie einstellen, welche erweiterten Artikel Attribute als Mediendateien interpretiert und deshalb in den RSS Feed als Enclosure gepackt werden sollen. Dies muss eine Komma separierte Liste der Attributsnamen sein. Das Plugin "Erweiterte Eigenschaften von Artikeln" wird ben�tigt!');

@define('PLUGIN_PODCAST_EXTPOS', 'Medien aus erweiterten Artikel Attributen einbetten');
@define('PLUGIN_PODCAST_EXTPOS_DESC', 'Hier stellen Sie ein, an welcher Stelle Medien aus erweiterten Attributen in den Artikel eingef�gt werden sollen.');
@define('PLUGIN_PODCAST_EXTPOS_NONE', 'Nicht in den Artikel einf�gen');
@define('PLUGIN_PODCAST_EXTPOS_BT', 'Oberhalb des Artikels');
@define('PLUGIN_PODCAST_EXTPOS_BB', 'Unterhalb des Artikels');
@define('PLUGIN_PODCAST_EXTPOS_ET', 'Oberhalb des erw. Artikels');
@define('PLUGIN_PODCAST_EXTPOS_EB', 'Unterhalb des erw. Artikels');

@define('PLUGIN_PODCAST_EXPERT', 'Experten Einstellungen:');
@define('PLUGIN_PODCAST_QTEXT', 'Quicktime Erweiterungen');
@define('PLUGIN_PODCAST_QTEXT_DESC', 'Erweiterungen, die mit dem Quicktime Player abgespielt werden sollen.');
@define('PLUGIN_PODCAST_WMEXT', 'WindowsMediaPlayer Erweiterungen');
@define('PLUGIN_PODCAST_WMEXT_DESC', 'Erweiterungen, die mit dem Windows Media Player abgespielt werden sollen.');
@define('PLUGIN_PODCAST_MFEXT', 'Flash Erweiterungen');
@define('PLUGIN_PODCAST_MFEXT_DESC', 'Erweiterungen, die mit dem Flash Player abgespielt werden sollen.');

@define('PLUGIN_PODCAST_AUEXT', 'Quicktime Miniplayer Audio Erweiterungen');
@define('PLUGIN_PODCAST_AUEXT_DESC', 'Audio Erweiterungen, die mit dem Quicktime Mini Player abgespielt werden sollen.');

@define('PLUGIN_PODCAST_USECACHE', 'Caching');
@define('PLUGIN_PODCAST_USECACHE_DESC', 'Soll ein Cache aktiviert werden, in dem die ermittelten Informationen zu dem podcast gespeichert werden? So muss die Datei nur einmal analysiert werden. (Empfohlen!)');
@define('PLUGIN_PODCAST_JS_OPTIMIZATION', 'JavaScript Optimierung');
@define('PLUGIN_PODCAST_JS_OPTIMIZATION_DESC','Wenn angeschaltet, dann werden JavaScripte nur in die Seite eingebaut, wenn sie ben�tigt werden. Falls ihre Artikel gecached werden, MUSS diese Option ausgeschaltet bleiben!');

@define('PLUGIN_PODCAST_ASURE_FEEDENC', 'Feed enclosure sicher stellen');
@define('PLUGIN_PODCAST_ASURE_FEEDEENC_DESC', 'Sicher stellen, dass Medien als "enclosure" in den Feed eingef�gt werden, selbst wenn sie nicht im Eintrag erscheinen.');

@define('PLUGIN_PODCAST_HTTPREL', 'Relativer HTTP Pfad des Plugins');
@define('PLUGIN_PODCAST_HTTPREL_DESC', 'Hier k�nnen Sie angeben, wie ihr relativer Pfad zu dem Plugin bezogen auf die Basis Adresse lautet. Wenn Sie die Permalink Struktur f�r Plugins nicht ge�ndert haben und wenn ihr Blog nicht in einem Unterverzeichnis installiert ist, k�nnen Sie die Vorgabe so belassen.');

@define('PLUGIN_PODCAST_USAGE', 
'Durchsucht einen Eintrag nach Links, die auf Mediendateien (Video, Audio) zeigen, und ersetzt diese durch einem Player f�r die Mediadatei. Dadurch kann man einfach aus der Mediathek z.B. einen Film in den Eintrag einf�gen, f�r den dann HTML Code zum Abspielen der Mediadatei generiert wird.');

