<?php

declare(strict_types=1);

if (IN_serendipity !== true) {
    die ("Don't hack!");
}

@serendipity_plugin_api::load_language(dirname(__FILE__));

class serendipity_event_externalphp extends serendipity_event
{
    public $title = PLUGIN_EXTERNALPHP_TITLE;

    function introspect(&$propbag)
    {
        global $serendipity;

        $propbag->add('name', PLUGIN_EXTERNALPHP_TITLE);
        $propbag->add('description', PLUGIN_EXTERNALPHP_TITLE_BLAHBLAH);
        $propbag->add('event_hooks',  array('entries_header' => true, 'entry_display' => true, 'genpage' => true));
        $propbag->add('configuration', array('permalink', 'pagetitle', 'include', 'articleformat', 'markup'));
        $propbag->add('author', 'Garvin Hicking, Ian Styx');
        $propbag->add('version', '2.0.0');
        $propbag->add('requirements',  array(
            'serendipity' => '5.0',
            'smarty'      => '4.1',
            'php'         => '8.2'
        ));
        $propbag->add('groups', array('FRONTEND_EXTERNAL_SERVICES'));
        $propbag->add('stackable', true);
    }

    function introspect_config_item($name, &$propbag)
    {
        global $serendipity;

        switch($name) {
            case 'permalink':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_EXTERNALPHP_PERMALINK);
                $propbag->add('description', PLUGIN_EXTERNALPHP_PERMALINK_BLAHBLAH);
                $propbag->add('default',     $serendipity['rewrite'] != 'none'
                                             ? $serendipity['serendipityHTTPPath'] . 'pages/phpname.html'
                                             : $serendipity['serendipityHTTPPath'] . $serendipity['indexFile'] . '?/pages/phpname.html');
                break;

            case 'include':
                // THIS IS AN EVIL EVIL PLUGIN.
                if ($serendipity['serendipityUserlevel'] < USERLEVEL_ADMIN) {
                    return false;
                }

                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_EXTERNALPHP_INCLUDE);
                $propbag->add('description', PLUGIN_EXTERNALPHP_INCLUDE_DESC);
                $propbag->add('default',     $serendipity['serendipityPath'] . 'include/your_php.inc.php');
                break;

            case 'pagetitle':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_EXTERNALPHP_PAGETITLE);
                $propbag->add('description', '');
                $propbag->add('default',     'phpname');
                break;

            case 'articleformat':
                $propbag->add('type',        'boolean');
                $propbag->add('name',        PLUGIN_EXTERNALPHP_ARTICLEFORMAT);
                $propbag->add('description', PLUGIN_EXTERNALPHP_ARTICLEFORMAT_BLAHBLAH);
                $propbag->add('default',     'true');
                break;

            case 'markup':
                $propbag->add('type',           'boolean');
                $propbag->add('name',           DO_MARKUP);
                $propbag->add('description',    DO_MARKUP_DESCRIPTION);
                $propbag->add('default',        'false');
                break;

            default:
                return false;
        }
        return true;
    }

    function show()
    {
        global $serendipity;

        if ($this->selected()) {
            if (!headers_sent()) {
                header('HTTP/1.0 200');
                header('Status: 200 OK');
            }

            if (!isset($serendipity['smarty']) || !is_object($serendipity['smarty'])) {
                serendipity_smarty_init();
            }

            $_ENV['staticpage_pagetitle'] = preg_replace('@[^a-z0-9]@i', '_',$this->get_config('pagetitle'));
            $serendipity['smarty']->assign('staticpage_pagetitle', $_ENV['staticpage_pagetitle']);

            $articleformat = serendipity_db_bool($this->get_config('articleformat', 'true'));

            if ($articleformat === true) {
                echo '<div class="serendipity_Entry_Date">
                         <h3 class="serendipity_date">' . $this->get_config('pagetitle') . '</h3>';
            }

            echo '<h4 class="serendipity_title"><a href="#">' . $this->get_config('headline') . '</a></h4>';

            if ($articleformat === true) {
                echo '<div class="serendipity_entry"><div class="serendipity_entry_body">';
            }

            $include_file = realpath($this->get_config('include'));
            $content = null;
            ob_start();
              include $include_file;
              $content = ob_get_contents();
            ob_end_clean();

            if (serendipity_db_bool($this->get_config('markup', 'false')) === true) {
                $entry = array('body' => $content);
                serendipity_plugin_api::hook_event('frontend_display', $entry);
                echo $entry['body'];
            } else {
                echo $content;
            }

            if ($articleformat === true) {
                echo "</div>\n</div>\n</div>\n";
            }
        }
    }

    function selected()
    {
        global $serendipity;

        if (isset($serendipity['GET']['subpage'])
        && ($serendipity['GET']['subpage'] == $this->get_config('pagetitle') || preg_match('@^' . preg_quote($this->get_config('permalink')) . '@i', $serendipity['GET']['subpage']))) {
            return true;
        }

        return false;
    }

    function generate_content(&$title)
    {
        $title = PLUGIN_EXTERNALPHP_TITLE.' (' . $this->get_config('pagetitle') . ')';
    }

    function event_hook($event, &$bag, &$eventData, $addData = null)
    {
        global $serendipity;

        $hooks = &$bag->get('event_hooks');

        if (isset($hooks[$event])) {
            switch($event) {
                case 'genpage':
                    if ($serendipity['rewrite'] != 'none') {
                        $nice_url = $serendipity['serendipityHTTPPath'] . $addData['uriargs'];
                    } else {
                        $nice_url = $serendipity['serendipityHTTPPath'] . $serendipity['indexFile'] . '?/' . $addData['uriargs'];
                    }

                    if (empty($serendipity['GET']['subpage'])) {
                        $serendipity['GET']['subpage'] = $nice_url;
                    }
                    break;

                case 'entry_display':
                    if ($this->selected()) {
                        if (is_array($eventData)) {
                            $eventData['clean_page'] = true; // This is important to not display an entry list!
                        } else {
                            $eventData = array('clean_page' => true);
                        }
                    }
                    break;

                case 'entries_header':
                    $this->show();
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
