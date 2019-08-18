<?php

@define('PLUGIN_DISQUS_TITLE', 'Disqus-Kommentare');
@define('PLUGIN_DISQUS_DESC', 'Disqus.com ist ein Webservice, mit dem Sie Kommentare zentral verwalten k�nnen. Der Dienst speichert und verwaltet Kommentare au�erhalb Ihrer Serendipity-Installation und ist mit JavaScript eingebettet. Weitere Informationen finden Sie unter https://disqus.com/.');
@define('PLUGIN_DISQUS_DESC2', '
Das Plugin f�gt die DISQUS-Ausgabe in die Smarty-Variablen {$entry.plugin_display_dat} und {$entry.disqus} ein, die Sie an einer beliebigen Stelle im {$entry}-Loop in Ihre entries.tpl-Vorlage einf�gen k�nnen.

Wenn der angezeigte Eintrag bereits DISQUS-Unterst�tzung bietet, ist die Variable {$entry.has_disqus} wahr (true).
');
@define('PLUGIN_DISQUS_ENABLE_SINCE', 'Aktiviere disqus.com f�r Eintr�ge seit ...');
@define('PLUGIN_DISQUS_ENABLE_SINCE_DESC', 'Geben Sie ein Datum (Y-m-d) ein, ab dem Disqus-Kommentare aktiviert werden sollen, damit auch �ltere Kommentare noch ordnungsgem�� angezeigt werden.');
@define('PLUGIN_DISQUS_SHORTNAME', 'Kurzname Ihres Disqus-Blog-Kontos');
@define('PLUGIN_DISQUS_SHORTNAME_DESC', 'Geben Sie den Kurznamen (shortname) dieses Blogs ein, den Sie in Ihrem Disqus-Konto registriert haben.');
@define('PLUGIN_DISQUS_FOOTERCOMMENTLINK', 'DISQUS die Anzahl der Kommentare in der Fu�zeile anzeigen lassen');
@define('PLUGIN_DISQUS_FOOTERCOMMENTLINK_DESC', 'Da die Anzahl der Kommentare nicht bekannt ist, f�gt dieses Plugin nur "Kommentare" statt "N Kommentare" in die Fu�zeile ein. Sie k�nnen DISQUS veranlassen, dies durch die richtige Anzahl zu ersetzen. In einigen Vorlagen wird dies jedoch m�glicherweise nicht korrekt angezeigt, so dass Sie das dynamische Ersetzen von DISQUS hier deaktivieren k�nnen.');
@define('PLUGIN_DISQUS_HIDE_COMMENTCSS', 'Kommentar-CSS ausblenden');
@define('PLUGIN_DISQUS_HIDE_COMMENTCSS_DESC', 'Wenn disqus.com-Kommentare aktiviert sind, funktionieren alle Funktionen, die auf in Serendipity gespeicherten Kommentaren basieren, nat�rlich nicht mehr. Intern verwendet dieses Plugin CSS, um die Serendipity-Ausgabe f�r Kommentare und das Kommentarformular auszublenden. Daf�r setzt es f�r diese CSS-Klassen "display: none". Bitte geben Sie die in Ihrem Theme verwendeten Klassen ein, mit denen Sie Ihren Kommentarbereich und Ihr Kommentarformular ausgezeichnet haben. Der Standard sollte f�r die meisten Themes funktionieren.');

