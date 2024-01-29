<?php

@define('PLUGIN_EVENT_AUTOUPDATE_NAME', 'Serendipity Autoupdate');
@define('PLUGIN_EVENT_AUTOUPDATE_DESC', 'Sobald das Serendipity Backend (einmal am Tag) ein Serendipity Update entdeckt, setzt dieses Plugin eine Ein-Klick Option in die Startseite des Backends, um ein manuelles Download oder ein automatisches und gesichertes Upgrade der Blogsoftware zu starten. Es ist zu empfehlen, dieses Plugin in Kombination mit dem modemaintain (Wartungs-) Ereignis Plugin zu nutzen. Für Autoupdate Hinweise müssen Sie die globale Serendipity Konfigurationsoption in "Einstellungen:: Generelle Einstellungen: Update-Hinweis" auf "stable" oder "beta" stellen, um es überhaupt über das Dashboard nutzen zu können!');
@define('PLUGIN_EVENT_AUTOUPDATE_UPDATEBUTTON', 'Automatisches Upgrade starten');

@define('PLUGIN_EVENT_AUTOUPDATE_DL_URL', 'Benutzerdefinierte (GitHub?) download URL');
@define('PLUGIN_EVENT_AUTOUPDATE_DL_URL_DESC', 'Definieren Sie hier eine URL wie diese: "https://github.com/name/repo/releases/download/". Ihr benutzerdefiniertes Verzeichnis/Datei-Schema muss mit "$version/serendipity-$version.zip" enden (ersetzen Sie $version mit dem Versionsnummer String aus ihrer benutzerdefinierten RELEASE-Datei, zB. "2.1.5/serendipity-2.1.5.zip"). Sie können die URL zu Letzterer in der Backend Konfiguration, unter dem Optionsblock "Generelle Einstellungen" hinterlegen. Lassen Sie ansonsten die angegebene Styx Default-URL hier unverändert stehen!');
@define('PLUGIN_EVENT_AUTOUPDATE_RF_URL', 'Benutzerdefinierte (GitHub?) release tag URL');
@define('PLUGIN_EVENT_AUTOUPDATE_RF_URL_DESC', 'Definieren Sie hier eine URL wie diese: "https://github.com/name/repo/releases/tag/". Ihr benutzerdefinierter Dateiname muss "$version" heißen (ersetzen Sie $version mit dem Versionsnummer String aus ihrer benutzerdefinierten RELEASE-Datei, zB. "2.1.5"). Sie können die URL zu Letzterer in der Backend Konfiguration, unter dem Optionsblock "Generelle Einstellungen" hinterlegen. Lassen Sie ansonsten die angegebene Styx Default-URL hier unverändert stehen!');
@define('PLUGIN_EVENT_AUTOUPDATE_REMOVE_ZIPS', 'Erlaube alte Zip-Upgrade Dateien zu entfernen?');
@define('PLUGIN_EVENT_AUTOUPDATE_REMOVE_ZIPS_DESC', 'Empfehlung (ja)!');

@define('PLUGIN_EVENT_AUTOUPDATE_CHECK', 'SICHERHEITSHINWEIS:\n\nHaben Sie bereits auf Plugin UPDATES geprüft?\nHaben Sie wirklich das MODEMAINTAIN Plugin installiert und den Wartungsmodus für dieses Update angestellt?\n\nDrücken Sie OK, um mit dem AUTOUPDATE fortzufahren.');

@define('PLUGIN_AUTOUPD_MSG_TITLE', 'Serendipity Auto-Upgrade Prozessor');
@define('PLUGIN_AUTOUPD_MSG_INFO', 'Der ZIP Download, die Datei Überprüfungen und verschiedenen Verifizierungen, sowie die Dateiverschiebungen für das Serendipity Update: %s können eine gewisse Zeit beanspruchen... (ca. 1-3 Min).<br>Bitte werden Sie nicht ungeduldig und schließen oder verändern Sie diese Seite nicht während des Vorgangs!');
@define('PLUGIN_AUTOUPD_MSG_RELOAD', 'BEACHTEN SIE: Wenn diese Seite je mit einem Fehler während des Vorganges abbricht, oder sich nichts mehr tut, können sie den Vorgang problemlos durch einen RELOAD ihrer Browserseite [<em>per Tastatur, zB. F5</em>] wiederanstoßen. Dieses tut der Fortsetzung der Updatefunktion keinen Schaden. Dies gilt auch, wenn Sie einen Hinweis Fehler behoben haben.');
@define('PLUGIN_AUTOUPD_MSG_EXECUTIONTIME', 'PHP max execution time set to 210 seconds');

@define('PLUGIN_AUTOUPD_MSG_ZIPEXTFAIL', 'Die ZIP extension wurde nicht in PHP einkompiliert, bzw eingebunden. Sorgen Sie für Abhilfe!');

@define('PLUGIN_AUTOUPD_MSG_FLUSH_COMP', ' abgeschlossen!'); // KEEP the starting whitespace!
@define('PLUGIN_AUTOUPD_MSG_FLUSH_WAIT', ' <b>Bitte warten ... verarbeite:</b><span> %s ...</span>'); // KEEP the starting whitespace!

@define('PLUGIN_AUTOUPD_MSG_FLUSH_FNC_TIME', "In %0.4d seconds run fcn %s...\n"); // %0.4d prints in readable format 1.2345

@define('PLUGIN_AUTOUPD_MSG_FLUSH_NEXT_VERIFY', 'Verifiziere das Update Paket'); // = next function msg
@define('PLUGIN_AUTOUPD_MSG_FLUSH_NEXT_PERM', 'Überprüfe Schreibberechtigungen'); // = next function msg
@define('PLUGIN_AUTOUPD_MSG_FLUSH_NEXT_UNPACK', 'Entpacke das Update'); // = next function msg
@define('PLUGIN_AUTOUPD_MSG_FLUSH_NEXT_INTEGRITY', 'Überprüfe Integrität'); // = next function msg
@define('PLUGIN_AUTOUPD_MSG_FLUSH_NEXT_COPY', 'Kopiere das Update'); // = next function msg
@define('PLUGIN_AUTOUPD_MSG_FLUSH_NEXT_CLEAN', 'Lösche den vorläufigen Autoupdate Ordner'); // = next function msg
@define('PLUGIN_AUTOUPD_MSG_FLUSH_NEXT_FINISH', 'Beende Verarbeitungsfunktion'); // = next function msg

@define('PLUGIN_AUTOUPD_MSG_FLUSH_FINI_CLEANUP', 'Aufräumen der temporären Autoupdate-Verarbeitung beendet!');
@define('PLUGIN_AUTOUPD_MSG_FLUSH_INST_GO', '<a href="%s">Klicken Sie hier, um den eigentlichen Serendipity Installer zu starten</a>!');

@define('PLUGIN_AUTOUPD_MSG_FLUSH_FAIL_COPY', 'Kopieren der Update-Dateien gescheitert!');
@define('PLUGIN_AUTOUPD_MSG_FLUSH_FAIL_UNPACK', 'Das Entpacken der Update-Zip-Datei ist fehlgeschlagen!');
@define('PLUGIN_AUTOUPD_MSG_FLUSH_FAIL_CLEAN', 'Bereinigung des entpackten Verzeichnisses!');
@define('PLUGIN_AUTOUPD_MSG_FLUSH_FAIL_RELOAD', 'Bitte <a href="?serendipity[newVersion]=%s">laden</a> Sie diese Seite [F5] neu, um noch einmal zu versuchen, Ihr Blog erfolgreich zu aktualisieren!');

@define('PLUGIN_AUTOUPD_MSG_EXISTS', 'Existiert der Link nach (<span class="file">%s</span>) überhaupt?');
@define('PLUGIN_AUTOUPD_MSG_RETURN', 'Seite neu <a href="?serendipity[adminModule]=event_display&serendipity[adminAction]=update&serendipity[newVersion]=%s">laden</a>, oder zurück zum <a href="serendipity_admin.php">Backend</a> Ihres Blogs.');

@define('PLUGIN_AUTOUPD_MSG_FETCH_ZIPFAIL', 'Fehler bei vorhandener Zip-Datei; Code: %s ("%s"). Der Autoupdater wird erneut versuchen, das Programm herunterzuladen...');
@define('PLUGIN_AUTOUPD_MSG_FETCH_CURLFAIL', 'Update-Download fehlgeschlagen (Curl installiert, aber fehlgeschlagen)!');
@define('PLUGIN_AUTOUPD_MSG_FETCH_DWLFAIL', 'Das Herunterladen des Updates ist fehlgeschlagen (Kopie fehlgeschlagen, Curl nicht verfügbar)!');
@define('PLUGIN_AUTOUPD_MSG_FETCH_DWLDONE', 'Herunterladen des Download nach "<span class="dir">templates_c</span>" erfolgt!');

@define('PLUGIN_AUTOUPD_MSG_VERIFY_CKS', 'Überprüfung der %s-Zip-Datei-Prüfsumme: %s');
@define('PLUGIN_AUTOUPD_MSG_VERIFY_FAIL', 'Fehler! Das Update konnte nicht überprüft werden.');

@define('PLUGIN_AUTOUPD_MSG_UNPACK', 'Extrahieren des Zips in "<span class="dir">templates_c</span>" erfolgt!');

@define('PLUGIN_AUTOUPD_MSG_COPY_FAIL', 'Fehler! Kopieren der Datei "<span class="file">%s</span>" nach "<span class="file">%s</span>" ist fehlgeschlagen!');

@define('PLUGIN_AUTOUPD_MSG_WRITE_FAIL', 'Das Entpacken der Update-Zip-Datei ist fehlgeschlagen, da die folgenden Dateien nicht beschreibbar waren:');

@define('PLUGIN_AUTOUPD_MSG_CKSUM_FAIL', 'Die Aktualisierung ist fehlgeschlagen, da der Integritätstest für die folgenden Dateien fehlgeschlagen ist:');

@define('PLUGIN_AUTOUPD_MSG_CLOSE', 'BITTE BEACHTEN SIE:<br><span class="foot">Sollte diese Seite während der Bearbeitung jemals mit einer Fehlermeldung oder unerwarteten Funktionseinstellung beendet werden, können Sie Ihren Browser normalerweise einfach per RELOAD [<em> zB. das Tastaturkürzel F5</em>] neu laden, um einen weiteren Update-Durchlauf anzustoßen. Dies schadet dem vorangegangenen Upgradevorgang nicht.</span>');

@define('PLUGIN_AUTOUPD_MSG_DUNNE_JS', "Autoupdate erfolgreich durchgeführt!\\nWir leiten nun zum Serendipity Installer um!\\n"); // KEEP double quotes and escape for js
@define('PLUGIN_AUTOUPD_MSG_DUNNE_OK', 'Autoupdate erfolgreich durchgeführt - leite zum Serendipity Installer um...');

@define('PLUGIN_AUTOUPD_MSG_CLEAN_ZIPS', 'Entfernung von %d alten Zip-Dateien in "<span class="dir">templates_c</span>" erfolgt!');
@define('PLUGIN_AUTOUPD_MSG_CLEAN_FILES', 'Entfernen aller Dateien in "<span class="dir">%s</span>" erfolgt!');
@define('PLUGIN_AUTOUPD_MSG_CLEAN_DIR', 'Löschen des leeren Verzeichnisses: "<span class="dir">%s</span>" erfolgt!');
@define('PLUGIN_AUTOUPD_MSG_CLEAN_DIR_FAILED', 'Löschen des leeren Verzeichnisses: "<span class="dir">%s</span>" fehlgeschlagen!');
@define('PLUGIN_AUTOUPD_MSG_CLEAN_TC_OK', 'Die automatische Bereinigung des von Smarty kompilierten Theme-Verzeichnisses: "<span class="dir">templates_c/%s</span>" ist erfolgt!');
@define('PLUGIN_AUTOUPD_MSG_CLEAN_TC_FAILED', 'Die automatische Bereinigung des von Smarty kompilierten Theme-Verzeichnisses: "<span class="dir">templates_c/%s</span>" ist fehlgeschlagen! Wenn Sie nachfolgend Probleme mit Ihren aktuellen Theme haben, löschen Sie das Verzeichnis manuell, um Smarty zu einer automatischen Neukompilierung zu veranlassen.');

