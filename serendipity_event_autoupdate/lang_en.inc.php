<?php

@define('PLUGIN_EVENT_AUTOUPDATE_NAME', 'Serendipity Autoupdate');
@define('PLUGIN_EVENT_AUTOUPDATE_DESC', 'When the dashboard (once a day) detects an update, this plugin adds the option to manually download or start an automatic and secured upgrade of the blog directly with one click from within the adminarea.');
@define('PLUGIN_EVENT_AUTOUPDATE_UPDATEBUTTON', 'Start automatic upgrade');

@define('PLUGIN_EVENT_AUTOUPDATE_DL_URL', 'Custom (GitHub?) download url');
@define('PLUGIN_EVENT_AUTOUPDATE_DL_URL_DESC', 'Please set an URL like this: "https://github.com/s9y/Serendipity/releases/download/". Your custom location dir/file-pattern has to end with "$version/serendipity-$version.zip" (replace $version with the version string provided in your custom RELEASE-file, eg. "2.1.5/serendipity-2.1.5.zip"). You can set the latter in the backend configuration - general setting option block. Else leave this default-URL untouched!');
@define('PLUGIN_EVENT_AUTOUPDATE_RF_URL', 'Custom (GitHub?) release tag url');
@define('PLUGIN_EVENT_AUTOUPDATE_RF_URL_DESC', 'Please set an URL like this: "https://github.com/s9y/Serendipity/releases/tag/". Your custom location page name must be named "$version" (replace $version with the version string provided in your custom RELEASE-file, eg. "2.1.5"). You can set the latter in the backend configuration - general setting option block. Else leave this default-URL untouched!');

