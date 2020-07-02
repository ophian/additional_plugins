<?php

# (c) 2005 by Alexander 'dma147' Mieland, http://blog.linux-stats.org, <dma147@linux-stats.org>
# Contact me on IRC in #linux-stats, #archlinux, #archlinux.de, #s9y on irc.freenode.net

# german language file

@define("PLUGIN_FORUM_TITLE", "Diskussions-Forum / phpBB-Kommentare");
@define("PLUGIN_FORUM_DESC", "Stellt ein komplettes Diskussions-Forum zur Verf�gung, kann alternativ Blog-Kommentare in eine phpBB-Installation spiegeln.");
@define('PLUGIN_FORUM_PAGETITLE', 'Seitentitel');
@define('PLUGIN_FORUM_PAGETITLE_BLAHBLAH', 'Der Titel des Forums');
@define('PLUGIN_FORUM_HEADLINE', 'Kopfzeile/Beschreibung');
@define('PLUGIN_FORUM_HEADLINE_BLAHBLAH', 'Die Kopfzeile/Beschreibung des Forums');
@define('PLUGIN_FORUM_PAGEURL', 'Statische URL');
@define('PLUGIN_FORUM_PAGEURL_BLAHBLAH', 'Definiert die URL des Forums (index.php?serendipity[subpage]=name)');
@define("PLUGIN_FORUM_UPLOADDIR", "Absoluter Server-Pfad zum uploads-Verzeichnis");
@define("PLUGIN_FORUM_UPLOADDIR_BLAHBLAH", "Default: ".$serendipity['serendipityPath'].'files');
@define("PLUGIN_FORUM_DATEFORMAT", "Das Datumsformat f�r die Foren-Beitr�ge. Es wird die PHP-Funktion date() verwendet (Default: \"Y/m/d\")");
@define("PLUGIN_FORUM_TIMEFORMAT", "Zeitformatierung");
@define("PLUGIN_FORUM_TIMEFORMAT_BLAHBLAH", "Das Zeitformat f�r die Foren-Beitr�ge. Es wird die PHP-Funktion date() verwendet (Default: \"h:ia\")");
@define("PLUGIN_FORUM_BGCOLOR_HEAD", "Hintergrundfarbe der Titelzeilen");
@define("PLUGIN_FORUM_BGCOLOR_HEAD_BLAHBLAH", "Hintergrundfarbe aller Titelzeilen");
@define("PLUGIN_FORUM_BGCOLOR1", "1. Hintergrundfarbe");
@define("PLUGIN_FORUM_BGCOLOR2", "2. Hintergrundfarbe");
@define("PLUGIN_FORUM_APPLY_MARKUP", "Sollen die Textformatierungs-Plugins benutzt werden?");
@define("PLUGIN_FORUM_APPLY_MARKUP_BLAHBLAH", "Wenn ja, dann werden alle Textformatierungs-Plugins benutzt um den geschriebenen Text aufzuwerten (BBCodes, Smilies, GImage, ...)");
@define("PLUGIN_FORUM_ITEMSPERPAGE", "Eintr�ge pro Seite");
@define("PLUGIN_FORUM_ITEMSPERPAGE_BLAHBLAH", "Wieviele Eintr�ge (Threads/Posts) sollen pro Seite angezeigt werden? Default: 15");
@define("PLUGIN_FORUM_USE_CAPTCHAS", "Spamblock-Plugin benutzen");
@define("PLUGIN_FORUM_USE_CAPTCHAS_BLAHBLAH", "Soll das Spamblock-Plugin benutzt werden um Spam zu verhindern (Captchas)?");
@define("PLUGIN_FORUM_UNREG_NOMARKUPS", "Textformatierungs-Plugins f�r unregistrierten User deaktivieren?");
@define("PLUGIN_FORUM_UNREG_NOMARKUPS_BLAHBLAH", "Falls aktivier, k�nnen nur noch (im Blog) registrierte User die Textformatierungen benutzen.");
@define("PLUGIN_FORUM_FILEUPLOAD_REGUSER", "Datei-Upload f�r registrierte User");
@define("PLUGIN_FORUM_FILEUPLOAD_REGUSER_BLAHBLAH", "Soll der Datei-Upload in Beitr�gen f�r registrierte User erlaubt werden?");
@define("PLUGIN_FORUM_FILEUPLOAD_GUEST", "Datei-Upload f�r G�ste");
@define("PLUGIN_FORUM_FILEUPLOAD_GUEST_BLAHBLAH", "Soll der Datei-Upload in Beitr�gen f�r G�ste erlaubt werden? (NICHT empfohlen!!!)");
@define("PLUGIN_FORUM_HOW_MANY_FILES_IN_ONE_POST", "Max. Anzahl Dateien in einem Posting");
@define("PLUGIN_FORUM_HOW_MANY_FILES_IN_ONE_POST_BLAHBLAH", "Wieviele Dateien sollen maximal in einem Posting erlaubt werden?");
@define("FORUM_HOW_MANY_FILEUPLOADS_WHEN_POSTING", "Anzahl gleichzeitiger Datei-Uploads");
@define("FORUM_HOW_MANY_FILEUPLOADS_WHEN_POSTING_BLAHBLAH", "Wieviele Dateien sollen gleichzeitig beim Schreiben eines Postings hochladbar sein?");
@define("FORUM_PLUGIN_HOW_MANY_FILEUPLOADS_AT_ALL", "Max. Anzahl Datei-Uploads pro User");
@define("FORUM_PLUGIN_HOW_MANY_FILEUPLOADS_AT_ALLBLAHBLAH", "Wieviele Datei-Uploads sollen insgesamt pro User erlaubt werden? Achtung: Wenn der Datei-Upload f�r G�ste erlaubt wurde, koennen diese so viele Dateien hochladen, wie sie wollen, da diese Option nicht die Dateien von G�sten �berpr�fen kann!!!");
@define("FORUM_PLUGIN_NOTIFYMAIL_FROM", "Benachrichtigungs E-Mail: E-Mail-Adresse");
@define("FORUM_PLUGIN_NOTIFYMAIL_FROM_BLAHBLAH", "Die E-Mail-Adresse, von der die Benachrichtigungs-Mails verschickt werden sollen (From-Feld)");
@define("FORUM_PLUGIN_NOTIFYMAIL_NAME", "Benachrichtigungs E-Mail: Name");
@define("FORUM_PLUGIN_NOTIFYMAIL_NAME_BLAHBLAH", "Der Name, von dem die Benachrichtigungs Mails verschickt werden sollen (From-Feld)");
@define("FORUM_PLUGIN_ADMIN_NOTIFY", "Admin benachrichtigen");
@define("FORUM_PLUGIN_ADMIN_NOTIFY_BLAHBLAH", "Soll der Admin bei jedem neuen Post oder Reply per Mail benachrichtigt werden?");
@define("PLUGIN_FORUM_COLORTODAY", "Farbe f�r den \"Heute\" Schriftzug");
@define("PLUGIN_FORUM_COLORYESTERDAY", "Farbe f�r den \"Gestern\" Schriftzug");

@define("PLUGIN_FORUM_NO_BOARDS", "Keine Foren definiert!");
@define("PLUGIN_FORUM_NO_ENTRIES", "Keine Beitr�ge");
@define("PLUGIN_FORUM_BOARDS", "Foren");
@define("PLUGIN_FORUM_THREADS", "Beitr�ge");
@define("PLUGIN_FORUM_POSTS", "Antworten");
@define("PLUGIN_FORUM_LASTPOST", "Letzter Beitrag");
@define("PLUGIN_FORUM_LASTREPLY", "Letzte Antwort");
@define("PLUGIN_FORUM_NO_THREADS", "Keine Beitr�ge gefunden!");
@define("PLUGIN_FORUM_THREADTITLE", "Beitragstitel");
@define("PLUGIN_FORUM_POSTTITLE", "Kopfzeile");
@define("PLUGIN_FORUM_REPLIES", "Antworten");
@define("PLUGIN_FORUM_VIEWS", "Gelesen");
@define("PLUGIN_FORUM_NO_REPLIES", "Keine Antworten");
@define("PLUGIN_FORUM_AUTHOR", "Autor");
@define("PLUGIN_FORUM_MESSAGE", "Nachricht");
@define("PLUGIN_FORUM_BACKTOTOP", "Zur�ck nach oben");
@define("PLUGIN_FORUM_ALT_REOPEN", "Beitrag wiederer�ffnen...");
@define("PLUGIN_FORUM_ALT_CLOSE", "Beitrag schliessen...");
@define("PLUGIN_FORUM_ALT_MOVE", "Beitrag in ein anderes Forum verschieben...");
@define("PLUGIN_FORUM_ALT_DELETE", "Beitrag l�schen...");
@define("PLUGIN_FORUM_ALT_DELETE_POST", "Diese Antwort l�schen...");
@define("PLUGIN_FORUM_ALT_REPLY", "Auf diesen Beitrag antworten...");
@define("PLUGIN_FORUM_ALT_QUOTE", "Auf den Beitrag antworten, mit dem Zitat aus dieser Antwort...");
@define("PLUGIN_FORUM_ALT_EDIT", "Deine Antwort �ndern...");
@define("PLUGIN_FORUM_ALT_DELETE", "Diese Antwort l�schen...");
@define("PLUGIN_FORUM_ALT_UNREAD", "Bisher noch nicht gelesen oder neue Antworten wurden geschrieben...");
@define("PLUGIN_FORUM_ALT_READ", "Dieser Beitrag wurde bereits vollst�ndig gelesen...");
@define("PLUGIN_FORUM_ALT_DIRECTGOTOPOST", "Gehe direkt zu diesen Beitrag...");
@define("PLUGIN_FORUM_MARKUPS", "Folgende Textformatierungen k�nnen benutzt werden, wenn vom Administrator aktiviert:<br />&nbsp; - <a href=\"http://www.s9y.org/forums/faq.php?mode=bbcode\" target=\"_blank\" rel=\"noopener\">BBCode</a><br />&nbsp; - Smilies<br />&nbsp; - GalleryImage<br />");
@define("PLUGIN_FORUM_GUEST", "Gast");
@define("PLUGIN_FORUM_CONFIRM_DELETE_POST", "M�chtest Du diese Antwort wirklich l�schen?");
@define("PLUGIN_FORUM_ORDER", "Umsortieren");
@define("PLUGIN_FORUM_BOARDNAME", "Forenname");
@define("PLUGIN_FORUM_BOARDDESC", "Beschreibung");
@define("PLUGIN_FORUM_REALLY_DELETE_BOARDS", "Bist Du wirklich sicher, dass Du {num} board(s) l�schen willst?");
@define("PLUGIN_FORUM_REALLY_DELETE_THREAD", "Bist Du wirklich sicher, dass Du diesen Beitrag l�schen willst?");
@define("PLUGIN_FORUM_DELETE_OR_MOVE", "Sollen die Beitr�ge gel�scht werden oder in ein anderes Forum verschoben werden?");
@define("PLUGIN_FORUM_WHERE_TO_MOVE", "W�hle das Ziel-Forum oder L�schen:");
@define("PLUGIN_FORUM_ADD_BOARD", "Neues Forum hinzuf�gen");
@define("PLUGIN_FORUM_PAGES", "Seiten");
@define("PLUGIN_FORUM_MOVE_THREAD", "In welches Forum m�chtest Du den Beitrag verschieben?");
@define("PLUGIN_FORUM_MOVE", "Verschieben");
@define("PLUGIN_FORUM_FROM_BOARD", "von Forum");
@define("PLUGIN_FORUM_TO_BOARD", "zu Forum");
@define("PLUGIN_FORUM_SUBMIT", "Senden");
@define("PLUGIN_FORUM_RESET", "Zur�cksetzen");
@define("PLUGIN_FORUM_REG_USER", "Registrierter Benutzer");
@define("PLUGIN_FORUM_POSTS", "Beitr�ge");
@define("PLUGIN_FORUM_VISITS", "Besuche");
@define("PLUGIN_FORUM_UPLOAD_FILE","Datei");
@define("PLUGIN_FORUM_DOWNLOADCOUNT", "Downloads:");
@define("PLUGIN_FORUM_REST_UPLOAD_USER", "Uploads f�r Benutzer noch m�glich");
@define("PLUGIN_FORUM_REST_UPLOAD_POST", "Uploads f�r dieses Posting noch m�glich");
@define("PLUGIN_FORUM_ANNOUNCEMENT", "Ist das eine Ank�ndigung?");
@define("PLUGIN_FORUM_SUBSCRIBE", "Bei Antworten per E-Mail benachrichtigen lassen?");
@define("PLUGIN_FORUM_UNSUBSCRIBE", "E-Mail-Benachrichtigung abschalten?");
@define("PLUGIN_FORUM_TODAY", "Heute");
@define("PLUGIN_FORUM_YESTERDAY", "Gestern");
@define("PLUGIN_FORUM_UPLOAD_OVERWRITE", "�berschreiben");
@define("PLUGIN_FORUM_UPLOAD_OVERWRITE_BLAHBLAH", "Soll ein bereits bestehender Upload mit dem gleichen Namen �berschrieben werden?<br />Achtung: Dies wird *alle* Dateien �berschreiben, die den gleichen Namen haben und Dir geh�ren!");

@define("PLUGIN_FORUM_ERR_MISSING_THREADTITLE", "Fehler: Beitragstitel fehlt oder ist zu kurz (min. 4 Zeichen)! Beitrag nicht gespeichert!");
@define("PLUGIN_FORUM_ERR_MISSING_MESSAGE", "Fehler: Nachrichtentext fehlt oder ist zu kurz (min. 4 Zeichen)! Beitrag nicht gespeichert!");
@define("PLUGIN_FORUM_ERR_THREAD_CLOSED", "Fehler: Der Beitrag ist geschlossen! Beitrag nicht gespeichert!");
@define("PLUGIN_FORUM_ERR_EDIT_NOT_ALLOWED", "Fehler: Es ist Dir nicht erlaubt, diesen Beitrag zu �ndern! Beitrag nicht gespeichert!");
@define("PLUGIN_FORUM_ERR_DELETE_NOT_ALLOWED", "Fehler: Es ist Dir nicht erlaubt diesen Beitrag zu l�schen! Beitrag nicht gespeichert!");
@define("PLUGIN_FORUM_ERR_DOUBLE_THREAD", "Fehler: Du hast diesen Beitrag eben schon abgeschickt! Beitrag nicht gespeichert!");
@define("PLUGIN_FORUM_ERR_DOUBLE_POST", "Fehler: Du hast diese Antwort eben schon abgeschickt! Beitrag nicht gespeichert!");
@define("PLUGIN_FORUM_ERR_POST_INTERVAL", "Fehler: Das Zeitintervall zwischen dem letzten und diesem Beitrag war zu kurz! Beitrag nicht gespeichert!");
@define("PLUGIN_FORUM_ERR_WRONG_CAPTCHA_STRING", "Fehler: Falsche Captcha-Zeichenkette! Beitrag nicht gespeichert!");
@define("PLUGIN_FORUM_ERR_FILE_TOO_BIG", "Datei zu gro�! (nicht gespeichert!)");
@define("PLUGIN_FORUM_ERR_FILE_NOT_COPIED", "Datei konnte nicht gespeichert werden! (Grund unbekannt)");


// email notify
@define("PLUGIN_FORUM_EMAIL_NOTIFY_SUBJECT", "Ein neues Posting wurde von {postauthor} im Forum auf {blogurl} geschrieben!");

@define("PLUGIN_FORUM_EMAIL_NOTIFY_PART1", "Hallo,

{postauthor} hat im Thread
\"{threadtitle}\"
im Forum auf
{forumurl}
einen neuen Beitrag geschrieben.
");

@define ("PLUGIN_FORUM_EMAIL_NOTIFY_PART2", "
Dies ist der Text, den er schrieb:

----------------------------------------------------------------------
\"{replytext}\"
----------------------------------------------------------------------
");

@define ("PLUGIN_FORUM_EMAIL_NOTIFY_PART3", "
Du kannst diesen Thread besuchen, indem Du auf den folgenden Link
klickst:
{posturl}

");

@define('PLUGIN_FORUM_IMGDIR', 'Pfad zu dem Plugin');
@define('FORUM_PLUGIN_NEW_THREAD', 'Neuen Beitrag erstellen');
@define('PLUGIN_FORUM_IMGDIR_DESC', 'Der HTTP-Pfad, in dem das Plugin gespeichert wurde (wird ben�tigt um Bilder auszugeben).');

/* vim: set sts=4 ts=4 expandtab : */
