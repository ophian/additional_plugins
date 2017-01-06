<?php

/**
 *  @version
 *  @author Translator Name <yourmail@example.com>
 *  EN-Revision: Revision of lang_en.inc.php
 */

@define('PLUGIN_METADESC_NAME', 'HTML META-Tags');
@define('PLUGIN_METADESC_DESC', 'Sets HTML meta keywords/description tags and title element for single entry pages and default meta keywords/description tags for non-single entry pages.');
@define('PLUGIN_METADESC_FORM', 'If you leave these fields empty, the first 120 characters of the entry will be served as the meta description.  If a keyword phrase cannot be generated based upon the list of HTML Tags for keywords, the default meta keywords for non-single entry pages will be used.<br /><br />META-Description suggestion<sup>*</sup>: 20-30 words, 120-180 characters maximum including spaces.<br />META-Keywords suggestion<sup>*</sup>: 15-20 words utilizing keywords and phrases from entry content.');
@define('PLUGIN_METADESC_DESCRIPTION', 'META-Description:');
@define('PLUGIN_METADESC_KEYWORDS', 'META-Keywords:');
@define('PLUGIN_METADESC_HEADTITLE_DESC', 'The HTML page title element can be customized using the field below. If you leave this field empty, the title element will be served as defined by the template, which is typically "Entry Title - Blog Title".  <br /><br />Suggestion<sup>*</sup>: 3-9 words, 64 characters maximum including spaces, most important words first.');
@define('PLUGIN_METADESC_HEADTITLE', 'HTML page title element');
@define('PLUGIN_METADESC_LENGTH', 'Length');
@define('PLUGIN_METADESC_WORDS', 'words');
@define('PLUGIN_METADESC_CHARACTERS', 'characters');
@define('PLUGIN_METADESC_STRINGLENGTH_DISCLAIMER', 'Word and character count suggestions are approximate guidelines, not actual limits.');
@define('PLUGIN_METADESC_TAGNAMES', 'HTML Tags for keywords');
@define('PLUGIN_METADESC_TAGNAMES_DESC', 'Enter a comma-separated list of HTML tags that should be searched, which usually contain keywords.');
@define('PLUGIN_METADESC_DEFAULT_DESCRIPTION', 'HTML default meta description');
@define('PLUGIN_METADESC_DEFAULT_DESCRIPTION_DESC', 'Enter the default meta description used on non-single entry pages.');
@define('PLUGIN_METADESC_DEFAULT_KEYWORDS', 'HTML default meta keywords');
@define('PLUGIN_METADESC_DEFAULT_KEYWORDS_DESC', 'Enter a comma-separated list of keywords to be used on non-single entry pages.');
@define('PLUGIN_METADESC_ESCAPE', 'Escape HTML entities');
@define('PLUGIN_METADESC_ESCAPE_DESC', 'Replace reserved HTML characters within meta description or keywords with their corresponding HTML entities using htmlspecialchars().');

@define('PLUGIN_METADESC_MARKDOWN_DEPENDENCY', 'If using the "serendipity_event_markdown" plugin for your entries, you need to place/move this plugin beneath the markdown plugin in your plugin list to properly handle HTLM tags.');

