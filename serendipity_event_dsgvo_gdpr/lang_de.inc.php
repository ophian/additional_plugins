<?php

@define('PLUGIN_EVENT_DSGVO_GDPR_NAME', 'DSGVO / GDPR: Datenschutz-Grundverordnung');
@define('PLUGIN_EVENT_DSGVO_GDPR_DESC', 'Dieses Plugin soll Blog-Besitzern helfen, die �bereinstimmung mit dem Allgemeinen Datenschutzgesetz zu gew�hrleisten.');
@define('PLUGIN_EVENT_DSGVO_GDPR_MENU', 'GDPR-Erkl�rung');
@define('PLUGIN_EVENT_DSGVO_GDPR_STATEMENT', 'Ihre Datenschutzerkl�rung / Impressum');
@define('PLUGIN_EVENT_DSGVO_GDPR_STATEMENT_DESC', 'Sie k�nnen die obige automatische �berpr�fung als groben Entwurf einer Information verwenden, die Sie in Ihre Datenschutzerkl�rung aufnehmen sollten. Stellen Sie sicher, dass Ihre Datenschutzerkl�rung alle relevanten Informationen enth�lt. Wenden Sie sich an einen Anwalt, wenn Sie dabei Hilfe ben�tigen, wir k�nnen Ihnen aus Haftungsgr�nden leider keinen vollst�ndigen Entwurf zur Verf�gung stellen.');
@define('PLUGIN_EVENT_DSGVO_GDPR_URL', 'Optionale URL zur Datenschutzerkl�rung');
@define('PLUGIN_EVENT_DSGVO_GDPR_URL_DESC', 'Standardm��ig wird ein interner Link erstellt, der den Text Ihrer Datenschutzerkl�rung mit dem hier eingegebenen Text anzeigt. Wenn Sie jedoch eine bestimmte URL (oder eine statische Seiten-URL) haben, mit der Sie Ihre Besucher verlinken m�chten, k�nnen Sie diese hier eingeben. Dann wird der Text der Datenschutzerkl�rung nicht angezeigt und muss nicht eingegeben werden.');
@define('PLUGIN_EVENT_DSGVO_GDPR_COMMENTFORM_CHECKBOX', 'Kommentare zur Annahme erforderlich?');
@define('PLUGIN_EVENT_DSGVO_GDPR_COMMENTFORM_CHECKBOX_DESC', 'Wenn aktiviert, m�ssen Besucher eine zus�tzliche Checkbox f�r Blog-Kommentare aktivieren, um Ihre Datenschutzerkl�rung zu best�tigen.');

@define('PLUGIN_EVENT_DSGVO_GDPR_COMMENTFORM_TEXT', 'Text f�r Kommentarzustimmung');
@define('PLUGIN_EVENT_DSGVO_GDPR_COMMENTFORM_TEXT_DESC', 'Geben Sie hier den Text ein, der dem Benutzer zur Annahme Ihrer Aufgabenstellung angezeigt wird. Verwenden Sie %gdpr_url% als Platzhalter f�r die URL.');
@define('PLUGIN_EVENT_DSGVO_GDPR_COMMENTFORM_TEXT_DEFAULT', 'Ich bin damit einverstanden, dass meine Daten gespeichert werden. Bitte lesen Sie die <a href="%gdpr_url%" target="_blank">Nutzungsbedingungen / Impressum</a> f�r weitere Details.');
@define('PLUGIN_EVENT_DSGVO_GDPR_INFO', 'Informationen zur GDPR-Relevanz Ihres Blogs');
@define('PLUGIN_EVENT_DSGVO_GDPR_INFO_DESC', 'Serendipity erlaubt es Plugins zu spezifizieren, welche Auswirkungen sie auf die Nutzung und Handhabung sensibler Daten in Ihrem Blog haben. An dieser Stelle werden diese Daten automatisch ausgewertet und zu Ihrer Information an dieser Stelle ausgegeben. Bitte stellen Sie sicher, dass Sie immer die neuesten Versionen ihrer Plugins verwenden. Sie sind selbst daf�r verantwortlich, die von Ihnen genutzten Dienste dem Besucher zur Verf�gung zu stellen. Wenn Sie Funktionen au�erhalb vom Serendipity Kern und seinen Plugins (inkl. Spartacus) verwenden (benutzerdefinierte Plugins, benutzerdefinierte Vorlagen, Snippets), die relevant sind, sollten Sie diese in Ihre Datenschutzerkl�rung aufnehmen!');

@define('PLUGIN_EVENT_DSGVO_GDPR_ANONYMIZE', 'Anonymisiere IPs?');
@define('PLUGIN_EVENT_DSGVO_GDPR_ANONYMIZE_DESC', 'Wenn aktiviert, werden die letzten Teile der IP-Adresse (ipv4 und ipv6) durch "0" ersetzt. Dies bedeutet, dass �berall dort, wo serendipity die IP-Adresse des Besuchers speichert oder nutzt (auch f�r Anti-Spam-Methoden), die aufgezeichnete IP-Adresse nicht die tats�chliche IP-Adresse des Nutzers ist. Im Falle eines missbr�uchlichen Zugriffs k�nnen Sie die tats�chliche IP, dann beispielsweise f�r einen Kommentar, nicht mehr erkennen.');

@define('PLUGIN_EVENT_DSGVO_GDPR_SHOW_IN_FOOTER', 'Link zur Erkl�rung in der Fu�zeile anzeigen?');
@define('PLUGIN_EVENT_DSGVO_GDPR_SHOW_IN_FOOTER_DESC', 'Wenn aktiviert, wird ein Link zu Ihrer Datenschutzerkl�rung in die Fu�zeile Ihres Blogs eingef�gt. Sie k�nnen den angezeigten Text anpassen. Der Platzhalter %gdpr_url% kann f�r diesen Link verwendet werden.');
@define('PLUGIN_EVENT_DSGVO_GDPR_SHOW_IN_FOOTER_TEXT', 'Datenschutzerkl�rung Linktext');
@define('PLUGIN_EVENT_DSGVO_GDPR_SHOW_IN_FOOTER_TEXT_DESC', 'Wenn der Link zur Datenschutzerkl�rung aktiviert ist, geben Sie den Text ein, den Sie dort anzeigen m�chten');
@define('PLUGIN_EVENT_DSGVO_GDPR_SHOW_IN_FOOTER_TEXT_DEFAULT', '<a href="%gdpr_url%">Datenschutzerkl�rung / Impressum</a>');

@define('PLUGIN_EVENT_DSGVO_GDPR_COOKIE_MENU', 'CookieConsent');
@define('PLUGIN_EVENT_DSGVO_GDPR_COOKIE_CONSENT','CookieConsent durch Insites aktivieren?');
@define('PLUGIN_EVENT_DSGVO_GDPR_COOKIE_CONSENT_DESC', 'Wenn aktiviert, wird ein Cookie-Banner in Ihrem Blog angezeigt. Dabei wird die CookieConsent Javascript-Bibliothek verwendet. Es unterst�tzt nur den Typ der Cookie-Informationen. Sie k�nnen den Generator auf <a href="https://cookieconsent.insites.com/download/">https://cookieconsent.insites.com/download/</a> verwenden, um den eigentlichen Code zu erstellen; stellen Sie sicher, dass Sie NUR den Hauptskript-Teil hier einf�gen und NICHT den Link zum CSS und JavaScript, um sicherzustellen, dass kein Code von fremden Servern geladen wird, sondern nur von Ihrem.');
@define('PLUGIN_EVENT_DSGVO_GDPR_COOKIE_CONSENT_TEXT', 'CookieConsent Code');
@define('PLUGIN_EVENT_DSGVO_GDPR_COOKIE_CONSENT_TEXT_DESC', 'Dieses Javascript ist einfach zu lesen, hier k�nnen Sie alle Farben und Texte anpassen. Sie k�nnen %gdpr_url% als Platzhalter f�r den Link zu Ihrer Datenschutzerkl�rung verwenden.');
@define('PLUGIN_EVENT_DSGVO_GDPR_COOKIE_CONSENT_TEXT_DEFAULT', '
<script>
window.addEventListener("load", function(){
window.cookieconsent.initialise({
  "palette": {
    "popup": {
      "background": "#FFFFFF",
      "text": "#000000"
    },
    "button": {
      "background": "#FFFFFF",
      "text": "#0c5e0a",
      "border": "#000000"
    }
  },
  "content": {
    "message": "Diese Website verwendet Cookies.",
    "dismiss": "Ich akzeptiere",
    "link": "Lesen Sie mehr in der Datenschutzerkl�rung",
    "href": "%gdpr_url%"
  }
})});
</script>
');

@define('PLUGIN_EVENT_DSGVO_GDPR_COOKIE_CONSENT_PATH', 'CookieConsent javascript location');
@define('PLUGIN_EVENT_DSGVO_GDPR_COOKIE_CONSENT_PATH_DESC', 'Dieses Plugin b�ndelt die JS und CSS der Cookie-Einwilligungsseite. Sie k�nnen hier auf andere Verzeichnisse verweisen. Stellen Sie sicher, dass die Dateien cookieconsent.min.css und cookieconsent.min.js hei�en.');
@define('PLUGIN_EVENT_DSGVO_GDPR_COMMENTFORM_ERROR', 'Sie m�ssen die Bedingungen akzeptieren, um einen Kommentar zu hinterlassen.');
@define('PLUGIN_EVENT_DSGVO_GDPR_STATEMENT_ERROR', 'Dieses Blog hat noch keine Datenschutzerkl�rung erstellt, es muss in der Plugin-Konfiguration konfiguriert werden.');

@define('PLUGIN_EVENT_DSGVO_GDPR_SERENDIPITY_CORE', '

<h4>Serendipity Kern</h4>

<p>Serendipity verwendet ein sogenanntes "Session-Cookie" f�r Frontend und Backend. Ein Besucher erh�lt ein Cookie mit dem folgenden Inhalt
eine eindeutige ID, die auf dem Server verwendet wird, um tempor�re Session-Benutzerdaten zu speichern (z.B. Login-G�ltigkeit, Benutzereinstellungen).
Dieses Cookie ist obligatorisch f�r die Anmeldung am Backend, aber optional f�r das Frontend.
Bestimmte Plugins k�nnen das Session-Cookie verwenden, um zus�tzliche tempor�re Daten zu speichern.</p>

<p>Die folgenden Daten k�nnen von der Serendipity-Anwendung auf dem Server gespeichert werden (tempor�r, ung�ltig nach dem vom Server konfigurierten Timeout, normalerweise im Zeitbereich von Stunden):</p>

<ul>
    <li>HTTP-Browser-Referrer bei der Eingabe des Blogs</li>
    <li>Einzigartiges Autoren-ID-Token</li>
    <li>Benutzerdaten eines angemeldeten Autors, wie sie in der Datenbank gespeichert sind, f�r einen schnelleren Zugriff auf:
        <ul>
            <li>Passwort</li>
            <li>ID des Benutzers</li>
            <li>Konfigurierte Sprache des Benutzers</li>
            <li>Benutzername</li>
            <li>E-Mail</li>
            <li>Login Hashtyp</li>
            <li>Systemrechte des Publiziernden</li>
        </ul>
    </li>
    <li>Letzter Blogeintrag beim Speichern</li>
    <li>Indikator, wenn Smarty Templating verwendet wird</li>
    <li>M�glicher Inhalt eines generierten Captcha-Bildes</li>
    <li>Das konfigurierte Frontend-Theme</li>
</ul>

<p>Die folgenden Daten werden in Cookies gespeichert:</p>

<ul>
    <li>PHP Sitzungs ID</li>
    <li>Zustand des Eintragseditors: Umschaltungszustand, Sortierung, Sortierungs- und Filterzustand, zuletzt benutztes Verzeichnis der Mediendatenbank (nur wenn eingeloggt)</li>
    <li>Author Login Token (nur wenn angemeldet)</li>
    <li>Anzeigesprache</li>
    <li>Nach dem Kommentar: Nachname, E-Mail, URL, Status von "Kommentare merken" (falls aktiviert)</li>
</ul>

<p>Die IP-Adressen der Benutzer werden an diesen Stellen verwendet:</p>

<ul>
    <li>Speichert in der Datenbank, wenn das Referrer-Tracking aktiviert ist (Statistik)</li>
    <li>Speichert f�r Kommentare eines Besuchers und wird in der E-Mail, die an Moderatoren gesendet wird, angezeigt</li>
    <li>Speichert in der Logdatei (falls aktiviert) des Antispam-Spamblock-Plugins</li>
    <li>�bermittelt im Antispam-Filter von Akismet (falls aktiviert)</li>
    <li>Tempor�rer Nur-Lesezugriff zur �berpr�fung von Referrern, Logins, IP-Flooding</li>
</ul>

<p>Benutzereingaben von Besuchern (nicht von Redakteuren):</p>

<ul>
    <li>Kommentare (alle Kommentar-Metadaten, gespeichert in der Datenbanktabelle serendipity_comments)</li>
    <li>Referring URL beim Betreten des Blogs (wenn das Referrer-Tracking aktiviert ist, in der Datenbanktabelle serendipity_referers)</li>
</ul>

<p>Zus�tzlich sind derzeit die folgenden Plugins aktiviert und dies ist ihr automatisch generiertes Manifest:</p>.

');

@define('PLUGIN_EVENT_DSGVO_GDPR_PLUGINS_SERVICES_HEAD', 'Webservices / Dritte');
@define('PLUGIN_EVENT_DSGVO_GDPR_PLUGINS_SESSIONDATA_HEAD', 'Sitzungsdaten');
@define('PLUGIN_EVENT_DSGVO_GDPR_PLUGINS_ATTR_HEAD', 'Eigenschaften');
@define('PLUGIN_EVENT_DSGVO_GDPR_PLUGINS_ATTR_STORAGE_USER_YES', 'Speichert Benutzerdaten');
@define('PLUGIN_EVENT_DSGVO_GDPR_PLUGINS_ATTR_STORAGE_USER_NO', 'Keine Speicherung von Benutzerdaten (oder nicht angegeben)');
@define('PLUGIN_EVENT_DSGVO_GDPR_PLUGINS_ATTR_STORAGE_IP_YES', 'Speichert IP-Daten');
@define('PLUGIN_EVENT_DSGVO_GDPR_PLUGINS_ATTR_STORAGE_IP_NO', 'Speichert keine IP-Daten (oder nicht spezifiziert)');
@define('PLUGIN_EVENT_DSGVO_GDPR_PLUGINS_ATTR_USES_IP_YES', 'Arbeitet mit IP-Daten');
@define('PLUGIN_EVENT_DSGVO_GDPR_PLUGINS_ATTR_USES_IP_NO', 'Verwendet keine IP-Daten (oder nicht spezifiziert)');
@define('PLUGIN_EVENT_DSGVO_GDPR_PLUGINS_ATTR_TRANSMITS_YES', '�bertr�gt Benutzereingaben an Dienste / Dritte');
@define('PLUGIN_EVENT_DSGVO_GDPR_PLUGINS_ATTR_TRANSMITS_NO', '�bermittelt keine Benutzereingaben an Dienste / Dritte (oder nicht spezifiziert)');

