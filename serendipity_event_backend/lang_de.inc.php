<?php

/**
 *  @version 1.0
 *  @author Konrad Bauckmeier <yourmail@example.com>
 *  @translated 2011/11/22
 */

@define('PLUGIN_BACKEND_TITLE', 'Zeige Eintr�ge mittels JavaScript');
@define('PLUGIN_BACKEND_DESC', 'Stellt JavaScript Ausgabe der letzten Eintr�ge zum Einbinden in andere, externe Webseiten bereit. (Siehe README im Plugin Verzeichnis!)');
@define('PLUGIN_BACKEND_BACKENDURL', 'Backend URL');
@define('PLUGIN_BACKEND_BACKENDURL_BLAHBLAH', 'Die URL zum Backend zum Aufruf von einer externen Webseite (http://your.blog.com/' . ($serendipity['rewrite'] == "none" ? $serendipity['indexFile'] . "?/" : "") . 'plugin/[BACKEND_URL]).');