<?php

/**
 *  @file lang_de.inc.php 1.4.17 2016-08-15 Ian
 *  @version 1.4.17
 *  @author Translator Name <yourmail@example.com>
 *  DE-Revision: Revision of lang_de.inc.php
 */

@define('PLUGIN_EVENT_CKEDITOR_NAME', 'CKEditor Plus');
@define('PLUGIN_EVENT_CKEDITOR_DESC', 'Nutzt CKEditor als Standard WYSIWYG Editor. Benutzung f�r JS-Editoren: Empfohlen! Nach der Installation, lies die Plugin Konfigurations Seite f�r weitere Informationen.');
@define('PLUGIN_EVENT_CKEDITOR_REVISION_TITLE', '<h3>Das Plugin enth�lt:</h3>');
@define('PLUGIN_EVENT_CKEDITOR_INSTALL', '<h2>Installation</h2>
<p class="msg_notice">
    <span class="icon-attention"></span> <strong>Abh�ngigkeiten:</strong> Deaktiviere body, extended und nugget global im <strong>NL2BR</strong> Plugin, <strong>oder</strong> per entry �ber das entryproperties event plugin <strong>und/oder</strong> f�r statische Seiten �ber die Entry "Textformatierungs" Option! Seit Serendipity 2.0-rc1 sollte entryproperties den CKEditor diesbez�glich automatisch erkennen.
</p>
<ol style="line-height: 1.6">
    <li>Um anderen Plugins Zugriff auf das Plugin oder dessen Hook zu gew�hren, plaziere das (CKEditor) Plugin nahe dem Ende deiner Pluginliste.</li>
    <li>Versichere dich, dass der WYSIWYG Modus in den "Eigenen Einstellungen" eingeschaltet ist.</li>
</ol>
<div class="cke_config_block msg_dialogue">
    <h3>Manuelle Erweiterungen mit anderen CKEDITOR Plugins</h3>
    <ol style="line-height: 1.6">
        <li>Definiere manuell hinzugef�gte Plugins (analog zu <em>{ name: \'mediaembed\' },</em>) in der custom cke_config.js, in der <em>CKEDITOR.config.toolbarGroups = [...]</em> Definition.</li>
        <li>Au�erdem f�ge den neuen Pluginnamen (analog zu mediaembed) der <em>var extraPluginList = \'...\'</em> Definition in der cke_plugin.js Datei hinzu.</li>
    </ol>

    <h3>Upgrading</h3>
    <p>Dieses Plugin wird zeitnah selber Updates via Spartacus bereitstellen.</p>
    <p><strong>Achtung</strong>: Bitte nutzen Sie nicht den automatisierten Spartacus Updater Button f�r alle Plugins, sofern in ihrer S9y Version schon vorhanden, sondern f�hren Sie das Upgrade des CKEditors einzeln durch, um f�r die internen ZIP-Installer Operationen in diese Konfiguration weiter geleitet zu werden. Ansonsten m�ssen Sie nach jedem CKEditor Upgrade selber die "Entpacke Zip Datei (im Notfall)" Option ausf�hren.</p>
    <p>Es ist generell abzuraten, ein eigenes "customized" CKEDITOR release zu erstellen und herunterzuladen, da dies zu unerw�nschten Nebenwirkungen in der Einbindung f�hrt.</p>
</div>');
@define('PLUGIN_EVENT_CKEDITOR_CONFIG', '');
@define('PLUGIN_EVENT_CKEDITOR_INSTALL_PLUGPATH', 'HTTP Pfad des S9y Plugins Verzeichnisses');
@define('PLUGIN_EVENT_CKEDITOR_CKEACF_OPTION', 'Stelle Advanced-Content-Filter (ACF) ab?');
@define('PLUGIN_EVENT_CKEDITOR_TOOLBAR_OPTION', 'Nutze den (CKE-default) toolbar-group Umbruch?');

@define('PLUGIN_EVENT_CKEDITOR_CODEBUTTON_OPTION', 'Nutze "code toolbar button"?');
@define('PLUGIN_EVENT_CKEDITOR_PRETTIFY_OPTION', 'Nutze zus�tzliches code prettify css/js im Frontend?');
@define('PLUGIN_EVENT_CKEDITOR_PRETTIFY_OPTION_DESC', 'Nur f�r Upgrader! R�ckw�rtskompatibilit�t f�r alte Blog Eintr�ge mit Code-Bl�cken.');
@define('PLUGIN_EVENT_CKEDITOR_OPTION_DESC', 'Normalerweise: ');

@define('PLUGIN_EVENT_CKEDITOR_FORCEINSTALL_OPTION', 'Entpacke Zip Datei (im Notfall)');
@define('PLUGIN_EVENT_CKEDITOR_FORCEINSTALL_OPTION_DESC', 'Nur bei upgrade Fehlern: Entpacke augenblicklich das mitgelieferte ');

@define('PLUGIN_EVENT_CKEDITOR_CKEACF_OPTION_DESC', 'Dieser CKEDITOR "Housekeeper" Filter erlaubt nur bestimmtes Markup. Normalerweise ist dies gut und sollte als Einstellung erhalten bleiben, da es bereits eingebaute Workarounds f�r auff�lliges Markup, zB. "iframe" Video-Media via den "Embed Media"-Knopf, oder "audio" und "andere Serendipity" tags via "Quellcode"-Anzeige, gibt. Bitte lese dazu auch: "http://docs.ckeditor.com/?_escaped_fragment_=/guide/dev_advanced_content_filter#!/guide/dev_advanced_content_filter".');

@define('PLUGIN_EVENT_CKEDITOR_SETTOOLBAR_OPTION', 'W�hle voreingestellte Toolbars');

@define('PLUGIN_EVENT_CKEDITOR_CKEIBN_OPTION', 'Stelle den eingebauen Bildbutton ab?');
@define('PLUGIN_EVENT_CKEDITOR_CKEIBN_OPTION_DESC', 'Dieser CKE eigene Toolbar Button folgt seinen eigenen Regeln f�r Stylings und Markup! Wir empfehlen daher nur den Serendipity Medien Datenbank Button zu nutzen, da dieser spezialisiert auf die N�te dieses Blogsystem eingeht. Erlaube mit "Nein" und nutze auf eigenes Risiko.');

