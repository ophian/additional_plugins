<?php

@define('LANG_ALL', 'Alle Sprachen');

@define('PLUGIN_STATICPAGELIST_NAME', 'Liste der statischen Seiten');
@define('PLUGIN_STATICPAGELIST_NAME_DESC', 'Dieses Plugin zeigt eine konfigurierbare Liste der statischen Seiten.');
@define('PLUGIN_STATICPAGELIST_TITLE', 'Titel');
@define('PLUGIN_STATICPAGELIST_TITLE_DESC', 'Überschrift für die Sidebar:');
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
@define('STATICPAGE_TITLE_BLAHBLAH', 'Verwaltet beliebige statische Seiten innerhalb des Blogs mit dem Blog-Design und allen Formatierungen. Fügt einen neuen Menüpunkt in der Admin-Oberfläche hinzu!');
@define('STATICPAGE_PAGETITLE', 'URL-Titel der Seite');
@define('STATICPAGE_PERMALINK', 'Permalink');
@define('STATICPAGE_PERMALINK_BLAHBLAH', 'Gibt den Permalink der statischen Seite an. Dieser muss eine absolute Pfadangabe vom HTTP-Root ab sein und die Dateiendung .htm oder .html besitzen!');
@define('CONTENT_BLAHBLAH', 'Der Inhalt');
@define('STATICPAGE_ARTICLEFORMAT', 'Als Artikel formatieren?');
@define('STATICPAGE_ARTICLEFORMAT_BLAHBLAH', 'Legt fest, ob die Ausgabe automatisch wie ein Artikel formatiert werden soll (Farben, Ränder, etc.) (Standard: ja)');
@define('STATICPAGE_ARTICLEFORMAT_PAGETITLE', 'Seitentitel für "Als Artikel formatieren"-Ansicht');
@define('STATICPAGE_ARTICLEFORMAT_PAGETITLE_BLAHBLAH', 'Wenn die Option "Als Artikel formatieren" gewählt ist kann durch diesen Titel bestimmt werden, was an der Stelle angezeigt wird, wo normalerweise das Blog-Datum dargestellt wird.');
@define('STATICPAGE_SELECT', 'Statische Seite zur Bearbeitung wählen.');
@define('STATICPAGE_PASSWORD_NOTICE', 'Diese Seite ist Passwortgeschützt. Bitte geben Sie das geeignete Passwort ein: ');
@define('STATICPAGE_PARENTPAGES_NAME', 'Elternseite');
@define('STATICPAGE_PARENTPAGE_DESC', 'Die übergeordnete Seite auswählen');
@define('STATICPAGE_PARENTPAGE_PARENT', 'Ist Elternseite');
@define('STATICPAGE_AUTHORS_NAME', 'Name des Autors');
@define('STATICPAGE_AUTHORS_DESC', 'Dieser Autor ist der Seiteninhaber');
@define('STATICPAGE_FILENAME_NAME', 'Template (Smarty)');
@define('STATICPAGE_FILENAME_DESC', 'Geben Sie den Dateinamen des Templates an, das für diese Seite genutzt werden soll. Diese Smarty-Datei kann sich entweder im Verzeichnis dieses Plugins befinden oder in ihrem Template-Ordner.');

@define('STATICPAGE_SHOWCHILDPAGES_NAME', 'Kinderseiten anzeigen');
@define('STATICPAGE_SHOWCHILDPAGES_DESC', 'Alle Kindseiten als Linkliste anzeigen.');
@define('STATICPAGE_PRECONTENT_NAME', 'Einleitung');
@define('STATICPAGE_PRECONTENT_DESC', 'Diese Einleitung wird vor den Kindseiten angezeigt.');
@define('STATICPAGE_CANNOTDELETE_MSG', 'Diese Seite kann nicht gelöscht werden. Es sind noch Kindseiten in der Datenbank. Diese müssen erst gelöscht werden.');
@define('STATICPAGE_IS_STARTPAGE', 'Diese Seite als Startseite definieren');
@define('STATICPAGE_IS_STARTPAGE_DESC', 'Anstatt der standardmäßigen Serendipity Startseite wird diese statische Seite angezeigt. Nur eine Seite als Startseite definieren! Wenn Sie zur ursprünglichen Startseite verlinken möchten, muss nach "index.php?frontpage" verlinkt werden.');
@define('STATICPAGE_IS_404_PAGE', 'Diese Seite als 404-Fehler-Seite definieren');
@define('STATICPAGE_IS_404_PAGE_DESC', 'Mit dieser Option kann diese statische Seite als 404-Fehler-Seite verwendet werden. Dies darf jedoch nur für eine Seite definiert werden! Der Webserver muss zudem so konfiguriert sein, dass er diese Seite verwendet!');
@define('STATICPAGE_TOP', 'Hoch');
@define('STATICPAGE_LINKNAME', 'Bearbeiten');
@define('STATICPAGE_NEXT', 'Weiter');
@define('STATICPAGE_PREV', 'Zurück');

@define('STATICPAGE_ARTICLETYPE', 'Artikeltyp');
@define('STATICPAGE_ARTICLETYPE_DESC', 'Den Artikeltyp auswählen, den die Seite erhalten soll.');

@define('STATICPAGE_CATEGORY_PAGEORDER', 'Seitenreihenfolge');
@define('STATICPAGE_CATEGORY_PAGES', 'Seiten bearbeiten');
@define('STATICPAGE_CATEGORY_PAGETYPES', 'Seitentypen bearbeiten');

@define('PAGETYPES_SELECT', 'Einen Seitentypen zum Bearbeiten auswählen.');
@define('STATICPAGE_ARTICLETYPE_DESCRIPTION', 'Beschreibung');
@define('STATICPAGE_ARTICLETYPE_DESCRIPTION_DESC', 'Beschreibung der Seite.');
@define('STATICPAGE_ARTICLETYPE_TEMPLATE', 'Templatename');
@define('STATICPAGE_ARTICLETYPE_TEMPLATE_DESC', 'Der Name des Templates. Das Template kann im staticpages-plugin-Ordner oder im standardmäßigen Template-Ordner sein.');
@define('STATICPAGE_ARTICLETYPE_IMAGE', 'Bildpfad');
@define('STATICPAGE_ARTICLETYPE_IMAGE_DESC', 'Die URL zu einem (Kategorie)-Bild.');

@define('STATICPAGE_USELMDATE_DEFAULT', 'Zeige als last_modified Datum im Eintragsfuß?');

@define('STATICPAGE_STATUS', 'Status');

@define('STATICPAGE_PLUGINS_INSTALLED', 'Plugin ist installiert');
@define('STATICPAGE_PLUGIN_AVAILABLE', 'Plugin ist verfügbar, aber nicht installiert');
@define('STATICPAGE_PLUGIN_NOTAVAILABLE', 'Plugin ist nicht verfügbar');
@define('STATICPAGE_PAGEADD_DESC', 'Wählen Sie die Plugins aus, die in der Frontend Seitenleiste als zusätzlicher "Staticpage"-Link zur Verfügung stehen sollen.');
@define('STATICPAGE_PAGEADD_PLUGINS', 'Die folgenden Plugins können in die staticpage sidebar eingefügt werden.');
@define('STATICPAGE_CATEGORY_PAGEADD', 'Andere Plugins');
@define('STATICPAGE_SEARCHRESULTS', 'Weitere %d Seiten gefunden:');

@define('STATICPAGE_MEDIA_DIRECTORY_MOVE_ENTRIES', 'Die URL der verschobenen Verzeichnisse wurde in %s statischen Seiten angepasst.');
#@define('STATICPAGE_MEDIA_DIRECTORY_MOVE_ENTRY', 'Bei Nicht-MySQL Datenbanken ist es nicht möglich, jede statische Seite durchzugehen und das alte Verzeichnis durch das neue zu ersetzen. Daher müssen Sie manuell bestehende statische Seiten überarbeiten und die neuen URLs eintragen. Sie können natürlich auch das Verzeichnis an seinen alten Platz zurückschieben, falls dies zu viel Aufwand bedeuten würde.');

@define('PLUGIN_LINKS_IMGDIR', 'Verzeichnis für Bilder dieses Plugins');
@define('PLUGIN_LINKS_IMGDIR_BLAHBLAH', 'Bitte geben Sie hier die URL ein, die zu dem Bildverzeichnis ihres Plugins führt. Das eingegebene Verzeichnis muss einen "img"-Unterordner besitzen, der standardmäßig mit diesem Plugin auch ausgeliefert wird.');
@define('PLUGIN_STATICPAGELIST_ICON', 'JS Baumstruktur');
@define('PLUGIN_STATICPAGELIST_IMG_NAME', 'Grafiken für Baumstruktur aktivieren');
@define('PLUGIN_STATICPAGELIST_PARENTSONLY', 'Nur Eltern-Seiten darstellen?');
@define('PLUGIN_STATICPAGELIST_PARENTSONLY_DESC', 'Falls aktiviert werden nur Eltern-Seiten dargestellt. Andernfalls werden auch Unterseiten angezeigt.');
@define('PLUGIN_STATICPAGELIST_SHOWICONS_DESC', 'Baumstruktur oder einfache Textauflistung verwenden');
@define('PLUGIN_STATICPAGELIST_SHOWICONS_NAME', 'Icons bzw. Klartext');
@define('PLUGIN_STATICPAGELIST_TEXT', 'Klartext');
@define('STATICPAGE_DEFAULT_DESC', 'Standardeinstellung für neue Seiten');
@define('STATICPAGE_LANGUAGE_DESC', 'Wählen Sie die Sprache dieser Seite');
@define('STATICPAGE_PAGEORDER_DESC', 'Hier kann die Reihenfolge der statischen Seiten geändert werden');
@define('STATICPAGE_PUBLISHSTATUS', 'Artikelstatus');
@define('STATICPAGE_PUBLISHSTATUS_DESC', 'Artikelstatus dieser Seite (veröffentlicht oder im Entwurf)');
@define('STATICPAGE_SHOWARTICLEFORMAT_DEFAULT', 'Wie einen Blog-Eintrag formatieren');
@define('STATICPAGE_SHOWCHILDPAGES_DEFAULT', 'Unterseiten anzeigen');
@define('STATICPAGE_SHOWMARKUP_DEFAULT', 'Textformatierungs-Plugins anwenden');
@define('STATICPAGE_SHOWNAVI', 'Navigation anzeigen');
@define('STATICPAGE_SHOWNAVI_DEFAULT', 'Navigation anzeigen');
@define('STATICPAGE_SHOWNAVI_DESC', 'Zeigt eine Navigation für diese Seite an');
@define('STATICPAGE_SHOWONNAVI', 'In der Navigation der Seitenleiste einbinden');
@define('STATICPAGE_SHOWONNAVI_DEFAULT', 'Seite in Liste des Seitenleisten-Plugins anzeigen');
@define('STATICPAGE_SHOWONNAVI_DESC', 'Diese Seite in der Liste des Seitenleisten-Plugins anzeigen');
@define('STATICPAGE_SHOWMETA_DEFAULT', 'Zeige HTML Meta input Felder');
@define('STATICPAGE_SHOWTEXTORHEADLINE_HEADLINE', 'Überschrift');
@define('STATICPAGE_SHOWTEXTORHEADLINE_NAME', 'Überschriften oder Vor/Zurück-Navigation anzeigen?');
@define('STATICPAGE_SHOWTEXTORHEADLINE_TEXT', 'Text: Vor/Zurück');

@define('STATICPAGE_QUICKSEARCH_DESC', 'Wenn aktiviert, werden Suchergebnisse in den Statischen Seiten berücksichtigt.');

@define('STATICPAGE_CATEGORYPAGE','Zugeordnete statische Seite');
@define('STATICPAGE_RELATED_CATEGORY', 'Zugeordnete Kategorie');
@define('STATICPAGE_RELATED_CATEGORY_DESCRIPTION', 'U.a. können Einträge einer Kategorie oder Links auf die Kategorie in einer statischen Seite eingebunden werden. Näheres in der "plugin_staticpage_related_category.tpl" und "README_FOR_RELATED_CATEGORIES.txt"');

@define('STATICPAGE_ARTICLE_OVERVIEW','Artikelübersicht');
@define('STATICPAGE_NEW_HEADLINES','Aktuelle Schlagzeilen:');

@define('STATICPAGES_CUSTOMEXAMPLE_OPTION_SHOW', 'Zeige benutzerdefinierte Optionen');
@define('STATICPAGES_CUSTOM_OPTION_SHOW', 'Zeige KONFIGURATIONS Optionen');
@define('STATICPAGES_CUSTOM_STRUCTURE_SHOW', 'Zeige STRUKTUR Optionen');
@define('STATICPAGES_CUSTOM_META_SHOW', 'Zeige META FELD Optionen');
@define('STATICPAGES_CUSTOM_META_TITLE', 'HTML META Seitentitel (optional)');
@define('STATICPAGES_CUSTOM_META_DESC', 'HTML META Seitenbeschreibung (optional)');
@define('STATICPAGES_CUSTOM_META_KEYS', 'HTML META Seiten Schlüsselwörter (optional)');

@define('STATICPAGE_SHOW_BREADCRUMB_DEFAULT', 'Zeige Navigationspfad (Breadcrumbs)');
@define('STATICPAGE_SHOW_BREADCRUMB', 'Zeige Navigationspfad (Breadcrumbs)');
@define('STATICPAGE_SHOW_BREADCRUMB_DESC', 'Zeige auf dieser Seite den Navigationspfad (Breadcrumbs) an');

@define('STATICPAGE_SHOWLIST_DEFAULT', 'Zeige als Eintragsliste');
@define('STATICPAGE_SHOWLIST_DESC', 'Zeige Staticpage Backend Startseite als Eintrags-Liste oder als Auswahl-Liste.');
@define('STATICPAGE_SHOWLIST_NUMLIST', 'Zeige als "N" (6) Einträge per Seite');

@define('STATICPAGE_CONFIRM_SELECTDIALOG', "Sind Sie sicher ihren offenen Artikel im Falle einer Veränderung gespeichert zu haben?\\n\\nWenn Sie OK drücken, wird die Seite gewechselt!"); // js confirm needs an additional backslash before the linebreaks!

@define('STATICPAGE_TOGGLEANDSAVE', '%s und merken!');

@define('CREATED_ON', 'Erstellt am');

@define('RELATED_CATEGORY_CHANGE_MSG', 'Dies hat eine vorherige, zugeordnete-Kategorie-Assoziierung von ID #%s, mit Staticpage ID #%s überschrieben, da nur 1:1 Beziehungen erlaubt sind! Bitte überprüfen Sie beide statischen Seiten im Eingabeformular für statische Seiten, um diese Änderungen im ausgewählten Feld "zugeordnete Kategorie" zu bestätigen.');
@define('RELATED_CATEGORY_CHANGE_DEL_MSG', 'Das korrespondierende related_category_id Feld von Staticpage ID #%s wurde zurückgesetzt.');

@define('STATICPAGE_CONFIGGROUP_FORM', 'Backend Formular Voreinstellungen:');
@define('STATICPAGE_CONFIGGROUP_FRONTEND', 'Allgemeine Frontend Anzeigen:');
@define('STATICPAGE_CONFIGGROUP_BACKEND', 'Allgemeine Backend Anzeigen:');

@define('STATICPAGE_LANGUAGE_INFO', 'Dieses Sprach-Auswahl-Feld ist für die Nutzung als Multi-Sprachen-Blog ausgelegt (zB. in Kombination mit dem "Multilingual" Seitenleistenplugin,
                    oder einfach, wenn Autoren mit einer eigenen Spracheinstellung in den Eigenen Einstellungen eingeloggt sind).
                    Durch die Nutzung dieses Feldes können spezifische Statische Seiten nach Sprache erstellt werden, die auch nur dann angezeigt werden,
                    wenn das Frontend diese Sprache aktiv nutzt. "Alle Sprachen" meint "in jedem Fall".');

@define('PLAIN_ASCII', 'URLs sollten nur ASCII verwenden. [A-Za-z0-9]');
@define('STATICPAGE_RELCAT_INFO', 'Dies funktioniert <b>nur</b> in Kombination mit dem entries.tpl-Patch, der in der "README FOR RELATED CATEGORIES.txt" <a href="%s" target="_blank" rel="noopener" style="color:#7fdbff">Datei</a> beschrieben ist.<br>
                    Für eine Frontend-Kategorien-Seite, mit einer Anzahl<span style="font-size:10px"><sup> (1)</sup></span> der letzten Eintrags-Links als Teaser, ist die beste Verwendung mit dem Artikeltyp: "<em>Staticpage with related category</em>" Feld in diesem Formular.
                    Bitte beachten Sie, dass nur einheitliche 1:1-Beziehungen zwischen Statischen Seiten und Kategorien erlaubt sind.<br><br>
                    <span style="font-size:10px"><sup>(1)</sup></span> Das Ändern der Menge der dargestellten Teaser-Eintragsverknüpfungen erfolgt in der Datei "plugin staticpage related category.tpl" durch den konfigurierbaren Aufruf-Hook. Standard sind 5 Einträge.');
@define('STATICPAGE_CUSTOMFIELDS_INFO', '<p>Dieser benutzerdefinierte Abschnitt verbessert die CMS-Fähigkeiten von Serendipity erheblich und zeigt einige Beispiele für das Speichern von benutzerdefinierten Feldern für Statische Seiten.
                    Alle benutzerdefinierten Felder müssen durch übliche HTML-Formularelemente implementiert werden und müssen ihre Werte in einem "serendipity[plugin][custom][XXX]" Feldnamen speichern.
                    Einmal eingegeben, werden die Daten automatisch in der "serendipity_staticpage_custom" Datenbanktabelle gespeichert und stehen als "&#123;$staticpage_custom.XXX&#125;" Smarty-Variable zur Verfügung,
                    wenn sie später im Frontend angezeigt werden. Auf diese Weise können Sie ganz einfach neue benutzerdefinierte Felder für eine Statische Seite hinzufügen, zB. um für jede
                    Statische Seite ein benutzerdefiniertes Header-Image anzugeben. Die Verwendungsmöglichkeiten sind nahezu unbegrenzt!</p>
                    <p>Mit diesen optionalen Beispielen können Sie entweder eine benutzerdefinierte CSS-BODY-ID verwenden, um die Seite zu rendern.
                    Oder Sie können angeben, welche Seitenleiste Sie sehen möchten, wenn diese Statische Seite gerendert wird.
                    Ein weiteres schönes Beispiel hierin ist es, einige verwandte Tags für diese Statische Seite zu definieren, um eine bestimmte Anzahl von Einträgen mit diesen Tags anzuzeigen,
                    so wie es das Freetag-Plugin für Blog Einträge erlaubt.<br>
                    <span><strong>Bitte lesen Sie:</strong> </span> <a href="%s" target="_blank" rel="noopener" style="color:#7fdbff">the readme for custom fields</a>-Beispiele.</p>
                    <p>Die "Disable nl2br markup parser" Radio-Option wird bereits intern verwendet, um automatisch WYSIWYG-Einträge von Statischen Seiten für die Speicherung zu markieren, auf dass sie folgend nicht durch das nl2br Markup-Parser Plugin bei der Anzeige verändert werden.</p>');

@define('PLUGIN_STATICPAGE_PREVIEW', 'Die Voransicht ihrer statischen Seite wurde in einem neuen Browsertab geöffnet. Sonst benutzen Sie diesen: %s');

@define('STATICPAGE_FORM_FAIL', 'Die Erstellung einer neuen Seite ist fehlgeschlagen! Es ist mindestens eine eindeutige Einstellung in "' . STATICPAGE_PERMALINK . '" und in "' . STATICPAGE_PAGETITLE . '" erforderlich.');

