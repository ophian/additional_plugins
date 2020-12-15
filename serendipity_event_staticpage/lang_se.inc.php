<?php

@define('PLUGIN_STATICPAGELIST_NAME',             'lista med statiska sidorna');
@define('PLUGIN_STATICPAGELIST_NAME_DESC',        'Den h�r plugin visar en konfigurerbar lista den statiska sidorna. StaticPage-Plugin beh�ver version 1.22 eller h�gre.');
@define('PLUGIN_STATICPAGELIST_TITLE',            'Titel');
@define('PLUGIN_STATICPAGELIST_TITLE_DESC',       'Rubrik f�r den sidonavigator:');
@define('PLUGIN_STATICPAGELIST_TITLE_DEFAULT',    'statiska sidor');
@define('PLUGIN_STATICPAGELIST_LIMIT',            "Antal sidor: Seitenanzahl");
@define('PLUGIN_STATICPAGELIST_LIMIT_DESC',       "Max antal sidor som ska visas. Maximale Anzahl der anzuzeigenden Seiten");
@define('PLUGIN_STATICPAGELIST_FRONTPAGE_NAME',   "Visa startsidorlink Startseitenlink anzeigen");
@define('PLUGIN_STATICPAGELIST_FRONTPAGE_DESC',   "Skapar l�nk p� Startsidor Einen Link zur Startseite erstellen");
@define('PLUGIN_STATICPAGELIST_FRONTPAGE_LINKNAME',"Startsidor");

@define('STATICPAGE_HEADLINE', 'Sidhuvudet');
@define('STATICPAGE_HEADLINE_BLAHBLAH', 'visar ett sidhuvud som titel p� den statiska sidan'); 
@define('STATICPAGE_TITLE', 'statiska sidor');
@define('STATICPAGE_TITLE_BLAHBLAH', 'F�rvaltar olika statiska sidor inom ditt blog med blog-design och alla formateringen. L�gg3r till en ny menypunkt i administrationsgr�nssnittet!');
@define('STATICPAGE_PAGETITLE', 'Sidans URL-Titel');
@define('STATICPAGE_PERMALINK', 'Permal�nk');
@define('STATICPAGE_PERMALINK_BLAHBLAH', 'Anger den statiska sidans permal�nkar. Denna m�ste ha en absolut s�kv�g fr�n HTTP.roten och ha fil�ndelsen .htm eller .html!');
@define('CONTENT_BLAHBLAH', 'inneh�llet','der Inhalt');
@define('STATICPAGE_ARTICLEFORMAT', 'Formatera som artikel?');
@define('STATICPAGE_ARTICLEFORMAT_BLAHBLAH', 'best�mmer om utg�van automatiskt ska formateras som en artikel (f�rger, kanter mm.) (Standard: ja)');
@define('STATICPAGE_ARTICLEFORMAT_PAGETITLE', 'Sidans titel som "Formaters som artikel"-vy');
@define('STATICPAGE_ARTICLEFORMAT_PAGETITLE_BLAHBLAH', 'N�r optionen "Formatera som artikel" �r vald, kan man genom den h�r titeln avg�ra vad som ska visas p� det st�llet d�r vanligtvis blog-datumet finns.');
@define('STATICPAGE_SELECT',           'V�lj statiska sidor f�r bearbetning.');
@define('STATICPAGE_PASSWORD_NOTICE',   'Denna sida �r l�senordsskyddad. Var god ange ditt l�senord: ');
@define('STATICPAGE_PARENTPAGES_NAME',  'Parent sida');
@define('STATICPAGE_PARENTPAGE_DESC',   'V�lj den �verordnade sidan');
@define('STATICPAGE_PARENTPAGE_PARENT', ' �r parent sida');
@define('STATICPAGE_AUTHORS_NAME',      'F�rfattarens namn');
@define('STATICPAGE_AUTHORS_DESC',      'F�rfattare har skapat sidan');
@define('STATICPAGE_FILENAME_NAME',     'Template (Smarty)');
@define('STATICPAGE_FILENAME_DESC',     'Ange det templates filnamn, som ska anv�ndas f�r denna sida. Smarty-filen �terfinns antingen bland dina plugin eller i din template-mapp.');

@define('STATICPAGE_SHOWCHILDPAGES_NAME', 'visa child-sidor');
@define('STATICPAGE_SHOWCHILDPAGES_DESC', 'visa samtliga child-sidor som linklista.');
@define('STATICPAGE_PRECONTENT_NAME', 'Inledning');
@define('STATICPAGE_PRECONTENT_DESC', 'Denna inledning visas f�re child-sidorna.');
@define('STATICPAGE_CANNOTDELETE_MSG', 'Denna sida kan inte raderas eftersom det finns fortfarande child-sidor i databasen. Dessa beh�ver raderas innan.');
@define('STATICPAGE_IS_STARTPAGE', 'Definiera denna sida som startsida');
@define('STATICPAGE_IS_STARTPAGE_DESC', 'Ist�llet f�r serendipities ska denna statiska sida vara startsida. Du f�r enbart definiera en sida som standardsida. Om du vill vill skapa en l�nk till den ursprungliga sidan, f�r du l�nka till "index.php?frontpage"');
@define('STATICPAGE_TOP', 'H�g');
@define('STATICPAGE_LINKNAME', 'Bearbeta');

@define('STATICPAGE_ARTICLETYPE', 'Typ av artikel');
@define('STATICPAGE_ARTICLETYPE_DESC', 'V�lj en typ av artikel f�r denna sida.');

@define('STATICPAGE_CATEGORY_PAGEORDER', 'Sidornas ordning');
@define('STATICPAGE_CATEGORY_PAGES', 'Editera sidor');
@define('STATICPAGE_CATEGORY_PAGETYPES', 'Editera sidtyp');

@define('PAGETYPES_SELECT', 'V�lj en sidtyp f�r bearbetning.');
@define('STATICPAGE_ARTICLETYPE_DESCRIPTION', 'Beskrivning');
@define('STATICPAGE_ARTICLETYPE_DESCRIPTION_DESC', 'Beskrivning av sidan.');
@define('STATICPAGE_ARTICLETYPE_TEMPLATE', 'Templatenamn');
@define('STATICPAGE_ARTICLETYPE_TEMPLATE_DESC', 'Templatenamn. Ett template kan �terfinnas i staticpages-plugin mappen eller i standardmappen f�r template.');
@define('STATICPAGE_ARTICLETYPE_IMAGE', 's�kv�g bild');
@define('STATICPAGE_ARTICLETYPE_IMAGE_DESC', 'URL f�r en kategoribild.');

