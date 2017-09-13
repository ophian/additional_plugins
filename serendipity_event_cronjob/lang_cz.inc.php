<?php

/**
 *  @author Vladim�r Ajgl <vlada@ajgl.cz>
 *  @translated 2009/08/14
 */

@define('PLUGIN_EVENT_CRONJOB_NAME', 'Pl�nova� �loh');
@define('PLUGIN_EVENT_CRONJOB_DESC', 'Tento plugin periodicky vykon�v� pluginy, kter� poskytuj�/vy�aduj� opakovan� vykon�v�n�. Podrobnosti v konfiguraci pluginu.');
@define('PLUGIN_EVENT_CRONJOB_DETAILS', 'Tento plugin poskytuje nov� API hooky pro ostatn� pluginy (cronjob_5min, cronjob_30min, cronjob_1h, cronjob_12h, cronjob_daily, cronjob_weekly, cronjob_monthly). POZN�MKA: Vykon�n� skript� je z�visl� na Va�ich n�v�t�vn�c�ch. Pokud nikdo nenav�t�vuje Va�e str�nky, ��dn� �lohy nemohou b�t spu�t�ny. Pokud vlastn�te server s programem pro spou�t�n� �loh (jako nap��klad Cron), je lep��m �e�en�m p�idat do jeho konfigura�n� tabulky z�znam <br /><br />5 * * * wget http://vasBlog/index.php?serendipity[cronjob]=all.<br /><br />A pak m��ete zak�zat vykon�v�n� �loh na z�klad� n�v�t�v u�ivatel�.');
@define('PLUGIN_EVENT_CRONJOB_VISITOR', 'Povolit spou�t�n� �loh na z�klad� n�v�t�v u�ivatel�?');
@define('PLUGIN_EVENT_CRONJOB_VISITOR_DESC', 'Pokud je tato volba povolena, pl�novan� �lohy budou spou�t�ny n�v�t�vami blogu. K tomu bude do str�nek blogu vlo�en obr�zek o rozm�rech 0 pixel� (kter� vol� index.php?serendipity[cronjob]=true), kter� se star� o spu�t�n� �loh. Pro ty z V�s, kte�� nem�te mo�nost spou�t�t �lohy p��mo na serveru (nem�te mo�nost pou��vat Cron nebo podobn� n�stro), je to jedin� mo�nost, jak periodicky opakovat n�kter� �lohy. Pamatujte, �e takov�to spou�t�n� �loh je z�visl� na n�v�t�v�ch Va�ich str�nek, tedy �asov� prodlevy mezi jednotliv�mi spu�t�n�mi skriptu nebudou p�esn�. (Nap��klad �loze nastaven� na opakov�n� ka�dou hodinu se m��e st�t, �e nebude b�hem 3 hodin spu�t�na ani jednou, pokud b�hem t�ch t�� hodin na blog nep�ijde jedin� n�v�t�vn�k.)');
@define('PLUGIN_EVENT_CRONJOB_LOG', 'Posledn� aktivita pl�nova�e �loh');
@define('PLUGIN_EVENT_CRONJOB_CHOOSE', 'Kdy spustit?');

