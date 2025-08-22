<?php

# (c) by Falk Döring


if (IN_serendipity !== true) {
    die ("Don't hack!");
}

@serendipity_plugin_api::load_language(dirname(__FILE__));

class serendipity_plugin_userprofiles extends serendipity_plugin
{

    function introspect(&$propbag)
    {
        $propbag->add('name',        PLUGIN_USERPROFILES_NAME);
        $propbag->add('description', PLUGIN_USERPROFILES_NAME_DESC);
        $propbag->add('author',      "Falk Doering");
        $propbag->add('stackable',   false);
        $propbag->add('version',     '2.0.0');
        $propbag->add('configuration', array('title', 'show_groups', 'show_users'));
        $propbag->add('requirements',  array(
            'serendipity' => '5.0',
            'smarty'      => '4.1',
            'php'         => '8.2'
        ));
        $propbag->add('groups',       array('FRONTEND_VIEWS'));
        $this->dependencies = array('serendipity_event_userprofiles' => 'keep');
    }

    function introspect_config_item($name, &$propbag)
    {
        switch($name) {
            case 'title':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_USERPROFILES_TITLE);
                $propbag->add('description', PLUGIN_USERPROFILES_TITLE_DESC);
                $propbag->add('default',     PLUGIN_USERPROFILES_TITLE_DEFAULT);
                break;

            case 'show_groups':
                $propbag->add('type',        'boolean');
                $propbag->add('name',        PLUGIN_USERPROFILES_SHOWGROUPS);
                $propbag->add('description', PLUGIN_USERPROFILES_SHOWGROUPS_DESC);
                $propbag->add('default',     false);
                break;

            case 'show_users':
                $propbag->add('type',        'boolean');
                $propbag->add('name',        PLUGIN_USERPROFILES_SHOWAUTHORS);
                $propbag->add('description', PLUGIN_USERPROFILES_SHOWAUTHORS_DESC);
                $propbag->add('default',     true);
                break;

            default:
                return false;
        }
        return true;
    }

    function example() {
        return '<span class="msg_notice"><span class="icon-info-circled" aria-hidden="true"></span> ' . PLUGIN_USERPROFILES_SHOWWARNING . '</span>';
    }

    function generate_content(&$title)
    {
        global $serendipity;

        $title = $this->get_config('title');

        echo '<ul class="plainList">'."\n";
        if (serendipity_db_bool($this->get_config('show_users', 'true'))) {
            echo $this->displayUserList();
        }

        if (serendipity_db_bool($this->get_config('show_groups', 'false'))) {
            echo '                        <li><a href="' . $serendipity['baseURL'] . $serendipity['indexFile'] . '?/serendipity[subpage]=userprofiles">' . USERCONF_GROUPS . "</a></li>\n";
        }
        echo "                    </ul>\n";
    }

    function displayUserList()
    {
        global $serendipity;

        $userlist = serendipity_fetchUsers();

        $content = "";
        foreach($userlist AS $user) {
            $entryLink = serendipity_authorURL($user);
            $content .= sprintf("                        <li><a href=\"%s\" title=\"%s\">%s</a></li>\n",
                      $entryLink,
                      htmlspecialchars($user['realname']),
                      htmlspecialchars($user['realname']));
        }

        return $content;
    }

}

?>