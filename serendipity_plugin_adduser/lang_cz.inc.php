<?php

/**
 *  @author Vladim�r Ajgl <vlada@ajgl.cz>
 *  @translated 2009/02/18
 *  @author Vladim�r Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2013/03/13
 *  @author Vladim�r Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2013/04/20
 */

@define('PLUGIN_ADDUSER_NAME',		'Samoregistrace nov�ch u�ivatel�');
@define('PLUGIN_ADDUSER_DESC',		'Umo��uje n�v�t�vn�k�m webu vytvo�it si vlastn� u�ivatelsk� ��et. Dohromady s pluginem ud�lost� (index.php?serendipity[subpage]=adduser) m��ete ur�it, jestli koment��e mohou pos�lat pouze registrovan� u�ivatel�.');
@define('PLUGIN_ADDUSER_INSTRUCTIONS',		'Dal�� pokyny');
@define('PLUGIN_ADDUSER_INSTRUCTIONS_DESC',		'Zde p�idejte pokyny, kter� se maj� objevit vedle formul��e pro vytvo�en� u�ivatelsk�ho ��tu.');
@define('PLUGIN_ADDUSER_INSTRUCTIONS_DEFAULT',		'Zde se m��ete zaregistrovat do blogu jako nov� u�ivatel. Jednodu�e zadejte sv� data, potvr�te formul�� a �i�te se dal��mi pokyny, kter� V�m p�ijdou mailem.');
@define('PLUGIN_ADDUSER_USERLEVEL',		'V�choz� u�ivatelsk� �rove�');
@define('PLUGIN_ADDUSER_USERLEVEL_DESC',		'Jakou u�ivatelskou �rove� (opr�vn�n�) m� m�t nov� u�ivatel');
@define('PLUGIN_ADDUSER_USERLEVEL_CHIEF',		'��fredaktor');
@define('PLUGIN_ADDUSER_USERLEVEL_EDITOR',		'Autor');
@define('PLUGIN_ADDUSER_USERLEVEL_ADMIN',		'Administr�tor');
@define('PLUGIN_ADDUSER_USERLEVEL_DENY',		'P��stup odep�en');
@define('PLUGIN_SIDEBAR_LOGIN',		'Zobrazit p�ihla�ovac� formul�� v postrann�m sloupci?');
@define('PLUGIN_SIDEBAR_LOGIN_DESC',		'Pokud je povoleno, v postrann�m sloupci se budou zobrazovat blok s p�ihla�ovac�m formul��em. Pokud je zak�z�no, budou se muset u�ivatel� registrovat pomoc� zvl�tn� str�nky v odpov�daj�c�m pluginu ud�lost�.');

@define('PLUGIN_ADDUSER_EXISTS',		'Omlouv�me se, jm�no "%s" u� n�kdo jin� pou��v�. Vyberte si pros�m jin�.');
@define('PLUGIN_ADDUSER_MISSING',		'Mus�te vyplnit v�echna pole, aby V�m mohl b�t vytvo�en nov� ��et.');
@define('PLUGIN_ADDUSER_SENTMAIL',		'V� ��et byl vytvo�en. B�hem n�kolika okam�ik� byste m�li obdr�et email se souhrnem nejd�le�it�j��ch informac�.');
@define('PLUGIN_ADDUSER_WRONG_ACTIVATION',		'Nespr�vn� aktiva�n� URL adresa!');

@define('PLUGIN_ADDUSER_MAIL_SUBJECT',		'Nov� u�ivatelsk� ��et byl vytvo�en');
@define('PLUGIN_ADDUSER_MAIL_BODY',		"Nov� u�ivatelsk� ��et %s byl pr�v� vytvo�en na blogu %s. Pro aktivaci toho ��tu pros�m klikn�te na n�sleduj�c� odkaz:\n\n%s\n\nPot� se m��ete p�ihl�sit pomoc� d��ve zadan�ho jm�na a hesla. Tento email byl posl�n jak nov�mu u�ivateli, tak provozovateli blogu.");
@define('PLUGIN_ADDUSER_SUCCEED',		'��et byl �sp�n� aktivov�n. Nyn� se m��ete p�ihl�sit do administr�torsk� sekce blogu. odkaz na p�ihla�ovac� str�nku je uveden v aktiva�n�m emailu.');
@define('PLUGIN_ADDUSER_FAILED',		'��et nemohl b�t aktivov�n. Neopsali jste �patn� URL adresu z aktiva�n�ho emailu?');

@define('PLUGIN_ADDUSER_REGISTERED_ONLY',		'Koment��e sm� pos�lat pouze registrovan� u�ivatel�?');
@define('PLUGIN_ADDUSER_REGISTERED_ONLY_DESC',		'Pokud je povoleno, koment��e k p��sp�vk�m mohou pos�lat pouze registrovan� a p�ihl�en� u�ivatel�.');
@define('PLUGIN_ADDUSER_REGISTERED_ONLY_REASON',		'Koment��e mohou pos�lat pouze registrovan� u�ivatel�. <a href="%s">Zalo�te si ��et</a> a pak se <a href="%s">p�ihla�te do blogu</a>. V� prohl�e� mus� podporovat cookies.');

@define('PLUGIN_ADDUSER_STRAIGHT',		'Okam�it� vlo�en�?');
@define('PLUGIN_ADDUSER_STRAIGHT_DESC',		'Pokud je povoleno, u�ivatel bude okam�it� po registraci vlo�en jako aktivovan� autor. Tato volba je doporu�ena pouze na serverech, kde nen� p��tomen mailserver. Toto nastaven� m��e b�t lehce zneu�ito spamery. Zapn�te jen pokud dob�e v�te, co d�l�te!');

@define('PLUGIN_ADDUSER_REGISTERED_CHECK',		'Ochrana p�ed fal�ov�n�m identity');
@define('PLUGIN_ADDUSER_REGISTERED_CHECK_DESC',		'Pokud je povoleno, u�ivatelsk� jm�na zaregistrovan�ch autor� mohou pou��vat pouze tito auto�i, nav�c mus� b�t pod t�mto jm�nem p�ihl�eni.');
@define('PLUGIN_ADDUSER_REGISTERED_CHECK_REASON',		'Jm�no, kter� jste zadali, pat�� jin�mu u�ivateli registrovan�mu na tomto blogu. <a href="%s" %s>P�ihla�te se pros�m</a>, abyste mohli poslat p��sp�vek pod Va��m jm�nem. Pokud nem�te zaregistrovan� ��et pod v��e uveden�m jm�nem, pou�ijte pros�m jin� jm�no.');

@define('PLUGIN_ADDUSER_ADMINAPPROVE',		'Registrovan� u�ivatel� mus� m�t potvrzen� administr�tora?');
@define('PLUGIN_ADDUSER_ADMINAPPROVE_DESC',		'Pokud je zapnuto, administr�tor mus� nov�ho u�ivatele nejd��ve potvrdit, teprve pak mu bude odesl�n aktiva�n� email.');
@define('PLUGIN_ADDUSER_SENTMAIL_APPROVE',		'V� ��et by vytvo�en. Pot�, co V� ��et schv�l� administr�tor, V�m bude zasl�n email se souhrnem d�le�it�ch informac�.');
@define('PLUGIN_ADDUSER_SENTMAIL_APPROVE_ADMIN',		'��et byl potvrzen, u�ivateli byl zasl�n email s �daji o jeho ��tu.');
@define('PLUGIN_ADDUSER_MAIL_SUBJECT_APPROVE',		'[Potvrzen� vy�adov�no] Nov� u�ivatelsk� ��et byl vytvo�en');
@define('PLUGIN_ADDUSER_MAIL_BODY_APPROVE',		"Nov� u�ivatelsk� ��et se jm�nem %s byl vytvo�en na blogu %s. Pro potvrzen� ��tu, a aby si mohl u�ivatel ��et aktivovat, klikn�te na n�sleduj�c� odkaz:\n\n%s\n\nPot�, co tak u�in�te, nov� u�ivatel obdr�� aktiva�n� email s nezbytn�mi informacemi pro p�ihl�en�.");

@define('PLUGIN_ADDUSER_CAPTCHA',		'Pou��t kryptogramy');
@define('PLUGIN_ADDUSER_CAPTCHA_DESC',		'Vy�aduje nainstalovan� plugin ud�lost� "spamblock".');

@define('PLUGIN_ADDUSER_ANTISPAM',		'Nepro�li jste protispamov�m testem. Pros�m zkontrolujte, jestli jste spr�vn� opsali KRYPTOGRAM.');

// Next lines were translated on 2013/03/13

@define('PLUGIN_ADDUSER_REGISTERED_ONLY_GROUP',		'P��davn� funkce: Pouze registrovan� u�ivatel� z t�to skupiny sm� p�id�vat koment��e?');
@define('PLUGIN_ADDUSER_REGISTERED_ONLY_GROUP_DESC',		'Abyste toto mohli pou��t, mus�te z�rove� povolit volbu "Koment��e sm� pos�lat pouze registrovan� u�ivatel�". Pokud je tato volba zapnut�, pak mohou pos�lat koment��e pouze u�ivatel� ze specifick� skupiny u�ivatel� a mus� k tomu b�t p�ihl�eni.');

