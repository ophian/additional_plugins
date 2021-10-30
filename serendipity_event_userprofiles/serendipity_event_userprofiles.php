<?php

if (IN_serendipity !== true) {
    die ("Don't hack!");
}

@serendipity_plugin_api::load_language(dirname(__FILE__));

class serendipity_event_userprofiles extends serendipity_event
{

    var $title = PLUGIN_EVENT_USERPROFILES_TITLE;

    var $properties = array(
        'city'       => array('desc' => PLUGIN_EVENT_USERPROFILES_CITY,
                            'type' => 'string'),
        'street'     => array('desc' => PLUGIN_EVENT_USERPROFILES_STREET,
                            'type' => 'string'),
        'country'    => array('desc' => PLUGIN_EVENT_USERPROFILES_COUNTRY,
                            'type' => 'string'),
        'url'        => array('desc' => PLUGIN_EVENT_USERPROFILES_URL,
                            'type' => 'string'),
        'occupation' => array('desc' => PLUGIN_EVENT_USERPROFILES_OCCUPATION,
                            'type' => 'string'),
        'hobbies'    => array('desc' => PLUGIN_EVENT_USERPROFILES_HOBBIES,
                            'type' => 'html'),
        'yahoo'      => array('desc' => PLUGIN_EVENT_USERPROFILES_YAHOO,
                            'type' => 'string'),
        'aim'        => array('desc' => PLUGIN_EVENT_USERPROFILES_AIM,
                            'type' => 'string'),
        'jabber'     => array('desc' => PLUGIN_EVENT_USERPROFILES_JABBER,
                            'type' => 'string'),
        'icq'        => array('desc' => PLUGIN_EVENT_USERPROFILES_ICQ,
                            'type' => 'string'),
        'msn'        => array('desc' => PLUGIN_EVENT_USERPROFILES_MSN,
                            'type' => 'string'),
        'skype'      => array('desc' => PLUGIN_EVENT_USERPROFILES_SKYPE,
                            'type' => 'string'),
        'birthday'    => array('desc' => PLUGIN_EVENT_USERPROFILES_BIRTHDAY,
                            'type' => 'date')
    );

    var $option_properties = array(
        'show_email' => array('desc' => PLUGIN_EVENT_USERPROFILES_SHOWEMAIL,
                            'type' => 'boolean'),
        'show_city'  => array('desc' => PLUGIN_EVENT_USERPROFILES_SHOWCITY,
                            'type' => 'boolean'),
        'show_street' => array('desc' => PLUGIN_EVENT_USERPROFILES_SHOWSTREET,
                            'type' => 'boolean'),
        'show_country'  => array('desc' => PLUGIN_EVENT_USERPROFILES_SHOWCOUNTRY,
                            'type' => 'boolean'),
        'show_url'  => array('desc' => PLUGIN_EVENT_USERPROFILES_SHOWURL,
                            'type' => 'boolean'),
        'show_occupation'  => array('desc' => PLUGIN_EVENT_USERPROFILES_SHOWOCCUPATION,
                            'type' => 'boolean'),
        'show_hobbies'  => array('desc' => PLUGIN_EVENT_USERPROFILES_SHOWHOBBIES,
                            'type' => 'boolean'),
        'show_yahoo'  => array('desc' => PLUGIN_EVENT_USERPROFILES_SHOWYAHOO,
                            'type' => 'boolean'),
        'show_aim'  => array('desc' => PLUGIN_EVENT_USERPROFILES_SHOWAIM,
                            'type' => 'boolean'),
        'show_jabber'  => array('desc' => PLUGIN_EVENT_USERPROFILES_SHOWJABBER,
                            'type' => 'boolean'),
        'show_icq'  => array('desc' => PLUGIN_EVENT_USERPROFILES_SHOWICQ,
                            'type' => 'boolean'),
        'show_msn'  => array('desc' => PLUGIN_EVENT_USERPROFILES_SHOWMSN,
                            'type' => 'boolean'),
        'show_skype' => array('desc' => PLUGIN_EVENT_USERPROFILES_SHOWSKYPE,
                            'type' => 'boolean'),
        'show_birthday' => array('desc' => PLUGIN_EVENT_USERPROFILES_BIRTHDAY,
                            'type' => 'boolean')

    );

    var $found_images = array();

    function introspect(&$propbag)
    {
        global $serendipity;

        $propbag->add('name',        PLUGIN_EVENT_USERPROFILES_TITLE);
        $propbag->add('description', PLUGIN_EVENT_USERPROFILES_DESC);
        $propbag->add('event_hooks', array(
            'backend_sidebar_entries_event_display_profiles'  => true,
            'backend_sidebar_users'                           => true,
            'backend_sidebar_admin'                           => true,
            'frontend_display'                                => true,
            'entries_header'                                  => true,
            'css'                                             => true,
            'css_backend'                                     => true,
            'frontend_display_cache'                          => true,
            'entry_display'                                   => true,
            'genpage'                                         => true
        ));
        $propbag->add('author', 'Garvin Hicking, Falk Doering, Matthias Mees, Ian Styx');
        $propbag->add('version', '1.2.0');
        $propbag->add('requirements', array(
            'serendipity' => '3.5',
            'smarty'      => '3.1.0',
            'php'         => '7.3.0'
        ));
        $propbag->add('stackable', false);
        $propbag->add('groups', array('BACKEND_USERMANAGEMENT','BACKEND_TEMPLATES'));
        $propbag->add('scrambles_true_content', true);
        $propbag->add('configuration', array('extension','authorpic','gravatar','gravatar_size','gravatar_default','gravatar_rating','commentcount'));

    }

    function introspect_config_item($name, &$propbag)
    {
        switch($name) {
            case 'authorpic':
                $propbag->add('type', 'boolean');
                $propbag->add('name', PLUGIN_EVENT_AUTHORPIC_ENABLED);
                $propbag->add('description', PLUGIN_EVENT_AUTHORPIC_ENABLED_DESC);
                $propbag->add('default', 'false');
                break;

            case 'extension':
                $propbag->add('type', 'string');
                $propbag->add('name', PLUGIN_EVENT_AUTHORPIC_EXTENSION);
                $propbag->add('description', PLUGIN_EVENT_AUTHORPIC_EXTENSION_BLAHBLAH);
                $propbag->add('default', 'jpg');
                break;

            case 'gravatar':
                $propbag->add('type', 'boolean');
                $propbag->add('name', PLUGIN_USERPROFILES_GRAVATAR);
                $propbag->add('description', PLUGIN_USERPROFILES_GRAVATAR_DESC);
                $propbag->add('default', 'false');
                break;

            case 'gravatar_size':
                $propbag->add('type', 'string');
                $propbag->add('name', PLUGIN_USERPROFILES_GRAVATAR_SIZE);
                $propbag->add('description', PLUGIN_USERPROFILES_GRAVATAR_SIZE_DESC);
                $propbag->add('default', "80");
                break;

            case 'gravatar_rating':
                $propbag->add('type', 'string');
                $propbag->add('name', PLUGIN_USERPROFILES_GRAVATAR_RATING);
                $propbag->add('description', PLUGIN_USERPROFILES_GRAVATAR_RATING_DESC);
                $propbag->add('default', "R");
                break;

            case 'gravatar_default':
                $propbag->add('type', 'string');
                $propbag->add('name', PLUGIN_USERPROFILES_GRAVATAR_DEFAULT);
                $propbag->add('description', PLUGIN_USERPROFILES_GRAVATAR_DEFAULT_DESC);
                $propbag->add('default', "");
                break;

            case 'commentcount':
                $propbag->add('type', 'select');
                $propbag->add('name', PLUGIN_EVENT_AUTHORPIC_COMMENTCOUNT);
                $propbag->add('description', PLUGIN_EVENT_AUTHORPIC_COMMENTCOUNT_BLAHBLAH);
                $propbag->add('select_values', array(
                                                'off'     => NONE,
                                                'append'  => PLUGIN_EVENT_AUTHORPIC_COMMENTCOUNT_APPEND,
                                                'prepend' => PLUGIN_EVENT_AUTHORPIC_COMMENTCOUNT_PREPEND,
                                                'smarty'  => PLUGIN_EVENT_AUTHORPIC_COMMENTCOUNT_SMARTY)
                                             );
                $propbag->add('default', 'off');
                break;

            default:
                return false;
        }
        return true;
    }

    function getLocalProperties() /* no more & */
    {
        return array(
            'realname' => array('desc' => USERCONF_REALNAME,
                                'type' => 'string'),
            'username' => array('desc' => USERCONF_USERNAME,
                                'type' => 'string'),
            'email'    => array('desc' => USERCONF_EMAIL,
                                'type' => 'string')
        );
    }

    function getShow($type, $user)
    {
        global $serendipity;

        $q = "SELECT value FROM {$serendipity['dbPrefix']}profiles WHERE authorid = '{$user}' AND property = '{$type}'";
        $sql = serendipity_db_query($q);

        return (is_array($sql) ? $sql[0]['value'] : "false");
    }

    function checkUser(&$user)
    {
        global $serendipity;

        return ($user['userlevel'] < $serendipity['serendipityUserlevel'] || $user['authorid'] == $serendipity['authorid'] || $serendipity['serendipityUserlevel'] >= USERLEVEL_ADMIN);
    }

    function &getValidUsers()
    {
        global $serendipity;

        if (serendipity_checkPermission('adminUsersMaintainOthers')) {
            $users = serendipity_chainByLevel(serendipity_fetchUsers('', 'hidden'));
        } elseif (serendipity_checkPermission('adminUsersMaintainSame')) {
            $users = serendipity_chainByLevel(serendipity_fetchUsers('', serendipity_getGroups($serendipity['authorid'], true)));
        } else {
            // special for this plugin since it wants us to display same group members for show (only) in the backend
            $ingroups = serendipity_getGroups($serendipity['authorid'], true); // eg standard editor
            $allmembers = serendipity_getGroupUsers($ingroups[0]); // get all group members
            foreach ($allmembers AS $amember) {
                // remove high level CHIEFS and ADMINS members (a NULL empty array item may be an authorgroup_idxA index leftover before we activated to clear authorgroups on DELETE)
                if (!empty($amember['id']) && !serendipity_checkPermission('adminUsersMaintainSame', $amember['id'])) {
                    $slevelmembers[] = array('authorid' => $amember['id'], 'realname' => $amember['author']);
                }
            }
            $users = $slevelmembers ?? serendipity_fetchUsers($serendipity['authorid']);
            $users = $users ?? [];
        }

        return $users;
    }

    function showUsers()
    {
        global $serendipity;

        if (substr($serendipity['version'], 0, 3) >= '3.6' && $serendipity['GET']['adminModule'] == 'personal') {
            return;
        }

        echo '<h2>' . serendipity_specialchars(PLUGIN_EVENT_USERPROFILES_SELECT) . '</h2>'."\n";

        if (!empty($serendipity['POST']['submitProfile'])) {
            echo '<span class="msg_success"><span class="icon-ok-circled" aria-hidden="true"></span> ' . DONE . ': ' . sprintf(SETTINGS_SAVED_AT, serendipity_strftime('%H:%M:%S')) . '</span>';
        }

        if (!empty($serendipity['POST']['submitProfileOptions'])) {
            echo '<span class="msg_success"><span class="icon-ok-circled" aria-hidden="true"></span> ' . DONE . ': ' . sprintf(SETTINGS_SAVED_AT, serendipity_strftime('%H:%M:%S')) . '</span>';
        }
        if (!empty($serendipity['POST']['createVcard']) && (serendipity_checkPermission('adminUsersMaintainSame') || $serendipity['serendipityUserlevel'] == USERLEVEL_EDITOR)) {
            if ($this->createVCard($serendipity['POST']['profileUser'])) {
                echo '<span class="msg_success"><span class="icon-ok-circled" aria-hidden="true"></span> '. DONE . ': ' . sprintf(PLUGIN_EVENT_USERPROFILES_VCARDCREATED_AT, serendipity_strftime('%H:%M:%S')) . '</span>';
                echo '<span class="msg_notice"><span class="icon-info-circled" aria-hidden="true"></span> '. IMPORT_NOTES . ': '. PLUGIN_EVENT_USERPROFILES_VCARDCREATED_NOTE . '</span>';
            }
            else {
                echo '<span class="msg_error"><span class="icon-attention-circled" aria-hidden="true"></span> '. ERROR . ': ' . PLUGIN_EVENT_USERPROFILES_VCARDNOTCREATED . '</span>';
            }
        }

        // check against privileges
        $avail_users =& $this->getValidUsers();

        echo '<form action="?" method="post" class="userprofiles_form">'."\n";
        echo '    <input type="hidden" name="serendipity[adminModule]" value="event_display">'."\n";
        echo '    <input type="hidden" name="serendipity[adminAction]" value="profiles">'."\n";
        echo "    <div class='form_select'>\n";
        echo '        <label for="serendipity_profile_user">' . USER . '</label>';
        echo '        <select id="serendipity_profile_user" name="serendipity[profileUser]">'."\n";
        foreach($avail_users AS $user) {
            echo '          <option value="' . $user['authorid'] . '" ' . (((empty($serendipity['POST']['profileUser']) && ($serendipity['authorid'] == $user['authorid'])) || (isset($serendipity['POST']['profileUser']) && $serendipity['POST']['profileUser'] == $user['authorid'])) ? 'selected="selected"' : '') . '>' . serendipity_specialchars($user['realname']) . '</option>'."\n";
        }
        echo "        </select>\n";
        echo "    </div>\n";
        echo '    <div class="form_buttons">'."\n";
        echo '        <input type="submit" name="serendipity[viewUser]" value="'. VIEW .'">'."\n";
        echo '        <input type="submit" name="submit" value="' . EDIT . '">'."\n";
        echo '        <input type="submit" name="serendipity[editOptions]" value="'. ADVANCED_OPTIONS .'">'."\n";
        // show only when allowed to edit the local_properties
        if (!empty($serendipity['POST']['profileUser']) && empty($serendipity['POST']['editOptions']) && empty($serendipity['POST']['viewUser']) && (serendipity_checkPermission('adminUsersMaintainSame') || ($this->checkUser(serendipity_fetchUsers($serendipity['POST']['profileUser'])[0]) && $serendipity['serendipityUserlevel'] == USERLEVEL_EDITOR))) {
            echo '        <input type="submit" name="serendipity[createVcard]" value="' . PLUGIN_EVENT_USERPROFILES_VCARD . '">'."\n";
        }
        echo "    </div>\n";

        if (!empty($serendipity['POST']['profileUser'])) {
            $user = serendipity_fetchUsers($serendipity['POST']['profileUser']);
            if ($this->checkUser($user[0])) {
                if (!empty($serendipity['POST']['viewUser'])) {
                    $this->showUser($user[0]);
                } elseif (!empty($serendipity['POST']['editOptions']) || !empty($serendipity['POST']['submitProfileOptions'])) {
                    $this->editOptions($user[0]);
                } else {
                    $this->editUser($user[0]);
                }
            } else {
                $this->showUser($user[0]);
            }
        } else {
            if ($serendipity['GET']['adminModule'] != 'personal') {
                $user = serendipity_fetchUsers($serendipity['authorid']);
                $this->editUser($user[0]);
            }
        }
        echo "</form>\n\n";
    }

    function show()
    {
        global $serendipity;

        if ($this->selected()) {
            if (!headers_sent()) {
                header('HTTP/1.0 200');
                header('Status: 200 OK');
            }

            $serendipity['GET']['groupid'] = $serendipity['GET']['groupid'] ?? 1; // defaults to standard editor group

            if (!isset($serendipity['smarty']) || !is_object($serendipity['smarty'])) {
                serendipity_smarty_init();
            }

            $members =& serendipity_db_query("SELECT g.name AS groupname,
                                                     COUNT(e.id) AS posts,
                                                     a.*
                                                FROM {$serendipity['dbPrefix']}authorgroups AS ag
                                     LEFT OUTER JOIN {$serendipity['dbPrefix']}groups AS g
                                                  ON g.id = ag.groupid
                                     LEFT OUTER JOIN {$serendipity['dbPrefix']}authors AS a
                                                  ON ag.authorid = a.authorid
                                     LEFT OUTER JOIN {$serendipity['dbPrefix']}entries AS e
                                                  ON e.authorid = a.authorid
                                               WHERE ag.groupid = " . (int)$serendipity['GET']['groupid'] . "
                                            GROUP BY a.authorid", false, 'assoc');

            $group = serendipity_fetchGroup((int)$serendipity['GET']['groupid']);
            if ('USERLEVEL_' == substr($group['name'], 0, 10)) {
                $group['name'] = constant($group['name']);
            }
            #$_ENV['staticpage_pagetitle'] = 'userprofiles';
            $serendipity['smarty']->assign(array(
                'staticpage_pagetitle' => 'userprofiles',
                'userprofile_groups'   => serendipity_getAllGroups(),
                'selected_group'       => (int)$serendipity['GET']['groupid'],
                'selected_group_data'  => $group,
                'selected_members'     => $members
            ));

            $filename = '/plugin_groupmembers.tpl';
            $tfile = serendipity_getTemplateFile($filename, 'serendipityPath');

            if (!$tfile || $tfile == $filename) {
                $tfile = dirname(__FILE__) . $filename;
            }
            $content = $serendipity['smarty']->fetch('file:'. $tfile);

            echo $content;
        }
    }

    /**
     * PUH! What a hassle! But a need to not show group/profiles without being actually allowed to when someone just uses /index.php?/serendipity[subpage]=userprofiles.
     */
    function checkFrontendGroupOption() {
        global $serendipity;

        $puf = serendipity_plugin_api::enum_plugins('*', false, 'serendipity_plugin_userprofiles');
        foreach ($puf AS $p) {
            if (false !== strpos($p['name'], 'serendipity_plugin_userprofiles:')) {
                $instance = explode(':', $p['name']);
            }
        }

        return serendipity_db_query("SELECT value FROM {$serendipity['dbPrefix']}config WHERE name = 'serendipity_plugin_userprofiles:{$instance[1]}/show_groups'", false, 'assoc');
    }

    function selected()
    {
        global $serendipity;

        if (isset($serendipity['GET']['subpage']) && ($serendipity['GET']['subpage'] == 'userprofiles' || $serendipity['GET']['subpage'] == $serendipity['serendipityHTTPPath'] . 'serendipity[subpage]=userprofiles')) {
            $showgroups = $this->checkFrontendGroupOption();

            if (is_array($showgroups) && serendipity_db_bool($showgroups[0]['value'])) {
                return true;
            }
        }

        return false;
    }

    /**
     * View local properties from user
     *
     * @access private
     * @param array $user  The Userproperties to show
     *
     */
    function showUser(&$user)
    {
        global $serendipity;

        echo '<dl class="userprofiles_show clearfix">'."\n";
        $local_properties = $this->getLocalProperties(); /* no more & */
        foreach($local_properties AS $property => $info) {
            echo '<dt>' . $info['desc'] ."</dt>\n";
            echo '<dd>' . $user[$property] . "</dd>\n";
        }
        echo "</dl>\n";
    }

    function showCol($property, &$info, &$user)
    {
        echo "<tr>\n";
        echo '  <td>' . $info['desc'] . "</td>\n";
        echo "  <td>\n";
        switch($info['type']) {
            case 'html':
                echo '<textarea rows="10" name="serendipity[profile' . $property . ']">' . serendipity_specialchars($user[$property]) . "</textarea>\n";
                break;

            case 'boolean':
                $s = $this->getShow($property, $user['authorid']);
                echo sprintf(PLUGIN_EVENT_USERPROFILES_ILINK . "\n", $property . "true", ((serendipity_db_bool($s)) ? "checked='checked'" : ""), $property, "true", YES);
                echo sprintf(PLUGIN_EVENT_USERPROFILES_LABEL . "\n", $property . "true", YES);
                echo sprintf(PLUGIN_EVENT_USERPROFILES_ILINK . "\n", $property . "false", ((serendipity_db_bool($s)) ? "" : "checked='checked'"), $property, "false", NO);
                echo sprintf(PLUGIN_EVENT_USERPROFILES_LABEL . "\n", $property . "false", NO);
                break;

            case 'date':
                ?> <input type="text" name="serendipity[profile<?php echo $property; ?>_day]" value="<?php echo date("d", $user[$property]); ?>" size="2" maxlength="2">.
                   <input type="text" name="serendipity[profile<?php echo $property; ?>_month]" value="<?php echo date("m", $user[$property]); ?>" size="2" maxlength="2">.
                   <input type="text" name="serendipity[profile<?php echo $property; ?>_year]" value="<?php echo date("Y", $user[$property]); ?>" size="4" maxlength="4">
                <?php
                break;

            case 'string':
            default:
                echo '<input type="text" name="serendipity[profile' . $property . ']" value="' . serendipity_specialchars($user[$property]) . '">'."\n";
        }
        echo "  </td>\n";
        echo "</tr>\n";
    }

    /**
     *
     * edit properties from user
     *
     * @access private
     *
     * @param array $user  The User-properties to edit
     *
     */
    function editUser(&$user)
    {
        global $serendipity;

        if (isset($serendipity['POST']['submitProfile']) && isset($serendipity['POST']['profilebirthday_day']) && isset($serendipity['POST']['profilebirthday_month']) && isset($serendipity['POST']['profilebirthday_year'])) {
            if ($re = checkdate($serendipity['POST']['profilebirthday_month'], $serendipity['POST']['profilebirthday_day'], $serendipity['POST']['profilebirthday_year'])) {
                $serendipity['POST']['profilebirthday'] = mktime(0, 0, 0, $serendipity['POST']['profilebirthday_month'], $serendipity['POST']['profilebirthday_day'], $serendipity['POST']['profilebirthday_year']);
            }
            unset($serendipity['POST']['profilebirthday_month'], $serendipity['POST']['profilebirthday_day'], $serendipity['POST']['profilebirthday_year']);
        }

        echo '<div class="userprofiles_wrap">'."\n";
        echo '<table class="userprofiles_table">'."\n";
        $local_properties = $this->getLocalProperties(); /* no more & */

        foreach($local_properties AS $property => $info) {
            if (isset($serendipity['POST']['submitProfile']) && isset($serendipity['POST']['profile' . $property])) {
                $user[$property] = $serendipity['POST']['profile' . $property];
                serendipity_set_user_var($property, $user[$property], $user['authorid'], false);
            }

            $this->showCol($property, $info, $user);
        }

        $profile =& $this->getConfigVars($user['authorid']);

        foreach($this->properties AS $property => $info) {
            if (isset($serendipity['POST']['submitProfile']) && isset($serendipity['POST']['profile' . $property])) {
                $user[$property]    = $serendipity['POST']['profile' . $property];
                $this->updateConfigVar($property, $profile, $user[$property], $user['authorid']);
                $profile[$property] = $user[$property];
            } else {
                $user[$property] = $profile[$property] ?? null;
            }

            $this->showCol($property, $info, $user);
        }

        echo "</table>\n";
        echo "</div>\n";
        echo '<input type="submit" name="serendipity[submitProfile]" value="' . SAVE . '">' . "\n";
    }

    function editOptions(&$user)
    {
        global $serendipity;

        echo '<div class="userprofiles_wrap">'."\n";
        echo '<table class="userprofiles_table">'."\n";
        $profile =& $this->getConfigVars($user['authorid']);

        foreach($this->option_properties AS $property => $info) {
            if (isset($serendipity['POST']['submitProfileOptions']) && isset($serendipity['POST']['profile' . $property])) {
                $user[$property]    = $serendipity['POST']['profile' . $property];
                $this->updateConfigVar($property, $profile, $user[$property], $user['authorid']);
                $profile[$property] = $user[$property];
            } else {
                $user[$property] = $profile[$property] ?? null;
            }

            $this->showCol($property, $info, $user);
        }
        echo "</table>\n";
        echo "</div>\n";
        echo '<input type="submit" name="serendipity[submitProfileOptions]" value="' . SAVE . '">' . "\n";
    }

    function &getConfigVars($authorid)
    {
        global $serendipity;

        $rows = serendipity_db_query("SELECT * FROM {$serendipity['dbPrefix']}profiles WHERE authorid = " . (int)$authorid);
        if (!is_array($rows)) {
            $empty = array();
            return $empty;
        }

        $profile = array();
        foreach($rows AS $idx => $row) {
            $profile[$row['property']] = $row['value'];
        }

        return $profile;
    }

    function updateConfigVar($property, &$profile, $newvalue, $authorid)
    {
        global $serendipity;

        if (!isset($profile[$property])) {
            return serendipity_db_query("INSERT INTO {$serendipity['dbPrefix']}profiles (authorid, property, value) VALUES ('" . (int)$authorid . "', '" . serendipity_db_escape_string($property) . "', '" . serendipity_db_escape_string($newvalue) . "')");
        } else {
            return serendipity_db_query("UPDATE {$serendipity['dbPrefix']}profiles SET value = '" . serendipity_db_escape_string($newvalue) . "' WHERE property = '" . serendipity_db_escape_string($property) . "' AND authorid = " . (int)$authorid);
        }
    }

    function event_hook($event, &$bag, &$eventData, $addData = null)
    {
        global $serendipity;

        $hooks = &$bag->get('event_hooks');

        if (isset($hooks[$event])) {
            switch($event) {
                case 'css':
                    if (strpos($eventData, '.serendipityAuthorProfile')) {
                        // class exists in CSS, so a user has customized it and we don't need default
                        return true;
                    }
                    $eventData .= '

/* serendipity_event userprofiles start */

main > .serendipityAuthorProfile,
section > .serendipityAuthorProfile,
.container > .serendipityAuthorProfile {
    margin-top: 1.5rem;
}

.serendipityAuthorProfile {
    border: 1px solid #909090;
    width: 300px;
    margin-top: 5px;
    margin-bottom: 5px;
    margin-left: auto;
    margin-right: auto;
    padding: 10px;
}

.serendipityAuthorProfile dt {
    margin-top: 5px;
    font-weight: bold;
}

.serendipityAuthorProfile dd {
    margin-bottom: 5px;
}
.serendipity_authorpic {
    float: right;
    margin: 5px;
    border: 0px;
    display: block;
}

.serendipity_commentcount {
    text-align: right;
}

/* serendipity_event userprofiles end */

';
                    break;


                case 'css_backend':
                    $eventData .= '

/* serendipity_event userprofiles start */

.userprofiles_wrap {
    min-height: .01%;
    -ms-overflow-style: -ms-autohiding-scrollbar;
    overflow-x: auto;
    overflow-y: hidden;
}

.userprofiles_wrap th,
.userprofiles_wrap td {
    white-space: nowrap;
}

.userprofiles_table {
    border: 1px solid #aaa;
    width: 100%;
}

.userprofiles_table tr:nth-child(2n+1) {
    background: #eee;
}
[data-color-mode="dark"] .userprofiles_table tr:nth-child(2n+1) {
    background: var(--color-bg-overlay);
}

.userprofiles_table td {
    border-bottom: 1px solid #aaa;
    padding: .25em;
}
[data-color-mode="dark"] .userprofiles_table td {
    border-bottom-color: var(--color-border-primary);
}

@media only screen and (min-width: 768px) {
    .userprofiles_wrap {
        overflow-y: auto;
    }

    .userprofiles_wrap th,
    .userprofiles_wrap td {
        white-space: normal;
    }

    .userprofiles_table td {
        min-width: 15em;
    }

    .userprofiles_show {
        border: 1px solid #aaa;
        border-bottom: 0;
    }

    .userprofiles_show dt,
    .userprofiles_show dd {
        border-bottom: 1px solid #aaa;
        box-sizing: border-box;
        float: left;
        padding: .25em .5em;
    }

    .userprofiles_show dt {
        border-right: 1px solid #aaa;
        clear: left;
        width: 40%;
    }

    .userprofiles_show dd {
        width: 60%;
        min-height: 2.05rem;
    }
    [data-color-mode="dark"] .userprofiles_show, [data-color-mode="dark"] .userprofiles_show dt, [data-color-mode="dark"] .userprofiles_show dd {
        border-color: var(--color-border-primary);
    }
}

/* serendipity_event userprofiles end */

';
                    break;

                case 'entries_header':
                    if (!empty($serendipity['GET']['viewAuthor'])) {
                        $filename = '/plugin_userprofile.tpl';
                        $tfile = serendipity_getTemplateFile($filename, 'serendipityPath');
                        if (!$tfile || $tfile == $filename) {
                            $tfile = dirname(__FILE__) . $filename;
                        }
                        $profile = $this->getConfigVars($serendipity['GET']['viewAuthor']);
                        $local_properties = $this->getLocalProperties(); /* no more & */
                        foreach($local_properties AS $property => $info) {
                            $profile[$property] = $serendipity['uInfo'][0][$property] ?? null;
                        }

                        $properties = array();
                        $properties = array_merge($this->properties, $this->option_properties);

                        $entry = array('body' => ($profile['hobbies'] ?? null));
                        serendipity_plugin_api::hook_event('frontend_display', $entry);
                        $_profile = ['show_email', 'birthday', 'url', 'city', 'street', 'country', 'occupation', 'yahoo', 'aim', 'jabber', 'icq', 'msn', 'skype'];
                        foreach($_profile AS $prop) {
                            if (!isset($profile[$prop])) $profile[$prop] = null;
                        }
                        $profile['hobbies'] = $entry['body'];

                        $serendipity['smarty']->assign('userProfile', $profile);
                        $serendipity['smarty']->assign('userProfileProperties', $properties);
                        $serendipity['smarty']->assign('userProfileLocalProperties', $local_properties);
                        $serendipity['smarty']->assign('userProfileTitle', PLUGIN_EVENT_USERPROFILES_SHOW);

                        $content = $serendipity['smarty']->fetch('file:'. $tfile);

                        echo $content;
                    }

                    $this->show();
                    break;

                case 'backend_sidebar_entries_event_display_profiles':
                    // ADMIN and CHIEFs shall check in via 'backend_sidebar_users' (< 3.6 backend_sidebar_admin) link, simple EDITORs via personal preferences (only < 3.6)
                    if ($serendipity['GET']['adminAction'] == 'profiles' || $serendipity['serendipityUserlevel'] == USERLEVEL_EDITOR) {
                        $this->checkSchema();
                        $this->showUsers();
                    }
                    break;

                case 'backend_sidebar_admin':// until Styx 3.6
                    if (substr($serendipity['version'], 0, 3) < '3.6') {
?>
                    <li><a href="?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=profiles"><?php echo PLUGIN_EVENT_USERPROFILES_TITLE ?></a></li>
<?php
                    }
                    break;

                case 'backend_sidebar_users':// Up from Styx 3.6
                    if (substr($serendipity['version'], 0, 3) >= '3.6') {
?>
                    <li><a href="?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=profiles"><?php echo PLUGIN_EVENT_USERPROFILES_TITLE ?></a></li>
<?php
                    }
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

                case 'frontend_display':
                    if ($bag->get('scrambles_true_content') && is_array($addData) && isset($addData['no_scramble'])) {
                        break;
                    }
                    // no break [PSR-2] - extends frontend_display_cache

                case 'frontend_display_cache':
                    if (isset($serendipity['view']) && $serendipity['view'] == 'entry') {
                        $this->showCommentcount($eventData);
                    } else {
                        break;
                    }
                    if (!serendipity_db_bool($this->get_config('authorpic', 'false'))) {
                        return true;
                    }

                    if (empty($eventData['author'])) {
                        $tmp = isset($eventData['authorid']) ? serendipity_fetchAuthor($eventData['authorid']) : [];
                        $author = $tmp[0]['realname'] ?? null;
                    } else {
                        $author = $eventData['author'];
                    }

                    $authorname = $author;

                    if (isset($GLOBALS['i18n_filename_to'])) {
                        $author = str_replace($GLOBALS['i18n_filename_from'], $GLOBALS['i18n_filename_to'], $author);
                    }

                    if (serendipity_db_bool($this->get_config('gravatar', 'false')) && isset($eventData['body'])) {
                        $img = 'https://www.gravatar.com/avatar.php?'
                                . 'default=' . $this->get_config('gravatar_default', '80')
                                . '&amp;gravatar_id=' . md5($eventData['email'])
                                . '&amp;size=' . $this->get_config('gravatar_size', '80')
                                . '&amp;border=&amp;rating=' . $this->get_config('gravatar_rating', 'R');
                        $this->found_images[$author] = '<div class="serendipity_authorpic"><img src="' . $img . '" alt="' . AUTHOR . '" title="' . serendipity_specialchars($authorname) . '" /><br /><span>' . serendipity_specialchars($authorname) . '</span></div>';
                        $eventData['body'] = $this->found_images[$author] . $eventData['body'];
                    } elseif (isset($this->found_images[$author]) && isset($eventData['body'])) {
                        // Author image was already found previously. Display it.
                        $eventData['body'] = $this->found_images[$author] . $eventData['body'];
                    } elseif ($img = serendipity_getTemplateFile('img/' . preg_replace('@[^a-z0-9]@i', '_', $author) . '.' . $this->get_config('extension'))) {
                        if (isset($eventData['body'])) {
                            // Author image exists, save it in cache and display it.
                            $this->found_images[$author] = '<div class="serendipity_authorpic"><img src="' . $img . '" alt="' . AUTHOR . '" title="' . serendipity_specialchars($authorname) . '" /><br /><span>' .serendipity_specialchars($authorname) . '</span></div>';
                            $eventData['body'] = $this->found_images[$author] . $eventData['body'];
                        }
                    } else {
                         // No image found, do not try again in next article.
                        $this->found_images[$author] = '';
                    }

                    // Assign smarty variable {$entry.authorpic}
                    $eventData['authorpic'] = $this->found_images[$author];
                    break;

                default:
                    return false;
            }
            return true;
        } else {
            return false;
        }
    }

    function showCommentcount(&$eventData)
    {
        global $serendipity;
        static $commentcount = null;
        static $db_commentcount = null;

        if ($commentcount === null) {
            $commentcount = $this->get_config('commentcount');
        }

        if (!isset($eventData['comment']) || $commentcount == 'off') {
            return false;
        }

        if ($db_commentcount === null && !empty($eventData['entry_id'])) {
            $dbc = serendipity_db_query("SELECT count(c.id) AS counter, c.author
                                    FROM {$serendipity['dbPrefix']}comments AS c
                                   WHERE c.entry_id = " . (int)$eventData['entry_id'] . "
                                GROUP BY c.author");
            $db_commentcount = array();
            if (is_array($dbc)) {
                foreach($dbc AS $row) {
                    $db_commentcount[$row['author']] = $row['counter'];
                }
            }
        }

        $c = $db_commentcount !== null ? ($db_commentcount[$eventData['author']] ?? null) : null; // mid part for sidebar comments

        if ($c !== null) {
            $html_commentcount = '<div class="serendipity_commentcount">';
            if ($c == 1) {
                $html_commentcount .= COMMENT . ' (1)';
            } else {
                $html_commentcount .= COMMENTS . ' (' . $c . ')';
            }
            $html_commentcount .= '</div>';

            if ($commentcount == 'append') {
                $eventData['comment'] .= $html_commentcount;
            } elseif ($commentcount == 'prepend') {
                $eventData['comment'] = $html_commentcount . $eventData['comment'];
            }

            $eventData['plugin_commentcount'] = $html_commentcount;
        }

        return true;
    }

    /**
     * Create a vcard from user
     *
     * @access private
     * @param int $authorid  The UserID to build the vcard
     *
     * @return bool
     */
    function createVCard($authorid)
    {
        global $serendipity;

        include 'Contact_Vcard_Build.php';

        if (!class_exists('Contact_Vcard_Build')) {
            return false;
        }

        $authorres = $this->getConfigVars($authorid);
        if (empty($authorres)) {
            return false;
        }
        $name = explode(" ", $serendipity['POST']['profilerealname']);
        $city = explode(" ", $serendipity['POST']['profilecity']);

        $vcard = new Contact_Vcard_Build();
        $vcard->setFormattedName($serendipity['POST']['profilerealname']);
        $vcard->setName(($name[1] ?? ''), $name[0], "", "", "");
        $vcard->addEmail($serendipity['POST']['profileemail']);
        $vcard->addParam('TYPE', 'WORK');
        $vcard->addParam('TYPE', 'PREF');
        $vcard->addAddress(
            "",
            "",
            $serendipity['POST']['profilestreet'],
            $city[1] ?? '',
            "",
            $city[0],
            $serendipity['POST']['profilecountry']
        );
        $vcard->addParam('TYPE', 'WORK');
        $vcard->setURL($serendipity['POST']['profileurl']);

        $card = $serendipity['serendipityPath'].$serendipity['uploadPath'].
            serendipity_makeFilename($serendipity['POST']['profilerealname']).".vcf";

        if(!$fp = @fopen($card,"w")) {
            return false;
        }
        fwrite($fp, $vcard->fetch());
        fclose($fp);

        $filename = serendipity_makeFilename($serendipity['POST']['profilerealname']);
        $q = "SELECT id
                FROM {$serendipity['dbPrefix']}images
               WHERE name = '$filename'
                 AND extension = 'vcf'";
        $res = serendipity_db_query($q, true, 'assoc');
        if (!is_array($res)) {
            serendipity_insertImageInDatabase(basename($card),'');
        }

        return true;

    }

    function checkSchema()
    {
        global $serendipity;

        switch($this->get_config('dbversion')) {
            case '':
                $q   = "CREATE TABLE {$serendipity['dbPrefix']}profiles (
                        authorid int(11) default '0',
                        property varchar(255) not null,
                        value text
                        ) {UTF_8};";
                $sql = serendipity_db_schema_import($q);

                $q   = "CREATE INDEX userprofile_idx ON {$serendipity['dbPrefix']}profiles (authorid);";
                $sql = serendipity_db_schema_import($q);

                if ($serendipity['dbType'] == 'mysqli') {
                    $serendipity['db_server_info'] = $serendipity['db_server_info'] ?? mysqli_get_server_info($serendipity['dbConn']); // eg.  == 5.5.5-10.4.11-MariaDB
                    if (stristr(strtolower($serendipity['db_server_info']), 'mariadb')) {
                        $db_version_match = explode('-', $serendipity['db_server_info']);
                        if (version_compare($db_version_match[1], '10.5.0', '>=')) {
                            $q = "CREATE UNIQUE INDEX userprofile_uidx ON {$serendipity['dbPrefix']}profiles (authorid, property);";
                        } elseif (version_compare($db_version_match[1], '10.3.0', '>=')) {
                            $q = "CREATE UNIQUE INDEX userprofile_uidx ON {$serendipity['dbPrefix']}profiles (authorid, property(239));"; // max key 1000 bytes
                        } else {
                            $q = "CREATE UNIQUE INDEX userprofile_uidx ON {$serendipity['dbPrefix']}profiles (authorid, property(180));"; // 191 - old MyISAMs
                        }
                    } else {
                        $q = "CREATE UNIQUE INDEX userprofile_uidx ON {$serendipity['dbPrefix']}profiles (authorid, property(180));"; // Oracle Mysql/InnoDB max key 767 bytes
                    }
                } else {
                    $q   = "CREATE UNIQUE INDEX userprofile_uidx ON {$serendipity['dbPrefix']}profiles (authorid, property);";
                }
                $sql = serendipity_db_schema_import($q);
                break;
        }
        $this->set_config('dbversion', '1');
    }

    function install()
    {
        global $serendipity;

        $this->checkSchema();
    }

}

/* vim: set sts=4 ts=4 expandtab : */
?>