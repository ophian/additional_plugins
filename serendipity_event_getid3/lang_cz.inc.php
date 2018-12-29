<?php

/**
 *  @author Vladim�r Ajgl <vlada@ajgl.cz>
 *  @translated 2009/06/05
 *  @author Vladim�r Ajgl <vlada@ajgl.cz>
 *  @revisionDate 2011/10/16
 */

@define('PLUGIN_GETID3', 'getID3() podpora pro z�sk�n� vlastnost� m�dia');
@define('PLUGIN_GETID3_DESC', 'Pou��v� knihovnu getID3() k z�sk�n� dopl�uj�c�ch informac� o audio/video souborech. getID3() samotn� nen� distribuov�na s t�mto pluginem.');
@define('PLUGIN_GETID3_INSTALL', 'Knihovna getID3() nen� z licen�n�ch d�vod� distribuov�na s t�mto pluginem, mus�te si ji ru�n� st�hnout z http://getid3.org/. Rozbalte soubory do adres��e serendipity_event_getid3 nebo (a to je lep�� volba) do adres��e bundled-libs.');

@define('PLUGIN_GETID3_INSTALL_DESC', 
'<h3>Instalace</h3>' .
'<p>Knihovna getID3() sama o sob� nen� distribuov�na s t�mto pluginem. Mus�te ji ru�n� st�hnout z ' .
'<a href="http://getid3.org/" target="_blank">getid3.org</a>. <b>Podporov�na je pouze verze knihovny 1.x!</b></p>' .
'<p>Ve sta�en�m archivu najdete podadres�� getid3. Zkop�rujte pros�m obsah tohoto adres��e do adres��e Serendipity "bundled-libs".</p>');

@define('PLUGIN_GETID3_LIBNOTFOUND',    'Knihovna getID3 nebyla nalezena ani v adres��i bundled-libs, ani v adres��i pluginu!'); 
@define('PLUGIN_GETID3_LIBFOUNDBUNDLED','Knihovna getID3 byla nalezena v adres��i bundled-libs.'); 
@define('PLUGIN_GETID3_LIBFOUNDPLUGIN', 'Knihovna getID3 nalezena v adres��i pluginu.');