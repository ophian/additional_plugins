<?php

/**
 *  @author Vladim�r Ajgl <vlada@ajgl.cz>
 *  @translated 2009/06/04
 */

@define('PLUGIN_EVENT_TEXTLINKADS_TITLE', 'Vlo�en� reklamy (TextLinkAds.com, vlastn�)');
@define('PLUGIN_EVENT_TEXTLINKADS_DESC', 'Vkl�d� reklamy do blogu.');
@define('PLUGIN_EVENT_TEXTLINKADS_INFO', '<p>Je t�eba upravit soubory �ablon *.tpl a zadat, kam maj� b�t vkl�d�ny reklamy, jinak se na blogu reklamy neobjev�. Pou�ijte n�sleduj�c� k�d �ablonovac�ho syst�mu Smarty pro vlo�en� reklam TextLinkAd.com: {serendipity_hookPlugin hook="external_service_tla" hookAll="true"}. Pokud chcete pou��t vlastn� metodu pro vlo�en� textov�ch reklam, pou�ijte tuto funkci Smarty n�sledovn�:</p>
<p>{serendipity_hookPlugin hook="external_service_ad" hookAll="true" data="X:Y"}</p>
<p>V k�du v��e nahra�te "X" jm�nem podadres��e (relativ� cesta vzhledem k adres��i s pluginy - obvykle "plugins/"), kde um�st�te jednotliv� reklamy. Plugin pak v pravideln�ch intervalech dan�ch parametrem "Y" ("weekly", "daily", "hourly", "half-hour", "per-call") projede adres�� a n�hodn� vybere jeden z p��tomn�ch *.html soubor� a zobraz� jeho obsah jako reklamu.</p>
<p>Nap��klad, m�te podadres��e "hlavicky" a "paticky". V podadres��i "hlavicky" m�te soubory "hezka.html", "vtipna.html" a "obrovska.html". V podadres��i "paticky" jsou sobory "obrovska.html" a "hrozna.html". Pak pozm�n�te �ablonu index.tpl tak, �e nahoru vlo��te:</p>
<p>{serendipity_hookPlugin hook="external_service_ad" hookAll="true" data="hlavicky:daily"}</p>
<p>a do ��sti s pati�kou vlo��te n�sleduj�c�:</p>
<p>{serendipity_hookPlugin hook="external_service_ad" hookAll="true" data="paticky:weekly"}</p>
<p>Kdy� pak budete prohl�et blog, uvid�te na m�stech vlo�en� k�du reklamy, kter� se budou m�nit se zadanou frekvenc�. Do HTML soubor� m��ete vlo�it libovoln� HTML k�d (nap�. libovoln� JavaScrip, GoogleAdSense, apod.)');
@define('PLUGIN_EVENT_TEXTLINKADS_HTMLID', '(Pouze TextLinkAds) CSS ID identifik�tor HTML tagu, kter� obsahuje textov� reklamy');
@define('PLUGIN_EVENT_TEXTLINKADS_XMLFILENAME', '(Pouze TextLinkAds) Jm�no lok�ln�ho souboru, pdo ukl�d�n� textov�ch odkaz�');

