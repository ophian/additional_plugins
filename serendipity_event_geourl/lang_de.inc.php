<?php

@define('PLUGIN_EVENT_GEOURL_NAME',      'GeoURL');
@define('PLUGIN_EVENT_GEOURL_DESC',      'GeoURL ordnet URLs �rtlichkeiten zu. Mehr Infos unter http://geourl.org/');
@define('PLUGIN_EVENT_GEOURL_LAT',       'Breitengrad');
@define('PLUGIN_EVENT_GEOURL_LAT_DESC',  'Der Breitengrad des Ortes an dem das Blog gef�hrt wird oder �ber den das Blog berichtet in Dezimaldarstellung (zB 50.0515)');
@define('PLUGIN_EVENT_GEOURL_LONG',      'L�ngengrad');
@define('PLUGIN_EVENT_GEOURL_LONG_DESC', 'Der L�ngengrad des Ortes an dem das Blog gef�hrt wird oder �ber den das Blog berichtet in Dezimaldarstellung (zB 6.6209)');
@define('PLUGIN_EVENT_GEOURL_PINGED',    'GeoURL Service erfolgreich �ber die neuen Koordinaten benachrichtigt. Besuche <a href="http://geourl.org/near/?p='.$serendipity['baseURL'].'">deine Nachbarn</a>!');
@define('PLUGIN_EVENT_GEOURL_NOLATLONG', 'Breiten- und L�ngengrad m�ssen in Dezimaldarstellung eingegeben werden. Sie k�nnen zB bei <a href="http://www.maporama.com">maporama</a> oder einer <a href="http://geourl.org/resources.html">anderen Ressource</a> ermittelt werden.');

