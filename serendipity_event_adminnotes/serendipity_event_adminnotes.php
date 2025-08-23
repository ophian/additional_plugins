<?php

declare(strict_types=1);

if (IN_serendipity !== true) {
    die ("Don't hack!");
}

@serendipity_plugin_api::load_language(dirname(__FILE__));

class serendipity_event_adminnotes extends serendipity_event
{
    #var $debug;

    function introspect(&$propbag)
    {
        global $serendipity;

        $propbag->add('name',          PLUGIN_ADMINNOTES_TITLE);
        $propbag->add('description',   PLUGIN_ADMINNOTES_DESC);
        $propbag->add('requirements',  array(
            'serendipity' => '5.0',
            'smarty'      => '4.1',
            'php'         => '8.2'
        ));

        $propbag->add('version',       '1.1.1');
        $propbag->add('author',        'Garvin Hicking, Matthias Mees, Ian Styx');
        $propbag->add('stackable',     false);
        $propbag->add('configuration', array('feedback', 'limit', 'expire', 'html', 'markup', 'cutoff'));
        $propbag->add('event_hooks',   array(
            'backend_sidebar_entries'                           => true,
            'backend_sidebar_entries_event_display_adminnotes'  => true,
            'js_backend'                                        => true,
            'backend_dashboard'                                 => true,
            'css_backend'                                       => true,
        ));
        $propbag->add('groups', array('BACKEND_FEATURES','BACKEND_DASHBOARD'));
    }

    function introspect_config_item($name, &$propbag)
    {
        switch($name) {
            case 'feedback':
                $propbag->add('type',        'boolean');
                $propbag->add('name',        PLUGIN_ADMINNOTES_FEEDBACK);
                $propbag->add('description', PLUGIN_ADMINNOTES_FEEDBACK_DESC);
                $propbag->add('default',     'true');
                break;

            case 'html':
                $radio = array();
                $radio['value'][] = 'true';
                $radio['desc'][]  = YES;

                $radio['value'][] = 'false';
                $radio['desc'][]  = NO;

                $radio['value'][] = 'admin';
                $radio['desc'][]  = USERLEVEL_ADMIN_DESC;

                $propbag->add('type',        'radio');
                $propbag->add('radio',       $radio);
                $propbag->add('name',        PLUGIN_ADMINNOTES_HTML);
                $propbag->add('description', PLUGIN_ADMINNOTES_HTML_DESC);
                $propbag->add('default',     'false');
                break;

            case 'limit':
                $propbag->add('type',        'string');
                $propbag->add('name',        LIMIT_TO_NUMBER);
                $propbag->add('description', '');
                $propbag->add('default',     '15');
                break;

            case 'expire':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_ADMINNOTES_EXPIRE_IN_DAYS);
                $propbag->add('description', '');
                $propbag->add('default',     '0');
                break;

            case 'cutoff':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_ADMINNOTES_CUTOFF);
                $propbag->add('description', PLUGIN_ADMINNOTES_CUTOFF_DESC);
                $propbag->add('default',     '200');
                break;

            case 'markup':
                $propbag->add('type',        'boolean');
                $propbag->add('name',        DO_MARKUP);
                $propbag->add('description', DO_MARKUP_DESCRIPTION);
                $propbag->add('default',     'true');
                break;

            default:
                return false;
        }
        return true;
    }

    function setupDB()
    {
        global $serendipity;

        if (serendipity_db_bool($this->get_config('db_built_1', false))) {
            return true;
        }

        $sql = "CREATE TABLE IF NOT EXISTS {$serendipity['dbPrefix']}adminnotes (
                      noteid {AUTOINCREMENT} {PRIMARY},
                      authorid int(10) {UNSIGNED} default null,
                      notetime int(10) {UNSIGNED} default null,
                      subject varchar(255),
                      body text,
                      notetype     varchar(255) NOT NULL default ''
                    );";

        serendipity_db_schema_import($sql);

        $sql = "CREATE TABLE IF NOT EXISTS {$serendipity['dbPrefix']}adminnotes_to_groups (
                      noteid int(10) {UNSIGNED} default null,
                      groupid int(10) {UNSIGNED} default null
                    );";

        serendipity_db_schema_import($sql);

        $this->set_config('db_built_1', 'true');
    }

    function getMyNotes($limited = true)
    {
        global $serendipity;

        $this->setupDB();

        $expire = (int)$this->get_config('expire', 0);
        $and    = is_int($limited) ? " AND" : "WHERE";
        if ($serendipity['dbType'] == 'postgres' || $serendipity['dbType'] == 'pdo-postgres') {
            $exbydb = "(CURRENT_TIMESTAMP - INTERVAL '$expire DAY')"; // CURRENT_TIMESTAMP is a synonym for NOW
        } elseif ($serendipity['dbType'] == 'sqlite' || $serendipity['dbType'] == 'sqlite3' || $serendipity['dbType'] == 'pdo-sqlite' || $serendipity['dbType'] == 'sqlite3oo') {
            $exbydb = "DATETIME('NOW', '-$expire DAY')"; // SQLite has no NOW() function
        } else {
            $exbydb = "(UNIX_TIMESTAMP(DATE_SUB(NOW(), INTERVAL $expire DAY)))";
        }
        $where  = ($expire > 0) ? "$and a.notetime > $exbydb" : '';

        $sql = "SELECT a.noteid, a.authorid, a.notetime, a.subject, a.body, a.notetype,
                       ar.realname
                  FROM {$serendipity['dbPrefix']}adminnotes
                    AS a

                  JOIN {$serendipity['dbPrefix']}adminnotes_to_groups
                    AS atg
                    ON atg.noteid = a.noteid

                  JOIN {$serendipity['dbPrefix']}authorgroups
                    AS ag
                    ON (ag.groupid = atg.groupid AND ag.authorid = {$serendipity['authorid']})

                  JOIN {$serendipity['dbPrefix']}authors
                    AS axs
                    ON axs.authorid = ag.authorid

                  JOIN {$serendipity['dbPrefix']}authors
                    AS ar
                    ON ar.authorid = a.authorid
                " . (is_int($limited) ? 'WHERE a.noteid = ' . (int)$limited : '') . $where . "
              GROUP BY a.noteid
              ORDER BY a.notetime DESC";

        if ($limited) {
            $sql .= ' ' . serendipity_db_limit_sql($this->get_config('limit'));
        }
        return serendipity_db_query($sql, (is_int($limited) ? true : false), 'assoc');
    }

    function generate_content(&$title)
    {
        $title = PLUGIN_ADMINNOTES_TITLE;
    }

    function shownotes()
    {
        global $serendipity;

        echo '<h2>' . PLUGIN_ADMINNOTES_TITLE . "</h2>\n";

        if (!serendipity_db_bool($this->get_config('feedback')) && $serendipity['serendipityUserlevel'] < USERLEVEL_CHIEF) {
            return false;
        }

        $allow_html = $this->get_config('html');

        $_REQUEST['action'] = $_REQUEST['action'] ?? null;
        switch($_REQUEST['action']) {
            case 'edit':
                $entry = $this->getMyNotes((int)$_REQUEST['note']);
                $mode  = 'update';
            case 'new':
                if (!isset($mode)) {
                    $mode = 'insert';
                }

                if (!isset($entry) || !is_array($entry)) {
                    $entry = array();
                }

                if (isset($_REQUEST['submit'])/* && serendipity_checkFormToken() */) {
                    $valid_groups = serendipity_getAllGroups($serendipity['authorid']);
                    $targets = array();
                    if (is_array($_REQUEST['note_target'])) {
                        foreach($_REQUEST['note_target'] AS $groupid) {
                            $found = false;
                            foreach($valid_groups AS $group) {
                                if ($group['confkey'] == $groupid) {
                                    $found = true;
                                    break;
                                }
                            }

                            if ($found) {
                                $targets[] = (int)$groupid;
                            }

                        }
                    }

                    if ($mode == 'update') {
                        $noteid = (int)$_REQUEST['note'];
                        $q = serendipity_db_query("UPDATE {$serendipity['dbPrefix']}adminnotes
                                                 SET authorid = {$serendipity['authorid']},
                                                     subject = '" . serendipity_db_escape_string($_REQUEST['note_subject']) . "',
                                                     body = '" . serendipity_db_escape_string($_REQUEST['note_body']) . "',
                                                     notetype = '" . serendipity_db_escape_string($_REQUEST['note_notetype']) . "'
                                               WHERE noteid = $noteid");
                        $q = serendipity_db_query("DELETE FROM {$serendipity['dbPrefix']}adminnotes_to_groups WHERE noteid = $noteid");
                        foreach($targets AS $target) {
                            $q = serendipity_db_query("INSERT INTO {$serendipity['dbPrefix']}adminnotes_to_groups (noteid, groupid) VALUES ($noteid, $target)");
                        }
                        if (is_string($q)) {
                            echo $q . "<br>\n";
                        }
                    } else {
                        serendipity_db_query("INSERT INTO {$serendipity['dbPrefix']}adminnotes (authorid, notetime, subject, body, notetype) VALUES ('" . $serendipity['authorid'] . "', " . time() . ", '" . serendipity_db_escape_string($_REQUEST['note_subject']) . "', '" . serendipity_db_escape_string($_REQUEST['note_body']) . "', '" . serendipity_db_escape_string($_REQUEST['note_notetype']) . "')");
                        $noteid = serendipity_db_insert_id('adminnotes', 'noteid');
                        foreach($targets AS $target) {
                            serendipity_db_query("INSERT INTO {$serendipity['dbPrefix']}adminnotes_to_groups (noteid, groupid) VALUES ($noteid, $target)");
                        }
                    }
                    echo '<span class="msg_success"><span class="icon-ok-circled" aria-hidden="true"></span> ' . DONE . ': '. sprintf(SETTINGS_SAVED_AT, serendipity_strftime('%H:%M:%S')) . "</span>\n";
                }

                echo '
<p>' . PLUGIN_ADMINNOTES_FEEDBACK_INFO . '</p>

<form name="serendipity[adminnotes]" action="?" method="post">
    '. serendipity_setFormToken() .'
    <input type="hidden" name="serendipity[adminModule]" value="event_display">
    <input type="hidden" name="serendipity[adminAction]" value="adminnotes">
    <input type="hidden" name="action" value="' . htmlspecialchars($_REQUEST['action']) . '">
    <input type="hidden" name="note" value="' . ($entry['noteid'] ?? '') . '">
    <input type="hidden" name="note_notetype" value="note">

    <div class="form_field">
        <label for="note_subject" class="block_level">' . TITLE . '</label>
        <input id="note_subject" type="text" name="note_subject" value="' . htmlspecialchars(($entry['subject'] ?? '')) . '">
    </div>

    <div class="form_multiselect">
        <label for="note_target" class="block_level">' . USERCONF_GROUPS . '</label>';

                $valid_groups = serendipity_getAllGroups($serendipity['authorid']);
                if (isset($_REQUEST['note_target'])) {
                    $selected = $_REQUEST['note_target'];
                } elseif ($mode == 'update') {
                    $sql = serendipity_db_query("SELECT * FROM {$serendipity['dbPrefix']}adminnotes_to_groups");
                    $selected = array();
                    foreach($sql AS $row) {
                        $selected[] = $row['groupid'];
                    }
                } else {
                    $selected = array();
                }

                echo '
        <select id="note_target" name="note_target[]" multiple="multiple" size="5">'."\n";
                foreach($valid_groups AS $group) {
                    # PRESELECT!
                    if (in_array($group['confkey'], (array)$selected) || count($selected) == 0) {
                        $is_selected = ' selected="selected"';
                    } else {
                        $is_selected = '';
                    }
                    echo '            <option' . $is_selected . ' value="' . $group['confkey'] . '">' . htmlspecialchars($group['confvalue']) . "</option>\n";
                }
                echo '        </select>
    </div>

    <div class="form_area">
        <label for="quicknote" class="block_level">' . ENTRY_BODY . '</label>
        <textarea id="quicknote" rows=10 cols=80 name="note_body">' . htmlspecialchars(($entry['body'] ?? '')) . "</textarea>\n";// no break or indents !! (inside default textarea tags)
        if (($allow_html === 'admin' && $serendipity['serendipityUserlevel'] >= USERLEVEL_ADMIN) && isset($serendipity['wysiwyg']) && $serendipity['wysiwyg']) {
            include_once $serendipity['serendipityPath'] . 'include/functions_entries_admin.inc.php';
            serendipity_emit_htmlarea_code('quicknote','');
        }
        echo "\n";
// REMEMBER: This is a none hooked display, so i.e. emoticonchooser will not happen in PLAIN TEXT displays !
?>

    </div>
    <div class="form_buttons"><input type="submit" name="submit" value="<?= SAVE ?>"></div>
</form>
<?php
                break;

            case 'delete':
                $newLoc = '?' . serendipity_setFormToken('url') . '&amp;serendipity[adminModule]=event_display&amp;serendipity[adminAction]=adminnotes&amp;action=isdelete&amp;note=' . (int)$_REQUEST['note'];

                $entry = $this->getMyNotes((int)$_REQUEST['note']);

                echo '<span class="msg_hint"><span class="icon-help-circled" aria-hidden="true"></span> ';
                printf(DELETE_SURE, $entry['noteid'] . ' - ' . htmlspecialchars($entry['subject']));
                echo "</span>\n";

?>
                    <div class="form_buttons">
                        <a class="button_link state_submit" href="<?php echo $newLoc; ?>"><?php echo DUMP_IT; ?></a>
                        <a class="button_link state_cancel" href="<?php echo htmlspecialchars($_SERVER["HTTP_REFERER"]); ?>"><?php echo NOT_REALLY; ?></a>
                    </div>
<?php
                break;

            case 'isdelete':
                if (!serendipity_checkFormToken()) {
                    break;
                }

                $entry = $this->getMyNotes((int)$_REQUEST['note']);
                if (isset($entry['noteid'])) {
                    serendipity_db_query("DELETE FROM {$serendipity['dbPrefix']}adminnotes           WHERE noteid = " . (int)$_REQUEST['note']);
                    serendipity_db_query("DELETE FROM {$serendipity['dbPrefix']}adminnotes_to_groups WHERE noteid = " . (int)$_REQUEST['note']);
                }
                echo '<span class="msg_success"><span class="icon-ok-circled" aria-hidden="true"></span> ';
                printf(RIP_ENTRY, $entry['noteid'] . ' - ' . htmlspecialchars($entry['subject']));
                echo "</span>\n";
                break;

            default:
                $notes = $this->getMyNotes(false);
                echo '
<ol class="note_list plainList">'."\n";
                if (is_array($notes)) {
                    foreach($notes AS $note) {
                        echo '
    <li>
        <h3>' . $note['subject'] . '</h3>
        <p>' . POSTED_BY . ' ' . $note['realname'] . ' ' . ON . ' ' . serendipity_strftime(DATE_FORMAT_SHORT, (int) $note['notetime']) . '</p>
        <div class="form_buttons">
            <a class="button_link state_submit" href="?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=adminnotes&amp;action=edit&amp;note=' . $note['noteid'] . '">' . EDIT . '</a>
            <a class="button_link state_cancel" href="?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=adminnotes&amp;action=delete&amp;note=' . $note['noteid'] . '">' . DELETE . '</a>
        </div>
    </li>
';
                    }
                }
                echo '
</ol>

<div class="form_buttons">
    <a class="button_link" href="?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=adminnotes&amp;action=new">' . NEW_ENTRY . '</a>
</div>
';
                break;
        }
    }

    function output($string)
    {
        global $serendipity;
        static $allow_html = null;
        static $do_markup  = null;

        if ($allow_html == null) {
            $allow_html = $this->get_config('html');
            if ($allow_html === 'admin') {
                if ($serendipity['serendipityUserlevel'] >= USERLEVEL_ADMIN) {
                    $allow_html = true;
                } else {
                    $allow_html = false;
                }
            } else {
                $allow_html = serendipity_db_bool($allow_html);
            }
            $do_markup  = serendipity_db_bool($this->get_config('markup', 'true'));
        }

        if ($allow_html) {
            $body = $string;
        } else {
            $body = htmlspecialchars($string);
        }

        if ($do_markup) {
            $entry = array('html_nugget' => $body);
            serendipity_plugin_api::hook_event('frontend_display', $entry, array('from' => 'serendipity_event_adminnotes:output'));
            $body  = $entry['html_nugget'];
        }

        return $body;
    }

    function event_hook($event, &$bag, &$eventData, $addData = null)
    {
        global $serendipity;

        $hooks = &$bag->get('event_hooks');

        if (isset($hooks[$event])) {

            switch($event) {
                case 'backend_sidebar_entries':
                    if ($serendipity['serendipityUserlevel'] < USERLEVEL_CHIEF) {
                        break;
                    }
                    echo '                        <li class="list-flex"><div class="flex-column-1"><a href="?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=adminnotes">' . PLUGIN_ADMINNOTES_TITLE . "</a></div></li>\n";
                    break;

                case 'backend_sidebar_entries_event_display_adminnotes':
                    $this->shownotes();
                    break;

                case 'js_backend':
?>

/* serendipity_event_adminnotes (quicknotes) start */

function fulltext_toggle(id) {
    if ( document.getElementById(id + '_full').style.display == '' ) {
        document.getElementById(id + '_full').style.display='none';
        document.getElementById(id + '_summary').style.display='';
        document.getElementById(id + '_text').innerHTML = '<?php echo TOGGLE_OPTION ?>';
    } else {
        document.getElementById(id + '_full').style.display='';
        document.getElementById(id + '_summary').style.display='none';
        document.getElementById(id + '_text').innerHTML = '<?php echo HIDE ?>';
    }
    return false;
}

/* serendipity_event_adminnotes (quicknotes) end */

<?php
                    break;

                case 'backend_dashboard':
                    $cutoff = (int) $this->get_config('cutoff');
                    $notes  = $this->getMyNotes();
                    if (is_array($notes)) {
?>

    <section id="dashboard_quicknotes" class="equal_heights quick_list dashboard_widget">
        <h3><?php echo PLUGIN_ADMINNOTES_TITLE ?></h3>
        <ol class="plainList">
<?php
            foreach($notes AS $id => $note) {
?>
            <li class="serendipity_note note_<?php echo $this->output($note['notetype']) ?> note_owner_<?php echo $note['authorid'] . (isset($serendipity['COOKIE']['lastnote']) && $serendipity['COOKIE']['lastnote'] < $note['noteid'] ? ' note_new' : ''); ?>">
                <div class="note_subject">
                    <h3><?php echo $this->output($note['subject']) ?></h3>
                    <?php echo POSTED_BY . ' ' . htmlspecialchars($note['realname']) . ' ' . ON . ' ' . serendipity_strftime(DATE_FORMAT_SHORT, (int) $note['notetime'])."\n"; ?>
                </div>
<?php
                    if (strlen(strip_tags($note['body'])) > $cutoff) {
                        $output = $this->output($note['body']);
?>
                <div id="<?php echo $id ?>_full" style="display: none" class="note_body">
                    <?php echo $output . "\n"; ?>
                </div>
                <div id="<?php echo $id ?>_summary" class="note_body">
                    <?php echo mb_substr(strip_tags($output), 0, $cutoff) . "&hellip;\n"; ?>
                </div>
                <div class="note_summarylink">
                    <button class="button_link toggle_comment_full" type="button" onclick="fulltext_toggle(<?php echo $id ?>); return false;" data-href="#qn<?php echo $id ?>_full" title="<?php echo TOGGLE_OPTION ?>"><span class="icon-right-dir" aria-hidden="true"></span><span id="<?php echo $id ?>_text" class="visuallyhidden"> <?php echo TOGGLE_OPTION ?></span></button>
                </div>
<?php
                    } else {
?>
                <div class="note_body">
                    <?php echo $this->output($note['body']) . "\n"; ?>
                </div>
<?php
                    }
?>
            </li>
<?php
            }
?>
        </ol>
    </section>

<?php

                        serendipity_JSsetCookie('lastnote', $notes[0]['noteid']);
                    }
                    break;

                case 'css_backend':
                    // CSS class does NOT exist by user customized template styles, include default
                    if (strpos($eventData, '.note_') === false) {
                        $eventData .= '

/* plugin adminnotes start */

.note_subject { margin: 0px 0px 1em; }
.note_subject h3 { line-height: 1.6; margin: 0; }
.note_new { border: 2px solid rgb(0, 255, 0); margin: -0.2em; padding: 0.2em; }

/* plugin adminnotes end */

';
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