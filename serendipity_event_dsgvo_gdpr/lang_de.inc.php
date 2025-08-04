<?php

@define('PLUGIN_EVENT_DSGVO_GDPR_NAME', 'DSGVO / GDPR: Datenschutz-Grundverordnung');
@define('PLUGIN_EVENT_DSGVO_GDPR_DESC', 'Dieses Plugin soll Blog-Besitzern helfen, die Übereinstimmung mit dem Allgemeinen Datenschutzgesetz zu gewährleisten.');
@define('PLUGIN_EVENT_DSGVO_GDPR_MENU', 'GDPR-Erklärung und dafür benötigte Informationen');
@define('PLUGIN_EVENT_DSGVO_GDPR_STATEMENT', 'Ihre Datenschutzerklärung / Impressum');
@define('PLUGIN_EVENT_DSGVO_GDPR_STATEMENT_DESC', 'Sie können die obige automatische Überprüfung als groben Entwurf einer Information sehen, deren Elemente Sie (soweit sie zutreffen) in Ihre Datenschutzerklärung aufnehmen sollten. Stellen Sie sicher, dass Ihre Datenschutzerklärung alle relevanten Informationen enthält. Wenden Sie sich an einen Anwalt, wenn Sie dabei Hilfe benötigen, wir können Ihnen aus Haftungsgründen leider keinen vollständigen Entwurf zur Verfügung stellen.');
@define('PLUGIN_EVENT_DSGVO_GDPR_URL', 'Optionale URL zur Datenschutzerklärung');
@define('PLUGIN_EVENT_DSGVO_GDPR_URL_DESC', 'Standardmäßig wird ein interner Link erstellt, der den Text Ihrer Datenschutzerklärung mit dem hier eingegebenen Text anzeigt (siehe textarea input form "Ihre Datenschutzerklärung / Impressum" weiter unten). Wenn Sie jedoch eine bestimmte URL (oder eine statische Seiten-URL) haben, mit der Sie Ihre Besucher verlinken möchten, können Sie diese hier eingeben. Dann wird der Text der Datenschutzerklärung nicht angezeigt und muss nicht eingegeben werden.');
@define('PLUGIN_EVENT_DSGVO_GDPR_COMMENTFORM_CHECKBOX', 'Ausdrückliche Annahme in Formularen erforderlich?');
@define('PLUGIN_EVENT_DSGVO_GDPR_COMMENTFORM_CHECKBOX_DESC', 'Wenn aktiviert, müssen Besucher eine zusätzliche Checkbox für Blog-Kommentare oder Kontaktformulare aktivieren, um Ihre Datenschutzerklärung zu bestätigen.');

@define('PLUGIN_EVENT_DSGVO_GDPR_SAVENEWLANG', 'Wurde dieses Feld bereits unter einer anderen Sprache abgespeichert, löschen Sie den Inhalt und speichern Sie erneut, um eine angepasste Sprach-Version zum Speichern zu erhalten.');
@define('PLUGIN_EVENT_DSGVO_GDPR_COMMENTFORM_TEXT', 'Text für Kommentarzustimmung');
@define('PLUGIN_EVENT_DSGVO_GDPR_COMMENTFORM_TEXT_DESC', 'Geben Sie hier den Text ein, der dem Benutzer zur Annahme Ihrer Aufgabenstellung angezeigt wird. Verwenden Sie %gdpr_url% als Platzhalter für die URL.');
@define('PLUGIN_EVENT_DSGVO_GDPR_COMMENTFORM_TEXT_DEFAULT', 'Ich bin damit einverstanden, dass meine Daten gespeichert werden. Bitte lesen Sie die <a href="%gdpr_url%" target="_blank" rel="noopener">Nutzungsbedingungen / Impressum</a> für weitere Details.');
@define('PLUGIN_EVENT_DSGVO_GDPR_INFO', 'Informationen zur GDPR-Relevanz Ihres Blogs');
@define('PLUGIN_EVENT_DSGVO_GDPR_INFO_DESC', 'Serendipity erlaubt es Plugins zu spezifizieren, welche Auswirkungen sie auf die Nutzung und Handhabung sensibler Daten in Ihrem Blog haben. An dieser Stelle werden diese Daten automatisch ausgewertet und zu Ihrer Information an dieser Stelle ausgegeben. Bitte stellen Sie sicher, dass Sie immer die neuesten Versionen ihrer Plugins verwenden. Sie sind selbst dafür verantwortlich, die von Ihnen genutzten Dienste dem Besucher zur Verfügung zu stellen. Wenn Sie Funktionen außerhalb vom Serendipity Kern und seinen Plugins (inkl. Spartacus) verwenden (benutzerdefinierte Plugins, benutzerdefinierte Vorlagen, Snippets), die relevant sind, sollten Sie diese in Ihre Datenschutzerklärung aufnehmen!');

@define('PLUGIN_EVENT_DSGVO_GDPR_ANONYMIZE', 'Anonymisiere IPs?');
@define('PLUGIN_EVENT_DSGVO_GDPR_ANONYMIZE_DESC', 'Wenn aktiviert, werden die letzten Teile der IP-Adresse (ipv4 und ipv6) durch "0" ersetzt. Dies bedeutet, dass überall dort, wo Serendipity die IP-Adresse des Besuchers speichert oder nutzt (auch für Anti-Spam-Methoden), die aufgezeichnete IP-Adresse nicht die tatsächliche IP-Adresse des Nutzers ist. Im Falle eines missbräuchlichen Zugriffs können Sie die tatsächliche IP, dann beispielsweise für einen Kommentar, nicht mehr erkennen.');

@define('PLUGIN_EVENT_DSGVO_GDPR_SHOW_IN_FOOTER', 'Link zur Erklärung in der Fußzeile anzeigen?');
@define('PLUGIN_EVENT_DSGVO_GDPR_SHOW_IN_FOOTER_DESC', 'Wenn aktiviert, wird ein Link zu Ihrer Datenschutzerklärung in die Fußzeile Ihres Blogs eingefügt. Sie können den angezeigten Text anpassen. Der Platzhalter %gdpr_url% kann für diesen Link verwendet werden.');
@define('PLUGIN_EVENT_DSGVO_GDPR_SHOW_IN_FOOTER_TEXT', 'Datenschutzerklärung Linktext');
@define('PLUGIN_EVENT_DSGVO_GDPR_SHOW_IN_FOOTER_TEXT_DESC', 'Wenn der Link zur Datenschutzerklärung aktiviert ist, geben Sie den Text ein, den Sie dort anzeigen möchten');
@define('PLUGIN_EVENT_DSGVO_GDPR_SHOW_IN_FOOTER_TEXT_DEFAULT', '<a href="%gdpr_url%">Datenschutzerklärung / Impressum</a>');

@define('PLUGIN_EVENT_DSGVO_GDPR_COOKIE_MENU', 'CookieConsent');
@define('PLUGIN_EVENT_DSGVO_GDPR_COOKIE_CONSENT','CookieConsent durch Osano aktivieren?');
@define('PLUGIN_EVENT_DSGVO_GDPR_COOKIE_CONSENT_DESC', 'Wenn aktiviert, wird ein Cookie-Banner in Ihrem Blog angezeigt. Dabei wird die CookieConsent Javascript-Bibliothek verwendet. Es unterstützt nur den Typ der Cookie-Informationen. Sie können den Generator auf <a href="https://cookieconsent.insites.com/download/">https://cookieconsent.insites.com/download/</a> verwenden, um den eigentlichen Code zu erstellen; stellen Sie sicher, dass Sie NUR den Hauptskript-Teil hier einfügen und NICHT den Link zum CSS und JavaScript, um sicherzustellen, dass kein Code von fremden Servern geladen wird, sondern nur von Ihrem.');
@define('PLUGIN_EVENT_DSGVO_GDPR_COOKIE_CONSENT_TEXT', 'CookieConsent Code');
@define('PLUGIN_EVENT_DSGVO_GDPR_COOKIE_CONSENT_TEXT_DESC', 'Dieses Javascript ist einfach zu lesen, hier können Sie alle Farben und Texte anpassen. Sie müssten ihre korrekte Domain Adresse eingeben und das Secure Attribute auf true oder false setzen, wenn ihr Blog unter einem gesicherten Zertifikat läuft. Sie können %gdpr_url% als Platzhalter für den Link zu Ihrer Datenschutzerklärung verwenden.');
@define('PLUGIN_EVENT_DSGVO_GDPR_COOKIE_CONSENT_TEXT_DEFAULT', '
<script>
    window.addEventListener("load", function(){
    const CC = window.CookieConsent;
    const cc = new CC({
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
      "cookie": {
        "domain": "IHRE.DOMAIN.DE",
        "secure": true
      },
      "content": {
        "message": "Diese Website verwendet Cookies.",
        "dismiss": "Verstanden",
        "link": "Lesen Sie mehr in der Datenschutzerklärung",
        "href": "%gdpr_url%"
      }
    })});
</script>
');

@define('PLUGIN_EVENT_DSGVO_GDPR_COOKIE_CONSENT_PATH', 'CookieConsent javascript location');
@define('PLUGIN_EVENT_DSGVO_GDPR_COOKIE_CONSENT_PATH_DESC', 'Dieses Plugin bündelt die JS und CSS der Cookie-Einwilligungsseite. Sie können hier auf andere Verzeichnisse verweisen. Stellen Sie sicher, dass die Dateien cookieconsent.min.css und cookieconsent.min.js heißen.');
@define('PLUGIN_EVENT_DSGVO_GDPR_COMMENTFORM_ERROR', 'Sie müssen die Bedingungen akzeptieren, um einen Kommentar zu hinterlassen.');
@define('PLUGIN_EVENT_DSGVO_GDPR_STATEMENT_ERROR', 'Dieses Blog hat noch keine Datenschutzerklärung erstellt, es muss in der Plugin-Konfiguration konfiguriert werden.');

@define('PLUGIN_EVENT_DSGVO_GDPR_SERENDIPITY_CORE', '

<h4>Serendipity Kern</h4>

<p>Serendipity verwendet ein sogenanntes "Session-Cookie" für Frontend und Backend. Ein Besucher erhält ein Cookie mit dem folgenden Inhalt:
eine eindeutige ID, die auf dem Server verwendet wird, um temporäre Session-Benutzerdaten zu speichern (z.B. Login-Gültigkeit, Benutzereinstellungen).
Dieses Cookie ist obligatorisch für die Anmeldung am Backend, aber optional für das Frontend.
Bestimmte Plugins können das Session-Cookie verwenden, um zusätzliche temporäre Daten zu speichern.</p>

<p>Die folgenden Daten können von der Serendipity-Anwendung auf dem Server gespeichert werden (temporär, ungültig nach dem vom Server konfigurierten Timeout, normalerweise im Zeitbereich von Stunden):</p>

<ul>
    <li>HTTP-Browser-Referrer bei der Eingabe des Blogs</li>
    <li>Einzigartiges Autoren-ID-Token</li>
    <li>Benutzerdaten eines angemeldeten Autors, wie sie in der Datenbank gespeichert sind, für einen schnelleren Zugriff auf:
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
    <li>Indikator, ob das Smarty Templating verwendet wird</li>
    <li>Möglicher Inhalt eines generierten Captcha-Bildes</li>
    <li>Das konfigurierte Frontend-Theme</li>
</ul>

<p>Die folgenden Daten werden in Cookies gespeichert:</p>

<ul>
    <li>PHP Sitzungs ID</li>
    <li>Zustand des Eintragseditors: Umschaltungszustand, Sortierung, Sortierungs- und Filterzustand, zuletzt benutztes Verzeichnis der Mediathek (nur wenn eingeloggt)</li>
    <li>Author Login Token (nur wenn angemeldet)</li>
    <li>Anzeigesprache</li>
    <li>Nach dem Kommentar: Nachname, E-Mail, URL, Status von "Kommentare merken" (falls aktiviert)</li>
</ul>

<p>Die IP-Adressen der Benutzer werden an diesen Stellen verwendet:</p>

<ul>
    <li>Speichert in der Datenbank, wenn das Referrer-Tracking aktiviert ist (Statistik)</li>
    <li>Gespeichert bei den Kommentaren eines Besuchers und werden in der E-Mail, die an Moderatoren gesendet wird, angezeigt</li>
    <li>Speichert in der Logdatei (falls aktiviert) des Antispam-Spamblock-Plugins</li>
    <li>Übermittelt im Antispam-Filter von Akismet (falls aktiviert)</li>
    <li>Temporärer Nur-Lesezugriff zur Überprüfung von Referrern, Logins, IP-Flooding</li>
</ul>

<p>Benutzereingaben von Besuchern (nicht von Redakteuren):</p>

<ul>
    <li>Kommentare (alle Kommentar-Metadaten, gespeichert in der Datenbanktabelle serendipity_comments)</li>
    <li>Referring URL beim Betreten des Blogs (wenn das Referrer-Tracking aktiviert ist, gespeichert in der Datenbanktabelle serendipity_referers)</li>
</ul>

<p>Zusätzlich sind derzeit die folgenden Plugins aktiviert und dies ist ihr automatisch generiertes Manifest:</p>.

');
@define('PLUGIN_EVENT_DSGVO_GDPR_SERENDIPITY_CORE_THEMES', '

<h2>Serendipity Kern Themes</h2>

<p>Zusätzlich sind folgende Themes vorhanden und dies ist ihr automatisch generiertes Manifest:</p>.

');

@define('PLUGIN_EVENT_DSGVO_GDPR_PLUGINS_SERVICES_HEAD', 'Webservices / Dritte');
@define('PLUGIN_EVENT_DSGVO_GDPR_PLUGINS_SESSIONDATA_HEAD', 'Sitzungsdaten');
@define('PLUGIN_EVENT_DSGVO_GDPR_PLUGINS_ATTR_HEAD', 'Eigenschaften des Plugins');
@define('PLUGIN_EVENT_DSGVO_GDPR_PLUGINS_ATTR_STORAGE_USER_YES', 'Speichert Benutzerdaten (wie Namen, Text, Einstellungen) in einer Datenbank, Datei oder irgend einem anderen Speicher (wie Mail, Cookie, ...)');
@define('PLUGIN_EVENT_DSGVO_GDPR_PLUGINS_ATTR_STORAGE_USER_NO', 'Keine Speicherung von Benutzerdaten (oder nicht angegeben)');
@define('PLUGIN_EVENT_DSGVO_GDPR_PLUGINS_ATTR_STORAGE_IP_YES', 'Speichert IP-Daten (in lokalen oder externen Speichermedien)');
@define('PLUGIN_EVENT_DSGVO_GDPR_PLUGINS_ATTR_STORAGE_IP_NO', 'Speichert keine IP-Daten (oder nicht spezifiziert)');
@define('PLUGIN_EVENT_DSGVO_GDPR_PLUGINS_ATTR_USES_IP_YES', 'Arbeitet mit IP-Daten (Lesezugriff, auch über Metadaten)');
@define('PLUGIN_EVENT_DSGVO_GDPR_PLUGINS_ATTR_USES_IP_NO', 'Verwendet keine IP-Daten (oder nicht spezifiziert)');
@define('PLUGIN_EVENT_DSGVO_GDPR_PLUGINS_ATTR_TRANSMITS_YES', 'Überträgt Benutzereingaben an Dienste / Dritte (nicht unbedingt gespeichert)');
@define('PLUGIN_EVENT_DSGVO_GDPR_PLUGINS_ATTR_TRANSMITS_NO', 'Übermittelt keine Benutzereingaben an Dienste / Dritte (oder nicht spezifiziert)');

@define('PLUGIN_EVENT_DSGVO_GDPR_BACKEND', 'Verwaltung des Datenschutz-Plugins');
@define('PLUGIN_EVENT_DSGVO_GDPR_BACKEND_SB_TITLE', 'Kommentar-Benutzerdaten');
@define('PLUGIN_EVENT_DSGVO_GDPR_BACKEND_TITLE', 'DSGVO/GDPR - Kommentar-Benutzerdaten verwalten');
@define('PLUGIN_EVENT_DSGVO_GDPR_BACKEND_INFO', 'Hier können Sie einen passgenauen Benutzernamen oder eine E-Mail-Adresse eingeben, um alle Kommentar-Metadaten dieses Benutzer zu löschen oder die Kommentare zu exportieren. Sie können mehrere Namen mit einem Zeilenumbruch trennen.');
@define('PLUGIN_EVENT_DSGVO_GDPR_BACKEND_DELFAIL', 'Um Daten zu exportieren oder zu löschen, müssen Sie mindestens einen Benutzernamen oder eine E-Mail-Adresse angeben.');

@define('PLUGIN_EVENT_DSGVO_GDPR_BACKEND_CHECK_REQUESTS', 'Momentan ist ein solches Auskunfts- bzw Löschersuchen nicht oder nur bedingt über die Email verifizierbar. Ist der Anfragende wirklich auch der Kommentator?');

