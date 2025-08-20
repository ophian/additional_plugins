<?php
/**
 * serendipity_plugin_flickrbadge - Your last photos from Flickr.com
 *
 * Serendipity plugin implementing a sidebar item which displays your last photos
 * you have added to Flickr.com
 *
 * @author Lars Strojny <lars@strojny.net>
 */
@define('SERENDIPITY_PLUGIN_FLICKRBADGE_VERSION', '1.0.0');

if (!defined('IN_serendipity') || IN_serendipity !== true) die("Don't hack");

@serendipity_plugin_api::load_language(dirname(__FILE__));

require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'plugin.inc.php';
