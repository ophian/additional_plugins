<?php

/**
 *  @version
 *  @author Kostas CoSTa Brzezinski <costa@kofeina.net>
 *  EN-Revision: Revision of lang_en.inc.php
 */

@define('PLUGIN_EVENT_RELATEDLINKS_TITLE', 'Powi�zane wpisy/linki');
@define('PLUGIN_EVENT_RELATEDLINKS_DESC', 'Wstaw powi�zane z danym wpisem linki do innych wpis�w lub stron. Mo�esz swobodnie zmienia� spos�b prezentowania link�w przez edycj� szablonu smarty "plugin_relatedlinks.tpl". Prosz� zwr�ci� uwag�, �e ten plugin pokazuje dane tylko w pe�nym widoku wpisu (wymaga wy�wietlenia pe�nej jego tre�ci).');
@define('PLUGIN_EVENT_RELATEDLINKS_ENTERDESC', 'Wstaw powi�zane z tym wpisem linki, kt�re chcesz pokaza�. Jeden URL (nie kod HTML!) na lini� (to znaczy linie separowane znakiem nowej linii - po prostu wci�nij enter aby przej�c do nowej linii). Je�li chcesz doda� opis, wprowad� go wed�ug nast�puj�cego schematu: http://przyklad.com/link.html=Przyk�ad owa strona. Wszystko co znajdzie si� w linii po znaku "=" b�dzie traktowane jako opis linku. Je�li nie wprowadzisz opisu, zostanie wy�wietlony sam link.');
@define('PLUGIN_EVENT_RELATEDLINKS_LIST', 'Powi�zane linki:');

@define('PLUGIN_EVENT_RELATEDLINKS_POSITION', 'Umieszczenie wtyczki');
@define('PLUGIN_EVENT_RELATEDLINKS_POSITION_DESC', 'Umie�ci� wynik dzia�ania wtyczki w stopce wpisu czy u�y� w tym celu szablonu Smarty? Je�li uaktywnisz szablon Smarty, musisz doda� t� lini� do szablonu entries.tpl swojego schematu: {serendipity_hookPlugin hook="frontend_display_relatedlinks" data=$entry hookAll="true"}{$RELATEDLINKS}. Lini� umie�� w p�tli foreach, w kt�rej definiowane jest wy�wietlanie zmiennej $entry (np. w miejscu wy�wietlania komentarzy, �lad�w czy rozszerzonej tre�ci wpisu).');
@define('PLUGIN_EVENT_RELATEDLINKS_POSITION_FOOTER', 'Umie�� w stopce wpisu');
@define('PLUGIN_EVENT_RELATEDLINKS_POSITION_BODY', 'Umie�� w tre�ci wpisu');
@define('PLUGIN_EVENT_RELATEDLINKS_POSITION_SMARTY', 'U�yj wywo�ania Smarty');

