<?php

/**
 *  @author Vladim�r Ajgl <vlada@ajgl.cz>
 *  @translated 2009/05/13
 */

@define('PLUGIN_AUDIOSCROBBLER_TITLE', 'Audioscrobbler');
@define('PLUGIN_AUDIOSCROBBLER_TITLE_BLAHBLAH', 'Ze slu�by audioscrobbler.net (neblo last.fm) Zobrazuje naposledy p�ehr�van� skladby');
@define('PLUGIN_AUDIOSCROBBLER_NUMBER', 'Po�et skladeb');
@define('PLUGIN_AUDIOSCROBBLER_NUMBER_BLAHBLAH', 'Kolik posledn�ch skladeb se m� zobrazovat? (mus� b�t v�t�� nebo rovna 1; obvykl� hodnota: 1)');
@define('PLUGIN_AUDIOSCROBBLER_USERNAME', 'U�ivatelsk� jm�no na Audioscrobbleru');
@define('PLUGIN_AUDIOSCROBBLER_USERNAME_BLAHBLAH', 'Zadejte sv� u�ivatelsk� jm�no ke slu�b� audioscrobbler, aby se mohl plugin p�ipojit k Va�emu RSS kan�lu.');
@define('PLUGIN_AUDIOSCROBBLER_NEWWINDOW', 'Nov� okno');
@define('PLUGIN_AUDIOSCROBBLER_NEWWINDOW_BLAHBLAH', 'Maj� se odkazy otev�rat v nov�m okn�? (pou��v� javascript)');
@define('PLUGIN_AUDIOSCROBBLER_CACHETIME', 'Jak �asto se m� aktualizovat seznam skladeb?');
@define('PLUGIN_AUDIOSCROBBLER_CACHETIME_BLAHBLAH', 'Obsah RSS kan�lu z Audioscrobbleru se ukl�d� do cache. Ta je obnovov�na po uplynut� zde zadan�ho �asu v minut�ch. (v�choz�: 30, minim�ln� hodnota: 5 minut)');
@define('PLUGIN_AUDIOSCROBBLER_FORMATSTRING', 'Form�tov�n� ��dk�');
@define('PLUGIN_AUDIOSCROBBLER_FORMATSTRING_BLAHBLAH', 'Pou�ijte prom�nnou %ARTIST% pro um�st�n� jm�na interpreta, %SONG% pro n�zev skladby, %ALBUM% pro n�zev alba a %DATE% pro datum.');
@define('PLUGIN_AUDIOSCROBBLER_UTCDIFFERENCE', 'Posun �asu v��i GMT (Greenwichsk� �as)');
@define('PLUGIN_AUDIOSCROBBLER_UTCDIFFERENCE_BLAHBLAH', 'Posun v��i Greenwichsk�mu �asu (nap�. EST, tj. Boston a New York v USA = -5)');
@define('PLUGIN_AUDIOSCROBBLER_FORMATSTRING_BLOCK', 'Form�t postrann�ho bloku Audioscrobbler');
@define('PLUGIN_AUDIOSCROBBLER_FORMATSTRING_BLOCK_BLAHBLAH', 'Pou�ijte prom�nnou %ENTRIES% pro seznam skladeb, %PROFILE% pro zobrazen� odkazu na V� profil na Audioscrobbleru a %LASTUPDATE% pro datum, kdy byl naposledy obnoven obsah cache s RSS kan�lem.');
@define('PLUGIN_AUDIOSCROBBLER_PROFILETITLE', 'Text odkazu na profil');
@define('PLUGIN_AUDIOSCROBBLER_PROFILETITLE_BLAHBLAH', 'Text, kter� se zobrazuje jako odkaz na V� profil Audioscrobbler. (u�ivatelsk� jm�no vlo��te pomoc� %USER%)');
@define('PLUGIN_AUDIOSCROBBLER_SONGLINK', 'Skladby jako odkazy?');
@define('PLUGIN_AUDIOSCROBBLER_SONGLINK_BLAHBLAH', 'Maj� b�t n�zvy skladeb jako odkazy na jejich str�nku na Audioscrobbleru?');
@define('PLUGIN_AUDIOSCROBBLER_ARTISTLINK', 'Interpret jako odkaz?');
@define('PLUGIN_AUDIOSCROBBLER_ARTISTLINK_BLAHBLAH', 'Maj� se jm�na interpret� zobrazovat jako odkazy? (vyberte slu�bu)');
@define('PLUGIN_AUDIOSCROBBLER_ARTISTLINK_NONE', 'ne');
@define('PLUGIN_AUDIOSCROBBLER_ARTISTLINK_SCROBBLER', 'Str�nka interpreta na Audioscrobbleru');
@define('PLUGIN_AUDIOSCROBBLER_ARTISTLINK_MUSICBRAINZ_ELSE_NONE', 'Musicbrainz, pokud je dostupn�');
@define('PLUGIN_AUDIOSCROBBLER_ARTISTLINK_MUSICBRAINZ_ELSE_SCROBBLER', 'Musicbrainz, pokud nen� dostupn�, pak Audioscrobbler');
@define('PLUGIN_AUDIOSCROBBLER_SPACER', 'Odd�lova�');
@define('PLUGIN_AUDIOSCROBBLER_SPACER_BLAHBLAH', 'Co se m� pou��t jako odd�lova� jednotliv�ch skladeb v seznamu skladeb?');
@define('PLUGIN_AUDIOSCROBBLER_COULD_NOT_WRITE', 'Cache nemohla b�t ulo�ena');
@define('PLUGIN_AUDIOSCROBBLER_COULD_NOT_READ', 'Cache nemohla b�t p�e�tena');
@define('PLUGIN_AUDIOSCROBBLER_FEED_OFFLINE', 'Audioscrobbler je offline');
@define('PLUGIN_AUDIOSCROBBLER_STACK', 'Pou��t vypl�ov�n� seznamu skladeb?');
@define('PLUGIN_AUDIOSCROBBLER_STACK_BLAHBLAH', 'Pokud je po�et skladeb ve Va�em seznamu skladeb men��, ne� kolik skladeb chcete zobrazovat v postrann�m bloku, m��ete povolit puginu, aby zb�vaj�c� voln� m�sta zaplnil posledn� skladbou.');
@define('PLUGIN_AUDIOSCROBBLER_NUMBER_BLAHBLAH', 'Kolik posledn�ch skladeb se m� zobrazovat? (mus� b�t v�t�� nebo rovna 1; obvykl� hodnota: 1)');
@define('PLUGIN_AUDIOSCROBBLER_FORCE_ENCODING', 'Vynutit k�dov�n�:');
@define('PLUGIN_AUDIOSCROBBLER_FORCE_ENCODING_BLAHBLAH', 'Serendipity p�edpokl�d�, �e data z Audioscrobbleru p�ich�z� v k�dov�n� UTF-8. Pokud se n�kter� speci�ln� znaky nezobrazuj� spr�vn�, proto�e V� blog nem� nastavenou znakovou sadu na UTF-8, zadejte zde odpov�daj�c� k�dov�n�.');

