<?php

@define('PLUGIN_EVENT_OUTDATE', 'Einträge nach Verfallsdatum ausblenden');
@define('PLUGIN_EVENT_OUTDATE_DESC', 'Blendet alle Einträge die ein definiertes Alter überschritten haben aus, so dass sie nur für registrierte Benutzer sichtbar sind. Sowie weitere, ähnliche Methoden zur Artikel Behandlung.');
@define('PLUGIN_EVENT_OUTDATE_TIMEOUT', 'Wann werden Artikel unsichtbar?');
@define('PLUGIN_EVENT_OUTDATE_TIMEOUT_DESC', 'Geben sie das Alter eines Eintrages (in Tagen, beispielsweise 31) an, nachdem ein Artikel für Besucher "unsichtbar" wird. 0 zum Deaktivieren. Sollten Sie dieses Feature bereits benutzt haben, wird das Deaktivieren mit 0 zu keiner Veränderung derjenigen Einträge führen. Zum Zurücksetzen all dieser Einträge, die bereits nur für registrierte Benutzer sichtbar gesetzt wurden, geben Sie einmalig -1 ein und speichern die Konfiguration ab. Der nächste Aufruf im Frontend (*) nimmt dann die Konvertierung aller "member" Einträge in "public" Einträge vor und setzt diese Konfiguration Variable auf 0. (* Unter Umständen benötigt solch ein Frontend Request bis zu 2 Aufrufe bis alles gesetzt und korrekt wieder ausgelesen ist. Machen Sie es am besten selbst.)');
@define('PLUGIN_EVENT_OUTDATE_TIMEOUT_STICKY', 'Wann werden dauerhafte Artikel freigegeben?');
@define('PLUGIN_EVENT_OUTDATE_TIMEOUT_STICKY_DESC', 'Geben Sie das maximale Alter eines Eintrags (Anzahl der Tage, beispielsweise 31) ein, nach dem ein "klebriger" (angehefteter) Eintrag wieder freigegeben wird. 0 zum Deaktivieren.');

@define('PLUGIN_EVENT_OUTDATE_TIMEOUT_EXPIRY_FIELD', 'Name für benutzerdefiniertes Feld (Verfallsdatum)');
@define('PLUGIN_EVENT_OUTDATE_TIMEOUT_EXPIRY_FIELD_DESC', 'Wenn Sie das Plugin "Erweiterte Eigenschaften von Artikeln" verwenden, können Sie ein benutzerdefiniertes Feld definieren, in das Sie das Datum eingeben, an dem ein Eintrag ablaufen soll. Dieses Datum sollte mit einem Zeitstempel wie JJJJ-MM-TT formatiert werden. Das Plugin sucht nach diesem Ablaufdatum und setzt den Eintrag auf ENTWURF, so dass er im Frontend verborgen ist. Geben Sie hier den Feldnamen des benutzerdefinierten Feldes ein (z. B. "ExpiryDate").');

