<?php

/**
 *  @version 
 *  @author Translator Name <yourmail@example.com>
 *  EN-Revision: Revision of lang_de.inc.php
 */

//
//  serendipity_event_freetag.php
//
@define('PLUGIN_EVENT_FREETAG_TITLE', 'Freie Artikel-Tags');
@define('PLUGIN_EVENT_FREETAG_DESC', 'Erlaubt das freie Tagging von Artikeln');
@define('PLUGIN_EVENT_FREETAG_ENTERDESC', 'Bitte alle zutreffenden Tags angeben. Mehrere zutreffende Tags mit Komma (,) trennen');
@define('PLUGIN_EVENT_FREETAG_LIST', 'Tags für diesen Artikel: %s');
@define('PLUGIN_EVENT_FREETAG_USING', 'Artikel mit Tag: <span class="freetag_current">%s</span>');
@define('PLUGIN_EVENT_FREETAG_SUBTAG', 'Verwandte Tags zu Tag: %s');
@define('PLUGIN_EVENT_FREETAG_NO_RELATED', 'Keine verwandten Tags gefunden.');
@define('PLUGIN_EVENT_FREETAG_ALLTAGS', 'Alle festgelegten Tags');
@define('PLUGIN_EVENT_FREETAG_MANAGETAGS', 'Tags verwalten');
@define('PLUGIN_EVENT_FREETAG_MANAGE_ALL', 'Alle Tags verwalten');
@define('PLUGIN_EVENT_FREETAG_MANAGE_LEAF', '\'Verwaiste\' Tags verwalten');
@define('PLUGIN_EVENT_FREETAG_MANAGE_UNTAGGED', 'Einträge ohne Tags anzeigen');
@define('PLUGIN_EVENT_FREETAG_MANAGE_LEAFTAGGED', 'Einträge mit \'verwaisten\' Tags anzeigen');
@define('PLUGIN_EVENT_FREETAG_MANAGE_CLEANUP', 'Eintrag-Tag-Zuordnungen bereinigen');
@define('PLUGIN_EVENT_FREETAG_MANAGE_CLEANUP_INFO', 'In der nachfolgenden Auflistung sind Tags aufgeführt, die mit nicht existierenden Einträgen verknüpft sind. Klicken Sie auf &quot;Bereinigen&quot;, um diese nicht benötigten Verknüpfungen zu entfernen.');
@define('PLUGIN_EVENT_FREETAG_MANAGE_CLEANUP_NOTHING', 'Es wurden keine Tags gefunden, die mit nicht existierenden Einträgen verknüpft sind. Daher ist keine Bereinigung erforderlich.');
@define('PLUGIN_EVENT_FREETAG_MANAGE_CLEANUP_LOOKUP_ERROR', 'Es konnten keine Tags, die mit nicht existierenden Einträgen verknüpft sind, gefunden werden, da ein Fehler aufgetreten ist.');
@define('PLUGIN_EVENT_FREETAG_MANAGE_CLEANUP_PERFORM', 'Bereinigen');
@define('PLUGIN_EVENT_FREETAG_MANAGE_CLEANUP_ENTRIES', 'IDs der betroffenen Einträge');
@define('PLUGIN_EVENT_FREETAG_MANAGE_CLEANUP_SUCCESSFUL', 'Alle nicht benötigten Verknüpfungen wurden erfolgreich entfernt.');
@define('PLUGIN_EVENT_FREETAG_MANAGE_CLEANUP_FAILED', 'Die Entfernung nicht benötigter Verknüpfungen konnte nicht durchgeführt werden.');
@define('PLUGIN_EVENT_FREETAG_MANAGE_UNTAGGED_NONE', 'Keine Einträge ohne Tags gefunden!');
@define('PLUGIN_EVENT_FREETAG_MANAGE_LIST_TAG', 'Tag');
@define('PLUGIN_EVENT_FREETAG_MANAGE_LIST_WEIGHT', 'Häufigkeit');
@define('PLUGIN_EVENT_FREETAG_MANAGE_LIST_ACTIONS', 'Funktionen');
@define('PLUGIN_EVENT_FREETAG_MANAGE_ACTION_RENAME', 'Umbenennen');
@define('PLUGIN_EVENT_FREETAG_MANAGE_ACTION_SPLIT', 'Aufteilen');
@define('PLUGIN_EVENT_FREETAG_MANAGE_ACTION_DELETE', 'Löschen');
@define('PLUGIN_EVENT_FREETAG_MANAGE_CONFIRM_DELETE', 'Tag "%s" wirklich löschen?');
@define('PLUGIN_EVENT_FREETAG_MANAGE_INFO_SPLIT', 'Tags mit einem Komma trennen:');
@define('PLUGIN_EVENT_FREETAG_SHOW_TAGCLOUD', 'Zeige Wolke mit verwandten Tags an?');
@define('PLUGIN_EVENT_FREETAG_SEND_HTTP_HEADER', 'Sende X-FreeTag-HTTP-Header');
@define('PLUGIN_EVENT_FREETAG_ADMIN_TAGLIST', 'Klickbare Liste aller schon vorhandenen Tags beim Schreiben eines Eintrags anzeigen');
@define('PLUGIN_EVENT_FREETAG_ADMIN_FTAYT', 'Zeige Tag-Vorschläge bei der Eingabe');

//
//  serendipity_plugin_freetag.php
//
@define('PLUGIN_FREETAG_NAME', 'Getaggte Artikel');
@define('PLUGIN_FREETAG_BLAHBLAH', 'Zeigt alle vorhandenen Tags');
@define('PLUGIN_FREETAG_NEWLINE', 'Zeilenumbruch nach jedem Tag?');
@define('PLUGIN_FREETAG_XML', 'XML-Icons anzeigen?');
@define('PLUGIN_FREETAG_SCALE', 'Schriftgröße der Tags nach Häufigkeit skalieren?');
@define('PLUGIN_FREETAG_UPGRADE1_2', 'Aktualisiere %d Tags zu Eintrag %d');
@define('PLUGIN_FREETAG_MAX_TAGS', 'Wieviele Tags sollen angezeigt werden?');
@define('PLUGIN_FREETAG_TRESHOLD_TAG_COUNT', 'Mindest-Nutzung eines Tags für Anzeige');

@define('PLUGIN_EVENT_FREETAG_USE_CAROC', 'Eine rotierende Canvas-Wolke verwenden?');
@define('PLUGIN_EVENT_FREETAG_USE_CAROC_DESC', 'Eine rotierende JavaScript-Wolke in %s! (Begrenzt einsetzbar, da sie mehr oder weniger "quadratische" Umgebungen benötigt.)');
@define('PLUGIN_EVENT_FREETAG_CAROC_TAG_COLOR', 'Tag-Farbe für rotierende Canvas-Wolke (rrggbb)');
@define('PLUGIN_EVENT_FREETAG_CAROC_TAG_COLOR_DESC', 'Wählen Sie die beiden Farben mit Bedacht. Für die Themes "pure" und "b53+" werden sie für die Textfarbe im "dark"-theme-mode automatisch gegeneinander vertauscht, so dass helle Schrift auf dunklem Grund und dunkle Schrift auf hellem Grund zu sehen ist.');
@define('PLUGIN_EVENT_FREETAG_CAROC_TAG_BORDER_COLOR', 'Tag Randfarbe für rotierende Canvas-Wolke (rrggbb)');
@define('PLUGIN_EVENT_FREETAG_CAROC_BOXWIDTH', 'Breite der rotierenden Canvas-Wolke in Pixeln');

@define('PLUGIN_EVENT_FREETAG_USE_CAWOC', 'Eine moderne Canvas 2D-Wortwolke verwenden?');
@define('PLUGIN_EVENT_FREETAG_USE_CAWOC_DESC', 'Eine hochmoderne "wordle"-ähnliche 2D-Wortwolke in %s!');

@define('PLUGIN_EVENT_FREETAG_USE_CANVAS_PLUGIN_SPRINT', 'Seitenleisten und Archiven');
@define('PLUGIN_EVENT_FREETAG_USE_CANVAS_EVENT_SPRINT', 'verwandten Tags');

@define('PLUGIN_FREETAG_USE_CANVAS_SCRIPTS_DESC', 'Um die Canvas-Skripte einzubinden, muss "show_tagcloud" auch im Event-Plugin aktiviert werden!');

//
// later on additions
//
@define('PLUGIN_EVENT_FREETAG_TAGCLOUD_MIN', 'Minimale Schriftgröße eines Tags in dieser Wolke in %');
@define('PLUGIN_EVENT_FREETAG_TAGCLOUD_MAX', 'Maximale Schriftgröße eines Tags in dieser Wolke in %');

@define('PLUGIN_FREETAG_META_KEYWORDS', 'Anzahl der Schlagwörter, die in die Meta-Angaben des HTML-Codes eingesetzt werden sollen (0: abgeschaltet)');

@define('PLUGIN_EVENT_FREETAG_TEMPLATE', 'Template für Seitenleiste (siehe default theme)');
@define('PLUGIN_EVENT_FREETAG_TEMPLATE_DESCRIPTION', 'Wenn ein Template angegeben ist, aber nicht das schon andernorts verwendete "plugin_freetag.tpl", wird es benutzt um die Seitenleiste anzuzeigen. Im Template wird eine Variable <tags> zur Verfügung gestellt, die ein Liste von Einträgen im folgenden Format enthält: <tagName> => array(href = <tagLink>, count => <tagCount>). Siehe "plugin_freetag_sidebar.tpl" im default Theme als simples copy Beispiel.');

@define('PLUGIN_EVENT_FREETAG_RELATED_ENTRIES', 'Artikel mit ähnlichen Themen:');
@define('PLUGIN_EVENT_FREETAG_SHOW_RELATED', 'Zeige Artikel mit ähnlichen Themen an?');
@define('PLUGIN_EVENT_FREETAG_SHOW_RELATED_COUNT', 'Wieviele Artikel mit ähnlichen Themen sollen angezeigt werden?');
@define('PLUGIN_EVENT_FREETAG_EMBED_FOOTER', 'Zeige die Tags in der Fußzeile an?');
@define('PLUGIN_EVENT_FREETAG_EMBED_FOOTER_DESC', 'Falls eingeschaltet, werden die Tags in der Fußzeile des Eintrags angezeigt. Wenn abgeschaltet, werden die Tags innerhalb des Textkörpers/erweiterten Teils des Artikels angezeigt.');
@define('PLUGIN_EVENT_FREETAG_LOWERCASE_TAGS', 'Tags in Kleinbuchstaben umwandeln');

@define('PLUGIN_EVENT_FREETAG_RELATED_TAGS', 'Verwandte Tags');
@define('PLUGIN_EVENT_FREETAG_TAGLINK', 'Taglink');
@define('PLUGIN_EVENT_FREETAG_CAT2TAG', 'Erstelle Tags für zugewiesene Kategorien?');
@define('PLUGIN_EVENT_FREETAG_CAT2TAG_DESC', 'Falls aktiviert, werden alle Kategorien eines Eintrags als Tags zugewiesen. Alle bestehende Kategoriezuweisungen können über die Tag-Verwaltung in Tags konvertiert werden.');
@define('PLUGIN_EVENT_FREETAG_KEYWORD2TAG', 'Erstelle Tags durch automatische Schlüsselwörter?');
@define('PLUGIN_EVENT_FREETAG_KEYWORD2TAG_DESC', 'Falls aktiviert, wird der Eintrag daraufhin geprüft, ob darin automatische Schlüsselwörter enthalten sind. Gegebenenfalls werden die entsprechenden Tags zugewiesen. Die Schlüsselwörter können über die Tag-Verwaltung festgelegt werden.');
@define('PLUGIN_EVENT_FREETAG_GLOBALLINKS', 'Alle zugewiesenen Kategorien bestehender Artikel zu Tags konvertieren');
@define('PLUGIN_EVENT_FREETAG_GLOBALCAT2TAG_ENTRY', 'Kategorien von Artikel #%d (%s) konvertiert zu: %s.');
@define('PLUGIN_EVENT_FREETAG_GLOBALCAT2TAG', 'Alle Kategorien wurden zu Tags konvertiert.');

@define('PLUGIN_EVENT_FREETAG_KEYWORDS', 'Automatische Schlüsselwörter');
@define('PLUGIN_EVENT_FREETAG_KEYWORDS_DESC', 'Sie können Schlüsselwörter (mit "," getrennt) für jedes bereits bestehende Tag zuweisen. Immer wenn eines dieser Schlüsselwörter im Text gefunden wird, wird der zugehörige Tag automatisch dem Eintrag zugewiesen. Achten Sie darauf, dass sehr viele automatische Schlüsselwörter beim Speichern eines Artikels längere Zeit beanspruchen können.');
@define('PLUGIN_EVENT_FREETAG_KEYWORDS_ADD', 'Schlüsselwort <strong>%s</strong> gefunden, Tag <strong><em>%s</em></strong> automatisch zugewiesen.');

@define('PLUGIN_EVENT_FREETAG_REBUILD_FETCHNO', 'Lese Einträge %d bis %d');
@define('PLUGIN_EVENT_FREETAG_REBUILD_TOTAL', ' (gesamt %d Einträge)...');
@define('PLUGIN_EVENT_FREETAG_REBUILD_FETCHNEXT', 'Hole nächste Runde von Einträgen...');
@define('PLUGIN_EVENT_FREETAG_REBUILD', 'Automatische Schlüsselwörter neu parsen');
@define('PLUGIN_EVENT_FREETAG_REBUILD_DESC', 'Warnung: Diese Funktion wird jeden einzelnen Blogeintrag einlesen und neu speichern. Das wird zum einen etwas dauern, und zum anderen besteht die Gefahr, dass ihre Einträge verändert werden könnten. Daher empfehlen wir, vorher ein Datenbank-Backup zu erstellen. Klicken Sie auf "Abbrechen", um diese Aktion abzubrechen.');

@define('PLUGIN_EVENT_FREETAG_ORDER_TAGNAME', 'Tag-Name');
@define('PLUGIN_EVENT_FREETAG_ORDER_TAGCOUNT', 'Tag-Anzahl');

@define('PLUGIN_EVENT_FREETAG_XMLIMAGE', 'XML Bild relativ zum Template Verzeichnis');

@define('PLUGIN_EVENT_FREETAG_EMBED_FOOTER_DESC2', 'Wenn auf "Smarty" gestellt wird, dann wird eine smarty Variable {$entry.freetag} generiert, die an beliebiger Stelle in der entries.tpl Vorlagendatei eingefügt werden kann.');

@define('PLUGIN_EVENT_FREETAG_EXTENDED_SMARTY', 'Erweitertes Smarty');
@define('PLUGIN_EVENT_FREETAG_EXTENDED_SMARTY_DESC', 'Nutze statt der HTML-Ausgabe, ob nun direkt oder per Smarty, verschiedene Smarty Variablen, die im Template zusammengefügt werden können. Dies überschreibt alle anderen diesbezüglichen Einstellungen. Ein Beispiel für die Nutzung findet sich im Readme.');
@define('PLUGIN_EVENT_FREETAG_KILL', 'Wenn aktiviert werden alle zugehörigen Tags gelöscht.');
@define('PLUGIN_EVENT_FREETAG_KILL_INFO_DESC', 'Einzelne Tags aus mehreren können von Hand entfernt werden, indem Sie das obige Eingabefeld für Tags verwenden. Das vollständige Entfernen wird jedoch nur mittels dieser Checkbox-Option unterstützt! <b>HINWEIS</b>: Bestimmte optionale Freetag-Plugin-Fälle, wie z.B. Kategorie-Tag-Namen und automatisierte Schlüsselwort-zu-Tag-Fälle, unterstützen das Entfernen nur bis zur nächsten Bearbeitung des Eintrags, wo sie automatisch wieder hinzugefügt werden. <b>ACHTUNG</b>: Rufen Sie nach abgeschickten Änderungen für den Fall einer fortsetzenden Bearbeitung den Eintrag noch einmal komplett neu auf, um die aktuell gespeicherten Werte (Tags) zu erhalten. Vertrauen Sie den angezeigten Daten nicht blindlings, sonst kann es sein, dass eben vorgenommene Änderungen gleich wieder überschrieben werden.');

@define('PLUGIN_EVENT_FREETAG_TAGLINK_DESC', 'Eine mögliche Änderung des Taglinks wäre "plugin/taglist/" anstelle von "plugin/tag/" zu schreiben. Dies wäre das Kommando, um jeden Taglink als Liste, anstelle von bereits geöffneten Artikeln, auszugeben. Man kann aber ebenso manuell für bestimmte Taglinks den "/taglist" tag an einen bereits existierenden Taglink (zB. "/plugin/tag/deine/tags/taglist") anhängen. In beiden Fällen ist "taglist" fortan ein reserviertes Kommando und kann nicht mehr als normales Tagwort verwendet werden. Für beide Möglichkeiten ist eine eigenhändig eingebaute Code-Änderung nötig, wie in der Dokumentation für die "Listenanzeige" Option beschrieben. Benötigt Option: "Listenanzeige (ungeöffnete Artikel)".');

@define('PLUGIN_EVENT_FREETAG_TAGSASLIST', 'Listenanzeige (ungeöffnete Artikel)');
@define('PLUGIN_EVENT_FREETAG_TAGSASLIST_DESC', 'In der Plugin-Dokumentation ist zu lesen, wie die existierende templates entries.tpl Datei für die Listenanzeige der Taglink-Ausgabe im Code geändert werden muss.');

@define('PLUGIN_EVENT_FREETAG_SORTTAGSBYCOUNT', 'Absteigende Sortierung von "Multi-Tags" Einträgen');
@define('PLUGIN_EVENT_FREETAG_SORTTAGSBYCOUNT_DESC', 'Normalerweise werden bei der Darstellung von mehreren gewählten Tags die damit zugewiesenen Einträge einfach nach Datum sortiert aufgelistet. Wenn diese Option aktiviert wird, werden die Einträge nach den häufigsten Überschneidungen mit den angeforderten Tags sortiert.');

@define('PLUGIN_EVENT_FREETAG_MANAGE_LEAFTAGS_NONE', 'Keine verwaisten Tags gefunden!');

@define('PLUGIN_EVENT_FREETAG_LOWERCASE_TAGS_DESC', 'Datenbank und Backend-Tags werden wie eingegeben gespeichert und angezeigt. Diese Option ist nur für Frontend-Tags.');

@define('PLUGIN_EVENT_FREETAG_ADMIN_DELIMITER', 'Erlaube alphabetische Sortierung und Unterteilung der Tag-Liste per Index?');

@define('PLUGIN_EVENT_FREETAG_SORT_DESC_FOR_TOTAL', 'Mit "order by count", absteigender Sortierung');

@define('PLUGIN_EVENT_FREETAG_ALLOW_JQUERYLIB', 'Nutze Plugin jQuery lib');
@define('PLUGIN_EVENT_FREETAG_ALLOW_JQUERYLIB_DESC', 'Lade Plugin jQuery lib nur im Frontend, wenn ihr Theme im header oder footer nicht schon das "default" jquery.js lädt.');

