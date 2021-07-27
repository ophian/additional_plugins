<?php

// TODO:
// Use parent category template for a child category, but allow child categories to override template of parent category.


if (IN_serendipity !== true) {
    die ("Don't hack!");
}

@serendipity_plugin_api::load_language(dirname(__FILE__));

@define('CATEGORYTEMPLATE_DB_VERSION', 5);

class serendipity_event_categorytemplates extends serendipity_event
{
    var $title = PLUGIN_CATEGORYTEMPLATES_NAME;

    private $bycategory = [];

    function introspect(&$propbag)
    {
        global $serendipity;

        $propbag->add('name',          PLUGIN_CATEGORYTEMPLATES_NAME);
        $propbag->add('description',   PLUGIN_CATEGORYTEMPLATES_DESC);
        $propbag->add('stackable',     false);
        $propbag->add('author',        'Garvin Hicking, Judebert, Ian Styx');
        $propbag->add('version',       '2.2.0');
        $propbag->add('requirements',  array(
            'serendipity' => '2.7.0',
            'php'         => '7.3.0'
        ));
        $propbag->add('event_hooks',    array(
            'genpage'                   => true,
            'external_plugin'           => true,
            'css_backend'               => true,
            'backend_category_addNew'   => true,
            'backend_category_update'   => true,
            'backend_category_delete'   => true,
            'backend_category_showForm' => true,
            'frontend_fetchcategories'  => true,
            'frontend_fetcharchives'    => true,
            'frontend_fetchcomments'    => true,
            'frontend_fetchentries'     => true,
            'frontend_fetchentry'       => true,
            'backend_sidebar_entries_event_display_cattemplate' => true
//            'frontend_configure'        => true
        ));

        $propbag->add('configuration', array('pass', 'sort_order', 'fixcat', 'cat_precedence'));
        $propbag->add('groups', array('FRONTEND_FULL_MODS', 'FRONTEND_VIEWS', 'BACKEND_TEMPLATES'));
    }

    function introspect_config_item($name, &$propbag)
    {
        switch($name) {
            case 'pass':
                $propbag->add('type',        'boolean');
                $propbag->add('name',        PLUGIN_CATEGORYTEMPLATES_PASS);
                $propbag->add('description', PLUGIN_CATEGORYTEMPLATES_PASS_DESC);
                $propbag->add('default',     'false');
                break;

            case 'sort_order':
                $propbag->add('type',        'string');
                $propbag->add('name',        USE_DEFAULT . ': ' . SORT_ORDER);
                $propbag->add('description', '');
                $propbag->add('default',     'timestamp DESC');
                break;

            case 'fixcat':
                $propbag->add('type',           'radio');
                $propbag->add('name',           PLUGIN_CATEGORYTEMPLATES_FIXENTRY);
                $propbag->add('description',    PLUGIN_CATEGORYTEMPLATES_FIXENTRY_DESC);
                $propbag->add('radio',          array(
                                                    'value' => array('true', 'false', 'hard'),
                                                    'desc'  => array(YES, NO, FORCE)
                                                ));
                $propbag->add('default',        'false');
                break;

            case 'cat_precedence':
                $propbag->add('type',        'sequence');
                $propbag->add('name',        PLUGIN_CATEGORYTEMPLATES_CATPRECEDENCE);
                $propbag->add('description', PLUGIN_CATEGORYTEMPLATES_CATPRECEDENCE_DESC);
                $propbag->add('checkable',   true);
                $tcats = $this->getTemplatizedCats();
                $values = array();
                if (is_array($tcats)) {
                    foreach($tcats AS $cat) {
                        $values[$cat['categoryid']] = array('display' => $cat['category_name']);
                    }
                } else {
                    $values = array(PLUGIN_CATEGORYTEMPLATES_NO_CUSTOMIZED_CATEGORIES);
                }
                $propbag->add('values',      $values);
                // To make this work with Serendipity 2.0+ versions (maybe even before)
                // we had to make them checkable, although not having a default they are
                // unchecked before usage and the drag&drop value isn't stored unless they are!

                // People who already had custom categories, but don't have
                // the sequence widget, will not save this value.  So entries
                // won't ever use custom templates.  To duplicate the original
                // without-sequence-widget behavior, we'll have to do some
                // magic when the 'cat_precedence' is retrieved.

                // If you want to set a default here:
                // Note that get_config() will cause HTTP error 500 the first
                // time the plugin is installed, unless we provide a default
                break;

            default:
                return false;
        }
        return true;
    }

    /**
     * Retrieves a list of IDs of all categories that have some customization enabled.
     *
     * @return array A list of category IDs, or false if no categories are customized.
     */
    function getTemplatizedCats()
    {
        global $serendipity;
        // Find all the categories that have custom templates
        $query = "SELECT
                    c.categoryid,
                    c.category_name,
                    c.category_icon
                  FROM {$serendipity['dbPrefix']}category AS c
            INNER JOIN {$serendipity['dbPrefix']}categorytemplates AS t
                    ON t.categoryid = c.categoryid
                 WHERE t.template != ''
              ORDER BY c.category_name ASC";
        $dbcids = serendipity_db_query($query);
        if (!is_array($dbcids)) {
            // It's the value "1", for "success", or something
            $dbcids = false;
        }
        return $dbcids;
        //--TODO: Maybe find all the ones with custom sort orders and other display alterations, too
    }

    /**
     * Updates database to version-appropriate schema
     *
     * @param The current version number of the database (could be empty)
     *
     * @return true
     */
    function checkScheme($ver)
    {
        global $serendipity;

        if ($ver == 4) {
            $q   = "ALTER TABLE {$serendipity['dbPrefix']}categorytemplates CHANGE hide_rss hide varchar(4)";
            $sql = serendipity_db_schema_import($q);

            $this->set_config('dbversion', CATEGORYTEMPLATE_DB_VERSION);
        } elseif ($ver == 3) {
            $q   = "ALTER TABLE {$serendipity['dbPrefix']}categorytemplates ADD COLUMN hide_rss varchar(4) default false";
            $sql = serendipity_db_schema_import($q);

            $this->set_config('dbversion', CATEGORYTEMPLATE_DB_VERSION);
        } elseif ($ver == 2) {
            $q   = "ALTER TABLE {$serendipity['dbPrefix']}categorytemplates ADD COLUMN hide_rss varchar(4) default false";
            $sql = serendipity_db_schema_import($q);

            $q   = "ALTER TABLE {$serendipity['dbPrefix']}categorytemplates ADD COLUMN sort_order varchar(255)";
            $sql = serendipity_db_schema_import($q);

            $this->set_config('dbversion', CATEGORYTEMPLATE_DB_VERSION);
        } elseif ($ver == 1) {
            $q   = "ALTER TABLE {$serendipity['dbPrefix']}categorytemplates ADD COLUMN hide_rss tinyint(1) default false";
            $sql = serendipity_db_schema_import($q);

            $q   = "ALTER TABLE {$serendipity['dbPrefix']}categorytemplates ADD COLUMN sort_order varchar(255)";
            $sql = serendipity_db_schema_import($q);

            $q   = "ALTER TABLE {$serendipity['dbPrefix']}categorytemplates ADD COLUMN pass varchar(255) default null";
            $sql = serendipity_db_schema_import($q);
            $this->set_config('dbversion', CATEGORYTEMPLATE_DB_VERSION);
        } elseif ($ver != CATEGORYTEMPLATE_DB_VERSION) {
            $q   = "CREATE TABLE {$serendipity['dbPrefix']}categorytemplates (
                        categoryid int(11) default null,
                        template varchar(255) default null,
                        fetchlimit int(4) default null,
                        futureentries int(4) default null,
                        lang varchar(255) default null,
                        pass varchar(255) default null,
                        sort_order varchar(255),
                        hide varchar(4) default null
                    )";
            $sql = serendipity_db_schema_import($q);

            $q   = "CREATE INDEX ctcid ON {$serendipity['dbPrefix']}categorytemplates (categoryid);";
            $sql = serendipity_db_schema_import($q);

            $this->set_config('dbversion', CATEGORYTEMPLATE_DB_VERSION);
        }

        return true;
    }

    /**
     * Returns the most appropriate category ID for the current entry.
     * Only called from genpage hook.
     *
     * @global array $serendipity Determines the current entry from HTTP variables
     *
     * @return int|string Category ID if custom template defined or category
     *    view, otherwise 'default'
     */
    function getID()
    {
        global $serendipity;

        // If category view, just return the current category ID
        if (!empty($serendipity['GET']['category']) && !isset($serendipity['GET']['id'])) {
            return (int)$serendipity['GET']['category'];
        }

        // If entry view, determine the best category ID for custom templating
        if (!empty($serendipity['GET']['id'])) {
            // Find all the category IDs that have custom templates
            $cidstr = $this->get_config('cat_precedence', false);
            if ($cidstr === false) {
                // No precedence set: default to old, alphabetical precedence.
                $tcats = $this->getTemplatizedCats();
                $cids = array();
                if (is_array($tcats)) {
                    foreach($tcats AS $cat) {
                        $cids[] = $cat['categoryid'];
                    }
                }
            } else {
                if ($cidstr) {
                    $cids = explode(',', $cidstr);
                } else {
                    // Possibly it's set, but no categories, therefore empty
                    $cids = array();
                }
            }

            // Get all the categories' IDs belonging to this entry
            $entrycats = serendipity_fetchEntryCategories($serendipity['GET']['id']);
            $entrycids = array();
            foreach ($entrycats AS $catdata) {
                $entrycids[] = $catdata['categoryid'];
            }

            // Return the first customized template in the entry's categories
            // Could try array_intersect(), but will it keep order?
            foreach ($cids AS $idx => $candidate) {
                if (in_array($candidate, $entrycids)) {
                    return $candidate;
                }
            }// End if we know of any customized categories

            // If set to force, ALWAYS set the category to a forced category.
            if ((string)$this->get_config('fixcat') === 'hard') {
                return $entrycids[0];
            }
        }// End if entry

        return 'default';
    }

    /**
     * Wrapper for fetchProp() returning name of custom template for the
     * given category ID, if defined, with default.
     *
     * @param int cid The category ID to lookup
     * @param string fallback The default template name
     *
     * @return string The name of the template to be used
     */
    function fetchTemplate($cid, $fallback)
    {
        $this->usesDefaultTemplate = true;

        if ($cid === false || $cid == 'default') {
            return $fallback;
        } else {
            $val = $this->fetchProp($cid, 'template');
            if (!empty($val)) {
                $this->usesDefaultTemplate = false;
                return $val;
            }
        }

        return $fallback;
    }

    /**
     * Wrapper for fetchProp() returning the limit of entries to fetch
     * for this category ID, with default.
     *
     * @param int cid The category ID to lookup
     * @param int fallback The default number of entries to fetch
     *
     * @return int The max number of entries to be fetched
     */
    function fetchLimit($cid, $fallback)
    {
        if ($cid == false || $cid == 'default' || $cid == 0) {
            return $fallback;
        } else {
            $val = $this->fetchProp($cid, 'fetchlimit');
            if (!empty($val)) {
                return $val;
            }
        }

        return $fallback;
    }

    /**
     * Wrapper for fetchProp() returning the language for the category ID,
     * with default.
     *
     * @param int cid The category ID to lookup
     * @param string fallback The default language to use
     *
     * @return string The language to be used
     */
    function fetchLang($cid, $fallback)
    {
        if ($cid === false || $cid == 'default') {
            return $fallback;
        } else {
            $val = $this->fetchProp($cid, 'lang');
            if (!empty($val)) {
                return $val;
            }
        }

        return $fallback;
    }

    /**
     * Wrapper for fetchProp() returning whether to display entries with
     * dates in the future for this category ID, with default.
     *
     * @param int cid The category ID to lookup
     * @param bool fallback The default whether to display entries from the future
     *
     * @return bool Whether to display entries from the future
     */
    function fetchFuture($cid, $fallback)
    {
        if ($cid === false || $cid == 'default' || $cid == 0) {
            return $fallback;
        } else {
            $val = $this->fetchProp($cid, 'futureentries');
            if ($val == 1) {
                return false;
            } elseif ($val == 2) {
                return true;
            }
        }

        return $fallback;
    }

    /**
     * Wrapper for fetchProp() returning the entry sort order for this
     * category ID, with default.
     *
     * @param int cid The category ID to lookup
     * @param string fallback The default database ordering string
     *
     * @return string The database ordering string to use (i.e, 'date ASC')
     */
    function fetchSortOrder($cid, $fallback)
    {
        if ($cid === false || $cid == 'default' || $cid == 0) {
            return $fallback;
        } else {
            $val = $this->fetchProp($cid, 'sort_order');
        }

        return !empty($val) ? $val : $fallback;
    }

    /**
     * Fetches the requested property of the given category ID, retrieving
     * from cache where possible, querying database and populating cache
     * with all properties otherwise.
     *
     * @param int cide The category ID to be queried
     * @param string key optional The property to be fetched (default 'template')
     *
     * @return mixed The value of the requested property
     */
    function fetchProp($cid, $key = 'template')
    {
        global $serendipity;
        static $cache = array();

        if (isset($cache[$cid][$key])) {
            return $cache[$cid][$key];
        }

        $props = serendipity_db_query("SELECT * FROM {$serendipity['dbPrefix']}categorytemplates WHERE categoryid = " . (int)$cid . " LIMIT 1");
        if (is_array($props)) {
            $cache[$cid] = $props[0];
            return $cache[$cid][$key];
        }

        return false;
    }

    /**
     * Sets or deletes properties for this category from the database.
     *
     * @param int cid The category ID to use
     * @param array val optional An array associating SQL column names with
     *     their desired values (default false)
     * @param bool deleteOnly optional Whether to skip inserting new values (default false)
     *
     * @return true
     */
    function setProps($cid, $val = false, $deleteOnly = false)
    {
        global $serendipity;

        serendipity_db_query("DELETE FROM {$serendipity['dbPrefix']}categorytemplates
                                    WHERE categoryid = " . (int)$cid);

        if ($deleteOnly === false) {
            $db = serendipity_db_insert('categorytemplates', $val, 'execute');
            return $db;
        }

        return true;
    }

    /**
     * Check for an engine based category template
     * @param string The full Path to the themes info.txt file
     *
     * @return mixed Name of Engine or NIL
     */
    function getFallbackEngineChain($file)
    {
        if (file_exists($file)) {
            $lines = @file($file);
            if (!$lines) {
                return null;
            }
            // init default
            $data['summary'] = $data['description'] = $data['backenddesc'] = $data['backend'] = null;

            for($x=0; $x<count($lines); $x++) {
                $j = preg_split('/([^\:]+)\:/', $lines[$x], -1, PREG_SPLIT_DELIM_CAPTURE);
                if (!empty($j[2])) {
                    $currSec = $j[1];
                    $data[strtolower($currSec)][] = trim($j[2]);
                } else {
                    $data[strtolower($currSec)][] = trim($j[0]);
                }
            }

            foreach($data AS $k => $v) {
                if (!is_null($v)) {
                    $data[$k] = @trim(implode("\n", $v));
                }
            }
        }
        if (isset($data['engine'])) {
            return $data['engine'];
        }
        return null;
    }

    /**
     * Set category template options
     * @param string The theme
     * @param integer The category ID
     *
     * @return mixed
     */
    function template_options($template, $catid)
    {
        global $serendipity, $template_config;

        if (!serendipity_checkPermission('adminTemplates')) {
            return;
        }

        $template = str_replace('.', '', urldecode($template));
        $catid    = (int)$catid;
        $tpl_path = $serendipity['serendipityPath'] . $serendipity['templatePath'] . $template;

        if (!is_dir($tpl_path)) {
            return false;
        }

        $serendipity['GET']['adminModule'] == 'templates';
        $serendipity['smarty_vars']['template_option'] = $template . '_' . $catid;

        echo '<section id="template_options">'."\n";
        echo '    <h2>' . STYLE_OPTIONS . ' ('.$template.')</h2>'."\n\n";

        if (file_exists($tpl_path . '/config.inc.php')) {
            serendipity_smarty_init();
            include_once $tpl_path . '/config.inc.php';
        }

        if (is_array($template_config)) {
            serendipity_plugin_api::hook_event('backend_templates_configuration_top', $template_config);

            if (isset($serendipity['POST']['adminSubAction']) && $serendipity['POST']['adminSubAction'] == 'configure') {
                foreach($serendipity['POST']['template'] AS $option => $value) {
                    categorytemplate_option::set_config($option, $value, $serendipity['smarty_vars']['template_option']);
                }
                echo '<span class="msg_success"><span class="icon-ok-circled"></span> ' . DONE .': '. sprintf(SETTINGS_SAVED_AT, serendipity_strftime('%H:%M:%S')) . "</span>\n";
            }

            echo '<form class="theme_options option_list" method="post" action="serendipity_admin.php">'."\n";
            echo '<input type="hidden" name="serendipity[adminSubAction]" value="configure">'."\n";
            echo '<input type="hidden" name="serendipity[adminAction]" value="cattemplate">'."\n";
            echo '<input type="hidden" name="serendipity[adminModule]" value="event_display">'."\n";
            echo '<input type="hidden" name="serendipity[catid]" value="' . $catid . '">'."\n";
            echo '<input type="hidden" name="serendipity[cat_template]" value="' . urlencode($template) . '">'."\n";
            echo serendipity_setFormToken();

            include_once S9Y_INCLUDE_PATH . 'include/functions_plugins_admin.inc.php';
            $template_vars =& serendipity_loadThemeOptions($template_config, $serendipity['smarty_vars']['template_option'], true);

            $template_options = new categorytemplate_option();
            $template_options->import($template_config);
            $template_options->values =& $template_vars;

            echo serendipity_plugin_config(
                $template_options,
                $template_vars,
                $serendipity['template'],
                $serendipity['template'],
                $template_options->keys,
                true,
                true,
                true,
                true,
                'categorytemplate'
            ); // normally this is 'template' to properly work but since used for buttoning we have made an exception for categorytemplate(s)

            echo "\n</form>\n";
            serendipity_plugin_api::hook_event('backend_templates_configuration_bottom', $template_config);
        } else {
            echo '<p>' . STYLE_OPTIONS_NONE . "</p>\n";
            serendipity_plugin_api::hook_event('backend_templates_configuration_none', $template_config);
        }
        echo "</section>\n";
    }

    /**
     * Fetch and memorize possible hidden set categories
     */
    function fetchHiddenCategoryTemplates()
    {
        global $serendipity;

        if (!isset($this->bycategory[0])) {
            $this->bycategory = serendipity_db_query("SELECT categoryid, template FROM {$serendipity['dbPrefix']}categorytemplates WHERE hide = 1", false, 'assoc');
        }
    }

    /**
     * The meat of the plugin, called for each registered hook.
     *
     * @param string event The name of the hook being called
     * @param mixed bag An array of configuration options for this plugin
     * @param mixed eventData An array containing parameters for the hook
     * @param mixed addData Additional hook data, if any
     *
     * @return true
     */
    function event_hook($event, &$bag, &$eventData, $addData = null)
    {
        global $serendipity;

        $hooks = &$bag->get('event_hooks');

        // check access if user is in admin group levels (admin/chief)
        $access_granted = serendipity_checkPermission('adminPlugins');

        if (isset($hooks[$event])) {
            // Update the database on first run if changed.
            $ver = $this->get_config('dbversion', 0);
            if ($ver != CATEGORYTEMPLATE_DB_VERSION) {
                $this->checkScheme($ver);
            }

            switch($event) {
                // When changing category options, display the new extended
                // options, such as template, future entries, limit, and order
                case 'backend_category_showForm':
                    if (!$access_granted) {
                        break;
                    }
                    // The $eventData is the category ID
                    if (empty($eventData)) {
                        break;
                    }
                    $eventData = (int)$eventData;
                    $clang      = $this->fetchLang($eventData, '');
                    $cfuture    = $this->fetchFuture($eventData, '');
                    $styles     = serendipity_fetchTemplates();
                    $template   = $this->fetchTemplate($eventData, '');
                    $hidden     = serendipity_db_query("SELECT hide FROM {$serendipity['dbPrefix']}categorytemplates AS t WHERE t.categoryid = {$eventData}", true);
                    if ($hidden !== false) {
                        $hide = serendipity_db_bool($hidden['hide']);
                    } else $hide = false;
?>

            <h3 class="additional_properties"><?php echo defined('ADDITIONAL_PROPERTIES_BY_PLUGIN') ? sprintf(ADDITIONAL_PROPERTIES_BY_PLUGIN, PLUGIN_CATEGORYTEMPLATES_NAME) : 'Additional properties by Plugin: ' . PLUGIN_CATEGORYTEMPLATES_NAME; ?></h3>

            <div id="category_templates" class="clearfix">
                <div class="form_field">
                    <label for="category_template" class="wrap_legend"><?php echo PLUGIN_CATEGORYTEMPLATES_SELECT_TEMPLATE; ?><a class="toggle_info button_link" href="#hide_templates_info"><span class="icon-info-circled" aria-hidden="true"></span><span class="visuallyhidden"><?=MORE?></span></a></label>
                    <input id="category_template" class="input_textbox" name="serendipity[cat][template]" type="text" data-configitem="category_template" value="<?php echo $template; ?>">
                </div>
                <div class="select_field">
                    <legend>- <?php echo WORD_OR; ?> -</legend>
                    <select name="serendipity[cat][drop_template]">
                        <option value=""><?php echo NONE; ?></option>
<?php
                    foreach ($styles AS $style => $path) {
                        $templateInfo = serendipity_fetchTemplateInfo($style);
?>
                        <option value="<?php echo (function_exists('serendipity_specialchars') ? serendipity_specialchars($style) : htmlspecialchars($style, ENT_COMPAT, LANG_CHARSET)); ?>" <?php echo ($style == $template? 'selected="selected"' : ''); ?>><?php echo (function_exists('serendipity_specialchars') ? serendipity_specialchars($templateInfo['name']) : htmlspecialchars($templateInfo['name'], ENT_COMPAT, LANG_CHARSET)); ?></option>
<?php
                    }
?>
                    </select>
                </div>
<?php if (!empty($template)) { ?>
                <div><a class="button_link" href="serendipity_admin.php?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=cattemplate&amp;serendipity[catid]=<?php echo $eventData; ?>&amp;serendipity[cat_template]=<?php echo urlencode($template);?>"><?php echo STYLE_OPTIONS; ?></a></div>
<?php } ?>
                <span id="hide_templates_info" class="field_info category_field_info additional_info">
                    <span class="icon-info-circled"></span> <em><?php echo PLUGIN_CATEGORYTEMPLATES_SELECT; ?></em>
                </span>
            </div>

<?php /* TODO: This does not work easily. ... Ian: Why not?
            <div id="category_language" class="clearfix">
                <div class="select_field">
                    <label for="language"><?php echo INSTALL_LANG; ?></label>
                    <select id="language" name="serendipity[cat][lang]">
                        <option value="default"><?php echo USE_DEFAULT; ?></option>
<?php foreach($serendipity['languages'] AS $langkey => $lang) { ?>
                        <option value="<?php echo $lang; ?>" <?php echo ($langkey == $clang ? 'selected="selected"' : ''); ?>><?php echo (function_exists('serendipity_specialchars') ? serendipity_specialchars($lang) : htmlspecialchars($lang, ENT_COMPAT, LANG_CHARSET)); ?></option>
<?php } ?>
                    </select>
                </div>
            </div>
*/ ?>
            <div id="category_future" class="clearfix">
                <div class="radio_field">
                    <label for="language"><?php echo INSTALL_SHOWFUTURE; ?></label>
                    <input id ="futureentries_default" class="input_radio" name="serendipity[cat][futureentries]" type="radio" value="0"<?php echo (empty($cfuture) || $cfuture == 0) ? ' checked="checked"' : ''; ?>><label for="futureentries_default" class="wrap_legend"><?php echo USE_DEFAULT; ?></label>
                    <input id ="futureentries_no" class="input_radio"      name="serendipity[cat][futureentries]" type="radio" value="1"<?php echo $cfuture == 1 ? ' checked="checked"' : ''; ?>><label for="futureentries_no" class="wrap_legend"><?php echo NO; ?></label>
                    <input id ="futureentries_yes" class="input_radio"     name="serendipity[cat][futureentries]" type="radio" value="2"<?php echo $cfuture == 2 ? ' checked="checked"' : ''; ?>><label for="futureentries_yes" class="wrap_legend"><?php echo YES; ?></label>
                </div>
            </div>


            <div id="category_fetchlimit" class="clearfix">
                <div class="radio_field">
                    <label for="fetchlimit"><?php echo PLUGIN_CATEGORYTEMPLATES_FETCHLIMIT; ?></label>
                    <input id="fetchlimit" class="input_textbox" name="serendipity[cat][fetchlimit]" type="text" value="<?php echo $this->fetchLimit($eventData, ''); ?>">
                </div>
            </div>

            <div id="category_sortorder" class="clearfix">
                <div class="radio_field">
                    <label for="sort_order"><?php echo SORT_ORDER; ?></label>
                    <input id="sort_order" class="input_textbox" name="serendipity[cat][sort_order]" type="text" value="<?php echo $this->fetchSortOrder($eventData, $this->get_config('sort_order')); ?>">
                </div>
            </div>

            <div id="category_hide" class="clearfix">
                <div class="radio_field">
                    <label for="hide"><?php echo PLUGIN_CATEGORYTEMPLATES_HIDE; ?></label>
                    <div>
                        <input class="input_radio" type="radio" id="hide_yes" name="serendipity[cat][hide]" value="1" <?php echo ($hide ? 'checked="checked"' : ''); ?>><label for="hide_yes"><?php echo YES; ?></label>
                        <input class="input_radio" type="radio" id="hide_no"  name="serendipity[cat][hide]" value="0" <?php echo ($hide ? '' : 'checked="checked"'); ?>><label for="hide_no"><?php echo NO; ?></label>
                    </div>
                </div>
            </div>
<?php if (serendipity_db_bool($this->get_config('pass', 'false'))) { ?>

            <div id="category_pass" class="clearfix">
                <div class="radio_field">
                    <label for="pass"><?php echo PLUGIN_CATEGORYTEMPLATES_PASS; ?></label>
                    <input class="input_textbox" id="pass" type="text" name="serendipity[cat][pass]" value="<?php echo $this->fetchProp($eventData, 'pass'); ?>">
                </div>
            </div>
<?php }
                    break;

                // When a category is deleted, delete its custom properties
                case 'backend_category_delete':
                    // $eventData is the category ID.  This just deletes.
                    $this->setProps($eventData, null, true);
                    // Remove it from the list of template categories, too.
                    $cidstr = $this->get_config('cat_precedence', false);
                    // No need to modify config if no config set, or if no
                    // templates are templatized
                    if ($cidstr) {
                        $cids = explode(',', $cidstr);
                        // Why doesn't PHP have an array_remove(item)?
                        if (in_array($eventData, $cids)) {
                            $newcids = array();
                            foreach ($cids AS $cid) {
                                if ($cid != $eventData) {
                                    $newcids[] = $cid;
                                }
                            }
                            $cidstr = implode(',', $newcids);
                            $this->set_config('cat_precedence', $cidstr);
                        }
                    }
                    break;

                case 'css_backend':
                    $eventData .= '
/* serendipity_event_categorytemplates backend start */

@media screen and (max-width: 768px) {
    #serendipity_category > div#category_templates,
    #serendipity_category > div#category_language,
    #serendipity_category > div#category_future,
    #serendipity_category > div#category_fetchlimit,
    #serendipity_category > div#category_sortorder,
    #serendipity_category > div#category_hide,
    #serendipity_category > div#category_pass {
        margin-top: 0.5em;
        margin-bottom: 0.5em;
    }
}
#serendipity_category > div#category_future > div.radio_field,
#serendipity_category > div#category_hide > div.radio_field {
    float: none;
    width: 100%;
    display: block;
}
#category_future .radio_field label,
#category_hide .radio_field label {
    padding-left: 0;
    display: inline-block;
}
#category_future .radio_field input,
#category_hide .radio_field input {
    margin-left: 0.5em;
    margin-right: 0.5em;
}
#category_templates .category_field_info {
    width: 100%;
    float: none;
}

/* serendipity_event_categorytemplates backend end */
';
                break;

                // When a category is updated or added, modify its properties
                case 'backend_category_update':
                case 'backend_category_addNew':
                    $orig_tpl = $this->fetchTemplate($eventData, '');
                    $text_tpl = $serendipity['POST']['cat']['template'] ?? null;
                    $drop_tpl = $serendipity['POST']['cat']['drop_template'] ?? null;
                    // Default no change to template
                    $set_tpl = $orig_tpl;
                    // If text template changed, it takes precedence
                    if ($text_tpl != $orig_tpl) {
                        // (even when invalid; no checking)
                        $set_tpl = $text_tpl;
                    }
                    // If it hasn't changed, drop-down template can override
                    else if ($drop_tpl != $orig_tpl) {
                        $set_tpl = $drop_tpl;
                    }
                    $val = array(
                        'fetchlimit'    => !empty($serendipity['POST']['cat']['fetchlimit']) ? (int)$serendipity['POST']['cat']['fetchlimit'] : $serendipity['fetchLimit'],
                        'template'      => $set_tpl,
                        'categoryid'    => (int)$eventData,
                        'lang'          => $serendipity['POST']['cat']['lang'] ?? 'default',
                        'futureentries' => (int)($serendipity['POST']['cat']['futureentries'] ?? null),
                        'pass'          => $serendipity['POST']['cat']['pass'] ?? null,
                        'sort_order'    => serendipity_db_escape_string(($serendipity['POST']['cat']['sort_order'] ?? null)),
                        'hide'          => $serendipity['POST']['cat']['hide'] ?? null
                    );
                    $this->setProps($eventData, $val);
                    // Update list of template categories, too.
                    //
                    // Get the list of customized category IDs, in precedence order
                    $cidstr = $this->get_config('cat_precedence', false);
                    // Only save the new precedence if we can actually
                    // manually change templatized categories precedence
                    if ($cidstr !== false) {
                        if ($cidstr) {
                            // If $cidstr is empty, this returns an array
                            // with an empty string
                            $cids = explode(',', $cidstr);
                        } else {
                            // For instance, set but empty
                            $cids = array();
                        }
                        // If it had a custom template just added, append it
                        // to the list (user can change precedence later)
                        if (!in_array($eventData, $cids) && !empty($set_tpl)) {
                            $cids[] = $eventData;
                            $cidstr = implode(',', $cids);
                            $this->set_config('cat_precedence', $cidstr);
                        }
                        // If it had a custom template just deleted, remove it
                        // from the list
                        if (in_array($eventData, $cids) && empty($set_tpl)) {
                            // Why doesn't PHP have an array_remove(item)?
                            $newcids = array();
                            foreach ($cids AS $cid) {
                                if ($cid != $eventData) {
                                    $newcids[] = $cid;
                                }
                            }
                            $cidstr = implode(',', $newcids);
                            $this->set_config('cat_precedence', $cidstr);
                        }
                    }
                    break;

                // When an entry or category is displayed, this changes the
                // CSS to the custom template
                case 'external_plugin':
                    $parts = explode('_', $eventData);
                    $cid = !empty($parts[1]) ? (int)$parts[1] : null;

                    if (is_null($cid)) {
                        return;
                    }
                    $serendipity['template'] = $this->fetchTemplate($cid, $serendipity['template']);
                    $methods = array('ct', "ct{$serendipity['template']}", 'categorytemplate');

                    if (!in_array($parts[0], $methods)) {
                        return;
                    }

                    $serendipity['GET']['css_mode'] = 'external_plugin';
                    include_once(S9Y_INCLUDE_PATH . 'serendipity.css.php');
                    exit;
                    break;

                // When Serendipity Styx tries to gather the archive entry sums, exclude hidden category(template) entries
                case 'frontend_fetchcategories':
                case 'frontend_fetcharchives':
                    $this->fetchHiddenCategoryTemplates();
                    if (!empty($this->bycategory[0]['template'])) {
                        $conds = array();
                        if ($event == 'frontend_fetcharchives') {
                            $eventData['joins'] = "LEFT JOIN {$serendipity['dbPrefix']}entrycat AS ec ON (ec.entryid IS NULL OR ec.entryid = e.id)";
                        }
                        $as = ($event == 'frontend_fetchcategories') ? 'c' : 'ec';
                        foreach ($this->bycategory AS $bcat) {
                            if ($bcat['template'] == $serendipity['template']) {
                                $conds[] = "($as.categoryid = " . (int)$bcat['categoryid'] . ")";
                            } else {
                                $conds[] = "($as.categoryid != " . (int)$bcat['categoryid'] . " OR $as.categoryid IS NULL)";
                            }
                        }
                        // Conditions
                        if (count($conds) > 0) {
                            $cond = count($conds) > 1 ? '(' .implode(' AND ', $conds) .')' : implode(' AND ', $conds);
                            $and  = ($event == 'frontend_fetchcategories') ? '' : ' AND ';
                            if (empty($eventData['and'])) {
                                $eventData['and'] = $and . $cond;
                            } else {
                                $eventData['and'] .= $and . $cond;
                            }
                        }
                    }
                    break;

                case 'frontend_fetchcomments':
                    // Do not apply to logged in Administrators (so not in the backend as well)
                    if ((isset($_SESSION['serendipityAuthedUser']) && $_SESSION['serendipityAuthedUser'] === true)
                    && (serendipity_checkPermission('siteConfiguration') || serendipity_checkPermission('blogConfiguration'))) {
                        return;
                    }
                    $coctr = (isset($addData['source']) && $addData['source'] == 'comments_counter') ? true : false;
                    $conds = array();
                    $joins = array();
                    // Will force comments query to not fetch comments of (hidden) categorytemplates to be not displayed in comments and RSS feed for comments.
                    $this->fetchHiddenCategoryTemplates();
                    if (!empty($this->bycategory[0]['template'])) {
                        if ($coctr) {
                            $joins[] = "LEFT OUTER JOIN {$serendipity['dbPrefix']}entries AS e ON (co.entry_id = e.id)";
                        }
                        $joins[] = "LEFT OUTER JOIN {$serendipity['dbPrefix']}entrycat AS ec ON (e.id = ec.entryid)";
                        $joins[] = "LEFT OUTER JOIN {$serendipity['dbPrefix']}categorytemplates AS ct ON (ec.categoryid = ct.categoryid)";
                        foreach ($this->bycategory AS $bcat) {
                            if ($bcat['template'] != $serendipity['template']) {
                                $conds[] = "(ec.categoryid != " . (int)$bcat['categoryid'] . " OR ec.categoryid IS NULL)";
                            }
                        }
                    }
                    // Conditions
                    if (count($conds) > 0) {
                        $cond = count($conds) > 1 ? '(' .implode(' AND ', $conds) .')' : implode(' AND ', $conds);
                        if (empty($eventData['and'])) {
                            $eventData['and'] = $cond;
                        } else {
                            $eventData['and'] .= $cond;
                        }
                    }
                    // Joins
                    if (count($joins) > 0) {
                        $cond = implode("\n", $joins);
                        if (empty($eventData['joins'])) {
                            $eventData['joins'] = $cond."\n";
                        } else {
                            $eventData['joins'] .= $cond."\n";
                        }
                    }
                    break;

                // When Serendipity tries to get the entries, check for
                // passwords
                case 'frontend_fetchentries':
                case 'frontend_fetchentry':
                    $allowPasswordProtected = serendipity_db_bool($this->get_config('pass'));

                    // Override sort order - don't touch for default serendipity_fetchEntries(..., $orderby)
                    if (!empty($this->sort_order) && $this->sort_order != 'timestamp DESC') {
                        $eventData['orderby'] = $this->sort_order . (!empty($eventData['orderby']) ? ', ' : '') . (!empty($eventData['orderby']) ? $eventData['orderby'] : '') . '/*BYcategorytemplate*/';
                    }

                    // This usually emits the normal query search like being used to - to dig into all and return
                    // Password are not required on search or calendar, and we don't do RSS for them either
                    if ($allowPasswordProtected || ($allowPasswordProtected && $serendipity['view'] == 'feed')) {
                        if (!isset($addData['source']) || ($addData['source'] == 'search' || $addData['source'] == 'calendar')) {
                            return true;
                        }
                    }

                    // Password and hidden categories not required for installation
                    if (defined('IN_installer') && IN_installer === true && defined('IN_upgrader') && IN_upgrader === true) {
                        return true;
                    }

                    // Prepare to modify SQL
                    $joins   = array();
                    $conds   = array();
                    $addkeys = array();
                    $havings = array();

                    // Password protection SQL
                    if ($allowPasswordProtected) {
                        $pw = !empty($this->current_pw) ? $this->current_pw : '';
                        $conds[] = "(ctpass.pass IS NULL OR ctpass.pass = '$pw')";
                        $joins[] = "LEFT OUTER JOIN {$serendipity['dbPrefix']}categorytemplates ctpass
                            ON (ec.categoryid = ctpass.categoryid)";
                    }

                    // Serendipity entries list startpage, (P) paged views of archives, by authors, 404 fallback, search requests and feeds.
                    // Add       <input type="hidden" name="serendipity[category]" value="5">   and take the correct category ID number(!)
                    // to your categorytemplate index.tpl or sidebar.tpl; wherever you have the quicksearch form!

                    if (isset($serendipity['view']) && in_array($serendipity['view'], ['archives', 'authors', 'entries', 'feed', 'search', 'start', '404'])) {
                        $this->fetchHiddenCategoryTemplates();
                        if (!empty($this->bycategory[0]['template'])) {
                            foreach ($this->bycategory AS $bcat) {
                                if ($bcat['template'] == $serendipity['template']) {
                                    $conds[] = "(ec.categoryid = " . (int)$bcat['categoryid'] . ")";
                                } else {
                                    $conds[] = "(ec.categoryid != " . (int)$bcat['categoryid'] . " OR ec.categoryid IS NULL)";
                                }
                            }
                        }
                        /* This looks like an other (old archived) try to support multiple hidden categories.
                         *
                        $q = serendipity_db_query("SELECT categoryid FROM {$serendipity['dbPrefix']}categorytemplates WHERE hide = 1");
                        if (is_array($q)) {
                            $hidecats = array();
                            foreach($q AS $hidden) {
                                $hidecats[] = $hidden['categoryid'];
                            }
                            $hidecats = implode(';', $hidecats);
                        }
                        if (!empty($hidecats)) {
                            $hide_sql = serendipity_getMultiCategoriesSQL($hidecats, true);
                            $conds[] = $hide_sql;
                        }
                        */

                        /*
                        $addkeys[] = "SUM(ctpass.hide) AS cat_hide, ";
                        // Reuse password join if possible
                        if (count($joins) == 0) {
                            $joins[] = "LEFT OUTER JOIN {$serendipity['dbPrefix']}categorytemplates AS ctpass
                                ON (ec.categoryid = ctpass.categoryid)\n";
                        }
                        //$conds[] = "(cat_hide IS NULL OR cat_hide < 1)";
                        //$conds[] = "(ctpass.hide IS NULL OR ctpass.hide = 0)";
                        //$conds[] = "(SUM(ctpass.hide < 1))";
                        $havings[] = '(cat_hide IS NULL OR cat_hide < 1)';
                        */
                    }

                    // Apply query additions
                    // Select keys
                    if (count($addkeys) > 0) {
                        $cond = implode("\n", $addkeys);
                        if (empty($eventData['select'])) {
                            $eventData['addkey'] = $cond;
                        } else {
                            $eventData['addkey'] .= $cond;
                        }
                    }
                    // Conditions
                    if (count($conds) > 0) {
                        $cond = count($conds) > 1 ? '(' .implode(' AND ', $conds) .')' : implode(' AND ', $conds);
                        if (empty($eventData['and'])) {
                            $eventData['and'] = " WHERE $cond ";
                        } else {
                            $eventData['and'] .= " AND $cond ";
                        }
                    }
                    // Joins
                    if (count($joins) > 0) {
                        $cond = implode("\n", $joins);
                        if (empty($eventData['joins'])) {
                            $eventData['joins'] = $cond;
                        } else {
                            $eventData['joins'] .= $cond;
                        }
                    }
                    // Havings
                    if (count($havings) > 0) {
                        $cond = implode(' AND ', $havings);
                        if (empty($eventData['having'])) {
                            $eventData['having'] =  "HAVING $cond ";
                        } else {
                            $eventData['having'] .= " AND $cond ";
                        }
                    }
                    break;
/*
                // EXPERIMENTAL CODE: fetch language for entry (:: maybe wrong hook..?)
                case 'frontend_configure':
                    // TODO: This does not work. The ID is not present! :-()
                    // $cid = $this->getID(true);
                    // $serendipity['lang'] = $this->fetchLang($cid, $serendipity['lang']);
                    break;
*/
                // When the HTML is generated, apply properties
                case 'genpage':
                    // Get the category in question
                    $cid = $this->getID();

                    if ($cid !== 'default') {
                        $fc  = $this->get_config('fixcat', 'false');
                        if ((string)$fc === 'hard') {
                            $fc = 'true';
                        }
                        if (serendipity_db_bool($fc)) {
                            // Need this for category_name to be set.  (?)
                            $serendipity['GET']['category'] = $cid;
                            header('X-FixEntry-Cat: true');
                        }

                        // Reset s9y to use the category's properties
                        $serendipity['fetchLimit']        = $this->fetchLimit($cid, $serendipity['fetchLimit']);
                        $serendipity['showFutureEntries'] = $this->fetchFuture($cid, $serendipity['showFutureEntries']);
                        $serendipity['template']          = $this->fetchTemplate($cid, $serendipity['template']); // here $this->usesDefaultTemplate gets defined
                        $this->sort_order                 = $this->fetchSortOrder($cid, $this->get_config('sort_order'));

                        // Fetch an engine template if set
                        $infofile = $serendipity['serendipityPath'] . $serendipity['templatePath'] . $serendipity['template'] . '/info.txt';
                        $serendipity['template_engine'] = $this->getFallbackEngineChain($infofile); // This is a need for the correct fallback chain

                        // Set the template options
                        if (!$this->usesDefaultTemplate) {
                            $serendipity['smarty_vars']['template_option'] = $serendipity['template'] . '_' . $cid;
                        }

                        // Check for password
                        if (serendipity_db_bool($this->get_config('pass')) && $this->fetchProp($cid, 'pass') != '') {

                            if (!isset($_SERVER['PHP_AUTH_PW']) || $_SERVER['PHP_AUTH_PW'] != $this->fetchProp($cid, 'pass')) {
                                header('WWW-Authenticate: Basic realm="' . PLUGIN_CATEGORYTEMPLATES_PASS_USER . '"');
                                header("HTTP/1.0 401 Unauthorized");
                                header('Status: 401 Unauthorized');
                                echo PLUGIN_CATEGORYTEMPLATES_PASS_USER;
                                exit;
                            } else {
                                $this->current_pw = $_SERVER['PHP_AUTH_PW'];
                            }
                        }

                        // Set the template stylesheet
                        if (!$this->usesDefaultTemplate) {
                            $serendipity['smarty_vars']['head_link_stylesheet'] = serendipity_rewriteURL('plugin/ct' . $serendipity['template'] . '_' . $cid);
                        }
                    }
                    break;

                // When the back end is displayed, use the custom template, too
                case 'backend_sidebar_entries_event_display_cattemplate':
                    if (empty($serendipity['GET']['cat_template'])) {
                        $serendipity['GET']['cat_template'] = $serendipity['POST']['cat_template'];
                    }

                    if (empty($serendipity['GET']['catid'])) {
                        $serendipity['GET']['catid'] = $serendipity['POST']['catid'];
                    }

                    $old = $serendipity['GET']['adminModule'];
                    $serendipity['GET']['adminModule'] = 'templates';
                    $this->template_options($serendipity['GET']['cat_template'], $serendipity['GET']['catid']);
                    $serendipity['GET']['adminModule'] = $old;
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

class categorytemplate_option
{
    var $config = null;
    var $values = null;
    var $keys   = null;

    public function introspect_config_item($item, &$bag)
    {
        foreach($this->config[$item] AS $key => $val) {
            $bag->add($key, $val);
        }
    }

    public function get_config($item)
    {
        return $this->values[$item];
    }

    public static function set_config($item, $value, $okey = '')
    {
        global $serendipity;

        serendipity_db_query("DELETE FROM {$serendipity['dbPrefix']}options
                               WHERE okey = 't_" . serendipity_db_escape_string($okey) . "'
                                 AND name = '" . serendipity_db_escape_string($item) . "'");
        serendipity_db_query("INSERT INTO {$serendipity['dbPrefix']}options (name, value, okey)
                                   VALUES ('" . serendipity_db_escape_string($item) . "', '" . serendipity_db_escape_string($value) . "', 't_" . serendipity_db_escape_string($okey) . "')");
        return true;
    }

    public function import(&$config)
    {
        foreach($config AS $key => $item) {
            $this->config[$item['var']] = $item;
            $this->keys[$item['var']]   = $item['var'];
        }
    }

}

/* vim: set ts=4 sts=4 sw=4 expandtab: */
?>