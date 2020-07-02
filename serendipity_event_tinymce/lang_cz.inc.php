<?php

/**
 *  @author Vladim�r Ajgl <vlada@ajgl.cz>
 *  @translated 2009/06/26
 */

@define('PLUGIN_EVENT_TINYMCE_NAME',            'TinyMCE jako WYSIWYG editor');
@define('PLUGIN_EVENT_TINYMCE_DESC',            'Pou�ije TiniMCE WYSIWYG editor pro psan� p��sp�vk�. Vy�aduje Serendipity 1.6 nebo nov�j��. Po instalaci si p�e�t�te instala�n�ho pr�vodce v nastaven� tohoto pluginu.');
@define('PLUGIN_EVENT_TINYMCE_ARTICLE_ONLY',    'Pou��t pouze v p��sp�vc�ch');
@define('PLUGIN_EVENT_TINYMCE_ARTICLE_ONLY_DESC','Pokud je zapnuto, TinyMCE bude pou�ito pouze k �prav�m p��sp�vku, nebude pou�ito v ostatn�ch pluginech.');
@define('PLUGIN_EVENT_TINYMCE_IMANAGER',        'Zapnout pou�it� n�stroje iManager?');
@define('PLUGIN_EVENT_TINYMCE_IMANAGER_DESC',   'iManager je pru�n� n�stroj pro spr�vu obr�zk� (vy�aduje knihovnu GD). Pod�vejte se na http://www.j-cons.com/ a p�e�t�te si tam instala�n� p��ru�ku, s jej� pomoc� dokon�ete instalaci n�stroje.');
@define('PLUGIN_EVENT_TINYMCE_PLUGINS',         'P��davn� pluginy pro TinyMCE');
@define('PLUGIN_EVENT_TINYMCE_PLUGINS_DESC',    'Napi�te jm�na adres��� (odd�len� ��rkou). Adres��e mus� b�t v adres��i pluginu TinyMCE. Pozorn� �t�te dokumentaci ke ka�d�muu z plugin� pro TinyMCE. Seznam plugin� dod�van�ch s TinyMCE najdete na str�nce: http://wiki.moxiecode.com/index.php/TinyMCE:Plugins');
@define('PLUGIN_EVENT_TINYMCE_BUTTONS1',        'Tla��tkov� li�ta 1');
@define('PLUGIN_EVENT_TINYMCE_BUTTONS1_DESC',   'Zadejte tla��tka, kter� maj� b�t viditeln� v prvn� tla��tkov� li�t�. Mezera znamen� odd�lova� v li�t�, pokud sma�ete obsah, bude nata�ena v�choz� li�ta TinyMCE. Tla��tka, kter� lze pou��t, jsou zobrazena na http://wiki.moxiecode.com/index.php/TinyMCE:Control_reference');
@define('PLUGIN_EVENT_TINYMCE_BUTTONS2',        'Tla��tkov� li�ta 2');
@define('PLUGIN_EVENT_TINYMCE_BUTTONS2_DESC',   'Zadejte tla��tka, kter� maj� b�t viditeln� v druh� tla��tkov� li�t�.');
@define('PLUGIN_EVENT_TINYMCE_BUTTONS3',        'Tla��tkov� li�ta 3');
@define('PLUGIN_EVENT_TINYMCE_BUTTONS3_DESC',   'Zadejte tla��tka, kter� maj� b�t viditeln� v t�et� tla��tkov� li�t�.');
@define('PLUGIN_EVENT_TINYMCE_SPELLING',        'Kontrola pravopisu v Mozille');
@define('PLUGIN_EVENT_TINYMCE_SPELLING_DESC',   'TinyMCE um� vyu��vat kontrolu pravopisu ve Firefoxu.');
@define('PLUGIN_EVENT_TINYMCE_RELURLS',         'P�ev�st na relativn� URL adresy');
@define('PLUGIN_EVENT_TINYMCE_RELURLS_DESC',    'TinyMCE um� p�ev�d�t m�stn� URL adresy do relativn�ho form�tu. Tedy z adresy "http://vas.blog.cz/test.html" se stane "/test.html". Relativn� URL adresy jsou d�le�it�, pokud pl�nujete d�lat zm�ny v blogu, nebo pokud chcete k blogu p�istupovat z r�zn�ch dom�n. Na druhou stranu relativn� adresy mohou n�kde p�sobit probl�my.');
@define('PLUGIN_EVENT_TINYMCE_VFYHTML',         'Kontrolovat HTML');
@define('PLUGIN_EVENT_TINYMCE_VFYHTML_DESC',    'TinyMCE se pokou�� transformovat zadan� �l�nek na pokud mo�no validn� HTML k�d. Sma�e tagy, kter� nejsou sou��st� HTML specifikace. Nap�. k�dy z YouTube �asto podle t�to specifikace nejsou a jsou tud� smaz�ny b�hem ulo�en� �l�nku. Tato volba m��e toto chov�n� vypnout nebo zapnout.');
@define('PLUGIN_EVENT_TINYMCE_CLEANUP',         'Vy�istit k�d');
@define('PLUGIN_EVENT_TINYMCE_CLEANUP_DESC',    'TinyMCE �ist� k�d p��sp�vku p�i otev�r�n� a ukl�d�n�. Pokud tuto volbu vypnete, TinyMCE se HTML k�du ani nedotkne, ale z�stane na V�s zkontrolovat, jestli je k�d validn�. Vypnut� volby [' . PLUGIN_EVENT_TINYMCE_VFYHTML . '] je ve v�t�in� p��pad� lep�� �e�en�.');
@define('PLUGIN_EVENT_TINYMCE_HTTPREL',         'Relativn� HTTP cesta pluginu');
@define('PLUGIN_EVENT_TINYMCE_HTTPREL_DESC',    'Definuje HTTP cestu k pluginu relativn� ke ko�enu serveru. Pokud jste nezm�nili strukturu permalink� pro tento plugin a pokud V� blog neb�� na serveru v podadres��i, pak by m�lo dob�e fungovat v�choz� nastaven�.');
@define('PLUGIN_EVENT_TINYMCE_INSTALL',         '<br /><br /><strong>Instala�n� p��ru�ka:</strong><br />
<ul>
<li><a href="http://tinymce.moxiecode.com/download.php" target="_blank" rel="noopener">St�hn�te TinyMCE, TinyMCE compressor</a> (Pouze TinyMCE 2.0 nebo nov�j��).</li>
<li><b>TinyMCE</b>: Rozbalte do adres��e "tinymce" v adres��i ' . dirname(__FILE__) . '.</li>
<li>TinyMCE compressor rozbalte do adres��e "tinymce/jscripts/tiny_mce/" v adres��i ' . dirname(__FILE__) . ' (Pouze TinyMCE 2.0 nebo nov�j��).</li>
<li>M��ete st�hnout iManager, ale nen� to povin� (vy�aduje PHP knihovnu GD):
<ul>
<li>Rozbalte iManager do adres��e "tinymce/jscripts/tiny_mce/plugins/imanager"</li>
<li>Upravte konfigura�n� soubor "tinymce/jscripts/tiny_mce/plugins/imanager/config/config.inc.php"</li>
<li>Nastavte hodnoty pro $cfg["ilibs"] a $cfg["ilibs_dir"]. Zadejte n�sleduj�c� relativn� HTTP cestu k adres��i pro sta�en� soubory Serendipity: "' . $serendipity['serendipityHTTPPath'] . $serendipity['uploadHTTPPath'] . '"</li>
<li>Ujist�te se, �e adres��e imanager/scripts/phpThumb/cache a imanager/temp maj� nastaven� pr�va z�pisu (777)</li>
</ul>
</li>
<li>V nastaven� pluginu TinyMCE zadejte relativn� HTTP cestu k adres��i pluginu.</li>
<li>Ujist�te se, �e jste v Osobn�m nastaven� Serendipity povolili pou�it� WYSIWYG editoru.</li>
</ul>');

