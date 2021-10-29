<?php

if (IN_serendipity !== true) {
    die ("Don't hack!");
}

@serendipity_plugin_api::load_language(dirname(__FILE__));

class serendipity_event_suggest extends serendipity_event
{
    var $title = PLUGIN_SUGGEST_TITLE;

    function introspect(&$propbag)
    {
        global $serendipity;

        $propbag->add('name',           PLUGIN_SUGGEST_TITLE);
        $propbag->add('description',    PLUGIN_SUGGEST_DESC);
        $propbag->add('event_hooks',    array(
                                            'entries_header'  => true,
                                            'entry_display'   => true,
                                            'genpage'         => true,
                                            'external_plugin' => true,
                                            'backend_display' => true,
                                            'backend_publish' => true
                                        ));
        $propbag->add('configuration',  array('permalink', 'pagetitle', 'authorid', 'email'));
        $propbag->add('author',         'Garvin Hicking, Ian Styx');
        $propbag->add('version',        '0.19');
        $propbag->add('groups',         array('FRONTEND_FEATURES'));
        $propbag->add('requirements',   array(
                                            'serendipity' => '2.0',
                                            'smarty'      => '3.0',
                                            'php'         => '7.0'
                                        ));
        $propbag->add('stackable',      true);
        $propbag->add('license',        'Commercial');
        $propbag->add('legal',          array(
            'services' => array(
            ),
            'frontend' => array(
                'Stores recommended entries in the database, contains some visitor metadata (IP addresses)',
                'Sends user data via e-mail'
            ),
            'backend' => array(
            ),
            'cookies' => array(
            ),
            'stores_user_input'     => true,
            'stores_ip'             => true,
            'uses_ip'               => true,
            'transmits_user_input'  => true
        ));
    }

    function install()
    {
        global $serendipity;

        serendipity_db_schema_import("CREATE TABLE IF NOT EXISTS {$serendipity['dbPrefix']}suggestmails (
            id {AUTOINCREMENT} {PRIMARY},
            email varchar(255) NOT NULL,
            entry_id int(10) {UNSIGNED} not null default '0',
            copycop text NOT NULL,
            ip varchar(16),
            submitted int(11),
            name varchar(255),
            article text,
            title text,
            validation varchar(128)
            ) {UTF_8}");
    }

    function introspect_config_item($name, &$propbag)
    {
        global $serendipity;

        switch($name) {
            case 'author':
                $propbag->add('type',        'select');
                $propbag->add('name',        AUTHOR);
                $propbag->add('description', PLUGIN_SUGGEST_AUTHOR);
                $propbag->add('default',     '');
                $users = serendipity_fetchUsers();
                $vals  = array();
                foreach($users AS $user) {
                    $vals[$user['authorid']] = $user['realname'];
                }
                $propbag->add('select_values', $vals);
                break;

            case 'permalink':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_SUGGEST_PERMALINK);
                $propbag->add('description', PLUGIN_SUGGEST_PERMALINK_DESC);
                $propbag->add('default',     $serendipity['rewrite'] != 'none'
                                             ? $serendipity['serendipityHTTPPath'] . 'pages/suggest.html'
                                             : $serendipity['serendipityHTTPPath'] . $serendipity['indexFile'] . '?/pages/suggest.html');
                break;

            case 'pagetitle':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_SUGGEST_PAGETITLE);
                $propbag->add('description', PLUGIN_SUGGEST_PAGETITLE_DESC);
                $propbag->add('default',     'suggest');
                break;

            case 'email':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_SUGGEST_EMAIL);
                $propbag->add('description', '');
                $propbag->add('default',     $serendipity['blogMail']);
                break;

            default:
                return false;
        }
        return true;
    }

    function sendComment($to, $title, $fromName, $fromEmail, $fromUrl, $comment)
    {
        global $serendipity;

        if (empty($fromName)) {
            $fromName = ANONYMOUS;
        }

        $key = md5(uniqid(rand(), true));

        //  CUSTOMIZE
        $subject = PLUGIN_SUGGEST_TITLE;
        $text    = sprintf(PLUGIN_SUGGEST_MAIL,
                   $serendipity['baseURL'] . '?suggestkey=' . $key);

        $db = array(
            'email'         => $fromEmail,
            'entry_id'      => 0,
            'copycop'       => '',
            'ip'            => $_SERVER['REMOTE_ADDR'],
            'submitted'     => time(),
            'name'          => $fromName,
            'article'       => $comment,
            'title'         => $title,
            'validation'    => $key
        );
        serendipity_db_insert('suggestmails', $db);

        return serendipity_sendMail($to, $subject, $text, $serendipity['blogMail'], null, $serendipity['blogTitle']);
    }

    function checkSubmit()
    {
        global $serendipity;

        if (empty($serendipity['POST']['suggestform'])) {
            return false;
        }

        if (empty($serendipity['POST']['name']) || empty($serendipity['POST']['email']) || empty($serendipity['POST']['comment'])) {
            $serendipity['smarty']->assign(
                array(
                    'is_suggest_error'     => true,
                    'plugin_suggest_error' => PLUGIN_SUGGEST_ERROR_DATA
                )
            );
            return false;
        }

        // Fake call to spamblock/captcha and other comment plugins.
        $ca = array(
            'id'                => 0,
            'allow_comments'    => 'true',
            'moderate_comments' => '0',
            'last_modified'     => 1,
            'timestamp'         => 1
        );

        // Strip everything except <a>, <b>, <strong>
        $serendipity['POST']['comment'] = strip_tags($serendipity['POST']['comment'], '<b><strong><a>');

        $commentInfo = array(
            'type'      => 'NORMAL',
            'source'    => 'suggestform',
            'name'      => $serendipity['POST']['name'],
            'url'       => $serendipity['POST']['url'],
            'comment'   => $serendipity['POST']['comment'],
            'email'     => $serendipity['POST']['email'],
            'timestamp' => true
        );
        serendipity_plugin_api::hook_event('frontend_saveComment', $ca, $commentInfo);

        if ($ca['allow_comments'] === false) {
            $serendipity['smarty']->assign(
                array(
                    'is_suggest_error'     => true,
                    'plugin_suggest_error' => PLUGIN_SUGGEST_ERROR_DATA
                )
            );

            return false;
        }
        // End of fake call.

        if ($this->sendComment(
            $serendipity['POST']['email'],
            $serendipity['POST']['entry_title'],
            $serendipity['POST']['name'],
            $serendipity['POST']['email'],
            $serendipity['POST']['url'],
            $serendipity['POST']['comment'])) {

            $serendipity['smarty']->assign('is_suggest_sent', true);
            return true;
        } else {
            // Unknown error occurred.
            $serendipity['smarty']->assign(
                array(
                    'is_suggest_error'     => true,
                    'plugin_suggest_error' => PLUGIN_SUGGEST_ERROR_HTML
                )
            );
        }

        return false;
    }

    function show()
    {
        global $serendipity;

        if ($this->selected()) {
            if (!headers_sent()) {
                header('HTTP/1.0 200');
                header('Status: 200 OK');
            }

            if (!isset($serendipity['smarty']) || !is_object($serendipity['smarty'])) {
                serendipity_smarty_init();
            }

            $_ENV['staticpage_pagetitle'] = preg_replace('@[^a-z0-9]@i', '_',$this->get_config('pagetitle'));
            $serendipity['smarty']->assign('staticpage_pagetitle', $_ENV['staticpage_pagetitle']);

            $this->checkSubmit();

            $validation_error      = false;
            $validation_success    = false;
            $validation_error_code = 0;

            if (!empty($_REQUEST['suggestkey'])) {
                $res = serendipity_db_query("SELECT * FROM {$serendipity['dbPrefix']}suggestmails WHERE validation = '" . serendipity_db_escape_string($_REQUEST['suggestkey']) . "'", true, 'assoc');
                if (!is_array($res) || $res['validation'] != $_REQUEST['suggestkey']) {
                    $validation_error      = true;
                    $validation_error_code = serendipity_specialchars($_REQUEST['suggestkey']);
                } else {
                    $validation_success = true;
                    $validation_error_code = serendipity_specialchars($_REQUEST['suggestkey']);
                    serendipity_db_query("UPDATE {$serendipity['dbPrefix']}suggestmails SET validation = '' WHERE id = " . (int)$res['id']);

                    $entry = array(
                        'isdraft'           => true,
                        'allow_comments'    => true,
                        'moderate_comments' => '0',
                        'authorid'          => $this->get_config('authorid'),
                        'title'             => $res['title'],
                        'body'              => $res['article']
                    );
                    $serendipity['POST']['properties'] = array('fake' => 'fake');
                    ob_start();
                    $id = serendipity_updertEntry($entry);
                    serendipity_db_query("UPDATE {$serendipity['dbPrefix']}suggestmails SET entry_id = " . (int)$id . "  WHERE id = " . (int)$res['id']);
                    $metaout = ob_get_contents();
                    ob_end_clean();
                    serendipity_sendMail($this->get_config('email'), PLUGIN_SUGGEST_TITLE . ': ' . $res['title'], $res['article'], $serendipity['blogMail'], null, $serendipity['blog']);
                }
            }

            $serendipity['smarty']->assign(
                array(
                    'input'                         => $_REQUEST,
                    'plugin_suggest_articleformat'  => $this->get_config('articleformat'),
                    'plugin_suggest_name'           => PLUGIN_SUGGEST_TITLE,
                    'plugin_suggest_pagetitle'      => $this->get_config('pagetitle'),

                    'plugin_suggest_message'        => PLUGIN_SUGGEST_MESSAGE,
                    'suggest_backend'               => $metaout ?? null,
                    'suggest_action'                => $serendipity['baseURL'] . $serendipity['indexFile'],
                    'suggest_sname'                 => $serendipity['GET']['subpage'],
                    'suggest_name'                  => serendipity_specialchars(($serendipity['POST']['name'] ?? null)),
                    'suggest_url'                   => serendipity_specialchars(($serendipity['POST']['url'] ?? null)),
                    'suggest_email'                 => serendipity_specialchars(($serendipity['POST']['email'] ?? null)),
                    'suggest_entry_title'           => serendipity_specialchars(($serendipity['POST']['entry_title'] ?? null)),
                    'suggest_data'                  => serendipity_specialchars(($serendipity['POST']['comment'] ?? null)),
                    'comments_messagestack'         => $serendipity['messagestack']['comments'] ?? null,
                    'suggest_validation_error'      => $validation_error,
                    'suggest_validation_success'    => $validation_success,
                    'suggest_validation_code'       => $validation_error_code,

                    'suggest_entry'                 => array(
                                                            'timestamp' => 1, // force captchas!
                                                        )
                )
            );

            $tfile = serendipity_getTemplateFile('plugin_suggest.tpl', 'serendipityPath');
            if (!$tfile || $tfile == 'plugin_suggest.tpl') {
                $tfile = dirname(__FILE__) . '/plugin_suggest.tpl';
            }
            $content = $serendipity['smarty']->fetch('file:'. $tfile);

            echo $content;
        }
    }

    function selected()
    {
        global $serendipity;

        if (!empty($_REQUEST['suggestkey'])) {
            $serendipity['GET']['subpage'] = $this->get_config('pagetitle');
        }

        if (!empty($serendipity['POST']['subpage'])) {
            $serendipity['GET']['subpage'] = $serendipity['POST']['subpage'];
        }

        if ($serendipity['GET']['subpage'] == $this->get_config('pageurl') || (isset($serendipity['GET']['subpage'])
        &&  preg_match('@^' . preg_quote($this->get_config('permalink')) . '@i', $serendipity['GET']['subpage']))) {
            return true;
        }

        return false;
    }

    function generate_content(&$title)
    {
        $title = PLUGIN_SUGGEST_TITLE.' (' . $this->get_config('pagetitle') . ')';
    }

    function event_hook($event, &$bag, &$eventData, $addData = null)
    {
        global $serendipity;

        $hooks = &$bag->get('event_hooks');

        if (isset($hooks[$event])) {
            switch($event) {
                case 'external_plugin':
                    $events = explode('_', $eventData);
                    if ($events[0] != 'copycop') return false;

                    // TODO: Call CopyCop here somehow.
                    break;

                case 'genpage':
                    if ($serendipity['rewrite'] != 'none') {
                        $nice_url = $serendipity['serendipityHTTPPath'] . $addData['uriargs'];
                    } else {
                        $nice_url = $serendipity['serendipityHTTPPath'] . $serendipity['indexFile'] . '?/' . $addData['uriargs'];
                    }

                    if (empty($serendipity['GET']['subpage'])) {
                        $serendipity['GET']['subpage'] = $nice_url;
                    }
                    break;

                case 'entry_display':
                    if ($this->selected()) {
                        if (is_array($eventData)) {
                            $eventData['clean_page'] = true; // This is important to not display an entry list!
                        } else {
                            $eventData = array('clean_page' => true);
                        }
                    }
                    break;

                case 'entries_header':
                    $this->show();
                    break;

                case 'backend_publish':
                    if (!$eventData['id']) return false;
                    $res = serendipity_db_query("SELECT * FROM {$serendipity['dbPrefix']}suggestmails WHERE entry_id = " . (int)$eventData['id'], true, 'assoc');
                    if (!is_array($res)) {
                        $res = array();
                    }

                    if (!$res['id']) {
                        return false;
                    }

                    //  CUSTOMIZE
                    serendipity_sendMail($res['email'], PLUGIN_SUGGEST_TITLE, PLUGIN_SUGGEST_PUBLISHED, $serendipity['blogMail'], null, $serendipity['blog']);
                    echo PLUGIN_SUGGEST_INFORM . "<br />\n";

                    serendipity_db_query("REPLACE INTO {$serendipity['dbPrefix']}entryproperties
                                                       (entryid, property, value)
                                                VALUES (" . (int)$eventData['id'] . ", 'ep_suggest_name', '" . serendipity_db_escape_string($res['name']) . "')");
                    break;

                case 'backend_display':
                    $res = serendipity_db_query("SELECT * FROM {$serendipity['dbPrefix']}suggestmails WHERE entry_id = " . (int)($eventData['id'] ?? null), true, 'assoc');
                    if (isset($res) && !is_array($res)) {
?>
                    <fieldset id="edit_entry_suggest" class="entryproperties_suggest">
                        <span class="wrap_legend"><legend><?php echo PLUGIN_SUGGEST_TITLE; ?></legend></span>
                        <div><?php echo PLUGIN_SUGGEST_INTERNAL; ?></div>
                    </fieldset>

<?php
                    } else {
                        //  CUSTOMIZE
?>
                    <fieldset id="edit_entry_suggest" class="entryproperties_suggest">
                        <span class="wrap_legend"><legend><?php echo PLUGIN_SUGGEST_TITLE; ?></legend></span>
                        <div>
                            <?php printf(PLUGIN_SUGGEST_META, serendipity_specialchars($res['name']), strftime('%d.%m.%Y %H:%M', $res['submitted']), serendipity_specialchars($res['ip']), serendipity_specialchars($res['email'])); ?>
                        </div>
                    </fieldset>
<?php
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