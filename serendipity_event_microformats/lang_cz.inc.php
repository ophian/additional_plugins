<?php

/**
 *  @author Vladim�r Ajgl <vlada@ajgl.cz>
 *  @translated 2009/06/08
 */

@define('PLUGIN_EVENT_MICROFORMATS_TITLE', 'Mikroform�ty');
@define('PLUGIN_EVENT_MICROFORMATS_DESC', 'Tento plugin poskytuje jednoduch� publikov�n� p�ehled� (nebo ud�lost�); podporuje p��slu�n� mikroform�ty.');

@define('PLUGIN_EVENT_MICROFORMATS_TYPES', 'Typ p��sp�vku');
@define('PLUGIN_EVENT_MICROFORMATS_TYPES_DESC', 'Kter� typ p��sp�vk� chcete publikovat, tzn. p�ehledy nebo ud�losti?');

@define('PLUGIN_EVENT_MICROFORMATS_TYPES_HREVIEW', 'P�ehledy');
@define('PLUGIN_EVENT_MICROFORMATS_TYPES_HCALENDAR', 'Ud�losti');

@define('PLUGIN_EVENT_MICROFORMATS_ID', 'ID');
@define('PLUGIN_EVENT_MICROFORMATS_RATING', 'Hodnocen�');

@define('PLUGIN_EVENT_MICROFORMATS_SB_SUBNODE', 'P�idat uzel');
@define('PLUGIN_EVENT_MICROFORMATS_SB_SUBNODE_DESC', 'Pokud je k p��sp�vku p�id�n uzel, slu�by, kter� pou��vaj� strukturovan� blogov�n�, ho mohou p�e��st; ale XHTML k�d nemus� b�t spr�vn� vykreslen.');

@define('PLUGIN_MICROFORMATS_TITLE_N', 'Nadch�zej�c� ud�losti');
@define('PLUGIN_MICROFORMATS_TITLE_D', 'Zobrazit nejbli��� a doporu�en� ud�losti v postrann�m sloupci a pou��t na n� mikroformat hCalendar.');

@define('PLUGIN_MICROFORMATS_DISPLAY_N', 'Hlavi�ka postrann�ho sloupce');
@define('PLUGIN_MICROFORMATS_DISPLAY_D', 'To je to, co se zobraz� jako nadpis bloku v postrann�m sloupci');

@define('PLUGIN_MICROFORMATS_SORT_N', 'T��dit ud�losti podle data');
@define('PLUGIN_MICROFORMATS_SORT_D', 'Pokud je "Ano", pak budou ud�losti t��d�ny podle data kon�n�. Jinak se budou zobrazovat v po�ad�, v jak�m byly zad�ny.');

@define('PLUGIN_MICROFORMATS_PURGE_N', 'Odstranit ud�losti, kter� u� prob�hly');
@define('PLUGIN_MICROFORMATS_PURGE_D', 'Ud�losti, kter� jsou star�� ne� X dn� od aktu�ln�ho data, budou odstran�ny ze seznamu. Ponechte pr�zdn�, pokud nechcete mazat ud�losti.');

@define('PLUGIN_MICROFORMATS_ENTRIES_N', 'V�etn� ud�lost� z p��sp�vk�');
@define('PLUGIN_MICROFORMATS_ENTRIES_D', 'Pokud pou�ijete mikroform�t hCalendar v p��sp�vc�ch, m��ete je tak� zobrazit v postrann�m sloupci.');

@define('PLUGIN_MICROFORMATS_ICONDISPLAY_N', 'Zobrazit CAL ikonu');
@define('PLUGIN_MICROFORMATS_ICONDISPLAY_D', 'Zobrazit �ervenou CAL ikonu pod seznamem ud�lost�.');

@define('PLUGIN_MICROFORMATS_TIMEZONE_N', '�asov� p�smo');
@define('PLUGIN_MICROFORMATS_TIMEZONE_D', '�asov� p�smo ud�lost� (nejpravd�podobn�ji �asov� p�smo blogu).');

@define('PLUGIN_MICROFORMATS_EVENTLIST_XML_N', 'Seznam ud�lost�');
@define('PLUGIN_MICROFORMATS_EVENTLIST_XML_D', 'Pou�ijte pros�m spr�vn� XML form�tov�n� (viz. n�e). Mus�te zadat p�inejmen��m "summary" (shrnut� nebo popis) a "dtstart" (datum po��tku).');

@define('PLUGIN_EVENT_MICROFORMATS_BEST_N', 'Maximum bod�');
@define('PLUGIN_EVENT_MICROFORMATS_BEST_D', '');

@define('PLUGIN_EVENT_MICROFORMATS_STEP_N', 'Krok�');
@define('PLUGIN_EVENT_MICROFORMATS_STEP_D', '');

@define('PLUGIN_EVENT_MICROFORMATS_PATH_N', 'Cesta ke skript�m');
@define('PLUGIN_EVENT_MICROFORMATS_PATH_D', 'Zadejte plnou HTTP cestu (v�echno po dom�nov�m jm�nu), kter� vede do adres��e tohoto pluginu (nap�. /serendipity/plugins/serendipity_event_microformats).');

@define('PLUGIN_MICROFORMATS_EVENTLIST_XML_EXPLAIN', 'V souladu s definic� mikroform�tu hCalendar (28.01.2007), t�lo p��sp�vku je definov�no n�sledovn�: <p><code>&lt;events&gt;<br/>&lt;event summary="Mistrovstv� sv�ta ve fotbale 2010" location="Jihoafrick� republika" url="http://www.fifa.com/de/worldcup/index/0,3360,WF2010,00.html?comp=WF&year=2010" dtstart="20100611T1930" dtend="20100711T2000" description="Africk� v�zva" /&gt;<br/>&lt;/events&gt;</code></p><p>Pod�vejte se tak� na <a href="http://blog.sperr-objekt.de/pages/microformats.html">dokumentaci</a>, kter� by u� m�la b�t naps�na.</p>');

