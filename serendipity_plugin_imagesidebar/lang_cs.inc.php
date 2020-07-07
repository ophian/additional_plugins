<?php

/**
 *  @author Vladim�r Ajgl <vlada@ajgl.cz>
 *  @translated 2009/03/16
 *  @author Vladim�r Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2013/04/21
 */

@define('PLUGIN_SIDEBAR_IMAGESIDEBAR_NAME', 'Jednotn� zobrazov�n� obr�zk� v postrann�m sloupci');
@define('PLUGIN_SIDEBAR_IMAGESIDEBAR_DESC', 'Umo��uje zobrazovat obr�zky v postrann�m sloupci. Zdroj� t�chto obr�zk� m��e b�t v�cero. Plugin se dok�e p�ipojit do atab�ze Coppermine galerie (pouze pokud b�� na MySQL) a samoz�ejm� i ke Knihovn� m�di� Serendipity.');

@define('PLUGIN_SIDEBAR_IMAGESIDEBAR_DISPLAYSRC_NAME', 'Zdroj obr�zku');
@define('PLUGIN_SIDEBAR_IMAGESIDEBAR_DISPLAYSRC_DESC', 'Vyberte ze seznamu zdroj obr�zk�');
@define('PLUGIN_SIDEBAR_IMAGESIDEBAR_DISPLAYSRC_NONE', 'Je�t� nebylo nic vybr�no');
@define('PLUGIN_SIDEBAR_IMAGESIDEBAR_DISPLAYSRC_COPPERMINE', 'Datab�ze Coppermine');
@define('PLUGIN_SIDEBAR_IMAGESIDEBAR_DISPLAYSRC_MEDIALIB', 'Knihovna m�di� Serendipity');

@define('PLUGIN_CPGS_NAME', 'Coppermine n�hledy');
@define('PLUGIN_CPGS_DESC', 'Zobrazit n�hledy galerie Coppermine v postrann�m sloupci');
@define('PLUGIN_CPGS_SERVER_NAME', 'Server');
@define('PLUGIN_CPGS_SERVER_DESC', 'SQL server pou�it� v Coppermine');
@define('PLUGIN_CPGS_DB_NAME', 'Datab�ze');
@define('PLUGIN_CPGS_DB_DESC', 'SQL datab�ze');
@define('PLUGIN_CPGS_PREFIX_NAME', 'P�edpona (prefix)');
@define('PLUGIN_CPGS_PREFIX_DESC', 'P�edpona - prefix tabulek Coppermine galerie');
@define('PLUGIN_CPGS_USER_NAME', 'P�ihla�ovac� jm�no');
@define('PLUGIN_CPGS_USER_DESC', 'P�ihla�ovac� jm�no do datab�ze');
@define('PLUGIN_CPGS_PASSWORD_NAME', 'Heslo');
@define('PLUGIN_CPGS_PASSWORD_DESC', 'Heslo do datab�ze');
@define('PLUGIN_CPGS_URL_NAME', 'URL');
@define('PLUGIN_CPGS_URL_DESC', 'URL adresa galerie');
@define('PLUGIN_CPGS_TYPE_NAME', 'Typ');
@define('PLUGIN_CPGS_TYPE_DESC', 'Kter� obr�zky zobrazit?');
@define('PLUGIN_CPGS_TITLE_NAME', 'Nadpis');
@define('PLUGIN_CPGS_TITLE_DESC', 'Nadpis postrann�ho bloku');
@define('PLUGIN_CPGS_ALBUM_NAME', 'Odkaz na album');
@define('PLUGIN_CPGS_ALBUM_DESC', 'P�ilo�it odkaz na album pod n�hled obr�zku');
@define('PLUGIN_CPGS_GALLLINK_NAME', 'URL odkaz na galerii');
@define('PLUGIN_CPGS_GALLLINK_DESC', 'URL adresa - odkaz pod n�hledy (pr�zdn� = ��dn� odkaz)');
@define('PLUGIN_CPGS_GALLNAME_NAME', 'N�zev galerie');
@define('PLUGIN_CPGS_GALLNAME_DESC', 'Text pro odkaz na galerii');
@define('PLUGIN_CPGS_COUNT_NAME', 'N�hledy');
@define('PLUGIN_CPGS_COUNT_DESC', 'Po�et zobrazen�ch n�hled�');
@define('PLUGIN_CPGS_SIZE_NAME', 'Velikost');
@define('PLUGIN_CPGS_SIZE_DESC', 'Maxim�ln� velikost n�hled�');
@define('PLUGIN_CPGS_THUMB_NAME', 'Zpracovat i ne-obr�zky?');
@define('PLUGIN_CPGS_THUMB_DESC', 'Pokus� se nal�zt n�hledy generovan� galeri� Coppermine i pro ne-obr�zky (videa apod.)');
@define('PLUGIN_CPGS_FILTER_NAME', 'Filtr alb');
@define('PLUGIN_CPGS_FILTER_DESC', 'T��dit alba podle:');
@define('PLUGIN_CPGS_RECENT', 'Nejnov�j��');
@define('PLUGIN_CPGS_POPULAR', 'Nej�ast�ji zobrazovan�');
@define('PLUGIN_CPGS_RANDOM', 'N�hodn�');

@define('PLUGIN_SIDEBAR_MEDIASIDEBAR_NAME', 'Zobrazen� Knihovny m�di� v postrann�m sloupci');
@define('PLUGIN_SIDEBAR_MEDIASIDEBAR_DESC', 'Zobrazit n�hodn� obr�zek z Knihovny m�di� Serendipity v postrann�m sloupci. (Pozor, nerozli�uje mezi typy soubor�, neodli�uje obr�zky a jin� soubory!)');
@define('PLUGIN_SIDEBAR_MEDIASIDEBAR_DIRECTORY_NAME', 'V�choz� adres��');
@define('PLUGIN_SIDEBAR_MEDIASIDEBAR_DIRECTORY_DESC', 'Vyberte v�choz� adres��, plugin bude vyhled�vat obr�zky pouze v n�m.');
@define('PLUGIN_SIDEBAR_MEDIASIDEBAR_IMAGESTRICT_NAME', 'Nerekurzivn� zobrazov�n� obr�zk�');
@define('PLUGIN_SIDEBAR_MEDIASIDEBAR_IMAGESTRICT_DESC', 'Pokud je "Ano", budou se zobrazovat pouze obr�zky z aktu�ln�ho adres��e. Pokud je "Ne", pak se budou zobrazovat obr�zky i ze v�ech podadres���.');
@define('PLUGIN_SIDEBAR_MEDIASIDEBAR_LINKBEHAVIOR_NAME', 'Chov�n� odkazu');
@define('PLUGIN_SIDEBAR_MEDIASIDEBAR_LINKBEHAVIOR_DESC', '"Ve str�nce" otev�e obr�zek ve st�vaj�c�m okn�. "Vyskakovac� okno" - obr�zek bude otev�en v nov�m, velikostn� p�izp�soben�m okn�. "URL" umo��uje zadat statickou url adresu jako c�l odkazu. "Galerie" povede na st�lou adresu (permalink) pluginu usergallery (pokud je nainstalov�n).');
@define('PLUGIN_SIDEBAR_MEDIASIDEBAR_LINKBEHAVIOR_INPAGE', 'Ve str�nce');
@define('PLUGIN_SIDEBAR_MEDIASIDEBAR_LINKBEHAVIOR_POPUP', 'Vyskakovac� okno');
@define('PLUGIN_SIDEBAR_MEDIASIDEBAR_LINKBEHAVIOR_URL', 'URL adresa');
@define('PLUGIN_SIDEBAR_MEDIASIDEBAR_LINKBEHAVIOR_GALLERY', 'Galerie');
@define('PLUGIN_SIDEBAR_MEDIASIDEBAR_LINKBEHAVIOR_ENTRY', 'Odkaz na p��buzn� p��sp�vek');

@define('PLUGIN_SIDEBAR_MEDIASIDEBAR_WIDTH_NAME', '���ka obr�zku');
@define('PLUGIN_SIDEBAR_MEDIASIDEBAR_WIDTH_DESC', 'Zadat pevnou ���ku obr�zku. Pokud je zad�na nula, plugin obr�zku zad� "width: 100%"');
@define('PLUGIN_SIDEBAR_MEDIASIDEBAR_URL_NAME', 'URL');
@define('PLUGIN_SIDEBAR_MEDIASIDEBAR_URL_DESC', 'St�l� URL adresa, na kterou m� v�st odkaz. (nap�. "http://www.s9y.org")');
@define('PLUGIN_SIDEBAR_MEDIASIDEBAR_GALPERM_NAME', 'Zadejte st�l� odkaz (permalink) nebo podstr�nku');
@define('PLUGIN_SIDEBAR_MEDIASIDEBAR_GALPERM_DESC', 'Tato hodnota se mus� shodovat s hodnotou zadanou v pluginu "galerie". Pamatujte, �e pokud je vypnut� p�episov�n� URL adresy (url rewrite), mus�te pou��t podstr�nku.');
@define('PLUGIN_SIDEBAR_MEDIASIDEBAR_INTRO', 'Libovoln� text (html zna�ky povoleny), kter� m� b�t p�ed obr�zkem');
@define('PLUGIN_SIDEBAR_MEDIASIDEBAR_SUMMERY', 'Libovoln� text (html zna�ky povoleny), kter� bude p�ipojen� za obr�zek');
@define('PLUGIN_SIDEBAR_MEDIASIDEBAR_ROTATETIME_NAME', 'Perioda v�m�ny obr�zk�');
@define('PLUGIN_SIDEBAR_MEDIASIDEBAR_ROTATETIME_DESC', 'Jak �asto maj� b�t vym��ov�ny obr�zky. V minut�ch. Hodnota "0" znamen� obm�nu p�i ka�d�m na�ten� str�nky.');
@define('PLUGIN_SIDEBAR_MEDIASIDEBAR_NUMIMAGES_NAME', 'Po�et zobrazen�ch obr�zk�');
@define('PLUGIN_SIDEBAR_MEDIASIDEBAR_NUMIMAGES_DESC', 'Kolik obr�zk� se m� zobrazovat?');
@define('PLUGIN_SIDEBAR_MEDIASIDEBAR_HOTLINKS_NAME', 'Omezit pouze na hotlink obr�zky');
@define('PLUGIN_SIDEBAR_MEDIASIDEBAR_HOTLINKS_DESC', 'Tato volba omezuje zobrazov�n� obr�zk� v postrann�m sloupci pouze na ty, kter� jsou v Knihovn� m�di� ozna�eny jako hotlink (nejsou ulo�en� na va�em blogu, ale jedn� se pouze na odkazy na ciz� servery).');
@define('PLUGIN_SIDEBAR_MEDIASIDEBAR_HOTLINKBASE_NAME', 'Kl��ov� slovo');
@define('PLUGIN_SIDEBAR_MEDIASIDEBAR_HOTLINKBASE_DESC', 'Vstupem pro tuto funkci je jedin� kl��ov� slovo (bez mezer). Funkce omezuje zobrazov�n� pouze na obr�zky obsahuj�c� zadan� slovo. Nap�. pokud m�te hotlinky z v�ce zdroj�, ale chcete zobrazovat pouze ty poch�zej�c� z jednoho zdroje, m��ete sem napsat nap��klad "zdroj.cz".');

@define('PLUGIN_CPGS_GROUP_NAME', 'U�ivatelsk� skupina (usergroup)');
@define('PLUGIN_CPGS_GROUP_DESC', 'Coppermine umo��uje omezit zobrazen� obr�zk� pouze na zadanou skupinu u�ivatel�. Pokud pot�ebujete zobrazovat pouze n�kter� obr�zky, zadejte u�ivatelskou skupinu, za kterou se bude tento plugin maskovat. "Everybody" znamen�, �e nastaven� u�ivatelsk� skupiny bude ignorov�no.');

