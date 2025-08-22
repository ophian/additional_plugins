<?php

declare(strict_types=1);

if (IN_serendipity !== true) {
    die ("Don't hack!");
}

// Load possible language files.
@serendipity_plugin_api::load_language(dirname(__FILE__));

class serendipity_event_stalkerbuster extends serendipity_event
{
    public $title = PLUGIN_STALKERBUSTER;

    function introspect(&$propbag)
    {
        $this->title = $this->get_config('title', $this->title);
        $propbag->add('name',          PLUGIN_STALKERBUSTER);
        $propbag->add('description',   PLUGIN_STALKERBUSTER_DESC);
        $propbag->add('stackable',     true);
        $propbag->add('author',        'Garvin Hicking');
        $propbag->add('version',       '2.0.0');
        $propbag->add('requirements',  array(
            'serendipity' => '5.0',
            'smarty'      => '4.1',
            'php'         => '8.2'
        ));
        $propbag->add('configuration', array(
            'mail',
            'cname'
        ));
        $propbag->add('groups', array('BACKEND_ADMIN'));
        $propbag->add('event_hooks',    array(
            'frontend_configure' => true,
            'backend_sendmail' => true
        ));
    }

    function introspect_config_item($name, &$propbag)
    {
        global $serendipity;

        switch($name) {
            case 'mail':
                $propbag->add('name', 'E-Mail');
                $propbag->add('description', '');
                $propbag->add('type', 'string');
                $propbag->add('default', $serendipity['blogMail']);
                break;

            case 'cname':
                $propbag->add('name', 'Cookiename');
                $propbag->add('description', '');
                $propbag->add('type', 'string');
                $propbag->add('default', 'PHPSESSIDSB');
                break;
        }
    }

    function event_hook($event, &$bag, &$eventData, $addData = null)
    {
        global $serendipity;

        $hooks = &$bag->get('event_hooks');
        if (isset($hooks[$event])) {
            switch($event) {
                case 'backend_sendmail':
                    $eventData['message'] .= "\n" . 'StalkerBuster:' . $_COOKIE['serendipity'][$this->get_config('cname')] . "\n";
                    break;

                case 'frontend_configure':
                    if (!isset($_COOKIE['serendipity'][$this->get_config('cname')])) {
                        serendipity_setCookie($this->get_config('cname'), uniqid('sb', true));
                    }
                    
                    $bl = @file_get_contents($serendipity['serendipityPath'] . 'stalkerbuster.php');
                    if (preg_match('@' . preg_quote($_COOKIE['serendipity'][$this->get_config('cname')]) . '@imsU', $bl)) {
                        mail($this->get_config('mail'), 'StalkerBuster', print_r($_REQUEST, true) . "\n" . print_r($_SERVER, true) . "\n");
                        header('HTTP/1.0 404 Not found');
                        header('Status: 404 Not found');
                        echo 'HTTP/1.0 404 Not found';
                        exit;
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