<?php

@define('LANG_ALL', 'Alle Sprachen');

@define('PLUGIN_STATICPAGELIST_NAME', 'Liste der statischen Seiten');
@define('PLUGIN_STATICPAGELIST_NAME_DESC', 'Dieses Plugin zeigt eine konfigurierbare Liste der statischen Seiten.');
@define('PLUGIN_STATICPAGELIST_TITLE', 'Titel');
@define('PLUGIN_STATICPAGELIST_TITLE_DESC', '�berschrift f�r die Sidebar:');
@define('PLUGIN_STATICPAGELIST_TITLE_DEFAULT', 'Statische Seiten');
@define('PLUGIN_STATICPAGELIST_LIMIT', 'Seitenanzahl');
@define('PLUGIN_STATICPAGELIST_LIMIT_DESC', 'Maximale Anzahl der anzuzeigenden Seiten. 0 ist alle.');
@define('PLUGIN_STATICPAGELIST_FRONTPAGE_NAME', 'Startseitenlink anzeigen');
@define('PLUGIN_STATICPAGELIST_FRONTPAGE_DESC', 'Einen Link zur Startseite erstellen');
@define('PLUGIN_STATICPAGELIST_FRONTPAGE_LINKNAME', 'Startseite');

@define('STATICPAGE_LIST_EXISTING_PAGES', 'Liste vorhandener statischer Seiten');
@define('STATICPAGE_HEADLINE', 'Kopfzeile');
@define('STATICPAGE_HEADLINE_BLAHBLAH', 'Zeigt eine Kopfzeile als Titel der statischen Seite an');
@define('STATICPAGE_TITLE', 'Statische Seiten');
@define('STATICPAGE_TITLE_BLAHBLAH', 'Verwaltet beliebige statische Seiten innerhalb des Blogs mit dem Blog-Design und allen Formatierungen. F�gt einen neuen Men�punkt in der Admin-Oberfl�che hinzu!');
@define('STATICPAGE_PAGETITLE', 'URL-Titel der Seite');
@define('STATICPAGE_PERMALINK', 'Permalink');
@define('STATICPAGE_PERMALINK_BLAHBLAH', 'Gibt den Permalink der statischen Seite an. Dieser muss eine absolute Pfadangabe vom HTTP-Root ab sein und die Dateiendung .htm oder .html besitzen!');
@define('CONTENT_BLAHBLAH', 'Der Inhalt');
@define('STATICPAGE_ARTICLEFORMAT', 'Als Artikel formatieren?');
@define('STATICPAGE_ARTICLEFORMAT_BLAHBLAH', 'Legt fest, ob die Ausgabe automatisch wie ein Artikel formatiert werden soll (Farben, R�nder, etc.) (Standard: ja)');
@define('STATICPAGE_ARTICLEFORMAT_PAGETITLE', 'Seitentitel f�r "Als Artikel formatieren"-Ansicht');
@define('STATICPAGE_ARTICLEFORMAT_PAGETITLE_BLAHBLAH', 'Wenn die Option "Als Artikel formatieren" gew�hlt ist kann durch diesen Titel bestimmt werden, was an der Stelle angezeigt wird, wo normalerweise das Blog-Datum dargestellt wird.');
@define('STATICPAGE_SELECT', 'Statische Seite zur Bearbeitung w�hlen.');
@define('STATICPAGE_PASSWORD_NOTICE', 'Diese Seite ist Passwortgesch�tzt. Bitte geben Sie das geeignete Passwort ein: ');
@define('STATICPAGE_PARENTPAGES_NAME', 'Elternseite');
@define('STATICPAGE_PARENTPAGE_DESC', 'Die �bergeordnete Seite ausw�hlen');
@define('STATICPAGE_PARENTPAGE_PARENT', 'Ist Elternseite');
@define('STATICPAGE_AUTHORS_NAME', 'Name des Autors');
@define('STATICPAGE_AUTHORS_DESC', 'Dieser Autor ist der Seiteninhaber');
@define('STATICPAGE_FILENAME_NAME', 'Template (Smarty)');
@define('STATICPAGE_FILENAME_DESC', 'Geben Sie den Dateinamen des Templates an, das f�r diese Seite genutzt werden soll. Diese Smarty-Datei kann sich entweder im Verzeichnis dieses Plugins befinden oder in ihrem Template-Ordner.');

@define('STATICPAGE_SHOWCHILDPAGES_NAME', 'Kinderseiten anzeigen');
@define('STATICPAGE_SHOWCHILDPAGES_DESC', 'Alle Kindseiten als Linkliste anzeigen.');
@define('STATICPAGE_PRECONTENT_NAME', 'Einleitung');
@define('STATICPAGE_PRECONTENT_DESC', 'Diese Einleitung wird vor den Kindseiten angezeigt.');
@define('STATICPAGE_CANNOTDELETE_MSG', 'Diese Seite kann nicht gel�scht werden. Es sind noch Kindseiten in der Datenbank. Diese m�ssen erst gel�scht werden.');
@define('STATICPAGE_IS_STARTPAGE', 'Diese Seite als Startseite definieren');
@define('STATICPAGE_IS_STARTPAGE_DESC', 'Anstatt der standardm��igen Serendipity Startseite wird diese statische Seite angezeigt. Nur eine Seite als Startseite definieren! Wenn Sie zur urspr�nglichen Startseite verlinken m�chten, muss nach "index.php?frontpage" verlinkt werden.');
@define('STATICPAGE_IS_404_PAGE', 'Diese Seite als 404-Fehler-Seite definieren');
@define('STATICPAGE_IS_404_PAGE_DESC', 'Mit dieser Option kann diese statische Seite als 404-Fehler-Seite verwendet werden. Dies darf jedoch nur f�r eine Seite definiert werden! Der Webserver muss zudem so konfiguriert sein, dass er diese Seite verwendet!');
@define('STATICPAGE_TOP', 'Hoch');
@define('STATICPAGE_LINKNAME', 'Bearbeiten');
@define('STATICPAGE_NEXT', 'Weiter');
@define('STATICPAGE_PREV', 'Zur�ck');

@define('STATICPAGE_ARTICLETYPE', 'Artikeltyp');
@define('STATICPAGE_ARTICLETYPE_DESC', 'Den Artikeltyp ausw�hlen, den die Seite erhalten soll.');

@define('STATICPAGE_CATEGORY_PAGEORDER', 'Seitenreihenfolge');
@define('STATICPAGE_CATEGORY_PAGES', 'Seiten bearbeiten');
@define('STATICPAGE_CATEGORY_PAGETYPES', 'Seitentypen bearbeiten');

@define('PAGETYPES_SELECT', 'Einen Seitentypen zum Bearbeiten ausw�hlen.');
@define('STATICPAGE_ARTICLETYPE_DESCRIPTION', 'Beschreibung');
@define('STATICPAGE_ARTICLETYPE_DESCRIPTION_DESC', 'Beschreibung der Seite.');
@define('STATICPAGE_ARTICLETYPE_TEMPLATE', 'Templatename');
@define('STATICPAGE_ARTICLETYPE_TEMPLATE_DESC', 'Der Name des Templates. Das Template kann im staticpages-plugin-Ordner oder im standardm��igen Template-Ordner sein.');
@define('STATICPAGE_ARTICLETYPE_IMAGE', 'Bildpfad');
@define('STATICPAGE_ARTICLETYPE_IMAGE_DESC', 'Die URL zu einem (Kategorie)-Bild.');

@define('STATICPAGE_USELMDATE_DEFAULT', 'Zeige als last_modified Datum im Eintragsfu�?');

@define('STATICPAGE_STATUS', 'Status');

@define('STATICPAGE_PLUGINS_INSTALLED', 'Plugin ist installiert');
@define('STATICPAGE_PLUGIN_AVAILABLE', 'Plugin ist verf�gbar, aber nicht installiert');
@define('STATICPAGE_PLUGIN_NOTAVAILABLE', 'Plugin ist nicht verf�gbar');
@define('STATICPAGE_PAGEADD_DESC', 'W�hlen Sie die Plugins aus, die in der Frontend Seitenleiste als zus�tzlicher "Staticpage"-Link zur Verf�gung stehen sollen.');
@define('STATICPAGE_PAGEADD_PLUGINS', 'Die folgenden Plugins k�nnen in die staticpage sidebar eingef�gt werden.');
@define('STATICPAGE_CATEGORY_PAGEADD', 'Andere Plugins');
@define('STATICPAGE_SEARCHRESULTS', 'Weitere %d Seiten gefunden:');

@define('STATICPAGE_MEDIA_DIRECTORY_MOVE_ENTRIES', 'Die URL der verschobenen Verzeichnisse wurde in %s statischen Seiten angepasst.');
#@define('STATICPAGE_MEDIA_DIRECTORY_MOVE_ENTRY', 'Bei Nicht-MySQL Datenbanken ist es nicht m�glich, jede statische Seite durchzugehen und das alte Verzeichnis durch das neue zu ersetzen. Daher m�ssen Sie manuell bestehende statische Seiten �berarbeiten und die neuen URLs eintragen. Sie k�nnen nat�rlich auch das Verzeichnis an seinen alten Platz zur�ckschieben, falls dies zu viel Aufwand bedeuten w�rde.');

@define('PLUGIN_LINKS_IMGDIR', 'Verzeichnis f�r Bilder dieses Plugins');
@define('PLUGIN_LINKS_IMGDIR_BLAHBLAH', 'Bitte geben Sie hier die URL ein, die zu dem Bildverzeichnis ihres Plugins f�hrt. Das eingegebene Verzeichnis muss einen "img"-Unterordner besitzen, der standardm��ig mit diesem Plugin auch ausgeliefert wird.');
@define('PLUGIN_STATICPAGELIST_ICON', 'JS Baumstruktur');
@define('PLUGIN_STATICPAGELIST_IMG_NAME', 'Grafiken f�r Baumstruktur aktivieren');
@define('PLUGIN_STATICPAGELIST_PARENTSONLY', 'Nur Eltern-Seiten darstellen?');
@define('PLUGIN_STATICPAGELIST_PARENTSONLY_DESC', 'Falls aktiviert werden nur Eltern-Seiten dargestellt. Andernfalls werden auch Unterseiten angezeigt.');
@define('PLUGIN_STATICPAGELIST_SHOWICONS_DESC', 'Baumstruktur oder einfache Textauflistung verwenden');
@define('PLUGIN_STATICPAGELIST_SHOWICONS_NAME', 'Icons bzw. Klartext');
@define('PLUGIN_STATICPAGELIST_TEXT', 'Klartext');
@define('STATICPAGE_DEFAULT_DESC', 'Standardeinstellung f�r neue Seiten');
@define('STATICPAGE_LANGUAGE_DESC', 'W�hlen Sie die Sprache dieser Seite');
@define('STATICPAGE_PAGEORDER_DESC', 'Hier kann die Reihenfolge der statischen Seiten ge�ndert werden');
@define('STATICPAGE_PUBLISHSTATUS', 'Artikelstatus');
@define('STATICPAGE_PUBLISHSTATUS_DESC', 'Artikelstatus dieser Seite (ver�ffentlicht oder im Entwurf)');
@define('STATICPAGE_SHOWARTICLEFORMAT_DEFAULT', 'Wie einen Blog-Eintrag formatieren');
@define('STATICPAGE_SHOWCHILDPAGES_DEFAULT', 'Unterseiten anzeigen');
@define('STATICPAGE_SHOWMARKUP_DEFAULT', 'Textformatierungs-Plugins anwenden');
@define('STATICPAGE_SHOWNAVI', 'Navigation anzeigen');
@define('STATICPAGE_SHOWNAVI_DEFAULT', 'Navigation anzeigen');
@define('STATICPAGE_SHOWNAVI_DESC', 'Zeigt eine Navigation f�r diese Seite an');
@define('STATICPAGE_SHOWONNAVI', 'In der Navigation der Seitenleiste einbinden');
@define('STATICPAGE_SHOWONNAVI_DEFAULT', 'Seite in Liste des Seitenleisten-Plugins anzeigen');
@define('STATICPAGE_SHOWONNAVI_DESC', 'Diese Seite in der Liste des Seitenleisten-Plugins anzeigen');
@define('STATICPAGE_SHOWMETA_DEFAULT', 'Zeige HTML Meta input Felder');
@define('STATICPAGE_SHOWTEXTORHEADLINE_HEADLINE', '�berschrift');
@define('STATICPAGE_SHOWTEXTORHEADLINE_NAME', '�berschriften oder Vor/Zur�ck-Navigation anzeigen?');
@define('STATICPAGE_SHOWTEXTORHEADLINE_TEXT', 'Text: Vor/Zur�ck');

@define('STATICPAGE_QUICKSEARCH_DESC', 'Wenn aktiviert, werden Suchergebnisse in den Statischen Seiten ber�cksichtigt.');

@define('STATICPAGE_CATEGORYPAGE','Zugeordnete statische Seite');
@define('STATICPAGE_RELATED_CATEGORY', 'Zugeordnete Kategorie');
@define('STATICPAGE_RELATED_CATEGORY_DESCRIPTION', 'U.a. k�nnen Eintr�ge einer Kategorie oder Links auf die Kategorie in einer statischen Seite eingebunden werden. N�heres in der "plugin_staticpage_related_category.tpl" und "README_FOR_RELATED_CATEGORIES.txt"');

@define('STATICPAGE_ARTICLE_OVERVIEW','Artikel�bersicht');
@define('STATICPAGE_NEW_HEADLINES','Aktuelle Schlagzeilen:');

@define('STATICPAGE_SECTION_META', 'HTML Metadaten');// As container title only in old default form template
@define('STATICPAGE_SECTION_BASIC', 'Seiteninhalt');
@define('STATICPAGE_SECTION_OPT', 'Konfigurieren');
@define('STATICPAGE_SECTION_STRUCT', 'Strukturieren');

@define('STATICPAGES_CUSTOMEXAMPLE_OPTION_SHOW', 'Benutzerdefinierte Optionen anzeigen');
@define('STATICPAGES_CUSTOM_OPTION_SHOW', 'KONFIGURATIONS Optionen anzeigen');
@define('STATICPAGES_CUSTOM_STRUCTURE_SHOW', 'STRUKTUR Optionen anzeigen');
@define('STATICPAGES_CUSTOM_META_SHOW', 'META FELD Optionen anzeigen');
@define('STATICPAGES_CUSTOM_META_TITLE', 'HTML META Seitentitel (optional)');
@define('STATICPAGES_CUSTOM_META_DESC', 'HTML META Seitenbeschreibung (optional)');
@define('STATICPAGES_CUSTOM_META_KEYS', 'HTML META Seiten Schl�sselw�rter (optional)');

@define('STATICPAGE_SHOW_BREADCRUMB_DEFAULT', 'Zeige Navigationspfad (Breadcrumbs)');
@define('STATICPAGE_SHOW_BREADCRUMB', 'Zeige Navigationspfad (Breadcrumbs)');
@define('STATICPAGE_SHOW_BREADCRUMB_DESC', 'Zeige auf dieser Seite den Navigationspfad (Breadcrumbs) an');

@define('STATICPAGE_SHOWLIST_DEFAULT', 'Zeige als Eintragsliste');
@define('STATICPAGE_SHOWLIST_DESC', 'Zeige Staticpage Backend Startseite als Eintrags-Liste oder als Auswahl-Liste.');
@define('STATICPAGE_SHOWLIST_NUMLIST', 'Zeige als "N" (6) Eintr�ge per Seite');

@define('STATICPAGE_CONFIRM_SELECTDIALOG', "Sind Sie sicher ihren offenen Artikel im Falle einer Ver�nderung gespeichert zu haben?\\n\\nWenn Sie OK dr�cken, wird die Seite gewechselt!"); // js confirm needs an additional backslash before the linebreaks!

@define('STATICPAGE_TOGGLEANDSAVE', '%s und merken!');

@define('CREATED_ON', 'Erstellt am');

@define('RELATED_CATEGORY_CHANGE_MSG', 'Dies hat eine vorherige, zugeordnete-Kategorie-Assoziierung von ID #%s, mit Staticpage ID #%s �berschrieben, da nur 1:1 Beziehungen erlaubt sind! Bitte �berpr�fen Sie beide statischen Seiten im Eingabeformular f�r statische Seiten, um diese �nderungen im ausgew�hlten Feld "zugeordnete Kategorie" zu best�tigen.');
@define('RELATED_CATEGORY_CHANGE_DEL_MSG', 'Das korrespondierende related_category_id Feld von Staticpage ID #%s wurde zur�ckgesetzt.');

@define('STATICPAGE_CONFIGGROUP_FORM', 'Backend Formular Voreinstellungen:');
@define('STATICPAGE_CONFIGGROUP_FRONTEND', 'Allgemeine Frontend Anzeigen:');
@define('STATICPAGE_CONFIGGROUP_BACKEND', 'Allgemeine Backend Anzeigen:');

@define('STATICPAGE_LANGUAGE_INFO', 'Dieses Sprach-Auswahl-Feld ist f�r die Nutzung als Multi-Sprachen-Blog ausgelegt (zB. in Kombination mit dem "Multilingual" Seitenleistenplugin,
                    oder einfach, wenn Autoren mit einer eigenen Spracheinstellung in den Eigenen Einstellungen eingeloggt sind).
                    Durch die Nutzung dieses Feldes k�nnen spezifische Statische Seiten nach Sprache erstellt werden, die auch nur dann angezeigt werden,
                    wenn das Frontend diese Sprache aktiv nutzt. "Alle Sprachen" meint "in jedem Fall".');

@define('PLAIN_ASCII', 'URLs sollten nur ASCII verwenden. [A-Za-z0-9]');
@define('STATICPAGE_RELCAT_INFO', 'Dies funktioniert <b>nur</b> in Kombination mit dem entries.tpl-Patch, der in der "README FOR RELATED CATEGORIES.txt" <a href="%s" target="_blank" rel="noopener" style="color:#7fdbff">Datei</a> beschrieben ist.<br>
                    F�r eine Frontend-Kategorien-Seite, mit einer Anzahl<span style="font-size:10px"><sup> (1)</sup></span> der letzten Eintrags-Links als Teaser, ist die beste Verwendung mit dem Artikeltyp: "<em>Staticpage with related category</em>" Feld in diesem Formular.
                    Bitte beachten Sie, dass nur einheitliche 1:1-Beziehungen zwischen Statischen Seiten und Kategorien erlaubt sind.<br><br>
                    <span style="font-size:10px"><sup>(1)</sup></span> Das �ndern der Menge der dargestellten Teaser-Eintragsverkn�pfungen erfolgt in der Datei "plugin staticpage related category.tpl" durch den konfigurierbaren Aufruf-Hook. Standard sind 5 Eintr�ge.');
@define('STATICPAGE_CUSTOMFIELDS_INFO', '<p>Dieser benutzerdefinierte Abschnitt verbessert die CMS-F�higkeiten von Serendipity erheblich und zeigt einige Beispiele f�r das Speichern von benutzerdefinierten Feldern f�r Statische Seiten.
                    Alle benutzerdefinierten Felder m�ssen durch �bliche HTML-Formularelemente implementiert werden und m�ssen ihre Werte in einem "serendipity[plugin][custom][XXX]" Feldnamen speichern.
                    Einmal eingegeben, werden die Daten automatisch in der "serendipity_staticpage_custom" Datenbanktabelle gespeichert und stehen als "&#123;$staticpage_custom.XXX&#125;" Smarty-Variable zur Verf�gung,
                    wenn sie sp�ter im Frontend angezeigt werden. Auf diese Weise k�nnen Sie ganz einfach neue benutzerdefinierte Felder f�r eine Statische Seite hinzuf�gen, zB. um f�r jede
                    Statische Seite ein benutzerdefiniertes Header-Image anzugeben. Die Verwendungsm�glichkeiten sind nahezu unbegrenzt!</p>
                    <p>Mit diesen optionalen Beispielen k�nnen Sie entweder eine benutzerdefinierte CSS-BODY-ID verwenden, um die Seite zu rendern.
                    Oder Sie k�nnen angeben, welche Seitenleiste Sie sehen m�chten, wenn diese Statische Seite gerendert wird.
                    Ein weiteres sch�nes Beispiel hierin ist es, einige verwandte Tags f�r diese Statische Seite zu definieren, um eine bestimmte Anzahl von Eintr�gen mit diesen Tags anzuzeigen,
                    so wie es das Freetag-Plugin f�r Blog Eintr�ge erlaubt.<br>
                    <span><strong>Bitte lesen Sie:</strong> </span> <a href="%s" target="_blank" rel="noopener" style="color:#7fdbff">the readme for custom fields</a>-Beispiele.</p>
                    <p>Die "Disable nl2br markup parser" Radio-Option wird bereits intern verwendet, um automatisch WYSIWYG-Eintr�ge von Statischen Seiten f�r die Speicherung zu markieren, auf dass sie folgend nicht durch das nl2br Markup-Parser Plugin bei der Anzeige ver�ndert werden.</p>');

@define('PLUGIN_STATICPAGE_PREVIEW', 'Die Voransicht ihrer statischen Seite wurde in einem neuen Browsertab ge�ffnet. Sonst benutzen Sie diesen: %s');

@define('STATICPAGE_FORM_FAIL', 'Die Erstellung einer neuen Seite ist fehlgeschlagen! Es ist mindestens eine eindeutige Einstellung in "' . STATICPAGE_PERMALINK . '" und in "' . STATICPAGE_PAGETITLE . '" erforderlich.');

