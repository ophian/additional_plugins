<?php

/**
 *  @author Vladim�r Ajgl <vlada@ajgl.cz>
 *  @translated 2013/04/05
 */
@define('PLUGIN_EVENT_COMMENTSPICE_TITLE', 'Koment��ov� ko�en�');
@define('PLUGIN_EVENT_COMMENTSPICE_DESC',  'Oko�e�te formul�� pro zad�n� koment��� pomoc� twitteru komentuj�c�ho, odkazem na posledn� �l�nek nebo pravidly pro ne-sledov�n�.');
@define('PLUGIN_EVENT_COMMENTSPICE_CONFIG_HINTBEE', '<strong>UPOZORN�N� K AKTUALIZACI!</strong>: Antispamov� ochrana vytahuj�c� se ke komnt���m byla p�esunuta do samostatn�ho pluginu "Spamblock Bee". Pokud tedy chcete pou��t Honeypot, kter� zde byl d��ve implementov�n, nainstalujte si pros�m tento nov� plugin.');

@define('PLUGIN_EVENT_COMMENTSPICE_CONFIG_TWITTERNAME', 'Twitterov� jm�no');
@define('PLUGIN_EVENT_COMMENTSPICE_CONFIG_ANNOUNC_RSS', 'Oznamovat posledn� p��sp�vky');
@define('PLUGIN_EVENT_COMMENTSPICE_CONFIG_GENERAL', 'Obecn� nastaven�');

@define('PLUGIN_EVENT_COMMENTSPICE_TWITTERINPUT', 'Povol� komentuj�c�m p�idat ke koment��i jejich twitterov� jm�no');
@define('PLUGIN_EVENT_COMMENTSPICE_TWITTERINPUT_DESC', 'Pokud je povoleno, komentuj�c� mohou zadat sv� twitterov� jm�no, po kter�m bude odkaz na jejich twitterovou �asovou osu.');
@define('PLUGIN_EVENT_COMMENTSPICE_TWITTERINPUT_NOFOLLOW', 'Nastavit "nofollow" pro twitter');
@define('PLUGIN_EVENT_COMMENTSPICE_TWITTERINPUT_NOFOLLOW_DESC', 'Pokud je nastaven� nesledov�n�, vyhled�va�e budou ignorovat odkaz na �asovou osu na twitteru. To bude m�n� zaj�mav� pro ru�n� koment��ov� spamery, ale ned� to vyhled�va��m odkaz na skute�n� koment�tory.');
@define('PLUGIN_EVENT_COMMENTSPICE_FOLLOWME_WIDGET', 'Zobrazit twitter followme widget');
@define('PLUGIN_EVENT_COMMENTSPICE_FOLLOWME_WIDGET_DESC', 'Pokud je tato volba zapnuta, bude se m�sto vlastn�ho textu zobrazovat p�kn� origin�ln� twitterovsk� widget "followme". A�koliv to bude vypadat hezky, zpomal� to vykreslov�n� str�nky, proto�e mus� b�t na�ten pro ka�d� koment��. Pokud je vkl�d�n� followme �e�eno pomoc� smarty, bude se tato volba p�ep�nat podle toho, jestli $comment.spice_twitter_followme n�co obsahuje nebo ne.');
@define('PLUGIN_EVENT_COMMENTSPICE_FOLLOWME_WIDGET_COUNT',  'Zobrazovat po�et follower�');
@define('PLUGIN_EVENT_COMMENTSPICE_FOLLOWME_WIDGET_COUNT_DESC',    'Pokud je zapnuto, widget bude zobrazovat po�et follower� komentuj�c�ho.');
@define('PLUGIN_EVENT_COMMENTSPICE_FOLLOWME_WIDGET_DARK',          'Tmav� pozad� widgetu');
@define('PLUGIN_EVENT_COMMENTSPICE_FOLLOWME_WIDGET_DARK_DESC',     'Pokud V� styl vzhledu pou��v� tmav� pozad�, je z�ejm� dobr� n�pad toto zapnout.');
@define('PLUGIN_EVENT_COMMENTSPICE_ANNOUNCE_RSS', 'Povolit komentuj�c�m oznamov�n� ned�vn�ch p��sp�vk�');
@define('PLUGIN_EVENT_COMMENTSPICE_ANNOUNCE_RSS_DESC', 'Kdy� komentuj�c� zad� svoji domovskou str�nku, pugin comment spice zkontroluje RSS kan�l na t�to str�nce. Pokud existuje, m��e komentuj�c� vybrat jeden z ned�vn�ch �l�nk�, kter� bude inzerov�n spole�n� s jeho koment��em.');
@define('PLUGIN_EVENT_COMMENTSPICE_ANNOUNCE_RSS_NOFOLLOW', 'Nastavit odkazy na ned�vn� �l�nky jako "nofollow"');
@define('PLUGIN_EVENT_COMMENTSPICE_ANNOUNCE_RSS_NOFOLLOW_DESC', 'Pokud je nastaven� nesledov�n�, vyhled�va�e budou ignorovat odkaz na ned�vn� p��sp�vky. To bude m�n� zaj�mav� pro ru�n� koment��ov� spamery, ale ned� to vyhled�va��m odkaz na skute�n� koment�tory.');
@define('PLUGIN_EVENT_COMMENTSPICE_ANNOUNCE_RSS_MAXSELECT', 'Maxim�ln� po�et inzerovan�ch �l�nk�');
@define('PLUGIN_EVENT_COMMENTSPICE_ANNOUNCE_RSS_MAXSELECT_DESC', 'Kolik ned�vn�ch �l�nk� m��e komentuj�c� maxim�ln� inzerovat se sv�m koment��em?');
@define('PLUGIN_EVENT_COMMENTSPICE_ANNOUNCE_RSS_ONCEONLY', 'Inzerovat ned�vn� �l�nek pouze jednou na jedn� str�nce blogu');
@define('PLUGIN_EVENT_COMMENTSPICE_ANNOUNCE_RSS_ONCEONLY_DESC', 'Tato volba umo��uje komentuj�c�mu inzerovat ka�d� sv�j �l�nek na str�nce blogu pouze jednou. (U prvn�ho koment��e si m��e vybrat v�echny �l�nky, u druh�ho v�echny krom� t�ch, kter� inzeroval u prvn�ho koment��e atd.)');
@define('PLUGIN_EVENT_COMMENTSPICE_ANNOUNCE_RSS_CACHEMIN', 'Po�et minut mezi obnoven�m cache s ned�vn�mi �l�nky');
@define('PLUGIN_EVENT_COMMENTSPICE_ANNOUNCE_RSS_CACHEMIN_DESC', 'V jak�m �asov�m intervalu m� CommentSpice obnovovat informace o ned�vn�ch �l�nc�ch? Nenastavujte zde p��li� vysokou hodinu, jinak se nov� �l�nky budou objevovat se zpo�d�n�m. Jedna a� dv� hodiny (60-120min) je dobr� hodnota. Zad�n�m 0 vypnete cachov�n�.');

@define('PLUGIN_EVENT_COMMENTSPICE_CONFIG_RULES', 'Pravidla');
@define('PLUGIN_EVENT_COMMENTSPICE_RULE_EXTRAS_COMMENTCOUNT', 'Minim�ln� po�et koment��� nutn� pro povolen� koment��ov�ch extra funkc�');
@define('PLUGIN_EVENT_COMMENTSPICE_RULE_EXTRAS_COMMENTCOUNT_DESC', 'Zadejte po�et koment���, kter� mus� komentuj�c� vlo�it p�edt�m, ne� se mu povol� CommentSpice. 0 znamen�: povolit komukoliv.');
@define('PLUGIN_EVENT_COMMENTSPICE_RULE_EXTRAS_COMMENTLENGTH', 'MInim�ln� d�lka koment��e nutn� pro povolen� koment��ov�ch extra funkc�');
@define('PLUGIN_EVENT_COMMENTSPICE_RULE_EXTRAS_COMMENTLENGTH_DESC', 'Zadejte d�lku koment��e nutnou k zapnut� CommentSpice. 0 znamen�: povolit pro koment��e libovoln� d�lky.');
@define('PLUGIN_EVENT_COMMENTSPICE_RULE_DOFOLLOW_COMMENTCOUNT', 'Minim�ln� po�et koment��� nutn� pro povolen� follow odkaz�');
@define('PLUGIN_EVENT_COMMENTSPICE_RULE_DOFOLLOW_COMMENTCOUNT_DESC', 'Zadejte po�et koment���, kter� mus� komentuj�c� vlo�it p�edt�m, ne� m��e pou��t follow (sledovan�) odkazy. 0 znamen�: povolit komukoliv.');
@define('PLUGIN_EVENT_COMMENTSPICE_RULE_DOFOLLOW_COMMENTLENGTH', 'MInim�ln� d�lka koment��e nutn� pro povolen� follow odkaz�');
@define('PLUGIN_EVENT_COMMENTSPICE_RULE_DOFOLLOW_COMMENTLENGTH_DESC', 'Zadejte d�lku koment��e nutnou k zapnut� follow (sledovan�ch) odkaz�. 0 znamen�: povolit pro koment��e libovoln� d�lky.');
@define('PLUGIN_EVENT_COMMENTSPICE_ENABLED', 'povoleno');
@define('PLUGIN_EVENT_COMMENTSPICE_DISABED', 'zak�z�no');
@define('PLUGIN_EVENT_COMMENTSPICE_RULES', 'pou��t pravidla');

@define('PLUGIN_EVENT_COMMENTSPICE_SMARTIFY_TWITTER', 'Smartifikovat zobrazov�n� twitter jm�na');
@define('PLUGIN_EVENT_COMMENTSPICE_SMARTIFY_TWITTER_DESC', 'Pokud je zapnuto, CommentSpice nebude generovat HTML k�d pro zobrazen� odkazu na twitter, resp. widgetu, ale v�e pot�ebn� vlo�� do prom�nn�ch Smarty. Aby se pak n�co zobrazovalo, mus�te p�idat odpov�daj�c� obsah do �ablony comments.tpl. Dostupn� prom�nn� jsou $comment.spice_twitter_name (twitter jm�no, kontrolujte, jsetli nen� pr�zdn�), $comment.spice_twitter_url (url adresa na �asovou osu twitter), $comment.spice_twitter_nofollow (nastaven� nofollow pro odkazy na twitter), $comment.spice_twitter_icon_html (html vytv��ej�c� twitterovou ikonu), $comment.spice_twitter_followme (html zobrazuj�c� followme widget).');
@define('PLUGIN_EVENT_COMMENTSPICE_PATCHEDINPUT_TWITTER', '�ablona formul��e pro zad�n� koment��� upravena pro zad�n� twitteru');
@define('PLUGIN_EVENT_COMMENTSPICE_PATCHEDINPUT_TWITTER_DESC', 'Zapn�te tuto volbu, pokud jste upravovali �ablonu commentform.tpl, aby obsahovala pol��ko pro zad�n� twitteru na v�mi zvolen�m m�st�. V adres��i pluginu najdete p��klady, jak na to.');
@define('PLUGIN_EVENT_COMMENTSPICE_SMARTIFY_RSS', 'Smartifikovat zobrazen� �l�nk�');
@define('PLUGIN_EVENT_COMMENTSPICE_SMARTIFY_RSS_DESC', 'Pokud je zapnuto, CommentSpice nebude generovat HTML k�d pro zobrazen� ned�vn�ch p��sp�vk�, ale v�e pot�ebn� vlo�� do prom�nn�ch Smarty. Aby se pak n�co zobrazovalo, mus�te p�idat odpov�daj�c� obsah do �ablony comments.tpl. Dostupn� prom�nn� jsou $comment.spice_article_name (nadpisy �l�nk�, kontrolujte, jestli v�bec n�co obsahuj�). $comment.spice_article_url (url adresa �l�nk�), $comment.spice_article_nofollow (nastaven� nofollow pro ned�vn� �l�nky), $comment.spice_article_prefix (p�edpona v jazyku �ten��e).');
@define('PLUGIN_EVENT_COMMENTSPICE_PATCHEDINPUT_RSS', '�ablona formul��e pro zad�n� koment��� upravena pol��kem pro v�b�r �l�nk�');
@define('PLUGIN_EVENT_COMMENTSPICE_PATCHEDINPUT_RSS_DESC', 'Zapn�te tuto volbu, pokud jste upravovali �ablonu commentform.tpl, aby obsahovala pol��ko pro v�b�r ned�vn�ch �l�nk�. V adres��i pluginu najdete p��klady, jak na to.');
@define('PLUGIN_EVENT_COMMENTSPICE_STYLE_RSS', 'Styl ozn�men� o ned�vn�ch �l�nc�ch');
@define('PLUGIN_EVENT_COMMENTSPICE_STYLE_RSS_DESC', 'Plugin vykresl� pol��ko pro v�b�r �l�nk� �ern� s p�knou ikonou apod. Pokud se v�m to tak nel�b�, m��ete toto zobrazov�n� vypnout a ostylovat si pol��ko sami pomoc� vlastn� �ablony.');

@define('PLUGIN_EVENT_COMMENTSPICE_FETCH_PINGBACK', 'Vlo�it obsah pingbackovan�ch �l�nk�');
@define('PLUGIN_EVENT_COMMENTSPICE_FETCH_PINGBACK_DESC', 'Pokud n�jak� ciz� blog po�le tomu va�emu pingback, je zn�m� pouze URL adresa ciz�ho �l�nku. Serendipity um� st�hnout i obsah ciz�ho �l�nku a zobrazit ho, jak to zn�te z odezev (trackback). Jenom z v�konostn�ch d�vod� to Serendipit ned�l� jako v�choz� nastaven�. Pomoc� t�to volby umo�n�te pluginu ulo�it nastaven� do serendipity_config_local.inc.php. Pokud hodnotu nem��ete zm�nit, pak jste u� v minulosti museli zm�n�n� nastaven� p�epsat. V takov�m p��pad� byste m�li vymazat va�e ru�n� nastaven� ze souboru serendipity_config_local.inc.php, aby zm�ny mohl prov�d�t tento plugin.');
@define('PLUGIN_EVENT_COMMENTSPICE_FETCH_PINGBACK_LEAVE_ON', 'Ponechat: stahovat obsah');
@define('PLUGIN_EVENT_COMMENTSPICE_FETCH_PINGBACK_LEAVE_OFF', 'Ponechat: nestahovat obsah');
@define('PLUGIN_EVENT_COMMENTSPICE_FETCH_PINGBACK_FETCH', 'Zm�nit na: stahovat obsah');
@define('PLUGIN_EVENT_COMMENTSPICE_FETCH_PINGBACK_DONTFETCH', 'Zm�nit na: nestahovat obsah');

@define('PLUGIN_EVENT_COMMENTSPICE_PATH', 'Cesta k plugin�m');
@define('PLUGIN_EVENT_COMMENTSPICE_PATH_DESC', 'V b�n�ch instalac�ch je v�choz� hodnota spr�vn�');

@define('PLUGIN_EVENT_COMMENTSPICE_EXPERTSETTINGS', 'Zobrazit pokro�il� nastaven�');
@define('PLUGIN_EVENT_COMMENTSPICE_STANDARDSETTINGS', 'Zobrazit z�kladn� nastaven�');

@define('PLUGIN_EVENT_COMMENTSPICE_PROMOTE_TWITTER', '��st na Twitteru');
@define('PLUGIN_EVENT_COMMENTSPICE_PROMOTE_TWITTER_FOOTER', 'Pokud zad�te <b>twitterov� jm�no</b>, ke koment��i bude p�id�n odkaz na Va�i �asovou osu z twitteru.');
@define('PLUGIN_EVENT_COMMENTSPICE_PROMOTE_TWITTER_PLACEHOLDER', 'twittername nebo jmeno@identi.ca');
@define('PLUGIN_EVENT_COMMENTSPICE_PROMOTE_TWITTER_LABEL', 'Twitter');

@define('PLUGIN_EVENT_COMMENTSPICE_PROMOTE_ARTICLE_LABEL', 'Inzerovat ned�vn� �l�nky');
@define('PLUGIN_EVENT_COMMENTSPICE_PROMOTE_ARTICLE_CHOOSE', '- vyberte �l�nek -');
@define('PLUGIN_EVENT_COMMENTSPICE_PROMOTE_ARTICLE_RECENT', '% p�e o');
@define('PLUGIN_EVENT_COMMENTSPICE_PROMOTE_ARTICLE_FOOTER', '<b>Inzerujte ned�vn� �l�nky</b><br/>Tento blog v�m umo��uje spole�n� s Va��m koment��em inzerovat i n�kter� z posledn�ch �l�nk� na Va�em blogu. Jako domovksou str�nku zadejte p��slu�nou URL adresu Va�eho blogu a objev� se pol��ko, ze kter�ho m��ete vybrat ned�vn� �l�nky. (pot�eba m�t zapnut� Javascript)');
@define('PLUGIN_EVENT_COMMENTSPICE_PROMOTE_ARTICLE_CORRUPTED', 'Je mi l�to, nepoda�ilo se mi st�hnout Va�e "ned�vn� �l�nky"...');

@define('PLUGIN_EVENT_COMMENTSPICE_CONFIG_BOO','Audio koment��e pomoc� audioboo.fm');
@define('PLUGIN_EVENT_COMMENTSPICE_CONFIG_BOO_DESC','Pokud m�te podcastovac� blog, mo�n� chcete umo�nit u�ivatel�m vkl�dat i audio koment��e, tzv. boo audios (mini podcasty) um�st�n� na <a href="http://audioboo.fm" target="_blank">audioboo.fm</a>.');
@define('PLUGIN_EVENT_COMMENTSPICE_BOO_ALLOW','Povolit boo audio koment��e');
@define('PLUGIN_EVENT_COMMENTSPICE_BOO_ALLOW_DESC','Zapn�te, pokud chcete povolit audio boo koment��e. Pod pol��kem pro vlo�en� koment��e se objev� pol��ko pro vlo�en� a nahr�n� (beta funkce!) audio boo koment���.');
@define('PLUGIN_EVENT_COMMENTSPICE_BOO_MODERATE','Schvalovat audio boo koment��e');
@define('PLUGIN_EVENT_COMMENTSPICE_BOO_MODERATE_DESC','Zapn�te, pokud maj� audio boo koment��e podl�hat schvalov�n� p�ed zve�ejn�n�m.');
@define('PLUGIN_EVENT_COMMENTSPICE_BOO_FOOTER','Tento blog V�m umo��uje vlo�it audio boo koment��e pomoc� <a href="http://audioboo.fm/profile" target="_blank">audioboo.fm</a>. <a href="http://audioboo.fm/boos/new" target="_blank">Nahrajte nov� koment��</a> a zadejte odkaz do pol��ka audio boo.');
@define('PLUGIN_EVENT_COMMENTSPICE_BOO_PLACEHOLDER', 'http://audioboo.fm/boos/123456-nadpis');
@define('PLUGIN_EVENT_COMMENTSPICE_BOO_WRONG', 'Je mi l�to, toto nevypad� jako boo URL (http://audioboo.fm/boos/12345-nadpis)');
@define('PLUGIN_EVENT_COMMENTSPICE_BOO_MODERATED', 'Audio boo koment��e podl�haj� schv�len� p�ed zve�ejn�n�m, pros�me o trp�livost.');

@define('PLUGIN_EVENT_COMMENTSPICE_REQUIREMENTS', 'Po�adavky');
@define('PLUGIN_EVENT_COMMENTSPICE_REQUIREMENTS_COMMENTCOUNT', '%s napsan�ch koment���');
@define('PLUGIN_EVENT_COMMENTSPICE_REQUIREMENTS_COMMENTLEN', 'nejm�n� %s znak� v koment��i');

