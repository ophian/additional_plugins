<?php

/**
 *  @version $$
 *  @author Martin Matu¹ka <martin@matuska.org>
 *  EN-Revision: Revision of lang_en.inc.php
 */

@define('PLUGIN_EVENT_CONTENTREWRITE_FROM', 'slovo');
@define('PLUGIN_EVENT_CONTENTREWRITE_TO', 'popis');
@define('PLUGIN_EVENT_CONTENTREWRITE_NAME', 'Prepisovaè obsahu');
@define('PLUGIN_EVENT_CONTENTREWRITE_DESCRIPTION', 'Nahradzuje slová µubovolným re»azcom (u¾itoèné na vkladanie akronymov)');
@define('PLUGIN_EVENT_CONTENTREWRITE_NEWTITLE', 'Nový nadpis');
@define('PLUGIN_EVENT_CONTENTREWRITE_NEWTDESCRIPTION', 'Zadajte slovo akronymu (to, ktoré má by» v texte hµadané a nahradené) pre novú polo¾ku ({slovo})');
@define('PLUGIN_EVENT_CONTENTREWRITE_OLDTITLE', 'Slovo èíslo %d');
@define('PLUGIN_EVENT_CONTENTREWRITE_OLDTDESCRIPTION', 'Zadejte akronym (prepisované slovo) ({slovo})');
@define('PLUGIN_EVENT_CONTENTREWRITE_PTITLE', 'Nadpis doplnku');
@define('PLUGIN_EVENT_CONTENTREWRITE_PDESCRIPTION', 'Nadpis tohto doplnku');
@define('PLUGIN_EVENT_CONTENTREWRITE_NEWDESCRIPTION', 'Nový popis');
@define('PLUGIN_EVENT_CONTENTREWRITE_NEWDDESCRIPTION', 'Zadajte popis, ktorý se má k akronymu prida» ({popis})');
@define('PLUGIN_EVENT_CONTENTREWRITE_OLDDESCRIPTION', 'Popis èíslo %s');
@define('PLUGIN_EVENT_CONTENTREWRITE_OLDDDESCRIPTION', 'Zadajte popis akronymu ({popis})');
@define('PLUGIN_EVENT_CONTENTREWRITE_REWRITESTRING', 'Prepisovací re»azec');
@define('PLUGIN_EVENT_CONTENTREWRITE_REWRITESTRING_DESC', 'The string used to rewrite. Place {from} and {to} anywhere you like to get a rewrite.' . "\n" . 'Example: <acronym title="{to}">{from}</acronym>');
@define('PLUGIN_EVENT_CONTENTREWRITE_REWRITECHAR', 'Prepisovanie znakov');
@define('PLUGIN_EVENT_CONTENTREWRITE_REWRITECHARDESC', 'Zmazanie znakov zo slova ({slovo}) - príklad pou¾itia: Máte podnikový weblog a vedúcich Hru¹ku, Dlhého a Mokrého. Chcete, aby boli mená vedúcich zvýrazòované, ale nechcete, aby slovo hru¹ka odkazovalo na vedúceho, keï ide o ovocie. V texte budete písa» Hru¹ka_vedúci, Dlhý_vedúci a Mokrý_vedúci. V tomto poli zadáte \'_vedúci\'. Táto prípona Vám umo¾ní rozpozna» vedúcich, ale sama sa nebude v poli {slovo} zobrazova».');
@define('PLUGIN_EVENT_CONTENTREWRITE_REWRITESTRING_EX', 'Va¹e nahradzované re»azce sú "%s" a "%s".');

