<?php

// GeoURL Plugin for Serendipity
//
// 2005/03 by Thomas Nesges
//            thomas@tnt-computer.de
//            http://blog.thomasnesges.de
//
// You can find your Latitude/Longitude coordinates via maporama
// (http://www.maporama.com/) or one of the other resources mentioned
// on http://geourl.org/resources.html


declare(strict_types=1);

if (IN_serendipity !== true) {
    die ("Don't hack!");
}

@serendipity_plugin_api::load_language(dirname(__FILE__));

class serendipity_event_geourl extends serendipity_event
{
    function introspect(&$propbag)
    {
        global $serendipity;

        $propbag->add('name',          PLUGIN_EVENT_GEOURL_NAME);
        $propbag->add('event_hooks',   array('frontend_header' => true));
        $propbag->add('configuration', array('lat', 'long'));
        $propbag->add('description',   PLUGIN_EVENT_GEOURL_DESC);
        $propbag->add('version',        '2.0.0');
        $propbag->add('requirements',   array(
            'serendipity' => '5.0',
            'php'         => '8.2'
        ));
        $propbag->add('groups', array('BACKEND_METAINFORMATION'));
    }

    function introspect_config_item($name, &$propbag)
    {
        switch($name) {
            case 'lat':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_EVENT_GEOURL_LAT);
                $propbag->add('description', PLUGIN_EVENT_GEOURL_LAT_DESC);
                $propbag->add('default',     '');
                break;

            case 'long':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_EVENT_GEOURL_LONG);
                $propbag->add('description', PLUGIN_EVENT_GEOURL_LONG_DESC);
                $propbag->add('default',     '');
                break;
        }

        return true;
    }

    function generate_content(&$title)
    {
        $title = PLUGIN_EVENT_GEOURL_NAME;
    }


    function event_hook($event, &$bag, &$eventData, $addData = null)
    {
        global $serendipity;
        $hooks = &$bag->get('event_hooks');

        if (isset($hooks[$event])) {
            switch($event) {
                case 'frontend_header':
                    $lat  = $this->get_config('lat');
                    $long = $this->get_config('long');
                    print "\n";
                    print '    <meta name="ICBM" content="' . $lat . ', ' . $long . '" />' . "\n";
                    print '    <meta name="geo.position" content="' . $lat . ';' . $long . '" />' . "\n";
                    print '    <meta name="DC.title" content="' . htmlspecialchars($serendipity['blogTitle']) . '" />' . "\n";
                    break;

                default:
                    return false;
            }
        } else {
            return false;
        }
    }

    function cleanup()
    {
        global $serendipity;
        echo '<div class="serendipity_msg_notice">';
        if ($this->get_config('lat') && $this->get_config('long')) {
            // Try to get the URL
            $geourl = "http://geourl.org/ping/?p=" . $serendipity['baseURL'];
            if (function_exists('serendipity_request_object')) {
                $req = serendipity_request_object($geourl);
                $response = $req->send();
                if (PEAR::isError($req->send()) || $response->getStatus() != '200') {
                    printf(REMOTE_FILE_NOT_FOUND, $geourl);
                } else {
                    echo PLUGIN_EVENT_GEOURL_PINGED;
                }
            } else {
                require_once (defined('S9Y_PEAR_PATH') ? S9Y_PEAR_PATH : S9Y_INCLUDE_PATH . 'bundled-libs/') . 'HTTP/Request.php';
                $req = new HTTP_Request($geourl);
                if (PEAR::isError($req->sendRequest()) || $req->getResponseCode() != '200') {
                    printf(REMOTE_FILE_NOT_FOUND, $geourl);
                } else {
                    echo PLUGIN_EVENT_GEOURL_PINGED;
                }
            }
        } else {
            echo PLUGIN_EVENT_GEOURL_NOLATLONG;
        }
        echo '</div>';
    }

}

?>