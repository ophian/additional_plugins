<?php

if (IN_serendipity !== true) {
    die ("Don't hack!");
}

@serendipity_plugin_api::load_language(dirname(__FILE__));
include dirname(__FILE__) . '/plugin_version.inc.php';

class serendipity_event_static_osm extends serendipity_event
{
    function introspect(&$propbag)
    {
        $propbag->add('name', PLUGIN_EVENT_STATIC_OSM_NAME);
        $propbag->add('description', PLUGIN_EVENT_STATIC_OSM_DESC);
        $propbag->add('copyright', 'GPL');
        $propbag->add('configuration', array('compress_gpx'));
        $propbag->add('event_hooks', array(
                'frontend_header' => true,
                'backend_image_add' => true
        ));
        $propbag->add('author', PLUGIN_EVENT_OSM_AUTHOR);
        $propbag->add('version', PLUGIN_EVENT_OSM_VERSION);
        $propbag->add('requirements', array(
            'serendipity' => '2.3',
            'php'         => '7.4'
        ));
        $propbag->add('stackable', false);
        $propbag->add('groups', array('FRONTEND_ENTRY_RELATED'));
        $this->dependencies = array(
            'serendipity_event_geo_osm' => 'keep'
        );
    }

    function introspect_config_item($name, &$propbag)
    {
        switch($name) {
            case 'compress_gpx':
                $propbag->add('type',        'boolean');
                $propbag->add('name',        PLUGIN_EVENT_STATIC_OSM_COMPRESS_GPX);
                $propbag->add('description', PLUGIN_EVENT_STATIC_OSM_COMPRESS_GPX_DESC);
                $propbag->add('default',     true);
                break;

            default:
                return false;
        }
        return true;
    }

    function generate_content(&$title)
    {
        $title = PLUGIN_EVENT_STATIC_OSM_NAME;
    }

    function event_hook($event, &$bag, &$eventData, $addData = null)
    {
        global $serendipity;

        if ($event === 'frontend_header') {
            echo '    <link rel="stylesheet" href="' . $serendipity['serendipityHTTPPath'] . 'plugins/serendipity_event_osm/resources/ol.css" type="text/css" />' . PHP_EOL;
            echo '    <link rel="stylesheet" href="' . $serendipity['serendipityHTTPPath'] . 'plugins/serendipity_event_osm/resources/osm.css" type="text/css" />' . PHP_EOL;
            echo '    <script src="' . $serendipity['serendipityHTTPPath'] . 'plugins/serendipity_event_osm/resources/ol.js"></script>' . PHP_EOL;
            echo '    <script src="' . $serendipity['serendipityHTTPPath'] . 'plugins/serendipity_event_osm/resources/osm.js"></script>' . PHP_EOL;
        } else if ($event === 'backend_image_add') {
            $fileName = $eventData;
            // up from PHP 8 if (str_ends_with(if (($fileName), '.gpx') && ..
            if (preg_match('/\\.gpx$/i', mb_strtolower($eventData)) && serendipity_db_bool($this->get_config('compress_gpx', 'true')) === true) {
                $gpx = new SimpleXMLElement($fileName, 0, true); // sets dataIsURL to true
                $tmpGpx = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8" standalone="yes" ?><gpx version="1.1" creator="surrim.org" xmlns="http://www.topografix.com/GPX/1/1" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.topografix.com/GPX/1/1 http://www.topografix.com/GPX/1/1/gpx.xsd"></gpx>');
                if (!isset($gpx->trk)) {
                    $gpx->trk = [];
                }
                foreach($gpx->trk AS $trk) {
                    if (!isset($$trk->trkseg)) {
                        $trk->trkseg = [];
                    }
                    $tmpTrkseg = $tmpTrk->addChild('trkseg');
                    foreach (($trkseg->trkpt ?? []) as $trkpt) {
                        $tmpTrkpt = $tmpTrkseg->addChild('trkpt');
                        $tmpTrkpt->addAttribute('lat', $trkpt['lat']);
                        $tmpTrkpt->addAttribute('lon', $trkpt['lon']);
                        if ($trkpt->ele != '') {
                            $tmpTrkpt->addChild('ele', $trkpt->ele);
                        }
                    }
                }
                $tmpGpx->asXML($fileName);
                clearstatcache(true, $fileName);

                $fileId = $addData['image_id'];
                $fileSize = filesize($fileName);
                serendipity_updateImageInDatabase(array('size' => $fileSize), $fileId);
            }
        }
    }

}

?>