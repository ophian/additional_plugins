<?php

declare(strict_types=1);

if (IN_serendipity !== true) {
    die ("Don't hack!");
}

@serendipity_plugin_api::load_language(dirname(__FILE__));

class serendipity_event_linktrimmer extends serendipity_event
{
    /**
     * Access property title
     */
    public $title = PLUGIN_LINKTRIMMER_NAME;

    function introspect(&$propbag)
    {
        global $serendipity;

        $propbag->add('name',          PLUGIN_LINKTRIMMER_NAME);
        $propbag->add('description',   PLUGIN_LINKTRIMMER_DESC);
        $propbag->add('requirements',  array(
            'serendipity' => '5.0',
            'smarty'      => '4.1',
            'php'         => '8.2.0'
        ));

        $propbag->add('version',       '2.0.2');
        $propbag->add('author',        'Garvin Hicking, Ian Styx');
        $propbag->add('stackable',     false);
        $propbag->add('configuration', array('prefix', 'frontpage', 'domain'));
        $propbag->add('event_hooks',   array(
                                            'css_backend'                    => true,
                                            'frontend_configure'             => true,
                                            'backend_dashboard'              => true,
                                            'backend_entry_toolbar_extended' => true,
                                            'backend_entry_toolbar_body'     => true,
                                            'backend_wysiwyg'                => true,
                                            'external_plugin'                => true,

                                        )
        );
        $propbag->add('groups', array('BACKEND_FEATURES'));
    }

    function introspect_config_item($name, &$propbag)
    {
        global $serendipity;

        switch($name) {
            case 'prefix':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_LINKTRIMMER_LINKPREFIX);
                $propbag->add('description', PLUGIN_LINKTRIMMER_LINKPREFIX_DESC);
                $propbag->add('default',     'l');
                break;

            case 'frontpage':
                $propbag->add('type',        'boolean');
                $propbag->add('name',        PLUGIN_LINKTRIMMER_FRONTPAGE_OPTION);
                $propbag->add('description', '');
                $propbag->add('default',     'true');
                break;

            case 'domain':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_LINKTRIMMER_DOMAIN);
                $propbag->add('description', PLUGIN_LINKTRIMMER_DOMAIN_DESC);
                $propbag->add('default',     $serendipity['baseURL']);
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

        if (preg_match('@mysql@i', $serendipity['dbType'])) {
            $sql = "CREATE TABLE {$serendipity['dbPrefix']}linktrimmer (
                          id {AUTOINCREMENT} {PRIMARY},
                          hash varchar(32) collate latin1_general_cs,
                          url text
                        );";
        } else {
            $sql = "CREATE TABLE {$serendipity['dbPrefix']}linktrimmer (
                          id {AUTOINCREMENT} {PRIMARY},
                          hash varchar(32),
                          url text
                        );";
        }

        serendipity_db_schema_import($sql);

        $sql = "CREATE INDEX linkidx ON {$serendipity['dbPrefix']}linktrimmer (hash)";
        serendipity_db_schema_import($sql);

        $this->set_config('db_built_1', 'true');
    }

    function generate_content(&$title)
    {
        $title = PLUGIN_LINKTRIMMER_NAME;
    }

    static function base62(string $var) : string
    {
        static $base_characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';

        $stack = array();
        while (bccomp($var, '0') != 0) {
            $remainder = bcmod($var, '62');
            $var = bcdiv(bcsub($var, $remainder), '62');

            array_push($stack, $base_characters[$remainder]);
        }

        return implode('', array_reverse($stack));
    }

    static function lookup($url, $custom_hash = '', $pref = '')
    {
        global $serendipity;

        $custom_hash = trim($custom_hash);
        $url = trim($url);

        if (!preg_match('@https?://@i', $url)) {
            $url = 'http://' . $url;
        }

        $res = serendipity_db_query("SELECT hash FROM {$serendipity['dbPrefix']}linktrimmer WHERE url = '" . serendipity_db_escape_string($url) . "' LIMIT 1", true, 'assoc');
        if (!is_array($res) || empty($res['hash'])) {

            if (!empty($custom_hash)) {
                $res = serendipity_db_query("SELECT hash FROM {$serendipity['dbPrefix']}linktrimmer WHERE hash = '" . serendipity_db_escape_string($custom_hash) . "' LIMIT 1", true, 'assoc');
                if (is_array($res) && !empty($res['hash'])) {
                    return false;
                }
            }

            $hash = serendipity_event_linktrimmer::create($url, $custom_hash);
            if (empty($hash)) {
                return false;
            } else {
                return $pref . $hash;
            }
        }

        return $pref . $res['hash'];
    }

    static function create($url, $hash = '')
    {
        global $serendipity;

        serendipity_db_query("INSERT INTO {$serendipity['dbPrefix']}linktrimmer (url) VALUES ('" . serendipity_db_escape_string($url) . "')");
        $id = serendipity_db_insert_id();

        if (empty($id)) return false;

        if (empty($hash)) {
            $hash = serendipity_event_linktrimmer::base62((string) $id); // bccomp() ++ await $var as string
        }

        serendipity_db_query("UPDATE {$serendipity['dbPrefix']}linktrimmer
                                 SET hash = '" . $hash . "'
                               WHERE id = " . (int)$id);

        return $hash;
    }

    function show($external = false)
    {
        global $serendipity;

        if (IN_serendipity !== true) {
            die ("Don't hack!");
        }

        if (!isset($serendipity['smarty']) || !is_object($serendipity['smarty'])) {
            serendipity_smarty_init();
        }

        $this->setupDB();

        $pref = $this->get_config('domain') . $this->get_config('prefix') . '/';
        if ($this->get_config('domain') == $serendipity['baseURL'])  {
            $pref = $this->get_config('domain') . $this->get_config('prefix') . '/';
        } else {
            $pref = $this->get_config('domain');
        }

        if (isset($_POST['submit']) && !empty($_POST['linktrimmer_url'])) {
            $url = $this->lookup($_POST['linktrimmer_url'], $_POST['linktrimmer_hash'], $pref);
            if ($url == false) {
                $error = PLUGIN_LINKTRIMMER_ERROR;
            }
        }

        $serendipity['smarty']->assign(array(
            'linktrimmer_ispopup'     => $serendipity['enableBackendPopup'],
            'linktrimmer_error'       => !empty($error) ? $error : null,
            'linktrimmer_url'         => !empty($url) ? $url : '',
            'linktrimmer_origurl'     => !empty($_POST['linktrimmer_url']) ? $_POST['linktrimmer_url'] : '',
            'linktrimmer_external'    => $external,
            'linktrimmer_hashex'      => hash('xxh32', (string) time()),
            'linktrimmer_txtarea'     => !empty($_GET['txtarea']) ? $_GET['txtarea'] : '',
            'linktrimmer_darkmode'    => isset($serendipity['dark_mode']) && $serendipity['dark_mode'] === true
        ));

        echo $this->parseTemplate('plugin_linktrimmer.tpl');
    }

    function generate_button($txtarea)
    {
        global $serendipity;

        if (!isset($txtarea)) {
           $txtarea = 'serendipity_textarea_body';
        }
        $link =  ($serendipity['rewrite'] == 'none' ? $serendipity['indexFile'] . '?/' : '') . 'plugin/linktrimmer' . ($serendipity['rewrite'] != 'none' ? '?' : '&amp;') . 'txtarea=' . $txtarea;
// root indent & empty linespace for consistency, please !
?>
<input type="button" class="input_button" name="insLinktrimmer" value="<?php echo PLUGIN_LINKTRIMMER_NAME; ?>" onclick="serendipity.openPopup('<?php echo $link; ?>', 'linktrimmerSel', 'width=800,height=600,toolbar=no,scrollbars=1,scrollbars,resize=1,resizable=1');">

<?php
    }

    function event_hook($event, &$bag, &$eventData, $addData = null)
    {
        global $serendipity;

        $hooks = &$bag->get('event_hooks');

        if (isset($hooks[$event])) {

            switch($event) {

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
                    $link = $serendipity['serendipityHTTPPath'] . ($serendipity['rewrite'] == 'none' ? $serendipity['indexFile'] . '?/' : '') . 'plugin/linktrimmer' . ($serendipity['rewrite'] != 'none' ? '?' : '&amp;') . 'txtarea='.$eventData['item'];
                    $open = 'serendipity.openPopup';
                    $eventData['buttons'][] = array(
                        'id'         => 'linktrimmer' . $eventData['item'],
                        'name'       => PLUGIN_LINKTRIMMER_NAME,
                        'javascript' => 'function() { '.$open.'(\'' . $link . '\', \'LinkTrimmer\', \'width=800,height=600,toolbar=no,scrollbars=1,scrollbars,resize=1,resizable=1\') }',
                        'img_url'    => $serendipity['serendipityHTTPPath'] . ($serendipity['rewrite'] == 'none' ? $serendipity['indexFile'] . '?/' : '') . 'plugin/plugin_linktrimmer.gif',
                        'svg'        => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-layer-forward bi-layer-forward-btn" viewBox="0 0 16 16"><path d="M8.354.146a.5.5 0 0 0-.708 0l-3 3a.5.5 0 0 0 0 .708l1 1a.5.5 0 0 0 .708 0L7 4.207V12H1a1 1 0 0 0-1 1v2a1 1 0 0 0 1 1h14a1 1 0 0 0 1-1v-2a1 1 0 0 0-1-1H9V4.207l.646.647a.5.5 0 0 0 .708 0l1-1a.5.5 0 0 0 0-.708z"/><path d="M1 7a1 1 0 0 0-1 1v2a1 1 0 0 0 1 1h4.5a.5.5 0 0 0 0-1H1V8h4.5a.5.5 0 0 0 0-1zm9.5 0a.5.5 0 0 0 0 1H15v2h-4.5a.5.5 0 0 0 0 1H15a1 1 0 0 0 1-1V8a1 1 0 0 0-1-1z"/></svg>',
// no need, since we have a css_backend hook. Else use this
//                        'css'        => '.bi.bi-noise-reduction.bi-noise-reduction-btn { fill: currentColor; }',
                        'toolbar'    => 'other'
                    );
                    break;

                case 'frontend_configure':
                    if (preg_match('@' . $serendipity['serendipityHTTPPath'] . '/?(' . $serendipity['indexFile'] . ')?\??' . $this->get_config('prefix') . '/?(.+)$@imsU', $_SERVER['REQUEST_URI'], $m)) {
                        $hash = preg_replace('@[^a-z0-9]@imsU', '', $m[2]);
                        $res = serendipity_db_query("SELECT url
                                                       FROM {$serendipity['dbPrefix']}linktrimmer
                                                      WHERE hash = '" . serendipity_db_escape_string($hash) . "'
                                                      LIMIT 1", true, 'assoc');
                        if (is_array($res) && !empty($res['url'])) {
                            $url = str_replace(array("\n", "\r", "\0"), '', $res['url']);
                            header('HTTP/1.0 301 Moved Permanently');
                            header('Location: ' . $url);
                            exit;
                        }
                    }
                    break;

                case 'backend_dashboard':
                    if (serendipity_db_bool($this->get_config('frontpage', 'true'))) {
                        $this->show();
                    }
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

                    switch($uri_part) {
                        case 'plugin_linktrimmer.gif':
                            header('Content-Type: image/gif');
                            echo file_get_contents(dirname(__FILE__) . '/serendipity_event_linktrimmer.gif');
                            break;

                        case 'linktrimmer':
                            $this->show(true);
                    }
                    break;

                case 'css_backend':
                    if (!strpos($eventData, '.linktrimmer')) {
                        // class exists in CSS, so a user has customized it and we don't need default
                        $eventData .= @file_get_contents(dirname(__FILE__) . '/linktrimmer.css');
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