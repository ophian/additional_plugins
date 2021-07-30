<?php

@define('PLUGIN_ADDUSER_NAME', 'Registrierung neuer User');
@define('PLUGIN_ADDUSER_DESC', 'Erm�glicht es Blog-Besuchern sich einen eigenen Autoren-Account anzulegen. Zusammen mit dem Event-Plugin kann �ber (index.php?serendipity[subpage]=adduser) eingestellt werden ob nur registrierte Benutzer Kommentare posten d�rfen.');
@define('PLUGIN_ADDUSER_INSTRUCTIONS', 'Eigene Hinweise');
@define('PLUGIN_ADDUSER_INSTRUCTIONS_DESC', 'Geben Sie etwaige Zusatzhinweise an, die im Formular erscheinen sollen');
@define('PLUGIN_ADDUSER_INSTRUCTIONS_DEFAULT', 'Hier k�nnen Sie sich f�r dieses Blog als Autor anmelden. Einfach Daten eingeben, Formular abschicken und alles weitere per E-Mail erhalten.');
@define('PLUGIN_ADDUSER_USERLEVEL', 'Standard Benutzerlevel');
@define('PLUGIN_ADDUSER_USERLEVEL_DESC', 'W�hlen Sie den Standard-Benutzerlevel f�r einen neu hinzugef�gten Benutzer');
@define('PLUGIN_ADDUSER_USERLEVEL_CHIEF', 'Chefredakteur');
@define('PLUGIN_ADDUSER_USERLEVEL_EDITOR', 'Editor');
@define('PLUGIN_ADDUSER_USERLEVEL_ADMIN', 'Administrator');
@define('PLUGIN_ADDUSER_USERLEVEL_DENY', 'Zugriff verbieten');
@define('PLUGIN_SIDEBAR_LOGIN', 'Seitenleisten-Plugin anzeigen?');
@define('PLUGIN_SIDEBAR_LOGIN_DESC', 'Wenn aktiviert wird eine Loginbox in der Seitenleiste angezeigt. Wenn diese Option deaktiviert wird, erscheint die Seitenleisten-Box nicht, und neue User k�nnen sich nur mittels des zugeh�rigen Event-Plugins und dessen Extra-Unterseite anmelden.');

@define('PLUGIN_ADDUSER_EXISTS', 'Sorry, der Username "%s" ist bereits vergeben. Bitte w�hlen Sie einen anderen Namen.');
@define('PLUGIN_ADDUSER_MISSING', 'Sie m�ssen alle Felder ausf�llen, um einen Account zu beantragen.');
@define('PLUGIN_ADDUSER_SENTMAIL', 'Ihr Account wurde erstellt. Sie haben gerade eine E-Mail mit weiteren Informationen erhalten.');
@define('PLUGIN_ADDUSER_WRONG_ACTIVATION', 'Ung�ltiger Aktivierungslink!');

@define('PLUGIN_ADDUSER_MAIL_SUBJECT', 'Ein neuer Autor hat sich registriert');
@define('PLUGIN_ADDUSER_MAIL_BODY', "F�r den Autoren %s wurde f�r das Blog %s ein Account eingerichtet. Um den Account zu aktivieren, bitte auf diesen Link klicken:\n\n%s\n\nErst nach diesem Vorgang ist der Login mit dem �bermitteltem Passwort m�glich. Diese Informations-E-Mail wurde sowohl an den Eigent�mer des Blogs wie an den neuen Autoren geschickt.");
@define('PLUGIN_ADDUSER_SUCCEED', 'Der Account wurde erfolgreich aktiviert. Sie k�nnen Sich nun in die Administrationsoberfl�che einloggen, der Link dazu befindet sich in ihrer Aktivierungs-E-Mail.');
@define('PLUGIN_ADDUSER_FAILED', 'Der Account konnte nicht freigeschaltet werden. Vielleicht haben Sie die URL aus ihrer Aktivierungs-E-Mail nicht korrekt kopiert?');

@define('PLUGIN_ADDUSER_REGISTERED_ONLY', 'Nur registrierte Nutzer d�rfen Kommentare schicken');
@define('PLUGIN_ADDUSER_REGISTERED_ONLY_DESC', 'Wenn diese Option aktiviert ist, d�rfen nur registrierte Nutzer die Eintr�ge kommentieren und m�ssen dazu angemeldet sein.');
@define('PLUGIN_ADDUSER_REGISTERED_ONLY_REASON', 'Nur registrierte Benutzer d�rfen Eintr�ge kommentieren. Erstellen Sie sich einen eigenen Account <a href="%s">hier</a> und <a href="%s">loggen Sie sich danach ein</a>. Ihr Browser muss Cookies unterst�tzen.');

@define('PLUGIN_ADDUSER_STRAIGHT', 'Direkter Eintrag?');
@define('PLUGIN_ADDUSER_STRAIGHT_DESC', 'Wenn diese Option aktiviert ist, wird der neue User unverz�glich als valider Co-Autor eingetragen. Dies ist nur in Setups zu empfehlen, die keinen Mailserver zur Verf�gung haben; ansonsten kann diese Option als Einfallstor von Spammern ausgenutzt werden. Nur genehmigen, wenn Sie genau wissen was sie tun!');

@define('PLUGIN_ADDUSER_REGISTERED_CHECK', 'Autoren-Identit�ten sch�tzen');
@define('PLUGIN_ADDUSER_REGISTERED_CHECK_DESC', 'Wenn aktiviert, k�nnen die Namen der registrierten Autoren nicht von G�sten benutzt werden.');
@define('PLUGIN_ADDUSER_REGISTERED_CHECK_REASON', 'Der angegebene Benutzername wird bereits von einem Autoren dieses Blogs verwendet. Bitte <a href="%s" %s>loggen Sie sich ein</a> um das Kommentar abzuschicken oder benutzen einen anderen Benutzernamen.');

@define('PLUGIN_ADDUSER_ADMINAPPROVE', 'Best�tigung der Registrierung durch Administrator?');
@define('PLUGIN_ADDUSER_ADMINAPPROVE_DESC', 'Falls aktiviert m�ssen Administratoren einen neu registrierten Redakteur erst best�tigen, bevor sich diese einloggen k�nnen.');
@define('PLUGIN_ADDUSER_SENTMAIL_APPROVE', 'Ihr Account wurde erstellt. Sie werden eine E-Mail mit weiteren Informationen erhalten, sobald ein Administrator ihren Antrag best�tigt hat.');
@define('PLUGIN_ADDUSER_SENTMAIL_APPROVE_ADMIN', 'Der Account wurde akzeptiert, der entsprechende Redakteur wird nun seine E-Mail mit Zugangsdaten erhalten.');
@define('PLUGIN_ADDUSER_MAIL_SUBJECT_APPROVE', '[Bewilligung notwendig] Ein neuer Autor hat sich registriert');
@define('PLUGIN_ADDUSER_MAIL_BODY_APPROVE', "F�r den Autoren %s wurde f�r das Blog %s ein Account eingerichtet. Um dem Redakteur den Login zu erlauben, bitte auf diesen Link klicken:\n\n%s\n\nErst nach diesem Vorgang wird der Redakteur seine Zugangsdaten per E-Mail erhalten.");

@define('PLUGIN_ADDUSER_CAPTCHA', 'Benutze Captchas?');
@define('PLUGIN_ADDUSER_CAPTCHA_DESC', 'Ben�tigt installiertes spamblock event Plugin.');

@define('PLUGIN_ADDUSER_ANTISPAM', 'Sie haben die Anti-Spam-Tests nicht bestanden. Bitte �berpr�fen Sie, ob Sie den CAPTCHA korrekt eingegeben haben.');

@define('PLUGIN_ADDUSER_REGISTERED_ONLY_GROUP', 'Zus�tzlich: Nur registrierte Benutzer in diesen Autorengruppen k�nnen Kommentare schreiben?');
@define('PLUGIN_ADDUSER_REGISTERED_ONLY_GROUP_DESC', 'Sie m�ssen auch die Option "Nur registrierte Nutzer d�rfen Kommentare schicken" benutzen, um dies zu aktivieren. Wenn diese Option aktiviert ist, k�nnen nur registrierte Benutzer bestimmter Autorengruppen Kommentare zu Ihren Eintr�gen posten und m�ssen dazu angemeldet sein.');

@define('PLUGIN_ADDUSER_DEFAULTSETTINGS', 'Hier k�nnen Standard-Einstellungen f�r den neuen Autoren festgelegt werden.');

