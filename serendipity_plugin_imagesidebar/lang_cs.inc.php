<?php

/**
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @translated 2009/03/16
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2013/04/21
 */

@define('PLUGIN_SIDEBAR_IMAGESIDEBAR_NAME', 'Jednotné zobrazování obrázků v postranním sloupci');
@define('PLUGIN_SIDEBAR_IMAGESIDEBAR_DESC', 'Umožňuje zobrazovat obrázky v postranním sloupci. Zdrojů těchto obrázků může být vícero. Plugin se dokáže připojit do databáze Coppermine galerie (pouze pokud běží na MySQL) a samozřejmě i ke Knihovně médií Serendipity.');

@define('PLUGIN_SIDEBAR_IMAGESIDEBAR_DISPLAYSRC_NAME', 'Zdroj obrázku');
@define('PLUGIN_SIDEBAR_IMAGESIDEBAR_DISPLAYSRC_DESC', 'Vyberte ze seznamu zdroj obrázků');
@define('PLUGIN_SIDEBAR_IMAGESIDEBAR_DISPLAYSRC_NONE', 'Ještě nebylo nic vybráno');
@define('PLUGIN_SIDEBAR_IMAGESIDEBAR_DISPLAYSRC_COPPERMINE', 'Databáze Coppermine');
@define('PLUGIN_SIDEBAR_IMAGESIDEBAR_DISPLAYSRC_MEDIALIB', 'Knihovna médií Serendipity');

@define('PLUGIN_CPGS_NAME', 'Coppermine náhledy');
@define('PLUGIN_CPGS_DESC', 'Zobrazit náhledy galerie Coppermine v postranním sloupci');
@define('PLUGIN_CPGS_SERVER_NAME', 'Server');
@define('PLUGIN_CPGS_SERVER_DESC', 'SQL server použitý v Coppermine');
@define('PLUGIN_CPGS_DB_NAME', 'Databáze');
@define('PLUGIN_CPGS_DB_DESC', 'SQL databáze');
@define('PLUGIN_CPGS_PREFIX_NAME', 'Předpona (prefix)');
@define('PLUGIN_CPGS_PREFIX_DESC', 'Předpona - prefix tabulek Coppermine galerie');
@define('PLUGIN_CPGS_USER_NAME', 'Přihlašovací jméno');
@define('PLUGIN_CPGS_USER_DESC', 'Přihlašovací jméno do databáze');
@define('PLUGIN_CPGS_PASSWORD_NAME', 'Heslo');
@define('PLUGIN_CPGS_PASSWORD_DESC', 'Heslo do databáze');
@define('PLUGIN_CPGS_URL_NAME', 'URL');
@define('PLUGIN_CPGS_URL_DESC', 'URL adresa galerie');
@define('PLUGIN_CPGS_TYPE_NAME', 'Typ');
@define('PLUGIN_CPGS_TYPE_DESC', 'Které obrázky zobrazit?');
@define('PLUGIN_CPGS_TITLE_NAME', 'Nadpis');
@define('PLUGIN_CPGS_TITLE_DESC', 'Nadpis postranního bloku');
@define('PLUGIN_CPGS_ALBUM_NAME', 'Odkaz na album');
@define('PLUGIN_CPGS_ALBUM_DESC', 'Přiložit odkaz na album pod náhled obrázku');
@define('PLUGIN_CPGS_GALLLINK_NAME', 'URL odkaz na galerii');
@define('PLUGIN_CPGS_GALLLINK_DESC', 'URL adresa - odkaz pod náhledy (prázdné = žádný odkaz)');
@define('PLUGIN_CPGS_GALLNAME_NAME', 'Název galerie');
@define('PLUGIN_CPGS_GALLNAME_DESC', 'Text pro odkaz na galerii');
@define('PLUGIN_CPGS_COUNT_NAME', 'Náhledy');
@define('PLUGIN_CPGS_COUNT_DESC', 'Počet zobrazených náhledů');
@define('PLUGIN_CPGS_SIZE_NAME', 'Velikost');
@define('PLUGIN_CPGS_SIZE_DESC', 'Maximální velikost náhledů');
@define('PLUGIN_CPGS_THUMB_NAME', 'Zpracovat i ne-obrázky?');
@define('PLUGIN_CPGS_THUMB_DESC', 'Pokusí se nalézt náhledy generované galerií Coppermine i pro ne-obrázky (videa apod.)');
@define('PLUGIN_CPGS_FILTER_NAME', 'Filtr alb');
@define('PLUGIN_CPGS_FILTER_DESC', 'Třídit alba podle:');
@define('PLUGIN_CPGS_RECENT', 'Nejnovější');
@define('PLUGIN_CPGS_POPULAR', 'Nejčastěji zobrazované');
@define('PLUGIN_CPGS_RANDOM', 'Náhodné');

@define('PLUGIN_SIDEBAR_MEDIASIDEBAR_NAME', 'Zobrazení Knihovny médií v postranním sloupci');
@define('PLUGIN_SIDEBAR_MEDIASIDEBAR_DESC', 'Zobrazit náhodný obrázek z Knihovny médií Serendipity v postranním sloupci. (Pozor, nerozlišuje mezi typy souborů, neodlišuje obrázky a jiné soubory!)');
@define('PLUGIN_SIDEBAR_MEDIASIDEBAR_DIRECTORY_NAME', 'Výchozí adresář');
@define('PLUGIN_SIDEBAR_MEDIASIDEBAR_DIRECTORY_DESC', 'Vyberte výchozí adresář, plugin bude vyhledávat obrázky pouze v něm.');
#@define('PLUGIN_SIDEBAR_MEDIASIDEBAR_IMAGESTRICT_NAME', 'Nerekurzivní zobrazování obrázků');
#@define('PLUGIN_SIDEBAR_MEDIASIDEBAR_IMAGESTRICT_DESC', 'Pokud je "Ano", budou se zobrazovat pouze obrázky z aktuálního adresáře. Pokud je "Ne", pak se budou zobrazovat obrázky i ze všech podadresářů.');
@define('PLUGIN_SIDEBAR_MEDIASIDEBAR_LINKBEHAVIOR_NAME', 'Chování odkazu');
@define('PLUGIN_SIDEBAR_MEDIASIDEBAR_LINKBEHAVIOR_DESC', '"Ve stránce" otevře obrázek ve stávajícím okně. "Vyskakovací okno" - obrázek bude otevřen v novém, velikostně přizpůsobeném okně. "URL" umožňuje zadat statickou url adresu jako cíl odkazu. "Galerie" povede na stálou adresu (permalink) pluginu usergallery (pokud je nainstalován).');
@define('PLUGIN_SIDEBAR_MEDIASIDEBAR_LINKBEHAVIOR_INPAGE', 'Ve stránce');
@define('PLUGIN_SIDEBAR_MEDIASIDEBAR_LINKBEHAVIOR_POPUP', 'Vyskakovací okno');
@define('PLUGIN_SIDEBAR_MEDIASIDEBAR_LINKBEHAVIOR_URL', 'URL adresa');
@define('PLUGIN_SIDEBAR_MEDIASIDEBAR_LINKBEHAVIOR_GALLERY', 'Galerie');
@define('PLUGIN_SIDEBAR_MEDIASIDEBAR_LINKBEHAVIOR_ENTRY', 'Odkaz na příbuzný příspěvek');

@define('PLUGIN_SIDEBAR_MEDIASIDEBAR_WIDTH_NAME', 'Šířka obrázku');
#@define('PLUGIN_SIDEBAR_MEDIASIDEBAR_WIDTH_DESC', 'Zadat pevnou šířku obrázku. Pokud je zadána nula, plugin obrázku zadá "width: 100%"');
@define('PLUGIN_SIDEBAR_MEDIASIDEBAR_URL_NAME', 'URL');
@define('PLUGIN_SIDEBAR_MEDIASIDEBAR_URL_DESC', 'Stálá URL adresa, na kterou má vést odkaz. (např. "https://www.example.org/")');
@define('PLUGIN_SIDEBAR_MEDIASIDEBAR_GALPERM_NAME', 'Zadejte stálý odkaz (permalink) nebo podstránku');
@define('PLUGIN_SIDEBAR_MEDIASIDEBAR_GALPERM_DESC', 'Tato hodnota se musí shodovat s hodnotou zadanou v pluginu "galerie". Pamatujte, že pokud je vypnuté přepisování URL adresy (url rewrite), musíte použít podstránku.');
@define('PLUGIN_SIDEBAR_MEDIASIDEBAR_INTRO', 'Libovolný text (html značky povoleny), který má být před obrázkem');
@define('PLUGIN_SIDEBAR_MEDIASIDEBAR_SUMMERY', 'Libovolný text (html značky povoleny), který bude připojený za obrázek');
@define('PLUGIN_SIDEBAR_MEDIASIDEBAR_ROTATETIME_NAME', 'Perioda výměny obrázků');
#@define('PLUGIN_SIDEBAR_MEDIASIDEBAR_ROTATETIME_DESC', 'Jak často mají být vyměňovány obrázky. V minutách. Hodnota "0" znamená obměnu při každém načtení stránky.');
@define('PLUGIN_SIDEBAR_MEDIASIDEBAR_NUMIMAGES_NAME', 'Počet zobrazených obrázků');
#@define('PLUGIN_SIDEBAR_MEDIASIDEBAR_NUMIMAGES_DESC', 'Kolik obrázků se má zobrazovat?');
@define('PLUGIN_SIDEBAR_MEDIASIDEBAR_HOTLINKS_NAME', 'Omezit pouze na hotlink obrázky');
@define('PLUGIN_SIDEBAR_MEDIASIDEBAR_HOTLINKS_DESC', 'Tato volba omezuje zobrazování obrázků v postranním sloupci pouze na ty, které jsou v Knihovně médií označeny jako hotlink (nejsou uložené na vašem blogu, ale jedná se pouze na odkazy na cizí servery).');
@define('PLUGIN_SIDEBAR_MEDIASIDEBAR_HOTLINKBASE_NAME', 'Klíčové slovo');
@define('PLUGIN_SIDEBAR_MEDIASIDEBAR_HOTLINKBASE_DESC', 'Vstupem pro tuto funkci je jediné klíčové slovo (bez mezer). Funkce omezuje zobrazování pouze na obrázky obsahující zadané slovo. Např. pokud máte hotlinky z více zdrojů, ale chcete zobrazovat pouze ty pocházející z jednoho zdroje, můžete sem napsat například "zdroj.cz".');

@define('PLUGIN_CPGS_GROUP_NAME', 'Uživatelská skupina (usergroup)');
@define('PLUGIN_CPGS_GROUP_DESC', 'Coppermine umožňuje omezit zobrazení obrázků pouze na zadanou skupinu uživatelů. Pokud potřebujete zobrazovat pouze některé obrázky, zadejte uživatelskou skupinu, za kterou se bude tento plugin maskovat. "Everybody" znamená, že nastavení uživatelské skupiny bude ignorováno.');

