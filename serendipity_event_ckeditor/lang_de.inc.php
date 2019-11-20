<?php

/**
 *  @file lang_de.inc.php 1.4.22 2017-11-23 Ian
 *  @version 1.4.22
 *  @author Translator Name <yourmail@example.com>
 *  DE-Revision: Revision of lang_de.inc.php
 */

@define('PLUGIN_EVENT_CKEDITOR_NAME', 'CKEditor Plus');
@define('PLUGIN_EVENT_CKEDITOR_DESC', 'Nutzt CKEditor als Standard WYSIWYG Editor. Benutzung f�r JS-Editoren: Empfohlen! Nach der Installation, lesen Sie die Plugin Konfigurations Seite f�r mehr Informationen.');
@define('PLUGIN_EVENT_CKEDITOR_REVISION_TITLE', '<h3>Das Plugin enth�lt:</h3>');
@define('PLUGIN_EVENT_CKEDITOR_INSTALL', '<h2>Installation</h2>
<p class="msg_notice">
    <span class="icon-attention" aria-hidden="true"></span> <strong>Abh�ngigkeiten:</strong> Deaktivieren Sie das "body", "extended" und "nugget" parsing global im <strong>NL2BR</strong> Plugin, <strong>oder</strong> per entry �ber das entryproperties event plugin <strong>und/oder</strong> f�r statische Seiten �ber die Entry "Textformatierungs" Option!<br><strong>Seit Serendipity</strong> 2.0 kann entryproperties den CKEditor diesbez�glich aber automatisch erkennen.
</p>
<ol style="line-height: 1.6">
    <li>Um anderen Plugins Zugriff auf das Plugin oder dessen Hook zu gew�hren, platzieren Sie das (CKEditor) Plugin nahe dem Ende der Pluginliste.</li>
    <li>Versichern Sie sich, dass der WYSIWYG Modus in den "Eigenen Einstellungen" eingeschaltet ist.</li>
</ol>
<div class="cke_config_block msg_dialogue">
    <h3>Manuelle Erweiterungen mit anderen CKEDITOR Plugins</h3>
    <ol style="line-height: 1.6">
        <li>Definieren Sie manuell hinzugef�gte Plugins (analog zu <em>{ name: \'mediaembed\' },</em>) in der custom cke_config.js, in der <em>CKEDITOR.config.toolbarGroups = [...]</em> Definition.</li>
        <li>Au�erdem f�gen Sie den neuen Pluginnamen (analog zu mediaembed) der <em>var extraPluginList = \'...\'</em> Definition in der cke_plugin.js Datei hinzu.</li>
    </ol>

    <h3>Upgrading</h3>
    <p>Dieses Plugin wird zeitnah selber Updates via Spartacus bereitstellen.</p>
    <p><strong>Achtung</strong>: Bitte nutzen Sie <strong>nicht</strong> den automatisierten Spartacus Updater "Update All" Button f�r alle Plugins, sofern in ihrer S9y Version schon vorhanden, sondern f�hren Sie das Upgrade des CKEditors einzeln durch, um f�r die internen ZIP-Installer Operationen in diese Konfiguration weitergeleitet zu werden. Ansonsten m�ssen Sie nach jedem CKEditor (library) Upgrade selber die "Entpacke Zip Datei (im Notfall)" Option ausf�hren.</p>
    <p>Es ist generell abzuraten, ein eigenes "customized" CKEDITOR release zu erstellen und herunterzuladen, da dies zu unerw�nschten Nebenwirkungen in der Einbindung f�hrt.</p>
</div>');
@define('PLUGIN_EVENT_CKEDITOR_CONFIG', '');
@define('PLUGIN_EVENT_CKEDITOR_INSTALL_PLUGPATH', 'HTTP Pfad des S9y Plugins Verzeichnisses');
@define('PLUGIN_EVENT_CKEDITOR_CKEACF_OPTION', 'Stelle Advanced-Content-Filter (ACF) ab?');
@define('PLUGIN_EVENT_CKEDITOR_TOOLBAR_OPTION', 'Nutze den (CKE-default) toolbar-group Umbruch?');

@define('PLUGIN_EVENT_CKEDITOR_CODEBUTTON_OPTION', 'Nutze "codesnippet" Toolbar-Button?');
@define('PLUGIN_EVENT_CKEDITOR_PRETTIFY_OPTION', 'Nutze zus�tzliches code prettify css/js im Frontend?');
@define('PLUGIN_EVENT_CKEDITOR_PRETTIFY_OPTION_DESC', 'Nur f�r Upgrader! R�ckw�rtskompatibilit�t f�r sehr alte Blog Eintr�ge mit Code-Bl�cken.');
@define('PLUGIN_EVENT_CKEDITOR_OPTION_DESC', 'Normalerweise: ');

@define('PLUGIN_EVENT_CKEDITOR_FORCEINSTALL_OPTION', 'Entpacke Zip Datei (im Notfall)');
@define('PLUGIN_EVENT_CKEDITOR_FORCEINSTALL_OPTION_DESC', 'Nur bei Upgrade Fehlern: Entpacke augenblicklich das mitgelieferte ');

@define('PLUGIN_EVENT_CKEDITOR_CKEACF_OPTION_DESC', 'Dieser CKEDITOR "Housekeeper" Filter erlaubt nur bestimmtes Markup. Normalerweise ist dies gut und sollte als Einstellung erhalten bleiben, da es bereits eingebaute Workarounds f�r auff�lliges Markup, zB. "iframe" Video-Media via den "Embed Media"-Knopf, oder "audio" und "andere Serendipity" tags via "Quellcode"-Anzeige, gibt. Bitte lesen Sie dazu auch: "http://docs.ckeditor.com/?_escaped_fragment_=/guide/dev_advanced_content_filter#!/guide/dev_advanced_content_filter".');

@define('PLUGIN_EVENT_CKEDITOR_SETTOOLBAR_OPTION', 'W�hle voreingestellte Toolbars');

@define('PLUGIN_EVENT_CKEDITOR_CKEIBN_OPTION', 'Stelle den (CKE)-Bild Toolbar-Button ab?');
@define('PLUGIN_EVENT_CKEDITOR_CKEIBN_OPTION_DESC', 'Dieser CKE eigene Toolbar-Button folgt seinen eigenen Regeln f�r Stylings und Markup! Wir empfehlen daher nur den Serendipity "Medien Datenbankbank" Button zu nutzen, da dieser spezialisiert auf die N�te dieses Blogsystem eingeht. Erlaube mit "Nein" und nutze auf eigenes Risiko.');

@define('PLUGIN_EVENT_CKEDITOR_SCAYTLANG_OPTION', 'Setze Sprache der Scayt Rechtschreibpr�fung');

@define('PLUGIN_EVENT_CKEDITOR_OEMBED_OPTION', 'Nutze "oEmbed" Toolbar-Button?');
@define('PLUGIN_EVENT_CKEDITOR_OEMBED_OPTION_DESC', 'Das "oEmbed"-Button-Widget erm�glicht es, alle Arten von Ressourcen (Videos, Bilder, Tweets, etc.) einzubetten, die von anderen Diensten (sogenannte "Content Provider" in der Editor-Konfiguration) gehostet werden.
Zu unserem eigenen Bedauern muss "oEmbed" daf�r einen externen "Proxy"-Dienst verwenden, um richtig arbeiten zu k�nnen und �berhaupt sinnvoll zu sein.
Die standardm��ige CKEditor-Konfiguration verwendet einen anonymisierten Endpunkt, der von Iframely bereitgestellt wird, jedoch manche Features, wie zB. Google Maps, ohne API key nicht einbetten kann.
Dieser "//ckeditor.iframe.ly/api/oembed?url={url}&callback={callback}" Endpunkt wird hier verwendet und ist in der Konfiguration gesetzt. Es gibt aber zahlreiche andere, siehe "http://oembed.com/#section7.1".
Es wird in der CKEditor Dokumentation empfohlen, ein eigenes Konto f�r eine bessere Kontrolle der eingebetteten Inhalte bei "https://iframely.com/" einzurichten, oder einen eigenen privaten Host aufzusetzen, siehe "http://docs.ckeditor.com/#!/guide/dev_media_embed-section-embedding-media-demo".
Wenn Sie das alles nicht wirklich ben�tigen, sollten Sie sich an das vorhandene einfache Mediaembed Button-Widget halten und diese Option hier auf "Nein" gestellt lassen.');
@define('PLUGIN_EVENT_CKEDITOR_OEMBEDTYPE_OPTION', 'Typ des "oEmbed" Buttons');
@define('PLUGIN_EVENT_CKEDITOR_OEMBEDTYPE_OPTION_DESC', 'Der Unterschied zwischen "Media Embed" und "Semantic Media Embed" besteht darin, dass das Erste das gesamte HTML enth�lt, das ben�tigt wird, um die Ressource in den Daten anzuzeigen, w�hrend das Letztere nur einen <oembed> Tag mit der URL der Ressource enth�lt.
Dieser Unterschied macht das Media Embed Plugin perfekt f�r Systeme, bei denen die Funktion des Eingebundenen ohne Weiteres funktionieren soll.
Das Semantic Media Embed Plugin eignet sich f�r Rich Content Managment Systeme, die nur reine, semantische Inhalte f�r die Weiterverarbeitung speichern.
Zum Beispiel bei unterschiedlichen Styles f�r verschiedene Browser Screen- oder Drucktypen. Auch ist es viel k�rzer und �bersichtlicher und weniger anf�llig f�r automatische Korrekturen des Editors. Es zeigt den eingebetteten Inhalt im Editor w�hrend der ersten include Session, ben�tigt aber einen Ausgabe-Filter zur Konvertierung. Dies gilt f�r das Frontend, wie auch wiederholte Eintrags-Bearbeitungs-Sessions im Backend, damit es �berhaupt funktionieren kann.
W�hlen und testen Sie also selbst.');
@define('PLUGIN_EVENT_CKEDITOR_OEMBEDTYPE_SEMANTIC_OPTION', 'Semantic Media Embed');
@define('PLUGIN_EVENT_CKEDITOR_OEMBEDTYPE_MARKUP_OPTION', 'Media Embed');

@define('PLUGIN_EVENT_CKEDITOR_OPHANDLER', '<b>Achtung:</b> Nach jedem Upgrade und durch interne Optimierungen der Plugin Ausgaben betreffend Javascript Konstanten im Backend Kontext, m�ssen sie nach �nderungen in obiger Plugin-Konfiguration Ihren Browser, <em>auf einer Seite eines WYSIWYG-Editor &lt;textarea&gt; Formulares</em>, <b>einmal</b> manuell anweisen den Browser Cache <u><b>neu</b> zu laden</u> (zB. durch <b>F5</b>), sonst wird ihre �nderung durch den Browsercache der serendipity_admin.js Datei m�glicherweise erst nach bis zu einer Stunde aktiv.');

@define('PLUGIN_EVENT_CKEDITOR_INSTALLER_DEFLATEDONE', '<strong>Notfall-Zip-Extraktion ausgef�hrt:</strong> Bitte laden Sie diese Seite neu <a href="%s" target="_self">hier</a>!');
@define('PLUGIN_EVENT_CKEDITOR_INSTALLER_MSG4', '<strong>Meldung der Plugin-Update �berpr�fung:</strong> NO CONFIG SET oder NO MATCH -> config_set: "last_%s_version:%s"');
@define('PLUGIN_EVENT_CKEDITOR_INSTALLER_MSG3', '<strong>Installer Update Meldung:</strong> Zip-Upgrade �berpr�fung meldet false; keine Extraktion n�tig. Das Plugin Update wurde erfolgreich durchgef�hrt <strong>oder</strong> durch ein anderes Spartacus Plugin Update angestossen!');
@define('PLUGIN_EVENT_CKEDITOR_INSTALLER_MSG2', '<strong>Installer Upgrade Meldung:</strong> Extraktion der Zip-Datei in das %s Verzeichnis abgeschlossen!');
@define('PLUGIN_EVENT_CKEDITOR_INSTALLER_MSG1', '<strong>Installer Fehler[1]:</strong> Das Extrahieren der Zip-Datei in das %s Verzeichnis ist fehlgeschlagen!<br>Bitte extrahieren Sie die Datei %s von Hand.');
@define('PLUGIN_EVENT_CKEDITOR_INSTALLER_MSG0', '<strong>Installer Fehler[0]:</strong> Aufgrund eines Schreibberechtigungsfehlers ist das Extrahieren der Zip-Datei in das Verzeichnis %s fehlgeschlagen!<br>�berpr�fen Sie die "/plugins" und "/plugins/serendipity_event_ckeditor" Verzeichnisse/Dateien auf fehlende Schreibberechtigungen, oder extrahieren Sie %s von Hand, oder versuchen es anschlie�end hier erneut, oder <u>deinstallieren(!)</u> Sie dieses Plugin von ihrer Pluginliste, um es daraufhin neu zu installieren.');

