<?php

declare(strict_types=1);

if (IN_serendipity !== true) {
    die ("Don't hack!");
}

// Load possible language files.
#@serendipity_plugin_api::load_language(dirname(__FILE__));

class serendipity_event_mailcc extends serendipity_event
{
    public $title = 'Adds CC to all sent emails';

    function introspect(&$propbag)
    {
        $propbag->add('name',          'Adds CC to all sent emails');
        $propbag->add('description',   '(Notice: Make sure that the all of your authors have the option to receive comment notification emails activated, or else no mails will be created that can be CCed');
        $propbag->add('stackable',     false);
        $propbag->add('author',        'Garvin Hicking');
        $propbag->add('version',       '2.0.0');
        $propbag->add('requirements',  array(
            'serendipity' => '5.0',
            'smarty'      => '4.1',
            'php'         => '8.2'
        ));
        $propbag->add('groups', array('BACKEND_FEATURES'));
        $propbag->add('event_hooks',   array('backend_sendmail' => true));
        $propbag->add('configuration', array('cc'));
    }

    function generate_content(&$title)
    {
        $title = $this->title;
    }

    function introspect_config_item($name, &$propbag)
    {
        switch($name) {
            case 'cc':
            $propbag->add('type',        'string');
            $propbag->add('name',        'E-Mail address to CC');
            $propbag->add('description', '');
            $propbag->add('default',     'nobody@example.com');
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
                case 'backend_sendmail':
                    $eventData['headers'][] = 'CC: ' . $this->get_config('cc');
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