<?php

@define('PLUGIN_EVENT_AUTOUPDATE_NAME', 'Serendipity Autoupdate');
@define('PLUGIN_EVENT_AUTOUPDATE_DESC', 'When the Dashboard (once a day) detects an update, this plugin adds the option to manually download or start an automatic and secured upgrade of the blog directly with one click from within the adminarea. With Styx 2.1+ it is recommended to use it in combination with the modemaintain (maintenance-) event plugin. For Autoupdate Notifications you have to enable the global Serendipity configuration option in "Configuration:: General Settings: Update notification" to "stable" or "beta" to use and get notifications at all!');
@define('PLUGIN_EVENT_AUTOUPDATE_UPDATEBUTTON', 'Start automatic upgrade');

@define('PLUGIN_EVENT_AUTOUPDATE_DL_URL', 'Custom (GitHub?) download URL');
@define('PLUGIN_EVENT_AUTOUPDATE_DL_URL_DESC', 'Please set an URL like this: "https://github.com/name/repo/releases/download/". Your custom location dir/file-pattern has to end with "$version/serendipity-$version.zip" (replace $version with the version string provided in your custom RELEASE-file, eg. "2.1.5/serendipity-2.1.5.zip"). You can set the latter in the Backend configuration - general setting option block. Else leave this Styx default-URL untouched!');
@define('PLUGIN_EVENT_AUTOUPDATE_RF_URL', 'Custom (GitHub?) release tag URL');
@define('PLUGIN_EVENT_AUTOUPDATE_RF_URL_DESC', 'Please set an URL like this: "https://github.com/name/repo/releases/tag/". Your custom location page name must be named "$version" (replace $version with the version string provided in your custom RELEASE-file, eg. "2.1.5"). You can set the latter in the Backend configuration - general setting option block. Else leave this Styx default-URL untouched!');
@define('PLUGIN_EVENT_AUTOUPDATE_REMOVE_ZIPS', 'Enable to remove all previously fetched upgrade zip binaries?');
@define('PLUGIN_EVENT_AUTOUPDATE_REMOVE_ZIPS_DESC', 'Recommendation (yes)!');

@define('PLUGIN_EVENT_AUTOUPDATE_CHECK', 'SECURITY ADVICE:\n\nDid you already check for plugin UPDATES?\nDo you really have the MODEMAINTAIN plugin installed and is the Maintenance-Mode enabled and ON for the current upgrade?\n\nPress OK to continue with the AUTOUPDATE.');

@define('PLUGIN_AUTOUPD_MSG_TITLE', 'Serendipity Auto-Upgrade Processor');
@define('PLUGIN_AUTOUPD_MSG_INFO', 'To download, verify, check, unzip, copy and remove temporary stuff for the Serendipity Update: %s may take a little while... (approx. 1-3 min).<br>Please don\'t get nervous and do not close this page while in progress!');
@define('PLUGIN_AUTOUPD_MSG_RELOAD', 'PLEASE NOTE: If this page ever stops with an error message during procession, you can normally just RELOAD your browser [<em>by keyboard shortcut, eg. F5</em>] to get another run. This does not do any harm to a continued upgrade.');
@define('PLUGIN_AUTOUPD_MSG_EXECUTIONTIME', 'PHP max execution time set to 210 seconds');

@define('PLUGIN_AUTOUPD_MSG_ZIPEXTFAIL', 'ZIP extension has not been compiled or loaded in PHP.');

@define('PLUGIN_AUTOUPD_MSG_FLUSH_COMP', ' completed!'); // KEEP the starting whitespace!
@define('PLUGIN_AUTOUPD_MSG_FLUSH_WAIT', ' <b>Please wait ... processing:</b><span> %s ...</span>'); // KEEP the starting whitespace!

@define('PLUGIN_AUTOUPD_MSG_FLUSH_FNC_TIME', "In %0.4d seconds run fcn %s...\n"); // %0.4d prints in readable format 1.2345

@define('PLUGIN_AUTOUPD_MSG_FLUSH_NEXT_VERIFY', 'Verify the update package'); // = next function msg
@define('PLUGIN_AUTOUPD_MSG_FLUSH_NEXT_PERM', 'Checking write permissions'); // = next function msg
@define('PLUGIN_AUTOUPD_MSG_FLUSH_NEXT_UNPACK', 'Unpacking the update'); // = next function msg
@define('PLUGIN_AUTOUPD_MSG_FLUSH_NEXT_INTEGRITY', 'Checking integrity'); // = next function msg
@define('PLUGIN_AUTOUPD_MSG_FLUSH_NEXT_COPY', 'Finally copy update'); // = next function msg
@define('PLUGIN_AUTOUPD_MSG_FLUSH_NEXT_CLEAN', 'Cleaning up temporary directory'); // = next function msg
@define('PLUGIN_AUTOUPD_MSG_FLUSH_NEXT_FINISH', 'Finish processing unit'); // = next function msg

@define('PLUGIN_AUTOUPD_MSG_FLUSH_FINI_CLEANUP', 'Cleanup download temp done!');
@define('PLUGIN_AUTOUPD_MSG_FLUSH_INST_GO', '<a href="%s">click to start Serendipity Installer here</a>!');

@define('PLUGIN_AUTOUPD_MSG_FLUSH_FAIL_COPY', 'Copying the files for the update failed!');
@define('PLUGIN_AUTOUPD_MSG_FLUSH_FAIL_UNPACK', 'Unpacking the update zip file failed!');
@define('PLUGIN_AUTOUPD_MSG_FLUSH_FAIL_CLEAN', 'Cleaning up the failed unpack directory!');
@define('PLUGIN_AUTOUPD_MSG_FLUSH_FAIL_RELOAD', 'Please <a href="?serendipity[newVersion]=%s">reload</a> this page [F5] to have another try to upgrade your Blog successful!');

@define('PLUGIN_AUTOUPD_MSG_EXISTS', 'Does the Link to (<span class="file">%s</span>) exist?');
@define('PLUGIN_AUTOUPD_MSG_RETURN', '<a href="?serendipity[newVersion]=%s">Reload</a> page or return to your blogs <a href="serendipity_admin.php">backend</a>.');

@define('PLUGIN_AUTOUPD_MSG_FETCH_ZIPFAIL', 'Existing zip file error; Code: %s ("%s"). The Autoupdater will try to download again...');
@define('PLUGIN_AUTOUPD_MSG_FETCH_CURLFAIL', 'Downloading update failed (Curl installed, but failed)!');
@define('PLUGIN_AUTOUPD_MSG_FETCH_DWLFAIL', 'Downloading update failed (copy failed, Curl not available)!');
@define('PLUGIN_AUTOUPD_MSG_FETCH_DWLDONE', 'Fetch download to "<span class="dir">templates_c</span>" done!');

@define('PLUGIN_AUTOUPD_MSG_VERIFY_CKS', 'Checking %s-zip file checksum: %s');
@define('PLUGIN_AUTOUPD_MSG_VERIFY_FAIL', 'Error! Could not verify the update.');

@define('PLUGIN_AUTOUPD_MSG_UNPACK', 'Extracting the zip in "<span class="dir">templates_c</span>" done!');

@define('PLUGIN_AUTOUPD_MSG_COPY_FAIL', 'Error! Copying file "<span class="file">%s</span>" to "<span class="file">%s</span>" failed!');

@define('PLUGIN_AUTOUPD_MSG_WRITE_FAIL', 'Unpacking the update zip file failed, while the following files were not writable:');

@define('PLUGIN_AUTOUPD_MSG_CKSUM_FAIL', 'Updating failed, while the integrity-test for the following files failed:');

@define('PLUGIN_AUTOUPD_MSG_CLOSE', 'PLEASE NOTE:<br><span class="foot">If this page ever stops with an error message during procession, you can normally just RELOAD your browser [<em>by keyboard shortcut, eg. F5</em>] to get another run. This does not do any harm to a continued upgrade.</span>');

@define('PLUGIN_AUTOUPD_MSG_DUNNE_JS', "Autoupdate successfully done!\\nWe now refresh to the Serendipity Installer!\\n"); // KEEP double quotes and escape for js
@define('PLUGIN_AUTOUPD_MSG_DUNNE_OK', 'Autoupdate successfully done - refreshing to Serendipity Installer...');

@define('PLUGIN_AUTOUPD_MSG_CLEAN_ZIPS', 'Removing %d zip files in "<span class="dir">templates_c</span>" done!');
@define('PLUGIN_AUTOUPD_MSG_CLEAN_FILES', 'Removing all files in "<span class="dir">%s</span>" done!');
@define('PLUGIN_AUTOUPD_MSG_CLEAN_DIR', 'Removing the empty directory: "<span class="dir">%s</span>" done!');
@define('PLUGIN_AUTOUPD_MSG_CLEAN_DIR_FAILED', 'Removing the empty directory: "<span class="dir">%s</span>" failed!');
@define('PLUGIN_AUTOUPD_MSG_CLEAN_TC_OK', 'Auto-Cleanup of the Smarty compiled theme directory: "<span class="dir">templates_c/%s</span>" done!');
@define('PLUGIN_AUTOUPD_MSG_CLEAN_TC_FAILED', 'Auto-Cleanup of the Smarty compiled theme directory: "<span class="dir">templates_c/%s</span>" failed! If you laterly encounter problems with your current themes compiles, delete this directory manually to make Smarty auto-recompile.');

