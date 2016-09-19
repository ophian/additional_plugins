<?php

/**
 *  @author Vladim�r Ajgl <vlada@ajgl.cz>
 *  EN-Revision: Revision of lang_en.inc.php
 *  Czech translation to userprofiles plugin
 *  CS-Revision date: 1.3.2007
 *  @author Vladimir Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2009/02/15
 */

//
//  for serendipity_event_userprofiles.php
//
@define('PLUGIN_EVENT_USERPROFILES_DBVERSION',		'0.1');
@define('PLUGIN_EVENT_USERPROFILES_ILINK',		'<input class="direction_ltr" id="serendipity_event_userprofiles%s" type="radio" %s name="serendipity[profile%s]" value="%s" title="%s" />');
@define('PLUGIN_EVENT_USERPROFILES_LABEL',		'<label for="serendipity_event_userprofiles%s">%s</label>');

@define('PLUGIN_EVENT_USERPROFILES_CITY',		'M�sto');
@define('PLUGIN_EVENT_USERPROFILES_COUNTRY',		'Zem�');
@define('PLUGIN_EVENT_USERPROFILES_URL',		'Web');
@define('PLUGIN_EVENT_USERPROFILES_OCCUPATION',		'Povol�n�');
@define('PLUGIN_EVENT_USERPROFILES_HOBBIES',		'Z�jmy a z�liby');
@define('PLUGIN_EVENT_USERPROFILES_YAHOO',		'Yahoo');
@define('PLUGIN_EVENT_USERPROFILES_AIM',		'AIM');
@define('PLUGIN_EVENT_USERPROFILES_JABBER',		'Jabber');
@define('PLUGIN_EVENT_USERPROFILES_ICQ',		'ICQ');
@define('PLUGIN_EVENT_USERPROFILES_MSN',		'MSN');
@define('PLUGIN_EVENT_USERPROFILES_SKYPE',		'Skype');
@define('PLUGIN_EVENT_USERPROFILES_STREET',		'Ulice');
@define('PLUGIN_EVENT_USERPROFILES_BIRTHDAY',		'Den narozen�');

@define('PLUGIN_EVENT_USERPROFILES_SHOWEMAIL',		'Uka� e-maily');
@define('PLUGIN_EVENT_USERPROFILES_SHOWCITY',		'Uka� m�sto');
@define('PLUGIN_EVENT_USERPROFILES_SHOWCOUNTRY',		'Uka� zemi');
@define('PLUGIN_EVENT_USERPROFILES_SHOWURL',		'Uka� web');
@define('PLUGIN_EVENT_USERPROFILES_SHOWOCCUPATION',		'Uka� povol�n�');
@define('PLUGIN_EVENT_USERPROFILES_SHOWHOBBIES',		'Uka� z�liby');
@define('PLUGIN_EVENT_USERPROFILES_SHOWYAHOO',		'Uka� Yahoo');
@define('PLUGIN_EVENT_USERPROFILES_SHOWAIM',		'Uka� AIM');
@define('PLUGIN_EVENT_USERPROFILES_SHOWJABBER',		'Uka� Jabber');
@define('PLUGIN_EVENT_USERPROFILES_SHOWICQ',		'Uka� ICQ');
@define('PLUGIN_EVENT_USERPROFILES_SHOWMSN',		'Uka� MSN');
@define('PLUGIN_EVENT_USERPROFILES_SHOWSKYPE',		'Uka� Skype');
@define('PLUGIN_EVENT_USERPROFILES_SHOWSTREET',		'Uka� ulici');

@define('PLUGIN_EVENT_USERPROFILES_SHOW',		'Zobraz u�ivatelsk� profil vybran�ho autora:');
@define('PLUGIN_EVENT_USERPROFILES_TITLE',		'Profily u�ivatel�');
@define('PLUGIN_EVENT_USERPROFILES_DESC',		'Zobrazuje jednoduch� profily u�ivatel� a dovoluje p�ilo�it jejich fotku.');
@define('PLUGIN_EVENT_USERPROFILES_SELECT',		'Vyber u�ivatele k editaci.');
@define('PLUGIN_EVENT_USERPROFILES_VCARD',		'Vytvo� vizitku');
@define('PLUGIN_EVENT_USERPROFILES_VCARDCREATED_AT',		'Vizitka vytvo�ena v %s');
@define('PLUGIN_EVENT_USERPROFILES_VCARDCREATED_NOTE',		'Tuto vizitku naleznete v hnihovn� m�di�.');
@define('PLUGIN_EVENT_USERPROFILES_VCARDNOTCREATED',		'Nelze vytvo�it vizitku');

@define('PLUGIN_EVENT_AUTHORPIC_EXTENSION',		'P��pona souboru');
@define('PLUGIN_EVENT_AUTHORPIC_EXTENSION_BLAHBLAH',		'P��pona (typ - jpg, gif, ...) obr�zk� autor�');
@define('PLUGIN_EVENT_AUTHORPIC_ENABLED',		'Zobrazit fotku u�ivatele v p��sp�vku?');
@define('PLUGIN_EVENT_AUTHORPIC_ENABLED_DESC',		'Pokud je povoleno, fotka u�ivatele bude zobrazena u ka�d�ho jeho p��sp�vku. Vizu�ln� to ukazuje, kdo p��sp�vek napsal. Soubor s obr�zkem mus� b�t nejd��ve vlo�en do podadres��e "img" va�� vybran� �ablony (template) a mus� b�t pojmenov�n stejn� jako je autorovo jm�no. V�echny speci�ln� znaky (uvozovky, mezery, ...) mus� b�t ve jm�n� souboru nahrazeny znakem "_" (podtr��tko).');

//
//  for serendipity_plugin_userprofiles.php
//
@define('PLUGIN_USERPROFILES_NAME',		'Serendipity Authors');
@define('PLUGIN_USERPROFILES_NAME_DESC',		'Zobrazuje roz���en� profily autor�/u�ivatel�');
@define('PLUGIN_USERPROFILES_TITLE',		'Nadpis');
@define('PLUGIN_USERPROFILES_TITLE_DESC',		'Nadpis, kter� se bude zobrazovat v postrann�m panelu:');
@define('PLUGIN_USERPROFILES_TITLE_DEFAULT',		'Auto�i');

@define('PLUGIN_EVENT_AUTHORPIC_COMMENTCOUNT',		'Zobrazit po�et koment���?');
@define('PLUGIN_EVENT_AUTHORPIC_COMMENTCOUNT_BLAHBLAH',		'Chcete zobrazit po�et koment���, kter� n�v�t�vn�k napsal? Volba m��e b�t zak�z�na, nebo m��ete p�ipojit p�ed/za po�et koment��� k t�lu koment��e, anebo m��ete vlo�it po�et koment��� kamkoliv se v�m zl�b�, a to editac� �ablony comments.tpl. Text, kter� mus�te vlo�it, je: {$comment.plugin_commentcount} . M��ete upravit vzhled oblasti skrz css t��du .serendipity_commentcount.');
@define('PLUGIN_EVENT_AUTHORPIC_COMMENTCOUNT_APPEND',		'P�ipojit za koment��');
@define('PLUGIN_EVENT_AUTHORPIC_COMMENTCOUNT_PREPEND',		'P�ipojit p�ed koment��');
@define('PLUGIN_EVENT_AUTHORPIC_COMMENTCOUNT_SMARTY',		'Ru�n� um�st�n� v �ablon�');

@define('PLUGIN_USERPROFILES_GRAVATAR',		'Pou�ij sp�e Gravatar ne� m�stn� obr�zek?');
@define('PLUGIN_USERPROFILES_GRAVATAR_DESC',		'Pou�ije Gravatar obr�zek sdru�en� s va�� emailovou adresou.  Registrace na <a href="www.gravatar.com">www.gravatar.com</a>');
@define('PLUGIN_USERPROFILES_GRAVATAR_SIZE',		'Velikost Gravatar obr�zku');
@define('PLUGIN_USERPROFILES_GRAVATAR_SIZE_DESC',		'Nastavuje velikost zobrazen� obr�zku Gravatar, ve �tvere�n�ch pixelech. Max je 80.');
@define('PLUGIN_USERPROFILES_GRAVATAR_RATING',		'Maxim�ln� Gravatar hodnocen�');
@define('PLUGIN_USERPROFILES_GRAVATAR_RATING_DESC',		'Nastavuje nejvy��� povolen� hodnocen� pro Gravatar.  G, PG, R nebo X.');
@define('PLUGIN_USERPROFILES_GRAVATAR_DEFAULT',		'Um�st�n� defaultn�ho Gravatar obr�zku');
@define('PLUGIN_USERPROFILES_GRAVATAR_DEFAULT_DESC',		'Up�es�uje um�st�n� obr�zku k zobrazen�, pokud u�ivatel nem� Gravatar.');

@define('PLUGIN_USERPROFILES_BIRTHDAYSNAME',		'Narozeniny u�ivatel�');
@define('PLUGIN_USERPROFILES_BIRTHDAYTITLE',		'Narozeniny');
@define('PLUGIN_USERPROFILES_BIRTHDAYTITLE_DESCRIPTION',		'Uk�e, kdy maj� u�ivatel� narozeniny.');
@define('PLUGIN_USERPROFILES_BIRTHDAYTITLE_DEFAULT',		'narozeniny');

@define('PLUGIN_USERPROFILES_BIRTHDAYIN',		'Narozeniny za %d dn�');
@define('PLUGIN_USERPROFILES_BIRTHDAYTODAY',		'Dnes slav� narozeniny.');

@define('PLUGIN_USERPROFILES_BIRTHDAYNUMBERS',		'Omez p�i zobrazen� po�et lid�, kte�� maj� narozeniny, na toto ��slo');
@define('PLUGIN_USERPROFILES_SHOWAUTHORS',		'Zobrazovat seznam u�ivatel�?');
@define('PLUGIN_USERPROFILES_SHOWGROUPS',		'Zobrazovat odkaz na podrobnosti o skupin�ch?');

