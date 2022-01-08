<?php

/**
 *  @version 1.0
 *  @author Konrad Bauckmeier <kontakt@dd4kids.de>
 *  @translated 2009/06/03
 */

@define('PLUGIN_EVENT_STATISTICS_NAME', 'Statistiken');
@define('PLUGIN_EVENT_STATISTICS_DESC', 'Zeigt einen Link zu informativen Statistiken (inkl. Besucherz�hler) in der Administrationsoberfl�che an.');
@define('PLUGIN_EVENT_STATISTICS_OUT_STATISTICS', 'Statistik');
@define('PLUGIN_EVENT_STATISTICS_OUT_FIRST_ENTRY', 'Erster Eintrag');
@define('PLUGIN_EVENT_STATISTICS_OUT_LAST_ENTRY', 'Letzter Eintrag');
@define('PLUGIN_EVENT_STATISTICS_OUT_TOTAL_ENTRIES', 'Insgesamt verfasste Artikel');
@define('PLUGIN_EVENT_STATISTICS_OUT_ENTRIES', 'Artikel');
@define('PLUGIN_EVENT_STATISTICS_OUT_TOTAL_PUBLIC', ' ... davon �ffentlich');
@define('PLUGIN_EVENT_STATISTICS_OUT_TOTAL_DRAFTS', ' ... davon Entw�rfe');
@define('PLUGIN_EVENT_STATISTICS_OUT_PER_AUTHOR', 'Artikel pro Benutzer');
@define('PLUGIN_EVENT_STATISTICS_OUT_CATEGORIES', 'Vorhandene Kategorien');
@define('PLUGIN_EVENT_STATISTICS_OUT_CATEGORIES2', 'Kategorie(n)');
@define('PLUGIN_EVENT_STATISTICS_OUT_DISTRIBUTION_CATEGORIES', 'Verteilung der Artikel auf Kategorien');
@define('PLUGIN_EVENT_STATISTICS_OUT_DISTRIBUTION_CATEGORIES2', 'eingetragene(r) Artikel');
@define('PLUGIN_EVENT_STATISTICS_OUT_UPLOADED_IMAGES', 'Hochgeladene Bilder/Medien');
@define('PLUGIN_EVENT_STATISTICS_OUT_UPLOADED_IMAGES2', 'Bild(er)');
@define('PLUGIN_EVENT_STATISTICS_OUT_DISTRIBUTION_IMAGES', 'Verteilung der Bild-Dateitypen');
@define('PLUGIN_EVENT_STATISTICS_OUT_DISTRIBUTION_IMAGES2', 'vorhandene Datei(en)');
@define('PLUGIN_EVENT_STATISTICS_OUT_COMMENTS', 'Erhaltene Kommentare');
@define('PLUGIN_EVENT_STATISTICS_OUT_COMMENTS2', 'Kommentar(e)');
@define('PLUGIN_EVENT_STATISTICS_OUT_COMMENTS3', 'Top kommentierte Artikel');
@define('PLUGIN_EVENT_STATISTICS_OUT_TOPCOMMENTS', 'Top Kommentatoren');
@define('PLUGIN_EVENT_STATISTICS_OUT_LINK', 'Link');
@define('PLUGIN_EVENT_STATISTICS_OUT_SUBSCRIBERS', 'Abonnenten');
@define('PLUGIN_EVENT_STATISTICS_OUT_SUBSCRIBERS2', 'Abonnent(en)');
@define('PLUGIN_EVENT_STATISTICS_OUT_TOPSUBSCRIBERS', 'Top abonnierte Artikel');
@define('PLUGIN_EVENT_STATISTICS_OUT_TOPSUBSCRIBERS2', 'eingetragene(r) Abonnent(en)');
@define('PLUGIN_EVENT_STATISTICS_OUT_TRACKBACKS', 'Erhaltene Trackbacks');
@define('PLUGIN_EVENT_STATISTICS_OUT_TRACKBACKS2', 'Trackback(s)');
@define('PLUGIN_EVENT_STATISTICS_OUT_TOPTRACKBACK', 'Top Trackback-Artikel');
@define('PLUGIN_EVENT_STATISTICS_OUT_TOPTRACKBACK2', 'eingetragene(r) Trackback(s)');
@define('PLUGIN_EVENT_STATISTICS_OUT_TOPTRACKBACKS3', 'Top Trackbacker');
@define('PLUGIN_EVENT_STATISTICS_OUT_AVERAGES', 'Durchschnittswerte');
@define('PLUGIN_EVENT_STATISTICS_OUT_COMMENTS_PER_ARTICLE', 'Durchschnittliche Kommentare pro Artikel');
@define('PLUGIN_EVENT_STATISTICS_OUT_TRACKBACKS_PER_ARTICLE', 'Durchschnittliche Trackbacks pro Artikel');
@define('PLUGIN_EVENT_STATISTICS_OUT_ARTICLES_PER_DAY', 'Durchschnittliche Artikel pro Tag');
@define('PLUGIN_EVENT_STATISTICS_OUT_ARTICLES_PER_WEEK', 'Durchschnittliche Artikel pro Woche');
@define('PLUGIN_EVENT_STATISTICS_OUT_ARTICLES_PER_MONTH', 'Durchschnittliche Artikel pro Monat');
@define('PLUGIN_EVENT_STATISTICS_OUT_COMMENTS_PER_ARTICLE2', 'Kommentare/Artikel');
@define('PLUGIN_EVENT_STATISTICS_OUT_TRACKBACKS_PER_ARTICLE2', 'Trackbacks/Artikel');
@define('PLUGIN_EVENT_STATISTICS_OUT_ARTICLES_PER_DAY2', 'Artikel/Tag');
@define('PLUGIN_EVENT_STATISTICS_OUT_ARTICLES_PER_WEEK2', 'Artikel/Woche');
@define('PLUGIN_EVENT_STATISTICS_OUT_ARTICLES_PER_MONTH2', 'Artikel/Monat');
@define('PLUGIN_EVENT_STATISTICS_OUT_CHARS', 'Menge der geschriebenen Zeichen');
@define('PLUGIN_EVENT_STATISTICS_OUT_CHARS2', 'Zeichen');
@define('PLUGIN_EVENT_STATISTICS_OUT_CHARS_PER_ARTICLE', 'Zeichen pro Artikel');
@define('PLUGIN_EVENT_STATISTICS_OUT_CHARS_PER_ARTICLE2', 'Zeichen/Artikel');
@define('PLUGIN_EVENT_STATISTICS_OUT_LONGEST_ARTICLES', 'Die %s l�ngsten Artikel');
@define('PLUGIN_EVENT_STATISTICS_MAX_ITEMS', 'Anzahl Eintr�ge');
@define('PLUGIN_EVENT_STATISTICS_MAX_ITEMS_DESC', 'Wie viele Eintr�ge sollen pro statistischem Wert angezeigt werden (Standard: 20)?');
@define('PLUGIN_EVENT_STATISTICS_CHECKDNS', 'Zeige Host-Adresse f�r die IP in "Letzte Besucher"');
@define('PLUGIN_EVENT_STATISTICS_CHECKDNS_DESC', 'Dabei wird die PHP-Funktion gethostbyaddr() verwendet, was die Anzeige der Ergebnisse Ihrer Statistikaktivit�ten auf manchen Servern drastisch verlangsamen kann. Wenn dies der Fall ist und Sie sich nicht darum k�mmern, nur eine IP ausgewiesen zu bekommen, schalten Sie dies bitte einfach aus.');

//Language constants for the Extended Visitors feature
@define('PLUGIN_EVENT_STATISTICS_EXT_ADD', 'Erweiterte Besucherstatistiken');
@define('PLUGIN_EVENT_STATISTICS_EXT_ADD_DESC', 'Erweiterte Besucherstatistiken anzeigen (Standard: nein)?');
@define('PLUGIN_EVENT_STATISTICS_EXT_OPT1', 'Nein!');
@define('PLUGIN_EVENT_STATISTICS_EXT_OPT2', 'Ja, am unteren Ende der Seite.');
@define('PLUGIN_EVENT_STATISTICS_EXT_OPT3', 'Ja, oben auf der Seite.');
@define('PLUGIN_EVENT_STATISTICS_EXT_ALL', 'Alles zeigen? (Standard: nein)');
@define('PLUGIN_EVENT_STATISTICS_EXT_ALL_DESC', 'Bei \'nein\' werden nur Besucherstatistiken angezeigt');
@define('PLUGIN_EVENT_STATISTICS_EXT_ALL1', 'Nein, alles au�er dem Z�hler verbergen.');
@define('PLUGIN_EVENT_STATISTICS_EXT_ALL2', 'Ja, alle Statistiken anzeigen!');
@define('PLUGIN_EVENT_STATISTICS_EXT_VISITORS', 'Anzahl der Besucher');
@define('PLUGIN_EVENT_STATISTICS_EXT_HITSTODAY', 'Aufrufe heute');
@define('PLUGIN_EVENT_STATISTICS_EXT_HITSLSTYR', 'Aufrufe letztes Jahr');
@define('PLUGIN_EVENT_STATISTICS_EXT_HITSCURYR', 'Aufrufe dieses Jahr');
@define('PLUGIN_EVENT_STATISTICS_EXT_HITSTOTAL', 'Aufrufe gesamt (seit %s)');
@define('PLUGIN_EVENT_STATISTICS_EXT_VISTODAY', 'Besucher heute');
@define('PLUGIN_EVENT_STATISTICS_EXT_VISLSTYR', 'Besucher letzten Jahres');
@define('PLUGIN_EVENT_STATISTICS_EXT_VISCURYR', 'Besucher dieses Jahres');
@define('PLUGIN_EVENT_STATISTICS_EXT_VISTOTAL', 'Besucher gesamt (seit %s)');
#@define('PLUGIN_EVENT_STATISTICS_EXT_VISSINCE', 'Die erweiterte Besucherstatistik hat seit folgendem Zeitpunkt Daten gesammelt:');
@define('PLUGIN_EVENT_STATISTICS_EXT_COUNTDESC', 'Die Zahl der Aufrufe kann sehr gro� werden, liefert jedoch einen Wert bez�glich der einzelnen Seitenanfragen. Diese Zahl erh�ht sich deshalb mit JEDEM Seitenaufruf sowie jeder Aktualisierung der Seite und kann damit NICHT als Besucherz�hler verstanden werden.');
@define('PLUGIN_EVENT_STATISTICS_EXT_VISLATEST', 'Letzte Besucher');
@define('PLUGIN_EVENT_STATISTICS_EXT_TOPREFS', 'Top-Referrer');
@define('PLUGIN_EVENT_STATISTICS_EXT_TOPREFS_NONE', 'Bisher wurden keine Referrer registriert.');
@define('PLUGIN_EVENT_STATISTICS_EXT_DAYGRAPH', 'Aufrufe, auf den Tag bezogen');
@define('PLUGIN_EVENT_STATISTICS_EXT_MONTHGRAPH', 'Aufrufe, auf den Monat bezogen');
@define('PLUGIN_EVENT_STATISTICS_OUT_EXT_STATISTICS', 'Erweiterte Besucherstatistik');
@define('PLUGIN_EVENT_STATISTICS_BANNED_HOSTS1', 'Aktivieren, keine Robots z�hlen');
@define('PLUGIN_EVENT_STATISTICS_BANNED_HOSTS2', 'Nein, Robots bitte mitz�hlen');
@define('PLUGIN_EVENT_STATISTICS_BANNED_HOSTS', 'Spider/Robot-Z�hlung verhindern');
@define('PLUGIN_EVENT_STATISTICS_BANNED_HOSTS_DESC', 'Bei \'ja\' werden keine Spiders/Robots gez�hlt. Bei \'nein\' werden Spiders/Robots mitgez�hlt. Bislang k�nnen �ber 290 Bots von der Z�hlung ausgeschlossen werden.');
@define('PLUGIN_EVENT_STATISTICS_SHOW_LASTENTRY', 'Datum des letzten Artikels anzeigen');
@define('PLUGIN_EVENT_STATISTICS_SHOW_ENTRYCOUNT', 'Anzahl der Artikel anzeigen');
@define('PLUGIN_EVENT_STATISTICS_SHOW_COMMENTCOUNT', 'Anzahl der Kommentare anzeigen');
@define('PLUGIN_EVENT_STATISTICS_SHOW_MONTHVISITORS', 'Besucher dieses Monats anzeigen');
@define('PLUGIN_EVENT_STATISTICS_SHOW_CACHETIMEOUT', 'Cache-Zeitlimit');
@define('PLUGIN_EVENT_STATISTICS_SHOW_CACHETIMEOUT_DESC', 'Gibt an (in Minuten), wie lange die Statistik angezeigt wird, bevor sie aktualisiert wird. Ein h�heres Zeitlimit f�hrt zu einer besseren Leistung, gew�hrleistet aber nicht, dass die Statistiken immer aktuell sind.');
@define('PLUGIN_EVENT_STATISTICS_TEXT', 'Textformatierung');
@define('PLUGIN_EVENT_STATISTICS_TEXT_DESC', 'Bitte %s als Platzhalter f�r die Zahl/den Text benutzen');
@define('PLUGIN_EVENT_STATISTICS_TEXT_LASTENTRY', 'Letzter Artikel: %s');
@define('PLUGIN_EVENT_STATISTICS_TEXT_ENTRYCOUNT', '%s Artikel wurden geschrieben');
@define('PLUGIN_EVENT_STATISTICS_TEXT_COMMENTCOUNT', '%s Kommentare wurden abgegeben');
@define('PLUGIN_EVENT_STATISTICS_TEXT_MONTHVISITORS', '%s Besucher in diesem Monat');

@define('PLUGIN_EVENT_STATISTICS_SHOW_CURRENTVISITORS', 'Anzahl momentaner Besucher (inkl. ca. der letzten 15 Minuten) anzeigen');
@define('PLUGIN_EVENT_STATISTICS_TEXT_CURRENTVISITORS', '%s Besucher online');

// Next lines were translated on 2009/06/03
@define('PLUGIN_EVENT_STATISTICS_SHOW_DAYVISITORS', 'Besucher dieses Tages anzeigen');
@define('PLUGIN_EVENT_STATISTICS_SHOW_WEEKVISITORS', 'Besucher dieser Woche anzeigen');
@define('PLUGIN_EVENT_STATISTICS_TEXT_DAYVISITORS', '%s Besucher heute');
@define('PLUGIN_EVENT_STATISTICS_TEXT_WEEKVISITORS', '%s Besucher in dieser Woche');

@define('PLUGIN_EVENT_STATISTICS_AUTOCLEAN', 'Automatisches L�schen alter Logeintr�ge');
@define('PLUGIN_EVENT_STATISTICS_AUTOCLEAN_DESC', 'L�scht alle Eintr�ge der "visitors"-Tabelle jeweils �lter als 1 Jahr, da diese Logeintr�ge die Datenbank kontinuierlich aufbl�hen, zu einer steten Verlangsamung des System f�hren und z.Z. keinen echten Mehrwert bieten. Nat�rlich bleiben die bereits ausgewerteten Daten der "visitors_count"-Tabelle weiterhin erhalten.');

