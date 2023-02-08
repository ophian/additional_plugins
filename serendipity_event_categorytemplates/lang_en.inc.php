<?php

/**
 *  @version
 *  @author Translator Name <yourmail@example.com>
 *  EN-Revision: Revision of lang_en.inc.php
 */

@define('PLUGIN_CATEGORYTEMPLATES_NAME', 'Properties/Templates of categories');
@define('PLUGIN_CATEGORYTEMPLATES_DESC', 'This plugin provides additional properties for categories and their entries, including custom templates, sort order, display limit, password protection, hiding from other entry lists including RSS.');
@define('PLUGIN_CATEGORYTEMPLATES_SELECT', 'Please enter the directory name of the theme you wish to use for this category. The relative directory names begin below the "templates/" structure. So you can use i.e. "blue" or "kubrick". You can also enter a subdirectory name, if you saved a subdirectory within your theme directory as if it were a theme on its own. Then you can enter i.e. "blue/category1" or "blue/category2". However, it is recommended to create your own category "Engine:" theme.<br>To change the ranking order in which items with multiple assigned categories are considered when applying custom category templates, configure the Category Templates plugin.<br>Dot not forget to reset the list hide option down below, when removing a category theme assignment.');
@define('PLUGIN_CATEGORYTEMPLATES_FETCHLIMIT', 'Entries to display on category frontpage');
@define('PLUGIN_CATEGORYTEMPLATES_PASS', 'Password protection:');
@define('PLUGIN_CATEGORYTEMPLATES_PASS_DESC', 'Should password-protection of categories be allowed? The drawbacks are that another database lookup needs to be made, and that entries in password-protected categories are NOT shown on the frontpage for users until they go to the protected category\'s view.');
@define('PLUGIN_CATEGORYTEMPLATES_PASS_USER', 'Serendipity Category Password protection');
@define('PLUGIN_CATEGORYTEMPLATES_FIXENTRY', 'Globally set entry\'s category');
@define('PLUGIN_CATEGORYTEMPLATES_FIXENTRY_DESC', 'If enabled, the category of an article in single entry view will be set as the current category.');
@define('PLUGIN_CATEGORYTEMPLATES_CATPRECEDENCE', 'Precedence of category templates');
@define('PLUGIN_CATEGORYTEMPLATES_CATPRECEDENCE_DESC', 'When an entry is assigned to multiple categories, this list determines the category whose custom template is applied. The category on top is considered first. To be able to save and activate your order changes for existing categorytemplates, you must first activate their checkbox(es) here.');
@define('PLUGIN_CATEGORYTEMPLATES_NO_CUSTOMIZED_CATEGORIES', 'No categories have customized templates yet. In this case let this checkbox unchecked!');
@define('PLUGIN_CATEGORYTEMPLATES_HIDE', 'Shall entries of this category be hidden from entries listings and RSS feeds?');
@define('PLUGIN_CATEGORYTEMPLATES_SELECT_TEMPLATE', 'Set the Theme for this blog category:');

