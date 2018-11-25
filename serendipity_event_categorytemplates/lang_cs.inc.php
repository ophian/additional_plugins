<?php

/**
 *  @author Vladim�r Ajgl <vlada@ajgl.cz>
 *  @translated 2009/06/26
 */

@define('PLUGIN_CATEGORYTEMPLATES_NAME', 'Vlastnosti/�ablona vzhledu pro kategorie');
#@define('PLUGIN_CATEGORYTEMPLATES_DESC', 'Tento plugin poskytuje p��davn� vlastnosti pro kategorie a v nich obsa�en� p��sp�vky, v�etn� voliten� �ablony vzhledu, po�ad� �azen�, po�et zobrazen�ch p��sp�vk�, ochranu heslem a schov�v�n� RSS kan�lu.');// translate new, see en
@define('PLUGIN_CATEGORYTEMPLATES_SELECT', 'Zadejte pros�m n�zev adres��e se �ablonou, kterou chcete pou��t pro tuto kategorii. Relativn� cesta za��n� v adres��i "templates/". Tak�e m��ete zadat nap��klad "blue" nebo "kubrick". M��ete pou��t tak� n�zev podadres��e, pokud jste ulo�ili �ablonu v podadres��i jin� �ablony. Pak zad�v�te "blue/kategorie1" nebo "blue/kategorie2". Recommended use is to add a category own "Engine:" template.');
@define('PLUGIN_CATEGORYTEMPLATES_FETCHLIMIT', 'P��sp�vky zobrazen� na v�choz� str�nce kategorie');
@define('PLUGIN_CATEGORYTEMPLATES_PASS', 'Ochrana heslem:');
@define('PLUGIN_CATEGORYTEMPLATES_PASS_DESC', 'M� b�t zapnuta ochrana kategori� heslem? Nev�hoda je, �e se kv�li zaheslovan�mu p��stupu mus� prov�st jeden dotaz do datab�ze nav�c a �e p��sp�vky v kategori�ch chr�n�n�ch heslem se nezobrazuj� na v�choz� str�nce blogu dokud u�ivatel nezobraz� chr�n�nou kategorii.');
@define('PLUGIN_CATEGORYTEMPLATES_PASS_USER', 'Ochrana kategorie heslem');
@define('PLUGIN_CATEGORYTEMPLATES_FIXENTRY', 'Glob�ln� nastaven� kategorie p��sp�vku');
@define('PLUGIN_CATEGORYTEMPLATES_FIXENTRY_DESC', 'Pokud je zapnuto, kategorie p��sp�vku p�i zobrazen� jedin�ho p��sp�vku bude nastavena jako aktu�ln� kategorie.');
@define('PLUGIN_CATEGORYTEMPLATES_CATPRECEDENCE', 'Po�ad� �ablon kategori�');
@define('PLUGIN_CATEGORYTEMPLATES_CATPRECEDENCE_DESC', 'Pokud je p��sp�vek p�i�azen do v�ce kategori�, tento seznam ur�uje, kter� �ablona bude pou�ita. �ablona pro kategorii, kter� je nejv��e, bude pou�ita.');
@define('PLUGIN_CATEGORYTEMPLATES_NO_CUSTOMIZED_CATEGORIES', '��dn� kategorie je�t� nemaj� vlastn� �ablonu.');
#@define('PLUGIN_CATEGORYTEMPLATES_HIDE', 'P��sp�vky v t�to kategorii se nebudou zobrazovat v RSS kan�lu');// translate new, see en

