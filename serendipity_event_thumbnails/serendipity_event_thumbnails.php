<?php

declare(strict_types=1);

if (IN_serendipity !== true) {
    die ("Don't hack!");
}

@serendipity_plugin_api::load_language(dirname(__FILE__));

class serendipity_event_thumbnails extends serendipity_event
{
    function introspect(&$propbag)
    {
        global $serendipity;

        $propbag->add('name', THUMBPAGE_TITLE);
        $propbag->add('description', THUMBPAGE_TITLE_BLAHBLAH);
        $propbag->add('event_hooks',  array(
            'entries_header' => true,
            'entry_display' => true));
        $propbag->add('configuration', array('number'));
        $propbag->add('stackable',     false);
        $propbag->add('author',        'Cameron MacFarland');
        $propbag->add('version', '2.0.0');
        $propbag->add('requirements',  array(
            'serendipity' => '5.0',
            'smarty'      => '4.1',
            'php'         => '8.2'
        ));
        $propbag->add('groups', array('IMAGES'));
        $this->dependencies = array('serendipity_plugin_photoblog' => 'remove',
                                    'serendipity_event_photoblog' => 'keep');
    }

    function introspect_config_item($name, &$propbag)
    {
        switch($name) {
            case 'number':
                $propbag->add('type',           'string');
                $propbag->add('name',           THUMBPAGE_NUMBER);
                $propbag->add('description',    THUMBPAGE_NUMBER_BLAHBLAH);
                $propbag->add('default',        5);
                break;

            default:
                return false;
        }
        return true;
    }

    function getPhoto($entryid)
    {
        global $serendipity;

        $q = "SELECT * FROM {$serendipity['dbPrefix']}photoblog WHERE entryid=" . (int)$entryid;
        $row = serendipity_db_query($q, true);

        if (!isset($row) || !is_array($row)) {
            $row = null;
        }

        return $row;
    }

    function show()
    {
        global $serendipity;

        if (isset($serendipity['GET']['tnpage']) && $serendipity['GET']['tnpage'] == 'thumbs') {
            $title = '';
            if (!isset($serendipity['smarty']) || !is_object($serendipity['smarty'])) {
                serendipity_smarty_init();
            }
            $_ENV['staticpage_pagetitle'] = 'thumbs';
            $serendipity['smarty']->assign('staticpage_pagetitle', 'thumbs');
            $this->generate_content($title);
        }
    }

    function generate_content(&$title)
    {
        global $serendipity;

        $title = THUMBPAGE_TITLE;

        if (isset($serendipity['GET']['tnpage']) && $serendipity['GET']['tnpage'] != 'thumbs') {
            return true;
        }

        if (!headers_sent()) {
            header('HTTP/1.0 200');
            header('Status: 200 OK');
        }

        $cols = $this->get_config('number');

        $entries = serendipity_db_query("SELECT id,
                                                title,
                                                timestamp
                                           FROM {$serendipity['dbPrefix']}entries
                                          WHERE isdraft = 'false'
                                       ORDER BY timestamp DESC");

        if (isset($entries) && is_array($entries)) {
            echo "<div class=\"c$cols col serendipity_image_block\">\n";
            foreach ($entries AS $k => $entry) {
                echo '<div style="margin: 5px">';
                serendipity_initPermalinks();
                $entryLink = serendipity_archiveURL(
                               $entry['id'],
                               $entry['title'],
                               'serendipityHTTPPath',
                               true,
                               array('timestamp' => $entry['timestamp'])
                            );
                $photo = $this->getPhoto($entry['id']);
                if (isset($photo)) {
                    $file = serendipity_fetchImageFromDatabase($photo['photoid'], (defined('IN_serendipity_admin') ? 'discard' : 'read'));
                    $imgsrc = $serendipity['serendipityHTTPPath'] . $serendipity['uploadHTTPPath'] . $file['path'] . $file['name'] . '.' . $file['thumbnail_name'] .'.'. $file['extension'];
                    $thumbbasename = $file['path'] . $file['name'] . '.' . $file['thumbnail_name'] . '.' . $file['extension'];
                    $thumbName     = $serendipity['serendipityHTTPPath'] . $serendipity['uploadHTTPPath'] . $thumbbasename;
                    $thumbsize     = @getimagesize($serendipity['serendipityPath'] . $serendipity['uploadPath'] . $thumbbasename);
                }

                echo '<a class="serendipity_image_link" href="' . $entryLink . '" title="' . htmlspecialchars($entry['title'], ENT_COMPAT, LANG_CHARSET) . '">';
                if (isset($photo)) {
                    echo '<img class="serendipity_image_left" src="' . $imgsrc . '" width=' . $thumbsize[0] . ' height=' . $thumbsize[1];
                    if (isset($id) && ($id == $entry['id'])) {
                        echo ' border=4';
                    }
                    echo ' />';
                } else {
                    if (isset($id) && ($id == $entry['id'])) {
                        echo '<b>';
                    }
                    echo $entry['title'];
                    if (isset($id) && ($id == $entry['id'])) {
                        echo '</b>';
                    }
                }
                echo "</a></div>\n";
            }
            echo "</div>\n";
        }
    }

    function event_hook($event, &$bag, &$eventData, $addData = null)
    {
        global $serendipity;

        $hooks = &$bag->get('event_hooks');

        if (isset($hooks[$event])) {
        switch($event) {
            case 'entry_display':
                if (isset($serendipity['GET']['tnpage']) && $serendipity['GET']['tnpage'] == 'thumbs') {
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

            default:
                break;
            }
        } else {
            return false;
        }
    }

}

/* vim: set sts=4 ts=4 expandtab : */
?>