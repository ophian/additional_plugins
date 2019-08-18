<?php

/**
 *  @version
 *  @author Thomas Hochstein <thh@inter.net>
 */

//
//  serendipity_event_linklist.php
//
@define('PLUGIN_LINKLIST_TITLE', 'Linkliste');
@define('PLUGIN_LINKLIST_DESC', 'Linkmanager - zeigt Ihre Lieblingslinks in der Seitenleiste an.');
@define('PLUGIN_LINKLIST_LINK', 'Link');
@define('PLUGIN_LINKLIST_LINK_NAME', 'Name');
@define('PLUGIN_LINKLIST_ADMINLINK', 'Links verwalten');
@define('PLUGIN_LINKLIST_ORDER', 'Links sortieren nach:');
@define('PLUGIN_LINKLIST_ORDER_DESC', 'Sortierung der angezeigten Links ausw�hlen.');
@define('PLUGIN_LINKLIST_ORDER_NUM_ORDER', 'Benutzerdefiniert');
@define('PLUGIN_LINKLIST_ORDER_DATE_ACS', 'Nach Datum (vom �ltesten aufsteigend)');
@define('PLUGIN_LINKLIST_ORDER_DATE_DESC', 'Nach Datum (vom neuesten absteigend)');
@define('PLUGIN_LINKLIST_ORDER_CATEGORY', 'Nach Kategorien');
@define('PLUGIN_LINKLIST_ORDER_ALPHA', 'Alphabetisch');
@define('PLUGIN_LINKLIST_LINKS', 'Links verwalten');
@define('PLUGIN_LINKLIST_NOLINKS', 'Keine Links vorhanden');
@define('PLUGIN_LINKLIST_CATEGORY', 'Kategorien verwenden');
@define('PLUGIN_LINKLIST_CATEGORYDESC', 'Kategorien verwenden, um Links zu organisieren.');
@define('PLUGIN_LINKLIST_ADDLINK', 'Link hinzuf�gen');
@define('PLUGIN_LINKLIST_LINK_EXAMPLE', 'Beispiel: http://www.s9y.org oder http://www.s9y.org/forums/');
@define('PLUGIN_LINKLIST_EDITLINK', 'Link bearbeiten');
@define('PLUGIN_LINKLIST_LINKDESC', 'Beschreibung f�r den Link');
@define('PLUGIN_LINKLIST_CATEGORY_NAME', 'Kategoriensystem:');
@define('PLUGIN_LINKLIST_CATEGORY_NAME_DESC', 'Sie k�nnen entweder die Blog-Kategorien oder die mit diesem Plugin bereitgestellten benutzerdefinierten Kategorien verwenden.');
@define('PLUGIN_LINKLIST_CATEGORY_NAME_CUSTOM', 'Benutzerdefiniert');
@define('PLUGIN_LINKLIST_CATEGORY_NAME_DEFAULT', 'Standard');
@define('PLUGIN_LINKLIST_ADD_CAT', 'Kategorie verwalten');
@define('PLUGIN_LINKLIST_CAT_NAME', 'Name der Kategorie');
@define('PLUGIN_LINKLIST_PARENT_CATEGORY', '�bergeordnete Kategorie');
@define('PLUGIN_LINKLIST_ADMINCAT', 'Kategorien administrieren');
@define('PLUGIN_LINKLIST_CACHE_NAME', 'Seitenleiste cachen');
@define('PLUGIN_LINKLIST_CACHE_DESC', 'Durch das Zwischenspeichern der Seitenleiste wird die Geschwindigkeit Ihrer Seite erh�ht. Um den Cache f�r Fehlerbehebungszwecke zu l�schen, schalten Sie ihn aus und wieder ein.');
@define('PLUGIN_LINKLIST_ENABLED_NAME', 'Aktiviert');
@define('PLUGIN_LINKLIST_ENABLED_DESC', 'Plugin aktivieren/deaktivieren.');
@define('PLUGIN_LINKLIST_DELETE_WARN', 'Wenn eine Kategorie gel�scht wird, werden alle ihre Eintr�ge in die Stammkategorie verschoben.');

//
//  serendipity_plugin_linklist.php
//
@define('PLUGIN_LINKS_NAME', 'Linkliste');
@define('PLUGIN_LINKS_BLAHBLAH', 'Linkmanager - zeigt Ihre Lieblingslinks in der Seitenleiste an.');
@define('PLUGIN_LINKS_TITLE', '�berschrift');
@define('PLUGIN_LINKS_TITLE_BLAHBLAH', 'Die �berschrift f�r die Linkliste.');
@define('PLUGIN_LINKS_TOP_LEVEL', 'Text f�r die oberste Ebene');
@define('PLUGIN_LINKS_TOP_LEVEL_BLAHBLAH', 'Geben Sie hier einen beliebigen Text ein, der auf der obersten Ebene erscheinen soll (kann leer bleiben)');
@define('PLUGIN_LINKS_DIRECTXML', 'XML direkt eingeben');
@define('PLUGIN_LINKS_DIRECTXML_BLAHBLAH', 'Sie k�nnen XML-Daten direkt eingeben oder eine Webseite zum Verwalten von Links verwenden.');
@define('PLUGIN_LINKS_LINKS', 'Linkliste');
@define('PLUGIN_LINKS_LINKS_BLAHBLAH', 'Verwenden Sie XML!! - Verwenden Sie f�r Verzeichnissbl�cke <dir name="dir name"> und schlie�en Sie mit </dir>. - Verwenden Sie f�r Links <link name="link name" link="http://link.com/" />.');
@define('PLUGIN_LINKS_OPENALL', 'Linktext f�r "Alle ausklappen"');
@define('PLUGIN_LINKS_OPENALL_BLAHBLAH', 'Geben Sie den Linktext f�r den Link "Alle ausklappen" ein.');
@define('PLUGIN_LINKS_OPENALL_DEFAULT', 'Alle ausklappen');
@define('PLUGIN_LINKS_CLOSEALL', 'Linktext f�r "Alle einklappen"');
@define('PLUGIN_LINKS_CLOSEALL_BLAHBLAH', 'Geben Sie den Linktext f�r den Link "Alle einklappen" ein.');
@define('PLUGIN_LINKS_CLOSEALL_DEFAULT', 'Alle einklappen');
@define('PLUGIN_LINKS_SHOW', 'Links zum Aus-/Einklappen anzeigen?');
@define('PLUGIN_LINKS_SHOW_BLAHBLAH', 'M�chten Sie die Links "Alle ausklappen" und "Alle einklappen" sehen?');
@define('PLUGIN_LINKS_LOCATION', 'Link-Position');
@define('PLUGIN_LINKS_LOCATION_BLAHBLAH', 'Position der Links zum Aus-/Einklappen.');
@define('PLUGIN_LINKS_LOCATION_TOP', 'Oben');
@define('PLUGIN_LINKS_LOCATION_BOTTOM', 'Unten');
@define('PLUGIN_LINKS_SELECTION', 'Auswahl erm�glichen');
@define('PLUGIN_LINKS_SELECTION_BLAHBLAH', 'Bei "Ja" k�nnen Knoten ausgew�hlt (hervorgehoben) werden.');
@define('PLUGIN_LINKS_COOKIE', 'Cookies verwenden');
@define('PLUGIN_LINKS_COOKIE_BLAHBLAH', 'Bei "Ja" verwendet die Baumanzeige Cookies, um ihren Zustand zu speichern.');
@define('PLUGIN_LINKS_LINE', 'Linien verwenden');
@define('PLUGIN_LINKS_LINE_BLAHBLAH', 'Bei "Ja" wird die Baumanzeige mit Linien gezeichnet.');
@define('PLUGIN_LINKS_ICON', 'Icons verwenden');
@define('PLUGIN_LINKS_SVGICON', 'Use link SVG icon by CSS');
@define('PLUGIN_LINKS_ICON_BLAHBLAH', 'Bei "Ja" wird die Baumanzeige mit Icons gezeichnet.');
@define('PLUGIN_LINKS_STATUS', 'Statuszeile verwenden');
@define('PLUGIN_LINKS_STATUS_BLAHBLAH', 'Bei "Ja" wird die Knotenbezeichnung statt der URL in der Statuszeile des Browsers angezeigt.');
@define('PLUGIN_LINKS_CLOSELEVEL', 'Gleiche Ebene schlie�en');
@define('PLUGIN_LINKS_CLOSELEVEL_BLAHBLAH', 'Bei "Ja" kann nur ein Knoten innerhalb eines �bergeordneten Knotens gleichzeitig erweitert werden. "Alle ausklappen" und "Alle einklappen" funktionieren nicht, wenn diese Option aktiviert ist.');
@define('PLUGIN_LINKS_TARGET', 'Linkziel');
@define('PLUGIN_LINKS_TARGET_BLAHBLAH', 'Das Ziel f�r die Links kann "_blank", "_self", "_top", "_parent" oder der Name eines Frames sein.');
@define('PLUGIN_LINKS_IMGDIR', 'Plugin-Image-Verzeichnis verwenden');
@define('PLUGIN_LINKS_IMGDIR_BLAHBLAH', 'Bei "Ja" geht das Plugin davon aus, dass sich die Bilder im Plugin-Ordner befinden. Bei "Nein" verwendet das Plugin als Pfad f�r die Bilder "/templates/default/img/". Das Deaktivieren des Plugin-Image-Verzeichnisses ist f�r gemeinsame Installationen erforderlich, erfordert jedoch, dass die Bilder manuell verschoben werden.');
@define('PLUGIN_LINKLIST_CATEGORY_DEFAULT_OPEN_NAME', 'Kategoriebaum aus- oder einklappen');
@define('PLUGIN_LINKLIST_CATEGORY_DEFAULT_OPEN_DESC', 'Bei der Sortierung nach Kategorien werden die Links standardm��ig aus- oder eingeklappt.');
@define('PLUGIN_LINKLIST_CATEGORY_DEFAULT_OPEN_NAME_CLOSED', 'Ausklappen');
@define('PLUGIN_LINKLIST_CATEGORY_DEFAULT_OPEN_NAME_OPEN', 'Einklappen');
@define('PLUGIN_LINKLIST_OUTSTYLE_DTREE', 'dtree');
@define('PLUGIN_LINKLIST_OUTSTYLE_CSS', 'CSS-Liste');
@define('PLUGIN_LINKLIST_ORDER_OUTSTYLE_SIMP_CSS', 'Einfaches CSS');
@define('PLUGIN_LINKS_OUTSTYLE', 'Anzeige-Stil f�r die Linkliste w�hlen');
@define('PLUGIN_LINKS_OUTSTYLE_BLAHBLAH', 'W�hlen Sie den Ausgabestil f�r die Linkliste. "dtree" verwendet Javascript, um eine browser�bergreifende Baumansicht zu erstellen. "CSS-Liste" verwendet CSS und ein einfaches Javascript, um die "dtree"-Ansicht wiederzugeben, unterst�tzt jedoch nicht alle Funktionen von "dtree". "Einfaches CSS" gibt eine einfache CSS-gesteuerte Liste aus, die eine genaue Kontrolle �ber die Darstellung von Links erm�glicht. Beachten Sie, dass "dtree" in der Regel nicht von Suchmaschinen ausgewertet werden kann.');
@define('PLUGIN_LINKS_CALLMARKUP', 'Markup-Plugins anwenden?');
@define('PLUGIN_LINKS_CALLMARKUP_BLAHBLAH', 'W�hlen Sie diese Option, um Markups-Plugins auf die Linkliste anzuwenden. Dies wendet alle Markup-Plugins an, die auch auf einen HTML-Klotz angewendet werden.');
@define('PLUGIN_LINKS_USEDESC', 'Vorhandene Beschreibung verwenden');
@define('PLUGIN_LINKS_USEDESC_BLAHBLAH', 'Verwenden Sie die Beschreibung als Linktitel, falls sie verf�gbar ist.');
@define('PLUGIN_LINKS_PREPEND', 'Geben Sie einen beliebigen Text ein, der vor der Linkliste angezeigt werden soll.');
@define('PLUGIN_LINKS_APPEND', 'Geben Sie einen beliebigen Text ein, der nach der Linkliste angezeigt werden soll.');

