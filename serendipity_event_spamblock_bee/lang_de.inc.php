<?php

@define('PLUGIN_EVENT_SPAMBLOCK_BEE_TITLE', 'Spamschutz Biene (Honeypot, Verstecktes Captcha)');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_DESC',  'Implementiert Kommentar AntiSpam Ma�nahmen, die einfach zu konfigurieren aber sehr effektiv sind.');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_EXTRA_DESC',  '<strong>Installationshinweis</strong>: Es ist recht wichtig, dieses Plugin an die Spitze der Plugin Liste zu verschieben, weil es dann am effektivsten arbeiten kann.');

@define('PLUGIN_EVENT_SPAMBLOCK_BEE_PATH', 'Plugin Pfad');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_PATH_DESC', 'In normalen Installationen ist der Default die korrekte Einstellung.');

@define('PLUGIN_EVENT_SPAMBLOCK_BEE_REQUIRED_FIELDS', 'Pflichtfelder beim Kommentieren');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_REQUIRED_FIELDS_DESC', 'Geben Sie die Liste von Pflichtfeldern bei der Abgabe eines Kommentars ein. Mehrere Felder k�nnen mit "," getrennt werden. Verf�gbare Felder sind: name, email, url, replyTo, comment');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_REASON_REQUIRED_FIELD', 'Sie haben das Feld "%s" nicht ausgef�llt!');

@define('PLUGIN_EVENT_SPAMBLOCK_BEE_FILTER_TITLE', 'Kommentare abweisen, die als Text nur den Artikeltitel enthalten');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_FILTER_TITLE_DESC', 'Einige Kommentar SpamBots wollen nur einen Link absetzen und f�llen den Kommentar einfach mit dem, was im Seitentitel gefunden wird. Dies w�rde kein normaler Kommentator tun, somit ist es sicher, diese Option einzuschalten.');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_FILTER_SAMEBODY', 'Kommentare abweisen, die einen bereits gespeicherten Text haben');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_FILTER_SAMEBODY_DESC', 'Dies wird Kommentare abweisen, die einen Text haben, der im System bereits gespeichert wurde. Z.B. wenn ein Kommentator nach einer Kommentar Speicherung die Seite erneut l�dt. Solche Kommentare k�nnen sicher abgewiesen werden.');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_ERROR_BODY', 'Antispam Ma�nahme: Ung�ltiger Kommentar.');

@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_SECTION_LOGGING', 'Dateien und Logging');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_SECTION_ADVANCED', 'Fortgeschrittene Captcha-Konfiguration');

@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_SPAM_HONEYPOT', 'Honeypot einsetzen');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_SPAM_HONEYPOT_DESC', 'Ein "Honeypot" ist ein verstecktes Kommentar Feld, das leer gelassen werden soll. Da Bots aber dazu tendieren, alle vorgefundenen Felder auszuf�llen, ist dies ein einfacher und unkritischer Weg, viele der Bots auszusperren. Um den Honeypot besonders effektiv zu machen, setze die Spamschutz Biene als erstes AntiSpam Plugin in Deiner Liste ein.');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_WARN_HONEPOT', 'Du willst mir nicht wirklich Deine Nummer geben, oder? ;)');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_SPAM_HCAPTCHA', 'Versteckte Captchas');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_SPAM_HCAPTCHA_DESC', 'Hiermit wird ein Captcha erzeugt, das f�r Menschen sehr einfach zu l�sen ist, aber nicht f�r Bots. Wenn der Kommentator Javascript angeschaltet hat, wird das Captcha sogar automatisch gel�st und versteckt. Da Bots kein Javascript unterst�tzen, ist dies eine weitere Falle f�r Bots, die f�r normale Benutzer unsichtbar ist.');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_ERROR_HCAPTCHA', 'Antispam Ma�nahme: Falsches Captcha.');

@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_SPAM_LOGTYPE', 'Spam Log Typ');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_SPAM_LOGTYPE_DESC', 'Wohin sollen Kommentare, die von der Spamschutz Biene gefunden wurden, geloggt werden?');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_SPAM_LOGTYPE_NONE', 'Nicht loggen');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_SPAM_LOGTYPE_FILE', 'Textdatei');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_SPAM_LOGTYPE_DATABASE', 'Spamlog Datenbank Tabelle');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_SPAM_LOGFILE', 'Logdatei');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_SPAM_LOGFILE_DESC', 'Wohin soll das Textfile f�r die Logs gespeichert werden?');

@define('PLUGIN_EVENT_SPAMBLOCK_BEE_RESULT_OFF', 'Ausgeschaltet');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_RESULT_MODERATE', 'Kommentare moderieren');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_RESULT_REJECT', 'Kommentare abweisen');

@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_ADV_RM_DEFAULT', 'Standard');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_ADV_RM_JSON', 'JSON');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_ADV_RM_SMARTY', 'Smarty');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_ADV_RM_SMARTY_ENC', 'Smarty + Verschl�sselung');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_ADV_QT_MATH', 'Rechenaufgaben');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_ADV_QT_CUSTOM', 'Eigene Fragen');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_ADV_DESC', 'Fortgeschrittene Konfigurationsoptionen f�r das verstecke Captcha. Wenn dieses nicht aktiviert ist, kann dieser Abschnitt getrost �bersprungen werden.');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_ADV_ANSWER_RETRIEVAL', 'Methode f�r Abfrage der Antwort');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_ADV_ANSWER_RETRIEVAL_DESC', 'W�hlen Sie hier aus, wie die korrekte Antwort abgefragt werden soll. Bei Auswahl von "JSON" kann ein Ajax-Request an index.php/plugin/spamblockbeecaptcha abgesetzt werden, um die richtige Antwort zu erhalten. Die Auswahl "Smarty" wird die Antwort �ber die Smarty-Variable {$beeCaptchaAnswer} bereitstellen, w�hrend "Standard" den Wert in der Seite hartkodiert.');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_ADV_ANSWER_RETRIEVAL_DESC_ADD', 'ACHTUNG: ist "Smarty" ausgew�hlt, wird keinerlei zus�tzliches CSS oder JavaScript eingebunden. Das Captcha-Feld muss also selbst bef�llt und versteckt werden. "Smarty + Verschl�sselung" ist dasselbe wie "Smarty" mit dem Unterschied, dass die {$beeCaptchaAnswer} mit einer simplen XOR-Verschl�sselung verschleiert wurde. Der Entschl�sselungs-Key steht in der Variablen {$beeCaptchaScrambleKey}.');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_ADV_QUESTION_TYPE', 'Art der Frage');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_ADV_QUESTION_TYPE_DESC', 'Spamschutz Biene kann automatisch simple Rechenaufgaben generieren. Es k�nnen aber auch eigene Fragen und Antworten angegeben werden. W�hlen Sie die bevorzugte aus.');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_ADV_QUESTIONS', 'Eigene Fragen');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_ADV_DEFAULT_QUESTIONS', "Frage1\nFrage2");
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_ADV_QUESTIONS_DESC', 'Wenn Sie eigene Fragen verwenden m�chten, geben Sie diese hier an. Schreiben Sie dabei eine Frage pro Zeile. Bevor der Benutzer das Formular absenden kann, muss er eine zuf�llig aus der Liste gew�hlte Frage beantworten.');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_ADV_ANSWERS', 'Antworten auf die Fragen');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_ADV_ANSWERS_DESC', 'Dieses Feld enth�lt die korrekten Antworten auf die oben angegebenen Fragen. Geben Sie pro Zeile eine Antwort an in derselben Reihenfolge, die auch die Fragen haben. Fragen, f�r die es keine Antworten gibt, werden ignoriert. Gro�- und Kleinschreibung spielt keine Rolle (d.h. "Antwort" ist dasselbe wie "antwort".');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_ADV_DEFAULT_ANSWERS', "Antwort1\nAntwort2");
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_ADV_USE_REGEXP', 'Regul�re Ausdr�cke benutzen');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_ADV_USE_REGEXP_DESC', 'Gibt an, ob Perl-kompatible regul�re Ausdr�cke (PCREs) f�r die Antworten verwendet werden sollen. Diese k�nnen dazu benutzt werden, mehrere Varianten einer Antwort zuzulassen. Jeder Antwortzeile sollte dabei dem Muster /pattern/:Antwort entsprechen.');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_ADV_USE_REGEXP_DESC_ADD', 'ACHTUNG: Aktivieren Sie diese Option nur, wenn Sie genau wissen was Sie tun. Ein ung�ltiger regul�rer Ausdruck wird Validit�ts-Pr�fungen fehlschlagen lassen und k�nnte das Blog in wenigen F�llen einer sogenannten Denial-of-Service-Attacke aussetzen. Antworten l�nger als 1000 Zeichen werden abgewiesen, wenn regul�re Ausdr�cke eingeschaltet sind.');

@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CAPTCHA_0', 'Null');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CAPTCHA_1', 'Eins');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CAPTCHA_2', 'Zwei');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CAPTCHA_3', 'Drei');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CAPTCHA_4', 'Vier');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CAPTCHA_5', 'F�nf');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CAPTCHA_6', 'Sechs');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CAPTCHA_7', 'Sieben');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CAPTCHA_8', 'Acht');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CAPTCHA_9', 'Neun');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CAPTCHA_10', 'Zehn');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CAPTCHA_PLUS', 'plus');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CAPTCHA_MINUS', 'minus');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CAPTCHA_QUEST', 'Was ist');

@define('PLUGIN_SPAMBLOCK_BEE_TITLE', 'Spam Report');
@define('PLUGIN_SPAMBLOCK_BEE_DESC', 'Stellt eine Statistik dar �ber Kommentar Spam Eintr�ge, wenn die AntiSpam Plugins in die spamblocklog Tabelle loggen.');
@define('PLUGIN_SPAMBLOCK_BEE_DAYS', 'Anzuzeigende Tage');
@define('PLUGIN_SPAMBLOCK_BEE_DAYS_DESC', 'Der Report wird f�r die letzten X Tage erstellt. Hier k�nnen mehrere Tage Komma separiert einstellt werden, f�r die jeweils ein Report dargestellt werden soll.');
@define('PLUGIN_SPAMBLOCK_BEE_DBSEARCHES', 'Datenbank Suchen');
@define('PLUGIN_SPAMBLOCK_BEE_DBSEARCHES_DESC', 'Dieses Plugin durchsucht die spamblocklog-Tabelle. Hier kann man Suchen f�r bestimmte AntiSpam Ma�nahmen einstellen, die gez�hlt werden sollen. In jede Zeile kommt eine Einstellung und ihr Format ist NameF�rAntiSpamArt:Suchbegriff. Das Zeichen % kann als Wildcard benutzt werden. Beispiel: "BayesPlugin:%Bayes%" wird alle Eintr�ge z�hlen, die "Bayes" irgendwo in ihrem Titel haben und sie als "BayesPlugin" im Report darstellen.');
@define('PLUGIN_SPAMBLOCK_BEE_LOGGEDIN', 'Nur f�r eingeloggte Benutzer');
@define('PLUGIN_SPAMBLOCK_BEE_LOGGEDIN_DESC', 'Wenn Sie dies anschalten k�nnen nur eingeloggte Benutzer des Blogs die Statistik in der Seitenleiste sehen.');
@define('PLUGIN_SPAMBLOCK_BEE_CACHEMINS', 'Reporting Cache');
@define('PLUGIN_SPAMBLOCK_BEE_CACHEMINS_DESC', 'Das Erzeugen des Reports erzeugt Last auf der Datenbank, deshalb sollte der Report gecached werden. Hier wird eingestellt, wie viele Minuten mindestens gewartet werden soll, bevor ein neuer Report erstellt wird.');
@define('PLUGIN_SPAMBLOCK_BEE_TODAY', 'Heute:');
@define('PLUGIN_SPAMBLOCK_BEE_LAST_X_DAYS', 'Die letzten %d Tage:');

@define('PLUGIN_EVENT_SPAMBLOCK_BEE_SHOW', 'Frontend Ausgabe des Bee javascripts');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_SHOW_DESC', 'Nur auf Eintrags-Kommentarseiten, nur auf Kontaktform (Plugin) Seite, oder auf beiden (Standard).');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_SHOW_ENTRY', 'Eintrag');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_SHOW_CONTACTFORM', 'Kontaktform');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_SHOW_BOTH', 'Beide');

