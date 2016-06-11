<?php

/**
 *  @author Vladim�r Ajgl <vlada@ajgl.cz>
 *  @translated 2009/07/07
 */

@define('PLUGIN_EVENT_INCLUDEENTRY_NAME', 'Markup: Vlo�en� p��sp�vku/�ablony/bloku');
@define('PLUGIN_EVENT_INCLUDEENTRY_DESC', 'Umo��uje p�idat do p��sp�vku tagy, kter� zajist� vlo�en� ��st jin�ho p��sp�vku. Pou�ijte tuto zna�ku: [s9y-include-entry:XXX:YYY]. Nahra�te XXX ��slem ID odkazovan�ho p��sp�vku a YYY nahra�te n�zvem pole p��sp�vku, kter� chcete vlo�it (nap�. "body", "title", "extended", ...). Tak� m��ete vyu��t nov� funkce menu pro spr�vu �ablon a blok�, kter� je mo�no vlo�it mezi p��sp�vky.');
@define('PLUGIN_EVENT_INCLUDEENTRY_BLOCKS', 'Bloky �ablon');
@define('PLUGIN_EVENT_INCLUDEENTRY_DBVERSION', '1.0');
@define('PLUGIN_EVENT_INCLUDEENTRY_FILENAME_NAME', '�ablona (Smarty)');
@define('PLUGIN_EVENT_INCLUDEENTRY_FILENAME_DESC', 'Zadejte jm�no souboru �ablony, kter� se m� pou��t pro tuto str�nku. �ablona smarty m��e b�t um�st�na v adres��i tohoto pluginu nebo v adres��i Va�� �ablony.');
@define('STATICBLOCK_SELECT_TEMPLATES', 'Vyberte �ablonu');
@define('STATICBLOCK_SELECT_BLOCKS', 'Vyberte blok');
@define('STATICBLOCK_EDIT_TEMPLATES', 'Upravit �ablonu');
@define('STATICBLOCK_EDIT_BLOCKS', 'Upravit blok');
@define('STATICBLOCK_USE', 'Pou��t �ablonu');
@define('STATICBLOCK_ATTACH', 'P�idat statick� blok: ');

@define('STATICBLOCK_RANDOMIZE', 'Zobrazovat n�hodn� bloky');
@define('STATICBLOCK_RANDOMIZE_DESC', 'Pokud je zapnuto, bloky budou n�hodn� vlo�eny za p��sp�vky.');
@define('STATICBLOCK_FIRST_SHOW', 'Prvn� p��sp�vek');
@define('STATICBLOCK_FIRST_SHOW_DESC', 'Zadejte po�et p��sp�vk�, po kter�ch za�nou b�t vkl�d�ny n�hodn� bloky. "1" vlo�� n�hodn� blok za prvn� p��sp�vek, "2" za druh� atp.');
@define('STATICBLOCK_SHOW_SKIP', 'P�esko�it p��sp�vky');
@define('STATICBLOCK_SHOW_SKIP_DESC', 'Zadejte po�et p��sp�vk�, po kter�ch se m� znovu v�adit n�hodn� blok. "1" bude zobrazovat n�hodn� blok po ka�d�m p��sp�vku, "2" pouze po ka�d�ch dvou p��sp�vc�ch.');

@define('STATICBLOCK_SHOW_MULTI', 'Povolit v�cen�sobn� bloky');
@define('STATICBLOCK_SHOW_MULTI_DESC', 'Pokud vlo��te blok do p��sp�vku, m� p�esto funkce n�hodn� vkl�d�n� blok� vkl�dat bloky po p��sp�vku? Pokud je nastaveno "Ne", ka�d� p��sp�vek nebude obsahovat v�ce ne� jeden n�hodn� blok.');

