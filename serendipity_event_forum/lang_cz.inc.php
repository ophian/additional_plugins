<?php

/**
 *  @author Vladim�r Ajgl <vlada@ajgl.cz>
 *  @translated 2009/05/15
 */

@define('PLUGIN_FORUM_TITLE', 'Diskusn� f�rum / zrcadlen� phpBB f�ra');
@define('PLUGIN_FORUM_DESC', 'Poskytuje kompletn� diskusn� f�rum. Alternativ� umo��uje p��stup do diskusn�ho f�ra phpBB.');
@define('PLUGIN_FORUM_PAGETITLE', 'Titulek str�nky');
@define('PLUGIN_FORUM_PAGETITLE_BLAHBLAH', 'TItule str�nky s diskusn�m f�rem, tj. informace v horn�m pruhu okna prohl�e�e');
@define('PLUGIN_FORUM_HEADLINE', 'Nadpis');
@define('PLUGIN_FORUM_HEADLINE_BLAHBLAH', 'Hlavn� nadpis str�nky s f�rem');
@define('PLUGIN_FORUM_PAGEURL', 'Statick� URL adresa');
@define('PLUGIN_FORUM_PAGEURL_BLAHBLAH', 'Definujte statickou URL adresu, pod kterou bude f�rum dostupn� (index.php?serendipity[subpage]={zde zadan� jm�no})');
@define('PLUGIN_FORUM_UPLOADDIR', 'Absolutn� cesta vzhledem ke ko�enov�mu adres��i serveru do adres��e s nahran�mi soubory (upload)');
@define('PLUGIN_FORUM_UPLOADDIR_BLAHBLAH', 'v�choz�: '. $serendipity['serendipityPath'].'files');
@define('PLUGIN_FORUM_DATEFORMAT', 'Form�t data zobrazovan�ho u p��sp�vk�, lze pou��t libovoln� form�t platn� pro PHP funkci date(). (V�choz�: "Y/m/d")');
@define('PLUGIN_FORUM_TIMEFORMAT', 'Form�tov�n� �asu');
@define('PLUGIN_FORUM_TIMEFORMAT_BLAHBLAH', 'Form�t �asu zobrazovan�ho u p��sp�vk�, lze pou��t libovoln� form�t platn� pro PHP funkci date(). (V�choz�: "h:ia")');
@define('PLUGIN_FORUM_BGCOLOR_HEAD', 'Barva pozad� pro pruh s titulkem');
@define('PLUGIN_FORUM_BGCOLOR_HEAD_BLAHBLAH', 'Barva pozad� v�ech titulkov�ch pruh�');
@define('PLUGIN_FORUM_BGCOLOR1', '1. barva pozad�');
@define('PLUGIN_FORUM_BGCOLOR2', '2. barva pozad�');
@define('PLUGIN_FORUM_APPLY_MARKUP', 'Maj� se ve f�ru pou��vat zna�kovac� pluginy?');
@define('PLUGIN_FORUM_APPLY_MARKUP_BLAHBLAH', 'Pokud "Ano", pak se v�echny pou�it� zna�kovac� pluginy (BBCode, smajl�ci, galleryimage, atd.) budou pou��vat i v p��sp�vc�ch na f�ru.');
@define('PLUGIN_FORUM_ITEMSPERPAGE', 'Po�et polo�ek na str�nce');
@define('PLUGIN_FORUM_ITEMSPERPAGE_BLAHBLAH', 'Kolik polo�ek (vl�ken/p��sp�vk�) se m� zobrazovat na str�nce. (V�choz�: 15)');
@define('PLUGIN_FORUM_USE_CAPTCHAS', 'Pou��vat plugin Spamblock');
@define('PLUGIN_FORUM_USE_CAPTCHAS_BLAHBLAH', 'M� se pou��t plugin Spamblock i ve f�ru? (tj. kryptogramy p�i odes�l�n� p��sp�vku)');
@define('PLUGIN_FORUM_UNREG_NOMARKUPS', 'Zak�zat pou��v�n� zna�kovac�ch plugin� nep�ihl�en�m u�ivatel�m');
@define('PLUGIN_FORUM_UNREG_NOMARKUPS_BLAHBLAH', 'M� b�t pou��v�n� zna�kovac�ch plugin� umo�n�no pouze registrovan�m p�isp�vatel�m?');
@define('PLUGIN_FORUM_FILEUPLOAD_REGUSER', 'Povolit nahr�v�n� soubor� v�em registrovan�m u�ivatel�m.');
@define('PLUGIN_FORUM_FILEUPLOAD_REGUSER_BLAHBLAH', 'M� se registrovan�m u�ivatel�m povolit nahr�v�n� soubor�?');
@define('PLUGIN_FORUM_FILEUPLOAD_GUEST', 'Povolit nahr�v�n� soubor� nep�ihl�en�m n�v�t�vn�k�m');
@define('PLUGIN_FORUM_FILEUPLOAD_GUEST_BLAHBLAH', 'M� se nahr�v�n� povolit i nep�ihl�en�m n�v�t�vn�k�m? (d�razn� NEdoporu�eno!!!)');
@define('PLUGIN_FORUM_HOW_MANY_FILES_IN_ONE_POST', 'Maxim�ln� po�et soubor� u jednoho p��sp�vku');
@define('PLUGIN_FORUM_HOW_MANY_FILES_IN_ONE_POST_BLAHBLAH', 'Jak� nejvy��� mno�stv� soubor� lze p�ilo�it k jednomu p��sp�vku ve f�ru?');
@define('FORUM_HOW_MANY_FILEUPLOADS_WHEN_POSTING', 'Po�et sou�asn�ch upload�');
@define('FORUM_HOW_MANY_FILEUPLOADS_WHEN_POSTING_BLAHBLAH', 'Kolik soubor� je mo�n� nahr�t (uploadovat) p�i psan� nebo editaci p��sp�vku?');
@define('FORUM_PLUGIN_HOW_MANY_FILEUPLOADS_AT_ALL', 'Kolik nahran�ch soubor� (upload�) na u�ivatele?');
@define('FORUM_PLUGIN_HOW_MANY_FILEUPLOADS_AT_ALLBLAHBLAH', 'Kolik soubor� celkem m��e nahr�t jeden u�ivatel? Pozor: pokud povol�te nahr�v�n� soubor� i nep�ihl�en�m u�ivatel�m, ti budou moci nahr�t kolik soubor� cht�j�, proto�e tato volba nedok�e ohl�dat mno�stv� soubor� nahran�ch nep�ihl�en�mi u�ivateli!!!');
@define('FORUM_PLUGIN_NOTIFYMAIL_FROM', 'Maily s ozn�men�mi: odes�latel');
@define('FORUM_PLUGIN_NOTIFYMAIL_FROM_BLAHBLAH', 'Mailov� adresa, kter� bude v mailech s ozn�men�mi z f�ra uvedena jako odes�latel.');
@define('FORUM_PLUGIN_NOTIFYMAIL_NAME', 'Maily s ozn�men�mi: Jm�no odes�latele');
@define('FORUM_PLUGIN_NOTIFYMAIL_NAME_BLAHBLAH', 'Jm�no odes�latele mail� s ozn�men�m');
@define('FORUM_PLUGIN_ADMIN_NOTIFY', 'Ozn�men� pro administr�tora');
@define('FORUM_PLUGIN_ADMIN_NOTIFY_BLAHBLAH', 'M� se administr�torovi blogu poslat mailem ozn�men�, pokud je posl�n nov� p��sp�vek nebo odpov��?');
@define('PLUGIN_FORUM_COLORTODAY', 'Barva n�pisu "Dnes"');
@define('PLUGIN_FORUM_COLORYESTERDAY', 'Barva n�pisu "V�era"');


@define('PLUGIN_FORUM_NO_BOARDS', '��dn� f�ra nebyla je�t� zalo�ena!');
@define('PLUGIN_FORUM_NO_ENTRIES', 'F�rum neobsahuje ��dn� diskuzn� vl�kna');
@define('PLUGIN_FORUM_BOARDS', 'Diskuzn� f�ra');
@define('PLUGIN_FORUM_THREADS', 'Diskuzn� vl�kna');
@define('PLUGIN_FORUM_POSTS', 'P��sp�vky');
@define('PLUGIN_FORUM_NO_POSTS', 'Toto diskuzn� vl�kno zat�m neobsahuje p��sp�vky!');
@define('PLUGIN_FORUM_LASTPOST', 'Nejnov�j�� p��sp�vek');
@define('PLUGIN_FORUM_LASTREPLY', 'Nejnov�j�� odpov��');
@define('PLUGIN_FORUM_NO_THREADS', 'Nebyla nalezena ��dn� diskuzn� vl�kna');
@define('PLUGIN_FORUM_THREADTITLE', 'Nadpis diskuzn�ho vl�kna');
@define('PLUGIN_FORUM_POSTTITLE', 'Nadpis');
@define('PLUGIN_FORUM_REPLIES', 'Odpov�di');
@define('PLUGIN_FORUM_VIEWS', 'Zobrazen�');
@define('PLUGIN_FORUM_NO_REPLIES', '��dn� odpov�di');
@define('PLUGIN_FORUM_AUTHOR', 'Autor');
@define('PLUGIN_FORUM_MESSAGE', 'Zpr�va');
@define('PLUGIN_FORUM_BACKTOTOP', 'Zp�t nahoru');
@define('PLUGIN_FORUM_ALT_REOPEN', 'Znovu otev��t vl�kno...');
@define('PLUGIN_FORUM_ALT_CLOSE', 'Zav��t vl�kno...');
@define('PLUGIN_FORUM_ALT_MOVE', 'P�esunout toto diskuzn� vl�kno di jin�ho diskuzn�ho f�ra...');
@define('PLUGIN_FORUM_ALT_DELETE', 'Smazat p��sp�vek...');
@define('PLUGIN_FORUM_ALT_DELETE_POST', 'Vyma�e tento p��sp�vek z f�ra...');
@define('PLUGIN_FORUM_ALT_REPLY', 'Odpov�d�t v tomto vl�knu...');
@define('PLUGIN_FORUM_ALT_QUOTE', 'Odpov�d�t v tomto vl�knu s citac� tohoto p��sp�vku...');
@define('PLUGIN_FORUM_ALT_EDIT', 'Editovat p��sp�vek...');
@define('PLUGIN_FORUM_ALT_DELETE', 'Smazat p��sp�vek...');
@define('PLUGIN_FORUM_ALT_UNREAD', 'je�t� nebylo p�e�teno nebo p�ibyly nov� odpov�di...');
@define('PLUGIN_FORUM_ALT_READ', 'ji� p�e�teno...');
@define('PLUGIN_FORUM_ALT_DIRECTGOTOPOST', 'p�ej�t p��mo na p��sp�vek...');
@define('PLUGIN_FORUM_MARKUPS', 'N�sleduj�c� zna�kovac� jazyky mohou b�t pou�ity, pokud je administr�tor povolil: <br />&nbsp; - <a href=\"http://www.s9y.org/forums/faq.php?mode=bbcode\" target=\"_blank\" rel=\"noopener\">BBCode</a><br />&nbsp; - Smajl�ci<br />&nbsp; - GalleryImage<br />');
@define('PLUGIN_FORUM_GUEST', 'Host');
@define('PLUGIN_FORUM_CONFIRM_DELETE_POST', 'Opravdu chcete smazat tento p��sp�vek?');
@define('PLUGIN_FORUM_ORDER', 'Se�adit');
@define('PLUGIN_FORUM_BOARDNAME', 'Jm�no f�ra');
@define('PLUGIN_FORUM_BOARDDESC', 'Popis');
@define('PLUGIN_FORUM_REALLY_DELETE_BOARDS', 'Opravdu chcete smazat {num} diskuzn�ch f�r?');
@define('PLUGIN_FORUM_REALLY_DELETE_THREAD', 'Opravdu chcete smazat diskuzn� vl�kno?');
@define('PLUGIN_FORUM_DELETE_OR_MOVE', 'Maj� se diskuzn� vl�kna smazat nebo p�esunout do jin�ho f�ra?');
@define('PLUGIN_FORUM_WHERE_TO_MOVE', 'Vyberte diskuzn� f�rum nebo je sma�te:');
@define('PLUGIN_FORUM_ADD_BOARD', 'P�idat nov� f�rum');
@define('PLUGIN_FORUM_PAGES', 'Str�nky');
@define('PLUGIN_FORUM_MOVE_THREAD', 'Do kter�ho f�ra chcete p�esunout diskuzn� vl�kno?');
@define('PLUGIN_FORUM_MOVE', 'P�esun');
@define('PLUGIN_FORUM_FROM_BOARD', 'z f�ra');
@define('PLUGIN_FORUM_TO_BOARD', 'do f�ra');
@define('PLUGIN_FORUM_SUBMIT', 'Potvrdit');
@define('PLUGIN_FORUM_RESET', 'Zru�it');
@define('PLUGIN_FORUM_REG_USER', 'Registrovan� u�ivatel');
@define('PLUGIN_FORUM_POSTS', 'P��sp�vky');
@define('PLUGIN_FORUM_VISITS', 'N�v�t�vy');
@define('PLUGIN_FORUM_UPLOAD_FILE','nahr�n� souboru');
@define('PLUGIN_FORUM_DOWNLOADCOUNT', 'Soubory ke sta�en�:');
@define('PLUGIN_FORUM_REST_UPLOAD_USER', 'soubor� lze je�t� nahr�t');
@define('PLUGIN_FORUM_REST_UPLOAD_POST', 'soubor� lze je�t� nahr�t do tohoto p��sp�vku');
@define('PLUGIN_FORUM_ANNOUNCEMENT', 'Je p��sp�vek ozn�men�m?');
@define('PLUGIN_FORUM_SUBSCRIBE', 'P�ihl�sit se k odb�ru vl�kna?');
@define('PLUGIN_FORUM_UNSUBSCRIBE', 'Odhl�sit se z vl�kna?');
@define('PLUGIN_FORUM_TODAY', 'Dnes');
@define('PLUGIN_FORUM_YESTERDAY', 'V�era');
@define('PLUGIN_FORUM_UPLOAD_OVERWRITE', 'P�epsat');
@define('PLUGIN_FORUM_UPLOAD_OVERWRITE_BLAHBLAH', 'Maj� se v�echny ji� nahran� soubory p�epsat nov� nahran�mi soubory?<br />Pozor: Toto p�ep�e *opravdu v�echny* va�e soubory se stejn�m jm�nem!');

@define('PLUGIN_FORUM_ERR_MISSING_THREADTITLE', 'Chyba: Nadpis vl�kna nebyl zad�n nebo je p��li� kr�tk� (alespo� 4 znaky)! P��sp�vek nebyl vlo�en!');
@define('PLUGIN_FORUM_ERR_MISSING_MESSAGE', 'Chyba: Text vl�kna nebyl zad�n nebo je p��li� kr�tk� (minim�ln� 4 znaky)! P��sp�vek nebyl vlo�en!');
@define('PLUGIN_FORUM_ERR_THREAD_CLOSED', 'Chyba: Diskuzn� vl�kno bylo uzav�eno! P��sp�vek nebyl vlo�en!');
@define('PLUGIN_FORUM_ERR_EDIT_NOT_ALLOWED', 'Chyba: Nem�te opr�vn�n� m�nit tento p��sp�vek! P��sp�vek nebyl zm�n�n!');
@define('PLUGIN_FORUM_ERR_DELETE_NOT_ALLOWED', 'Chyba: Nem�te opr�vn�n� smazat p��sp�vek! P��sp�vek byl ponech�n!');
@define('PLUGIN_FORUM_ERR_DOUBLE_THREAD', 'Chyba: Vl�kno ji� bylo jednou zalo�eno! P��sp�vek nebyl vlo�en!');
@define('PLUGIN_FORUM_ERR_DOUBLE_POST', 'Chyba: Tuto odpov�� jste ji� odeslali! P��sp�vek nebyl vlo�en!');
@define('PLUGIN_FORUM_ERR_POST_INTERVAL', 'Chyba: P��li� kr�tk� interval mezi dv�ma p��sp�vky! P��sp�vek nebyl vlo�en!');
@define('PLUGIN_FORUM_ERR_WRONG_CAPTCHA_STRING', 'Chyba: Nespr�vn� kryptogram! P��sp�vek nebyl vlo�en!');
@define('PLUGIN_FORUM_ERR_FILE_TOO_BIG', 'Soubor je p��li� velk�! Nebyl ulo�en!');
@define('PLUGIN_FORUM_ERR_FILE_NOT_COPIED', 'Soubor se nepoda�ilo zkop�rovat! (z neup�esn�n�ho d�vodu)');


// email notify
@define('PLUGIN_FORUM_EMAIL_NOTIFY_SUBJECT', 'Na f�ru na {blogurl} p�ibyl nov� p��sp�vek od autora  {postauthor}!');

@define('PLUGIN_FORUM_EMAIL_NOTIFY_PART1', 'Ahoj,

{postauthor} reagoval na diskuzi ve vl�kn�
"{threadtitle}"
na diskuzn�m f�ru na
{forumurl}.

');

@define('PLUGIN_FORUM_EMAIL_NOTIFY_PART2', 'Zde je text jeho reakce:

----------------------------------------------------------------------
"{replytext}"
----------------------------------------------------------------------

');

@define('PLUGIN_FORUM_EMAIL_NOTIFY_PART3', 'Nav�tivte diskuzn� vl�kno kliknut�m na n�sleduj�c� odkaz:
{posturl}

');
@define('PLUGIN_FORUM_IMGDIR', 'Cesta k tomuto pluginu');
@define('PLUGIN_FORUM_IMGDIR_DESC', 'HTTP cesta k m�stu, kde je ulo�en tento plugin. Pou��v� se nap�. pro v�stup obr�zk�.');


@define('PLUGIN_FORUM_PHPBB_MIRROR', 'Povolit zdrcadlen� phpBB?');
@define('PLUGIN_FORUM_PHPBB_MIRROR_DESC', 'Pokud je povoleno, nov� p��sp�vky (�l�nky) na blogu budou p�esm�rov�ny do nastaven�ho phpBB f�ra. Koment��e k p��sp�vk�m (�l�nk�m) pak budou p�esm�rov�ny do phpBB f�ra  nebudou ukl�d�ny zde na tomto blogu Serendipity.');

@define('FORUM_PLUGIN_PHPBB_USER', '(voliteln�) phpBB - p�ihla�ovac� jm�no k datab�zi');
@define('FORUM_PLUGIN_PHPBB_PW', '(voliteln�) phpBB - heslo k datab�zi');
@define('FORUM_PLUGIN_PHPBB_NAME', '(voliteln�) phpBB - jm�no datab�ze');
@define('FORUM_PLUGIN_PHPBB_HOST', '(voliteln�) phpBB - server s datab�z�');
@define('FORUM_PLUGIN_PHPBB_PREFIX', '(voliteln�) phpBB - p�edpona datab�zov�ch tabulek (prefix)');
@define('FORUM_PLUGIN_PHPBB_FORUM', '(voliteln�) phpBB - ID identifik�tor f�ra (diskuzn� skupiny), kam budou nov� �l�nky
 p�esm�rov�ny');
@define('FORUM_PLUGIN_PHPBB_POSTER', '(voliteln�) phpBB - poster ID');
@define('FORUM_PLUGIN_PHPBB_DISCUSS', 'Diskutujte o tomto p��sp�vku na f�ru');

@define('FORUM_PLUGIN_NEW_THREAD', 'Nov� vl�kno');

/* vim: set sts=4 ts=4 expandtab : */