<?php

/**
 *  @author Vladim�r Ajgl <vlada@ajgl.cz>
 *  @translated 2009/05/24
 */

@define('PLUGIN_EVENT_TODOLIST_TITLE', 'Seznam �kol� / ToDo list / projektov� ��zen�');
@define('PLUGIN_EVENT_TODOLIST_DESC', 'Spr�va seznamu projekt�/�kol� a jejich spln�n� v procentech');
@define('PLUGIN_EVENT_TODOLIST_PROJECT', 'Projekt');
@define('PLUGIN_EVENT_TODOLIST_PROJECT_NAME', 'N�zev');
@define('PLUGIN_EVENT_TODOLIST_HIDDEN', 'Skryt�');
@define('PLUGIN_EVENT_TODOLIST_PERCENTDONE', '% hotovo');
@define('PLUGIN_EVENT_TODOLIST_BLOGENTRY', 'P��sp�vek blogu');
@define('PLUGIN_EVENT_TODOLIST_ADMINPROJECT', 'Spr�va projekt�');
@define('PLUGIN_EVENT_TODOLIST_ORDER', '�azen� podle:');
@define('PLUGIN_EVENT_TODOLIST_ORDER_DESC', 'Vyberte, jak �adit v�pis projekt�.');
@define('PLUGIN_EVENT_TODOLIST_ORDER_NUM_ORDER', 'Vlastn� �azen�');
@define('PLUGIN_EVENT_TODOLIST_ORDER_DATE_ACS', 'Datum (od nejstar��ch po nejnov�j��)');
@define('PLUGIN_EVENT_TODOLIST_ORDER_DATE_DESC', 'Datum (od nejnov�j��ch po nejstar��)');
@define('PLUGIN_EVENT_TODOLIST_ORDER_PROGRESS_ASC', 'V�voj (od nejm�n� hotov�ch, po kompletn�)');
@define('PLUGIN_EVENT_TODOLIST_ORDER_PROGRESS_DESC', 'V�voj (od kompletn�ch po nejm�n� hotov�)');
@define('PLUGIN_EVENT_TODOLIST_ORDER_CATEGORY', 'Podle kategori�');
@define('PLUGIN_EVENT_TODOLIST_ORDER_JSCATEGORY', 'Podle kategori�, pou��t Javascript');
@define('PLUGIN_EVENT_TODOLIST_ORDER_ALPHA', 'Abecedn�');
@define('PLUGIN_EVENT_TODOLIST_PROJECTS', 'Spr�va projekt�');
@define('PLUGIN_EVENT_TODOLIST_NOPROJECTS', '��dn� projekty v seznamu');
@define('PLUGIN_EVENT_TODOLIST_TITLEDESC','Nadpis postrann�ho bloku v blogu.');
@define('PLUGIN_EVENT_TODOLIST_COLOR1', 'Barva vnit�ku');
@define('PLUGIN_EVENT_TODOLIST_COLOR2', 'Barva vn�j�ku');
@define('PLUGIN_EVENT_TODOLIST_COLORCONFIG', 'V�choz� barva ukazatele v�voje');
@define('PLUGIN_EVENT_TODOLIST_COLORCONFIGDESC', 'Vyberte v�choz� barvu pro ukazatel stupn� v�voje projektu. Barvy m��ete p�id�vat nebo m�nit na str�nce "Spr�va barev". Nastaven� se projev� pouze pokud m�te instalovanou knihovnu PHP GD.');
@define('PLUGIN_EVENT_TODOLIST_BACKGROUNDCOLOR', 'Barva pozad� ukazatele v�voje');
@define('PLUGIN_EVENT_TODOLIST_BACKGROUNDCOLORDESC', 'Zadejte 6-ti cifernou hexadecim�ln� hodnotu. Nap� FFFFFF je b�l�. Nastaven� se projev� pouze pokud m�te nainstalovanou knihovnu PHP GD.');
@define('PLUGIN_EVENT_TODOLIST_WHITETEXTBORDER', 'B�l� obrys p�sma');
@define('PLUGIN_EVENT_TODOLIST_WHITETEXTBORDERDESC', 'Pokud pou��v�te tmav� pozad� a text se na nich ztr�c�, mo�n� zlep��te �itelnost nastaven�m b�l�ho okraje p�sma.');
@define('PLUGIN_EVENT_TODOLIST_OUTSIDETEXT', 'Text mimo ukazatel v�voje.');
@define('PLUGIN_EVENT_TODOLIST_OUTSIDETEXTDESC', 'Tato volba nastavuje v�pis v�voje projektu v procentech vpravo od ukazatele v�voje, m�sto v�choz�ho prost�edku ukazatele.');
@define('PLUGIN_EVENT_TODOLIST_BARLENGTH', 'D�lka ukazatele v�voje');
@define('PLUGIN_EVENT_TODOLIST_BARLENGTHDESC', 'D�lka v pixelech. Nastaven� se pou��v� na ukazatele vyjma �azen� podle kategori�. Toto nastaven� vy�aduje nainstalovanou knihovnu PHP GD.');
@define('PLUGIN_EVENT_TODOLIST_BARHEIGHT', 'V��ka ukazatele v�voje');
@define('PLUGIN_EVENT_TODOLIST_BARHEIGHTDESC', 'V��ka v pixelech. Toto nastaven� vy�aduje nainstalovanou knihovnu PHP GD.');
@define('PLUGIN_EVENT_TODOLIST_FONTSIZE', 'Velikost fontu p�sma');
@define('PLUGIN_EVENT_TODOLIST_FONTSIZEDESC', 'Velikost v pixelech. Toto nastaven� vy�aduje nainstalovanou knihovnu PHP GD.');
@define('PLUGIN_EVENT_TODOLIST_FONT', 'Font');
@define('PLUGIN_EVENT_TODOLIST_FONTDESC', 'Zadejte n�zev fontu pou�it�ho pro text v ukazateli v�voje. Do adres��e '.dirname(__FILE__).'/fonts/ m��ete p�idat dal�� vlastn� fonty. Musej� b�t typu TrueType. Toto nastaven� vy�aduje nainstalovanou knihovnu PHP GD.');
@define('PLUGIN_EVENT_TODOLIST_CATBARLENGTH', 'D�lka ukazatele v�voje (pro �azen� podle kategori�)');
@define('PLUGIN_EVENT_TODOLIST_CATBARLENGTHDESC', 'D�lka ukazatele v�voje pro p��pad, kdy jsou projekty �azen� podle kategori�. Pravd�podobn� budete cht�t v tomto p��pad� krat�� ukazatel, proto�e n�jak� m�sto sebere zobrazen� kategori�. Toto nastaven� vy�aduje nainstalovanou knihovnu PHP GD.');
@define('PLUGIN_EVENT_TODOLIST_CACHEIMAGE', 'Cachovat vygenerovanou grafiku');
@define('PLUGIN_EVENT_TODOLIST_CACHEIMAGEDESC', 'Cachovat kopie v�ech vytvo�en�ch ukazatel� v�voje. P��zniv� ovliv�uje dobu na��t�n� str�nky a sni�uje z�t� serveru. Toto nastaven� vy�aduje nainstalovanou knihovnu PHP GD.');
@define('PLUGIN_EVENT_TODOLIST_NUMENTRIES', 'Po�et zobrazen�ch p��sp�vk� blogu');
@define('PLUGIN_EVENT_TODOLIST_NUMENTRIESDESC', 'Zobrazit tento po�et nejnov�j��ch p��sp�vk� p�i v�b�ru p��sp�vku blogu z ukazatele v�voje.');
@define('PLUGIN_EVENT_TODOLIST_CATEGORY', 'Pou��vat kategorie');
@define('PLUGIN_EVENT_TODOLIST_CATEGORYDESC','Pou��vat kategorie k �azen� a t��d�n� projekt�.');
@define('PLUGIN_EVENT_TODOLIST_ADDPROJECT','P�idat projekt');
@define('PLUGIN_EVENT_TODOLIST_EDITPROJECT','Upravit projekt');
@define('PLUGIN_EVENT_TODOLIST_PERCENTAGECOMPLETE','Stupe� v�voje projektu v procentech');
@define('PLUGIN_EVENT_TODOLIST_PROJECTDESC','Popis projektu');
@define('PLUGIN_EVENT_TODOLIST_DEFAULT_NOTE','Pamatujte, �e toto je plugin ud�lost� a k tomu, aby se jeho v�stup objevil v postrann�m sloupci mus�te pou��t plugin Event Output Wrapper nebo jin� postran� plugin, kter� dok�e zobrazit jeho obsah.');
@define('PLUGIN_EVENT_TODOLIST_CATEGORY_NAME','Pou�it� syst�m kategori�:');
@define('PLUGIN_EVENT_TODOLIST_CATEGORY_NAME_DESC','M��ete si vybrat, jestli chcete pou��t stejn� syst�m kategori�, jak� maj� p��sp�vky blogu, nebo vlastn� odd�len� syst�m kategori�.');
@define('PLUGIN_EVENT_TODOLIST_CATEGORY_NAME_CUSTOM','Vlastn�');
@define('PLUGIN_EVENT_TODOLIST_CATEGORY_NAME_DEFAULT','V�choz� (z blogu)');
@define('PLUGIN_EVENT_TODOLIST_CATDB_WARNING','Nastavili jste pou�it� vlastn�ho syst�mu kategori�, ale datab�zov� tabulka s kategoriemi je�t� neexistuje. Klikn�te sem a tabulka bude vytvo�ena.');
@define('PLUGIN_EVENT_TODOLIST_ADD_CAT','Spr�va kategori�');
@define('PLUGIN_EVENT_TODOLIST_ADD_COLOR','P�idat barvu');
@define('PLUGIN_EVENT_TODOLIST_MANAGE_COLORS','Spr�va barev');
@define('PLUGIN_EVENT_TODOLIST_CAT_NAME','N�zev kategorie');
@define('PLUGIN_EVENT_TODOLIST_PARENT_CATEGORY','Rodi� = nad�azen� kategorie');
@define('PLUGIN_EVENT_TODOLIST_ADMINCAT','Spr�va kategori�');
@define('PLUGIN_EVENT_TODOLIST_CACHE_NAME','Cachovat postrann� sloupec');
@define('PLUGIN_EVENT_TODOLIST_CACHE_DESC','Cachov�n� postrann�ho sloupce zvy�uje rychlost na��t�n� blogu.');
@define('PLUGIN_EVENT_TODOLIST_NOGDLIB', 'Vypad� to, �e nem�te nainstalovanou knihovnu PHP GD. Statick� obr�zky v�voje jsou p�edp�ipraven� po 5%, tak�e v�sledky spln�n� projektu budou zaokrouhleny na nejbli���ch 5%.');
@define('PLUGIN_EVENT_TODOLIST_ADDCOLOR_NAME', 'N�zev barvy (pou�it� v rozbalovac�ch nab�dk�ch pro v�b�r barvy)');
@define('PLUGIN_EVENT_TODOLIST_ADDCOLOR_COLOR1', 'Barva vnit�ku ukazatele v�voje (hexadecim�ln� hodnota jako ap�. ff3333). Pro vnit�ek ukazatele doporu�ujeme sv�tlej�� barvy.');
@define('PLUGIN_EVENT_TODOLIST_ADDCOLOR_COLOR2', 'Barva vn�j�ku ukazatele v�voje  (hexadecim�ln� hodnota jako ap�. ff3333)');
@define('PLUGIN_EVENT_TODOLIST_COLOR', 'Barva');
@define('PLUGIN_EVENT_TODOLIST_SAMPLE', 'Uk�zka');
@define('PLUGIN_EVENT_TODOLIST_COLORWHEEL', 'Barevn� kolo');
@define('PLUGIN_EVENT_TODOLIST_COLORWHEEL_INSTRUCTIONS', 'Pohybujte se s my�� nad barevn�m kolem nebo �tvercem sytosti pro zobrazen� n�hledu barvy. Kliknut�m vyberete barvu. Kop�rujte (Ctrl-C) a vlo�te (Ctrl-V) �estim�stn� k�d barvy do pol��ka pro barvu.');

