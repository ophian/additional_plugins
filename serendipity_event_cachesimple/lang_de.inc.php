<?php

/**
 *  @version 1.0
 *  @author Konrad Bauckmeier <kontakt@dd4kids.de>
 *  @translated 2009/08/20
 */
@define('PLUGIN_EVENT_CACHESIMPLE_NAME', 'Einfache Cached/Pregenerated Seiten');
@define('PLUGIN_EVENT_CACHESIMPLE_DESC', '[EXPERIMENTELL] Erm�glicht es, vollst�ndige Seiten zu cachen. Hinweis: Zerst�rt so ziemlich alle dynamischen Optionen des Frontends und arbeitet h�chstvermutlich nicht gut mit dynamischen Plugins zusammen. Daf�r ist es schnell, wenn man nicht auf Echtzeit-Dynamik angewiesen ist. (Dieses Plugin sollte also so fr�h wie m�glich in der Event-Plugin-Liste positioniert werden. Nur Dynamische Plugins wie Karmavoting sollten vor diesem Plugin ausgef�hrt werden.)');

// Next lines were translated on 2009/08/20
@define('PLUGIN_EVENT_CACHESIMPLE_BROWSER', 'Benutze getrennte IE/Mozilla Caches');
@define('PLUGIN_EVENT_CACHESIMPLE_KEEPFRESH', 'Zwinge Clients zum Neuabruf');
@define('PLUGIN_EVENT_CACHESIMPLE_KEEPFRESH_DESC', 'Indem kein "Expires- Header gesedet wird, werden Clients angewiesen, die Webseite nicht lokal zwischenzuspeichern. Dadurch ist der Client gezwungen, die Seite bei jedem Aufruf neu abzurufen. Dies verhindert Probleme, wenn Kommentare nach dem Absenden nicht auftauchen, aber resultiert in geringeren Zugriffszeiten. (Einige Clients nutzen zus�tzlich interne G�ltigkeitspr�fungen, um das �bertragungsvolumen zu minimieren.) ');

