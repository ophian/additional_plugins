<?php

// TODO:
// - Order by index instead of RANDOM only

declare(strict_types=1);

if (IN_serendipity !== true) {
    die ("Don't hack!");
}

@serendipity_plugin_api::load_language(dirname(__FILE__));

class serendipity_event_includeentry extends serendipity_event
{
    public $title = PLUGIN_EVENT_INCLUDEENTRY_NAME;
    protected $config = array(
            'type',
            'title',
            'body',
            'extended',
            'template',
            'apply_markup',
        );
    private $staticblock = [];
    private $enabled_categories = null;
    private $statictemplate = null;

    function introspect(&$propbag)
    {
        global $serendipity;

        $propbag->add('name',          PLUGIN_EVENT_INCLUDEENTRY_NAME);
        $propbag->add('description',   PLUGIN_EVENT_INCLUDEENTRY_DESC);
        $propbag->add('stackable',     false);
        $propbag->add('author',        'Garvin Hicking, Ian Styx');
        $propbag->add('version',       '3.1.0');
        $propbag->add('scrambles_true_content', true);
        $propbag->add('requirements',  array(
            'serendipity' => '5.0',
            'smarty'      => '4.1',
            'php'         => '8.2'
        ));
        $propbag->add('page_configuration', $this->config);
        $propbag->add('event_hooks',   array(
            'frontend_display'                                   => true,
            'backend_sidebar_entries_event_display_staticblocks' => true,
            'backend_sidebar_entries'                            => true,
            'backend_entryform'                                  => true,
            'frontend_display:html:per_entry'                    => true,
            'backend_display'                                    => true,
            'backend_publish'                                    => true,
            'backend_save'                                       => true,
            'frontend_display_cache'                             => true
        ));
        $propbag->add('groups', array('MARKUP'));

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
        $conf_array[] = 'enabled_categories';
        $conf_array[] = 'randomize';
        $conf_array[] = 'first_show';
        $conf_array[] = 'show_skip';
        $conf_array[] = 'show_multi';

        foreach($this->markup_elements AS $element) {
            $conf_array[] = $element['name'];
        }
        $propbag->add('configuration', $conf_array);

        $ec = (array)explode(',', $this->get_config('enabled_categories', 'false'));
        $this->enabled_categories = array();

        foreach($ec AS $cid) {
            if ($cid === false || empty($cid)) {
                continue;
            }
            $this->enabled_categories[$cid] = true;
        }
    }

    function introspect_config_item($name, &$propbag)
    {
        switch($name) {

            case 'show_multi':
                $propbag->add('type',        'boolean');
                $propbag->add('name',        STATICBLOCK_SHOW_MULTI);
                $propbag->add('description', STATICBLOCK_SHOW_MULTI_DESC);
                $propbag->add('default',     'false');
                break;

            case 'randomize':
                $propbag->add('type',        'boolean');
                $propbag->add('name',        STATICBLOCK_RANDOMIZE);
                $propbag->add('description', STATICBLOCK_RANDOMIZE_DESC);
                $propbag->add('default',     'false');
                break;

            case 'first_show':
                $propbag->add('type',        'string');
                $propbag->add('name',        STATICBLOCK_FIRST_SHOW);
                $propbag->add('description', STATICBLOCK_FIRST_SHOW_DESC);
                $propbag->add('default',     '1');
                break;

            case 'show_skip':
                $propbag->add('type',        'string');
                $propbag->add('name',        STATICBLOCK_SHOW_SKIP);
                $propbag->add('description', STATICBLOCK_SHOW_SKIP_DESC);
                $propbag->add('default',     '1');
                break;

            case 'enabled_categories':
                $propbag->add('type',      'content');
                $propbag->add('default',   $this->getCategories());
                break;

            case 'ENTRY_BODY':
            case 'EXTENDED_BODY':
            case 'COMMENT':
            case 'HTML_NUGGET':
                $propbag->add('type',        'boolean');
                $propbag->add('name',        constant($name));
                $propbag->add('description', sprintf(APPLY_MARKUP_TO, constant($name)));
                $propbag->add('default',     'true');
                break;

            default:
                return false;
        }
        return true;
    }

    function introspect_item($name, &$propbag)
    {
        global $serendipity;

        switch($name) {
            case 'title':
                $propbag->add('type',          'string');
                $propbag->add('name',          TITLE);
                $propbag->add('description',   '');
                $propbag->add('default',       '');
                break;

            case 'body':
                $propbag->add('type',          'html');
                $propbag->add('name',          ENTRY_BODY);
                $propbag->add('description',   '');
                $propbag->add('default',       '');
                break;

            case 'extended':
                $propbag->add('type',          'html');
                $propbag->add('name',          EXTENDED_BODY);
                $propbag->add('description',   '');
                $propbag->add('default',       '');
                break;

            case 'template':
                $propbag->add('type',          'string');
                $propbag->add('name',          PLUGIN_EVENT_INCLUDEENTRY_FILENAME_NAME);
                $propbag->add('description',   PLUGIN_EVENT_INCLUDEENTRY_FILENAME_DESC);
                $propbag->add('default',       'plugin_staticblock.tpl');
                $propbag->add('only_type',     'block');
                break;

            case 'apply_markup':
                $propbag->add('type',          'boolean');
                $propbag->add('name',          sprintf(APPLY_MARKUP_TO, 'Block'));
                $propbag->add('description',   '');
                $propbag->add('default',       'true');
                $propbag->add('only_type',     'block');
                break;
        }

        return true;
    }

    function generate_content(&$title)
    {
        $title = $this->title;
    }

    function parse(&$element)
    {
        $element = preg_replace_callback(
            "@\[(s9y-include-entry|s9y-include-block):([0-9]+):?([^:]+)?\]@isUm",
            array($this, 'parseCallback'),
            $element
        );

        return true;
    }

    function set_config($name, $value, $implodekey = '^')
    {
        $fname = $this->instance . '/' . $name;

        if (is_array($value)) {
            $dbval = implode(',', $value);
        } else {
            $dbval = $value;
        }

        $_POST['serendipity']['plugin'][$name] = $dbval;

        return serendipity_set_config_var($fname, $dbval);
    }

    /* This is a per method workaround for correct introspect_config_item configuration element pair consistency (clearfix enables bottom padding) */
    function &getCategories()
    {
        global $serendipity;

        $html = '<div class="clearfix form_select">
                        <label for="staticblock_enabled_categories">' . CATEGORIES . '</label>';

        $all_valid = false;
        if (isset($serendipity['POST']['plugin']['enabled_categories']) && is_array($serendipity['POST']['plugin']['enabled_categories'])) {
            $valid = $this->enabled_categories = array();
            foreach ($serendipity['POST']['plugin']['enabled_categories'] AS $idx => $id) {
                $valid[$id] = true;
                $this->enabled_categories[$id] = true;
            }
        } else {
            $valid =& $this->enabled_categories;
            if (count($valid) == 0) {
                $all_valid = true;
            }
        }

        $html .= '
                        <select id="staticblock_enabled_categories" name="serendipity[plugin][enabled_categories][]" multiple="true" size="5">'."\n";
        $html .= '    <option value="-front-" ' . ($all_valid || isset($valid['-front-']) ? "selected='selected'" : '') . '>[' . NO_CATEGORY . ']</option>'."\n";
        if (is_array($cats = serendipity_fetchCategories())) {
            $cats = serendipity_walkRecursive($cats, 'categoryid', 'parentid', VIEWMODE_THREADED);
            foreach($cats AS $cat) {
                $html .= '    <option value="'. $cat['categoryid'] .'"'. ($all_valid || isset($valid[$cat['categoryid']]) ? ' selected="selected"' : '') .'>'. str_repeat(' ', $cat['depth']) . $cat['category_name'] .'</option>' . "\n";
            }
        }

        $html .= '                        </select>
                    </div>';

        return $html;
    }

    function parseCallback($buffer)
    {
        if (!isset($buffer[3]) || empty($buffer[3])) {
            $buffer[3] = 'body';
        }

        $id = (int) $buffer[2];

        switch($buffer[1]) {

            case 's9y-include-block':
                $this->fetchStaticBlock($id);

                if ($buffer[3] == 'template') {
                    $newbuf = $this->smartyParse($this->staticblock['template']);
                } else {
                    $newbuf = $this->staticblock[$buffer[3]];
                }
                break;

            default:
            case 's9y-include-entry':
                if (preg_match('/^prop[=:]/', $buffer[3])) {
                    $entry = serendipity_fetchEntryProperties($id);
                    $propname = preg_replace('/^prop[=:]/', '', $buffer[3]);
                    $newbuf = $entry[$propname];
                } else {
                    $entry = serendipity_fetchEntry('id', $id, fetchDrafts: 'something');
                    $newbuf = $entry[$buffer[3]];
                }
                break;

        }

        return $newbuf;
    }

    function install()
    {
        $this->check();
    }

    function check()
    {
        global $serendipity;

        $built = $this->get_config('db_built', null);
        if (empty($built)) {
            $q = "CREATE TABLE IF NOT EXISTS {$serendipity['dbPrefix']}staticblocks (
              id {AUTOINCREMENT} {PRIMARY},
              title varchar(255) not null default '',
              type varchar(255) not null default '',
              body text,
              extended text,
              template varchar(255) not null default '',
              apply_markup int(1) default '0',
              author varchar(20) default null,
              authorid int(11) default null,
              last_modified int(10) {UNSIGNED} default null,
              timestamp int(10) {UNSIGNED} default null) {UTF_8}";

            serendipity_db_schema_import($q);

            $this->set_config('db_built', '1');
        }
    }

    function showForm($type = 'template')
    {
        if (!isset($this->statictemplate['type'])) {
            $this->statictemplate['type'] = '';
        }
        if (!isset($this->statictemplate['title'])) {
            $this->statictemplate['title'] = '';
        }
        if (!isset($this->statictemplate['body'])) {
            $this->statictemplate['body'] = '';
        }
        if (!isset($this->statictemplate['extended'])) {
            $this->statictemplate['extended'] = '';
        }
        if (!isset($this->statictemplate['template'])) {
            $this->statictemplate['template'] = 'plugin_staticblock.tpl';
        }
        if (!isset($this->statictemplate['apply_markup'])) {
            $this->statictemplate['apply_markup'] = true;
        }

        if (!function_exists('serendipity_emit_htmlarea_code')) {
            include_once S9Y_INCLUDE_PATH . 'include/functions_entries_admin.inc.php';
        }
        include 'form.inc.php';
    }

    // This function checks the values of a staticblock entry, and maybe adjusts the right values to use.
    function checkBlock()
    {
        global $serendipity;

        if (empty($this->staticblock['template'])) {
            $this->staticblock['template'] = 'plugin_staticblock.tpl';
        }
        if (empty($this->staticblock['timestamp'])) {
            $this->staticblock['timestamp'] = time();
        }
        if (empty($this->staticblock['last_modified'])) {
            $this->staticblock['last_modified'] = time();
        }
        if (empty($this->staticblock['authorid'])) {
            $this->staticblock['authorid'] = $serendipity['authorid'];
        }
        if (empty($this->staticblock['author'])) {
            $this->staticblock['author'] = $serendipity['serendipityUser'];
        }
        if (empty($this->staticblock['type'])) {
            if (isset($serendipity['POST']['type'])) {
                $this->staticblock['type'] = $serendipity['POST']['type'];
            } else {
                $this->staticblock['type'] = 'template';
            }
        }
    }

    function fetchStaticBlock($id, $order = '')
    {
        global $serendipity;

        $q = "SELECT *
                FROM {$serendipity['dbPrefix']}staticblocks
               WHERE id = " . (int)$id . "
               LIMIT 1";
        $block = serendipity_db_query($q, true, 'assoc');
        if (is_array($block)) {
            $this->staticblock =& $block;
            $this->checkBlock();
        }
    }

    function updateStaticBlock()
    {
        global $serendipity;

        $this->checkBlock();
        if (empty($this->staticblock['apply_markup']) || false === $this->staticblock['apply_markup']) {
            $this->staticblock['apply_markup'] = '0';
        }
        if (!isset($this->staticblock['id'])) {
            $result = serendipity_db_insert('staticblocks', $this->staticblock);
            if (is_string($result)) {
                echo '<span class="msg_error"><span class="icon-attention-circled" aria-hidden="true"></span> ERROR: ' . $result . '</span>'."\n";
            }
            $serendipity["POST"]["staticblock"] = serendipity_db_insert_id("staticblocks", 'id');
        } else {
            $result = serendipity_db_update("staticblocks", array("id" => $this->staticblock["id"]), $this->staticblock);
            if (is_string($result)) {
                echo '<span class="msg_error"><span class="icon-attention-circled" aria-hidden="true"></span> ERROR: ' . $result . '</span>'."\n";
            }
        }
    }

    function &fetchStaticBlocks($type = 'template', $order = 'title DESC', $limit = 0)
    {
        global $serendipity;

        $limit_sql = '';
        if ($limit > 0) {
            $limit_sql .= 'LIMIT ' . (int)$limit;
        }

        $q = "SELECT * FROM {$serendipity['dbPrefix']}staticblocks
                      WHERE type = '" . $type . "'
                   ORDER BY $order
                   $limit_sql";
        if ($limit == 1) {
            $blocks = serendipity_db_query($q, true, 'assoc', 1);
        } else {
            $blocks = serendipity_db_query($q, false, 'assoc');
        }

        return $blocks;
    }

    function showBlockForm($type)
    {
        global $serendipity;
        static $form = null;

        if ($form === null) {
            $form = '
                    <form action="serendipity_admin.php" method="post">
                        <div>
                            <input type="hidden" name="serendipity[adminModule]" value="event_display">
                            <input type="hidden" name="serendipity[adminAction]" value="staticblocks">
                        </div>'."\n";
        }

        if ($type == 'form') {
            return $form;
        }

        $html = $form . '
                        <div>
                            <input type="hidden" name="serendipity[type]" value="' . $type . '">
                            <select id="staticblock_' . $type . '" name="serendipity[staticblock]">
                                <option value="__new">' . NEW_ENTRY . '</option>
                                <option value="__new">-----------------</option>'."\n";

        $html .= $this->getPages(($serendipity['POST']['staticblock'] ?? null), $type);
        $html .= '
                            </select>&nbsp;
                            <input class="input_button state_submit" type="submit" name="serendipity[staticSubmit]" value="' . GO . '">
                            <input  class="input_button state_cancel" type="submit" name="serendipity[staticDelete]" value="' . DELETE . '">'."\n";

        if ($type == 'template') {
            $html .= '<a onclick="this.href = this.href + document.getElementById(\'staticblock_template\').options[document.getElementById(\'staticblock_template\').selectedIndex].value" href="serendipity_admin.php?serendipity[adminModule]=entries&amp;serendipity[adminAction]=new&amp;serendipity[staticblock]=" class="button_link">' . STATICBLOCK_USE . "</a>\n";
        }

        $html .= '
                        </div>
                    </form>'."\n";

        return $html;
    }

    function &getPages($sel, $type = 'block')
    {
        $blocks = (array)$this->fetchStaticBlocks($type);
        $html = '';
        foreach ($blocks AS $block) {
            if (empty($block['id'])) {
                continue;
            }
            $html .= ' <option value="' . $block['id'] . '" ' . ($sel == $block['id'] ? 'selected="selected"' : '') . '>'."\n";
            $html .= htmlspecialchars($block['title'] ?? '') . '</option>'."\n";
        }

        return $html;
    }

    function &get_static($key, $default = null)
    {
        if (isset($this->staticblock[$key])) {
            return $this->staticblock[$key];
        } else {
            return $default;
        }
    }

    function &smartyParse($filename = '')
    {
        global $serendipity;

        if (empty($filename)) {
            $filename = $this->staticblock['template'];
            if (empty($filename)) $filename = $this->get_config('template', 'plugin_staticblock.tpl'); // case multi_block true, on fresh installs
        }

        $filename = basename($filename);

        $tfile = $serendipity['serendipityPath'] . $serendipity['templatePath'] . $serendipity['template'] . '/' . $filename;
        if (!file_exists($tfile)) {
            $tfile = dirname(__FILE__) . '/' . $filename;
        }

        if (serendipity_db_bool($this->staticblock['apply_markup'])) {
            serendipity_plugin_api::hook_event('frontend_display', $this->staticblock, array('from' => 'serendipity_event_includeentry:smartyParse'));
        }

        $serendipity['smarty']->assign('staticblock', $this->staticblock);

        $content = $serendipity['smarty']->fetch('file:'. $tfile);

        return $content;
    }

    function showBackend()
    {
        global $serendipity;

        if (isset($serendipity['POST']['staticblock']) && $serendipity['POST']['staticblock'] != '__new') {
            $this->fetchStaticBlock($serendipity['POST']['staticblock']);
        }

        echo '<h2>' . PLUGIN_EVENT_INCLUDEENTRY_BLOCKS . "</h2>\n";

        if (isset($serendipity['POST']['staticSave']) && $serendipity['POST']['staticSave'] == "true" && !empty($serendipity['POST']['SAVECONF'])) {
            $serendipity['POST']['staticSubmit'] = true;
            $bag  = new serendipity_property_bag;
            $this->introspect($bag);
            $name = htmlspecialchars($bag->get('name') ?? '');
            $desc = htmlspecialchars($bag->get('description') ?? '');
            $config_names = $bag->get('page_configuration');

            foreach($config_names AS $config_item) {
                $cbag = new serendipity_property_bag;
                if ($this->introspect_item($config_item, $cbag)) {
                    $this->staticblock[$config_item] = serendipity_get_bool($_POST['serendipity']['plugin'][$config_item] ?? null);
                }
            }

            echo '<span class="msg_success"><span class="icon-ok-circled" aria-hidden="true"></span> '. DONE . ': '. sprintf(SETTINGS_SAVED_AT, serendipity_strftime('%H:%M:%S')). "</span>\n";
            $this->updateStaticBlock();
        }

        if (!empty($serendipity['POST']['staticDelete']) && $serendipity['POST']['staticblock'] != '__new') {
            serendipity_db_query("DELETE FROM {$serendipity['dbPrefix']}staticblocks WHERE id = " . (int)$serendipity['POST']['staticblock']);
            echo '<span class="msg_success"><span class="icon-ok-circled" aria-hidden="true"></span> '. DONE .': '. sprintf(RIP_ENTRY, $this->staticblock['title']) . "</span>\n";
        }

        echo '
            <div class="form_select">
                <label for="staticblock_template">' . STATICBLOCK_SELECT_TEMPLATES . '</label>' .
                  $this->showBlockForm('template') . '
            </div>

            <div class="form_select">
                <label for="staticblock_block">' . STATICBLOCK_SELECT_BLOCKS . '</label>' .
                  $this->showBlockForm('block') . "
            </div>\n";

        /* SHOW SELECTION */
        echo $this->showBlockForm('form');

        if (isset($serendipity['POST']['staticSubmit']) && $serendipity['POST']['staticSubmit']) {
            echo '<h3>';
            if ($serendipity['POST']['type'] == 'template') {
                echo STATICBLOCK_EDIT_TEMPLATES;
            } else {
                echo STATICBLOCK_EDIT_BLOCKS;
            }
            echo "</h3>\n\n";

            echo "<div>\n";
            echo '    <input type="hidden" name="serendipity[staticSave]" value="true">'."\n";
            echo '    <input type="hidden" name="serendipity[staticblock]" value="' . htmlspecialchars($serendipity['POST']['staticblock']) . '">'."\n";
            echo '    <input type="hidden" name="serendipity[type]" value="' . htmlspecialchars($serendipity['POST']['type']) . '">'."\n";
            echo "</div>\n\n";

            $this->showForm($serendipity['POST']['type']);
        }

        echo "</form>\n";
    }

    function addProperties(&$properties, &$eventData)
    {
        global $serendipity;
        // Get existing data
        $property = serendipity_fetchEntryProperties((int) $eventData['id']);
        $supported_properties = array('attach_block');

        foreach($supported_properties AS $prop_key) {
            $prop_val = $properties[$prop_key] ?? null;
            $prop_key = 'ep_' . $prop_key;

            if (is_array($prop_val)) {
                $prop_val = ";" . implode(';', $prop_val) . ";";
            }

            $q = "DELETE FROM {$serendipity['dbPrefix']}entryproperties WHERE entryid = " . (int)$eventData['id'] . " AND property = '" . serendipity_db_escape_string($prop_key) . "'";
            serendipity_db_query($q);

            if (!empty($prop_val)) {
                $q = "INSERT INTO {$serendipity['dbPrefix']}entryproperties (entryid, property, value) VALUES (" . (int)$eventData['id'] . ", '" . serendipity_db_escape_string($prop_key) . "', '" . serendipity_db_escape_string($prop_val) . "')";
                serendipity_db_query($q);
            }
        }
    }

    function event_hook($event, &$bag, &$eventData, $addData = null)
    {
        global $serendipity;
        static $check = null;
        static $cache = array();

        // check access if user is in admin group levels (admin/chief)
        $access_granted = serendipity_checkPermission('adminPlugins');

        $hooks = &$bag->get('event_hooks');

        if ($check === null) {
            $this->check();
        }

        if (isset($hooks[$event])) {

            switch($event) {

                case 'backend_entryform':
                    if (!$access_granted) {
                        break;
                    }
                    if (!isset($serendipity['GET']['staticblock'])) {
                        break;
                    }

                    $this->fetchStaticBlock($serendipity['GET']['staticblock']);
                    $eventData['title']    = $this->staticblock['title'] ?? '';
                    $eventData['body']     = $this->staticblock['body'] ?? '';
                    $eventData['extended'] = $this->staticblock['extended'] ?? '';

                    if (!empty($eventData['extended'])) {
                        $eventData['exflag'] = true;
                    }
                    break;

                case 'frontend_display:html:per_entry':
                    /* Check cache options */
                    if (!isset($cache['show'])) {
                        $cache['show'] = false;

                        if (!serendipity_db_bool($this->get_config('randomize'))) {
                            $cache['show'] = false;
                        } elseif (!isset($serendipity['GET']['category']) && in_array('-front-', $this->enabled_categories)) {
                            $cache['show'] = true;
                        } elseif (isset($serendipity['GET']['category']) && isset($this->enabled_categories[$serendipity['GET']['category']])) {
                            $cache['show'] = true;
                        } else {
                            $cache['show'] = false;
                        }
                    }

                    if (!isset($cache['first_show'])) {
                        $cache['first_show'] = $this->get_config('first_show') - 1;
                    }

                    if (!isset($cache['show_skip'])) {
                        $cache['show_skip'] = $this->get_config('show_skip');
                    }

                    if (!isset($cache['last_skip'])) {
                        $cache['last_skip'] = 0;
                    }

                    if (!isset($cache['loops'])) {
                        $cache['loops'] = 0;
                    }

                    if (!isset($cache['show_multi'])) {
                        $cache['show_multi'] = serendipity_db_bool($this->get_config('show_multi'));
                    }

                    /* Show attached blocks */
                    $show_multi = true;
                    if (!empty($eventData['properties']['ep_attach_block'])) {
                        $this->fetchStaticBlock($eventData['properties']['ep_attach_block']);
                        $block = $this->smartyParse();;
                        $eventData['display_dat'] .= $block;
                        if (isset($eventData['entryblock'])) {
                            $eventData['entryblock']  .= $block;
                        }
                        // We have shown a block already, check if more are wanted with the setting below.
                        $show_multi = $cache['show_multi'];
                    }

                    /* Show randomized blocks */
                    if ($cache['show'] && $show_multi && $cache['loops'] >= $cache['first_show']) {
                        if ($cache['last_skip'] == 0) {
                            if (stristr($serendipity['dbType'], 'mysql') === FALSE) {
                                $this->staticblock = $this->fetchStaticBlocks('block', 'RANDOM()', 1);
                            } else {
                                $this->staticblock = $this->fetchStaticBlocks('block', 'RAND()', 1);
                            }
                            $eventData['display_dat'] .= $this->smartyParse();
                        }

                        $cache['last_skip']++;

                        if ($cache['last_skip'] >= $cache['show_skip']) {
                            $cache['last_skip'] = 0;
                        }
                    }

                    $cache['loops']++;
                    break;

                case 'backend_sidebar_entries':
                    if (!$access_granted) {
                        break;
                    }
                    $this->check();
                    echo '                        <li class="list-flex"><div class="flex-column-1"><a href="?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=staticblocks">' . PLUGIN_EVENT_INCLUDEENTRY_BLOCKS . "</a></div></li>\n";
                    break;

                case 'backend_sidebar_entries_event_display_staticblocks':
                    if (!$access_granted) {
                        break;
                    }
                    $this->showBackend();
                    break;

                case 'frontend_display':
                    if ($bag->get('scrambles_true_content') && is_array($addData) && isset($addData['no_scramble'])) {
                        break;
                    }
                    // no-BREAK! [PSR-2] - extends frontend_display_cache

                case 'frontend_display_cache':
                    foreach ($this->markup_elements AS $temp) {
                        if (serendipity_db_bool($this->get_config($temp['name'], 'true')) && !empty($eventData[$temp['element']])
                        &&  (!isset($eventData['properties']['ep_disable_markup_' . $this->instance]) || !$eventData['properties']['ep_disable_markup_' . $this->instance])
                        &&  !isset($serendipity['POST']['properties']['disable_markup_' . $this->instance])) {
                            $element = $temp['element'];
                            $this->parse($eventData[$element]);
                        }
                    }
                    break;

                case 'backend_display':
                    if (!$access_granted) {
                        break;
                    }
                    if (isset($eventData['properties']['ep_attach_block'])) {
                        $attach_block = (int)$eventData['properties']['ep_attach_block'];
                    } elseif (isset($serendipity['POST']['properties']['attach_block'])) {
                        $attach_block = (int)$serendipity['POST']['properties']['attach_block'];
                    } else {
                        $attach_block = '';
                    }
?>
            <fieldset id="edit_entry_staticblock" class="entryproperties_staticblock">
                <span class="wrap_legend"><legend><?php echo STATICBLOCK_ATTACH; ?></legend></span>
                <div class="form_field">
                    <select id="attach_static_block" name="serendipity[properties][attach_block]">
                        <option value=""></option>
                        <?php echo $this->getPages($attach_block); ?>
                    </select>
                </div>
            </fieldset>

<?php
                    break;

                case 'backend_publish':
                case 'backend_save':
                    if (!$access_granted) {
                        break;
                    }
                    if (!isset($serendipity['POST']['properties']) || !is_array($serendipity['POST']['properties']) || !isset($eventData['id'])) {
                        break;
                    }
                    $this->addProperties($serendipity['POST']['properties'], $eventData);
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