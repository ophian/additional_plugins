<?php

@define('PLUGIN_EVENT_OUTDATE', 'Einträge für nicht-registrierte Benutzer nach Verfallsdatum ausblenden');
@define('PLUGIN_EVENT_OUTDATE_DESC', 'Blendet alle Einträge die ein definiertes Alter überschritten haben aus, so dass sie nur für registrierte Benutzer sichtbar sind.');
@define('PLUGIN_EVENT_OUTDATE_TIMEOUT', 'Wann werden Artikel unsichtbar?');
@define('PLUGIN_EVENT_OUTDATE_TIMEOUT_DESC', 'Geben sie das Alter eines Eintrages (in Tagen) an, nachdem ein Artikel unsichtbar wird');
@define('PLUGIN_EVENT_OUTDATE_TIMEOUT_STICKY', 'Wann werden klebrige Artikel wieder freigegeben?');
@define('PLUGIN_EVENT_OUTDATE_TIMEOUT_STICKY_DESC', 'Geben Sie das maximale Alter eines Eintrags (Anzahl der Tage) ein, nach dem ein "klebriger" (angehefteter) Eintrag wieder freigegeben wird. 0 zum Deaktivieren.');

@define('PLUGIN_EVENT_OUTDATE_TIMEOUT_EXPIRY_FIELD', 'Name für benutzerdefiniertes Feld (Verfallsdatum)');
@define('PLUGIN_EVENT_OUTDATE_TIMEOUT_EXPIRY_FIELD_DESC', 'Wenn Sie das Plugin "Erweiterte Eigenschaften von Artikeln" verwenden, können Sie ein benutzerdefiniertes Feld definieren, in das Sie das Datum eingeben, an dem ein Eintrag ablaufen soll. Dieses Datum sollte mit einem Zeitstempel wie JJJJ-MM-TT formatiert werden. Das Plugin sucht nach diesem Ablaufdatum und setzt den Eintrag auf ENTWURF, so dass er im Frontend verborgen ist. Geben Sie hier den Feldnamen des benutzerdefinierten Feldes ein (z. B. "ExpiryDate").');

