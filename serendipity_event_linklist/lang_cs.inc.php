<?php

/**
 *  @author Vladim�r Ajgl <vlada@ajgl.cz>
 *  EN-Revision: Revision of lang_en.inc.php
 *  Translated on 2007/11/30
 *  @author Vladimir Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2009/02/15
 *  @author Vladim�r Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2013/04/21
 */

//
//  serendipity_event_linklist.php
//

@define('PLUGIN_LINKLIST_TITLE', 'Link List');
@define('PLUGIN_LINKLIST_DESC', 'Spr�vce odkaz� (link�) - V bo�n�m panelu zobrazuje va�e obl�ben� odkazy.');
@define('PLUGIN_LINKLIST_LINK', 'Odkaz (Link)');
@define('PLUGIN_LINKLIST_LINK_NAME', 'Jm�no');
@define('PLUGIN_LINKLIST_ADMINLINK', 'Odkazy (LinkList)');
@define('PLUGIN_LINKLIST_ORDER', 'Se�a� odkazy podle:');
@define('PLUGIN_LINKLIST_ORDER_DESC', 'Vyber krit�rium, podle kter�ho se maj� �adit odkazy p�i zobrazov�n�.');
@define('PLUGIN_LINKLIST_ORDER_NUM_ORDER', 'Po�ad� zadan� u�ivatelem (tebou)');
@define('PLUGIN_LINKLIST_ORDER_DATE_ACS', 'Datum (Od nejstar��ho po nejnov�j��)');
@define('PLUGIN_LINKLIST_ORDER_DATE_DESC', 'Datum (Od nejnov�j��ho po nejstar��)');
@define('PLUGIN_LINKLIST_ORDER_CATEGORY', 'Kategorie');
@define('PLUGIN_LINKLIST_ORDER_ALPHA', 'Abecedn�');
@define('PLUGIN_LINKLIST_LINKS', 'Spr�va odkaz�');
@define('PLUGIN_LINKLIST_NOLINKS', '��dn� odkazy nejsou zad�ny');
@define('PLUGIN_LINKLIST_CATEGORY', 'Pou��t kategorie');
@define('PLUGIN_LINKLIST_CATEGORYDESC', 'Pou��t kategorie p�i seskupov�n� odkaz�.');
@define('PLUGIN_LINKLIST_ADDLINK', 'P�idat odkaz');
@define('PLUGIN_LINKLIST_LINK_EXAMPLE', 'P��klad spr�vn�ho odkazu: http://www.s9y.org nebo http://www.s9y.org/forums/');
@define('PLUGIN_LINKLIST_EDITLINK', 'Upravit odkaz');
@define('PLUGIN_LINKLIST_LINKDESC', 'Popis odkazu');
@define('PLUGIN_LINKLIST_CATEGORY_NAME', 'Syst�m kategori�:');
@define('PLUGIN_LINKLIST_CATEGORY_NAME_DESC', 'M��ete si vybrat, kter� syst�m kategori� chcete pou��t. Jestli stejn� kategorie, jako u p��sp�vk�, nebo nez�visl� kategorie definovan� v tomto pluginu.');
@define('PLUGIN_LINKLIST_CATEGORY_NAME_CUSTOM', 'Vlastn�');
@define('PLUGIN_LINKLIST_CATEGORY_NAME_DEFAULT', 'Standardn� - z blogu');
@define('PLUGIN_LINKLIST_ADD_CAT', 'P�idat kategorii');
@define('PLUGIN_LINKLIST_CAT_NAME', 'N�zev kategorie');
@define('PLUGIN_LINKLIST_PARENT_CATEGORY', 'Nad�azen� (rodi�ovsk�) kategorie');
@define('PLUGIN_LINKLIST_ADMINCAT', 'Spr�va kategori�');
@define('PLUGIN_LINKLIST_CACHE_NAME', 'Cachovat postrann� sloupec');
@define('PLUGIN_LINKLIST_CACHE_DESC', 'Cachov�n� postrann�ho sloupce zvy�uje rychlost str�nek. Cache je obnovov�na pouze p�i vkl�d�n� odkaz� p�es administrativn� rozhran�. Nen� obnovov�na p�i ru�n�m zad�v�n� pomoc� xml.');
@define('PLUGIN_LINKLIST_ENABLED_NAME', 'Povolit');
@define('PLUGIN_LINKLIST_ENABLED_DESC', 'Povolit tento z�suvn� modul.');
@define('PLUGIN_LINKLIST_DELETE_WARN', 'Pokud sma�ete kategorii, v�echny odkazy v n� obsa�en� budou p�esunuty do ko�enov� kategorie.');

//
//  serendipity_plugin_linklist.php
//

@define('PLUGIN_LINKS_NAME', 'Link List');
@define('PLUGIN_LINKS_BLAHBLAH', 'Spr�vce odkaz� (link�) - V bo�n�m panelu zobrazuje va�e obl�ben� odkazy.');
@define('PLUGIN_LINKS_TITLE', 'Nadpis');
@define('PLUGIN_LINKS_TITLE_BLAHBLAH', 'Nadpis cel�ho panelu odkaz� v postrann�m sloupci');
@define('PLUGIN_LINKS_TOP_LEVEL', 'Text nejvy��� �rovn�');
@define('PLUGIN_LINKS_TOP_LEVEL_BLAHBLAH', 'Zadejte text, kter� se m� zobrazit jako popis hlavn� kategorie stromu odkaz�. Pole m��ete t� nechat pr�zdn�.');
@define('PLUGIN_LINKS_DIRECTXML', 'Vlo�it XML p��mo');
@define('PLUGIN_LINKS_DIRECTXML_BLAHBLAH', 'Odkazy m��ete vlo�it p��mo pomoc� ru�n�ho zad�n� XML struktury. (zad�v�n� p�es administr�torsk� rozhran� pak nebude mo�n�)');
@define('PLUGIN_LINKS_LINKS', 'Odkazy');
@define('PLUGIN_LINKS_LINKS_BLAHBLAH', 'Pou��v� se XML!!! - pro zad�n� adres��e (kategorie) pou�ijte strukturu "<dir name="dirname"> a uzav�ete pomoc� </dir> - jednotliv� odkazy zad�vejte jako "<link name="linkname" link="http://link.com/" />');
@define('PLUGIN_LINKS_OPENALL', 'Text "Otev�i v�echny"');
@define('PLUGIN_LINKS_OPENALL_BLAHBLAH', 'Zadej text, kter� se m� zobrazit u p�ep�na�e "Otev�i v�echny" nad seznamem odkaz�');
@define('PLUGIN_LINKS_OPENALL_DEFAULT', 'Otev�i v�echny');
@define('PLUGIN_LINKS_CLOSEALL', 'Zav�i v�echny');
@define('PLUGIN_LINKS_CLOSEALL_BLAHBLAH', 'Zadej text, kter� se m� zobrazit u p�ep�na�e "Zav�i v�echny" nad seznamem odkaz�');
@define('PLUGIN_LINKS_CLOSEALL_DEFAULT', 'Zav�i v�echny');
@define('PLUGIN_LINKS_SHOW', 'Zobrazit p�ep�na�e "Otev�i v�echny" a "Zav�i v�echny" ');
@define('PLUGIN_LINKS_SHOW_BLAHBLAH', 'Chce� zobrazit p�ep�na�e "Otev�i v�echny" a "Zav�i v�echny" u stromu odkaz�?');
@define('PLUGIN_LINKS_LOCATION', 'Poloha p�ep�na�� "Otev�i/Zav�i v�echny"');
@define('PLUGIN_LINKS_LOCATION_BLAHBLAH', 'Kde se maj� zobrazit p�ep�na�e "Otev�i v�echny" a "Zav�i v�echny"?');
@define('PLUGIN_LINKS_LOCATION_TOP', 'Naho�e');
@define('PLUGIN_LINKS_LOCATION_BOTTOM', 'Dole');
@define('PLUGIN_LINKS_SELECTION', 'Pou��t zv�raz�ov�n� v�b�ru');
@define('PLUGIN_LINKS_SELECTION_BLAHBLAH', 'Pokud je nastaveno na ANO, pr�v� nav�t�ven� odkazy jsou zv�raz�ov�ny.');
@define('PLUGIN_LINKS_COOKIE', 'Pou��t cookies');
@define('PLUGIN_LINKS_COOKIE_BLAHBLAH', 'Pokud je nastaveno na ANO, strom odkaz� pou��v� cookies k tomu, aby si pamatoval sv�j aktu�ln� stav (kter� kategorie jsou otev�en� a kter� zav�en�).');
@define('PLUGIN_LINKS_LINE', 'Vykreslit ��ry');
@define('PLUGIN_LINKS_LINE_BLAHBLAH', 'Pokud nastaveno na ANO, strom odkaz� je vykreslen s ��rami spojuj�c� soused�c� polo�ky a kategorie.');
@define('PLUGIN_LINKS_ICON', 'Pou��t ikony');
@define('PLUGIN_LINKS_ICON_BLAHBLAH', 'Pokud nastaveno na ANO, strom odkaz� je vykreslen s pou�it�m ikon pro odakzy a kategorie.');
@define('PLUGIN_LINKS_STATUS', 'Zobrazovat text ve status ��dku');
@define('PLUGIN_LINKS_STATUS_BLAHBLAH', 'Pokud nastaveno na ANO, zobrazuje ve status ��dku m�sto adresy n�zev odkazu.');
@define('PLUGIN_LINKS_CLOSELEVEL', 'Zav�rat stejnou �rove�');
@define('PLUGIN_LINKS_CLOSELEVEL_BLAHBLAH', 'Pokud nastaveno na ANO, je mo�n� rozkliknout pouze jednu kategorii ve stromu odkaz�. P�ep�na�e "Zav��t/otev��t v�echny" p�i za�krtnut� t�to volby nefunguj�.');
@define('PLUGIN_LINKS_TARGET', 'C�l - Target');
@define('PLUGIN_LINKS_TARGET_BLAHBLAH', 'C�l - Target pro zobrazov�n� odkaz�, mo�n� hodnoty jsou "_blank", "_self", "_top", "_parent" nebo jak�koliv jm�no r�mu');
@define('PLUGIN_LINKS_IMGDIR', 'Obr�zky z adres��e v pluginu');
@define('PLUGIN_LINKS_IMGDIR_BLAHBLAH', 'Pokud je nastaveno na ANO, plugin bude hledat obr�zky pro odkazy/kategorie ve sv�m podadres��i. Pokud je nastaveno na NE, plugin se bude odkazovat do adres��e "/templates/default/img/". Nastaven� volby na NE je nezbytn� pro sd�len� instalace, ale obr�zky mus�te p�esunout do adres��e �ablony ru�n�.');
@define('PLUGIN_LINKLIST_CATEGORY_DEFAULT_OPEN_NAME', 'Strom kategori� otev�en nebo zav�en.');
@define('PLUGIN_LINKLIST_CATEGORY_DEFAULT_OPEN_DESC', 'P�i pou�it� �azen� odkaz� podle "Kategorie", bude strom kategori� p�ednastaven jako otev�en�/zav�en�, pokud se nenajde nastaven� o jeho stavu.');
@define('PLUGIN_LINKLIST_CATEGORY_DEFAULT_OPEN_NAME_CLOSED', 'Zav�en�');
@define('PLUGIN_LINKLIST_CATEGORY_DEFAULT_OPEN_NAME_OPEN', 'Otev�en�');
@define('PLUGIN_LINKLIST_OUTSTYLE_DTREE', 'dtree');
@define('PLUGIN_LINKLIST_OUTSTYLE_CSS', 'CSS List');
@define('PLUGIN_LINKLIST_ORDER_OUTSTYLE_SIMP_CSS', 'Simple CSS');
@define('PLUGIN_LINKS_OUTSTYLE', 'Vyber styl zobrazen� odkazovn�ku (LinkListu)');
@define('PLUGIN_LINKS_OUTSTYLE_BLAHBLAH', 'Vyber styl zobrazen� odkazovn�ku (LinkListu).  "Dtree" zobrazuje strom pomoc� javascriptu. "CSS list" pou�iv� ostylovan� tagy div a jednoduch� javascript, ov�em neumo��uje v�echny volby jako Dtree. "Simple CSS" zobraz� jednoduch� odkazovn�k form�tovan� pouze pomoc� CSS styl�. Pamatujte, �e Dtree nen� pr�choz� pro vyhled�vac� roboty. ');
@define('PLUGIN_LINKS_CALLMARKUP', 'Pou��vat zna�kov�n�?');
@define('PLUGIN_LINKS_CALLMARKUP_BLAHBLAH', 'Zda pou��vat zna�kov�n� na odkazovn�k. Tato volba pou�ije v�echna zna�kov�n�, kter� jsou obecn� pou��v�na na vlo�en� HTML k�d.');
@define('PLUGIN_LINKS_USEDESC', 'Pou��t zadan� popis');
@define('PLUGIN_LINKS_USEDESC_BLAHBLAH', 'Pou��t popis pro titulek odkazu, pokud je p��tomen.');
@define('PLUGIN_LINKS_PREPEND', 'Zadej jak�koliv text. Zobraz� se p�ed seznamem odkaz�.');
@define('PLUGIN_LINKS_APPEND', 'Zadej jak�koliv text. Zobraz� se za seznamem odkaz�.');

