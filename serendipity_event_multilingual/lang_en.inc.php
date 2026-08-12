<?php

/**
 *  @version
 *  @author Translator Name <yourmail@example.com>
 *  EN-Revision: Revision of lang_en.inc.php
 */

//
//  serendipity_event_multilingual.php
//
@define('PLUGIN_EVENT_MULTILINGUAL_TITLE', 'Multilingual entries');
@define('PLUGIN_EVENT_MULTILINGUAL_DESC', 'Allows to create multiple language versions of an entry');
@define('PLUGIN_EVENT_MULTILINGUAL_NEEDTOSAVE', 'Your entry needs to be saved, before you can enter additional language versions. You can also save the entry as draft.');
@define('PLUGIN_EVENT_MULTILINGUAL_CURRENT', 'Choose language version to edit: ');
@define('PLUGIN_EVENT_MULTILINGUAL_SWITCH', 'Select language');
@define('PLUGIN_EVENT_MULTILINGUAL_COPY', 'Retain previous language contents');
@define('PLUGIN_EVENT_MULTILINGUAL_COPYDESC', 'Keep contents from previous language intact in the input box when working with new language version');
@define('PLUGIN_EVENT_MULTILINGUAL_TAGTITLE', 'Translation of the Blog banner title(s) (see Configuration)');
@define('PLUGIN_EVENT_MULTILINGUAL_TAGTITLE_DESC', 'Enables the use of {{!<lang>}}<text>{{--}} tag translations for Blog title and Blog description. Also used for non-tag mode translated multilingual entry_title(s).');
@define('PLUGIN_EVENT_MULTILINGUAL_TAGENTRIES', 'Tag translation of entries and entry titles');
@define('PLUGIN_EVENT_MULTILINGUAL_TAGENTRIES_DESC', 'Enable {{!<lang>}}<text>{{--}} tags for entries');
@define('PLUGIN_EVENT_MULTILINGUAL_TAGSIDEBAR', 'Tag translation of sidebar items');
@define('PLUGIN_EVENT_MULTILINGUAL_TAGSIDEBAR_DESC', 'Enable {{!<lang>}}<text>{{--}} tags for sidebar items');
@define('PLUGIN_EVENT_MULTILINGUAL_PLACE', 'Where to place entry links?');
@define('PLUGIN_EVENT_MULTILINGUAL_PLACE_ADDFOOTER', 'Footer of an entry');
@define('PLUGIN_EVENT_MULTILINGUAL_PLACE_ADDSPECIAL', '"multilingual_footer" for custom Smarty output');

@define('PLUGIN_EVENT_MULTILINGUAL_LANGSWITCH', 'Force full language switch?');
@define('PLUGIN_EVENT_MULTILINGUAL_LANGSWITCH_DESC', 'Choosing a translation for a blog entry will also switch the whole language of the blog?');

@define('PLUGIN_EVENT_MULTILINGUAL_ENTRY_RELOADED', 'Multilingual entry language &lsaquo; %s &rsaquo; reloaded');

@define('PLUGIN_EVENT_MULTILINGUAL_LANGIFIED', 'Use national language names?');
@define('PLUGIN_EVENT_MULTILINGUAL_LANGIFIED_DESC', 'Default: in English. Pertains linknames of multilingual entry metadata.');

@define('PLUGIN_EVENT_MULTILINGUAL_EXAMPLE_READMEHINT', 'Please carefully read the plugin documentation using above link!');

@define('PLUGIN_EVENT_MULTILINGUAL_PURGE_ML_ENTRY', 'Check, to delete an existing multilingual Entry via entryform submit');
@define('PLUGIN_EVENT_MULTILINGUAL_PURGE_INFO_DESC', '<em>You came along, that this additional selection push can be used to create and manage a blog entry multilingually.</em>
   <p><strong><u>Recap</u>:</strong> To do this, write a blog entry in the actual blog language (example) "English" and save it as usual. When you call it again from
   the database, the entryproperties event plugin now provides an additional option in the <b>Advanced Options</b>, with which you
   can select or create a language version (eg. "German") for editing. Depending on the optional setting in the multilingual plugin,
   the same entry is now made available as an German language pendant of the same entry, either filled in as a copy or not. Now change
   and write your German text and the German heading and save it. Technically, this is a language copy of the old entry and is stored
   in the entryproperties database table.</p>
   <p><strong><u>Edit / Change / Multiply</u>:</strong></p>
   <p>The backend entry list still only lists the origin English blog entry, but now marks it with the additional language as a multilingual entry.
   If you click on the &laquo; Title &raquo; or &laquo; Edit &raquo;, the original English entry will be displayed again for editing.</p>
   <p>If you now - as before - simply change the multilingual selection language to "German", then your German-speaking Entry will appear.</p>
   <p>You can now repeat this process for another language (i.e. Spanish), or apply it directly to the "English" post you just
   created for another language. - And so on. These respective language entries can also be edited later.</p>
   <p><strong><u>Dismiss</u>:</strong></p>
   <p>If you want to DELETE an extended language entry (e.g., Spanish), load that language entry and check the "purge" box before
   saving the entry again as usual. The Header "success" message that appears after saving is designed for the normal entry worklow,
   and tells you, that the entry has been saved, although you have pushed a force delete checking the checkbox before.
   <strong>Don’t let that deter you.</strong></p>
   <p>This language entry should now be deleted from the database entryproperties table, but is still being displayed in the entry form after saving
   because you remain to be in the Spanish language configuration setting. Another immediate SAVE would push the current content into again.</p>
   <p>Now, switch back to "German" (your first multilingual entry copy) or better just jump to the backends entries list, and you’ll notice that
   the notification signal for the extended Spanish language entry "es" has disappeared.</p>'); // Translators, check the language this is written for and use equivalent start & example languages
@define('PLUGIN_EVENT_MULTILINGUAL_JS_LANG_CHANGE_NOTIFICATION', 'ATTENTION: You previously selected the language "%s".
 If you select standard "Default", no active language will be loaded. "This is the End, my friend". Care for your work,
 since even now or after changing to default via the button, a rashly direct SAVE would overwrite your origin entry.');

//
//  serendipity_plugin_multilingual.php
//
@define('PLUGIN_SIDEBAR_MULTILINGUAL_TITLE', 'Choose Language');
@define('PLUGIN_SIDEBAR_MULTILINGUAL_DESC', 'Allows visitors to change the frontend interface language');
@define('PLUGIN_SIDEBAR_MULTILINGUAL_USERDESC', 'You can select a different language for the displayed interface of this blog: ');
@define('PLUGIN_SIDEBAR_MULTILINGUAL_SUBMIT', 'Submit button?');
@define('PLUGIN_SIDEBAR_MULTILINGUAL_SUBMIT_DESC', 'Show a submit button?');
@define('PLUGIN_SIDEBAR_MULTILINGUAL_SIZE', 'Font size');

@define('PLUGIN_SIDEBAR_MULTILINGUAL_LANGIFIED_DESC', 'Default: in English. Pertains select-title of sidebar selectbox.');

