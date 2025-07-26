<?php

/**
 * @author Vladimír Ajgl <vlada@ajgl.cz>
 * @translated 2009/05/28
 * @author Vladimír Ajgl <vlada@ajgl.cz>
 * @revisionDate 2011/06/19
 * @author Vladimír Ajgl <vlada@ajgl.cz>
 * @revisionDate 2012/05/13
 */

@define('PLUGIN_PODCAST_NAME', 'Podcasting plugin');
@define('PLUGIN_PODCAST_DESC', 'Přidává "podcastovací" možnosti (RSS zapouzdření, přehrávač videa a/nebo hudby)');
@define('PLUGIN_PODCAST_EASY', 'Jednoduché nastavení:');
@define('PLUGIN_PODCAST_USEPLAYER', 'Zobrazit přehrávač');
@define('PLUGIN_PODCAST_USEPLAYER_DESC', 'Má se generovat HTML kód pro přehrávání podcastů místo jednoduchého odkazu na soubor multimédia?');
@define('PLUGIN_PODCAST_AUTOSIZE', 'Přizpůsobit velikost přehrávače');
@define('PLUGIN_PODCAST_AUTOSIZE_DESC', 'Snaží se určit rozměry videa a přizpůsobit jim rozměry přehrávače. Nastavení šířky a výšky budou ingorována.');
@define('PLUGIN_PODCAST_WIDTH', 'Šířka');
@define('PLUGIN_PODCAST_WIDTH_DESC', 'Šířka přehrávače');
@define('PLUGIN_PODCAST_HEIGHT', 'Výška');
@define('PLUGIN_PODCAST_HEIGHT_DESC', 'Výška přehrávače');
@define('PLUGIN_PODCAST_ALIGN', 'Zarovnání');
@define('PLUGIN_PODCAST_ALIGN_DESC', 'Zarovnání přehrávače k okolnímu textu');
@define('PLUGIN_PODCAST_ALIGN_LEFT', 'doleva');
@define('PLUGIN_PODCAST_ALIGN_RIGHT', 'doprava');
@define('PLUGIN_PODCAST_ALIGN_CENTER', 'na střed');
@define('PLUGIN_PODCAST_ALIGN_NONE', 'žádné');
@define('PLUGIN_PODCAST_FIRSTMEDIAONLY', 'Vložit první multimediální soubor pouze jako RSS zapouzdření');
@define('PLUGIN_PODCAST_FIRSTMEDIAONLY_DESC', 'Specifikace standardu RSS umožňuje vložit pouze jedno zapouzdření u každého příspěvku. Pokud je tato volba "Ano", pak bude respektován výše zmíněný standard RDD a pouze první nalezený multimediální soubor bude vložen do RSS kanálu.');

@define('PLUGIN_PODCAST_EXTATTRSETTINGS', 'Podcastování pomocí rozšířených parametrů příspěvku:');
@define('PLUGIN_PODCAST_EXTATTR', 'Rozšířující parametry příspěvku');
@define('PLUGIN_PODCAST_EXTATTR_DESC', 'Zde můžete určit, které rozšiřující parametry mají být zpracovávány jako multimediální přílohy článku a které tedy budou vkládány do RSS. Pište seznam čárkou oddělených jmen parametrů. Pro tuto funkci je třeba mít nainstalovaný plugin "Rozšířené parametry příspěvku".');

@define('PLUGIN_PODCAST_EXTPOS', 'Poloha multimédiálních souborů nalezených v rozšířených parametrech příspěvku.');
@define('PLUGIN_PODCAST_EXTPOS_DESC', 'Určete, jakým způsobem mají být vřazeny multimediální soubory do příspěvku.');
@define('PLUGIN_PODCAST_EXTPOS_NONE', 'Nevkládat do příspěvku');
@define('PLUGIN_PODCAST_EXTPOS_BT', 'Začátek příspěvku');
@define('PLUGIN_PODCAST_EXTPOS_BB', 'Konec příspěvku');
@define('PLUGIN_PODCAST_EXTPOS_ET', 'Začátek rozšířené textové části');
@define('PLUGIN_PODCAST_EXTPOS_EB', 'Konec rozšířené textové části');

@define('PLUGIN_PODCAST_EXPERT', 'Pokročilá nastavení:');
@define('PLUGIN_PODCAST_QTEXT', 'Quicktime přípony');
@define('PLUGIN_PODCAST_QTEXT_DESC', 'Typy souborů, které je schopný přehrát Quick Time Player.');
@define('PLUGIN_PODCAST_WMEXT', 'Windows Media Player přípony');
@define('PLUGIN_PODCAST_WMEXT_DESC', 'Typy souborů, které je schopný přehrát Windows Media Player.');

@define('PLUGIN_PODCAST_AUEXT', 'Quicktime miniplayer audio přípony');
@define('PLUGIN_PODCAST_AUEXT_DESC', 'Typy zvukových souborů, které je schopný přehrát Quick Time Miniplayer.');

@define('PLUGIN_PODCAST_USECACHE', 'Cachování');
@define('PLUGIN_PODCAST_USECACHE_DESC', 'Má se použít cashování pro zapamatování informací nalezených podcastů? Při použití cachování je nutní analyzovat obsah souborů pouze jednou. (Doporučená volba!)');
@define('PLUGIN_PODCAST_JS_OPTIMIZATION', 'Optimalizace JavaScriptu');
@define('PLUGIN_PODCAST_JS_OPTIMIZATION_DESC','Pokud je zapnutá, JavaScripty jsou do stránky přidávány pouze v případě potřeby. Pokud používáte cachování příspěvků, MUSÍTE tuto volbu VYPNOUT!');

@define('PLUGIN_PODCAST_ASURE_FEEDENC', 'Ujistit se o zapouzdření multimédia do RSS kanálu');
@define('PLUGIN_PODCAST_ASURE_FEEDEENC_DESC', 'Zajistí vložení média do RSS kanálu jako "zapouzdření" i v případě, že není zobrazeno v příspěvku');

@define('PLUGIN_PODCAST_HTTPREL', 'Relativní HTTP adresa pluginu');
@define('PLUGIN_PODCAST_HTTPREL_DESC', 'Napište relativní cestu k pluginu vzhledem k základnímu adresáři blogu. Pokud jste nezměnili strukturu stálých odkazů (permalinků) a pokud Váš blog neběží na serveru v podadresáři, pak by vše mělo fungovat s výchozím nastavením.');

@define('PLUGIN_PODCAST_USAGE', 
'Skenuje příspěvky na přítomnost odkazů na multimediální soubory (video, audio) a nahrazuje je HTML kódem, který zobrazí soubor v přehrávači multimédií. Toto ulehčuje vytváření objektů přehrávače, jednoduše tím, že stačí napsat odkaz na soubor (např. video) nebo ho vybrat z mediatéky. Navíc plugin vkládá multimediální soubory do RSS kanálu způsobem, který umožňuje RSS čtečkám zobrazit je jako podcasty. /Klíčové slovo: Zapouzdřovací tagy / Enclosure Tags).');

// Next lines were translated on 2011/06/19

@define('PLUGIN_PODCAST_EXPERT_HINT', 'TIP: Pomocí HTML značek si můžete přizpůsobit LIBOVOLNÝ přehrávač, takže můžete zadat seznam různých variant přehrávače pro různé typy souborů! Pamatujte, že jak jednou uložíte nastavení pluginu, bude vždy použito statické značkování <strong>namísto</strong> toho, které plugin poskytuje pomocí souboru <strong>podcast_player.php</strong>. Pokud chcete resetovat nastavení na výchozí hodnoty, jednoduše vymažte veškerý obsah pole pro značkování pluginu a uložte nastavení.');
@define('PLUGIN_PODCAST_QTEXT_HTML', 'Značkování přehrávače Quicktime');
@define('PLUGIN_PODCAST_WMEXT_HTML', 'Značkování Windows Media Player');
@define('PLUGIN_PODCAST_AUEXT_HTML', 'Značkování Quicktime.');

@define('PLUGIN_PODCAST_HTML5_AUDIO', 'HTML5 audio rozšíření');
@define('PLUGIN_PODCAST_HTML5_AUDIO_DESC', 'Moderní prohlížeče nativně podporují HTML5 widgety.');
@define('PLUGIN_PODCAST_HTML5_AUDIO_HTML', 'Značkování HTML5 audio');
@define('PLUGIN_PODCAST_HTML5_VIDEO', 'HTML5 vedio rozšíření');
@define('PLUGIN_PODCAST_HTML5_VIDEO_DESC', 'Moderní prohlížeče nativně podporují HTML5 widgety.');
@define('PLUGIN_PODCAST_HTML5_VIDEO_HTML', 'Značkování HTML5 video');
@define('PLUGIN_PODCAST_USAGE_RSS', 'Pro omezení RSS kanálů na pouze specifikované typy můžete přistupovat ke kanálu pomocí URL jako http://' . $serendipity['baseURL'] . 'rss.php?version=2.0&podcast_format=ogg.
Toto nastavení například vloží do kanálu pouze soubory formátu "ogg". Můžete určit více formátů oddělených čárkou ",".');
@define('PLUGIN_PODCAST_ITUNES', 'Značkování iTunes XML');
@define('PLUGIN_PODCAST_ITUNES_DESC', 'Zadejte XML, které má být vložení do RSS-kanálu, aby se zobrazovalo v iTunes.');
@define('PLUGIN_PODCAST_MERGEMULTI', 'Sloučit více elementů HTML5 přehrávače');
@define('PLUGIN_PODCAST_DOWNLOADLINK', 'Vždy připojit odkaz na stažení');
@define('PLUGIN_PODCAST_DOWNLOADLINK_DESC','Pokud je vypnuto, můžete přidat vlastní prizpůsobený odkaz na stažení do značek přehrávače.');

// Next lines were translated on 2012/05/13
@define('PLUGIN_PODCAST_NOPODCASTING_CLASS','Ignorovat CSS třídy');
@define('PLUGIN_PODCAST_NOPODCASTING_CLASS_DESC','Pokud mají odkazy na média zadanou tuto CSS třídu, pak budou ignorovány (tyto odkazy nebudou nahrazovány přehrávačem a nebudou se zobrazovat v RSS kanálu).');

