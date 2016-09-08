<?php

/**
 *  @author Vladim�r Ajgl <vlada@ajgl.cz>
 *  @translated 2009/06/04
 *  @author Vladim�r Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2010/12/25
 */

@define('PLUGIN_EVENT_MOBILE_OUTPUT_NAME', 'Markup: V�stup na mobil');
@define('PLUGIN_EVENT_MOBILE_OUTPUT_DESC', 'Tento plugin se star� o vytvo�en� k�du optimalizovan�ho pro mobiln� telefony (tzv. XHTML MP), pokud zjist�, �e str�nku prohl�� prohl�e� pro mobily. Plugin je speci�ln� optimalizov�n pro iPhone a iPod Touch. Plugin tak� m�n� velikost obr�zk�, aby se p�izp�sobily velikosti displeje.');

@define('PLUGIN_EVENT_MOBILE_OUTPUT_ENABLE_PLUGIN_NAME', 'Povolit plugin');
@define('PLUGIN_EVENT_MOBILE_OUTPUT_ENABLE_PLUGIN_DESC', 'Povoluje optimalizace v�stupn�ho HTML pro mobiln� telefony');

@define('PLUGIN_EVENT_MOBILE_OUTPUT_MOBILE_TEMPLATE_NAME', '�ablona pro mobily');
@define('PLUGIN_EVENT_MOBILE_OUTPUT_MOBILE_TEMPLATE_DESC', 'Jm�no �ablony vzhledu pro mobiln� telefony. V�choz� je "xhtml_mp", kter� je distribuov�na s pluginem.');

@define('PLUGIN_EVENT_MOBILE_OUTPUT_IPHONE_TEMPLATE_NAME', '�ablona vzhledu pro iPohne');
@define('PLUGIN_EVENT_MOBILE_OUTPUT_IPHONE_TEMPLATE_DESC', 'Jm�no �ablony vzhledu pro iPhony. V�choz� je "iphone,app", kter� je distribuov�na spole�n� s pluginem.');

@define('PLUGIN_EVENT_MOBILE_OUTPUT_IMAGES_NAME', 'Zobrazovat obr�zky');
@define('PLUGIN_EVENT_MOBILE_OUTPUT_IMAGES_DESC', 'Zobrazovat obr�zky v p��sp�vc�ch');

@define('PLUGIN_EVENT_MOBILE_OUTPUT_SCALE_IMAGE_WIDTH_NAME', 'Maxim�ln� ���ka obr�zku');
@define('PLUGIN_EVENT_MOBILE_OUTPUT_SCALE_IMAGE_WIDTH_DESC', 'Zm�n� velikost obr�zku na ���ku X pixel�. Nastavte 0 pro zak�z�n� zm�ny velikosti obr�zk�. Vy�aduje knihovnu GD!');
@define('PLUGIN_EVENT_MOBILE_OUTPUT_REDIRECT_NAME', 'P�esm�rov�n� (redirect)');
@define('PLUGIN_EVENT_MOBILE_OUTPUT_REDIRECT_DESC', 'P�esm�rov�v� mobiln� prohl�e�e na jinou webovou adresu (viz. n�e)');

@define('PLUGIN_EVENT_MOBILE_OUTPUT_REDIRECT_URL_NAME', 'C�l p�esm�rov�n�');
@define('PLUGIN_EVENT_MOBILE_OUTPUT_REDIRECT_URL_DESC', 'P�esm�rovat mobiln� prohl�e�e na tuto adresu (nap�. "m.vasblog.com"). M��e to b�t jin� host, kde b�� stejn� instance Serendipity, nap�. z d�vod� optimalizace na vyhled�v�n� (SEO).');

@define('PLUGIN_EVENT_MOBILE_OUTPUT_STICKY_HOST_NAME', 'Mobiln� host');
@define('PLUGIN_EVENT_MOBILE_OUTPUT_STICKY_HOST_DESC', 'Tento host bude v�dycky vracet v�stup pro mobily. Nechte pr�zdn� pro zak�z�n�.');

@define('PLUGIN_EVENT_MOBILE_OUTPUT_WURFL_NAME', 'Pou��t WURFL');
@define('PLUGIN_EVENT_MOBILE_OUTPUT_WURFL_DESC', 'Pokud je tato volba zapnut�, velikost v�ech obr�zk� bude upravena tak, aby p�esn� sed�ly na velikost displeje mobiln�ho za��zen�. P�i t�to funkci je pou�it� optimalizovan� verze WURFL UAP (http://wurfl.sourceforge.net/). Nejnov�j�� verze souboru "wurfl.xml" je na http://c.seo-mobile.de/. Tento soubor je ale st�le dost velk�, proto je cachov�n. Cachov�n� spot�ebov�v� kolem 50MB na disku. Pokud st�hnete nov� soubor "wurfl.xml", zadejte v prohl�e�i '.$serendipity['baseURL'].'plugins/serendipity_event_mobile_output/wurfl/update_cache.php pro vytvo�en� cache. Tato funkce pou��v� v��e uveden� nastaven� "Maxim�ln� ���ka obr�zku" jako nouzovou hodnotu, pokud se nepoda�� zjistit velikost displeje. Tato funkce m��e zv��it z�t� serveru! D�LE�IT�: webserver mus� m�t pr�vo z�pisu v adres��i "wurfl/data/" kv�li cachi!');

@define('PLUGIN_EVENT_MOBILE_OUTPUT_CATEGORIES_NAME', 'Zobrazovat kategorie');
@define('PLUGIN_EVENT_MOBILE_OUTPUT_CATEGORIES_DESC', 'Zobrazit v�echny kategorie v naviga�n� pati�ce a p�idej funkci p��stupov�ho tla��tka. Pokud existuje v�ce ne� 9 kategori�, s p��stupov�m tla��tkem bude asociov�no pouze prvn�ch 9.');

@define('PLUGIN_EVENT_MOBILE_OUTPUT_REMOVE_TAGS_NAME', 'Odstranit HTML tagy');
@define('PLUGIN_EVENT_MOBILE_OUTPUT_REMOVE_TAGS_DESC', '��rkami odd�len� seznam tag�, kter� se maj� odstra�ovat, nap�. script, object, embed, ...');

@define('PLUGIN_EVENT_MOBILE_OUTPUT_REMOVE_ATTRIBUTES_NAME', 'Odstranit HTML atributy');
@define('PLUGIN_EVENT_MOBILE_OUTPUT_REMOVE_ATTRIBUTES_DESC', '��rkami odd�len� seznam atribut�, kter� se maj� odstranit, nap�. onclick, onmouseover, style');

@define('PLUGIN_EVENT_MOBILE_OUTPUT_REWRITE_WIKIPEDIA_NAME', 'P�epsat odkazy Wikipedie');
@define('PLUGIN_EVENT_MOBILE_OUTPUT_REWRITE_WIKIPEDIA_DESC', 'P�episuje odkaz sm��uj�c� na Wikipedii tak, aby sm��ovaly na stejn� heslo na mobiln� Wikipedii (http://wikipedia.7val.com/)');

@define('PLUGIN_EVENT_MOBILE_OUTPUT_DEBUG_PASSWORD_NAME', 'Ladic� heslo');
@define('PLUGIN_EVENT_MOBILE_OUTPUT_DEBUG_PASSWORD_DESC', 'Zadejte heslo, po jeho� zad�n� budou zobrazeny ladic� zpr�vy. Ty zboraz�te p�id�n�m ?mpDebug=HESLO k URL adrese blogu');

@define('PLUGIN_EVENT_MOBILE_OUTPUT_NAVIGATION', 'Navigace');

@define('PLUGIN_EVENT_MOBILE_OUTPUT_SITEMAP_NAME', 'Vytvo�it mapu str�nek pro mobily');
@define('PLUGIN_EVENT_MOBILE_OUTPUT_SITEMAP_DESC', 'Vytv��� soubor mobile_sitemap.xml(.gz) v ko�enov�m adres��i Serendipity pro vyhled�vac� roboty jako je Google, Ask.com apod.');
@define('PLUGIN_EVENT_MOBILE_OUTPUT_SITEMAP_REPORT_NAME', 'Oznamovat aktualizace');
@define('PLUGIN_EVENT_MOBILE_OUTPUT_SITEMAP_REPORT_DESC', 'Oznamovat aktualizace n�e zadan�m slu�b�m');
@define('PLUGIN_EVENT_MOBILE_OUTPUT_SITEMAP_URL_NAME', 'Seznam URL pro ozn�men�');
@define('PLUGIN_EVENT_MOBILE_OUTPUT_SITEMAP_URL_DESC', 'URL adresy pro pos�l�n� ozn�men� o aktualizac�ch (%s je nahrazeno URL adresou na soubor s mapou str�nek, v�ce slu�eb odd�lujte st�edn�kem ";", pokud pot�ebujete zadat st�edn�k do URL adresy, pou�ijte "%3B").');
@define('PLUGIN_EVENT_MOBILE_OUTPUT_SITEMAP_GZIP_NAME', 'Gzipovat soubor s mapou mobile_sitemap.xml');
@define('PLUGIN_EVENT_MOBILE_OUTPUT_SITEMAP_GZIP_DESC', 'Protokol pro mobiln� mapu str�nek podporuje gzipovan� soubory pro zm�n�en� datov�ho toku. Pokud p�i pou�it� t�to funkce naraz�te na probl�my, m��ete ji zkusit vypnout. (Pozn. Pokud Va�e instalace PHP nepodporuje funkce gzip, plugin bude automaticky tvo�it nezipovanou mapu str�nek. Tedy obecn� nen� nutn� tuto volbu vyp�nat.)');
@define('PLUGIN_EVENT_MOBILE_OUTPUT_SITEMAP_PERMALINK_WARNING', 'Varov�n�: pro vygenerov�n� spr�vn� mapy str�nek mus�te m�t v nastaven� plugin� plugin "permalink" um�st�n� p�ed pluginem "Sitemap".');
@define('PLUGIN_EVENT_MOBILE_OUTPUT_SITEMAP_FAILEDOPEN', 'Nelze otev��t soubor pro psan�.');
@define('PLUGIN_EVENT_MOBILE_OUTPUT_SITEMAP_UNKNOWN_HOST', 'C�l ozn�men� o aktualizaci nenalezen.');
@define('PLUGIN_EVENT_MOBILE_OUTPUT_SITEMAP_REPORT_ERROR', 'Nepoda�ilo se ohl�sit aktualizaci na %s: %s<br/>');
@define('PLUGIN_EVENT_MOBILE_OUTPUT_SITEMAP_REPORT_OK', 'Aktualizovan� mapa str�nek odesl�na na %s.<br/>');
@define('PLUGIN_EVENT_MOBILE_OUTPUT_SITEMAP_REPORT_MANUAL', 'Pokud se nepoda�ilo zapsat mapu str�nek na %s, ud�lejte to te� n�v�t�vou <a href="%s">tohoto odkazu</a>.');

// Next lines were translated on 2010/12/25
@define('PLUGIN_EVENT_MOBILE_OUTPUT_ANDROID_TEMPLATE_NAME', '�ablona pro Androidy');
@define('PLUGIN_EVENT_MOBILE_OUTPUT_ANDROID_TEMPLATE_DESC', 'N�zev �ablony pro telefony Android. V�choz� je "android,app", kter� je sou��st� pluginu.');
@define('PLUGIN_EVENT_MOBILE_OUTPUT_SMALLTEASER_NAME', 'Mal� ochutn�vky');
@define('PLUGIN_EVENT_MOBILE_OUTPUT_SMALLTEASER_DESC', 'Pokud je zapnuto, bude v p�ehledu p��sp�vk� zobrazen pouze prvn� odstavec p��sp�vku. Opa�n� je zobrazeno cel� t�lo bez roz���en� textov� ��sti jako obvykle.');

