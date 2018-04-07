<?php

/**
 *  @author Vladim�r Ajgl <vlada@ajgl.cz>
 *  @translated 2009/06/27
 *  @author Vladim�r Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2010/09/12
 */

@define('PLUGIN_EVENT_FORGOTPASSWORD_NAME', 'Zapomenut� heslo');
@define('PLUGIN_EVENT_FORGOTPASSWORD_DESC', 'Vybran�mu u�ivateli umo��uje zm�nit heslo.');
@define('PLUGIN_EVENT_FORGOTPASSWORD_LOST_PASSWORD', 'Zapomenut� heslo?');
@define('PLUGIN_EVENT_FORGOTPASSWORD_ENTER_USERNAME', 'Zadejte p�ihla�ovac� jm�no k ��tu se zapomenut�m heslem');
@define('PLUGIN_EVENT_FORGOTPASSWORD_ENTER_PASSWORD', 'Zadejte nov� heslo');
@define('PLUGIN_EVENT_FORGOTPASSWORD_SEND_EMAIL', 'Poslat email');
@define('PLUGIN_EVENT_FORGOTPASSWORD_EMAIL_SUBJECT', 'Zapomenut� heslo');
@define('PLUGIN_EVENT_FORGOTPASSWORD_EMAIL_BODY', 'N�kdo (pravd�podobn� ty s�m) chce zm�nit heslo pro p��stup do blogu.'."\n".'pokud chcete zm�nit heslo, klikn�te na n�sleduj�c� odkaz:'."\n");
@define('PLUGIN_EVENT_FORGOTPASSWORD_EMAIL_DB_ERROR', 'Nezda�ilo se p�ipojen� do datab�ze');
@define('PLUGIN_EVENT_FORGOTPASSWORD_EMAIL_CANNOT_SEND', 'Nepoda�ilo se poslat mail, pravd�podobn� kv�li chybn�mu nastaven� SMPT serveru v php.ini</br>'."\n".'nebo proto�e jste ve sv�m u�ivatelsk�m profilu nezadali platnou emailovou adresu.');
@define('PLUGIN_EVENT_FORGOTPASSWORD_EMAIL_SENT', 'Email �sp�n� odesl�n. Zkontrolujte svoji mailovou schr�nku.');
@define('PLUGIN_EVENT_FORGOTPASSWORD_CHANGE_PASSWORD', 'Zm�nit heslo');
@define('PLUGIN_EVENT_FORGOTPASSWORD_PASSWORD_CHANGED', 'Heslo �sp�n� zm�n�no');
@define('PLUGIN_EVENT_FORGOTPASSWORD_USER_NOT_EXIST', 'Zadan� u�ivatelsk� jm�no v datab�zi nen�. Vra�te se a zkuste to znovu.');

// Next lines were translated on 2010/09/12
@define('PLUGIN_EVENT_FORGOTPASSWORD_MAILER_MAIL', 'Poslat ozn�men� mailem, kdy� se u�ivatel pokus� zm�nit heslo bez zad�n� mailov� adresy?');
@define('PLUGIN_EVENT_FORGOTPASSWORD_MAILER_MAILTXT', 'Obsah oznamovac�ho mailu');
@define('PLUGIN_EVENT_FORGOTPASSWORD_MAILER_MAILTXT_DEFAULT', 'U�ivatel "%s" se pokusil p�ihl�sit, ale nezadal emailovou adresu. Vytvo�te pros�m nov� heslo a kontaktujte u�ivatele.');
@define('PLUGIN_EVENT_FORGOTPASSWORD_MAILER', 'Chybov� zpr�va, pokud neexistuje emailov� adresa.');
@define('PLUGIN_EVENT_FORGOTPASSWORD_MAILER_DEFAULT', 'Pro u�ivatele nebyla zad�na ��dn� emailov� adresa. Nov� heslo nemohlo b�t posl�no mailem.');

