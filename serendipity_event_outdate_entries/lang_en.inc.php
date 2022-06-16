<?php

/**
 * @version
 * @author Translator Name <yourmail@example.com>
 * EN-Revision: Revision of lang_en.inc.php
 */

@define('PLUGIN_EVENT_OUTDATE', 'Hide/delete entries after a specific timespan');
@define('PLUGIN_EVENT_OUTDATE_DESC', 'Hides all entries which are older than a specified age, so that they are only visible for registered users/authors. And similar more.');
@define('PLUGIN_EVENT_OUTDATE_TIMEOUT', 'When shall entries be hidden?');
@define('PLUGIN_EVENT_OUTDATE_TIMEOUT_DESC', 'Enter the maximum age of an entry (number of days, for example 31) after which an entry is hidden. 0 to deactivate. If you have already used this feature, deactivating with 0 will not change those entries. To reset all those entries that have already been set visible only to registered users, enter -1 once and save the configuration. The next call in the frontend (*) will then convert all "member" entries to "public" entries and set this configuration variable to 0. (* Under certain circumstances such a frontend request may take up to 2 calls until everything is set and correctly read out again. It is best to do it yourself).');
@define('PLUGIN_EVENT_OUTDATE_TIMEOUT_STICKY', 'When shall sticky entries be un-stickified?');
@define('PLUGIN_EVENT_OUTDATE_TIMEOUT_STICKY_DESC', 'Enter the maximum age of an entry (in days, for example 31) after which an entry is unstickified. 0 to deactivate.');

@define('PLUGIN_EVENT_OUTDATE_TIMEOUT_EXPIRY_FIELD', 'Custom Field name for expiry date');
@define('PLUGIN_EVENT_OUTDATE_TIMEOUT_EXPIRY_FIELD_DESC', 'If you are using the plugin "Extended properties for entries" you can define a custom field where you enter the date when an entry shall expire. That date should be formatted using a timestamp like YYYY-MM-DD. This plugin will look for this expiry date and will set the entry to DRAFT so that it is hidden from the frontend. Enter the fieldname of the custom field (like "ExpiryDate") here.');

