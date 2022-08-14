<?php

if (IN_serendipity !== true) {
    die ("Don't hack!");
}

@serendipity_plugin_api::load_language(dirname(__FILE__));

class serendipity_event_dbclean extends serendipity_event
{
    var $title = PLUGIN_EVENT_DBCLEAN_NAME;

    function introspect(&$propbag)
    {
        global $serendipity;

        $propbag->add('name',          PLUGIN_EVENT_DBCLEAN_NAME);
        $propbag->add('description',   PLUGIN_EVENT_DBCLEAN_DESC);
        $propbag->add('stackable',     false);
        $propbag->add('author',        'Malte Paskuda, Matthias Mees, Ian Styx');
        $propbag->add('version',       '0.6');
        $propbag->add('requirements',  array(
            'serendipity' => '2.0'
        ));
        $propbag->add('event_hooks',   array(
                                    'backend_sidebar_admin_appearance'  => true,
                                    'backend_sidebar_entries_event_display_dbclean'  => true,
                                    'external_plugin' => true,
                                    'css_backend' => true,
                                    'cronjob' => true
            )
            );
        $propbag->add('groups', array('BACKEND_FEATURES'));
        $propbag->add('configuration', array('cronjob', 'days'));
    }

    function generate_content(&$title)
    {
        $title = $this->title;
    }

    function introspect_config_item($name, &$propbag)
    {
        switch($name) {
            case 'cronjob':
                if (class_exists('serendipity_event_cronjob')) {
                    $propbag->add('type',        'select');
                    $propbag->add('name',        PLUGIN_EVENT_DBCLEAN_CRONJOB);
                    $propbag->add('description', '');
                    $propbag->add('default',     'daily');
                    $propbag->add('select_values', serendipity_event_cronjob::getValues());
                }
                break;

            case 'days':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_EVENT_DBCLEAN_MENU_KEEP . ' (' . DAYS . ')');
                $propbag->add('description', '');
                $propbag->add('default',     '30');
                break;

            default:
                return false;
        }
        return true;
    }

    function event_hook($event, &$bag, &$eventData, $addData = null)
    {
        global $serendipity;

        $hooks = &$bag->get('event_hooks');

        if (isset($hooks[$event])) {

            switch($event) {
                case 'cronjob':
                    if ($this->get_config('cronjob') == $eventData) {
                        serendipity_event_cronjob::log('DBClean', 'plugin');

                        $days = (int)$this->get_config('days');
                        if ($days > 0) {
                            if (class_exists('serendipity_event_cronjob')) $this->cleanDB('cronjoblog', $days);
                            if (class_exists('serendipity_event_karma')) $this->cleanDB('karmalog', $days);
                            $this->cleanDB('spamblocklog', $days);
                            $this->cleanDB('spamblock_htaccess', $days);
                            if (class_exists('serendipity_event_statistics')) $this->cleanDB('visitors', $days);
                            $this->cleanDB('referrers', $days);
                            $this->cleanDB('exits', $days);
                        }
                    }
                    break;

                case 'external_plugin':
                    switch ($eventData) {
                        case 'dbclean':
                            if (! (serendipity_checkPermission('siteConfiguration') || serendipity_checkPermission('blogConfiguration'))) {
                                return;
                            }
                            $days = $_POST['days'];
                            if (is_numeric($days)) {
                                if (isset($_POST['cronjoblog']) && class_exists('serendipity_event_cronjob')) {
                                    $this->cleanDB('cronjoblog', $days);
                                }
                                if (isset($_POST['karmalog']) && class_exists('serendipity_event_karma')) {
                                    $this->cleanDB('karmalog', $days);
                                }
                                if (isset($_POST['spamblocklog'])) {
                                    $this->cleanDB('spamblocklog', $days);
                                }
                                if (isset($_POST['spamblock_htaccess'])) {
                                    $this->cleanDB('spamblock_htaccess', $days);
                                }
                                if (isset($_POST['visitors']) && class_exists('serendipity_event_statistics')) {
                                    $this->cleanDB('visitors', $days);
                                }
                                if (isset($_POST['referrers'])) {
                                    $this->cleanDB('referrers', $days);
                                }
                                if (isset($_POST['exits'])) {
                                    $this->cleanDB('exits', $days);
                                }
                            }
                            #redirect the user back to the menu
                            echo '<meta http-equiv="REFRESH" content="0;url=serendipity_admin.php?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=dbclean">';
                            return true;
                            break;
                        }
                        break;

                case 'backend_sidebar_admin_appearance':
                    echo '<li><a href="serendipity_admin.php?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=dbclean">' .PLUGIN_EVENT_DBCLEAN_NAME ."</a></li>\n";
                    break;

                case 'backend_sidebar_entries_event_display_dbclean':
                    $this->displayMenu();
                    break;

                case 'css_backend':
                    // append!
                    $eventData .= '

/* serendipity_event_dbclean start */

#dbcleanTable {
    border: 1px solid #aaa;
    border-bottom: 0 none;
    width: 100%;
}

#dbcleanTable thead tr {
    background-color: #eee;
}

#dbcleanTable tr {
    border-bottom: 1px solid #aaa;
}

#dbcleanTable th,
#dbcleanTable td {
    padding: .125em .25em;
}

/* serendipity_event_dbclean end */

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

    private function cleanDB($table, $days)
    {
        global $serendipity;
        set_time_limit(0);

        if (in_array($table, array('visitors', 'referrers', 'exits'))) {
            if (stristr($serendipity['dbType'], 'sqlite')) {
                $sql = "DELETE
                          FROM {$serendipity['dbPrefix']}$table
                         WHERE strftime('%s', day) < (strftime('%s', 'now') - ($days*86400))";
            }
            else if (stristr($serendipity['dbType'], 'postgres')) {
                $sql = "DELETE
                          FROM {$serendipity['dbPrefix']}$table
                         WHERE to_timestamp(day) < (NOW() - INTERVAL '$days days')";
            }
            else {
                $sql = "DELETE
                          FROM {$serendipity['dbPrefix']}$table
                         WHERE UNIX_TIMESTAMP(day) < (UNIX_TIMESTAMP(NOW()) - ($days*86400))";
            }
            serendipity_db_query($sql);
        }
        else if ($table == 'karmalog') {
            if (stristr($serendipity['dbType'], 'sqlite')) {
                $sql = "DELETE
                          FROM {$serendipity['dbPrefix']}karmalog
                         WHERE votetime < (strftime('%s', 'now') - ($days*86400))";
            }
            else if (stristr($serendipity['dbType'], 'postgres')) {
                $sql = "DELETE
                          FROM {$serendipity['dbPrefix']}karmalog
                         WHERE votetime < (NOW() - INTERVAL '$days days')";
            }
            else {
                $sql = "DELETE
                          FROM {$serendipity['dbPrefix']}karmalog
                         WHERE votetime < (UNIX_TIMESTAMP(NOW()) - ($days*86400))";
            }
            serendipity_db_query($sql);
        }
        if (in_array($table, array('cronjoblog', 'spamblocklog', 'spamblock_htaccess'))) {
            if (stristr($serendipity['dbType'], 'sqlite')) {
                $sql = "DELETE
                          FROM {$serendipity['dbPrefix']}$table
                         WHERE timestamp < (strftime('%s', 'now') - ($days*86400))";
            }
            else if (stristr($serendipity['dbType'], 'postgres')) {
                $sql = "DELETE
                          FROM {$serendipity['dbPrefix']}$table
                         WHERE timestamp < (NOW() - INTERVAL '$days days')";
            }
            else {
                $sql = "DELETE
                          FROM {$serendipity['dbPrefix']}$table
                         WHERE timestamp < (UNIX_TIMESTAMP(NOW()) - ($days*86400))";
            }
            serendipity_db_query($sql);
        }

        switch($serendipity['dbType']) {
            case 'sqlite':
            case 'sqlite3':
            case 'sqlite3oo':
            case 'pdo-sqlite':
                $sql = "VACUUM";
                serendipity_db_query($sql);
                break;

            case 'pdo-postgres':
            case 'postgres':
                $sql = "VACUUM";
                serendipity_db_query($sql);
                break;

            case 'mysql':
            case 'mysqli':
                $sql = "OPTIMIZE TABLE
                        {$serendipity['dbPrefix']}$table";
                serendipity_db_query($sql);
                break;
        }
    }

    function displayMenu()
    {
        global $serendipity;

        echo '<h2>' . PLUGIN_EVENT_DBCLEAN_NAME_MENU . "</h2>\n";

        echo '<form action="'.$serendipity['baseURL'] . 'index.php?/plugin/dbclean' .'" method="post">'."\n";
        echo '<div class="form_field">'."\n";
        echo '  <label for="dbcleanup_days">' . PLUGIN_EVENT_DBCLEAN_MENU_KEEP . ' (' . DAYS . ')' . "</label>\n";
        echo '  <input id="dbcleanup_days" type="text" name="days" value="' . $this->get_config('days') . '" size="3" maxlength="3">'."\n";
        echo "</div>\n";

        $thc = array(DELETE, PLUGIN_EVENT_DBCLEAN_TABLE, ENTRIES);
        echo <<<EOS
        <table id="dbcleanTable">
          <thead>
            <tr>
              <th>{$thc[0]}</th>
              <th>{$thc[1]}</th>
              <th>{$thc[2]}</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td><input class="input_checkbox" type="checkbox" name="spamblocklog" value="spamblocklog" checked="checked" tabindex="1" /></td>
              <td>spamblocklog</td>
              <td>{$this->countElements('spamblocklog')}</td>
            </tr>
            <tr>
              <td><input class="input_checkbox" type="checkbox" name="spamblock_htaccess" value="spamblock_htaccess" checked="checked" tabindex="1" /></td>
              <td>spamblock_htaccess</td>
              <td>{$this->countElements('spamblock_htaccess')}</td>
            </tr>
            <tr>
              <td><input class="input_checkbox" type="checkbox" name="visitors" value="visitors" checked="checked" tabindex="1" /></td>
              <td>visitors</td>
              <td>{$this->countElements('visitors')}</td>
            </tr>
            <tr>
              <td><input class="input_checkbox" type="checkbox" name="referrers" value="referrers" checked="checked" tabindex="1" /></td>
              <td>referrers</td>
              <td>{$this->countElements('referrers')}</td>
            </tr>
            <tr>
              <td><input class="input_checkbox" type="checkbox" name="exits" value="exits" checked="checked" tabindex="1" /></td>
              <td>exits</td>
              <td>{$this->countElements('exits')}</td>
            </tr>
            <tr>
              <td><input class="input_checkbox" type="checkbox" name="cronjoblog" value="cronjoblog" checked="checked" tabindex="1" /></td>
              <td>cronjoblog</td>
              <td>{$this->countElements('cronjoblog')}</td>
            </tr>
            <tr>
              <td><input class="input_checkbox" type="checkbox" name="karmalog" value="karmalog" checked="checked" tabindex="1" /></td>
              <td>karmalog</td>
              <td>{$this->countElements('karmalog')}</td>
            </tr>
        </table>
EOS;

        echo '<div class="form_buttons"><input class="state_cancel" type="submit" value="' . DELETE . '"></div>'."\n";
        echo "</form>\n";
    }

    function countElements($table)
    {
        global $serendipity;

        $sql = "SELECT COUNT(1)
                  FROM {$serendipity['dbPrefix']}$table";
        $count = serendipity_db_query($sql, true, 'num', false, false, false, true); // set single true and last expectError true, since table is known to fail when not exist
        if (is_array($count)) {
            if (is_array($count[0])) {
                return $count[0][0];
            }
        }
        return (!empty($count) && is_numeric($count[0])) ? $count[0] : '-';
    }

    function debugMsg($msg)
    {
        global $serendipity;

        $this->debug_fp = @fopen( $serendipity['serendipityPath'] . 'templates_c/dbclean.log', 'a' );
        if (! $this->debug_fp) {
            return false;
        }

        if (empty( $msg )) {
            fwrite( $this->debug_fp, "failure \n" );
        } else {
            fwrite( $this->debug_fp, print_r( $msg, true ) );
        }
        fclose( $this->debug_fp );
    }

}

/* vim: set sts=4 ts=4 expandtab : */
?>