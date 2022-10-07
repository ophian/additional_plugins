<?php

/**
 *  @author Vladim�r Ajgl <vlada@ajgl.cz>
 *  @translated 2009/06/05
 *  @author Vladim�r Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2010/12/25
 */

@define('PLUGIN_AGGREGATOR_TITLE', 'RSS agreg�tor');
@define('PLUGIN_AGGREGATOR_DESC', 'Zobrazuje zpr�vy z mnoha RSS kan�l�. D�LE�IT� POZN�MKA: Aktualizace a "krmen�" agreg�toru je v sou�asnosti nutno d�lat ru�n� pomoc� Cronjobs nebo podobn�. Volejte n�sleduj�c� adresu v libovoln�ch �asov�ch intervalech: ' . $serendipity['baseURL'] . 'index.php?/plugin/aggregator');
@define('PLUGIN_AGGREGATOR_FEEDNAME', 'N�zev RSS kan�lu');
@define('PLUGIN_AGGREGATOR_FEEDNAME_DESC', 'Zobrazovan� n�zev RSS kan�lu.');
@define('PLUGIN_AGGREGATOR_FEEDURI', 'URI adresa RSS kan�lu');
@define('PLUGIN_AGGREGATOR_FEEDURI_DESC', 'Adresa RSS kan�lu.');
@define('PLUGIN_AGGREGATOR_HTMLURI', 'Domovsk� str�nka - URI adresa');
@define('PLUGIN_AGGREGATOR_HTMLURI_DESC', 'HTML adresa kan�lu.');
@define('PLUGIN_AGGREGATOR_CATEGORIES', 'Kategorie');

@define('PLUGIN_AGGREGATOR_FEEDLIST', 'Toto je seznam pou�iteln�ch kan�l�. Jednotilv� kan�ly m��ete zadat ru�n� a stisknout tla��tko "GO" ("Prov�st"), nebo m��ete importovat cel� OPML soubor. Kan�ly mohou b�t smaz�ny zad�n�m pr�zdn� hodnoty do n�zvuv nebo URL adresy kan�lu. Nov� kan�ly mohou b�t p�id�ny jako posledn� ��dka tabulky.');
@define('PLUGIN_AGGREGATOR_FEEDUPDATE', 'Posledn� aktualizace');
@define('PLUGIN_AGGREGATOR_FEED_MISSINGDATA', 'Mus�te zadat jm�no a URL adresu RSS kan�lu.');
@define('PLUGIN_AGGREGATOR_EXPORTFEEDLIST', 'Exportovat OPML seznam RSS kan�l�');
@define('PLUGIN_AGGREGATOR_IMPORTFEEDLIST', 'Importovat OPML seznam RSS kan�l�');
@define('PLUGIN_AGGREGATOR_IMPORTFEEDLIST_DESC', 'Zadejte URL adresu k OPML soubor (sou�asn� nastaven� RSS kan�l� bude ZRU�ENO a p�eps�no importovan�mi kan�ly!). Pokud za�krtnete vobu "Import kategori�", bude z OMPL souboru do blogu importov�na i struktura kategori�.');
@define('PLUGIN_AGGREGATOR_IMPORTFEEDLIST_BUTTON', 'Importovat OPML!');
@define('PLUGIN_AGGREGATOR_EXPORTFEEDLIST_BUTTON', 'Exportovat OPML!');
@define('PLUGIN_AGGREGATOR_IMPORTCATEGORIES', 'Importovat kategorie');
@define('PLUGIN_AGGREGATOR_IMPORTCATEGORIES2', 'Za�adit ka�d� RSS kan�l do vlastn� kategorie');
@define('PLUGIN_AGGREGATOR_CATEGORYSKIPPED', 'P�eskakuji vytv��en� kategorie "%s", proto�e u� existuje.');

@define('PLUGIN_AGGREGATOR_EXPIRE', 'Vypr�en� platnosti obsahu');
@define('PLUGIN_AGGREGATOR_EXPIRE_BLAHBLAH', 'Platnost obsahu v datab�zi vypr�� po uplynut� n dn� (0 = ��dn� vypr�en� platnosti).');
@define('PLUGIN_AGGREGATOR_EXPIRE_MD5', 'Kontroln� sou�ty pro expiraci');
@define('PLUGIN_AGGREGATOR_EXPIRE_MD5_BLAHBLAH', 'Kontroln� sumy se pou��vaj� ke kontrole �l�nk� bez data na duplik�ty. Po kolika dnech maj� kontroln� sou�ty vypr�et? (90 = doporu�en� hodnota, 0 = nikdy).');
@define('PLUGIN_AGGREGATOR_DELETEDEPENDENCIES', 'Odstranit z�visl� p��sp�vky?');
@define('PLUGIN_AGGREGATOR_DELETEDEPENDENCIES_DESC', 'Pokud odhl�s�te (sma�ete) kan�l a tato volba je zapnuta, v�echny p��sp�vky sv�zan� s t�mto kan�lem budou smaz�ny.');
@define('PLUGIN_AGGREGATOR_DEBUG', 'Ladic� v�pisy');
@define('PLUGIN_AGGREGATOR_DEBUG_BLAHBLAH', 'Zapnout zapisov�n� ladic�ch v�pis� do souboru?');
@define('PLUGIN_AGGREGATOR_IGNORE_UPDATES', 'Ignorovat aktualizace?');
@define('PLUGIN_AGGREGATOR_IGNORE_UPDATES_DESC', 'Pokud se text �l�nku zm�n� pozd�ji po vyd�n�, m� se tato aktualizace ignorovat?');
@define('PLUGIN_AGGREGATOR_CHOOSE_ENGINE', 'Vybrat RSS parser');
@define('PLUGIN_AGGREGATOR_CHOOSE_ENGINE_DESC', 'Onys je distribuov�n pod BSD licenc�, ale nepodporuje kan�ly typu ATOM.');
@define('PLUGIN_AGGREGATOR_CRONJOB', 'Tento plugin vyu��v� Serendipity plugin Cronjob. Nainstalujte jej, pokud pot�ebujete vyu��vat pravideln� opakovan� aktualizace.');
@define('PLUGIN_AGGREGATOR_MATCH_EXPRESSION', 'Filtr (*)');
@define('PLUGIN_AGGREGATOR_MATCH_EXPRESSION_DESC', 'Zde lze zadat regul�rn� v�raz, kter�m se bude porovn�vat obsah p��sp�vku (nadpis a t�lo) a tento p��sp�vek se vlo�� do bogu, pouze pokud obsahuje zde zadan� vzor. Pokud je ponech�no pr�zdn�, ��dn� porovn�v�n� se neprov�d�. V�ce v�raz� m��e b�t odd�leno znakem ~ (vlnovka = tilda) a jsou kombinov�ny podle logiky OR (nebo = pokud �l�nek obsahuje alespo� jeden z v�raz�, je p�ijat).');

@define('PLUGIN_AGGREGATOR_PUBLISH', 'Ulo�it agregovan� p��sp�vky jako...');
@define('PLUGIN_AGGREGATOR_MARKUP_DISABLE', 'Zak�zat zna�kovac� pluginy pro p��sp�vky vyroben� pomoc� agreg�toru.');
@define('PLUGIN_AGGREGATOR_MARKUP_DISABLE_DESC', 'Ozna�te zna�kovac� pluginy, kter� nemaj� b�t pou��v�ny v agregovan�ch p��sp�vc�ch.');

