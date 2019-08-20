<?php

@define('PLUGIN_EVENT_AUTOUPDATE_NAME', 'Serendipity Autoupdate');
@define('PLUGIN_EVENT_AUTOUPDATE_DESC', 'Sobald das Dashboard (einmal am Tag) ein Serendipity Update entdeckt, setzt dieses Plugin eine Ein-Klick Option in das Dashboard des Backends, um ein manuelles Download oder ein automatisches und gesichertes Upgrade der Blogsoftware zu starten. Mit Styx 2.1+ ist zu empfehlen, dieses Plugin in Kombination mit dem modemaintain (Wartungs-) Ereignis Plugin zu nutzen.');
@define('PLUGIN_EVENT_AUTOUPDATE_UPDATEBUTTON', 'Automatisches Upgrade starten');

@define('PLUGIN_EVENT_AUTOUPDATE_DL_URL', 'Benutzerdefinierte (GitHub?) download URL');
@define('PLUGIN_EVENT_AUTOUPDATE_DL_URL_DESC', 'Definieren Sie hier eine URL wie diese: "https://github.com/name/repo/releases/download/". Ihr benutzerdefiniertes Verzeichnis/Datei-Schema muss mit "$version/serendipity-$version.zip" enden (ersetzen Sie $version mit dem Versionnummern String aus ihrer benutzerdefinierten RELEASE-Datei, zB. "2.1.5/serendipity-2.1.5.zip"). Sie k�nnen die URL zu Letzterer in der Backend Konfiguration, unter dem Optionsblock "Generelle Einstellungen" hinterlegen. Lassen Sie ansonsten die angegebene Styx Default-URL hier unver�ndert stehen!');
@define('PLUGIN_EVENT_AUTOUPDATE_RF_URL', 'Benutzerdefinierte (GitHub?) release tag URL');
@define('PLUGIN_EVENT_AUTOUPDATE_RF_URL_DESC', 'Definieren Sie hier eine URL wie diese: "https://github.com/name/repo/releases/tag/". Ihr benutzerdefinierter Dateiname muss "$version" hei�en (ersetzen Sie $version mit dem Versionnummern String aus ihrer benutzerdefinierten RELEASE-Datei, zB. "2.1.5"). Sie k�nnen die URL zu Letzterer in der Backend Konfiguration, unter dem Optionsblock "Generelle Einstellungen" hinterlegen. Lassen Sie ansonsten die angegebene Styx Default-URL hier unver�ndert stehen!');

@define('PLUGIN_EVENT_AUTOUPDATE_CHECK', 'SICHERHEITSHINWEIS:\n\nHaben Sie bereits auf Plugin UPDATES gepr�ft?\nHaben Sie wirklich das MODEMAINTAIN Plugin installiert und den Wartungsmodus f�r dieses Update angestellt?\n\nDr�cken Sie OK, um mit dem AUTOUPDATE fortzufahren.');

@define('PLUGIN_AUTOUPD_MSG_TITLE', 'Serendipity Auto-Upgrade Prozessor');
@define('PLUGIN_AUTOUPD_MSG_INFO', 'Der ZIP Download, die Datei �berpr�fungen und verschiedenen Verifizierungen, sowie die Dateiverschiebungen f�r das Serendipity Update: %s k�nnen eine gewisse Zeit beanspruchen... (ca. 1-3 Min).<br>Bitte werden Sie nicht ungeduldig und schlie�en oder ver�ndern Sie diese Seite nicht w�hrend des Vorgangs!');
@define('PLUGIN_AUTOUPD_MSG_RELOAD', 'BEACHTEN SIE: Wenn diese Seite je mit einem Fehler w�hrend des Vorganges abbricht, oder sich nichts mehr tut, k�nnen sie den Vorgang problemlos durch einen RELOAD ihrer Browserseite [<em>per Tastatur, zB. F5</em>] wiederansto�en. Dieses tut der Fortsetzung der Updatefunktion keinen Schaden. Dies gilt auch, wenn Sie einen Hinweis Fehler behoben haben.');
@define('PLUGIN_AUTOUPD_MSG_EXECUTIONTIME', 'PHP max execution time set to 210 seconds');

@define('PLUGIN_AUTOUPD_MSG_ZIPEXTFAIL', 'Die ZIP extension wurde nicht in PHP einkompiliert, bzw eingebunden. Sorgen Sie f�r Abhilfe!');

@define('PLUGIN_AUTOUPD_MSG_FLUSH_COMP', ' abgeschlossen!'); // KEEP the starting whitespace!
@define('PLUGIN_AUTOUPD_MSG_FLUSH_WAIT', ' <b>Bitte warten ... verarbeite:</b><span> %s ...</span>'); // KEEP the starting whitespace!

@define('PLUGIN_AUTOUPD_MSG_FLUSH_FNC_TIME', "In %0.4d seconds run fcn %s...\n"); // %0.4d prints in readable format 1.2345

@define('PLUGIN_AUTOUPD_MSG_FLUSH_NEXT_VERIFY', 'Verifiziere das Update Paket'); // = next function msg
@define('PLUGIN_AUTOUPD_MSG_FLUSH_NEXT_PERM', '�berpr�fe Schreibberechtigungen'); // = next function msg
@define('PLUGIN_AUTOUPD_MSG_FLUSH_NEXT_UNPACK', 'Entpacke das Update'); // = next function msg
@define('PLUGIN_AUTOUPD_MSG_FLUSH_NEXT_INTEGRITY', '�berpr�fe Integrit�t'); // = next function msg
@define('PLUGIN_AUTOUPD_MSG_FLUSH_NEXT_COPY', 'Kopiere das Update'); // = next function msg
@define('PLUGIN_AUTOUPD_MSG_FLUSH_NEXT_CLEAN', 'L�sche den vorl�ufigen Autoupdate Ordner'); // = next function msg
@define('PLUGIN_AUTOUPD_MSG_FLUSH_NEXT_FINISH', 'Beende Verarbeitungsfunction'); // = next function msg

@define('PLUGIN_AUTOUPD_MSG_FLUSH_FINI_CLEANUP', 'Aufr�umen der tempor�ren Autoupdate-Verarbeitung beendet!');
@define('PLUGIN_AUTOUPD_MSG_FLUSH_INST_GO', '<a href="%s">Klicken Sie hier, um den eigentlichen Serendipity Installer zu starten</a>!');

@define('PLUGIN_AUTOUPD_MSG_FLUSH_FAIL_COPY', 'Kopieren der Update-Dateien gescheitert!');
@define('PLUGIN_AUTOUPD_MSG_FLUSH_FAIL_UNPACK', 'Das Entpacken der Update-Zip-Datei ist fehlgeschlagen!');
@define('PLUGIN_AUTOUPD_MSG_FLUSH_FAIL_CLEAN', 'Bereinigung des entpackten Verzeichnisses!');
@define('PLUGIN_AUTOUPD_MSG_FLUSH_FAIL_RELOAD', 'Bitte <a href="?serendipity[newVersion]=%s">laden</a> Sie diese Seite [F5] neu, um noch einmal zu versuchen, Ihr Blog erfolgreich zu aktualisieren!');

@define('PLUGIN_AUTOUPD_MSG_EXISTS', 'Existiert der Link nach (<span class="file">%s</span>) �berhaupt?');
@define('PLUGIN_AUTOUPD_MSG_RETURN', 'Seite neu <a href="?serendipity[newVersion]=%s">laden</a>, oder zur�ck zum <a href="serendipity_admin.php">Backend</a> Ihres Blogs.');

@define('PLUGIN_AUTOUPD_MSG_FETCH_ZIPFAIL', 'Fehler bei vorhandener Zip-Datei; Code: %s. Der Autoupdater wird erneut versuchen, das Programm herunterzuladen...');
@define('PLUGIN_AUTOUPD_MSG_FETCH_CURLFAIL', 'Update-Download fehlgeschlagen (Curl installiert, aber fehlgeschlagen)!');
@define('PLUGIN_AUTOUPD_MSG_FETCH_DWLFAIL', 'Das Herunterladen des Updates ist fehlgeschlagen (Kopie fehlgeschlagen, Curl nicht verf�gbar)!');
@define('PLUGIN_AUTOUPD_MSG_FETCH_DWLDONE', 'Herunterladen des Download nach "<span class="dir">templates_c</span>" erfolgt!');

@define('PLUGIN_AUTOUPD_MSG_VERIFY_MD5', '�berpr�fung der MD5-Zip-Datei-Pr�fsumme: %s');
@define('PLUGIN_AUTOUPD_MSG_VERIFY_FAIL', 'Fehler! Das Update konnte nicht �berpr�ft werden.');

@define('PLUGIN_AUTOUPD_MSG_UNPACK', 'Extrahieren des Zips in "<span class="dir">templates_c</span>" erfolgt!');

@define('PLUGIN_AUTOUPD_MSG_COPY_FAIL', 'Fehler! Kopieren der Datei "<span class="file">%s</span>" nach "<span class="file">%s</span>" ist fehlgeschlagen!');

@define('PLUGIN_AUTOUPD_MSG_WRITE_FAIL', 'Das Entpacken der Update-Zip-Datei ist fehlgeschlagen, da die folgenden Dateien nicht beschreibbar waren:');

@define('PLUGIN_AUTOUPD_MSG_CKSUM_FAIL', 'Die Aktualisierung ist fehlgeschlagen, da der Integrit�tstest f�r die folgenden Dateien fehlgeschlagen ist:');

@define('PLUGIN_AUTOUPD_MSG_CLOSE', 'BITTE BEACHTEN SIE:<br><span class="foot">Sollte diese Seite w�hrend der Bearbeitung jemals mit einer Fehlermeldung oder unerwarteten Funktionseinstellung beendet werden, k�nnen Sie Ihren Browser normalerweise einfach per RELOAD [<em> zB. das Tastaturk�rzel F5</em>] neu laden, um einen weiteren Update-Durchlauf anzusto�en. Dies schadet dem vorangegangenen Upgradevorgang nicht.</span>');

@define('PLUGIN_AUTOUPD_MSG_DUNNE_JS', "Autoupdate erfolgreich durchgef�hrt!\\nWir leiten nun zum Serendipity Installer um!\\n"); // KEEP double quotes and escape for js
@define('PLUGIN_AUTOUPD_MSG_DUNNE_OK', 'Autoupdate erfolgreich durchgef�hrt - leite zum Serendipity Installer um...');

#@define('PLUGIN_AUTOUPD_MSG_CLEAN_ZIP', 'Entfernen der Zip-Datei in "<span class="dir">templates_c</span>" erfolgt!'); // currently not used
@define('PLUGIN_AUTOUPD_MSG_CLEAN_FILES', 'Entfernen aller Dateien in "<span class="dir">%s</span>" erfolgt!');
@define('PLUGIN_AUTOUPD_MSG_CLEAN_DIR', 'L�schen des leeren Verzeichnisses: "<span class="dir">%s</span>" erfolgt!');
@define('PLUGIN_AUTOUPD_MSG_CLEAN_DIR_FAILED', 'L�schen des leeren Verzeichnisses: "<span class="dir">%s</span>" fehlgeschlagen!');
@define('PLUGIN_AUTOUPD_MSG_CLEAN_TC_OK', 'Die automatische Bereinigung des von Smarty kompilierten Theme-Verzeichnisses: "<span class="dir">templates_c/%s</span>" ist erfolgt!');
@define('PLUGIN_AUTOUPD_MSG_CLEAN_TC_FAILED', 'Die automatische Bereinigung des von Smarty kompilierten Theme-Verzeichnisses: "<span class="dir">templates_c/%s</span>" ist fehlgeschlagen! Wenn Sie nachfolgend Probleme mit Ihren aktuellen Theme haben, l�schen Sie das Verzeichnis manuell, um Smarty zu einer automatischen Neukompilierung zu veranlassen.');

