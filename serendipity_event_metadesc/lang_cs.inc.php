<?php

/**
 *  @author Vladim�r Ajgl <vlada@ajgl.cz>
 *  @translated 2009/07/16
 *  @author Vladim�r Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2011/01/11
 *  @author Vladim�r Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2011/01/20
 */

@define('PLUGIN_METADESC_NAME', 'HTML META tagy');
@define('PLUGIN_METADESC_DESC', 'Zadejte HTML meta tagy pro kl��ov� slova nebo popis blogu. Tak� m��ete zad�vat r�zn� titulek pro jednotliv� str�nky blogu a v�choz� hodnotu pro kl��ov� slova/popis pro str�nky se zobrazenm v�ce p��sp�vk� (v�choz� str�nka, p�ehledy kategori�).');
@define('PLUGIN_METADESC_FORM', 'Pokud ponech�te tato pol��ka pr�zdn�, pak bude prvn�ch 120 znak� p��sp�vku pou�ito jako popis (meta description). Pokud nep�jdou vygenerovat kl��ov� slova na z�klad� HTML tag� pro kl��ov� slova, budou pou�ita v�choz� kl��ov� slova (meta keywords).<br /><br />Doporu�en� pro psan� popisu (meta description)<sup>*</sup>: 20 a� 30 slov, nejv��e 120 a� 180 znak� v�etn� mezer.<br />Doporu�en� pro kl��ov� slova (meta keywords)<sup>*</sup>: 15 a� 20 nejv�sti�n�j��ch slov vyskytuj�c�ch se v p��sp�vku.');
@define('PLUGIN_METADESC_DESCRIPTION', 'META-Description:');
@define('PLUGIN_METADESC_KEYWORDS', 'META-Keywords:');
@define('PLUGIN_METADESC_HEADTITLE_DESC', 'Tag TITLE v hlavi�ce HTML k�du m��e b�t p�izp�soben pomoc� n�sleduj�c�ho pole. Pokud ponech�te pole pr�zdn�, nadpis bude vygenerov�n podle �ablony, co� je obvykle "Nadpis p��sp�vku - nadpis blogu".   <br /><br />Doporu�en�<sup>*</sup>: 3 a� 9 slov, nanejv�� 64 znak� v�etn� mezer, nejd�le�it�j�� slova jako prvn�.');
@define('PLUGIN_METADESC_HEADTITLE', 'Tag TITLE v HTML k�du str�nky');
@define('PLUGIN_METADESC_LENGTH', 'D�lka');
@define('PLUGIN_METADESC_WORDS', 'slov');
@define('PLUGIN_METADESC_CHARACTERS', 'znak�');
@define('PLUGIN_METADESC_STRINGLENGTH_DISCLAIMER', 'Po�et slov a znak� v doporu�en� je pouze doporu�en�, m��ete napsat libovoln� dlouh� text.');
@define('PLUGIN_METADESC_TAGNAMES', 'HTML tagy pro generov�n� kl��ov�ch slov');
@define('PLUGIN_METADESC_TAGNAMES_DESC', 'Zadejte seznam HTML tag�, kter� obsahuj� kl��ov� slova a ve kter�ch maj� b�t kl��ov� slova hled�na. Jednotliv� tagy odd�lujte ��rkou.');
@define('PLUGIN_METADESC_DEFAULT_DESCRIPTION', 'V�choz� HTML meta description');
@define('PLUGIN_METADESC_DEFAULT_DESCRIPTION_DESC', 'Zadejte v�choz� hodnotu pro popis str�nky (meta description), kter� se pou�ije na p�ehledov�ch stran�ch. Tj. tam, kde je zobrazeno v�ce p��sp�vk� najednou.');
@define('PLUGIN_METADESC_DEFAULT_KEYWORDS', 'V�choz� HTML meta keywords');
@define('PLUGIN_METADESC_DEFAULT_KEYWORDS_DESC', 'Zadejte seznam ��rkou odd�len�ch kl��ov�ch slov, kter� se maj� pou��t na str�nk�ch, kter� zobrazuj� v�ce p��sp�vk�.');

// Next lines were translated on 2011/01/11

@define('PLUGIN_METADESC_ESCAPE', 'Escapovat HTML entity');

// Next lines were translated on 2011/01/20
@define('PLUGIN_METADESC_ESCAPE_DESC', 'Nahradit ��d�c� znaky jazyka HTML v popisu meta-description nebo v kl��ov�ch slovech pomoc� odpov�daj�c�ch HTML entit. K nahrazen� se pou��v� funkce htmlspecialchars().');

