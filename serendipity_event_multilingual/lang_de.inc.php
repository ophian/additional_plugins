<?php

@define('PLUGIN_EVENT_MULTILINGUAL_TITLE', 'Multilinguale Einträge');
@define('PLUGIN_EVENT_MULTILINGUAL_DESC', 'Erlaubt die Erstellung mehrerer Sprachversionen eines Eintrags');
@define('PLUGIN_EVENT_MULTILINGUAL_NEEDTOSAVE', 'Der Artikel muss gespeichert werden, bevor eine alternative Sprachversion erstellt werden kann. Der Eintrag kann dazu auch als Entwurf gespeichert werden.');
@define('PLUGIN_EVENT_MULTILINGUAL_CURRENT', 'Sprachversion zur Bearbeitung auswählen: ');
@define('PLUGIN_EVENT_MULTILINGUAL_SWITCH', 'Sprache wechseln');
@define('PLUGIN_EVENT_MULTILINGUAL_COPY', 'Behalten Sie vorhergehenden Spracheninhalt bei');
@define('PLUGIN_EVENT_MULTILINGUAL_COPYDESC', 'Beibehaltung des Inhalts der vorherigen Sprache im Backend Eintrags-Eingabefeld, bei der Arbeit mit der neuen Sprachversion');
@define('PLUGIN_EVENT_MULTILINGUAL_TAGTITLE', 'Übersetzte Blog Titel (siehe Konfiguration)');
@define('PLUGIN_EVENT_MULTILINGUAL_TAGTITLE_DESC', 'Erlaubt die Benutzung von {{!<lang>}}<text>{{--}} übersetzten "tag" Sprachmodulen des globalen Blogtitels und der Blog Beschreibung. Auch benutzt für Eintragstitel der multilingualen Einträge.');
@define('PLUGIN_EVENT_MULTILINGUAL_TAGENTRIES', 'Übersetzte Einträge und Eintragstitel');
@define('PLUGIN_EVENT_MULTILINGUAL_TAGENTRIES_DESC', 'Erlaubt {{!<lang>}}<text>{{--}} Sprachmodule für Einträge');
@define('PLUGIN_EVENT_MULTILINGUAL_TAGSIDEBAR', 'Übersetzung von Seitenleisten Elementen');
@define('PLUGIN_EVENT_MULTILINGUAL_TAGSIDEBAR_DESC', 'Erlaubt {{!<lang>}}<text>{{--}} Sprachmodule für Seitenleisten Einträge');
@define('PLUGIN_EVENT_MULTILINGUAL_PLACE', 'Wo sollen die Links dargestellt werden?');
@define('PLUGIN_EVENT_MULTILINGUAL_PLACE_ADDFOOTER', 'im Eintragsfuß');
@define('PLUGIN_EVENT_MULTILINGUAL_PLACE_ADDSPECIAL', 'per "multilingual_footer" Variable für benutzerdefinierte Smarty Ausgaben');

@define('PLUGIN_EVENT_MULTILINGUAL_LANGSWITCH', 'Überschreibe die globale Sprache?');
@define('PLUGIN_EVENT_MULTILINGUAL_LANGSWITCH_DESC', 'Wenn Sie eine Übersetzung für einen Blog-Eintrag wählen, soll auch die gesamte Sprache des Blogs gewechselt werden?');

@define('PLUGIN_EVENT_MULTILINGUAL_ENTRY_RELOADED', 'Multilinguale Eintrags-Sprache &lt;%s&gt; erneuert');

@define('PLUGIN_EVENT_MULTILINGUAL_LANGIFIED', 'Sprachname in Landessprache?');
@define('PLUGIN_EVENT_MULTILINGUAL_LANGIFIED_DESC', 'Default: in Englisch. Betrifft Linknamen der multilingualen Eintrags Metadaten.');

@define('PLUGIN_EVENT_MULTILINGUAL_EXAMPLE_READMEHINT', 'Bitte lesen Sie die Plugin Dokumentation über obigen Link sorgfältig durch!');

//
//  serendipity_plugin_multilingual.php
//
@define('PLUGIN_SIDEBAR_MULTILINGUAL_TITLE', 'Sprachauswahl');
@define('PLUGIN_SIDEBAR_MULTILINGUAL_DESC', 'Ermöglicht Besuchern die Ausgabesprache von Serendipity zu ändern');
@define('PLUGIN_SIDEBAR_MULTILINGUAL_USERDESC', 'Hier können Sie eine andere Ausgabesprache dieser Blog-Oberfläche wählen: ');
@define('PLUGIN_SIDEBAR_MULTILINGUAL_SUBMIT', 'Submit-Button?');
@define('PLUGIN_SIDEBAR_MULTILINGUAL_SUBMIT_DESC', 'Einen Submit-Button anzeigen?');
@define('PLUGIN_SIDEBAR_MULTILINGUAL_SIZE', 'Schriftkegelgröße');

@define('PLUGIN_SIDEBAR_MULTILINGUAL_LANGIFIED_DESC', 'Default: in Englisch. Betrifft Select-Titel der Seitenleisten Selectbox.');
@define('PLUGIN_EVENT_MULTILINGUAL_PURGE_INFO_DESC', 'Wie Sie bereits erfahren haben, kann über diese zusätzliche Auswahl ein Blogeintrag mehrsprachig erstellt und verwaltet werden.
   <p><strong>Zusammenfassend:</strong> Schreiben Sie einen Blog Eintrag in der eigentlichen Blogsprache (Beispiel) "Deutsch" und speichern diesen wie gewohnt ab.
   Bei einen erneuten Aufruf aus der Datenbank hat das entryproperties event Plugin nun einen zusätzliche Auswahlmöglichkeit in den
   <b>Erweiterten Optionen</b> bereitgestellt, mit dem Sie eine Sprachversion (zb, "Englisch") zur Bearbeitung auswählen bzw.
   erstellen können. Je nach optionaler Einstellung im multilingual Plugin, wird nun derselbe Eintrag, textlich als Kopie bereits
   befüllt oder nicht, als englischsprachiges Pendent desselben Eintrags bereitgestellt. Jetzt ändern und schreiben Sie ihren
   englischen Text und die englische Überschrift und speichern denselben ab. Technisch gesehen ist dies also eine Sprachkopie
   des alten Eintrags und wird in der entryproperties Datenbanktabelle gespeichert.</p>
   <p>Die Backend Eintrags Liste führt weiterhin nur den originären deutschen Blogeintag auf, markiert diesen aber mit der zusätzlichen
   Sprache als multilingualen Eintrag. Klicken Sie auf den &laquo;Titel&raquo; oder &laquo;Bearbeiten&raquo; wird wieder der originale,
   deutschsprachige Eintrag zur Bearbeitung ausgegeben.</p>
   <p>Wechseln Sie nun - wie vordem - einfach die multilinguale Auswahl-Sprache nach "Englisch", so sollte Ihr englischsprachiger Eintrag erscheinen.</p>
   <p>Dies kann nun für eine weitere Sprache wiederholt werden oder gleich aus dem eben erstellten "englischen" Beitrag für eine weitere Sprache vollzogen werden.
   - Und so weiter. Diese jeweiligen Spracheinträge sind auch nachträglich veränderbar.</p>
   <p>Möchten Sie nun später einen dieser erweiternden Spracheinträge (zB. Spanisch) löschen wollen, so laden Sie diesen Spracheintrag
   wie besprochen und markieren/setzen Sie die Checkbox zur Löschung, bevor Sie den Blog-Eintrag wie immer erneut abspeichern.</p>
   <p>Die Kopf "Header success" Anzeigen nach dem Speichern sind für den normalen Eintrags-Ablauf gestaltet und besagen, dass der Eintrag gespeichert wurde,
   obwohl Sie ihn ja mittels der Checkbox gelöscht haben. Lassen Sie sich davon nicht beirren.</p>
   <p>Dieser Spracheintrag sollte nun in der Datenbank entryproperties Tabelle gelöscht sein, wird aber im Eintragsformular nach dem Speichern
   immer noch angezeigt, da Sie sich ja immer noch in der "Spanischen" Sprachkondition befinden. Ein erneutes Speichern würde ihn mit den gezeigten Daten wieder anlegen.</p>
   <p>Wechseln Sie diese nun zurück auf ihren ersterstellten multiligualen (englischen) Eintrag oder springen Sie besser zur Eintragsliste
   des Backends und Sie werden sehen, dass die Auszeichnung für den erweiterten Spanischen Spracheintrag "es" verschwunden ist.</p>');
@define('PLUGIN_SIDEBAR_MULTILINGUAL_JS_LANG_CHANGE_NOTIFICATION', 'ACHTUNG: Sie haben zuvor Sprache "%s" ausgewählt. Bei "Standard" wird keine aktive Sprache geladen. "This is the End, my friend". Seien Sie umsichtig, denn nicht nur nach dem Umschalten könnte jetzt ein unbedachtes, weiteres Speichern direkt Ihren ursprünglichen Eintrag überschreiben.');

