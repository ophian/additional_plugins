<?php

@define('PLUGIN_EVENT_EXTERNALAUTH_TITLE', 'Externe Benutzer-Authentifizierung (LDAP) [EXPERIMENTAL]');
@define('PLUGIN_EVENT_EXTERNALAUTH_DESC', 'Erm�glicht die externe authentifizierung f�r Logins der Benutzer. Die Zugangsdaten werden im lokalen Serendipity Datenbank-Framework gecached.');
@define('PLUGIN_EVENT_EXTERNALAUTH_SOURCE', 'Authentifizierungs-Quelle');
@define('PLUGIN_EVENT_EXTERNALAUTH_SOURCE_DESC', 'W�hlen Sie die Quelle der externen Zugangsdaten');
@define('PLUGIN_EVENT_EXTERNALAUTH_USERLEVEL', 'Standard Benutzerlevel');
@define('PLUGIN_EVENT_EXTERNALAUTH_USERLEVEL_DESC', 'W�hlen Sie den Standard-Benutzerlevel f�r einen neu hinzugef�gten externen Benutzer');
@define('PLUGIN_EVENT_EXTERNALAUTH_USERLEVEL_ATTR', 'Benutzerlevel Attribut');
@define('PLUGIN_EVENT_EXTERNALAUTH_USERLEVEL_ATTR_DESC', 'Welches Attribut enth�lt die Angabe des Benutzerlevel f�r einen neu synchronisierten Benutzer?');
@define('PLUGIN_EVENT_EXTERNALAUTH_HOST', 'Ziel-Host');
@define('PLUGIN_EVENT_EXTERNALAUTH_HOST_DESC', 'Auf welchem Server befindet sich die Authentifizierungsquelle');
@define('PLUGIN_EVENT_EXTERNALAUTH_PORT', 'Ziel-Port');
@define('PLUGIN_EVENT_EXTERNALAUTH_PORT_DESC', 'Verbindungs-Port der Authentifizierungsquelle. Ein leerer Wert nutzt den Standardport.');
@define('PLUGIN_EVENT_EXTERNALAUTH_RDN', 'Authentifizierungsstring');
@define('PLUGIN_EVENT_EXTERNALAUTH_RDN_DESC', 'String f�r die Authentifizierung. %1 wird durch den Benutzernamen, %2 durch das Passwort und %3 durch das MD5-kodierte Passwort ersetzt');
@define('PLUGIN_EVENT_EXTERNALAUTH_FIRSTLOGIN', 'Externe Authentifizierung nur einmalig durchf�hren');
@define('PLUGIN_EVENT_EXTERNALAUTH_FIRSTLOGIN_DESC', 'Soll die externe Authentifizierung nur einmal pro Session ausgef�hrt werden, oder bei jeder Anfrage? JA wird die Geschwindigkeit erh�hen, NEIN die Sicherheit.');

@define('PLUGIN_EVENT_EXTERNALAUTH_USERLEVEL_CHIEF', 'Chefredakteur');
@define('PLUGIN_EVENT_EXTERNALAUTH_USERLEVEL_EDITOR', 'Editor');
@define('PLUGIN_EVENT_EXTERNALAUTH_USERLEVEL_ADMIN', 'Administrator');
@define('PLUGIN_EVENT_EXTERNALAUTH_USERLEVEL_DENY', 'Zugriff verbieten');

