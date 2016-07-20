<?php

/**
 *  @version 1.0
 *  @author Konrad Bauckmeier <yourmail@example.com>
 *  @translated 2011/11/22
 */
@define('PLUGIN_DOWNLOADMANAGER_TITLE', 'Downloadmanager');
@define('PLUGIN_DOWNLOADMANAGER_DESC', 'Stellt einen kompletten Downloadmanager zur Verf�gung. Bei Deinstallation werden alle zugeh�rigen Tabellen gel�scht!');
@define('PLUGIN_DOWNLOADMANAGER_PAGETITLE', 'Seitentitel');
@define('PLUGIN_DOWNLOADMANAGER_PAGETITLE_BLAHBLAH', 'Titel der Seite');
@define('PLUGIN_DOWNLOADMANAGER_HEADLINE', 'Kopfzeile');
@define('PLUGIN_DOWNLOADMANAGER_HEADLINE_BLAHBLAH', 'Die Kopfzeile/Beschreibung der Seite');
@define('PLUGIN_DOWNLOADMANAGER_PAGEURL', 'Statische URL');
@define('PLUGIN_DOWNLOADMANAGER_PAGEURL_BLAHBLAH', 'Definiere hier den Namen der statischen URL (index.php?serendipity[subpage]=NAME)');
@define('PLUGIN_DOWNLOADMANAGER_PERMALINK', 'Permalink');
@define('PLUGIN_DOWNLOADMANAGER_PERMALINK_BLAHBLAH', 'Gibt den Permalink der statischen Download-Seite an, der sehr viel k�rzer sein kann als die statische URL. Der Permalink muss eine absolute Pfadangabe vom HTTP-Root sein und die Dateiendung .htm oder .html besitzen. (Default ist "%s")');
@define('PLUGIN_DOWNLOADMANAGER_ABSINCOMINGPATH', 'Pfad zu \'incoming\'');
@define('PLUGIN_DOWNLOADMANAGER_ABSINCOMINGPATH_BLAHBLAH', 'Voller, absoluter Pfad zum \'incoming\' Verzeichnis in welches man Dateien per FTP hochladen kann, um sie in den Downloadmanager zu importieren. (Zum Beispiel, wenn die Datei zu gross f�r den PHP-HTTP-Upload ist.)');
@define('PLUGIN_DOWNLOADMANAGER_ABSDOWNLOADPATH', 'Pfad zum \'download\' Verzeichnis');
@define('PLUGIN_DOWNLOADMANAGER_ABSDOWNLOADPATH_BLAHBLAH', 'Voller und absoluter Pfad zum Download-Verzeichnis, in welchem die Dateien gespeichert werden.');
@define('PLUGIN_DOWNLOADMANAGER_HTTPPATH', 'Pfad zum Downloadmanager Verzeichnis');
@define('PLUGIN_DOWNLOADMANAGER_HTTPPATH_BLAHBLAH', 'Absoluter Pfad zum Plugin-Verzeichnis, in welchem der Downloadmanager installiert ist (�blicherweise \'/plugins/serendipity_event_downloadmanager\').');
@define('PLUGIN_DOWNLOADMANAGER_DATEFORMAT', 'Format der Datumsanzeigen. Es werden die Variablen der PHP-Funktion date() verwendet (Default: \'Y/m/d, h:ia\')');
@define('PLUGIN_DOWNLOADMANAGER_SHOWFILEDATE', 'Datei-Datum anzeigen');
@define('PLUGIN_DOWNLOADMANAGER_SHOWFILEDATE_BLAHBLAH', 'Soll das Datum einer Datei in der Dateiliste angezeigt werden?');
@define('PLUGIN_DOWNLOADMANAGER_SHOWFILENAME', 'Dateinamen anzeigen');
@define('PLUGIN_DOWNLOADMANAGER_SHOWFILENAME_BLAHBLAH', 'Soll der Name einer Datei in der Dateiliste angezeigt werden?');
@define('PLUGIN_DOWNLOADMANAGER_SHOWFILESIZE', 'Dateigr��e anzeigen');
@define('PLUGIN_DOWNLOADMANAGER_SHOWFILESIZE_BLAHBLAH', 'Soll die Gr��e einer Datei in der Dateiliste angezeigt werden?');
@define('PLUGIN_DOWNLOADMANAGER_SHOWDOWNLOADS', 'Anzahl der Datei-Downloads');
@define('PLUGIN_DOWNLOADMANAGER_SHOWDOWNLOADS_BLAHBLAH', 'Soll die Anzahl der bisherigen Download einer Datei in der Dateiliste angezeigt werden?');
@define('PLUGIN_DOWNLOADMANAGER_FILENAME_FIELD', 'Bezeichnung des Dateinamen-Felds');
@define('PLUGIN_DOWNLOADMANAGER_FILENAME_FIELD_BLAHBLAH', 'Eintragen eines beliebigen Namens f�r das Dateinamen-Feld in der Dateiliste');
@define('PLUGIN_DOWNLOADMANAGER_FILESIZE_FIELD', 'Bezeichnung des Dateigr��e-Felds');
@define('PLUGIN_DOWNLOADMANAGER_FILESIZE_FIELD_BLAHBLAH', 'Eintragen eines beliebigen Namens f�r das Dateigr��e-Feld in der Dateiliste');
@define('PLUGIN_DOWNLOADMANAGER_FILEDATE_FIELD', 'Bezeichnung des Dateidatum-Felds');
@define('PLUGIN_DOWNLOADMANAGER_FILEDATE_FIELD_BLAHBLAH', 'Eintragen eines beliebigen Namens f�r das Dateidatum-Feld in der Dateiliste');
@define('PLUGIN_DOWNLOADMANAGER_DLS_FIELD', 'Bezeichnung des \'Anzahl bisheriger Downloads\'-Felds');
@define('PLUGIN_DOWNLOADMANAGER_DLS_FIELD_BLAHBLAH', 'Eintragen eines beliebigen Namens f�r das \'Anzahl bisheriger Downloads\'-Feld in der Dateiliste');
@define('PLUGIN_DOWNLOADMANAGER_ICONWIDTH', 'Icon Breite');
@define('PLUGIN_DOWNLOADMANAGER_ICONWIDTHBLAH', 'Breite der Dateiicons in der Dateiliste');
@define('PLUGIN_DOWNLOADMANAGER_ICONHEIGHT', 'Icon H�he');
@define('PLUGIN_DOWNLOADMANAGER_ICONHEIGHT_BLAHBLAH', 'H�he der Dateiicons in der Dateiliste');
@define('PLUGIN_DOWNLOADMANAGER_SHOWHIDDEN_REGISTERED', 'Versteckte Kategorien f�r registrierte User zeigen?');
@define('PLUGIN_DOWNLOADMANAGER_SHOWHIDDEN_REGISTERED_BLAHBLAH', 'Sollen versteckte Kategorien f�r registrierte und eingeloggte User sichtbar sein?');

@define('PLUGIN_DOWNLOADMANAGER_NO_CATS_FOUND', 'Keine Kategorien gefunden!');
@define('PLUGIN_DOWNLOADMANAGER_CATEGORIES', 'Kategorien');
@define('PLUGIN_DOWNLOADMANAGER_SUBCATEGORIES', 'Unter-Kategorien');
@define('PLUGIN_DOWNLOADMANAGER_CATEGORY', 'Kategorie');
@define('PLUGIN_DOWNLOADMANAGER_NUMBER_OF_DOWNLOADS', '# Dateien');
@define('PLUGIN_DOWNLOADMANAGER_CATNAME', 'Kategorie-Name:');
@define('PLUGIN_DOWNLOADMANAGER_SUBCAT_OF', 'Unter-Kategorie von:');
@define('PLUGIN_DOWNLOADMANAGER_ADD_CAT', 'Neue Kategorie erstellen');
@define('PLUGIN_DOWNLOADMANAGER_DEL_FILE', 'Diese Datei l�schen...');
@define('PLUGIN_DOWNLOADMANAGER_DEL_CAT', 'Diese Kategorie l�schen (Und alle darin enthaltenen Dateien!)...');
@define('PLUGIN_DOWNLOADMANAGER_DEL_CAT_NOT_ALLOWD', 'L�schen nicht erlaubt! Kategorie hat Unter-Kategorien');
@define('PLUGIN_DOWNLOADMANAGER_DELETE_NOT_ALLOWED', 'Diese Kategorie kann nicht gel�scht werden, da sie mindestens eine Unter-Kategorie enth�lt!');
@define('PLUGIN_DOWNLOADMANAGER_CAT_NOT_FOUND', 'Kategorie nicht gefunden!');
@define('PLUGIN_DOWNLOADMANAGER_DLS_IN_THIS_CAT', 'Dateien in dieser Kategorie');
@define('PLUGIN_DOWNLOADMANAGER_BACK', 'Zur�ck');
@define('PLUGIN_DOWNLOADMANAGER_FILENAME', 'Dateiname');
@define('PLUGIN_DOWNLOADMANAGER_FILESIZE', 'Dateigr��e');
@define('PLUGIN_DOWNLOADMANAGER_FILEDATE', 'Datum');
@define('PLUGIN_DOWNLOADMANAGER_NUM_DOWNLOADS', 'dls');
@define('PLUGIN_DOWNLOADMANAGER_NUM_DOWNLOADS_BLAH', 'Anzahl der Downloads');
@define('PLUGIN_DOWNLOADMANAGER_IMPORT_FILE', 'Importieren von dieser Datei in die aktuelle Kategorie...');
@define('PLUGIN_DOWNLOADMANAGER_COPY_NOT_ALLOWED', 'Konnte Datei nicht in das Download-Verzeichnis kopieren!<br />Dies kann zB. passieren, wenn das encoding nicht stimmt, oder wenn der SAFE_MODE aktiviert ist<br />Bitte SAFE_MODE in der php.ini deaktivieren!');
@define('PLUGIN_DOWNLOADMANAGER_DELETE_IN_INCOMING_NOT_ALLOWED', 'Konnte die Datei im Import-Verzeichnis nicht l�schen, da keine Schreibberechtigung bestand.<br />Bitte Berechtigungen �ndern!');
@define('PLUGIN_DOWNLOADMANAGER_DELETE_IN_DOWNLOADDIR_NOT_ALLOWED', 'Konnte die Datei im Download-Verzeichnis nicht l�schen, da keine Schreibberechtigung bestand.<br />Bitte Berechtigungen �ndern!');
/*@define('PLUGIN_DOWNLOADMANAGER_INCOMINGTABLE', 'incoming Verzeichnis:');*/
@define('PLUGIN_DOWNLOADMANAGER_INCOMINGTABLE_BLAHBLAH', 'Dieses Verzeichnis "%s"
<ul>
    <li>erm�glicht den Import von per FTP hochgeladenen Dateien in die aktuelle Kategorie "<strong>%s</strong>"</li>
    <li>fungiert als ein tempor�res(!) Zwischenverzeichnis f�r zu verschiebene oder gel�schte Dateien und</li>
    <li>erlaubt die vollst�ndige L�schung aller hier befindlichen Dateien (�ber das blaue Trash Symbol).</li>
    <li>Um Dateien l�ngerfristig zu verstecken nutzen Sie das Stamm-Verzeichnis. Siehe DLM Help Box.</li>
</ul>');
@define('PLUGIN_DOWNLOADMANAGER_THIS_FILE', 'Gew�hlte Datei');
@define('PLUGIN_DOWNLOADMANAGER_EDIT_FILE', 'Diese Datei �ndern');
@define('PLUGIN_DOWNLOADMANAGER_MOVE_TO_CAT', 'Diese Datei verschieben nach');
@define('PLUGIN_DOWNLOADMANAGER_EDIT_FILE_DESC', 'Dateibeschreibung');
@define('PLUGIN_DOWNLOADMANAGER_FILE_EDITED', 'Datei erfolgreich gespeichert!');
@define('PLUGIN_DOWNLOADMANAGER_DOWNLOAD_FILE', 'Diese Datei herunterladen');
@define('PLUGIN_DOWNLOADMANAGER_UPLOAD_FILE', 'Dateien hochladen');
@define('PLUGIN_DOWNLOADMANAGER_FILE', 'Datei');
@define('PLUGIN_DOWNLOADMANAGER_UPLOAD_NOT_ALLOWED', 'Datei-Upload ist nicht erlaubt<br />Bitte in der php.ini aktivieren (file_uploads)!');
@define('PLUGIN_DOWNLOADMANAGER_ERRORS_OCCOURED', 'Es sind Fehler beim Upload aufgetreten!');
@define('PLUGIN_DOWNLOADMANAGER_ERRORS_NOTCOPIED', 'Diese Dateien konnten nicht kopiert werden:');
@define('PLUGIN_DOWNLOADMANAGER_ERRORS_TOOBIG', 'Diese Dateien waren zu gro�:');
@define('PLUGIN_DOWNLOADMANAGER_NO_FILES_UPLOADED', 'Keine hochgeladenen Dateien gefunden!');
@define('PLUGIN_DOWNLOADMANAGER_MEDIA_LIBRARY', 'Dateien aus der Mediendatenbank');
@define('PLUGIN_DOWNLOADMANAGER_MEDIA_LIBRARY_BLAHBLAH', 'Hier k�nnen bereits hochgeladene Dateien aus der Mediendatenbank in den Downloadmanager importiert werden. Diese Dateien werden nicht verschoben, sondern nur kopiert!<br />Aktuelles Verzeichnis: ');
@define('PLUGIN_DOWNLOADMANAGER_HIDE_TREE', 'Diese Kategorie und alle Unterkategorien verstecken...');
@define('PLUGIN_DOWNLOADMANAGER_UNHIDE_TREE', 'Diese Kategorie und alle Unterkategorien wieder zeigen...');
@define('PLUGIN_DOWNLOADMANAGER_OPEN_CAT', 'Klicken um die Kategorie zu �ffnen um Dateien hochzuladen oder zu modifizieren...');

@define('PLUGIN_DOWNLOADMANAGER_SHOWDESC_INLIST',       'Dateibeschreibungen in der Dateiliste');
@define('PLUGIN_DOWNLOADMANAGER_SHOWDESC_INLIST_DESC',  'Wenn Sie eine kompakte Liste wollen, so schalten Sie dies aus. Wenn Sie dem Benutzer viele Informationen geben wollen, schalten Sie diese Option an.');
@define('PLUGIN_DOWNLOADMANAGER_DOWNLOAD_INLIST',       'Dateien direkt in der Dateiliste herunter laden');
@define('PLUGIN_DOWNLOADMANAGER_DOWNLOAD_INLIST_DESC',  'Normalerweise wird dem Besucher immer eine Informationsseite angezeigt, bevor er die Datei herunter laden kann. Hier k�nnen Sie einstellen, dass man bei einem Klick auf das Icon, den Namen oder beides direkt den Download startet.');
@define('PLUGIN_DOWNLOADMANAGER_DOWNLOAD_INLIST_NO',    'Immer Infoseite anzeigen');
@define('PLUGIN_DOWNLOADMANAGER_DOWNLOAD_INLIST_ICON',  'Download �ber Icon');
@define('PLUGIN_DOWNLOADMANAGER_DOWNLOAD_INLIST_NAME',  'Download �ber Dateiname');
@define('PLUGIN_DOWNLOADMANAGER_DOWNLOAD_INLIST_BOTH',  'Download �ber beides');
@define('PLUGIN_DOWNLOADMANAGER_ADD_EXISTING',          'Neue Versionen von existierenden Dateien sollen..');
@define('PLUGIN_DOWNLOADMANAGER_ADD_EXISTING_DESC',     'Wenn Sie eine Datei hoch geladen haben, die bereits existiert, soll ein neuer Eintrag f�r diese Datei erzeugt werden oder soll der alte Eintrag mit den neuen Datei Informationen erneuert werden?');
@define('PLUGIN_DOWNLOADMANAGER_ADD_EXISTING_INSERT',   'neue Eintr�ge erzeugen');
@define('PLUGIN_DOWNLOADMANAGER_ADD_EXISTING_UPDATE',   'alte Eintr�ge erneuern');

/* changed with 0.22 and up - uncommented above */
@define('PLUGIN_DOWNLOADMANAGER_INCOMINGTABLE', 'income ftp/trash Verzeichnis:');

/* newly shipped with 0.22 and up */
@define('PLUGIN_DOWNLOADMANAGER_BACKEND_TITLE', 'Downloadmanager v.%s - Backend Admin Men�');
@define('PLUGIN_DOWNLOADMANAGER_INTRO', 'Einf�hrungstext (optional)');
@define('PLUGIN_DOWNLOADMANAGER_REGISTERED_ONLY', 'Allgemein: Zeige Data nur registrierten Benutzern');
@define('PLUGIN_DOWNLOADMANAGER_REGISTERED_ONLY_BLAHBLAH', 'Sollen die Kategorien und Downloads im Frontend nur registrierten und eingeloggten Benutzern dieses Blogs zur Verf�gung stehen?');
@define('PLUGIN_DOWNLOADMANAGER_REGISTERED_ONLY_ERROR', 'Die Downloads stehen nur registrierten Benutzern dieses Blogs zur Verf�gung!');
@define('PLUGIN_DOWNLOADMANAGER_ROOTLEVEL_TITLE', 'Dateien auf der Rootebene (versteckt im Frontend!)');
@define('PLUGIN_DOWNLOADMANAGER_ERRORS_UPGRADE_NOTCOPIED', 'Entschuldigung! Ein Fehler trat w�hrend des upgrade Prozesses auf. Die Dateien aus<br /><em>%s</em><br />konnten nicht nach<br /><em>%s</em><br />verschoben werden.<br /><br />Bitte verschieben Sie sie manuell und dr�cken sie <a class="backend_error_link" href="%s">diesen Link</a>, um das Plugin dar�ber zu informieren!<br />L�schen Sie die alten Verzeichnisse ebenfalls manuell.<br />');
#@define('PLUGIN_DOWNLOADMANAGER_ALLFILES_COPIED_NEWDIR', 'Da Sie das Downloadmanager Plugin auf v.0.24 hochgestuft haben, wurden alle alten Dateien in das neue \'/.dlm/files\' und \'/.dlm/ftpin\' Verzeichnis im Serendipity \'/archives\' Verzeichnis verschoben, um Konflikte mit dem alten Pfad zu vermeiden.<br /><br />Die Config Einstellungen wurden auf die neuen Pfade angepasst und sind k�nftig nicht mehr ver�nderbar.<br />L�schen Sie die alten Verzeichnisse manuell.<br />');
#@define('PLUGIN_DOWNLOADMANAGER_ALLFILES_COPY_NEWDIR_REMEMBER', 'Sie haben dem Plugin erfolgreich mitgeteilt, nur noch die neuen Pfade zu akzeptieren.<br /><br />Bitte denken Sie daran, ihre Dateien manuell in das neue \'archives/.dlm/files\' und \'archives/.dlm/ftpin\' Verzeichnis zu verschieben!<br />L�schen Sie die alten Verzeichnisse ebenfalls manuell.<br />');
@define('PLUGIN_DOWNLOADMANAGER_BUTTON_MARK', 'alle markieren / unmarkieren');
@define('PLUGIN_DOWNLOADMANAGER_BUTTON_MARK_TITLE', 'markierte l�schen nach ftp/trash');
@define('PLUGIN_DOWNLOADMANAGER_BUTTON_MOVE_TITLE', 'markierte in Kategorie verschieben');
@define('PLUGIN_DOWNLOADMANAGER_CLEAR_TRASH', 'L�sche alle Dateien im ftp/trash Verzeichnis');
@define('PLUGIN_DOWNLOADMANAGER_NO_TRASH', 'Kein M�ll im ftp/trash Verzeichnis');
@define('PLUGIN_DOWNLOADMANAGER_EDIT_FILE_RENAME', 'Datei umbenennen in');
/* HELPTIP_CF = category folder; HELPTIP_IF = incoming folder; HELPTIP_FF = file folder; HELPTIP_MF = s9y media library folder; */
@define('PLUGIN_DOWNLOADMANAGER_HELPTIP_CF_START', 'Start: Erstellen Sie eine Kategorie, um Dateien hochzuladen.');
@define('PLUGIN_DOWNLOADMANAGER_HELPTIP_CF_CHANGE', 'Kategorie Name im Feld selbst �ndern / <em>Enter</em>');
@define('PLUGIN_DOWNLOADMANAGER_HELPTIP_IF_VIEW', 'Um das ftp/trash Verzeichnis zu sehen, w�hlen sie einen Subordner von root.');
@define('PLUGIN_DOWNLOADMANAGER_HELPTIP_FF_MULTI', 'Alle Dateien im ftp/trash Verzeichnis werden sofort gel�scht!');
@define('PLUGIN_DOWNLOADMANAGER_HELPTIP_FF_SINGLE', 'Alle L�schungen �ber den aktiven roten Button werden sofort gel�scht!');
@define('PLUGIN_DOWNLOADMANAGER_HELPTIP_IF_ERASE', 'Alle markierten und gel�schten (x) Dateien, werden in das ftp/trash Verzeichnis <b>verschoben</b>,<br />&nbsp;&nbsp;&nbsp;um das versehentliche L�schen vieler Dateien zu vermeiden!');
@define('PLUGIN_DOWNLOADMANAGER_HELPTIP_FF_KEEP', 'Dateien behalten, aber nicht im Frontend zeigen? Verschieben Sie sie in den root Ordner,<br />&nbsp;&nbsp;&nbsp;oder erstellen Sie einen verstecken Subordner! Beachten Sie, dass es 2 Config Einstellungen<br />&nbsp;&nbsp;&nbsp;bez�glich registrierter und eingeloggter Benutzer des Blog im Frontend gibt.');
@define('PLUGIN_DOWNLOADMANAGER_HELPTIP_FF_CHANGE', 'Datei Name �ndern auf der Datei-Link Sub-Seite.');
@define('PLUGIN_DOWNLOADMANAGER_HELPTIP_IF_LFTP', 'Laden Sie Dateien per FTP in den /serendipity/archives/.dlm/ftpin Ordner.');
@define('PLUGIN_DOWNLOADMANAGER_HELPTIP_IF_TRASH', 'Nutzen Sie die blauen Trashboxen, um das ftp/trash Verzeichnis nach beendeter Arbeit zu leeren!');
@define('PLUGIN_DOWNLOADMANAGER_HELPTIP_IF_MOVE', 'Nutzen Sie das ftp/trash Verzeichnis, um mehrere Dateien zwischen Ordnern zu verschieben!<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;1. Senden Sie �ber <b>markieren</b> <em>und</em> <b>l�schen</b> mehrere Dateien in das ftp/trash Verzeichnis;<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;2. In den Kategorien, w�hlen Sie einen anderen Subordner;<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;3. �ffnen Sie das ftp/trash Verzeichnis, <b>markieren</b> <em>und</em> <b>verschieben</b> Sie die Dateien.');
@define('PLUGIN_DOWNLOADMANAGER_HELPTIP_DESC', 'Bei der Deinstallation dieses Plugins werden alle zugeh�rigen Tabellen gel�scht!');
/*
@define('PLUGIN_DOWNLOADMANAGER_HELPTIP_IF_VIEW', '');
@define('PLUGIN_DOWNLOADMANAGER_HELPTIP_IF_VIEW', '');
*/

// Next lines were translated on 2011/11/22
@define('PLUGIN_DOWNLOADMANAGER_BACK_ROOT', 'Wurzel-Kategorie');
@define('PLUGIN_DOWNLOADMANAGER_BACK_CURRENT', 'Aktuelle Kategorie');

