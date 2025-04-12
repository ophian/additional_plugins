<?php

@define('PLUGIN_SIDEBAR_IMAGESIDEBAR_NAME', 'Integrierte Bildanzeige in der Seitenleiste');
@define('PLUGIN_SIDEBAR_IMAGESIDEBAR_DESC', 'Bietet die Möglichkeit, Bilder in der Seitenleiste anzuzeigen. Die Quelle der Bilder ist konfigurierbar. Das Plugin ist in der Lage, auf die Styx Mediathek zuzugreifen.');

@define('PLUGIN_SIDEBAR_IMAGESIDEBAR_DISPLAYSRC_NAME', 'Bild-Quelle');
@define('PLUGIN_SIDEBAR_IMAGESIDEBAR_DISPLAYSRC_DESC', 'Bitte wählen Sie eine Quelle für Ihre Bilder aus dem Dropdown-Menü.');
@define('PLUGIN_SIDEBAR_IMAGESIDEBAR_DISPLAYSRC_NONE', 'Keine Auswahl getroffen');
@define('PLUGIN_SIDEBAR_IMAGESIDEBAR_DISPLAYSRC_MEDIALIB', 'Mediathek');

@define('PLUGIN_SIDEBAR_MEDIASIDEBAR_NAME', 'Anzeige der Mediathek-Seitenleiste');
@define('PLUGIN_SIDEBAR_MEDIASIDEBAR_DESC', 'Zeigt ein zufälliges Bild aus der Medienbibliothek in der Seitenleiste an. (Hinweis: Es wird nicht zwischen Bildern und anderen Dateitypen unterschieden)');
@define('PLUGIN_SIDEBAR_MEDIASIDEBAR_DIRECTORY_NAME', 'Wählen Sie ein Standardverzeichnis');
@define('PLUGIN_SIDEBAR_MEDIASIDEBAR_DIRECTORY_DESC', 'Wählen Sie das Standardverzeichnis, auf das das Plugin beschränkt werden soll');
@define('PLUGIN_SIDEBAR_MEDIASIDEBAR_NOSUBDIRS_NAME', 'Keine Unterverzeichnisse einbeziehen');
@define('PLUGIN_SIDEBAR_MEDIASIDEBAR_NOSUBDIRS_DESC', 'Bei der Einstellung „ Ja “ holt das Plugin nur Bilder aus dem aktuellen Verzeichnis und zeigt diese an. Bei der Einstellung „ Nein “ wird das Plugin alle Bilder aus allen Unterverzeichnissen abrufen und ausgeben. Bitte beachten Sie: Je mehr Bilder geholt werden müssen, desto länger dauert es!');
@define('PLUGIN_SIDEBAR_MEDIASIDEBAR_LINKBEHAVIOR_NAME', 'Verhalten des Bild-Links');
@define('PLUGIN_SIDEBAR_MEDIASIDEBAR_LINKBEHAVIOR_DESC', '„Auf der Seite“ verweist auf das Bild. „Pop Up“ öffnet das Bild in einem neuen, großen Fenster. Mit „URL“ können Sie eine bestimmte, statische URL als Ziel definieren. „Gallery“ verlinkt das Bild mit der Permalink-Ansicht des Usergallery-Plugins (falls installiert). „None“ zeigt nur das Bild an.');
@define('PLUGIN_SIDEBAR_MEDIASIDEBAR_LINKBEHAVIOR_INPAGE', 'Auf der Seite');
@define('PLUGIN_SIDEBAR_MEDIASIDEBAR_LINKBEHAVIOR_POPUP', 'Pop Up');
@define('PLUGIN_SIDEBAR_MEDIASIDEBAR_LINKBEHAVIOR_URL', 'URL');
@define('PLUGIN_SIDEBAR_MEDIASIDEBAR_LINKBEHAVIOR_GALLERY', 'Gallery');
@define('PLUGIN_SIDEBAR_MEDIASIDEBAR_LINKBEHAVIOR_ENTRY', 'Versuche, einen Link zu einem verwandten Eintrag zu setzen');
@define('PLUGIN_SIDEBAR_MEDIASIDEBAR_GAL_STYLES', 'Definieren Sie #mediasidebar Verhaltens Stile');
@define('PLUGIN_SIDEBAR_MEDIASIDEBAR_GAL_STYLES_DESC', 'Dies hängt davon ab, wie Ihre aktuellen Theme-Stile definiert sind. „Compat“ setzt eine überprüfte (Fallback-)Mindestvorgabe nur für img-Styling; „Ja“ schreibt sie sowohl für Link- als auch für img-Elemente; „Nein“ deaktiviert alle vom Plugin hinzugefügten Stile. Aus Gründen der vollständigen Kompatibilität müssen wir hier „Ja“ als Standard verwenden. Schauen Sie sich den Quellcode in der Seitenleiste an, um zu sehen, wie sie definiert sind und für welche Teile Ihr Theme Unterstützung benötigt. Aber besser(!) ist es, dies alles in Ihrer eigenen Theme-Datei (user.css) zu tun. Prüfen Sie vorher, ob Ihr Theme style.css dies nicht bereits unterstützt. Verwenden Sie als vereinfachtes Beispiel:
#mediasidebar .mediasidebar_link {
    display: inline-table;
    text-decoration: none transparent;
    color: transparent;
    border: 0 none;
}
#mediasidebar .mediasidebaritem img {
    border: 0 none;
    width: 200px;
}
');

@define('PLUGIN_SIDEBAR_MEDIASIDEBAR_WIDTH_NAME', 'Bild-Breite');
@define('PLUGIN_SIDEBAR_MEDIASIDEBAR_WIDTH_DESC', 'Legen Sie eine feste maximale Bildbreite für die Anzeige fest. Wenn die Breite auf „0“ gesetzt wird, gibt das Plugin entweder „width:100%“ oder Bilder in beliebiger Größe aus, skaliert mit den Container-Styles Ihres Themes für die Seitenleisten.');
@define('PLUGIN_SIDEBAR_MEDIASIDEBAR_DIMENSION_RANGE_NAME', 'Wählen Sie einen Mindest-/Maximalbereich für die Abmessungen der Abfrage');
@define('PLUGIN_SIDEBAR_MEDIASIDEBAR_DIMENSION_RANGE_DESC', 'Dieser Wert wird verwendet, um die Auswahl der Bildbreite von „x“ (Minimum) bis „y“ (Maximum) in Pixeln zu filtern, was den Abruf der gesamten ausgewählten Datenbank reduziert und dazu beiträgt, dass keine Bilder mit zu kleinen Größen angezeigt werden. Schreiben Sie als durch Komma getrennte Ganzzahlwerte, z. B. „240,2400“. Für keine Filter auf „0,0“ setzen.');
@define('PLUGIN_SIDEBAR_MEDIASIDEBAR_URL_NAME', 'URL eingeben');
@define('PLUGIN_SIDEBAR_MEDIASIDEBAR_URL_DESC', 'Geben Sie die statische URL ein, zu der Sie verlinken möchten. (Beispiel: \'https://adresse.org\')');
@define('PLUGIN_SIDEBAR_MEDIASIDEBAR_GALPERM_NAME', 'Eingabe des Permalinks oder der Unterseite');
@define('PLUGIN_SIDEBAR_MEDIASIDEBAR_GALPERM_DESC', 'Dieser Wert sollte mit dem im Galerie-Plugin eingestellten Wert übereinstimmen. Hinweis: Wenn die URL-Umschreibung "mod_rewrite" deaktiviert ist, müssen Sie die Unterseite verwenden.');
@define('PLUGIN_SIDEBAR_MEDIASIDEBAR_INTRO', 'Text (oder HTML), den Sie vor dem Bild platzieren möchten');
@define('PLUGIN_SIDEBAR_MEDIASIDEBAR_SUMMERY', 'Ein beliebiger Text (oder HTML), den Sie an das Bild anhängen möchten');
@define('PLUGIN_SIDEBAR_MEDIASIDEBAR_ROTATETIME_NAME', 'Zeit für Bild-Aktualisierung');
@define('PLUGIN_SIDEBAR_MEDIASIDEBAR_ROTATETIME_DESC', 'Wie oft soll(en) sich das/die Bild(er) aktualisieren, in Minuten, ausgehend von der vollen Stunde. Bei einer Einstellung von „0“ werden die Bilder bei jeder Aktualisierung aktualisiert.');
@define('PLUGIN_SIDEBAR_MEDIASIDEBAR_NUMIMAGES_NAME', 'Anzahl der anzuzeigenden Bilder');
@define('PLUGIN_SIDEBAR_MEDIASIDEBAR_NUMIMAGES_DESC', 'Geben Sie die Anzahl der Bilder ein, die Sie anzeigen möchten.');
@define('PLUGIN_SIDEBAR_MEDIASIDEBAR_HOTLINKS_NAME', 'Ausgabe nur auf verlinkte Bilder beschränken');
@define('PLUGIN_SIDEBAR_MEDIASIDEBAR_HOTLINKS_DESC', 'Diese Option beschränkt die Ausgabe der Seitenleiste auf Bilder, die Hotlinks in der Medienbibliothek sind.');
@define('PLUGIN_SIDEBAR_MEDIASIDEBAR_HOTLINKBASE_NAME', 'Hotlink-Begrenzungsschlüsselwort');
@define('PLUGIN_SIDEBAR_MEDIASIDEBAR_HOTLINKBASE_DESC', 'Diese Option nimmt ein einzelnes Schlüsselwort (ohne Leerzeichen) und beschränkt die Ausgabe auf alles, was dieses Wort enthält. Wenn Sie z. B. Hotlinks aus verschiedenen Quellen haben, aber nur die eines einzigen Hosts anzeigen möchten, können Sie „host.com“ in dieses Feld eingeben.');

@define('PLUGIN_SIDEBAR_MEDIASIDEBAR_LIGHTBOX_NAME', 'Verwendung mit installiertem Lightbox-Plugin');
@define('PLUGIN_SIDEBAR_MEDIASIDEBAR_LIGHTBOX_DESC', 'Bitte fügen Sie ein html-Attribut ein, z.B. <rel=„lightbox“> für einzelne, oder <rel=„lightbox[]“> für gruppierte Lightbox-Ansichten (beide ohne <>) für die Lightbox-Nutzung mit dem Lightbox-Event-Plugin. Dies wird in den Bildanker aufgenommen. Es funktioniert nur für „Media Library“ mit der Option „Verhalten des Bild-Links“ : „Auf der Seite“. Mit Vorsicht verwenden.');

