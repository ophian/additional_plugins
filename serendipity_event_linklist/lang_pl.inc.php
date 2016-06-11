<?php

/**
 *  @version 
 *  @author Kostas CoSTa Brzezinski <costa@kofeina.net>
 *  EN-Revision: Revision of lang_en.inc.php
 */

//
//  serendipity_event_linklist.php
//
@define('PLUGIN_LINKLIST_TITLE', 'Lista link�w');
@define('PLUGIN_LINKLIST_DESC', 'Manad�er link�w - pokazuje Twoje ulubione linki w Panelu bocznym.');
@define('PLUGIN_LINKLIST_LINK', 'Link');
@define('PLUGIN_LINKLIST_LINK_NAME', 'Nazwa');
@define('PLUGIN_LINKLIST_ADMINLINK', 'Zarz�dzaj linkami');
@define('PLUGIN_LINKLIST_ORDER', 'Sortowanie link�w');
@define('PLUGIN_LINKLIST_ORDER_DESC', 'Wybierz metod� sortowania wy�wietlanych link�w');
@define('PLUGIN_LINKLIST_ORDER_NUM_ORDER', 'W�asna metoda');
@define('PLUGIN_LINKLIST_ORDER_DATE_ACS', 'Wed�ug daty (starsze do nowszych)');
@define('PLUGIN_LINKLIST_ORDER_DATE_DESC', 'Wed�ug daty (nowsze do starszych)');
@define('PLUGIN_LINKLIST_ORDER_CATEGORY', 'Kategoriami');
@define('PLUGIN_LINKLIST_ORDER_ALPHA', 'Alfabetycznie');
@define('PLUGIN_LINKLIST_LINKS', 'Zarz�dzaj linkami');
@define('PLUGIN_LINKLIST_NOLINKS', 'Brak link�w na li�cie');
@define('PLUGIN_LINKLIST_CATEGORY', 'U�ywaj kategorii');
@define('PLUGIN_LINKLIST_CATEGORYDESC', 'Uzywaj kategorii by organizowa� swoje linki');
@define('PLUGIN_LINKLIST_ADDLINK', 'Dodaj linka');
@define('PLUGIN_LINKLIST_LINK_EXAMPLE', 'Przyk�ad: http://www.s9y.org lub http://www.s9y.org/forums/');
@define('PLUGIN_LINKLIST_EDITLINK', 'Edytuj linka');
@define('PLUGIN_LINKLIST_LINKDESC', 'Opis linka');
@define('PLUGIN_LINKLIST_CATEGORY_NAME', 'U�ywa� kt�rego systemu kategorii:');
@define('PLUGIN_LINKLIST_CATEGORY_NAME_DESC', 'Mo�esz wybra�, jaki system kategorii ma by� wykorzystywany. System kategorii bloga (Domy�lny), czy te� dostarczany i zawiadywany przez wtyczk� (W�asny).');
@define('PLUGIN_LINKLIST_CATEGORY_NAME_CUSTOM', 'W�asny');
@define('PLUGIN_LINKLIST_CATEGORY_NAME_DEFAULT', 'Domy�lny');
@define('PLUGIN_LINKLIST_ADD_CAT', 'Zarz�dzaj kategoriami');
@define('PLUGIN_LINKLIST_CAT_NAME', 'Nazwa kategorii');
@define('PLUGIN_LINKLIST_PARENT_CATEGORY', 'Kategoria nadrz�dna');
@define('PLUGIN_LINKLIST_ADMINCAT', 'Podgl�d i zarz�dzanie kategoriami');
@define('PLUGIN_LINKLIST_CACHE_NAME', 'Buforowanie link�w');
@define('PLUGIN_LINKLIST_CACHE_DESC', 'Buforowanie listy link�w skutkuje wzrostem wydajno�ci strony. Bufor jest aktualizowany przy modyfikacji listy link�w z poziomu Panelu administracyjnego.');
@define('PLUGIN_LINKLIST_ENABLED_NAME', 'W��cz');
@define('PLUGIN_LINKLIST_ENABLED_DESC', 'W��cz wtyczk�');
@define('PLUGIN_LINKLIST_DELETE_WARN', 'Kiedy kategoria jest usuwana, wszystkie linki do niej przynale�ne zostan� przeniesione do kategorii g��wnej drzewa link�w.');

//
//  serendipity_plugin_linklist.php
//
@define('PLUGIN_LINKS_NAME', 'Lista link�w');
@define('PLUGIN_LINKS_BLAHBLAH', 'Manad�er link�w - pokazuje Twoje ulubione linki w Panelu bocznym.');
@define('PLUGIN_LINKS_TITLE', 'Tytu�');
@define('PLUGIN_LINKS_TITLE_BLAHBLAH', 'Wprowad� tytu�/nazw� sekcji z linkami (b�dzie widoczna w Panelu bocznym)');
@define('PLUGIN_LINKS_TOP_LEVEL', 'Tekst pocz�tkowy');
@define('PLUGIN_LINKS_TOP_LEVEL_BLAHBLAH', 'Wprowad� dowolny tekst, jaki ma by� pokazywany przed list� link�w (mo�na to pole pozostawi� puste)');
@define('PLUGIN_LINKS_DIRECTXML', 'Wprowadzaj XML bezpo�rednio');
@define('PLUGIN_LINKS_DIRECTXML_BLAHBLAH', 'Mo�esz wprowadza� dane XML bezpo�rednio (samodzielnie) lub u�y� strony web zarz�dzaj�cej linkami');
@define('PLUGIN_LINKS_LINKS', 'Linki');
@define('PLUGIN_LINKS_LINKS_BLAHBLAH', 'u�ywaj XML! - dla katalog�w u�yj sk�adni "<dir name="dirname"> i zamykaj u�ywaj�c </dir> - dla link�w u�ywaj sk�adni "<link name="nazwa linku" link="http://link.com/" />');
@define('PLUGIN_LINKS_OPENALL', 'Otw�rz wszystkie');
@define('PLUGIN_LINKS_OPENALL_BLAHBLAH', 'Wprowad� tekst dla linku "Otw�rz wszystkie"');
@define('PLUGIN_LINKS_OPENALL_DEFAULT', 'Otw�rz wszystkie');
@define('PLUGIN_LINKS_CLOSEALL', 'Zamknij wszystkie');
@define('PLUGIN_LINKS_CLOSEALL_BLAHBLAH', 'Wprowad� tekst dla linku "Zamknij wszystkie"');
@define('PLUGIN_LINKS_CLOSEALL_DEFAULT', 'Zamknij wszystkie');
@define('PLUGIN_LINKS_SHOW', 'Pokazuj linki "Otw�rz wszystkie" i "Zamknij wszystkie"');
@define('PLUGIN_LINKS_SHOW_BLAHBLAH', 'Czy chcesz umie�ci� w Panelu bocznym linki do "Otw�rz wszystkie" i "Zamknij wszystkie"?');
@define('PLUGIN_LINKS_LOCATION', 'Lokalizacja link�w "Otw�rz wszystkie" i "Zamknij wszystkie"');
@define('PLUGIN_LINKS_LOCATION_BLAHBLAH', 'Gdzie linki "Otw�rz wszystkie" i "Zamknij wszystkie" maj� by� umieszczone? Nad czy pod list� link�w?');
@define('PLUGIN_LINKS_LOCATION_TOP', 'Nad');
@define('PLUGIN_LINKS_LOCATION_BOTTOM', 'Pod');
@define('PLUGIN_LINKS_SELECTION', 'U�ywaj selekcji');
@define('PLUGIN_LINKS_SELECTION_BLAHBLAH', 'Je�li zaznaczysz "Tak", ga��zie drzewa link�w mog� by� zaznaczane (pod�wietlane)');
@define('PLUGIN_LINKS_COOKIE', 'U�ywaj cookies (ciasteczek)');
@define('PLUGIN_LINKS_COOKIE_BLAHBLAH', 'Je�li zaznaczysz "Tak", drzewo link�w b�dzie u�ywa�o cookies (ciasteczek) do zapami�tania swojego stanu');
@define('PLUGIN_LINKS_LINE', 'U�ywaj linii');
@define('PLUGIN_LINKS_LINE_BLAHBLAH', 'Je�li zaznaczysz "Tak", drzewo link�w b�dzie rysowane przy pomocy linii');
@define('PLUGIN_LINKS_ICON', 'U�ywaj ikon');
@define('PLUGIN_LINKS_ICON_BLAHBLAH', 'Je�li zaznaczysz "Tak", drzewo link�w b�dzie rysowane przy pomocy ikon');
@define('PLUGIN_LINKS_STATUS', 'U�ywaj tekstu w panelu statusu przegl�darki');
@define('PLUGIN_LINKS_STATUS_BLAHBLAH', 'Je�li zaznaczysz "Tak", nazwy ga��zi drzewa b�d� pokazywane w panelu statusu przegl�darki zamiast adresu URL');
@define('PLUGIN_LINKS_CLOSELEVEL', 'Zamknij ten sam poziom');
@define('PLUGIN_LINKS_CLOSELEVEL_BLAHBLAH', 'Je�li zaznaczysz "Tak", tylko jedna ga��� drzewa link�w mo�e by� otwarta w danym momencie. Linki "Otw�rz wszystkie" i "Zamknij wszystkie" nie dzia�aj� kiedy to ustawienie jest w��czone.');
@define('PLUGIN_LINKS_TARGET', 'Cel');
@define('PLUGIN_LINKS_TARGET_BLAHBLAH', 'Docelowe miejsce dla link�w - mo�e by� zdefioniowane jako "_blank", "_self", "_top", "_parent" lub mo�esz wprowadzi� nazw� ramki (frame)');
@define('PLUGIN_LINKS_IMGDIR', 'Uzyj katalogu wtyczki, w nim znajduj� si� odpowiednie obrazki');
@define('PLUGIN_LINKS_IMGDIR_BLAHBLAH', 'Je�li zaznaczysz "Tak", wtyczka za�o�y, �e potrzebne jej do prawid�owego wy�wietlania obrazki znajduj� si� w katalogu wtyczki. Je�li zaznaczysz "Nie", wtyczka jako katalog obrazk�w wska�e katalog "/templates/default/img/". Wy��czenie �ciezki do obrazk�w jest wymagane przy wsp�dzielonych instalacjach lecz wymaga tak�e r�cznego przeniesienia obrazk�w do odpowiedniego katalogu.');
@define('PLUGIN_LINKLIST_CATEGORY_DEFAULT_OPEN_NAME', 'Drzewo kategorii otwarte czy zamkni�te?');
@define('PLUGIN_LINKLIST_CATEGORY_DEFAULT_OPEN_DESC', 'Przy u�ywaniu sortowania Kategoriami mo�esz ustawi� czy wszystkie ga��zie drzewa link�w b�d� standardowo otwarte czy zamkni�te');
@define('PLUGIN_LINKLIST_CATEGORY_DEFAULT_OPEN_NAME_CLOSED', 'Zamkni�te');
@define('PLUGIN_LINKLIST_CATEGORY_DEFAULT_OPEN_NAME_OPEN', 'Otwarte');
@define('PLUGIN_LINKLIST_OUTSTYLE_DTREE', 'dtree');
@define('PLUGIN_LINKLIST_OUTSTYLE_CSS', 'Lista CSS');
@define('PLUGIN_LINKLIST_ORDER_OUTSTYLE_SIMP_CSS', 'Prosty CSS');
@define('PLUGIN_LINKS_OUTSTYLE', 'Wybierz styl wy�wietlania dla listy link�w');
@define('PLUGIN_LINKS_OUTSTYLE_BLAHBLAH', 'Wybierz styl wy�wietlania dla listy link�w. Dtree u�ywa javascriptu do tworzenia drzewa link�w (skrypt dzia�a we wszystkich popularnych przegl�darkach). Lista CSS u�ywa div�w i prostego javascriptu dla stworzenia efektu uzyskiwanego przez zastosowanie Dtree ale nie jest tak zaawansowany jak Dtree. Prosty CSS to metoda najlepsza je�li chcesz by wyszukiwarki parsowa�y linki umieszczone na Twojej stronie. Prosty CSS wy�wietli kontrolowan� przez CSS list�. UWAGA! Metody z u�yciem Dtree zazwyczaj NIE umozliwiaj� wyszukiwarkom interentowym na parsowanie wy�wietlanych przez nie link�w.');

