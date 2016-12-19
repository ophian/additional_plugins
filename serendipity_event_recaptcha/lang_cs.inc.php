<?php

/**
 *  @author Vladim�r Ajgl <vlada@ajgl.cz>
 *  @translated 2009/06/22
 *  @author Vladim�r Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2013/04/21
 */

@define('PLUGIN_EVENT_RECAPTCHA_TITLE', 'Recaptcha');
@define('PLUGIN_EVENT_RECAPTCHA_DESC', 'P�i vkl�d�n� koment��� pou��v� syst�m kryptogram� Recaptcha (je t�eba p�edem za��dat o p��stupov� kl��)');

@define('PLUGIN_EVENT_RECAPTCHA_HIDE', 'Vypnout kryptogramy Recaptcha pro p�ihl�en� u�ivatele');
@define('PLUGIN_EVENT_RECAPTCHA_HIDE_DESC', 'U�ivatel� ve zde vybran�ch skupin�ch mohou pos�lat koment��e, ani� by museli zad�vat Recaptcha kryptogramy');


@define('PLUGIN_EVENT_RECAPTCHA_RECAPTCHA', 'Pou��t kryptogramy Recaptcha');
@define('PLUGIN_EVENT_RECAPTCHA_RECAPTCHA_DESC', 'Pokud je nastaveno, budou pou�ity kryptogramy Recaptcha. To je speci�ln� druh kryptogram�, kter� pom�h� p�i digitalizaci knih. Viz http://www.recaptcha.net. U�ivatel si m��e vybrat, �e m�sto zad�v�n� zobrazen�ch p�smen mu bude p�ehr�na kr�tk� zpr�va obsahuj�c� ��sla, kter� slou�� jako k�d. Pokud nejsou generov�ny ��dn� kryptogramy, server je pravd�podobn� mimo slu�bu.');

@define('PLUGIN_EVENT_RECAPTCHA_RECAPTCHA_STYLE', 'Kter� typ kryptogram� pou��t?');
@define('PLUGIN_EVENT_RECAPTCHA_RECAPTCHA_STYLE_DESC', 'Vyberte jeden z n�sleduj�c�ch typ�: red (�erven�), white (b�l�), blackglass (�ern� sklo). Tato volba funguje pouze s povolen�m javascriptem.');

@define('PLUGIN_EVENT_RECAPTCHA_RECAPTCHA_PUB', 'Ve�ejn� kl�� pro kryptogramy Recaptcha');
@define('PLUGIN_EVENT_RECAPTCHA_RECAPTCHA_PUB_DESC', 'Zadejte ve�ejnou (public) ��st kl��e pro komunikaci se serveren recaptcha.net. O vygenerov�n� p�ru kl��e (ve�ejn� + soukrom� kl��) m��ete po��dat na http://www.recaptcha.net/api/getkey');

@define('PLUGIN_EVENT_RECAPTCHA_RECAPTCHA_PRIV', 'Soukrom� kl�� recaptcha');
@define('PLUGIN_EVENT_RECAPTCHA_RECAPTCHA_PRIV_DESC', 'Zadejte soukromou (private) ��st kl��e pro komunikaci se serveren recaptcha.net. O vygenerov�n� p�ru kl��e (ve�ejn� + soukrom� kl��) m��ete po��dat na http://www.recaptcha.net/api/getkey');

@define('PLUGIN_EVENT_RECAPTCHA_CAPTCHAS_TTL', 'Vynutit kryptogramy po uplynut� kolika dn�?');
@define('PLUGIN_EVENT_RECAPTCHA_CAPTCHAS_TTL_DESC', 'Pou�it� kryptogram� m��e b�t vynuceno v z�vislosti na st��� �l�nk�. Zadejte po�et dn�, po jejich� uplynut� od vyd�n� �l�nku je t�eba zadat kryptogram. Hodnota 0 znamen�, �e kryptogramy budou pou�ity v�dy.');


@define('PLUGIN_EVENT_RECAPTCHA_LOGTYPE', 'Vyberte metodu logov�n�');
@define('PLUGIN_EVENT_RECAPTCHA_LOGTYPE_DESC', 'Odm�tnut� koment��e je mo�n� logovat bu� do datab�ze nebo do textov�ho souboru.');
@define('PLUGIN_EVENT_RECAPTCHA_LOGTYPE_FILE', 'Soubor (viz volba "logfile" n�e)');
@define('PLUGIN_EVENT_RECAPTCHA_LOGTYPE_DB', 'Datab�ze');
@define('PLUGIN_EVENT_RECAPTCHA_LOGTYPE_NONE', 'Nelogovat');

@define('PLUGIN_EVENT_RECAPTCHA_LOGFILE', 'Um�st�n� souboru s logem');
@define('PLUGIN_EVENT_RECAPTCHA_LOGFILE_DESC', 'Informace o odm�tnut�ch/schvalovan�ch p��sp�vc�ch je mo�n� zapisovat do souboru. Zadejte zde pr�zdn� �et�zec pro vypnut� logov�n�.');

@define('PLUGIN_EVENT_RECAPTCHA_ERROR_CAPTCHAS', 'Nezadal(a) jsi spr�vn� �et�zec podle antispamov�ho obr�zku. Pod�vej se na kryptogram pros�m je�t� jednou a zadej spr�vn� hodnoty.');
@define('PLUGIN_EVENT_RECAPTCHA_ERROR_RECAPTCHA', 'Nezadali jste ve�ejn�/soukrom� kl�� v nastaven� kryptogram� recaptcha. Kryptogramy budou vypnuty. Pokud je chcete pou��vat, zadejte pros�m oba dva kl��e v nastaven� pluginu Recaptcha, nebo pou�ijte oby�ejn� kryptogramy (plugin "antispamov� metody").');

@define('PLUGIN_EVENT_RECAPTCHA_INFO1', 'Recaptcha je zvl�tn� druh <a href="http://en.wikipedia.com/wiki/Captcha">kryptogramu</a>. U�ivatel mus� rozpoznat dv� slova. Prvn� syst�mem v�zva-odpov�� (ochrana p�ed spamem), a druh�, kter� pom�h� p�i digitalizaci knih. Nav�c zrakov� posti�en� lid� mohou pou��t audio-kryptogram. Pro v�ce informac� se pod�vejte na str�nku <a href="http://www.recaptcha.net">www.recaptcha.net</a>.<br/>Pamatujte, �e abyste mohli pou��vat tento plugin, mus�te se registrovat na zm�n�n� webov� str�nce.O kl�� m��ete po��dat  <a href="http://www.recaptcha.net/api/getkey?app=serendipity&domain=');
@define('PLUGIN_EVENT_RECAPTCHA_INFO2', '">tady</a>. <br/> Pamatujte tak� pros�m, �e tento plugin se bude p�i ka�d�m koment��i dotazovat serveru recaptcha, a m��e proto zpomalit na��t�n� str�nek. Pokud bude server recaptcha vypnut�, pak nebudou pou�ity ��dn� kryptogramy.');

