<?php # 

/**
 *  @version 
 *  @author Norbert Mocsnik <norbert@mocsnik.hu>
 *  EN-Revision: 1.15
 */

//
//  serendipity_event_freetag.php
//
@define('PLUGIN_EVENT_FREETAG_TITLE', 'Bejegyz�sek c�mk�z�se');
@define('PLUGIN_EVENT_FREETAG_DESC', 'C�mk�k megad�s�t teszi lehet�v� tetsz�leges kombin�ci�ban');
@define('PLUGIN_EVENT_FREETAG_ENTERDESC', 'Adj meg tetsz�leges sz�m� c�mk�t, vessz�vel (,) elv�lasztva');
@define('PLUGIN_EVENT_FREETAG_LIST', 'C�mk�k: %s');
@define('PLUGIN_EVENT_FREETAG_USING', 'Bejegyz�sek %s c�mk�vel');
@define('PLUGIN_EVENT_FREETAG_SUBTAG', '%s c�mke kapcsol�d� c�mk�i');
@define('PLUGIN_EVENT_FREETAG_NO_RELATED','Nincsenek kapcsol�d� c�mk�k.');
@define('PLUGIN_EVENT_FREETAG_ALLTAGS', '�sszes c�mke');
@define('PLUGIN_EVENT_FREETAG_MANAGETAGS', 'C�mk�k kezel�se');
@define('PLUGIN_EVENT_FREETAG_MANAGE_ALL', 'Minden c�mke kezel�se');
@define('PLUGIN_EVENT_FREETAG_MANAGE_LEAF', 'Egyedi c�mk�k kezel�se');
@define('PLUGIN_EVENT_FREETAG_MANAGE_UNTAGGED', 'Bejegyz�sek c�mke n�lk�l');
@define('PLUGIN_EVENT_FREETAG_MANAGE_LEAFTAGGED', 'Egyedi c�mk�s bejegyz�sek');
@define('PLUGIN_EVENT_FREETAG_MANAGE_UNTAGGED_NONE', 'Nincsenek c�mk�zetlen bejegyz�sek.');
@define('PLUGIN_EVENT_FREETAG_MANAGE_LIST_TAG', 'C�mke');
@define('PLUGIN_EVENT_FREETAG_MANAGE_LIST_WEIGHT', 'S�ly');
@define('PLUGIN_EVENT_FREETAG_MANAGE_LIST_ACTIONS', 'M�velet');
@define('PLUGIN_EVENT_FREETAG_MANAGE_ACTION_RENAME', '�tnevez�s');
@define('PLUGIN_EVENT_FREETAG_MANAGE_ACTION_SPLIT', 'Feloszt�s');
@define('PLUGIN_EVENT_FREETAG_MANAGE_ACTION_DELETE', 'T�rl�s');
@define('PLUGIN_EVENT_FREETAG_MANAGE_CONFIRM_DELETE', 'T�r�lni k�v�nod a k�vetkez� c�mk�t: %s?');
@define('PLUGIN_EVENT_FREETAG_MANAGE_INFO_SPLIT', 'use a comma to seperate tags:');
@define('PLUGIN_EVENT_FREETAG_SHOW_TAGCLOUD', 'C�mke felh� mutat�sa a kapcsol�d� c�mk�kkel?');
@define('PLUGIN_EVENT_FREETAG_SEND_HTTP_HEADER', 'X-FreeTag-HTTP fejl�cek k�ld�se');
//
//  serendipity_plugin_freetag.php
//
@define('PLUGIN_FREETAG_NAME', 'C�mk�zett bejegyz�sek list�z�sa');
@define('PLUGIN_FREETAG_BLAHBLAH', 'Kilist�zza a megl�v� c�mk�ket');
@define('PLUGIN_FREETAG_NEWLINE', 'Soremel�s minden c�mke ut�n?');
@define('PLUGIN_FREETAG_XML', 'XML-ikonok megjelen�t�se?');
@define('PLUGIN_FREETAG_SCALE','C�mke bet�m�ret ny�jt�s/zsugor�t�s n�pszer�s�g alapj�n (a Technorati-hoz �s a flickr-hez hasonl�an)?');
@define('PLUGIN_FREETAG_UPGRADE1_2','%d db c�mke friss�t�se a %d. bejegyz�shez: ');
@define('PLUGIN_FREETAG_MAX_TAGS', 'Mennyi c�mk�t mutassunk?');
@define('PLUGIN_FREETAG_TRESHOLD_TAG_COUNT', 'Mennyi el�fordul�s felett jelenjenek meg a c�mk�k?');

@define('PLUGIN_EVENT_FREETAG_TAGCLOUD_MIN', 'Minimum bet�m�ret% a c�mkefelh�ben');
@define('PLUGIN_EVENT_FREETAG_TAGCLOUD_MAX', 'Maximum bet�m�ret% a c�mkefelh�ben');

@define('PLUGIN_FREETAG_META_KEYWORDS', 'HTML forr�sba �gyazand� meta kulcsszavak sz�ma (0: letilt�s)');

@define('PLUGIN_EVENT_FREETAG_RELATED_ENTRIES', 'Kapcsol�d� bejegyz�sek c�mk�k alapj�n:');
@define('PLUGIN_EVENT_FREETAG_SHOW_RELATED','Mutassuk a c�mke alapj�n kapcsol�d� bejegyz�seket?');
@define('PLUGIN_EVENT_FREETAG_SHOW_RELATED_COUNT','Mennyi kapcsol�d� bejegyz�st mutassunk?');
@define('PLUGIN_EVENT_FREETAG_EMBED_FOOTER', 'C�mk�k mutat�sa a l�bl�cben?');
@define('PLUGIN_EVENT_FREETAG_EMBED_FOOTER_DESC', 'Ha enged�lyezett, az egyes bejegyz�shez rendelt c�mk�k a l�bl�cben jelennek meg. Kikapcsolt �llapotban a c�mk�k a bejegyz�s R�szletesebb T�rzs�ben jelennek meg.');
@define('PLUGIN_EVENT_FREETAG_LOWERCASE_TAGS', 'Kisbet�s c�mk�k haszn�lata');

@define('PLUGIN_EVENT_FREETAG_RELATED_TAGS', 'Kapcsol�d� c�mk�k');
@define('PLUGIN_EVENT_FREETAG_TAGLINK', 'C�mkelink');
@define('PLUGIN_EVENT_FREETAG_CAT2TAG', 'L�trehozzuk a c�mk�ket minden hozz�rendelt kateg�ria alapj�n?');
@define('PLUGIN_EVENT_FREETAG_CAT2TAG_DESC', 'Bekapcsolt �llapot�ban minden kateg�ria c�mke form�j�ban is hozz�rendel�dik a bejegyz�shez. Az �sszes megl�v� bejegyz�s konvert�l�s�t az Adminisztr�ci�s K�szlet C�mk�k kezel�se men�pontj�ban lehet megtenni.');
@define('PLUGIN_EVENT_FREETAG_GLOBALLINKS', 'Megl�v� bejegyz�sek minden hozz�rendelt kateg�ri�in�k konvert�l�sa c�mk�kk�');
@define('PLUGIN_EVENT_FREETAG_GLOBALCAT2TAG_ENTRY', '#%d (%s) bejegyz�s konvert�lt kateg�ri�i: %s.');
@define('PLUGIN_EVENT_FREETAG_GLOBALCAT2TAG', 'Minden kateg�ri�t c�mk�kk� konvert�ltunk.');

@define('PLUGIN_EVENT_FREETAG_KEYWORDS', 'Automatiz�lt kulcsszavak');
@define('PLUGIN_EVENT_FREETAG_KEYWORDS_DESC', 'Minden c�mk�hez megadhat�k kulcsszavak (vessz�vel elv�lasztva). Amikor ezeket a kulcsszavakat haszn�ljuk a bejegyz�sek sz�veg�ben, a megfelel� c�mke hozz�rendel�dik a bejegyz�shez. T�l sok automatiz�lt kulcssz� megn�velheti a bejegyz�sek elment�s�vel t�lt�tt id�t!');
@define('PLUGIN_EVENT_FREETAG_KEYWORDS_ADD', 'Megtal�ltuk a k�vetkez� kulcssz�t: <strong>%s</strong>, a k�vetkez� c�mk�t automatikusan a bejegyz�shez rendelj�k: <strong><em>%s</em></strong><br />');

@define('PLUGIN_EVENT_FREETAG_REBUILD_FETCHNO', '%d-%d bejegyz�sek lek�r�se');
@define('PLUGIN_EVENT_FREETAG_REBUILD_TOTAL', ' (�sszesen %d bejegyz�s)...');
@define('PLUGIN_EVENT_FREETAG_REBUILD_FETCHNEXT', 'K�vetkez� k�teg bejegyz�s lek�r�se...');
@define('PLUGIN_EVENT_FREETAG_REBUILD', 'Minden automatiz�lt kulcssz� �jragener�l�sa');
@define('PLUGIN_EVENT_FREETAG_REBUILD_DESC', 'Figyelmeztet�s: Ez a funkci� minden egyes bejegyz�st k�l�n-k�l�n bet�lt �s �jra elment. Ez eltart egy ideig �s el�fordulhat, hogy megs�r�lnek a megl�v� bejegyz�sek. Aj�nlott el�bb egy biztons�gi m�solat k�sz�t�se az adatb�zisr�l! Kattints a "M�gsem" gombra a m�velet megszak�t�s�hoz!');

@define('PLUGIN_EVENT_FREETAG_ORDER_TAGNAME', 'C�mken�v');
@define('PLUGIN_EVENT_FREETAG_ORDER_TAGCOUNT', 'C�mke el�fordul�sok sz�ma');