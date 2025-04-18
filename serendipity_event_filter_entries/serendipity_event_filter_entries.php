<?php

if (IN_serendipity !== true) {
    die ("Don't hack!");
}

@serendipity_plugin_api::load_language(dirname(__FILE__));

class serendipity_event_filter_entries extends serendipity_event
{
    var $title = PLUGIN_EVENT_FILTER_ENTRIES_NAME;
    var $fetchLimit;

    function introspect(&$propbag)
    {
        global $serendipity;

        $propbag->add('name',          PLUGIN_EVENT_FILTER_ENTRIES_NAME);
        $propbag->add('description',   PLUGIN_EVENT_FILTER_ENTRIES_DESC);
        $propbag->add('stackable',     false);
        $propbag->add('author',        'Garvin Hicking, Ian Styx');
        $propbag->add('version',       '2.2.1');
        $propbag->add('requirements',  array(
            'serendipity' => '3.0',
            'smarty'      => '3.1',
            'php'         => '7.2'
        ));
        $propbag->add('event_hooks',    array(
            'external_plugin'    => true,
            'entries_footer'     => true,
            'frontend_configure' => true,
            'css'                => true,
            'frontend_fetchentries' => true
        ));
        $propbag->add('groups', array('FRONTEND_VIEWS'));
        $propbag->add('legal',    array(
            'services' => array(
            ),
            'frontend' => array(
                'Temporarily stores user-selected sort order and search restrictions in a PHP session variable on the server, which requires a PHP session cookie',
            ),
            'backend' => array(
            ),
            'cookies' => array(
                'Temporarily stores user-selected sort order and search restrictions in a PHP session variable on the server, which requires a PHP session cookie',
            ),
            'stores_user_input'     => false,
            'stores_ip'             => false,
            'uses_ip'               => false,
            'transmits_user_input'  => false
        ));
    }

    function generate_content(&$title)
    {
        $title = $this->title;
    }

    function event_hook($event, &$bag, &$eventData, $addData = null)
    {
        global $serendipity;

        $hooks = &$bag->get('event_hooks');
        $links = array();

        if (isset($hooks[$event])) {
            $sort_order = array('timestamp'     => DATE,
                                'isdraft'       => PUBLISH . '/' . DRAFT,
                                'a.realname'    => AUTHOR,
                                'category_name' => CATEGORY,
                                'last_modified' => LAST_UPDATED,
                                'title'         => TITLE);
            $per_page_max = 50;
            $per_page = array('12', '16', '25', $per_page_max);

            switch($event) {
                case 'frontend_fetchentries':
                    if ($this->fetchLimit > 0) {
                        $serendipity['fetchLimit'] = $this->fetchLimit;
                    }
                    break;

                case 'frontend_configure':
                    $_SERVER['REQUEST_URI'] = str_replace('%2Fplugin%2Ffilter%2F', '/plugin/filter/', $_SERVER['REQUEST_URI']);
                    break;

                case 'css':
                    if (false !== strpos($eventData, '#filter_entries_container')) {
                        // This CSS is already filter_entries-aware.
                        break;
                    }
                    $eventData .= '

/* serendipity_event_filter_entries mobile start */

@media screen and (max-width: 560px) {
    #filter_entries_container {
        display: block;
        width: auto;
        overflow-x: scroll;
        line-height: 2;
    }
    #filter_entries_container select,
    #filter_entries_container input {
        display: inline-block;
        width: auto;
    }
    #filter_entries_container td {
        display: block;
        width: 100%;
    }
}

/* serendipity_event_filter_entries mobile end */
';
                    break;

                case 'entries_footer':
                    // don't do this in mode preview iframe, we use GET, since $serendipity['preview'] isn't available (yet?)
                    if (empty($serendipity['GET']['preview']) && in_array($serendipity['view'], ['archive', 'archives', 'start', 'entries', 'entry'])) {
                        $link = $serendipity['baseURL'] . ($serendipity['rewrite'] == 'none' ? $serendipity['indexFile'] . '?/' : '') . 'plugin/filter/';
?>
<div id="filter_entries_container">
    <br />
    <hr />
    <form action="<?php echo $link; ?>" method="get">

    <?php if ($serendipity['rewrite'] == 'none') { ?>
    <input type="hidden" name="/plugin/filter/" value=""/>
    <?php } ?>
    <table width="100%">
        <tr>
            <td colspan="6" style="text-align: left"><strong><?php echo FILTERS ?></strong> - <?php echo FIND_ENTRIES ?></td>
        </tr>
        <tr>
            <td width="80"><?php echo AUTHOR ?></td>
            <td>
                <select name="filter[author]">
                    <option value="">--</option>
<?php
                    $users = serendipity_fetchUsers();
                    if (is_array($users)) {
                        foreach ($users AS $user) {
                            echo '<option value="' . $user['authorid'] . '"' . (isset($_SESSION['filter']['author']) && $_SESSION['filter']['author'] == $user['authorid'] ? ' selected="selected"' : '') . '>' . (function_exists('serendipity_specialchars') ? serendipity_specialchars($user['realname']) : htmlspecialchars($user['realname'], ENT_COMPAT, LANG_CHARSET)) . '</option>' . "\n";
                        }
                    }
?>              </select>
            </td>
            <td width="80"><?php echo CATEGORY ?></td>
            <td>
                <select name="filter[category]">
                    <option value="">--</option>
<?php
                    $categories = serendipity_fetchCategories();
                    $categories = serendipity_walkRecursive($categories, 'categoryid', 'parentid', VIEWMODE_THREADED);
                    foreach($categories AS $cat) {
                        echo '<option value="'. $cat['categoryid'] .'"'. (isset($_SESSION['filter']['category']) && $_SESSION['filter']['category'] == $cat['categoryid'] ? ' selected="selected"' : '') .'>'. str_repeat('&nbsp;', $cat['depth']) . $cat['category_name'] .'</option>' . "\n";
                    }
?>              </select>
            </td>
            <td width="80"><span title="<?= REQUIRED_FIELD ?>"><?php echo CONTENT ?> *</span></td>
            <td><input size="10" type="text" name="filter[body]" value="<?php echo (isset($_SESSION['filter']['body']) ? (function_exists('serendipity_specialchars') ? serendipity_specialchars($_SESSION['filter']['body']) : htmlspecialchars($_SESSION['filter']['body'], ENT_COMPAT, LANG_CHARSET)) : '') ?>"/></td>
        </tr>
        <tr>
            <td colspan="6" style="text-align: left"><strong><?php echo SORT_ORDER ?></strong></td>
        </tr>
        <tr>
            <td><?php echo SORT_BY ?></td>
            <td>
                <select name="sort[order]">
<?php
    foreach($sort_order AS $so_key => $so_val) {
        echo '<option value="' . $so_key . '"' . (isset($_SESSION['sort']['order']) && $_SESSION['sort']['order'] == $so_key ? ' selected="selected"': '') . '>' . $so_val . '</option>' . "\n";
    }
?>              </select>
            </td>
            <td><?php echo SORT_ORDER ?></td>
            <td>
                <select name="sort[ordermode]">
                    <option value="DESC"<?php echo (isset($_SESSION['sort']['ordermode']) && $_SESSION['sort']['ordermode'] == 'DESC' ? ' selected="selected"' : '') ?>><?php echo SORT_ORDER_DESC ?></option>
                    <option value="ASC"<?php echo (isset($_SESSION['sort']['ordermode']) && $_SESSION['sort']['ordermode'] == 'ASC'  ? ' selected="selected"' : '') ?>><?php echo SORT_ORDER_ASC ?></option>
                </select>
            </td>
            <td><?php echo ENTRIES_PER_PAGE ?></td>
            <td>
                <select name="sort[perPage]">
<?php
    foreach($per_page AS $per_page_nr) {
       echo '<option value="' . $per_page_nr . '"' . (isset($_SESSION['sort']['perPage']) && $_SESSION['sort']['perPage'] == $per_page_nr ? ' selected="selected"' : '') . '>' . $per_page_nr . '</option>' . "\n";
    }

?>
                </select>
            </td>
        </tr>
        <tr>
            <td align="right" colspan="6"><input type="submit" name="go" value="<?php echo GO ?>" class="serendipityPrettyButton" /></td>
        </tr>
    </table>
</form>
</div>
<?php
                    }
                    break;

                case 'external_plugin':
                    $uri_parts  = explode('?', str_replace('&amp;', '&', $eventData));
                    $parts      = explode('/', $uri_parts[0]);
                    $plugincode = $parts[0];
                    unset($parts[0]);
                    $uri = $_SERVER['REQUEST_URI'];
                    $puri = parse_url($uri);

                    $queries = explode('&', str_replace(array('%5B', '%5D'), array('[', ']'), ($puri['query'] ?? '')));
                    foreach($queries AS $query_part) {
                        $query = explode('=', $query_part);

                        switch($query[0]) {
                            case 'filter[author]':
                                $_GET['filter']['author']   = urldecode($query[1]);
                                break;

                            case 'filter[category]':
                                $_GET['filter']['category'] = urldecode($query[1]);
                                break;

                            case 'filter[body]':
                                $_GET['filter']['body']     = urldecode($query[1]);
                                break;

                            case 'sort[order]':
                                $_GET['sort']['order']      = urldecode($query[1]);
                                break;

                            case 'sort[ordermode]':
                                $_GET['sort']['ordermode']  = urldecode($query[1]);
                                break;

                            case 'sort[perPage]':
                                $_GET['sort']['perPage']    = urldecode($query[1]);
                                break;

                        }
                    }

                    if (isset($_GET['filter']) && is_array($_GET['filter'])) {
                        $_SESSION['filter'] = $_GET['filter'];
                    }

                    if (isset($_GET['sort']) && is_array($_GET['sort'])) {
                        $_SESSION['sort']   = $_GET['sort'];
                    }

                    /* Attempt to locate hidden variables within the URI */
                    foreach ($serendipity['uriArguments'] AS $k => $v){
                        if ($k === array_key_last($serendipity['uriArguments']) && isset($v[0]) && $v[0] == 'P') { /* Page */
                            $page = substr($v, 1);
                            if (is_numeric($page)) {
                                $serendipity['GET']['page'] = $page;
                                unset($serendipity['uriArguments'][$k]);
                            }
                        }
                    }

                    switch($plugincode) {
                        case 'filter':
                            $full = false;
                            $perPage = (int)(!empty($_SESSION['sort']['perPage']) ? $_SESSION['sort']['perPage'] : $per_page[0]);
                            if ($perPage > $per_page_max) {
                                $perPage = $per_page_max;
                            }
                            $serendipity['fetchLimit'] = $perPage;
                            $this->fetchLimit          = $perPage;

                            $page    = (int)($serendipity['GET']['page'] ?? null);
                            if ($page == 0) $page = 1;
                            $offSet  = $perPage*($page-1);

                            if (empty($_SESSION['sort']['ordermode']) || $_SESSION['sort']['ordermode'] != 'ASC') {
                                $_SESSION['sort']['ordermode'] = 'DESC';
                            }

                            if (!empty($_SESSION['sort']['order']) && !empty($sort_order[$_SESSION['sort']['order']])) {
                                $orderby = serendipity_db_escape_string($_SESSION['sort']['order'] . ' ' . $_SESSION['sort']['ordermode']);
                            } else {
                                $orderby = 'timestamp ' . serendipity_db_escape_string($_SESSION['sort']['ordermode']);
                            }

                            $filter = array();
                            if (!empty($_SESSION['filter']['author'])) {
                                $filter[] = "e.authorid = '" . serendipity_db_escape_string($_SESSION['filter']['author']) . "'";
                            }

                            if (!empty($_SESSION['filter']['category'])) {
                                $filter[] = "ec.categoryid = '" . serendipity_db_escape_string($_SESSION['filter']['category']) . "'";
                            }

                            if (!empty($_SESSION['filter']['body'])) {
                                $term = serendipity_db_escape_string($_SESSION['filter']['body']);
                                $full = true;
                            }
                            if ($full && $serendipity['dbType'] == 'postgres' || $serendipity['dbType'] == 'pdo-postgres') {
                                $term = str_replace('*', '', $term);
                                $filter[] = "(title ILIKE '%$term%' OR body ILIKE '%$term%' OR extended ILIKE '%$term%')"; // Using percentage (%) wildcard already
                            } elseif ($full && $serendipity['dbType'] == 'sqlite' || $serendipity['dbType'] == 'sqlite3' || $serendipity['dbType'] == 'pdo-sqlite' || $serendipity['dbType'] == 'sqlite3oo') {
                                $term = str_replace('*', '', $term);
                                $term = mb_strtolower($term);
                                $filter[] = "(lower(title) LIKE '%$term%' OR lower(body) LIKE '%$term%' OR lower(extended) LIKE '%$term%')"; // Using percentage (%) wildcard already
                            } elseif ($full && $serendipity['dbType'] == 'mysqli') {
                                // See notes on limitations with Chinese, Japanese, and Korean languages in function_entries.inc
                                if (isset($term) && preg_match('@["\+\-\*~<>\(\)]+@', $term)) {
                                    #$term = str_replace(' + ', ' +', $term); // be strict for boolean mode
                                    $filter[] = "MATCH (title,body,extended) AGAINST ('" . $term . "' IN BOOLEAN MODE)";
                                } else {
                                    $filter[] = !isset($term) ? '1' : "MATCH (title,body,extended) AGAINST ('" . $term . "')";
                                }
                            } else {
                                $filter[] = "MATCH (title,body,extended) AGAINST ('" . ($term ?? '1') . "')";
                            }

                            $filter_sql = implode(' AND ', $filter);

                            // Fetch the entries
                            $entries = serendipity_fetchEntries(
                                         false,
                                         false,
                                         serendipity_db_limit(
                                           $offSet,
                                           $perPage
                                         ),
                                         true,
                                         false,
                                         $orderby,
                                         $filter_sql
                                       );

                            $serendipity['smarty_raw_mode'] = true;
                            $serendipity['GET']['action'] = 'empty'; // allows the correct pagination and outputs searched only entries, else you get em all and the filtered ones appended
                            include_once(S9Y_INCLUDE_PATH . 'include/genpage.inc.php'); // sets index, sidebars

                            $raw_data = serendipity_printEntries($entries); // sets the content (entries) part

                            $serendipity['smarty']->assign('CONTENT', $raw_data);
                            $serendipity['smarty']->assign('is_raw_mode', false);
                            serendipity_gzCompression();
                            $serendipity['smarty']->display(serendipity_getTemplateFile($serendipity['smarty_file'], 'serendipityPath'));
                            break;
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

/* vim: set sts=4 ts=4 expandtab : */
?>