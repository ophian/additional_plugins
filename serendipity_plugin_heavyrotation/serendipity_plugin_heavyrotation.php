<?php
/**
 * serendipity_plugin_heavyrotation - Displaying Heavy Rotation
 *
 * Serendipity plugin implementing a Last.fm/Audioscrobbler based Heavy Rotation
 * visualisation with the cover image fetched from Amazon.
 *
 * @author Lars Strojny <lars@strojny.net>
 */
@define('SERENDIPITY_PLUGIN_HEAVYROTATION_VERSION', '0.10');

if (IN_SERENDIPITY != true) die("Don't hack");

if (version_compare(phpversion(), '5.1.0', '>=')) {
    @serendipity_plugin_api::load_language(dirname(__FILE__));

    require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'plugin.inc.php';
}
