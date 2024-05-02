<?php

@define('PLUGIN_EVENT_GOOGLE_ANALYTICS_NAME', 'Google Analytics 4');
@define('PLUGIN_EVENT_GOOGLE_ANALYTICS_DESC', 'This plugin adds extended Google Analytics 4 functionality.');
@define('PLUGIN_EVENT_GOOGLE_ANALYTICS_ACCOUNT_NUMBER', 'Google Analytics 4 measurement ID');
@define('PLUGIN_EVENT_GOOGLE_ANALYTICS_ACCOUNT_NUMBER_DESC', 'Your Google Analytics 4 measurement ID from stream details. Format is "G-xxxxxxxxxx".');
@define('PLUGIN_EVENT_GOOGLE_ANALYTICS_TRACK_EXTERNAL', 'Track external links');
@define('PLUGIN_EVENT_GOOGLE_ANALYTICS_TRACK_EXTERNAL_DESC', 'Add tracking into content links for accurate link exit tracking');
#@define('PLUGIN_EVENT_GOOGLE_ANALYTICS_ANONYMIZEIP', 'Anonymize IP');
#@define('PLUGIN_EVENT_GOOGLE_ANALYTICS_ANONYMIZEIP_DESC', 'Tell Google Analytics to anonymize the information sent by the tracker objects by removing the last octet of the IP address prior to its storage. Note that this will slightly reduce the accuracy of geographic reporting');
@define('PLUGIN_EVENT_GOOGLE_ANALYTICS_TRACK_DOWNLOADS', 'Track downloads?');
@define('PLUGIN_EVENT_GOOGLE_ANALYTICS_TRACK_DOWNLOADS_DESC', '');
@define('PLUGIN_EVENT_GOOGLE_ANALYTICS_DOWNLOAD_EXTENSIONS', 'Which downloads should be tracked?');
@define('PLUGIN_EVENT_GOOGLE_ANALYTICS_DOWNLOAD_EXTENSIONS_DESC', 'Comma separated list of tracked extensions.');
@define('PLUGIN_EVENT_GOOGLE_ANALYTICS_INTERNAL_HOSTS', 'Hosts you use for your blog.');
@define('PLUGIN_EVENT_GOOGLE_ANALYTICS_INTERNAL_HOSTS_DESC', 'One host per line (www.example.net).');
@define('PLUGIN_EVENT_GOOGLE_ANALYTICS_EXCLUDE_GROUPS', 'Which usergroups should not be tracked?');
@define('PLUGIN_EVENT_GOOGLE_ANALYTICS_EXCLUDE_GROUPS_DESC', 'Select group(s) from list.');

#@define('PLUGIN_EVENT_GOOGLE_ANALYTICS_APPLY_TRACKING_TO', 'If enabled, apply external tracking to %s');
@define('PLUGIN_EVENT_GOOGLE_ANALYTICS_APPLY_TRACKING_TO_DESC', 'If enabled, apply external tracking to blog entry element %s');

