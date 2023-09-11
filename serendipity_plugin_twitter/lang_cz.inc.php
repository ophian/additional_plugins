<?php

/**
 *  @author VladimA­r Ajgl <vlada@ajgl.cz>
 *  @translated 2009/08/08
 *  @author VladimA­r Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2009/08/15
 *  @author VladimA­r Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2009/08/25
 *  @author VladimA­r Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2010/09/28
 *  @author VladimA­r Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2011/03/09
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2012/01/11
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2013/03/31
 *  @author Vladimír Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2013/10/26
 */
@define('PLUGIN_TWITTER_TITLE',                         'Twitter');
@define('PLUGIN_TWITTER_DESC',                          'Zobrazuje Vaše nejnovejší príspevky na Twitteru');
@define('PLUGIN_TWITTER_NUMBER',                        'Pocet príspevku');
@define('PLUGIN_TWITTER_NUMBER_DESC',                   'Kolik príspevku z Twitteru má být zobrazeno? (Výchozí: 10)');
@define('PLUGIN_TWITTER_TOALL_ONLY',                    'Pouze tweety adresované všem');
@define('PLUGIN_TWITTER_TOALL_ONLY_DESC',               'Pokud je zapnuto, nebudou se zobrazovat tweety, které obsahují zavinác "@" (pouze v PHP verzi)');
@define('PLUGIN_TWITTER_SERVICE',                       'Služba');
@define('PLUGIN_TWITTER_SERVICE_DESC',                  'Vyberte mikroblogovací službu, kterou používáte');
@define('PLUGIN_TWITTER_USERNAME',                      'Uživatelské jméno');
@define('PLUGIN_TWITTER_USERNAME_DESC',                 'Pokud máte adresu http://www.twitter.com/ptak_jarabak, pak je Vaše uživatelské jméno ptak_jarabak. Mužete použít i prihlašovací jméno k indenti.ca.');
@define('PLUGIN_TWITTER_SHOWFORMAT',                    'Výstupní formát');
@define('PLUGIN_TWITTER_SHOWFORMAT_DESC',               'Mužete si vybrat mezi Javascriptem a PHP. Týká se vlastního zobrazení príspevku v postranním bloku na blogu. Pozor! - JavaScript nebude fungovat s více instancemi pluginu na jedné stránce. Musíte použít PHP verzi, pokud ho tak chcete nastavit.');
@define('PLUGIN_TWITTER_SHOWFORMAT_RADIO_JAVASCRIPT',   'Javascript');
@define('PLUGIN_TWITTER_SHOWFORMAT_RADIO_PHP',          'PHP');

@define('PLUGIN_TWITTER_CACHETIME',                     'Jak dlouho cachovat data (pouze pro PHP formát)');
@define('PLUGIN_TWITTER_CACHETIME_DESC',                'Aby se zamezilo príliš velkému a zbytecnému prenášení dat mezi blogem a Twitterem, mohou se výsledky z Twitteru ukládat do cache. Zde zadejte v sekundách dobu, po které se bude aktualizovat obsah cache podle Twitteru.');
@define('PLUGIN_TWITTER_BACKUP',                        'Zálohovat Tweety? (experimentální funkce, pouze Twitter)');
@define('PLUGIN_TWITTER_BACKUP_DESC',                   'Pokud je povoleno, plugin bude denne stahovat tweety a zálohovat je v databázi blogu (tabulka ' . $serendipity['dbPrefix'] . 'tweets). Vyžaduje PHP5.');

@define('PLUGIN_TWITTER_LINKTEXT',                      'Text odkazu ve tweetech');
@define('PLUGIN_TWITTER_LINKTEXT_DESC',                 'Odkazy nalezené v Tweetech jsou nahrazeny kliknutelným HTML odkazem. Zde nastavte text odkazu. Hodnota $1 bude nahrazena samotným odkazem tak, jak to delá Twitter.');
@define('PLUGIN_TWITTER_FOLLOWME_LINK',                 'Odkaz "Sledování"');
@define('PLUGIN_TWITTER_FOLLOWME_LINK_DESC',            'Pridává odkaz "sledování" pod casovou osu');
@define('PLUGIN_TWITTER_FOLLOWME_LINK_TEXT',            'Sledování');
@define('PLUGIN_TWITTER_USE_TIME_AGO',                  'Použít pohled zpet v case');
@define('PLUGIN_TWITTER_USE_TIME_AGO_DESC',             'Pokud je zapnuto, pak bude cas statutu zobrazen jako cas, který uplynul od zadání statutu (tak jak to delá samotný twitter), jinak bude použít nastavitelný formát data.');

@define('PLUGIN_TWITTER_PROBLEM_TWITTER_ACCESS',        'Problém pri prístupu na Twitter. <br />Pockejte chvilku a obnovte stránku...');

// Twitter Event Plugin

@define('PLUGIN_EVENT_TWITTER_NAME',                    'Mikroblogování (Twitter, Identica)');
@define('PLUGIN_EVENT_TWITTER_DESC',                    'Pridává klienta Twitter/Identica do administracní sekce a stahuje nové tweety a oznámuje nové clánky na úctu mikroblogu.');

@define('PLUGIN_EVENT_TWITTER_ACCOUNT_NAME',            'Jméno úctu');
@define('PLUGIN_EVENT_TWITTER_ACCOUNT_NAME_DESC',       'Jméno úctu, kterým se bude klient na pozadí prihlašovat k mikroblogu.');
@define('PLUGIN_EVENT_TWITTER_ACCOUNT_PWD',             'Heslo k úctu');
@define('PLUGIN_EVENT_TWITTER_ACCOUNT_PWD_DESC',        'Heslo úctu, kterým se bude klient na pozadí prihlašovat k mikroblogu.');

@define('PLUGIN_EVENT_TWITTER_ANNOUNCE_ARTICLES_TITLE', 'Oznámování clánku');
@define('PLUGIN_EVENT_TWITTER_ANNOUNCE_ARTICLES',       'Oznamovat nové clánky');
@define('PLUGIN_EVENT_TWITTER_ANNOUNCE_ARTICLES_DESC',  'Pokud je zapnuto, plugin bude oznamovat nové na blogu publikované príspevky na službe Twitter nebo Identica.');
@define('PLUGIN_EVENT_TWITTER_ANNOUNCE_WITHTTAGS',      'Oznámit s tagy');
@define('PLUGIN_EVENT_TWITTER_ANNOUNCE_WITHTTAGS_DESC', 'Pokud je nainstalován plugin Free Tag (Klícová slova), oznamovac clánku prohledá nadpis príspevku, jestli neobsahuje tagy. Pokud nejaký nalezne, budou tyto tagy oznacené jako tagy twitteru. Vždy mužete pridat tagy rucne pomocí #tags#. Tyto budou naplneny všemi tagy, které ješte nebyly nalezeny v nadpisu príspevku. To znamená všechny zde zadané tagy budou pridány, pokud volba automatického hledání tagu není zapnuta.');
@define('PLUGIN_EVENT_TWITTER_ANNOUNCE_SERVICE',        'Oznámit URL zkracovac');
@define('PLUGIN_EVENT_TWITTER_ANNOUNCE_SERVICE_DESC',   'Služba, která má být použita pro zkrácení odkazu pri oznamování príspevku. Doporucené jsou 7ax.de nebo tinyurl.com, protože to jsou zatím jediné známé služby, které fungují spolecne s tweetbacks.');

@define('PLUGIN_EVENT_TWITTER_TWEETBACKS_TITLE',        'Tweetbacks');
@define('PLUGIN_EVENT_TWITTER_DO_TWEETBACKS',           'Zjištovat Tweetbacky');
@define('PLUGIN_EVENT_TWITTER_DO_TWEETBACKS_DESC',      'Pokud je zapnuto, plugin se pokusí najít tweetbacky (odezvy twitteru) na clánky a pridá volbu "zkontrolovat odezvy twitteru" pod rozšírené telo príspevku, pokud je návštevník prihlášený do blogu.');
@define('PLUGIN_EVENT_TWITTER_IGNORE_MYTWEETBACKS',     'Ignorovat moje Tweety');
@define('PLUGIN_EVENT_TWITTER_IGNORE_MYTWEETBACKS_DESC','Pokud nechcete zobrazovat vlastní tweety jako tweetbacky, zapnete tuto volbu. V opacném prípade budou oznámení zobrazována jako tweetbacky.');

@define('PLUGIN_EVENT_TWITTER_TWEETBACK_CHECK_FREQ',    'Frekvence kontroly tweetbacku');
@define('PLUGIN_EVENT_TWITTER_TWEETBACK_CHECK_FREQ_DESC','Cas v minutách mezi dvema kontrolami twitteru. (musí být alespon 5 minut)');
@define('PLUGIN_EVENT_TWITTER_TB_TYPE',                 'Typ tweetbacku');
@define('PLUGIN_EVENT_TWITTER_TB_TYPE_DESC',            'Serendipity nepodporuje sama o sobe tweetbacky. Takže ty musejí být uloženy jako odezvy nebo normální komentáre. Protože pricházejí z vne blogu, jsou jistým type odezvy, ale podle obsahu by patrily spíš mezi komentáre. Rozhodnete sami, jak se mají tweetbacky ukládat.');
@define('PLUGIN_EVENT_TWITTER_TB_TYPE_TRACKBACK',       'Odezva');
@define('PLUGIN_EVENT_TWITTER_TB_TYPE_COMMENT',         'Komentár');

@define('PLUGIN_EVENT_TWITTER_TWEETER_TITLE',           'Mikroblogovací klient');
@define('PLUGIN_EVENT_TWITTER_TWEETER_SIDEBARTITLE',    'Tweeter');
@define('PLUGIN_EVENT_TWITTER_TWEETER_SHOW',            'Zapnout mikroblogovacího klienta');
@define('PLUGIN_EVENT_TWITTER_TWEETER_SHOW_DESC',       'Zapnte tweeter na hlavní stránce administracní sekce, jako postranní sloupec a nebo ho vypne.');
@define('PLUGIN_EVENT_TWITTER_TWEETER_SHOW_FRONTPAGE',  'Hlavní stránka');
@define('PLUGIN_EVENT_TWITTER_TWEETER_SHOW_SIDEBAR',    'Postranní sloupec');
@define('PLUGIN_EVENT_TWITTER_TWEETER_SHOW_DISABLE',    'Vypnout');
@define('PLUGIN_EVENT_TWITTER_TWEETER_HISTORY',         'Zobrazit casovou osu');
@define('PLUGIN_EVENT_TWITTER_TWEETER_HISTORY_DESC',    'Zobrazuje casovou osu s clánky pod aktualizovaným výpisem.');
@define('PLUGIN_EVENT_TWITTER_TWEETER_HISTORY_COUNT',   'Délka casové osy');
@define('PLUGIN_EVENT_TWITTER_TWEETER_HISTORY_COUNT_DESC','Kolik nejnovejších príspevku  se má zobrazovat na hlavní strane?');

@define('PLUGIN_EVENT_TWITTER_TWEETER_FORM',            'Zadejte tweet:');
@define('PLUGIN_EVENT_TWITTER_TWEETER_CHARSLEFT',       'znaku vlevo');
@define('PLUGIN_EVENT_TWITTER_TWEETER_SHORTEN',         'Zkracovat URL adresy');
@define('PLUGIN_EVENT_TWITTER_TWEETER_STORED',          'Tweet uložen ');
@define('PLUGIN_EVENT_TWITTER_TWEETER_STOREFAIL',       'Tweet nemohl být uložen! Chyba Twitteru: ');

@define('PLUGIN_EVENT_TWITTER_GENERAL_TITLE',           'Obecná');
@define('PLUGIN_EVENT_TWITTER_PLUGIN_EVENT_REL_URL',    'Plugin rel. path');
@define('PLUGIN_EVENT_TWITTER_PLUGIN_EVENT_REL_URL_DESC', 'Zadejte celou HTTP cestu (všechno, co následuje po Vašem doménovém jméne), které vede do adresáre s pluginem.');

@define('PLUGIN_EVENT_TWITTER_TWEETER_WARNING',         '<p class="msg_error">' .
                '<span class="icon-attention-circled" aria-hidden="true"></span> ' .
                'UPOZORNENÍ: Nalezen nainstalovaný plugin TwitterTweeter.</p>' .
                '<p class="msg_error">Tento plugin je sloucením pluginu TwitterTweeter a oficiálního starého serendipity pluginu twitter, navíc oba dva pluginy rozširuje.Meli byste odinstalovat všechny predchozí pluginy.</p>');

@define('PLUGIN_EVENT_TWITTER_TB_USE_URL',              'URL Tweetbacku');
@define('PLUGIN_EVENT_TWITTER_TB_USE_URL_DESC',         'Co uložit jako URL adresu tweetbacku? Máte 3 možnosti. Status: url tweetu, který je tweetbackem, Profil: adresa profilu uživatele twitteru nebo WebURL: adresa zadaná uživatelem twitteru v jeho profilu jako Web URL');
@define('PLUGIN_EVENT_TWITTER_TB_USE_URL_STATUS',       'Status');
@define('PLUGIN_EVENT_TWITTER_TB_USE_URL_PROFILE',      'Profil');
@define('PLUGIN_EVENT_TWITTER_TB_USE_URL_WEBURL',       'Web URL');

@define('PLUGIN_EVENT_TWITTER_IDENTITIES',              'Identity');
@define('PLUGIN_EVENT_TWITTER_ACCOUNT_IDCOUNT',         'Pocet úctu');
@define('PLUGIN_EVENT_TWITTER_ACCOUNT_IDCOUNT_DESC',    'Po uložení tohoto nastavení se na této stránce nastavení objeví polícka pro nastavení zde zadaného poctu úctu. Možná budete muset nastavení uložit dvakrát, abyste príslušná zadávací polícka videli.');
@define('PLUGIN_EVENT_TWITTER_IDENTITY',                'Identita');
@define('PLUGIN_EVENT_TWITTER_ACCOUNT_SERVICE',         'Jméno služby');
@define('PLUGIN_EVENT_TWITTER_ACCOUNT_SERVICE_DESC',    'Zadejte, zda je tento úcet na twitteru nebo na identi.ca');
@define('PLUGIN_EVENT_TWITTER_ACCOUNT_SERVICE_TWITTER', 'twitter');
@define('PLUGIN_EVENT_TWITTER_ACCOUNT_SERVICE_IDENTICA','identica');

@define('PLUGIN_EVENT_TWITTER_ANNOUNCE_ACCOUNTS',       'Oznamovací úcty');
@define('PLUGIN_EVENT_TWITTER_ANNOUNCE_ACCOUNTS_DESC',  'Vyberte úcty, na které se mají oznamovat nové príspevky');

// Configuration Tabs:

@define('PLUGIN_EVENT_TWITTER_CFGTAB',                  'Konfiguracní záložky:');
@define('PLUGIN_EVENT_TWITTER_CFGTAB_IDENTITIES',       'Identity');
@define('PLUGIN_EVENT_TWITTER_CFGTAB_ANNOUNCE',         'Oznamování clánku');
@define('PLUGIN_EVENT_TWITTER_CFGTAB_TWEETER',          'Mikroblogovací klient');
@define('PLUGIN_EVENT_TWITTER_CFGTAB_TWEETBACK',        'Tweetbacky');
@define('PLUGIN_EVENT_TWITTER_CFGTAB_GLOBAL',           'Obecné');
@define('PLUGIN_EVENT_TWITTER_CFGTAB_ALL',              'Všechno');

@define('PLUGIN_EVENT_TWITTER_TWEETER_REPLY',           'Odpovedet pisateli');
@define('PLUGIN_EVENT_TWITTER_TWEETER_RETWEET',         'Retweetovat');
@define('PLUGIN_EVENT_TWITTER_TWEETER_DM',              'Prímá zpráva (Pracuje pouze pokud Vás uživatel sleduje)');

@define('PLUGIN_EVENT_TWITTER_IGNORE_TWEETBACKS_BYNAME','Ignorovat tweetbacky z');
@define('PLUGIN_EVENT_TWITTER_IGNORE_TWEETBACKS_BYNAME_DESC','Cárkami oddelený seznam úctu twitteru, ze kterých nechcete prijímat tweetbacky.');

@define('PLUGIN_TWITTER_EVENT_NOT_INSTALLED',           '<p class="msg_error">' .
                '<span class="icon-attention-circled" aria-hidden="true"></span> ' .
                'VAROVÁNÍ: Plugin událostí pro mikroblogování (twitter/identica) ješte nebyl nainstalován!</p>' .
                '<p class="msg_error">Hlavní cást funkcí twitter/identica je zabezpecována pluginem událostí mikroblogování. Pokud chcete plnou funkcnost pluginu, meli byste ho také nainstalovat
.</p>');

@define('PLUGIN_EVENT_TWITTER_ANNOUNCE_FORMAT',         'Formát oznámení');
@define('PLUGIN_EVENT_TWITTER_ANNOUNCE_FORMAT_DESC',    'Zadejte vlastní formát oznamovacích zpráv. Mužete použít následující promenné. title#: bude nahrazen nadpisem príspevku (a odpovídajícími tagy); #link#: odkaz na príspevek; #author#: Autor príspevku; #tags#: zbývající tagy.');

@define('PLUGIN_EVENT_TWITTER_CFGTAB_TWEETTHIS',        'Twittni to!');
@define('PLUGIN_EVENT_TWITTER_TWEETTHIS_TITLE',         'Twittni to!');
@define('PLUGIN_EVENT_TWITTER_DO_TWEETTHIS',            'Povolit "Twittni to!"');
@define('PLUGIN_EVENT_TWITTER_DO_TWEETTHIS_DESC',       'Zapnutí této funkce zobrazí tlacítko "Twittni to!" v paticce príspevku.');
@define('PLUGIN_EVENT_TWITTER_DO_IDENTICATHIS',         'Zapnout Identica');
@define('PLUGIN_EVENT_TWITTER_DO_IDENTICATHIS_DESC',    'Zapnutí této funkce zobrazí tlacítko "Identica" v paticce príspevku.');
@define('PLUGIN_EVENT_TWITTER_TWEETTHIS_FORMAT',        'Formát "Twittni to!"');
@define('PLUGIN_EVENT_TWITTER_TWEETTHIS_FORMAT_DESC',   'Zadejte formát pro tweety návštevníku. Meli byste použít následující promenné. title#: bude nahrazen nadpisem príspevku (a odpovídajícími tagy); #link#: odkaz na príspevek; #author#: Autor príspevku; #tags#: zbývající tagy.');
@define('PLUGIN_EVENT_TWITTER_TWEETTHIS_FORMAT_BUTTON', 'Styl tlacítek');
@define('PLUGIN_EVENT_TWITTER_TWEETTHIS_FORMAT_BUTTON_DESC', 'V soucasnosti je možno vybrat mezi dvema styly twittovacího tlacítka.');
@define('PLUGIN_EVENT_TWITTER_TWEETTHIS_FORMAT_BUTTON_BLACK', 'cerné');
@define('PLUGIN_EVENT_TWITTER_TWEETTHIS_FORMAT_BUTTON_WHITE', 'bílé');

@define('PLUGIN_EVENT_TWITTER_TWEETTHIS_NEWWINDOW',     '"Twittni to!" v novém okne');
@define('PLUGIN_EVENT_TWITTER_TWEETTHIS_NEWWINDOW_DESC','Pokud je zapnuto, twitter a identica se natáhnou v novém okne, v aktuálním okne tedy zustane stále zobrazený blog.');
@define('PLUGIN_EVENT_TWITTER_TWEETTHIS_SMARTIFY',      'Smartyfizce funkce "Twittni to!"');
@define('PLUGIN_EVENT_TWITTER_TWEETTHIS_SMARTIFY_DESC', 'Pokud je zapnuto, plugin nebude pridávat tlacítko sám o sobe. Místo toho pridá do smarty dve promenné: entry.url_tweetthis a entry.url_dentthis. Ty pak lze použít v šablone. Tyto promenné obsahují pouze URL adresy, takže mužete vytvorit vlastní text pro tlacítko "Twittni to!", nebo tlacítko umístit napríklad do záhlaví clánku.');

@define('PLUGIN_EVENT_TWITTER_BACKEND_DONTANNOUNCE',    'NEoznamovat tento príspevek pomocí mikroblogovacích služeb');
@define('PLUGIN_EVENT_TWITTER_BACKEND_ENTERDESC',       'Zadejte libovolné tagy, které souvisí s príspevkem. Více tagu oddelujte cárkou (,). Pokud je zde neco zadáno, tagy pluginu freetag jsou pri oznamování ignorovány!');

// Next lines were translated on 2009/08/15

@define('PLUGIN_TWITTER_FILTER_ALL',                    'Žádné uživatelské tweety');
@define('PLUGIN_TWITTER_FILTER_ALL_DESC',               'Pokud je volba zapnuta, nebudou se zobrazovat tweety obsahující @. (pouze v PHP verzi)');
@define('PLUGIN_EVENT_TWITTER_TB_MODERATE',             'Schvalování tweetbacku');
@define('PLUGIN_EVENT_TWITTER_TB_MODERATE_DESC',        'Jak pracovat s prijatými tweetbacky? Mužete použít obecné nastavení pro komentáre, schvalovat je, nebo je vždy povolit.');
@define('PLUGIN_EVENT_TWITTER_TB_MODERATE_DEFAULT',     'Použít obecné nastavení komentáru');

// Next lines were translated on 2009/08/25

@define('PLUGIN_EVENT_TWITTER_SHORTURL_TITLE',          'Zobrazit URL adresu pro tento clánek');
@define('PLUGIN_EVENT_TWITTER_SHORTURL_ON_CLICK',       'Tento odkaz není klikací. Obsahuje zkrácenou URL adresu k tomuto príspevku. Tuto URL adresu mužete použít jako odkaz na tento clánek, napríklad v twitteru. Odkaz zkopírujete tak, že kliknete pravým tlacítkem a vyberete "Zkopírovat odkaz" v Internet Exploreru, nebo "Kopírovat adresu odkazu" v Mozille.');
@define('PLUGIN_EVENT_TWITTER_SHOW_SHORTURL',           'Zobrzit krátkou URL adresu pro každý príspevek');
@define('PLUGIN_EVENT_TWITTER_SHOW_SHORTURL_DESC',      'Bude zobrazovat výchozí krátkou URL v paticce každého clánku. Pokud je zapnutá funkce smarty TweetThis, každý príspevek bude obsahovat promennou entry.url_shorturl, která se dá libovolne využít ve smarty šablone.');

// Next lines were translated on 2010/09/28

@define('PLUGIN_EVENT_TWITTER_CONSUMER_KEY',            'Klíc zákazníka (Consumer key)');
@define('PLUGIN_EVENT_TWITTER_CONSUMER_KEY_DESC',       '"Zákaznický klíc" a "zákaznické heslo" obdržíte od Twitteru poté, co pro svuj blok vytvoríte aplikaci Twitteru.');
@define('PLUGIN_EVENT_TWITTER_CONSUMER_SECRET',         'Zákaznické heslo');
@define('PLUGIN_EVENT_TWITTER_TIMELINE',                'Casová osa statutu');
@define('PLUGIN_EVENT_TWITTER_TIMELINE_DESC',           '');
@define('PLUGIN_EVENT_TWITTER_CONNECT_OK',           'Pripojeno');
@define('PLUGIN_EVENT_TWITTER_CONNECT_DEL',          'Smazat odkaz');
@define('PLUGIN_EVENT_TWITTER_CONNECT_DEL_OK',       'Twitter OAuth token odstranen');
@define('PLUGIN_EVENT_TWITTER_CLOSEWINDOW',             'Zavrít okno');
@define('PLUGIN_EVENT_TWITTER_REGISTER',                'Registrovat');
@define('PLUGIN_EVENT_TWITTER_CALLBACKURL',             'Zpetná URL adresa (zadejte ve Twitteru)');
@define('PLUGIN_EVENT_TWITTER_CONNECT_ERROR',        'Chyba zpetného volání Twitteru');

// Next lines were translated on 2011/03/09

@define('PLUGIN_EVENT_TWITTER_ANNOUNCE_ARTICLES_NO',    'Pro oznamování príspevku je ve výchozím nastavení checkbox odškrtnut');
@define('PLUGIN_EVENT_TWITTER_ANNOUNCE_ARTICLES_NO_DESC','Povolení znamená, že nový príspevek na blogu musí být výslovne odeslán do twiteru. Vypnutí (výchozí hodnota) znamená, že príspevek bude do twiteru odeslán automaticky.');

// Next lines were translated on 2012/01/11

@define('PLUGIN_EVENT_TWITTER_SIGN_IN',                 'Kliknete na tlacítko níže a pripojte Twitter.<br/>
<p><a style="color:red;">VAROVÁNÍ!</a><br/>
Musíte se prihlásit nebo odhlásit s <b>odpovídajícím úctem Twitteru</b>!<br/>
<a href="#" onclick="window.open(\'http://twitter.com\',\'\',\'width=1000,height=400\'); return false">Potvrdte prosím pred pripojením</a>.</p>');
@define('PLUGIN_EVENT_TWITTER_SIGNIN',                  'Prihlásit');
@define('PLUGIN_TWITTER_FOLLOWME_WIDGET',               'Widget sledování Twitteru');
@define('PLUGIN_TWITTER_FOLLOWME_WIDGET_DESC',          'Pokud plugin zobrazuje casovou osu, mužete povolit widget twitteru pro zobrazování aktuálního poctu followeru a další. Nastavení je ignorováno, pokud zobrazujete z identi.ca.');
@define('PLUGIN_TWITTER_FOLLOWME_WIDGET_COUNT',         'Pocet followeru ve widgetu');
@define('PLUGIN_TWITTER_FOLLOWME_WIDGET_COUNT_DESC',    'Pokud je povoleno, widget zobrazuje pocet followeru.');
@define('PLUGIN_TWITTER_FOLLOWME_WIDGET_DARK',          'Widget sledování Twitter na tmavém pozadí');
@define('PLUGIN_TWITTER_FOLLOWME_WIDGET_DARK_DESC',     'Pokud Vaše šablona používá tmavé pozadí, meli byste toto povolit.');
@define('PLUGIN_EVENT_TWITTER_ANNOUNCE_BITLYDESC',      '<h3>uživatelské jméno bit.ly a API klíc</h3><b>bit.ly</b> a <b>j.mp</b> zkracovace URL adres potrebují prihlašovací jméno k bit.ly a API klíc. Pokud ani jeden z techto zkracovacu nepoužíváte, nemeli byste je potrebovat.<br/>Výchozí klíc vetšinou nefunguje, protože je to demo klíc a jeho kvóta je pravidelne precerpána. Pokud máte úcet na bit.ly account, meli byste zadat vlastní prihlašovací údaje.<br/><a href="http://bitly.com/a/your_api_key/" target="_blank" rel="noopener">Najdete je tady</a>.');
@define('PLUGIN_EVENT_TWITTER_ANNOUNCE_BITLYLOGIN',     'Uživatelské jméno bit.ly');
@define('PLUGIN_EVENT_TWITTER_ANNOUNCE_BITLYAPIKEY',    'bit.ly API klíc');
@define('PLUGIN_EVENT_TWITTER_GENERALCONSUMER',         '<h3>Vlastní twitter klient</h3>Ve výchozím nastavení používá plugin klienta \'s9y\'. Mužete si <a href="https://dev.twitter.com/apps" target="_blank" rel="noopener">zaregistrovat vlastního klienta</a> a nastavit consumer klíc a heslo vašeho klienta.');

// Next lines were translated on 2013/03/31

@define('PLUGIN_EVENT_TWITTER_TWEETER_UPDATE',           'Update');
@define('PLUGIN_EVENT_TWITTER_ANNOUNCE_PIRATLYDESC',     '<h3>pirat.ly API token</h3>Pro zkrácené odkaz <b>pirat.ly</b> mužete <a href="http://pirat.ly/account" target="_blank" rel="noopener">získat API token tím, že se zdarma registrujete na službe piratly</a>. Použitím tohoto API tokenu pri oznamování Vašich príspevku mužete prohlížet pocty prokliku bud pomocí webového rozhraní nebo na zarízení s Androidem pomocí <a href="http://pirat.ly/shortenerrr" target="_blank" rel="noopener">aplikace Shortenerrr</a>.');
@define('PLUGIN_EVENT_TWITTER_ANNOUNCE_PIRATLYAPIKEY',   'Váš osobní piratly API token');
@define('PLUGIN_TWITTER_FILTER_RT',                      'FIltrovat nativní retweety');
@define('PLUGIN_TWITTER_FILTER_RT_DESC',                 'Mají se filtrovat nativní retweety? (pouze pro Twitter API 1.1; API 1.0 filtruje vždy)');
@define('PLUGIN_TWITTER_API11',                          'Použít OAuth Twitter API 1.1');
@define('PLUGIN_TWITTER_API11_DESC',                     'Twitter API 1.0 je zastaralé a behem roku 2013 bude úplne zrušeno. Meli byste se tedy prepnout na API 1.1. Nicméne to vyžaduje, abyste nastavili alespon jedno OAuth propojení v hlavním mikroblogovacím pluginu. Pokud v polícku níže najdete nejaký úcet, už jste to udelali.');
@define('PLUGIN_TWITTER_OAUTHACC',                       'OAuth úcet, který se má použít tímto pluginem');
@define('PLUGIN_TWITTER_OAUTHACC_DESC',                  'Nové OAuth Twitter API je treba volat pomocí OAuthorzied Twitter úctu. Tento úcet bude také použit pro omezení prístupu. Mužete použít libovolný úcet, který vlastníte, treba úcet, který nikde jinde nepoužíváte, napríklad abyste meli pro tento plugin samostatný limit prístupu.');
@define('PLUGIN_EVENT_TWITTER_API_TYPE',                 'Verze Twitter API');
@define('PLUGIN_EVENT_TWITTER_API_TYPE_DESC',            'Twitter API 1.0 je zastaralé a behem roku 2013 bude úplne zrušeno. Meli byste se tedy prepnout na API 1.1. Nicméne to vyžaduje, abyste nastavili alespon jedno OAuth propojení (nastavení identity/uživatele)');
@define('PLUGIN_EVENT_TWITTER_API_10',                   'API 1.0 [zastaralé]');
@define('PLUGIN_EVENT_TWITTER_API_11',                   'API 1.1 OAuth');

// Next lines were translated on 2013/10/26
@define('PLUGIN_EVENT_TWITTER_ANNOUNCE_YOURLSDESC',      '<h3>Yourls doména a API klíc</h3>Zkracovac adres <b>yourls</b> vlastní nastavení a API klíc. Pokud žádné nemáte, nebudete toto nastavení potrebovat.<br/>Výchozí klíc není funkcní<br/><a href="http://yourls.org/" target="_blank" rel="noopener">Prectete si o zkracovaci URL adres yourls</a>. Nepoužívejte prosím bez <a href="https://bitbucket.org/laceous/yourls-concurrency-fix" target="_blank" rel="noopener">opravy konfliktu</a> pluginu YOURIS.');
@define('PLUGIN_EVENT_TWITTER_ANNOUNCE_YOURLSURL',       'Vaše Yourls doména');
@define('PLUGIN_EVENT_TWITTER_ANNOUNCE_YOURLSAPIKEY',    'Yourls API klíc');

