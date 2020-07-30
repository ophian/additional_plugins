<?php

if (IN_serendipity !== true) {
    die ("Don't hack!");
}

@serendipity_plugin_api::load_language(dirname(__FILE__));

class serendipity_event_unstrip_tags extends serendipity_event
{
    var $title = PLUGIN_EVENT_UNSTRIP_NAME;

    function introspect(&$propbag)
    {
        global $serendipity;

        $propbag->add('name',          PLUGIN_EVENT_UNSTRIP_NAME);
        $propbag->add('description',   PLUGIN_EVENT_UNSTRIP_DESC);
        $propbag->add('stackable',     false);
        $propbag->add('author',        'Garvin Hicking');
        $propbag->add('version',       '1.04');
        $propbag->add('requirements',  array(
            'serendipity' => '1.6',
            'smarty'      => '2.6.7',
            'php'         => '5.1.0'
        ));
        $propbag->add('groups', array('MARKUP'));
        $propbag->add('event_hooks',   array('frontend_display' => true, 'frontend_comment' => true));
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
                case 'frontend_display':
                    if (isset($eventData['comment']) && !empty($eventData['body'])) {
                        $eventData['comment'] = (function_exists('serendipity_specialchars') ? serendipity_specialchars($eventData['body']) : htmlspecialchars($eventData['body'], ENT_COMPAT, LANG_CHARSET));
                        $addData['comment_escaped'] = true; // @see serendipity_event_markdown
                    }
                    break;

                case 'frontend_comment':
                    echo '<div class="serendipity_commentDirection serendipity_comment_unstrip_tags">' . PLUGIN_EVENT_UNSTRIP_TRANSFORM . '</div>';
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

/* vim: set sts=4 ts=4 expandtab : */
?>