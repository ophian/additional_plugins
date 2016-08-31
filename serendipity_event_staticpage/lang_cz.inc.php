<?php

/**
 *  @author Vladim�r Ajgl <vlada@ajgl.cz>
 *  EN-Revision: Revision of lang_en.inc.php
 *  Translated on 2007/11/30
 *  @author Vladimir Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2009/02/15
 *  @author Vladim�r Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2011/03/09
 *  @author Vladim�r Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2011/06/30
 *  @author Vladim�r Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2013/03/31
 */

//
//  serendipity_event_staticpage.php
//

@define('STATICPAGE_HEADLINE',		'Nadpis');
@define('STATICPAGE_HEADLINE_BLAHBLAH',		'Tento text je uveden� jako nadpis statick� str�nky, zobrazen� stejn� jako nadpisy b�n�ch p��sp�vk�');
@define('STATICPAGE_TITLE',		'Statick� str�nky');
@define('STATICPAGE_TITLE_BLAHBLAH',		'Zobrazuje v blogu statick� str�nky se stejn�m designem jako maj� b�n� p�sp�vky. P�id� nov� menu do adminstr�torsk�ho rozhran�.');
@define('CONTENT_BLAHBLAH',		'zde vepi�te obsah str�nky');
@define('STATICPAGE_PERMALINK',		'St�l� odkaz');
@define('STATICPAGE_PERMALINK_BLAHBLAH',		'Definuje adresu st�l�ho odkazu (permalink), pod kterou je str�nka zobraziteln�. Mus� b�t ve from�tu absolutn� adresy a mus� kon�it .htm nebo .html!');
@define('STATICPAGE_PAGETITLE',		'Zkr�cen� URL adresa (kv�li zp�tn� kompatibilit�, v nov�j��ch verz�ch ignorujte)');
@define('STATICPAGE_ARTICLEFORMAT',		'Form�tovat jako �l�nek?');
@define('STATICPAGE_ARTICLEFORMAT_BLAHBLAH',		'Pokud je nastaveno na ANO, �l�nek je automaticky form�tov�n jako b�n� p��sp�vek (barvy, okraje, apod.) (Standardn�: ANO)');
@define('STATICPAGE_ARTICLEFORMAT_PAGETITLE',		'Nadpis str�nka v m�du "Form�tovat jako �l�nek"');
@define('STATICPAGE_ARTICLEFORMAT_PAGETITLE_BLAHBLAH',		'Pokud pro statickou str�nku pou�ijete stejn� form�t jako pro b�n� p��sp�vky, tento nadpis se zobraz� na m�st�, kde se u norm�ln�ch p��sp�vk� zobrazuje DATUM.');
@define('STATICPAGE_SELECT',		'Upravit nebo vytvo�it statickou str�nku - vyber v menu');
@define('STATICPAGE_PASSWORD_NOTICE',		'Tato str�nka je zaheslov�na. Zadej pros�m spr�vn� heslo:');
@define('STATICPAGE_PARENTPAGES_NAME',		'Rodi�ovsk� str�nka');
@define('STATICPAGE_PARENTPAGE_DESC',		'Vyber nad�azenou - rodi�ovskou str�nku');
@define('STATICPAGE_PARENTPAGE_PARENT',		'Toto je rodi�ovsk� str�nka');
@define('STATICPAGE_AUTHORS_NAME',		'Jm�no autora');
@define('STATICPAGE_AUTHORS_DESC',		'Tento autor je vlastn�kem t�to statick� str�nky');
@define('STATICPAGE_FILENAME_NAME',		'�ablona (Smarty)');
@define('STATICPAGE_FILENAME_DESC',		'Vlo� jm�no souboru �ablony, kter� m� b�t pou�ita k zobrazen� str�nky. Tento soubor m��e b�t um�st�n� bu� v adres��i /plugins/serendipity_event_staticpage nebo v adres��i Va�� �ablony.');
@define('STATICPAGE_SHOWCHILDPAGES_NAME',		'Zobraz d�ti (pod�azen� str�nky)');
@define('STATICPAGE_SHOWCHILDPAGES_DESC',		'Zobraz� seznam odkaz� na v�echny pod�azen� str�nky = d�ti, kter� maj� tuto str�nku nastavenou jako rodi�e.');
@define('STATICPAGE_PRECONTENT_NAME',		'�vod');
@define('STATICPAGE_PRECONTENT_DESC',		'Tento blok se zobraz� p�ed seznamem pod�azen�ch �l�nek.');
@define('STATICPAGE_CANNOTDELETE_MSG',		'Nen� mo�n� vymazat tuto str�nku. V datab�zi byly nalezeny pod�azen� str�nky. Nejd��ve mus�te smazat je.');
@define('STATICPAGE_IS_STARTPAGE',		'Ud�lej z t�to strany hlavn� stranu Serendipity');
@define('STATICPAGE_IS_STARTPAGE_DESC',		'Pokud je nastaveno, tato strana se zobraz� m�sto standardn� �vodn� strany Serendipity. Lze zadat pouze jednu str�nku jako �vodn�! Pokud pak chcete zobrazit p�vodn� �vodn� str�nku, pou�ijte odkaz "index.php?frontpage". Pokud chcete pou��t tuto vlastnost modulu statick� str�nky, mus�te ho v seznamu plugin� p�em�stit p�ed v�echny ostatn� pluginy zobrazuj�c� statick� str�nky (jako hlasov�n� nebo kniha host�).');
@define('STATICPAGE_TOP',		'Hlavn� str�nka blogu');
@define('STATICPAGE_NEXT',		'Dal��');
@define('STATICPAGE_PREV',		'P�edchoz�');
@define('STATICPAGE_LINKNAME',		'Upravit');

@define('STATICPAGE_ARTICLETYPE',		'Typ str�nky');
@define('STATICPAGE_ARTICLETYPE_DESC',		'Vyberte typ t�to statick� str�nky.');

@define('STATICPAGE_CATEGORY_PAGEORDER',		'Po�ad� str�nek');
@define('STATICPAGE_CATEGORY_PAGES',		'�prava str�nek');
@define('STATICPAGE_CATEGORY_PAGETYPES',		'Typy str�nek');
@define('STATICPAGE_CATEGORY_PAGEADD',		'Ostatn� pluginy');

@define('PAGETYPES_SELECT',		'Vyber typ str�nky k �prav�m');
@define('STATICPAGE_ARTICLETYPE_DESCRIPTION',		'N�zev:');
@define('STATICPAGE_ARTICLETYPE_DESCRIPTION_DESC',		'N�zev typu str�nky.');
@define('STATICPAGE_ARTICLETYPE_TEMPLATE',		'�ablona:');
@define('STATICPAGE_ARTICLETYPE_TEMPLATE_DESC',		'Jm�no souboru �ablony. Soubor m��e b�t um�st�n v adres��i pluginy "statick� str�nky" nebo v adres��i Va�� �ablony.');
@define('STATICPAGE_ARTICLETYPE_IMAGE',		'Cesta k obr�zku:');
@define('STATICPAGE_ARTICLETYPE_IMAGE_DESC',		'Zadejte URL adresu obr�zku.');

@define('STATICPAGE_SHOWNAVI',		'Vlo�it navigaci');
@define('STATICPAGE_SHOWNAVI_DESC',		'Zobraz� naviga�n� li�tu s odkazy na dal�� statick� str�nky v t�to statick� str�nce.');
@define('STATICPAGE_SHOWONNAVI',		'Vlo�it postrann� navigaci');
@define('STATICPAGE_SHOWONNAVI_DESC',		'Zobraz� tuto str�nku na seznamu statick�ch str�nek v postrann�m panelu.');

@define('STATICPAGE_SHOWNAVI_DEFAULT',		'Vlo�it navigaci');
@define('STATICPAGE_DEFAULT_DESC',		'Standardn� nastaven� pro nov� str�nky.');
@define('STATICPAGE_SHOWONNAVI_DEFAULT',		'Zobrazit str�nku v postrann� navigaci');
@define('STATICPAGE_SHOWMARKUP_DEFAULT',		'Pou��t zna�kov�n�');
@define('STATICPAGE_SHOWARTICLEFORMAT_DEFAULT',		'Form�tovat jako b�n� �l�nek');
@define('STATICPAGE_SHOWCHILDPAGES_DEFAULT',		'Zobrazit d�ti (pod�azen� str�nky)');

@define('STATICPAGE_PAGEORDER_DESC',		'Tady m��ete zm�nit po�ad� statick�ch str�nek.');
@define('STATICPAGE_PAGEADD_DESC',		'Vyberte pluginy, na kter� chcete zobrazi odkaz v navigaci statick�ch str�nek.');
@define('STATICPAGE_PAGEADD_PLUGINS',		'N�sleduj�c� pluginy mohou b�t vlo�eny do navigace statick�ch str�nek v postrann�m sloupci.');

@define('STATICPAGE_PUBLISHSTATUS',		'Publikovat');
@define('STATICPAGE_PUBLISHSTATUS_DESC',		'Typ ulo�en� str�nky - zve�ejnit/koncept');

@define('STATICPAGE_SHOWTEXTORHEADLINE_NAME',		'Zobrazit v navigaci text "p�edchoz�/dal��" nebo n�zvy p�edchoz� a dal�� str�nky?');
@define('STATICPAGE_SHOWTEXTORHEADLINE_TEXT',		'P�edchoz�/Dal��');
@define('STATICPAGE_SHOWTEXTORHEADLINE_HEADLINE',		'N�zvy str�nek');

@define('STATICPAGE_LANGUAGE',		'Jazyk');
@define('STATICPAGE_LANGUAGE_DESC',		'Vyberte jazyk t�to str�nky');

@define('STATICPAGE_PLUGINS_INSTALLED',		'Plugin je nainstalov�n');
@define('STATICPAGE_PLUGIN_AVAILABLE',		'Plugin je k dispozici, ale nen� nainstalov�n.');
@define('STATICPAGE_PLUGIN_NOTAVAILABLE',		'Plugin nen� k dispozici');

@define('STATICPAGE_SEARCHRESULTS',		'Po�et nalezen�ch statick�ch str�nek - %d:');

@define('LANG_ALL',		'V�echny jazyky');
@define('LANG_EN',		'Angli�tina');
@define('LANG_DE',		'N�m�ina');
@define('LANG_DA',		'D�n�tina');
@define('LANG_ES',		'�pan�l�tina');
@define('LANG_FR',		'Francouz�tina');
@define('LANG_FI',		'Fin�tina');
@define('LANG_CS',		'�e�tina (Win-1250)');
@define('LANG_CZ',		'�e�tina (ISO-8859-2)');
@define('LANG_NL',		'Holand�tina');
@define('LANG_IS',		'Island�tina');
@define('LANG_PT',		'Brazilsk� portugal�tina');
@define('LANG_BG',		'Bulhar�tina');
@define('LANG_NO',		'Nor�tina');
@define('LANG_RO',		'Rumun�tina');
@define('LANG_IT',		'Ital�tina');
@define('LANG_RU',		'Ru�tina');
@define('LANG_FA',		'Per�tina');
@define('LANG_TW',		'Tradi�n� ��n�tina (Big5)');
@define('LANG_TN',		'Tradi�n� ��n�tina (UTF-8)');
@define('LANG_ZH',		'Zjednodu�en� ��n�tina (GB2312)');
@define('LANG_CN',		'Zjednodu�en� ��n�tina (UTF-8)');
@define('LANG_JA',		'Japon�tina');
@define('LANG_KO',		'Korej�tina');

@define('STATICPAGE_STATUS',		'Stav');

//
//  serendipity_plugin_staticpage.php
//

@define('PLUGIN_STATICPAGELIST_NAME',		'Seznam statick�ch str�nek');
@define('PLUGIN_STATICPAGELIST_NAME_DESC',		'Tento plugin zobrazuje nastaviteln� seznam st�l�ch (statick�ch) str�nek.');
@define('PLUGIN_STATICPAGELIST_TITLE',		'Nadpis');
@define('PLUGIN_STATICPAGELIST_TITLE_DESC',		'Nadpis bloku v postrann�m panelu:');
@define('PLUGIN_STATICPAGELIST_TITLE_DEFAULT',		'St�l� str�nky');
@define('PLUGIN_STATICPAGELIST_LIMIT',		'Po�et str�nek k zobrazen�');
@define('PLUGIN_STATICPAGELIST_LIMIT_DESC',		'Zadej maxim�ln� po�et str�nek, kter� se zobraz� najednou. 0 znamen� bez omezen�.');
@define('PLUGIN_STATICPAGELIST_FRONTPAGE_NAME',		'Zobrazit odkaz na hlavn� srt�nku');
@define('PLUGIN_STATICPAGELIST_FRONTPAGE_DESC',		'Zobraz� odkaz na hlavn� str�nku');
@define('PLUGIN_STATICPAGELIST_FRONTPAGE_LINKNAME',		'Hlavn� str�nka');
@define('PLUGIN_LINKS_IMGDIR',		'Adres�� s obr�zky');
@define('PLUGIN_LINKS_IMGDIR_BLAHBLAH',		'Zadej URL adresu adres��e, kde se nach�z� obr�zky zobrazen� ve stromu. V tomto adres��i se mus� nach�zet podadres�� "img".');
@define('PLUGIN_STATICPAGELIST_SHOWICONS_NAME',		'Ikony nebo �ist� text');
@define('PLUGIN_STATICPAGELIST_SHOWICONS_DESC',		'Zobrazit menu jako strom s ikonami nebo jako �ist� text');
@define('PLUGIN_STATICPAGELIST_ICON',		'JS Strom - ikony');
@define('PLUGIN_STATICPAGELIST_TEXT',		'�ist� text');
@define('PLUGIN_STATICPAGELIST_PARENTSONLY',		'Zobrazit pouze rodi�ovsk� str�nky?');
@define('PLUGIN_STATICPAGELIST_PARENTSONLY_DESC',		'Pokud je zaponuto, jsou zobrazeny pouze rodi�ovsk� str�nky. Jinak budou zobrazeny i pod�azen� str�nky.');
@define('PLUGIN_STATICPAGELIST_IMG_NAME',		'Povolit grafiku pro strom');

@define('STATICPAGE_MEDIA_DIRECTORY_MOVE_ENTRIES',		'Zm�n�na URL adresa p�esunut�ho adres��e v %s statick�ch str�nk�ch.');
@define('STATICPAGE_MEDIA_DIRECTORY_MOVE_ENTRY',		'V jin�ch datab�z�ch ne� je MySQL nen� mo�n� iterativn� prohled�v�n� v�ech statick�ch str�nek a nahrazen� n�zv� star�ch adres��� n�zvy nov�ch adres���. Budete muset prov�st tuto operaci ru�n�. St�le m��ete p�esunout star� adres�� zp�t tam, kde byl p�vodn�, pokud se v�m do ru�n�ch zm�n nechce.');

@define('STATICPAGE_QUICKSEARCH_DESC',		'Pokud je povoleno, rychl� vyhled�v�n� prohled� tak� statick� str�nky.');

@define('STATICPAGE_CATEGORYPAGE',		'P��buzn� statick� str�nka');
@define('STATICPAGE_RELATED_CATEGORY',		'P��buzn� kategorie');
@define('STATICPAGE_RELATED_CATEGORY_DESCRIPTION',		'Zobrazte p��sp�vky z t�to kategorie a nebo zobrazte odkazy na n� ve statick� str�nce. Pro �pravu vzhledu seznamu p��sp�vk� upravte �ablonu "plugin_staticpage_related_category.tpl".');

@define('STATICPAGE_ARTICLE_OVERVIEW',		'P�ehled �l�nk�:');
@define('STATICPAGE_NEW_HEADLINES',		'Nejnov�j�� �l�nky:');

@define('STATICPAGE_TEMPLATE',		'�ablona pro pozad�');
@define('STATICPAGE_TEMPLATE_EXTERNAL',		'Jednoduch� �ablona');

@define('STATICPAGE_SECTION_META',		'Metadata');
@define('STATICPAGE_SECTION_BASIC',		'Z�kladn� obsah');
@define('STATICPAGE_SECTION_OPT',		'Volby');
@define('STATICPAGE_SECTION_STRUCT',		'Struktura');

// Next lines were translated on 2011/03/09

@define('STATICPAGE_IS_404_PAGE',		'Nastavit tuto str�nku jako chybovou str�nku 404');
@define('STATICPAGE_IS_404_PAGE_DESC',		'M�sto vytv��en� zvl�tn�ho chybov�ho dokumentu m��ete nastavit tuto str�nku jako chybovou str�nku 404. Webserver mus� toto nastaven� umo��ovat!');

// Next lines were translated on 2011/06/30

@define('PLUGIN_STATICPAGELIST_SMARTIFY',		'Postrann� seznam pomoc� Smarty');
@define('PLUGIN_STATICPAGELIST_SMARTIFY_BLAHBLAH',		'Pou�ijte �ablonu Smarty: "plugin_staticpage_sidebar.tpl" pro zad�n� v�stupu do postrann�ho sloupce (umo��uje zkr�tit d�lku pomoc� funkc� Smarty).');

// Next lines were translated on 2013/03/31
@define('STATICPAGE_SHOWMETA_DEFAULT',		'Vkl�dat vstupn� pole pro zad�n� HTML meta tag�');
@define('STATICPAGES_CUSTOM_STRUCTURE_SHOW',		'Zobrazit mo�nosti struktur�ln�ch pol�');
@define('STATICPAGES_CUSTOM_META_SHOW',		'Zobrazit nepovinn� META pole');
@define('STATICPAGES_CUSTOM_META_TITLE',		'HTML TITLE (nepovinn�)');
@define('STATICPAGES_CUSTOM_META_TITLE_BLAH_BLAH',		'V HTML k�du bude vlo�eno jako <title>v� nadpis</title>');
@define('STATICPAGES_CUSTOM_META_DESC',		'HTML META Description (nepovinn�)');
@define('STATICPAGES_CUSTOM_META_DESC_BLAH_BLAH',		'V HTML k�du bude vlo�eno jako <meta name="description" content="Tady bude v� html meta popis str�nky">');
@define('STATICPAGES_CUSTOM_META_KEYS',		'HTML META Keywords (nepovinn�)');
@define('STATICPAGES_CUSTOM_META_KEYS_BLAH_BLAH',		'V HTML k�du bude vlo�eno jako <meta name="keywords" content="va�e html meta kl��ov� slova">' );
@define('PLUGIN_STATICPAGE_PREVIEW',		'N�hled statick� str�nky byl otev�en v nov�m pop-up okn�. Pokud ho nevid�te, klikn�te na n�sleduj�c� odkaz: %s');
@define('STATICPAGE_SHOW_BREADCRUMB_DEFAULT',		'Zobrazit breadcrumb');
@define('STATICPAGE_SHOW_BREADCRUMB',		'Zobrazit naviga�n� kol��ek (bradcrumb)');
@define('STATICPAGE_SHOW_BREADCRUMB_DESC',		'Na t�to str�nce zobraz� kol��kovou navigaci, tzv. breadcrumb.');