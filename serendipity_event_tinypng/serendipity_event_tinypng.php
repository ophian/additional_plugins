<?php

declare(strict_types=1);

if (IN_serendipity !== true) {
    die ("Don't hack!");
}

@serendipity_plugin_api::load_language(dirname(__FILE__));

class serendipity_event_tinypng extends serendipity_event
{
    public $title = PLUGIN_EVENT_TINYPNG_NAME;

    function introspect(&$propbag)
    {
        global $serendipity;

        $propbag->add('name',          PLUGIN_EVENT_TINYPNG_NAME);
        $propbag->add('description',   PLUGIN_EVENT_TINYPNG_DESC);
        $propbag->add('stackable',     false);
        $propbag->add('author',        'onli, Ian Styx');
        $propbag->add('version',        '2.0.1');
        $propbag->add('requirements',   array(
            'serendipity' => '5.0',
            'php'         => '8.2'
        ));
        $propbag->add('event_hooks',   array('backend_image_add' => true));
        $propbag->add('groups', array('IMAGES'));

        $propbag->add('configuration', array('tinypngkey'));

        $propbag->add('legal',         array(
            'services' => array(
                'tinify' => array(
                    'url'  => 'https://tinify.com',
                    'desc' => 'Transmits image data (and metadata) to an online service to get back a new rendered PNG/JPEG image by best compression. You need an API key for tinypng, register at https://tinypng.com/developers. The API_ENDPOINT is "https://api.tinify.com"'
                ),
            ),
            'frontend' => array(
            ),
            'backend' => array(
                'Hooks into Serendipity backend "backend_image_add" hook for uploading images to the MediaLibrary.'
            ),
            'cookies' => array(
            ),
            'stores_user_input'     => false,
            'stores_ip'             => false,
            'uses_ip'               => false,
            'transmits_user_input'  => true
        ));
    }

    function generate_content(&$title)
    {
        $title = $this->title;
    }

    function introspect_config_item($name, &$propbag)
    {
        global $serendipity;

        switch($name) {
            case 'tinypngkey':
                $propbag->add('type',           'string');
                $propbag->add('name',           PLUGIN_EVENT_TINYPNG_APIKEY);
                $propbag->add('description',    PLUGIN_EVENT_TINYPNG_APIKEY_DESC);
                $propbag->add('default',        'none');
                break;
        }

        return true;
    }

    function event_hook($event, &$bag, &$eventData, $addData = null)
    {
        global $serendipity;

        $hooks = &$bag->get('event_hooks');

        if (isset($hooks[$event])) {
            switch($event) {
                case 'backend_image_add':
                    require_once("tinify-php/lib/Tinify/Exception.php");
                    require_once("tinify-php/lib/Tinify/ResultMeta.php");
                    require_once("tinify-php/lib/Tinify/Result.php");
                    require_once("tinify-php/lib/Tinify/Source.php");
                    require_once("tinify-php/lib/Tinify/Client.php");
                    require_once("tinify-php/lib/Tinify.php");

                    Tinify\setKey($this->get_config("tinypngkey"));

                    $image = $eventData;
                    if (substr($image, -4) == ".png" || substr($image, -4) == ".jpg") {
                        $thumbnail = str_replace(".jpg", ".serendipityThumb.jpg", $image);
                        $thumbnail = str_replace(".png", ".serendipityThumb.png", $thumbnail);
                        Tinify\fromFile($image)->toFile($image);
                        Tinify\fromFile($thumbnail)->toFile($thumbnail);
                    }
                    break;

                default:
                    return false;
            }
        } else {
            return false;
        }
    }

}

/* vim: set sts=4 ts=4 expandtab : */
?>