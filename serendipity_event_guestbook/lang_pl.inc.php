<?php

/**
 *  @version
 *  @file serendipity_event_guestbook.php, langfile(pl) v1.0 2007-05-21 16:10:54 utak3r
 *  @author utak3r
 *  EN-Revision: 
 */

@define('PLUGIN_GUESTBOOK_HEADLINE', 'Nag��wek');
@define('PLUGIN_GUESTBOOK_HEADLINE_BLAHBLAH', 'Nag��wek strony.');
@define('PLUGIN_GUESTBOOK_TITLE', 'Ksi�ga go�ci');
@define('PLUGIN_GUESTBOOK_TITLE_BLAHBLAH', 'Pokazuje ksi�g� go�ci w ramach twojego blogu, stosuj�c normalny jego wygl�d.');
@define('PLUGIN_GUESTBOOK_PERMALINK', 'Permalink');
@define('PLUGIN_GUESTBOOK_PERMALINK_BLAHBLAH', 'Definiuje permalink. Musi by� �cie�k� absolutn� HTTP i ko�czy� si� .htm lub .html!');
@define('PLUGIN_GUESTBOOK_PAGETITLE', 'Nazwa strony');
@define('PLUGIN_GUESTBOOK_PAGETITLE_BLAHBLAH', 'Nazwa strony');
@define('PLUGIN_GUESTBOOK_PAGEURL', 'Statyczny URL');
@define('PLUGIN_GUESTBOOK_PAGEURL_BLAHBLAH', 'Definiuje URL strony (index.php?serendipity[subpage]=name)');

@define('PLUGIN_GUESTBOOK_SESSIONLOCK', 'Blokada sesji');
@define('PLUGIN_GUESTBOOK_SESSIONLOCK_BLAHBLAH', 'Je�li aktywne, mo�liwy tylko jeden wpis na sesj� (u�ytkownika).');
@define('PLUGIN_GUESTBOOK_TIMELOCK', 'Blokada czasu');
@define('PLUGIN_GUESTBOOK_TIMELOCK_BLAHBLAH', 'Po ilu sekundach u�ytkownik mo�e zrobi� kolejny wpis. Przydatne, je�li chcesz unikn�� podw�jnych wpis�w przez np. podw�jne klikni�cia, ewentualnie zwalczy� roboty spamowe.');

@define('PLUGIN_GUESTBOOK_EMAILADMIN', 'Wy�lij e-maila do administratora');
@define('PLUGIN_GUESTBOOK_EMAILADMIN_BLAHBLAH', 'Je�li zaznaczone, administrator dostaje maila po ka�dym wpisie.');
@define('PLUGIN_GUESTBOOK_TARGETMAILADMIN', 'E-mail administratora');
@define('PLUGIN_GUESTBOOK_TARGETMAILADMIN_BLAHBLAH', 'Prosz� poda� prawid�owy adres e-mail, je�li chcesz otrzymywa� powiadomienia o wpisach.');
@define('PLUGIN_GUESTBOOK_SHOWEMAIL', 'Pyta� u�ytkownika o e-mail?');
@define('PLUGIN_GUESTBOOK_SHOWEMAIL_BLAHBLAH', 'Czy chcesz pole na e-mail u�ytkownika?');
@define('PLUGIN_GUESTBOOK_SHOWURL', 'Pyta� o stron� u�ytkownika?');
@define('PLUGIN_GUESTBOOK_SHOWURL_BLAHBLAH', 'Czy chcesz pole na stron� domow� u�ytkownika?');
@define('PLUGIN_GUESTBOOK_SHOWCAPTCHA', 'Pokazywa� obrazki Captcha?');
@define('PLUGIN_GUESTBOOK_SHOWCAPTCHA_BLAHBLAH', 'Czy chcesz u�ywa� obrazk�w Captcha (wymaga uruchomionej wtyczki Spamblock)');
@define('PLUGIN_GUESTBOOK_NUMBER', 'Wpis�w na stron�');
@define('PLUGIN_GUESTBOOK_NUMBER_BLAHBLAH', 'Ile wpis�w ma si� wy�wietla� na stron�?');
@define('PLUGIN_GUESTBOOK_WORDWRAP', 'Znak�w na lini� (zawijanie)');
@define('PLUGIN_GUESTBOOK_WORDWRAP_BLAHBLAH', 'Po ilu znakach ma by� wstawiony znak nowej linii?');
@define('PLUGIN_GUESTBOOK_ERROR_DATA', 'Wyst�pi� b��d podczas przetwarzania');

@define('PLUGIN_GUESTBOOK_EMAIL', 'Adres e-mail');
@define('PLUGIN_GUESTBOOK_INTRO', 'Tekst wst�pny (opcjonalny)');
@define('PLUGIN_GUESTBOOK_MESSAGE', 'Wiadomo��');
@define('PLUGIN_GUESTBOOK_SENT', 'Tekst po wys�aniu wiadomo�ci');
@define('PLUGIN_GUESTBOOK_SENT_HTML', 'Twoja wiadomo�� zosta�a pomy�lnie wys�ana!');
@define('PLUGIN_GUESTBOOK_ERROR_HTML', 'Podczas wysy�ania wiadomo�ci wyst�pi� b��d!');
@define('PLUGIN_GUESTBOOK_ERROR_DATA', 'Ksywka, e-mail i tre�� nie mog� by� puste.');
@define('PLUGIN_GUESTBOOK_ARTICLEFORMAT', 'Formatowa� jak artyku�?');
@define('PLUGIN_GUESTBOOK_ARTICLEFORMAT_BLAHBLAH', 'Je�li zaznaczone, tre�� jest automatycznie formatowana jak artyku� (kolory, ramki itp.) (domy�lnie: tak)');
@define('PLUGIN_GUESTBOOK_CAPTCHAWARNING', '');
@define('PLUGIN_GUESTBOOK_PROTECTION', 'E-mail b�dzie przekonwertowany do postaci: u�ytkownik at email dot com');
@define('PLUGIN_GUESTBOOK_DBDONE', 'Wpis do ksi��ki zapisany!');
@define('PLUGIN_GUESTBOOK_USER_LOGGEDOFF', 'U�ytkownik si� wylogowa�.');
@define('PLUGIN_GUESTBOOK_USERSDATE_OF_ENTRY', 'napisa�(a)');
@define('PLUGIN_GUESTBOOK_UNKNOWN_ERROR', 'Nieznany b��d! Prosz� skontaktowa� si� z administratorem witryny');
@define('PLUGIN_GUESTBOOK_TIMESTAMP_THE', '');
@define('PLUGIN_GUESTBOOK_ALTER_OLDTABLE_DONE', 'Tabela bazy pomy�lnie zmieniona.');
@define('PLUGIN_GUESTBOOK_INSTALL_NEWTABLE_DONE', 'Tabela bazy pomy�lnie zainstalowana.');

@define('BODY', 'Wpis');
@define('SUBMIT', 'Wy�lij wpis');

@define('GUESTBOOK_NEXTPAGE', 'nast. strona');
@define('GUESTBOOK_PREVPAGE', 'poprz. strona');

@define('TEXT_DELETE', 'usu�');
@define('TEXT_SAY', 'powiedzia�');
@define('TEXT_EMAIL', 'E-mail');
@define('TEXT_NAME', 'Ksywka');
@define('TEXT_HOMEPAGE', 'Strona domowa');
@define('TEXT_EMAILSUBJECT', 'Nowy wpis');
@define('TEXT_EMAILTEXT', "%s w�a�nie wpisa� do twojej ksi��ki go�ci:\n%s\n%s\n");
@define('TEXT_CONVERTBOLDUNDERLINE', 'Zamkni�cie tekstu w znakach gwiazdki spowoduje jego wyt�uszczenie (*tekst*), podkre�lenia s� tworzone przez zastosowanie _tekst_.');
@define('TEXT_CONVERTSMILIES', 'Standardowe emotikony jak :-) lub ;-) b�d� zmieniane na ich graficzn� wersj�.');
@define('TEXT_IMG_DELETEENTRY', 'Usu� wpis');
@define('TEXT_IMG_LASTMODIFIED', 'ostatnio modyfikowane');
@define('TEXT_USERS_HOMEPAGE', 'Strona domowa go�cia');

@define('ERROR_TIMELOCK', 'Prosz� poczeka� przynajmniej %s sekund przed ponownym wpisem!');
@define('ERROR_NAMEEMPTY', 'Prosz� podac swoj� ksywk�.');
@define('ERROR_TEXTEMPTY', 'Prosz� wprowadzi� tekst.');
@define('ERROR_EMAILEMPTY', 'Prosz� podac prawid�owy adres e-mail.');
@define('ERROR_DATATOSHORT', 'Tw�j wpis powinien mie� przynajmniej 3, a w polu komentarza 10 znak�w.');
@define('ERROR_NOVALIDEMAIL', 'Tw�j adres e-mail wygl�da na nieprawid�owy: ');
@define('ERROR_COLOR_START', '<span style="color: #ff0000"> ');
@define('ERROR_COLOR_END', ' </span>');
@define('ERROR_NOINPUT', 'Prosz� poda� swoj� ksywk�, adres e-mail i tre�� wpisu');
@define('ERROR_ISFALSECAPTCHA', 'Kod z obrazka CAPTCHAS nie pasuje!');
@define('ERROR_NOCAPTCHASET', 'Og�lne ustawienia CAPTCHA nie mog� by� poprawnie skonfigurowane!');
@define('ERROR_UNKNOWN', 'Wyst�pi� nieznany b��d. Prosz� spr�bowa� ponownie lub poinformowa� administratora tej witryny. Dzi�kuj�!');
@define('ERROR_OCCURRED', 'Wyst�pi�y pewne b��dy:');
@define('ERROR_IS_MARKED_SPAM', 'Tw�j wpis zostal oznaczony jako spam. Prosz� poprawi� sw�j wpis, lub skontaktowa� si� z administratorem!');

@define('THANKS_FOR_ENTRY', 'Tw�j wpis do ksi��ki:');
@define('QUESTION_DELETE', 'Na prawd� chcesz usun�� wpis %s ?');
@define('MARK_SPAM', 'Czy ten wpis ma by� oznaczony jako SPAM?');

@define('PAGINATOR_TO', 'Do');
@define('PAGINATOR_FIRST', 'Pierwsza');
@define('PAGINATOR_PREVIOUS', 'Poprzednia');
@define('PAGINATOR_NEXT', 'Nast�pna');
@define('PAGINATOR_LAST', 'Ostatnia');
@define('PAGINATOR_PAGE', 'Strona.');
@define('PAGINATOR_RANGE', ' do ');
@define('PAGINATOR_OFFSET', ', razem ');
@define('PAGINATOR_ENTRIES', ' wpis�w. ');

//
//  serendipity_plugin_guestbook.php
//
@define('PLUGIN_GUESTSIDE_NAME', 'Guestbook Sidebar');
@define('PLUGIN_GUESTSIDE_BLAHBLAH', 'Display the latest guestbook items in the sidebar');
@define('PLUGIN_GUESTSIDE_TITLE', 'Item Title');
@define('PLUGIN_GUESTSIDE_TITLE_BLAHBLAH', 'Set the title for the plugin');
@define('PLUGIN_GUESTSIDE_SHOWEMAIL', 'Show e-mail');
@define('PLUGIN_GUESTSIDE_SHOWEMAIL_BLAHBLAH', 'Should the e-mail address of the writer be displayed?');
@define('PLUGIN_GUESTSIDE_SHOWHOMEPAGE', 'Show homepage');
@define('PLUGIN_GUESTSIDE_SHOWHOMEPAGE_BLAHBLAH', 'Should the homepage of the writer be displayed?');
@define('PLUGIN_GUESTSIDE_MAXCHARS', 'Max. characters');
@define('PLUGIN_GUESTSIDE_MAXCHARS_BLAHBLAH', 'The content length in characters');
@define('PLUGIN_GUESTSIDE_MAXITEMS', 'Max. items');
@define('PLUGIN_GUESTSIDE_MAXITEMS_BLAHBLAH', 'Set the number of items to be displayed');

