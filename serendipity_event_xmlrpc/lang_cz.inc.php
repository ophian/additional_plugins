<?php

/**
 *  @author Vladim�r Ajgl <vlada@ajgl.cz>
 *  @translated 2009/06/14
 *  @author Vladim�r Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2012/01/16
 */

@define('PLUGIN_EVENT_XMLRPC_NAME', 'Pos�l�n� p��sp�vk� pomoc� XML-RPC');
@define('PLUGIN_EVENT_XMLRPC_DESC', 'Umo��uje pos�lat/editovat p��sp�vky pomoc� XML-RPC API (MT, Blogger, WordPress Endpoints)');
@define('PLUGIN_EVENT_XMLRPC_GMT', 'Pou��vat �as ve form�tu GMT');
@define('PLUGIN_EVENT_XMLRPC_DEFAULTCAT', 'V�choz� kategorie');
@define('PLUGIN_EVENT_XMLRPC_DEFAULTCAT_DESC', 'Up�esn�te v�choz� kategorii, kam se maj� um�stit poslan� p��sp�vky, pokud u nich nen� zad�na kategorie.');

// Next lines were translated on 2012/01/16
@define('PLUGIN_EVENT_XMLRPC_DOC_RPCLINK', '<b>Pro informaci:</b><br/>Tento blog disponuje URL adresou, kter� zpracov�v� vol�n� XMLRPC. Modern� klienti jsou schopni tutot RPC URL adresu zjistit automaticky ze z�kladn� URL adresy blogu, ale n�kter�m star��m klient�m je t�eba zadat RPC URL explicitn�.<br/>Va�e XML-RPC URL je: <b>%s</b><br/>');
@define('PLUGIN_EVENT_XMLRPC_DEBUGLOG', 'Ladic� v�pisy');
@define('PLUGIN_EVENT_XMLRPC_DEBUGLOG_DESC', 'Pokud V�s zaj�m�, jak� zpr�vy XML-RPC dost�v� a odpov�d�, zapn�te ladic� v�pisy. Logovac� soubor se jmenuje rpc.log a je um�st�n v adres��i plugins.');
@define('PLUGIN_EVENT_XMLRPC_DEBUGLOG_NONE', 'zak�z�no');
@define('PLUGIN_EVENT_XMLRPC_DEBUGLOG_NORMAL', 'povoleno');
@define('PLUGIN_EVENT_XMLRPC_DEBUGLOG_VERBOSE', 'lad�n�: Nepou��vejte pro klienty!');
@define('PLUGIN_EVENT_XMLRPC_WPFAKEVERSION', 'Fale�n� WordPress verze');
@define('PLUGIN_EVENT_XMLRPC_WPFAKEVERSION_DESC', 'Toto rozhran� XML-RPC um� odpov�dat na vol�n� typu WordPress. Norm�ln� pokud je dotazov�no na pou��van� software, odpov�d� verz� Serendipity ' . $serendipity['version'] .'. Ale pokud zde zad�te ��slo verze, bude odpov�dat jako WordPress (a ��slo zadan� verze). N�kte�� klienti kontroluj�, jestli m� WordPress dostate�n� vysokou verzi, tak�e hodnota 3.2 by m�la sta�it.');
@define('PLUGIN_EVENT_XMLRPC_HTMLCONVERT', 'P�ev�d�t p��sp�vky z plaintextu do HTML');
@define('PLUGIN_EVENT_XMLRPC_HTMLCONVERT_DESC', 'Plugin se sna�� zjistit, jestli je t�lo p��sp�vku pos�l�no jako �ist� text (plaintext), a pokud je, pak znaky nov�ho ��dku p�ev�d� na HTML tagy. Pokud pou��v�te zna�kovac� pluginy jako textile nebo nl2br, m�li byste tuto volbu vypnout.');
@define('PLUGIN_EVENT_XMLRPC_ASUREAUTHOR', 'Autor koment��e z p�ihla�ovac�ho jm�na');
@define('PLUGIN_EVENT_XMLRPC_ASUREAUTHOR_DESC', 'N�kte�� klienti pos�laj� koment��e s obecn�m jm�nem autora, jako nap�. \'koment�� z WordPressu\'. Pokud je tato volba zapnut�, jm�no autora bude p�evzato nikoliv z poslan�ho pole "autor", ale z p�ihla�ovac�ho jm�na.');
@define('PLUGIN_EVENT_XMLRPC_ASUREAUTHOR_DEFAULT', 'Nem�nit autora');
@define('PLUGIN_EVENT_XMLRPC_ASUREAUTHOR_LOGIN', 'Pou��t p�ihla�ovac� jm�no jako autora');
@define('PLUGIN_EVENT_XMLRPC_ASUREAUTHOR_REALNAME', 'Pou��t skute�n� jm�no jako autora');
@define('PLUGIN_EVENT_XMLRPC_UPLOADDIR', 'Adres�� pro upload');
@define('PLUGIN_EVENT_XMLRPC_UPLOADDIR_DESC', 'Pokud klienti nahr�vaj� m�dia (nap�. obr�zky a videa), do jak�ho adres��e v mediat�ce se maj� ukl�dat?');
@define('PLUGIN_EVENT_XMLRPC_EVENT_SPAM_HEADER', '<h3>Hl�sit SPAM AntiSpamov�m plugin�m</h3>
Tento plugin je schopen hl�sit HAM a SPAM AntiSpamov�m plugin�m, kter� umo��uj� p�ij�mat tyto hl�ky, aby na n� mohly reagovat (nap�. se z nich u�it).<br/>
Porovnejte s tla��tky Spam/Ham v seznamu koment���. 
Hl�en� tohoto pluginu budou m�t stejn� ��inek jako kliknut� na tato tla��tka v administra�n� sekci.<br/>
Pokud n�kte�� klienti nemaj� samostatn� tla��tka, ale pouze mo�nosti povolit a po��dat o schv�len� (moderovat), m��ete nastavit, kter� hl�ky budou kdy posl�ny.<br/>
Pokud V� klient neum� pos�lat hl�en� o spamu, mo�n� se v�m bude hodit, kdy� nastav�te, aby byl hl�en spam poka�d�, kdy� zvol�te moderovat (moderate, po��dat o schv�len�).');
@define('PLUGIN_EVENT_XMLRPC_EVENT_SPAM', 'Koment�� ozna�en� jako SPAM');
@define('PLUGIN_EVENT_XMLRPC_EVENT_SPAM_DESC', 'Klient ozna�il koment�� jako SPAM');
@define('PLUGIN_EVENT_XMLRPC_EVENT_APPROVED', 'Koment�� schv�len');
@define('PLUGIN_EVENT_XMLRPC_EVENT_APPROVED_DESC', 'Klient ozna�il koment�� jako schv�len�');
@define('PLUGIN_EVENT_XMLRPC_EVENT_PENDING', 'Koment�� byl moderov�n');
@define('PLUGIN_EVENT_XMLRPC_EVENT_PENDING_DESC', 'Klient ozna�il koment�� jako moderovan� (k dal��mu schv�len�)');
@define('PLUGIN_EVENT_XMLRPC_EVENTVALUE_NONE', 'Ned�lat nic');
@define('PLUGIN_EVENT_XMLRPC_EVENTVALUE_SPAM', 'Hl�sit jako SPAM');
@define('PLUGIN_EVENT_XMLRPC_EVENTVALUE_HAM', 'Hl�sit jako HAM');

