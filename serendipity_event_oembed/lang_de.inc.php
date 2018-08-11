<?php

/**
 *  @version
 *  @author Translator Name <yourmail@example.com>
 *  EN-Revision: Revision of lang_en.inc.php
 */

@define('PLUGIN_EVENT_OEMBED_NAME', 'oEmbed Plugin');
@define('PLUGIN_EVENT_OEMBED_DESC', 'oEmbed ist ein Format für die eingebettete Darstellung einer URL in Ihrem Blog. Es erlaubt Blog-Artikeln, eingebettete Inhalte (wie Tweets, Fotos oder Videos) anzuzeigen, wenn ein Benutzer einen Link zu dieser Ressource veröffentlicht, ohne die Ressource direkt analysieren zu müssen.');

@define('PLUGIN_EVENT_OEMBED_MAXWIDTH', 'Maximale Breite der Ersetzungen');
@define('PLUGIN_EVENT_OEMBED_MAXWIDTH_DESC', 'Dies ist die maximale Breite, die der Dienst bei der Bereitstellung eines Ersatzes erzeugen soll. Nicht alle Dienste unterstützen dies, aber die meisten.');
@define('PLUGIN_EVENT_OEMBED_MAXHEIGHT', 'Maximale Höhe der Ersetzungen');
@define('PLUGIN_EVENT_OEMBED_MAXHEIGHT_DESC', 'Dies ist die maximale Höhe, die der Dienst bei der Bereitstellung eines Ersatzes erzeugen sollte. Nicht alle Dienste unterstützen dies, aber die meisten.');

@define('PLUGIN_EVENT_OEMBED_GENERIC_SERVICE', 'Generic oEmbed provider');
@define('PLUGIN_EVENT_OEMBED_GENERIC_SERVICE_DESC', 'Wenn das Plugin eine URL nicht auflösen kann, weil sie noch unbekannt ist, können Sie sie auf einen "generischen Provider" zurückgreifen lassen. Diese Dienste implementieren oEmbed für eine große Anzahl von Diensten, die nicht oEmbed haben. Sie haben zwei Möglichkeiten: oohembed.com, ein früherer kostenloser Dienst, der von embedly gekauft wurde und jetzt nur noch mit sehr begrenzten API-Schnittstellen frei zugänglich ist. "embed.ly" ist ein sehr gut gepflegter Service für viele oEmbed-Dienste (siehe http://embed.ly/providers), benötigt aber einen API-Schlüssel.');
@define('PLUGIN_EVENT_OEMBED_SERVICE_NONE', 'Kein generischer Anbieter');
@define('PLUGIN_EVENT_OEMBED_SERVICE_OOHEMBED', 'oohembed (frei aber begrenzt)');
@define('PLUGIN_EVENT_OEMBED_SERVICE_EMBEDLY', 'embed.ly (apikey erforderlich)');
@define('PLUGIN_EVENT_OEMBED_EMBEDLY_APIKEY', 'embed.ly API-Schlüssel');
@define('PLUGIN_EVENT_OEMBED_EMBEDLY_APIKEY_DESC', 'embed.ly benötigt einen API-Schlüssel. Der kostenlose Account erlaubt augenblicklich 10k Anrufe pro Monat, was auch für stark genutzte Blogs ausreichen sollte, da die Ergebnisse lokal zwischengespeichert und nur einmal pro URL geholt werden. Sie können sich für Ihr kostenloses Konto unter http://app.embed.ly/pricing/free registrieren.');

@define('PLUGIN_EVENT_OEMBED_INFO', '<h3>oEmbed Plugin</h3>' .
'<p>'.
'Dieses Plugin erweitert URLs auf Seiten bekannter Dienste zu einer Darstellung dieser URL. Es zeigt z.B. das Video für eine Youtube-URL oder das Bild anstelle einer flickr-URL.<br />' .
'Die Syntax dieses Plugins ist <b>[embed <i>link</i>]</b> (oder <b>[e <i>link</i>]</b> wenn Sie es kürzer mögen).<br />'.
'Wenn der Link im Moment vom Plugin nicht unterstützt wird, ersetzt er die URL durch einen Link, der auf diese URL zeigt.<br />'.
'</p><p>'.
'Bitte setzen Sie dieses Plugin an den Anfang Ihrer Plugin-Liste, damit kein anderes Plugin diese Syntax ändern kann (durch Hinzufügen eines href z.B.)'.
'</p>');

@define('PLUGIN_EVENT_OEMBED_SUPPORTED', '<p>'.
'Das Plugin unterstützt Darstellungen der folgenden Link-Typen ohne die Notwendigkeit des generischen Fallback:%s'.
'</p>');

@define('PLUGIN_EVENT_OEMBED_PLAYER_BOO', 'Audioboo-Player');
@define('PLUGIN_EVENT_OEMBED_PLAYER_BOO_DESC', 'Audioboo unterstützt 3 verschiedene Player (siehe http://audioboo.fm/boos/649785-ein-erster-testboo.embed?labs=1). Wählen Sie den Player, der Ihnen am besten gefällt.');
@define('PLUGIN_EVENT_OEMBED_PLAYER_BOO_STANDARD', 'standard Player');
@define('PLUGIN_EVENT_OEMBED_PLAYER_BOO_FULLFEATURED', 'voll bestückt (erfordert JavaScript)');
@define('PLUGIN_EVENT_OEMBED_PLAYER_BOO_WORDPRESS', 'wordpress.com player (benötigt Flash)');

