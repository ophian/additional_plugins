<?php

/**
 *  @version
 *  @author Thomas Hochstein <thh@inter.net>
 */

@define('PLUGIN_EVENT_FACEBOOK_NAME', 'Facebook (Experimentell!)');
@define('PLUGIN_EVENT_FACEBOOK_DESC', 'Importiert Kommentare von Facebook-Posts (vergleichbar RSS-Graffiti) zur�ck in den Blog. Bettet auch Facebook-OpenGraph-Meta-Tags in den Blog ein.');
@define('PLUGIN_EVENT_FACEBOOK_HOWTO', 'Kommentare werden in Blogeintr�ge importiert, indem die URL des Facebook-Links (der �ffentlich sein muss!) mit dem Blogbeitrag verglichen wird. F�r diese Suche wird der konfigurierte Hostname von Serendipity (baseURL) verwendet. Dieses Plugin kann �ber das Cronjob-Plugin oder �ber manuelle Cronjobs (d.h. wget) �ber index.php?/plugin/facebookcomments ausgef�hrt werden.');
@define('PLUGIN_EVENT_FACEBOOK_MODERATE', 'Sollten Facebook-Kommentare standardm��ig moderiert werden?');
@define('PLUGIN_EVENT_FACEBOOK_USERS', 'Facebook-Benutzername(n)');
@define('PLUGIN_EVENT_FACEBOOK_USERS_DESC', 'Geben Sie den Facebook-Benutzernamen oder die ID ein, der/die mit Ihrem Blog verbunden ist und abgerufen werden soll. Denken Sie daran, dass nur �ffentliche Accounts/Storys/Kommentare �ber die Facebook-Graph-API abgerufen werden k�nnen. Mehrere Benutzernamen / IDs k�nnen durch "," getrennt werden.');
@define('PLUGIN_EVENT_FACEBOOK_VIA', 'Welchen Text zu Facebook-Kommentaren hinzuf�gen?');
@define('PLUGIN_EVENT_FACEBOOK_LIMIT', 'Wie viele Graph-API-Eintr�ge abrufen?');
@define('PLUGIN_EVENT_FACEBOOK_LIMIT_DESC', 'Legt fest, wie viele Elemente die Facebook-API-Anfrage zur�ckgeben soll. Normalerweise sollten die letzten 25 Elemente ausreiche;, wenn Sie eine stark frequentierte Facebook-Pinnwand haben, m�chten Sie m�glicherweise das Limit erh�hen (oder h�ufiger einen Abruf ausf�hren). Je h�her der Grenzwert, desto l�nger dauert die �berpr�fung der Graph-API.');
@define('PLUGIN_AGGREGATOR_CRONJOB', 'Dieses Plugin unterst�tzt das Serendipity-Cronjob-Plugin. Installieren Sie es, wenn Sie eine zeitgesteuerte Ausf�hrung w�nschen.');

