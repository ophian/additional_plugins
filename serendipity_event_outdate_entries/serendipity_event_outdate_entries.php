<?php

if (IN_serendipity !== true) {
    die ("Don't hack!");
}

@serendipity_plugin_api::load_language(dirname(__FILE__));

class serendipity_event_outdate_entries extends serendipity_event {

    var $title = PLUGIN_EVENT_OUTDATE;

    function introspect(&$propbag)
    {
        global $serendipity;

        $propbag->add('name', PLUGIN_EVENT_OUTDATE);
        $propbag->add('description', PLUGIN_EVENT_OUTDATE_DESC);
        $propbag->add('event_hooks',  array('entries_header' => true, 'entry_display' => true));
        $propbag->add('configuration', array('timeout', 'timeout_sticky', 'timeout_custom'));
        $propbag->add('author', 'Garvin Hicking, Ian Styx');
        $propbag->add('requirements',  array(
            'serendipity' => '2.0',
            'smarty'      => '3.1.6',
            'php'         => '7.4.0'
        ));
        $propbag->add('groups', array('FRONTEND_ENTRY_RELATED'));
        $propbag->add('version', '2.1.1');
        $propbag->add('stackable', false);
        $this->dependencies = array('serendipity_event_entryproperties' => 'keep');
    }

    function introspect_config_item($name, &$propbag)
    {
        switch($name) {
            case 'timeout':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_EVENT_OUTDATE_TIMEOUT);
                $propbag->add('description', PLUGIN_EVENT_OUTDATE_TIMEOUT_DESC);
                $propbag->add('default',     0);
                break;

            case 'timeout_sticky':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_EVENT_OUTDATE_TIMEOUT_STICKY);
                $propbag->add('description', PLUGIN_EVENT_OUTDATE_TIMEOUT_STICKY_DESC);
                $propbag->add('default',     0);
                break;

            case 'timeout_custom':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_EVENT_OUTDATE_TIMEOUT_EXPIRY_FIELD);
                $propbag->add('description', PLUGIN_EVENT_OUTDATE_TIMEOUT_EXPIRY_FIELD_DESC);
                $propbag->add('default',     '');
                break;

            default:
                return false;
        }
        return true;
    }

    function generate_content(&$title)
    {
        $title = PLUGIN_EVENT_OUTDATE;
    }

    function event_hook($event, &$bag, &$eventData, $addData = null)
    {
        global $serendipity;

        $hooks = &$bag->get('event_hooks');

        if (isset($hooks[$event])) {
            switch($event) {
                case 'entry_display':
                    if ($this->get_config('timeout') > 0) {
                        $sql = "SELECT id, ep.value AS access
                                  FROM {$serendipity['dbPrefix']}entries
                                    AS e
                       LEFT OUTER JOIN {$serendipity['dbPrefix']}entryproperties
                                    AS ep
                                    ON (ep.entryid = e.id AND ep.property = 'ep_access')
                                 WHERE (ep.property IS NULL OR ep.value = 'public')
                                   AND e.timestamp < " . (time() - ((int)$this->get_config('timeout') * 24 * 60 * 60));

                        $rows = serendipity_db_query($sql);
                        if (is_array($rows)) {
                            foreach($rows AS $idx => $row) {
                                if (!empty($row['access'])) {
                                    serendipity_db_query("UPDATE {$serendipity['dbPrefix']}entryproperties SET value = 'member' WHERE entryid = " . (int)$row['id'] . " AND property = 'ep_access'");
                                } else {
                                    serendipity_db_query("INSERT INTO {$serendipity['dbPrefix']}entryproperties (entryid, property, value) VALUES (" . $row['id'] . ", 'ep_access', 'member')");
                                }
                            }
                        }
                    } else {
                        // Fix issue https://board.s9y.org/viewtopic.php?f=4&t=20456 resetting the timeout variable again after all entries are restricted to get accessed by member(s) only, to 0 or once manual set -1 !
                        if ($this->get_config('timeout') === '-1') {
                            // Check out given entryproperties 'default_read' config variable (private, public, member)
                            if (isset($serendipity[$this->get_config('dependencies').'/default_read'])){
                                $access = $serendipity[$this->get_config('dependencies').'/default_read'];
                            }
                            $ep_access = $access ?? 'public'; // else fallback to default

                            $sql = "SELECT id, ep.value AS access
                                      FROM {$serendipity['dbPrefix']}entries
                                        AS e
                           LEFT OUTER JOIN {$serendipity['dbPrefix']}entryproperties
                                        AS ep
                                        ON (ep.entryid = e.id AND ep.property = 'ep_access')
                                     WHERE (ep.property = 'ep_access' AND ep.value = 'member')
                                       AND e.timestamp < " . (time());

                            $rows = serendipity_db_query($sql);

                            if (is_array($rows)) {
                                foreach($rows AS $idx => $row) {
                                    serendipity_db_query("UPDATE {$serendipity['dbPrefix']}entryproperties SET value = '$ep_access' WHERE entryid = " . (int)$row['id'] . " AND property = 'ep_access'");
                                }
                            }
                            // Reset to 0 for disabled option, to not run again !
                            $this->set_config('timeout', '0');
                        }
                    }

                    // Change to use " . serendipity_db_get_unixTimestamp('ep.value', true) . " up from Styx 5
                    if ($serendipity['dbType'] == 'postgres' || $serendipity['dbType'] == 'pdo-postgres') {
                        $utByDbType = "'EXTRACT(EPOCH FROM ep.value)'";
                    } elseif ($serendipity['dbType'] == 'sqlite' || $serendipity['dbType'] == 'sqlite3' || $serendipity['dbType'] == 'pdo-sqlite' || $serendipity['dbType'] == 'sqlite3oo') {
                        $utByDbType = "STRFTIME('%s', ep.value)";
                    } else {
                        $utByDbType = 'UNIX_TIMESTAMP(ep.value)';
                    }

                    $timeout_custom = $this->get_config('timeout_custom');
                    if (!empty($timeout_custom)) {
                        $sql = "SELECT id, ep.value AS access
                                  FROM {$serendipity['dbPrefix']}entries
                                    AS e
                                  JOIN {$serendipity['dbPrefix']}entryproperties
                                    AS ep
                                    ON ep.entryid = e.id
                                 WHERE e.isdraft = 'false'
                                   AND ep.property = 'ep_" . $timeout_custom . "'
                                   AND ep.value != ''
                                   AND $utByDbType < " . time();

                        $rows = serendipity_db_query($sql);
                        if (is_array($rows)) {
                            foreach($rows AS $idx => $row) {
                                serendipity_db_query("UPDATE {$serendipity['dbPrefix']}entries SET isdraft = 'true' WHERE id = " . (int)$row['id']);
                            }
                        }
                    }

                    if ($this->get_config('timeout_sticky') > 0) {
                        $sql = "SELECT id, ep.value AS sticky
                                  FROM {$serendipity['dbPrefix']}entries
                                    AS e
                       LEFT OUTER JOIN {$serendipity['dbPrefix']}entryproperties
                                    AS ep
                                    ON ep.entryid = e.id
                                 WHERE (ep.property = 'ep_is_sticky')
                                   AND e.timestamp < " . (time() - ($this->get_config('timeout_sticky') * 24 * 60 * 60));

                        $rows = serendipity_db_query($sql);
                        if (is_array($rows)) {
                            foreach($rows AS $idx => $row) {
                                if (!empty($row['sticky'])) {
                                    serendipity_db_query("DELETE FROM {$serendipity['dbPrefix']}entryproperties WHERE property = 'ep_is_sticky' AND entryid = " . (int)$row['id']);
                                }
                            }
                        }
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
