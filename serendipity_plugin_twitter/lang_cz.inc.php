<?php

/**
 *  @author VladimA�r Ajgl <vlada@ajgl.cz>
 *  @translated 2009/08/08
 *  @author VladimA�r Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2009/08/15
 *  @author VladimA�r Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2009/08/25
 *  @author VladimA�r Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2010/09/28
 *  @author VladimA�r Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2011/03/09
 *  @author Vladim�r Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2012/01/11
 *  @author Vladim�r Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2013/03/31
 *  @author Vladim�r Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2013/10/26
 */
@define('PLUGIN_TWITTER_TITLE',                         'Twitter');
@define('PLUGIN_TWITTER_DESC',                          'Zobrazuje Va�e nejnovej�� pr�spevky na Twitteru');
@define('PLUGIN_TWITTER_NUMBER',                        'Pocet pr�spevku');
@define('PLUGIN_TWITTER_NUMBER_DESC',                   'Kolik pr�spevku z Twitteru m� b�t zobrazeno? (V�choz�: 10)');
@define('PLUGIN_TWITTER_TOALL_ONLY',                    'Pouze tweety adresovan� v�em');
@define('PLUGIN_TWITTER_TOALL_ONLY_DESC',               'Pokud je zapnuto, nebudou se zobrazovat tweety, kter� obsahuj� zavin�c "@" (pouze v PHP verzi)');
@define('PLUGIN_TWITTER_SERVICE',                       'Slu�ba');
@define('PLUGIN_TWITTER_SERVICE_DESC',                  'Vyberte mikroblogovac� slu�bu, kterou pou��v�te');
@define('PLUGIN_TWITTER_USERNAME',                      'U�ivatelsk� jm�no');
@define('PLUGIN_TWITTER_USERNAME_DESC',                 'Pokud m�te adresu http://www.twitter.com/ptak_jarabak, pak je Va�e u�ivatelsk� jm�no ptak_jarabak. Mu�ete pou��t i prihla�ovac� jm�no k indenti.ca.');
@define('PLUGIN_TWITTER_SHOWFORMAT',                    'V�stupn� form�t');
@define('PLUGIN_TWITTER_SHOWFORMAT_DESC',               'Mu�ete si vybrat mezi Javascriptem a PHP. T�k� se vlastn�ho zobrazen� pr�spevku v postrann�m bloku na blogu. Pozor! - JavaScript nebude fungovat s v�ce instancemi pluginu na jedn� str�nce. Mus�te pou��t PHP verzi, pokud ho tak chcete nastavit.');
@define('PLUGIN_TWITTER_SHOWFORMAT_RADIO_JAVASCRIPT',   'Javascript');
@define('PLUGIN_TWITTER_SHOWFORMAT_RADIO_PHP',          'PHP');

@define('PLUGIN_TWITTER_CACHETIME',                     'Jak dlouho cachovat data (pouze pro PHP form�t)');
@define('PLUGIN_TWITTER_CACHETIME_DESC',                'Aby se zamezilo pr�li� velk�mu a zbytecn�mu pren�en� dat mezi blogem a Twitterem, mohou se v�sledky z Twitteru ukl�dat do cache. Zde zadejte v sekund�ch dobu, po kter� se bude aktualizovat obsah cache podle Twitteru.');
@define('PLUGIN_TWITTER_BACKUP',                        'Z�lohovat Tweety? (experiment�ln� funkce, pouze Twitter)');
@define('PLUGIN_TWITTER_BACKUP_DESC',                   'Pokud je povoleno, plugin bude denne stahovat tweety a z�lohovat je v datab�zi blogu (tabulka ' . $serendipity['dbPrefix'] . 'tweets). Vy�aduje PHP5.');

@define('PLUGIN_TWITTER_LINKTEXT',                      'Text odkazu ve tweetech');
@define('PLUGIN_TWITTER_LINKTEXT_DESC',                 'Odkazy nalezen� v Tweetech jsou nahrazeny kliknuteln�m HTML odkazem. Zde nastavte text odkazu. Hodnota $1 bude nahrazena samotn�m odkazem tak, jak to del� Twitter.');
@define('PLUGIN_TWITTER_FOLLOWME_LINK',                 'Odkaz "Sledov�n�"');
@define('PLUGIN_TWITTER_FOLLOWME_LINK_DESC',            'Prid�v� odkaz "sledov�n�" pod casovou osu');
@define('PLUGIN_TWITTER_FOLLOWME_LINK_TEXT',            'Sledov�n�');
@define('PLUGIN_TWITTER_USE_TIME_AGO',                  'Pou��t pohled zpet v case');
@define('PLUGIN_TWITTER_USE_TIME_AGO_DESC',             'Pokud je zapnuto, pak bude cas statutu zobrazen jako cas, kter� uplynul od zad�n� statutu (tak jak to del� samotn� twitter), jinak bude pou��t nastaviteln� form�t data.');

@define('PLUGIN_TWITTER_PROBLEM_TWITTER_ACCESS',        'Probl�m pri pr�stupu na Twitter. <br />Pockejte chvilku a obnovte str�nku...');

// Twitter Event Plugin

@define('PLUGIN_EVENT_TWITTER_NAME',                    'Mikroblogov�n� (Twitter, Identica)');
@define('PLUGIN_EVENT_TWITTER_DESC',                    'Prid�v� klienta Twitter/Identica do administracn� sekce a stahuje nov� tweety a ozn�muje nov� cl�nky na �ctu mikroblogu.');

@define('PLUGIN_EVENT_TWITTER_ACCOUNT_NAME',            'Jm�no �ctu');
@define('PLUGIN_EVENT_TWITTER_ACCOUNT_NAME_DESC',       'Jm�no �ctu, kter�m se bude klient na pozad� prihla�ovat k mikroblogu.');
@define('PLUGIN_EVENT_TWITTER_ACCOUNT_PWD',             'Heslo k �ctu');
@define('PLUGIN_EVENT_TWITTER_ACCOUNT_PWD_DESC',        'Heslo �ctu, kter�m se bude klient na pozad� prihla�ovat k mikroblogu.');

@define('PLUGIN_EVENT_TWITTER_ANNOUNCE_ARTICLES_TITLE', 'Ozn�mov�n� cl�nku');
@define('PLUGIN_EVENT_TWITTER_ANNOUNCE_ARTICLES',       'Oznamovat nov� cl�nky');
@define('PLUGIN_EVENT_TWITTER_ANNOUNCE_ARTICLES_DESC',  'Pokud je zapnuto, plugin bude oznamovat nov� na blogu publikovan� pr�spevky na slu�be Twitter nebo Identica.');
@define('PLUGIN_EVENT_TWITTER_ANNOUNCE_WITHTTAGS',      'Ozn�mit s tagy');
@define('PLUGIN_EVENT_TWITTER_ANNOUNCE_WITHTTAGS_DESC', 'Pokud je nainstalov�n plugin Free Tag (Kl�cov� slova), oznamovac cl�nku prohled� nadpis pr�spevku, jestli neobsahuje tagy. Pokud nejak� nalezne, budou tyto tagy oznacen� jako tagy twitteru. V�dy mu�ete pridat tagy rucne pomoc� #tags#. Tyto budou naplneny v�emi tagy, kter� je�te nebyly nalezeny v nadpisu pr�spevku. To znamen� v�echny zde zadan� tagy budou prid�ny, pokud volba automatick�ho hled�n� tagu nen� zapnuta.');
@define('PLUGIN_EVENT_TWITTER_ANNOUNCE_SERVICE',        'Ozn�mit URL zkracovac');
@define('PLUGIN_EVENT_TWITTER_ANNOUNCE_SERVICE_DESC',   'Slu�ba, kter� m� b�t pou�ita pro zkr�cen� odkazu pri oznamov�n� pr�spevku. Doporucen� jsou 7ax.de nebo tinyurl.com, proto�e to jsou zat�m jedin� zn�m� slu�by, kter� funguj� spolecne s tweetbacks.');

@define('PLUGIN_EVENT_TWITTER_TWEETBACKS_TITLE',        'Tweetbacks');
@define('PLUGIN_EVENT_TWITTER_DO_TWEETBACKS',           'Zji�tovat Tweetbacky');
@define('PLUGIN_EVENT_TWITTER_DO_TWEETBACKS_DESC',      'Pokud je zapnuto, plugin se pokus� naj�t tweetbacky (odezvy twitteru) na cl�nky a prid� volbu "zkontrolovat odezvy twitteru" pod roz��ren� telo pr�spevku, pokud je n�v�tevn�k prihl�en� do blogu.');
@define('PLUGIN_EVENT_TWITTER_IGNORE_MYTWEETBACKS',     'Ignorovat moje Tweety');
@define('PLUGIN_EVENT_TWITTER_IGNORE_MYTWEETBACKS_DESC','Pokud nechcete zobrazovat vlastn� tweety jako tweetbacky, zapnete tuto volbu. V opacn�m pr�pade budou ozn�men� zobrazov�na jako tweetbacky.');

@define('PLUGIN_EVENT_TWITTER_TWEETBACK_CHECK_FREQ',    'Frekvence kontroly tweetbacku');
@define('PLUGIN_EVENT_TWITTER_TWEETBACK_CHECK_FREQ_DESC','Cas v minut�ch mezi dvema kontrolami twitteru. (mus� b�t alespon 5 minut)');
@define('PLUGIN_EVENT_TWITTER_TB_TYPE',                 'Typ tweetbacku');
@define('PLUGIN_EVENT_TWITTER_TB_TYPE_DESC',            'Serendipity nepodporuje sama o sobe tweetbacky. Tak�e ty musej� b�t ulo�eny jako odezvy nebo norm�ln� koment�re. Proto�e prich�zej� z vne blogu, jsou jist�m type odezvy, ale podle obsahu by patrily sp� mezi koment�re. Rozhodnete sami, jak se maj� tweetbacky ukl�dat.');
@define('PLUGIN_EVENT_TWITTER_TB_TYPE_TRACKBACK',       'Odezva');
@define('PLUGIN_EVENT_TWITTER_TB_TYPE_COMMENT',         'Koment�r');

@define('PLUGIN_EVENT_TWITTER_TWEETER_TITLE',           'Mikroblogovac� klient');
@define('PLUGIN_EVENT_TWITTER_TWEETER_SIDEBARTITLE',    'Tweeter');
@define('PLUGIN_EVENT_TWITTER_TWEETER_SHOW',            'Zapnout mikroblogovac�ho klienta');
@define('PLUGIN_EVENT_TWITTER_TWEETER_SHOW_DESC',       'Zapnte tweeter na hlavn� str�nce administracn� sekce, jako postrann� sloupec a nebo ho vypne.');
@define('PLUGIN_EVENT_TWITTER_TWEETER_SHOW_FRONTPAGE',  'Hlavn� str�nka');
@define('PLUGIN_EVENT_TWITTER_TWEETER_SHOW_SIDEBAR',    'Postrann� sloupec');
@define('PLUGIN_EVENT_TWITTER_TWEETER_SHOW_DISABLE',    'Vypnout');
@define('PLUGIN_EVENT_TWITTER_TWEETER_HISTORY',         'Zobrazit casovou osu');
@define('PLUGIN_EVENT_TWITTER_TWEETER_HISTORY_DESC',    'Zobrazuje casovou osu s cl�nky pod aktualizovan�m v�pisem.');
@define('PLUGIN_EVENT_TWITTER_TWEETER_HISTORY_COUNT',   'D�lka casov� osy');
@define('PLUGIN_EVENT_TWITTER_TWEETER_HISTORY_COUNT_DESC','Kolik nejnovej��ch pr�spevku  se m� zobrazovat na hlavn� strane?');

@define('PLUGIN_EVENT_TWITTER_TWEETER_FORM',            'Zadejte tweet:');
@define('PLUGIN_EVENT_TWITTER_TWEETER_CHARSLEFT',       'znaku vlevo');
@define('PLUGIN_EVENT_TWITTER_TWEETER_SHORTEN',         'Zkracovat URL adresy');
@define('PLUGIN_EVENT_TWITTER_TWEETER_STORED',          'Tweet ulo�en ');
@define('PLUGIN_EVENT_TWITTER_TWEETER_STOREFAIL',       'Tweet nemohl b�t ulo�en! Chyba Twitteru: ');

@define('PLUGIN_EVENT_TWITTER_GENERAL_TITLE',           'Obecn�');
@define('PLUGIN_EVENT_TWITTER_PLUGIN_EVENT_REL_URL',    'Plugin rel. path');
@define('PLUGIN_EVENT_TWITTER_PLUGIN_EVENT_REL_URL_DESC', 'Zadejte celou HTTP cestu (v�echno, co n�sleduje po Va�em dom�nov�m jm�ne), kter� vede do adres�re s pluginem.');

@define('PLUGIN_EVENT_TWITTER_TWEETER_WARNING',         '<p class="msg_error">' .
                '<span class="icon-attention-circled" aria-hidden="true"></span> ' .
                'UPOZORNEN�: Nalezen nainstalovan� plugin TwitterTweeter.</p>' .
                '<p class="msg_error">Tento plugin je sloucen�m pluginu TwitterTweeter a ofici�ln�ho star�ho serendipity pluginu twitter, nav�c oba dva pluginy roz�iruje.Meli byste odinstalovat v�echny predchoz� pluginy.</p>');

@define('PLUGIN_EVENT_TWITTER_TB_USE_URL',              'URL Tweetbacku');
@define('PLUGIN_EVENT_TWITTER_TB_USE_URL_DESC',         'Co ulo�it jako URL adresu tweetbacku? M�te 3 mo�nosti. Status: url tweetu, kter� je tweetbackem, Profil: adresa profilu u�ivatele twitteru nebo WebURL: adresa zadan� u�ivatelem twitteru v jeho profilu jako Web URL');
@define('PLUGIN_EVENT_TWITTER_TB_USE_URL_STATUS',       'Status');
@define('PLUGIN_EVENT_TWITTER_TB_USE_URL_PROFILE',      'Profil');
@define('PLUGIN_EVENT_TWITTER_TB_USE_URL_WEBURL',       'Web URL');

@define('PLUGIN_EVENT_TWITTER_IDENTITIES',              'Identity');
@define('PLUGIN_EVENT_TWITTER_ACCOUNT_IDCOUNT',         'Pocet �ctu');
@define('PLUGIN_EVENT_TWITTER_ACCOUNT_IDCOUNT_DESC',    'Po ulo�en� tohoto nastaven� se na t�to str�nce nastaven� objev� pol�cka pro nastaven� zde zadan�ho poctu �ctu. Mo�n� budete muset nastaven� ulo�it dvakr�t, abyste pr�slu�n� zad�vac� pol�cka videli.');
@define('PLUGIN_EVENT_TWITTER_IDENTITY',                'Identita');
@define('PLUGIN_EVENT_TWITTER_ACCOUNT_SERVICE',         'Jm�no slu�by');
@define('PLUGIN_EVENT_TWITTER_ACCOUNT_SERVICE_DESC',    'Zadejte, zda je tento �cet na twitteru nebo na identi.ca');
@define('PLUGIN_EVENT_TWITTER_ACCOUNT_SERVICE_TWITTER', 'twitter');
@define('PLUGIN_EVENT_TWITTER_ACCOUNT_SERVICE_IDENTICA','identica');

@define('PLUGIN_EVENT_TWITTER_ANNOUNCE_ACCOUNTS',       'Oznamovac� �cty');
@define('PLUGIN_EVENT_TWITTER_ANNOUNCE_ACCOUNTS_DESC',  'Vyberte �cty, na kter� se maj� oznamovat nov� pr�spevky');

// Configuration Tabs:

@define('PLUGIN_EVENT_TWITTER_CFGTAB',                  'Konfiguracn� z�lo�ky:');
@define('PLUGIN_EVENT_TWITTER_CFGTAB_IDENTITIES',       'Identity');
@define('PLUGIN_EVENT_TWITTER_CFGTAB_ANNOUNCE',         'Oznamov�n� cl�nku');
@define('PLUGIN_EVENT_TWITTER_CFGTAB_TWEETER',          'Mikroblogovac� klient');
@define('PLUGIN_EVENT_TWITTER_CFGTAB_TWEETBACK',        'Tweetbacky');
@define('PLUGIN_EVENT_TWITTER_CFGTAB_GLOBAL',           'Obecn�');
@define('PLUGIN_EVENT_TWITTER_CFGTAB_ALL',              'V�echno');

@define('PLUGIN_EVENT_TWITTER_TWEETER_REPLY',           'Odpovedet pisateli');
@define('PLUGIN_EVENT_TWITTER_TWEETER_RETWEET',         'Retweetovat');
@define('PLUGIN_EVENT_TWITTER_TWEETER_DM',              'Pr�m� zpr�va (Pracuje pouze pokud V�s u�ivatel sleduje)');

@define('PLUGIN_EVENT_TWITTER_IGNORE_TWEETBACKS_BYNAME','Ignorovat tweetbacky z');
@define('PLUGIN_EVENT_TWITTER_IGNORE_TWEETBACKS_BYNAME_DESC','C�rkami oddelen� seznam �ctu twitteru, ze kter�ch nechcete prij�mat tweetbacky.');

@define('PLUGIN_TWITTER_EVENT_NOT_INSTALLED',           '<p class="msg_error">' .
                '<span class="icon-attention-circled" aria-hidden="true"></span> ' .
                'VAROV�N�: Plugin ud�lost� pro mikroblogov�n� (twitter/identica) je�te nebyl nainstalov�n!</p>' .
                '<p class="msg_error">Hlavn� c�st funkc� twitter/identica je zabezpecov�na pluginem ud�lost� mikroblogov�n�. Pokud chcete plnou funkcnost pluginu, meli byste ho tak� nainstalovat
.</p>');

@define('PLUGIN_EVENT_TWITTER_ANNOUNCE_FORMAT',         'Form�t ozn�men�');
@define('PLUGIN_EVENT_TWITTER_ANNOUNCE_FORMAT_DESC',    'Zadejte vlastn� form�t oznamovac�ch zpr�v. Mu�ete pou��t n�sleduj�c� promenn�. title#: bude nahrazen nadpisem pr�spevku (a odpov�daj�c�mi tagy); #link#: odkaz na pr�spevek; #author#: Autor pr�spevku; #tags#: zb�vaj�c� tagy.');

@define('PLUGIN_EVENT_TWITTER_CFGTAB_TWEETTHIS',        'Twittni to!');
@define('PLUGIN_EVENT_TWITTER_TWEETTHIS_TITLE',         'Twittni to!');
@define('PLUGIN_EVENT_TWITTER_DO_TWEETTHIS',            'Povolit "Twittni to!"');
@define('PLUGIN_EVENT_TWITTER_DO_TWEETTHIS_DESC',       'Zapnut� t�to funkce zobraz� tlac�tko "Twittni to!" v paticce pr�spevku.');
@define('PLUGIN_EVENT_TWITTER_DO_IDENTICATHIS',         'Zapnout Identica');
@define('PLUGIN_EVENT_TWITTER_DO_IDENTICATHIS_DESC',    'Zapnut� t�to funkce zobraz� tlac�tko "Identica" v paticce pr�spevku.');
@define('PLUGIN_EVENT_TWITTER_TWEETTHIS_FORMAT',        'Form�t "Twittni to!"');
@define('PLUGIN_EVENT_TWITTER_TWEETTHIS_FORMAT_DESC',   'Zadejte form�t pro tweety n�v�tevn�ku. Meli byste pou��t n�sleduj�c� promenn�. title#: bude nahrazen nadpisem pr�spevku (a odpov�daj�c�mi tagy); #link#: odkaz na pr�spevek; #author#: Autor pr�spevku; #tags#: zb�vaj�c� tagy.');
@define('PLUGIN_EVENT_TWITTER_TWEETTHIS_FORMAT_BUTTON', 'Styl tlac�tek');
@define('PLUGIN_EVENT_TWITTER_TWEETTHIS_FORMAT_BUTTON_DESC', 'V soucasnosti je mo�no vybrat mezi dvema styly twittovac�ho tlac�tka.');
@define('PLUGIN_EVENT_TWITTER_TWEETTHIS_FORMAT_BUTTON_BLACK', 'cern�');
@define('PLUGIN_EVENT_TWITTER_TWEETTHIS_FORMAT_BUTTON_WHITE', 'b�l�');

@define('PLUGIN_EVENT_TWITTER_TWEETTHIS_NEWWINDOW',     '"Twittni to!" v nov�m okne');
@define('PLUGIN_EVENT_TWITTER_TWEETTHIS_NEWWINDOW_DESC','Pokud je zapnuto, twitter a identica se nat�hnou v nov�m okne, v aktu�ln�m okne tedy zustane st�le zobrazen� blog.');
@define('PLUGIN_EVENT_TWITTER_TWEETTHIS_SMARTIFY',      'Smartyfizce funkce "Twittni to!"');
@define('PLUGIN_EVENT_TWITTER_TWEETTHIS_SMARTIFY_DESC', 'Pokud je zapnuto, plugin nebude prid�vat tlac�tko s�m o sobe. M�sto toho prid� do smarty dve promenn�: entry.url_tweetthis a entry.url_dentthis. Ty pak lze pou��t v �ablone. Tyto promenn� obsahuj� pouze URL adresy, tak�e mu�ete vytvorit vlastn� text pro tlac�tko "Twittni to!", nebo tlac�tko um�stit napr�klad do z�hlav� cl�nku.');

@define('PLUGIN_EVENT_TWITTER_BACKEND_DONTANNOUNCE',    'NEoznamovat tento pr�spevek pomoc� mikroblogovac�ch slu�eb');
@define('PLUGIN_EVENT_TWITTER_BACKEND_ENTERDESC',       'Zadejte libovoln� tagy, kter� souvis� s pr�spevkem. V�ce tagu oddelujte c�rkou (,). Pokud je zde neco zad�no, tagy pluginu freetag jsou pri oznamov�n� ignorov�ny!');

// Next lines were translated on 2009/08/15

@define('PLUGIN_TWITTER_FILTER_ALL',                    '��dn� u�ivatelsk� tweety');
@define('PLUGIN_TWITTER_FILTER_ALL_DESC',               'Pokud je volba zapnuta, nebudou se zobrazovat tweety obsahuj�c� @. (pouze v PHP verzi)');
@define('PLUGIN_EVENT_TWITTER_TB_MODERATE',             'Schvalov�n� tweetbacku');
@define('PLUGIN_EVENT_TWITTER_TB_MODERATE_DESC',        'Jak pracovat s prijat�mi tweetbacky? Mu�ete pou��t obecn� nastaven� pro koment�re, schvalovat je, nebo je v�dy povolit.');
@define('PLUGIN_EVENT_TWITTER_TB_MODERATE_DEFAULT',     'Pou��t obecn� nastaven� koment�ru');

// Next lines were translated on 2009/08/25

@define('PLUGIN_EVENT_TWITTER_SHORTURL_TITLE',          'Zobrazit URL adresu pro tento cl�nek');
@define('PLUGIN_EVENT_TWITTER_SHORTURL_ON_CLICK',       'Tento odkaz nen� klikac�. Obsahuje zkr�cenou URL adresu k tomuto pr�spevku. Tuto URL adresu mu�ete pou��t jako odkaz na tento cl�nek, napr�klad v twitteru. Odkaz zkop�rujete tak, �e kliknete prav�m tlac�tkem a vyberete "Zkop�rovat odkaz" v Internet Exploreru, nebo "Kop�rovat adresu odkazu" v Mozille.');
@define('PLUGIN_EVENT_TWITTER_SHOW_SHORTURL',           'Zobrzit kr�tkou URL adresu pro ka�d� pr�spevek');
@define('PLUGIN_EVENT_TWITTER_SHOW_SHORTURL_DESC',      'Bude zobrazovat v�choz� kr�tkou URL v paticce ka�d�ho cl�nku. Pokud je zapnut� funkce smarty TweetThis, ka�d� pr�spevek bude obsahovat promennou entry.url_shorturl, kter� se d� libovolne vyu��t ve smarty �ablone.');

// Next lines were translated on 2010/09/28

@define('PLUGIN_EVENT_TWITTER_CONSUMER_KEY',            'Kl�c z�kazn�ka (Consumer key)');
@define('PLUGIN_EVENT_TWITTER_CONSUMER_KEY_DESC',       '"Z�kaznick� kl�c" a "z�kaznick� heslo" obdr��te od Twitteru pot�, co pro svuj blok vytvor�te aplikaci Twitteru.');
@define('PLUGIN_EVENT_TWITTER_CONSUMER_SECRET',         'Z�kaznick� heslo');
@define('PLUGIN_EVENT_TWITTER_TIMELINE',                'Casov� osa statutu');
@define('PLUGIN_EVENT_TWITTER_TIMELINE_DESC',           '');
@define('PLUGIN_EVENT_TWITTER_VERBINDUNG_OK',           'Pripojeno');
@define('PLUGIN_EVENT_TWITTER_VERBINDUNG_DEL',          'Smazat odkaz');
@define('PLUGIN_EVENT_TWITTER_VERBINDUNG_DEL_OK',       'Twitter OAuth token odstranen');
@define('PLUGIN_EVENT_TWITTER_CLOSEWINDOW',             'Zavr�t okno');
@define('PLUGIN_EVENT_TWITTER_REGISTER',                'Registrovat');
@define('PLUGIN_EVENT_TWITTER_CALLBACKURL',             'Zpetn� URL adresa (zadejte ve Twitteru)');
@define('PLUGIN_EVENT_TWITTER_VERBINDUNG_ERROR',        'Chyba zpetn�ho vol�n� Twitteru');

// Next lines were translated on 2011/03/09

@define('PLUGIN_EVENT_TWITTER_ANNOUNCE_ARTICLES_NO',    'Pro oznamov�n� pr�spevku je ve v�choz�m nastaven� checkbox od�krtnut');
@define('PLUGIN_EVENT_TWITTER_ANNOUNCE_ARTICLES_NO_DESC','Povolen� znamen�, �e nov� pr�spevek na blogu mus� b�t v�slovne odesl�n do twiteru. Vypnut� (v�choz� hodnota) znamen�, �e pr�spevek bude do twiteru odesl�n automaticky.');

// Next lines were translated on 2012/01/11

@define('PLUGIN_EVENT_TWITTER_SIGN_IN',                 'Kliknete na tlac�tko n�e a pripojte Twitter.<br/>
<p><a style="color:red;">VAROV�N�!</a><br/>
Mus�te se prihl�sit nebo odhl�sit s <b>odpov�daj�c�m �ctem Twitteru</b>!<br/>
<a href="#" onclick="window.open(\'http://twitter.com\',\'\',\'width=1000,height=400\'); return false">Potvrdte pros�m pred pripojen�m</a>.</p>');
@define('PLUGIN_EVENT_TWITTER_SIGNIN',                  'Prihl�sit');
@define('PLUGIN_TWITTER_FOLLOWME_WIDGET',               'Widget sledov�n� Twitteru');
@define('PLUGIN_TWITTER_FOLLOWME_WIDGET_DESC',          'Pokud plugin zobrazuje casovou osu, mu�ete povolit widget twitteru pro zobrazov�n� aktu�ln�ho poctu followeru a dal��. Nastaven� je ignorov�no, pokud zobrazujete z identi.ca.');
@define('PLUGIN_TWITTER_FOLLOWME_WIDGET_COUNT',         'Pocet followeru ve widgetu');
@define('PLUGIN_TWITTER_FOLLOWME_WIDGET_COUNT_DESC',    'Pokud je povoleno, widget zobrazuje pocet followeru.');
@define('PLUGIN_TWITTER_FOLLOWME_WIDGET_DARK',          'Widget sledov�n� Twitter na tmav�m pozad�');
@define('PLUGIN_TWITTER_FOLLOWME_WIDGET_DARK_DESC',     'Pokud Va�e �ablona pou��v� tmav� pozad�, meli byste toto povolit.');
@define('PLUGIN_EVENT_TWITTER_ANNOUNCE_BITLYDESC',      '<h3>u�ivatelsk� jm�no bit.ly a API kl�c</h3><b>bit.ly</b> a <b>j.mp</b> zkracovace URL adres potrebuj� prihla�ovac� jm�no k bit.ly a API kl�c. Pokud ani jeden z techto zkracovacu nepou��v�te, nemeli byste je potrebovat.<br/>V�choz� kl�c vet�inou nefunguje, proto�e je to demo kl�c a jeho kv�ta je pravidelne precerp�na. Pokud m�te �cet na bit.ly account, meli byste zadat vlastn� prihla�ovac� �daje.<br/><a href="http://bitly.com/a/your_api_key/" target="_blank" rel="noopener">Najdete je tady</a>.');
@define('PLUGIN_EVENT_TWITTER_ANNOUNCE_BITLYLOGIN',     'U�ivatelsk� jm�no bit.ly');
@define('PLUGIN_EVENT_TWITTER_ANNOUNCE_BITLYAPIKEY',    'bit.ly API kl�c');
@define('PLUGIN_EVENT_TWITTER_GENERALCONSUMER',         '<h3>Vlastn� twitter klient</h3>Ve v�choz�m nastaven� pou��v� plugin klienta \'s9y\'. Mu�ete si <a href="https://dev.twitter.com/apps" target="_blank" rel="noopener">zaregistrovat vlastn�ho klienta</a> a nastavit consumer kl�c a heslo va�eho klienta.');

// Next lines were translated on 2013/03/31

@define('PLUGIN_EVENT_TWITTER_TWEETER_UPDATE',           'Update');
@define('PLUGIN_EVENT_TWITTER_ANNOUNCE_PIRATLYDESC',     '<h3>pirat.ly API token</h3>Pro zkr�cen� odkaz <b>pirat.ly</b> mu�ete <a href="http://pirat.ly/account" target="_blank" rel="noopener">z�skat API token t�m, �e se zdarma registrujete na slu�be piratly</a>. Pou�it�m tohoto API tokenu pri oznamov�n� Va�ich pr�spevku mu�ete prohl�et pocty prokliku bud pomoc� webov�ho rozhran� nebo na zar�zen� s Androidem pomoc� <a href="http://pirat.ly/shortenerrr" target="_blank" rel="noopener">aplikace Shortenerrr</a>.');
@define('PLUGIN_EVENT_TWITTER_ANNOUNCE_PIRATLYAPIKEY',   'V� osobn� piratly API token');
@define('PLUGIN_TWITTER_FILTER_RT',                      'FIltrovat nativn� retweety');
@define('PLUGIN_TWITTER_FILTER_RT_DESC',                 'Maj� se filtrovat nativn� retweety? (pouze pro Twitter API 1.1; API 1.0 filtruje v�dy)');
@define('PLUGIN_TWITTER_API11',                          'Pou��t OAuth Twitter API 1.1');
@define('PLUGIN_TWITTER_API11_DESC',                     'Twitter API 1.0 je zastaral� a behem roku 2013 bude �plne zru�eno. Meli byste se tedy prepnout na API 1.1. Nicm�ne to vy�aduje, abyste nastavili alespon jedno OAuth propojen� v hlavn�m mikroblogovac�m pluginu. Pokud v pol�cku n�e najdete nejak� �cet, u� jste to udelali.');
@define('PLUGIN_TWITTER_OAUTHACC',                       'OAuth �cet, kter� se m� pou��t t�mto pluginem');
@define('PLUGIN_TWITTER_OAUTHACC_DESC',                  'Nov� OAuth Twitter API je treba volat pomoc� OAuthorzied Twitter �ctu. Tento �cet bude tak� pou�it pro omezen� pr�stupu. Mu�ete pou��t libovoln� �cet, kter� vlastn�te, treba �cet, kter� nikde jinde nepou��v�te, napr�klad abyste meli pro tento plugin samostatn� limit pr�stupu.');
@define('PLUGIN_EVENT_TWITTER_API_TYPE',                 'Verze Twitter API');
@define('PLUGIN_EVENT_TWITTER_API_TYPE_DESC',            'Twitter API 1.0 je zastaral� a behem roku 2013 bude �plne zru�eno. Meli byste se tedy prepnout na API 1.1. Nicm�ne to vy�aduje, abyste nastavili alespon jedno OAuth propojen� (nastaven� identity/u�ivatele)');
@define('PLUGIN_EVENT_TWITTER_API_10',                   'API 1.0 [zastaral�]');
@define('PLUGIN_EVENT_TWITTER_API_11',                   'API 1.1 OAuth');

// Next lines were translated on 2013/10/26
@define('PLUGIN_EVENT_TWITTER_ANNOUNCE_YOURLSDESC',      '<h3>Yourls dom�na a API kl�c</h3>Zkracovac adres <b>yourls</b> vlastn� nastaven� a API kl�c. Pokud ��dn� nem�te, nebudete toto nastaven� potrebovat.<br/>V�choz� kl�c nen� funkcn�<br/><a href="http://yourls.org/" target="_blank" rel="noopener">Prectete si o zkracovaci URL adres yourls</a>. Nepou��vejte pros�m bez <a href="https://bitbucket.org/laceous/yourls-concurrency-fix" target="_blank" rel="noopener">opravy konfliktu</a> pluginu YOURIS.');
@define('PLUGIN_EVENT_TWITTER_ANNOUNCE_YOURLSURL',       'Va�e Yourls dom�na');
@define('PLUGIN_EVENT_TWITTER_ANNOUNCE_YOURLSAPIKEY',    'Yourls API kl�c');

