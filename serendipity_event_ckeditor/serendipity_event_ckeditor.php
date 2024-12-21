<?php

if (IN_serendipity !== true) {
    die ("Don't hack!");
}

@serendipity_plugin_api::load_language(dirname(__FILE__));

/**
 * Class member instance attribute values
 * Members must be initialized with a constant expression (like a string constant, numeric literal, etc), not a dynamic expression!
 */
if (!defined('CKEDITOR_DIRNAME_PLUGIN_PATH')) define('CKEDITOR_DIRNAME_PLUGIN_PATH', dirname(__FILE__));
if (!defined('CKEDITOR_DIRNAME_CKEDITOR_PATH')) define('CKEDITOR_DIRNAME_CKEDITOR_PATH', dirname(__FILE__) . '/ckeditor');

class serendipity_event_ckeditor extends serendipity_event
{
    /**
     * Access property title
     * Since already used in class serendipity_event extends serendipity_plugin this needs to be public
     * @access public
     * @var string
     */
    public $title = PLUGIN_EVENT_CKEDITOR_NAME;

    /**
     * Access property cke_path
     * @access protected
     * @var string
     */
    protected $cke_path = CKEDITOR_DIRNAME_PLUGIN_PATH;

    /**
     * Access property cke_dir
     * @access protected
     * @var string
     */
    protected $cke_dir = CKEDITOR_DIRNAME_CKEDITOR_PATH;

    /**
     * Access property forceZipInstall
     * @access protected
     * @var bool
     */
    protected $forceZipInstall = false;

    /**
     * Access property cke_zipfile
     * @access protected
     * @var string
     */
    protected $cke_zipfile = 'ckeditor_4.22.1.0-plus.zip';

    /**
     * Access property checkUpdateVersion
     * Is zip file version and is independent from plugin version string
     * Verify release package versions - do update on upgrades!
     * @var array
     */
    protected $checkUpdateVersion = array('ckeditor:4.22.1.0');

    /**
     * Access property revisionPackage
     * Note revisions of ckeditor and plugin additions to lang files
     * @var array
     */
    protected $revisionPackage = array('CKEditor 4.22.1 (revision 4a1fb11f44, full package, 2023-07-05)',
                                       'CKEditor-Plugin: mediaembed, included to custom build. v. 0.6 (https://github.com/frozeman/MediaEmbed, 2013-07-11)',
                                       'CKEditor-Plugin: Custom build added for current version "ajax", "autocomplete", "autogrow", "autolink", "button", "clipboard", "dialog", "dialogui", "embedbase", "emoji", "fakeobjects", "floatpanel", "lineutils", "notification", "notificationaggregator", "panelbutton", "placeholder", "textmatch", "textwatcher", "undo", "widget", "widgetselection" and "xml" plugins, 2023-07-05)',
                                       'CKEditor-Plugin: Manually added for current version "codesnippet", "embed" and "embedsemantic" plugins, 2023-07-05)',
                                       'CKEditor-Plugin: procurator, v. 1.7 (Serendipity placeholder Plugin, 2019-11-24)',
                                       'CKEditor-Plugin: cheatsheet, v. 1.3 (Serendipity CKE-Cheatsheet Plugin, 2019-07-03)',
                                       'CKEditor-S9yCustomConfig, cke_config.js, v. 2.27, 2023-07-15',
                                       'CKEditor-S9yCustomPlugins, cke_plugin.js, v. 1.20, 2021-11-05',
                                       'CKEditor-S9yAddOn, fresh highlight.min.js file v11.6.0 (https://highlightjs.org/) as from 2022-07-13 and github styles in highlight.min.css as from 2021-05-15',
                                       'Prettify: JS & CSS files, v. "current", (http://code.google.com/p/google-code-prettify/, 2013-03-04)');


    function install()
    {
        global $serendipity;

        if (!$serendipity['serendipityUserlevel'] >= USERLEVEL_ADMIN) {
            return false;
        }
        // do we have it already?
        if (!$this->forceZipInstall && is_dir($this->cke_dir) && is_file($this->cke_dir . '/ckeditor.js')) {
            // this is running while getting a new Plugin version
            if ($this->checkUpdate()) {
                $this->set_config('installer', '4-'.date('Ymd-H:i:s')); // this is a faked debug notice, since falldown is extract true with case 0, 1 or 2
                // continue
            } else {
                $this->set_config('installer', '3-'.date('Ymd-H:i:s')); // this will happen, if no further extract is necessary in case of an update - follow install or upgrade routines
                return false;
            }
        }

        if (!extension_loaded('zip')) {
            trigger_error(' ZIP extension has not been compiled or loaded in PHP.', E_USER_WARNING);
            return;
        }

        if (is_writable($this->cke_path)) {
            $zip = new ZipArchive;
            if ($zip->open($this->cke_path . '/' . $this->cke_zipfile) === true) {
                $zip->extractTo($this->cke_path);
                $zip->close();
                $this->set_config('installer', '2-'.date('Ymd-H:i:s')); // returned by string[0], which is better than substr in this case
                $is_update = false;
                // Check to remove every old ckeditor_(*)-plus.zip files - checked by partial string "-plus"
                foreach (glob($this->cke_path . '/*.zip') AS $filename) {
                    if ($this->cke_path . '/' . $this->cke_zipfile != $filename && (false !== strpos($filename, '-plus')) ) {
                        @unlink($filename);
                        $is_update = true;
                    }
                }
                if ($is_update) {
                    // purge removed files for upgraders to ckeditor v. 4.2 only
                    @unlink($this->cke_path . '/ckeditor/build_config.js');
                    @unlink($this->cke_path . '/ckeditor/skins/moono/images/mini.png');
                    // purge  removed files for upgraders to ckeditor >= v. 4.4.4 only
                    @unlink($this->cke_path . '/UTF-8/documentation_cz.html');
                    @unlink($this->cke_path . '/UTF-8/lang_en.inc.php');
                    @unlink($this->cke_path . '/UTF-8/documentation_cs.html');
                    // purge accidentally added Thumbs.db file with 4.5.8.0/1 throwing errors on unzip
                    @unlink($this->cke_path . '/ckeditor/plugins/codesnippet/icons/hidpi/Thumbs.db');
                    @unlink($this->cke_path . '/ckeditor/plugins/procurator/images/Thumbs.db');
                    // purge replaced by basic_toolbar.css, or removed files, since now requires 2.0+ only
                    @unlink($this->cke_path . '/basic_toolbar1.css');
                    @unlink($this->cke_path . '/basic_toolbar2.css');
                    @unlink($this->cke_path . '/cke_olds9y.css');
                    // purge up from 4.16.1.5
                    @unlink($this->cke_path . '/ckeditor/CHANGES.md');
                    @unlink($this->cke_path . '/ckeditor/README.md');
                }
                // remove flash plugin directory
                if (is_file(dirname(__FILE__) . '/ckeditor/plugins/flash/dialogs/flash.js')) {
                    $this->empty_dir(dirname(__FILE__) . '/ckeditor/plugins/flash');
                    @rmdir(dirname(__FILE__) . '/ckeditor/plugins/flash');
                }
                // remove widget/dev samples directory
                if (is_file(dirname(__FILE__) . '/ckeditor/plugins/widget/dev/console.js')) {
                    $this->empty_dir(dirname(__FILE__) . '/ckeditor/widget/dev');
                    @rmdir(dirname(__FILE__) . '/ckeditor/widget/dev');
                }
                // remove lineutils/dev samples directory
                if (is_file(dirname(__FILE__) . '/ckeditor/plugins/lineutils/dev/dnd.html')) {
                    $this->empty_dir(dirname(__FILE__) . '/ckeditor/plugins/lineutils/dev');
                    @rmdir(dirname(__FILE__) . '/ckeditor/plugins/lineutils/dev');
                }
                // remove usused placeholder plugin
                if (is_file(dirname(__FILE__) . '/ckeditor/plugins/placeholder/plugin.js')) {
                    $this->empty_dir(dirname(__FILE__) . '/ckeditor/plugins/placeholder');
                    @rmdir(dirname(__FILE__) . '/ckeditor/plugins/placeholder');
                }
                // remove code button plugin pbckcode
                if (is_file(dirname(__FILE__) . '/ckeditor/plugins/pbckcode/plugin.js')) {
                    $this->empty_dir(dirname(__FILE__) . '/ckeditor/plugins/pbckcode');
                    @rmdir(dirname(__FILE__) . '/ckeditor/plugins/pbckcode');
                }
                // remove kcfinder instance
                if (is_file(dirname(__FILE__) . '/kcfinder/config.php')) {
                    $this->empty_dir(dirname(__FILE__) . '/kcfinder');
                    @rmdir(dirname(__FILE__) . '/kcfinder');
                    unset($_COOKIE['KCFINDER_uploadurl']);
                    unset($_COOKIE['KCFINDER_displaySettings']);
                    unset($_COOKIE['KCFINDER_showname']);
                    unset($_COOKIE['KCFINDER_showsize']);
                    unset($_COOKIE['KCFINDER_showtime']);
                    unset($_COOKIE['KCFINDER_order']);
                    unset($_COOKIE['KCFINDER_orderDesc']);
                    unset($_COOKIE['KCFINDER_view']);
                }
                // remove all additional plugins which are now build in (customized) and don't need to be configurable
                $rips = ['ajax', 'autogrow', 'autolink', 'button', 'fakeobjects', 'floatpanel', 'lineutils', 'mediaembed', 'notification', 'notificationaggregator', 'panelbutton', 'textmatch', 'textwatcher', 'toolbar', 'undo', 'widgetselection', 'xml'];
                $this->cleanupAddOns($rips);
                // extracted, continue to set this version into config
            } else {
                $this->set_config('installer', '1-'.date('Ymd-H:i:s'));
                return false;
            }
        } else {
            $this->set_config('installer', '0-'.date('Ymd-H:i:s')); // do it again, Sam
            return false;
        }
        // Extraction found true, add the new version string to configs last_ckeditor_version
        $this->updateConfig();
        return true;
    }

    function uninstall(&$propbag)
    {
        // todo? uninstall old instances which may be in there, caused by a duplicating bug using installer fallback without right instance, in 2.3.2 (though, was for one day online only)
    }

    function introspect(&$propbag)
    {
        global $serendipity;

        $propbag->add('name',          PLUGIN_EVENT_CKEDITOR_NAME);
        $propbag->add('description',   PLUGIN_EVENT_CKEDITOR_DESC);
        $propbag->add('stackable',     false);
        $propbag->add('author',        'Rustam Abdullaev, Ian Styx');
        $propbag->add('version',       '4.22.1.2'); // is CKEDITOR Series 4.22.1 - and appended plugin revision .2
        $propbag->add('copyright',     'GPL or LGPL License');
        $propbag->add('requirements',  array(
            'serendipity' => '2.6.2',
            'smarty'      => '3.1.13',
            'php'         => '7.0.0'
        ));

        $propbag->add('event_hooks',   array(
            'frontend_header'                        => true,
            'frontend_footer'                        => true,
            'backend_header'                         => true,
            'js_backend'                             => true,
            'css'                                    => true,
            'css_backend'                            => true,
            'external_plugin'                        => true,
            'backend_plugins_update'                 => true,
            'backend_media_path_exclude_directories' => true,
            'backend_wysiwyg'                        => true,
            'backend_wysiwyg_finish'                 => true
        ));
        $propbag->add('configuration', array('path', 'plugpath', 'codebutton', 'prettify', 'oembed', 'oembed_type', 'acf_off', 'toolbar', 'ibn_off', 'toolbar_break', 'force_install', 'timestamp'));
        $propbag->add('groups', array('BACKEND_EDITOR'));
        $propbag->add('legal',         array(
            'services' => array(),
            'frontend' => array(
            ),
            'backend' => array(
                'If enabled, some plugins used by the CKEditor library (wsc/scayt and embed/embedbase/embedsemantic) use external services for web spell checking, and iframed proxy services. These may receive metadata.',
            ),
            'cookies' => array(
            ),
            'stores_user_input'     => false,
            'stores_ip'             => false,
            'uses_ip'               => false,
            'transmits_user_input'  => false
        ));
    }

    function introspect_config_item($name, &$propbag)
    {
        global $serendipity;

        switch($name) {
            case 'path':
                $propbag->add('type', 'string');
                $propbag->add('name', INSTALL_RELPATH);
                $propbag->add('description', PLUGIN_EVENT_CKEDITOR_OPTION_DESC . '"plugins/serendipity_event_ckeditor/ckeditor/"');
                $propbag->add('default', 'plugins/serendipity_event_ckeditor/ckeditor/');
                break;

            case 'plugpath':
                $propbag->add('type', 'string');
                $propbag->add('name', PLUGIN_EVENT_CKEDITOR_INSTALL_PLUGPATH);
                $propbag->add('description', PLUGIN_EVENT_CKEDITOR_OPTION_DESC . '"' . $serendipity['serendipityHTTPPath'] . 'plugins/"');
                $propbag->add('default', $serendipity['serendipityHTTPPath'] . 'plugins/');
                break;

            case 'codebutton':
                $propbag->add('type', 'boolean');
                $propbag->add('name', PLUGIN_EVENT_CKEDITOR_CODEBUTTON_OPTION);
                $propbag->add('description', '');
                $propbag->add('default', 'false');
                break;

            case 'prettify':
                $propbag->add('type', 'boolean');
                $propbag->add('name', PLUGIN_EVENT_CKEDITOR_PRETTIFY_OPTION);
                $propbag->add('description', PLUGIN_EVENT_CKEDITOR_PRETTIFY_OPTION_DESC);
                $propbag->add('default', 'false');
                break;

            case 'oembed':
                $propbag->add('type', 'boolean');
                $propbag->add('name', PLUGIN_EVENT_CKEDITOR_OEMBED_OPTION);
                $propbag->add('description', PLUGIN_EVENT_CKEDITOR_OEMBED_OPTION_DESC);
                $propbag->add('default', 'false');
                break;

            case 'oembed_type':
                $propbag->add('type', 'radio');
                $propbag->add('name', PLUGIN_EVENT_CKEDITOR_OEMBEDTYPE_OPTION);
                $propbag->add('description', PLUGIN_EVENT_CKEDITOR_OEMBEDTYPE_OPTION_DESC);
                $propbag->add('radio',  array(
                                            'value' => array('markup', 'semantic'),
                                            'desc'  => array(PLUGIN_EVENT_CKEDITOR_OEMBEDTYPE_MARKUP_OPTION, PLUGIN_EVENT_CKEDITOR_OEMBEDTYPE_SEMANTIC_OPTION)
                                        ));
                $propbag->add('default', 'markup');
                break;

            case 'acf_off':
                $propbag->add('type', 'boolean');
                $propbag->add('name', PLUGIN_EVENT_CKEDITOR_CKEACF_OPTION);
                $propbag->add('description', PLUGIN_EVENT_CKEDITOR_CKEACF_OPTION_DESC);
                $propbag->add('default', 'false');
                break;

            case 'toolbar':
                $select = array();
                $select["Standard"] = 'STANDARD';
                $select["Basic"]    = 'BASIC';
                $select["Full"]     = 'FULL';
                $propbag->add('type', 'select');
                $propbag->add('name', PLUGIN_EVENT_CKEDITOR_SETTOOLBAR_OPTION);
                $propbag->add('description', '');
                $propbag->add('select_values', $select);
                $propbag->add('default', 'Standard');
                break;

            case 'ibn_off':
                $propbag->add('type', 'boolean');
                $propbag->add('name', PLUGIN_EVENT_CKEDITOR_CKEIBN_OPTION);
                $propbag->add('description', PLUGIN_EVENT_CKEDITOR_CKEIBN_OPTION_DESC);
                $propbag->add('default', 'true');
                break;

            case 'toolbar_break':
                $propbag->add('type', 'boolean');
                $propbag->add('name', PLUGIN_EVENT_CKEDITOR_TOOLBAR_OPTION);
                $propbag->add('description', '');
                $propbag->add('default', 'true');
                break;

            case 'force_install':
                $propbag->add('type', 'boolean');
                $propbag->add('name', PLUGIN_EVENT_CKEDITOR_FORCEINSTALL_OPTION);
                $propbag->add('description', PLUGIN_EVENT_CKEDITOR_FORCEINSTALL_OPTION_DESC . $this->cke_zipfile);
                $propbag->add('default', 'false');
                break;

            case 'timestamp':
                $propbag->add('type', 'hidden');
                $propbag->add('value', time());
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

    function example()
    {
        global $serendipity;

        $s = '';
        if (serendipity_db_bool($this->get_config('force_install'))) {
            $this->forceZipInstall = true;
            $this->install();
            $this->forceZipInstall = false;
            $this->set_config('force_install', 'false');
            // forceZipInstall forces to surround the checkUpdate function, thus we set config database table to keep track
            $this->updateConfig();
            $s .= '<p class="msg_success"><span class="icon-ok" aria-hidden="true"></span> ' . sprintf(PLUGIN_EVENT_CKEDITOR_INSTALLER_DEFLATEDONE, $serendipity['baseURL'] . 'serendipity_admin.php?serendipity[adminModule]=plugins&serendipity[plugin_to_conf]='.urlencode($this->instance)) . '</p>';
        }

        $installer = $this->get_config('installer'); // Can't use method return value in write context in '' with substr(), get_config() and isset()
        $parts     = explode(':', $this->checkUpdateVersion[0]); // this is ckeditor only

        $s .= '<span class="msg_notice"><span class="icon-attention-circled" aria-hidden="true"></span> ' . PLUGIN_EVENT_CKEDITOR_OPHANDLER . "</span>\n";
        $s .= PLUGIN_EVENT_CKEDITOR_REVISION_TITLE;
        $s .= "\n<ul class=\"cke_revpack\">\n";
        // hook this as a scalar value into this plugins lang files (would be needed by adding this to a constant)
        foreach( $this->revisionPackage AS $revision ) {
            $s .= '    <li>' . $revision . "</li>\n";
        }
        $s .= "</ul>\n\n";

        if (!empty($installer)) {
            switch ($installer[0]) {
                case '4': // this probably won't ever happen, since case 2 is true - just a fake
                    $s .= '<p class="msg_notice"><span class="icon-attention" aria-hidden="true"></span> ' . sprintf(PLUGIN_EVENT_CKEDITOR_INSTALLER_MSG4, $parts[0], $parts[1]) . '</p>';
                    break;
                case '3':
                    $s .= '<p class="msg_success"><span class="icon-ok" aria-hidden="true"></span> ' . PLUGIN_EVENT_CKEDITOR_INSTALLER_MSG3 . '</p>';
                    break;
                case '2':
                    $s .= '<p class="msg_success"><span class="icon-ok" aria-hidden="true"></span> ' . sprintf(PLUGIN_EVENT_CKEDITOR_INSTALLER_MSG2, $this->cke_path) . '</p>';
                    break;
                case '1':
                    $s .= '<p class="msg_error"><span class="icon-error" aria-hidden="true"></span> ' . sprintf(PLUGIN_EVENT_CKEDITOR_INSTALLER_MSG1, $this->cke_path, $this->cke_zipfile) . '</p>';
                    break;
                case '0':
                    $s .= '<p class="msg_error"><span class="icon-error" aria-hidden="true"></span> ' . sprintf(PLUGIN_EVENT_CKEDITOR_INSTALLER_MSG0, $this->cke_path, $this->cke_zipfile) . '</p>';
                    break;
            }
            $this->set_config('installer', ''); // set empty and remove it
            serendipity_plugin_api::remove_plugin_value($this->instance, array('installer')); // with gc cleanup
        }
        $s .= PLUGIN_EVENT_CKEDITOR_INSTALL;
        $s .= PLUGIN_EVENT_CKEDITOR_CONFIG;
        $s .= PLUGIN_EVENT_CKEDITOR_SCAYT;
        return $s;
    }

    /**
     * Remove a list of all additional plugins which are now build into the (customized) ckeditor.js file
     * and do not need to be explicitly configurable by this CKEplus plugin
     */
    private function cleanupAddOns($plugins=array())
    {
        foreach ($plugins AS $plugin) {
            if (is_file(dirname(__FILE__) . "/ckeditor/plugins/$plugin/plugin.js")) {
                $this->empty_dir(dirname(__FILE__) . "/ckeditor/plugins/$plugin");
                @rmdir(dirname(__FILE__) . "/ckeditor/plugins/$plugin");
            }
        }
    }

    /**
     * Downgrade of version to keep plugin version track with CKE versioning for upcoming next major upgrades!
     * This method is temporary only!
     * @see updateConfig()
     * @see checkUpdate()
     */
    private function temporaryDowngrade($newVersion, $oldVersion)
    {
        global $serendipity;

        $thisclass = serendipity_db_escape_string('serendipity_event_ckeditor');
        $row = serendipity_db_query("SELECT version FROM {$serendipity['dbPrefix']}pluginlist
                                      WHERE plugin_class = '" . $thisclass . "'
                                        AND pluginlocation = 'local'
                                      LIMIT 1", true, 'assoc');

        $versions = array($oldVersion, $newVersion); // keep prior and current versions false check
        if (in_array($row['version'], $versions)) {
            return false;
        }

        serendipity_db_query("UPDATE {$serendipity['dbPrefix']}pluginlist
                                 SET version      = '" . serendipity_db_escape_string($oldVersion) . "'
                               WHERE plugin_class = '" . $thisclass . "'
                                 AND pluginlocation = 'local'");
        serendipity_db_query("UPDATE {$serendipity['dbPrefix']}pluginlist
                                 SET upgrade_version = '" . serendipity_db_escape_string($newVersion) . "'
                               WHERE plugin_class    = '" . $thisclass . "'
                                 AND pluginlocation = 'local'");
    }

    /**
     * Set config database table to keep track to zip update versions
     * @access    private
     */
    private function updateConfig()
    {
        #$this->temporaryDowngrade('4.22.1.2', '4.22.1.1'); // was temporary used for the harmonization of plugin and lib versions
        foreach(array_values($this->checkUpdateVersion) AS $package) {
            $match = explode(':', $package);
            $this->set_config('last_'.$match[0].'_version', $match[1]);
        }
    }

    /**
     * Check update versions to perform unzip and create config values
     * @access    private
     * @return    boolean
     */
    private function checkUpdate()
    {
        #$this->temporaryDowngrade('4.22.1.2', '4.22.1.1'); // was temporary used for the harmonization of plugin and lib versions
        $doupdate = false;
        foreach(array_values($this->checkUpdateVersion) AS $package) {
            $match = explode(':', $package);
            // always set and extract if not match
            if ($this->get_config('last_'.$match[0].'_version') == $match[1]) {
                $doupdate = false;
            } else {
                $doupdate = true;
                break; // this is probably needed to force install upgrade routines
            }
        }
        return $doupdate;
    }

    /**
     * empty a directory using the Standard PHP Library (SPL) iterator
     * @access    private
     * @param   string directory
     */
    private function empty_dir($dir)
    {
        if (!is_dir($dir)) return;
        try {
            $_dir = new RecursiveDirectoryIterator($dir);
            // NOTE: UnexpectedValueException thrown for PHP >= 5.3
            } catch (\Throwable $t) {
                return;
            }
        $iterator = new RecursiveIteratorIterator($_dir, RecursiveIteratorIterator::CHILD_FIRST);
        foreach ($iterator AS $file) {
            if ($file->isFile()) {
                @unlink($file->__toString());
            } else {
                @rmdir($file->__toString());
            }
        }
        @rmdir($dir);
    }

    function event_hook($event, &$bag, &$eventData, $addData = null)
    {
        global $serendipity;

        $hooks = &$bag->get('event_hooks');

        if (isset($hooks[$event])) {

            switch($event) {

                case 'frontend_header':
                    $headcss = true;
                case 'frontend_footer':
                    if (!isset($headcss)) $headcss = false;
                    // set prettify.css and prettify.js in frontend footer by plugin option (too much overhead to split this into head css and food js!)
                    if (serendipity_db_bool($this->get_config('codebutton', false))) {
                        $plugingpath = function_exists('serendipity_specialchars') ? serendipity_specialchars($this->get_config('plugpath')) : htmlspecialchars($this->get_config('plugpath'), ENT_COMPAT, LANG_CHARSET);
                        if (version_compare($serendipity['version'], '3.1-alpha1', '<')) {
                             if (!empty($headcss) && $headcss) {
?>
    <link rel="stylesheet" href="<?php echo $plugingpath . 'serendipity_event_ckeditor/highlight.min.css'; ?>" />
<?php
                            } else {
?>
    <script src="<?php echo $plugingpath . 'serendipity_event_ckeditor/highlight.min.js'; ?>"></script>
    <script>
        // launch the codesnippet highlight
        hljs.configure({
          tabReplace: '    ', // 4 spaces
        });
        hljs.initHighlightingOnLoad();
    </script>
<?php
                            }
                        }
                        if (serendipity_db_bool($this->get_config('prettify', false))) {
                            if (!empty($headcss) && $headcss) {
?>
    <link rel="stylesheet" type="text/css" href="<?php echo $plugingpath . 'serendipity_event_ckeditor/prettify.css'; ?>" />
<?php
                            } else {
?>
    <script type="text/javascript" src="<?php echo $plugingpath . 'serendipity_event_ckeditor/prettify.js'; ?>"></script>
    <script>
    jQuery(function($) {
        // launch the prettify code
        prettyPrint();
    });
    </script>
<?php
                            }
                        }
                    }
                    break;

                case 'js_backend':
                    $pastejs = true;
                case 'backend_header':
                    if (!isset($pastejs)) $pastejs = false;
                    if (isset($serendipity['wysiwyg']) && $serendipity['wysiwyg'] && isset($eventData) && !isset($_GET['serendipity']['iframe_mode'])) {
                        // both cases
                        $relpath = function_exists('serendipity_specialchars') ? serendipity_specialchars($this->get_config('path')) : htmlspecialchars($this->get_config('path'), ENT_COMPAT, LANG_CHARSET);
                        $plgpath = function_exists('serendipity_specialchars') ? serendipity_specialchars($this->get_config('plugpath')) : htmlspecialchars($this->get_config('plugpath'), ENT_COMPAT, LANG_CHARSET);
                        $toolbar = $this->get_config('toolbar', 'Standard');
                        // js_backend case
                        if ($pastejs) {
                            // Check, if Styx-Serendipity 2.1 changed WYSIWYG_LANG constant already is defined,
                            // which changed 2-letter or "**-utf" marked langs eg. "en" to "en_US", using the POSIX underscore standard,
                            // else workaround using DATE_LOCALES.
                            if (defined('DATE_LOCALES') && (false !== strpos('_', WYSIWYG_LANG))) {
                                // scayt available langs are ('en_US', 'en_GB', 'pt_BR', 'da_DK', 'nl_NL', 'en_CA', 'fi_FI', 'fr_FR', 'fr_CA', 'de_DE', 'el_GR', 'it_IT', 'la_VA', 'nb_NO', 'pt_PT', 'es_ES', 'sv_SE');
                                $locale  = explode(',', DATE_LOCALES); // get the current defined locales as array
                                $special = array('Arabic', 'bulgarian', 'pl.UTF-8', 'tw'); // special lang exceptions which have them at last position
                                if (in_array($locale[0], $special)) {
                                    $slocale = @strtok(end($locale), "."); // strtok dot fixes 'ar_SA.windows-1256'
                                    @reset($locale);
                                }
                                $_locale = trim(isset($slocale) ? $slocale : $locale[0]); // set the current lang locale as string
                                if (!empty($_locale)) {
                                    $flocale = explode('.', $_locale); // $flocale array is the first defined 4-letter lang locale, eg "de_DE".
                                    if ($flocale[0] == 'nl_BE') $flocale[0] = 'nl_NL'; // case locale Nederlands / België set back to Dutch (Netherlands)
                                    if ($flocale[0] == 'sv_SV') $flocale[0] = 'sv_SE'; // case Swedish set back to Swedish (Sweden)
                                }
                            }
                            $acf_off = serendipity_db_bool($this->get_config('acf_off', 'false')) ? 'true' : 'false';    // need this, to be passed correctly as boolean true/false to custom cke_config.js
                            $code_on = serendipity_db_bool($this->get_config('codebutton', 'false')) ? 'true' : 'false'; // same here for cke_plugins.js
                            $oembed  = serendipity_db_bool($this->get_config('oembed', 'false'));
                            $oetype  = $this->get_config('oembed_type', 'semantic');
                            $oembed1 = ($oembed && $oetype == 'markup') ? 'true' : 'false';
                            $oembed2 = ($oembed && $oetype == 'semantic') ? 'true' : 'false';
                            $uats_on = $serendipity['use_autosave'] ? 'true' : 'false';                                  // dito
                            $time    = $this->get_config('timestamp', time());
                            $slang   = (isset($flocale) && !empty($flocale[0]) ? $flocale[0] : WYSIWYG_LANG); // set scayt locales 4-letter POSIX lang or fall back
                            $lang    = $slang ? $slang : 'en_US'; // use new WYSIWYG_LANG, or the workaround locale, or fall back to default
                            $lang    = str_replace('_', '-', $lang); // change to IETF standard unicode language tag, using a dash
                            /*
                                Define some global CKEDITOR plugin startup vars
                                Include the ckeditor
                                Build dynamic plugins and set the custom config (cke_config.js)
                            */
?>

/* serendipity_event_ckeditor start */

// define CKE PLUS constants
CKEDITOR_BASEPATH       = '<?php echo $relpath; ?>';
CKEDITOR_PLUGPATH       = '<?php echo $plgpath; ?>';
CKECONFIG_ACF_OFF       = <?php echo $acf_off; ?>;
CKECONFIG_CODE_ON       = <?php echo $code_on; ?>;
CKECONFIG_OEMBED_ON     = <?php echo $oembed1; ?>;
CKECONFIG_OEMBED_SMT_ON = <?php echo $oembed2; ?>;
CKECONFIG_LANG          = '<?php echo $lang; ?>'; // as IETF
CKECONFIG_SLANG         = '<?php echo $slang; ?>'; // as POSIX
CKECONFIG_TOOLBAR       = '<?php echo $toolbar; ?>';
CKECONFIG_TOOLBAR_BREAK = <?php echo serendipity_db_bool($this->get_config('toolbar_break', 'false')) ? "'/'" : "''"; ?>;
CKECONFIG_FORCE_LOAD    = <?php echo $time; ?>;
CKECONFIG_USEAUTOSAVE   = <?php echo $uats_on; ?>;

/* serendipity_event_ckeditor end */
<?php
                        } else { //'backend_header' case
?>
    <script src="<?php echo $serendipity['serendipityHTTPPath'] . $relpath; ?>ckeditor.js"></script>
    <script src="<?php echo $plgpath . 'serendipity_event_ckeditor/'; ?>cke_plugin.js"></script>
<?php
                            // sadly this can't be pushed into streamed css, since that is cached to lazyload.
                            if ($toolbar == 'Basic') {
?>
    <link rel="stylesheet" href="<?php echo $plgpath . 'serendipity_event_ckeditor/'; ?>basic_toolbar.css" />
<?php
                            } else { // case other toolbars
                                if (false === serendipity_db_bool($this->get_config('ibn_off', 'true')) ) {
?>
    <link rel="stylesheet" href="<?php echo $plgpath . 'serendipity_event_ckeditor/'; ?>cke_ibn.css" />
<?php
                                }
                            }
                        }
                    }
                    break;

                case 'css':
                    if (serendipity_db_bool($this->get_config('codebutton', false))) {

/* moved to highlight.css to prepend streamed css first (keep note!)

CKEDITOR CODESNIPPET PLUGIN
pre {
    word-wrap: inherit; fixes chrome issue
}
pre code {
    white-space: pre;
    overflow-x: auto;
}
.hljs {
    border-left: 5px solid #DDD;
}
*/
                        if (serendipity_db_bool($this->get_config('prettify', false))) {
                            ob_start();
?>

/* CKEDITOR PLUGIN PBCKCODE PRETTY PRINT */

.prettyprint {
    padding: 8px;
    background-color: #f7f7f9;
    border: 1px solid #e1e1e8;
}
.prettyprint.linenums {
    -webkit-box-shadow: inset 40px 0 0 #fbfbfc, inset 41px 0 0 #ececf0;
       -moz-box-shadow: inset 40px 0 0 #fbfbfc, inset 41px 0 0 #ececf0;
            box-shadow: inset 40px 0 0 #fbfbfc, inset 41px 0 0 #ececf0;
}
.content ol {
    margin: 0px 0px 1em 2em;
}

<?php
    if ($serendipity['template'] == 'bulletproof') {
?>

.serendipity_entry ol.linenums {
    padding-left: 40px;
}

<?php
    }
?>

ol.linenums li {
    padding-left: 1em;
    color: #bebec5;
    line-height: 1.6;
    text-shadow: 0 1px 0 #fff;
}


<?php
                            $ckeplugin_frontpage_css = ob_get_contents();
                            ob_end_clean();

                            $eventData .= $ckeplugin_frontpage_css; // append CSS
                        }
                    }
                    break;

                case 'css_backend':

                    if (strpos($eventData, '.cke_config_block') === false) {
                        $eventData .= @file_get_contents(dirname(__FILE__) . '/cke_backend.css');
                    }
                    break;

                case 'external_plugin':
                    if ($eventData == 'triggerckeinstall') {
                        if (class_exists('serendipity_event_plugup')) {
                            serendipity_event_plugup::purge_plugupCookies();
                        }
                        if ($this->install()) {
                            header('Location: ' . $serendipity['baseURL'] . 'serendipity_admin.php?serendipity[adminModule]=plugins&serendipity[plugin_to_conf]='.urlencode($this->instance));
                        } else {
                            header('Location: ' . $serendipity['baseURL'] . 'serendipity_admin.php?serendipity[adminModule]=plugins&serendipity[plugin_to_conf]='.urlencode($this->instance));
                        }
                    }
                    break;

                case 'backend_plugins_update':
                    if ($eventData == 'serendipity_event_ckeditor' && !$serendipity['ajax']) {
                        // Make sure a Spartacus update really falls down into this plugins config.
                        // In case of using the UPDATE ALL 1-click ajax-upgrader, this redirection is disabled and you have to force the extraction yourself in the config.
                        // This needs a *REAL* new HTTP request! Using plugin_to_conf:instance (see above) would not do here!!
                        // A request to ...&serendipity[install_plugin]=serendipity_event_ckeditor would force a deflate, but would install another plugin instance!
                        header('Location: ' . $serendipity['baseURL'] . ($serendipity['rewrite'] == 'none' ? $serendipity['indexFile'] . '?/' : '') . 'plugin/triggerckeinstall');
                        // This runtime breakage will reset all other plugins waiting to UPGRADE back to their current version in table pluginlist.
                        // After this, the updater has to wait for a new read of the xml file(s) and to set pending plugins with setPluginInfo() method for versions and timestamp again.
                        // This is not what we want here! So we nuke the blog-servers xml file in templates_c to later on continue with pending plugin updates.
                        // Spartacus has to be prepared to set this global var (Styx with Spartacus v. 2.44 is ready). All other users probably have to wait up to 12h+.
                        @unlink($serendipity['spartacus_cachedXMLfile']);
                        die(); // now exit the runtime UPGRADE task executor, which forces to really halt into this->install() check redirector!
                    }
                    break;

                case 'backend_media_path_exclude_directories':
                    $eventData[".thumbs"] = true;
                    break;

                case 'backend_wysiwyg':
                    $eventData['skip'] = true; // this skips htmlarea drop-in

                    if (preg_match('@^nugget@i', $eventData['item'])) {
                        // switch to finisher, in case of nuggets
                        $this->event_hook('backend_wysiwyg_finish', $bag, $eventData);
                    } else {
                        // for case using customized toolbars, else it falls back to toolbar Group where 'others' is automatically added
                        $bid = array();
                        if (isset($eventData['buttons']) && (is_array($eventData['buttons']) && !empty($eventData['buttons']))) {
                            foreach ($eventData['buttons'] AS $bt) {
                                $bid[] = $bt['id'];
                            }
                        }
                        $addB = implode(',', $bid);
                        $addB = str_replace(',', '","', $addB);

                        // this builds both textareas of entry forms only
                        if (isset($eventData['item']) && !empty($eventData['item'])) {
                            $jebtnarr = (isset($eventData['buttons']) && (is_array($eventData['buttons']) && !empty($eventData['buttons']))) ? json_encode($eventData['buttons']) : 'null';
?>

<script type="text/javascript">
    if (typeof s9ypluginbuttons !== 'undefined') s9ypluginbuttons.push("<?php echo $addB; ?>");
    if (window.Spawnnuggets) Spawnnuggets('<?php echo $eventData['item']; ?>', 'entryforms<?php echo $eventData['jsname']; ?>', <?php echo $jebtnarr; ?>);
</script>
<?php
                        }
                    }
                    break;

                case 'backend_wysiwyg_finish':
                    // Run once only, save resources
                    // This should better move into a future(!) 'backend_footer' hook, to not happen for every of any multiple textareas!
                    // but there $eventData['item'] isn't available yet...
                    if (isset($eventData['item']) && !empty($eventData['item'])) {
                        if (isset($eventData['buttons']) && (is_array($eventData['buttons']) && !empty($eventData['buttons']))) {
                            // send eventData as json encoded array into the javascript stream, which can be pulled by 'backend_header' hooks global Spawnnuggets() nugget function
?>
    <script type="text/javascript">
        jsEventData = <?php echo json_encode($eventData['buttons']); ?>;
    </script>
<?php
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

?>