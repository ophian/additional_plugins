<?php

/**
 *  @version
 *  @author Translator Name <yourmail@example.com>
 *  EN-Revision: Revision of lang_en.inc.php
 */

@define('PLUGIN_EVENT_TEXTWIKI_NAME',     'Markup: Wiki');
@define('PLUGIN_EVENT_TEXTWIKI_DESC',     'Markup text using Text_Wiki');
@define('PLUGIN_EVENT_TEXTWIKI_TRANSFORM', '<a href="http://c2.com/cgi/wiki">Wiki</a> format allowed');

// Currently only english available

@define('PLUGIN_EVENT_TEXTWIKI_RULE_DESC_PREFILETER', 'Converts different OS linebreaks (Unix/DOS) to unified format and concates lines ending with \. Default is on. Not recommended to switch off.');
@define('PLUGIN_EVENT_TEXTWIKI_RULE_DESC_DELIMITER', 'Converts the Text_Wiki internal delimiter "\xFF" (255) to avoid conflicts while parsing. Default is on. Not recommended to switch off.');
@define('PLUGIN_EVENT_TEXTWIKI_RULE_DESC_CODE', 'Marks text between <code> and </code> as code. Using <code type=".."> you can switch highlighting on (e.g. for PHP). Default is on.');
@define('PLUGIN_EVENT_TEXTWIKI_RULE_DESC_PHPCODE', 'Marks and highlights text between <php> and </php> as PHP code and adds PHP open tags. Default is on.');
@define('PLUGIN_EVENT_TEXTWIKI_RULE_DESC_HTML', 'Allows you to use real HTML between <html> and </html>. Beware JS is possible, too! If you use this, switch off markup for comments! Default is off. Not recommended to switch on.');
@define('PLUGIN_EVENT_TEXTWIKI_RULE_DESC_RAW', 'Text between `` and `` is not touched by other markup rules. Default is on.');
@define('PLUGIN_EVENT_TEXTWIKI_RULE_DESC_INCLUDE', 'Allows you to include and run PHP code with the syntax [[include /path/to/script.php]]. Resulting output is parsed by markup rules. Beware, security risk! If you use this, switch off markup for comments! Default is off. Not recommended to switch on.');
@define('PLUGIN_EVENT_TEXTWIKI_RULE_INCLUDE_DESC_BASE', 'The base directory to your scripts. Default for this is set to "/path/to/scripts/". If you leave this blank and switch include on you can only use absolute paths.');
@define('PLUGIN_EVENT_TEXTWIKI_RULE_DESC_HEADING', 'Lines starting with "+ " are marked as headlines (+ = <h1>, ++++++ = <h6>). Default is on.');
@define('PLUGIN_EVENT_TEXTWIKI_RULE_DESC_HORIZ', '---- is converted to a horizontal line (<hr>). Default is on.');
@define('PLUGIN_EVENT_TEXTWIKI_RULE_DESC_BREAK', 'Line endings marked with " _" define explicit linebreaks. Default is on.');
@define('PLUGIN_EVENT_TEXTWIKI_RULE_DESC_BLOCKQUOTE', 'Enables to use email style quoting ("> ", ">> ",...). Default is on.');
@define('PLUGIN_EVENT_TEXTWIKI_RULE_DESC_LIST', 'Allows creation of lists ("* " = undefined, "# " = numbered). Default is on.');
@define('PLUGIN_EVENT_TEXTWIKI_RULE_DESC_DEFLIST', 'Enables to create definition lists. Syntax: ": Topic : Definition". Default is on.');
@define('PLUGIN_EVENT_TEXTWIKI_RULE_DESC_TABLE', 'Allows you to create tables. Only used for complete lines. Syntax: "|| Cell 1 || Cell 2 || Cell 3 ||". Default is on.');
@define('PLUGIN_EVENT_TEXTWIKI_RULE_DESC_EMBED', 'Allows you to include and run PHP code with the syntax [[embed /path/to/script.php]]. Resulting output is not parsed by markup rules. Beware, security risk! If you use this, switch off markup for comments! Default is off. Not recommended to switch on.');
@define('PLUGIN_EVENT_TEXTWIKI_RULE_EMBED_DESC_BASE', 'The base directory to your scripts. Default for this is set to "/path/to/scripts/". If you leave this blank and switch embed on you can only use absolute paths.');
@define('PLUGIN_EVENT_TEXTWIKI_RULE_DESC_IMAGE', 'Enables the inclusion of images. ([[image  /path/to/image.ext [HTML attributes] ]] or [[image  path/to/image.ext [link="PageName"] [HTML attributes] ]] for linked images). Por omissão ligado.');
@define('PLUGIN_EVENT_TEXTWIKI_RULE_IMAGE_DESC_BASE', 'Base directory to your images. Default for this is set to "/path/to/images". If you leave this blank you can only use absolute paths or URLs.');
@define('PLUGIN_EVENT_TEXTWIKI_RULE_DESC_PHPLOOKUP', 'Creates lookup links to the PHP manual with [[php function-name]]. Default is on.');
@define('PLUGIN_EVENT_TEXTWIKI_RULE_DESC_TOC', 'Generates a table of contents over all used headlines with [[toc]]. Default is on.');
@define('PLUGIN_EVENT_TEXTWIKI_RULE_DESC_NEWLINE', 'Converts single newlines ("\n") to line breaks. Default is on.');
@define('PLUGIN_EVENT_TEXTWIKI_RULE_DESC_CENTER', 'Lines starting with "= " are centered. Default is on.');
@define('PLUGIN_EVENT_TEXTWIKI_RULE_DESC_PARAGRAPH', 'Double newlines are converted to paragraphs (<p></p>). Default is on.');
@define('PLUGIN_EVENT_TEXTWIKI_RULE_DESC_URL', 'Normal converts http://example.com to links, [http://example.com] to footnotes and [http://example.com Example] to descriptive links. Default is on.');
@define('PLUGIN_EVENT_TEXTWIKI_RULE_URL_DESC_TARGET', 'Defines the target for your URLs. This is default set to "_blank", what is mostly feasible.');
@define('PLUGIN_EVENT_TEXTWIKI_RULE_DESC_FREELINK', 'Enables definition of non-standard wiki links using "((Non-standard link format))" and "((Non-standard link|Description))". Default is off.');
@define('PLUGIN_EVENT_TEXTWIKI_RULE_FREELINK_DESC_PAGES', 'The freelink rule (as well as the wikilink rule) must know, which pages exist and which have to be marked as "new". This specifies a file (local or remote) which has to contain 1 pagename per line. If the file is remote, it will be cached for the specified time.');
@define('PLUGIN_EVENT_TEXTWIKI_RULE_FREELINK_DESC_VIEWURL', 'This URL is specified to view the freelinks. You have to specify a "%s" inside this URL which will be replaced with the name of the freelink page.');
@define('PLUGIN_EVENT_TEXTWIKI_RULE_FREELINK_DESC_NEWURL', 'This URL is specified to create new freelinks. You have to specify a "%s" inside this URL which will be replaced with the name of the freelink page.');
@define('PLUGIN_EVENT_TEXTWIKI_RULE_FREELINK_DESC_NEWTEXT', 'This text will be added to undefined freelinks to link to the create page. Initially this is set to "?".');
@define('PLUGIN_EVENT_TEXTWIKI_RULE_FREELINK_DESC_CACHETIME', 'If you specify a remote file (URL) for your freelink pages, this file will be cached for as many seconds you specify here. Default is 1 hour.');
@define('PLUGIN_EVENT_TEXTWIKI_RULE_DESC_INTERWIKI', 'Allows inter wiki linking to MeatBall, Advogato and Wiki using SiteName:PageName or [SiteName:PageName Show this text instead]. Default is on.');
@define('PLUGIN_EVENT_TEXTWIKI_RULE_INTERWIKI_DESC_TARGET', '');
@define('PLUGIN_EVENT_TEXTWIKI_RULE_DESC_WIKILINK', 'Enables usage of standard WikiWords (2-X x uppercase) as wiki links. Default is off.');
@define('PLUGIN_EVENT_TEXTWIKI_RULE_WIKILINK_DESC_PAGES', 'The wikilink rule must know, which pages exist and which have to be marked as "new". This specifies a file (local or remote) which has to contain 1 pagename per line. If the file is remote, it will be cached for the specified time.');
@define('PLUGIN_EVENT_TEXTWIKI_RULE_WIKILINK_DESC_VIEWURL', 'This URL is specified to view the wikilinks. You have to specify a "%s" inside this URL which will be replaced with the name of the wikilink page.');
@define('PLUGIN_EVENT_TEXTWIKI_RULE_WIKILINK_DESC_NEWURL', 'This URL is specified to create new wikilinks. You have to specify a "%s" inside this URL which will be replaced with the name of the wikilink page.');
@define('PLUGIN_EVENT_TEXTWIKI_RULE_WIKILINK_DESC_NEWTEXT', 'This text will be added to undefined wikilinks to link to the create page. Initially this is set to "?".');
@define('PLUGIN_EVENT_TEXTWIKI_RULE_WIKILINK_DESC_CACHETIME', 'If you specify a remote file (URL) for your wikilink pages, this file will be cached for as many seconds you specify here. Default is 1 hour.');
@define('PLUGIN_EVENT_TEXTWIKI_RULE_DESC_COLORTEXT', 'Colorize text using ##color|text##. Default is on.');
@define('PLUGIN_EVENT_TEXTWIKI_RULE_DESC_STRONG', '**Text** is marked strong. Default is on.');
@define('PLUGIN_EVENT_TEXTWIKI_RULE_DESC_BOLD', '\'\'\'Text\'\'\' is marked bold. Default is on.');
@define('PLUGIN_EVENT_TEXTWIKI_RULE_DESC_EMPHASIS', '//Text// is marked emphasised. Default is on.');
@define('PLUGIN_EVENT_TEXTWIKI_RULE_DESC_ITALIC', '\'\'Text\'\' is marked italic. Default is on.');
@define('PLUGIN_EVENT_TEXTWIKI_RULE_DESC_TT', '{{Text}} is written in teletext (monotype). Default is on.');
@define('PLUGIN_EVENT_TEXTWIKI_RULE_DESC_SUPERSCRIPT', '^^Text^^ is written in superscript. Default is on.');
@define('PLUGIN_EVENT_TEXTWIKI_RULE_DESC_REVISE', 'Enables marking texts as revisions using "@@---delete this text+++insert this text@@". Default is on.');
@define('PLUGIN_EVENT_TEXTWIKI_RULE_DESC_TIGHTEN', 'Finds more than 3 newlines and reduces them to 2 newlines (paragraph). Default is on.');
@define('PLUGIN_EVENT_TEXTWIKI_RULE_DESC_ENTITIES', 'Escapes HTML entities. Default is on.');

@define('PLUGIN_EVENT_TEXTWIKI_RULE_DESC_UNDERLINE', '__Text__ is marked underline. Default is on.');
@define('PLUGIN_EVENT_TEXTWIKI_RULE_DESC_SUBSCRIPT', ',,Text,, is written in subscript. Default is on.');

