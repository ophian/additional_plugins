<?php

/**
 *  @author Vladim�r Ajgl <vlada@ajgl.cz>
 *  @translated 2009/08/08
 */

@define('PLUGIN_EVENT_USERGALLERY_TITLE', 'Galerie');
@define('PLUGIN_EVENT_USERGALLERY_DESC', 'Umo��uje nep�ihl�en�m u�ivatel�m prohl�et Serendipity knihovnu m�di�');
@define('PLUGIN_EVENT_USERGALLERY_NUMCOLS_TWO', '2');
@define('PLUGIN_EVENT_USERGALLERY_NUMCOLS_THREE', '3');
@define('PLUGIN_EVENT_USERGALLERY_NUMCOLS_FOUR', '4');
@define('PLUGIN_EVENT_USERGALLERY_NUMCOLS_FIVE', '5');
@define('PLUGIN_EVENT_USERGALLERY_NUMCOLS_DESC', 'Po�et sloupc� v zobrazen� galerie');
@define('PLUGIN_EVENT_USERGALLERY_NUMCOLS_NAME', 'Po�et sloupc�');
@define('PLUGIN_EVENT_USERGALLERY_PERMALINK_NAME', 'St�l� odkaz (permalink) na str�nku galerie');
@define('PLUGIN_EVENT_USERGALLERY_PERMALINK_DESC', 'Zadejte jedine�n� odkaz, pod kter�m bude p��stupn� galerie');
@define('PLUGIN_EVENT_USERGALLERY_SUBNAME_NAME', 'Jm�no podstr�nky pro zobrazen� galerie');
@define('PLUGIN_EVENT_USERGALLERY_SUBNAME_DESC', 'Zadejte jedine�n� jm�no podstr�nky, kter� bude sv�z�no s galeri� (galerie bude p��stupn� pod adresou index.php?serendipity[subpage]=zde_zadan�_jm�no)');
@define('PLUGIN_EVENT_USERGALLERY_DIRECTORY_NAME', 'Vyberte v�choz� adres��');
@define('PLUGIN_EVENT_USERGALLERY_DIRECTORY_DESC', 'Vyberte adres�� knihovny m�di�, na kter� m� b�t omezeno zobrazen� galerie');
@define('PLUGIN_EVENT_USERGALLERY_STYLE_NAME', 'Vyberte vzhled galerie');
@define('PLUGIN_EVENT_USERGALLERY_STYLE_DESC', '"Knihovna m�di�! umo��uje proch�zen� po adres���ch a vyhled�v�n�, zat�mco "Str�nka s n�hledy" zobraz� n�hledy v�ech obr�zk� v adres��i a obr�zky otev�r� v nov�m okn�.');
@define('PLUGIN_EVENT_USERGALLERY_STYLE_SERENDIPITY', 'Knihovna m�di�');
@define('PLUGIN_EVENT_USERGALLERY_STYLE_THUMBPAGE', 'Str�nka s n�hledy');
@define('PLUGIN_EVENT_USERGALLERY_PRETTY_NAME', 'Nadpis galerie');
@define('PLUGIN_EVENT_USERGALLERY_PRETTY_DESC', 'Zadejte nadpis str�nka s galeri�');
@define('PLUGIN_EVENT_USERGALLERY_INTRO', '�vodn� text (nepovinn�)');
@define('PLUGIN_EVENT_USERGALLERY_FIXED_WIDTH', 'Pevn� velikost obr�zk� v zobrazen� galerie');
@define('PLUGIN_EVENT_USERGALLERY_FIXED_DESC', 'Nastav� v��ku a ���ku obr�zku na pevnou hodnotu p�i prohl�en� galerie. Zadejte nulu pro pou�it� standardn�ch n�hled�.');
@define('PLUGIN_EVENT_USERGALLERY_FILESIZE', 'Velikost souboru');
@define('PLUGIN_EVENT_USERGALLERY_FILENAME', 'Jm�no souboru');
@define('PLUGIN_EVENT_USERGALLERY_DIMENSION', 'Rozm�ry');
@define('PLUGIN_EVENT_USERGALLERY_IMAGEDISPLAY_NAME', 'Zobrazit jedin� obr�zek');
@define('PLUGIN_EVENT_USERGALLERY_IMAGEDISPLAY_DESC', 'M�ete zobrazovat obr�zky v m���tku p�izp�soben� str�nce (s adaptivn�m pop-up oknem pro velk� obr�zky), nebo v adaptivn�m pop-up okn� p��mo po kliknut� na n�hled na str�nce galerie.');
@define('PLUGIN_EVENT_USERGALLERY_IMAGEDISPLAY_INPAGE', 'P�izp�soben� m���tko');
@define('PLUGIN_EVENT_USERGALLERY_IMAGEDISPLAY_POPUP', 'Adaptivn� pop-up okno');
@define('PLUGIN_EVENT_USERGALLERY_DIRLIST_NAME', 'Zobrazit v�pis adres��e');
@define('PLUGIN_EVENT_USERGALLERY_DIRLIST_DESC', 'Pokud je nastaven� na "Ano", galerie bude zobrazovat v�pis v�ech podadres��� ve v�choz�m adres��i.');
@define('PLUGIN_EVENT_USERGALLERY_IMAGESTRICT_NAME', 'Pouze obr�zky v aktu�ln�m adres��i');
@define('PLUGIN_EVENT_USERGALLERY_IMAGESTRICT_DESC', 'Pokud nastaveno na "Ano", galerie bude zobrazovat pouze obr�zky v aktu�ln�m adres��i. Pokud nastaveno na "Ne", galerie bude zobrazovat v�echny obr�zky ze v�ech podadres���.');
@define('PLUGIN_EVENT_USERGALLERY_IMAGEORDER_NAME', '�azen�');
@define('PLUGIN_EVENT_USERGALLERY_IMAGEORDER_DESC', 'Vyberte po�ad�, v jak�m se maj� vypisovat obr�zky');
@define('PLUGIN_EVENT_USERGALLERY_IMAGEORDER_NAMEACS', 'Jm�no (vzestupn�)');
@define('PLUGIN_EVENT_USERGALLERY_IMAGEORDER_NAMEDESC', 'Jm�no (sestupn�)');
@define('PLUGIN_EVENT_USERGALLERY_IMAGEORDER_DATEACS', 'Datum (vzestupn�)');
@define('PLUGIN_EVENT_USERGALLERY_IMAGEORDER_DATEDESC', 'Datum (sestupn�)');
@define('PLUGIN_EVENT_USERGALLERY_DISPLAYDIR_NAME', 'Zobrazit cel� strom adres���');
@define('PLUGIN_EVENT_USERGALLERY_DISPLAYDIR_DESC', '"Ano" znamen�, �e se bude na ka�d� str�nce galerie zobrazovat cel� strom adres���. "Ne" znamen�, �e se bude vypisovat pouze strom podadres��� aktu�ln�ho adres��e. (Toto chov�n� je tak� z�visl� na �ablon� vzhledu pou�it� pro zobrazen� galerie.)');
@define('PLUGIN_EVENT_USERGALLERY_1SUBLVL_NAME','Zobrazovat pouze jednu �rove� podadres���');  
@define('PLUGIN_EVENT_USERGALLERY_1SUBLVL_DESC','Toto nastaven� omez� v�pis stromu podadres��� pouze na prvn� �rove� podadres���. Tedy podadres��e podadres��� u� se nebudou zobrazovat. Tak� vyp�e celkov� po�et obr�zk� v podadres���ch. Toto nastaven� nen� p��stupn� pokud pou��v�te zobrazen� pln�ho stromu adres���.');
@define('PLUGIN_EVENT_USERGALLERY_IMAGESPERPAGE_NAME', 'Po�et obr�zk� na str�nce');
@define('PLUGIN_EVENT_USERGALLERY_IMAGESPERPAGE_DESC', 'Pokud zde zad�te "0", str�nkov�n� bude vypnuto a v�echny obr�zky se budou zobrazovat na prvn� str�nce.');
@define('PLUGIN_EVENT_USERGALLERY_PREVIOUS', 'p�edchoz�');
@define('PLUGIN_EVENT_USERGALLERY_NEXT', 'dal��');
@define('PLUGIN_EVENT_USERGALLERY_UPONELEVEL', 'O �rove� v��e');
@define('PLUGIN_EVENT_USERGALLERY_BACK', 'Zp�t');
@define('PLUGIN_EVENT_USERGALLERY_FRONTPAGE_NAME', 'Nastavit tuto str�nku jako �vodn� str�nku blogu Serendipity');
@define('PLUGIN_EVENT_USERGALLERY_FRONTPAGE_DESC', 'M�sto v�choz� str�nky Serendipity m��ete zobrazovat galerii. Pokud chcete zm�nit �vodn� str�nku zp�t na v�choz� str�nku Serendipity, pou�ijte "index.php?frontpage". Pokud chcete pou��vat tuto funkci, ujist�te se, �e p�ed pluginem "Galerie" (v nastaven� nainstalovan�ch plugin�) nejsou pou�ity ��dn� dal�� pluginy, kter� definuj� st�l� odkazy (permalink), jako nap�. hlasov�n�, n�v�t�vn� kniha.');

//Exif data tags
@define('PLUGIN_EVENT_USERGALLERY_EXIFDATA_SHOW_NAME', 'Zobrazovat exif tagy?');
@define('PLUGIN_EVENT_USERGALLERY_EXIFDATA_SHOW_DESC', 'EXIF tagy jsou p��davn� informace o obr�zku obsa�en� p��mo v souboru s obr�zkem. Tyto jsou automaticky vytv��en� fotoapar�ty, obsahuj� informace jako je model fotoapar�tu, nastaven� expozice, pou�it� blesku, �as z�v�rky apod. Star�� fotoapar�ty (p�ed rokem 2000) nemus� tyto informace zapisovat.');
@define('PLUGIN_EVENT_USERGALLERY_EXIFDATA_CAMERA', 'Podporovan� fotoapar�ty: Agfa, Canon, Casio, Epson, Fujifilm, Konica Minolta, Kyocera, Nikon, Olympus, Panasonic, Pentax, Ricoh, Sony.');
@define('PLUGIN_EVENT_USERGALLERY_EXIFDATA_NAME', 'EXIF data');
@define('PLUGIN_EVENT_USERGALLERY_EXIFDATA_DESC', 'V seznamu n�e jsou v�echny p��stupn� volby. V� konkr�tn� fotoapar�t m��e p�esko�it jednu nebo dv� hodnoty, proto�e ne v�echny hodnoty jsou zapisov�ny v�emi fotoapar�ty.');
@define('PLUGIN_EVENT_USERGALLERY_EXIFDATA_ADDITIONALDATA', 'Dal�� informace');
@define('PLUGIN_EVENT_USERGALLERY_EXIFDATA_NOADDITIONALDATA', '��dn� dal�� informace');

@define('PLUGIN_EVENT_USERGALLERY_RSS_FEED', 'Rozm�ry obr�zku v RSS kan�lu');
@define('PLUGIN_EVENT_USERGALLERY_RSS_FEED_DESC', 'Tento plugin nab�z� RSS kan�l s posledn�mi obr�zky na blogu. M��ete ho zobrazit jako jak�koliv jin� RSS kan�l na bogu, tedy zad�n�m n�sleduj�c� URL adresy: %s. Prom�nn� "gallery=true" v URL adrese je d�le�it�, proto�e znamen�, �e se maj� zobrazovat obr�zky galerie. M��ete pou��t tak� dal�� prom�nnou "limit=XX" k omezen� obr�zk� v RSS kan�lu. Prom�nn� "picdir=XXX" ur�uje adres��, jeho� obr�zky se maj� zobrazovat v RSS kan�lu. Prom�nn� "hide_title=true" skryje n�zvy soubor� a "feed_width=XXX" nastav� velikost c�lov�ch obr�zk� (podporovan� od verze Serendipity 1.1). Zadejte maxim�ln� velikost obr�zk� v RSS kan�lu.');

@define('PLUGIN_EVENT_USERGALLERY_RSS_FEED_LINKONLY', 'Zobrazit v RSS pouze propojen� obr�zky?');
@define('PLUGIN_EVENT_USERGALLERY_RSS_FEED_LINKONLY_DESC', '"Ano" znamen�, �e se v RSS kan�lu objev� pouze obr�zky, kter� jsou obsa�en� v n�kter�m z publikovan�ch p��sp�vk�.');

@define('USERGALLERY_SEE_FULLSIZED', 'Klikn�te pro obr�zek v pln� velikosti');
@define('USERGALLERY_DOWNLOAD_HERE', 'Download - klikn�te zde!');
@define('USERGALLERY_LINKED_ENTRIES', 'P��sp�vky obsahuj�c� tento obr�zek:');
@define('USERGALLERY_LINKED_STATICPAGES', 'Statick� str�nky zborazuj�c� tento obr�zek:');
@define('PLUGIN_EVENT_USERGALLERY_SHOW_LINKED_ENTRY', 'Zobrazit odkaz na p��sp�vky obsahuj�c� obr�zek?');
@define('PLUGIN_EVENT_USERGALLERY_DIRTAB_NAME','Odsazen� podadres��� ve stromu adres���');
@define('PLUGIN_EVENT_USERGALLERY_DIRTAB_DESC','Odsazen� podadres��e od rodi�ovsk�ho adres��e v pixelech.');
@define('PLUGIN_EVENT_USERGALLERY_IMAGE_WIDTH_NAME','Max. ���ka obr�zku');
@define('PLUGIN_EVENT_USERGALLERY_IMAGE_WIDTH_DESC','Maxim�ln� ���ka obr�zku. Na tuto ���u budou zmen�eny v�t�� obr�zky v p��pad� zobrazen� "P�izp�soben� m���tko". Nastaven� na "0" znamen� bez omezen� - v�echny obr�zky jsou zobrazen� v p�vodn� velikosti.');

//Media properties
@define('PLUGIN_EVENT_USERGALLERY_MEDIA_PROPERTIES_SHOW_NAME', 'Zobrazit vlastnosti obr�zk�');
@define('PLUGIN_EVENT_USERGALLERY_MEDIA_PROPERTIES_SHOW_DESC', 'Zobrazit vlastnosti obr�zk� p�i�azen� v knihovn� m�di�?');
@define('PLUGIN_EVENT_USERGALLERY_MEDIA_PROPERTIES_NAME', 'Seznam vlastnost� obr�zku');
@define('PLUGIN_EVENT_USERGALLERY_MEDIA_PROPERTIES_DESC', 'Toto je definice seznamu vlastnost� obr�zku a p�i�azen� popis jednotliv�ch polo�ek. Form�t je "POLO�KA1:N�zev polo�ky 1;POLO�KA2: N�zev polo�ky 2", kde jednotliv� polo�ky jsou odd�len� st�edn�kem, prvn� je n�zev vlastnosti (jak jsou vyps�ny v "Nastaven� blogu", pak ��rka, pak zobrazen� jm�no.');

//Several consants used in the template
@define('PLUGIN_EVENT_USERGALLERY_IMAGES', 'obr�zky');
@define('PLUGIN_EVENT_USERGALLERY_PAGINATION', 'Str�nka %s z %s, celkem %s obr�zk�');

@define('PLUGIN_EVENT_USERGALLERY_RSS_FEED_BODY', 'Pou��t origin�ln� form�t p��sp�vku pro obr�zek v RSS kan�lu?');
@define('PLUGIN_EVENT_USERGALLERY_RSS_FEED_BODY_DESC', 'Pokud je povoleno, obr�zek z knihovny m�di�, kter� byl pou�it v p��sp�vku na blogu, bude m�t v RSS kan�lu stejn� t�lo p��sp�vku jako p��sp�vek m�sto v�choz�ho jednoduch�ho odkazu na p��sp�vek a p�vodn� um�st�n� obr�zku.');

