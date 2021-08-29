<?php

@define('PLUGIN_USERPROFILES_NAME', "Serendipity Autoren");
@define('PLUGIN_USERPROFILES_NAME_DESC', "Zeigt eine Liste aller Autoren");
@define('PLUGIN_USERPROFILES_TITLE', "Titel");
@define('PLUGIN_USERPROFILES_TITLE_DESC', "Den Titel der Seitenleiste eintragen:");
@define('PLUGIN_USERPROFILES_TITLE_DEFAULT', "Autoren");

@define('PLUGIN_EVENT_USERPROFILES_CITY', 'Stadt');
@define('PLUGIN_EVENT_USERPROFILES_COUNTRY', 'Land');
@define('PLUGIN_EVENT_USERPROFILES_URL', 'Homepage');
@define('PLUGIN_EVENT_USERPROFILES_OCCUPATION', 'Besch�ftigung');
@define('PLUGIN_EVENT_USERPROFILES_HOBBIES', 'Hobbies');
@define('PLUGIN_EVENT_USERPROFILES_YAHOO', 'Yahoo');
@define('PLUGIN_EVENT_USERPROFILES_AIM', 'AIM');
@define('PLUGIN_EVENT_USERPROFILES_JABBER', 'Jabber');
@define('PLUGIN_EVENT_USERPROFILES_ICQ', 'ICQ');
@define('PLUGIN_EVENT_USERPROFILES_MSN', 'MSN');

@define('PLUGIN_EVENT_USERPROFILES_SHOWEMAIL', 'E-Mail-Adresse anzeigen');
@define('PLUGIN_EVENT_USERPROFILES_SHOWCITY', 'Stadt anzeigen');
@define('PLUGIN_EVENT_USERPROFILES_SHOWCOUNTRY', 'Land anzeigen');
@define('PLUGIN_EVENT_USERPROFILES_SHOWURL', 'Homepage anzeigen');
@define('PLUGIN_EVENT_USERPROFILES_SHOWOCCUPATION', 'Besch�ftigung anzeigen');
@define('PLUGIN_EVENT_USERPROFILES_SHOWHOBBIES', 'Hobbys anzeigen');
@define('PLUGIN_EVENT_USERPROFILES_SHOWYAHOO', 'Yahoo anzeigen');
@define('PLUGIN_EVENT_USERPROFILES_SHOWAIM', 'AIM anzeigen');
@define('PLUGIN_EVENT_USERPROFILES_SHOWJABBER', 'Jabber anzeigen');
@define('PLUGIN_EVENT_USERPROFILES_SHOWICQ', 'ICQ anzeigen');
@define('PLUGIN_EVENT_USERPROFILES_SHOWMSN', 'MSN anzeigen');

@define('PLUGIN_EVENT_USERPROFILES_SHOW', 'Benutzerprofil des gew�hlten Autoren:');
@define('PLUGIN_EVENT_USERPROFILES_TITLE', 'Benutzerprofile');
@define('PLUGIN_EVENT_USERPROFILES_DESC', 'Zeigt einfache Benutzerprofile');

@define('PLUGIN_EVENT_AUTHORPIC_EXTENSION', 'Dateiendung');
@define('PLUGIN_EVENT_AUTHORPIC_EXTENSION_BLAHBLAH', 'Welche Dateiendung haben die Bilder der Autoren?');
@define('PLUGIN_EVENT_AUTHORPIC_ENABLED', 'Bild des Autoren im Eintrag zeigen?');
@define('PLUGIN_EVENT_AUTHORPIC_ENABLED_DESC', 'Falls aktiviert wird ein Bild des Autoren in jedem Eintrag eingebunden um optisch darzustellen wer den Eintrag erstellt hat. Das Bild muss im Ordner "img" vom jeweiligen Templateordner liegen und so hei�en, wie der Autorname. Alle Sonderzeichen (Umlaute, Leerzeichen, ...) m�ssen dabei durch ein "_" im Dateinamen ersetzt werden.');

@define('PLUGIN_EVENT_AUTHORPIC_COMMENTCOUNT', 'Anzahl der Kommentare zeigen?');
@define('PLUGIN_EVENT_AUTHORPIC_COMMENTCOUNT_BLAHBLAH', 'Soll die Anzahl der Kommentare, die ein Besucher gemacht hat, dargestellt werden? Dies kann entweder deaktiviert werden, die Anzahl kann vor oder nach dem Kommentartext platziert werden, oder mittels Smarty Template comments.tpl manuell platziert werden indem {$comment.plugin_commentcount} an die gew�nschte Stelle gesetzt wird. Das Aussehen dieses Blocks kann mittels der .serendipity_commentcount CSS Klasse ver�ndert werden.');
@define('PLUGIN_EVENT_AUTHORPIC_COMMENTCOUNT_APPEND', 'An Kommentartext anh�ngen');
@define('PLUGIN_EVENT_AUTHORPIC_COMMENTCOUNT_PREPEND', 'Vor Kommentartext setzen');
@define('PLUGIN_EVENT_AUTHORPIC_COMMENTCOUNT_SMARTY', 'Eigenes Smarty Template');

@define('PLUGIN_USERPROFILES_BIRTHDAYIN', 'Geburtstag in %d Tagen');
@define('PLUGIN_USERPROFILES_BIRTHDAYTODAY', 'Geburtstag heute');

@define('PLUGIN_EVENT_USERPROFILES_SHOWSTREET', 'Stra�e anzeigen');
@define('PLUGIN_EVENT_USERPROFILES_SHOWSKYPE', 'Skype anzeigen');
@define('PLUGIN_EVENT_USERPROFILES_SELECT', 'Benutzerprofil zum Bearbeiten ausw�hlen.');
@define('PLUGIN_EVENT_USERPROFILES_BIRTHDAY', 'Geburtstag');
@define('PLUGIN_EVENT_USERPROFILES_VCARD', 'VCard-Datei erstellen');
@define('PLUGIN_EVENT_USERPROFILES_STREET', 'Stra�e');

@define('PLUGIN_EVENT_USERPROFILES_VCARDCREATED_AT', 'VCard-Datei um %s erstellt');
@define('PLUGIN_EVENT_USERPROFILES_VCARDCREATED_NOTE', 'Die VCard-Datei wurde in der Mediendatenbank gespeichert.');
@define('PLUGIN_EVENT_USERPROFILES_VCARDNOTCREATED', 'Konnte VCard-Datei nicht erstellen. Haben Sie bereits etwas eingetragen und gespeichert?');
@define('PLUGIN_USERPROFILES_BIRTHDAYNUMBERS', 'Anzahl der Geburtstagskinder');
@define('PLUGIN_USERPROFILES_BIRTHDAYSNAME', 'Geburtstage von Redakteuren');
@define('PLUGIN_USERPROFILES_BIRTHDAYTITLE', 'Geburtstage');
@define('PLUGIN_USERPROFILES_BIRTHDAYTITLE_DESCRIPTION', 'Anzeigen, wann der Benutzer den n�chsten Geburtstag hat.');

@define('PLUGIN_USERPROFILES_GRAVATAR', 'Gravatar-Bild bevorzugen?');
@define('PLUGIN_USERPROFILES_GRAVATAR_DEFAULT', 'Speicherort der Standard-Bilddatei');
@define('PLUGIN_USERPROFILES_GRAVATAR_DEFAULT_DESC', 'Gibt den Speicherort der Bilddatei an, wenn kein Gravatar vorhanden ist.');
@define('PLUGIN_USERPROFILES_GRAVATAR_DESC', 'Bindet ein Gravatar-Bild ein, dass mit der E-Mail-Adresse verbunden ist. Registrierung bei www.gravatar.com');
@define('PLUGIN_USERPROFILES_GRAVATAR_RATING', 'Einschr�nkung der Gravatare');
@define('PLUGIN_USERPROFILES_GRAVATAR_RATING_DESC','Hier k�nnen Sie Gravatare einschr�nken, damit nur Bilder mit gewissen Jugendschutz-Kriterien angezeigt werden (US-Wertungsstufen): G, PG, R oder X.');
@define('PLUGIN_USERPROFILES_GRAVATAR_SIZE', 'Gr��e des Gravatar-Bildes');
@define('PLUGIN_USERPROFILES_GRAVATAR_SIZE_DESC', 'Bestimmt die Bildgr��e des Gravatars (quadratische Gr��e, maximal 80).');
@define('PLUGIN_USERPROFILES_SHOWAUTHORS', 'Zeige Benutzerliste');
@define('PLUGIN_USERPROFILES_SHOWAUTHORS_DESC', 'Als Link zu den jeweiligen Blogeintr�gen der Autoren');
@define('PLUGIN_USERPROFILES_SHOWGROUPS', 'Link zu Benutzergruppen anzeigen');
@define('PLUGIN_USERPROFILES_SHOWGROUPS_DESC', 'Achtung: Dies zeigt alle Benutzergruppen mit allen freigegebenen Benutzerprofilen (und mehr, s.u.).');

@define('PLUGIN_USERPROFILES_SHOWWARNING', 'Ist dies wirklich ein geschlossenes Blog nur f�r Benutzergruppen? Beide Anzeigen, insbesondere aber die Benutzergruppen, geben Informationen Preis, die eigentlich nicht gerne geteilt werden, sei es aus Sicherheitserw�gungen oder aus pers�nlichen Gr�nden; und das weder ganz �ffentlich noch f�r eine gr��ere, aber geschlosssene Gruppe; dies sind zB. Loginnamen oder auch die Email Adresse. Ebenso werden alle vorhandenen Gruppen aufgef�hrt mit allen darin befindlichen Autoren/Benutzern. Bitte �berlegen Sie gut ob sie dieses Plugin wirklich verwenden wollen! Die Anzeigen des Event Plugins im Backend wurden aufgrund dieser Tatsache per Benutzerlevel entsch�rft; dies ist f�r dieses Frontend Plugin aber nicht so ohne Weiteres m�glich!<br>Beide radio Optionen beeinflussen nicht die Anzeige der Profilbox des Authors durch das event Plugins, mit ihren freigegebenen Benutzerprofildaten (soweit vorhanden) im Eintrags-Kopf.');


