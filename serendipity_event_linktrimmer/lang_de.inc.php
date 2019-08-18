<?php

define('PLUGIN_LINKTRIMMER_NAME', 'Linkverk�rzung');
define('PLUGIN_LINKTRIMMER_DESC', 'Erm�glicht Linkverk�rzung zur Weiterleitung in Ihrem eigenen Blog, z.B. vermittels tr.im, tinyurl.com usw.');
define('PLUGIN_LINKTRIMMER_ENTER', 'URL eingeben: ');
define('PLUGIN_LINKTRIMMER_HASH', 'Optional Hash: ');
define('PLUGIN_LINKTRIMMER_RESULT', 'Verk�rztes Resultat: ');
define('PLUGIN_LINKTRIMMER_ERROR', 'Link konnte nicht gek�rzt werden. M�glicherweise handelt es sich um ein Duplikat, einen ung�ltigen benutzerdefinierten Hash oder einen Datenbankfehler.');
define('PLUGIN_LINKTRIMMER_LINKPREFIX', 'Link-Prefix');
define('PLUGIN_LINKTRIMMER_LINKPREFIX_DESC', 'Geben Sie einen eindeutigen URL-Teil ein, der innerhalb Ihrer Domain als Basis-URL f�r den Linkverk�rzer verwendet wird. Wenn Sie beispielsweise "l" eingeben, sehen Ihre URLs wie folgt aus: http://yourblog/l/ feda [mit aktiviertem URL-Rewriting] oder http://yourblog/index.php?/L/feda [ohne URL-Rewriting ]. Lassen Sie das Feld niemals leer, auch wenn Sie eine separate Domain f�r Ihre kurzen URLs haben.');
define('PLUGIN_LINKTRIMMER_DOMAIN', 'Domain');
define('PLUGIN_LINKTRIMMER_DOMAIN_DESC', 'Der Link, der f�r die Ausgabe verwendet wird. Sie k�nnen die .htaccess-Umleitung jeder anderen, ihnen geh�renden Domain verwenden und diese hier eingeben. Wenn Sie Serendipity auf http://mylongdomain.com/serendipity/ installiert haben, aber auch http://short.com/ besitzen, k�nnen Sie hier http://short.com/ eingeben und innerhalb des .htaccess von short.com alles umleiten zu Ihrer langen Domain:  RewriteRule ^(.*)$ http://longdomain.com/serendipity/yourprefix/$1 (alternativ: redirectMatch 301 ^(.*)$ http://longdomain.com/serendipity/yourprefix/$1). URLs werden dann zweimal umgeleitet: von short.com zu mylongdomain.com zur urspr�nglichen URL.');

define('PLUGIN_LINKTRIMMER_FRONTPAGE_OPTION', 'Linkverk�rzer auf der Backend-Startseite anzeigen?');

