<?php

/**
 *  @version $$
 *  @author Martin Matu�ka <martin@matuska.org>
 *  EN-Revision: Revision of lang_en.inc.php
 */

@define('PLUGIN_EVENT_CONTENTREWRITE_FROM', 'slovo');
@define('PLUGIN_EVENT_CONTENTREWRITE_TO', 'popis');
@define('PLUGIN_EVENT_CONTENTREWRITE_NAME', 'Prepisova� obsahu');
@define('PLUGIN_EVENT_CONTENTREWRITE_DESCRIPTION', 'Nahradzuje slov� �ubovoln�m re�azcom (u�ito�n� na vkladanie akronymov)');
@define('PLUGIN_EVENT_CONTENTREWRITE_NEWTITLE', 'Nov� nadpis');
@define('PLUGIN_EVENT_CONTENTREWRITE_NEWTDESCRIPTION', 'Zadajte slovo akronymu (to, ktor� m� by� v texte h�adan� a nahraden�) pre nov� polo�ku ({slovo})');
@define('PLUGIN_EVENT_CONTENTREWRITE_OLDTITLE', 'Slovo ��slo %d');
@define('PLUGIN_EVENT_CONTENTREWRITE_OLDTDESCRIPTION', 'Zadejte akronym (prepisovan� slovo) ({slovo})');
@define('PLUGIN_EVENT_CONTENTREWRITE_PTITLE', 'Nadpis doplnku');
@define('PLUGIN_EVENT_CONTENTREWRITE_PDESCRIPTION', 'Nadpis tohto doplnku');
@define('PLUGIN_EVENT_CONTENTREWRITE_NEWDESCRIPTION', 'Nov� popis');
@define('PLUGIN_EVENT_CONTENTREWRITE_NEWDDESCRIPTION', 'Zadajte popis, ktor� se m� k akronymu prida� ({popis})');
@define('PLUGIN_EVENT_CONTENTREWRITE_OLDDESCRIPTION', 'Popis ��slo %s');
@define('PLUGIN_EVENT_CONTENTREWRITE_OLDDDESCRIPTION', 'Zadajte popis akronymu ({popis})');
@define('PLUGIN_EVENT_CONTENTREWRITE_REWRITESTRING', 'Prepisovac� re�azec');
@define('PLUGIN_EVENT_CONTENTREWRITE_REWRITESTRING_DESC', 'The string used to rewrite. Place {from} and {to} anywhere you like to get a rewrite.' . "\n" . 'Example: <acronym title="{to}">{from}</acronym>');
@define('PLUGIN_EVENT_CONTENTREWRITE_REWRITECHAR', 'Prepisovanie znakov');
@define('PLUGIN_EVENT_CONTENTREWRITE_REWRITECHARDESC', 'Zmazanie znakov zo slova ({slovo}) - pr�klad pou�itia: M�te podnikov� weblog a ved�cich Hru�ku, Dlh�ho a Mokr�ho. Chcete, aby boli men� ved�cich zv�raz�ovan�, ale nechcete, aby slovo hru�ka odkazovalo na ved�ceho, ke� ide o ovocie. V texte budete p�sa� Hru�ka_ved�ci, Dlh�_ved�ci a Mokr�_ved�ci. V tomto poli zad�te \'_ved�ci\'. T�to pr�pona V�m umo�n� rozpozna� ved�cich, ale sama sa nebude v poli {slovo} zobrazova�.');
@define('PLUGIN_EVENT_CONTENTREWRITE_REWRITESTRING_EX', 'Va�e nahradzovan� re�azce s� "%s" a "%s".');

