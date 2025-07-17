<?php

declare(strict_types=1);

if (IN_serendipity !== true) {
    die ("Don't hack!");
}

@serendipity_plugin_api::load_language(dirname(__FILE__));

class serendipity_event_assigncategories extends serendipity_event
{
    var $title = PLUGIN_ASSIGNCATEGORIES_NAME;

    function introspect(&$propbag)
    {
        global $serendipity;

        $propbag->add('name',          PLUGIN_ASSIGNCATEGORIES_NAME);
        $propbag->add('description',   PLUGIN_ASSIGNCATEGORIES_DESC);
        $propbag->add('stackable',     false);
        $propbag->add('author',        'Garvin Hicking, Matthias Mees, Ian Styx');
        $propbag->add('version',       '2.0.0');
        $propbag->add('requirements',  array(
            'serendipity' => '5.0',
            'php'         => '8.2'
        ));
        $propbag->add('event_hooks',    array(
            'backend_sidebar_entries'   => true,
            'backend_sidebar_entries_event_display_assigncategories'    => true,
            'frontend_generate_plugins' => true
        ));
        $propbag->add('groups', array('BACKEND_FEATURES'));
    }

    function event_hook($event, &$bag, &$eventData, $addData = null)
    {
        global $serendipity;

        $hooks = &$bag->get('event_hooks');

        if (isset($hooks[$event])) {
            switch($event) {
                case 'backend_sidebar_entries':
                    if ($this->check()) {
                        echo '                        <li class="list-flex"><div class="flex-column-1"><a href="?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=assigncategories">' . PLUGIN_ASSIGNCATEGORIES_NAME . "</a></div></li>\n";
                    }
                    break;

                case 'backend_sidebar_entries_event_display_assigncategories':
                    $this->showAssignment();
                    break;

                default:
                    return false;

            }
            return true;
        } else {
            return false;
        }
    }

    function &getAllEntries()
    {
        global $serendipity;

        $rows = serendipity_db_query("SELECT e.id, e.title, c.categoryid
                                        FROM {$serendipity['dbPrefix']}entries AS e
                             LEFT OUTER JOIN {$serendipity['dbPrefix']}entrycat AS ec
                                          ON e.id = ec.entryid
                             LEFT OUTER JOIN {$serendipity['dbPrefix']}category AS c
                                          ON ec.categoryid = c.categoryid
                                    ORDER BY e.title ASC");
        $entries = array();
        foreach($rows AS $row) {
            $entries[$row['id']]['title'] = $row['title'];
            if (!empty($row['categoryid'])) {
                $entries[$row['id']]['categories'][] = $row['categoryid'];
            }
        }

        return $entries;
    }

    function check()
    {
        global $serendipity;

        if (function_exists('serendipity_checkPermission')) {
            return serendipity_checkPermission('adminCategories');
        } elseif ($serendipity['serendipityUserlevel'] < USERLEVEL_CHIEF) {
            return false;
        } else {
            return true;
        }
    }

    function updateCategories(&$entries)
    {
        global $serendipity;

        foreach($entries AS $entryid => $entry) {
            $entries[$entryid]['categories'] = array();
        }

        foreach($serendipity['POST']['assigncat'] AS $categoryid => $entrylist) {
            serendipity_db_query("DELETE FROM {$serendipity['dbPrefix']}entrycat WHERE categoryid = " . (int)$categoryid);
            foreach($entrylist AS $entry) {
                serendipity_db_query("INSERT INTO {$serendipity['dbPrefix']}entrycat (entryid, categoryid) VALUES (" . (int)$entry . ", " . (int)$categoryid . ")");
                $entries[$entry]['categories'][] = $categoryid;
            }
        }

        echo '<span class="msg_success"><span class="icon-ok-circled" aria-hidden="true"></span> '. CATEGORY_SAVED .'</span>';
    }

    function showAssignment()
    {
        global $serendipity;

        if (!$this->check()) {
            return false;
        }

        echo '<h2>' . PLUGIN_ASSIGNCATEGORIES_NAME . "</h2>\n\n";

        $entries = $this->getAllEntries();

        if (!empty($serendipity['POST']['submit'])) {
            $this->updateCategories($entries);
        }

        echo '<form id="assigncategories" action="?" method="post">' . "\n";
        echo '    <input type="hidden" name="serendipity[adminModule]" value="event_display">' . "\n";
        echo '    <input type="hidden" name="serendipity[adminAction]" value="assigncategories">' . "\n";

        $cats = serendipity_fetchCategories('all');

        foreach ($cats AS $cat_data) {
            echo '    <div class="form_multiselect">' . "\n";
            echo '        <label for="serendipity_assigncat_'  . $cat_data['categoryid'] . '" class="block_level">🏷️ ' . htmlspecialchars($cat_data['category_name']) . "</label>\n";
            echo '        <select id="serendipity_assigncat_'  . $cat_data['categoryid'] . '" size="5" name="serendipity[assigncat][' . $cat_data['categoryid'] . '][]" multiple="true">' . "\n";
            if (is_array($entries) && !empty($entries)) {
                foreach($entries AS $entryid => $entry) {
                    echo '            <option value="' . $entryid . '"' . (isset($entry['categories']) && in_array($cat_data['categoryid'], (array)$entry['categories']) ? ' selected="selected"' : '') . '>' . htmlspecialchars(trim($entry['title'])) . "</option>\n";
                }
            }
            echo "        </select>\n";
            echo "    </div>\n";
        }

        echo '    <div class="form_buttons"><input type="submit" name="serendipity[submit]" value="' . SAVE . '"></div>' . "\n";
        echo "</form>\n\n";
    }

}

?>