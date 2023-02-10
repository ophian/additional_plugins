<?php
// Makes use of the Tabber JavaScript Tabifier (http://www.barelyfitz.com/projects/tabber/)
// Thanks to http://microformats.org/code/hcalendar/creator
// Thanks to http://microformats.org/code/hreview/creator

if (IN_serendipity !== true) {
    die ("Don't hack!");
}

@serendipity_plugin_api::load_language(dirname(__FILE__));

class serendipity_event_microformats extends serendipity_event
{
    var $is_smarty_init = false;
    var $title = PLUGIN_EVENT_MICROFORMATS_TITLE;

    var $timezones  = array('-1200' => '-12 (IDLW)',
                            '-1100' => '-11 (NT)',
                            '-1000' => '-10 (HST)',
                            '-0900' => '-9 (AKST)',
                            '-0800' => '-8 (PST/AKDT)',
                            '-0700' => '-7 (MST/PDT)',
                            '-0600' => '-6 (CST/MDT)',
                            '-0500' => '-5 (EST/CDT)',
                            '-0400' => '-4 (AST/EDT)',
                            '-0345' => '-3:45',
                            '-0330' => '-3:30',
                            '-0300' => '-3 (ADT)',
                            '-0200' => '-2 (AT)',
                            '-0100' => '-1 (WAT)',
                            'Z' => '+0 (GMT/UTC)',
                            '+0100' => '+1 (CET/BST/IST/WEST)',
                            '+0200' => '+2 (EET/CEST)',
                            '+0300' => '+3 (MSK/EEST)',
                            '+0330' => '+3:30 (Iran)',
                            '+0400' => '+4 (ZP4/MSD)',
                            '+0430' => '+4:30 (Afghanistan)',
                            '+0500' => '+5 (ZP5)',
                            '+0530' => '+5:30 (India)',
                            '+0600' => '+6 (ZP6)',
                            '+0630' => '+6:30 (Myanmar)',
                            '+0700' => '+7 (WAST)',
                            '+0800' => '+8 (WST)',
                            '+0900' => '+9 (JST)',
                            '+0930' => '+9:30 (Central Australia)',
                            '+1000' => '+10 (AEST)',
                            '+1100' => '+11 (AEST [summer])',
                            '+1200' => '+12 (NZST/IDLE)');

    function introspect(&$propbag)
    {
        $propbag->add('name',          PLUGIN_EVENT_MICROFORMATS_TITLE);
        $propbag->add('description',   PLUGIN_EVENT_MICROFORMATS_DESC);
        $propbag->add('stackable',     false);
        $propbag->add('author',        'Matthias Gutjahr, Ian Styx');
        $propbag->add('version',       '0.54');
        $propbag->add('requirements',  array(
            'serendipity' => '2.1',
            'smarty'      => '3.1',
            'php'         => '7.4'
        ));
        $propbag->add('event_hooks',    array(
            'frontend_header'                                   => true,
            'backend_publish'                                   => true,
            'backend_save'                                      => true,
            'backend_display'                                   => true,
            'entry_display'                                     => true,
            /*'frontend_rss'                                      => true,*/
            'css_backend'                                       => true,
            'genpage'                                           => true,
            'backend_preview'                                   => true
        ));
        $propbag->add('groups', array('BACKEND_EDITOR', 'BACKEND_TEMPLATES'));
        $propbag->add('configuration', array('subnode', 'timezone', 'best', 'step', 'path'));
        $this->dependencies = array('serendipity_event_entryproperties' => 'keep');
    }

    function introspect_config_item($name, &$propbag)
    {
        global $serendipity;

        switch($name) {
            case 'subnode':
                $propbag->add('type', 'boolean');
                $propbag->add('name', PLUGIN_EVENT_MICROFORMATS_SB_SUBNODE);
                $propbag->add('description', PLUGIN_EVENT_MICROFORMATS_SB_SUBNODE_DESC);
                $propbag->add('default', false);
                break;

            case 'timezone':
                $propbag->add('type', 'select');
                $propbag->add('name', PLUGIN_MICROFORMATS_TIMEZONE_N);
                $propbag->add('description', PLUGIN_MICROFORMATS_TIMEZONE_D);
                $propbag->add('select_values', $this->timezones);
                $propbag->add('default', 'Z');
                break;

            case 'best':
                $propbag->add('type', 'string');
                $propbag->add('name', PLUGIN_EVENT_MICROFORMATS_BEST_N);
                $propbag->add('description', PLUGIN_EVENT_MICROFORMATS_BEST_D);
                $propbag->add('default', '5.0');
                break;

            case 'step':
                $propbag->add('type', 'string');
                $propbag->add('name', PLUGIN_EVENT_MICROFORMATS_STEP_N);
                $propbag->add('description', PLUGIN_EVENT_MICROFORMATS_STEP_D);
                $propbag->add('default', '1.0');
                break;

            case 'path':
                $propbag->add('type', 'string');
                $propbag->add('name', PLUGIN_EVENT_MICROFORMATS_PATH_N);
                $propbag->add('description', PLUGIN_EVENT_MICROFORMATS_PATH_D);
                $propbag->add('default', $serendipity['serendipityHTTPPath'] . 'plugins/serendipity_event_microformats');
                break;

            default:
        }
        return true;
    }

    function generate_content(&$title)
    {
        $title = $this->title;
    }

    function &getSupportedProperties($mf_type)
    {
        static $supported_properties = null;

        if ($supported_properties === null) {
            foreach($mf_type AS $v) {
                switch (strtoupper($v)) {
                    case 'HREVIEW':
                        $supported_properties['hReview'] = 'hReview';
                        $hReview_fields = array('name', 'type', 'url', 'image', 'rating', 'summary', 'desc', 'date', 'timezone', 'reviewer');
                        foreach($hReview_fields AS $field) {
                            $supported_properties['hReview_'.$field] = '';
                        }
                        break;
                    case 'HCALENDAR':
                        $supported_properties['hCalendar'] = 'hCalendar';
                        $hCalendar_fields = array('summary', 'location', 'url', 'startdate', 'enddate', 'timezone', 'desc');
                        foreach($hCalendar_fields AS $field) {
                            $supported_properties['hCalendar_'.$field] = '';
                        }
                        break;
                    default:
                        break;
                }
            }
        }

        return $supported_properties;
    }

    function addProperties(&$properties, &$eventData)
    {
        global $serendipity;

        $supported_formats = array('hReview', 'hCalendar');
        $supported_properties =& $this->getSupportedProperties($supported_formats);
        foreach($supported_properties AS $prop_key => $_pkey) {

            $curr_format = (strpos($prop_key, '_') > 0) ? explode('_', $prop_key) : array(0 => $prop_key);
            if (!is_array($properties['mf_type'])) $properties['mf_type'] = array();
            $prop_val = (isset($properties[$prop_key]) && in_array($curr_format[0], $properties['mf_type'])) ? $properties[$prop_key] : null;
            $prop_key = 'mf_'.$prop_key;

            if (is_array($prop_val)) {
                $prop_val = ";" . implode(';', $prop_val) . ";";
            }
            if ($prop_val != null && strpos($prop_key, 'date') > 0) {
                $prop_val = strtotime($prop_val . ':00');
            }

            $q = "DELETE FROM {$serendipity['dbPrefix']}entryproperties WHERE entryid = " . (int)$eventData['id'] . " AND property = '" . serendipity_db_escape_string($prop_key) . "'";
            serendipity_db_query($q);

            if (!empty($prop_val)) {
                $q = "INSERT INTO {$serendipity['dbPrefix']}entryproperties (entryid, property, value) VALUES (" . (int)$eventData['id'] . ", '" . serendipity_db_escape_string($prop_key) . "', '" . serendipity_db_escape_string($prop_val) . "')";
                serendipity_db_query($q);
            }
        }
    }

    function event_hook($event, &$bag, &$eventData, $addData = null)
    {
        global $serendipity;

        $serendipity['mf_previews'] = 1;

        $hooks = &$bag->get('event_hooks');

        if (isset($hooks[$event])) {

            switch($event) {
                case 'css_backend':
                    $eventData .= '

/* serendipity_event_microformats start */

div.tabbertab div.field label {
    float: left;
    text-align: right;
    width: 15em;
    margin-right: .3em;
}
div.tabbertab div.field input {
    float: left;
    width: 30em;
}
div.tabbertab div.field select {float:left}
div.tabbertab div.field textarea {
    width: 100%;
}
div.tabbertab div.field br {
    margin-bottom:.5em;
}
div.tabbertab fieldset {
    margin: 5px;
}
.entryproperties_microformats #hReview_use,
.entryproperties_microformats #hCalendar_use {
    margin-left: .5em;
}
@media only screen and (min-width: 768px) {
    #microformats_tab_info {
        float: unset;
        width: 100%;
    }
}

/* serendipity_event_microformats end */
';
                    $eventData .= file_get_contents(dirname(__FILE__) . '/tabber.css');
                    $eventData .= '

/* serendipity_event_microformats end */

';
                    break;

                case 'genpage':
                    if (!isset($serendipity['smarty']) || !is_object($serendipity['smarty'])) {
                        // never init in genpage without adding previously set $vars, which is $view etc!
                        serendipity_smarty_init($serendipity['plugindata']['smartyvars']);
                    }
                    include_once(dirname(__FILE__).'/smarty.inc.php');
                    if (!isset($serendipity['smarty']->registered_plugins['function']['microformats_show'])) {
                        $serendipity['smarty']->registerPlugin('function', 'microformats_show', 'microformats_serendipity_show');
                    }
                    break;

                case 'frontend_header':
                    $pluginDir = $this->get_config('path', false);
                    if ($pluginDir === false) {
                        $plugin_dir = str_replace('//', '/', $serendipity['serendipityHTTPPath'] . preg_replace('@^.*(/plugins.*)@', '$1', dirname(__FILE__)));
                    }
                    echo '<link rel="stylesheet" type="text/css" href="' . $pluginDir . '/tabber.css"/>'."\n";
                    break;

                case 'backend_preview':
                    if (is_array($serendipity['POST']['properties']) && count($serendipity['POST']['properties']) > 0){
                        $parr = array();
                        $supported_formats = array('hReview', 'hCalendar');
                        $supported_properties =& $this->getSupportedProperties($supported_formats);
                        foreach($supported_properties AS $prop_key => $prop_val) {
                            if (isset($serendipity['POST']['properties'][$prop_key]))
                                $eventData['properties']['mf_' . $prop_key] = $serendipity['POST']['properties'][$prop_key];
                        }
                    }
                    if (!isset($serendipity['smarty'])) {
                        serendipity_smarty_init();
                    }
                    include_once(dirname(__FILE__).'/smarty.inc.php');
                    $serendipity['smarty']->assign('subnode', ($this->get_config('subnode') ? 1 : 0));
                    if (!isset($serendipity['smarty']->registered_plugins['function']['microformats_show'])) {
                        $serendipity['smarty']->registerPlugin('function', 'microformats_show', 'microformats_serendipity_show');
                    }
                    break;

                case 'backend_display':

                    if (isset($serendipity['POST']['properties']) && is_array($serendipity['POST']['properties']) && count($serendipity['POST']['properties']) > 0 && isset($serendipity['POST']['properties']['mf_type'])){
                        $supported_properties =& $this->getSupportedProperties($serendipity['POST']['properties']['mf_type']);
                        foreach($supported_properties AS $prop_key => $prop_val) {
                            $curr_format = (strpos($prop_key, '_') > 0) ? explode('_', $prop_key) : array(0 => $prop_key);
                            if (!isset($serendipity['POST']['properties'][$prop_key]) || !in_array($curr_format[0], $serendipity['POST']['properties']['mf_type'])) continue;
                            if (isset($serendipity['POST']['properties'][$prop_key])) {
                                $eventData['properties']['mf_' . $prop_key] = $serendipity['POST']['properties'][$prop_key];
                            }
                        }
                    }
                    $mf_exist = array();
                    if (!empty($eventData['properties'])) {
                        foreach($eventData['properties'] AS $k => $v) {
                            if (strpos($k, 'mf_hReview') !== false) $mf_exist['hReview'] = true;
                            if (strpos($k, 'mf_hCalendar') !== false) $mf_exist['hCalendar'] = true;
                        }
                    } else {
                        $mf_exist['hReview'] = null;
                        $mf_exist['hCalendar'] = null;
                    }
                    $itemtypes  = array('hReview' => array('product', 'business', 'event', 'person', 'place', 'website', 'url'));
                    $ratings    = array('hReview' => range(1.0, $this->get_config('best'), $this->get_config('step')));

                    $clock = ' <span class="icon-clock" aria-hidden="true"></span><span class="visuallyhidden"> ' . RESET_DATE . '</span>';

                    include_once('microformatsBackend.inc.php');
                    break;

                case 'backend_publish':
                case 'backend_save':
                    if (!isset($serendipity['POST']['properties']) || !is_array($serendipity['POST']['properties']) || !isset($eventData['id'])) {
                        return true;
                    }

                    $this->addProperties($serendipity['POST']['properties'], $eventData);
                    break;

                case 'entry_display':
                    if (!isset($serendipity['GET']['preview']) && isset($serendipity['POST']['properties']) && is_array($serendipity['POST']['properties']) && count($serendipity['POST']['properties']) > 0){
                        $parr = array();
                        $supported_formats = array('hReview', 'hCalendar');
                        $supported_properties =& $this->getSupportedProperties($supported_formats);
                        foreach($supported_properties AS $prop_key => $prop_val) {
                            if (isset($serendipity['POST']['properties'][$prop_key])) {
                                $eventData['properties']['mf_' . $prop_key] = $serendipity['POST']['properties'][$prop_key];
                            }
                        }
                    }
                    break;

                default:
                    return false;
            }
            return true;
        } else {
            return false;
        }
    }

}

?>