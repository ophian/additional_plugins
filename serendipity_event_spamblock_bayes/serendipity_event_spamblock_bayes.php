<?php

declare(strict_types=1);

if (IN_serendipity !== true) {
    die ("Don't hack!");
}

@serendipity_plugin_api::load_language(dirname(__FILE__));

#[\AllowDynamicProperties]
class serendipity_event_spamblock_bayes extends serendipity_event
{
    function introspect(&$propbag)
    {
        global $serendipity;

        $this->title = PLUGIN_EVENT_SPAMBLOCK_BAYES_NAME;

        $propbag->add('description',    PLUGIN_EVENT_SPAMBLOCK_BAYES_DESC);
        $propbag->add('name',           $this->title);
        $propbag->add('version',        '3.1.0');
        $propbag->add('requirements',   array(
            'serendipity' => '5.0',
            'smarty'      => '4.1',
            'php'         => '8.2'
        ));
        $propbag->add('event_hooks',  array('frontend_saveComment' => true,
                                            'backend_comments_top' => true,
                                            'external_plugin' => true,
                                            'css_backend' => true,
                                            'backend_view_comment' => true,
                                            'xmlrpc_comment_spam' => true,
                                            'xmlrpc_comment_ham' => true,
                                            'js_backend' => true,
                                            'css_backend' => true,
                                            'backend_sidebar_admin_appearance' => true,
                                            'backend_sidebar_entries_event_display_spamblock_bayes' => true
        ));
        $propbag->add('groups',         array('ANTISPAM'));
        $propbag->add('author',         'kleinerChemiker, Malte Paskuda, based upon b8 by Tobias Leupold, Mario Hommmel, Ian Styx');
        $propbag->add('configuration',  array(
            'method',
            'recycler'
        ));
        $propbag->add('legal',    array(
            'services' => array(
            ),
            'frontend' => array(
                'All user data and metadata (IP address, comment fields) can be logged to a database or file, and partially are used for SPAM / HAM filter measurements'
            ),
            'backend' => array(
            ),
            'cookies' => array(
            ),
            'stores_user_input'     => true,
            'stores_ip'             => true,
            'uses_ip'               => true,
            'transmits_user_input'  => true
        ));
    }

    function introspect_config_item($name, &$propbag)
    {
        global $serendipity;

        switch($name) {
            case 'method':
                $propbag->add('type', 'select');
                $propbag->add('name', PLUGIN_EVENT_SPAMBLOCK_METHOD);
                $propbag->add('description', PLUGIN_EVENT_SPAMBLOCK_METHOD_DESC);
                $propbag->add('select_values', array(
                                                    'moderate'   => PLUGIN_EVENT_SPAMBLOCK_BAYES_METHOD_MODERATE,
                                                    'block'      => PLUGIN_EVENT_SPAMBLOCK_BAYES_METHOD_BLOCK,
                                                    ));
                $propbag->add('default', 'moderation');
                break;

            case 'recycler':
                $propbag->add('type', 'boolean');
                $propbag->add('name', PLUGIN_EVENT_SPAMBLOCK_BAYES_MENU_RECYCLER);
                $propbag->add('description', PLUGIN_EVENT_SPAMBLOCK_BAYES_RECYCLER_DESC);
                $propbag->add('default', 'true');
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

    /**
     * Install the bayes database tables
     *
     * @access public
     * @return void
     */
    public function install()
    {
        $this->setupDB();
    }

    /**
     * initialize the db at first install or change after upgrade
     */
    function setupDB()
    {
        global $serendipity;

        $built = $this->get_config('db_built', null);

        if (is_null($built)) {

            if ($serendipity['dbType'] == 'mysqli') {
                // Print the MySQL version
                $serendipity['db_server_info'] = $serendipity['db_server_info'] ?? mysqli_get_server_info($serendipity['dbConn']); // eg.  == 5.5.5-10.4.11-MariaDB
                // be a little paranoid...
                if (substr($serendipity['db_server_info'], 0, 6) === '5.5.5-') {
                    // strip any possible added prefix having this 5.5.5 version string (which was never released). PHP up from 8.0.16 now strips it correctly.
                    $serendipity['db_server_info'] = str_replace('5.5.5-', '', $serendipity['db_server_info']);
                }
                $db_version_match = explode('-', $serendipity['db_server_info']);
                if (stristr(strtolower($serendipity['db_server_info']), 'mariadb')) {
                    if (version_compare($db_version_match[0], '10.5.0', '>=')) {
                        $length = 255; // MariaDB 10.5 ARIA versions with max key 2000 bytes
                    } elseif (version_compare($db_version_match[0], '10.3.0', '>=')) {
                        $length = 250; // MariaDB 10.3 and 10.4 ARIA versions with max key 1000 bytes
                    } else {
                         $length = 191; // for old InnoDB
                    }
                } else {
                    // Oracle MySQL - https://dev.mysql.com/doc/refman/5.7/en/innodb-limits.html
                    if (version_compare($db_version_match[0], '5.7.7', '>=')) {
                         $length = 255; // 255 varchar key length - InnoDB (Since MySQL 5.7 innodb_large_prefix is enabled by default allowing up to 3072 bytes)
                    } else {
                         $length = 191; // // 191 varchar key length - old Oracles MySQL InnoDB (191 characters * 4 bytes = 764 bytes which is less than the maximum length of 767 bytes allowed when innoDB_large_prefix is disabled)
                    }
                }
            } else {
                // everything else
                $length = 255;
            }
            # b8 needs to one table for the tokens - using the old name without dbPrefix - see later
            $sql = "CREATE TABLE IF NOT EXISTS b8_wordlist(
              token varchar($length) {PRIMARY} NOT NULL,
              count_ham int {UNSIGNED} default NULL,
              count_spam int {UNSIGNED} default NULL
            ) {UTF_8}";
            serendipity_db_schema_import($sql);

            # recycler-table
            switch ($serendipity['dbType']) {
                case 'mysqli':
                    $sql = "INSERT IGNORE INTO b8_wordlist (token, count_ham) VALUES ('b8*dbversion', 3)";
                    serendipity_db_query($sql);
                    $sql = "INSERT IGNORE INTO b8_wordlist (token, count_ham, count_spam) VALUES ('b8*texts', 0, 0)";
                    serendipity_db_query($sql);

                    # our recycler bin needs to copy the comments table
                    $sql = "CREATE TABLE IF NOT EXISTS
                            {$serendipity['dbPrefix']}spamblock_bayes_recycler
                            LIKE
                            {$serendipity['dbPrefix']}comments";
                    serendipity_db_schema_import($sql);
                    break;

                case 'pdo-sqlite':
                    $sql = "INSERT OR IGNORE INTO b8_wordlist (token, count_ham) VALUES ('b8*dbversion', 3)";
                    serendipity_db_query($sql);
                    $sql = "INSERT OR IGNORE INTO b8_wordlist (token, count_ham, count_spam) VALUES ('b8*texts', 0, 0)";
                    serendipity_db_query($sql);

                    # To get all column definitions we get the SQL used for creating the original table
                    $sql = "SELECT sql FROM sqlite_master WHERE type = 'table' AND name = '{$serendipity['dbPrefix']}comments'";
                    $sql = serendipity_db_query($sql);
                    if (is_array($sql)) {
                        $sql = $sql[0][0];
                    }
                    $sql = str_replace("{$serendipity['dbPrefix']}comments", "{$serendipity['dbPrefix']}spamblock_bayes_recycler", $sql);
                    if (strpos($sql, 'NOT EXISTS') === false) {
                        $sql = str_replace("CREATE TABLE", "CREATE TABLE IF NOT EXISTS", $sql);
                    }
                    serendipity_db_schema_import($sql);
                    break;

                default:
                    $sql = "CREATE TABLE IF NOT EXISTS
                        {$serendipity['dbPrefix']}spamblock_bayes_recycler
                        AS SELECT * FROM
                        {$serendipity['dbPrefix']}comments ORDER BY id LIMIT 1 WITH NO DATA";
                    serendipity_db_schema_import($sql);
            }
            $this->set_config('db_built', 1);
            $built = 1;
        }
        switch($built) {
            case 1: // RENAME the b8 TABLE without prefix
            case 2:
                if (stristr($serendipity['dbType'], 'sqlite')) {
                    $sql = "SELECT name FROM sqlite_schema WHERE type = 'table' AND 'b8_wordlist'";
                    $oldname = serendipity_db_query($sql);
                }
                if (stristr($serendipity['dbType'], 'mysql')) {
                    $sql = 'SHOW TABLES LIKE "b8_wordlist"';
                    $oldname = serendipity_db_query($sql);
                }
                if (!empty($oldname)) {
                    $q = "ALTER TABLE `b8_wordlist` RENAME TO `{$serendipity['dbPrefix']}b8_wordlist`";
                    serendipity_db_schema_import($q);
                }
                $this->set_config('db_built', 4);
                break;
            case 3: // Fix it once for sqlite PDO
                if (stristr($serendipity['dbType'], 'sqlite')) {
                    $q = "ALTER TABLE `b8_wordlist` RENAME TO `{$serendipity['dbPrefix']}b8_wordlist`";
                    serendipity_db_schema_import($q);
                }
                $this->set_config('db_built', 4);
                break;
       }
    }


    function event_hook($event, &$bag, &$eventData, $addData = null)
    {
        global $serendipity;

        $hooks = &$bag->get('event_hooks');

        if (isset ( $hooks [$event] )) {

            switch ($event) {

                case 'external_plugin':
                    switch ($eventData) {
                        case 'bayes_learncomment':
                            if (!serendipity_checkPermission('adminComments')) {
                                break;
                            }
                            $category = $_REQUEST['category'];
                            $ids = $_REQUEST['id'];
                            $ids = explode(';', $ids);
                            foreach($ids AS $id) {
                                $databaseComment = $this->getComment($id)[0];

                                $comment = $databaseComment['url'] . ' ' . strip_tags($databaseComment['body']) . ' ' . $databaseComment['author'] . ' ' . $databaseComment['email'];

                                $this->learn($comment, $category);

                                // Ham shall be approved, Spam deleted
                                if ($category == 'ham') {
                                    serendipity_approveComment($id, $databaseComment['entry_id']);
                                }
                                if ($category == 'spam') {
                                    if ($this->get_config('recycler', true)) {
                                        $this->recycleComment($id, $databaseComment['entry_id']);
                                    }
                                    serendipity_deleteComment($id, $databaseComment['entry_id']); // BE aware, if this is a comment parent, which already has threaded children, it is NOT nuked and only the comment body text is purged to contain COMMENT_DELETED, which is a core functionality AND can NOT be made undone in case it returns from recycler.
                                }
                            }
                            break;

                        case 'bayes_recycle':
                            if (!serendipity_checkPermission('adminComments')) {
                                break;
                            }
                            if (!empty($_REQUEST['serendipity']['selected'])) {
                                $ids = array_keys($_REQUEST['serendipity']['selected']);
                            }
                            if (isset($_REQUEST['restore'])) {
                                if (!empty($ids)) {
                                    $this->restoreComments($ids);

                                    if (count($ids) > 1) {
                                        $msg = 'Comments '. implode(', ', $ids) .' restored';
                                    } else {
                                        $msg = 'Comment '. implode(', ', $ids) .' restored';
                                    }
                                    $msgtype = 'success';
                                } else {
                                    $msg = 'No comment selected';
                                    $msgtype = 'message';
                                }
                            }

                            if (isset($_REQUEST['empty'])) {
                                $this->emptyRecycler();
                            }

                            $redirect= '<meta http-equiv="REFRESH" content="0;url=';
                            $url = 'serendipity_admin.php?serendipity[adminModule]=event_display';
                            $url .= '&amp;serendipity[adminAction]=spamblock_bayes">';
                            echo $redirect . $url;
                            break;
                    }
                    break;

                case 'frontend_saveComment':
                    if (! is_array ( $eventData ) || serendipity_db_bool ( $eventData ['allow_comments'] )) {
                        if (!isset($serendipity['csuccess'])) {
                            $serendipity['csuccess'] = 'true';
                        }

                        $comment = $addData['url'] . ' ' . strip_tags($addData['comment']) . ' ' . $addData['name'] . ' ' . $addData['email'];

                        if ($this->rate($comment) > 0.8) {
                            $method = $this->get_config('method', 'moderate');
                            if ($method == 'moderate') {
                                $this->moderate($eventData, $addData);
                                return false;
                            } elseif($method == 'block') {
                                $this->block($eventData, $addData);
                                return false;
                            }
                        }
                    }
                    break;

                case 'backend_view_comment':
                    if ($eventData['type'] == 'NORMAL') {
                        $comment = ($eventData['url'] ?? '') . ' ' . ($eventData['fullBody'] ?? '') . ' ' . ($eventData['name'] ?? '') . ' ' . ($eventData['email'] ?? '');
                        if (!isset($eventData['action_more']) || !is_string($eventData['action_more'])) $eventData['action_more'] = ''; // bayes and spamblock akismet place it
                        $eventData['action_more'] .= '<li><a class="button_link spamblockBayesControls" onclick="return ham('. $eventData['id'].');" title="'. PLUGIN_EVENT_SPAMBLOCK_BAYES_NAME . ': ' . PLUGIN_EVENT_SPAMBLOCK_BAYES_HAM .'"><span class="icon-ok-circled" aria-hidden="true"></span><span class="visuallyhidden"> ' . PLUGIN_EVENT_SPAMBLOCK_BAYES_HAM .'</span></a></li>';
                        $eventData['action_more'] .= '<li><a class="button_link spamblockBayesControls" onclick="return spam('. $eventData['id'] .');" title="'. PLUGIN_EVENT_SPAMBLOCK_BAYES_NAME . ': ' . PLUGIN_EVENT_SPAMBLOCK_BAYES_SPAM .'"><span class="icon-cancel" aria-hidden="true"></span><span class="visuallyhidden"> ' . PLUGIN_EVENT_SPAMBLOCK_BAYES_SPAM .'</span></a></li>';
                        $eventData['action_more'] .= '<li class="bayes_spamrating"><span id="' . $eventData['id'] . '_rating" title="'. PLUGIN_EVENT_SPAMBLOCK_BAYES_NAME . '"> ' . preg_replace('/\..*/', '', $this->rate($comment) * 100) . '%</span></li>';
                    }
                    break;

                case 'xmlrpc_comment_spam':
                    $entry_id = $addData['id'];
                    $comment_id = $addData['cid'];
                    $comment = eventData['url'] . ' ' . strip_tags($eventData['body']) . ' ' . $eventData['name'] . ' ' . $eventData['email'];
                    $this->learn($eventData, 'spam');
                    serendipity_deleteComment($comment_id, $entry_id);
                     break;

                case 'xmlrpc_comment_ham':
                    $comment_id = $addData['cid'];
                    $entry_id = $addData['id'];
                    $comment = eventData['url'] . ' ' . strip_tags($eventData['body']) . ' ' . $eventData['name'] . ' ' . $eventData['email'];
                    $this->learn($comment, 'ham');
                    //moderated ham-comments should be instantly approved, that's why they need an id:
                    serendipity_approveComment($comment_id, $entry_id);
                    break;

                case 'backend_sidebar_admin_appearance':
                    if (!serendipity_checkPermission('adminComments')) {
                        break;
                    }

                    $this->setupDB();

                    echo '                    <li class="list-flex"><div class="flex-column-1"><a href="?serendipity[adminModule]=event_display&serendipity[adminAction]=spamblock_bayes">'. PLUGIN_EVENT_SPAMBLOCK_BAYES_NAME ."</a></div></li>\n";
                    break;

                case 'backend_sidebar_entries_event_display_spamblock_bayes':
                    if (!serendipity_checkPermission('adminComments')) {
                        break;
                    }

                    $this->displayRecycler();
                    break;

                case 'js_backend':
                    echo "var learncommentPath = '{$serendipity['baseURL']}index.php?/plugin/bayes_learncomment';";
                    echo file_get_contents(dirname(__FILE__). '/bayes_commentlist.js');
                    break;

                case 'css_backend':
                        $eventData .= '

/* serendipity_event_spamblock_bayes start */

#formMultiSelect .form_buttons fieldset > input {
    margin-right: .25em;
}
.spamblockBayesControls {
    cursor: pointer;
}

.bayes_spamrating {
    display: inline;
}
.bayes_spamrating span {
    vertical-align: middle;
    padding: .25em;
    font-size: .9125em;
}

/* serendipity_event_spamblock_bayes end */

';
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
     * We init b8 in this function and not directly in the event hook, because in the event hook the SPL autoload gets triggered by Smarty and fails
     */
    function initB8()
    {
        global $serendipity;

        if (!isset($this->b8) || $this->b8 === null) {
            $this->setupDB();

            require_once(dirname(__FILE__) . '/b8/b8.php');
            switch ($serendipity['dbType']) {
                case 'mysql':
                case 'mysqli':
                    $config_b8 = [ 'storage'  => 'mysql' ];
                    break;

                case 'sqlite':
                case 'sqlite3':
                case 'sqlite3oo':
                case 'pdo-sqlite':
                    $config_b8 = [ 'storage'  => 'sqlite' ];
                    break;
            }

            $config_storage = [ 'resource' => $serendipity['dbConn'],
                                'table'    => "{$serendipity['dbPrefix']}b8_wordlist" ];
            $this->b8 = new b8\b8($config_b8, $config_storage);
        }
    }

    /**
     * Return the bayes rating reflecting the spamminess of the comment string. 0: ham, 1: spam
     * @param comment string
     * @return error/success ?
     */
    function rate($comment)
    {
        $this->initB8();

        return $this->b8->classify($comment);
    }

    /**
     * Mark a comment text as ham or spam
     * @param comment string
     * @param category string
     */
    function learn($comment, $category)
    {
        $this->initB8();

        if ($category == 'ham') {
            $this->b8->learn($comment, b8\b8::HAM);
        }
        if ($category == 'spam') {
            $this->b8->learn($comment, b8\b8::SPAM);
        }
    }

    /**
     * Set block comments state
     * @param eventData array
     * @param addData array
     */
    function block(&$eventData, &$addData)
    {
        global $serendipity;

        if ($this->get_config('recycler', true)) {
            $this->throwInRecycler($eventData, $addData);
        }
        $eventData['allow_comments'] = false;
        $serendipity['messagestack']['comments'][] = PLUGIN_EVENT_SPAMBLOCK_BAYES_ERROR;
    }

    /**
     * Set into moderate state
     * @param eventData array
     * @param addData array
     */
    function moderate(&$eventData, &$addData)
    {
        global $serendipity;

        $eventData['moderate_comments'] = true;
        $serendipity['csuccess']        = 'moderate';
        $serendipity['moderate_reason'] = sprintf(PLUGIN_EVENT_SPAMBLOCK_BAYES_MODERATE);
    }

    /**
     * Get comment
     * @param id integer
     * @return array
     */
    function getComment($id)
    {
        global $serendipity;

        $sql = "SELECT id, body, entry_id, author, email, url, ip, referer
                  FROM {$serendipity['dbPrefix']}comments
                 WHERE id = " . (int)$id;

        $comments = serendipity_db_query($sql, false, 'assoc');

        return $comments;
    }

    /**
     * Recycler functionality
     */
    function displayRecycler()
    {
        global $serendipity;

        $comments = $this->getAllRecyclerComments();
        if (isset($comments[0]) && is_array($comments[0])) {
            for ($i=0; $i < count($comments); $i++) {
                $databaseComment = $comments[$i];
                $comment = $databaseComment['url'] . ' ' . $databaseComment['body'] . ' ' . $databaseComment['author'] . ' ' . $databaseComment['email'];

                $databaseComment['article_link'] = serendipity_archiveURL($databaseComment['entry_id'], 'comments', 'serendipityHTTPPath', true);
                $databaseComment['article_title'] = $this->getEntryTitle($databaseComment['entry_id']);
                $comments[$i] = $databaseComment;
            }
        } else {
            $comments = array();
        }
        if (!is_object($serendipity['smarty'])) {
            serendipity_smarty_init();
        }
        $serendipity['smarty']->assign('comments', $comments);

        echo $this->parseTemplate('bayesRecyclermenu.tpl');
    }

    /**
     * Get all recycler comments
     * @return array
     */
    function getAllRecyclerComments()
    {
        global $serendipity;

        $sql = "SELECT * FROM {$serendipity['dbPrefix']}spamblock_bayes_recycler ORDER BY id DESC";
        $comments = serendipity_db_query($sql, false, 'assoc');

        return $comments;
    }

    /**
     * Empty the Recycler
     * @return error/success ?
     */
    function emptyRecycler()
    {
        global $serendipity;

        $sql = "DELETE FROM {$serendipity['dbPrefix']}spamblock_bayes_recycler";

        return serendipity_db_query($sql);
    }

    /**
     * Get the blocked comment and store it in the recycler-table
     * Used when the comment is from a current happening event
     * @param ca array
     * @param commentInfo string
     */
    function throwInRecycler(&$ca, &$commentInfo)
    {
        global $serendipity;

        # code copied from serendipity_insertComment. Changed: $id and $status
        $id    = (int)$ca['id'];
        $type  = $commentInfo['type'];
        $email = serendipity_db_escape_string($commentInfo['email']);

        if (isset($commentInfo['subscribe'])) {
            if (!isset($serendipity['allowSubscriptionsOptIn']) || $serendipity['allowSubscriptionsOptIn']) {
                $subscribe = 'false';
            } else {
                $subscribe = 'true';
            }
        } else {
            $subscribe = 'false';
        }
        // 'approved' cause only relevant after recovery
        $dbstatus = 'approved';

        $title         = serendipity_db_escape_string($ca['title']);
        $comments      = $commentInfo['comment'];
        $ip            = serendipity_db_escape_string(isset($commentInfo['ip']) ? $commentInfo['ip'] : $_SERVER['REMOTE_ADDR']);
        $commentsFixed = serendipity_db_escape_string($commentInfo['comment']);
        $name          = serendipity_db_escape_string($commentInfo['name']);
        $url           = serendipity_db_escape_string($commentInfo['url']);
        $parentid      = (isset($commentInfo['parent_id']) && is_numeric($commentInfo['parent_id'])) ? $commentInfo['parent_id'] : 0;
        $status        = serendipity_db_escape_string(isset($commentInfo['status']) ? $commentInfo['status'] : (serendipity_db_bool($ca['moderate_comments']) ? 'pending' : 'approved'));
        $t             = serendipity_db_escape_string(isset($commentInfo['time']) ? $commentInfo['time'] : time());
        $referer       = substr((isset($_SESSION['HTTP_REFERER']) ? serendipity_db_escape_string($_SESSION['HTTP_REFERER']) : ''), 0, 200);

        $sql  = "INSERT INTO
                    {$serendipity['dbPrefix']}spamblock_bayes_recycler (entry_id, parent_id, ip, author, email, url, body, type, timestamp, title, subscribed, status, referer)
                    VALUES ('$id', '$parentid', '$ip', '$name', '$email', '$url', '$commentsFixed', '$type', '$t', '$title', '$subscribe', '$dbstatus', '$referer')";

        serendipity_db_query($sql);
    }

    /**
     * Recycle comments
     * @param id integer
     * @param entry_id integer
     */
    function recycleComment($id, $entry_id)
    {
        global $serendipity;

        $sql  = "INSERT INTO
                    {$serendipity['dbPrefix']}spamblock_bayes_recycler (id, entry_id, parent_id, ip, author, email, url, body, type, timestamp, title, subscribed, status, referer)
                        SELECT
                            id, entry_id, parent_id, ip, author, email, url, body, type, timestamp, title, subscribed, status, referer
                        FROM
                            {$serendipity['dbPrefix']}comments
                        WHERE
                            id = '$id' AND entry_id = '$entry_id';";
        serendipity_db_query($sql);
    }

    /**
     * Restore comments
     * @param ids mixed
     */
    function restoreComments($ids)
    {
        global $serendipity;

        if (is_array($ids)) {
            $sql = "INSERT INTO
                    {$serendipity['dbPrefix']}comments (id, entry_id, parent_id, ip, author, email, url, body, type, timestamp, title, subscribed, status, referer)
                        SELECT
                            id, entry_id, parent_id, ip, author, email, url, body, type, timestamp, title, subscribed, status, referer
                        FROM
                            {$serendipity['dbPrefix']}spamblock_bayes_recycler
                        WHERE " . serendipity_db_in_sql ( 'id', $ids );
        } else {
            $sql = "INSERT INTO
                    {$serendipity['dbPrefix']}comments (id entry_id, parent_id, ip, author, email, url, body, type, timestamp, title, subscribed, status, referer)
                        SELECT
                            id, entry_id, parent_id, ip, author, email, url, body, type, timestamp, title, subscribed, status, referer
                        FROM
                            {$serendipity['dbPrefix']}spamblock_bayes_recycler
                        WHERE id = " . (int)$ids;
        }
        $result = serendipity_db_query($sql);
        $this->deleteFromRecycler($ids);
    }

    /**
     * Delete items from recycler
     * @param ids mixed
     * @return array
     */
    function deleteFromRecycler($ids)
    {
        global $serendipity;

        if (is_array($ids)) {
            $sql = "DELETE FROM
                    {$serendipity['dbPrefix']}spamblock_bayes_recycler
                    WHERE " . serendipity_db_in_sql ( 'id', $ids );
        } else {
            $sql = "DELETE FROM
                    {$serendipity['dbPrefix']}spamblock_bayes_recycler
                    WHERE id = " . (int)$ids;
        }

        return serendipity_db_query($sql);
    }

    /**
     * Get entry title
     * @param id integer
     * @return string
     */
    function getEntryTitle($id)
    {
        global $serendipity;

        $sql = "SELECT title FROM {$serendipity['dbPrefix']}entries WHERE id = '$id'";
        $title = serendipity_db_query($sql, true, "assoc");
        $title = $title['title'];

        return $title;
    }

}

?>