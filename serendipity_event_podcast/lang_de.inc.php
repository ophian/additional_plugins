<?php

/**
 * @version
 * @author Translator Name <yourmail@example.com>
 * DE-Revision: Revision of lang_de.inc.php
 */

@define('PLUGIN_PODCAST_NAME', 'Easy Podcasting Plugin');
@define('PLUGIN_PODCAST_DESC', 'Fügt "Podcasting" Fähigkeiten hinzu (RSS enclosure, Video/Sound-Player)');
@define('PLUGIN_PODCAST_EASY', 'Einfache Einstellungen:');
@define('PLUGIN_PODCAST_USEPLAYER', 'Player anzeigen');
@define('PLUGIN_PODCAST_USEPLAYER_DESC', 'Soll Code für einen Player anstatt eines Links auf Mediadateien erzeugt werden?');
@define('PLUGIN_PODCAST_AUTOSIZE', 'Player Größe anpassen');
@define('PLUGIN_PODCAST_AUTOSIZE_DESC', 'Versucht, die Größe eines Videos zu ermitteln, und passt dann die Größe des Players entsprechend an. Die Einstellung für Breite und Höhe wird dann ignoriert.');
@define('PLUGIN_PODCAST_WIDTH', 'Breite');
@define('PLUGIN_PODCAST_WIDTH_DESC', 'Wie breit soll der eingefügte Player sein?');
@define('PLUGIN_PODCAST_HEIGHT', 'Höhe');
@define('PLUGIN_PODCAST_HEIGHT_DESC', 'Wie hoch soll der eingefügte Player sein?');
@define('PLUGIN_PODCAST_ALIGN', 'Ausrichtung');
@define('PLUGIN_PODCAST_ALIGN_DESC', 'Wie soll die Ausrichtung des eingefügten Player zum Text sein?');
@define('PLUGIN_PODCAST_ALIGN_LEFT', 'links');
@define('PLUGIN_PODCAST_ALIGN_RIGHT', 'rechts');
@define('PLUGIN_PODCAST_ALIGN_CENTER', 'zentriert');
@define('PLUGIN_PODCAST_ALIGN_NONE', 'keine');
@define('PLUGIN_PODCAST_FIRSTMEDIAONLY', 'Erste Mediendatei an den Feed Eintrag hängen');
@define('PLUGIN_PODCAST_FIRSTMEDIAONLY_DESC', 'Die RSS Spezifikation unterstützt nur einen Medienanhang pro Eintrag. Wird diese Option angeschaltet, so wird nur die erste gefundene Mediendatei pro Artikel an den Feed Eintrag angehängt.');
@define('PLUGIN_PODCAST_NOPODCASTING_CLASS', 'Ignorieren über CSS class');
@define('PLUGIN_PODCAST_NOPODCASTING_CLASS_DESC', 'Wenn ein Medien Link dieses Class Style bekommt, dann wird er ignoriert (kein Player und kein Eintrag im RSS).');

@define('PLUGIN_PODCAST_EXTATTRSETTINGS', 'Podcasting über die erweiterten Artikel Attribute:');
@define('PLUGIN_PODCAST_EXTATTR', 'Erweiterte Artikel Attribute');
@define('PLUGIN_PODCAST_EXTATTR_DESC', 'Hier können Sie einstellen, welche erweiterten Artikel Attribute als Mediendateien interpretiert und deshalb in den RSS Feed als Enclosure gepackt werden sollen. Dies muss eine Komma separierte Liste der Attributsnamen sein. Das Plugin "Erweiterte Eigenschaften von Artikeln" wird benötigt!');

@define('PLUGIN_PODCAST_EXTPOS', 'Medien aus erweiterten Artikel Attributen einbetten');
@define('PLUGIN_PODCAST_EXTPOS_DESC', 'Hier stellen Sie ein, an welcher Stelle Medien aus erweiterten Attributen in den Artikel eingefügt werden sollen.');
@define('PLUGIN_PODCAST_EXTPOS_NONE', 'Nicht in den Artikel einfügen');
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
@define('PLUGIN_PODCAST_JS_OPTIMIZATION_DESC','Wenn angeschaltet, dann werden JavaScripte nur in die Seite eingebaut, wenn sie benötigt werden. Falls ihre Artikel gecached werden, MUSS diese Option ausgeschaltet bleiben!');

@define('PLUGIN_PODCAST_ASURE_FEEDENC', 'Feed enclosure sicher stellen');
@define('PLUGIN_PODCAST_ASURE_FEEDEENC_DESC', 'Sicher stellen, dass Medien als "enclosure" in den Feed eingefügt werden, selbst wenn sie nicht im Eintrag erscheinen.');

@define('PLUGIN_PODCAST_HTTPREL', 'Relativer HTTP Pfad des Plugins');
@define('PLUGIN_PODCAST_HTTPREL_DESC', 'Hier können Sie angeben, wie ihr relativer Pfad zu dem Plugin bezogen auf die Basis Adresse lautet. Wenn Sie die Permalink Struktur für Plugins nicht geändert haben und wenn ihr Blog nicht in einem Unterverzeichnis installiert ist, können Sie die Vorgabe so belassen.');

@define('PLUGIN_PODCAST_USAGE', 
'Durchsucht einen Eintrag nach Links, die auf Mediendateien (Video, Audio) zeigen, und ersetzt diese durch einem Player für die Mediadatei. Dadurch kann man einfach aus der Mediathek z.B. einen Film in den Eintrag einfügen, für den dann HTML Code zum Abspielen der Mediadatei generiert wird.');

