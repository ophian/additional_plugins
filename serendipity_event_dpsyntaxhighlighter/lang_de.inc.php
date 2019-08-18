<?php

/**
 *  @version
 *  @author Thomas Hochstein <thh@inter.net>
*/

@define('PLUGIN_EVENT_DPSYNTAXHIGHLIGHTER_NAME', 'Markup: Syntax-Hervorhebung');
@define('PLUGIN_EVENT_DPSYNTAXHIGHLIGHTER_DESC', 'Dieses Plugin ist ein JavaScript-Syntax-Hervorheber, der auf dem gleichnamigen Code von Alex Gorbatchev basiert. '
        .'Es ben�tigt weniger serverseitige Ressourcen als GeSHi und zeigt im eigentlichen HTML-Code weniger Markups an; eine leichtgewichtigere, sauberere Alternative. '
        .'Dieses Plugin ben�tigt das zugeh�rige Theme, um die folgenden Hooks bereitzustellen: frontend_header, frontend_footer (und optional backend_preview im '
        .'Admin-Theme).');
@define('PLUGIN_EVENT_DPSYNTAXHIGHLIGHTER_PATH', 'Pfad zu den Scripts');
@define('PLUGIN_EVENT_DPSYNTAXHIGHLIGHTER_PATH_DESC', 'Geben Sie den vollst�ndigen HTTP-Pfad (alles nach Ihrem Domain-Namen) ein, der zum Verzeichnis dieses Plugins f�hrt. ');
@define('PLUGIN_EVENT_DPSYNTAXHIGHLIGHTER_THEME', 'Theme ausw�hlen');
@define('PLUGIN_EVENT_DPSYNTAXHIGHLIGHTER_THEME_DESC', 'W�hlen Sie ein Theme / einen Stil f�r den Syntax-Hervorheber, der dem Blog am besten entspricht.');
@define('PLUGIN_EVENT_DPSYNTAXHIGHLIGHTER_TOOLBAR', 'Symbolleiste anzeigen?');
@define('PLUGIN_EVENT_DPSYNTAXHIGHLIGHTER_TOOLBAR_DESC', 'Zeigt die Fragezeichen-Schaltfl�che mit dem Info-Dialog an.');
@define('PLUGIN_EVENT_DPSYNTAXHIGHLIGHTER_AUTOLINS', 'URLs klickbar machen?');
@define('PLUGIN_EVENT_DPSYNTAXHIGHLIGHTER_AUTOLINKS_DESC', 'Aktiviert/deaktiviert die Erkennung von Links im hervorgehobenen Element. Wenn die Option deaktiviert ist, k�nnen URLs nicht angeklickt werden.');
@define('PLUGIN_EVENT_DPSYNTAXHIGHLIGHTER_CLASSNAME', 'Benutzerdefinierte CSS-Klassen hinzuf�gen');
@define('PLUGIN_EVENT_DPSYNTAXHIGHLIGHTER_CLASSNAME_DESC', 'Erm�glicht das Hinzuf�gen einer benutzerdefinierten Klasse (oder mehrerer Klassen) zu jedem hervorgehobenen Element, das auf der Seite angezeigt wird.');
@define('PLUGIN_EVENT_DPSYNTAXHIGHLIGHTER_COLLAPSE', 'Hervorgehobene Codeausschnitte einklappen?');
@define('PLUGIN_EVENT_DPSYNTAXHIGHLIGHTER_COLLAPSE_DESC', 'Erm�glicht es Ihnen, hervorgehobene Elemente standardm���g einzuklappen. In diesem Fall muss die Symbolleiste angezeigt werden, andernfalls wird kein Code-Ausschnitt zu sehen sein.');
@define('PLUGIN_EVENT_DPSYNTAXHIGHLIGHTER_GUTTER', 'Zeilennummern anzeigen?');
@define('PLUGIN_EVENT_DPSYNTAXHIGHLIGHTER_GUTTER_DESC', 'Erm�glicht das Ein- und Ausschalten der Zeilennummern.');
@define('PLUGIN_EVENT_DPSYNTAXHIGHLIGHTER_SMARTTABS', 'Smart tabs?');
@define('PLUGIN_EVENT_DPSYNTAXHIGHLIGHTER_SMARTTABS_DESC', 'Aktiviert/deaktiviert Smart Tabs.');
@define('PLUGIN_EVENT_DPSYNTAXHIGHLIGHTER_TABSIZE', 'Gr��e der Smart Tabs');
@define('PLUGIN_EVENT_DPSYNTAXHIGHLIGHTER_TABSIZE_DESC', 'Hier k�nnen Sie die Gr��e der Registerkarten anpassen.');
@define('PLUGIN_EVENT_DPSYNTAXHIGHLIGHTER_STRIPBRS', '<br> Tags ignorieren?');
@define('PLUGIN_EVENT_DPSYNTAXHIGHLIGHTER_STRIPBRS_DESC', 'Wenn Ihre Software am Ende jeder Zeile <br />-Tags hinzuf�gt, k�nnen Sie diese ignorieren.');

