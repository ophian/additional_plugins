<?php # 

/**
 *  @version 
 *  @author Kostas CoSTa Brzezinski <costa@kofeina.net>
 *  EN-Revision: Revision of lang_en.inc.php
 */

//
//  serendipity_event_staticpage.php
//
@define('STATICPAGE_HEADLINE', 'Nag��wek');
@define('STATICPAGE_HEADLINE_BLAHBLAH', 'Pokazuje nag��wek nad zawarto�ci� Strony statycznej, taki sam jak w normalnych wpisach');
@define('STATICPAGE_TITLE', 'Strony statyczne');
@define('STATICPAGE_TITLE_BLAHBLAH', 'Pokazuje Strony statyczne w Twoim blogu tak, jak pokazywane s� wszystkie inne wpisy (z zachowaniem formatowania i layoutu). Dodaje now� zak�adk� w menu w Panelu administracyjnym.');
@define('CONTENT_BLAHBLAH', 'Zawarto��');
@define('STATICPAGE_PERMALINK', 'Permalink');
@define('STATICPAGE_PERMALINK_BLAHBLAH', 'Definiuje permalinka dla URLa. Wymaga absolutnej �cie�ki HTTP i musi ko�czy� si� rozszerzeniem .htm lub .html!');
@define('STATICPAGE_PAGETITLE', 'Kr�tka nazwa URLa (kompatybilno�� wsteczna)');
@define('STATICPAGE_ARTICLEFORMAT', 'Formatowa� jak wpis?');
@define('STATICPAGE_ARTICLEFORMAT_BLAHBLAH', 'Je�li tak, zawarto�� Strony statycznej jest formatowana jak ka�dy inny wpis (kolory, ramki itd.) (domy�lnie: tak)');
@define('STATICPAGE_ARTICLEFORMAT_PAGETITLE', 'Tytu� strony w trybie "Formatowa� jak wpis"');
@define('STATICPAGE_ARTICLEFORMAT_PAGETITLE_BLAHBLAH', 'U�ywaj�c formatowania jak ka�dy inny wpis, mo�esz zdecydowa� jaki tekst wpisa� w miejscu, w kt�rym zazwyczaj pokazuje si� data wpisu');
@define('STATICPAGE_SELECT', 'Wybierz Stron� statyczn� do edycji lub stworzenia');
@define('STATICPAGE_PASSWORD_NOTICE', 'Ta strona jest chroniona has�em. Prosz�, wpisz prawid�owe has�o, kt�re zosta�o Ci przekazane:');
@define('STATICPAGE_PARENTPAGES_NAME', 'Strona nadrz�dna');
@define('STATICPAGE_PARENTPAGE_DESC', 'wybierz stron� nadrz�dn�');
@define('STATICPAGE_PARENTPAGE_PARENT', 'Jest nadrz�dna');
@define('STATICPAGE_AUTHORS_NAME', 'Imi� autora');
@define('STATICPAGE_AUTHORS_DESC', 'Ten autor jest w�a�cicielem tej strony');
@define('STATICPAGE_FILENAME_NAME', 'Schemat (Smarty)');
@define('STATICPAGE_FILENAME_DESC', 'Wpisz nazwe pliku/katalogu Schematu, kt�ry ma by� u�yty dla tej strony. Ten plik/katalog mo�e znajdowa� si� w katalogu wtyczki Strony statyczne lub w katalogu Schematu, z kt�rego korzystasz.');
@define('STATICPAGE_SHOWCHILDPAGES_NAME', 'Pokazuj strony potomne');
@define('STATICPAGE_SHOWCHILDPAGES_DESC', 'Poka� wszystkie strony potomne jako spis link�w');
@define('STATICPAGE_PRECONTENT_NAME', 'Tre�� poprzedzaj�ca');
@define('STATICPAGE_PRECONTENT_DESC', 'Poka� t� tre�� przed list� stron potomnych');
@define('STATICPAGE_CANNOTDELETE_MSG', 'Nie mog� usun�� tej strony. W bazie znajduj� si� strony potomne dla tej strony, prosz� je wpierw usun��.');
@define('STATICPAGE_IS_STARTPAGE', 'Ustaw t� stron� jako strone g��w� Twojej strony');
@define('STATICPAGE_IS_STARTPAGE_DESC', 'Je�li ustawisz t� stron� jako stron� g��wn� swojego serwisu, zamiast zwyczajowej strony startowej Serendipity poka�e t� stron� jako stron� startow� Twojej witryny. Tylko jedna strona mo�e by� stron� startow�! Je�li chcesz linkowa� do standardowej strony startowej, musisz u�y� konstrukcji "index.php?frontpage". Je�li chcesz u�ywa� tej funcji, upewnij si�, �e �adne inne wtyczki wspieraj�ce mechanizm permalink�w (np. G�osowanie, Ksi�ga go�ci) nie znajduj� si� przed wtyczk� Strony statyczne w Kolejce wtyczek Serendipity (upewnij si�, �e wtyczka jest wy�ej (czyli znajduje si� wcze�niej w kolejce zada� wykonywanych przez silnik strony) od innych wtyczek korzystaj�cych z permalink�w).');
@define('STATICPAGE_TOP', 'Do g�ry');
@define('STATICPAGE_NEXT', 'Nast�pny');
@define('STATICPAGE_PREV', 'Poprzedni');
@define('STATICPAGE_LINKNAME', 'Edycja');

@define('STATICPAGE_ARTICLETYPE', 'Typ wpisu');
@define('STATICPAGE_ARTICLETYPE_DESC', 'Wybierz typ Strony statycznej');

@define('STATICPAGE_CATEGORY_PAGEORDER', 'Kolejno�� stron');
@define('STATICPAGE_CATEGORY_PAGES', 'Edytuj strony');
@define('STATICPAGE_CATEGORY_PAGETYPES', 'Typy stron');
@define('STATICPAGE_CATEGORY_PAGEADD', 'Inne wtyczki');

@define('PAGETYPES_SELECT', 'Wybierz typ strony');
@define('STATICPAGE_ARTICLETYPE_DESCRIPTION', 'Opis:');
@define('STATICPAGE_ARTICLETYPE_DESCRIPTION_DESC', 'Opisz ten typ strony');
@define('STATICPAGE_ARTICLETYPE_TEMPLATE', 'Nazwa schematu:');
@define('STATICPAGE_ARTICLETYPE_TEMPLATE_DESC', 'Nazwa Schematu. Schemat mo�e znajdowa� si� w katalogu wtyczki Strony statyczne lub w domy�lnym katalogu ze Schematami.');
@define('STATICPAGE_ARTICLETYPE_IMAGE', '�cie�ka do obrazka:');
@define('STATICPAGE_ARTICLETYPE_IMAGE_DESC', 'URL do obrazka');

@define('STATICPAGE_SHOWNAVI', 'Poka� nawigacj�');
@define('STATICPAGE_SHOWNAVI_DESC', 'Poka� pasek nawigacyjny na tej stronie');
@define('STATICPAGE_SHOWONNAVI', 'Poka� w menu nawigacyjnym w Panelu bocznym');
@define('STATICPAGE_SHOWONNAVI_DESC', 'Poka� t� stron� w menu nawigacyjnym (o ile takowe jest w��czone), kt�re b�dzie si� pokazywa�o w Panelu bocznym (b�d� tam zawarte tylko Strony statyczne)');

@define('STATICPAGE_SHOWNAVI_DEFAULT', 'Poka� nawigacj�');
@define('STATICPAGE_DEFAULT_DESC', 'Domy�lne ustawienie dla nowych stron');
@define('STATICPAGE_SHOWONNAVI_DEFAULT', 'Poka� w menu nawigacyjnym w Panelu bocznym');
@define('STATICPAGE_SHOWMARKUP_DEFAULT', 'Poka� Markup');
@define('STATICPAGE_SHOWARTICLEFORMAT_DEFAULT', 'Formatuj jak wpis');
@define('STATICPAGE_SHOWCHILDPAGES_DEFAULT', 'Poka� strony potomne');

@define('STATICPAGE_PAGEORDER_DESC', 'Tu mo�esz zmieni� kolejno�� Stron statycznych');
@define('STATICPAGE_PAGEADD_DESC', 'Wybierz wtyczk�, kt�r� chcesz umie�ci� jako link w menu nawigacyjnym Stron statycznych.');
@define('STATICPAGE_PAGEADD_PLUGINS', 'Nast�puj�ce wtyczki mog� by� umieszczone w w menu nawigacyjnym w Panelu bocznym:');

@define('STATICPAGE_PUBLISHSTATUS', 'Status publikacji');
@define('STATICPAGE_PUBLISHSTATUS_DESC', 'Status publikacji tej strony');
@define('STATICPAGE_PUBLISHSTATUS_DRAFT', 'Szkic');
@define('STATICPAGE_PUBLISHSTATUS_PUBLISHED', 'Publikacja');

@define('STATICPAGE_SHOWTEXTORHEADLINE_NAME', 'Poka� nag��wek lub Poprzedni/Nast�pny w pasku nawigacyjnym');
@define('STATICPAGE_SHOWTEXTORHEADLINE_DESC', '');
@define('STATICPAGE_SHOWTEXTORHEADLINE_TEXT', 'Tekst: Poprzedni/Nast�pny');
@define('STATICPAGE_SHOWTEXTORHEADLINE_HEADLINE', 'Nag��wek');

@define('STATICPAGE_LANGUAGE', 'J�zyk');
@define('STATICPAGE_LANGUAGE_DESC', 'wybierz j�zyk tej strony');

@define('STATICPAGE_PLUGINS_INSTALLED', 'wtyczka jest zainstalowana');
@define('STATICPAGE_PLUGIN_AVAILABLE', 'Wtyczka jest dost�pna lecz nie zainstalowana');
@define('STATICPAGE_PLUGIN_NOTAVAILABLE', 'wtyczka jest niedost�pna');

@define('STATICPAGE_SEARCHRESULTS', 'Znaleziono %d Stron statycznych:');

@define('LANG_ALL', 'Wszystkie j�zyki');
@define('LANG_EN', 'English');
@define('LANG_DE', 'German');
@define('LANG_DA', 'Danish');
@define('LANG_ES', 'Spanish');
@define('LANG_FR', 'French');
@define('LANG_FI', 'Finnish');
@define('LANG_CS', 'Czech (Win-1250)');
@define('LANG_CZ', 'Czech (ISO-8859-2)');
@define('LANG_NL', 'Dutch');
@define('LANG_IS', 'Icelandic');
@define('LANG_PT', 'Portuguese Brazilian');
@define('LANG_BG', 'Bulgarian');
@define('LANG_NO', 'Norwegian');
@define('LANG_RO', 'Romanian');
@define('LANG_IT', 'Italian');
@define('LANG_RU', 'Russian');
@define('LANG_FA', 'Persian');
@define('LANG_TW', 'Traditional Chinese (Big5)');
@define('LANG_TN', 'Traditional Chinese (UTF-8)');
@define('LANG_ZH', 'Simplified Chinese (GB2312)');
@define('LANG_CN', 'Simplified Chinese (UTF-8)');
@define('LANG_JA', 'Japanese');
@define('LANG_KO', 'Korean');
@define('LANG_PL', 'Polish');

@define('STATICPAGE_STATUS', 'Status');

//
//  serendipity_plugin_staticpage.php
//

@define('PLUGIN_STATICPAGELIST_NAME', 'Lista Stron statycznych');
@define('PLUGIN_STATICPAGELIST_NAME_DESC', 'Ta wtyczka pokazuje konfigurowaln� list� Stron statycznych (menu). Wymaga wtyczki Strony statyczne w wersji minimum 1.22.');
@define('PLUGIN_STATICPAGELIST_TITLE', 'Tytu�');
@define('PLUGIN_STATICPAGELIST_TITLE_DESC', 'Wpisz tytu� pozycji w Panelu bocznym, w kt�rej uka�� si� linki menu do Stron statycznych');
@define('PLUGIN_STATICPAGELIST_TITLE_DEFAULT', 'Strony statyczne');
@define('PLUGIN_STATICPAGELIST_LIMIT', 'Ilo�� pokazywanych stron');
@define('PLUGIN_STATICPAGELIST_LIMIT_DESC', 'Wpisz ilo�� pokazywanych stron statycznych w menu. 0 oznacza brak limit�w.');
@define('PLUGIN_STATICPAGELIST_FRONTPAGE_NAME', 'Poka� link do strony g��wnej');
@define('PLUGIN_STATICPAGELIST_FRONTPAGE_DESC', 'Czy w menu ma byc pokazany link do strony g��wnej?');
@define('PLUGIN_STATICPAGELIST_FRONTPAGE_LINKNAME', 'Strona g��wna');
@define('PLUGIN_LINKS_IMGDIR', 'Uzyj katalogu wtyczki, w nim znajduj� si� odpowiednie obrazki');
@define('PLUGIN_LINKS_IMGDIR_BLAHBLAH', 'Podaj �cie�k� URL, kt�rej wtyczka ma u�ywa� przy szukaniu obrazk�w wizualizuj�cych uk�ad menu. Podkatalog "img" musi znajdowa� si� w miejscu wskazywanym przez �cie�k�. Taki podkatalog znajduje si� w katalogu wtyczki Strony statyczne. W razie w�tpliwo�ci pozostaw domy�lne ustawienie.');
@define('PLUGIN_STATICPAGELIST_SHOWICONS_NAME', 'Ikony czy czysty tekst');
@define('PLUGIN_STATICPAGELIST_SHOWICONS_DESC', 'Pokazywa� struktur� menu graficznie czy w formie czystego tekstu?');
@define('PLUGIN_STATICPAGELIST_ICON', 'JS graficznie');
@define('PLUGIN_STATICPAGELIST_TEXT', 'czysty tekst');
@define('PLUGIN_STATICPAGELIST_PARENTSONLY', 'Pokazywa� tylko strony nadrz�dne?');
@define('PLUGIN_STATICPAGELIST_PARENTSONLY_DESC', 'Je�li opcja zostanie w��czona, w strukturze menu pojawi� si� tylko strony oznaczone jako "nadrz�dne". Wy��czenie opcji poka�e tak�e strony "potomne" w strukturze menu.');
@define('PLUGIN_STATICPAGELIST_IMG_NAME', 'W��czy� graficzn� reprezentacj� struktury menu');

?>
