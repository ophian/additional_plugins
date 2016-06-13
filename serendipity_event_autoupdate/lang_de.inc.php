<?php

@define('PLUGIN_EVENT_AUTOUPDATE_NAME', 'Serendipity Autoupdate');
@define('PLUGIN_EVENT_AUTOUPDATE_DESC', 'Sobald das Dashboard Plugin (einmal am Tag) ein Serendipity Update entdeckt, setzt dieses Plugin eine Ein-Klick Option in das Dashboard des Backends, um ein manuelles Download oder ein automatisches und gesichertes Upgrade der Blogsoftware zu starten.');
@define('PLUGIN_EVENT_AUTOUPDATE_UPDATEBUTTON', 'Automatisches Upgrade starten');

@define('PLUGIN_EVENT_AUTOUPDATE_DL_URL', 'Benutzerdefinierte (GitHub?) download URL');
@define('PLUGIN_EVENT_AUTOUPDATE_DL_URL_DESC', 'Definieren Sie hier eine URL wie diese: "https://github.com/s9y/Serendipity/releases/download/". Ihr benutzerdefiniertes Verzeichnis/Datei-Schema muss mit "$version/serendipity-$version.zip" enden (ersetzen Sie $version mit dem Versionnummern String aus ihrer benutzerdefinierten RELEASE-Datei, zB. "2.1.5/serendipity-2.1.5.zip"). Sie können die URL zu Letzterer in der Backend Konfiguration, unter dem Optionsblock "Generelle Einstellungen" hinterlegen. Lassen Sie ansonsten die angegebene Default-URL hier unverändert stehen!');
@define('PLUGIN_EVENT_AUTOUPDATE_RF_URL', 'Benutzerdefinierte (GitHub?) release tag URL');
@define('PLUGIN_EVENT_AUTOUPDATE_RF_URL_DESC', 'Definieren Sie hier eine URL wie diese: "https://github.com/s9y/Serendipity/releases/tag/". Ihr benutzerdefinierter Dateiname muss "$version" heißen (ersetzen Sie $version mit dem Versionnummern String aus ihrer benutzerdefinierten RELEASE-Datei, zB. "2.1.5"). Sie können die URL zu Letzterer in der Backend Konfiguration, unter dem Optionsblock "Generelle Einstellungen" hinterlegen. Lassen Sie ansonsten die angegebene Default-URL hier unverändert stehen!');

