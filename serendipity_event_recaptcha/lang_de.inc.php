<?php

/**
 *  @version
 *  @author Translator Andy Blank <andy.blank@gmx.net>
 *  DE-Revision: Revision of lang_en.inc.php
 */

@define('PLUGIN_EVENT_RECAPTCHA_TITLE', 'Recaptcha');
@define('PLUGIN_EVENT_RECAPTCHA_DESC', 'Recaptcha f�r die Kommentar-Funktion von Artikeln aktivieren (Sie m�ssen einen Schl�ssel anfordern)');

@define('PLUGIN_EVENT_RECAPTCHA_HIDE', 'Recaptchas f�r Autoren deaktieren');
@define('PLUGIN_EVENT_RECAPTCHA_HIDE_DESC', 'Autoren der folgenden Benutzergruppen soll es erlaubt sein, Kommentare zu ver�ffentlichen, ohne ein Recaptcha einzugeben.');

@define('PLUGIN_EVENT_RECAPTCHA_RECAPTCHA', 'Recaptcha aktivieren');
@define('PLUGIN_EVENT_RECAPTCHA_RECAPTCHA_DESC', 'Wenn diese Funktion aktiviert ist, wird ein Recaptcha generiert. Diese spezielle Art von Capchas helfen B�cher zu digitalisieren. Weitere Informationen finden Sie unter https://www.google.com/recaptcha/. Statt der Eingabe der angezeigten Buchstaben, kann sich der Benutzer auch alternativ eine Nachricht anh�ren, und die geh�rten Nummern eingeben. Wenn kein Captcha generiert wird, kann es seinm dass der Recapcha-Server nicht erreichbar ist.');

@define('PLUGIN_EVENT_RECAPTCHA_RECAPTCHA_STYLE', 'Stil der Recapchas welcher genutzt wird');
@define('PLUGIN_EVENT_RECAPTCHA_RECAPTCHA_STYLE_DESC', 'Rot, weiss oder schwarz-glasig. Dies funktioniert nur, wenn Javascript aktiviert ist.');

@define('PLUGIN_EVENT_RECAPTCHA_RECAPTCHA_PUB', 'Geben Sie den �ffentlicher Schl�ssel f�r Recaptcha ein');
@define('PLUGIN_EVENT_RECAPTCHA_RECAPTCHA_PUB_DESC', '�ffentliches Schl�sselpaar f�r die Kommunikation mit dem reCAPTCHA Server. Ein �ffentliches/privates Schl�sselpaar kann unter https://www.google.com/recaptcha/admin angefordert werden.');

@define('PLUGIN_EVENT_RECAPTCHA_RECAPTCHA_PRIV', 'Geben Sie den privaten Schl�ssel f�r Recaptcha ein');
@define('PLUGIN_EVENT_RECAPTCHA_RECAPTCHA_PRIV_DESC', 'Privates Schl�sselpaar f�r die Kommunikation mit dem reCAPTCHA Server. Ein �ffentliches/privates Schl�sselpaar kann unter https://www.google.com/recaptcha/admin angefordert werden.');

@define('PLUGIN_EVENT_RECAPTCHA_CAPTCHAS_TTL', 'Anzahl der Tage nach der die Eingabe von Recaptchas erzwungen wird');
@define('PLUGIN_EVENT_RECAPTCHA_CAPTCHAS_TTL_DESC', 'Recaptchas k�nnen abh�ngig vom Alter des Artikels erzwungen werden. Hier kann die Anzahl der Tage eingegeben werden, nach der die korrekte Eingabe eines Recaptchas notwendig wird. Ist dieser Wert 0, werden Recaptchas immer angezeigt.');

@define('PLUGIN_EVENT_RECAPTCHA_LOGTYPE', 'W�hlen Sie die Log-Methode');
@define('PLUGIN_EVENT_RECAPTCHA_LOGTYPE_DESC', 'Das loggen von zur�ckgewiesenen Kommentaren kann mittels Datenbank oder (Text)Datei realisiert werden');
@define('PLUGIN_EVENT_RECAPTCHA_LOGTYPE_FILE', 'Datei (siehe Logdatei)');
@define('PLUGIN_EVENT_RECAPTCHA_LOGTYPE_DB', 'Datenbank');
@define('PLUGIN_EVENT_RECAPTCHA_LOGTYPE_NONE', 'Kein Loggen');

@define('PLUGIN_EVENT_RECAPTCHA_LOGFILE', 'Speicherort der Logdatei');
@define('PLUGIN_EVENT_RECAPTCHA_LOGFILE_DESC', 'Informationen �ber zur�ckgewiesene/moderierte Kommentare k�nnen in eine Logdatei geschrieben werden. Um das Loggen zu deaktivieren, kann f�r diesen Wert eine leere Zeichenkette eingegeben werden.');

@define('PLUGIN_EVENT_RECAPTCHA_ERROR_CAPTCHAS', 'Sie haben keine g�ltige Zeichenkette in die Spam-Schutz Box eingegeben. Bitten betrachten Sie das angezeigte Bild an und geben Sie die entsprechenden Werte ein.');
@define('PLUGIN_EVENT_RECAPTCHA_ERROR_RECAPTCHA', 'Sie haben keinen �ffentlichen/privaten Schl�ssel in der Recapcha-Konfiguration eingegeben. Es werden keine Recaptchas verwendet. Wenn Sie Recaptchas nutzen wollen, geben Sie bitte die entsprechenden Schl�ssel im Konfigurations-Bereich des Recaptcha-Plugins ein oder verwenden Sie die herk�mmlichen Captchas.');

@define('PLUGIN_EVENT_RECAPTCHA_INFO1', 'Ein Recaptcha ist eine spezielle Art von <a href="https://de.wikipedia.com/wiki/Captcha">Captcha</a>. Im einfachsten Fall muss der Benutzer nur einen Haken setzen; ansonsten m�ssen verschiedene Bilderr�tsel gel�st werden. Weitere Informationen finden Sie unter <a href="https://www.google.com/recaptcha/">https://www.google.com/recaptcha/</a>.<br/>Bitte beachten Sie, wenn sie Recaptcha nutzen wollen, dass Sie sich bei der genannten Webseite registrieren m�ssen. Einen Schl�ssel k�nnen Sie <a href="https://www.google.com/recaptcha/admin');
@define('PLUGIN_EVENT_RECAPTCHA_INFO2', '">hier</a> anfordern. <br/> Bitte beachten Sie auch, dass dieses Plugin jedes Mal Anfragen an den reCAPTCHA Server sendet. Dies kann den Ladevorgang der Artikel verlangsamen. Wenn ein Timeout auftritt, wird kein Recaptcha angezeigt.');

