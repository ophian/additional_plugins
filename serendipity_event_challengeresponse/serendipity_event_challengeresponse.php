<?php

declare(strict_types=1);

if (IN_serendipity !== true) {
    die ("Don't hack!");
}


// Load possible language files.
#@serendipity_plugin_api::load_language(dirname(__FILE__));

class serendipity_event_challengeresponse extends serendipity_event
{
    function introspect(&$propbag) {
        global $serendipity;

        $this->title = 'Spam: Challenge/Response';

        $propbag->add('name',          $this->title);
        $propbag->add('description',   'A simple example for custom Spam verification.');
        $propbag->add('stackable',     false);
        $propbag->add('author',        'Nobody');
        $propbag->add('requirements',  array(
            'serendipity' => '5.0',
            'smarty'      => '4.1',
            'php'         => '8.2'
        ));
        $propbag->add('version',       '1.0.0');
        $propbag->add('event_hooks',    array(
            'frontend_saveComment' => true,
            'frontend_comment'     => true
        ));
        $propbag->add('configuration', array(
            'challenge',
            'response',
            'error'));
        $propbag->add('groups',         array('ANTISPAM'));
    }

    function introspect_config_item($name, &$propbag)
    {
        global $serendipity;

        switch($name) {
            case 'challenge':
                $propbag->add('type', 'text');
                $propbag->add('name', 'Challenge');
                $propbag->add('description', '');
                $propbag->add('default', 'What\'s the name of this blog?');
                break;

            case 'response':
                $propbag->add('type', 'text');
                $propbag->add('name', 'Response');
                $propbag->add('description', '');
                $propbag->add('default', 'Serendipity Styx');
                break;

            case 'error':
                $propbag->add('type', 'text');
                $propbag->add('name', 'Error message');
                $propbag->add('description', '');
                $propbag->add('default', 'You suck.');
                break;

            default:
                return false;
        }

        return true;
    }

    function generate_content(&$title)
    {
        $title = $this->title;
    }

    function event_hook($event, &$bag, &$eventData, $addData = null)
    {
        global $serendipity;

        $hooks = &$bag->get('event_hooks');

        if (isset($hooks[$event])) {
            switch($event) {
                case 'frontend_saveComment':
                    if (!is_array($eventData) || serendipity_db_bool($eventData['allow_comments'])) {
                        if (strtolower((string)$_POST['response']) != strtolower($this->get_config('response'))) {
                            $eventData = array('allow_comments' => false);
                            $serendipity['messagestack']['comments'][] = $this->get_config('error');
                            return false;
                        }
                    }
                    break;

                case 'frontend_comment':
                    echo '
                    <div class="serendipity_challengeresponse"><label for="serendipity_challengeresponse_response">' . $this->get_config('challenge') . '</label>
                        <input type="text" id="serendipity_challengeresponse_response" name="response" value="" />
                    </div>';
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