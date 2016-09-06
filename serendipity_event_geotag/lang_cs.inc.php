<?php

/**
 * @author Vladim�r Ajgl <vlada@ajgl.cz>
 * EN-Revision: Revision of lang_en.inc.php
 * Revision-date: 2008/01/27 17:35:00
 * Revision-author: Vladim�r Ajgl <vlada@ajgl.cz>
 * @author Vladim�r Ajgl <vlada@ajgl.cz>
 * @revisionDate 2009/06/30
 * @author Vladim�r Ajgl <vlada@ajgl.cz>
 * @revisionDate 2009/08/15
 * @author Vladim�r Ajgl <vlada@ajgl.cz>
 * @revisionDate 2012/01/10
 * @author Vladim�r Ajgl <vlada@ajgl.cz>
 * @revisionDate 2012/06/22
 */

//
// serendipity_event_geotag.php
//

@define('PLUGIN_EVENT_GEOTAG_TITLE', 'Geotag');
@define('PLUGIN_EVENT_GEOTAG_DESC', 'Umo��uje p�idat k p��sp�vku zem�pisn� sou�adnice - geotag');
@define('PLUGIN_EVENT_GEOTAG_LONG', 'Zem�pisn� d�lka');
@define('PLUGIN_EVENT_GEOTAG_LONG_DESC', 'Zem�pisn� d�lka st�edu mapy p�i editaci p��sp�vku - mapa pro zad�v�n� sou�adnic. Uplatn� se pouze pokud v p��sp�vku ji� nejsou zad�ny sou�adnice. Pokud jsou zad�ny, je mapa vyst�ed�na na zadanou sou�adnici.');
@define('PLUGIN_EVENT_GEOTAG_LAT', 'Zem�pisn� ���ka');
@define('PLUGIN_EVENT_GEOTAG_LAT_DESC', 'Zem�pisn� ���ka st�edu mapy p�i editaci p��sp�vku - mapa pro zad�v�n� sou�adnic. Uplatn� se pouze pokud v p��sp�vku ji� nejsou zad�ny sou�adnice. Pokud jsou zad�ny, je mapa vyst�ed�na na zadanou sou�adnici.');
@define('PLUGIN_EVENT_GEOTAG_ZOOM', 'Zoom');
@define('PLUGIN_EVENT_GEOTAG_ZOOM_DESC', 'P�ibl�en� mapy p�i editaci p��sp�vku - mapa pro zad�v�n� sou�adnic.');
@define('PLUGIN_EVENT_GEOTAG_FRONTEND_LABEL', 'Sou�adnice');
@define('PLUGIN_EVENT_GEOTAG_MAP_URL', 'URL mapy');
@define('PLUGIN_EVENT_GEOTAG_MAP_DESC', 'Up�esn�te podrobn� link do mapy, nap��klad http://local.google.com/maps?q=%GEO_LAT%,%GEO_LONG%+(%TITLE%)&spn=0.1,0.1&t=h');
@define('PLUGIN_EVENT_GEOTAG_API_KEY', 'Google Maps API key');
@define('PLUGIN_EVENT_GEOTAG_API_KEY_DESC', 'Z�skejte ho na adrese http://www.google.com/apis/maps/signup.html. Ponechte pr�zdn�, pokud nechcete pou��v�t Google Maps location picker.');

//
// serendipity_plugin_geotag.php
//

@define('PLUGIN_GEOTAG_GMAP_NAME', "Geotag Google Map");
@define('PLUGIN_GEOTAG_GMAP_NAME_DESC', "Tento plugin zobrazuje sou�adnice u osou�adnicovan�ch p��sp�vk� v map�ch na Googlu");
@define('PLUGIN_GEOTAG_GMAP_TITLE', "Nadpis");
@define('PLUGIN_GEOTAG_GMAP_TITLE_DESC', "Vlo�te nadpis postran�ho panelu:");
@define('PLUGIN_GEOTAG_GMAP_TITLE_DEFAULT', "GMap");
@define('PLUGIN_GEOTAG_GMAP_KEY', "Google Maps API Key");
@define('PLUGIN_GEOTAG_GMAP_KEY_DESC', "Z�skejte jej na http://www.google.com/apis/maps/signup.html zad�n�m ko�enov� adresy va�eho blogu:");
@define('PLUGIN_GEOTAG_GMAP_WIDTH', "���ka");
@define('PLUGIN_GEOTAG_GMAP_WIDTH_DESC', "(v�choz� = 220).");
@define('PLUGIN_GEOTAG_GMAP_HEIGHT', "V��ka");
@define('PLUGIN_GEOTAG_GMAP_HEIGHT_DESC', "(v�choz� = 150).");
@define('PLUGIN_GEOTAG_GMAP_ZOOM', "Velikost zoomu");
@define('PLUGIN_GEOTAG_GMAP_ZOOM_DESC', "(0-8) P�i 0 je vid�t cel� sv�t, v�t�� ��sla pro bli��� pohled.");
@define('PLUGIN_GEOTAG_GMAP_LONGITUDE', "Zem�pisn� d�lka");
@define('PLUGIN_GEOTAG_GMAP_LONGITUDE_DESC', "Zem�pisn� d�lka st�edu mapy");
@define('PLUGIN_GEOTAG_GMAP_LATITUDE', "Zem�pisn� ���ka");
@define('PLUGIN_GEOTAG_GMAP_LATITUDE_DESC', "Zem�pisn� ���ka st�edu mapy");
@define('PLUGIN_GEOTAG_GMAP_TYPE', "Typ mapy");
@define('PLUGIN_GEOTAG_GMAP_TYPE_DESC', "Satelitn�, Mapa nebo Hybridn�");
@define('PLUGIN_GEOTAG_GMAP_SATELLITE', "Satelitn�");
@define('PLUGIN_GEOTAG_GMAP_MAP', "Mapa");
@define('PLUGIN_GEOTAG_GMAP_HYBRID', "Hybridn�");
@define('PLUGIN_GEOTAG_GMAP_RSSURL', "RSS2 URL");
@define('PLUGIN_GEOTAG_GMAP_RSSURL_DESC', "Pro volbu z�sk�v�n� geodat z RSS kan�lu: URL na geotagovan� RSS2 kan�l. M��ete pou��t jednotlivou kategorii, nebo p�ipojit v�e - all=1.");

@define('PLUGIN_GEOTAG_GMAP_DATABASE', 'datab�ze');
@define('PLUGIN_GEOTAG_GMAP_GEODATA_SOURCE', 'Zdroj geodat');
@define('PLUGIN_GEOTAG_GMAP_GEODATA_SOURCE_DESC', 'Vyberte, odkud se maj� z�sk�vat geodata. "RSS" znamen�, �e javacsript bude na��tat rss kan�l, kter� specifikujete ve volb� n�e, z n�j pak bude vysos�vat sou�adnice. "Datab�ze" znamen�, �e se budou na��tat z datab�ze. RSS kan�l je obecn�j�� a sn�� zat�en� p��stupu do datab�ze d�ky mo�nosti cachov�n�, ale pokud m�te rozs�hl� blog, m��e u�ivateli napoprv� trvat dlouhou dobu, ne� se st�hne kompletn� RSS kan�l.');
@define('PLUGIN_GEOTAG_GMAP_CATEGORY_DESC', 'Pro volbu z�sk�v�n� geodat z datab�ze: Zde m��ete omezit zobrazov�n� sou�adnic na p��sp�vky z jedin� kategorie.');
@define('PLUGIN_GEOTAG_GMAP_GEOCODE', 'naj�t adresu');
@define('PLUGIN_GEOTAG_GMAP_GEOCODE_TYPE_ADDRESS', 'Napi�te adresu...');
@define('PLUGIN_GEOTAG_GMAP_GEOCODE_MSG_PROGRESS', 'Sna��m se naj�t sou�adnice...');
@define('PLUGIN_GEOTAG_GMAP_GEOCODE_NOT_FOUND', 'nenalezeno:-(');
@define('PLUGIN_GEOTAG_GMAP_GEOCODE_OK', 'OK');

// Next lines were translated on 2012/01/10

@define('PLUGIN_EVENT_GEOTAG_WARNING_GEOURL_PLUGIN', 'VAROV�N�: nalezen plugin GeoUrl. Odinstalujte ho pros�m, je zastaral� a d�le neudr�ovan�.<br/>V�echny jeho funkce jsou zaji�t�ny i pluginem GeoTag. Plugin GeoTag je podrobn�j��, um� toho v�c.');
@define('PLUGIN_EVENT_GEOTAG_HEADER_EDITOR', 'Nastaven� editoru p��sp�vku');
@define('PLUGIN_EVENT_GEOTAG_HEADER_FOOTER', 'Nastaven� pati�ky p��sp�vku');
@define('PLUGIN_EVENT_GEOTAG_HEADER_FOOTER_LIST', 'Nastaven� pati�ky p��sp�vku (v p�ehledu p��sp�vk�)');
@define('PLUGIN_EVENT_GEOTAG_HEADER_FOOTER_SINGLE', 'Nastaven� pati�ky p��sp�vku (p�i zobrazen� jedin�ho p��sp�vku)');
@define('PLUGIN_EVENT_GEOTAG_HEADER_HDRTAG', 'HTML hlavi�ka GeoTagu');
@define('PLUGIN_EVENT_GEOTAG_HEADER_HDRTAG_DESC', 'Tento plugin p�id�v� <a href="http://en.wikipedia.org/wiki/Geotag#HTML_pages" target="_blank">geourl meta tagy</a> do HTML hlavi�ky str�nky. Tak umo��uje ostatn�m snadno zjistit zem�pisn� sou�adnice �l�nku nebo blogu.');
@define('PLUGIN_EVENT_GEOTAG_SERVICE_DESC', 'Chcete vytvo�it mapu do pati�ky str�nky pomoc� Google Map nebo pomoc� Openstreetmap?');
@define('PLUGIN_EVENT_GEOTAG_EDITOR_AUTOFILL', 'Automaticky vypl�ovat polohu v editoru');
@define('PLUGIN_EVENT_GEOTAG_EDITOR_AUTOFILL_DESC', 'To se pokus� automaticky zjistit Va�i aktu�ln� polohu p�i psan� p��sp�vku a zji��enou hodnotu p�edvypln� do pol��ka polohy. (Pouze pokud tuto funkci podporuje prohl�e�.)');
@define('PLUGIN_EVENT_GEOTAG_MAP_LINK_BLANK', 'Otev��t odkazy z mapy v nov�m okn�');
@define('PLUGIN_EVENT_GEOTAG_MAP_LINK_BLANK_DESC', 'P�i kliknut� na polohu je otev�en� google mapa. M� se zobrazovat v nov�m okn� prohl�e�e?');
@define('PLUGIN_EVENT_GEOTAG_SHOW_IMAGE', 'Zobrazovat polohu jako mapu');
@define('PLUGIN_EVENT_GEOTAG_SHOW_IMAGE_DESC', 'M�sto zobrazov�n� nicne��kaj�c�ch ��seln�ch zem�pisn�ch sou�adnic m��ete v pati�ce p��sp�vku zobrazit malou mapku.');
@define('PLUGIN_EVENT_GEOTAG_SHOW_IMAGE_HEIGHT', 'V��ka mapy');
@define('PLUGIN_EVENT_GEOTAG_SHOW_IMAGE_HEIGHT_DESC', 'V��ka mapy v pati�ce');
@define('PLUGIN_EVENT_GEOTAG_SHOW_IMAGE_WIDTH', '���ka mapy');
@define('PLUGIN_EVENT_GEOTAG_SHOW_IMAGE_WIDTH_DESC', '���ka mapy v pati�ce');
@define('PLUGIN_EVENT_GEOTAG_SHOW_IMAGE_ZOOM', 'Zoom mapy');
@define('PLUGIN_EVENT_GEOTAG_SHOW_IMAGE_ZOOM_DESC', 'Zoom faktor pro mapu v pati�ce. ��m v�t�� ��slo, t�m podrobn�j�� mapa bude.');
@define('PLUGIN_EVENT_GEOTAG_SHOW_IMAGE_TITLE', 'Zobrazovat polohu p��sp�vku');
@define('PLUGIN_EVENT_GEOTAG_IMAGE_MARKER_SIZE', 'Google: Velikost mapov�ch k��k�');
@define('PLUGIN_EVENT_GEOTAG_IMAGE_MARKER_SIZE_DESC', 'Mapa umo��uje pou��t r�znou velikost zna�kovac�ch k��k�. V z�vislosti na velikosti mapy byste se m�li vybrat velikost, kter� V�m nejv�c vyhovuje.');
@define('PLUGIN_EVENT_GEOTAG_IMAGE_MARKER_SIZE_TINY', 'Mr�av�');
@define('PLUGIN_EVENT_GEOTAG_IMAGE_MARKER_SIZE_SMALL', 'Mal�');
@define('PLUGIN_EVENT_GEOTAG_IMAGE_MARKER_SIZE_MID', 'St�edn�');
@define('PLUGIN_EVENT_GEOTAG_IMAGE_MARKER_SIZE_NORMAL', 'Norm�ln�');
@define('PLUGIN_EVENT_GEOTAG_HDRTAG_DEFAULT_LAT', 'Zem�psin� ���ka blogu');
@define('PLUGIN_EVENT_GEOTAG_HDRTAG_DEFAULT_LAT_DESC', 'Zadejte zem�psinou ���ku blogu. Bude pou�ita u p��sp�vk�, kter� nemaj� p�i�azenou vlastn� polohu, a u p�ehledu p��sp�vk�. Ponechte pr�zdn� pokud nechcete tyto str�nky ozna�ovat sou�adnicemi.');
@define('PLUGIN_EVENT_GEOTAG_HDRTAG_DEFAULT_LONG', 'Zem�pisn� d�lka blogu');
@define('PLUGIN_EVENT_GEOTAG_HDRTAG_DEFAULT_LONG_DESC', 'Zadejte zem�psinou d�lku blogu. Bude pou�ita u p��sp�vk�, kter� nemaj� p�i�azenou vlastn� polohu, a u p�ehledu p��sp�vk�. Ponechte pr�zdn� pokud nechcete tyto str�nky ozna�ovat sou�adnicemi.');
@define('PLUGIN_EVENT_GEOTAG_GEOURL_PINGED', 'Slu�ba GeoURL �sp�n� kontaktov�na pro z�sk�n� nov�ch sou�adnic. Nav�tivte <a href="http://geourl.org/near/?p='.$serendipity['baseURL'].'">Va�e sousedy</a>!');
@define('PLUGIN_GEOTAG_GMAP_TERRAIN', 'Povrch');
@define('PLUGIN_GEOTAG_SERVICE', 'Mapov� slu�ba');
@define('PLUGIN_GEOTAG_SERVICE_DESC', 'Jako mapov� podklad m��ete pou��t bu� mapy Googlu nebo Openstreetmap');
@define('PLUGIN_GEOTAG_GMAP_GEOCODE_GET_CODE', 'va�e aktu�ln� poloha');

// Next lines were translated on 2012/06/22
@define('PLUGIN_EVENT_CLEAR_LOCATION', 'Smazat polohu');

