<?php

/**
 *  @author Vladim�r Ajgl <vlada@ajgl.cz>
 *  @translated 2009/06/26
 *  @author Vladim�r Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2012/01/12
 */

@define('PLUGIN_EVENT_WIKILINKS_NAME', 'Wiki odkazy v p��sp�vc�ch');
@define('PLUGIN_EVENT_WIKILINKS_DESC', 'V p��sp�vc�ch m��ete zadat odkazy na existuj�c�/nov� p��sp�vky pomoc� [[nadpis p��sp�vku]], na statick� str�nky pomoc� ((nadpis str�nky)) a na oboj� pomoc� {{nadpis}}.');
@define('PLUGIN_EVENT_WIKILINKS_IMGPATH', 'Cesta k obr�zk�m');
@define('PLUGIN_EVENT_WIKILINKS_IMGPATH_DESC', 'Zadejte cestu, na kter� jsou um�st�ny ikony wiki odkaz�.');

@define('PLUGIN_EVENT_WIKILINKS_EDIT_INTERNAL', 'Upravit p��sp�vek');
@define('PLUGIN_EVENT_WIKILINKS_EDIT_STATICPAGE', 'Upravit statickou str�nku');
@define('PLUGIN_EVENT_WIKILINKS_CREATE_INTERNAL', 'Vytvo�it p��sp�vek');
@define('PLUGIN_EVENT_WIKILINKS_CREATE_STATICPAGE', 'Vytvo�it statickou str�nku');

@define('PLUGIN_EVENT_WIKILINKS_LINKENTRY', 'Odkaz na p��sp�vek');
@define('PLUGIN_EVENT_WIKILINKS_LINKENTRY_DESC', 'Vyberte p��sp�vek, na kter� chcete odkazovat.');

@define('PLUGIN_EVENT_WIKILINKS_SHOWDRAFTLINKS_NAME', 'Vytvo�it odkazy na koncepty?');
@define('PLUGIN_EVENT_WIKILINKS_SHOWDRAFTLINKS_DESC', 'Maj� se tvo�it odkazy na p��sp�vky, kter� jsou ve stavu "koncept"?');
@define('PLUGIN_EVENT_WIKILINKS_SHOWFUTURELINKS_NAME', 'Vytv��et odkazy na budouc� p��sp�vky?');
@define('PLUGIN_EVENT_WIKILINKS_SHOWFUTURELINKS_DESK', 'Maj� se vytv��et odkazy na p��sp�vky, jejich� datum vyd�n� je v budoucnosti?');

// Next lines were translated on 2012/01/12
@define('PLUGIN_EVENT_WIKILINKS_REFMATCH_NAME', 'Vzor pro odchyt�v�n� referenc�');
@define('PLUGIN_EVENT_WIKILINKS_REFMATCH_DESC', 'Zde m��ete zadat vzor, podle kter�ho budou odchyt�v�ny reference p�i proch�zen� textu. Plugin sesb�r� tyto reference, ulo�� je do datab�ze a vyp�e je pod p��sp�vkem. M��ete tak� pou��t smarty tag {$entry.properties.references} pro um�st�n� tohoto bloku na libovoln� m�sto ve va�� �ablon�. Vzor je mo�n� zad�vat jako regul�rn� v�raz, nezapome�te escapovat speci�ln� znaky. V�choz� vzor vypad� slo�it�, proto�e pou��v� pojmenovan� pod-vzory, ale zato m��e b�t jednodu�e pou�it jako:<ref name="xxx">yyy</ref>, kde xxx je nepovinn� jm�no reference (viz n�e) a yyy je vlastn� text reference, kde yyy m��e b�t libovoln� HTML nebo jin� zna�kovac� jazyk.');
@define('PLUGIN_EVENT_WIKILINKS_REFDOC', '<strong>Znovu-pou��v�n� referenc�</strong><br /><br />Pokud chcete pou��t reference na v�ce m�stech, je v�hodn� specifikovat je pouze jednou a pak u� jen znovu-pou��vat. Nap��kad pokud nap�ete n�sleduj�c� text:<br />
<div style="border: 1px solid black; padding: 4px">
Serendipity&lt;ref&gt;&lt;a href="https://ophian.github.io/"&gt;Serendipity Styx Weblog&lt;/a&gt; - Serendipity m��e b�t tak� pou�ito v dal��ch v�znamech, ajko nap��klad film nebo tane�n�k ve filmu, nebo film o filmov�m tane�n�kovi.</ref> se m��e vyskytovat na mnoha m�stech.
</div>
<br/><br />
Proto�e budete mluvit o Serendipity na va�em blogu ur�it� na mnoha m�stech, m�li byste vytvo�it referenci, kter� funguje p�id�n�m atributu <em>name</em> attribute do tagu &lt;ref&gt; a bude vypadat n�sledovn�:
<div style="border: 1px solid black; padding: 4px">
Serendipity&lt;ref name="Serendipity"&gt;&lt;a href="https://ophian.github.io/"&gt;Serendipity Styx Weblog&lt;/a&gt; Serendipity m��e b�t tak� pou�ito v dal��ch v�znamech, ajko nap��klad film nebo tane�n�k ve filmu, nebo film o filmov�m tane�n�kovi.</ref> a m��e se vyskytovat na mnoha m�stech.</pre>
</div>
<br/><br />
Toto sta�� vlo�it pouze na prvn�m m�st� v�skytu reference. Kdykoliv budete cht�t pou��t tu samou referenci, sta�� napsat jednodu�e:
<div style="border: 1px solid black; padding: 4px">
Serendipity&lt;ref name="Serendipity"&gt;&lt;/ref&gt;
</div>
<br /><br />
To se postar� o vlo�en� existuj�c� pojmenovan� reference z datab�ze. Pamatujte, �e mus�te pou��t &lt;ref&gt;...&lt;/ref&gt; z�pis, &lt;ref.../&gt; nen� podporov�no kv�li syntaxi regul�rn�ho v�razu.
');
@define('PLUGIN_EVENT_WIKILINKS_REFMATCHTARGET_NAME', 'Form�t nahrazen� reference');
@define('PLUGIN_EVENT_WIKILINKS_REFMATCHTARGET_DESC', 'Zde m��ete zadat, jak bude odchycen� reference nahrazena, obvykle ��seln�m odkazem do seznamu referenc�. {count} (��slo) a {text} jsou z�stupn� prom�nn� pro ��slo a cel� text reference. {refname} odpov�d� nepovinn�mu jm�nu reference.');
@define('PLUGIN_EVENT_WIKILINKS_REFMATCHTARGET2_NAME', 'Form�t seznamu referenc�');
@define('PLUGIN_EVENT_WIKILINKS_REFMATCHTARGET2_DESC', 'M��ete zadat, jak se budou odchycen� reference zobrazovat v seznamu referenc�. Pokud je nastaveno na "-", pak se seznam referenc� nebude vypisovat. To je u�ite�n�, pokud chcete seznam referenc� zobrazovat sami pomoc� smarty!');
@define('PLUGIN_EVENT_WIKILINKS_MAINT', 'Zachovat index reference');
@define('PLUGIN_EVENT_WIKILINKS_MAINT_DESC', 'Zde m��ete upravit ulo�en� reference. Pamatujte, �e kdy� uprav�te p�vodn� p��sp�vek, ve kter�m byla reference, tak text v p��sp�vku m� v�dy p�ednost p�ed v��m, co zad�te tady. Pokud �asto upravujete star�� p��sp�vky, m�li byste rad�ji upravovat text referenc� uvnt� p��sp�vk� a ne zde.');
@define('PLUGIN_EVENT_WIKILINKS_DB_REFNAME', 'N�zev reference');
@define('PLUGIN_EVENT_WIKILINKS_DB_REF', 'Obsah reference');
@define('PLUGIN_EVENT_WIKILINKS_DB_ENTRYDID', 'Zad�no v:');

