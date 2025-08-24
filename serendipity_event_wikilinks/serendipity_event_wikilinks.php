<?php

// TODO:
// Show existing references for insertion in 'Extended options' panel for 'edit entry' screen
// Test (with) Smarty output
// Some documentation WHY HOW WHERE

declare(strict_types=1);

if (IN_serendipity !== true) {
    die ("Don't hack!");
}

@serendipity_plugin_api::load_language(dirname(__FILE__));

class serendipity_event_wikilinks extends serendipity_event
{
    public $title = PLUGIN_EVENT_WIKILINKS_NAME;

    private $references = array();
    private $out_references = array();
    private $refcount = array();
    private $ref_entry = 0;

    function introspect(&$propbag)
    {
        $propbag->add('name',          PLUGIN_EVENT_WIKILINKS_NAME);
        $propbag->add('description',   PLUGIN_EVENT_WIKILINKS_DESC);
        $propbag->add('stackable',     false);
        $propbag->add('author',        'Garvin Hicking, Grischa Brockhaus, Ian Styx');
        $propbag->add('version',       '2.1.1');
        $propbag->add('requirements',  array(
            'serendipity' => '5.0',
            'smarty'      => '4.1',
            'php'         => '8.2'
        ));
        $propbag->add('groups', array('MARKUP'));
        $propbag->add('event_hooks',   array(
            'frontend_display' => true,
            'backend_entry_toolbar_extended' => true,
            'backend_entry_toolbar_body' => true,
            'backend_wysiwyg' => true,
            'external_plugin' => true,
            'backend_publish' => true,
            'backend_save' => true,
            'backend_sidebar_entries_event_display_wikireferences' => true,
            'backend_sidebar_entries' => true,
        ));

        $this->markup_elements = array(
            array(
              'name'     => 'ENTRY_BODY',
              'element'  => 'body',
            ),
            array(
              'name'     => 'EXTENDED_BODY',
              'element'  => 'extended',
            ),
            array(
              'name'     => 'COMMENT',
              'element'  => 'comment',
            ),
            array(
              'name'     => 'HTML_NUGGET',
              'element'  => 'html_nugget',
            )
        );

        $conf_array = array();
        foreach($this->markup_elements as $element) {
            $conf_array[] = $element['name'];
        }
        $conf_array[] = 'imgpath';
        $conf_array[] = 'generate_draft_links';
        $conf_array[] = 'generate_future_links';
        $conf_array[] = 'reference_match';
        $conf_array[] = 'reference_info';
        $conf_array[] = 'target_match';
        $conf_array[] = 'target_match2';
        $propbag->add('configuration', $conf_array);
    }

    function generate_content(&$title)
    {
        $title = $this->title;
    }

    function introspect_config_item($name, &$propbag)
    {
        global $serendipity;

        switch($name) {
            case 'imgpath':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_EVENT_WIKILINKS_IMGPATH);
                $propbag->add('description', PLUGIN_EVENT_WIKILINKS_IMGPATH_DESC);
                $propbag->add('default',     $serendipity['serendipityHTTPPath'] . 'plugins/serendipity_event_wikilinks/');
                break;

            case 'generate_draft_links':
                $propbag->add('name',        PLUGIN_EVENT_WIKILINKS_SHOWDRAFTLINKS_NAME);
                $propbag->add('description', PLUGIN_EVENT_WIKILINKS_SHOWDRAFTLINKS_DESC);
                $propbag->add('type',        'boolean');
                $propbag->add('default', 'true');
                break;

            case 'generate_future_links':
                $propbag->add('name',        PLUGIN_EVENT_WIKILINKS_SHOWFUTURELINKS_NAME);
                $propbag->add('description', PLUGIN_EVENT_WIKILINKS_SHOWFUTURELINKS_DESK);
                $propbag->add('type',        'boolean');
                $propbag->add('default', 'true');
                break;

            case 'reference_match':
                $propbag->add('name',        PLUGIN_EVENT_WIKILINKS_REFMATCH_NAME);
                $propbag->add('description', PLUGIN_EVENT_WIKILINKS_REFMATCH_DESC);
                $propbag->add('type',        'string');
                $propbag->add('default', '<ref(?:\s*name=["\'](?P<refname>.+)["\'])?>(?P<ref>.*)</ref>');
                break;

            case 'target_match':
                $propbag->add('name',        PLUGIN_EVENT_WIKILINKS_REFMATCHTARGET_NAME);
                $propbag->add('description', PLUGIN_EVENT_WIKILINKS_REFMATCHTARGET_DESC);
                $propbag->add('type',        'string');
                $propbag->add('default', '<sup class="wikiref"><a href="#reference{count}" title="{text}">{count}</a></sup>');
                break;

            case 'target_match2':
                $propbag->add('name',        PLUGIN_EVENT_WIKILINKS_REFMATCHTARGET2_NAME);
                $propbag->add('description', PLUGIN_EVENT_WIKILINKS_REFMATCHTARGET2_DESC);
                $propbag->add('type',        'string');
                $propbag->add('default', '<li id="reference{count}" title="{refname}">{text}</li>');
                break;

            case 'reference_info':
                $propbag->add('name',        PLUGIN_EVENT_WIKILINKS_REFMATCHTARGET2_NAME);
                $propbag->add('description', PLUGIN_EVENT_WIKILINKS_REFMATCHTARGET2_DESC);
                $propbag->add('type',        'content');
                $propbag->add('default', '<span class="msg_hint">' . PLUGIN_EVENT_WIKILINKS_REFDOC . '</span>');
                break;

            case 'db_built':
                return false;

            default:
                $propbag->add('type',        'boolean');
                $propbag->add('name',        @constant($name));
                $propbag->add('description', sprintf(APPLY_MARKUP_TO, constant($name)));
                $propbag->add('default', 'true');
        }
        return true;
    }

    /**
     * Creates the template for either the popup page OR the magnific/popup window
     */
    function show($area = '', $name = '')
    {
        global $serendipity;

        if (IN_serendipity !== true) {
            die ("Don't hack!");
        }

        #if (!isset($serendipity['smarty']) || !is_object($serendipity['smarty'])) {
        #    serendipity_smarty_init();
        #}
?>
<!DOCTYPE html>
<html<?php echo (isset($serendipity['dark_mode']) && $serendipity['dark_mode'] === true) ? ' data-color-mode="dark"' : ' data-color-mode="light"';?> class="no-js page_wlelist" dir="ltr" lang="<?=$serendipity['lang']?>">
    <head>
        <title><?php echo PLUGIN_EVENT_WIKILINKS_LINKENTRY; ?></title>
        <meta http-equiv="Content-Type" content="text/html; charset=<?php echo LANG_CHARSET; ?>">
        <link rel="stylesheet" type="text/css" href="<?=serendipity_rewriteURL('serendipity_admin.css')?>">
<?php if ($serendipity['dark_mode']) { ?>
        <link rel="stylesheet" href="<?=serendipity_rewriteURL('templates/styx/admin/styx_dark.min.css')?>" type="text/css">
<?php } else {
    if (!isset($serendipity['forceLightMode'])) { ?>
        <script>
          if ((window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) || localStorage.getItem('data-login-color-mode') === 'dark') {
            document.currentScript.insertAdjacentHTML('beforebegin', '<link rel="stylesheet" href="<?=serendipity_rewriteURL('templates/styx/admin/styx_dark.min.css')?>" type="text/css">');
          }
        </script>
<?php } } ?>
        <script>
            function linkchooser(instance_name = '', this_instance = '') {
                const capturingRegex = /(?<area>nugget|quick)/; //all nuggets(\d+) and plugin adminnotes quicknote // NO QUOTES !!!!
                const found = instance_name.match(capturingRegex);
                const instance = (found !== null) ? instance_name : this_instance;
                const use_wikilink = 'use_wikilink_'+instance_name;

                // works on both: enableBackendPopup or MFP- layer
                window[use_wikilink] = function (item) {
                    item = item.replace(/'/g, '"'); //convert single to double quote
                    try {
                        window.parent.parent.serendipity.serendipity_imageSelector_addToBody(item, instance);
                        window.parent.parent.$.magnificPopup.close();
                    }
                    catch (e) {
                        self.opener.serendipity.serendipity_imageSelector_addToBody(item, instance);
                        self.close();
                    }
                }
            }
        </script>
    </head>

    <body id="serendipity_admin_page">
        <div id="serendipityAdminFrame">
            <header id="top">
                <div id="banner" class="clearfix">
<?php if (isset($serendipity['enableBackendPopup']) && $serendipity['enableBackendPopup'] === true): ?>
                    <h1><?php echo SERENDIPITY_ADMIN_SUITE; ?></h1>
<?php endif; ?>
                    <h2><?php echo PLUGIN_EVENT_WIKILINKS_LINKENTRY_DESC; ?></h2>
                </div>
            </header>

            <script>
                document.onreadystatechange = function () {
                    if (document.readyState == 'interactive') {
                        linkchooser('<?=$name;?>', '<?=$area;?>');
                    }
                }
            </script>

            <main id="workspace" class="clearfix">
                <ul>
<?php
    $sql = "SELECT *
              FROM {$serendipity['dbPrefix']}entries
          ORDER BY timestamp DESC";
    $e = serendipity_db_query($sql);
    if (is_array($e)) {
        foreach($e AS $entry) {
            $entry['qtitle'] = str_replace("'", "&#39;", $entry['title']); // fetch possible single quote in title to not break the link compilation
            $link = serendipity_archiveURL($entry['id'], $entry['title'], 'serendipityHTTPPath', true, array('timestamp' => $entry['timestamp']));
            $jslink = "'<a href=\'$link\'>" . htmlspecialchars($entry['qtitle']) . "</a>'";
            echo '<li style="margin-bottom: 10px">'
               . '<a href="javascript:use_wikilink_' . $name . '(' . $jslink . '); self.close();" title="' . htmlspecialchars($entry['title']) . '"><strong>' . htmlspecialchars($entry['title']) . '</strong></a> (<a href="' . $link . '" title="' . htmlspecialchars($entry['title']) . '">#' . $entry['id'] . '</a>)<br>'
               . POSTED_BY . ' ' . $entry['author'] . ' '
               . ON . ' ' . serendipity_formatTime(DATE_FORMAT_SHORT, (int) $entry['timestamp']) .
               ($entry['isdraft'] != 'false' ? ' (' . DRAFT . ')' : '') . '</a></li>' . "\n";
        }
    }
?>
                </ul>
            </main>

        </div>

    </body>
</html>
<?php
    }

    function generate_button($txtarea)
    {
        global $serendipity;

        if (!isset($txtarea)) {
           $txtarea = 'serendipity_textarea_body';
        }
        $link =  ($serendipity['rewrite'] == 'none' ? $serendipity['indexFile'] . '?/' : '') . 'plugin/wikilinks' . ($serendipity['rewrite'] != 'none' ? '?' : '&amp;') . 'txtarea=' . $txtarea;
// root indent & empty linespace for consistency, please !
?>
<input type="button" class="input_button" name="insWikiLinks" value="<?php echo PLUGIN_EVENT_WIKILINKS_NAME; ?>" onclick="serendipity.openPopup('<?php echo $link; ?>', 'wikilink', 'width=800,height=600,toolbar=no,scrollbars=1,scrollbars,resize=1,resizable=1');">

<?php
    }

    function event_hook($event, &$bag, &$eventData, $addData = null)
    {
        global $serendipity;

        $hooks = &$bag->get('event_hooks');

        if (isset($hooks[$event])) {
            switch($event) {

                case 'backend_publish':
                case 'backend_save':
                    // Purge, so that the data within the entry takes precedence over other changes
                    serendipity_db_query("DELETE FROM {$serendipity['dbPrefix']}wikireferences WHERE entryid = " . (int)$eventData['id']);
                    break;

                case 'backend_sidebar_entries':
                    $this->setupDB();
                    echo '                        <li class="list-flex"><div class="flex-column-1"><a href="?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=wikireferences">' . PLUGIN_EVENT_WIKILINKS_MAINT . '</a></div></li>';
                    break;

                case 'backend_sidebar_entries_event_display_wikireferences':
                    $entries = serendipity_db_query("SELECT id, refname FROM {$serendipity['dbPrefix']}wikireferences ORDER BY refname ASC");

                    echo '<p class="msg_notice">' . PLUGIN_EVENT_WIKILINKS_MAINT_DESC . '</p>';

                    echo '<form action="serendipity_admin.php" method="post" name="serendipityEntry">';
                    echo '    <input type="hidden" name="serendipity[adminModule]" value="event_display">';
                    echo '    <input type="hidden" name="serendipity[adminAction]" value="wikireferences">';
                    echo '    <select name="serendipity[wikireference]">';
                    echo '        <option value="">...</option>';
                    if (is_array($entries)) {
                      foreach($entries AS $idx => $row) {
                        echo '        <option value="' . $row['id'] . '"' . ($row['id'] == ($serendipity['POST']['wikireference'] ?? null) ? ' selected="selected"' : '') . '>' . $row['refname'] . '</option>' . "\n";
                      }
                    }
                    echo '    </select>';
                    echo '    <input type="submit" class="input_button state_submit" name="serendipity[typeSubmit]" style="margin-left: .5em;" value="' . GO . '">';
                    echo '    <entry style="display: block; margin: 1.5em auto">';

                    if (isset($serendipity['POST']['wikireference']) && $serendipity['POST']['wikireference'] > 0) {

                        if (isset($serendipity['POST']['saveSubmit'])) {
                            serendipity_db_update('wikireferences', array('id' => $serendipity['POST']['wikireference']), array('refname' => $serendipity['POST']['wikireference_refname'], 'ref' => $serendipity['POST']['wikireference_ref']));
                            echo '<span class="msg_success"><span class="icon-ok-circled"></span> ' . DONE .': '. sprintf(SETTINGS_SAVED_AT, serendipity_strftime('%H:%M:%S')) . '</span>';
                        }

                        $ref = serendipity_db_query("SELECT * FROM {$serendipity['dbPrefix']}wikireferences WHERE id = " . (int)$serendipity['POST']['wikireference'], true, 'assoc');
                        $entry = serendipity_fetchEntry('id', $ref['entryid']);

                        echo '    <div>';
                        echo '      <label>' . PLUGIN_EVENT_WIKILINKS_DB_REFNAME . '</label> ';
                        echo '      <input type="text" name="serendipity[wikireference_refname]" value="' . htmlspecialchars($ref['refname']) . '">';
                        echo '      <input type="submit" class="input_button state_submit" name="serendipity[saveSubmit]" style="margin-left: .5em;" value="' . SAVE . '">';
                        echo '    </div>';

                        echo '    <div style="display: inline-block; margin: .5em auto">';
                        echo '      <label>' . PLUGIN_EVENT_WIKILINKS_DB_REF . '</label>';
                        echo '      <textarea id="wikireference_ref" style="padding: .5em;" cols="80" rows="20" name="serendipity[wikireference_ref]">' . htmlspecialchars($ref['ref']) . '</textarea>';
                        echo '    </div>';

                        echo '    <div style="display: inline-block; margin: .5em auto">';
                        echo '      <label>' . PLUGIN_EVENT_WIKILINKS_DB_ENTRYDID . '</label>';
                        echo '      <a href="' . serendipity_archiveUrl($ref['entryid'], $entry['title']) . '">' . $entry['title'] . '</a>';
                        echo '    </div>';

                        echo '    <p><a class="serendipityPrettyButton" href="?serendipity[action]=admin&amp;serendipity[adminModule]=entries&amp;serendipity[adminAction]=edit&amp;serendipity[id]=' . $entry['id'] . '&amp;' . serendipity_setFormToken('url') . '"><span class="icon-edit" aria-hidden="true"></span> ' . EDIT_ENTRY . '</a></p>';
                    }
                    echo '</entry>';
                    echo "</form>\n";

                    break;

                case 'frontend_display':
                    if (isset($serendipity['GET']['adminModule']) && $serendipity['GET']['adminModule'] == 'comments') break; // avoid running in backend comment previews
                    $this->out_references = array();
                    foreach ($this->markup_elements AS $temp) {
                        if (serendipity_db_bool($this->get_config($temp['name'], 'true')) && !empty($eventData[$temp['element']])
                        &&  (!isset($eventData['properties']['ep_disable_markup_' . $this->instance]) || !$eventData['properties']['ep_disable_markup_' . $this->instance])
                        &&  !isset($serendipity['POST']['properties']['disable_markup_' . $this->instance])) {
                            $element = $temp['element'];

                            $is_body = false;
                            if ($element == 'body' || $element == 'extended') {
                                $source =& $this->getFieldReference($element, $eventData);
                                $is_body = true;
                            } else {
                                $source =& $eventData[$element];
                            }

                            $this->references = $this->refcount = array();
                            $this->ref_entry = $eventData['id'];
                            $source = preg_replace_callback(
                                '^' . $this->get_config('reference_match') . '^imsU',
                                array($this, '_reference'),
                                $source
                            );

                            $source = preg_replace_callback(
                                "#(\[\[|\(\(|\{\{)(.+)(\]\]|\)\)|\}\})#isUm",
                                array($this, '_wikify'),
                                $source
                            );

                            $source .= $this->reference_parse();
                            if ($is_body) {
                                if (!isset($eventData['properties']['references']) || !is_array($eventData['properties']['references'])) {
                                    $eventData['properties']['references'] = [];
                                }
                                $eventData['properties']['references'] += $this->references;
                            }

                            // To workaround the doubled ref tag when ref tag contains a link added with TinyMCE code cleanup tasker we use the markdown approach [title](url) for the link
                            if ($element != 'comment' && str_contains($source, '<sup class="wikiref">')) {
                                $source = preg_replace('/\[(.*?)\]\s*\((.*?)\)/', '<a href="$2">$1</a>', $source);
                            }
                        }
                    }
                    break;

                 case 'backend_entry_toolbar_extended':
                    if (isset($eventData['backend_entry_toolbar_extended:textarea'])) {
                        $txtarea = $eventData['backend_entry_toolbar_extended:nugget'];
                    } else {
                        $txtarea = 'serendipity_textarea_extended';
                    }
                    if (!$serendipity['wysiwyg']) {
                        $this->generate_button($txtarea);
                        return true;
                    } else {
                        return false;
                    }
                    break;

                case 'backend_entry_toolbar_body':
                    if (isset($eventData['backend_entry_toolbar_body:textarea'])) {
                        $txtarea = $eventData['backend_entry_toolbar_body:nugget'];
                    } else {
                        $txtarea = 'serendipity_textarea_body';
                    }
                    if (!$serendipity['wysiwyg']) {
                        $this->generate_button($txtarea);
                        return true;
                    } else {
                        return false;
                    }
                    break;

                case 'backend_wysiwyg':
                    #$eventData['additional_styles'][] = '.tox .tox-tbtn svg.bi.bi-list-task { fill: deepskyblue; }';
                    $link = $serendipity['serendipityHTTPPath'] . ($serendipity['rewrite'] == 'none' ? $serendipity['indexFile'] . '?/' : '') . 'plugin/wikilinks' . ($serendipity['rewrite'] != 'none' ? '?' : '&amp;') . 'txtarea='.$eventData['item'];
                    $open = 'serendipity.openPopup';
                    $eventData['buttons'][] = array(
                        'id'         => 'wikilinks' . $eventData['item'],
                        'name'       => PLUGIN_EVENT_WIKILINKS_NAME,
                        'javascript' => 'function() { '.$open.'(\'' . $link . '\', \'WikiLinks\', \'width=800,height=600,toolbar=no,scrollbars=1,scrollbars,resize=1,resizable=1\') }',
                        'svg'        => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-list-task" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M2 2.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5V3a.5.5 0 0 0-.5-.5zM3 3H2v1h1z"/><path d="M5 3.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5M5.5 7a.5.5 0 0 0 0 1h9a.5.5 0 0 0 0-1zm0 4a.5.5 0 0 0 0 1h9a.5.5 0 0 0 0-1z"/><path fill-rule="evenodd" d="M1.5 7a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5H2a.5.5 0 0 1-.5-.5zM2 7h1v1H2zm0 3.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5zm1 .5H2v1h1z"/></svg>',
// no need when we have css_backend hook. Else use this
                        'css'        => '.tox .tox-tbtn svg.bi.bi-list-task { fill: #1d8a8a; }[data-color-mode="dark"] .tox .tox-tbtn svg.bi.bi-list-task { fill: #25f8f8; }',
                        'toolbar'    => 'other'
                    );
                    break;

               case 'external_plugin':
                    if ($_SESSION['serendipityAuthedUser'] !== true)  {
                        return true;
                    }

                    $uri_parts = explode('?', str_replace('&amp;', '&', $eventData));
                    $parts     = explode('&', $uri_parts[0]);

                    $uri_part = $parts[0];
                    $parts = array_pop($parts);

                    if (is_array($parts) && count($parts) > 1) {
                       foreach($parts AS $key => $value) {
                            $val = explode('=', $value);
                            $_GET[$val[0]] = $val[1];
                       }
                    } else {
                       $val = explode('=', $parts[0]);
                       if (isset($val[1])) $_GET[$val[0]] = $val[1];
                    }

                    if (!isset($_GET['txtarea'])) {
                        if (isset($uri_parts[1])) {
                            $parts = explode('&', $uri_parts[1]);
                            if (is_array($parts) && count($parts) > 1) {
                                foreach($parts AS $key => $value) {
                                     $val = explode('=', $value);
                                     $_GET[$val[0]] = $val[1];
                                }
                            } else {
                                $val = explode('=', $parts[0]);
                                $_GET[$val[0]] = $val[1];
                            }
                        }
                    }

                    if (empty($_GET['txtarea'])) {
                        return false;
                    }

                    switch($uri_part) {
                        case 'wikilinks':
                            $this->show(htmlspecialchars($_GET['txtarea']), str_replace('serendipity_textarea_', '', htmlspecialchars($_GET['txtarea'])));
                            break;
                    }
                    break;

                default:
                    return false;
            }

        } else {
            return false;
        }
    }

    function install()
    {
        $this->setupDB();
    }

    function setupDB()
    {
        global $serendipity;

        $built = $this->get_config('db_built', null);
        if (empty($built)) {
            serendipity_db_schema_import("CREATE TABLE {$serendipity['dbPrefix']}wikireferences (
                    id {AUTOINCREMENT} {PRIMARY},
                    entryid int(11) default '0',
                    refname text,
                    ref text)");

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
                        $q = "CREATE INDEX wikiref_refname ON {$serendipity['dbPrefix']}wikireferences (refname);";
                    } elseif (version_compare($db_version_match[0], '10.3.0', '>=')) {
                        $q = "CREATE INDEX wikiref_refname ON {$serendipity['dbPrefix']}wikireferences (refname(250));"; // max key 1000 bytes
                    } else {
                        $q = "CREATE INDEX wikiref_refname ON {$serendipity['dbPrefix']}wikireferences (refname(191));"; // 191 - old MyISAMs
                    }
                } else {
                    // Oracle MySQL - https://dev.mysql.com/doc/refman/5.7/en/innodb-limits.html
                    if (version_compare($db_version_match[0], '5.7.7', '>=')) {
                        $q = "CREATE INDEX wikiref_refname ON {$serendipity['dbPrefix']}wikireferences (refname);"; // Oracle Mysql/InnoDB max key up to 3072 bytes
                    } else {
                        $q = "CREATE INDEX wikiref_refname ON {$serendipity['dbPrefix']}wikireferences (refname(191));"; // Oracle Mysql/InnoDB max key 767 bytes
                    }
                }
                serendipity_db_schema_import($q);
                if (stristr(strtolower($serendipity['db_server_info']), 'mariadb')) {
                    if (version_compare($db_version_match[0], '10.5.0', '>=')) {
                        $q = "CREATE INDEX wikiref_comb ON {$serendipity['dbPrefix']}wikireferences (entryid,refname);";
                    } elseif (version_compare($db_version_match[0], '10.3.0', '>=')) {
                        $q = "CREATE INDEX wikiref_comb ON {$serendipity['dbPrefix']}wikireferences (entryid,refname(245));"; // max key 1000 bytes (assume 5 for entryid)
                    } else {
                        $q = "CREATE INDEX wikiref_comb ON {$serendipity['dbPrefix']}wikireferences (entryid,refname(191));"; // 191 - old MyISAMs
                    }
                } else {
                    // Oracle MySQL - https://dev.mysql.com/doc/refman/5.7/en/innodb-limits.html
                    if (version_compare($db_version_match[0], '5.7.7', '>=')) {
                        $q = "CREATE INDEX wikiref_comb ON {$serendipity['dbPrefix']}wikireferences (entryid,refname);"; // Oracle Mysql/InnoDB max key up to 3072 bytes
                    } else {
                        $q = "CREATE INDEX wikiref_comb ON {$serendipity['dbPrefix']}wikireferences (entryid,refname(191));"; // Oracle Mysql/InnoDB max key 767 bytes
                    }
                }
                serendipity_db_schema_import($q);
            } else {
                serendipity_db_schema_import("CREATE INDEX wikiref_refname ON {$serendipity['dbPrefix']}wikireferences (refname);");
                serendipity_db_schema_import("CREATE INDEX wikiref_comb ON {$serendipity['dbPrefix']}wikireferences (entryid,refname);");
            }

            serendipity_db_schema_import("CREATE INDEX wikiref_entry ON {$serendipity['dbPrefix']}wikireferences (entryid);"); // all
            $this->set_config('db_built', 1);
        }
    }

    /**
     * Textreference to either compare to wikireferences DB or to newly insert
     */
    function _reference($buffer)
    {
        global $serendipity;
        static $count = 0;

        $count++;

        if (!empty($buffer['ref']) && !empty($buffer['refname']) && !empty($this->ref_entry)) {
            // New refname, needs to be stored in the database IF NOT CURRENTLY EXISTING
            $exists = serendipity_db_query("SELECT * FROM {$serendipity['dbPrefix']}wikireferences WHERE refname = '" . serendipity_db_escape_string($buffer['refname']) . "'", true, 'assoc');

            if (!empty($exists['entryid']) && $exists['entryid'] == $this->ref_entry) {
                #serendipity_db_update('wikireferences', array('entryid' => $this->ref_entry, 'refname' => $buffer['refname']), array('ref' => $buffer['ref']));
            } elseif (empty($exists['entryid'])) {
                serendipity_db_insert('wikireferences', array('entryid' => $this->ref_entry, 'refname' => $buffer['refname'], 'ref' => $buffer['ref']));
            }
        }

        if (empty($buffer['ref']) && !empty($buffer['refname'])) {
            // We found a referenced pattern like <ref name="XXX" /> in entry data, so let's fetch that from the database!
            $exists = serendipity_db_query("SELECT * FROM {$serendipity['dbPrefix']}wikireferences WHERE refname = '" . serendipity_db_escape_string($buffer['refname']) . "'", true, 'assoc');
            $buffer['ref'] = $exists['ref'] ?? null;
        }

        if (empty($buffer['refname'])) {
            $buffer['refname'] = (string)$count;
        }

        $refix = $count;
        if (isset($this->references[$buffer['refname']])) {
            if ($this->references[$buffer['refname']] == $buffer['ref']) {
                $refix = $this->refcount[$buffer['refname']];
            } else {
                $this->references[$buffer['refname'] . $count] = $buffer['ref'];
                $this->refcount[$buffer['refname'] . $count] = (string)$count;
            }
        } else {
            $this->references[$buffer['refname']] = $buffer['ref'];
            $this->refcount[$buffer['refname']] = (string)$count;
        }

        // Backend entry preview case
        #<p>Serendipity<ref name="Serendipity">[Serendipity Styx Weblog](https://ophian.github.io/) - also, Serendipity stands for several other interpretations like a movie, or a dancer in a movie, or a movie of a dancer in a movie.</ref> can be found in many places.</p>
        #<p>FooBar<ref name="foobar">[FooBar wording](https://google.com/search?q=foobar) - The terms foobar foo, bar, baz, qux, quux, and others are used as metasyntactic variables and placeholder names in computer programming or computer-related ..., also FooBar stands for several other interpretations like an advanced freeware audio player for the Windows platform, or for "fucked up beyond all recognition", etc.</ref> can be found in many places.</p>
        //to workaround the doubled ref tag when ref tag contains a link with TinyMCE code cleanup tasker we use the markdown approach []() for the link
        if (!empty($buffer['ref'])) {
            $buffer['ref'] = preg_replace('/\[(.*?)\]\s*\((.*?)\)/', '<a href="$2">$1</a>', $buffer['ref']);
        }

        $result = $this->get_config('target_match');
        $result = str_replace(
            array(
                '{count}',
                '{text}',
                '{refname}'
            ),
            array(
                $refix,
                htmlspecialchars(strip_tags($buffer['ref'] ?? '')),// strips link out of title attribute
                htmlspecialchars($buffer['refname'] ?? ''),
            ),
            $result
        );

        return $result;
    }

    function reference_parse()
    {
        static $count = 0;
        static $count2 = 0;

        $count++;

        $format = $this->get_config('target_match2');

        if ($format == '-') return;
        if (count($this->references) == 0) return;

        $block = "\n\n" . '<ol class="serendipity_referencelist" id="serendipity_referencelist' . $count . '">' . "\n";

        foreach($this->references AS $key => $buffer) {
            $count2++;
            $result = str_replace(
                array(
                    '{count}',
                    '{text}',
                    '{refname}'
                ),

                array(
                    $count2,
                    $buffer,/* htmlspecialchars($buffer), NOT: since then link markup will not display properly */
                    $key
                ),
                $format
            );

            $block .= $result . "\n";
        }

        $block .= '</ol>' . "\n";

        return $block;
    }

    /**
     * Wikifies:
     * [[ENTRY|DESC]] is an internal link
     * ((ENTRY|DESC)) is a staticpage link.
     */
    function _wikify($buffer)
    {
        global $serendipity;
        #$debug = true;

        $admin_url = false;

        $cidx = 2; // 1 & 3 are [[ & ]]

        if ($buffer[1] == '((') {
            $type = $otype = 'staticpage';
        } elseif ($buffer[1] == '{{') {
            $type = $otype = 'mixed';
        } else {
            $type = $otype = 'internal';
        }

        $parts = explode('|', $buffer[$cidx]);

        if (isset($parts[1])) {
            $desc   = $parts[1];
            $ltitle = $parts[0];
        } else {
            $desc = $ltitle = $buffer[$cidx];
        }
        // ltitle might contain entities, convert them:
        $ltitle = @html_entity_decode($ltitle);

        $sql = '';
        if ($type == 'staticpage') {
            $entry = serendipity_db_query("SELECT id, permalink FROM {$serendipity['dbPrefix']}staticpages WHERE headline = '" . serendipity_db_escape_string($ltitle) . "'" . " ORDER BY timestamp DESC LIMIT 1", true, 'assoc');
        } elseif ($type == 'mixed') {
            $entry = serendipity_db_query("SELECT * FROM {$serendipity['dbPrefix']}entries WHERE title = '" . serendipity_db_escape_string($ltitle) . "'" . " ORDER BY timestamp DESC LIMIT 1", true, 'assoc');
            $type = 'internal';
            if (!is_array($entry)) {
                $entry = serendipity_db_query("SELECT id, permalink FROM {$serendipity['dbPrefix']}staticpages WHERE headline = '" . serendipity_db_escape_string($ltitle) . "'" . " ORDER BY timestamp DESC LIMIT 1", true, 'assoc');
                $type = 'staticpage';
            }
        } else {
            $entry = serendipity_db_query("SELECT * FROM {$serendipity['dbPrefix']}entries WHERE title = '" . serendipity_db_escape_string($ltitle) . "'" . " ORDER BY timestamp DESC LIMIT 1", true, 'assoc');
        }

        if (is_array($entry)) { // The entry exists.

            // check, whether we don't want draft or future links:
            //if (serendipity_db_bool($this->get_config('generate_draft_links', false)) ||  !$entry['isdraft']){
            if (serendipity_db_bool($this->get_config('generate_future_links', false)) ||  $entry['timestamp'] <= serendipity_db_time()){
                if ($type == 'staticpage') {
                    $entry_url = $entry['permalink'];
                } else {
                    $entry_url = serendipity_archiveURL($entry['id'], $entry['title'], 'serendipityHTTPPath', true, array('timestamp' => $entry['timestamp']));
                }
            }
            if (serendipity_userLoggedIn()) {
                $mode = 'edit';
                if ($type == 'staticpage') {
                    $admin_url   = $serendipity['baseURL'] .'serendipity_admin.php?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=staticpages&amp;serendipity[staticid]='. $entry['id'];
                    $admin_title = PLUGIN_EVENT_WIKILINKS_EDIT_STATICPAGE;
                } else {
                    $admin_url = $serendipity['baseURL'] .'serendipity_admin.php?serendipity[action]=admin&amp;serendipity[adminModule]=entries&amp;serendipity[adminAction]=edit&amp;serendipity[id]='. $entry['id'];
                    $admin_title = PLUGIN_EVENT_WIKILINKS_EDIT_INTERNAL;
                }
            }
        } else {
            // The entry does not yet exist.
            $entry_url = '';

            if (serendipity_userLoggedIn()) {
                $mode  = 'create';
                $title = urlencode($ltitle);
                $body  = '<h2>' . htmlspecialchars($ltitle) . '</h2>';

                $admin_url2 = $serendipity['baseURL'] . 'serendipity_admin.php?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=staticpages&amp;serendipity[pre][headline]=' . $title . '&amp;serendipity[pre][content]=' . urlencode($body) . '&amp;serendipity[pre][pagetitle]=' . $title;
                if ($otype == 'staticpage') {
                    $admin_url = $serendipity['baseURL'] . 'serendipity_admin.php?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=staticpages&amp;serendipity[staticpagecategory]=pages&amp;serendipity[pre][headline]=' . $title . '&amp;serendipity[pre][content]=' . urlencode($body) . '&amp;serendipity[pre][pagetitle]=' . $title;
                    $admin_title = PLUGIN_EVENT_WIKILINKS_CREATE_STATICPAGE;
                } elseif ($otype == 'mixed') {
                    $admin_url = $serendipity['baseURL'] . 'serendipity_admin.php?serendipity[adminModule]=entries&amp;serendipity[adminAction]=new&amp;serendipity[title]=' . $title . '&amp;serendipity[body]=' . urlencode($body);
                    $admin_title = PLUGIN_EVENT_WIKILINKS_CREATE_INTERNAL;
                } else {
                    $admin_url = $serendipity['baseURL'] . 'serendipity_admin.php?serendipity[adminModule]=entries&amp;serendipity[adminAction]=new&amp;serendipity[title]=' . $title . '&amp;serendipity[body]=' . urlencode($body);
                    $admin_title = PLUGIN_EVENT_WIKILINKS_CREATE_INTERNAL;
                }
            } else {
                $ltitle .= '?';
            }
        }

        $out = '<span class="serendipity_wikilink_' . $type . '">';
        if ($entry_url) {
            $out .= '<a class="serendipity_wikilink_visitor" href="' . $entry_url . '">';
        }
        $out .= $desc;
        if ($entry_url) {
            $out .= '</a>';
        }

        if ($admin_url) {
            if ($otype == 'mixed') {
                $imgurl = $this->get_config('imgpath') . $mode . '_internal.png';
                $img1   = '<img style="border: 0px" alt="?" src="' . $imgurl . '" width="16" height="16">';
                $out .= '<a title="' . $admin_title . '" class="serendipity_wikilink_editor_internal" href="' . $admin_url . '"> ' . $img1 . '</a>';
                if ($admin_url2) {
                    $imgurl = $this->get_config('imgpath') . $mode . '_staticpage.png';
                    $img2 = '<img style="border: 0px" alt="?" src="' . $imgurl . '" width="16" height="16">';
                    $out .= '<a title="' . PLUGIN_EVENT_WIKILINKS_CREATE_STATICPAGE . '" class="serendipity_wikilink_editor_staticpage" href="' . $admin_url2 . '"> ' . $img2 . '</a>';
                }
            } else {
                $imgurl = $this->get_config('imgpath') . $mode . '_' . $type . '.png';
                $img = '<img style="border: 0px" alt="?" src="' . $imgurl . '" width="16" height="16">';
                $out .= '<a title="' . $admin_title . '" class="serendipity_wikilink_editor_' . $type . '" href="' . $admin_url . '"> ' . $img . '</a>';
            }
        }
        $out .= '</span>';

        return $out;
    }

}

/* vim: set sts=4 ts=4 expandtab : */
?>