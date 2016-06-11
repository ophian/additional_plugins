<?php

/**
 *  @author Vladim�r Ajgl <vlada@ajgl.cz>
 *  @translated 2009/08/14
 *  @author Vladim�r Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2013/06/22
 */
@define('PLUGIN_LINKTRIMMER_NAME', 'Zkracova� adres');
@define('PLUGIN_LINKTRIMMER_DESC', 'Umo��uje zkr�tit odkaz na V� blog, podobn� jako t�eba tr.im, tinyurl.com apod.');
@define('PLUGIN_LINKTRIMMER_ENTER', 'Zadejte URL adresu: ');
@define('PLUGIN_LINKTRIMMER_HASH', 'voliteln� hash k�d: ');
@define('PLUGIN_LINKTRIMMER_RESULT', 'Zkr�cen� v�sledek: ');
@define('PLUGIN_LINKTRIMMER_ERROR', 'Odkaz nelze zkr�tit. Mo�n� se jedn� o duplicitu, neplatn� hash nebo datab�zovou chybu.');
@define('PLUGIN_LINKTRIMMER_LINKPREFIX', 'P�edpona odkazu');
@define('PLUGIN_LINKTRIMMER_LINKPREFIX_DESC', 'Zadejte jedine�nou ��st URL adresy, kter� bude pou�ita ve Va�� dom�n� pro identifikaci zkracova�e odkaz�. Pokud nap�. zad�te "I", Va�e URL adresa bude vypadat jako http://vasBlog/l/feda [se zapnut�m p�episov�n�m URL adres] nebo http://vasBlog/l/feda [bez URL p�episov�n�]');
@define('PLUGIN_LINKTRIMMER_DOMAIN', 'Dom�na');
@define('PLUGIN_LINKTRIMMER_DOMAIN_DESC', 'Odkaz pou�it� jako v�sledek. M��ete pou��t p�esm�rov�n� pomoc� .htaccess na jin� dom�n�, kterou vlastn�te. Tu zad�te zde. Pokud Va�e Serendipity b�� na http://vaseDlouhaDomena.cz/serendipity, ale vlastn�te taky http://kratka.cz, m��ete zde zadat http://kratka.cz a na http://kratka.cz um�st�t� soubor .htaccess, kter� bude v�echno p�esm�rov�vat na dlouhou dom�nu n�sledovn�: RewriteRule ^(.*)$ http://vaseDlouhaDomena.cz/serendipity/$1.');

// Next lines were translated on 2013/06/22
@define('PLUGIN_LINKTRIMMER_FRONTPAGE_OPTION', 'Zobrazovat zkracova� adres na hlavn� str�nce administra�n� sekce?');

