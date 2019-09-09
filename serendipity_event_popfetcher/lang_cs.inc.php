<?php

/**
 *  @author Vladim�r Ajgl <vlada@ajgl.cz>
 *  @translated 2009/05/18
 *  @author Vladim�r Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2009/10/23
 *  @author Vladim�r Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2009/11/21
 *  @author Vladim�r Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2011/06/19
 *  @author Vladim�r Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2013/04/14
 */

@define('PLUGIN_MF_NAME', 'POP3 stahova�');
@define('PLUGIN_MF', 'POP3 stahova�');
@define('PLUGIN_MF_DESC', 'Stahuje zpr�vy z emailu a zobraz� je v�etn� p��loh v bloku v postrann�m sloupci (speci�ln� podpora pro mobiln� telefony)');
@define('PLUGIN_MF_AM', 'Typ pluginu');
@define('PLUGIN_MF_AM_DESC', 'Pokud je nastaveno na "Intern�", m��ete spustit POP3 stahova� pouze z administra�n� sekce. Pokud je nastaveno "Extern�", m��ete spustit POP3 stahova� pouze zvn�j�ku (typicky jako �lohu cronu). V�choz� je "Intern�".');
@define('PLUGIN_MF_HN', 'Jm�no pro extern� spou�t�n�');
@define('PLUGIN_MF_HN_DESC', 'Tento n�zev je pou�it pro spu�t�n� stahova�e zvn�j�ku. Nastavte na n�jak� obt�n� uhodnuteln� jm�no, aby V�m skript nemohla spustit neopr�vn�n� osoba. Podtr��tka nejsou povolena. Pokud je nastaven Typ na Intern�, pak toto nastaven� nem� ��dn� ��inek. V�choz�: "popfetcher".');
@define('PLUGIN_MF_MS', 'Mailov� server');
@define('PLUGIN_MF_MS_DESC', 'Dom�na, na kter� b�� POP3 mailov� server, nap�. "vasedomena.cz"');
@define('PLUGIN_MF_MD', 'Adres�� pro upload');
@define('PLUGIN_MF_MD_DESC', 'Sta�en� p��lohy budou ulo�eny do tohoto adres��e. V�choz� nastaven� je shodn� s upload adres��em Serendipity (zde pr�zdn� hodnota). Pokud zad�te jin� adres��, mus� jeho jm�no kon�it lom�tkem "/". Nap�: "dovolena/".');
@define('PLUGIN_MF_PP', 'POP3 port');
@define('PLUGIN_MF_PP_DESC', '��slo portu na serveru, na kter�m b�� slu�ba POP3. Pokud je nastaveno na 995, POP3 stahova� se pokus� p�ipojit zabezpe�en�m p�ipojen�m (POP3 over SSL). V�choz�: 110.');
@define('PLUGIN_MF_MU', 'U�ivatelsk� jm�no');
@define('PLUGIN_MF_MU_DESC', 'P�ihla�ovac� jm�no k po�t�');
@define('PLUGIN_MF_CAT', 'Kategorie');
@define('PLUGIN_MF_CAT_DESC', 'Kategorie blogu, ve kter� se budou publikovat maily. V�choz� je ��dn� kategorie (pr�zdn� pol��ko)');
@define('PLUGIN_MF_MP', 'Heslo');
@define('PLUGIN_MF_MP_DESC', 'Heslo k po�t�');
@define('PLUGIN_MF_TO', 'Timeout');
@define('PLUGIN_MF_TO_DESC', 'Po�et vte�in, po kter�ch se ukon�� pokus o p�ipojen� k mailov�mu serveru. V�choz�: 30.');
@define('PLUGIN_MF_DF', 'P��znak "Smazat"');
@define('PLUGIN_MF_PF_DESC', 'Pokud je nastaveno na "Publikovat", p��sp�vky blogu s emaily jsou po sta�en� okam�it� publikov�ny. Pokud je nastaveno "Koncept", pak jsou ulo�eny jako koncept a zve�ejn�ny teprve po p�epnut� administr�torem do stavu "publikovat". V�choz�: "Koncept". (Toto nastaven� je ignorov�no, pokud je p��znak "Blog" nastaven na "Ne".)');
@define('PLUGIN_MF_PF', 'P��znak "Publikovat"');
@define('PLUGIN_MF_BF_DESC', 'Pokud nastaveno na "Ano", p��lohy jsou ulo�eny do adres��e pro stahov�n�, p�ipojeny k textu mailu a dohromady jsou vystaveny jako p��sp�vek blogu. Pokud je nastaveno na "Ne", p��lohy mailu jsou ulo�eny do adres��e pro stahov�n� a zbytek mailu (tj. v�echen text) je zahozen.');
@define('PLUGIN_MF_BF', 'P��znak "Blog"');
@define('PLUGIN_MF_DF_DESC', 'Pokud je nastaveno "Ano", pak je mail po sta�en� smaz�n ze serveru. Obvykl� nastaven� je "Ano", pokud plugin netestujete.');
@define('PLUGIN_MF_AF', 'P��znak "APOP"');
@define('PLUGIN_MF_AF_DESC', 'Pokud je nastaveno "Ano", stahova� se pokus� p�ihla�ovat metodou APOP. V�choz�: "Ne".');
@define('ERROR_CHECK', 'CHYBA:');
@define('INTERNAL_MF', 'Intern�');
@define('EXTERNAL_MF', 'Extern�');
@define('PUBLISH_MF', 'Publikovat');
@define('DRAFT_MF', 'Koncept');
@define('MF_ERROR1', 'CHYBA: nelze se p�ipojit k mailov�mu serveru');
@define('MF_ERROR2', 'CHYBA: nepoda�ilo se p�ihl�sit k mailov�mu ��tu (chybn� jm�no a/nebo heslo)');
@define('MF_ERROR3', 'CHYBA: z po�tovn�ho ��tu nelze z�skat UIDL info. Pravd�podobn� nepodporuje UIDL.');
@define('MF_ERROR4', 'CHYBA: probl�m p�i stahov�n� mailu');
@define('MF_ERROR5', 'CHYBA: nelze vytvo�it soubor: ');
@define('MF_ERROR6', 'CHYBA: adres�� pro stahov�n� nen� zapisovateln�. Jd�te do nastaven� pluginu a zm��te adres�� nebo zm��te p��stupov� pr�va k aktu�ln�mu adres��i.');
@define('MF_ERROR7', 'CHYBA: cesta k adres��i pro stahov�n� mus� kon�it lom�tkem "/". Jd�te do nastaven� pluginu a opravte nastaven�.');
@define('MF_ERROR8', 'CHYBA: V�mi zadan� kategorie blogu pro zve�ej�ov�n� mail� neexistuje.');
@define('MF_ERROR9', 'CHYBA: nezda�ilo se dek�dov�n� mailu, mail m� chybn� MIME form�t. (Chyba je na stran� odes�latele mailu.)');
@define('MF_ERROR10', 'CHYBA: Nelze nal�zt SprintPCS Picture/Video Share URL.');
@define('MF_ERROR11', 'CHYBA: Nepoda�ilo se st�hnout SprintPCS Picture/Video URL.');
@define('MF_ERROR13', 'CHYBA: Nepoda�ilo se otev��t soubor s obr�zkem/videem');
@define('MF_ERROR14', 'CHYBA: Nelze otev��t nov� soubor pro SprintPCS sound memo.');
@define('MF_MSG1', 'Ve Va�� mailov� schr�nce nejsou ��dn� zpr�vy');
@define('MF_MSG2', 'Po�et mail� sta�en�ch z Va�� schr�nky');
@define('MF_MSG3', '[Hlavi�ka s datem nenalezena]');
@define('MF_MSG4', '[Hlavi�ka "Od" nenalezena - nezn�m� odes�latel]');
@define('MF_MSG5', 'Datum: ');
@define('MF_MSG6', 'Od: ');
@define('MF_MSG7', 'DATA MAILU');
@define('MF_MSG8', '��ST MAILU -- Nalezena p��loha se jm�nem: ');
@define('MF_MSG9', '��ST MAILU -- Zpr�va nalezena, ��dn� p��lohy');
@define('MF_MSG10', 'V mailu nebyl nalezen ��dn� text ani p��lohy');
@define('MF_MSG11', 'V�echny zpr�vy byly smaz�ny z mailov�ho serveru');
@define('MF_MSG12', 'V�echny zpr�vy jsou st�le ulo�eny na mailov�m serveru');
@define('MF_MSG13', 'P��loha byla ulo�ena jako soubor: ');
@define('MF_MSG14', 'Soubor pojmenovan� jako p��loha ji� existuje. P��loha bude ulo�ena jako soubor: ');
@define('MF_MSG15', 'Publikuji nov� p��sp�vek blogu s ��slem');
@define('MF_MSG16', 'P�edm�t: ');
@define('MF_MSG17', '[Hlavi�ka s p�edm�tem nebyla nalezena]');
@define('MF_MSG18', 'Klikn�te pro plnou velikost obr�zku');
@define('MF_MSG19', 'Zpr�va pravd�podobn� obsahuje vir. Mail byl p�esko�en kv�li p��loze s podez�el�m jm�nem.');
@define('MF_MSG20', 'P�esko�ena zpr�va bez p��loh');
@define('MF_MSG21', 'Sound Memo');
@define('MF_MSG22', 'Klikn�te pro video');
@define('MF_MSG23', 'Mobil @');
@define('MF_TEXTBODY', 'Zobrazit plaintextov� p��lohy v t�le p��sp�vku?');
@define('MF_TEXTBODY_DESC', 'Pokud je aktivov�no, v�echny p��lohy, kter� obsahuj� pouze text budou p�id�ny do t�la p��sp�vku na blogu. Pokud nen� aktivov�no, tyto p��lohy budou ulo�eny jako samostatn� soubory a do p��sp�vku bude vlo�en pouze odkaz na n�.');
@define('MF_TEXTBODY_FIRST', 'Prvn� textov� p��loha je vlo�ena jako t�lo p��sp�vku, ostatn� jako roz���en� textov� ��st.');
@define('MF_TEXTBODY_FIRST_DESC', 'Nastaven� je pou�ito pouze pokud jsou plaintextov� p��lohy vkl�d�ny do t�la p��sp�vku (viz. v��e). Pokud je aktivov�no, bude pouze prvn� textov� p��loha pou�ita jako t�lo p��sp�vku (perex, teaser), ostatn� budou ulo�eny do "roz���en� textov� ��sti" p��sp�vku. Budou se tud� zobrazovat pouze p�i zobrazen� jednoho konkr�tn�ho p��sp�vku a ne na p�ehledov�ch str�nk�ch, jako je nap�. hlavn� str�nka.');
@define('MF_MYSELF', 'Autor');
@define('MF_AUTHOR_DESC', 'Nastavte autora, kter� se bude zobrazovat jako autor u p��sp�vk� obsahuj�c�ch sta�en� maily.');
@define('PLUGIN_MF_STRIPTAGS', 'Odstranit z mailu v�echny HTML tagy');
@define('PLUGIN_MF_STRIPTAGS_DESC', 'Odstran� z mailu v�echny HTML tagy, p��padn� form�tov�n� mailu tak bude ztraceno. Nehroz� ale rozh�zen� str�nky vlivem kuka���ho HTML k�du.');

@define('PLUGIN_MF_ADDFLAG', 'O�ezat reklamy?');
@define('PLUGIN_MF_ADDFLAG_DESC', 'M� POP3 stahova� odstra�ovat z mailu reklamn� grafku a texty? Tento filter v sou�asnosti funguje pouze pro T-Mobile a O2.');

@define('PLUGIN_MF_STRIPTEXT', 'O��znout text na speci�ln�m znaku');
@define('PLUGIN_MF_STRIPTEXT_DESC', 'Pokud chcete o�ezat z mail� reklamy nebo jin� ne��douc� text, m��ete zde zadat "kouzeln� �et�zec". V�echen text, kter� se v mailu nach�z� za t�mto �et�zcem, bude odstran�n a nebude se zobrazovat v p��sp�vku.');

@define('PLUGIN_MF_ONLYFROM', 'Omezen� na konkr�tn� odes�latele');
@define('PLUGIN_MF_ONLYFROM_DESC', 'Pokud chcete povolit pos�l�n� mail� do blogu pouze z jedn� mailov� adresy, jednodu�e ji sem zadejte. Pokud ponech�te pol��ko pr�zdn�, na blogu budou zobrazov�ny v�echny sta�en� maily. Separate multiple mail adresses with a semicolon.');
@define('MF_ERROR_ONLYFROM', 'Emailov� adresa %s se neshoduje s povolenou adresou %s. Mail byl ignorov�n.');
@define('MF_ERROR_NOAUTHOR', '��dn� z autor� nem� adresu %s. Mail byl p�esko�en.');

@define('PLUGIN_MF_SPLITTEXT', 'Zadejte �et�zec, kter� odd�luje t�lo a roz���enou textovou ��st p��sp�vku');
@define('PLUGIN_MF_SPLITTEXT_DESC', 'Pomoc� tohoto nastaven� m��ete zajistit, �e se ��st meilu bude ukl�dat do t�la p��sp�vku a zbytek do roz���en� textov� ��sti. Pokud POP3 stahova� nalezne v mailu zde zadan� �et�zec, v�echno p�ed n�m vlo�� do t�la p��sp�vku a v�echno za n�m do roz���en� textov� ��sti. Zvolte jedine�n� text, kter� se nem��e ocitnout v b�n�m textu, jako nap�. "xxx-SPLIT-xxx". Zad�n� t�to volby m��e p�ekr�t jin� nastaven� pro zpracov�n� mail�!');

@define('PLUGIN_MF_USETEXT', 'Text hledan� v mailu');
@define('PLUGIN_MF_USETEXT_DESC', 'Pokud chcete z mail� vkl�dat do p��sp�vk� pouze ur�itou ��st, m��ete zde zadat "kouzeln� �et�zec", podle kter� stahova� pozn�, kterou ��st mailu m� pou��t. N�sledn� pak mus�te tento �et�zec napsat do ka�d�ho mailu a ozna�it tak text ur�en� pro blog. Zadejte �et�zec, kter� se v mailech nem��e n�hodn� objevit, dobr� je nap�. "xxx-BLOG-xxx".');
@define('PLUGIN_MF_CRONJOB', 'Tento plugin lze aktivovat pomoc� Serendipity Cronjob pluginu. Instalujte jej, pokud chcete spou�t�t stahova� v pravideln�ch intervalech.');

@define('PLUGIN_MF_TEXTPREF', 'Up�ednost�ovat text');
@define('PLUGIN_MF_TEXTPREF_DESC', 'N�kter� za��zen� pos�laj� maily, kter� jsou psan� ve form�tu HTML, ale z�rove� maj� ten sam� obsah pouze v neform�tovan�m textu. Tak�e z mail dostanete dvakr�t ten sam� text. Pomoc� t�to volby m��ete ur�it, kterou ��st chcete pou��vat.');
@define('PLUGIN_MF_TEXTPREF_BOTH', 'Ob� ��sti');
@define('PLUGIN_MF_TEXTPREF_HTML', 'HTML');
@define('PLUGIN_MF_TEXTPREF_PLAIN', '�ist� text');

// Next lines were translated on 2009/10/23

@define('PLUGIN_MF_USEDATE', 'Up�ednostnit �as odesl�n� p��choz�ho mailu p�ed �asem doru�en�');
@define('PLUGIN_MF_REPLY', 'Koment��/odpov�� m�sto p��sp�vku v blogu.');
@define('PLUGIN_MF_REPLY_ERROR1', 'Nebyl nalezen ��dn� p��sp�vek, kter� by se shodoval s p�edm�tem mailu. Mail nebyl ulo�en.');
@define('PLUGIN_MF_REPLY_ERROR2', 'Nelze ulo�it koment��.');

// Next lines were translated on 2009/11/21

@define('PLUGIN_MF_SUBFOLDER', 'Ukl�dat p��lohy v podadres���ch pojmenovan�ch jako 2010/02/ pro zachov�n� chronologick�ho po�ad�?');
@define('PLUGIN_MF_DEBUG', 'Ukl�dat ladic� zpr�vy do souboru uploads/popfetcher-RRRR-MM.log?');

// Next lines were translated on 2011/06/19

@define('THUMBNAIL_VIEW', 'Zobrazovat n�hledy v t�le p��sp�vku');
@define('THUMBNAIL_VIEW_DESC', 'Kdy� chcete zobrazit v t�le p��sp�vku n�hledy p�ipojen�ch obr�zk�. Pokud nastav�te "NE", budou se zobrazovat obr�zky v pln� velikosti.');

