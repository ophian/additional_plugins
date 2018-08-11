<?php

/**
 *  @version
 *  @author Translator Name <yourmail@example.com>
 *  EN-Revision: Revision of lang_en.inc.php
 */

@define('PLUGIN_EVENT_OEMBED_NAME', 'oEmbed Plugin');
@define('PLUGIN_EVENT_OEMBED_DESC', 'oEmbed ist ein Format f�r die eingebettete Darstellung einer URL in Ihrem Blog. Es erlaubt Blog-Artikeln, eingebettete Inhalte (wie Tweets, Fotos oder Videos) anzuzeigen, wenn ein Benutzer einen Link zu dieser Ressource ver�ffentlicht, ohne die Ressource direkt analysieren zu m�ssen.');

@define('PLUGIN_EVENT_OEMBED_MAXWIDTH', 'Maximale Breite der Ersetzungen');
@define('PLUGIN_EVENT_OEMBED_MAXWIDTH_DESC', 'Dies ist die maximale Breite, die der Dienst bei der Bereitstellung eines Ersatzes erzeugen soll. Nicht alle Dienste unterst�tzen dies, aber die meisten.');
@define('PLUGIN_EVENT_OEMBED_MAXHEIGHT', 'Maximale H�he der Ersetzungen');
@define('PLUGIN_EVENT_OEMBED_MAXHEIGHT_DESC', 'Dies ist die maximale H�he, die der Dienst bei der Bereitstellung eines Ersatzes erzeugen sollte. Nicht alle Dienste unterst�tzen dies, aber die meisten.');

@define('PLUGIN_EVENT_OEMBED_GENERIC_SERVICE', 'Generic oEmbed provider');
@define('PLUGIN_EVENT_OEMBED_GENERIC_SERVICE_DESC', 'Wenn das Plugin eine URL nicht aufl�sen kann, weil sie noch unbekannt ist, k�nnen Sie sie auf einen "generischen Provider" zur�ckgreifen lassen. Diese Dienste implementieren oEmbed f�r eine gro�e Anzahl von Diensten, die nicht oEmbed haben. Sie haben zwei M�glichkeiten: oohembed.com, ein fr�herer kostenloser Dienst, der von embedly gekauft wurde und jetzt nur noch mit sehr begrenzten API-Schnittstellen frei zug�nglich ist. "embed.ly" ist ein sehr gut gepflegter Service f�r viele oEmbed-Dienste (siehe http://embed.ly/providers), ben�tigt aber einen API-Schl�ssel.');
@define('PLUGIN_EVENT_OEMBED_SERVICE_NONE', 'Kein generischer Anbieter');
@define('PLUGIN_EVENT_OEMBED_SERVICE_OOHEMBED', 'oohembed (frei aber begrenzt)');
@define('PLUGIN_EVENT_OEMBED_SERVICE_EMBEDLY', 'embed.ly (apikey erforderlich)');
@define('PLUGIN_EVENT_OEMBED_EMBEDLY_APIKEY', 'embed.ly API-Schl�ssel');
@define('PLUGIN_EVENT_OEMBED_EMBEDLY_APIKEY_DESC', 'embed.ly ben�tigt einen API-Schl�ssel. Der kostenlose Account erlaubt augenblicklich 10k Anrufe pro Monat, was auch f�r stark genutzte Blogs ausreichen sollte, da die Ergebnisse lokal zwischengespeichert und nur einmal pro URL geholt werden. Sie k�nnen sich f�r Ihr kostenloses Konto unter http://app.embed.ly/pricing/free registrieren.');

@define('PLUGIN_EVENT_OEMBED_INFO', '<h3>oEmbed Plugin</h3>' .
'<p>'.
'Dieses Plugin erweitert URLs auf Seiten bekannter Dienste zu einer Darstellung dieser URL. Es zeigt z.B. das Video f�r eine Youtube-URL oder das Bild anstelle einer flickr-URL.<br />' .
'Die Syntax dieses Plugins ist <b>[embed <i>link</i>]</b> (oder <b>[e <i>link</i>]</b> wenn Sie es k�rzer m�gen).<br />'.
'Wenn der Link im Moment vom Plugin nicht unterst�tzt wird, ersetzt er die URL durch einen Link, der auf diese URL zeigt.<br />'.
'</p><p>'.
'Bitte setzen Sie dieses Plugin an den Anfang Ihrer Plugin-Liste, damit kein anderes Plugin diese Syntax �ndern kann (durch Hinzuf�gen eines href z.B.)'.
'</p>');

@define('PLUGIN_EVENT_OEMBED_SUPPORTED', '<p>'.
'Das Plugin unterst�tzt Darstellungen der folgenden Link-Typen ohne die Notwendigkeit des generischen Fallback:%s'.
'</p>');

@define('PLUGIN_EVENT_OEMBED_PLAYER_BOO', 'Audioboo-Player');
@define('PLUGIN_EVENT_OEMBED_PLAYER_BOO_DESC', 'Audioboo unterst�tzt 3 verschiedene Player (siehe http://audioboo.fm/boos/649785-ein-erster-testboo.embed?labs=1). W�hlen Sie den Player, der Ihnen am besten gef�llt.');
@define('PLUGIN_EVENT_OEMBED_PLAYER_BOO_STANDARD', 'standard Player');
@define('PLUGIN_EVENT_OEMBED_PLAYER_BOO_FULLFEATURED', 'voll best�ckt (erfordert JavaScript)');
@define('PLUGIN_EVENT_OEMBED_PLAYER_BOO_WORDPRESS', 'wordpress.com player (ben�tigt Flash)');

