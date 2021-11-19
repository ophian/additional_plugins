<?php

/**
 *  @version
 *  @author Translator Name <yourmail@example.com>
 *  EN-Revision: Revision of lang_en.inc.php
 *  Revised by
 */

@define('PLUGIN_EVENT_IMAGESELECTORPLUS_NAME', 'Extended options for media manager');
@define('PLUGIN_EVENT_IMAGESELECTORPLUS_DESC', 'Allows extended options for inserting images from the media manager');
@define('PLUGIN_EVENT_IMAGESELECTORPLUS_TARGET', 'Target for this link');
@define('PLUGIN_EVENT_IMAGESELECTORPLUS_TARGET_JS', 'Popup window (via JavaScript, adaptive size)');
@define('PLUGIN_EVENT_IMAGESELECTORPLUS_TARGET_ENTRY', 'Isolated Entry');
@define('PLUGIN_EVENT_IMAGESELECTORPLUS_TARGET_BLANK', 'Popup window (via target=_blank)');
@define('PLUGIN_EVENT_IMAGESELECTORPLUS_QUICKBLOG', 'QuickBlog extra');
@define('PLUGIN_EVENT_IMAGESELECTORPLUS_QUICKBLOG_DESC', 'If you enter at least a title in the following fields, the image will be posted as a new blog entry immediately. The design can be edited via the quickblog.tpl file.');
@define('PLUGIN_EVENT_IMAGESELECTORPLUS_MAXWIDTH', 'Maximum width of thumbnail (discards height)');
@define('PLUGIN_EVENT_IMAGESELECTORPLUS_MAXHEIGHT', 'Maximum height of thumbnail (discards width)');
@define('PLUGIN_EVENT_IMAGESELECTORPLUS_AUTORESIZE', 'Dynamically resize images based on width and height attributes');
@define('PLUGIN_EVENT_IMAGESELECTORPLUS_AUTORESIZE_DESC', 'Automatically send resized versions of your images to the client based on the manual edited width and/or height attributes specified in the IMG tag of you entry text. This can make your life easier and decrease download times but decreases server-side performance. (Note: Aspect ratios are maintained). An old feature of S9y history and at the latest with Styx 3 partly unusable, since with the new image Variations much has become irrelevant in this context. Recommended: No!');

@define('PLUGIN_EVENT_IMAGESELECTORPLUS_UNZIP_FILES', 'ZIP archives unzipping');
@define('PLUGIN_EVENT_IMAGESELECTORPLUS_UNZIP_FILES_BLABLAH', 'Unzip uploaded ZIP archives? - Preset value for form on the images upload page.');
@define('PLUGIN_EVENT_IMAGESELECTORPLUS_UNZIP_FILES_DESC', 'Unzip uploaded ZIP archives?');
@define('PLUGIN_EVENT_IMAGESELECTORPLUS_UNZIP_OK', 'ZIP archive successfully unzipped');
@define('PLUGIN_EVENT_IMAGESELECTORPLUS_UNZIP_FAILED', 'ZIP archive failed to unzip');
@define('PLUGIN_EVENT_IMAGESELECTORPLUS_UNZIP_IMAGE_FROM_ARCHIVE', 'Image from zip archive');
@define('PLUGIN_EVENT_IMAGESELECTORPLUS_UNZIP_ADD_TO_DB', 'added to database');

@define('PLUGIN_EVENT_IMAGESELECTORPLUS_JHEAD', 'Use jhead to obtain EXIF data');
@define('PLUGIN_EVENT_IMAGESELECTORPLUS_JHEAD_DESC', 'Override the default behaviour and use external calls to jhead to obtain EXIF data. Choose this option only if jhead is installed and can be executed.');

@define('PLUGIN_EVENT_IMAGESELECTORPLUS_IMAGE_SIZE_DESC', 'Changing this default $serendipity[\'thumbSize\'] to another value, will add an additional and resized copy of that image to the MediaLibrary. This instance is then used as the preview thumbnail image in your frontend blog entry, linking to the origin image.');
@define('PLUGIN_EVENT_IMAGESELECTORPLUS_ASOBJECT', 'Non-image object?');

@define('PLUGIN_EVENT_IMAGESELECTORPLUS_THUMBRESIZE_DESC', 'Default setting to both MAX values is 0, which is used as a fallback! Changing these values will overwrite $serendipity[\'thumbSize\'], defined in the blogs global "Configuration" - "Image Conversion Settings"! If you want to influence the MediaLibrary thumb size creation, change either the global "Image Conversion Settings" or use either this "max-width" OR "max-height" setting only, for landscape/portrait ratios. Setting both to the same value here, has the same effect.');

@define('PLUGIN_EVENT_IMAGESELECTORPLUS_EXAMPLE_READMEHINT', 'Please carefully read the plugin documentation using above link!');
@define('PLUGIN_EVENT_IMAGESELECTORPLUS_EXAMPLETEXT', 'PLEASE NOTE: The cores configuration option for media resizing via javascript/ajax disables some of these options, like quickblog entries and quickblog sized "thumbnails". If you want to use them disable that option! Furthermore you need the "Allow dynamic image resizing" option set true in BOTH, the plugin config AND the global serendipity config, to allow resizing images.');
@define('PLUGIN_EVENT_IMAGESELECTORPLUS_EXAMPLE_QUICKBLOG', 'PLEASE NOTE: Uploaded and per <b>Quickblog</b> <u>resized</u> images are stored as a third (additional) media-file into the MediaLibrary, eg <em>"imagename.quickblog.jpg"</em>. Since this "independent" file shall not sync (file and database cleanup) or double your auto-thumbnail generation for the MediaLibrary, the Serendipity <b>Styx Edition 2.4+</b> has been touched to exclude these "differing" quickblog thumbs to only inform you being present by an additional MediaLibrary action button next to delete.');

@define('PLUGIN_EVENT_IMAGESELECTORPLUS_ALLOW_QUICKBLOG', 'Allow QuickBlog entry form');
@define('PLUGIN_EVENT_IMAGESELECTORPLUS_ALLOW_QUICKBLOG_DESC', 'Quickblog is a special, immediate entry creator just inside the add media data form. When uploading an image, you can post an associated entry directly. Since it behaves different to normal entry pages in look and feel, and even creates a different image handler, you should make a good strategic choice about using it.');

@define('PLUGIN_EVENT_IMAGESELECTORPLUS_ZIP_WARNING', '<b>For Deflation:</b> Do only upload zip files which follow this scheme:<ul><li>Use valid ASCII only [A-Za-z0-9_-] w/o whitespaces</li><li>Lowercased directory names (recommended)</li><li>No duplicate file names in recursive directories</li><li>Images need a valid File.extension</li></ul>Also the ZIP file name itself has to match this scheme. Else, the Zip deflation is either terminated, or leads to errors and/or unexpected behaviours, breaking the MediaLibrary.');

