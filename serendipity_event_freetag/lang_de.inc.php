<?php

/**
 *  @version 
 *  @author Translator Name <yourmail@example.com>
 *  EN-Revision: Revision of lang_en.inc.php
 */

//
//  serendipity_event_freetag.php
//
@define('PLUGIN_EVENT_FREETAG_TITLE', 'Freie Artikel-Tags');
@define('PLUGIN_EVENT_FREETAG_DESC', 'Erlaubt das freie Tagging von Artikeln');
@define('PLUGIN_EVENT_FREETAG_MPFDESC', 'Sie m�ssen Ihren Eintrag anschlie�end noch speichern, um die �nderungen endg�ltig auszuf�hren!');
@define('PLUGIN_EVENT_FREETAG_ENTERDESC', 'Bitte alle zutreffenden Tags angeben. Mehrere zutreffende Tags mit Komma (,) trennen');
@define('PLUGIN_EVENT_FREETAG_LIST', 'Tags f�r diesen Artikel: %s');
@define('PLUGIN_EVENT_FREETAG_USING', 'Artikel mit Tag: <span class="freetag_current">%s</span>');
@define('PLUGIN_EVENT_FREETAG_SUBTAG', 'Verwandte Tags zu Tag: %s');
@define('PLUGIN_EVENT_FREETAG_NO_RELATED', 'Keine verwandten Tags gefunden.');
@define('PLUGIN_EVENT_FREETAG_ALLTAGS', 'Alle festgelegten Tags');
@define('PLUGIN_EVENT_FREETAG_MANAGETAGS', 'Tags verwalten');
@define('PLUGIN_EVENT_FREETAG_MANAGE_ALL', 'Alle Tags verwalten');
@define('PLUGIN_EVENT_FREETAG_MANAGE_LEAF', '\'Verwaiste\' Tags verwalten');
@define('PLUGIN_EVENT_FREETAG_MANAGE_UNTAGGED', 'Eintr�ge ohne Tags anzeigen');
@define('PLUGIN_EVENT_FREETAG_MANAGE_LEAFTAGGED', 'Eintr�ge mit \'verwaisten\' Tags anzeigen');
@define('PLUGIN_EVENT_FREETAG_MANAGE_CLEANUP', 'Eintrag-Tag-Zuordnungen bereinigen');
@define('PLUGIN_EVENT_FREETAG_MANAGE_CLEANUP_INFO', 'In der nachfolgenden Auflistung sind Tags aufgef�hrt, die mit nicht existierenden Eintr�gen verkn�pft sind. Klicken Sie auf &quot;Bereinigen&quot;, um diese nicht ben�tigten Verkn�pfungen zu entfernen.');
@define('PLUGIN_EVENT_FREETAG_MANAGE_CLEANUP_NOTHING', 'Es wurden keine Tags gefunden, die mit nicht existierenden Eintr�gen verkn�pft sind. Daher ist keine Bereinigung erforderlich.');
@define('PLUGIN_EVENT_FREETAG_MANAGE_CLEANUP_LOOKUP_ERROR', 'Es konnten keine Tags, die mit nicht existierenden Eintr�gen verkn�pft sind, gefunden werden, da ein Fehler aufgetreten ist.');
@define('PLUGIN_EVENT_FREETAG_MANAGE_CLEANUP_PERFORM', 'Bereinigen');
@define('PLUGIN_EVENT_FREETAG_MANAGE_CLEANUP_ENTRIES', 'IDs der betroffenen Eintr�ge');
@define('PLUGIN_EVENT_FREETAG_MANAGE_CLEANUP_SUCCESSFUL', 'Alle nicht ben�tigten Verkn�pfungen wurden erfolgreich entfernt.');
@define('PLUGIN_EVENT_FREETAG_MANAGE_CLEANUP_FAILED', 'Die Entfernung nicht ben�tigter Verkn�pfungen konnte nicht durchgef�hrt werden.');
@define('PLUGIN_EVENT_FREETAG_MANAGE_UNTAGGED_NONE', 'Keine Eintr�ge ohne Tags gefunden!');
@define('PLUGIN_EVENT_FREETAG_MANAGE_LIST_TAG', 'Tag');
@define('PLUGIN_EVENT_FREETAG_MANAGE_LIST_WEIGHT', 'H�ufigkeit');
@define('PLUGIN_EVENT_FREETAG_MANAGE_LIST_ACTIONS', 'Funktionen');
@define('PLUGIN_EVENT_FREETAG_MANAGE_ACTION_RENAME', 'Umbenennen');
@define('PLUGIN_EVENT_FREETAG_MANAGE_ACTION_SPLIT', 'Aufteilen');
@define('PLUGIN_EVENT_FREETAG_MANAGE_ACTION_DELETE', 'L�schen');
@define('PLUGIN_EVENT_FREETAG_MANAGE_CONFIRM_DELETE', 'Tag "%s" wirklich l�schen?');
@define('PLUGIN_EVENT_FREETAG_MANAGE_INFO_SPLIT', 'Tags mit einem Komma trennen:');
@define('PLUGIN_EVENT_FREETAG_SHOW_TAGCLOUD', 'Zeige Wolke mit verwandten Tags an?');
@define('PLUGIN_EVENT_FREETAG_SEND_HTTP_HEADER', 'Sende X-FreeTag-HTTP-Header');
@define('PLUGIN_EVENT_FREETAG_ADMIN_TAGLIST', 'Klickbare Liste aller schon vorhandenen Tags beim Schreiben eines Eintrags anzeigen');
@define('PLUGIN_EVENT_FREETAG_ADMIN_FTAYT', 'Zeige Tag-Vorschl�ge bei der Eingabe');

//
//  serendipity_plugin_freetag.php
//
@define('PLUGIN_FREETAG_NAME', 'Getaggte Artikel');
@define('PLUGIN_FREETAG_BLAHBLAH', 'Zeigt alle vorhandenen Tags');
@define('PLUGIN_FREETAG_NEWLINE', 'Zeilenumbruch nach jedem Tag?');
@define('PLUGIN_FREETAG_XML', 'XML-Icons anzeigen?');
@define('PLUGIN_FREETAG_SCALE', 'Schriftgr��e der Tags nach H�ufigkeit skalieren?');
@define('PLUGIN_FREETAG_UPGRADE1_2', 'Aktualisiere %d Tags zu Eintrag %d');
@define('PLUGIN_FREETAG_MAX_TAGS', 'Wieviele Tags sollen angezeigt werden?');
@define('PLUGIN_FREETAG_TRESHOLD_TAG_COUNT', 'Mindest-Nutzung eines Tags f�r Anzeige');

@define('PLUGIN_EVENT_FREETAG_USE_CAROC', 'Eine rotierende Canvas-Wolke verwenden?');
@define('PLUGIN_EVENT_FREETAG_USE_CAROC_DESC', 'Eine rotierende JavaScript-Wolke in %s! (Begrenzt einsetzbar, da sie mehr oder weniger "quadratische" Umgebungen ben�tigt.)');
@define('PLUGIN_EVENT_FREETAG_CAROC_TAG_COLOR', 'Tag-Farbe f�r rotierende Canvas-Wolke (rrggbb)');
@define('PLUGIN_EVENT_FREETAG_CAROC_TAG_COLOR_DESC', 'W�hlen Sie die beiden Farben mit Bedacht. F�r die Themes "pure" und "b53+" werden sie f�r die Textfarbe im "dark"-theme-mode automatisch gegeneinander vertauscht, so dass helle Schrift auf dunklem Grund und dunkle Schrift auf hellem Grund zu sehen ist.');
@define('PLUGIN_EVENT_FREETAG_CAROC_TAG_BORDER_COLOR', 'Tag Randfarbe f�r rotierende Canvas-Wolke (rrggbb)');
@define('PLUGIN_EVENT_FREETAG_CAROC_BOXWIDTH', 'Breite der rotierenden Canvas-Wolke in Pixeln');

@define('PLUGIN_EVENT_FREETAG_USE_CAWOC', 'Eine moderne Canvas 2D-Wortwolke verwenden?');
@define('PLUGIN_EVENT_FREETAG_USE_CAWOC_DESC', 'Eine hochmoderne "wordle"-�hnliche 2D-Wortwolke in %s!');

@define('PLUGIN_EVENT_FREETAG_USE_CANVAS_PLUGIN_SPRINT', 'Seitenleisten und Archiven');
@define('PLUGIN_EVENT_FREETAG_USE_CANVAS_EVENT_SPRINT', 'verwandten Tags');

@define('PLUGIN_FREETAG_USE_CANVAS_SCRIPTS_DESC', 'Um die Canvas-Skripte einzubinden, muss "show_tagcloud" auch im Event-Plugin aktiviert werden!');

//
// later on additions
//
@define('PLUGIN_EVENT_FREETAG_TAGCLOUD_MIN', 'Minimale Schriftgr��e eines Tags in dieser Wolke in %');
@define('PLUGIN_EVENT_FREETAG_TAGCLOUD_MAX', 'Maximale Schriftgr��e eines Tags in dieser Wolke in %');

@define('PLUGIN_FREETAG_META_KEYWORDS', 'Anzahl der Schlagw�rter, die in die Meta-Angaben des HTML-Codes eingesetzt werden sollen (0: abgeschaltet)');

@define('PLUGIN_EVENT_FREETAG_TEMPLATE', 'Template f�r Seitenleiste (siehe default theme)');
@define('PLUGIN_EVENT_FREETAG_TEMPLATE_DESCRIPTION', 'Wenn ein Template angegeben ist, aber nicht das schon andernorts verwendete "plugin_freetag.tpl", wird es benutzt um die Seitenleiste anzuzeigen. Im Template wird eine Variable <tags> zur Verf�gung gestellt, die ein Liste von Eintr�gen im folgenden Format enth�lt: <tagName> => array(href = <tagLink>, count => <tagCount>). Siehe "plugin_freetag_sidebar.tpl" im default Theme als simples copy Beispiel.');

@define('PLUGIN_EVENT_FREETAG_RELATED_ENTRIES', 'Artikel mit �hnlichen Themen:');
@define('PLUGIN_EVENT_FREETAG_SHOW_RELATED', 'Zeige Artikel mit �hnlichen Themen an?');
@define('PLUGIN_EVENT_FREETAG_SHOW_RELATED_COUNT', 'Wieviele Artikel mit �hnlichen Themen sollen angezeigt werden?');
@define('PLUGIN_EVENT_FREETAG_EMBED_FOOTER', 'Zeige die Tags in der Fu�zeile an?');
@define('PLUGIN_EVENT_FREETAG_EMBED_FOOTER_DESC', 'Falls eingeschaltet, werden die Tags in der Fu�zeile des Eintrags angezeigt. Wenn abgeschaltet, werden die Tags innerhalb des Textk�rpers/erweiterten Teils des Artikels angezeigt.');
@define('PLUGIN_EVENT_FREETAG_LOWERCASE_TAGS', 'Tags in Kleinbuchstaben umwandeln');

@define('PLUGIN_EVENT_FREETAG_RELATED_TAGS', 'Verwandte Tags');
@define('PLUGIN_EVENT_FREETAG_TAGLINK', 'Taglink');
@define('PLUGIN_EVENT_FREETAG_CAT2TAG', 'Erstelle Tags f�r zugewiesene Kategorien?');
@define('PLUGIN_EVENT_FREETAG_CAT2TAG_DESC', 'Falls aktiviert, werden alle Kategorien eines Eintrags als Tags zugewiesen. Alle bestehende Kategoriezuweisungen k�nnen �ber die Tag-Verwaltung in Tags konvertiert werden.');
@define('PLUGIN_EVENT_FREETAG_KEYWORD2TAG', 'Erstelle Tags durch automatische Schl�sselw�rter?');
@define('PLUGIN_EVENT_FREETAG_KEYWORD2TAG_DESC', 'Falls aktiviert, wird der Eintrag daraufhin gepr�ft, ob darin automatische Schl�sselw�rter enthalten sind. Gegebenenfalls werden die entsprechenden Tags zugewiesen. Die Schl�sselw�rter k�nnen �ber die Tag-Verwaltung festgelegt werden.');
@define('PLUGIN_EVENT_FREETAG_GLOBALLINKS', 'Alle zugewiesenen Kategorien bestehender Artikel zu Tags konvertieren');
@define('PLUGIN_EVENT_FREETAG_GLOBALCAT2TAG_ENTRY', 'Kategorien von Artikel #%d (%s) konvertiert zu: %s.');
@define('PLUGIN_EVENT_FREETAG_GLOBALCAT2TAG', 'Alle Kategorien wurden zu Tags konvertiert.');

@define('PLUGIN_EVENT_FREETAG_KEYWORDS', 'Automatische Schl�sselw�rter');
@define('PLUGIN_EVENT_FREETAG_KEYWORDS_DESC', 'Sie k�nnen Schl�sselw�rter (mit "," getrennt) f�r jedes bereits bestehende Tag zuweisen. Immer wenn eines dieser Schl�sselw�rter im Text gefunden wird, wird der zugeh�rige Tag automatisch dem Eintrag zugewiesen. Achten Sie darauf, dass sehr viele automatische Schl�sselw�rter beim Speichern eines Artikels l�ngere Zeit beanspruchen k�nnen.');
@define('PLUGIN_EVENT_FREETAG_KEYWORDS_ADD', 'Schl�sselwort <strong>%s</strong> gefunden, Tag <strong><em>%s</em></strong> automatisch zugewiesen.');

@define('PLUGIN_EVENT_FREETAG_REBUILD_FETCHNO', 'Lese Eintr�ge %d bis %d');
@define('PLUGIN_EVENT_FREETAG_REBUILD_TOTAL', ' (gesamt %d Eintr�ge)...');
@define('PLUGIN_EVENT_FREETAG_REBUILD_FETCHNEXT', 'Hole n�chste Runde von Eintr�gen...');
@define('PLUGIN_EVENT_FREETAG_REBUILD', 'Automatische Schl�sselw�rter neu parsen');
@define('PLUGIN_EVENT_FREETAG_REBUILD_DESC', 'Warnung: Diese Funktion wird jeden einzelnen Blogeintrag einlesen und neu speichern. Das wird zum einen etwas dauern, und zum anderen besteht die Gefahr, dass ihre Eintr�ge ver�ndert werden k�nnten. Daher empfehlen wir, vorher ein Datenbank-Backup zu erstellen. Klicken Sie auf "Abbrechen", um diese Aktion abzubrechen.');

@define('PLUGIN_EVENT_FREETAG_ORDER_TAGNAME', 'Tag-Name');
@define('PLUGIN_EVENT_FREETAG_ORDER_TAGCOUNT', 'Tag-Anzahl');

@define('PLUGIN_EVENT_FREETAG_XMLIMAGE', 'XML Bild relativ zum Template Verzeichnis');

@define('PLUGIN_EVENT_FREETAG_EMBED_FOOTER_DESC2', 'Wenn auf "Smarty" gestellt wird, dann wird eine smarty Variable {$entry.freetag} generiert, die an beliebiger Stelle in der entries.tpl Vorlagendatei eingef�gt werden kann.');

@define('PLUGIN_EVENT_FREETAG_EXTENDED_SMARTY', 'Erweitertes Smarty');
@define('PLUGIN_EVENT_FREETAG_EXTENDED_SMARTY_DESC', 'Nutze statt der HTML-Ausgabe, ob nun direkt oder per Smarty, verschiedene Smarty Variablen, die im Template zusammengef�gt werden k�nnen. Dies �berschreibt alle anderen diesbez�glichen Einstellungen. Ein Beispiel f�r die Nutzung findet sich im Readme.');
@define('PLUGIN_EVENT_FREETAG_KILL', 'Wenn aktiviert werden alle zugeh�rigen Tags gel�scht.');
@define('PLUGIN_EVENT_FREETAG_KILL_INFO_DESC', 'Einzelne Tags aus mehreren k�nnen von Hand entfernt werden, indem Sie das obige Eingabefeld f�r Tags verwenden. Das vollst�ndige Entfernen wird jedoch nur mittels dieser Checkbox-Option unterst�tzt! <b>HINWEIS</b>: Bestimmte optionale Freetag-Plugin-F�lle, wie z.B. Kategorie-Tag-Namen und automatisierte Schl�sselwort-zu-Tag-F�lle, unterst�tzen das Entfernen nur bis zur n�chsten Bearbeitung des Eintrags, wo sie automatisch wieder hinzugef�gt werden. <b>ACHTUNG</b>: Rufen Sie nach abgeschickten �nderungen f�r den Fall einer fortsetzenden Bearbeitung den Eintrag noch einmal komplett neu auf, um die aktuell gespeicherten Werte (Tags) zu erhalten. Vertrauen Sie den angezeigten Daten nicht blindlings, sonst kann es sein, dass eben vorgenommene �nderungen gleich wieder �berschrieben werden.');

@define('PLUGIN_EVENT_FREETAG_TAGLINK_DESC', 'Eine m�gliche �nderung des Taglinks w�re "plugin/taglist/" anstelle von "plugin/tag/" zu schreiben. Dies w�re das Kommando, um jeden Taglink als Liste, anstelle von bereits ge�ffneten Artikeln, auszugeben. Man kann aber ebenso manuell f�r bestimmte Taglinks den "/taglist" tag an einen bereits existierenden Taglink (zB. "/plugin/tag/deine/tags/taglist") anh�ngen. In beiden F�llen ist "taglist" fortan ein reserviertes Kommando und kann nicht mehr als normales Tagwort verwendet werden. F�r beide M�glichkeiten ist eine eigenh�ndig eingebaute Code-�nderung n�tig, wie in der Dokumentation f�r die "Listenanzeige" Option beschrieben. Ben�tigt Option: "Listenanzeige (unge�ffnete Artikel)".');

@define('PLUGIN_EVENT_FREETAG_TAGSASLIST', 'Listenanzeige (unge�ffnete Artikel)');
@define('PLUGIN_EVENT_FREETAG_TAGSASLIST_DESC', 'In der Plugin-Dokumentation ist zu lesen, wie die existierende templates entries.tpl Datei f�r die Listenanzeige der Taglink-Ausgabe im Code ge�ndert werden muss.');

@define('PLUGIN_EVENT_FREETAG_SORTTAGSBYCOUNT', 'Absteigende Sortierung von "Multi-Tags" Eintr�gen');
@define('PLUGIN_EVENT_FREETAG_SORTTAGSBYCOUNT_DESC', 'Normalerweise werden bei der Darstellung von mehreren gew�hlten Tags die damit zugewiesenen Eintr�ge einfach nach Datum sortiert aufgelistet. Wenn diese Option aktiviert wird, werden die Eintr�ge nach den h�ufigsten �berschneidungen mit den angeforderten Tags sortiert.');

@define('PLUGIN_EVENT_FREETAG_MANAGE_LEAFTAGS_NONE', 'Keine verwaisten Tags gefunden!');

@define('PLUGIN_EVENT_FREETAG_LOWERCASE_TAGS_DESC', 'Datenbank und Backend-Tags werden wie eingegeben gespeichert und angezeigt. Diese Option ist nur f�r Frontend-Tags.');

@define('PLUGIN_EVENT_FREETAG_ADMIN_DELIMITER', 'Erlaube alphabetische Sortierung und Unterteilung der Tag-Liste per Index?');

@define('PLUGIN_EVENT_FREETAG_SORT_DESC_FOR_TOTAL', 'Mit "order by count", absteigender Sortierung');

@define('PLUGIN_EVENT_FREETAG_ALLOW_JQUERYLIB', 'Nutze Plugin jQuery lib');
@define('PLUGIN_EVENT_FREETAG_ALLOW_JQUERYLIB_DESC', 'Lade Plugin jQuery lib nur im Frontend, wenn ihr Theme im header oder footer nicht schon das "default" jquery.js l�dt.');

