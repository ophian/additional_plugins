<?php

declare(strict_types=1);

if (IN_serendipity !== true) {
    die ("Don't hack!");
}

@serendipity_plugin_api::load_language(dirname(__FILE__));

class serendipity_common_adduser
{
    static function sendMail(string $username, string $hash, string $email, bool $approve_only = false, bool $admin_cc = true) : bool
    {
        global $serendipity;

        if ($approve_only) {
            $activation_url = $serendipity['baseURL'] . $serendipity['indexFile'] . '?r=1&serendipity%5Badduser_activation%5D=' . $hash . '#adduser';
        } else {
            $activation_url = $serendipity['baseURL'] . $serendipity['indexFile'] . '?serendipity%5Badduser_activation%5D=' . $hash . '#adduser';
        }
        $fromName = $serendipity['blogTitle'];

        if ($approve_only) {
            $subject  = '['. $serendipity['blogTitle'] . '] ' . PLUGIN_ADDUSER_MAIL_SUBJECT_APPROVE;
            $message  = sprintf(PLUGIN_ADDUSER_MAIL_BODY_APPROVE, $username . ' (' . $email . ')', $serendipity['baseURL'] . 'serendipity_admin.php', $activation_url);
        } else {
            $subject  = '['. $serendipity['blogTitle'] . '] ' . PLUGIN_ADDUSER_MAIL_SUBJECT;
            $message  = sprintf(PLUGIN_ADDUSER_MAIL_BODY, $username . ' (' . $email . ')', $serendipity['baseURL'] . 'serendipity_admin.php', $activation_url);
        }

        $admins = serendipity_db_query("SELECT authorid, email FROM {$serendipity['dbPrefix']}authors WHERE userlevel = " . USERLEVEL_ADMIN);
        $admin_cc = array();
        if (is_array($admins)) {
            foreach($admins AS $idx => $admin) {
                if (empty($admin['email'])) {
                    continue;
                }
                $admin_cc[] = $admin['email'];
                serendipity_sendMail($admin['email'], $subject, $message, $email, null, $serendipity['blogTitle']);
            }
        }

        if ($approve_only) {
            // Only Admin-Mails, done in the foreach-loop above already.
            $mail = true;
        } else {
            // Send out Mails to the actual receiver.
            $mail = serendipity_sendMail($email, $subject, $message, $email, null, $serendipity['blogTitle']);
        }

        return $mail;
    }

    static function checkUser(iterable $usergroups = array()) : bool
    {
        global $serendipity;
        static $debug = false;

        if (!empty($serendipity['GET']['adduser_activation']) && !empty($_GET['r'])) {
            $string = $serendipity['GET']['adduser_activation'];
            $q = "SELECT * FROM {$serendipity['dbPrefix']}pending_authors WHERE hash = '" . serendipity_db_escape_string($string) . "' LIMIT 1";
            if ($debug) {
                echo "[debug] QUERY: $q<br />\n";
            }
            $author = serendipity_db_query($q, true);

            serendipity_common_adduser::sendMail($author['username'], htmlspecialchars($string), $author['email'], false, false);

            echo '<p class="serendipity_content_message serendipity_msg_success"> ' . PLUGIN_ADDUSER_SENTMAIL_APPROVE_ADMIN . "</p>\n";
            return true;
        }

        if (!empty($serendipity['GET']['adduser_activation'])) {
            $string = $serendipity['GET']['adduser_activation'];
            unset($serendipity['GET']['adduser_activation']);

            if (strlen($string) != 32) {
                echo '<p class="serendipity_content_message serendipity_msg_important"> ' . PLUGIN_ADDUSER_WRONG_ACTIVATION . "</p>\n<hr />\n";
                return false;
            }

            $q = "SELECT * FROM {$serendipity['dbPrefix']}pending_authors WHERE hash = '" . serendipity_db_escape_string($string) . "' LIMIT 1";
            if ($debug) {
                echo "[debug] QUERY: $q<br />\n";
            }
            $author = serendipity_db_query($q, true);
            if ($debug) {
                echo "[debug] RESULT: " . print_r($author,true) . "<br />\n";
            }
            if (is_array($author)) {
                $user = serendipity_db_query("SELECT authorid FROM {$serendipity['dbPrefix']}authors WHERE username = '" . serendipity_db_escape_string($author['username']) . "'", true);
                if (is_array($user) && !empty($user['authorid'])) {
                    printf('<p class="serendipity_content_message serendipity_msg_notice"> ' . PLUGIN_ADDUSER_EXISTS . "</p>\n<hr />\n", htmlspecialchars($author['username']));
                    return false;
                }

                $newID = serendipity_addAuthor($author['username'], '', $author['username'], $author['email'], $author['userlevel']);
                if ($debug) {
                    echo "[debug] serendipity_addAuthor: $newID<br />\n";
                }
                if ($newID) {
                    serendipity_db_query("UPDATE {$serendipity['dbPrefix']}authors
                                             SET right_publish = '" . ($author['right_publish'] ? '1' : '0') . "',
                                                 password      = '" . $author['password'] . "'
                                           WHERE authorid = " . (int)$newID);
                    serendipity_set_config_var('no_create', $author['no_create'], $newID);
                    serendipity_set_config_var('lang', $serendipity['lang'], $newID);
                    serendipity_set_config_var('enableBackendPopupGranular', 'categories,tags,links', $newID);

                    // Fetch default properties for new authors as configured.
                    // Only set values for the keys that are supported (all booleans currently! Ahem, well ... NO!)
                    $config = serendipity_db_query("SELECT name, value FROM {$serendipity['dbPrefix']}config WHERE name LIKE 'serendipity_plugin_adduser:%'");
                    $pair_config = array(
                        'wysiwyg' => '',
                        'simpleFilters' => '',
                        'enableBackendPopup' => '',
                        'moderateCommentsDefault' => '',
                        'allowCommentsDefault' => '',
                        'showMediaToolbar' => '',
                        'use_autosave' => ''
                    );

                    if (is_array($config)) {
                        foreach($config AS $conf) {
                            $names = explode('/', $conf['name']);
                            if (isset($pair_config[$names[1]])) {
                                $pair_config[$names[1]] = serendipity_get_bool($conf['value']);
                                serendipity_set_config_var($names[1], ($pair_config['wysiwyg'] ? 'true' : 'false'), $newID); // store as string !! to serendipity_set_config_var( arg #2 )
                            }
                        }
                    }

                    if (is_array($usergroups) && function_exists('serendipity_updateGroups')) {
                        if ($debug) echo "[debug] update groups: " . print_r($usergroups, true) . "<br />\n";
                        serendipity_updateGroups($usergroups, $newID, false);
                    } elseif ($debug) {
                        echo "[debug] no group addition: " . print_r($usergroups, true) . "<br />\n";
                    }
                } elseif ($debug) {
                    echo "[debug] serendipity_addAuthor() failed!<br />\n";
                }
            }

            $q = "SELECT authorid FROM {$serendipity['dbPrefix']}authors
                                             WHERE username = '" . $author['username'] . "'
                                               AND password = '" . $author['password'] . "'
                                             LIMIT 1";
            $newauthor = serendipity_db_query($q, true);

            if (is_array($newauthor) && $newauthor['authorid'] > 0) {
                echo '<p class="serendipity_content_message serendipity_msg_success"> ' . PLUGIN_ADDUSER_SUCCEED . "</p>\n<hr />\n";
                serendipity_db_query("DELETE FROM {$serendipity['dbPrefix']}pending_authors WHERE hash = '" . serendipity_db_escape_string($string) . "'");
                unset($serendipity['POST']); // clear input fields and post data
                return true;
            } else {
                if ($debug) {
                    echo "[debug] QUERY: $q<br />\n";
                    echo "[debug] RESULT: " . print_r($newauthor, true) . "<br />\n";
                }

                echo '<p class="serendipity_content_message serendipity_msg_important"> ' . PLUGIN_ADDUSER_FAILED . "</p>\n<hr />\n";
                return false;
            }
        }

        return false;
    }

    static function addAuthor(string $username, #[\SensitiveParameter] string $password, string $email, string $userlevel, bool $right_publish, bool $no_create) : string
    {
        global $serendipity;

        if (!is_array(serendipity_db_query("SELECT username FROM {$serendipity['dbPrefix']}pending_authors LIMIT 1", true, 'both', false, false, false, true))) {
            serendipity_db_schema_import("CREATE TABLE {$serendipity['dbPrefix']}pending_authors (
              username varchar(20) default null,
              password varchar(128) default null,
              email varchar(128) not null default '',
              userlevel int(4) {UNSIGNED} not null default '0',
              right_publish int(1) default '1',
              no_create int(1) default '0',
              hash varchar(32) default null
            );");
        }

        $hash = hash('xxh128', $username.time().$email);

        $hashpw = serendipity_hash($password);

        serendipity_db_insert('pending_authors', array(
            'username'      => $username,
            'password'      => $hashpw,
            'email'         => $email,
            'userlevel'     => $userlevel,
            'right_publish' => (serendipity_db_bool($right_publish) ? '1' : '0'),
            'no_create'     => (serendipity_db_bool($no_create) ? '1' : '0'),
            'hash'          => $hash
        ));

        return $hash;
    }

    static function addUser(string &$username, #[\SensitiveParameter] string &$password, string &$email, string $userlevel, iterable $usergroups = array(),
                            bool $no_create = false, bool $right_publish = true, bool $straight_insert = false, bool $approve = false, bool $use_captcha = false) : bool
    {
        global $serendipity;

        if (serendipity_common_adduser::checkUser($usergroups)) {
            return true;
        }

        if (!empty($serendipity['POST']['adduser_action'])) {
            if (empty($username) || empty($password) || empty($email)) {
                echo '<p class="serendipity_content_message serendipity_msg_notice"> ' . PLUGIN_ADDUSER_MISSING . "</p>\n<hr />\n";
                return false;
            }

            if ($use_captcha) {
                // Fake call to spamblock/captcha and other comment plugins.
                $ca = array(
                    'id'                => 0,
                    'allow_comments'    => 'true',
                    'moderate_comments' => false,
                    'last_modified'     => 1,
                    'timestamp'         => 10 // make those entries old so that captcha_ttl will be enabled.
                );

                $commentInfo = array(
                    'type' => 'NORMAL',
                    'source' => 'commentform',
                    'name' => $username,
                    'url' => '',
                    'comment' => 'A new user ' . hash('xxh128', $username.time().$email) . ' is registered.',
                    'email' => $email,
                    'source2' => 'adduser'
                );
                serendipity_plugin_api::hook_event('frontend_saveComment', $ca, $commentInfo);

                if ($ca['allow_comments'] === false) {
                    echo '<p class="serendipity_content_message serendipity_msg_notice"> ' . PLUGIN_ADDUSER_ANTISPAM . "</p>\n<hr />\n";
                    return false;
                }
                // End of fake call.
            }

            $user = serendipity_db_query("SELECT authorid FROM {$serendipity['dbPrefix']}authors WHERE username = '" . serendipity_db_escape_string($username) . "'", true);
            if (is_array($user) && !empty($user['authorid'])) {
                printf('<p class="serendipity_content_message serendipity_msg_notice"> ' . PLUGIN_ADDUSER_EXISTS . "</p>\n<hr />\n", htmlspecialchars($username));
                return false;
            }

            $hash = serendipity_common_adduser::addAuthor($username, $password, $email, $userlevel, $right_publish, $no_create);

            if ($approve) {
                serendipity_common_adduser::sendMail($username, $hash, $email, true);
                echo '<p class="serendipity_content_message serendipity_msg_notice"> ' . PLUGIN_ADDUSER_SENTMAIL_APPROVE . "</p>\n";
                unset($serendipity['POST']); // clear input fields and post data
            } elseif ($straight_insert) {
                $serendipity['GET']['adduser_activation'] = $hash;
                serendipity_common_adduser::checkUser($usergroups);
            } elseif (serendipity_common_adduser::sendMail($username, $hash, $email)) {
                echo '<p class="serendipity_content_message serendipity_msg_success"> ' . PLUGIN_ADDUSER_SENTMAIL . "</p>\n";
                unset($serendipity['POST']); // clear input fields and post data
            } else {
                echo '<p class="serendipity_content_message serendipity_msg_important"> ' . ERROR . ': ' . PLUGIN_ADDUSER_SENTMAIL_FAILED . "</p>\n";
            }

            unset($serendipity['POST']['adduser_action']); // Ensure the plugin is not called twice
            return true;
        }

        return false;
    }

    static function loginform(string $url, iterable $hidden = array(), string $instructions = '', string $username = '', #[\SensitiveParameter] string $password = '', string $email = '', bool $use_captcha = false) : void
    {
        global $serendipity;

        if (!isset($serendipity['smarty']) || !is_object($serendipity['smarty'])) {
            serendipity_smarty_init();
        }
        $serendipity['smarty']->assign(array(
            'registerbox_url'          => $url,
            'registerbox_hidden'       => $hidden,
            'registerbox_instructions' => $instructions,
            'registerbox_username'     => $username,
            'registerbox_password'     => $password,
            'registerbox_email'        => $email,
            'registerbox_captcha'      => $use_captcha,
        ));
        $filename = 'plugin_registerbox.tpl';
        $tfile = serendipity_getTemplateFile($filename, 'serendipityPath');

        if (!$tfile || $tfile == $filename) {
            $tfile = dirname(__FILE__) . '/' . $filename;
        }
        $serendipity['smarty']->display($tfile);
    }

}
