<?php

@define('PLUGIN_EVENT_COMMENTSPICE_CNAME_DBCONFIG', 'spicedb');

class DbSpice
{
    static function table_created($table = 'tweetbackhistory')
    {
        global $serendipity;

        $q = "SELECT count(*) FROM {$serendipity['dbPrefix']}" . $table;
        $row = serendipity_db_query($q, single: true, expectError: true);// The executed SQL error is known to fail, and should be disregarded

        if (is_bool($row) || !is_numeric($row[0])) { // if the response we got back was an SQL error.. :P
            return false;
        } else {
            return true;
        }
    }

    static function install(&$obj)
    {
        global $serendipity;

        $dbversion = $obj->get_config(PLUGIN_EVENT_COMMENTSPICE_CNAME_DBCONFIG);
        if (empty($dbversion)) $dbversion=0;

        if (!DbSpice::table_created('commentspice')) {
            // twitternames cant be longer than 15 referring to API docs. 20 for safety. nvarchar because of unicode names
            $q = "CREATE TABLE {$serendipity['dbPrefix']}commentspice (" .
                    "commentid int(10) not null, " .
                    "twittername nvarchar(20), " .
                    "PRIMARY KEY (commentid)" .
                ")";

            $result = serendipity_db_schema_import($q);

            if ($result !== true) {
                return;
            }
            $obj->set_config(PLUGIN_EVENT_COMMENTSPICE_CNAME_DBCONFIG, 1);
        }
        // Version 2 updates
        if ($obj->get_config((PLUGIN_EVENT_COMMENTSPICE_CNAME_DBCONFIG)<2)) {
            if (stristr($serendipity['dbType'], 'postgres')) {
                $q = "ALTER TABLE {$serendipity['dbPrefix']}commentspice" .
                    " ADD COLUMN promo_name varchar(200),".
                    " ADD COLUMN promo_url varchar(250);";
            } else {
                $q = "ALTER TABLE {$serendipity['dbPrefix']}commentspice" .
                    " ADD COLUMN promo_name nvarchar(200),".
                    " ADD COLUMN promo_url nvarchar(250);";
            }
            serendipity_db_query($q);
            $obj->set_config(PLUGIN_EVENT_COMMENTSPICE_CNAME_DBCONFIG, 2);
        }
        // Version 3 updates
        if ($obj->get_config((PLUGIN_EVENT_COMMENTSPICE_CNAME_DBCONFIG)<3)) {
            if ($serendipity['dbType'] == 'mysqli') {
                $serendipity['db_server_info'] = $serendipity['db_server_info'] ?? mysqli_get_server_info($serendipity['dbConn']); // eg.  == 5.5.5-10.4.11-MariaDB
                // be a little paranoid...
                if (substr($serendipity['db_server_info'], 0, 6) === '5.5.5-') {
                    // strip any possible added prefix having this 5.5.5 version string (which was never released). PHP up from 8.0.16 now strips it correctly.
                    $serendipity['db_server_info'] = str_replace('5.5.5-', '', $serendipity['db_server_info']);
                }
                $db_version_match = explode('-', $serendipity['db_server_info']);
                if (stristr(strtolower($serendipity['db_server_info']), 'mariadb')) {
                    if (version_compare($db_version_match[0], '10.5.0', '>=')) {
                        $q = "CREATE INDEX idx_comments_email ON {$serendipity['dbPrefix']}comments (email);";
                    } elseif (version_compare($db_version_match[0], '10.3.0', '>=')) {
                        $q = "CREATE INDEX idx_comments_email ON {$serendipity['dbPrefix']}comments (email);"; // max key 1000 bytes - well, field is varchar(200)
                    } else {
                        $q = "CREATE INDEX idx_comments_email ON {$serendipity['dbPrefix']}comments (email(191));"; // 191 - old MyISAMs
                    }
                } else {
                    // Oracle MySQL - https://dev.mysql.com/doc/refman/5.7/en/innodb-limits.html
                    if (version_compare($db_version_match[0], '5.7.7', '>=')) {
                        $q = "CREATE INDEX idx_comments_email ON {$serendipity['dbPrefix']}comments (email);"; // Oracle Mysql/InnoDB max key up to 3072 bytes
                    } else {
                        $q = "CREATE INDEX idx_comments_email ON {$serendipity['dbPrefix']}comments (email(191));"; // Oracle Mysql/InnoDB max key 767 bytes
                    }
                }
            } else {
                $q = "CREATE INDEX idx_comments_email ON {$serendipity['dbPrefix']}comments (email));";
            }
            serendipity_db_query($q); // if it already exists, it won't be created
            $obj->set_config(PLUGIN_EVENT_COMMENTSPICE_CNAME_DBCONFIG, 3);
        }
        // Version 4 updates
        if ($obj->get_config((PLUGIN_EVENT_COMMENTSPICE_CNAME_DBCONFIG)<4)) {
            $q = "ALTER TABLE {$serendipity['dbPrefix']}commentspice" .
                " ADD COLUMN boo nvarchar(250);";
            serendipity_db_query($q);
            $obj->set_config(PLUGIN_EVENT_COMMENTSPICE_CNAME_DBCONFIG, 4);
        }
        // nvarchar (NATIONAL VARCHAR) supports multibyte characters is a synonym for varchar with UTF-8
    }

    static function countComments($email)
    {
        global $serendipity;
        if (empty($email)) return 0;
        $db_email = serendipity_db_escape_string($email);
        $q = "SELECT COUNT(*) AS commentcount FROM {$serendipity['dbPrefix']}comments WHERE email='$db_email'";
        $row = serendipity_db_query($q, true);
        return $row['commentcount'];
    }

    static function saveCommentSpice($commentid, $twittername, $promo_name, $promo_url, $boo_url)
    {
        global $serendipity;
        if (empty($commentid) || !is_numeric($commentid) || (empty($twittername) && empty($promo_name) && empty($boo_url)) ) return true;

        $spice = array('commentid' => $commentid);
        if (!empty($twittername)) $spice['twittername'] = $twittername;
        if (!empty($promo_name)) $spice['promo_name'] = $promo_name;
        if (!empty($promo_url)) $spice['promo_url'] = $promo_url;
        if (!empty($boo_url)) $spice['boo'] = $boo_url;

        return serendipity_db_insert('commentspice', $spice);
    }

    static function loadCommentSpice($commentid)
    {
        global $serendipity;
        if (empty($commentid) || !is_numeric($commentid)) return false;

        $sql = "SELECT * FROM {$serendipity['dbPrefix']}commentspice WHERE commentid=$commentid";
        $row = serendipity_db_query($sql, true);
        if (!is_array($row)) return false;
        return $row;
    }

    static function deleteCommentSpice($commentid)
    {
        global $serendipity;

        if (empty($commentid) || !is_numeric($commentid)) return;
        $sql = "DELETE FROM {$serendipity['dbPrefix']}commentspice WHERE commentid=$commentid";
        return serendipity_db_query($sql, true);
    }

    static function loadCommentSpiceByEntry($entryId)
    {
        if (empty($entryId)) return FALSE;
        $comments = serendipity_fetchComments($entryId);
        $result = array();
        foreach ($comments as $comment) {
            $result[] = DbSpice::loadCommentSpice($comment['id']);
        }
        return $result;
    }

}
