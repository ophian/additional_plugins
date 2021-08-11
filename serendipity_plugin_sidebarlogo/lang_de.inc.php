<?php

/**
 *  @version 0.4
 *  @author Oliver Gerlach (http://www.stumblingpilgrim.net/)
 */

@define('PLUGIN_SIDEBARLOGO_NAME', 'SideBar Logo');
@define('PLUGIN_SIDEBARLOGO_DESC', 'Zeigt ein Logo mit einer Beschreibung und allen relevanten Informationen in der Seitenleiste (eine Aboutbox).');
@define('PLUGIN_SIDEBARLOGO_GROUP_MOREOPTIONS', 'Weitere Felder & Optionen');
@define('PLUGIN_SIDEBARLOGO_GROUP_STYLES', 'Styling');
@define('PLUGIN_SIDEBARLOGO_TITLE', 'Titel');
@define('PLUGIN_SIDEBARLOGO_TITLE_DESC', 'Titeltext für das Seitenleistenelement');
@define('PLUGIN_SIDEBARLOGO_IMAGE', 'Logo');
@define('PLUGIN_SIDEBARLOGO_IMAGE_DESC', 'Bild aus der Medienbibliothek, das vor der Beschreibung angezeigt werden soll. Leer lassen, um kein Bild anzuzeigen.');
@define('PLUGIN_SIDEBARLOGO_IMAGEWIDTH', 'Bildbreite');
@define('PLUGIN_SIDEBARLOGO_IMAGEWIDTH_DESC', 'Bildbreite des Logos (CSS-Definitionen wie 50px oder 200% verwenden oder leer lassen)');
@define('PLUGIN_SIDEBARLOGO_IMAGEHEIGHT', 'Bildhöhe');
@define('PLUGIN_SIDEBARLOGO_IMAGEHEIGHT_DESC', 'Bildhöhe des Logos (CSS-Definitionen wie 50px oder 200% verwenden oder leer lassen)');
@define('PLUGIN_SIDEBARLOGO_IMAGETEXT', 'Bildbeschreibung');
@define('PLUGIN_SIDEBARLOGO_IMAGETEXT_DESC', 'Beschreibender Text für das Bild (erforderlich)');
@define('PLUGIN_SIDEBARLOGO_IMAGETEXT_MISSING', 'keine Beschreibung');
@define('PLUGIN_SIDEBARLOGO_DESCRIPTION', 'Beschreibung');
@define('PLUGIN_SIDEBARLOGO_DESCRIPTION_DESC', 'Beschreibung für das Blog oder was auch immer im Element angezeigt werden soll. HTML kann für weitere Formatierung verwendet werden.');
@define('PLUGIN_SIDEBARLOGO_IMAGESTYLE', 'Bild-Stil');
@define('PLUGIN_SIDEBARLOGO_IMAGESTYLE_DESC', 'CSS-Stil, der für das Bild verwendet werden soll. Vorhandene Serendipity image Klassen sind ".serendipity_image(Comment)_(left|center|right)". Für eigene Auszeichnungen: Mit dem Zeichen "#" oder "." beginnen, um eine CSS-ID oder eine CSS-Klasse zu spezifizieren, oder alternativ einen Inline-Style direkt eingeben. Ihre Relevanz liegt in der unterschiedlichen Wertigkeit zueinander.');
@define('PLUGIN_SIDEBARLOGO_DESCRIPTIONSTYLE', 'Beschreibung-Stil');
@define('PLUGIN_SIDEBARLOGO_DESCRIPTIONSTYLE_DESC', 'CSS-Stil, der für die Beschreibung verwendet werden soll. Mit dem Zeichen "#" beginnen, um eine CSS-ID zu spezifizieren, mit "." beginnen, um eine Klasse zu spezifizieren, direkt Inline-Style definieren oder frei lassen, um das Standardseitenleistenstyling zu verwenden (empfohlen).');
@define('PLUGIN_SIDEBARLOGO_DEFAULT_DESCRIPTION', 'Hier Text einfügen');

@define('PLUGIN_SIDEBARLOGO_SITENAME', 'Seitenname');
@define('PLUGIN_SIDEBARLOGO_SITENAME_DESC', 'Der Name der Webseite (z.B. Mein neuer Blog)');
@define('PLUGIN_SIDEBARLOGO_SITENAMESTYLE', 'Seitennamen-Stil');
@define('PLUGIN_SIDEBARLOGO_SITENAMESTYLE_DESC', 'CSS-Stil, der für den Seitennamen verwendet werden soll. Mit dem Zeichen "#" beginnen, um eine CSS-ID zu spezifizieren, mit "." beginnen, um eine Klasse zu spezifizieren oder alternativ einen Inline-Style direkt eingeben.');
@define('PLUGIN_SIDEBARLOGO_SITETAG', 'Motto');
@define('PLUGIN_SIDEBARLOGO_SITETAG_DESC', 'Das Seitenmotto (z.B. Blogger aus Leidenschaft)');
@define('PLUGIN_SIDEBARLOGO_SITETAGSTYLE', 'Motto-Stil');
@define('PLUGIN_SIDEBARLOGO_SITETAGSTYLE_DESC', 'CSS-Stil, der für das Seitenmotto verwendet werden soll. Mit dem Zeichen "#" beginnen, um eine CSS-ID zu spezifizieren, mit "." beginnen, um eine Klasse zu spezifizieren oder alternativ einen Inline-Style direkt eingeben.');
@define('PLUGIN_SIDEBARLOGO_CONTACT', 'Kontaktinformationen');
@define('PLUGIN_SIDEBARLOGO_CONTACT_DESC', 'Eine E-Mail-Adresse oder ein Maillink ("Kontakt: <a href=mailto:max@mustermann.de>Max Mustermann</a>")');
@define('PLUGIN_SIDEBARLOGO_CONTACTSTYLE', 'Kontakt-Stil');
@define('PLUGIN_SIDEBARLOGO_CONTACTSTYLE_DESC', 'CSS-Stil, der für die Kontaktinformationen verwendet werden soll. Mit dem Zeichen "#" beginnen, um eine CSS-ID zu spezifizieren, mit "." beginnen, um eine Klasse zu spezifizieren oder alternativ einen Inline-Style direkt eingeben.');
@define('PLUGIN_SIDEBARLOGO_COPYRIGHT', 'Copyright');
@define('PLUGIN_SIDEBARLOGO_COPYRIGHT_DESC', 'Kleiner Text, der am besten für Copyright oder Rechtshinweise verwendet wird (Copyright-Symbol: "&copy;")');
@define('PLUGIN_SIDEBARLOGO_COPYRIGHTSTYLE', 'Copyright-Stil');
@define('PLUGIN_SIDEBARLOGO_COPYRIGHTSTYLE_DESC', 'CSS-Stil, der für das Copyright verwendet werden soll. Mit dem Zeichen "#" beginnen, um eine CSS-ID zu spezifizieren, mit "." beginnen, um eine Klasse zu spezifizieren oder alternativ einen Inline-Style direkt eingeben.');
@define('PLUGIN_SIDEBARLOGO_DELIMITER', 'Trenner');
@define('PLUGIN_SIDEBARLOGO_DELIMITERSTYLE', 'Trenner-Stil');
@define('PLUGIN_SIDEBARLOGO_DELIMITERSTYLE_DESC', 'Optionaler CSS-Stil für den Trenner. Der Trenner ist ein Element zur Textflusskontrolle nach floats, zB. nach einem "float:left;" wäre dann hier einzutragen "clear:left;". Es zwingt den Rest der Box bzw. der Seite, unter dem Bild weiterzugehen. Normalerweise muss dieser Stil nicht angepasst werden. Das ist nur nötig, wenn entsprechende Änderung am Bild-Stil vorgenommen wurden.');
@define('PLUGIN_SIDEBARLOGO_SEQUENCE', 'Sequenz');
@define('PLUGIN_SIDEBARLOGO_SEQUENCE_DESC', 'Lege die Sequenz der Elemente von SideBar Logo fest und aktiviere bzw. deaktiviere sie (Standard ist: Logo, Beschreibung).');

