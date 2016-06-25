<?php

define('PLUGIN_AUDIOSCROBBLER_TITLE', 'Audioscrobbler');
define('PLUGIN_AUDIOSCROBBLER_TITLE_BLAHBLAH', 'Shows last played songs in your blog');
define('PLUGIN_AUDIOSCROBBLER_NUMBER', 'Anzahl der Einträge');
define('PLUGIN_AUDIOSCROBBLER_NUMBER_BLAHBLAH', 'Wieviele Einträge sollen angezeigt werden? (Standard: einer, muss mindestens 1 sein)');
define('PLUGIN_AUDIOSCROBBLER_USERNAME', 'Audioscrobbler Benutzername');
define('PLUGIN_AUDIOSCROBBLER_USERNAME_BLAHBLAH', 'Der Audioscrobbler Benutzername wird benötigt um den Feed abzufragen.');
define('PLUGIN_AUDIOSCROBBLER_NEWWINDOW', 'Neues Fenster');
define('PLUGIN_AUDIOSCROBBLER_NEWWINDOW_BLAHBLAH', 'Sollen die Links in einem neuen Fenster geöffnet werden (benötigt Javascript)');
define('PLUGIN_AUDIOSCROBBLER_CACHETIME', 'Wann wird die Songliste aktualisiert?');
define('PLUGIN_AUDIOSCROBBLER_CACHETIME_BLAHBLAH', 'Die Inhalte des Audioscrobbler Feeds werden gecached. Sobald der Cache älter ist als X Minuten wird er aktualisiert (Standard: 30 Minuten, mindestens 5 Minuten)');
define('PLUGIN_AUDIOSCROBBLER_FORMATSTRING', 'Der Formatierungsstring für einen Eintrag');
define('PLUGIN_AUDIOSCROBBLER_FORMATSTRING_BLAHBLAH', '%ARTIST% für den Artist, %SONG% für den Song, %ALBUM% für das Album und %DATE% für das Datum.');
define('PLUGIN_AUDIOSCROBBLER_UTCDIFFERENCE', 'Stunden Unterschied zur UTC Zeit');
define('PLUGIN_AUDIOSCROBBLER_UTCDIFFERENCE_BLAHBLAH', 'Wieviel Stunden Unterschied zur UTC Zeit (GMT -1) (zum Beispiel -1 oder +2)');    
define('PLUGIN_AUDIOSCROBBLER_FORMATSTRING_BLOCK', 'Der Formatierungsstring für den gesamten Block');
define('PLUGIN_AUDIOSCROBBLER_FORMATSTRING_BLOCK_BLAHBLAH', '%ENTRIES% für die Einträge, %PROFILE% für einen Link zum Audioscrobbler Profil, %LASTUPDATE% für die letzte Akutalisierung.');
define('PLUGIN_AUDIOSCROBBLER_PROFILETITLE', 'Titel für den Profillink');
define('PLUGIN_AUDIOSCROBBLER_PROFILETITLE_BLAHBLAH', 'Wird für %PROFILE% im Block-Formatierungsstring verwendet. %USER% für den Audioscrobbler Benutzername.');
define('PLUGIN_AUDIOSCROBBLER_SONGLINK', 'Lieder als Links darstellen');
define('PLUGIN_AUDIOSCROBBLER_SONGLINK_BLAHBLAH', 'Sollen die Lieder mit Audioscrobbler verlinkt werden?');
define('PLUGIN_AUDIOSCROBBLER_ARTISTLINK', 'Artist als Link darstellen');
define('PLUGIN_AUDIOSCROBBLER_ARTISTLINK_BLAHBLAH', 'Sollen die Artists mit Audioscrobbler oder Musicbrainz verlinkt werden?');
define('PLUGIN_AUDIOSCROBBLER_ARTISTLINK_SCROBBLER', 'mit Audioscrobbler verlinken');
define('PLUGIN_AUDIOSCROBBLER_ARTISTLINK_MUSICBRAINZ_ELSE_NONE', 'mit Musicbrainz verlinken, falls verfügbar');
define('PLUGIN_AUDIOSCROBBLER_ARTISTLINK_MUSICBRAINZ_ELSE_SCROBBLER', 'mit Musicbrainz oder nach Verfügbarkeit mit Audioscrobbler');
define('PLUGIN_AUDIOSCROBBLER_SPACER', 'Trennzeichen');
define('PLUGIN_AUDIOSCROBBLER_SPACER_BLAHBLAH', 'Was soll als Trennzeichen zwischen den Einträgen benutzt werden.');
define('PLUGIN_AUDIOSCROBBLER_COULD_NOT_WRITE', 'Cache konnnte nicht geschrieben werden');
define('PLUGIN_AUDIOSCROBBLER_COULD_NOT_READ', 'Cache konnnte nicht ausgewertet werden');
define('PLUGIN_AUDIOSCROBBLER_FEED_OFFLINE', 'Audioscrobbler Songlist offline');

