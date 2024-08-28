<?php

if (IN_serendipity !== true) {
    die ("Don't hack!");
}

@serendipity_plugin_api::load_language(dirname(__FILE__));

class serendipity_event_trackback extends serendipity_event
{
    var $title = PLUGIN_EVENT_MTRACKBACK_TITLETITLE;
    var $cache = array();

    function introspect(&$propbag)
    {
        global $serendipity;

        $propbag->add('name',          PLUGIN_EVENT_MTRACKBACK_TITLETITLE);
        $propbag->add('description',   PLUGIN_EVENT_MTRACKBACK_TITLEDESC);
        $propbag->add('stackable',     false);
        $propbag->add('author',        'Garvin Hicking, Malte Paskuda, Ian Styx');
        $propbag->add('version',       '1.38');
        $propbag->add('requirements',  array(
            'serendipity' => '2.1',
            'smarty'      => '3.1.0',
            'php'         => '5.3.0'
        ));
        $propbag->add('event_hooks',    array(
            'backend_display'           => true,
            'backend_trackbacks'        => true,
            'backend_trackback_check'   => true,
            'backend_http_request'      => true,
            'genpage'                   => true,
            'backend_publish'           => true,
            'backend_save'              => true,
            'css_backend'               => true
        ));
        $propbag->add('configuration', array('disable_trackall', 'trackown', 'delayed_trackbacks', 'host', 'port', 'user', 'password'));
        $propbag->add('groups', array('BACKEND_EDITOR'));
    }

    function introspect_config_item($name, &$propbag)
    {
        switch($name) {
            case 'trackown':
                $propbag->add('type',        'boolean');
                $propbag->add('name',        PLUGIN_EVENT_MTRACKBACK_TITLETRACKOWN);
                $propbag->add('default',     'true');
                break;

            case 'disable_trackall':
                $propbag->add('type',        'boolean');
                $propbag->add('name',        PLUGIN_EVENT_MTRACKBACK_TITLETRACKALL);
                $propbag->add('default',     'false');
                break;

            case 'delayed_trackbacks':
                $propbag->add('type',        'boolean');
                $propbag->add('name',        PLUGIN_EVENT_MTRACKBACK_DELAYED_TRACKBACKS_NAME);
                $propbag->add('description', PLUGIN_EVENT_MTRACKBACK_DELAYED_TRACKBACKS_DESC);
                $propbag->add('default',     'true');
                break;

            case 'host':
                $propbag->add('type',        'string');
                $propbag->add('name',        'Proxy Host');
                $propbag->add('default',     '');
                break;

            case 'port':
                $propbag->add('type',        'string');
                $propbag->add('name',        'Proxy Port');
                $propbag->add('default',     '');
                break;

            case 'user':
                $propbag->add('type',        'string');
                $propbag->add('name',        'Proxy User');
                $propbag->add('default',     '');
                break;

            case 'password':
                $propbag->add('type',        'string');
                $propbag->add('name',        'Proxy Password');
                $propbag->add('default',     '');
                break;

            default:
                return false;
        }
        return true;
    }

    function generate_content(&$title)
    {
        $title = PLUGIN_EVENT_MTRACKBACK_TITLETITLE;
    }

    function install()
    {
        $this->setupDB();
    }

    function event_hook($event, &$bag, &$eventData, $addData = null)
    {
        global $serendipity;

        $hooks = &$bag->get('event_hooks');
        if (isset($hooks[$event])) {

            switch($event) {
                case 'backend_http_request':
                    // Setup a Proxy?
                    $host = $this->get_config('host');
                    if (!empty($host)) {
                        $eventData['proxy_host'] = $host;
                        $eventData['proxy_port'] = $this->get_config('port');
                        $eventData['proxy_user'] = $this->get_config('user');
                        $eventData['proxy_password'] = $this->get_config('password');
                    }
                    break;

                case 'backend_trackbacks':
                    if (!isset($serendipity['POST']['enable_trackback']) && serendipity_db_bool($this->get_config('disable_trackall', 'false'))) {
                        $serendipity['noautodiscovery'] = true;
                    } elseif (isset($serendipity['POST']['enable_trackback']) && $serendipity['POST']['enable_trackback'] == 'off') {
                        $serendipity['noautodiscovery'] = true;
                    } else {
                        if (isset($serendipity['POST']['enable_trackback']) && $serendipity['POST']['enable_trackback'] == 'selective') {
                            // Clear TB URLs from the entry, start afresh from the textarea input.
                            $eventData = array();
                        }
                        $debug = $serendipity['trackback_debug_data'] ?? null;
                        if (!empty($serendipity['POST']['additional_trackbacks'])) {
                            $trackbackURLs = preg_split('@[ \s]+@', trim($serendipity['POST']['additional_trackbacks']));
                            if ($debug) $serendipity['logger']->debug("Trackback Plugin entry POST additional trackbacks " . print_r($trackbackURLs,true));
                            foreach($trackbackURLs AS $trackbackURL) {
                                $trackbackURL = trim($trackbackURL);
                                if (!in_array($trackbackURL, $eventData)) {
                                    $eventData[] = $trackbackURL;
                                    $this->cache[$trackbackURL] = 'plugin';
                                }
                            }
                        }

                        // Shall URLs be removed that point to your own blog?
                        if (!serendipity_db_bool($this->get_config('trackown', 'true'))) {
                            foreach($eventData AS $idx => $url) {
                                if (preg_match('@' . preg_quote($serendipity['baseURL'], '@') . '@i', $url)) {
                                    unset($eventData[$idx]);
                                }
                            }
                        }
                    }
                    // Debugging purpose only
                    if (isset($serendipity['POST']['trackback_resend'])) {
                        // the user selected to always send trackbacks, even if already stored
                        $serendipity['skip_trackback_check'] = true;
                    } else {
                        unset($serendipity['skip_trackback_check']);
                    }
                    break;

                case 'backend_trackback_check':
                    $checklock = '';
                    if (isset($this->cache[$addData])) {
                        $eventData[2] = $addData;
                        $eventData['skipValidate'] = true;
                    }
                    break;

                case 'backend_display':
                    $trackbackURLs = array();
                    if (isset($eventData['id']) && $eventData['id'] > 0) {
                        $urls = serendipity_db_query("SELECT link FROM {$serendipity['dbPrefix']}references WHERE entry_id = '". (int)$eventData['id'] ."'");
                        if (is_array($urls)) {
                            foreach($urls AS $row) {
                                $trackbackURLs[] = (function_exists('serendipity_specialchars') ? serendipity_specialchars($row['link']) : htmlspecialchars($row['link'], ENT_COMPAT, LANG_CHARSET));
                            }
                        }
                    }

                    if (isset($serendipity['POST']['additional_trackbacks'])) {
                        $additional_urls = preg_split('@[ \s]+@', trim($serendipity['POST']['additional_trackbacks']));
                        foreach($additional_urls AS $additional_url) {
                            $additional_url = trim($additional_url);
                            if (!in_array($additional_url, $trackbackURLs)) {
                                $trackbackURLs[] = (function_exists('serendipity_specialchars') ? serendipity_specialchars($additional_url) : htmlspecialchars($additional_url, ENT_COMPAT, LANG_CHARSET));
                            }
                        }
                    }

                    if (!isset($serendipity['POST']['enable_trackback'])) {
                        if (serendipity_db_bool($this->get_config('disable_trackall', 'false'))) {
                            $serendipity['POST']['enable_trackback'] = 'off';
                        } else {
                            $serendipity['POST']['enable_trackback'] = 'on';
                        }
                    }
                    $debugcheck = (isset($serendipity['logLevel']) && $serendipity['logLevel'] === 'debug')
? '                <input class="input_checkbox" type="checkbox" id="checkbox_enable_trackback_4" name="serendipity[trackback_resend]" value="true" /><label for="checkbox_enable_trackback_4">A forced resend of all trackbacks, if one sending option is chosen. (Debug purpose only!)</label><br />'
: '';
?>

            <fieldset id="edit_entry_trackbacks" class="entryproperties_trackbacks">
                <span class="wrap_legend"><legend><?php echo PLUGIN_EVENT_MTRACKBACK_TITLETITLE; ?></legend></span>
<?= $debugcheck ?>
                <input class="input_radio" type="radio" id="checkbox_enable_trackback_1" <?php echo ($serendipity['POST']['enable_trackback'] == 'on'        ? 'checked="checked"' : ''); ?> name="serendipity[enable_trackback]" value="on" /><label for="checkbox_enable_trackback_1"><?php echo ACTIVATE_AUTODISCOVERY; ?></label><br />
                <input class="input_radio" type="radio" id="checkbox_enable_trackback_2" <?php echo ($serendipity['POST']['enable_trackback'] == 'off'       ? 'checked="checked"' : ''); ?> name="serendipity[enable_trackback]" value="off" /><label for="checkbox_enable_trackback_2"><?php echo PLUGIN_EVENT_MTRACKBACK_TITLETRACKALL; ?></label><br />
                <input class="input_radio" type="radio" id="checkbox_enable_trackback_3" <?php echo ($serendipity['POST']['enable_trackback'] == 'selective' ? 'checked="checked"' : ''); ?> name="serendipity[enable_trackback]" value="selective" /><label for="checkbox_enable_trackback_3"><?php echo PLUGIN_EVENT_MTRACKBACK_TITLETRACKSEL; ?></label>
                <button class="toggle_info button_link" type="button" data-href="#trackback_tab_info"><span class="icon-info-circled" aria-hidden="true"></span><span class="visuallyhidden"><?= MORE ?></span></button><br />
                <div id="trackback_tab_info" class="clearfix field_info additional_info" style="width: 100%;"><span class="icon-info-circled"></span> <?= PLUGIN_EVENT_MTRACKBACK_CONTROL ?></div><br>

                <span class="wrap_legend"><label for="input_additional_trackbacks"><?php echo PLUGIN_EVENT_MTRACKBACK_TITLEADDITIONAL; ?></label></span>
                <span class="wrap_right"><span class="buttonless_link state_cancel" type="button" href="#edit_entry_trackbacks" onclick="clearFieldTrackbacks();">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
                  <title><?= CLEAR_FIELD ?></title>
                  <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8z"/>
                </svg></span></span>
                <div data-tooltip=" [i] &nbsp;&nbsp;<?= PLUGIN_EVENT_MTRACKBACK_CONTROL_SHORT ?>"></div>

                <textarea rows="5" cols="50" id="input_additional_trackbacks" name="serendipity[additional_trackbacks]"><?php echo trim(implode("\n", $trackbackURLs)); ?></textarea>
            </fieldset>

            <script> function clearFieldTrackbacks() { document.getElementById("input_additional_trackbacks").value = ""; $('div[data-tooltip]').addClass('clearChecked'); } </script>

<?php
                    break;

                case 'backend_save':
                case 'backend_publish':
                    if (!serendipity_db_bool($eventData['isdraft'])
                      && $eventData['timestamp'] >= serendipity_serverOffsetHour()
                      && serendipity_db_bool($this->get_config('delayed_trackbacks', 'true'))
                    ) {
                        // trackbacks couldn't get generated, so store this entry
                        $this->delay($eventData['id'], $eventData['timestamp']);
                    }
                    break;

                case 'css_backend':
                    $eventData .= '

/* serendipity_event_trackback start */

#edit_entry_trackbacks legend {
    margin-top: 1em;
    margin-bottom: 1em;
}
#edit_entry_trackbacks label {
    margin-left: .25em;
}
#edit_entry_trackbacks .wrap_right {
  float: right;
}
#edit_entry_trackbacks .wrap_right:after {
    clear: right;
}

#edit_entry_trackbacks .clearChecked[data-tooltip]:before {
    position: absolute;
    content: attr(data-tooltip);
    opacity: 1;
    right: 0;
    width: 75%;
    padding: .25rem;
    background-color: var(--color-input-tooltip-warning-bg);
    color: var(--color-input-tooltip-warning-text);
    font-size: smaller;
    pointer-events: none;
}
@media only screen and (min-width: 412px) {
  #edit_entry_trackbacks .clearChecked[data-tooltip]:before {
    width: 50%; }
}
@media only screen and (min-width: 660px) {
  #edit_entry_trackbacks .clearChecked[data-tooltip]:before {
    width: 41%; }
}
@media only screen and (min-width: 768px) {
  #edit_entry_trackbacks .clearChecked[data-tooltip]:before {
    width: 32%; }
}

/* serendipity_event_trackback end */

';
                    break;

                case 'genpage':
                    # don't check on every page
                    $try = mt_rand(1, 10);
                    if ($try == 1 && serendipity_db_bool($this->get_config('delayed_trackbacks', 'true'))) {
                        $this->generateDelayed();
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

    /**
     * store id of an entry and wanted release-timestamp
     */
    function delay($id, $timestamp)
    {
        global $serendipity;

        $this->upgradeCheck();
        $this->removeDelayed($id);
        $sql = "INSERT INTO
                    {$serendipity['dbPrefix']}delayed_trackbacks (id, timestamp)
                VALUES
                    ({$id}, {$timestamp})";
        serendipity_db_query($sql);
    }

    /**
     * generate trackbacks for entries which now are shown
     */
    function generateDelayed()
    {
        global $serendipity;

        $this->upgradeCheck();

        $sql = "SELECT id, timestamp FROM {$serendipity['dbPrefix']}delayed_trackbacks";
        $entries = serendipity_db_query($sql);

        if (is_array($entries) && !empty($entries)) {
            foreach ($entries AS $entry) {
                if ($entry['timestamp'] <= serendipity_serverOffsetHour()) {
                    include_once S9Y_INCLUDE_PATH . 'include/functions_trackbacks.inc.php';

                    $stored_entry = serendipity_fetchEntry('id', $entry['id']);

                    if (isset($_SESSION['serendipityRightPublish'])) {
                        $oldPublighRights = $_SESSION['serendipityRightPublish'];
                    } else {
                        $oldPublighRights = 'unset';
                    }
                    $_SESSION['serendipityRightPublish'] = true;
                    # remove unnatural entry-data which let the update fail
                    if (isset($stored_entry['loginname'])) {
                        unset($stored_entry['loginname']);
                    }
                    if (isset($stored_entry['email'])) {
                        unset($stored_entry['email']);
                    }

                    # Convert fetched categories to storable categories.
                    $current_cat = $stored_entry['categories'];
                    $stored_entry['categories'] = array();
                    foreach($current_cat AS $categoryidx => $category_data) {
                        $stored_entry['categories'][$category_data['categoryid']] = $category_data['categoryid'];
                    }

                    ob_start();
                    serendipity_updertEntry($stored_entry);
                    ob_end_clean();

                    if ($oldPublighRights == 'unset') {
                        unset($_SESSION['serendipityRightPublish']);
                    } else {
                        $_SESSION['serendipityRightPublish'] = $oldPublighRights;
                    }
                    # the trackbacks are now generated
                    $this->removeDelayed($entry['id']);
                }
            }
        }
    }

    /**
     * remove delayed entry from further use
     */
    function removeDelayed($id)
    {
        global $serendipity;

        $sql = "DELETE FROM {$serendipity['dbPrefix']}delayed_trackbacks
                      WHERE id={$id}";
        serendipity_db_query($sql);
    }

    function setupDB()
    {
        global $serendipity;

        // postgres < 9.3 IF NOT EXISTS workaround...
        $c = serendipity_db_query("SELECT COUNT(*) FROM {$serendipity['dbPrefix']}delayed_trackbacks", true, 'num', false, false, false, true); //expect error
        if (!is_bool($c) && is_numeric($c[0])) {
            return;
        }
        $sql = "CREATE TABLE {$serendipity['dbPrefix']}delayed_trackbacks (
                id int(11) NOT NULL {PRIMARY},
                timestamp int(10) {UNSIGNED}
                )";
        serendipity_db_schema_import($sql);
    }

    function upgradeCheck()
    {
        $db_upgrade = $this->get_config('db_upgrade', '');
        if ($db_upgrade != 4) {
            $this->setupDB();
            $this->set_config('db_upgrade', 4);
        }
    }

}

/* vim: set sts=4 ts=4 expandtab : */
?>