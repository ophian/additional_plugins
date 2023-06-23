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

