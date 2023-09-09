<?php

/**
 * @version 
 * @author Translator Name <yourmail@example.com>
 * EN-Revision: Revision of lang_en.inc.php
 */

//
// serendipity_event_staticpage.php
//
@define('STATICPAGE_LIST_EXISTING_PAGES', 'List of existing static pages');
@define('STATICPAGE_HEADLINE', 'Headline');
@define('STATICPAGE_HEADLINE_BLAHBLAH', 'Shows a headline above the content which is rendered as every other headline in your blog');
@define('STATICPAGE_TITLE', 'Static Pages');
@define('STATICPAGE_TITLE_BLAHBLAH', 'Shows static pages inside your blog with your blogs design and all formatting. Adds a new menu item to the admin interface.');
@define('CONTENT_BLAHBLAH', 'the content');
@define('STATICPAGE_PERMALINK', 'Permalink');
@define('STATICPAGE_PERMALINK_BLAHBLAH', 'Defines a permalink for the URL. Needs the absolute HTTP path and needs to end with .htm or .html!');
@define('STATICPAGE_PAGETITLE', 'URL shorthand name (Backwards compatibility)');
@define('STATICPAGE_ARTICLEFORMAT', 'Format as article?');
@define('STATICPAGE_ARTICLEFORMAT_BLAHBLAH', 'if yes the output is automatically formatted as an article (colors, borders, etc.) (default: yes)');
@define('STATICPAGE_ARTICLEFORMAT_PAGETITLE', 'Page title in "Format as article" mode');
@define('STATICPAGE_ARTICLEFORMAT_PAGETITLE_BLAHBLAH', 'Using article format, you can choose which text to display where the blog DATE shows up for an article.');
@define('STATICPAGE_SELECT', 'Select a staticpage to edit or create.');
@define('STATICPAGE_PASSWORD_NOTICE', 'This page is password protected. Please enter the appropriate password given to you: ');
@define('STATICPAGE_PARENTPAGES_NAME', 'Parent page');
@define('STATICPAGE_PARENTPAGE_DESC', 'Select the Parent-Page');
@define('STATICPAGE_PARENTPAGE_PARENT', 'Is parent');
@define('STATICPAGE_AUTHORS_NAME', 'Author\'s Name');
@define('STATICPAGE_AUTHORS_DESC', 'This author is the owner of this page');
@define('STATICPAGE_FILENAME_NAME', 'Template (Smarty)');
@define('STATICPAGE_FILENAME_DESC', 'Enter the filename of the template which should be used for this page. That Smarty file can be placed in this plugin\'s directory or into your template directory.');
@define('STATICPAGE_SHOWCHILDPAGES_NAME', 'Show childpages');
@define('STATICPAGE_SHOWCHILDPAGES_DESC', 'Show all childpages of current page as linklist.');
@define('STATICPAGE_PRECONTENT_NAME', 'Pre-content');
@define('STATICPAGE_PRECONTENT_DESC', 'Show this content before list of childpages.');
@define('STATICPAGE_CANNOTDELETE_MSG', 'Can\'t delete this page. Childpages are in the database. Please delete them first.');
@define('STATICPAGE_IS_STARTPAGE', 'Make this page the frontpage of Serendipity');
@define('STATICPAGE_IS_STARTPAGE_DESC', 'Instead of showing the default Serendipity startpage, this static page will show up. Only define one page as frontpage! If you want to link to your usual Serendipity Frontpage, you need to use "index.php?frontpage". If you want to use this feature, you need to make sure that no other permalink-plugin (like voting, guestbook) are placed before the staticpage plugin in the Serendipity Plugin Configuration Event Queue.');
@define('STATICPAGE_IS_404_PAGE', 'Set this page as 404 error page');
@define('STATICPAGE_IS_404_PAGE_DESC', 'Instead of creating a special error document you can set this page as 404 error page. Your webserver also must be configured to use this!');
@define('STATICPAGE_TOP', 'TOP');
@define('STATICPAGE_NEXT', 'Next');
@define('STATICPAGE_PREV', 'Prev');
@define('STATICPAGE_LINKNAME', 'Edit');

@define('STATICPAGE_ARTICLETYPE', 'Article type');
@define('STATICPAGE_ARTICLETYPE_DESC', 'Select the type of this staticpage.');

@define('STATICPAGE_CATEGORY_PAGEORDER', 'Page order');
@define('STATICPAGE_CATEGORY_PAGES', 'Edit pages');
@define('STATICPAGE_CATEGORY_PAGETYPES', 'Page types');
@define('STATICPAGE_CATEGORY_PAGEADD', 'Other plugins');

@define('PAGETYPES_SELECT', 'Select a page type to select.');
@define('STATICPAGE_ARTICLETYPE_DESCRIPTION', 'Description:');
@define('STATICPAGE_ARTICLETYPE_DESCRIPTION_DESC', 'Describe the page type.');
@define('STATICPAGE_ARTICLETYPE_TEMPLATE', 'Template name:');
@define('STATICPAGE_ARTICLETYPE_TEMPLATE_DESC', 'The name from the template. It can be in the staticpage-plugin or in the default template-directory.');
@define('STATICPAGE_ARTICLETYPE_IMAGE', 'Image path:');
@define('STATICPAGE_ARTICLETYPE_IMAGE_DESC', 'The URL to the image.');

@define('STATICPAGE_USELMDATE_DEFAULT', 'Use last modified date in footer?');

@define('STATICPAGE_SHOWNAVI', 'Include navigation');
@define('STATICPAGE_SHOWNAVI_DESC', 'Show navigation within staticpages on this page.');
@define('STATICPAGE_SHOWONNAVI', 'Include in sidebar-navigation');
@define('STATICPAGE_SHOWONNAVI_DESC', 'Show this page on the list of static pages in your sidebar.');

@define('STATICPAGE_SHOWNAVI_DEFAULT', 'Include navigation');
@define('STATICPAGE_SHOWMETA_DEFAULT', 'Include HTML meta input fields');
@define('STATICPAGE_DEFAULT_DESC', 'Default setting for new pages.');
@define('STATICPAGE_SHOWONNAVI_DEFAULT', 'Show page on sidebar-navigation');
@define('STATICPAGE_SHOWMARKUP_DEFAULT', 'Show markup');
@define('STATICPAGE_SHOWARTICLEFORMAT_DEFAULT', 'Format like an article');
@define('STATICPAGE_SHOWCHILDPAGES_DEFAULT', 'Show childpages');

@define('STATICPAGE_PAGEORDER_DESC', 'Here you can change the order of static pages.');
@define('STATICPAGE_PAGEADD_DESC', 'Select the plugin you want to include as link in the staticpages navigation.');
@define('STATICPAGE_PAGEADD_PLUGINS', 'The following plugins can be included in the staticpage sidebar.');

@define('STATICPAGE_PUBLISHSTATUS', 'Publish-status');
@define('STATICPAGE_PUBLISHSTATUS_DESC', 'Publish-status of this page.');

@define('STATICPAGE_SHOWTEXTORHEADLINE_NAME', 'Show headline or Prev/Next on navigation');
@define('STATICPAGE_SHOWTEXTORHEADLINE_TEXT', 'Text: Prev/Next');
@define('STATICPAGE_SHOWTEXTORHEADLINE_HEADLINE', 'Headline');

@define('STATICPAGE_LANGUAGE', 'Language');
@define('STATICPAGE_LANGUAGE_DESC', 'Select the language of this page.');

@define('STATICPAGE_PLUGINS_INSTALLED', 'Plugin is installed');
@define('STATICPAGE_PLUGIN_AVAILABLE', 'Plugin is available, but not installed');
@define('STATICPAGE_PLUGIN_NOTAVAILABLE', 'Plugin is not available');

@define('STATICPAGE_SEARCHRESULTS', 'Found %d static pages:');

@define('LANG_ALL', 'All languages');

@define('STATICPAGE_STATUS', 'Status');

@define('STATICPAGES_CUSTOMEXAMPLE_OPTION_SHOW', 'Show CUSTOM options');
@define('STATICPAGES_CUSTOM_OPTION_SHOW', 'Show CONFIGURATION options');
@define('STATICPAGES_CUSTOM_STRUCTURE_SHOW', 'Show STRUCTURAL options');
@define('STATICPAGES_CUSTOM_META_SHOW', 'Show META FIELD options');
@define('STATICPAGES_CUSTOM_META_TITLE', 'HTML title element (optional)');
@define('STATICPAGES_CUSTOM_META_TITLE_BLAH_BLAH', 'Will be emitted as <title>Your title here</title>');
@define('STATICPAGES_CUSTOM_META_DESC', 'HTML META Description (optional)');
@define('STATICPAGES_CUSTOM_META_DESC_BLAH_BLAH', 'Will be emitted as <meta name="description" content="Your HTML meta description here">');
@define('STATICPAGES_CUSTOM_META_KEYS', 'HTML META Keywords (optional)');
@define('STATICPAGES_CUSTOM_META_KEYS_BLAH_BLAH', 'Will be emitted as <meta name="keywords" content="Your HTML meta keywords here">');

//
// serendipity_plugin_staticpage.php
//

@define('PLUGIN_STATICPAGELIST_NAME', 'Static Page List');
@define('PLUGIN_STATICPAGELIST_NAME_DESC', 'This plugin displays a configurable list of the static pages.');
@define('PLUGIN_STATICPAGELIST_TITLE', 'Title');
@define('PLUGIN_STATICPAGELIST_TITLE_DESC', 'Enter the sidebar title to display:');
@define('PLUGIN_STATICPAGELIST_TITLE_DEFAULT', 'Static Pages');
@define('PLUGIN_STATICPAGELIST_LIMIT', 'Number to Display');
@define('PLUGIN_STATICPAGELIST_LIMIT_DESC', 'Enter the number of Static Pages to Display. 0 means, no limit.');
@define('PLUGIN_STATICPAGELIST_FRONTPAGE_NAME', 'Link to frontpage');
@define('PLUGIN_STATICPAGELIST_FRONTPAGE_DESC', 'Create a link to the frontpage');
@define('PLUGIN_STATICPAGELIST_FRONTPAGE_LINKNAME', 'Frontpage');
@define('PLUGIN_LINKS_IMGDIR', 'Use plugin image directory');
@define('PLUGIN_LINKS_IMGDIR_BLAHBLAH', 'Tell the URL path to use for accessing the tree structure images. The "img" subfolder needs to be in this directory, and is delivered with this plugin.');
@define('PLUGIN_STATICPAGELIST_SHOWICONS_NAME', 'Icons or plain Text');
@define('PLUGIN_STATICPAGELIST_SHOWICONS_DESC', 'Show tree structure or plain Text-Menu');
@define('PLUGIN_STATICPAGELIST_ICON', 'JS Tree');
@define('PLUGIN_STATICPAGELIST_TEXT', 'Plain Text');
@define('PLUGIN_STATICPAGELIST_PARENTSONLY', 'Only show parent pages?');
@define('PLUGIN_STATICPAGELIST_PARENTSONLY_DESC', 'If enabled, only parent pages are shown. If disabled, childpages will also be shown.');
@define('PLUGIN_STATICPAGELIST_IMG_NAME', 'Enable graphics for tree structure');

@define('STATICPAGE_MEDIA_DIRECTORY_MOVE_ENTRIES', 'Changed the URL of the moved directory in %s static pages.');
#@define('STATICPAGE_MEDIA_DIRECTORY_MOVE_ENTRY', 'On Non-MySQL databases, iterating through every static page to replace the old directory URLs with new directory URLs is not possible. You will need to manually edit your static pages to fix new URLs. You can still move your old directory back to where it was, if that is too cumbersome for you.');

@define('STATICPAGE_QUICKSEARCH_DESC', 'If enabled, quicksearch results will also display hits on static pages');

@define('STATICPAGE_CATEGORYPAGE','related static-page');
@define('STATICPAGE_RELATED_CATEGORY', 'related category');
@define('STATICPAGE_RELATED_CATEGORY_DESCRIPTION', 'Fetch entries from this category and display this or a link to the category on the staticpage. Use the template "plugin_staticpage_related_category.tpl" for this feature.');

@define('STATICPAGE_ARTICLE_OVERVIEW','article overview');
@define('STATICPAGE_NEW_HEADLINES','newest headlines:');

@define('STATICPAGE_TEMPLATE','Backend template');
@define('STATICPAGE_TEMPLATE_EXTERNAL', 'Default Template');

@define('STATICPAGE_SECTION_META', 'HTML Metadata');// As container title only in old default form template
@define('STATICPAGE_SECTION_BASIC', 'Basic Content');
@define('STATICPAGE_SECTION_OPT', 'Options');
@define('STATICPAGE_SECTION_STRUCT', 'Structural');

@define('PLUGIN_STATICPAGELIST_SMARTIFY', 'Smartify Sidebar list');
@define('PLUGIN_STATICPAGELIST_SMARTIFY_BLAHBLAH', 'Use Smarty template file: "plugin_staticpage_sidebar.tpl" for sidebar output (allows to truncate length via Smarty).');

@define('PLUGIN_STATICPAGE_PREVIEW', 'The preview of your static page has been opened in a new browser tab. Else click this: %s.'); // appears as "Else click this: link"

@define('STATICPAGE_SHOW_BREADCRUMB_DEFAULT', 'Show breadcrumb');
@define('STATICPAGE_SHOW_BREADCRUMB', 'Show breadcrumb');
@define('STATICPAGE_SHOW_BREADCRUMB_DESC', 'Show breadcrumb navigation on this page.');

@define('STATICPAGE_SHOWLIST_DEFAULT', 'Show as entry list');
@define('STATICPAGE_SHOWLIST_DESC', 'Show staticpage backend startpage as entry list or select box.');
@define('STATICPAGE_SHOWLIST_NUMLIST', 'Page entrylist by "N" (6) entries');

@define('STATICPAGE_CONFIRM_SELECTDIALOG', "Are you sure to have saved your changed entry and want to switch the current page?\\n\\nIf you press OK, the page will change to new content!"); // js confirm needs an additional backslash before the linebreaks!

@define('STATICPAGE_TREE_CHILD', 'Child of');

@define('STATICPAGE_TOGGLEANDSAVE', '%s and remember!');

@define('CREATED_ON', 'Created on');

@define('RELATED_CATEGORY_CHANGE_MSG', 'This has overwritten a previous related-category-association of staticpage ID #%s, with ID #%s, since only unique associations are allowed. Please check both static pages in the staticpage entryform to confirm to these changes within the selected "related category" field.');
@define('RELATED_CATEGORY_CHANGE_DEL_MSG', 'The corresponding related_category_id field of staticpage ID #%s has been updated and set to 0.');

@define('PLAIN_ASCII', 'URLs shall use plain ASCII only. [A-Za-z0-9]');
@define('STATICPAGE_RELCAT_INFO', 'This <b>only</b> works in combination with the entries.tpl patch, described in the "README FOR RELATED CATEGORIES.txt" <a href="%s" target="_blank" rel="noopener" style="color:#7fdbff">file</a>.
                        For a frontend category page, with an amount<span style="font-size:10px"><sup> (1)</sup></span> of last entry links as a teaser,
                        the best use is a set Articletype: "<em>Staticpage with related category</em>" field in this form.
                        Please note, that only unique 1:1 relations between staticpages and categories are allowed.<br><br>
                        <span style="font-size:10px"><sup>(1)</sup></span> Changing the amount of shown teaser entry links is done in the "plugin staticpage related category.tpl" file by the configurable calling hook. Defaults to 5 entries.');
@define('STATICPAGE_CUSTOMFIELDS_INFO', '<p>This custom section vastly improves Serendipity\'s CMS-abilities and shows some examples for saving custom fields for static pages.
                    All custom fields need to be implemented through usual HTML form elements, and need to save their values inside a serendipity[plugin][custom][XXX] fieldname.
                    Once entered, the data will be automatically saved inside the serendipity_staticpage_custom database table, and will be available through &#123;$staticpage_custom.XXX&#125;
                    when later being displayed in the frontend. This way, you can easily add new custom fields for a staticpage, ie. to specify a custom header image for each staticpage. Sky\'s the limit!</p>
                    <p>These optional examples enable to use either a custom CSS-BODY-ID to render the page. Or you can specify, which sidebar you want to see when this staticpage is rendered.
                    Another nice example included here, is to define some related tags for this staticpage, to show a specific amount of entries including these tags, like the freetag plugin allows for normal blog entries.<br>
                    <span><strong>Please read:</strong> </span><a href="%s" target="_blank" rel="noopener" style="color:#7fdbff">the readme for custom fields</a> examples.</p>
                    <p>The "Disable nl2br markup parser" radio option is already used internally to automark staticpage entries on wysiwyg usage by submit, to not pass through the nl2br markup parser on show.</p>');

@define('STATICPAGE_CONFIGGROUP_FORM', 'Backend Form Preferences:');
@define('STATICPAGE_CONFIGGROUP_FRONTEND', 'Default Frontend Appearance:');
@define('STATICPAGE_CONFIGGROUP_BACKEND', 'Default Backend Appearance:');

@define('STATICPAGE_LANGUAGE_INFO', 'The Language field is meant in use for multilingual blogs (with the languagechooser "multilingual" sidebar plugin,
                    or simply when authors are logged in that have a different language set in their personal configuration).
                    Using the field, staticpage entries can be created that each have a specific translation and will show up only in the currently active language.
                    "All languages" means "in any case".');

@define('STATICPAGE_FORM_FAIL', 'Add new page failed! It requires at least a unique "' . STATICPAGE_PERMALINK . '" and "' . STATICPAGE_PAGETITLE . '" setting.');

