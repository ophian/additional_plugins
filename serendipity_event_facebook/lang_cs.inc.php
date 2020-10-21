<?php

/**
 *  @author Vladim�r Ajgl <vlada@ajgl.cz>
 *  @translated 2011/04/17
 *  @author Vladim�r Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2013/04/21
 */

@define('PLUGIN_EVENT_FACEBOOK_NAME', 'Facebook');
@define('PLUGIN_EVENT_FACEBOOK_DESC', 'Importuje do blogu koment��e u p��sp�vk� na facebooku (pomoc� RSS Graffiti). Tak� do blogu vlo�� facebookov� OpenGraph Meta-Tagy. Pamatujte, �e p�id�n� tal��tka "L�b� se mi" k p��sp�vk�m blogu je zaji��ov�no pluginem serendipity_event_social!');

@define('PLUGIN_EVENT_FACEBOOK_HOWTO', 'Koment��e jsou importov�ny k p��sp�vk�m blogu p�i�azen�m URL adresy odkazu na facebook (odkazy mus� b�t ve�ejn�!), pro toto zp�tn� vol�n� je pou�ita nastaven� adresa Serendipity blogu (ko�enov� URL). Tento plugin m��e b�t spu�t�n pomoc� pluginu cronjob, nebo pomoc� ru�n�ho vol�n� cronu (nap�. wget) p�es blog (index.php?/plugin/facebookcomments).');

@define('PLUGIN_EVENT_FACEBOOK_MODERATE', 'Maj� b�t koment��e z facebooku schvalov�ny?');

@define('PLUGIN_EVENT_FACEBOOK_USERS', 'U�ivatelsk� jm�no (jm�na) na facebooku');
@define('PLUGIN_EVENT_FACEBOOK_USERS_DESC', 'Zadejte va�e u�ivatelsk� jm�no nebo ID k facebooku, kter� m� b�t sp�a�en� s blogem. Pamatujte, �e pouze ve�ejn� ��ty/p��sp�vky/koment��e mohou b�t z�sk�ny pomoc� Facebook Graph API. V�ce u�ivatelsk�ch jmen/ID m��e b�t vlo�eno pomoc� odd�lova�e "," (��rka).');

@define('PLUGIN_EVENT_FACEBOOK_VIA', 'Kter� �et�zec se m� p�id�vat k facebookov�m koment���m?');

@define('PLUGIN_EVENT_FACEBOOK_LIMIT', 'Kolik graph API polo�ek se m� stahovat');
@define('PLUGIN_EVENT_FACEBOOK_LIMIT_DESC', 'Zadejte, kolik polo�ek m� vracet Facebook API request. Obvykle sta�� posledn�ch 25 polo�ek. Pokud m�te �asto aktualizovan� facebookov� ��et, mo�n� budete cht�t zv�t�it limit. ��m v�t�� limit bude, t�m d�le bude trvat aktualizace pomoc� graph API.');

@define('PLUGIN_AGGREGATOR_CRONJOB', 'Tento plugin vyu��v� Serendipity plugin Cronjob. Nainstalujte jej, pokud pot�ebujete vyu��vat pravideln� opakovan� aktualizace.');

