<?php

@define('PLUGIN_EVENT_WIKILINKS_NAME', 'Freie Wiki-Links für Einträge');
@define('PLUGIN_EVENT_WIKILINKS_DESC', 'Ermöglicht Links zu blog-internen Einträgen via [[Titel]], Links zu Statischen Seiten via ((Titel)) und einen Link zu beidem via {{Titel}}. Zudem wird ein Button zu internen Einträgen bereitgestellt.  Referenzen können am Ende eines Blogeintrags eingehangen werden.');
@define('PLUGIN_EVENT_WIKILINKS_IMGPATH', 'Pfad zu den Bildern');
@define('PLUGIN_EVENT_WIKILINKS_IMGPATH_DESC', 'Bitte Pfad zu den Bildern der Wikilink-Icons eingeben.');

@define('PLUGIN_EVENT_WIKILINKS_EDIT_INTERNAL', 'Bearbeite Blog-Eintrag');
@define('PLUGIN_EVENT_WIKILINKS_EDIT_STATICPAGE', 'Bearbeite Statische Seite');
@define('PLUGIN_EVENT_WIKILINKS_CREATE_INTERNAL', 'Erstelle Blog-Eintrag');
@define('PLUGIN_EVENT_WIKILINKS_CREATE_STATICPAGE', 'Erstelle Statische Seite');

@define('PLUGIN_EVENT_WIKILINKS_LINKENTRY', 'Link zu Eintrag');
@define('PLUGIN_EVENT_WIKILINKS_LINKENTRY_DESC', 'Bitte wählen Sie den Eintrag aus, zu dem gelinkt werden soll');

@define('PLUGIN_EVENT_WIKILINKS_SHOWDRAFTLINKS_NAME', 'Links auf Entwürfe erzeugen?');
@define('PLUGIN_EVENT_WIKILINKS_SHOWDRAFTLINKS_DESC', 'Sollen Links dargestellt werden, selbst wenn der verlinkte Eintrag noch ein Entwurf ist?');
@define('PLUGIN_EVENT_WIKILINKS_SHOWFUTURELINKS_NAME', 'Links auf zukünftige Einträge erzeugen?');
@define('PLUGIN_EVENT_WIKILINKS_SHOWFUTURELINKS_DESK', 'Sollen Links dargestellt werden, selbst wenn der verlinkte Eintrag noch in der Zukunft datiert ist?');

@define('PLUGIN_EVENT_WIKILINKS_MAINT', 'Verweise pflegen');//Referenzregister pflegen
@define('PLUGIN_EVENT_WIKILINKS_MAINT_DESC', 'Hier können Sie gespeicherte Verweise bearbeiten. Beachten Sie, dass, wenn Sie den ursprünglichen Eintrag bearbeiten in dem der Verweis vorkommt, der Text eines Verweises dort immer Vorrang vor allem hat was Sie hier bearbeiten. Wenn Sie häufig alte Einträge neu bearbeiten, sollten Sie die Texte der Verweise besser innerhalb der Einträge pflegen und nicht hier.');

@define('PLUGIN_EVENT_WIKILINKS_DB_REFNAME', 'Referenz Name:');
@define('PLUGIN_EVENT_WIKILINKS_DB_REF', 'Referenz Inhalt:');
@define('PLUGIN_EVENT_WIKILINKS_DB_ENTRYDID', 'Definiert in:');

