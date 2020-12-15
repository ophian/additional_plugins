<?php

/**
 *  @version 1.0
 *  @author Konrad Bauckmeier <kontakt@dd4kids.de>
 *  @translated 2009/08/20
 */
@define('PLUGIN_EVENT_RELATEDLINKS_TITLE', 'Verwandte Links/Eintr�ge');
@define('PLUGIN_EVENT_RELATEDLINKS_DESC', 'F�gt verwandte Links/Eintr�ge in die Artikelansicht ein, die manuell f�r jeden Eintrag eingegeben werden k�nnen. F�r flexible Ausgabe kann das Smarty-Template "plugin_relatedlinks.tpl" angepasst werde.');
@define('PLUGIN_EVENT_RELATEDLINKS_ENTERDESC', 'Bitte in der folgenden Maske die verwandten Links eintragen, die sp�ter angezeigt werden sollen. Eine URL pro Zeile (d.h. durch Returns/Zeilenumbr�che getrennt, kein HTML!). Falls Sie ein Beschreibung des Links angeben wollen, bitte folgendes Format benutzen: http://example.com/link.html=Beispiel Beschreibung. Alles nach dem "=" Zeichen wird somit als Beschreibung gewertet. Falls dies nicht getan wird, werden nur URLs als Beschreibung dargestellt.');
@define('PLUGIN_EVENT_RELATEDLINKS_LIST', 'Verwandte Links:');

@define('PLUGIN_EVENT_RELATEDLINKS_POSITION', 'Position der Verwandten Links/Eintr�ge');
@define('PLUGIN_EVENT_RELATEDLINKS_POSITION_DESC', 'Soll die Liste der verwandten Links im Footer, im Eintrag oder via Smarty-Templating eingef�gt werden? Falls Sie Smarty-Templating aktivieren m�ssen Sie folgende Zeile in ihre entries.tpl Datei einbinden, und zwar innerhalb der foreach-Schleife in der $entry gesetzt wird (z.B. bei den Kommentaren, Trackbacks und dem Erweiterten Eintrag): {serendipity_hookPlugin hook="frontend_display_relatedlinks" data=$entry hookAll="true"}{$RELATEDLINKS}');
@define('PLUGIN_EVENT_RELATEDLINKS_POSITION_FOOTER', 'Im Footer des Eintrags');
@define('PLUGIN_EVENT_RELATEDLINKS_POSITION_BODY', 'Im Text des Eintrags');
@define('PLUGIN_EVENT_RELATEDLINKS_POSITION_SMARTY', 'Smarty-Aufruf verwenden');

// Next lines were translated on 2009/08/20
@define('PLUGIN_EVENT_RELATEDLINKS_EXPLODECHAR', 'Trennzeichen f�r Links');
@define('PLUGIN_EVENT_RELATEDLINKS_EXPLODECHAR_DESC', 'Geben Sie das Zeichen ein, womit die URLs von den Beschreibungen getrennt werden. Bitte achten Sie darauf, ein Sonderzeichen zu w�hlen, welches weder in der URL noch in der Beschreibung vorkommt, wie z.B. "|". ');

