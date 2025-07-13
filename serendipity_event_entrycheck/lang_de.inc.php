<?php

@define('PLUGIN_EVENT_ENTRYCHECK_TITLE', 'Regeln für Veröffentlichungen');
@define('PLUGIN_EVENT_ENTRYCHECK_DESC', 'Führt einige Prüfungen vor der Veröffentlichung eines Artikels durch.');
@define('PLUGIN_EVENT_ENTRYCHECK_EMPTYCATEGORIES', 'Leere Kategorien verhindern?');
@define('PLUGIN_EVENT_ENTRYCHECK_EMPTYCATEGORIES_DESC', 'Wenn auf "ja" gesetzt, muss ein Artikel mindestens einer Kategorie zugeordnet sein.');
@define('PLUGIN_EVENT_ENTRYCHECK_EMPTYCATEGORIES_WARNING', 'Es ist nicht erlaubt einen Eintrag ohne zugewiesene Kategorie zu veröffentlichen. Bitte die Kategorie setzen und erneut speichern!');
@define('PLUGIN_EVENT_ENTRYCHECK_EMPTYTITLE', 'Leeren Titel verhindern?');
@define('PLUGIN_EVENT_ENTRYCHECK_EMPTYTITLE_DESC', 'Wenn auf "ja" gesetzt, muss ein Artikel einen Titel besitzen.');
@define('PLUGIN_EVENT_ENTRYCHECK_EMPTYTITLE_WARNING', 'Es ist nicht erlaubt einen Eintrag ohne Titel zu veröffentlichen. Bitte einen Titel eintragen und erneut speichern!');
@define('PLUGIN_EVENT_ENTRYCHECK_EMPTYBODY', 'Leeren Eintrag verhindern?');
@define('PLUGIN_EVENT_ENTRYCHECK_EMPTYBODY_DESC', 'Wenn auf "ja" gesetzt, muss ein Artikel Text im Feld "Eintrag" enthalten.');
@define('PLUGIN_EVENT_ENTRYCHECK_EMPTYBODY_WARNING', 'Es ist nicht erlaubt einen Artikel mit leerem "Eintrag" zu veröffentlichen. Bitte einen Text in das Feld "Eintrag" eingeben und erneut speichern!');
@define('PLUGIN_EVENT_ENTRYCHECK_EMPTYEXTENDED', 'Leeren erweiterten Eintrag verhindern?');
@define('PLUGIN_EVENT_ENTRYCHECK_EMPTYEXTENDED_DESC', 'Wenn auf "ja" gesetzt, muss ein Artikel Text im Feld "Erweiterter Eintrag" enthalten.');
@define('PLUGIN_EVENT_ENTRYCHECK_EMPTYEXTENDED_WARNING', 'Es ist nicht erlaubt einen Eintrag mit leerem "Erweiterter Eintrag" zu veröffentlichen. Bitte einen Text in das Feld "Erweiterter Eintrag" eingeben und erneut speichern!');
@define('PLUGIN_EVENT_ENTRYCHECK_DEFAULTCAT', 'Standard-Kategorie definieren');
@define('PLUGIN_EVENT_ENTRYCHECK_DEFAULTCAT_DESC', 'Falls der Benutzer eine Kategorie leergelassen hat, kann der Eintrag automatisch dieser angegebenen Kategorie zugewiesen werden.');

@define('PLUGIN_EVENT_ENTRYCHECK_LOCKED', 'Dieser Artikel wurde vom Autoren %s am %s gesperrt');
@define('PLUGIN_EVENT_ENTRYCHECK_UNLOCK', 'Artikel entsperren');
@define('PLUGIN_EVENT_ENTRYCHECK_LOCK_WARNING', 'Dieser Artikel ist gesperrt und kann nur von dem sperrenden Autoren bearbeitet werden, oder Sie entfernen die Sperre.');
@define('PLUGIN_EVENT_ENTRYCHECK_LOCKING', 'Artikel-Sperren aktivieren?');
@define('PLUGIN_EVENT_ENTRYCHECK_LOCKING_DESC', 'Wenn Sie Serendipity als Plattform für die Zusammenarbeit im Team verwenden, möchten Sie vielleicht sicherstellen, dass Ihre Team-Autoren denselben Artikel bearbeiten/überprüfen können, ohne dass die Gefahr besteht, dass die Arbeit der anderen versehentlich überschrieben wird. Diese Option fügt eine grundlegende Sperr-Unterstützung hinzu. Sie sperrt einen Artikel automatisch, wenn er in den Bearbeitungsmodus wechselt, und die Sperre wird nach 1 Stunde Inaktivität aufgehoben. Außerdem wurde eine Schaltfläche zum Aufheben der Sperre hinzugefügt, die die Sperre aufhebt und Ihnen die Möglichkeit gibt, einen Eintrag zu bearbeiten.');

