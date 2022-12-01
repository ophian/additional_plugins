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
@define('PLUGIN_PODCAST_DESC', 'Pøidává "podcastovací" mo¾nosti (RSS zapouzdøení, pøehrávaè videa a/nebo hudby)');
@define('PLUGIN_PODCAST_EASY', 'Jednoduché nastavení:');
@define('PLUGIN_PODCAST_USEPLAYER', 'Zobrazit pøehrávaè');
@define('PLUGIN_PODCAST_USEPLAYER_DESC', 'Má se generovat HTML kód pro pøehrávání podcastù místo jednoduchého odkazu na soubor multimédia?');
@define('PLUGIN_PODCAST_AUTOSIZE', 'Pøizpùsobit velikost pøehrávaèe');
@define('PLUGIN_PODCAST_AUTOSIZE_DESC', 'Sna¾í se urèit rozmìry videa a pøizpùsobit jim rozmìry pøehrávaèe. Nastavení ¹íøky a vý¹ky budou ingorována.');
@define('PLUGIN_PODCAST_WIDTH', '©íøka');
@define('PLUGIN_PODCAST_WIDTH_DESC', '©íøka pøehrávaèe');
@define('PLUGIN_PODCAST_HEIGHT', 'Vý¹ka');
@define('PLUGIN_PODCAST_HEIGHT_DESC', 'Vý¹ka pøehrávaèe');
@define('PLUGIN_PODCAST_ALIGN', 'Zarovnání');
@define('PLUGIN_PODCAST_ALIGN_DESC', 'Zarovnání pøehrávaèe k okolnímu textu');
@define('PLUGIN_PODCAST_ALIGN_LEFT', 'doleva');
@define('PLUGIN_PODCAST_ALIGN_RIGHT', 'doprava');
@define('PLUGIN_PODCAST_ALIGN_CENTER', 'na støed');
@define('PLUGIN_PODCAST_ALIGN_NONE', '¾ádné');
@define('PLUGIN_PODCAST_FIRSTMEDIAONLY', 'Vlo¾it první multimediální soubor pouze jako RSS zapouzdøení');
@define('PLUGIN_PODCAST_FIRSTMEDIAONLY_DESC', 'Specifikace standardu RSS umo¾òuje vlo¾it pouze jedno zapouzdøení u ka¾dého pøíspìvku. Pokud je tato volba "Ano", pak bude respektován vý¹e zmínìný standard RDD a pouze první nalezený multimediální soubor bude vlo¾en do RSS kanálu.');

@define('PLUGIN_PODCAST_EXTATTRSETTINGS', 'Podcastování pomocí roz¹íøených parametrù pøíspìvku:');
@define('PLUGIN_PODCAST_EXTATTR', 'Roz¹íøující parametry pøíspìvku');
@define('PLUGIN_PODCAST_EXTATTR_DESC', 'Zde mù¾ete urèit, které roz¹iøující parametry mají být zpracovávány jako multimediální pøílohy èlánku a které tedy budou vkládány do RSS. Pi¹te seznam èárkou oddìlených jmen parametrù. Pro tuto funkci je tøeba mít nainstalovaný plugin "Roz¹íøené parametry pøíspìvku".');

@define('PLUGIN_PODCAST_EXTPOS', 'Poloha multimédiálních souborù nalezených v roz¹íøených parametrech pøíspìvku.');
@define('PLUGIN_PODCAST_EXTPOS_DESC', 'Urèete, jakým zpùsobem mají být vøazeny multimediální soubory do pøíspìvku.');
@define('PLUGIN_PODCAST_EXTPOS_NONE', 'Nevkládat do pøíspìvku');
@define('PLUGIN_PODCAST_EXTPOS_BT', 'Zaèátek pøíspìvku');
@define('PLUGIN_PODCAST_EXTPOS_BB', 'Konec pøíspìvku');
@define('PLUGIN_PODCAST_EXTPOS_ET', 'Zaèátek roz¹íøené textové èásti');
@define('PLUGIN_PODCAST_EXTPOS_EB', 'Konec roz¹íøené textové èásti');

@define('PLUGIN_PODCAST_EXPERT', 'Pokroèilá nastavení:');
@define('PLUGIN_PODCAST_QTEXT', 'Quicktime pøípony');
@define('PLUGIN_PODCAST_QTEXT_DESC', 'Typy souborù, které je schopný pøehrát Quick Time Player.');
@define('PLUGIN_PODCAST_WMEXT', 'Windows Media Player pøípony');
@define('PLUGIN_PODCAST_WMEXT_DESC', 'Typy souborù, které je schopný pøehrát Windows Media Player.');
@define('PLUGIN_PODCAST_MFEXT', 'Flash pøípony');
@define('PLUGIN_PODCAST_MFEXT_DESC', 'Typy souborù, které je schopný pøehrát Flash Player.');
@define('PLUGIN_PODCAST_AUEXT', 'Quicktime miniplayer audio pøípony');
@define('PLUGIN_PODCAST_AUEXT_DESC', 'Typy zvukových souborù, které je schopný pøehrát Quick Time Miniplayer.');

@define('PLUGIN_PODCAST_USECACHE', 'Cachování');
@define('PLUGIN_PODCAST_USECACHE_DESC', 'Má se pou¾ít cashování pro zapamatování informací nalezených podcastù? Pøi pou¾ití cachování je nutní analyzovat obsah souborù pouze jednou. (Doporuèená volba!)');
@define('PLUGIN_PODCAST_JS_OPTIMIZATION', 'Optimalizace JavaScriptu');
@define('PLUGIN_PODCAST_JS_OPTIMIZATION_DESC','Pokud je zapnutá, JavaScripty jsou do stránky pøidávány pouze v pøípadì potøeby. Pokud pou¾íváte cachování pøíspìvkù, MUSÍTE tuto volbu VYPNOUT!');

@define('PLUGIN_PODCAST_ASURE_FEEDENC', 'Ujistit se o zapouzdøení multimédia do RSS kanálu');
@define('PLUGIN_PODCAST_ASURE_FEEDEENC_DESC', 'Zajistí vlo¾ení média do RSS kanálu jako "zapouzdøení" i v pøípadì, ¾e není zobrazeno v pøíspìvku');

@define('PLUGIN_PODCAST_HTTPREL', 'Relativní HTTP adresa pluginu');
@define('PLUGIN_PODCAST_HTTPREL_DESC', 'Napi¹te relativní cestu k pluginu vzhledem k základnímu adresáøi blogu. Pokud jste nezmìnili strukturu stálých odkazù (permalinkù) a pokud Vá¹ blog nebì¾í na serveru v podadresáøi, pak by v¹e mìlo fungovat s výchozím nastavením.');

@define('PLUGIN_PODCAST_USAGE', 
'Skenuje pøíspìvky na pøítomnost odkazù na multimediální soubory (video, audio) a nahrazuje je HTML kódem, který zobrazí soubor v pøehrávaèi multimédií. Toto ulehèuje vytváøení objektù pøehrávaèe, jednodu¹e tím, ¾e staèí napsat odkaz na soubor (napø. video) nebo ho vybrat z mediatéky. Navíc plugin vkládá multimediální soubory do RSS kanálu zpùsobem, který umo¾òuje RSS èteèkám zobrazit je jako podcasty. /Klíèové slovo: Zapouzdøovací tagy / Enclosure Tags).');

// Next lines were translated on 2011/06/19

@define('PLUGIN_PODCAST_EXPERT_HINT', 'TIP: Pomocí HTML znaèek si mù¾ete pøizpùsobit LIBOVOLNÝ pøehrávaè, tak¾e mù¾ete zadat seznam rùzných variant pøehrávaèe pro rùzné typy souborù! Pamatujte, ¾e jak jednou ulo¾íte nastavení pluginu, bude v¾dy pou¾ito statické znaèkování <strong>namísto</strong> toho, které plugin poskytuje pomocí souboru <strong>podcast_player.php</strong>. Pokud chcete resetovat nastavení na výchozí hodnoty, jednodu¹e vyma¾te ve¹kerý obsah pole pro znaèkování pluginu a ulo¾te nastavení.');
@define('PLUGIN_PODCAST_QTEXT_HTML', 'Znaèkování pøehrávaèe Quicktime');
@define('PLUGIN_PODCAST_WMEXT_HTML', 'Znaèkování Windows Media Player');
@define('PLUGIN_PODCAST_MFEXT_HTML', 'Znaèkování Flash player');
@define('PLUGIN_PODCAST_AUEXT_HTML', 'Znaèkování Quicktime.');

@define('PLUGIN_PODCAST_HTML5_AUDIO', 'HTML5 audio roz¹íøení');
@define('PLUGIN_PODCAST_HTML5_AUDIO_DESC', 'Moderní prohlí¾eèe nativnì podporují HTML5 widgety.');
@define('PLUGIN_PODCAST_HTML5_AUDIO_HTML', 'Znaèkování HTML5 audio');
@define('PLUGIN_PODCAST_HTML5_VIDEO', 'HTML5 vedio roz¹íøení');
@define('PLUGIN_PODCAST_HTML5_VIDEO_DESC', 'Moderní prohlí¾eèe nativnì podporují HTML5 widgety.');
@define('PLUGIN_PODCAST_HTML5_VIDEO_HTML', 'Znaèkování HTML5 video');
@define('PLUGIN_PODCAST_USAGE_RSS', 'Pro omezení RSS kanálù na pouze specifikované typy mù¾ete pøistupovat ke kanálu pomocí URL jako http://' . $serendipity['baseURL'] . 'rss.php?version=2.0&podcast_format=ogg.
Toto nastavení napøíklad vlo¾í do kanálu pouze soubory formátu "ogg". Mù¾ete urèit více formátù oddìlených èárkou ",".');
@define('PLUGIN_PODCAST_ITUNES', 'Znaèkování iTunes XML');
@define('PLUGIN_PODCAST_ITUNES_DESC', 'Zadejte XML, které má být vlo¾ení do RSS-kanálu, aby se zobrazovalo v iTunes.');
@define('PLUGIN_PODCAST_MERGEMULTI', 'Slouèit více elementù HTML5 pøehrávaèe');
@define('PLUGIN_PODCAST_DOWNLOADLINK', 'V¾dy pøipojit odkaz na sta¾ení');
@define('PLUGIN_PODCAST_DOWNLOADLINK_DESC','Pokud je vypnuto, mù¾ete pøidat vlastní prizpùsobený odkaz na sta¾ení do znaèek pøehrávaèe.');

// Next lines were translated on 2012/05/13
@define('PLUGIN_PODCAST_NOPODCASTING_CLASS','Ignorovat CSS tøídy');
@define('PLUGIN_PODCAST_NOPODCASTING_CLASS_DESC','Pokud mají odkazy na média zadanou tuto CSS tøídu, pak budou ignorovány (tyto odkazy nebudou nahrazovány pøehrávaèem a nebudou se zobrazovat v RSS kanálu).');

