<?php

@define('PLUGIN_EVENT_WIKILINKS_NAME', 'Freie Wiki-Links f�r Eintr�ge');
@define('PLUGIN_EVENT_WIKILINKS_DESC', 'Erm�glicht Links zu blog-internen Eintr�gen via [[Titel]], Links zu Statischen Seiten via ((Titel)) und einen Link zu beidem via {{Titel}}. Zudem wird ein Button zu internen Eintr�gen bereitgestellt.  Referenzen k�nnen am Ende eines Blogeintrags eingehangen werden.');
@define('PLUGIN_EVENT_WIKILINKS_IMGPATH', 'Pfad zu den Bildern');
@define('PLUGIN_EVENT_WIKILINKS_IMGPATH_DESC', 'Bitte Pfad zu den Bildern der Wikilink-Icons eingeben.');

@define('PLUGIN_EVENT_WIKILINKS_EDIT_INTERNAL', 'Bearbeite Blog-Eintrag');
@define('PLUGIN_EVENT_WIKILINKS_EDIT_STATICPAGE', 'Bearbeite Statische Seite');
@define('PLUGIN_EVENT_WIKILINKS_CREATE_INTERNAL', 'Erstelle Blog-Eintrag');
@define('PLUGIN_EVENT_WIKILINKS_CREATE_STATICPAGE', 'Erstelle Statische Seite');

@define('PLUGIN_EVENT_WIKILINKS_LINKENTRY', 'Link zu Eintrag');
@define('PLUGIN_EVENT_WIKILINKS_LINKENTRY_DESC', 'Bitte w�hlen Sie den Eintrag aus, zu dem gelinkt werden soll');

@define('PLUGIN_EVENT_WIKILINKS_SHOWDRAFTLINKS_NAME', 'Links auf Entw�rfe erzeugen?');
@define('PLUGIN_EVENT_WIKILINKS_SHOWDRAFTLINKS_DESC', 'Sollen Links dargestellt werden, selbst wenn der verlinkte Eintrag noch ein Entwurf ist?');
@define('PLUGIN_EVENT_WIKILINKS_SHOWFUTURELINKS_NAME', 'Links auf zuk�nftige Eintr�ge erzeugen?');
@define('PLUGIN_EVENT_WIKILINKS_SHOWFUTURELINKS_DESK', 'Sollen Links dargestellt werden, selbst wenn der verlinkte Eintrag noch in der Zukunft datiert ist?');

@define('PLUGIN_EVENT_WIKILINKS_MAINT', 'Verweise pflegen');//Referenzregister pflegen
@define('PLUGIN_EVENT_WIKILINKS_MAINT_DESC', 'Hier k�nnen Sie gespeicherte Verweise bearbeiten. Beachten Sie, dass, wenn Sie den urspr�nglichen Eintrag bearbeiten in dem der Verweis vorkommt, der Text eines Verweises dort immer Vorrang vor allem hat was Sie hier bearbeiten. Wenn Sie h�ufig alte Eintr�ge neu bearbeiten, sollten Sie die Texte der Verweise besser innerhalb der Eintr�ge pflegen und nicht hier.');

@define('PLUGIN_EVENT_WIKILINKS_DB_REFNAME', 'Referenz Name:');
@define('PLUGIN_EVENT_WIKILINKS_DB_REF', 'Referenz Inhalt:');
@define('PLUGIN_EVENT_WIKILINKS_DB_ENTRYDID', 'Definiert in:');

