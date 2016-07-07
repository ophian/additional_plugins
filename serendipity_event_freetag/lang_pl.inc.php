<?php # 

/**
 *  @version 
 *  Kostas CoSTa Brzezinski <costa@kofeina.net>
 *  EN-Revision: Revision of lang_en.inc.php
 */

//
//  serendipity_event_freetag.php
//
@define('PLUGIN_EVENT_FREETAG_TITLE', 'Tagowanie wpis�w');
@define('PLUGIN_EVENT_FREETAG_DESC', 'Umo�liwia dowolne tagowanie wpis�w');
@define('PLUGIN_EVENT_FREETAG_ENTERDESC', 'Wprowad� dowolne pasuj�ce tagi. Rozdzielaj tagi przecinkami (,).');
@define('PLUGIN_EVENT_FREETAG_LIST', 'Tagi dla tego wpisu: %s');
@define('PLUGIN_EVENT_FREETAG_USING', 'Wpisy otagowane jako %s');
@define('PLUGIN_EVENT_FREETAG_SUBTAG', 'Tagi powi�zane z tagiem %s');
@define('PLUGIN_EVENT_FREETAG_NO_RELATED', 'Brak powi�zanych tag�w.');
@define('PLUGIN_EVENT_FREETAG_ALLTAGS', 'Wszystkie zdefiniowane tagi');
@define('PLUGIN_EVENT_FREETAG_MANAGETAGS', 'Zarz�dzaj tagami');
@define('PLUGIN_EVENT_FREETAG_MANAGE_ALL', 'Zarz�dzaj wszystkimi tagami');
@define('PLUGIN_EVENT_FREETAG_MANAGE_LEAF', 'Zarz�dzaj tagami \'Leaf\' (pojedynczymi)');
@define('PLUGIN_EVENT_FREETAG_MANAGE_UNTAGGED', 'Lista nieotagowanych wpis�w');
@define('PLUGIN_EVENT_FREETAG_MANAGE_LEAFTAGGED', 'Lista wpis�w z tagami \'Leaf\'');
@define('PLUGIN_EVENT_FREETAG_MANAGE_UNTAGGED_NONE', 'Nie ma nieotagowanych wpis�w!');
@define('PLUGIN_EVENT_FREETAG_MANAGE_LIST_TAG', 'Tag');
@define('PLUGIN_EVENT_FREETAG_MANAGE_LIST_WEIGHT', 'Waga');
@define('PLUGIN_EVENT_FREETAG_MANAGE_LIST_ACTIONS', 'Akcja');
@define('PLUGIN_EVENT_FREETAG_MANAGE_ACTION_RENAME', 'Zmie� nazw�');
@define('PLUGIN_EVENT_FREETAG_MANAGE_ACTION_SPLIT', 'Rozdziel');
@define('PLUGIN_EVENT_FREETAG_MANAGE_ACTION_DELETE', 'Usu�');
@define('PLUGIN_EVENT_FREETAG_MANAGE_CONFIRM_DELETE', 'Na pewno chcesz usun�� tag %s?');
@define('PLUGIN_EVENT_FREETAG_MANAGE_INFO_SPLIT', 'u�yj przecinka by rozdzieli� tagi:');
@define('PLUGIN_EVENT_FREETAG_SHOW_TAGCLOUD', 'Pokaza� tag cloud (chmur� tag�w) do powi�zanych wpis�w?');

//
//  serendipity_plugin_freetag.php
//
@define('PLUGIN_FREETAG_NAME', 'Tagi');
@define('PLUGIN_FREETAG_BLAHBLAH', 'Pokazuje list� tag�w zdefiniowanych dla wpis�w');
@define('PLUGIN_FREETAG_NEWLINE', 'Przej�cie do nowej linii po ka�dym tagu?');
@define('PLUGIN_FREETAG_XML', 'Pokazywa� ikony XML?');
@define('PLUGIN_FREETAG_SCALE', 'Skalowa� rozmiar czcionki w zale�no�ci od popularno�ci taga (jak w serwisach Technorati czy flickr)?');
@define('PLUGIN_FREETAG_UPGRADE1_2', 'Poprawiono %d tag�w dla wpisu numer: %d');
@define('PLUGIN_FREETAG_MAX_TAGS', 'Jak wiele tag�w ma by� pokazywanych?');
@define('PLUGIN_FREETAG_TRESHOLD_TAG_COUNT', 'Jak wiele razy musi wyst�pi� dany tag, by by� pokazywany na li�cie?');

@define('PLUGIN_EVENT_FREETAG_TAGCLOUD_MIN', 'Minimalny rozmiar czcionki w procentach (%) w chmurze tag�w (tag cloud)');
@define('PLUGIN_EVENT_FREETAG_TAGCLOUD_MAX', 'Maksymalny rozmiar czcionki w procentach (%) w chmurze tag�w (tag cloud)');

@define('PLUGIN_FREETAG_META_KEYWORDS', 'Ilo�� s��w kluczowych meta umieszczanych w �r�dle HTML (0: wy��czenie opcji)');

@define('PLUGIN_EVENT_FREETAG_RELATED_ENTRIES', 'Powi�zane wpisy wedlug tag�w:');
@define('PLUGIN_EVENT_FREETAG_SHOW_RELATED', 'Wy�wietla� wpisy powi�zane wed�ug tag�w?');
@define('PLUGIN_EVENT_FREETAG_SHOW_RELATED_COUNT', 'Jak wiele powi�zanych wpis�w ma by� pokazywanych?');
@define('PLUGIN_EVENT_FREETAG_EMBED_FOOTER', 'Pokazywa� tagi w stopce wpisu?');
@define('PLUGIN_EVENT_FREETAG_EMBED_FOOTER_DESC', 'Je�li opcja jest w��czona, tagi b�d� pokazywane w stopce wpisu. Je�li opcja b�dzie wy��czona, tagi zostan� umieszczone w tre�ci (na samym dole) wpisu lub rozszerzonej tre�ci wpisu.');
@define('PLUGIN_EVENT_FREETAG_LOWERCASE_TAGS', 'Poka� tagi tylko ma�ymi literami');

