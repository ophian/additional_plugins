<?php

@define('PLUGIN_DOWNLOADMANAGER_TITLE', 'Downloadmanager');
@define('PLUGIN_DOWNLOADMANAGER_DESC', 'Provides full downloadmanager capabilities to your s9y. When uninstalling, all related tables will be dropped!');
@define('PLUGIN_DOWNLOADMANAGER_PAGETITLE', 'Page title');
@define('PLUGIN_DOWNLOADMANAGER_PAGETITLE_BLAHBLAH', 'title of the page');
@define('PLUGIN_DOWNLOADMANAGER_HEADLINE', 'Headline');
@define('PLUGIN_DOWNLOADMANAGER_HEADLINE_BLAHBLAH', 'The headline of the page.');
@define('PLUGIN_DOWNLOADMANAGER_PAGEURL', 'Static URL');
@define('PLUGIN_DOWNLOADMANAGER_PAGEURL_BLAHBLAH', 'Defines the URL of the page (index.php?serendipity[subpage]=name)');
@define('PLUGIN_DOWNLOADMANAGER_PERMALINK', 'Permalink');
@define('PLUGIN_DOWNLOADMANAGER_PERMALINK_BLAHBLAH', 'Defines a custom permalink for the URL which can be much shorter than the Static URL. Needs the absolute HTTP path and needs to end with .htm or .html. (Defaults to "%s")');
@define('PLUGIN_DOWNLOADMANAGER_ABSINCOMINGPATH', 'Incoming data path');
@define('PLUGIN_DOWNLOADMANAGER_ABSINCOMINGPATH_BLAHBLAH', 'Full and absolute path to the directory in which you can (FTP)-upload bigger files to import them into your downloadmanager.');
@define('PLUGIN_DOWNLOADMANAGER_ABSDOWNLOADPATH', 'Absolute download data path');
@define('PLUGIN_DOWNLOADMANAGER_ABSDOWNLOADPATH_BLAHBLAH', 'Full and absolute path to the directory in which the files are stored.');
@define('PLUGIN_DOWNLOADMANAGER_HTTPPATH', 'HTTP-path to plugin');
@define('PLUGIN_DOWNLOADMANAGER_HTTPPATH_BLAHBLAH', 'absolute http path to plugin (usually \'/plugins/serendipity_event_downloadmanager\').');
@define('PLUGIN_DOWNLOADMANAGER_DATEFORMAT', 'The format of the entry\'s actual date, using PHPs date() variables. (Default: \'Y/m/d, h:ia\')');
@define('PLUGIN_DOWNLOADMANAGER_SHOWFILEDATE', 'Show filedate');
@define('PLUGIN_DOWNLOADMANAGER_SHOWFILEDATE_BLAHBLAH', 'Should the filedate be shown in the filelist?');
@define('PLUGIN_DOWNLOADMANAGER_SHOWFILENAME', 'Show filename');
@define('PLUGIN_DOWNLOADMANAGER_SHOWFILENAME_BLAHBLAH', 'Should the filename be shown in the filelist?');
@define('PLUGIN_DOWNLOADMANAGER_SHOWFILESIZE', 'Show filesize');
@define('PLUGIN_DOWNLOADMANAGER_SHOWFILESIZE_BLAHBLAH', 'Should the filesize be shown in the filelist?');
@define('PLUGIN_DOWNLOADMANAGER_SHOWDOWNLOADS', 'Show # of downloads');
@define('PLUGIN_DOWNLOADMANAGER_SHOWDOWNLOADS_BLAHBLAH', 'Should the number of the downloads be shown in the filelist?');
@define('PLUGIN_DOWNLOADMANAGER_FILENAME_FIELD', 'Label of filename field');
@define('PLUGIN_DOWNLOADMANAGER_FILENAME_FIELD_BLAHBLAH', 'Change the label of the filename field here');
@define('PLUGIN_DOWNLOADMANAGER_FILESIZE_FIELD', 'Label of filesize field');
@define('PLUGIN_DOWNLOADMANAGER_FILESIZE_FIELD_BLAHBLAH', 'Change the label of the filesize field here');
@define('PLUGIN_DOWNLOADMANAGER_FILEDATE_FIELD', 'Label of filedate field');
@define('PLUGIN_DOWNLOADMANAGER_FILEDATE_FIELD_BLAHBLAH', 'Change the label of the filedate field here');
@define('PLUGIN_DOWNLOADMANAGER_DLS_FIELD', 'Label of \'dls\' field');
@define('PLUGIN_DOWNLOADMANAGER_DLS_FIELD_BLAHBLAH', 'Change the label of the \'number of downloads of this file\' field here');
@define('PLUGIN_DOWNLOADMANAGER_ICONWIDTH', 'Icon width');
@define('PLUGIN_DOWNLOADMANAGER_ICONWIDTHBLAH', 'Width of the filetype-icon in the filelist');
@define('PLUGIN_DOWNLOADMANAGER_ICONHEIGHT', 'Icon height');
@define('PLUGIN_DOWNLOADMANAGER_ICONHEIGHT_BLAHBLAH', 'Height of the filetype-icon in the filelist');
@define('PLUGIN_DOWNLOADMANAGER_SHOWHIDDEN_REGISTERED', 'Show hidden categories to registered users?');
@define('PLUGIN_DOWNLOADMANAGER_SHOWHIDDEN_REGISTERED_BLAHBLAH', 'Should hidden categories be shown to registered and logged in users?');

@define('PLUGIN_DOWNLOADMANAGER_NO_CATS_FOUND', 'No categories found!');
@define('PLUGIN_DOWNLOADMANAGER_CATEGORIES', 'Categories');
@define('PLUGIN_DOWNLOADMANAGER_SUBCATEGORIES', 'Subcategories');
@define('PLUGIN_DOWNLOADMANAGER_CATEGORY', 'Category');
@define('PLUGIN_DOWNLOADMANAGER_NUMBER_OF_DOWNLOADS', '# files');
@define('PLUGIN_DOWNLOADMANAGER_CATNAME', 'Category name:');
@define('PLUGIN_DOWNLOADMANAGER_SUBCAT_OF', 'Sub-category of:');
@define('PLUGIN_DOWNLOADMANAGER_ADD_CAT', 'Add new category');
@define('PLUGIN_DOWNLOADMANAGER_DEL_FILE', 'Delete this file...');
@define('PLUGIN_DOWNLOADMANAGER_DEL_CAT', 'Delete this category (and all files in it!)...');
@define('PLUGIN_DOWNLOADMANAGER_DEL_CAT_NOT_ALLOWD', 'Deleting not allowed - has subcategories!');
@define('PLUGIN_DOWNLOADMANAGER_DELETE_NOT_ALLOWED', 'This category can not be deleted, because it contains at least one subcategory!');
@define('PLUGIN_DOWNLOADMANAGER_CAT_NOT_FOUND', 'Category not found!');
@define('PLUGIN_DOWNLOADMANAGER_DLS_IN_THIS_CAT', 'Downloads in this category');
@define('PLUGIN_DOWNLOADMANAGER_BACK', 'Back');
@define('PLUGIN_DOWNLOADMANAGER_FILENAME', 'Filename');
@define('PLUGIN_DOWNLOADMANAGER_FILESIZE', 'Filesize');
@define('PLUGIN_DOWNLOADMANAGER_FILEDATE', 'Date');
@define('PLUGIN_DOWNLOADMANAGER_NUM_DOWNLOADS', 'dls');
@define('PLUGIN_DOWNLOADMANAGER_NUM_DOWNLOADS_BLAH', 'Number of downloads');
@define('PLUGIN_DOWNLOADMANAGER_IMPORT_FILE', 'Import this file from your incoming directory into this actual category...');
@define('PLUGIN_DOWNLOADMANAGER_COPY_NOT_ALLOWED', 'Not able to copy the new file from your incoming directory to the download directory!<br />This can happen for example, if the file encoding is wrong, or when safe_mode is activated in your php.ini.<br />Please deactivate the php safe_mode to use this feature!');
@define('PLUGIN_DOWNLOADMANAGER_DELETE_IN_INCOMING_NOT_ALLOWED', 'I\'m not allowed to delete the file from your incoming directory! Please delete this one file manually and then set the file permissions that I can delete all further files for you.');
@define('PLUGIN_DOWNLOADMANAGER_DELETE_IN_DOWNLOADDIR_NOT_ALLOWED', 'I\'m not allowed to delete the file from your download directory! Please set the file permissions that I can delete this file.');
/*@define('PLUGIN_DOWNLOADMANAGER_INCOMINGTABLE', 'Incoming directory:');*/
@define('PLUGIN_DOWNLOADMANAGER_INCOMINGTABLE_BLAHBLAH', 'This directory "%s"
<ul>
    <li>allows to import files via FTP upload to the current category "<strong>%s</strong>"</li>
    <li>is used as a temporary(!) directory for delete and/or for moving files between categories.</li>
    <li>On the other hand you should not keep files in here and always erase stored files completly (see blue trash symbol link).</li>
    <li>For keeping and hiding files in the longer term please use the root directory. See DLM Help box.</li>
</ul>');
@define('PLUGIN_DOWNLOADMANAGER_THIS_FILE', 'Selected file');
@define('PLUGIN_DOWNLOADMANAGER_EDIT_FILE', 'Edit this file');
@define('PLUGIN_DOWNLOADMANAGER_MOVE_TO_CAT', 'Move file to');
@define('PLUGIN_DOWNLOADMANAGER_EDIT_FILE_DESC', 'File description');
@define('PLUGIN_DOWNLOADMANAGER_FILE_EDITED', 'File successfully edited and saved!');
@define('PLUGIN_DOWNLOADMANAGER_DOWNLOAD_FILE', 'Download this file');
@define('PLUGIN_DOWNLOADMANAGER_UPLOAD_FILE', 'Upload files');
@define('PLUGIN_DOWNLOADMANAGER_FILE', 'File');
@define('PLUGIN_DOWNLOADMANAGER_UPLOAD_NOT_ALLOWED', 'File uploads are not allowed!<br />Allow them in your php.ini (file_uploads)!');
@define('PLUGIN_DOWNLOADMANAGER_ERRORS_OCCOURED', 'Some errors occoured during file upload!');
@define('PLUGIN_DOWNLOADMANAGER_ERRORS_NOTCOPIED', 'These files could not be copied:');
@define('PLUGIN_DOWNLOADMANAGER_ERRORS_TOOBIG', 'These files were too big:');
@define('PLUGIN_DOWNLOADMANAGER_NO_FILES_UPLOADED', 'No uploaded files found!');
@define('PLUGIN_DOWNLOADMANAGER_MEDIA_LIBRARY', 'Files from media library');
@define('PLUGIN_DOWNLOADMANAGER_MEDIA_LIBRARY_BLAHBLAH', 'You can import already uploaded files from the media library to your downloadmanager.<br />Note: These files will not be moved, they will only be copied!<br />Current directory: ');
@define('PLUGIN_DOWNLOADMANAGER_HIDE_TREE', 'Hide this and the complete subtree below this category...');
@define('PLUGIN_DOWNLOADMANAGER_UNHIDE_TREE', 'Unhide this and the complete subtree below this category...');
@define('PLUGIN_DOWNLOADMANAGER_OPEN_CAT', 'Click to open this categorie for uploading or modifying files...');

@define('PLUGIN_DOWNLOADMANAGER_SHOWDESC_INLIST',       'Show file description in filelists');
@define('PLUGIN_DOWNLOADMANAGER_SHOWDESC_INLIST_DESC',  'If you want to have a short file list, switch this off, if you want more information in the list, switch this on.');
@define('PLUGIN_DOWNLOADMANAGER_DOWNLOAD_INLIST',       'Download files directly in filelist');
@define('PLUGIN_DOWNLOADMANAGER_DOWNLOAD_INLIST_DESC',  'The default behavior is to present an info page first before accessing the file. Here you can configure, if you want to have a direct download from the filelist. This can be accessd clicking file icon, file name or both.');
@define('PLUGIN_DOWNLOADMANAGER_DOWNLOAD_INLIST_NO',    'Infopage always');
@define('PLUGIN_DOWNLOADMANAGER_DOWNLOAD_INLIST_ICON',  'Direct download on icon');
@define('PLUGIN_DOWNLOADMANAGER_DOWNLOAD_INLIST_NAME',  'Direct download on filename');
@define('PLUGIN_DOWNLOADMANAGER_DOWNLOAD_INLIST_BOTH',  'Direct download on both');
@define('PLUGIN_DOWNLOADMANAGER_ADD_EXISTING',          'New versions of existing files do..');
@define('PLUGIN_DOWNLOADMANAGER_ADD_EXISTING_DESC',     'If you uploaded a file that is already exisitng should a new file entry be created or should the old one be refreshed with the new file information?');
@define('PLUGIN_DOWNLOADMANAGER_ADD_EXISTING_INSERT',   'create a new entry');
@define('PLUGIN_DOWNLOADMANAGER_ADD_EXISTING_UPDATE',   'refresh the old entry');

/* changed with 0.22 and up - uncommented above */
@define('PLUGIN_DOWNLOADMANAGER_INCOMINGTABLE', 'Income ftp/trash directory:');

/* newly shipped with 0.22 and up */
@define('PLUGIN_DOWNLOADMANAGER_BACKEND_TITLE', 'Downloadmanager v.%s - Backend Admin Menu');
@define('PLUGIN_DOWNLOADMANAGER_INTRO', 'Introductory Text (optional)');
@define('PLUGIN_DOWNLOADMANAGER_REGISTERED_ONLY', 'Generally: show data to registered users only');
@define('PLUGIN_DOWNLOADMANAGER_REGISTERED_ONLY_BLAHBLAH', 'Do you want the frontend to show categories and downloads to this blogs registered and logged in users only?');
@define('PLUGIN_DOWNLOADMANAGER_REGISTERED_ONLY_ERROR', 'The downloads are available only to this blogs registered users!');
@define('PLUGIN_DOWNLOADMANAGER_ROOTLEVEL_TITLE', 'files at root level (hidden in frontend!)');
@define('PLUGIN_DOWNLOADMANAGER_ERRORS_UPGRADE_NOTCOPIED', 'We are sorry! An error occured. The files of<br /><em>%s</em><br />could not be moved to<br /><em>%s</em>.<br /><br />Please move them manually and press <a class="backend_error_link" href="%s">this link</a>, to inform this plugin about it!<br />Additionally remove the old directories manually too.<br />');
#@define('PLUGIN_DOWNLOADMANAGER_ALLFILES_COPIED_NEWDIR', 'Since you upgraded your downloadmanager plugin to v.0.24, all you files were copied to the new \'/.dlm/files\' and \'/.dlm/ftpin\' directories in serendipities \'/archives\' folder to avoid oldpath conflicts.<br /><br />The config settings were set to hold the new path strings and are not alterable any more in future.<br />Please remove the old directories manually.<br />');
#@define('PLUGIN_DOWNLOADMANAGER_ALLFILES_COPY_NEWDIR_REMEMBER', 'You have successfully changed this plugin to accept the new path settings only.<br /><br />Please remember, to move your files manually to the new \'archives/.dlm/files\' and \'archives/.dlm/ftpin\' directories!<br />Additionally remove the old directories manually too.<br />');
@define('PLUGIN_DOWNLOADMANAGER_BUTTON_MARK', 'mark all / unmark');
@define('PLUGIN_DOWNLOADMANAGER_BUTTON_MARK_TITLE', 'erase all marked to ftp/trash');
@define('PLUGIN_DOWNLOADMANAGER_BUTTON_MOVE_TITLE', 'move all marked to category');
@define('PLUGIN_DOWNLOADMANAGER_CLEAR_TRASH', 'Clear bin in ftp/trash folder');
@define('PLUGIN_DOWNLOADMANAGER_NO_TRASH', 'No files to destroy in ftp/trash folder');
@define('PLUGIN_DOWNLOADMANAGER_EDIT_FILE_RENAME', 'Rename this file');
@define('PLUGIN_DOWNLOADMANAGER_BACK_ROOT', 'Root category');
@define('PLUGIN_DOWNLOADMANAGER_BACK_CURRENT', 'Current category');
/* HELPTIP_CF = category folder; HELPTIP_IF = incoming folder; HELPTIP_FF = file folder; HELPTIP_MF = s9y media library folder; */
@define('PLUGIN_DOWNLOADMANAGER_HELPTIP_CF_START', 'Start: Create a category to upload files.');
@define('PLUGIN_DOWNLOADMANAGER_HELPTIP_CF_CHANGE', 'Change category name in cat field directly / <em>Enter</em>');
@define('PLUGIN_DOWNLOADMANAGER_HELPTIP_IF_VIEW', 'To view and handle ftp/trash folder, choose subcategory of root.');
@define('PLUGIN_DOWNLOADMANAGER_HELPTIP_FF_MULTI', 'All file erasing in ftp/trash folder will happen immediately!');
@define('PLUGIN_DOWNLOADMANAGER_HELPTIP_FF_SINGLE', 'The active red button single erasing will happen immediately!');
@define('PLUGIN_DOWNLOADMANAGER_HELPTIP_IF_ERASE', 'All multi file erasing as marked, will be <b>moved</b> to the ftp/trash folder,<br />&nbsp;&nbsp;&nbsp;to avoid unintentional destroying!');
@define('PLUGIN_DOWNLOADMANAGER_HELPTIP_FF_KEEP', 'Keep files, but do not show in frontend? Send them to root,<br />&nbsp;&nbsp;&nbsp;or create a hidden subfolder! Keep in mind you have 2 config settings<br />&nbsp;&nbsp;&nbsp;concerning registered and logged in users in frontend.');
@define('PLUGIN_DOWNLOADMANAGER_HELPTIP_FF_CHANGE', 'Change file name on file-links edit-subpage.');
@define('PLUGIN_DOWNLOADMANAGER_HELPTIP_IF_LFTP', 'Load files per ftp into /serendipity/archives/.dlm/ftpin folder.');
@define('PLUGIN_DOWNLOADMANAGER_HELPTIP_IF_TRASH', 'Use the blue trashbox to clean up the ftp/trash ftp folder after your work!');
@define('PLUGIN_DOWNLOADMANAGER_HELPTIP_IF_MOVE', 'Use the ftp/trash folder to easily move multiple files between folders!<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;1. send files to ftp/trash via <b>mark</b> <em>and</em> <b>erase</b>;<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;2. in categories, select another subfolder;<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;3. open ftp/trash and move these files via <b>mark</b> <em>and</em> <b>move</b>.');
@define('PLUGIN_DOWNLOADMANAGER_HELPTIP_DESC', 'When uninstalling this plugin, all related tables will be dropped!');
/*
@define('PLUGIN_DOWNLOADMANAGER_HELPTIP_IF_VIEW', '');
@define('PLUGIN_DOWNLOADMANAGER_HELPTIP_IF_VIEW', '');
@define('PLUGIN_DOWNLOADMANAGER_HELPTIP_IF_VIEW', '');
*/

@define('PLUGIN_DOWNLOADMANAGER_PHPMB_ERROR', 'PHP mb_* functions not available. Please use ASCII filenames only!');

