<?php

declare(strict_types=1);

if (IN_serendipity !== true) {
  die("Don't hack!");
}

@serendipity_plugin_api::load_language(dirname(__FILE__));

class serendipity_event_proxy_realip extends serendipity_event
{
    public $title = PLUGIN_EVENT_PROXY_REALIP_NAME;

    function introspect(&$propbag)
    {
        $propbag->add('name', PLUGIN_EVENT_PROXY_REALIP_NAME);
        $propbag->add('description', PLUGIN_EVENT_PROXY_REALIP_DESC);
        $propbag->add('stackable', false);
        $propbag->add('author', 'kleinerChemiker');
        $propbag->add('version',        '2.0.0');
        $propbag->add('requirements',   array(
            'serendipity' => '5.0',
            'smarty'      => '4.1',
            'php'         => '8.2'
        ));
        $propbag->add('groups', array('BACKEND_FEATURES'));
        $propbag->add('event_hooks', array('frontend_configure' => true));

        $conf_array = array();
        $conf_array[] = 'realip_var';

        $propbag->add('configuration', $conf_array);
    }

    function introspect_config_item($name, &$propbag)
    {
        switch ($name) {
            case 'realip_var':
                $propbag->add('type',           'string');
                $propbag->add('name',           PLUGIN_EVENT_PROXY_REALIP);
                $propbag->add('description',    PLUGIN_EVENT_PROXY_REALIP_VAR_DESC);
                $propbag->add('validate',       '/^\$[^;]+$/');
                $propbag->add('default',        '$_SERVER[\'X-FORWARDED-FOR\']');
                break;

            default:
                $propbag->add('type',           'boolean');
                $propbag->add('name',           constant($name));
                $propbag->add('description',    sprintf(APPLY_MARKUP_TO, constant($name)));
                $propbag->add('default',        'true');
        }
        return true;
    }

    function event_hook($event, &$bag, &$eventData, $addData = null)
    {
        static $realip_var = NULL;

        $hooks = &$bag->get('event_hooks');

        if ($realip_var === null) {
            $realip_var = $this->get_config('realip_var', '$_SERVER[\'X-FORWARDED-FOR\']');
            $regex = '/^\$_(\w*) ?\[[\'"](\w*)[\'"]\]$/i';
            preg_match($regex, $realip_var, $matches);
            if (strtolower($matches[1]) == 'server') {
                $tmp = $matches[2];
                $realip_ip = filter_var($_SERVER[$tmp], FILTER_VALIDATE_IP);
            } elseif (strtolower($matches[1]) == 'env') {
                $tmp = $matches[2];
                $realip_ip = filter_var($_ENV[$tmp], FILTER_VALIDATE_IP);
            }
        }

        if (isset($hooks[$event])) {
            if ($event == 'frontend_configure') {
                if ($realip_ip !== FALSE) {
                    $_SERVER["REMOTE_ADDR"] = $realip_ip;
                }
            }
            return true;
        }
        return false;
    }

}

?>