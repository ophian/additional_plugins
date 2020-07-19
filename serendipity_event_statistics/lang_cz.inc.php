<?php

/**
 *  @version 1381.1
 *  @file lang_cz.inc.php 1381.1 2009-02-14 16:07:47 VladaAjgl
 *  @author Vladim�r Ajgl <vlada@ajgl.cz>
 *  EN-Revision: Revision of lang_en.inc.php
 *  Translated on 2007/11/23
 *  @author Vladimir Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2009/02/14
 */

@define('PLUGIN_EVENT_STATISTICS_NAME', 'Statistiky');
@define('PLUGIN_EVENT_STATISTICS_DESC', 'Zobrazen� statistik z�znam�');
@define('PLUGIN_EVENT_STATISTICS_OUT_STATISTICS', 'Statistiky');
@define('PLUGIN_EVENT_STATISTICS_OUT_FIRST_ENTRY', 'Prvn� z�znam');
@define('PLUGIN_EVENT_STATISTICS_OUT_LAST_ENTRY', 'Posledn� z�znam');
@define('PLUGIN_EVENT_STATISTICS_OUT_TOTAL_ENTRIES', 'Celkem z�znam�');
@define('PLUGIN_EVENT_STATISTICS_OUT_ENTRIES', 'z�znam�');
@define('PLUGIN_EVENT_STATISTICS_OUT_TOTAL_PUBLIC', ' ... publikovan�ch');
@define('PLUGIN_EVENT_STATISTICS_OUT_TOTAL_DRAFTS', ' ... koncept�');
@define('PLUGIN_EVENT_STATISTICS_OUT_PER_AUTHOR', 'Z�znamy podle u�ivatel�');
@define('PLUGIN_EVENT_STATISTICS_OUT_CATEGORIES', 'Kategorie');
@define('PLUGIN_EVENT_STATISTICS_OUT_CATEGORIES2', 'kategori�');
@define('PLUGIN_EVENT_STATISTICS_OUT_DISTRIBUTION_CATEGORIES', 'Rozd�len� z�znam�');
@define('PLUGIN_EVENT_STATISTICS_OUT_DISTRIBUTION_CATEGORIES2', 'z�znam�');
@define('PLUGIN_EVENT_STATISTICS_OUT_UPLOADED_IMAGES', 'Nahran�ch obr�zk�');
@define('PLUGIN_EVENT_STATISTICS_OUT_UPLOADED_IMAGES2', 'obr�zk�');
@define('PLUGIN_EVENT_STATISTICS_OUT_DISTRIBUTION_IMAGES', 'Rozd�len� obr�zk� podle typ�');
@define('PLUGIN_EVENT_STATISTICS_OUT_DISTRIBUTION_IMAGES2', 'soubor�');
@define('PLUGIN_EVENT_STATISTICS_OUT_COMMENTS', 'P�ijat� koment��e');
@define('PLUGIN_EVENT_STATISTICS_OUT_COMMENTS2', 'koment���');
@define('PLUGIN_EVENT_STATISTICS_OUT_COMMENTS3', 'Nej�ast�ji komentovan� z�znamy');
@define('PLUGIN_EVENT_STATISTICS_OUT_TOPCOMMENTS', 'Nej�ast�ji komentuj�c� �ten��i');
@define('PLUGIN_EVENT_STATISTICS_OUT_LINK', 'www');
@define('PLUGIN_EVENT_STATISTICS_OUT_SUBSCRIBERS', 'Odb�ratel� (RSS kan�lu)');
@define('PLUGIN_EVENT_STATISTICS_OUT_SUBSCRIBERS2', 'odb�ratel�');
@define('PLUGIN_EVENT_STATISTICS_OUT_TOPSUBSCRIBERS', 'Nej�ast�ji odeb�ran� z�znamy');
@define('PLUGIN_EVENT_STATISTICS_OUT_TOPSUBSCRIBERS2', 'odb�ratel�');
@define('PLUGIN_EVENT_STATISTICS_OUT_TRACKBACKS', 'P�ijat� odezvy');
@define('PLUGIN_EVENT_STATISTICS_OUT_TRACKBACKS2', 'odezev');
@define('PLUGIN_EVENT_STATISTICS_OUT_TOPTRACKBACK', 'Nej�ast�ji sledovan� z�znamy');
@define('PLUGIN_EVENT_STATISTICS_OUT_TOPTRACKBACK2', 'odezev');
@define('PLUGIN_EVENT_STATISTICS_OUT_TOPTRACKBACKS3', 'Nej�ast�j�� odezvy �ten���');
@define('PLUGIN_EVENT_STATISTICS_OUT_COMMENTS_PER_ARTICLE', 'po�et koment��� na z�znam');
@define('PLUGIN_EVENT_STATISTICS_OUT_TRACKBACKS_PER_ARTICLE', 'po�et odezev na z�znam');
@define('PLUGIN_EVENT_STATISTICS_OUT_ARTICLES_PER_DAY', 'po�et z�znam� za den');
@define('PLUGIN_EVENT_STATISTICS_OUT_ARTICLES_PER_WEEK', 'po�et z�znam� za t�den');
@define('PLUGIN_EVENT_STATISTICS_OUT_ARTICLES_PER_MONTH', 'po�et z�znam� za m�s�c');
@define('PLUGIN_EVENT_STATISTICS_OUT_COMMENTS_PER_ARTICLE2', 'koment���/z�znamy');
@define('PLUGIN_EVENT_STATISTICS_OUT_TRACKBACKS_PER_ARTICLE2', 'odezev/z�znam');
@define('PLUGIN_EVENT_STATISTICS_OUT_ARTICLES_PER_DAY2', 'z�znam�/den');
@define('PLUGIN_EVENT_STATISTICS_OUT_ARTICLES_PER_WEEK2', 'z�znam�/t�den');
@define('PLUGIN_EVENT_STATISTICS_OUT_ARTICLES_PER_MONTH2', 'z�znam�/m�s�c');
@define('PLUGIN_EVENT_STATISTICS_OUT_CHARS', 'Celkov� po�et znak�');
@define('PLUGIN_EVENT_STATISTICS_OUT_CHARS2', 'znak�');
@define('PLUGIN_EVENT_STATISTICS_OUT_CHARS_PER_ARTICLE', 'Znak� na z�znam');
@define('PLUGIN_EVENT_STATISTICS_OUT_CHARS_PER_ARTICLE2', 'znak�/z�znam');
@define('PLUGIN_EVENT_STATISTICS_OUT_LONGEST_ARTICLES', '%s nejdel��ch z�znam�');
@define('PLUGIN_EVENT_STATISTICS_MAX_ITEMS', 'Po�et prvk�');
@define('PLUGIN_EVENT_STATISTICS_MAX_ITEMS_DESC', 'Kolik prvk� vz�t pro statistick� vyhodnocen�? (Default: 20)');

//Language constants for the Extended Visitors feature
@define('PLUGIN_EVENT_STATISTICS_EXT_ADD', 'Roz���en� statistiky pro n�vt�vn�ky');
@define('PLUGIN_EVENT_STATISTICS_EXT_ADD_DESC', 'P�idat roz���en� statistiky pro n�v�t�vn�ky str�nek? (Standardn�: NE)');
@define('PLUGIN_EVENT_STATISTICS_EXT_OPT1', 'NE!');
@define('PLUGIN_EVENT_STATISTICS_EXT_OPT2', 'ANO, na konec str�nky');
@define('PLUGIN_EVENT_STATISTICS_EXT_OPT3', 'ANO, na za��tek str�nky');
@define('PLUGIN_EVENT_STATISTICS_EXT_ALL', 'Uk�zat v�echno?');
@define('PLUGIN_EVENT_STATISTICS_EXT_ALL_DESC', 'Zobrazit v�echny statistiky, i o u�ivatel�ch? (Standardn�: NE)');
@define('PLUGIN_EVENT_STATISTICS_EXT_ALL1', 'NE, krom� po��tadel v�echno schovej.');
@define('PLUGIN_EVENT_STATISTICS_EXT_ALL2', 'ANO, uka� v�echny statistiky!');
@define('PLUGIN_EVENT_STATISTICS_EXT_VISITORS', 'Jednotliv� po��tadla');
@define('PLUGIN_EVENT_STATISTICS_EXT_VISTODAY', 'N�v�t�vn�k� dnes');
@define('PLUGIN_EVENT_STATISTICS_EXT_VISTOTAL', 'N�v�t�vn�k� celkem');
@define('PLUGIN_EVENT_STATISTICS_EXT_HITSTODAY', 'Zobrazen� dnes');
@define('PLUGIN_EVENT_STATISTICS_EXT_HITSTOTAL', 'Zobrazen� celkem');
@define('PLUGIN_EVENT_STATISTICS_EXT_VISSINCE', 'Ukl�d�n� statistik od');
@define('PLUGIN_EVENT_STATISTICS_EXT_COUNTDESC', 'Zobrazen� se mohou vy�plhat do velk�ch hodnot, proto�e jsou zv��ena p�i KA�D�M na�ten� str�nky. Nen� to ��slo po�tu lid�, kte�� str�nku prohl�eli. Je to ukazatel po�tu zobrazen� str�nky.');
@define('PLUGIN_EVENT_STATISTICS_EXT_VISLATEST', 'Posledn� n�v�t�vn�ci');
@define('PLUGIN_EVENT_STATISTICS_EXT_TOPREFS', 'Top odkazova�e');
@define('PLUGIN_EVENT_STATISTICS_EXT_TOPREFS_NONE', '��dn� odkazy je�t� nebyly zaznamen�ny.');
@define('PLUGIN_EVENT_STATISTICS_EXT_DAYGRAPH', 'N�v�t�vy podle dn�');
@define('PLUGIN_EVENT_STATISTICS_EXT_MONTHGRAPH', 'N�v�t�vy podle m�s�c�');
@define('PLUGIN_EVENT_STATISTICS_OUT_EXT_STATISTICS', 'Roz���en� statistika o u�ivatel�ch');
@define('PLUGIN_EVENT_STATISTICS_BANNED_HOSTS1', 'Zapnout, nepo��tej roboty');
@define('PLUGIN_EVENT_STATISTICS_BANNED_HOSTS2', 'Vypnout, zapo��tej i roboty');
@define('PLUGIN_EVENT_STATISTICS_BANNED_HOSTS', 'Ochrana proti vyhled�vac�m robot�m');
@define('PLUGIN_EVENT_STATISTICS_BANNED_HOSTS_DESC', 'Nastav na \'Zapnout\' pokud do statistik nechce� zapo��t�vat vyhled�vac� roboty. nastav na \'Vypnout\' a roboti budou zapo��t�ni. V sou�asn� dob� filtruje 290 zn�m�ch robot�.');

@define('PLUGIN_EVENT_STATISTICS_SHOW_LASTENTRY', 'Zobraz datum posledn�ho p��sp�vku');
@define('PLUGIN_EVENT_STATISTICS_SHOW_ENTRYCOUNT', 'Zobraz po�et p��sp�vk�');
@define('PLUGIN_EVENT_STATISTICS_SHOW_COMMENTCOUNT', 'Zobraz po�et koment���');
@define('PLUGIN_EVENT_STATISTICS_SHOW_MONTHVISITORS', 'Zobraz n�v�t�vn�ky v tomto m�s�ci');
@define('PLUGIN_EVENT_STATISTICS_SHOW_DAYVISITORS', 'Zobraz n�v�t�vn�ky dnes');
@define('PLUGIN_EVENT_STATISTICS_SHOW_WEEKVISITORS', 'Zobraz n�v�t�vn�ky tento t�den');
@define('PLUGIN_EVENT_STATISTICS_SHOW_CACHETIMEOUT', 'Cache timeout');
@define('PLUGIN_EVENT_STATISTICS_SHOW_CACHETIMEOUT_DESC', 'Jak dlouho maj� b�t statistiky zobrazeny p�ed znovuna�ten�m? Nastaven� t�to hodnoty na vysok� po�et minut zv�t�� v�kon, ale pokud bude hodnota p��li� vysok�, mo�n� nebude zobrazovat aktu�ln� data.');
@define('PLUGIN_EVENT_STATISTICS_TEXT', 'Form�tov�n� text');
@define('PLUGIN_EVENT_STATISTICS_TEXT_DESC', 'Pou�ij symbol %s pro vlo�en� ��sla/textu');
@define('PLUGIN_EVENT_STATISTICS_TEXT_LASTENTRY', 'Posledn� p��sp�vek: %s');
@define('PLUGIN_EVENT_STATISTICS_TEXT_ENTRYCOUNT', '%s napsan�ch p��sp�vk�');
@define('PLUGIN_EVENT_STATISTICS_TEXT_COMMENTCOUNT', '%s koment��� bylo ud�leno');
@define('PLUGIN_EVENT_STATISTICS_TEXT_MONTHVISITORS', '%s n�v�t�vn�k(�) tento m�s�c');
@define('PLUGIN_EVENT_STATISTICS_TEXT_DAYVISITORS', '%s n�v�t�vn�k(�) dnes');
@define('PLUGIN_EVENT_STATISTICS_TEXT_WEEKVISITORS', '%s n�v�t�vn�k(�) tento t�den');

@define('PLUGIN_EVENT_STATISTICS_SHOW_CURRENTVISITORS', 'Uka� po�et online n�v�t�vn�k� (po��t�no b�hem posledn�ch 15 minut)');
@define('PLUGIN_EVENT_STATISTICS_TEXT_CURRENTVISITORS', '%s n�v�t�vn�k(�) online');

