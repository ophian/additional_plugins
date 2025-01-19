<?php

/**
 *  @author Vladim�r Ajgl <vlada@ajgl.cz>
 *  @translated 2009/11/07
 *  @author Vladim�r Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2009/12/29
 *  @author Vladim�r Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2010/03/07
 *  @author Vladim�r Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2010/04/24
 *  @author Vladim�r Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2010/09/12
 *  @author Vladim�r Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2010/11/26
 *  @author Vladim�r Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2012/01/11
 *  @author Vladim�r Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2012/05/13
 */

@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_NAME', 'Spamblock (Bayes)');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_DESC', 'Detekce spamu pomoc� adaptivn�ho algoritmu, kter� se dok�e s�m u�it.');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_HAM', 'V po��dku');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_SPAM', 'Spam');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_ERROR', 'Odm�tnuto jako spam.');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_MODERATE', 'Pravd�podobn� se jedn� o spam. P��sp�vek byl p�edlo�en ke schv�len�.');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_METHOD_MODERATE', 'Schvalovat');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_METHOD_BLOCK', 'Odm�tnout');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_RECYCLER_DESC', 'Maj� se zablokovan� koment��e ukl�dat do ko�e?');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_RECYCLER_EMPTY', 'Vypr�zdnit ko�');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_RESTORE', 'Obnovit');
@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_MENU_RECYCLER', 'Ko�');

//old

#@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_AUTOLEARN',     'U�it se');
#@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_AUTOLEARN_DESC',     'Koment��e, kter� velmi pravd�podobn� obsahuj� spam jsou pou�ity k u�en� pro detekci dal��ho spamu. T�mto zp�sobem se algoritmus automaticky lehce u��.');
#@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_LOGFILE',     'Um�st�n� logu');
#@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_LOGFILE_DESC',     'Ozn�men� o zam�tnut�ch/schvalovan�ch p��sp�vc�ch mohou b�t zapisov�ny do logu. Pokud chcete vypnout logov�n�, zadejte pr�zdn� �et�zec.');
#@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_LOGTYPE',     'Vyberte metodu logov�n�');
#@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_LOGTYPE_DESC',     'Logov�n� odm�tnut�ch koment��� m��e prob�hat bu� do datab�ze nebo do textov�ho souboru.');
#@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_LOGTYPE_FILE', 'Soubor (viz "Um�st�n� logu" n�e)');
#@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_LOGTYPE_DB', 'Datab�ze');
#@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_LOGTYPE_NONE', 'Nelogovat');
#@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_REASON', 'Odchyceno pluginem Bayes');

// Next lines were translated on 2009/12/29

#@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_RATING_EXPLANATION',     'Riziko spamu podle pluginu Spambock-Bayes.');
#@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_DELETE',     'Smazat koment�� a ozna�it jako spam');
#@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_APPROVE',     'Odsouhlasit koment�� a ozna�it jako platn�');
#@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_PATH',     'Cesta k pluginu');
#@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_PATH_DESC',     'Pokud je zde cesta zad�na, nen� nad�le rozpozn�v�na dynamicky. To m� v�znamn� vliv na v�kon pluginu. P��klad: http://www.priklad.cz/plugins/serendipity_event_spamblock_bayes/ (na konci mus� b�t lom�tko "/" ).');

// Next lines were translated on 2010/03/07

#@define('PLUGIN_EVENT_SPAMBLOCK_METHOD',     'Zach�zen� se spamem');
#@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_BARRIER_MODERATE',     'Vlastn� schvalov�n�');
#@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_BARRIER_MODERATE_DESC',     'P�i vlastn�m m�du schvalovat p�i hodnocen� v�t��m ne�? (v %)');
#@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_BARRIER_BLOCK',     'Vlastn� odm�tnut�');
#@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_BARRIER_BLOCK_DESC',     'P�i vlastn�m m�du odm�tnout p�i hodnocen� vy���m ne�? (v %)');
##@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_METHOD_CUSTOM',     'Vlastn� nastaven�');

// Next lines were translated on 2010/04/24

#@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_SPAMBUTTON',     'Ozna�it vybran� koment��e jako spam');
#@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_MENU_LEARN',     'U�it se');
#@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_MENU_DATABASE',     'Datab�ze');
#@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_CREATEDB',     'Vytvo�it datab�zi');
#@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_LEARNOLD',     'U�it se ze star��ch');
#@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_ERASEDB',     'Vymazat datab�zi');
#@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_SAVEDVALUES',     'Hodnocen� koment��e');
#@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_MENU',     'Menu');
#@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_MENU_DESC',     'Odkaz na roz���en� menu v administra�n� sekci.');

// Next lines were translated on 2010/09/12

#@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_HAMBUTTON',     'Oza�it jako platn�');
#@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_MENU_ANALYSIS',     'Anal�za');
#@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_RECYCLER_DELETE',     'P�emost�n� ko�e');
#@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_RECYCLER_DELETE_DESC',     'Koment��e s hodnocen�m v�t��m nebo rovn�m ne� je tato hodnota nebudou zahozeny do ko�e, n�br� rovnou smaz�ny. P��klad: 98');
#@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_IGNORE',     'Ignorovat');
#@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_IGNORE_DESC',     'Zadejte pole koment��e, kter� budou ignorov�ny. Mo�n� hodnoty: ip, referer, author, body, email, url. P��klad: "ip, referer".');

// Next lines were translated on 2010/11/26

#@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_EXPORTDB',     'Export datab�ze');
#@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_IMPORTDB',     'Import datab�ze');
#@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_IMPORT_EXPLANATION',     'Iportovat d��ve vygenerovan� CSV soubory. Na�ten� data filtru budou p�id�na do datab�ze.');

// Next lines were translated on 2012/01/11

#@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_MENU_IMPORT',     'Import');
#@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_TROJA_EXPLANATION',     'M��ete importovat datab�zi spamu z jin�ho blogu. Zaregistrujte se a ostatn� blogy se budou u�it z va�� datab�ze spamu.');
#@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_TROJA',     'Online Import');
#@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_TROJA_IMPORT',     'Import');
#@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_TROJA_REGISTER',     'P�idat tento blog');
#@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_TROJA_REMOVE',     'Odstranit tento blog');

// Next lines were translated on 2012/05/13
#@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_RATING',     'Hodnocen�');
#@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_RECYCLER_EMPTY_ALL',     'Ko�: �pln� vy�i�t�n�');
#@define('PLUGIN_EVENT_SPAMBLOCK_BAYES_RECYCLER_EMPTY_ALL_DESC',     'P�i vysyp�v�n� ko�e smazat v�echny koment��e, nejen ty na aktu�ln� str�nce.');

