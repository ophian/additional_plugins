<?php

@define('PLUGIN_CATEGORYTEMPLATES_NAME', 'Eigenschaften/Templates von Kategorien');
@define('PLUGIN_CATEGORYTEMPLATES_DESC', 'Dieses Plugin erm�glicht erweiterte Eigenschaften f�r Kategorien und deren Eintr�ge festzulegen: Speziell angepasste Templates, Anzeigereihenfolge, Anzeigeanzahl, Passwort-Schutz und Ausschluss aus anderen Eintragslisten und RSS-Feeds.');
@define('PLUGIN_CATEGORYTEMPLATES_SELECT', 'Bitte geben Sie den Verzeichnisnamen des Themes an, das f�r diese Kategorie verwendet werden soll. Die Verzeichnisnamen beginnen relativ ab Ihrem "templates/" Ordner. Sie k�nnen also z.B. "blue" oder "kubrick" eingeben. Alternativ k�nnen Sie auch Unterverzeichnisse eines Themes angeben, wenn Sie diese wie ein normales Theme in einem Unterverzeichnis eines anderen Themes angelegt haben. Also z.B. "blue/kategorie1" oder "blue/kategorie2". Empfohlen aber ist, ein eigenes "Engine:" Theme zu erstellen.<br>Um die Rangordnung zu �ndern, in der Artikel mit mehreren zugewiesenen Kategorien bei der Anwendung benutzerdefinierter Kategorie-Vorlagen ber�cksichtigt werden, konfigurieren Sie das Kategorievorlagen-Plugin.<br>Vergessen Sie aber nicht, die untenstehende "Verstecken"-Option zur�ckzusetzen, wenn sie eine gesetzte Kategorie-Theme Zuordnung wieder entfernen.');
@define('PLUGIN_CATEGORYTEMPLATES_FETCHLIMIT', 'Anzahl der Artikel f�r die Startseite der Kategorie');
@define('PLUGIN_CATEGORYTEMPLATES_PASS', 'Passwort-Schutz:');
@define('PLUGIN_CATEGORYTEMPLATES_PASS_DESC', 'Sollen Kategorien durch Passw�rter gesch�tzt werden k�nnen? Der Nachteil davon ist, dass eine weitere Datenbankanfrage durchgef�hrt werden muss und dass Artikel in passwortgesch�tzten Kategorien f�r Besucher NICHT auf der Startseite erscheinen, bis diese zur gesch�tzten Kategorieansicht gehen.');
@define('PLUGIN_CATEGORYTEMPLATES_PASS_USER', 'Serendipity Kategorie Passwort-Schutz');
@define('PLUGIN_CATEGORYTEMPLATES_FIXENTRY', 'Fixe Zuweisung eines Artikels zu seiner Kategorie');
@define('PLUGIN_CATEGORYTEMPLATES_FIXENTRY_DESC', 'Wenn aktiviert, wird die Kategorie eines Artikels in der Detailansicht auf die jeweils aktuelle Kategorie gesetzt.');
@define('PLUGIN_CATEGORYTEMPLATES_CATPRECEDENCE', 'Rangordnung von Kategorie-Vorlagen');
@define('PLUGIN_CATEGORYTEMPLATES_CATPRECEDENCE_DESC', 'Wenn einem Artikel mehrere Kategorien zugewiesen sind, wird anhand dieser Liste entschieden, welches speziell angepasste Template (Formatvorlage) angewandt wird. Das oberste Template wird als erstes angewandt. Damit Ihre Rangordnungs-�nderungen f�r tats�chliche Kategorietemplates gespeichert und aktiv werden k�nnen, m�ssen Sie die Checkbox(en) vorher aktivieren.');
@define('PLUGIN_CATEGORYTEMPLATES_NO_CUSTOMIZED_CATEGORIES', 'Bisher haben keine Kategorien speziell angepasste Templates. Lassen Sie diese Checkbox solange leer!');
@define('PLUGIN_CATEGORYTEMPLATES_HIDE', 'Sollen Eintr�ge dieser Kategorie von Eintragslisten und RSS-Feeds ausgeschlossen werden?');
@define('PLUGIN_CATEGORYTEMPLATES_SELECT_TEMPLATE', 'W�hlen oder setzen Sie das Theme f�r diese Blogkategorie:');

