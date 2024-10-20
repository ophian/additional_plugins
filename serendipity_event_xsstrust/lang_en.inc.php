<?php

/**
 *  @version
 *  @author Translator Name <yourmail@example.com>
 *  EN-Revision: Revision of lang_en.inc.php
 */

//
//  serendipity_event_xsstrust
//
@define('PLUGIN_EVENT_XSSTRUST_NAME',     'Options for trustworthy editing on multi-user blogs / HTMLPurifier');
@define('PLUGIN_EVENT_XSSTRUST_DESC',     'This plugin can specify, which authors on a multi-user blog you have enough trust in and do not expect hacking attempts. All other users are treated as possibly evil and cannot create HTML entries.');
@define('PLUGIN_EVENT_XSSTRUST_AUTHORS',  'Trustworthy editors');

//
//  serendipity_plugin_xsstrust
//
@define('PLUGIN_ETHICS_NAME', 'Show trusted users');
@define('PLUGIN_ETHICS_INTRO', 'This plugin shows all authors with their ethic value, lights have the following meaning:');
@define('PLUGIN_ETHICS_REDLIGHT', 'banned');
@define('PLUGIN_ETHICS_YELLOWLIGHT', 'warning');
@define('PLUGIN_ETHICS_GREENLIGHT', 'cool');
@define('PLUGIN_ETHICS_BLAHBLAH', "Displays all users with their ethics (represented by a traffic light). Green light means '".PLUGIN_ETHICS_GREENLIGHT."'; yellow light means '".PLUGIN_ETHICS_YELLOWLIGHT."'; red light means '".PLUGIN_ETHICS_REDLIGHT."'. The administrator can easily modify this value for each user.");
@define('PLUGIN_ETHICS_BASEVAL', 'Starting value for each user\'s ethics');
@define('PLUGIN_ETHICS_BASEVAL_BLAHBLAH', 'Starting ethics (1 = green; 2= yellow; 3 = red; default: 1)');

@define('PLUGIN_XSSTRUST_HTMLPURIFIER', 'Enable HTMLPurifier');
@define('PLUGIN_XSSTRUST_HTMLPURIFIER_DESC', 'Uses HTMLPurifier (www.htmlpurifier.org) to strip JavaScript and malicious HTML from user input. If enabled, this means HTML will be allowed for authors. If disabled, the plugin will strip ALL HTML from user\'s inputs.');

