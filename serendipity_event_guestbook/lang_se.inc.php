<?php

/**
 *  @version 
 *  @file serendipity_event_guestbook.php, langfile(se) v2.1 2006/10/17 crapmaster
 *  @author crapmaster
 *  EN-Revision: 
 */

@define('PLUGIN_GUESTBOOK_HEADLINE', 'Rubrik');
@define('PLUGIN_GUESTBOOK_HEADLINE_BLAHBLAH', 'Rubriken p� sidan.');
@define('PLUGIN_GUESTBOOK_TITLE', 'G�stbok');
@define('PLUGIN_GUESTBOOK_TITLE_BLAHBLAH', 'Visa en g�stbol i din blog med ditt vanlig blog-utseende.');
@define('PLUGIN_GUESTBOOK_PERMALINK', 'Permal�nk');
@define('PLUGIN_GUESTBOOK_PERMALINK_BLAHBLAH', 'Definierar en permal�nk f�r denna URL/address. Skall vara en absolut HTTP-path och skall avslutas med .htm eller .html!');
@define('PLUGIN_GUESTBOOK_PAGETITLE', 'Sidtitel');
@define('PLUGIN_GUESTBOOK_PAGETITLE_BLAHBLAH', 'Titel p� sidan');
@define('PLUGIN_GUESTBOOK_PAGEURL', 'Statisk URL');
@define('PLUGIN_GUESTBOOK_PAGEURL_BLAHBLAH', 'S�tter URL/adress till g�stboken (index.php?serendipity[subpage]=name)');

@define('PLUGIN_GUESTBOOK_SESSIONLOCK', 'Sessionsl�s');
@define('PLUGIN_GUESTBOOK_SESSIONLOCK_BLAHBLAH', 'Om aktivt, endast ett inl�gg p� session/anv�ndare.');
@define('PLUGIN_GUESTBOOK_TIMELOCK', 'Tidsl�s');
@define('PLUGIN_GUESTBOOK_TIMELOCK_BLAHBLAH', 'Efter hur m�nga sekunder kan anv�ndaren g�ra ett nytt inl�gg. Bra ifall du vill undvika dubbla inl�gg pga dubbelklick, eller att f�rebygga f�r spam robots.');

@define('PLUGIN_GUESTBOOK_EMAILADMIN', 'Skicka e-post till admininstrat�ren');
@define('PLUGIN_GUESTBOOK_EMAILADMIN_BLAHBLAH', 'Om sant, kommer admininstrat�ren att f� e-post f�r varje inl�gg som postas.');
@define('PLUGIN_GUESTBOOK_TARGETMAILADMIN', 'Administrat�rens E-post');
@define('PLUGIN_GUESTBOOK_TARGETMAILADMIN_BLAHBLAH', 'Var v�nlig ange en giltig e-post adress om du vill f� notifiering p� email.');
@define('PLUGIN_GUESTBOOK_SHOWEMAIL', 'Fr�ga efter anv�ndarens e-post adress?');
@define('PLUGIN_GUESTBOOK_SHOWEMAIL_BLAHBLAH', 'Vill du ha ett f�lt d�r anv�ndaren kan skriva in sin e-post adress?');
@define('PLUGIN_GUESTBOOK_SHOWURL', 'Fr�ga efter anv�ndarens hemsida?');
@define('PLUGIN_GUESTBOOK_SHOWURL_BLAHBLAH', 'Vill du ha ett f�lt d�r anv�ndaren kan skriva in sin hemsida?');
@define('PLUGIN_GUESTBOOK_SHOWCAPTCHA', 'Visa Captchas?');
@define('PLUGIN_GUESTBOOK_SHOWCAPTCHA_BLAHBLAH', 'Vill du anv�nda CAPTCHAS (kr�ver att Spamblock plugin �r aktiverad)');
@define('PLUGIN_GUESTBOOK_NUMBER', 'Inl�gg per sida');
@define('PLUGIN_GUESTBOOK_NUMBER_BLAHBLAH', 'Hur m�nga inl�gg skall visas per sida?');
@define('PLUGIN_GUESTBOOK_WORDWRAP', 'Antal tecken per rad');
@define('PLUGIN_GUESTBOOK_WORDWRAP_BLAHBLAH', 'Efter hur m�nga tecken skall radbrytning automatiskt ske?');
@define('PLUGIN_GUESTBOOK_ERROR_DATA', 'Ett fel uppstod vid processningen');
	
@define('PLUGIN_GUESTBOOK_EMAIL', 'E-post adress');
@define('PLUGIN_GUESTBOOK_INTRO', 'Introduktionstext (valfri)');
@define('PLUGIN_GUESTBOOK_MESSAGE', 'Meddelande');
@define('PLUGIN_GUESTBOOK_SENT', 'Text som visas efter att meddelandet har skickats.');
@define('PLUGIN_GUESTBOOK_SENT_HTML', 'Ditt medddelande har skickats!');
@define('PLUGIN_GUESTBOOK_ERROR_HTML', 'Ett fel uppstod n�r meddelande postades"!');
@define('PLUGIN_GUESTBOOK_ERROR_DATA', 'Namn, e-post och ditt meddelande f�r inte vara tomma.');
@define('PLUGIN_GUESTBOOK_ARTICLEFORMAT', 'Formattera som artikel?');
@define('PLUGIN_GUESTBOOK_ARTICLEFORMAT_BLAHBLAH', 'Om aktiverad, utdata blir automatiskt formatterad som en artikel (f�rger, ramar, etc.) (f�rvalt: ja)');
@define('PLUGIN_GUESTBOOK_CAPTCHAWARNING', '');
@define('PLUGIN_GUESTBOOK_PROTECTION', 'E-post kommer att bli konverterad p� f�ljande s�tt: user at email dot com');
@define('PLUGIN_GUESTBOOK_DBDONE', 'G�stboksinl�gg sparat!');
@define('PLUGIN_GUESTBOOK_USER_LOGGEDOFF', 'Anv�ndaren har loggat ut.');
@define('PLUGIN_GUESTBOOK_USERSDATE_OF_ENTRY', 'skrev');
@define('PLUGIN_GUESTBOOK_UNKNOWN_ERROR', 'Ok�nt fel! Var v�nlig kontakta admininistrat�r av sidan.');
@define('PLUGIN_GUESTBOOK_TIMESTAMP_THE', 'den');
@define('PLUGIN_GUESTBOOK_ALTER_OLDTABLE_DONE', 'Databas-tabellen har framg�ngsrikt �ndrats.');
@define('PLUGIN_GUESTBOOK_INSTALL_NEWTABLE_DONE', 'Databas-tabellen har framg�ngsrikt installerad.');

@define('BODY', 'Inl�gg');
@define('SUBMIT', 'Skicka inl�gg');
@define('GUESTBOOK_NEXTPAGE', 'n�sta sida');
@define('GUESTBOOK_PREVPAGE', 'f�reg�ende sida');

@define('TEXT_DELETE', 'ta bort');
@define('TEXT_SAY', 'sa');
@define('TEXT_EMAIL', 'E-post');
@define('TEXT_NAME', 'Namn');
@define('TEXT_HOMEPAGE', 'Hemsida');
@define('TEXT_EMAILSUBJECT', 'Blog: nytt inl�gg i g�stboken');
@define('TEXT_EMAILTEXT', "%s skrev precis n�t i din g�stbok:\n%s\n%s\n");

@define('TEXT_CONVERTBOLDUNDERLINE', 'Omslutande asterisker markerar text som fetstil (*ord*), underscore g�rs med hj�lp av _ord_.');
@define('TEXT_CONVERTSMILIES', 'Standard emoticons som :-) och ;-) konverteras till bilder.');
@define('TEXT_IMG_DELETEENTRY', 'Ta bort inl�gg');
@define('TEXT_IMG_LASTMODIFIED', 'senast modifierad');
@define('TEXT_USERS_HOMEPAGE', 'G�stens hemsida');

@define('ERROR_TIMELOCK', 'Du m�ste v�nta minst %s sekunder mellan varje postat inl�gg!');
@define('ERROR_NAMEEMPTY', 'Var v�nlig fyll i ditt namn.');
@define('ERROR_TEXTEMPTY', 'Var v�nlig fyll i text.');
@define('ERROR_OCCURRED', 'N�t gick fel:');
	
@define('ERROR_EMAILEMPTY', 'Var v�nlig ange en giltig e-post adress.');
@define('ERROR_DATATOSHORT', 'Ditt inl�gg skall ha minst 3, i kommentarer 10 tecken.');
@define('ERROR_NOVALIDEMAIL', 'Din e-post adress verkar vara ogiltig: ');
@define('ERROR_COLOR_START', '<span style="color: #ff0000"> ');
@define('ERROR_COLOR_END', ' </span>');
@define('ERROR_NOINPUT', 'Var v�nlig mata in ditt namn, e-post adress och en kommentar');
@define('ERROR_ISFALSECAPTCHA', 'CAPTCHAS f�r ditt inl�gg st�mmer inte!');
@define('ERROR_NOCAPTCHASET', 'Den generella CAPTCHA-konfigurationen kanske inte �r korrekt!');
@define('ERROR_UNKNOWN', 'Ett ok�nt fel intr�ffade. Var v�nlig f�rs�k igen eller informera webmastern f�r hemsidan. Tack!');
@define('ERROR_IS_MARKED_SPAM', 'Ditt inl�gg blev markerat som spam. Var v�nlig r�tta till ditt inl�gg eller kontakta webmastern f�r hemsidan!');

@define('THANKS_FOR_ENTRY', 'Ditt g�stboksinl�gg:');
@define('QUESTION_DELETE', 'Vill du verkligen ta bort inl�gget %s ?');
@define('MARK_SPAM', 'Skall detta inl�gg markeras som SPAM?');

@define('PAGINATOR_TO', 'Till');
@define('PAGINATOR_FIRST', 'F�rst');
@define('PAGINATOR_PREVIOUS', 'F�reg�ende');
@define('PAGINATOR_NEXT', 'N�sta');
@define('PAGINATOR_LAST', 'Sista');
@define('PAGINATOR_PAGE', 'Sifa.');
@define('PAGINATOR_RANGE', ' till ');
@define('PAGINATOR_OFFSET', ', totalt ');
@define('PAGINATOR_ENTRIES', ' inl�gg. ');

//
//  serendipity_plugin_guestbook.php
//
@define('PLUGIN_GUESTSIDE_NAME', 'G�stbokens sidmeny');
@define('PLUGIN_GUESTSIDE_BLAHBLAH', 'Visa de senaste g�stboksinl�ggen i sidmenyn');
@define('PLUGIN_GUESTSIDE_TITLE', 'Inl�ggets titel');
@define('PLUGIN_GUESTSIDE_TITLE_BLAHBLAH', 'S�tt titeln f�r sidmenyn');
@define('PLUGIN_GUESTSIDE_SHOWEMAIL', 'Visa anv�ndarens e-post?');
@define('PLUGIN_GUESTSIDE_SHOWEMAIL_BLAHBLAH', 'Skall skribentens e-post adress visas?');
@define('PLUGIN_GUESTSIDE_SHOWHOMEPAGE', 'Visa anv�ndarens hemsida?');
@define('PLUGIN_GUESTSIDE_SHOWHOMEPAGE_BLAHBLAH', 'Skall skribentens hemsida visas?');
@define('PLUGIN_GUESTSIDE_MAXCHARS', 'Max antal tecken');
@define('PLUGIN_GUESTSIDE_MAXCHARS_BLAHBLAH', 'Inl�ggets inneh�ll i antal tecken');
@define('PLUGIN_GUESTSIDE_MAXITEMS', 'Max. antal inl�gg');
@define('PLUGIN_GUESTSIDE_MAXITEMS_BLAHBLAH', 'S�tt antalet inl�gg som skall visas');

