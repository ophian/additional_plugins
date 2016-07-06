<?php

/**
 *  @author Vladim�r Ajgl <vlada@ajgl.cz>
 *  @translated 2009/11/21
 *  @author Vladim�r Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2009/11/29
 *  @author Vladim�r Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2010/02/14
 *  @author Vladim�r Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2010/03/07
 *  @author Vladim�r Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2011/03/05
 */

@define('PLUGIN_EVENTCAL_HEADLINE', 'Nadpis');
@define('PLUGIN_EVENTCAL_HEADLINE_BLAHBLAH', 'Nadpis str�nky');
@define('PLUGIN_EVENTCAL_TITLE', 'Kalend�� akc�');
@define('PLUGIN_EVENTCAL_TITLE_BLAHBLAH', 'Zobrazuje kalend�� akc� jako samostatnou str�nku v blogu. Design str�nky z�st�v� stejn� jako u zbytku blogu. (MySQL only)');
@define('PLUGIN_EVENTCAL_PERMALINK', 'St�l� odkaz');
@define('PLUGIN_EVENTCAL_PERMALINK_BLAHBLAH', 'Zadejte st�l� odkaz, st�lou URL adresu str�nky s kalend��em akc�. Mus� b�t absolutn� HTTP cesta a mus� kon�it .htm nebo .html!');
@define('PLUGIN_EVENTCAL_PAGETITLE', 'N�zev statick� str�nky & jej� URL');
@define('PLUGIN_EVENTCAL_PAGETITLE_BLAHBLAH', 'N�zev statick� str�nky. Pozor: n�zev tak� definuje URL adresu t�to str�nky (index.php?serendipity[subpage]=zde_zadany_nazev)');
@define('PLUGIN_EVENTCAL_ARTICLEFORMAT', 'Form�tovat jako p��sp�vek?');
@define('PLUGIN_EVENTCAL_ARTICLEFORMAT_BLAHBLAH', 'Pokud zad�te "ano", str�nka bude automaticky zform�tov�na stejn� jako b�n� p��sp�vky. (V�choz�: ano)');
@define('PLUGIN_EVENTCAL_SHOWCAPTCHA', 'Zobrazovat kryptogramy?');
@define('PLUGIN_EVENTCAL_SHOWCAPTCHA_BLAHBLAH', 'Maj� se pou��vat kryptogramy (captchas - vy�aduje nainstalovan� a aktivovan� plugin Spamblock)');
@define('PLUGIN_EVENTCAL_NEXTPAGE', 'dal�� strana');
@define('PLUGIN_EVENTCAL_PREVPAGE', 'p�edchoz� strana');
@define('PLUGIN_EVENTCAL_TEXT_DELETE', 'smazat');
@define('PLUGIN_EVENTCAL_TEXT_SAY', '�ekl');
@define('PLUGIN_EVENTCAL_TEXT_EMAIL', 'Email');
@define('PLUGIN_EVENTCAL_TEXT_NAME', 'Jm�no');
@define('PLUGIN_EVENTCAL_TEXT_EACH', 'Ka�d�');
@define('PLUGIN_EVENTCAL_TEXT_TO', 'pro');
@define('PLUGIN_EVENTCAL_TEXT_CW', 'CW-');

@define('PLUGIN_EVENTCAL_HALLO_ADMIN', 'Dobr� den u�ivateli: %s ( %s )<br />');
@define('PLUGIN_EVENTCAL_INSERT_DONE_BLAHBLAH', 'D�ky za V� p��sp�vek ��slo ID = %d.');
@define('PLUGIN_EVENTCAL_INSERT_DONE_EVALUATE', 'P�edt�m ne� V� p��sp�vek schv�l� administr�tor, naleznete jej v ��sti: "Neschv�len� akce".');
@define('PLUGIN_EVENTCAL_REJECT_DONE_BLAHBLAH', '�p�n� jste vymazali p��sp�vek ��slo ID = %s z datab�ze.');
@define('PLUGIN_EVENTCAL_APPROVE_DONE_BLAHBLAH', 'P��sp�vek ��slo ID = %d byl �sp�n� schv�len.');

@define('CAL_EVENT_PLEASECORRECT', 'Opravte pros�m.');
@define('CAL_EVENT_SHORTTITLE', 'Vlo�te pros�m kr�tk� n�zev pro tuto akci!');
@define('CAL_EVENT_EVENTDESC', 'Zadejte pros�m pln� popis akce!');
@define('CAL_EVENT_APPBY', 'Mus�te zadat token autora (sig) pro potvrzen� akce!');
@define('CAL_EVENT_START_DATE', 'Nespr�vn� za��tek akce!');
@define('CAL_EVENT_START_DATE_HISTORY', 'Nespr�vn� datum akce! Zad�v�n� prob�hl�ch akc� je podporov�no pouze na uplynul�ch 31 dn�!');
@define('CAL_EVENT_END_DATE', 'Nespr�vn� konec akce!');
@define('CAL_EVENT_REAL_START_DATE', 'Datum za��tku akce mus� b�t platn� den dan�ho m�s�ce (%s)!');
@define('CAL_EVENT_REAL_END_DATE', 'Datum konce akce mus� b�t platn� den dan�ho m�s�ce (%s) a mus� b�t za datem za��tku!');
@define('CAL_EVENT_REAL_MONTHLY_DATE', 'Hodnota opakov�n� pro m�s��n� akce nem��e b�t "T�dn�"!');
@define('CAL_EVENT_IDENTICAL_DATE', 'Akce m� stejn� datum za��tku a konce!');
@define('CAL_EVENT_ORDER_DATE', 'Zadan� sekvence akce nen� platn�!');
@define('CAL_EVENT_WEEKLY_DATE', 'Spr�vn� hodnota m� b�t: "T�dn�" a vybran� "Den v t�dnu".');

@define('CAL_EVENT_FORM_DAY_FIRST', 'Prvn�');
@define('CAL_EVENT_FORM_DAY_SECOND', 'Druh�');
@define('CAL_EVENT_FORM_DAY_THIRD', 'T�et�');
@define('CAL_EVENT_FORM_DAY_FOURTH', '�tvrt�');
@define('CAL_EVENT_FORM_DAY_LAST', 'Posledn�');
@define('CAL_EVENT_FORM_DAY_SECONDLAST', 'P�edposledn�');
@define('CAL_EVENT_FORM_DAY_THIRDLAST', 'P�ed-p�edposledn�');
@define('CAL_EVENT_FORM_DAY_EACH', 'T�dn�');

@define('CAL_EVENT_FORM_RIGHT_SHORTMAX', 'max. 16 znak�!');
@define('CAL_EVENT_FORM_RIGHT_URLDESC', 'Bu� ');
@define('CAL_EVENT_FORM_RIGHT_URL', 'http://www.domena.cz');
@define('CAL_EVENT_FORM_RIGHT_MAIL', 'mailto:vas@email.cz');
@define('CAL_EVENT_FORM_RIGHT_OR', 'nebo');
@define('CAL_EVENT_FORM_RIGHT_DETAILDESC', '<b>Nezapom��te</b>, pros�m, zadat do tohoto pole p�esn� �as akce.');
@define('CAL_EVENT_FORM_RIGHT_BBC', 'Pou��t BBcode (tu�n�, kurz�va, podtr�en�, p�e�krtnut�).');
@define('CAL_EVENT_FORM_RIGHT_SINGLE', 'Pouze jeden den');
@define('CAL_EVENT_FORM_RIGHT_SINGLE_NOEND', 'nen� t�eba zad�vat datum konce');
@define('CAL_EVENT_FORM_RIGHT_MULTI', 'V�cedenn� akce');
@define('CAL_EVENT_FORM_RIGHT_RECUR', 'Opakov�n�');
@define('CAL_EVENT_FORM_RIGHT_RECUR_MONTH', 'ka�d� m�s�c');
@define('CAL_EVENT_FORM_RIGHT_RECUR_WEEK', 'ka�d� t�den');

@define('CAL_EVENT_FORM_BUTTON_ADD_EVENT', 'Vlo�te akci');
@define('CAL_EVENT_FORM_BUTTON_APPROVE_EVENT', 'Neschv�len� akce');
@define('CAL_EVENT_FORM_BUTTON_CLOSE', 'Zav��t formul��');
@define('CAL_EVENT_FORM_BUTTON_FREETABLE', 'vy�istit star� data (star�� ne� 1 m�s�c) a p�eskl�dat tabulku');
@define('CAL_EVENT_FORM_BUTTON_LOGOFF', 'odhl�sit');
@define('CAL_EVENT_FORM_BUTTON_MARK', 'ozna�it/odzna�it v�echny');
@define('CAL_EVENT_FORM_BUTTON_OPEN', 'Otev��t formul��');
@define('CAL_EVENT_FORM_BUTTON_REJECT_SED', 'Vymazat p��sp�vek schv�len� akce');
@define('CAL_EVENT_FORM_BUTTON_EDIT_SED', 'Zm�nit p��sp�vek schv�len� akce');
@define('CAL_EVENT_FORM_BUTTON_SUBMIT', '&raquo; Poslat p��sp�vek &laquo;');
@define('CAL_EVENT_FORM_BUTTON_TOAPPROVE', 'akce/akc�');

@define('CAL_EVENT_FORM_TITLE_DATE', 'datum');
@define('CAL_EVENT_FORM_TITLE_TITLE', 'nadpis');
@define('CAL_EVENT_FORM_TITLE_DESC', 'popis');
@define('CAL_EVENT_FORM_TITLE_URL', 'url');
@define('CAL_EVENT_FORM_TITLE_OK', 'ok');
@define('CAL_EVENT_FORM_TITLE_EDIT', 'upravit');
@define('CAL_EVENT_FORM_TITLE_DEL', 'smazat');

@define('CAL_EVENT_FORM_LEFT_AUTHOR', '<u>Autor</u>');
@define('CAL_EVENT_FORM_LEFT_TITLE', '<u>Kr�tk�</u> nadpis');
@define('CAL_EVENT_FORM_LEFT_LINK', 'Webov� str�nka nebo email');
@define('CAL_EVENT_FORM_LEFT_DESC', '<u>Pln�</u> popis');
@define('CAL_EVENT_FORM_LEFT_SINGLE', '<u>Za��tek</u> - datum');
@define('CAL_EVENT_FORM_LEFT_MULTI', '<u>Konec</u> - datum');
@define('CAL_EVENT_FORM_LEFT_RECUR', 'Opakov�n�');
@define('CAL_EVENT_FORM_LEFT_SPAM', 'Bezpe�nost');

@define('CAL_EVENT_DB_ERROR_ONE', 'V datab�zov� tabulce kalend��e akc� (eventcal) se vyskytla chyba:');
@define('CAL_EVENT_DB_ERROR_TWO', 'Nelze se spojit s datab�z�!');
@define('CAL_EVENT_USER_LOGINFIRST', 'Pro pokra�ov�n� procesu se mus�te p�ihl�sit pomoc� platn�ho ��tu na blogu. Pokud ho m�te, p�ihla�te se do administra�n� sekce blogu.');
@define('CAL_EVENT_USER_LOGINFIRST', 'Pro pokra�ov�n� procesu se mus�te p�ihl�sit pomoc� platn�ho ��tu na blogu. Pokud ho m�te, p�ihla�te se do administra�n� sekce blogu.');
@define('CAL_EVENT_USER_VALIDATION', 'U�ivatelsk� jm�no nebo heslo nen� spr�vn�.');
@define('CAL_EVENT_USER_LOGGEDOFF', 'Va�e seance vypr�ela nebo jste se odhl�sili. Pro administraci kalend��e akc� se mus�te znovu p�ihl�sit do blogu.');
@define('CAL_EVENT_USER_FREETABLE', 'Data star�� ne� 1 m�s�c byla �sp�n� smaz�na a datab�zov� tabulka p�eskl�d�na.');
@define('CAL_EVENT_USER_FREE_SURE', 'Opravdu chcete rekonstruovat datab�zovou tabulku kalend��e akc�?');
@define('CAL_EVENT_USER_NOPERMISSION', 'Nem�te dostate�n� opr�vn�n� k pokra�ov�n�!');
@define('CAL_EVENT_CHGSELECTED_ARRAY', 'Pokud chcete zm�nit jeden p��sp�vek, odzna�te pros�m ostatn�.');
@define('CAL_EVENT_CHECKBOXALERT', 'Za�krtn�te �tvere�ek u p��sp�vku, kter� chcete ohodnotit, zm�nit nebo smazat.');
@define('CAL_EVENT_TODAY', 'DNES');

@define('PLUGIN_EVENTCAL_CAL', ' Vykreslit kalend�� ');
@define('PLUGIN_EVENTCAL_ADD', ' Vykreslit add ');
@define('PLUGIN_EVENTCAL_APP', ' Vykreslit app ');

// Next lines were translated on 2009/11/29

@define('CAL_EVENT_FALSECAPTCHA', 'Kryptogram u Va�eho p��sp�vku se neshoduje!');

// Next lines were translated on 2010/02/14

@define('PLUGIN_EVENTCAL_SHOWINTRO', '�vodn� text (voliteln�)');
@define('PLUGIN_EVENTCAL_SHOWINTRO_BLAHBLAH', 'Text, kter� se zobrazuje p�ed p��sp�vky. (HTML povoleno)');
@define('PLUGIN_EVENTCAL_SHOWICAL', 'Exportovat iCal kan�l?');
@define('PLUGIN_EVENTCAL_SHOWICAL_BLAHBLAH', 'Pokud ano, bude povolen export iCal jako m�s��n� p�ehled a nebo jako jednotliv� ud�losti pomoc� tla��tek.');
@define('PLUGIN_EVENTCAL_ICAL_LOG', 'P�ihl�en� pro sta�en� iCal?');
@define('PLUGIN_EVENTCAL_ICAL_LOG_BLAHBLAH', 'Ur�uje, jestli iCal exporty budou zaznamen�ny do logu a zda-li se m� pos�lat ozn�men� administr�torovi. [pot�eba zada emailovou adresu]');
@define('PLUGIN_EVENTCAL_ICAL_LOG_EMAIL', 'Administr�torsk� emailov� adresa (v z�vislosti na nastaven� \'p�ihl�en� nastaven� na ano\' a/nebo \'iCal URL\')');
@define('PLUGIN_EVENTCAL_ICAL_LOG_EMAIL_BLAHBLAH', 'Va�e emailov� adresa, na kterou se budou pos�lat ozn�men� o iCa exportech.');
@define('PLUGIN_EVENTCAL_ICAL_ICSURL', 'Export iCal URL adresa?');
@define('PLUGIN_EVENTCAL_ICAL_ICSURL_BLAH', 'Nastavte, jak bude exportov�n vybran� iCal soubor.');
@define('PLUGIN_EVENTCAL_ICAL_ICSURL_BLAHBLAH', 'Sta�en�, u�ivatelsk� po�adavek webcal-push, email (na administr�torskou adresu, kter� mus� b�t n�e nastavena) nebo v�echny t�i. V tom p��pad� si u�ivatel vybere, kter� se mu hod� nejv�ce.');
@define('PLUGIN_EVENTCAL_ICAL_ICSURL_INLIST_NO', '��dn� ics soubor');
@define('PLUGIN_EVENTCAL_ICAL_ICSURL_INLIST_DL', 'ics sta�en�');
@define('PLUGIN_EVENTCAL_ICAL_ICSURL_INLIST_WEBCAL', 'ics pomoc� webcal://');
@define('PLUGIN_EVENTCAL_ICAL_ICSURL_INLIST_MAIL', 'ics p�es email');
@define('PLUGIN_EVENTCAL_ICAL_ICSURL_INLIST_USER', 'u�ivatel rozhodne');
@define('PLUGIN_EVENTCAL_ICAL_ICSURL_INLIST_EXPORT', 'u�ivateli');
@define('PLUGIN_EVENTCAL_ICAL_ICSURL_INLIST_INTERN', 'administr�torovi');
@define('PLUGIN_EVENTCAL_TEXT_INTERVAL', 'Interval');
@define('PLUGIN_EVENTCAL_TEXT_BIWEEK', '�trn�ct dn�');
@define('PLUGIN_EVENTCAL_TEXT_YEARLY', 'rok');
@define('PLUGIN_EVENTCAL_SENDMAIL_BLAHBLAH', 'iCal soubor byl �p�n� odesl�n!');
@define('PLUGIN_EVENTCAL_SENDMAIL_ERROR', 'P�i odes�l�n� emailu se vyskytla chyba!');
@define('CAL_EVENT_START_RECUR', 'Po��te�n� datum &raquo; <u>%s</u> &laquo; prvn� v�skyt!');
@define('CAL_EVENT_FORM_RIGHT_RECURSTRICT1', 'Pozor:');
@define('CAL_EVENT_FORM_RIGHT_RECURSTRICT2', 'p��sn� podle prvn�ho dne u v�ech opakuj�c�ch se ud�lost�!');
@define('CAL_EVENT_FORM_RIGHT_RECUR_BIWEEK', 'ka�d� druh� t�den');
@define('CAL_EVENT_FORM_RIGHT_RECUR_YEAR', 'ka�d� rok');
@define('CAL_EVENT_FORM_RIGHT_HELP_SINGLE', 'Jednotliv� ud�lost. \'Kone�n� datum\' ani ��dn� dal�� informace nen� pot�eba!');
@define('CAL_EVENT_FORM_RIGHT_HELP_MULTI', 'Multi-ud�lost: Zobrazovat m�s��n�. Vy�aduje \'Po��te�n� datum\' a \'Koncov� datum\'.');
@define('CAL_EVENT_FORM_RIGHT_HELP_WEEK', 'T�denn� ud�lost. Ur�it� je pot�eba nastavit. \'v�dy zapnuto\', \'T�dn�\' a a \'Den v t�dnu\'. Zobrazuje ka�d� kalend��n� t�den v m�s�ci. Vy�aduje \'Po��te�n� datum\' a \'koncov� datum\'.');
@define('CAL_EVENT_FORM_RIGHT_HELP_BIWEEK', '�trn�ctidenn� ud�lost. Ur�it� je t�eba zadat: \'v�dy zapnuto\', \'T�dn�\' a \'Den v t�dnu\'. Zobrazuje se ka�d� druh� kalend��n� t�den v m�s�ci. Vy�aduje \'Po��te�n� datum\' a \'Koncov� datum\'.');
@define('CAL_EVENT_FORM_RIGHT_HELP_MONTH', 'M�s��n� ud�lost. Ur�it� je t�eba zadat: \'v�dy zapnuto\', \'nt� Den\' a \'Den v t�dnu\'. Zobrazuje se ka�d� m�s�c. Vy�aduje \'Po��te�n� datum\' a \'Koncov� datum\'.');
@define('CAL_EVENT_FORM_RIGHT_HELP_YEAR', 'Ro�n� ud�lost. Zobrazuje se ro�n� od \'Po��te�n�ho data\'. Nepot�ebuje \'Koncov� datum\' ani ��dn� dal�� nastaven�!');
@define('CAL_EVENT_FORM_BUTTON_HELP_ICALM', 'Sta�en� ud�lost� iCal ze v sou�asn�m m�s�ci v�etn� v�ech opakuj�c�ch se ud�lost� z minulosti i budoucnosti.');

// Next lines were translated on 2010/03/06

@define('PLUGIN_EVENTCAL_ADMIN_NAME', 'Kalend�� ud�lost�');
@define('PLUGIN_EVENTCAL_ADMIN_NAME_MENU', 'Kalend�� ud�lost�  ver.%s - Administr�torsk� menu');
@define('PLUGIN_EVENTCAL_ADMIN_DBC', 'Kalend�� ud�lost� - Administrace pluginu');
@define('PLUGIN_EVENTCAL_ADMIN_VIEW', 'Kalend�� ud�lost� - Zobrazit schv�len� ud�losti');
@define('PLUGIN_EVENTCAL_ADMIN_VIEW_DESC', 'Seskupeno podle typu - jednotliv�, v�cedenn�, opakuj�c� se, t�denn�, ro�n�.');
@define('PLUGIN_EVENTCAL_ADMIN_APP', 'Kalend�� ud�lost� - Zobrazit neschv�len� ud�losti');
@define('PLUGIN_EVENTCAL_ADMIN_APP_DESC', 'Seskupit podle Po��te�n�ho data [nejnov�j�� naho�e].');
@define('PLUGIN_EVENTCAL_ADMIN_ERASE', 'Kalend�� ud�lost� - Vymazat ud�losti');
@define('PLUGIN_EVENTCAL_ADMIN_LOG', 'Kalend�� ud�lost� - iCal Log');
@define('PLUGIN_EVENTCAL_ADMIN_LOG_ERROR', 'POZOR: P�i zapisov�n� iCal logovac�ho souboru se vyskytla chyba. Zkontrolujte, co je �patn� (m� adres�� a soubor nastaven� pr�va pro z�pis?)!');
@define('PLUGIN_EVENTCAL_ADMIN_ADD', 'Kalend�� ud�lost� - Vlo�en� nov� ud�losti');
@define('PLUGIN_EVENTCAL_ADMIN_NORESULT', '��dn� ud�losti ne�ekaj� na %s!');
@define('PLUGIN_EVENTCAL_ADMIN_NORESULT_APP', 'schv�len�');
@define('PLUGIN_EVENTCAL_ADMIN_NORESULT_DROP', 'vymaz�n�');
@define('PLUGIN_EVENTCAL_ADMIN_NORESULT_FREE', 'vy�i�t�n�');
@define('PLUGIN_EVENTCAL_ADMIN_FREE_SURE', 'Ur�it� chcete odstranit star� ud�losti z datab�zov� tabulky ud�lost�?');
@define('PLUGIN_EVENTCAL_ADMIN_CLEAN_SURE', 'Ur�it� chcete nastavit novou hodnotu autoincrementu (id) pro v�echna data v datab�zov� tabulce kalend��e ud�lost�?');
@define('PLUGIN_EVENTCAL_ADMIN_CLEAN_SURE_ADD', '<u>Upozorn�n�:</u> M��e to m�t negativn� dopady na cachovan� data ve vyhled�va��ch a podobn�ch slu�b�ch mimo V� blog!');
@define('PLUGIN_EVENTCAL_ADMIN_DROP_SURE', 'Ur�it� chcete smazat celou tabulku kalend��e ud�lost� v�etn� v�ch dat? Potvr�te pros�m zde!');
@define('PLUGIN_EVENTCAL_ADMIN_DROP_OK', 'Va�e %s datab�zov� tabulka byla �spa�n� vymaz�na!');
@define('PLUGIN_EVENTCAL_ADMIN_DUMP_SELF', 'P�ed pokra�ov�n�m byste m�li pro jistotu ud�lat mysql dump pomoc� PhpMyAdmina!');
@define('PLUGIN_EVENTCAL_ADMIN_ICAL_EMAILLINK', 'St�hn�te v�echny schv�len� ud�losti jako ics soubor pomoc� emailu na administr�torskou adresu, pokud je nastaven� v konfiguraci tohoto pluginu! Ujist�te se, �e je zadan�!');
@define('PLUGIN_EVENTCAL_ADMIN_ICAL_DOWNLINK', 'St�hnout v�echny schv�len� ud�losti jako ics soubor!');
@define('PLUGIN_EVENTCAL_ADMIN_DBC_TITLE', 'Pou��vejte pros�m tento administra�n� panel opatrn�.');
@define('PLUGIN_EVENTCAL_ADMIN_DBC_TITLE_DESC', 'N�kter� odkazy mohou b�t v p��t�ch verz�ch vylep�eny!');
@define('PLUGIN_EVENTCAL_ADMIN_DBC_DUMP', 'Administrace - dump');
@define('PLUGIN_EVENTCAL_ADMIN_DBC_DUMP_DESC', 'z�lohujte tabulky kalend��e akc� z datab�ze');
@define('PLUGIN_EVENTCAL_ADMIN_DBC_DUMP_TITLE', 'z�lohujte (dump v�pis) data z datab�ze kalend��e akc�');
@define('PLUGIN_EVENTCAL_ADMIN_DBC_DUMP_MSG', 'Proto�e to nen� jednoduch� akce, pou�ijte pros�m administr�torsk� n�stroje jako PhpMyAdmin k dumpu dat!');
@define('PLUGIN_EVENTCAL_ADMIN_DBC_INSERT', 'Administrace - vlo�en�');
@define('PLUGIN_EVENTCAL_ADMIN_DBC_INSERT_DESC', 'vlo�en� dat do datab�zov� tabulky kalend��e akc�');
@define('PLUGIN_EVENTCAL_ADMIN_DBC_INSERT_TITLE', 'vlo�en� hodnot do datab�ze kalend��e akc�');
@define('PLUGIN_EVENTCAL_ADMIN_DBC_INSERT_MSG', 'Proto�e to nen� jednoduch� operace, pou�ijte pros�m administra�n� n�stroje jako PhpMyAdmin pro znovu napln�n� datab�ze!');
@define('PLUGIN_EVENTCAL_ADMIN_DBC_ERASE', 'Administrace - vymaz�n�');
@define('PLUGIN_EVENTCAL_ADMIN_DBC_ERASE_DESC', 'odstranit tabulky kalend��e akc� z datab�ze');
@define('PLUGIN_EVENTCAL_ADMIN_DBC_ERASE_TITLE', 'vymazat datab�zi kalend��e akc�');
@define('PLUGIN_EVENTCAL_ADMIN_DBC_DELOLD', 'Administrace - �i�t�n�');
@define('PLUGIN_EVENTCAL_ADMIN_DBC_DELOLD_DESC', 'odstranit ud�losti star�� ne� 1 m�s�c z datab�zov� tabulky kalend��e akc�');
@define('PLUGIN_EVENTCAL_ADMIN_DBC_DELOLD_TITLE', 'smazat data star�� ne� 1 m�s�c z datab�zov� tabulky');
@define('PLUGIN_EVENTCAL_ADMIN_DBC_DELOLD_MSG', 'Z datab�zov� tabulky jste odstranili %d star�ch ud�lost� star��ch ne� 30 dn�.');
@define('PLUGIN_EVENTCAL_ADMIN_DBC_INCREMENT', 'Administrace - increment');
@define('PLUGIN_EVENTCAL_ADMIN_DBC_INCREMENT_DESC', 'Nastavte nov� autoincrement id identifik�tory v datab�zov� tabulce kalend��e akc�');
@define('PLUGIN_EVENTCAL_ADMIN_DBC_INCREMENT_TITLE', 'nastavit nov� autoincrement id v datab�zov� tabulce');
@define('PLUGIN_EVENTCAL_ADMIN_DBC_INCREMENT_MSG', 'Restrukturalizovali jste datab�zovou tabulku s %d zb�vaj�c�mi hodnotami.');
@define('PLUGIN_EVENTCAL_ADMIN_DBC_ICALALL', 'Administrace - iCal');
@define('PLUGIN_EVENTCAL_ADMIN_DBC_ICALALL_DESC', 'po�lete v�echny ud�losti jako iCal soubor administr�torovi - pomoc� emailu, pokud je zad�n v nastaven�, jinak pomoc� downloadu');
@define('PLUGIN_EVENTCAL_ADMIN_DBC_ICALALL_TITLE', 'poslat iCal pomoc� emailu, nebo st�hnout');
@define('PLUGIN_EVENTCAL_ADMIN_DBC_ILOG', 'Administrace - iLog');
@define('PLUGIN_EVENTCAL_ADMIN_DBC_ILOG_DESC', 'zobrazit iLog souboru exportu pomoc� iCal, pokud je');
@define('PLUGIN_EVENTCAL_ADMIN_DBC_ILOG_TITLE', 'zobrazit logovac� soubor iCal exportu');
@define('PLUGIN_EVENTCAL_ADMIN_DBC_ILOG_MSG', 'Soubor iLog neexistuje!');
@define('PLUGIN_EVENTCAL_ADMIN_DBC_NIXDA_DESC', 'v datab�zi nen� ��dn� tabulka kalend��e akc�');
@define('PLUGIN_EVENTCAL_ADMIN_DBC_NIXDA_TITLE', 'Administrace - chyba');

// Next lines were translated on 2011/03/05
@define('PLUGIN_EVENTCAL_ADMIN_ORDERBY_DESC', 'Seskupeno podle typu akce (�asov� zna�ky) sestupn�.');
@define('PLUGIN_EVENTCAL_ADMIN_DBC_DUMP_DONE', 'Datab�ze kalend��e akc� byla �sp�n� z�lohov�na!');
@define('PLUGIN_EVENTCAL_ADMIN_DBC_DELFILE_MSG', 'Soubor z�lohy datab�zov� tabulky <u>%s</u> �sp�n� vymaz�n');
@define('PLUGIN_EVENTCAL_ADMIN_DBC_DOWNLOAD', 'Administrace - management');
@define('PLUGIN_EVENTCAL_ADMIN_DBC_DOWNLOAD_DESC', 'Sta�en� a vymaz�n� z�loh datab�zov� tabulky kalend��e akc�');
@define('PLUGIN_EVENTCAL_ADMIN_DBC_DOWNLOAD_MSG', 'V adres��i "templates_c" nen� ��dn� adres�� "eventcal".');

