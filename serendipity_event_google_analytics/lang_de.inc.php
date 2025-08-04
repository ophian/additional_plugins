<?php

@define('PLUGIN_EVENT_GOOGLE_ANALYTICS_NAME', 'Google Analytics 4');
@define('PLUGIN_EVENT_GOOGLE_ANALYTICS_DESC', 'Dieses Plugin fügt Google Analytics 4 Funktionalität hinzu. So können auch externe Links oder Downloads verfolgt werden.');
@define('PLUGIN_EVENT_GOOGLE_ANALYTICS_ACCOUNT_NUMBER', 'Google Analytics 4 measurement ID');
@define('PLUGIN_EVENT_GOOGLE_ANALYTICS_ACCOUNT_NUMBER_DESC', 'Deine Google Analytics 4 measurement ID. Format ist "G-xxxxxxxxxx".');
@define('PLUGIN_EVENT_GOOGLE_ANALYTICS_TRACK_EXTERNAL', 'Externe Links verfolgen?');
@define('PLUGIN_EVENT_GOOGLE_ANALYTICS_TRACK_EXTERNAL_DESC', 'Soll Google Analytics 4 Absprünge zu externen Links (über exit.php) überwachen?');
#@define('PLUGIN_EVENT_GOOGLE_ANALYTICS_ANONYMIZEIP', 'Anonymize IP');
#@define('PLUGIN_EVENT_GOOGLE_ANALYTICS_ANONYMIZEIP_DESC', 'Anonymisiert die IP der Besucher, indem Google das letzte Oktett der IP Adresse nicht speichert. Verringert etwas die Genauigkeit der geographischen Berichte.');
@define('PLUGIN_EVENT_GOOGLE_ANALYTICS_TRACK_DOWNLOADS', 'Downloads verfolgen?');
@define('PLUGIN_EVENT_GOOGLE_ANALYTICS_TRACK_DOWNLOADS_DESC', 'Soll Google Analytics Downloads überwachen?');
@define('PLUGIN_EVENT_GOOGLE_ANALYTICS_DOWNLOAD_EXTENSIONS', 'Welche Extensions sollen als Download überwacht werden?');
@define('PLUGIN_EVENT_GOOGLE_ANALYTICS_DOWNLOAD_EXTENSIONS_DESC', 'Komma separierte Liste von Extensions.');
@define('PLUGIN_EVENT_GOOGLE_ANALYTICS_INTERNAL_HOSTS', 'Hosts die du für dein Blog benutzt.');
@define('PLUGIN_EVENT_GOOGLE_ANALYTICS_INTERNAL_HOSTS_DESC', 'Ein Host pro Zeile (www.example.net).');
@define('PLUGIN_EVENT_GOOGLE_ANALYTICS_EXCLUDE_GROUPS', 'Zu ignorierende Benutzergruppe?');
@define('PLUGIN_EVENT_GOOGLE_ANALYTICS_EXCLUDE_GROUPS_DESC', 'Sie können eingeloggte Redakteure, die Mitglied in speziellen Benutzergruppen sind von der Erfassung durch Google Analytics ausschließen. Besuche dieser Benutzer werden in der Statistik dann nicht auftauchen.');

#@define('PLUGIN_EVENT_GOOGLE_ANALYTICS_APPLY_TRACKING_TO', 'If enabled, apply external tracking to %s');
@define('PLUGIN_EVENT_GOOGLE_ANALYTICS_APPLY_TRACKING_TO_DESC', 'Falls aktiviert, externe Nachverfolgung auf Blogeintragselement %s anwenden');

