<?php

/**
 *  @version
 *  @author Translator Name <yourmail@example.com>
 *  EN-Revision: Revision of lang_en.inc.php
 */

@define('PLUGIN_SIDEBAR_IMAGESIDEBAR_NAME', 'Unified Sidebar Image Display');
@define('PLUGIN_SIDEBAR_IMAGESIDEBAR_DESC', 'Offers the ability to display images in the sidebar. The source of the images is configurable. The plugin is able to access a Coppermine database directory (MySQL only), or access images in the Serendipity Media Library.');

@define('PLUGIN_SIDEBAR_IMAGESIDEBAR_DISPLAYSRC_NAME', 'Image Source');
@define('PLUGIN_SIDEBAR_IMAGESIDEBAR_DISPLAYSRC_DESC', 'Please choose a source for your images from the drop down.');
@define('PLUGIN_SIDEBAR_IMAGESIDEBAR_DISPLAYSRC_NONE', 'No selection made');
@define('PLUGIN_SIDEBAR_IMAGESIDEBAR_DISPLAYSRC_COPPERMINE', 'Coppermine Database');
@define('PLUGIN_SIDEBAR_IMAGESIDEBAR_DISPLAYSRC_MEDIALIB', 'Media Library');

@define('PLUGIN_CPGS_NAME', 'Coppermine Thumbnails');
@define('PLUGIN_CPGS_DESC', 'Display thumbnails from a Coppermine gallery in the sidebar');
@define('PLUGIN_CPGS_SERVER_NAME', 'Server');
@define('PLUGIN_CPGS_SERVER_DESC', 'SQL server');
@define('PLUGIN_CPGS_DB_NAME', 'Database');
@define('PLUGIN_CPGS_DB_DESC', 'SQL database');
@define('PLUGIN_CPGS_PREFIX_NAME', 'Prefix');
@define('PLUGIN_CPGS_PREFIX_DESC', 'Database table prefix');
@define('PLUGIN_CPGS_USER_NAME', 'Username');
@define('PLUGIN_CPGS_USER_DESC', 'Database user name');
@define('PLUGIN_CPGS_PASSWORD_NAME', 'Password');
@define('PLUGIN_CPGS_PASSWORD_DESC', 'Database password');
@define('PLUGIN_CPGS_URL_NAME', 'URL');
@define('PLUGIN_CPGS_URL_DESC', 'Gallery URL');
@define('PLUGIN_CPGS_TYPE_NAME', 'Type');
@define('PLUGIN_CPGS_TYPE_DESC', 'Which images to display');
@define('PLUGIN_CPGS_TITLE_NAME', 'Title');
@define('PLUGIN_CPGS_TITLE_DESC', 'Sidebar item title');
@define('PLUGIN_CPGS_ALBUM_NAME', 'Album Link');
@define('PLUGIN_CPGS_ALBUM_DESC', 'Include a link to the pictures album below the thumbnail');
@define('PLUGIN_CPGS_GALLLINK_NAME', 'Gallery Link URL');
@define('PLUGIN_CPGS_GALLLINK_DESC', 'URL for the link below the thumbnails (empty for no link)');
@define('PLUGIN_CPGS_GALLNAME_NAME', 'Gallery Name');
@define('PLUGIN_CPGS_GALLNAME_DESC', 'Text for the gallery link');
@define('PLUGIN_CPGS_COUNT_NAME', 'Thumbnails');
@define('PLUGIN_CPGS_COUNT_DESC', 'Number of thumbnails to display');
@define('PLUGIN_CPGS_SIZE_NAME', 'Size');
@define('PLUGIN_CPGS_SIZE_DESC', 'Maximum thumbnail size');
@define('PLUGIN_CPGS_THUMB_NAME', 'Resolve Non-Images');
@define('PLUGIN_CPGS_THUMB_DESC', 'Attempt to find a Coppermine default thumbnail for non-images (e.g. videos)');
@define('PLUGIN_CPGS_FILTER_NAME', 'Album Filter');
@define('PLUGIN_CPGS_FILTER_DESC', 'Album id filter');
@define('PLUGIN_CPGS_RECENT', 'Most Recent');
@define('PLUGIN_CPGS_POPULAR', 'Most Viewed');
@define('PLUGIN_CPGS_RANDOM', 'Random Images');

@define('PLUGIN_SIDEBAR_MEDIASIDEBAR_NAME', 'Media library sidebar display');
@define('PLUGIN_SIDEBAR_MEDIASIDEBAR_DESC', 'Display a random image from the Media library in the sidebar. (Note, it does not distinguish images from other file types)');
@define('PLUGIN_SIDEBAR_MEDIASIDEBAR_DIRECTORY_NAME', 'Pick a default directory');
@define('PLUGIN_SIDEBAR_MEDIASIDEBAR_DIRECTORY_DESC', 'Pick the default directory you would like the plugin to be restricted to');
@define('PLUGIN_SIDEBAR_MEDIASIDEBAR_NOSUBDIRS_NAME', 'Do not include subdirectories');
@define('PLUGIN_SIDEBAR_MEDIASIDEBAR_NOSUBDIRS_DESC', 'If set to "yes" the plugin will only fetch from and display pictures in the current directory. If set to "no" the plugin will fetch from and output any pictures of all subdirectories. Keep in mind: The more to fetch, the longer it takes!');
@define('PLUGIN_SIDEBAR_MEDIASIDEBAR_LINKBEHAVIOR_NAME', 'Behavior of image link');
@define('PLUGIN_SIDEBAR_MEDIASIDEBAR_LINKBEHAVIOR_DESC', '"In Page" links to the image. "Pop Up" will open the image in a new, sized window. "URL" allows you to define a specific, static URL as the destination. "Gallery" will link the image to the permalink view of the usergallery plugin (if installed). "None" will be just the image.');
@define('PLUGIN_SIDEBAR_MEDIASIDEBAR_LINKBEHAVIOR_INPAGE', 'In Page');
@define('PLUGIN_SIDEBAR_MEDIASIDEBAR_LINKBEHAVIOR_POPUP', 'Pop Up');
@define('PLUGIN_SIDEBAR_MEDIASIDEBAR_LINKBEHAVIOR_URL', 'URL');
@define('PLUGIN_SIDEBAR_MEDIASIDEBAR_LINKBEHAVIOR_GALLERY', 'Gallery');
@define('PLUGIN_SIDEBAR_MEDIASIDEBAR_LINKBEHAVIOR_ENTRY', 'Try to link to related entry');
@define('PLUGIN_SIDEBAR_MEDIASIDEBAR_GAL_STYLES', 'Set #mediasidebar behaviour styles');
@define('PLUGIN_SIDEBAR_MEDIASIDEBAR_GAL_STYLES_DESC', 'This depends on how your current theme styles are defined. "Compat" sets a checked (fallback) minimum default for img styling only; "Yes" writes them for both, link and img elements; "No" disables any plugin added styles. For full compatibility reasons we have to use "yes" as the default here. Check out the source code in the sidebar to see them defined and for which parts your theme needs support. But better(!) do all of this in your themes (user.css) file. Before, check if your theme style.css does not already support it. As a simplified example use:
#mediasidebar .mediasidebar_link {
    display: inline-table;
    text-decoration: none transparent;
    color: transparent;
    border: 0 none;
}
#mediasidebar .mediasidebaritem img {
    border: 0 none;
    width: 200px;
}
');

@define('PLUGIN_SIDEBAR_MEDIASIDEBAR_WIDTH_NAME', 'Image width');
@define('PLUGIN_SIDEBAR_MEDIASIDEBAR_WIDTH_DESC', 'Set a fixed maximum display image width. If the width is set to "0" the plugin will either output "width:100%" or images of any size, scaled by your themes sidebars container styles.');
@define('PLUGIN_SIDEBAR_MEDIASIDEBAR_DIMENSION_RANGE_NAME', 'Select a min/max fetch dimension range');
@define('PLUGIN_SIDEBAR_MEDIASIDEBAR_DIMENSION_RANGE_DESC', 'This value is taken to filter select image-width dimension ranges from "x" (minimum) to "y" (maximum) in pixels, which reduces the full selected database fetch and helps to not display images of too small sizes. Write as comma separated integer values, eg. "240,2400". Set to "0,0" for no filters.');
@define('PLUGIN_SIDEBAR_MEDIASIDEBAR_URL_NAME', 'Enter URL');
@define('PLUGIN_SIDEBAR_MEDIASIDEBAR_URL_DESC', 'Enter the static URL you would like to link to. (example: \'https://www.example.org/\')');
@define('PLUGIN_SIDEBAR_MEDIASIDEBAR_GALPERM_NAME', 'Enter the permalink or subpage');
@define('PLUGIN_SIDEBAR_MEDIASIDEBAR_GALPERM_DESC', 'This value should match the value set in the gallery plugin. Note, if URL rewriting is turned off you must use the subpage.');
@define('PLUGIN_SIDEBAR_MEDIASIDEBAR_INTRO', 'Text (or html) you would like placed before the picture');
@define('PLUGIN_SIDEBAR_MEDIASIDEBAR_SUMMERY', 'Any text (or html) you would like appended to the picture');
@define('PLUGIN_SIDEBAR_MEDIASIDEBAR_ROTATETIME_NAME', 'Rotate image time');
@define('PLUGIN_SIDEBAR_MEDIASIDEBAR_ROTATETIME_DESC', 'How often would you like the image(s) to rotate, in minutes, from the hour. If set to "0" the image(s) will rotate on every refresh.');
@define('PLUGIN_SIDEBAR_MEDIASIDEBAR_NUMIMAGES_NAME', 'Number of images to display');
@define('PLUGIN_SIDEBAR_MEDIASIDEBAR_NUMIMAGES_DESC', 'Enter the number of images you would like to display.');
@define('PLUGIN_SIDEBAR_MEDIASIDEBAR_HOTLINKS_NAME', 'Limit output to only hotlinked images');
@define('PLUGIN_SIDEBAR_MEDIASIDEBAR_HOTLINKS_DESC', 'This option limits the sidebar output to only images which are hotlinks in the Media Library.');
@define('PLUGIN_SIDEBAR_MEDIASIDEBAR_HOTLINKBASE_NAME', 'Hotlink limiting keyword');
@define('PLUGIN_SIDEBAR_MEDIASIDEBAR_HOTLINKBASE_DESC', 'This option takes a single keyword (no spaces) and limits the output to anything containing that word. For example, if you have hotlinks from a variety of sources, but only want to display those from a single host you could put "host.com" in this field.');

@define('PLUGIN_CPGS_GROUP_NAME', 'Usergroup');
@define('PLUGIN_CPGS_GROUP_DESC', 'Coppermine allows to define visibility of images restricted to certain usergroups. If you want this plugin to only fetch specific images, enter the usergroup this plugin shall act as in this field. "Everybody" means that all group permissions are ignored.');

@define('PLUGIN_SIDEBAR_MEDIASIDEBAR_LIGHTBOX_NAME', 'Use with installed Lightbox plugin');
@define('PLUGIN_SIDEBAR_MEDIASIDEBAR_LIGHTBOX_DESC', 'Please insert a html attribute, eg. <rel="lightbox"> for single, or <rel="lightbox[]"> for grouped lightbox views (both without <>) for lightbox usage with the lightbox event plugin. This will be included to the image anchor. It works for "Media Library" with select option "Behavior of image link" : "In Page" only. Use with care.');

