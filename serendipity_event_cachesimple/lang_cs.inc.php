<?php

/**
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @translated 2009/06/04
 */

@define('PLUGIN_EVENT_CACHESIMPLE_NAME', 'Jednoduché cachování / pøedgenerování stránek');
@define('PLUGIN_EVENT_CACHESIMPLE_DESC', '[EXPERIMENTÁLNÍ] Umoòuje cachování (ve smyslu pøedgenerování) stránek. Pozor: Absolutnì zruší veškeré vymoenosti dynamicky vytváøeného obsahu, nepracuje dobøe s pluginy, které takovı obsah vytváøejí. Ale tato funkce zvyšuje rychlost blogu, pokud nepotøebujete dynamické funkce. (Tento plugin by mìl bıt umístìn co nejdøíve v seznamu pluginù. Pouze nutné pluginy generující dynamickı obsah, jako napø. karma, by mìly bıt umístìny pøed tímto pluginem.)');
@define('PLUGIN_EVENT_CACHESIMPLE_BROWSER', 'Pouít zvláš cache pro Internet Explorer a Mozillu?');
@define('PLUGIN_EVENT_CACHESIMPLE_KEEPFRESH', 'Vynutit obnovování èerstvé kopie na stranì klienta?');
@define('PLUGIN_EVENT_CACHESIMPLE_KEEPFRESH_DESC', 'Tím, e nebude posílána hlavièka "Expires", lze klienty (prohlíeèe) pøinutit, aby lokálnì necachovali stránky. To pøinutí klienty ádat server o stránku pøi kadém pokusu o její zobrazení. Dobré prohlíeèe pøesto pouívají nìkteér "ovìøovací" techniky pro minimalizaci datového toku mezi serverem a klientem. Tato volby zabrání problémùm typu, e se komentáø nezobrazí ihned poté, co byl pøidán, ale bude to také zpomalovat rychlost naèítání.');

