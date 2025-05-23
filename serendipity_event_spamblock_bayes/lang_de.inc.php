<?php

/**
 * @version
 * @author Translator Name <yourmail@example.com>
 * EN-Revision: Revision of lang_en.inc.php
 */

@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_NAME', 'Spamschutz (Bayes)');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_DESC', 'Filtert Kommentare mittels eines lernenden Algorithmus.');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_HAM', 'Valid');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_SPAM', 'Spam');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_ERROR', 'Als Spam eingestuft, wird vielleicht moderiert.');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_MODERATE', 'Als Spam erkannt, wird moderiert.');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_METHOD_MODERATE', 'Moderieren');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_METHOD_BLOCK', 'Abweisen');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_RECYCLER_DESC', 'Sollen abgewiesene Kommentare im Papierkorb gespeichert werden?');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_RECYCLER_EMPTY', 'Papierkorb leeren');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_RESTORE', 'Wiederherstellen');
@define('PLUGIN_EVENT_SPAMBLOCK_METHOD', 'Spambehandlung');
@define('PLUGIN_EVENT_SPAMBLOCK_METHOD_DESC', 'Ab einer Spambewertung von 80% werden Kommentare moderiert oder abgewiesen.');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_MENU_RECYCLER', 'Papierkorb');
//old
#@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_DIRECTBLOCK', 'Direktes Abweisen');
#@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_DIRECTBLOCK_DESC', 'Weist Spam-Kommentare direkt ab anstatt sie erst zu moderieren.');
#@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_AUTOLEARN', 'Lernen');
#@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_AUTOLEARN_DESC', 'Sehr eindeutige Spam-Kommentare werden direkt als Spam gelernt. So k�nnen schleichend stattfindende Modifikationen am Spam automatisch erfasst werden.');
#@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_LOGFILE', 'Speicherplatz f�r das Logfile');
#@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_LOGFILE_DESC', 'Einige Informationen �ber die Abweisung/Moderation von Kommentaren kann in ein Logfile geschrieben werden. Wenn diese Option auf einen leeren Wert gesetzt wird, findet keine Protokollierung statt.');
#@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_LOGTYPE', 'Protokollierung von fehlgeschlagenen Kommentaren');
#@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_LOGTYPE_DESC', 'Die Protokollierung von fehlgeschlagenen Kommentaren und deren Gr�nden kann auf mehrere Arten durchgef�hrt werden.');
#@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_LOGTYPE_FILE', 'Einfache Datei (siehe Option "Logfile")');
#@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_LOGTYPE_DB', 'Datenbank');
#@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_LOGTYPE_NONE', 'Keine Protokollierung');
#@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_REASON', 'Vom Bayes-Plugin als Spam erkannt');
#@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_RATING_EXPLANATION', 'Spamfaktor des Spamblock-Bayes-Plugins.');
#@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_DELETE', 'Kommentar l�schen und als Spam markieren');
#@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_APPROVE', 'Kommentar bewilligen und als valid markieren');
#@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_PATH', 'Plugin-Pfad');
#@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_PATH_DESC', 'Wird hier der Pluginpfad angegeben wird dieser nicht mehr dynamisch ermittelt, was einen deutlichen Leistungsgewinn einbringt. Beispiel: https://www.example.com/plugins/serendipity_event_spamblock_bayes/ (das / am Ende ist wichtig).');
#@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_BARRIER_MODERATE', 'Manuelle Moderationsgrenze');
#@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_BARRIER_MODERATE_DESC', 'Wenn die Option "Spambehandlung" auf "Manuelle Grenzen" gesetzt wird: Ab welchem Spamfaktor soll moderiert werden? (in %)');
#@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_BARRIER_BLOCK', 'Manuelle Abweisungsgrenze');
#@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_BARRIER_BLOCK_DESC', 'Wenn die Option "Spambehandlung" auf "Manuelle Grenzen" gesetzt wird: Ab welchem Spamfaktor soll abgewiesen werden? (in %)');
#@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_METHOD_CUSTOM', 'Manuelle Grenzen');
#@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_SPAMBUTTON', 'Als Spam lernen');
#@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_HAMBUTTON', 'Als valid lernen');
#@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_MENU_LEARN', 'Lernen');
#@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_MENU_DATABASE', 'Datenbank');
#@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_CREATEDB', 'Datenbank erstellen');
#@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_LEARNOLD', 'Kommentare einlernen');
#@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_ERASEDB', 'Datenbank l�schen');
#@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_SAVEDVALUES', 'Eingeordnete Kommentare');
#@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_MENU', 'Men�');
#@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_MENU_DESC', 'Verlinke das erweiterte Men� im Adminbereich.');
#@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_MENU_ANALYSIS', 'Analyse');
#@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_RECYCLER_DELETE', 'Papierkorbgrenze');
#@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_RECYCLER_DELETE_DESC', 'Ab welcher Bewertung soll ein Kommentar direkt gel�scht anstatt in den Papierkorb verschoben zu werden? Beispiel: 98');
#@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_IGNORE', 'Ignorieren');
#@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_IGNORE_DESC', 'Gibt Kommentarfelder an, die ignoriert werden sollen. M�glich sind: ip, referer, author, body, email, url. Beispiel: "ip, referer".');
#@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_EXPORTDB', 'Datenbank exportieren');
#@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_IMPORTDB', 'Datenbank importieren');
#@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_IMPORT_EXPLANATION', 'Hier kann eine CSV-Datei, die in einem anderen Blog mit der Export-Funktion erstellt wurde, importiert werden. Die enthaltenen Daten �ber Spam und valide Kommentare werden der eigenen Datenbank hinzugef�gt.');
#@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_MENU_IMPORT', 'Import');
#@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_IMPORT_EXPLANATION', 'Importiert eine CVS-Datei, deren Inhalt der Spamdatenbank hinzugef�gt wird.');
#@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_TROJA_EXPLANATION', 'Die Spamdatenbank eines registrierten Blogs einlernen oder das eigene Blog als Quelle hinzuf�gen.');
#@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_TROJA', 'Online-Import');
#@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_TROJA_IMPORT', 'Importieren');
#@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_TROJA_REGISTER', 'Blog hinzuf�gen');
#@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_TROJA_REMOVE', 'Blog entfernen');
#@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_RATING', 'Bewertung');
#@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_RECYCLER_EMPTY_ALL', 'Papierkorb komplett leeren');
#@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_RECYCLER_EMPTY_ALL_DESC', 'L�sche alle Kommentare im Papierkorb, nicht nur die auf der momentanen Seite.');

