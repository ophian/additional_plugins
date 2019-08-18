<?php

/**
 *  @version
 *  @author Thomas Hochstein <thh@inter.net>
 */

@define('PLUGIN_HTTPAUTH_NAME', 'HTTP-Authentifizierung');
@define('PLUGIN_HTTPAUTH_BLAHBLAH', 'Authentifiziert Benutzer �ber HTTP-Authentifizierung (basic_auth) mit ihren s9y-Anmeldedaten.');

@define('PLUGIN_HTTPAUTH_REMOTEUSER', 'REMOTE_USER-Authentifizierung zulassen?');
@define('PLUGIN_HTTPAUTH_REMOTEUSER_DESC', 'Wenn "JA" k�nnen Benutzer �ber IIS/Apache-Bordmittel authentifiziert werden. Diese speichern eine zentrale Servervariable REMOTE_USER mit dem Namen Ihres authentifizierten Benutzers, und Serendipity kann dann mit diesem Benutzernamen zur Anmeldung verwenden. Wenn Sie dies aktivieren, achten Sie darauf, dass Ihr pers�nliches Authentifizierungssystem g�ltige Benutzer sicherstellt, da es die normale Serendipity-Anmeldung umgeht!');
@define('PLUGIN_HTTPAUTH_REMOTEUSER_WILDCARD', 'Standardanmeldung ("Gast") aktivieren?');
@define('PLUGIN_HTTPAUTH_REMOTEUSER_WILDCARD_DESC', 'Diese Einstellung wird nur verwendet, wenn die REMOTE_USER-Authentifizierung aktiviert ist. Wenn diese Einstellung aktiviert ist, wird ein in Ihrer Serendipity-Datenbank nicht vorhandener REMOTE_USER durch einen fest codierten Serendipity-Benutzer ersetzt. Dies bedeutet, dass ein Benutzer, der sich als "Raymond" anmeldet, f�r den aber kein Serendipity-Benutzer mit diesem Namen vorhanden ist, unter einem zentrales Serendipity-Konto mit dem Namen "Visitor" angemeldet werden kann.');
@define('PLUGIN_HTTPAUTH_REMOTEUSER_AUTHORID', 'Standardanmeldung: Authorid');
@define('PLUGIN_HTTPAUTH_REMOTEUSER_AUTHORID_DESC', 'Die Authorid, unter der ein Standardbenutzer angemeldet wird.');
@define('PLUGIN_HTTPAUTH_REMOTEUSER_USERLEVEL', 'Standardanmeldung: Userlevel');
@define('PLUGIN_HTTPAUTH_REMOTEUSER_USERLEVEL_DESC', 'Der Userlevel, mit dem ein Standardbenutzer angemeldet wird.');
@define('PLUGIN_HTTPAUTH_FRONTEND', 'Authentifizierung f�r Frontend erforderlich?');
@define('PLUGIN_HTTPAUTH_FRONTEND_DESC', 'Soll bereits f�r das Frontend eine Anmeldung ben�tigt werden? Wenn diese Option aktiviert ist, wird der Zugriff auf das Blog ohne Anmeldung verweigert. Wenn diese Option deaktiviert ist, ist nur im Backend eine Anmeldung erforderlich.');

