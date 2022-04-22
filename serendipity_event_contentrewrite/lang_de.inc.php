<?php

@define('PLUGIN_EVENT_CONTENTREWRITE_FROM', 'quelle');
@define('PLUGIN_EVENT_CONTENTREWRITE_TO', 'ziel');
@define('PLUGIN_EVENT_CONTENTREWRITE_NAME', 'Wort-Ersetzer');
@define('PLUGIN_EVENT_CONTENTREWRITE_DESCRIPTION', 'Ersetzt ein Wort mit einem neuen Inhalt, z.B. f�r Akronyme');
@define('PLUGIN_EVENT_CONTENTREWRITE_NEWTITLE', 'Neuer Titel');
@define('PLUGIN_EVENT_CONTENTREWRITE_NEWTDESCRIPTION', 'Der Akronym-Titel des neuen Eintrages ({quelle})');
@define('PLUGIN_EVENT_CONTENTREWRITE_OLDTITLE', 'Titel #%d');
@define('PLUGIN_EVENT_CONTENTREWRITE_OLDTDESCRIPTION', 'Das Akronym ({quelle})');
@define('PLUGIN_EVENT_CONTENTREWRITE_PTITLE', 'Plugin Titel');
@define('PLUGIN_EVENT_CONTENTREWRITE_PDESCRIPTION', 'Der Name dieses Pligins');
@define('PLUGIN_EVENT_CONTENTREWRITE_NEWDESCRIPTION', 'Neue Beschreibung');
@define('PLUGIN_EVENT_CONTENTREWRITE_NEWDDESCRIPTION', 'Die Beschreibung des neuen Eintrages ({ziel})');
@define('PLUGIN_EVENT_CONTENTREWRITE_OLDDESCRIPTION', 'Beschreibung #%s');
@define('PLUGIN_EVENT_CONTENTREWRITE_OLDDDESCRIPTION', 'Die Beschreibung des Eintrages ({ziel})');
@define('PLUGIN_EVENT_CONTENTREWRITE_REWRITESTRING', 'Umformungsmaske');
@define('PLUGIN_EVENT_CONTENTREWRITE_REWRITESTRING_DESC', 'Ein beliebiger Text der zur Ersetzung verwendet werden soll. F�gen Sie {quelle} und {ziel} irgendwo in diesem Text ein.' . "\n" . 'Beispiel: <acronym title="{ziel}">{quelle}</acronym>');
@define('PLUGIN_EVENT_CONTENTREWRITE_REWRITECHAR', 'Rewrite Zeichen');
@define('PLUGIN_EVENT_CONTENTREWRITE_REWRITECHARDESC', 'Falls es ein besonderes Zeichen geben soll, was die Wort-Ersetzung ausf�hrt, geben Sie es hier an. Falls z.B. nur \'serendipity*\' damit ersetzt werden soll, was Sie als Akronym f�r \'serendipity\' definiert haben, und das \'*\' soll entfernt werden, dann geben Sie dieses Zeichen an.');
@define('PLUGIN_EVENT_CONTENTREWRITE_REWRITESTRING_EX', 'Die Zeichenfolgen f�r die Ersetzung in Ihren Texten sind "%s" und "%s".');

