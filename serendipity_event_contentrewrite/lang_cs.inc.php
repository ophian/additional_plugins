<?php 

/**
 *  @author Vladim�r Ajgl <vlada@ajgl.cz>
 *  EN-Revision: Revision of lang_en.inc.php
 *  First-transaltion: Vladimir Ajgl <vlada@ajgl.cz> 2007-12-11
 */

@define('PLUGIN_EVENT_CONTENTREWRITE_FROM', 'slovo');
@define('PLUGIN_EVENT_CONTENTREWRITE_TO', 'popis');
@define('PLUGIN_EVENT_CONTENTREWRITE_NAME', 'P�episova� obsahu');
@define('PLUGIN_EVENT_CONTENTREWRITE_DESCRIPTION', 'Nahrazuje slovat libovoln�m �et�zcem (u�ite�n� pro vkl�d�n� akronym�)');
@define('PLUGIN_EVENT_CONTENTREWRITE_NEWTITLE', 'Nov� nadpis');
@define('PLUGIN_EVENT_CONTENTREWRITE_NEWTDESCRIPTION', 'Zadejte slovo akronymu (to, kter� m� b�t v textu hled�no a nahrazov�no) pro novou polo�ku ({slovo})');
@define('PLUGIN_EVENT_CONTENTREWRITE_OLDTITLE', 'Slovo ��slo %d');
@define('PLUGIN_EVENT_CONTENTREWRITE_OLDTDESCRIPTION', 'Zadejte akronym (p�episovan� slovo) ({slovo})');
@define('PLUGIN_EVENT_CONTENTREWRITE_PTITLE', 'Nadpis Pluginu');
@define('PLUGIN_EVENT_CONTENTREWRITE_PDESCRIPTION', 'Nadpis tohoto pluginu');
@define('PLUGIN_EVENT_CONTENTREWRITE_NEWDESCRIPTION', 'Nov� popis');
@define('PLUGIN_EVENT_CONTENTREWRITE_NEWDDESCRIPTION', 'Zadejte popis, kter� se m� k akronymu p�idat ({popis})');
@define('PLUGIN_EVENT_CONTENTREWRITE_OLDDESCRIPTION', 'Popis ��slo %s');
@define('PLUGIN_EVENT_CONTENTREWRITE_OLDDDESCRIPTION', 'Zadejte popis akronymu ({popis})');
@define('PLUGIN_EVENT_CONTENTREWRITE_REWRITESTRING', 'P�episovac� �et�zec');
@define('PLUGIN_EVENT_CONTENTREWRITE_REWRITESTRING_DESC', 'The string used to rewrite. Place {from} and {to} anywhere you like to get a rewrite.' . "\n" . 'Example: <acronym title="{to}">{from}</acronym>');
@define('PLUGIN_EVENT_CONTENTREWRITE_REWRITECHAR', 'P�episov�n� znak�');
@define('PLUGIN_EVENT_CONTENTREWRITE_REWRITECHARDESC', 'Odmaz�v�n� znak� ze slova ({slovo}) - p��klad pou�it�: M�te podnikov� blog a ��fy Hru�ku, Jel�nka a Vr�tn�ho. Chcete, aby se jm�na ��f� zv�raz�ovala, ale nechcete, aby se slovo hru�ka odkazovalo na ��fa, pokud mluv�te o ovoci, podobn� se slivovic�, p��padn� nechcete zam��ovat ��fa s d�chodcem na vr�tnici. V textu budete ps�t Hru�ka_��f, Jel�nek_��f, Vr�tn�_��f. V tomto poli zad�te \'_��f\'. Tato p��pona V�m umo�n� rozpoznat ��fy, ale sama o sob� se nebude v poli {slovo} zobrazovat.');
@define('PLUGIN_EVENT_CONTENTREWRITE_REWRITESTRING_EX', 'Va�e nahrazovac� �et�zce jsou "%s" a "%s".');

