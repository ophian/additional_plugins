<?php

/**
 *  @author Vladim�r Ajgl <vlada@ajgl.cz>
 *  @translated 2013/03/31
 */
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_TITLE', 'Spamblock Bee (Honeypot, Skryt� Captcha)');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_DESC',  'Implementuje jednoduch� ale velmi ��inn� antispamov� algoritmy.');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_EXTRA_DESC',  '<strong>Tip k instalaci</strong>: Je d�le�it� um�stit tento plugin na za��tek seznamu plugin�. Pak bude nejefektivn�j��.');

@define('PLUGIN_EVENT_SPAMBLOCK_BEE_PATH', 'Cesta k plugin�m');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_PATH_DESC', 'V b�n�ch instalac�ch je v�choz� nastaven� spr�vn�.');

@define('PLUGIN_EVENT_SPAMBLOCK_BEE_REQUIRED_FIELDS', 'Povinn� pol��ka koment���');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_REQUIRED_FIELDS_DESC', 'Zadejte seznam pol��ek, kter� musej� b�t komentuj�c�m povinn� vypln�na. Jednotliv� pol��ka odd�lujte ��rkou ",". Pou��t m��ete: name, email, url, replyTo, comment');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_REASON_REQUIRED_FIELD', 'Nevyplnil jsi pol��ko %s!');

@define('PLUGIN_EVENT_SPAMBLOCK_BEE_FILTER_TITLE', 'Odm�tnout koment��e, kter� obsahuj� pouze nadpis p��sp�vku');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_FILTER_TITLE_DESC', 'N�kter� spamboty se sna�� pouze vlo�it odkaz a vytv��ej� obsah koment��e pouze podle toho, co najdou v titulku str�nky. ��dn� �iv� �ten�� to n�d�l�, je tedy bezpe�n� tuto volbu zapnout.');

@define('PLUGIN_EVENT_SPAMBLOCK_BEE_FILTER_SAMEBODY', 'Odm�tnout koment��e, jejich� text u� existuje');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_FILTER_SAMEBODY_DESC', 'To zamez� v�cen�sobn�mu vlo�en� t�ho� koment��e, t�eba kdy� �ten�� stiskne "reload" po vlo�en� koment��e. Tyto duplicity mohou b�t bezpe�n� odm�tnut�.');

@define('PLUGIN_EVENT_SPAMBLOCK_BEE_ERROR_BODY', 'Spamov� ochrana: Neplatn� zpr�va.');

@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_SECTION_LOGGING', 'Soubory a logov�n�');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_SECTION_ADVANCED', 'Pokro�il� nastaven� kryptogram� Captcha');

@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_SPAM_HONEYPOT', 'Pou��t Honeypot');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_SPAM_HONEYPOT_DESC', '"Honeypot" (v doslovn�m p�ekladu "hrnec s medem") je skryt� pol��ko koment��e, kter� by tud� m�lo z�stat v�dy pr�zdn�. Ale proto�e spamboty vpl�uj� �asto v�echna pol��ka, kter� najdou, je toto jednoduch� zp�sob, jak je odhalit. (T�mto je nech�te "sednout na lep") Zapnut� t�to volby nep�edstavuje v�bec ��dn� riziko pro b�n� u�ivatele, ale ��innost proti spambot�m p�edstavuje velkou v�hodu! Aby byl Honeypot co nejfektivn�j��, um�st�te ho p�ed ostatn� antispamov� pluginy.');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_WARN_HONEPOT', 'Nechce� mi d�t svoje ��slo, �e? ;)');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_SPAM_HCAPTCHA', 'Pou��t skryt� kryptogramy');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_SPAM_HCAPTCHA_DESC', 'Toto nastaven� vyrob� kryt�ptogram, kter� dok�ou �iv� lid� lehce vy�e�it, ale ne tak spampoty. Pokud m� �ten�� zapnut� Javascript, odpov�� bude vypln�na automaticky a skryta. A proto�e spampoty �asto Javacript neum�, je to dal�� p�kn� past, kter� je ale skryta p�ed �iv�mi �ten��i.');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_ERROR_HCAPTCHA', 'Spamov� ochrana: �patn� kryptogram (Captcha).');

@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_SPAM_LOGTYPE', 'Typ spam logu');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_SPAM_LOGTYPE_DESC', 'Kam se maj� zapisovat logy o spamu nalezen�m pluginem Spamblock Bee?');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_SPAM_LOGTYPE_NONE', 'Nelogovat');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_SPAM_LOGTYPE_FILE', 'Textov� soubor');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_SPAM_LOGTYPE_DATABASE', 'Datab�zov� tabulka');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_SPAM_LOGFILE', 'Logovac� soubor');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_SPAM_LOGFILE_DESC', 'Kam ulo�it logovac� soubor, pokud je pou�it pro logov�n� spamu?');

@define('PLUGIN_EVENT_SPAMBLOCK_BEE_RESULT_OFF', 'Vypnuto');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_RESULT_MODERATE', 'Schvalovat koment��e');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_RESULT_REJECT', 'Odm�tnout koment��e');

@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_ADV_RM_DEFAULT', 'V�choz�');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_ADV_RM_JSON', 'JSON');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_ADV_RM_SMARTY', 'Smarty');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_ADV_RM_SMARTY_ENC', 'Smarty + �ifrov�n�');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_ADV_QT_MATH', 'Matematick� rovnice');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_ADV_QT_CUSTOM', 'Libovoln� ot�zky');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_ADV_DESC', 'Pokro�il� nastaven� pro skryt� kryptogramy. Pokud jsou vypnuty, m��ete tuto ��st nastaven� v klidu ignorovat.');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_ADV_ANSWER_RETRIEVAL', 'Zp�sob z�sk�n� odpov�di');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_ADV_ANSWER_RETRIEVAL_DESC', 'Vyberte si, jak se m� z�skat spr�vn� odpov�� na kryptogram. Pokud vyberete "JSON", pak se budou pos�lat Ajaxov� po�adavky na index.php/plugin/spamblockbeecaptcha. "Smarty" poskytne odpov�� pomoc� prom�nn� Smarty {$beeCaptchaAnswer}, zat�mco "V�choz�" ji natvrdo vep�e do str�nky. POZN�MKA: Pokud je vybr�no "Smarty", nebude do str�nky vlo�eno ��dn� dal�� CSS nebo JavaScript. Mus�te se sami postarat o spr�vn� vypln�n� pol��ka a jeho skryt�. "Smarty + �ifrov�n�" je v principu stejn� nastaven� jako "Smarty" s t�m rozd�lem, �e odpov�� ulo�en� v {$beeCaptchaAnswer} je za�ifrovan� jednoduchou XOR �ifrou. Prom�nn� {$beeCaptchaScrambleKey} obsahuje de�ifrovac� kl��.');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_ADV_QUESTION_TYPE', 'Typ ot�zky');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_ADV_QUESTION_TYPE_DESC', 'Spamblock Bee um� automaticky vytv��et jednoduch� matematick� probl�my, nebo si m��ete zadat vlastn� sadu ot�zek a odpov�d�. Vyberte si mo�nost, kter� v�m v�ce vyhovuje.');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_ADV_QUESTIONS', 'Vlastn� ot�zky');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_ADV_DEFAULT_QUESTIONS', "Ot�zka1\nOt�zka2");
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_ADV_QUESTIONS_DESC', 'Pokud chcete pro kryptogramy pou��t vlastn� ot�zky, zapi�t� je sem. Pi�te jednu ot�zku na jednu ��dku. P�edt�m ne� m��e �ten�� poslat koment��, bude muset zodpov�d�t jednu n�hodn� vybranou ot�zku.');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_ADV_ANSWERS', 'Odpov�di na vlastn� ot�zky');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_ADV_ANSWERS_DESC', 'Toto pol��ko obsahuje spr�vn� odpov�di na ot�zky zadan� v��e. Pi�te jednu odpov�� na jednu ��dku ve stejn�m po�ad� jako ot�zky. Ot�zky, kter� nemaj� odpov��, budou ignorov�ny. V�echny odpov�di nerozli�uj� velikost p�smen (tedy "odpov��" je to sam�, co "Odpov��").');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_ADV_DEFAULT_ANSWERS', "Odpov��1\nOdpov��2");
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_ADV_USE_REGEXP', 'Pou��t regul�rn� v�razy');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CONFIG_ADV_USE_REGEXP_DESC', 'Maj� se odpov�di vyhodnocovat jako regul�rn� v�razy (PCRE = Perl compatible regular expressions)? Tato metoda m��e b�t pou�ita pro zad�n� v�ce spr�vn�ch odpov�d� k jedn� ot�zce. Ka�d� ��dka s odpov�d� by m�la b�t ve tvaru /pattern/:answer. POZN�MKA: Povolte tuto mo�nost, jen pokud opravdu v�te, co d�l�te. Vypln�n� �patn�ho regul�rn�ho v�razu m� za n�sledek selh�n� kontroly odpov�di a v n�kter�ch ��dk�ch p��padech V�s m��e i vystavit tzv. �toku Denial of Service! Odpov�di del�� ne� 1000 znak� budou odm�tnuty, pokud je zapnuto ov��ov�n� pomoc� regul�rn�ch v�raz�.');

@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CAPTCHA_0', 'nula');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CAPTCHA_1', 'jedna');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CAPTCHA_2', 'dva');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CAPTCHA_3', 't�i');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CAPTCHA_4', '�ty�i');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CAPTCHA_5', 'p�t');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CAPTCHA_6', '�est');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CAPTCHA_7', 'sedm');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CAPTCHA_8', 'osm');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CAPTCHA_9', 'dev�t');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CAPTCHA_10', 'deset');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CAPTCHA_PLUS', 'plus');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CAPTCHA_MINUS', 'm�nus');
@define('PLUGIN_EVENT_SPAMBLOCK_BEE_CAPTCHA_QUEST', 'Kolik je');

@define('PLUGIN_SPAMBLOCK_BEE_TITLE', 'Spam report');
@define('PLUGIN_SPAMBLOCK_BEE_DESC', 'Vyp�e statistiku o koment��ov�m spamu, pokud plugin ukl�d� logy do datab�ze.');
@define('PLUGIN_SPAMBLOCK_BEE_DAYS', 'Zobrazit dny');
@define('PLUGIN_SPAMBLOCK_BEE_DAYS_DESC', 'M��ete si nechat vypsat report o ud�lostech, kter� se staly b�hem posledn�ch X dn�. M��ete nastavit v�ce ne� jeden den, jednotliv� dny odd�lujte ��rkou.');
@define('PLUGIN_SPAMBLOCK_BEE_DBSEARCHES', 'Datab�zov� vyhled�v�n�');
@define('PLUGIN_SPAMBLOCK_BEE_DBSEARCHES_DESC', 'Tento plugin proch�z� datab�zovou tabulku "spamblocklog", ze kter� vytv��� report. M��ete zde zadat r�zn� vyhled�v�n�, kter� chcete prov�st. Jedna ��dka je jedno vyhled�v�n�. ��dka by m�la vypadat "V�N�zevVyhled�v�n�:Vyhled�van��et�zec". M��ete pou��t z�stupn� znak %. Nap��klad "BayesPlugin:%Bayes%" spo��t� v�echny p��sp�vky, kter� maj� text "Bayes" kdekoliv v nadpisu, a vyp�e je v postrann�m sloupci jako "BayesPlugin".');
@define('PLUGIN_SPAMBLOCK_BEE_LOGGEDIN', 'Pouze pro p�ihl�en� u�ivatele');
@define('PLUGIN_SPAMBLOCK_BEE_LOGGEDIN_DESC', 'Pokud je zapnuto, postrann� sloupec bude viditeln� pouze p�ihl�en�m u�ivatel�m (autor�m) Va�eho blogu.');
@define('PLUGIN_SPAMBLOCK_BEE_CACHEMINS', 'Cachovat report');
@define('PLUGIN_SPAMBLOCK_BEE_CACHEMINS_DESC', 'Vytv��en� reportu zat�uje datab�zi, tak�e byste ho nem�li vytv��et p�i ka�d�m na�ten� str�nky, ale report by m�l b�t cachov�n. Zde nastav�te �as mezi jednotliv�mi aktualizacemi reportu.');
@define('PLUGIN_SPAMBLOCK_BEE_TODAY', 'Dnes:');
@define('PLUGIN_SPAMBLOCK_BEE_LAST_X_DAYS', 'Posledn�ch %d dn�:');

