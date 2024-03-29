<?php

if (IN_serendipity !== true) {
    die ("Don't hack!");
}

@serendipity_plugin_api::load_language(dirname(__FILE__));

class serendipity_event_cronjob extends serendipity_event
{
    function introspect(&$propbag)
    {
        global $serendipity;

        $propbag->add('name',          PLUGIN_EVENT_CRONJOB_NAME);
        $propbag->add('description',   PLUGIN_EVENT_CRONJOB_DESC);
        $propbag->add('stackable',     false);
        $propbag->add('author',        'Garvin Hicking, Ian Styx');
        $propbag->add('version',       '2.1.0');
        $propbag->add('requirements',  array(
            'serendipity' => '3.2',
            'php'         => '7.3'
        ));

        $hooks = array('frontend_configure' => true, 'frontend_footer' => true, 'cronjob');
        $ts = $this->getValues('fetch');
        foreach($ts as $span => $unixsec) {
            $hooks['cronjob_' . $span] = true;
        }
        $propbag->add('event_hooks', $hooks);
        $propbag->add('groups', array('BACKEND_FEATURES'));

        $propbag->add('configuration', array('visitor_cronjob'));
        $this->dependencies = array();
    }

    static function getValues($mode = 'select')
    {
        // Add future timespans here
        static $timespan = array(
            'off'       => 0,
            'always'    => 1,
            '5min'      => 300,
            '30min'     => 1800,
            '1h'        => 3600,
            '12h'       => 43200,
            'daily'     => 86400,
            'weekly'    => 604800,
            'monthly'   => 2419200,
        );

        if ($mode === 'fetch') {
            return $timespan;
        }

        $r = array();
        foreach($timespan AS $span => $unix) {
            $r[$span] = $span;
        }
        return $r;
    }

    function example()
    {
        global $serendipity;
        $s = '';
        $s .= '<br /><div style="border: 1px solid red; padding: 5px;">' . PLUGIN_EVENT_CRONJOB_DETAILS . '</div>';
        $s .= '<br /><fieldset><legend>' . PLUGIN_EVENT_CRONJOB_LOG . '</legend><table cellspacing=1 cellpadding=2>';
        $s .= '<tr><th>' . DATE . '</th><th>' . TYPE . '</th><th>' . DESCRIPTION . '</th></tr>';
        $res = serendipity_db_query("SELECT timestamp, type, reason FROM {$serendipity['dbPrefix']}cronjoblog ORDER BY timestamp DESC");
        if (is_array($res)) {
            foreach($res AS $row) {
                $s .= '<tr><td>' . date('d.m.Y H:i', $row['timestamp']) . '</td><td>' . (function_exists('serendipity_specialchars') ? serendipity_specialchars($row['type']) : htmlspecialchars($row['type'], ENT_COMPAT, LANG_CHARSET)) . '</td><td>' . (function_exists('serendipity_specialchars') ? serendipity_specialchars($row['reason']) : htmlspecialchars($row['reason'], ENT_COMPAT, LANG_CHARSET)) . '</td></tr>' . "\n";
            }
        }
        $s .= '</table></fieldset>';
        return $s;
    }

    function introspect_config_item($name, &$propbag)
    {
        switch($name) {
            case 'visitor_cronjob':
                $propbag->add('type', 'boolean');
                $propbag->add('name', PLUGIN_EVENT_CRONJOB_VISITOR);
                $propbag->add('description', PLUGIN_EVENT_CRONJOB_VISITOR_DESC);
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

    function checkDB()
    {
        global $serendipity;

        if ($this->get_config('db_ver') < 2) {
            $q   = "CREATE TABLE {$serendipity['dbPrefix']}cronjoblog (
                          timestamp int(10) {UNSIGNED} default null,
                          type varchar(255),
                          reason text)";
            $sql = serendipity_db_schema_import($q);

            $q   = "CREATE INDEX kspamidx ON {$serendipity['dbPrefix']}cronjoblog (timestamp);";
            $sql = serendipity_db_schema_import($q);

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
                        $q = "CREATE INDEX kspamtypeidx ON {$serendipity['dbPrefix']}cronjoblog (type);";
                    } elseif (version_compare($db_version_match[0], '10.3.0', '>=')) {
                        $q = "CREATE INDEX kspamtypeidx ON {$serendipity['dbPrefix']}cronjoblog (type(250));"; // max key 1000 bytes
                    } else {
                        $q = "CREATE INDEX kspamtypeidx ON {$serendipity['dbPrefix']}cronjoblog (type(191));"; // 191 - old MyISAMs
                    }
                } else {
                    // Oracle MySQL - https://dev.mysql.com/doc/refman/5.7/en/innodb-limits.html
                    if (version_compare($db_version_match[0], '5.7.7', '>=')) {
                        $q = "CREATE INDEX kspamtypeidx ON {$serendipity['dbPrefix']}cronjoblog (type);"; // Oracle Mysql/InnoDB max key up to 3072 bytes
                    } else {
                        $q = "CREATE INDEX kspamtypeidx ON {$serendipity['dbPrefix']}cronjoblog (type(191));"; // Oracle Mysql/InnoDB max key 767 bytes
                    }
                }
            } else {
                $q = "CREATE INDEX kspamtypeidx ON {$serendipity['dbPrefix']}cronjoblog (type);";
            }
            $sql = serendipity_db_schema_import($q);
            $this->set_config('db_ver', 2);
        }
    }

    static function log($msg, $type = 'global')
    {
        global $serendipity;
        $now = time();
        echo '[' . date('d.m.Y H:i', $now) . '] ' . $msg . "<br />\n";
        $r = serendipity_db_query("INSERT INTO {$serendipity['dbPrefix']}cronjoblog (timestamp, type, reason) VALUES ($now, '$type', '" . serendipity_db_escape_string($msg) . "')");
    }

    function event_hook($event, &$bag, &$eventData, $addData = null)
    {
        global $serendipity;

        $hooks = &$bag->get('event_hooks');

        if (isset($hooks[$event])) {
            switch($event) {
                case 'frontend_footer':
                    if (serendipity_db_bool($this->get_config('visitor_cronjob'))) {
                        echo '<img alt="cronjob" src="' . $serendipity['baseURL'] . 'index.php?serendipity[cronjob]=true" style="display: none" width="0" height="0" />';
                    }
                    break;

                case 'frontend_configure':
                    if ($serendipity['GET']['cronjob']) {
                        session_write_close();
                        $this->checkDB();
                        $now = time();
                        $ts  = $this->getValues('fetch');
                        foreach($ts as $span => $time) {
                            if ($span == 'off') continue;
                            if ($this->get_config('last_' . $span) < ($now - $time)) {
                                $this->set_config('last_' . $span, $now);
                                $this->log('Executing "cronjob_' . $span . '"', 'execute');
                                serendipity_plugin_api::hook_event('cronjob', $span);
                                serendipity_plugin_api::hook_event('cronjob_' . $span, $serendipity['GET']);
                                $this->log('Next scheduled run: ' . date('d.m.Y H:i', $now+$time), 'next');
                            } else {
                                echo 'Discarding "' . $span . '"<br />' . "\n";
                            }
                        }
                        die('Cronjobs finished.');
                    }
                    break;

                default:
                    return false;
                    break;
            }

            return true;
        } else {
            return false;
        }
    }

}

/* vim: set sts=4 ts=4 expandtab : */
?>