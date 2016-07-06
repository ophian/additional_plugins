<?php

/**
 *  @author Vladim�r Ajgl <vlada@ajgl.cz>
 *  @translated 2009/06/04
 */

@define('PLUGIN_EVENT_CACHESIMPLE_NAME', 'Jednoduch� cachov�n� / p�edgenerov�n� str�nek');
@define('PLUGIN_EVENT_CACHESIMPLE_DESC', '[EXPERIMENT�LN�] Umo��uje cachov�n� (ve smyslu p�edgenerov�n�) str�nek. Pozor: Absolutn� zru�� ve�ker� vymo�enosti dynamicky vytv��en�ho obsahu, nepracuje dob�e s pluginy, kter� takov� obsah vytv��ej�. Ale tato funkce zvy�uje rychlost blogu, pokud nepot�ebujete dynamick� funkce. (Tento plugin by m�l b�t um�st�n co nejd��ve v seznamu plugin�. Pouze nutn� pluginy generuj�c� dynamick� obsah, jako nap�. karma, by m�ly b�t um�st�ny p�ed t�mto pluginem.)');
@define('PLUGIN_EVENT_CACHESIMPLE_BROWSER', 'Pou��t zvlṻ cache pro Internet Explorer a Mozillu?');
@define('PLUGIN_EVENT_CACHESIMPLE_KEEPFRESH', 'Vynutit obnovov�n� �erstv� kopie na stran� klienta?');
@define('PLUGIN_EVENT_CACHESIMPLE_KEEPFRESH_DESC', 'T�m, �e nebude pos�l�na hlavi�ka "Expires", lze klienty (prohl�e�e) p�inutit, aby lok�ln� necachovali str�nky. To p�inut� klienty ��dat server o str�nku p�i ka�d�m pokusu o jej� zobrazen�. Dobr� prohl�e�e p�esto pou��vaj� n�kte�r "ov��ovac�" techniky pro minimalizaci datov�ho toku mezi serverem a klientem. Tato volby zabr�n� probl�m�m typu, �e se koment�� nezobraz� ihned pot�, co byl p�id�n, ale bude to tak� zpomalovat rychlost na��t�n�.');

