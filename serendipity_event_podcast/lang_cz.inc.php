<?php

/**
 * @author Vladim�r Ajgl <vlada@ajgl.cz>
 * @translated 2009/05/28
 * @author Vladim�r Ajgl <vlada@ajgl.cz>
 * @revisionDate 2011/06/19
 * @author Vladim�r Ajgl <vlada@ajgl.cz>
 * @revisionDate 2012/05/13
 */

@define('PLUGIN_PODCAST_NAME', 'Podcasting plugin');
@define('PLUGIN_PODCAST_DESC', 'P�id�v� "podcastovac�" mo�nosti (RSS zapouzd�en�, p�ehr�va� videa a/nebo hudby)');
@define('PLUGIN_PODCAST_EASY', 'Jednoduch� nastaven�:');
@define('PLUGIN_PODCAST_USEPLAYER', 'Zobrazit p�ehr�va�');
@define('PLUGIN_PODCAST_USEPLAYER_DESC', 'M� se generovat HTML k�d pro p�ehr�v�n� podcast� m�sto jednoduch�ho odkazu na soubor multim�dia?');
@define('PLUGIN_PODCAST_AUTOSIZE', 'P�izp�sobit velikost p�ehr�va�e');
@define('PLUGIN_PODCAST_AUTOSIZE_DESC', 'Sna�� se ur�it rozm�ry videa a p�izp�sobit jim rozm�ry p�ehr�va�e. Nastaven� ���ky a v��ky budou ingorov�na.');
@define('PLUGIN_PODCAST_WIDTH', '���ka');
@define('PLUGIN_PODCAST_WIDTH_DESC', '���ka p�ehr�va�e');
@define('PLUGIN_PODCAST_HEIGHT', 'V��ka');
@define('PLUGIN_PODCAST_HEIGHT_DESC', 'V��ka p�ehr�va�e');
@define('PLUGIN_PODCAST_ALIGN', 'Zarovn�n�');
@define('PLUGIN_PODCAST_ALIGN_DESC', 'Zarovn�n� p�ehr�va�e k okoln�mu textu');
@define('PLUGIN_PODCAST_ALIGN_LEFT', 'doleva');
@define('PLUGIN_PODCAST_ALIGN_RIGHT', 'doprava');
@define('PLUGIN_PODCAST_ALIGN_CENTER', 'na st�ed');
@define('PLUGIN_PODCAST_ALIGN_NONE', '��dn�');
@define('PLUGIN_PODCAST_FIRSTMEDIAONLY', 'Vlo�it prvn� multimedi�ln� soubor pouze jako RSS zapouzd�en�');
@define('PLUGIN_PODCAST_FIRSTMEDIAONLY_DESC', 'Specifikace standardu RSS umo��uje vlo�it pouze jedno zapouzd�en� u ka�d�ho p��sp�vku. Pokud je tato volba "Ano", pak bude respektov�n v��e zm�n�n� standard RDD a pouze prvn� nalezen� multimedi�ln� soubor bude vlo�en do RSS kan�lu.');

@define('PLUGIN_PODCAST_EXTATTRSETTINGS', 'Podcastov�n� pomoc� roz���en�ch parametr� p��sp�vku:');
@define('PLUGIN_PODCAST_EXTATTR', 'Roz���uj�c� parametry p��sp�vku');
@define('PLUGIN_PODCAST_EXTATTR_DESC', 'Zde m��ete ur�it, kter� roz�i�uj�c� parametry maj� b�t zpracov�v�ny jako multimedi�ln� p��lohy �l�nku a kter� tedy budou vkl�d�ny do RSS. Pi�te seznam ��rkou odd�len�ch jmen parametr�. Pro tuto funkci je t�eba m�t nainstalovan� plugin "Roz���en� parametry p��sp�vku".');

@define('PLUGIN_PODCAST_EXTPOS', 'Poloha multim�di�ln�ch soubor� nalezen�ch v roz���en�ch parametrech p��sp�vku.');
@define('PLUGIN_PODCAST_EXTPOS_DESC', 'Ur�ete, jak�m zp�sobem maj� b�t v�azeny multimedi�ln� soubory do p��sp�vku.');
@define('PLUGIN_PODCAST_EXTPOS_NONE', 'Nevkl�dat do p��sp�vku');
@define('PLUGIN_PODCAST_EXTPOS_BT', 'Za��tek p��sp�vku');
@define('PLUGIN_PODCAST_EXTPOS_BB', 'Konec p��sp�vku');
@define('PLUGIN_PODCAST_EXTPOS_ET', 'Za��tek roz���en� textov� ��sti');
@define('PLUGIN_PODCAST_EXTPOS_EB', 'Konec roz���en� textov� ��sti');

@define('PLUGIN_PODCAST_EXPERT', 'Pokro�il� nastaven�:');
@define('PLUGIN_PODCAST_QTEXT', 'Quicktime p��pony');
@define('PLUGIN_PODCAST_QTEXT_DESC', 'Typy soubor�, kter� je schopn� p�ehr�t Quick Time Player.');
@define('PLUGIN_PODCAST_WMEXT', 'Windows Media Player p��pony');
@define('PLUGIN_PODCAST_WMEXT_DESC', 'Typy soubor�, kter� je schopn� p�ehr�t Windows Media Player.');
@define('PLUGIN_PODCAST_MFEXT', 'Flash p��pony');
@define('PLUGIN_PODCAST_MFEXT_DESC', 'Typy soubor�, kter� je schopn� p�ehr�t Flash Player.');
@define('PLUGIN_PODCAST_AUEXT', 'Quicktime miniplayer audio p��pony');
@define('PLUGIN_PODCAST_AUEXT_DESC', 'Typy zvukov�ch soubor�, kter� je schopn� p�ehr�t Quick Time Miniplayer.');

@define('PLUGIN_PODCAST_USECACHE', 'Cachov�n�');
@define('PLUGIN_PODCAST_USECACHE_DESC', 'M� se pou��t cashov�n� pro zapamatov�n� informac� nalezen�ch podcast�? P�i pou�it� cachov�n� je nutn� analyzovat obsah soubor� pouze jednou. (Doporu�en� volba!)');
@define('PLUGIN_PODCAST_JS_OPTIMIZATION', 'Optimalizace JavaScriptu');
@define('PLUGIN_PODCAST_JS_OPTIMIZATION_DESC','Pokud je zapnut�, JavaScripty jsou do str�nky p�id�v�ny pouze v p��pad� pot�eby. Pokud pou��v�te cachov�n� p��sp�vk�, MUS�TE tuto volbu VYPNOUT!');

@define('PLUGIN_PODCAST_ASURE_FEEDENC', 'Ujistit se o zapouzd�en� multim�dia do RSS kan�lu');
@define('PLUGIN_PODCAST_ASURE_FEEDEENC_DESC', 'Zajist� vlo�en� m�dia do RSS kan�lu jako "zapouzd�en�" i v p��pad�, �e nen� zobrazeno v p��sp�vku');

@define('PLUGIN_PODCAST_HTTPREL', 'Relativn� HTTP adresa pluginu');
@define('PLUGIN_PODCAST_HTTPREL_DESC', 'Napi�te relativn� cestu k pluginu vzhledem k z�kladn�mu adres��i blogu. Pokud jste nezm�nili strukturu st�l�ch odkaz� (permalink�) a pokud V� blog neb�� na serveru v podadres��i, pak by v�e m�lo fungovat s v�choz�m nastaven�m.');

@define('PLUGIN_PODCAST_USAGE', 
'Skenuje p��sp�vky na p��tomnost odkaz� na multimedi�ln� soubory (video, audio) a nahrazuje je HTML k�dem, kter� zobraz� soubor v p�ehr�va�i multim�di�. Toto uleh�uje vytv��en� objekt� p�ehr�va�e, jednodu�e t�m, �e sta�� napsat odkaz na soubor (nap�. video) nebo ho vybrat z mediat�ky. Nav�c plugin vkl�d� multimedi�ln� soubory do RSS kan�lu zp�sobem, kter� umo��uje RSS �te�k�m zobrazit je jako podcasty. /Kl��ov� slovo: Zapouzd�ovac� tagy / Enclosure Tags).');

// Next lines were translated on 2011/06/19

@define('PLUGIN_PODCAST_EXPERT_HINT', 'TIP: Pomoc� HTML zna�ek si m��ete p�izp�sobit LIBOVOLN� p�ehr�va�, tak�e m��ete zadat seznam r�zn�ch variant p�ehr�va�e pro r�zn� typy soubor�! Pamatujte, �e jak jednou ulo��te nastaven� pluginu, bude v�dy pou�ito statick� zna�kov�n� <strong>nam�sto</strong> toho, kter� plugin poskytuje pomoc� souboru <strong>podcast_player.php</strong>. Pokud chcete resetovat nastaven� na v�choz� hodnoty, jednodu�e vyma�te ve�ker� obsah pole pro zna�kov�n� pluginu a ulo�te nastaven�.');
@define('PLUGIN_PODCAST_QTEXT_HTML', 'Zna�kov�n� p�ehr�va�e Quicktime');
@define('PLUGIN_PODCAST_WMEXT_HTML', 'Zna�kov�n� Windows Media Player');
@define('PLUGIN_PODCAST_MFEXT_HTML', 'Zna�kov�n� Flash player');
@define('PLUGIN_PODCAST_AUEXT_HTML', 'Zna�kov�n� Quicktime.');

@define('PLUGIN_PODCAST_HTML5_AUDIO', 'HTML5 audio roz���en�');
@define('PLUGIN_PODCAST_HTML5_AUDIO_DESC', 'Modern� prohl�e�e nativn� podporuj� HTML5 widgety.');
@define('PLUGIN_PODCAST_HTML5_AUDIO_HTML', 'Zna�kov�n� HTML5 audio');
@define('PLUGIN_PODCAST_HTML5_VIDEO', 'HTML5 vedio roz���en�');
@define('PLUGIN_PODCAST_HTML5_VIDEO_DESC', 'Modern� prohl�e�e nativn� podporuj� HTML5 widgety.');
@define('PLUGIN_PODCAST_HTML5_VIDEO_HTML', 'Zna�kov�n� HTML5 video');
@define('PLUGIN_PODCAST_USAGE_RSS', 'Pro omezen� RSS kan�l� na pouze specifikovan� typy m��ete p�istupovat ke kan�lu pomoc� URL jako http://' . $serendipity['baseURL'] . 'rss.php?version=2.0&podcast_format=ogg.
Toto nastaven� nap��klad vlo�� do kan�lu pouze soubory form�tu "ogg". M��ete ur�it v�ce form�t� odd�len�ch ��rkou ",".');
@define('PLUGIN_PODCAST_ITUNES', 'Zna�kov�n� iTunes XML');
@define('PLUGIN_PODCAST_ITUNES_DESC', 'Zadejte XML, kter� m� b�t vlo�en� do RSS-kan�lu, aby se zobrazovalo v iTunes.');
@define('PLUGIN_PODCAST_MERGEMULTI', 'Slou�it v�ce element� HTML5 p�ehr�va�e');
@define('PLUGIN_PODCAST_DOWNLOADLINK', 'V�dy p�ipojit odkaz na sta�en�');
@define('PLUGIN_PODCAST_DOWNLOADLINK_DESC','Pokud je vypnuto, m��ete p�idat vlastn� prizp�soben� odkaz na sta�en� do zna�ek p�ehr�va�e.');

// Next lines were translated on 2012/05/13
@define('PLUGIN_PODCAST_NOPODCASTING_CLASS','Ignorovat CSS t��dy');
@define('PLUGIN_PODCAST_NOPODCASTING_CLASS_DESC','Pokud maj� odkazy na m�dia zadanou tuto CSS t��du, pak budou ignorov�ny (tyto odkazy nebudou nahrazov�ny p�ehr�va�em a nebudou se zobrazovat v RSS kan�lu).');

