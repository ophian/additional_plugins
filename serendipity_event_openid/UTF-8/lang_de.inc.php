<?php 

@define('PLUGIN_OPENID_NAME',     'OpenID Authentifizierung');
@define('PLUGIN_OPENID_DESC',     'Ermöglicht es Autoren des Blogs, sich mit ihrer OpenID (oder Google/Yahoo Account) einzuloggen.');

@define('PLUGIN_OPENID_EXISTS', 'Du bist bereits mit OpenID registriert.');
@define('PLUGIN_OPENID_WRONG_ACTIVATION', 'Ungültige Aktivierungs URL!');

@define('PLUGIN_EVENT_OPENID_SELECT', 'Mit diesem Benutzer verknüpfte OpenID URL');

@define('PLUGIN_OPENID_DESCRIPTION', 
'<h3>OpenID benutzen, um in Dein Blog einzuloggen</h3>' .
'<p>Das Plugin benötigt keinerlei Konfiguration, um ein OpenID Login zu implementieren (OpenID konfiguriert sich selbstständig)</p>' .
'<p>Aber Benutzer, die OpenID als Login verwenden wollen, müssen einmal angeben, welche OpenID URL sie identifizieren soll. ' . 
'Wenn Du also OpenID als Login Option benutzen möchtest, gehe zu Deiner <a href="serendipity_admin.php?serendipity[adminModule]=personal">Profilseite in Serendipity</a> und konfiguriere Deine OpenID URL (im unteren Bereich der Seite).</p>' .
'<p>Hier findest Du auch Knöpfe für <b>Google</b>, <b>Yahoo</b> und <b>Aol</b> Accounts. Diese Services sind ebenfalls OpenID Provider und die Knöpfe helfen Dir beim Setup der Verbindung.<br/>' .
'Es kann jedoch immer <b>nur eine OpenID Verbindung pro Benutzer</b> aktiviert werden.</p>'
);

@define('PLUGIN_OPENID_DELEGATION_DESCRIPTION', 
'<h3>Einstellungen für eine OpenID Delegation (Optional)</h3>' .
'<p>Wenn Du Deine Blog URL als Open ID URL benutzen möchtest, kannst Du hier eine Delegation von Deinem Blog zu Deinem eigentlichen OpenID Provider einrichten.<br/>' .
'Das Plugin wird damit dann Informationen in dem HTML Deines Blogs hinterlassen, die die Services darüber informieren, wo Deine OpenID gehostet wird.</p>' .
'<p>Das Aufsetzen der Delegation ist völlig optional und wird nicht für ein Login in Dein Blog mittels OpenID benötigt.</p>'
);

@define('PLUGIN_OPENID_LOGIN_USERS', 'Login mit Benutzer Auswahl');
@define('PLUGIN_OPENID_LOGIN_USERS_DESC', 
'Nachdem Autoren dieses Blogs ihre OpenID URL konfiguriert haben, können sie im Login ihren Namen auswählen und einfach einloggen.
Dies ist eine sehr bequeme Art des Logins, aber sie zeigt anderen die Autorennamen dieses Blogs.
Das sollte normaler Weise kein Problem sein, da diese ja auch in der Artikel Ansicht angezeigt werden.
Wenn Du das aber nicht magst, kannst Du diese Auswahl ausschalten. Dann wird beim Login eine normale Eingabe für die OpenID URL ausgegeben.');

@define('PLUGIN_OPENID_SERVER', 'OpenID Server');
@define('PLUGIN_OPENID_SERVER_DESC', 'OpenID Server, der Deine OpenID hostet (benötigt einen Eintrag in "OpenID Delegation")');

@define('PLUGIN_OPENID_DELEGATE', 'Deine OpenID Delegation');
@define('PLUGIN_OPENID_DELEGATE_DESC', 'OpenID Delegation (benötigt einen Eintrag in "OpenID Server")');

@define('PLUGIN_OPENID_XRDS_LOC', 'OpenID XRDS Location');
@define('PLUGIN_OPENID_XRDS_LOC_DESC', 'URL des XRDS Dokumentes (wird meist nicht benötigt)');

@define('PLUGIN_OPENID_VERSION_SUPPORTED', 'OpenID Version');
@define('PLUGIN_OPENID_VERSION_SUPPORTED_DESC', 'Die OpenID Version, die Dein Provider unterstützt. Normaler Weise ist "Beide" die richtige Einstellung, aber wenn Du weißt, dass Dein Provider nur Version 1 oder nur Version 2 unterstützt, dann kannst Du das hier einstellen..');
@define('PLUGIN_OPENID_VERSION_SUPPORTED_V1', 'Nur OpenID Version 1');
@define('PLUGIN_OPENID_VERSION_SUPPORTED_V2', 'Nur OpenID Version 2');
@define('PLUGIN_OPENID_VERSION_SUPPORTED_BOTH', 'Beide OpenID Versionen');

@define('PLUGIN_OPENID_LOGIN_INPUT', 'Melde Dich mit Deiner OpenID an.');

@define('PLUGIN_OPENID_UPDATE_SUCCESS', 'Deine OpenID wurde erneuert.');
@define('PLUGIN_OPENID_UPDATE_FAIL', 'Es trat ein Fehler beim Update Deiner OpenID auf.');
@define('PLUGIN_OPENID_INVALID_RESPONSE', 'Ungültige OpenID eingegeben');

@define('PLUGIN_OPENID_LOGIN_WITH_GOOGLE', 'Mit Deinem Google Account einloggen');
@define('PLUGIN_OPENID_SET_GOOGLE_OID', 'Deinen Google Account als OpenID setzen');
@define('PLUGIN_OPENID_LOGIN_WITH_YAHOO', 'Mit Deinem Yahoo Account einloggen');
@define('PLUGIN_OPENID_SET_YAHOO_OID', 'Deinen Yahoo Account als OpenID setzen');
@define('PLUGIN_OPENID_LOGIN_WITH_AOL', 'Mit Deinem Aol Account einloggen');
@define('PLUGIN_OPENID_SET_AOL_OID', 'Deinen Aol Account als OpenID setzen');


@define('PLUGIN_OPENID_LOGIN_NOOPENID', 'Im Moment gibt es keinen Benutzer mit konfigurierter OpenID URL.<br/>
Wenn Du Dich mit Deiner OpenID anmelden möchtest, dann konfiguriere sie bitte zuerst in den "Eigenen Einstellungen"..<br/>Danke.');
