<?php

if (IN_serendipity !== true) {
    die ("Don't hack!");
}


// NOTES:
//
//      If using the Onyx parser, this plugin is licensed as BSD.
//      If using SimplePie parser, this plugin is licensed as BSD-3.
//      If using SimplePie IDN converter, this plugin is licensed GPL.
//
// *****************************************************************
//
// LAYOUT NOTE:
// For best "planet experience" you are advised to create your own template and
// disable s9y-specific options which do not make sense in a planet environment.
// A suggestion is to display the originating feed URL inside entries.tpl via:
//
// {$entry.properties.ep_aggregator_feedname}
// {$entry.properties.ep_aggregator_feedurl}
// {$entry.properties.ep_aggregator_htmlurl}
// {$entry.properties.ep_aggregator_articleurl}
// {$entry.properties.ep_aggregator_author}
//
// See, eg. suggestions in file:
//
// [serendipity]/plugins/serendipity_event_aggregator/theme-patch.diff
//
// *****************************************************************
//
// Smarty plugin API hook to fetch and display feeds in a static page or template:
//
// {serendipity_hookPlugin hook='aggregator_feedlist' hookAll=true data="category:9|cachetime:3600|template:feedlist.tpl"}
//
// Currently supported parameters are only "category" and "cachetime". The ID of a category
// corresponds with the ID of the category that the feeds are associated to in the aggregator configuration.
// You can see the categoryIDs in the backend of managing categories in the URL ("cid"). Multiple categories
// can be separated with a comma (,).
//
// Calling the update like that does NOT STORE THE ENTRIES in your usual blog database, but in a separate
// one. So this does not really aggregate entries, but simply display them. The cachetime means how many
// seconds must pass until the feeds are refreshed when called.

// The template (by default: feedlist.tpl) can be stored either in the plugin directory or your custom
// template directory and is used to render the items.

// *****************************************************************


@serendipity_plugin_api::load_language(dirname(__FILE__));

@define('CANT_EXECUTE_EXTENSION', 'Cannot execute the %s extension library. Please allow in PHP.ini or load the missing module via servers package manager.');

class serendipity_event_aggregator extends serendipity_event
{
    var $debug;
    var $title = PLUGIN_AGGREGATOR_TITLE;

    function introspect(&$propbag)
    {
        global $serendipity;

        $propbag->add('name',          PLUGIN_AGGREGATOR_TITLE);
        $propbag->add('description',   PLUGIN_AGGREGATOR_DESC);
        $propbag->add('requirements',  array(
            'serendipity' => '2.2',
            'smarty'      => '3.1.0',
            'php'         => '7.4.0'
        ));
        $propbag->add('version',       '1.16');
        $propbag->add('author',       'Evan Nemerson, Garvin Hicking, Kristian Koehntopp, Thomas Schulz, Claus Schmidt, Ian Styx');
        $propbag->add('stackable',     false);
        $propbag->add('event_hooks',   array(
            'external_plugin'           => true,
            'backend_sidebar_entries'   => true,
            'backend_sidebar_entries_event_display_aggregator' => true,
            'cronjob'                   => true,
            'aggregator_feedlist'       => true
        ));
        $propbag->add('configuration', array('cronjob', 'engine', 'publishflag', 'expire', 'expire_md5', 'ignore_updates', 'delete_dependencies', 'allow_comments', 'markup', 'debug'));
        $propbag->add('groups', array('FRONTEND_FULL_MODS'));
        $propbag->add('license', 'GPL (IDN converter) or BSD (Onyx) or BSD-3 (SimplePie)');
        $this->dependencies = array('serendipity_event_entryproperties' => 'keep');
    }

    function introspect_config_item($name, &$propbag)
    {
        switch($name) {
            case 'publishflag':
                $propbag->add('type',        'radio');
                $propbag->add('name',        PLUGIN_AGGREGATOR_PUBLISH);
                $propbag->add('description', '');
                $propbag->add('radio',       array(
                    'value' => array('true', 'false'),
                    'desc'  => array(PUBLISH, DRAFT)
                ));
                $propbag->add('default',     'true');
                break;

            case 'cronjob':
                if (class_exists('serendipity_event_cronjob')) {
                    $propbag->add('type',        'select');
                    $propbag->add('name',        PLUGIN_EVENT_CRONJOB_CHOOSE);
                    $propbag->add('description', '');
                    $propbag->add('default',     'daily');
                    $propbag->add('select_values', serendipity_event_cronjob::getValues());
                } else {
                    $propbag->add('type', 'content');
                    $propbag->add('default', PLUGIN_AGGREGATOR_CRONJOB);
                }
                break;

            case 'debug':
                $propbag->add('type', 'boolean');
                $propbag->add('name', PLUGIN_AGGREGATOR_DEBUG);
                $propbag->add('description', PLUGIN_AGGREGATOR_DEBUG_BLAHBLAH);
                $propbag->add('default', 'false');
                break;

            case 'markup':
                $plugins = serendipity_plugin_api::get_event_plugins();
                $markups = array();

                if (is_array($plugins)) {
                    foreach($plugins AS $plugin => &$plugin_data) {
                        if (!isset($plugin_data['p']->markup_elements) || !is_array(@$plugin_data['p']->markup_elements) || empty($plugin_data['p']->markup_elements)) {
                            continue;
                        }
                        $markups[$plugin_data['p']->instance] = (function_exists('serendipity_specialchars') ? serendipity_specialchars($plugin_data['p']->title) : htmlspecialchars($plugin_data['p']->title, ENT_COMPAT, LANG_CHARSET));
                    }
                }

                $propbag->add('type', 'multiselect');
                $propbag->add('name', PLUGIN_AGGREGATOR_MARKUP_DISABLE);
                $propbag->add('description', PLUGIN_AGGREGATOR_MARKUP_DISABLE_DESC);
                $propbag->add('select_values', $markups);
                $propbag->add('select_size', 6);
                $propbag->add('default', '');
                break;

            case 'engine':
                $propbag->add('type', 'radio');
                $propbag->add('radio', array('value' => array('onyx', 'simplepie'),
                                             'desc'  => array('Onyx [BSD]', 'SimplePie [BSD-3]')));
                $propbag->add('name', PLUGIN_AGGREGATOR_CHOOSE_ENGINE);
                $propbag->add('description', PLUGIN_AGGREGATOR_CHOOSE_ENGINE_DESC);
                $propbag->add('default', 'onyx');
                break;

            case 'delete_dependencies':
                $propbag->add('type', 'boolean');
                $propbag->add('name', PLUGIN_AGGREGATOR_DELETEDEPENDENCIES);
                $propbag->add('description', PLUGIN_AGGREGATOR_DELETEDEPENDENCIES_DESC);
                $propbag->add('default', 'true');
                break;

            case 'expire':
                $propbag->add('type', 'string');
                $propbag->add('name', PLUGIN_AGGREGATOR_EXPIRE);
                $propbag->add('description', PLUGIN_AGGREGATOR_EXPIRE_BLAHBLAH);
                $propbag->add('default', 2);
                break;

            case 'expire_md5':
                $propbag->add('type', 'string');
                $propbag->add('name', PLUGIN_AGGREGATOR_EXPIRE_MD5);
                $propbag->add('description', PLUGIN_AGGREGATOR_EXPIRE_MD5_BLAHBLAH);
                $propbag->add('default', 90);
                break;

            case 'ignore_updates':
                $propbag->add('type', 'boolean');
                $propbag->add('name', PLUGIN_AGGREGATOR_IGNORE_UPDATES);
                $propbag->add('description', PLUGIN_AGGREGATOR_IGNORE_UPDATES_DESC);
                $propbag->add('default', 'false');
                break;

            case 'allow_comments':
                $propbag->add('type', 'boolean');
                $propbag->add('name', COMMENTS_ENABLE);
                $propbag->add('description', '');
                $propbag->add('default', 'false');
                break;

            default:
                return false;
        }
        return true;
    }

    function setupDB()
    {
        global $serendipity;

        # Old Schema
        if (! serendipity_db_bool($this->get_config('db_built', false))) {
            $sql = "CREATE TABLE {$serendipity['dbPrefix']}aggregator_feeds (
                          feedid {AUTOINCREMENT} {PRIMARY},
                          feedname    varchar(255) NOT NULL default '',
                          feedurl     varchar(255) NOT NULL default '',
                          htmlurl     varchar(255) NOT NULL default '',
                          categoryid  int(11) default NULL,
                          last_update int(10) {UNSIGNED} default null,
                          charset     varchar(255) NOT NULL default ''
                        );";
            serendipity_db_schema_import($sql);
            $this->set_config('db_built', 'true');
        }

        # Schema extension (version 2)
        if ($this->get_config('db_version') < 2) {
            echo "*** setup DB version " . $this->get_config('db_version'). "<br />\n";
            $sql = "CREATE TABLE {$serendipity['dbPrefix']}aggregator_md5 (
                          entryid {AUTOINCREMENT} {PRIMARY},
                          md5         varchar(32) NOT NULL default '',
                          timestamp   int(10) {UNSIGNED} default null,
                          key md5_idx (md5),
                          key timestamp_idx (timestamp)
                        );";
            serendipity_db_schema_import($sql);

            $sql = "INSERT INTO {$serendipity['dbPrefix']}aggregator_md5
                        ( entryid, md5, timestamp )
                        SELECT entryid, value, " . time() .
                      " FROM {$serendipity['dbPrefix']}entryproperties
                        WHERE property = 'ep_aggregator_md5'";
            serendipity_db_query($sql);

            $sql = "DELETE FROM {$serendipity['dbPrefix']}entryproperties
                    WHERE property = 'ep_aggregator_md5'";
            serendipity_db_query($sql);

            $this->set_config('db_version', '2');
        }

        # Schema extension (version 3)
        if ($this->get_config('db_version') < 3) {
            echo "*** setup DB version " . $this->get_config('db_version'). "<br />\n";
            $sql = "CREATE TABLE {$serendipity['dbPrefix']}aggregator_feedcat (
                         feedid int(11) not null,
                         categoryid int(11) not null
                        );";
            serendipity_db_schema_import($sql);

            $sql = "CREATE UNIQUE INDEX feedid_idx
                        ON {$serendipity['dbPrefix']}aggregator_feedcat (feedid, categoryid);";
            serendipity_db_schema_import($sql);

            $sql = "INSERT INTO {$serendipity['dbPrefix']}aggregator_feedcat
                        ( feedid, categoryid  )
                        SELECT feedid, categoryid
                        FROM {$serendipity['dbPrefix']}aggregator_feeds";
            serendipity_db_query($sql);

            $sql = "DELETE FROM {$serendipity['dbPrefix']}entryproperties
                    WHERE property = 'ep_aggregator_md5'";
            serendipity_db_query($sql);

            $sql = "ALTER TABLE {$serendipity['dbPrefix']}aggregator_feeds
                          DROP categoryid;";
            serendipity_db_schema_import($sql);

            $this->set_config('db_version', '3');
        }

        # Schema extension (version 4)
        if ($this->get_config('db_version') < 4) {
            $sql = "@ALTER TABLE {$serendipity['dbPrefix']}aggregator_feeds
                          ADD COLUMN charset varchar(255);";
            serendipity_db_schema_import($sql);

            $this->set_config('db_version', '4');
        }

        # Schema extension (version 5)
        if ($this->get_config('db_version') < 5) {
            $sql = "ALTER TABLE {$serendipity['dbPrefix']}aggregator_feeds
                          ADD COLUMN match_expression varchar(255);";
            serendipity_db_schema_import($sql);

            $this->set_config('db_version', '5');
        }

        # Schema extension (version 6)
        if ($this->get_config('db_version') < 6) {
            $sql = "CREATE TABLE {$serendipity['dbPrefix']}aggregator_feedlist (
                         id {AUTOINCREMENT} {PRIMARY},
                         feedid int(11) not null,
                         categoryid int(11) not null,
                         entrydate int(11) not null,
                         entrytitle text,
                         entrybody longtext,
                         entryurl text
                        );";
            serendipity_db_schema_import($sql);

            $this->set_config('db_version', '6');
        }

        if ($this->get_config('db_version') < 7) {
            $sql = "CREATE INDEX fl_feedid ON {$serendipity['dbPrefix']}aggregator_feedlist (feedid)";
            serendipity_db_schema_import($sql);

            $sql = "CREATE INDEX fl_entrydate ON {$serendipity['dbPrefix']}aggregator_feedlist (entrydate)";
            serendipity_db_schema_import($sql);

            $sql = "CREATE INDEX fl_categoryid ON {$serendipity['dbPrefix']}aggregator_feedlist (categoryid)";
            serendipity_db_schema_import($sql);

            $sql = "CREATE INDEX fl_feedid_2 ON {$serendipity['dbPrefix']}aggregator_feedlist (feedid, entrydate)";
            serendipity_db_schema_import($sql);

            $sql = "CREATE INDEX fl_feedid_3 ON {$serendipity['dbPrefix']}aggregator_feedlist (feedid, entrydate, categoryid)";
            serendipity_db_schema_import($sql);

            $this->set_config('db_version', '7');
        }
    }

    function &getFeeds($opt = null)
    {
        global $serendipity;

        $this->setupDB();

        $where = '';
        if (isset($opt['category']) && $opt['category'] > 0) {
            $where = "WHERE fc.categoryid IN (" . $opt['category'] . ")";
        }
        $sql = "SELECT f.feedid, f.feedname, f.feedurl, f.htmlurl, fc.categoryid, f.last_update, f.charset, f.match_expression
                  FROM {$serendipity['dbPrefix']}aggregator_feeds AS f
       LEFT OUTER JOIN {$serendipity['dbPrefix']}aggregator_feedcat AS fc
                    ON f.feedid = fc.feedid
                    $where
                 ORDER BY feedname, f.feedid
                 ";

        $feeds = serendipity_db_query($sql, false, 'assoc');

        // prepare array
        $ret = array();
        if (is_array($feeds)) {
            foreach ($feeds AS $feed) {
                $category = $feed['categoryid'];
                if (!isset($ret[$feed['feedid']])) {
                    unset($feed['categoryid']);
                    $ret[$feed['feedid']] = $feed;
                }
                $ret[$feed['feedid']]['categoryids'][] = $category;
            }
        }
        $feeds = array_values($ret);

        if (!is_array($feeds)) {
            return array();
        } else {
            return $feeds;
        }
    }

    function removeFeeds()
    {
        global $serendipity;

        if (!serendipity_db_query("DELETE FROM {$serendipity['dbPrefix']}aggregator_feedcat")) {
             return false;
        }
        return serendipity_db_query("DELETE FROM {$serendipity['dbPrefix']}aggregator_feeds");
    }

    function createFeeds()
    {
        global $serendipity;

        $this->setupDB();

        $feeds = $this->getFeeds();

        foreach($serendipity['POST']['feed'] AS $idx => $array) {
            if (empty($idx)) {
                if (empty($array['feedurl']) && empty($array['feedname']) && empty($array['htmlurl'])) {
                    continue;
                } elseif (empty($array['feedurl']) || empty($array['feedname'])) {
                    echo '<div class="msg_error"><span class="icon-attention-circled" aria-hidden="true"></span> ' . PLUGIN_AGGREGATOR_FEED_MISSINGDATA . '</div>';
                } else {
                    $array['charset'] = $array['charset'] ?? rtrim($serendipity['charset'], '/');
                    $this->insertFeed($array);
                }
            } elseif (is_numeric($idx)) {
                if (empty($array['feedurl']) || empty($array['feedname'])) {
                    $this->deleteFeed($idx, $array);
                } else {
                    $this->updateFeed($idx, $array);
                }
            }
        }
    }

    function purgeEntries($id_list)
    {
        global $serendipity;

        $a = serendipity_db_query("DELETE FROM {$serendipity['dbPrefix']}entries         WHERE id       IN (" . implode(", ", $id_list) . ")");
        $b = serendipity_db_query("DELETE FROM {$serendipity['dbPrefix']}entrycat        WHERE entryid  IN (" . implode(", ", $id_list) . ")");
        $c = serendipity_db_query("DELETE FROM {$serendipity['dbPrefix']}entryproperties WHERE entryid  IN (" . implode(", ", $id_list) . ")");
        $d = serendipity_db_query("DELETE FROM {$serendipity['dbPrefix']}references      WHERE entry_id IN (" . implode(", ", $id_list) . ")");
        $e = serendipity_db_query("DELETE FROM {$serendipity['dbPrefix']}exits           WHERE entry_id IN (" . implode(", ", $id_list) . ")");

        if ($a === true) echo '<span class="msg_success"><span class="icon-ok-circled" aria-hidden="true"></span> ' . PLUGIN_AGGREGATOR_SUCCESS_PURGE . '</span>';
        return true;
    }

    function expireFeedEntries($age)
    {
        global $serendipity;

        // CLSC: 86400 = number of seconds in 24 hours
        $t  = time() - 86400 * $age;
        if ($this->debug) printf("DEBUG: Expire cutoff %s\n", $t);

        $q = "SELECT e.id
                FROM {$serendipity['dbPrefix']}entries AS e
     LEFT OUTER JOIN {$serendipity['dbPrefix']}entryproperties AS ep
                  ON e.id = ep.entryid
     LEFT OUTER JOIN {$serendipity['dbPrefix']}aggregator_feeds AS af
                  ON ep.value = af.feedid
               WHERE ep.property = 'ep_aggregator_feed'
                 AND e.comments < 1
                 AND e.extended IS NULL
                 AND e.timestamp < " . (int)$t;
        $entries = serendipity_db_query($q);

        if (!is_array($entries)) {
            if ($this->debug) printf("DEBUG: Nothing to expire.\n");
            return false;
        }

        $id_list = array();
        foreach($entries AS $entry) {
            if ($this->debug) printf("Expire entry %s\n", $entry['id']);
            $id_list[] = $entry['id'];
        }

        $this->purgeEntries($id_list);

        return;
    }

    function purgeMD5($id_list)
    {
        global $serendipity;

        $a = serendipity_db_query("DELETE FROM {$serendipity['dbPrefix']}aggregator_md5 WHERE entryid IN (" . implode(", ", $id_list) . ")");

        return true;
    }

    function expireFeedMD5($age)
    {
        global $serendipity;

        // CLSC: 86400 = number of seconds in 24 hours
        $t  = time() - 86400 * $age;
        if ($this->debug) printf("DEBUG: MD5 Expire cutoff %s\n", $t);

        $q = "SELECT entryid FROM {$serendipity['dbPrefix']}aggregator_md5 WHERE timestamp < " . (int) $t;
        $entries = serendipity_db_query($q);

        if (!is_array($entries)) {
            if ($this->debug) printf("DEBUG: Nothing to expire.\n");
            return false;
        }

        $id_list = array();
        foreach($entries AS $entry) {
            if ($this->debug) printf("Expire MD5 %s\n", $entry['entryid']);
            $id_list[] = $entry['entryid'];
        }

        $this->purgeMD5($id_list);

        return;
    }

    function expireFeeds()
    {
        $t  = &$this->get_config('expire');
        if ($t > 0) {
            $this->expireFeedEntries($t);
        }

        $t = &$this->get_config('expire_md5');
        if ($t > 0) {
            $this->expireFeedMD5($t);
        }
        return;
    }

    function updateFeed($idx, &$array)
    {
        global $serendipity;

        $q = "UPDATE {$serendipity['dbPrefix']}aggregator_feeds
                 SET feedname           = '" . serendipity_db_escape_string($array['feedname']) . "',
                     feedurl            = '" . serendipity_db_escape_string($array['feedurl']) . "',
                     htmlurl            = '" . serendipity_db_escape_string($array['htmlurl']) . "',
                     match_expression   = '" . serendipity_db_escape_string($array['match_expression']) . "'
               WHERE feedid             = " . (int)$idx;

        if (!serendipity_db_query($q)) {
            return false;
        }
        // delete old categories
        if (!$this->deleteFeedCats($idx)) {
            return false;
        }
        // add changed categories
        return $this->insertFeedCats($idx, $array['categoryids']);
    }

    function deleteFeed($idx, &$array)
    {
        global $serendipity;

        if (serendipity_db_bool($this->get_config('delete_dependencies', 'true'))) {
            $q = "SELECT e.id
                    FROM {$serendipity['dbPrefix']}entries AS e
         LEFT OUTER JOIN {$serendipity['dbPrefix']}entryproperties AS ep
                      ON e.id = ep.entryid
                   WHERE ep.property = 'ep_aggregator_feed'
                     AND ep.value = " . (int)$idx;
            $entries = serendipity_db_query($q);

            if (is_array($entries)) {
                $id_list = array();
                foreach($entries AS $entry) {
                    $id_list[] = $entry['id'];
                }

                $this->purgeEntries($id_list);
            }
        }

        if (!$this->deleteFeedCats($idx)) {
            return false;
        }
        $q = "DELETE FROM {$serendipity['dbPrefix']}aggregator_feeds
                    WHERE feedid = " . (int)$idx;

        return serendipity_db_query($q);
    }

    function insertFeed(&$array)
    {
        global $serendipity;

        $query = "SELECT authorid
                    FROM {$serendipity['dbPrefix']}authors
                   WHERE realname='" . serendipity_db_escape_string($array['feedname']) . "'";
        if (!is_array($res = serendipity_db_query($query))) {
            serendipity_db_insert('authors', array('realname'      => $array['feedname'],
                                                   'username'      => $array['feedname'],
                                                   'password'      => serendipity_hash(mt_rand()),
                                                   'mail_comments' => 0,
                                                   'mail_trackbacks' => 0,
                                                   'email'         => $array['htmlurl'],
                                                   'userlevel'     => 0,
                                                   'right_publish' => 1,
                                                   'hashtype'      => 2));
            $res = serendipity_db_query($query);
        }

        $r = serendipity_db_query("INSERT INTO {$serendipity['dbPrefix']}aggregator_feeds
                                                 (feedname, feedurl, htmlurl, charset, match_expression, last_update)
                                        VALUES ('" . serendipity_db_escape_string($array['feedname']) . "',
                                                '" . serendipity_db_escape_string($array['feedurl']) . "',
                                                '" . serendipity_db_escape_string($array['htmlurl']) . "',
                                                '" . serendipity_db_escape_string($array['charset']) . "',
                                                '" . serendipity_db_escape_string($array['match_expression']) . "',
                                                '" . time() . "')");
        if ($r == false) {
            return $r;
        }

        if (!is_array($array['categoryids'])) {
            $array['categoryids']   = array();
            $array['categoryids'][] = $array['categoryid'];
        }

        return $this->insertFeedCats(serendipity_db_insert_id(), $array['categoryids']);
    }

    function insertFeedCats($idx, $categories)
    {
        global $serendipity;

        if (!is_array($categories)) {
            return true;
        }

        foreach ($categories AS $categoryid) {
            $r = serendipity_db_query("INSERT INTO {$serendipity['dbPrefix']}aggregator_feedcat
                                                   (feedid, categoryid)
                                            VALUES ('" . $idx . "',
                                                    '" . (int)$categoryid . "')");
            if ($r == false) {
                return false;
            }
        }
        return true;
    }

    function deleteFeedCats($idx)
    {
        global $serendipity;

        $q = "DELETE FROM {$serendipity['dbPrefix']}aggregator_feedcat
                    WHERE feedid = " . (int)$idx;

        return serendipity_db_query($q);
    }

    function &fetchCat($name, $selected = 0)
    {
        global $serendipity;

        $n = "\n";
        $cat_list = '
                    <select name="' . $name . '" multiple="multiple" size="4">'.$n;
        $cat_list .= '                        <option value="0"' . (empty($selected) ? ' selected="selected"' : '') . '>[' . NO_CATEGORY . ']</option>' . $n;
        if (is_array($cats = serendipity_fetchCategories())) {
            $cats = serendipity_walkRecursive($cats, 'categoryid', 'parentid', VIEWMODE_THREADED);
            foreach ($cats AS $cat) {
                $cat_list .= '                        <option value="'. $cat['categoryid'] .'"'. (in_array($cat['categoryid'], $selected) ? ' selected="selected"' : '') .'>'. str_repeat('&nbsp;', $cat['depth']) . $cat['category_name'] .'</option>' . "\n";
            }
        }
        $cat_list .= '                    </select>';

        return $cat_list;
    }

    function showFeeds()
    {
        # Shows feeds in admin area
        global $serendipity;

        echo '<h2>' . PLUGIN_AGGREGATOR_TITLE . "</h2>\n\n";

        if (!empty($serendipity['POST']['aggregatorAction'])) {
            $this->createFeeds();
        } elseif (!empty($serendipity['POST']['aggregatorOPMLImport'])) {
            $this->importOPML();
        }

        $feeds = $this->getFeeds();
        $feeds[] = array(
            'feedid'            => 0,
            'feedname'          => '',
            'feedurl'           => '',
            'charset'           => '',
            'htmlurl'           => '',
            'match_expression'  => '',
            'categoryids'       => array(),
            'last_update'       => time()
        );

        echo '<span class="msg_notice"><span class="icon-info-circled" aria-hidden="true"></span> ';
        echo PLUGIN_AGGREGATOR_DESC;
        echo "</span>\n";
        echo '<span class="msg_hint"><span class="icon-help-circled" aria-hidden="true"></span> ';
        echo PLUGIN_AGGREGATOR_FEEDLIST;
        echo "</span>\n";

        echo '
<form action="?" method="post">
    <div>
        <input type="hidden" name="serendipity[adminModule]" value="event_display">
        <input type="hidden" name="serendipity[adminAction]" value="aggregator">
    </div>';
        echo '    <style> table th:nth-child(n+2) { min-width: 8em; } .ag_legend { display: block; line-height: 2; font-weight: bold; } .ag_long { width: 100%; } .ag_short { width: 90%; margin-top: 2px; } .ag_tiny { font-size: 8pt; } </style>';
        echo '    <table>';
        echo '
        <thead>
            <tr>
                <th>#</th>
                <th>' . PLUGIN_AGGREGATOR_FEEDNAME . '</th>
                <th>' . PLUGIN_AGGREGATOR_FEEDURI . '</th>
                <th>' . PLUGIN_AGGREGATOR_CATEGORIES . '</th>
                <th>' . PLUGIN_AGGREGATOR_MATCH_EXPRESSION . '</th>
            </tr>
        </thead>
        <tbody>';

        $evenidx = 0;
        foreach($feeds AS $idx => $feed) {
            $cat = $this->fetchCat("serendipity[feed][{$feed['feedid']}][categoryids][]", $feed['categoryids']);
            $even = ($evenidx++ % 2 ? 'even' : 'uneven');

            echo '
            <tr style="padding: 10px;" class="serendipity_admin_list_item serendipity_admin_list_item_' . $even . '">
                <td valign="top"><em>' . $idx . '</em></td>
                <td valign="top">
                    <input class="input_textbox" type="text" name="serendipity[feed][' . $feed['feedid'] . '][feedname]" value="' . serendipity_specialchars($feed['feedname']) . '">
                    <span class="ag_legend">' . PLUGIN_AGGREGATOR_HTMLURI . ':</span>
                    ' . serendipity_specialchars($feed['charset']) . '
                </td>
                <td width="100%" valign="top">
                    <input class="input_textbox ag_long" type="text" name="serendipity[feed][' . $feed['feedid'] . '][feedurl]" value="' . serendipity_specialchars($feed['feedurl']) . '">
                    <input class="input_textbox ag_short" type="text" name="serendipity[feed][' . $feed['feedid'] . '][htmlurl]" value="' . serendipity_specialchars($feed['htmlurl']) . '">
                </td>
                <td valign="top" rowspan="2">'
                . $cat . '
                </td>
                <td valign="top" rowspan="2"><textarea rows=6 cols=25 name="serendipity[feed][' . $feed['feedid'] . '][match_expression]">' . serendipity_specialchars($feed['match_expression']) . '</textarea></td>
            </tr>
            <tr style="padding: 10px;" class="serendipity_admin_list_item serendipity_admin_list_item_' . $even . '">
                <td></td>
                <td colspan="2" valign="top">
                    <div class="ag_tiny">' . PLUGIN_AGGREGATOR_FEEDUPDATE . ' ' . serendipity_formatTime(DATE_FORMAT_SHORT, $feed['last_update']) . '</div>
                </td>
            </tr>';
        }

        echo '
            <tr>
                <td colspan="4"><br />
                    <input type="submit" name="serendipity[aggregatorAction]" value="' . GO . '" class="input_button">
                </td>
            </tr>
        </tbody>
    </table>
    * ' . PLUGIN_AGGREGATOR_MATCH_EXPRESSION_DESC . '
</form>
';

        echo '
<form action="?" method="post">
    <div>
        <input type="hidden" name="serendipity[adminModule]" value="event_display">
        <input type="hidden" name="serendipity[adminAction]" value="aggregator">
    </div>';

        echo '
    <h3>' . PLUGIN_AGGREGATOR_IMPORTFEEDLIST . '</h3>
    <span class="msg_hint"><span class="icon-help-circled" aria-hidden="true"></span> ' . PLUGIN_AGGREGATOR_IMPORTFEEDLIST_DESC . '</span>
    <div class="form_field">
        <label for="serendipity_aggregator_opml">URL</label>
        <input id="serendipity_aggregator_opml" type="text" name="serendipity[aggregatorOPML]" value="http://">
    </div>
    <div class="form_check">
        <input type="checkbox" id="import_categories" name="serendipity[aggregatorOPMLCategories]" value="true">
        <label for="import_categories">' . PLUGIN_AGGREGATOR_IMPORTCATEGORIES . '</label>
        <input type="checkbox" id="import_categories2" name="serendipity[aggregatorOPMLCategoriesNoNesting]" value="true">
        <label for="import_categories2">' . PLUGIN_AGGREGATOR_IMPORTCATEGORIES2 . '</label>
    </div>';

        echo '
    <h3>' . PLUGIN_AGGREGATOR_EXPORTFEEDLIST . '</h3>
    <a class="button_link" href="' . serendipity_rewriteURL('plugin/opmlfeeds.xml') .'"><span class="icon-rss" aria-hidden="true"></span> ' . PLUGIN_AGGREGATOR_EXPORTFEEDLIST_BUTTON . '</a>
</form>';
    }

    function importOPML()
    {
        $tree = $this->importFeeds();
        if (!$tree) {
            return;
        }
        $this->removeFeeds();
        $this->cats = serendipity_fetchCategories();

        foreach($tree AS $xml_base) {
            if ($xml_base['tag'] != 'opml' || !is_array($xml_base['children'])) {
                continue;
            }

            foreach($xml_base['children'] AS $xml_body) {
                if ($xml_body['tag'] != 'body' || !is_array($xml_body['children'])) {
                    continue;
                }

                foreach($xml_body['children'] AS $xml_outline) {
                    $this->parseOutline($xml_outline);
                }
            }
        }

        serendipity_rebuildCategoryTree();
    }

    function serendipity_addCategory($name, $desc, $authorid, $icon, $parentid)
    {
        global $serendipity;

        $query = "INSERT INTO {$serendipity['dbPrefix']}category
                        (category_name, category_description, authorid, category_icon, parentid, category_left, category_right)
                      VALUES
                        ('". serendipity_db_escape_string($name) ."',
                         '". serendipity_db_escape_string($desc) ."',
                          ". (int)$authorid .",
                         '". serendipity_db_escape_string($icon) ."',
                          ". (int)$parentid .",
                           0,
                           0)";

        return serendipity_db_query($query);
    }

    function newCategory($parent, $last_parent_id)
    {
        global $serendipity;

        if (function_exists('serendipity_addCategory')) {
            $parent_id = serendipity_addCategory($parent, '', 0, '', $last_parent_id);
        } else {
            $this->serendipity_addCategory($parent, '', 0, '', $last_parent_id);
            $parent_id = serendipity_db_insert_id('category', 'categoryid');
        }

        return $parent_id;
    }

    function fetchCategoryParent($parentname)
    {
        if (!is_array($this->cats)) {
            return false;
        }

        foreach($this->cats AS $cat) {
            if ($cat['category_name'] == $parentname) {
                return $cat['categoryid'];
            }
        }

        return false;
    }

    function parseOutline(&$xml_outline, $last_parent_name = '', $last_parent_id = 0)
    {
        global $serendipity;

        if (!empty($xml_outline['attributes']['title'])) {
            $parent = $xml_outline['attributes']['title'];
        } elseif (!empty($xml_outline['attributes']['text'])) {
            $parent = $xml_outline['attributes']['text'];
        } elseif (!empty($xml_outline['attributes']['id'])) {
            $parent = $xml_outline['attributes']['id'];
        } else {
            $parent = time();
        }

        if ($xml_outline['tag'] == 'outline' && is_array($xml_outline['children'])) {
            if ($serendipity['POST']['aggregatorOPMLCategories'] && $parent_id = $this->fetchCategoryParent($parent)) {
                printf(PLUGIN_AGGREGATOR_CATEGORYSKIPPED, $parent);
                echo "<br />\n";
            } elseif ($serendipity['POST']['aggregatorOPMLCategories']) {
                $parent_id = $this->newCategory($parent, $last_parent_id);
            }

            foreach($xml_outline['children'] AS $xml_child) {
                $this->parseOutline($xml_child, $parent, $parent_id);
            }
        } else {
            if ($serendipity['POST']['aggregatorOPMLCategoriesNoNesting']) {
                $last_parent_id = $this->newCategory($parent, $last_parent_id);
            }

            $newfeed = array(
                'feedname'   => $parent,
                'feedurl'    => $xml_outline['attributes']['xmlUrl'],
                'htmlurl'    => $xml_outline['attributes']['htmlUrl'],
                'categoryid' => $last_parent_id,
                'charset'    => ''
            );

            $this->insertFeed($newfeed);
        }

        return true;
    }

    function &importFeeds()
    {
        // Used by ImportOPML routine

        global $serendipity;

        $file = $serendipity['POST']['aggregatorOPML'];

        $data = serendipity_request_url($file);

        // XML functions
        $xml_string = '<?xml version="1.0" encoding="UTF-8" ?>';
        if (preg_match('@(<\?xml.+\?>)@imsU', $data, $xml_head)) {
            $xml_string = $xml_head[1];
        }

        $encoding = 'UTF-8';
        if (preg_match('@encoding="([^"]+)"@', $xml_string, $xml_encoding)) {
            $encoding = $xml_encoding[1];
        }

        // Global replacements
        // by: waldo@wh-e.com - trim space around tags not within
        $data = preg_replace('@>[[:space:]]+<@i', '><', $data);

        // Check for xml_parser_create()
        if (!function_exists('xml_parser_create')) {
            echo '<span class="msg_error"><span class="icon-attention-circled"></span> ' . sprintf(CANT_EXECUTE_EXTENSION, 'php-xml (PHP)') . "</span>\n";
        }

        switch(strtolower($encoding)) {
            case 'iso-8859-1':
            case 'utf-8':
                $p = xml_parser_create($encoding);
                break;

            default:
                $p = xml_parser_create('');
        }

        // by: anony@mous.com - meets XML 1.0 specification
        xml_parser_set_option($p, XML_OPTION_CASE_FOLDING, 0);
        @xml_parser_set_option($p, XML_OPTION_TARGET_ENCODING, LANG_CHARSET);
        xml_parse_into_struct($p, $data, $vals, $index);
        xml_parser_free($p);

        $i = 0;
        $tree = array();
        $tree[] = array(
            'tag'        => $vals[$i]['tag'],
            'attributes' => $vals[$i]['attributes'],
            'value'      => $vals[$i]['value'],
            'children'   => $this->GetChildren($vals, $i)
        );

        return $tree;
    }

    function &GetChildren($vals, &$i)
    {
        $children = array();
        $cnt = sizeof($vals);
        while (++$i < $cnt) {
            // compare type
            switch ($vals[$i]['type']) {
                case 'cdata':
                    $children[] = $vals[$i]['value'];
                    break;

                case 'complete':
                    $children[] = array(
                        'tag'        => $vals[$i]['tag'],
                        'attributes' => $vals[$i]['attributes'],
                        'value'      => $vals[$i]['value']
                    );
                    break;

                case 'open':
                    $children[] = array(
                        'tag'        => $vals[$i]['tag'],
                        'attributes' => $vals[$i]['attributes'],
                        'value'      => $vals[$i]['value'],
                        'children'   => $this->GetChildren($vals, $i)
                    );
                    break;

                case 'close':
                    return $children;
            }
        }
    }

    function insertProperties($entryid, $feed, $md5hash = null)
    {
        global $serendipity;

        $sql = "SELECT * FROM {$serendipity['dbPrefix']}entryproperties WHERE entryid = $entryid AND property = 'ep_aggregator_feed'";
        $props = serendipity_db_query($sql, true);
        if (!is_array($props) || empty($props['entryid'])) {
            $sql = "INSERT INTO {$serendipity['dbPrefix']}entryproperties
                                (entryid, property, value)
                         VALUES ('$entryid', 'ep_aggregator_feed', '" . serendipity_db_escape_string($feed['feedid']) . "')";
            serendipity_db_query($sql);

            $sql = "INSERT INTO {$serendipity['dbPrefix']}entryproperties
                                (entryid, property, value)
                         VALUES ('$entryid', 'ep_aggregator_feedname', '" . serendipity_db_escape_string($feed['feedname']) . "')";
            serendipity_db_query($sql);

            $sql = "INSERT INTO {$serendipity['dbPrefix']}entryproperties
                                (entryid, property, value)
                         VALUES ('$entryid', 'ep_aggregator_feedurl', '" . serendipity_db_escape_string($feed['feedurl']) . "')";
            serendipity_db_query($sql);

            $sql = "INSERT INTO {$serendipity['dbPrefix']}entryproperties
                                (entryid, property, value)
                         VALUES ('$entryid', 'ep_aggregator_htmlurl', '" . serendipity_db_escape_string($feed['htmlurl']) . "')";
            serendipity_db_query($sql);

            $sql = "INSERT INTO {$serendipity['dbPrefix']}entryproperties
                                (entryid, property, value)
                         VALUES ('$entryid', 'ep_aggregator_categoryid', '" . serendipity_db_escape_string($feed['categoryid'] ?? '') . "')";
            serendipity_db_query($sql);

            $sql = "INSERT INTO {$serendipity['dbPrefix']}entryproperties
                                (entryid, property, value)
                         VALUES ('$entryid', 'ep_aggregator_articleurl', '" . serendipity_db_escape_string($feed['articleurl']) . "')";
            serendipity_db_query($sql);

            $sql = "INSERT INTO {$serendipity['dbPrefix']}entryproperties
                                (entryid, property, value)
                         VALUES ('$entryid', 'ep_aggregator_author', '" . serendipity_db_escape_string($feed['author']) . "')";
            serendipity_db_query($sql);

            $sql = "INSERT INTO {$serendipity['dbPrefix']}entryproperties
                                (entryid, property, value)
                         VALUES ('$entryid', 'ep_flattr_active', '-1')";
                                serendipity_db_query($sql);

            # We will be using this for duplicate detection
            # same articleurl and same md5 property -> dupe
            $t = time();
            $sql  = "INSERT INTO {$serendipity['dbPrefix']}aggregator_md5
                                 (entryid, md5, timestamp)
                          VALUES ('$entryid', '$md5hash', '$t')";
            serendipity_db_query($sql);
        }

        $this->feedupdate_finish($feed, $entryid);
     }

    function feedupdate_finish(&$feed, $entryid)
    {
        global $serendipity;

        $t = time();
        $sql = "UPDATE {$serendipity['dbPrefix']}aggregator_feeds SET last_update = " . time() . " WHERE feedid = " . (int)$feed['feedid'];
        serendipity_db_query($sql);

        $md5hash = md5($entryid . $feed['articleurl'] . $feed['last_update']);

        # Always update the MD5 hash, to catch updates of an entry properly. Patch by jerwarren!
        $sql = "UPDATE {$serendipity['dbPrefix']}aggregator_md5 SET timestamp = '$t', md5='$md5hash' WHERE entryid = " . (int)$entryid;
        serendipity_db_query($sql);
    }

    function decode($charset, &$array)
    {
        if (LANG_CHARSET == 'ISO-8859-1' || LANG_CHARSET == 'UTF-8') {
            // Luckily PHP5 supports
            // xml_parser_set_option($this->parser, XML_OPTION_TARGET_ENCODING, LANG_CHARSET);
            // which means we need no transcoding here.
            return true;
        }
        if ($charset == LANG_CHARSET) {
            return true;
        } elseif ($charset == 'utf-8') {
            foreach($array AS $key => $val) {
                $array[$key] = utf8_decode($val);
            }
        } elseif ($charset == 'iso-8859-1') {
            foreach($array AS $key => $val) {
                if (function_exists('iconv')) {
                    $array[$key] = iconv('ISO-8859-1', LANG_CHARSET, $val);
                } elseif (function_exists('recode')) {
                    $array[$key] = recode('iso-8859-1..' . LANG_CHARSET, $val);
                }
            }
        }
        return true;
    }

    function parseDate($time)
    {
        if (empty($time)) {
            if ($this->debug) printf("DEBUG: parseDate(%s) is empty\n", $time);
            return -1;
        }

        $date = strtotime($time);

        if ($date > 0) {
            if ($this->debug) printf("DEBUG: parseDate(%s) as %s (strtotime)\n", $time, date('Y-m-d H:i:s', $date));
            return $date;
        }

        if (preg_match('@^([0-9]{4})\-([0-9]{2})\-([0-9]{2})T([0-9]{2}):([0-9]{2}):([0-9]{2})(?::\-([0-9]{2}):([0-9]{2}))?@', $time, $timematch)) {
            $date = mktime($timematch[4] - $timematch[7], $timematch[5] - $timematch[8], $timematch[6], $timematch[2], $timematch[3], $timematch[1]);
            if ($this->debug) printf("DEBUG: parseDate(%s) as %s (preg_match)\n", $time, date('Y-m-d H:i:s', $date));
            return $date;
        }

        if ($this->debug) printf("DEBUG: parseDate(%s) is unparseable\n", $time);
        return -1;
    }

    function checkCharset(&$feed)
    {
        global $serendipity;

        $data = serendipity_request_url($feed['feedurl']);

        #XML functions
        $xml_string = '<' . '?xml version="1.0" encoding="UTF-8"?' . '>';
        if (preg_match('@(\<\?xml.+\?\>)@imsU', $data, $xml_head)) {
            $xml_string = $xml_head[1];
        }
        $encoding = 'UTF-8';
        if (preg_match('@encoding="([^"]+)"@', $xml_string, $xml_encoding)) {
            # may return iso-8859-15 or windows-1252, which are not valid
            # for the XML parser in PHP
            $encoding = $xml_encoding[1];
        }
        if (preg_match('@utf@i', $encoding)) {
            $encoding = "UTF-8";
        } else {
            $encoding = "iso-8859-1";
        }
        serendipity_db_query("UPDATE {$serendipity['dbPrefix']}aggregator_feeds
                                 SET charset = '" . serendipity_db_escape_string($encoding) . "'
                               WHERE feedid  = " . (int)$feed['feedid']);
        $feed['charset'] = $encoding;
        return $encoding;
    }

    function fetchFeeds($opt = null)
    {
        global $serendipity;

        set_time_limit(360);
        ignore_user_abort(true);
        $_SESSION['serendipityRightPublish'] = true;
        $serendipity['noautodiscovery'] = true;

        $this->setupDB();
        $feeds = $this->getFeeds($opt);

        $engine = $this->get_config('engine', 'onyx');
        if ($engine == 'onyx') {
            require_once S9Y_PEAR_PATH . 'Onyx/RSS.php';
        }
        if ($engine == 'simplepie') {
            require_once S9Y_PEAR_PATH . 'simplepie/SimplePie.php';
            include_once(dirname(__FILE__) . '/simplepie/idn/idna_convert.class.php');
        }

        $cache_authors = array();
        $cache_entries = array();
        $cache_md5     = array();

        $sql_cache_authors = serendipity_db_Query("SELECT authorid, realname
                                                     FROM {$serendipity['dbPrefix']}authors");
        if (is_array($sql_cache_authors)) {
            foreach($sql_cache_authors AS $idx => $author) {
                $cache_authors[$author['realname']] = $author['authorid'];
            }
        }
        if ($this->debug) printf("DEBUG: cache_authors['realname'] = authorid has %d author(s)\n", count($cache_authors));

        if (isset($opt['store_separate']) && $opt['store_separate'] === true) {
            $sql_cache_entries = serendipity_db_query("SELECT e.feedid, e.id, e.entrydate, e.entrytitle
                                                         FROM {$serendipity['dbPrefix']}aggregator_feedlist AS e");
            if (is_array($sql_cache_entries)) {
                foreach($sql_cache_entries AS $idx => $entry) {
                    $cache_entries[$entry['entrytitle']][$entry['feedid']][$entry['entrydate']] = $entry['id'];
                }
            }
        } else {
            $sql_cache_entries = serendipity_db_query("SELECT e.id, e.timestamp, e.authorid, e.title, ep.value
                                                         FROM {$serendipity['dbPrefix']}entries AS e,
                                                              {$serendipity['dbPrefix']}entryproperties AS ep
                                                        WHERE e.id = ep.entryid
                                                          AND ep.property = 'ep_aggregator_feed'");
            if (is_array($sql_cache_entries)) {
                foreach($sql_cache_entries AS $idx => $entry) {
                    $cache_entries[$entry['title']][$entry['authorid']][$entry['timestamp']] = $entry['id'];
                }
            }
        }
        if ($this->debug) printf("DEBUG: cache_entries['title']['authorid']['timestamp'] = entryid has %d entries.\n", count($cache_entries));

        $sql_cache_md5 = serendipity_db_query("SELECT entryid, md5, timestamp
                                                 FROM {$serendipity['dbPrefix']}aggregator_md5");
        if (is_array($sql_cache_md5)) {
            foreach($sql_cache_md5 AS $idx => $entry) {
                $cache_md5[$entry['md5']]['entryid'] = $entry['entryid'];
                $cache_md5[$entry['md5']]['timestamp'] = $entry['timestamp'];
            }
        }
        if ($this->debug) printf("DEBUG: cache_md5['md5'] = entryid has %d entries.\n", count($cache_md5));

        foreach($feeds AS $feed) {
            if (empty($opt['store_separate'])) printf("Read %s.\n", $feed['feedurl']);
            flush();
            $feed_authorid = $cache_authors[$feed['feedname']] ?? 0;
            if (empty($feed_authorid)) {
                $feed_authorid = 0;
            }
            if ($this->debug) printf("DEBUG: Current authorid = %d\n", $feed_authorid);

            $stack = array();
            if ($engine == 'onyx') {
                if (empty($feed['charset'])) {
                    $this->checkCharset($feed);
                }

                # test multiple likely charsets
                $charsets = array( $feed['charset'], "ISO-8859-1", "utf-8");
                $retry = false;
                foreach ($charsets AS $ch) {
                    if ($retry) printf("DEBUG: Retry with charset %s instead of %s\n", $ch, $feed['charset']);
                    $retry = true;
                    $c = new Onyx_RSS($ch);
                    # does it parse? if so, all is fine...
                    if ($c->parse($feed['feedurl']))
                    break;
                }

                while ($item = $c->getNextItem()) {
                    /* Okay this is where things get tricky. Everybody
                     * encodes their information differently. For now I'm going to focus on
                     * s9y weblogs. */
                    $fake_timestamp = false;
                    $date = $this->parseDate($item['pubdate']);
                    if ($this->debug) printf("DEBUG: pubDate %s = %s\n", $item['pubdate'], $date);
                    if ($date == -1) {
                        // Fallback to try for dc:date
                        $date = $this->parseDate($item['dc:date']);
                        if ($this->debug) printf("DEBUG: falling back to dc:date % s= %s\n", $item['dc:date'], $date);
                    }
                    if ($date == -1) {
                        // Couldn't figure out the date string. Set it to "now" and hope that the md5hash will get it.
                        $date           = time();
                        $fake_timestamp = true;
                        if ($this->debug) printf("DEBUG: falling back to time() = %s\n", $date);
                    }
                    if (empty($item['title'])) {
                        if ($this->debug) printf("DEBUG: skip item: title was empty for %s\n", print_r($item, true));
                        continue;
                    }
                    $this->decode($c->rss['encoding'], $item);
                    $item['date'] = $date;
                    $stack[] = $item;
                }

            } elseif ($engine == 'simplepie') {

                // hwa: new SimplePie code  ; lifted from the SimplePie demo
                $simplefeed = new SimplePie();
                $simplefeed->cache=false;

                $simplefeed->set_feed_url($feed['feedurl']);

                // Initialize the whole SimplePie object.  Read the feed, process it, parse it, cache it, and
                // all that other good stuff.  The feed's information will not be available to SimplePie before
                // this is called.
                $success = $simplefeed->init();

                // We'll make sure that the right content type and character encoding gets set automatically.
                // This function will grab the proper character encoding, as well as set the content type to text/html.
                $simplefeed->set_output_encoding(LANG_CHARSET);
                $simplefeed->handle_content_type();

                // error handling
                if ($simplefeed->error()) {
                    if (empty($opt['store_separate'])) printf('<p><b>ERROR:</b> ' . (function_exists('serendipity_specialchars') ? serendipity_specialchars($simplefeed->error()) : htmlspecialchars($simplefeed->error(), ENT_COMPAT, LANG_CHARSET)) . "</p>\r\n") ;
                }

                if ($success) {
                    foreach($simplefeed->get_items() AS $simpleitem) {
                        // map SimplePie items to s9y items
                        $item['title']       = $simpleitem->get_title();
                        $item['date']        = $simpleitem->get_date('U');
                        $item['pubdate']     = $simpleitem->get_date('U');
                        $item['description'] = $simpleitem->get_description();
                        $item['content']     = $simpleitem->get_content();
                        $item['link']        = $simpleitem->get_permalink();
                        $item['author']      = $simpleitem->get_author();

                        //if ($this->debug) {
                        //  printf("DEBUG: SimplePie item: author: $item['author'], title: $item['title'], date: $item['date']\n");
                        //}

                        $stack[] = $item;
                    }
                } else {
                    if (empty($opt['store_separate'])) printf('<p><b>ERROR:</b> ' . print_r($success, true) . "</p>\r\n") ;
                }
           }

           foreach ($stack AS $key => $item) {

                if (isset($opt['store_separate']) && $opt['store_separate'] === true) {
                    $ep_id = $cache_entries[$item['title']][$feed['feedid']][$item['date']];
                    if ($this->debug) {
                            printf("DEBUG: lookup cache_entries[%s][%s][%s] finds %s.\n",
                                $item['title'],
                                $feed['feedid'],
                                $item['date'],
                                empty($ep_id)?"nothing":$ep_id
                            );
                    }
                } else {
                    $ep_id = $cache_entries[$item['title']][$feed_authorid][$item['date']] ?? null;
                    if ($this->debug) {
                            printf("DEBUG: lookup cache_entries[%s][%s][%s] finds %s.\n",
                                $item['title'],
                                $feed_authorid,
                                $item['date'],
                                empty($ep_id)?"nothing":$ep_id
                            );
                    }
                }

                if (!empty($ep_id) and serendipity_db_bool($this->get_config('ignore_updates', 'false'))) {
                    if ($this->debug) printf("DEBUG: entry %s is known and ignore_updates is set.\n", $ep_id);
                    continue;
                }

                # NOTE: If $ep_id is NULL or EMPTY, it means that an entry with this title does not
                #       yet exist. Later on we check if a similar entry with the body exists and skip
                #       updates in this case. Else it means that the new entry needs to be inserted
                #       as a new one.

                # The entry is probably new?
                $entry = array('id'             => $ep_id,
                               'title'          => $item['title'],
                               'timestamp'      => $item['date'],
                               'extended'       => '',
                               'isdraft'        => serendipity_db_bool($this->get_config('publishflag')) ? 'false' : 'true',
                               'allow_comments' => serendipity_db_bool($this->get_config('allow_comments', 'false')) ? 'true' : 'false',
                               'categories'     => $feed['categoryids'],
                               'author'         => $feed['feedname'],
                               'authorid'       => $feed_authorid);

                // ----------------------------------------------------------
                //    CLSC: Added a few flavours
                if (isset($item['content:encoded'])) {
                    $entry['body'] = $item['content:encoded'];
                } elseif ($item['description']) {
                    $entry['body'] = $item['description'];
                } elseif ($item['content']['encoded']) {
                    $entry['body'] = $item['content']['encoded'];
                } elseif ($item['atom_content']) {
                    $entry['body'] = $item['atom_content'];
                } elseif ($item['content']) {
                    $entry['body'] = $item['content'];
                }

                $md5hash = md5($feed_authorid . $item['title'] . $entry['body']);

                # Check 1: Have we seen this MD5?
                if ($this->debug) {
                    printf("DEBUG: lookup cache_md5[%s] finds %s.\n",
                        $md5hash,
                        empty($cache_md5[$md5hash]) ? "nothing" : $cache_md5[$md5hash]['entryid']
                    );
                }

                # If we have this md5, title and body for this article
                # are unchanged. We do not need to do anything.
                if (isset($cache_md5[$md5hash])) {
                    continue;
                }

                # Check 2 (conditional: expire enabled?):
                #         Is this article too old?
                if ($this->get_config('expire') > 0) {
                    $expire = time() - 86400 * $this->get_config('expire');

                    if ($item['date'] < $expire) {
                        if ($this->debug) printf("DEBUG: '%s' is too old (%s < %s).\n", $item['title'], $item['date'] , $expire);
                        continue;
                     }
                }

                # Check 3: Does this article match our expressions?
                if (!empty($feed['match_expression'])) {
                    $expressions = explode("~", $feed['match_expression']);

                    $match = 0;
                    foreach ($expressions AS $expression) {
                        $expression = ltrim(rtrim($expression));
                        if (preg_match("~$expression~imsU", $entry['title'] . $entry['body'])) {
                            $match = 1;
                        }
                    }

                    if ($match == 0) {
                        continue;
                    }
                }

                $feed['articleurl'] = $item['link'];

                if ($item['author']) {
                    $feed['author'] = $item['author'];
                } elseif ($item['dc:creator']) {
                    $feed['author'] = $item['dc:creator'];
                }

                // Store as property

                // Plugins might need this.
                $serendipity['POST']['properties'] = array('fake' => 'fake');

                $markups = explode('^', $this->get_config('markup'));
                if (is_array($markups)) {
                    foreach($markups AS $markup) {
                        $serendipity['POST']['properties']['disable_markups'][] = $markup;
                    }
                }

                if (isset($opt['store_separate']) && $opt['store_separate'] === true) {
                    if ($entry['id'] > 0) {
                        serendipity_db_query("UPDATE {$serendipity['dbPrefix']}aggregator_feedlist
                        SET feedid      = '" . $feed['feedid'] . "',
                            categoryid  = '" . $feed['categoryids'][0] . "',
                            entrydate   = '" . serendipity_db_escape_string($entry['timestamp']) . "',
                            entrytitle  = '" . serendipity_db_escape_string($entry['title']) . "',
                            entrybody   = '" . serendipity_db_escape_string($entry['body']) . "',
                            entryurl    = '" . serendipity_db_escape_string($item['link']) . "'
                        WHERE id = " . $entry['id']);
                        $entryid = $entry['id'];
                    } else {
                        serendipity_db_query("INSERT INTO {$serendipity['dbPrefix']}aggregator_feedlist (
                            feedid,
                            categoryid,
                            entrydate,
                            entrytitle,
                            entrybody,
                            entryurl
                        ) VALUES (
                            '" . $feed['feedid'] . "',
                            '" . $feed['categoryids'][0] . "',
                            '" . serendipity_db_escape_string($entry['timestamp']) . "',
                            '" . serendipity_db_escape_string($entry['title']) . "',
                            '" . serendipity_db_escape_string($entry['body']) . "',
                            '" . serendipity_db_escape_string($item['link']) . "'
                        )");
                        $entryid = serendipity_db_insert_id();
                    }
                    $this->feedupdate_finish($feed, $entryid);
                } else {
                    $entryid = serendipity_updertEntry($entry);
                    $this->insertProperties($entryid, $feed, $md5hash);
                }
                if (empty($opt['store_separate'])) printf(" Save '%s' as %s.\n", $item['title'], $entryid);
            }
            if (empty($opt['store_separate'])) printf("Finish feed.\n");
        }
        if (empty($opt['store_separate'])) printf("Finish planetarium.\n");
    }

    function generate_content(&$title)
    {
        $title = PLUGIN_AGGREGATOR_TITLE;
    }

    function showRecursive($ary, &$xml, $child_name = 'id', $parent_name = 'parent_id', $parentid = 0)
    {
        global $serendipity;

        if ( sizeof($ary) == 0 ) {
            return array();
        }

        if ($parentid === VIEWMODE_THREADED) {
            $parentid = 0;
        }

        foreach ($ary AS $data) {
            if ($parentid === VIEWMODE_LINEAR || !isset($data[$parent_name]) || $data[$parent_name] == $parentid) {
                echo '<outline title="' . serendipity_utf8_encode($data['category_name']) . '">' . "\n";

                if (is_array($xml[$data['categoryid']])) {
                    foreach($xml[$data['categoryid']] AS $feed) {
                        if (empty($feed['feedurl'])) {
                            continue;
                        }

                        printf('    <outline title="%s" xmlUrl="%s" htmlUrl="%s" description="%s" />' . "\n",
                            serendipity_utf8_encode((function_exists('serendipity_specialchars') ? serendipity_specialchars($feed['feedname']) : htmlspecialchars($feed['feedname'], ENT_COMPAT, LANG_CHARSET))),
                            serendipity_utf8_encode((function_exists('serendipity_specialchars') ? serendipity_specialchars($feed['feedurl']) : htmlspecialchars($feed['feedurl'], ENT_COMPAT, LANG_CHARSET))),
                            serendipity_utf8_encode((function_exists('serendipity_specialchars') ? serendipity_specialchars($feed['htmlurl']) : htmlspecialchars($feed['htmlurl'], ENT_COMPAT, LANG_CHARSET))),
                            serendipity_utf8_encode((function_exists('serendipity_specialchars') ? serendipity_specialchars($feed['feedname']) : htmlspecialchars($feed['feedname'], ENT_COMPAT, LANG_CHARSET)))
                        );
                    }
                }

                if ($data[$child_name] && $parentid !== VIEWMODE_LINEAR ) {
                    $this->showRecursive($ary, $xml, $child_name, $parent_name, $data[$child_name]);
                }

                echo "</outline>\n";
            }
        }

        return true;
    }

    function parseShowFeed(&$eventData)
    {
        global $serendipity;

        $cmd = explode('|', $eventData);
        $opt = array();
        foreach($cmd AS $cmdpart) {
            $cmdpart = trim($cmdpart);
            $cmdpart2 = explode(':', $cmdpart);

            if (!empty($cmdpart) && !empty($cmdpart2[1])) {
                $opt[$cmdpart2[0]] = $cmdpart2[1];
            }
        }

        if (empty($opt['cachetime'])) {
            $opt['cachetime'] = 3600;
        }

        if (empty($opt['template'])) {
            $opt['template'] = 'feedlist.tpl';
        }

        $opt['store_separate'] = true;

        $fkey = 'last_showfeed_' . md5(serialize($opt));
        if (time() - $this->get_config($fkey) > $opt['cachetime']) {
            $this->set_config($fkey, time());
            $this->fetchFeeds($opt);
        }

        $q = "SELECT fl.*,
                     f.feedname,
                     f.htmlurl
                 FROM {$serendipity['dbPrefix']}aggregator_feedlist AS fl
      LEFT OUTER JOIN {$serendipity['dbPrefix']}aggregator_feedlist AS fl2
                   ON (fl.feedid = fl2.feedid AND fl.entrydate < fl2.entrydate)
                 JOIN {$serendipity['dbPrefix']}aggregator_feeds AS f
                   ON fl.feedid = f.feedid
                WHERE fl2.feedid IS NULL
                      " . ($opt['category'] > 0 ? "AND fl.categoryid IN (" . $opt['category'] . ") " : "") . "
               GROUP BY fl.feedid
               ORDER BY fl.entrydate DESC
        ";
        $show = serendipity_db_query($q);
        $serendipity['smarty']->assign('feedlist_entries', $show);

        $filename = basename($opt['template']);
        $tfile = serendipity_getTemplateFile($filename, 'serendipityPath');
        if (!$tfile || $tfile == $filename) {
            $tfile = dirname(__FILE__) . '/' . $filename;
        }
        $serendipity['smarty']->display($tfile);
        //
        // Feed Icon parsen und in feeds speichern
        return true;
    }

    function event_hook($event, &$bag, &$eventData, $addData = null)
    {
        global $serendipity;

        $hooks = &$bag->get('event_hooks');
        $this->debug = serendipity_db_bool($this->get_config('debug', 'false'));

        if (isset($hooks[$event])) {

            switch($event) {

                case 'backend_sidebar_entries':
                    if ($serendipity['serendipityUserlevel'] >= USERLEVEL_CHIEF) {
                        echo '                        <li class="list-flex"><div class="flex-column-1"><a href="?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=aggregator">' . PLUGIN_AGGREGATOR_TITLE . "</a></div></li>\n";
                    }
                    break;

                case 'backend_sidebar_entries_event_display_aggregator':
                    $this->showFeeds();
                    break;

                case 'cronjob':
                    if ($this->get_config('cronjob') == $eventData) {
                        serendipity_event_cronjob::log('Aggregator', 'plugin');
                        $this->fetchFeeds();
                        # Fetch first, expire later (some feeds offer old stuff)
                        $this->expireFeeds();
                    }
                    break;

                case 'aggregator_feedlist':
                    $this->parseShowFeed($eventData);
                    break;

                case 'external_plugin':
                    if ($eventData == 'opmlfeeds.xml') {
                        header('Content-Type: text/xml; charset=utf-8');
                        echo '<?xml version="1.0" encoding="utf-8" ?>' . "\n";
                        $modified = gmdate('D, d M Y H:i:s \G\M\T', serendipity_serverOffsetHour(time(), true));

                        print <<<EOF
<opml version="1.0">
<head>
    <title>{$serendipity['blogTitle']}</title>
    <dateModified>{$modified}</dateModified>
    <ownerName>Serendipity Styx - https://ophian.github.io/</ownerName>
</head>
<body>
EOF;

                        $feeds = serendipity_db_Query("
                                    SELECT c.categoryid,
                                           f.feedname,
                                           f.feedurl,
                                           f.htmlurl
                                     FROM {$serendipity['dbPrefix']}category AS c
                                LEFT JOIN {$serendipity['dbPrefix']}aggregator_feedcat AS fc
                                       ON fc.categoryid = c.categoryid
                                LEFT JOIN {$serendipity['dbPrefix']}aggregator_feeds AS f
                                       ON fc.feedid = f.feedid", false, 'assoc');

                        $xml = array();
                        if (is_array($feeds)) {
                            foreach($feeds AS $feed) {
                                $xml[$feed['categoryid']][] = $feed;
                            }
                        }
                        if (is_array($cats = serendipity_fetchCategories())) {
                            $cats = $this->showRecursive($cats, $xml, 'categoryid', 'parentid', VIEWMODE_THREADED);
                        }

                        print "</body>\n</opml>";
                        return;
                    }

                    if ($eventData != 'aggregator') {
                        return;
                    }

                    $this->fetchFeeds();
                    # Fetch first, expire later (some feeds offer old stuff)
                    $this->expireFeeds();
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