<?php

/**
 *  @author Vladim�r Ajgl <vlada@ajgl.cz>
 *  @translated 2009/06/14
 *  @author Vladim�r Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2010/02/06
 *  @author Vladim�r Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2011/01/08
 */

@define('PLUGIN_EVENT_SITEMAP_TITLE', 'Gener�tor mapy str�nek pro vyhled�va�e');
@define('PLUGIN_EVENT_SITEMAP_DESC',  'Vytv��� soubor sitemap.xml.gz, kter� pou��vaj� nejr�zn�j�� webov� vyhled�va�e (Google, MSN, Yahoo nebo Ask)');
@define('PLUGIN_EVENT_SITEMAP_FAILEDOPEN', 'Nelze otev��t soubor pro z�pis.');
@define('PLUGIN_EVENT_SITEMAP_REPORT', 'Oznamovat zm�ny mapy');
@define('PLUGIN_EVENT_SITEMAP_REPORT_DESC', 'Oznamovat aktualizace mapy str�nek n�sleduj�c�m vyhled�vac�m slu�b�m.');
@define('PLUGIN_EVENT_SITEMAP_REPORT_ERROR', 'Nepoda�ilo se ohl�sit aktualizaci mapy str�nek na %s: %s<br />');
@define('PLUGIN_EVENT_SITEMAP_REPORT_OK', 'Mapa str�nek posl�na na %s.<br />');
@define('PLUGIN_EVENT_SITEMAP_REPORT_MANUAL','Mapa str�nek nebyla posl�na na %s, ud�lejte to ru�n� te� n�v�t�vou <a href="%s">tohoto odkazu</a>.<br/>');
@define('PLUGIN_EVENT_SITEMAP_ROBOTS_TXT', 'M��ete ji tak� p�idat do souboru "robots.txt", viz. <a href="http://googlewebmastercentral.blogspot.com/2007/04/whats-new-with-sitemapsorg.html">podrobnosti k robots.txt</a>.<br/>');
@define('PLUGIN_EVENT_SITEMAP_URL', 'Seznam URL adres pro ozn�men� (ping)');
@define('PLUGIN_EVENT_SITEMAP_URL_DESC', 'URL adresy pro ozn�men� (pingbacks) (%s bude nahrazeno URL adresou mapy str�nek, v�ce adres odd�lujte pomoc� \';\' (st�edn�k), pokud pot�ebujete zadat znak st�edn�ku ; napi�te \'%3B\').');
@define('PLUGIN_EVENT_SITEMAP_ADDFEEDS', 'P�idat kan�l s novinkami');
@define('PLUGIN_EVENT_SITEMAP_ADDFEEDS_DESC', 'Do mapy str�nek zahrne i RSS kan�ly (RSS 0.9, 1.0, 2.0, Atom a kategorie).');
@define('PLUGIN_EVENT_SITEMAP_UNKNOWN_SERVICE', 'nezn�m�');
@define('PLUGIN_EVENT_SITEMAP_PERMALINK_WARNING', 'Varov�n�: pro spr�vn� vygenerov�n� mapy str�nek je t�eba um�stit plugin "permalink" (st�l� odkazy) <b>p�ed</b> plugin "mapa str�nek".');
@define('PLUGIN_EVENT_SITEMAP_GZIP_SITEMAP', 'Gzipovat soubor sitemap.xml (komprese)');
@define('PLUGIN_EVENT_SITEMAP_GZIP_SITEMAP_DESC', 'Protokol pro mapy str�nek umo��uje komprimovat soubor pomoc� gzipu pro sn�en� objemu datov�ho p�enosu. Pokud pozorujete probl�my s pluginem, m��ete zkusit vypnout tuto volbu. (Pozn�mka: pokud Va�e instalace PHP nepodporuje gzip funkce, plugin automaticky bude tvo�it nekomprimovan� soubor. Tedy obecn� nen� pot�eba tuto volbu ru�n� vyp�nat.)');
@define('PLUGIN_EVENT_SITEMAP_TYPES_TO_ADD', 'Typy URL pro p�id�n�');
@define('PLUGIN_EVENT_SITEMAP_TYPES_TO_ADD_DESC', 'Zadejte typy URL adres, kter� maj� b�t zahrnuty do mapy str�nek.');
@define('PLUGIN_EVENT_SITEMAP_TYPES_TO_ADD_FEEDS', 'Kan�ly');
@define('PLUGIN_EVENT_SITEMAP_TYPES_TO_ADD_CATEGORIES', 'Kategorie');
@define('PLUGIN_EVENT_SITEMAP_TYPES_TO_ADD_AUTHORS', 'Auto�i');
@define('PLUGIN_EVENT_SITEMAP_TYPES_TO_ADD_PERMALINKS', 'St�l� odkazy (permalinky)');
@define('PLUGIN_EVENT_SITEMAP_TYPES_TO_ADD_ARCHIVES', 'Archivy');
@define('PLUGIN_EVENT_SITEMAP_TYPES_TO_ADD_STATIC', 'Statick� str�nky');
@define('PLUGIN_EVENT_SITEMAP_TYPES_TO_ADD_TAGS', 'Str�nky s tagy');
@define('PLUGIN_EVENT_SITEMAP_CUSTOM', 'Vlastn� (XML t�lo)');
@define('PLUGIN_EVENT_SITEMAP_CUSTOM_DESC', 'Zde zadejte text ve form�tu XML, kter� chcete p�idat na konec vygenerovan�ho souboru s mapou str�nek. Pomoc� t�to volby m��ete ru�n� p�idat KML soubory nebo nap��klad odkazy. Zkontrolujte, �e to, co zde zad�te, odpov�d� standardu XML.');
@define('PLUGIN_EVENT_SITEMAP_CUSTOM2', 'Vlastn� (XML hlavi�ka/jmenn� prostor)');
@define('PLUGIN_EVENT_SITEMAP_CUSTOM2_DESC', 'Zde m��ete zadat libovoln� text v XML form�tu, kter� bude p�id�n do hlavi�ky (nahoru) vygenerovan�ho souboru s mapou str�nek, p��mo do XML elementu "urlset". Zkontrolujte, �e to, co zde zad�te, odpov�d� standardu XML.');
@define('PLUGIN_EVENT_SITEMAP_NEWS', 'Zapnout obsah GoogleNews');

// Next lines were translated on 2010/02/06

@define('PLUGIN_EVENT_SITEMAP_GNEWS_NAME', 'Nadpis pro obsah GoogleNews');
@define('PLUGIN_EVENT_SITEMAP_GNEWS_NAME_DESC', 'Zadejte nadpis pro obsah GoogleNows');
@define('PLUGIN_EVENT_SITEMAP_PUBLIC', 'Ve�ejn�');
@define('PLUGIN_EVENT_SITEMAP_SUBSCRIPTION', 'Z�pis/p�edplatn� (placen� obsah)');
@define('PLUGIN_EVENT_SITEMAP_REGISTRATION', 'Registrace (obsah zdarma, registrace vy�adov�na)');
@define('PLUGIN_EVENT_SITEMAP_PRESS', 'Tiskov� zpr�va');
@define('PLUGIN_EVENT_SITEMAP_SATIRE', 'Satira');
@define('PLUGIN_EVENT_SITEMAP_BLOG', 'Blog');
@define('PLUGIN_EVENT_SITEMAP_OPED', 'N�zor autora');
@define('PLUGIN_EVENT_SITEMAP_OPINION', 'N�zor ostatn�ch');
@define('PLUGIN_EVENT_SITEMAP_USERGENERATED', 'U�ivatelsky vytvo�en� obsah');
@define('PLUGIN_EVENT_SITEMAP_GNEWS_SUBSCRIPTION', 'GoogleNews: typ obsahu');
@define('PLUGIN_EVENT_SITEMAP_GNEWS_SUBSCRIPTION_DESC', '');
@define('PLUGIN_EVENT_SITEMAP_GENRES', 'GoogleNews: ��nry');
@define('PLUGIN_EVENT_SITEMAP_GENRES_DESC', 'V sou�asnosti se tyto ��nry projev� u v�ech p��sp�vk�. Tak�e byste m�li vybrat ��nr, kter� se hod� na v�t�inu p��sp�vk� v blogu. Aby se tato volba stala z�vislou na jednotliv�ch p��sp�vc�ch, mus�te k p��sp�vk�m p�idat u�ivatelsk� pole (CustomProperty) pojmenovan� "gnews_genre", kter� m��e obsahovat ��nry jako textov� �et�zce odd�len� ��rkou.');
@define('PLUGIN_EVENT_SITEMAP_NONE', '��dn� ��nr');

// Next lines were translated on 2011/01/08
@define('PLUGIN_EVENT_SITEMAP_NEWS_SINGLE', 'Slou�it mapu str�nek GoogleNews (Novinky Google) s norm�ln� mapou str�nek?');
@define('PLUGIN_EVENT_SITEMAP_NEWS_SINGLE_DESC', 'Toto nastaven� se uplatn� pouze pokud jste povolili obsah novinek Google (GoogleNews). Pokud je zapnuto, norm�ln� soubor sitemap.xml bude obsahovat zna�ky z GoogleNews. Pokud je vypnuto, pak bude data form�tovan� podle GoogleNews obsahovat pouze soubor news_sitemap.xml. Pokud m�te v�ce ne� podporovan�ch 1000 �l�nk� na blogu, mus�te tuto volbu vypnout, abyste nem�tli GoogleSpiders va�� norm�ln� mapou str�nek.');

