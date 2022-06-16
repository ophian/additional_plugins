<?php

@define('PLUGIN_EVENT_OUTDATE', 'Eintr�ge nach Verfallsdatum ausblenden');
@define('PLUGIN_EVENT_OUTDATE_DESC', 'Blendet alle Eintr�ge die ein definiertes Alter �berschritten haben aus, so dass sie nur f�r registrierte Benutzer sichtbar sind. Sowie weitere, �hnliche Methoden zur Artikel Behandlung.');
@define('PLUGIN_EVENT_OUTDATE_TIMEOUT', 'Wann werden Artikel unsichtbar?');
@define('PLUGIN_EVENT_OUTDATE_TIMEOUT_DESC', 'Geben sie das Alter eines Eintrages (in Tagen, beispielsweise 31) an, nachdem ein Artikel f�r Besucher "unsichtbar" wird. 0 zum Deaktivieren. Sollten Sie dieses Feature bereits benutzt haben, wird das Deaktivieren mit 0 zu keiner Ver�nderung derjenigen Eintr�ge f�hren. Zum Zur�cksetzen all dieser Eintr�ge, die bereits nur f�r registrierte Benutzer sichtbar gesetzt wurden, geben Sie einmalig -1 ein und speichern die Konfiguration ab. Der n�chste Aufruf im Frontend (*) nimmt dann die Konvertierung aller "member" Eintr�ge in "public" Eintr�ge vor und setzt diese Konfiguration Variable auf 0. (* Unter Umst�nden ben�tigt solch ein Frontend Request bis zu 2 Aufrufe bis alles gesetzt und korrekt wieder ausgelesen ist. Machen Sie es am besten selbst.)');
@define('PLUGIN_EVENT_OUTDATE_TIMEOUT_STICKY', 'Wann werden dauerhafte Artikel freigegeben?');
@define('PLUGIN_EVENT_OUTDATE_TIMEOUT_STICKY_DESC', 'Geben Sie das maximale Alter eines Eintrags (Anzahl der Tage, beispielsweise 31) ein, nach dem ein "klebriger" (angehefteter) Eintrag wieder freigegeben wird. 0 zum Deaktivieren.');

@define('PLUGIN_EVENT_OUTDATE_TIMEOUT_EXPIRY_FIELD', 'Name f�r benutzerdefiniertes Feld (Verfallsdatum)');
@define('PLUGIN_EVENT_OUTDATE_TIMEOUT_EXPIRY_FIELD_DESC', 'Wenn Sie das Plugin "Erweiterte Eigenschaften von Artikeln" verwenden, k�nnen Sie ein benutzerdefiniertes Feld definieren, in das Sie das Datum eingeben, an dem ein Eintrag ablaufen soll. Dieses Datum sollte mit einem Zeitstempel wie JJJJ-MM-TT formatiert werden. Das Plugin sucht nach diesem Ablaufdatum und setzt den Eintrag auf ENTWURF, so dass er im Frontend verborgen ist. Geben Sie hier den Feldnamen des benutzerdefinierten Feldes ein (z. B. "ExpiryDate").');

