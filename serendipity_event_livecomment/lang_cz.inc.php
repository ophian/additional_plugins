<?php

/**
 *  @author Vladim�r Ajgl <vlada@ajgl.cz>
 *  @translated 2009/06/21
 */

@define('PLUGIN_EVENT_LIVECOMMENT_NAME', 'Vylep�en� pol��ko koment���');
@define('PLUGIN_EVENT_LIVECOMMENT_DESC', 'Pou��v� JavaScript k uk�z�n� n�hledu koment��e a zna�kovac� tla��tka');
@define('PLUGIN_EVENT_LIVECOMMENT_VARIANT', 'Zvolte zobrazovac� metodu.');
@define('PLUGIN_EVENT_LIVECOMMENT_VARIANT_DESC', 'Metoda jQuery pou��v� jvascriptov� funkce pro vykreslen� koment��e na obrazovku, a to p�ed formul��em pro posl�n� koment��e. Je rychl� a ve v�t�in� p��pad� odvede svoji pr�ci dob�e, ale podporuje pouze n�kter� formtovac� pluginy (BBCode, Textile, s9y, nl2br, markdown).
Star� metoda pou��v� skute�n� AJAXov� vol�n� pro naform�tov�n� n�hledu koment��e s pou�it�m v�ech dostupn�ch zna�kovac�ch plugin� (Wiki, Emoticons apod.). Tato metoda je n�ro�n�j�� a vkl�d� n�hled na p�esn� m�sto, kde bude koment�� pozd�ji zobrazen.
POZOR: �ablona vzhledu, kterou pou��v�te, mus� pou��vat obvykl� ID a t��dy v CSS, aby fungovala spr�vn� (#serendipity_replyform_*, #serendipity_commentForm apod. v �ablon� commentform.tpl).');
@define('PLUGIN_EVENT_LIVECOMMENT_VARIANT_JQUERY', 'jQuery (pevn� poloha, rychlej�� a hez��)');
@define('PLUGIN_EVENT_LIVECOMMENT_VARIANT_LEGACY', 'Star� metoda (odsazen� pozice, pln� pou�it� zna�kovac�ch plugin�)');
@define('PLUGIN_EVENT_LIVECOMMENT_VARIANT_NONE', '��dn� (vypnout n�hled)');
@define('PLUGIN_EVENT_LIVECOMMENT_PREVIEW_TITLE', 'N�hled');
@define('PLUGIN_EVENT_LIVECOMMENT_BUTTON', 'Form�tovac� tla��tka');
@define('PLUGIN_EVENT_LIVECOMMENT_BUTTON_DESC', 'Um�st� form�tovac� tla��tka nad oblast pro vlo�en� koment��e.');
@define('PLUGIN_EVENT_LIVECOMMENT_PREVIEW_ANIMATION', 'Animace n�hledu');
@define('PLUGIN_EVENT_LIVECOMMENT_PREVIEW_ANIMATION_DESC', 'Kter� animace se m� pou��t z zobrazen� oblasti n�hledu? Vyberte "zobrazit", pokud nechcete pou��t animaci pro oblast n�hledu.');
@define('PLUGIN_EVENT_LIVECOMMENT_PREVIEW_ANIMATION_SPEED', 'Rychlost animace oblasti s n�hledem');
@define('PLUGIN_EVENT_LIVECOMMENT_PREVIEW_ANIMATION_SPEED_DESC', 'Napi�te jedno z kl��ov�ch slov "fast, "def", nebo "slow", anebo napi�te ��slo (kter� zna�� �as v ms).');
@define('PLUGIN_EVENT_LIVECOMMENT_BUTTON_ANIMATION', 'Animace form�tovac�ch tla��tek');
@define('PLUGIN_EVENT_LIVECOMMENT_BUTTON_ANIMATION_DESC', 'Kter� animace se m� pou��t pro zobrazen� form�tovac�ch tla��tek? Vyberte "zobrazit", pokud si nep�ejete animaci pro tla��tka.');
@define('PLUGIN_EVENT_LIVECOMMENT_BUTTON_ANIMATION_SPEED', 'Rychlost animace form�tovac�ch tla��tek');
@define('PLUGIN_EVENT_LIVECOMMENT_BUTTON_ANIMATION_SPEED_DESC', 'Napi�te jedno z kl��ov�ch slov "fast, "def" nebo "slow" nebo zadejte ��slo (kter� zna�� �as v ms).');
@define('PLUGIN_EVENT_LIVECOMMENT_TIMEOUT', 'Prodleva Ajaxu');
@define('PLUGIN_EVENT_LIVECOMMENT_TIMEOUT_DESC', 'Prodleva p�edt�m, ne� jsou zobrazena tla��tka. Vol�n� ajaxu pak mus� b�t kompletn�. Ponechte pr�zdn�, pokud si nejse jisti.');
@define('PLUGIN_EVENT_LIVECOMMENT_ELASTIC', 'Pru�n� pole pro zad�n� koment��e');
@define('PLUGIN_EVENT_LIVECOMMENT_ELASTIC_DESC', 'V p��pad� pot�eby m�n� velikost textov�ho pole pro zad�n� koment��e.');
@define('PLUGIN_EVENT_LIVECOMMENT_BOLD', 'tu�n�');
@define('PLUGIN_EVENT_LIVECOMMENT_ITALIC', 'kurz�va');
@define('PLUGIN_EVENT_LIVECOMMENT_UNDERLINE', 'podtr�en�');
@define('PLUGIN_EVENT_LIVECOMMENT_URL', 'odkaz');
@define('PLUGIN_EVENT_LIVECOMMENT_INLINE', 'Vno�en� JavaScript');
@define('PLUGIN_EVENT_LIVECOMMENT_INLINE_DESC', 'P�id�v� prom�nn� JavaScriptu p��mo do HTML v�stupu - zlep�uje to v�kon blogu');
@define('PLUGIN_EVENT_LIVECOMMENT_PATH', 'Cesta k pluginu');
@define('PLUGIN_EVENT_LIVECOMMENT_PATH_DESC', 'Pokud je zad�na HTTP cesta k pluginu, pak nen� ur�ov�na dynamicky, co� m� v�znamn� vliv na zlep�en� v�konu pluginu. P��klad: http://www.priklad.cz/plugins/serendipity_event_livecomment/ (na konci mus� b�t lom�tko /).');

