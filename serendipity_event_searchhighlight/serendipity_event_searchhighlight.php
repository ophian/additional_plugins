<?php

/**********************************/
/*  Authored by Tom Sommer, 2004  */
/**********************************/

if (IN_serendipity !== true) {
    die ("Don't hack!");
}

// Load possible language files.
@serendipity_plugin_api::load_language(dirname(__FILE__));

class serendipity_event_searchhighlight extends serendipity_event
{
    public $title = PLUGIN_EVENT_SEARCHHIGHLIGHT_NAME;

    private $uri = null;

    function introspect(&$propbag)
    {
        global $serendipity;

        $propbag->add('name',          PLUGIN_EVENT_SEARCHHIGHLIGHT_NAME);
        $propbag->add('description',   PLUGIN_EVENT_SEARCHHIGHLIGHT_DESC);
        $propbag->add('stackable',     false);
        $propbag->add('author',        'Tom Sommer, Ian Styx');
        $propbag->add('version',       '2.4.0');
        $propbag->add('requirements',  array(
            'serendipity' => '2.9',
            'smarty'      => '3.1',
            'php'         => '8.0'
        ));
        $propbag->add('event_hooks',   array('frontend_display' => true, 'css' => true));
        $propbag->add('groups', array('FRONTEND_EXTERNAL_SERVICES'));

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
            ),
            array(
              'name'     => 'PLUGIN_EVENT_SEARCHHIGHLIGHT_STATICPAGE',
              'element'  => 'content',
            )
        );

        $conf_array = array();
        foreach($this->markup_elements AS $element) {
            $conf_array[] = $element['name'];
        }
        $propbag->add('configuration', $conf_array);
    }

    function generate_content(&$title)
    {
        $title = $this->title;
    }

    function introspect_config_item($name, &$propbag)
    {
        $propbag->add('type',        'boolean');
        $propbag->add('name',        constant($name));
        $propbag->add('description', sprintf(APPLY_MARKUP_TO, constant($name)));
        $propbag->add('default',     'true');
        return true;
    }

    function loadConstants()
    {
        @define('PLUGIN_EVENT_SEARCHHIGHLIGHT_NONE', 0);
        @define('PLUGIN_EVENT_SEARCHHIGHLIGHT_GOOGLE', 1);
        @define('PLUGIN_EVENT_SEARCHHIGHLIGHT_YAHOO', 2);
        @define('PLUGIN_EVENT_SEARCHHIGHLIGHT_LYCOS', 3);
        @define('PLUGIN_EVENT_SEARCHHIGHLIGHT_MSN', 4);
        @define('PLUGIN_EVENT_SEARCHHIGHLIGHT_ALTAVISTA', 5);
        @define('PLUGIN_EVENT_SEARCHHIGHLIGHT_AOL_DE', 6);
        @define('PLUGIN_EVENT_SEARCHHIGHLIGHT_AOL_COM', 7);
        @define('PLUGIN_EVENT_SEARCHHIGHLIGHT_BING', 8);
        @define('PLUGIN_EVENT_SEARCHHIGHLIGHT_S9Y', 9);
    }

    function getSearchEngine()
    {
        $url = parse_url($this->uri);

        /* Patterns should be placed in the order in which they are most likely to occur */
        if ( preg_match('@^(www\.)?google\.@i', $url['host']) ) {
            return PLUGIN_EVENT_SEARCHHIGHLIGHT_GOOGLE;
        }
        if ( preg_match('@^search\.yahoo\.@i', $url['host']) ) {
            return PLUGIN_EVENT_SEARCHHIGHLIGHT_YAHOO;
        }
        if ( preg_match('@^search\.lycos\.@i', $url['host']) ) {
            return PLUGIN_EVENT_SEARCHHIGHLIGHT_LYCOS;
        }
        if ( preg_match('@^search\.msn\.@i', $url['host']) ) {
            return PLUGIN_EVENT_SEARCHHIGHLIGHT_MSN;
        }
        if ( preg_match('@^(www\.)?altavista\.@i', $url['host']) ) {
            return PLUGIN_EVENT_SEARCHHIGHLIGHT_ALTAVISTA;
        }
        if ( preg_match('@^suche\.aol\.de@i', $url['host']) ) {
            return PLUGIN_EVENT_SEARCHHIGHLIGHT_AOL_DE;
        }
        if ( preg_match('@^search\.aol\.com@i', $url['host']) ) {
            return PLUGIN_EVENT_SEARCHHIGHLIGHT_AOL_COM;
        }
        if ( preg_match('@^(www\.)?bing\.@i', $url['host']) ) {
            return PLUGIN_EVENT_SEARCHHIGHLIGHT_BING;
        }

        if (!empty($_SESSION['search_referer']) && $this->uri != $_SESSION['search_referer']) {
            $this->uri = $_SESSION['search_referer'];
            return $this->getSearchEngine();
        }

        if ($url['host'] == $_SERVER['HTTP_HOST']) {
            return PLUGIN_EVENT_SEARCHHIGHLIGHT_S9Y;
        }

        return false;
    }

    function getQuery()
    {
        global $serendipity;

        if (empty($this->uri)) {
            return false;
        }

        $this->loadConstants();
        $url = parse_url($this->uri);
        if (isset($url['query'])) {
            parse_str($url['query'], $pStr);
        }

        $s = $this->getSearchEngine();

        switch($s) {
            case PLUGIN_EVENT_SEARCHHIGHLIGHT_S9Y:
                $query = $pStr['serendipity']['searchTerm'] ?? null;

                if (!empty($_REQUEST['serendipity']['searchTerm'])) {
                    $query = $_REQUEST['serendipity']['searchTerm'];
                }

                if (!empty($serendipity['GET']['searchTerm'])) {
                    $query = $serendipity['GET']['searchTerm'];
                }
                // obsolete now since query is set to searchTerm! And all static page summarized search results were never catched for highlight! Nor Comments.
                /* highlight selected static page, if not having a ['GET']['searchTerm'] REQUEST, but coming from a /search/ referrer
                if (empty($query)) {
                    // look out for path or query depending mod_rewrite setting
                    $urlpath = $serendipity['rewrite'] == 'rewrite' ? parse_url($_SERVER['HTTP_REFERER'], PHP_URL_PATH)
                                                                    : parse_url($_SERVER['HTTP_REFERER'], PHP_URL_QUERY);
                    if (!is_null($urlpath) && true === strpos($urlpath, 'search/')) {
                        $urlpath = serendipity_specialchars(strip_tags($urlpath)); // avoid spoofing
                        $path = explode('/', urldecode($urlpath)); // split and decode non ASCII
                        $query = $path[(array_search('search', $path)+1)];
                    }
                }*/
                break;

            case PLUGIN_EVENT_SEARCHHIGHLIGHT_MSN :
            case PLUGIN_EVENT_SEARCHHIGHLIGHT_BING :
            case PLUGIN_EVENT_SEARCHHIGHLIGHT_AOL_DE :
            case PLUGIN_EVENT_SEARCHHIGHLIGHT_ALTAVISTA :
            case PLUGIN_EVENT_SEARCHHIGHLIGHT_GOOGLE :
                $query = $pStr['q'];
                break;

            case PLUGIN_EVENT_SEARCHHIGHLIGHT_YAHOO :
                $query = $pStr['p'];
                break;

            case PLUGIN_EVENT_SEARCHHIGHLIGHT_AOL_COM :
            case PLUGIN_EVENT_SEARCHHIGHLIGHT_LYCOS :
                $query = $pStr['query'];
                break;

            default:
                if (isset($_REQUEST['serendipity']['searchTerm']) && $_REQUEST['serendipity']['searchTerm'] != '') {
                    $query = $_REQUEST['serendipity']['searchTerm'];
                } else {
                    return false;
                }
        }

        if (is_null($query)) {
            return false;
        }
        /* Clean the query */
        $query = trim($query);
        if (empty($query)) {
            return false;
        }
        $query = preg_replace('/(\"|\'|&quot;)/i', '', $query);

        /* Split by search engine chars or spaces */
        $words = preg_split('/[\s\,\+\.\-\/\=~<>(\)]+/', $query);

        /* Strip search engine keywords or common words we don't bother to highlight and for empty value strings */
        $words = array_diff($words, array('AND', 'OR', 'FROM', 'IN', ''));
        $words = array_values($words); // re-index for possible '' removal, so all relevant words get highlighted!

        return $words;
    }

    function event_hook($event, &$bag, &$eventData, $addData = null)
    {
        global $serendipity;

        // On paged search results we might have no HTTP_REFERER available (by theme) and so NO host (see getSearchEngine()). So we query our own here.
        // Works on all supported URL rewrite options; And the default theme. And we don't need to care about adding 'index.php?' or such.
        $this->uri = (!empty($serendipity['GET']['page']) && isset($serendipity['GET']['searchTerm']))
                        ? $serendipity['defaultBaseURL'] . '/search/' . urlencode($serendipity['GET']['searchTerm']) . '/P' . $serendipity['GET']['page'] . '.html'
                        : (
                            isset($serendipity['GET']['searchTerm'])
                                ? $serendipity['defaultBaseURL'] . '/search/' . urlencode($serendipity['GET']['searchTerm'])
                                : ($_SERVER['HTTP_REFERER'] ?? null)
                        );

        $hooks = &$bag->get('event_hooks');

        if (!isset($hooks[$event])) {
            return false;
        }

        if ($event == 'frontend_display') {
            if (($queries = $this->getQuery()) === false) {
                return;
            }

            $_SESSION['is_searchengine_visitor'] = true;
            $_SESSION['search_referer'] = $this->uri;

            foreach ($this->markup_elements AS $temp) {
                if (serendipity_db_bool($this->get_config($temp['name'], 'true')) && !empty($eventData[$temp['element']])
                &&  (!isset($eventData['properties']['ep_disable_markup_' . $this->instance]) || !$eventData['properties']['ep_disable_markup_' . $this->instance])
                &&  !isset($serendipity['POST']['properties']['disable_markup_' . $this->instance])) {
                    $element = &$eventData[$temp['element']];

                    // yeah its not 'content' as you would assume, its 'body' from passed staticpage $entry[body]
                    if ($temp['element'] == 'body') {
                        $checkhash_start = hash('xxh128', $element);
                    }
                    // Iterate over search terms and do the highlighting.
                    foreach ($queries AS $word) {
                        if (false !== strpos($word, '*')) {
                            // fuzzy search (case insensitive) all words containing term;
                            $word = str_replace('*', '', $word);
                            /* If the data contains HTML tags, we have to be careful not to break URIs and use a more complex preg */
                            if (preg_match('/\<.+\>/', $element)) {
                                $_pattern =  '/(?!<.*?)(' . preg_quote($word, '/') . ')(?![^<>]*?>)/im';
                            } else {
                                $_pattern = '/(' . preg_quote($word, '/') . ')/im';
                            }
                        } else {
                            /* If the data contains HTML tags, we have to be careful not to break URIs and use a more complex preg */
                            if (preg_match('/\<.+\>/', $element)) {
                                $_pattern =  '/(?!<.*?)(\b'. preg_quote($word, '/') .'\b)(?![^<>]*?>)/im';
                            } else {
                                $_pattern = '/(\b'. preg_quote($word, '/') .'\b)/im';
                            }
                        }
                        $element = preg_replace($_pattern, '<span class="serendipity_searchQuery">$1</span>', $element);
                    } // end foreach
                    // check it modified for staticpage
                    if ($temp['element'] == 'body') {
                        $checkhash_end = hash('xxh128', $element);
                        if ($checkhash_start !== $checkhash_end) {
                            $eventData['highlight_staticpage'] = true;
                        }
                    }
                }
            } // end foreach
            return;
        } // end if

        if ($event == 'css') {
            // CSS class does NOT exist by user customized template styles, include default
            if (strpos($eventData, '.serendipity_searchQuery') === false) {
                $eventData .= '

/* serendipity_event_searchhighlight start */

.serendipity_searchQuery {
    background-color: #D81F2A;
    color: #FFFFFF;
}

/* serendipity_event_searchhighlight end */

';
            }
            return;
        }

    } // end function

}

/* vim: set sts=4 ts=4 expandtab : */
?>