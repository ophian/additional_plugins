<?php

if (IN_serendipity !== true) {
    die ("Don't hack!");
}

@serendipity_plugin_api::load_language(dirname(__FILE__));

class serendipity_event_textile extends serendipity_event
{
    var $title = PLUGIN_EVENT_TEXTILE_NAME;

    function introspect(&$propbag)
    {
        global $serendipity;

        $propbag->add('name',          PLUGIN_EVENT_TEXTILE_NAME);
        $propbag->add('description',   PLUGIN_EVENT_TEXTILE_DESC);
        $propbag->add('stackable',     false);
        $propbag->add('author',        'Serendipity Team, Lars Strojny, Ian Styx');
        $propbag->add('version',       '1.12.4');
        $propbag->add('requirements',  array(
            'serendipity' => '2.0',
            'smarty'      => '3.1',
            'php'         => '7.4'
        ));
        $propbag->add('cachable_events', array('frontend_display' => true));
        $propbag->add('event_hooks',   array(
            'backend_entryform' => true,
            'backend_configure' => true,
            'frontend_display'  => true,
            'frontend_comment'  => true
        ));
        $propbag->add('groups', array('MARKUP'));

        $propbag->add('preserve_tags',
          array(
            'php',
            'output',
            'name'
          )
        );

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
        $conf_array[] = 'textile_version';
        $conf_array[] = 'textile_doctype';
        // todo $conf_array[] = 'textile_restrict_comments';
        $conf_array[] = 'unescape';
        $propbag->add('configuration', $conf_array);
    }


    function generate_content(&$title)
    {
        $title = $this->title;
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

    function example()
    {
        return '<p class="msg_notice">'.PLUGIN_EVENT_TEXTILE_EXAMPLE_NOTE.'</p>';
    }

    function introspect_config_item($name, &$propbag)
    {
        switch($name) {

            case 'textile_version':
                $propbag->add('type',        'radio');
                $propbag->add('name',        PLUGIN_EVENT_TEXTILE_VERSION);
                $propbag->add('description', PLUGIN_EVENT_TEXTILE_VERSION_DESCRIPTION);
                $propbag->add('radio',       array(
                                                'value' => array(2, 3),
                                                'desc'  => array('2.0', '3.0'),
                ));
                $propbag->add('default',     3);
                break;

            case 'textile_doctype':
                $propbag->add('type',        'boolean');
                $propbag->add('name',        PLUGIN_EVENT_TEXTILE_DOCTYPE);
                $propbag->add('description', PLUGIN_EVENT_TEXTILE_DOCTYPE_DESC);
                $propbag->add('default',     'false');
                break;

            case 'textile_restrict_comments':
                $propbag->add('type',        'boolean');
                $propbag->add('name',        PLUGIN_EVENT_TEXTILE_RESTRICTCOMMENTS);
                $propbag->add('description', PLUGIN_EVENT_TEXTILE_RESTRICTCOMMENTS_DESC);
                $propbag->add('default',     'true');
                break;

            case 'unescape':
                $propbag->add('type',        'boolean');
                $propbag->add('name',        PLUGIN_EVENT_TEXTILE_UNESCAPE);
                $propbag->add('description', PLUGIN_EVENT_TEXTILE_UNESCAPE_DESC);
                $propbag->add('default',     'false');
                break;

            default:
                $propbag->add('type',        'boolean');
                $propbag->add('name',        constant($name));
                $propbag->add('description', sprintf(APPLY_MARKUP_TO, constant($name)));
                $propbag->add('default',     'true');
                break;
        }

        return true;
    }

    function event_hook($event, &$bag, &$eventData, $addData = null)
    {
        global $serendipity;
        static $strict = null;

        $hooks = &$bag->get('event_hooks');

        if ($strict === null) {
            $strict = $serendipity['strict_markup_editors'] ?? true; // override per manually set user (local) config var
        }

        if (isset($hooks[$event])) {

            switch($event) {

                case 'backend_entryform':
                case 'backend_configure':
                    if ($strict) {
                        $serendipity['pdata']['markupeditor'] = $eventData['markupeditor'] = true;
                    }
                    // We don't want users to provide two active concurrent markup plugins. Without throwing a notice make it notable that the user has them installed!
                    if (!empty($eventData['markupeditortype'])) {
                        $serendipity['pdata']['markupeditortype'] = $eventData['markupeditortype'] .= ' <span title="Having 2 concurrent markup plugins active is not recommended!" class="icon-attention-circled alertinfo" aria-hidden="true"></span> <a href="https://textile-lang.com/" target="_blank">Textile</a>';
                    } else {
                        $serendipity['pdata']['markupeditortype'] = $eventData['markupeditortype'] = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-arrow-up-right" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M8.636 3.5a.5.5 0 0 0-.5-.5H1.5A1.5 1.5 0 0 0 0 4.5v10A1.5 1.5 0 0 0 1.5 16h10a1.5 1.5 0 0 0 1.5-1.5V7.864a.5.5 0 0 0-1 0V14.5a.5.5 0 0 1-.5.5h-10a.5.5 0 0 1-.5-.5v-10a.5.5 0 0 1 .5-.5h6.636a.5.5 0 0 0 .5-.5z"/><path fill-rule="evenodd" d="M16 .5a.5.5 0 0 0-.5-.5h-5a.5.5 0 0 0 0 1h3.793L6.146 9.146a.5.5 0 1 0 .708.708L15 1.707V5.5a.5.5 0 0 0 1 0v-5z"/><title>External link(s)</title></svg> ' . sprintf(PLUGIN_EVENT_TEXTILE_TRANSFORM, 'https://textile-lang.com/');
                    }
                    break;

                case 'frontend_display':

                    $preserve_tags = &$bag->get('preserve_tags');

                    foreach ($this->markup_elements AS $temp) {
                        if (serendipity_db_bool($this->get_config($temp['name'], 'true'))) {
                            if (isset($eventData['properties']['ep_disable_markup_' . $this->instance])
                            ||  isset($serendipity['POST']['properties']['disable_markup_' . $this->instance])) {
                                continue;
                            }
                            $element = $temp['element'];

                            if ($element == 'comment' && isset($eventData['comment'])) {
                                $_comment = $eventData['comment']; // the comment "body" IN data copy to compare to (see below)
                            }

                            /* find all the tags and store them in $blocks */

                            $blocks = array();
                            foreach($preserve_tags AS $tag) {
                                if (isset($eventData[$element]) && preg_match_all('/(<'.$tag.'[^>]?>.*<\/'.$tag.'>)/msU', $eventData[$element], $matches )) {
                                    foreach($matches[1] AS $match) {
                                        $blocks[] = $match;
                                    }
                                }
                            }

                            /* replace all the blocks with some code */

                            foreach($blocks AS $id=>$block) {
                                $eventData[$element] = str_replace($block, '@BLOCK::'.$id.'@', $eventData[$element]);
                            }

                            /* textile it */

                            if (serendipity_db_bool($this->get_config('unescape'))) {
                                $eventData[$element] = str_replace('&quot;', '"', $eventData[$element]);
                            }
                            if (isset($eventData[$element])) {
                                $eventData[$element] = $this->textile($eventData[$element]);
                            }

                            /* each block will now be "<code>BLOCK::2</code>"
                             * so look for those place holders and replace
                             * them with the original blocks */

                            if (isset($eventData[$element]) && preg_match_all('/<code>BLOCK::(\d+)<\/code>/', $eventData[$element], $matches )) {
                                foreach($matches[1] AS $key=>$match) {
                                    $eventData[$element] = str_replace($matches[0][$key], $blocks[$match], $eventData[$element]);
                                }
                            }

                            /* post-process each block */

                            foreach($preserve_tags AS $tag) {
                                $method = '_process_tag_' . $tag;
                                if (method_exists($this, $method)) {
                                    if (isset($eventData[$element]) && preg_match_all('/<'.$tag.'[^>]?>(.*)<\/'.$tag.'>/msU', $eventData[$element], $matches )) {
                                        foreach($matches[1] AS $key=>$match) {
                                            $eventData[$element] = str_replace($matches[0][$key], $this->$method($match), $eventData[$element]);
                                        }
                                    }
                                }
                            }

                            if (isset($_comment) && $_comment !== $eventData['comment']) {
                                // no escape parsing, since changed
                                $eventData['dismark'] = true;
                            }

                            /* end textile processing */

                        }
                    }
                    break;

                case 'frontend_comment':
                    if (serendipity_db_bool($this->get_config('COMMENT', 'true'))) {
                        echo '<div class="serendipity_commentDirection serendipity_comment_textile">' . sprintf(PLUGIN_EVENT_TEXTILE_TRANSFORM, 'https://textile-lang.com/') . '</div>';
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

    function _process_tag_php($text)
    {

        $code = "<?php\n" . trim($text) . "\n?>";

        # Using OB, as highlight_string() only supports
        # returning the result from 4.2.0

        ob_start();
        highlight_string($code);
        $highlighted = ob_get_contents();
        ob_end_clean();

        # Fix output to use CSS classes and wrap well

        $highlighted = '<p><div class="phpcode">' . str_replace(
            array(
                '&nbsp;',
                '<br />',
                '<font color="',
                '</font>',
                "\n ",
                'Ê '
            ),
            array(
                ' ',
                "<br />\n",
                '<span class="',
                '</span>',
                "\n&#160;",
                '&#160; '
            ),
            $highlighted
        ) . '</div></p>';

        return $highlighted;

    }


    function _process_tag_output($text)
    {
        return '<p><pre class="output">' . $text . '</pre></p>';
    }

    function _process_tag_name($text)
    {
        return '<a name="'. $text . '"></a>';
    }

    function textile($string)
    {
        switch($this->get_config('textile_version')) {
            case 3:
                require_once S9Y_INCLUDE_PATH . 'plugins/serendipity_event_textile/lib3/src/Netcarver/Textile/Parser.php';
                require_once S9Y_INCLUDE_PATH . 'plugins/serendipity_event_textile/lib3/src/Netcarver/Textile/DataBag.php';
                require_once S9Y_INCLUDE_PATH . 'plugins/serendipity_event_textile/lib3/src/Netcarver/Textile/Tag.php';
                include 'textile_namespace.inc.php'; // PHP 5.2 compat
                // todo check for user-supplied output to restrict
                #    return $textile->setRestricted($string);
                if (is_object($textile)) return $textile->parse($string);
                break;
            case 1:
            case 2:
                require_once S9Y_INCLUDE_PATH . 'plugins/serendipity_event_textile/lib2/classTextile.php';
                $textile = new Textile();
                return $textile->textileThis($string);
                break;
        }
    }

}

/* vim: set sts=4 ts=4 expandtab : */
?>