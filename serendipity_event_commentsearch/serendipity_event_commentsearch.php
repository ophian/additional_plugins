<?php

declare(strict_types=1);

if (IN_serendipity !== true) {
    die ("Don't hack!");
}

@serendipity_plugin_api::load_language(dirname(__FILE__));

class serendipity_event_commentsearch extends serendipity_event
{
    public $title = COMMENTSEARCH_TITLE;

    function introspect(&$propbag)
    {
        global $serendipity;

        $propbag->add('name', COMMENTSEARCH_TITLE);
        $propbag->add('description', COMMENTSEARCH_DESC);
        $propbag->add('event_hooks', array(
            'entries_footer'        => true,
            'frontend_fetchentries' => true
        ));

        $propbag->add('author', 'Garvin Hicking, Ian Styx');
        $propbag->add('version', '3.0.0');
        $propbag->add('requirements',  array(
            'serendipity' => '5.0',
            'smarty'      => '4.1',
            'php'         => '8.2'
        ));
        $propbag->add('stackable', false);
        $propbag->add('groups',    array('FRONTEND_FEATURES'));
    }

    function setupDB()
    {
        global $serendipity;

        $built = $this->get_config('db_built', null);
        if (empty($built)) {
            $q = "@CREATE {FULLTEXT_MYSQL} INDEX commentbody_idx on {$serendipity['dbPrefix']}comments (title, body);";
            serendipity_db_schema_import($q);
            $this->set_config('db_built', 1);
        }
    }

    function showSearch()
    {
        global $serendipity;

        $this->setupDB();

        $term = serendipity_db_escape_string($serendipity['GET']['searchTerm']);
        if ($serendipity['dbType'] == 'postgres' || $serendipity['dbType'] == 'pdo-postgres') {
            $group     = '';
            $distinct  = 'DISTINCT';
            $term = str_replace('*', '', $term);
            $find_part = "(c.title ILIKE '%$term%' OR c.body ILIKE '%$term%')";
        } elseif (stristr($serendipity['dbType'], 'sqlite') !== FALSE) {
            $group     = 'GROUP BY id';
            $distinct  = '';
            $term      = mb_strtolower(str_replace('*', '', $term));
            $find_part = "(lower(c.title) LIKE '%$term%' OR lower(c.body) LIKE '%$term%')";
        } else { // MYSQL
            $group     = 'GROUP BY id';
            $distinct  = '';
            $term      = str_replace('&quot;', '"', $term);
            // See notes on limitations with Chinese, Japanese, and Korean languages in function_entries.inc
            if (preg_match('@["\+\-\*~<>\(\)]+@', $term)) {
                #$term = str_replace(' + ', ' +', $term); // be strict for boolean mode
                $find_part = "MATCH(c.title,c.body) AGAINST('{$term}' IN BOOLEAN MODE)";
            } else {
                $find_part = "MATCH(c.title,c.body) AGAINST('{$term}')";
            }
        }

        $querystring = "SELECT c.id AS cid, c.title AS ctitle, c.body, c.author, c.entry_id, c.timestamp AS ctimestamp, c.url, c.type,
                               e.id, e.title, e.timestamp
                          FROM {$serendipity['dbPrefix']}comments AS c
               LEFT OUTER JOIN {$serendipity['dbPrefix']}entries AS e
                            ON e.id = c.entry_id
                         WHERE c.status = 'approved'
                           AND $find_part
                               $group
                      ORDER BY c.timestamp DESC";

        $results = serendipity_db_query($querystring, false, 'assoc');
        if (!is_array($results)) {
            if ($results !== 1 && $results !== true) {
                echo htmlspecialchars($results, ENT_QUOTES | ENT_SUBSTITUTE | ENT_HTML401, LANG_CHARSET);
            }
            $results = array();
        }
        $myAddData = array("from" => "serendipity_plugin_commentsearch:generate_content");
        foreach($results AS $idx => $result) {
            $results[$idx]['permalink'] = serendipity_archiveURL($result['id'], $result['title'], 'baseURL', true, $result).'#c'.$result['cid'];
            $results[$idx]['comment']   = $result['body']; // htmlspecialchars(strip_tags($result['body']), ENT_QUOTES | ENT_SUBSTITUTE | ENT_HTML401, LANG_CHARSET);
            serendipity_plugin_api::hook_event('frontend_display', $results[$idx], $myAddData);
            // let the template decide, if we want to have tags or not
            $results[$idx]['commenthtml'] = $results[$idx]['comment'];
            $results[$idx]['comment']     = strip_tags($results[$idx]['comment']);
        }

        $serendipity['smarty']->assign(
            array(
                'comment_searchresults' => count($results),
                'comment_results'       => $results
            )
        );

        $filename = 'plugin_commentsearch_searchresults.tpl';
        $content = $this->parseTemplate($filename);
        // What about pagination or max results and what about length ? Any restrictions in effect ? What about paginated search entries ?
        // Current implementation is to append in any case. Same as for static pages. Do we really need to care?
        $serendipity['smarty']->assign('comment_search_result', $content); // pass to content.tpl for the case of an empty search on entries, but true on comments
        echo $content;
    }

    function event_hook($event, &$bag, &$eventData, $addData = null)
    {
        global $serendipity;

        $hooks = &$bag->get('event_hooks');

        if (isset($hooks[$event])) {
            switch ($event) {
                case 'frontend_fetchentries':
                    if ($serendipity['GET']['action'] == 'search') {
                        serendipity_smarty_fetch('ENTRIES', 'entries.tpl', true);
                    }
                    break;

                case 'entries_footer':
                    if (isset($serendipity['GET']['action']) && $serendipity['GET']['action'] == 'search') {
                        $this->showSearch();
                    }
                    break;

                default:
                    return false;
            }
            return true;
        }
        return false;
    }

}

/* vim: set sts=4 ts=4 expandtab : */
?>