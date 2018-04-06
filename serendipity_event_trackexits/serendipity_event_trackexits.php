<?php

if (IN_serendipity !== true) {
    die ("Don't hack!");
}

@serendipity_plugin_api::load_language(dirname(__FILE__));

class serendipity_event_trackexits extends serendipity_event
{
    var $title = PLUGIN_EVENT_TRACKBACK_NAME;
    var $links;

    function introspect(&$propbag)
    {
        global $serendipity;

        $propbag->add('name',          PLUGIN_EVENT_TRACKBACK_NAME);
        $propbag->add('description',   PLUGIN_EVENT_TRACKBACK_DESC);
        $propbag->add('stackable',     false);
        $propbag->add('author',        'Serendipity Team, Ian');
        $propbag->add('version',       '1.14');
        $propbag->add('requirements',  array(
            'serendipity' => '1.6',
            'smarty'      => '2.6.7',
            'php'         => '5.1.0'
        ));
        $propbag->add('cachable_events', array('frontend_display' => true));
        $propbag->add('event_hooks',   array('frontend_display' => true, 'frontend_display_cache' => true));
        $propbag->add('scrambles_true_content', true);
        $propbag->add('groups', array('STATISTICS'));
        $propbag->add('legal',  array(
            'services' => array(
                'favatar' => array(
                    'url'  => 'https://www.google.com',
                    'desc' => 'Google link deflector.'
                ),
            ),
            'frontend' => array(
                'Outgoing links are routed through a link deflector, so the target page will not get the referrer of this blog. However, this means that the link deflector service will get both the target and the originating link plus metadata of a visitor.',
            ),
            'backend' => array(
            ),
            'cookies' => array(
            ),
            'stores_user_input'     => false,
            'stores_ip'             => false,
            'uses_ip'               => true,
            'transmits_user_input'  => true
        ));

        $this->markup_elements = array(
            array(
              'name'     => 'ENTRY_BODY',
              'element'  => 'body',
            ),
            array(
              'name'     => 'EXTENDED_BODY',
              'element'  => 'extended',
            ),
            array(
              'name'     => 'COMMENT',
              'element'  => 'comment',
            ),
            array(
              'name'     => 'HTML_NUGGET',
              'element'  => 'html_nugget',
            )
        );

        $conf_array = array();
        foreach($this->markup_elements AS $element) {
            $conf_array[] = $element['name'];
        }
        $conf_array[] = 'commentredirection';
        $propbag->add('configuration', $conf_array);
    }

    function install()
    {
        serendipity_plugin_api::hook_event('backend_cache_entries', $this->title);
    }

    function uninstall(&$propbag)
    {
        serendipity_plugin_api::hook_event('backend_cache_purge', $this->title);
        serendipity_plugin_api::hook_event('backend_cache_entries', $this->title);
    }

    function generate_content(&$title)
    {
        $title = $this->title;
    }

    function introspect_config_item($name, &$propbag)
    {
        switch($name) {
            case 'commentredirection':
                $propbag->add('type',        'select');
                $propbag->add('select_values', array('none'     => PLUGIN_EVENT_TRACKBACK_COMMENTREDIRECTION_NONE,
                                                     's9y'      => PLUGIN_EVENT_TRACKBACK_COMMENTREDIRECTION_S9Y,
                                                     'google'   => PLUGIN_EVENT_TRACKBACK_COMMENTREDIRECTION_GOOGLE));
                $propbag->add('name',        PLUGIN_EVENT_TRACKBACK_COMMENTREDIRECTION);
                $propbag->add('description', PLUGIN_EVENT_TRACKBACK_COMMENTREDIRECTION_BLAHBLA);
                $propbag->add('default',     'none');
                break;

            default:
                $propbag->add('type',        'boolean');
                $propbag->add('name',        constant($name));
                $propbag->add('description', sprintf(APPLY_MARKUP_TO, constant($name)));
                $propbag->add('default',     'true');
        }
        return true;
    }

    function event_hook($event, &$bag, &$eventData, $addData = null)
    {
        global $serendipity;

        $hooks = &$bag->get('event_hooks');

        if (isset($hooks[$event])) {
            switch($event) {
                case 'frontend_display':
                    if ($bag->get('scrambles_true_content') && is_array($addData) && isset($addData['no_scramble'])) {
                        return true;
                    }

                case 'frontend_display_cache':
                    $serendipity['encodeExitsCallback_entry_id'] = (int)(isset($eventData['entry_id']) ? $eventData['entry_id'] : $eventData['id']);

                    // Fetch all existing links from the database. They have been inserted there by our trackback-discovery.
                    if (empty($serendipity['encodeExitsCallback_entry_id'])) {
                        $this->links = array();
                    } else {
                        #echo "SELECT id, link FROM {$serendipity['dbPrefix']}references WHERE entry_id = {$serendipity['encodeExitsCallback_entry_id']} AND type = ''<br />\n";
                        $this->links = serendipity_db_query("SELECT id, link FROM {$serendipity['dbPrefix']}references WHERE entry_id = {$serendipity['encodeExitsCallback_entry_id']} AND (type = '' OR type IS NULL)", false, 'both', false, 'link', 'id');
                        #echo "<pre>" . print_r($this->links, true) . "</pre><br />\n";
                    }

                    foreach ($this->markup_elements as $temp) {
                        if (serendipity_db_bool($this->get_config($temp['name'], true)) && isset($eventData[$temp['element']]) &&
                            !$eventData['properties']['ep_disable_markup_' . $this->instance] &&
                            !isset($serendipity['POST']['properties']['disable_markup_' . $this->instance])) {
                            $element = $temp['element'];

                            $eventData[$element] = preg_replace_callback(
                                "#<a(.*)href=(\"|')http(s?)://([^\"']+)(\"|')([^>]*)>#isUm",
                                array($this, '_encodeExitsCallback'),
                                $eventData[$element]
                            );

                            if ($temp['element'] == 'comment' && !empty($eventData['url'])) {
                                switch(trim($this->get_config('commentredirection'))) {
                                    case 's9y':
                                        $eventData['url'] = $this->_encodeExitsCallback(
                                                              array(
                                                                1 => ' ',
                                                                2 => '"',
                                                                3 => '',
                                                                4 => $eventData['url'],
                                                                5 => '"'
                                                              ),
                                                              true
                                                            );
                                        break;

                                    case 'google':
                                        $eventData['url'] = 'https://www.google.com/url?sa=D&q=' . $eventData['url'];
                                        break;

                                    default:
                                        break;
                                }
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


    /**
     * Transforms '<a href="http://url/">' into
     * '<a href="exit.php?url=encurl" ...>'.
     */
    function _encodeExitsCallback($buffer, $url_only = false)
    {
        global $serendipity;
        static $redir = null;

        if ($redir === null) {
            $redir = $this->get_config('commentredirection');
        }

        $entry_id = $serendipity['encodeExitsCallback_entry_id'];
        $url      = 'http' . $buffer[3] . '://' . $buffer[4];

        if ($url_only) {
            return sprintf(
                '%sexit.php?url=%s%s',
                $serendipity['baseURL'],
                base64_encode($buffer[4]),
                ($entry_id != 0) ? '&amp;entry_id=' . $entry_id : ''
            );
        }

        $is_title = (stristr($buffer[0], 'title=')       !== false ? true : false);
        $is_over  = (stristr($buffer[0], 'onmouseover=') !== false ? true : false);
        $is_out   = (stristr($buffer[0], 'onmouseout=')  !== false ? true : false);

        $link     = '<a%shref="%sexit.php?url%s=%s%s" ' . (!$is_title ? 'title="%s" ' : '%s') . (!$is_over ? ' onmouseover="window.status=\'%s\';return true;" ' : '%s') . (!$is_out ? 'onmouseout="window.status=\'\';return true;"' : '') . '%s>';

        if (is_array($this->links) && !empty($this->links[$url])) {
            return sprintf(
                $link,
                $buffer[1],
                $serendipity['baseURL'],
                '_id',
                $this->links[$url],
                ($entry_id != 0) ? '&amp;entry_id=' . $entry_id : '',
                (!$is_title ? (function_exists('serendipity_specialchars') ? serendipity_specialchars($url) : htmlspecialchars($url, ENT_COMPAT, LANG_CHARSET)) : ''),
                (!$is_over  ? (function_exists('serendipity_specialchars') ? serendipity_specialchars($url) : htmlspecialchars($url, ENT_COMPAT, LANG_CHARSET)) : ''),
                $buffer[6]
            );
        } else {
            return sprintf(
                $link,
                $buffer[1],
                $serendipity['baseURL'],
                '',
                base64_encode($url),
                ($entry_id != 0) ? '&amp;entry_id=' . $entry_id : '',
                (!$is_title ? (function_exists('serendipity_specialchars') ? serendipity_specialchars($url) : htmlspecialchars($url, ENT_COMPAT, LANG_CHARSET)) : ''),
                (!$is_over  ? (function_exists('serendipity_specialchars') ? serendipity_specialchars($url) : htmlspecialchars($url, ENT_COMPAT, LANG_CHARSET)) : ''),
                $buffer[6]
            );
        }
    }

}

/* vim: set sts=4 ts=4 expandtab : */
?>