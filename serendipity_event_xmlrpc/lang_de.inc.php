<?php

@define('PLUGIN_EVENT_XMLRPC_NAME', 'Eintr�ge via XML-RPC erstellen');
@define('PLUGIN_EVENT_XMLRPC_DESC', 'Erm�glicht Eintr�ge via XML-RPC API zu erstellen/bearbeiten (MT, Blogger, WordPress API-Endpunkte)');
@define('PLUGIN_EVENT_XMLRPC_DEFAULTCAT', 'Standard-Kategorie');
@define('PLUGIN_EVENT_XMLRPC_DEFAULTCAT_DESC', 'Bestimmt die Standard-Kategorie f�r Blog-Artikel via XML-RPC, wenn der Client keine Kategorie setzt.');
@define('PLUGIN_EVENT_XMLRPC_GMT', 'GMT-Zeitzone verwenden');

@define('PLUGIN_EVENT_XMLRPC_DOC_RPCLINK','<div class="msg_hint msg-btm msg-sm"><b>Zur Information:</b><br>
Dieses Blog hat eine URL, an der XML-RPC Aufrufe abgearbeitet werden. Modernere Clients k�nnen diese automatisch mit der Blog URL ermitteln, bei �lteren Clients muss sie explizit angegeben werden.<br/>Diese XML-RPC URL ist: <b>%s</b></div>');

@define('PLUGIN_EVENT_XMLRPC_DEBUGLOG', 'Debug Log');
@define('PLUGIN_EVENT_XMLRPC_DEBUGLOG_DESC', 'Wenn Sie daran interessiert sind, was die XML-RPC Schnittstelle empf�ngt und antwortet, k�nnen Sie das Debug Log anschalten. Das Logfile wird als "rpc.log" im Plugin Verzeichnis angelegt.'); // Die \'debug\' Einstellung ist nur zum Auffinden von Problemen geeignet, sie produziert Antworten, mit denen ein Client nicht umgehen kann. Also bitte nicht in einem Live System einschalten!');
@define('PLUGIN_EVENT_XMLRPC_DEBUGLOG_NONE', 'ausgeschaltet');
@define('PLUGIN_EVENT_XMLRPC_DEBUGLOG_NORMAL', 'angeschaltet');
@define('PLUGIN_EVENT_XMLRPC_DEBUGLOG_VERBOSE', 'debug: Nicht f�r Clients!');

@define('PLUGIN_EVENT_XMLRPC_WPFAKEVERSION', 'WordPress Version vort�uschen');
@define('PLUGIN_EVENT_XMLRPC_WPFAKEVERSION_DESC', 'Die XML-RPC Schnittstelle kann auf WordPress Aufrufe reagieren. Wenn sie nach der installierten Software Version gefragt wird, antwortet sie normalerweise mit "Serendipity ' . $serendipity['version'] .'" (aktuelle Version). Wenn man hier eine Version (ohne Namen) eintr�gt, dann wird sie mit "WordPress x.y" antworten. Einige Clients k�nnten auf eine minimale WordPress Version testen; eine Version wie "3.2" w�re dann okay.');
@define('PLUGIN_EVENT_XMLRPC_HTMLCONVERT', 'Text Artikel nach HTML konvertieren');
@define('PLUGIN_EVENT_XMLRPC_HTMLCONVERT_DESC', 'Das Plugin versucht zu erkennen, ob Artikel als reine Texte oder als HTML �bermittelt werden. Bei reinem Text wird es Zeilenumbr�che in HTML umwandeln. Wenn Ihr Blog zB. das "Textile" oder das "NL2BR" Plugin f�r Artikel benutzt, sollten Sie diese Option ausschalten.');
@define('PLUGIN_EVENT_XMLRPC_ASUREAUTHOR', 'Benutze Login als Kommentar Autor');
@define('PLUGIN_EVENT_XMLRPC_ASUREAUTHOR_DESC', 'Manche Clients speichern Kommentare mit einem generischen Autorennamen wie \'from WordPress\'. Wenn diese Option eingeschaltet ist, so wird immer der Name des eingeloggten Benutzers als Autor genommen.');
@define('PLUGIN_EVENT_XMLRPC_ASUREAUTHOR_DEFAULT', 'Autor nicht ver�ndern');
@define('PLUGIN_EVENT_XMLRPC_ASUREAUTHOR_LOGIN', 'Loginname als Autor');
@define('PLUGIN_EVENT_XMLRPC_ASUREAUTHOR_REALNAME', 'Publizierter Name als Autor');
@define('PLUGIN_EVENT_XMLRPC_UPLOADDIR', 'Upload Verzeichnis');
@define('PLUGIN_EVENT_XMLRPC_UPLOADDIR_DESC', 'In welches Medienverzeichnis sollen Medien (wie Bilder und Videos) hoch geladen werden, die der Client schickt?');

@define('PLUGIN_EVENT_XMLRPC_EVENT_SPAM_HEADER', '<h3>SPAM an AntiSpam Plugins signalisieren</h3>
<div class="msg_hint msg-btm msg-sm">Das Plugin kann SPAM und HAM Signale an AntiSpam Plugins senden.<br/>
Dies wird von dem AntiSpam Plugin (das dies unterst�tzt) genauso abgearbeitet, als ob in der Admin Oberfl�che die Kn�pfe Ham oder Spam gedr�ckt wurden.<br/>
Da allerdings manche Clients keinen eigenen Spam Knopf anbieten, sondern nur "Moderieren" und "Freischalten", kann man hier einstellen, wann diese Signale verschickt werden sollen.<br/>
Bei einem Client ohne separaten Spam Knopf will man das Signal z.B. schicken, wenn man einen Kommentar moderiert.</div>');
@define('PLUGIN_EVENT_XMLRPC_EVENT_SPAM', 'Kommentar wurde als SPAM markiert');
@define('PLUGIN_EVENT_XMLRPC_EVENT_SPAM_DESC', 'Der Client hat den Kommentar als SPAM markiert');
@define('PLUGIN_EVENT_XMLRPC_EVENT_APPROVED', 'Kommentar wurde freigeschaltet');
@define('PLUGIN_EVENT_XMLRPC_EVENT_APPROVED_DESC', 'Im Client wurde der Kommentar freigeschaltet');
@define('PLUGIN_EVENT_XMLRPC_EVENT_PENDING', 'Kommentar wurde moderiert');
@define('PLUGIN_EVENT_XMLRPC_EVENT_PENDING_DESC', 'Im Client wurde der Kommentar moderiert');
@define('PLUGIN_EVENT_XMLRPC_EVENTVALUE_NONE', 'Nichts im SPAM Zusammenhang');
@define('PLUGIN_EVENT_XMLRPC_EVENTVALUE_SPAM', 'Signalisiere als SPAM');
@define('PLUGIN_EVENT_XMLRPC_EVENTVALUE_HAM', 'Signalisiere als HAM');

