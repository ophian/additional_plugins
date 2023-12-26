<?php

/**
 *  @version
 *  @author Translator Name <yourmail@example.com>
 *  EN-Revision: Revision of lang_en.inc.php
 */

//
//  serendipity_event_freetag.php
//
@define('PLUGIN_EVENT_FREETAG_TITLE', 'Tagging of entries');
@define('PLUGIN_EVENT_FREETAG_DESC', 'Allows freestyle tagging of entries');
@define('PLUGIN_EVENT_FREETAG_ENTERDESC', 'Enter any tags that apply. Separate multiple tags with a comma (,)');
@define('PLUGIN_EVENT_FREETAG_LIST', 'Defined tags for this entry: %s');
@define('PLUGIN_EVENT_FREETAG_USING', 'Entries tagged as: <span class="freetag_current">%s</span>');
@define('PLUGIN_EVENT_FREETAG_SUBTAG', 'Tags related to tag: %s');
@define('PLUGIN_EVENT_FREETAG_NO_RELATED', 'No related tags.');
@define('PLUGIN_EVENT_FREETAG_ALLTAGS', 'All defined tags');
@define('PLUGIN_EVENT_FREETAG_MANAGETAGS', 'Manage tags');
@define('PLUGIN_EVENT_FREETAG_MANAGE_ALL', 'Manage all tags');
@define('PLUGIN_EVENT_FREETAG_MANAGE_LEAF', 'Manage \'leaf\' tags');
@define('PLUGIN_EVENT_FREETAG_MANAGE_UNTAGGED', 'List untagged entries');
@define('PLUGIN_EVENT_FREETAG_MANAGE_LEAFTAGGED', 'List \'leaf\' tagged entries');
@define('PLUGIN_EVENT_FREETAG_MANAGE_CLEANUP', 'Cleanup entry-to-tag mappings');
@define('PLUGIN_EVENT_FREETAG_MANAGE_CLEANUP_INFO', 'The following list contains tags non-existent entries are assigned to. Please click on &quot;Cleanup&quot; to remove these unnecessary assignments.');
@define('PLUGIN_EVENT_FREETAG_MANAGE_CLEANUP_NOTHING', 'No Tags assigned to non-existent entries could be found. Therefor there is nothing to clean up.');
@define('PLUGIN_EVENT_FREETAG_MANAGE_CLEANUP_LOOKUP_ERROR', 'Tags assigned to non-existent entries could be found, because an error occurred.');
@define('PLUGIN_EVENT_FREETAG_MANAGE_CLEANUP_PERFORM', 'Cleanup');
@define('PLUGIN_EVENT_FREETAG_MANAGE_CLEANUP_ENTRIES', 'IDs of affected entries');
@define('PLUGIN_EVENT_FREETAG_MANAGE_CLEANUP_SUCCESSFUL', 'All unnecessary assignments have successfully been removed.');
@define('PLUGIN_EVENT_FREETAG_MANAGE_CLEANUP_FAILED', 'Removing unnecessary assignments failed.');
@define('PLUGIN_EVENT_FREETAG_MANAGE_UNTAGGED_NONE', 'No Untagged entries!');
@define('PLUGIN_EVENT_FREETAG_MANAGE_LIST_TAG', 'Tag');
@define('PLUGIN_EVENT_FREETAG_MANAGE_LIST_WEIGHT', 'Weight');
@define('PLUGIN_EVENT_FREETAG_MANAGE_LIST_ACTIONS', 'Action');
@define('PLUGIN_EVENT_FREETAG_MANAGE_ACTION_RENAME', 'Rename');
@define('PLUGIN_EVENT_FREETAG_MANAGE_ACTION_SPLIT', 'Split');
@define('PLUGIN_EVENT_FREETAG_MANAGE_ACTION_DELETE', 'Delete');
@define('PLUGIN_EVENT_FREETAG_MANAGE_CONFIRM_DELETE', 'Do you really want to delete the "%s" tag?');
@define('PLUGIN_EVENT_FREETAG_MANAGE_INFO_SPLIT', 'use a comma to separate tags:');
@define('PLUGIN_EVENT_FREETAG_SHOW_TAGCLOUD', 'Show tag cloud to related tags?');
@define('PLUGIN_EVENT_FREETAG_SEND_HTTP_HEADER', 'Send X-FreeTag-HTTP-Headers');
@define('PLUGIN_EVENT_FREETAG_ADMIN_TAGLIST', 'Show clickable list of all tags when writing an entry');
@define('PLUGIN_EVENT_FREETAG_ADMIN_FTAYT', 'Activate Find-tags-as-you-type');

//
//  serendipity_plugin_freetag.php
//
@define('PLUGIN_FREETAG_NAME', 'Show tagged entries');
@define('PLUGIN_FREETAG_BLAHBLAH', 'Shows a list of existing tags for entries');
@define('PLUGIN_FREETAG_NEWLINE', 'Linefeed after each Tag?');
@define('PLUGIN_FREETAG_XML', 'Show XML-icons?');
@define('PLUGIN_FREETAG_SCALE', 'Scale font size of tags by frequency?');
@define('PLUGIN_FREETAG_UPGRADE1_2', 'Upgrading %d tags for entry number: %d');
@define('PLUGIN_FREETAG_MAX_TAGS', 'How many tags should be shown?');
@define('PLUGIN_FREETAG_TRESHOLD_TAG_COUNT', 'Minimum usage of a tag for display');

//
// later on additions
//
@define('PLUGIN_EVENT_FREETAG_TAGCLOUD_MIN', 'Minimum font size % of tag in this tag cloud');
@define('PLUGIN_EVENT_FREETAG_TAGCLOUD_MAX', 'Maximum font size % of tag in this tag cloud');

@define('PLUGIN_FREETAG_META_KEYWORDS', 'Number of meta keywords to embed in HTML source (0: disabled)');

@define('PLUGIN_EVENT_FREETAG_TEMPLATE', 'Sidebar template (see default theme)');
@define('PLUGIN_EVENT_FREETAG_TEMPLATE_DESCRIPTION', 'If set, but not the named "plugin_freetag.tpl" file, which already is used in other places, it will be used to render the tag sidebar. In the template there is a variable <tags> available, which contains the list of tags in the format <tagName> => array(href => <tagLink>, count => <tagCount>). See "plugin_freetag_sidebar.tpl" in default theme as a very simple copy file.');

@define('PLUGIN_EVENT_FREETAG_RELATED_ENTRIES', 'Related entries by tags:');
@define('PLUGIN_EVENT_FREETAG_SHOW_RELATED', 'Display related entries by tags?');
@define('PLUGIN_EVENT_FREETAG_SHOW_RELATED_COUNT', 'How many related entries should be displayed?');
@define('PLUGIN_EVENT_FREETAG_EMBED_FOOTER', 'Show tags in footer?');
@define('PLUGIN_EVENT_FREETAG_EMBED_FOOTER_DESC', 'If enabled, the tags will be shown in the footer of an entry. If disabled, the tags will be put inside the body/extended part of your entries.');
@define('PLUGIN_EVENT_FREETAG_LOWERCASE_TAGS', 'Lowercase tags');

@define('PLUGIN_EVENT_FREETAG_RELATED_TAGS', 'Related tags');
@define('PLUGIN_EVENT_FREETAG_TAGLINK', 'Taglink');
@define('PLUGIN_EVENT_FREETAG_CAT2TAG', 'Create tags for all associated categories?');
@define('PLUGIN_EVENT_FREETAG_CAT2TAG_DESC', 'If enabled, all categories that an entry is assigned to will be added as tags to your entry. You can set all category associations of all your existing entries within the "Manage Tags" menu of your Administration Suite.');
@define('PLUGIN_EVENT_FREETAG_KEYWORD2TAG', 'Create tags from automated keywords?');
@define('PLUGIN_EVENT_FREETAG_KEYWORD2TAG_DESC', 'If enabled, the entry will be checked if it contains any of the automated keywords and the corresponding tags will be added. You can set the keywords within the "Manage Tags" menu of your Administration Suite.');
@define('PLUGIN_EVENT_FREETAG_GLOBALLINKS', 'Convert all assigned categories of existing entries to tags');
@define('PLUGIN_EVENT_FREETAG_GLOBALCAT2TAG_ENTRY', 'Converted categories of entry #%d (%s): %s.');
@define('PLUGIN_EVENT_FREETAG_GLOBALCAT2TAG', 'All categories converted to tags.');

@define('PLUGIN_EVENT_FREETAG_KEYWORDS', 'Automated keywords');
@define('PLUGIN_EVENT_FREETAG_KEYWORDS_DESC', 'You can assign keywords (separated by ",") for each existing tag. Whenever you use those keywords in the text of your entries, the corresponding tag is assigned to your entry. Note that many automated keywords may increase the time taken for saving an entry.');
@define('PLUGIN_EVENT_FREETAG_KEYWORDS_ADD', 'Found keyword <strong>%s</strong>, tag <strong><em>%s</em></strong> assigned automatically.');

@define('PLUGIN_EVENT_FREETAG_REBUILD_FETCHNO', 'Fetching entries %d to %d');
@define('PLUGIN_EVENT_FREETAG_REBUILD_TOTAL', ' (totaling %d entries)...');
@define('PLUGIN_EVENT_FREETAG_REBUILD_FETCHNEXT', 'Fetching next batch of entries...');
@define('PLUGIN_EVENT_FREETAG_REBUILD', 'Re-parse all automated keywords');
@define('PLUGIN_EVENT_FREETAG_REBUILD_DESC', 'Warning: This function will fetch and re-save every single one of your entries. This will take some time, and it might even damage existing articles. It is suggested you first backup your database! Click on "CANCEL" to abort this action.');

@define('PLUGIN_EVENT_FREETAG_ORDER_TAGNAME', 'Tag name');
@define('PLUGIN_EVENT_FREETAG_ORDER_TAGCOUNT', 'Tag count');

@define('PLUGIN_EVENT_FREETAG_XMLIMAGE', 'XML image relative to template path');

@define('PLUGIN_EVENT_FREETAG_EMBED_FOOTER_DESC2', 'If set to "Smarty", then a Smarty variable {$entry.freetag} will be created that you can place anywhere in your entries.tpl template file.');

@define('PLUGIN_EVENT_FREETAG_EXTENDED_SMARTY', 'Extended Smarty');
@define('PLUGIN_EVENT_FREETAG_EXTENDED_SMARTY_DESC', 'Emit separate Smarty-variables for later use in a template. This will override the other settings. An example for later use can be found in the Readme.');

@define('PLUGIN_EVENT_FREETAG_COLLATION', '(MySQL) Database collation for the entrytags.tag column (auto-detected)');
@define('PLUGIN_EVENT_FREETAG_KILL', 'When checked, all assigned tags to this entry will be removed.');

@define('PLUGIN_EVENT_FREETAG_TAGLINK_DESC', 'A possible change in your taglink, is to write "plugin/taglist/" instead of "plugin/tag/". This will make your tag(s) appear as as clickable list, instead of already opened entries. You can also add this manually to certain taglinks in the frontend or append a "/taglist" tag to an already existing path (eg "/plugin/tag/your/tags/append/taglist"). In both cases "taglist" is a reserved word from now on and can not be used as a normal tag elsewhere anymore. If you want to use this, please enable the "tags-as-list (non-opened entries)" option and add some code manually, described in the documentary for the "tag-as-list" option.');

@define('PLUGIN_EVENT_FREETAG_TAGSASLIST', 'Enable "tags-as-list" (non-opened entries)');
@define('PLUGIN_EVENT_FREETAG_TAGSASLIST_DESC', 'Please read the documentary in this plugins "Local Documentation" on how to add the Smarty taglist code to your existing templates entries.tpl file.');

@define('PLUGIN_EVENT_FREETAG_SORTTAGSBYCOUNT', 'Sort Multi-Tags entries result');
@define('PLUGIN_EVENT_FREETAG_SORTTAGSBYCOUNT_DESC', 'URL Multi-Tags are normally sorted by entry date. This Option sorts shown entries by taglist count, which shows the entries with the most tags in list first, in descending order.');

@define('FREETAG_CONFIGGROUP_CONFIG', 'Configuration Preferences');
@define('FREETAG_CONFIGGROUP_CONFIG_DESC', 'Backend and general configurations:');
@define('FREETAG_CONFIGGROUP_CLOUD', 'Frontend Cloud Preferences');
@define('FREETAG_CONFIGGROUP_CLOUD_DESC', 'Tag-Cloud related configurations:');
@define('FREETAG_CONFIGGROUP_ENTRYPAGE', 'Frontend Entry Page Preferences');
@define('FREETAG_CONFIGGROUP_ENTRYPAGE_DESC', 'Frontend entry page configurations:');

@define('PLUGIN_EVENT_FREETAG_MANAGE_LEAFTAGS_NONE', 'No \'Leaf\' tag entries!');

@define('PLUGIN_EVENT_FREETAG_LOWERCASE_TAGS_DESC', 'Storage and Backend-Tags live like applied. To lowercase applies only for shown Frontend-Tags.');

@define('PLUGIN_EVENT_FREETAG_USE_CAROC', 'Use a modern Canvas rotating cloud?');
@define('PLUGIN_EVENT_FREETAG_USE_CAROC_DESC', 'A rotating JavaScript canvas cloud in %s! (Limited in use, since it needs more or less "squared" environments.)');
@define('PLUGIN_EVENT_FREETAG_CAROC_TAG_COLOR', 'Rotating Canvas-Cloud tag color (rrggbb)');
@define('PLUGIN_EVENT_FREETAG_CAROC_TAG_COLOR_DESC', 'Carefully select the two colors. For the "pure" and "B53+" themes, they are automatically exchanged for the text color in "dark" theme mode, so that light text is formed on a dark background and dark text on a light background.');
@define('PLUGIN_EVENT_FREETAG_CAROC_TAG_BORDER_COLOR', 'Rotating Canvas-Cloud tag border color (rrggbb)');
@define('PLUGIN_EVENT_FREETAG_CAROC_BOXWIDTH', 'Rotating Canvas-Cloud width');

@define('PLUGIN_EVENT_FREETAG_USE_CAWOC', 'Use a modern Canvas 2D word cloud?');
@define('PLUGIN_EVENT_FREETAG_USE_CAWOC_DESC', 'A state-of-the-Art "wordle" like awesome 2D-tagword canvas cloud in %s!');

@define('PLUGIN_EVENT_FREETAG_USE_CANVAS_PLUGIN_SPRINT', 'sidebars and archives');
@define('PLUGIN_EVENT_FREETAG_USE_CANVAS_EVENT_SPRINT', 'related tags');

@define('PLUGIN_FREETAG_CONFIGGROUP_CONFIG', 'Sidebar and general configurations:');

@define('PLUGIN_FREETAG_USE_CANVAS_SCRIPTS_DESC', 'For including the canvas scripts, "show_tagcloud" needs to be enabled in event plugin too!');

@define('PLUGIN_EVENT_FREETAG_SET_OPTION_ERROR_1', '<strong>Set option Error[1]:</strong> You may only use one cloud by time. All clouds were internally set false again. Please set and submit again here! (The form still shows what you had chosen before!)</p>');

@define('PLUGIN_EVENT_FREETAG_ADMIN_DELIMITER', 'Allow alphabetical index tag-list delimiter?');

@define('PLUGIN_EVENT_FREETAG_SORT_DESC_FOR_TOTAL', 'With "order by count", sort descending');

@define('PLUGIN_EVENT_FREETAG_ALLOW_JQUERYLIB', 'Use plugin jQuery lib');
@define('PLUGIN_EVENT_FREETAG_ALLOW_JQUERYLIB_DESC', 'Enable only, if your theme does not already load the jquery.js library in its page header or footer.');

