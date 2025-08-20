<?php
/**
 * serendipity_plugin_heavyrotation - Displaying Heavy Rotation
 *
 * Serendipity plugin implementing a Last.fm/Audioscrobbler based Heavy Rotation
 * visualisation with the cover image fetched from Amazon.
 *
 * @author Lars Strojny <lars@strojny.net>
 */
@define('SERENDIPITY_PLUGIN_HEAVYROTATION_VERSION', '1.0.0');

if (!defined('IN_serendipity') || IN_serendipity !== true) die("Don't hack");

@serendipity_plugin_api::load_language(dirname(__FILE__));

require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'plugin.inc.php';
