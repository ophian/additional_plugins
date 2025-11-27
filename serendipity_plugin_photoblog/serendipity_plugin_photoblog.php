<?php

declare(strict_types=1);

if (IN_serendipity !== true) {
    die ("Don't hack!");
}

@serendipity_plugin_api::load_language(dirname(__FILE__));

class serendipity_plugin_photoblog extends serendipity_plugin {

    function introspect(&$propbag)
    {
        $propbag->add('name',        PLUGIN_PHOTOBLOG_TITLE);
        $propbag->add('description', PLUGIN_PHOTOBLOG_BLAHBLAH);
        $propbag->add('configuration', array('number', 'showpicsonly'));
        $propbag->add('requirements',  array(
            'serendipity' => '5.0',
            'smarty'      => '4.1',
            'php'         => '8.2'
        ));
        $propbag->add('author',        'Cameron MacFarland, Ian Styx');
        $propbag->add('version',     '2.1.1');
        $propbag->add('groups', array('IMAGES'));
        $this->dependencies = array('serendipity_event_thumbnails' => 'keep');
    }

    function introspect_config_item($name, &$propbag)
    {
        switch($name) {
            case 'number':
                $propbag->add('type',           'string');
                $propbag->add('name',           PLUGIN_PHOTOBLOG_NUMBER);
                $propbag->add('description',    PLUGIN_PHOTOBLOG_NUMBER_BLAHBLAH);
                $propbag->add('default',        5);
                break;

            case 'showpicsonly':
                $propbag->add('type',           'boolean');
                $propbag->add('name',           PLUGIN_PHOTOBLOG_SHOWPICSONLY);
                $propbag->add('description',    PLUGIN_PHOTOBLOG_SHOWPICSONLY_BLAHBLAH);
                $propbag->add('default',        'false');
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

    function generate_content(&$title)
    {
        global $serendipity;

        $number = $this->get_config('number');
        $showpicsonly = $this->get_config('showpicsonly');

        if (!$number || !is_numeric($number) || $number < 1) {
            $number = 5;
        }

        $title = PLUGIN_PHOTOBLOG_TITLE;

        if (!isset($serendipity['GET']['id']) || !is_numeric($serendipity['GET']['id'])) {
            $number = $number * $number + 1;
            $entries = serendipity_db_query("SELECT id,
                                                title,
                                                timestamp
                                           FROM {$serendipity['dbPrefix']}entries
                                          WHERE isdraft = 'false'
                                       ORDER BY timestamp DESC
                                          LIMIT $number");
        } else {
            $id = serendipity_db_escape_string($serendipity['GET']['id']);
            $entries1 = serendipity_db_query("SELECT id,
                                                title,
                                                timestamp
                                           FROM {$serendipity['dbPrefix']}entries
                                          WHERE isdraft = 'false'
                                            AND id > $id
                                       ORDER BY timestamp ASC
                                          LIMIT $number");
            $number++;
            $entries2 = serendipity_db_query("SELECT id,
                                                title,
                                                timestamp
                                           FROM {$serendipity['dbPrefix']}entries
                                          WHERE isdraft = 'false'
                                            AND id <= $id
                                       ORDER BY timestamp DESC
                                          LIMIT $number");
            if (isset($entries1) && is_array($entries1) && isset($entries2) && is_array($entries2)) {
                $entries = array_merge(array_reverse($entries1), $entries2);
            } elseif (isset($entries1) && is_array($entries1)) {
                $entries = array_reverse($entries1);
            } elseif (isset($entries2) && is_array($entries2)) {
                $entries = $entries2;
            }
        }

        if (isset($entries) && is_array($entries)) {

            foreach ($entries as $k => $entry) {
                $entryLink = serendipity_archiveURL(
                               $entry['id'],
                               $entry['title'],
                               'serendipityHTTPPath',
                               true,
                               array('timestamp' => $entry['timestamp'])
                            );
                $photo = $this->getPhoto($entry['id']);

                if (($showpicsonly == 'true') && (isset($photo)) || ($showpicsonly != 'true')) {
                    if (isset($photo)) {
                        $file = serendipity_fetchImageFromDatabase((int) $photo['photoid']);
                        $imgFSPAvif = $serendipity['serendipityPath'] . $serendipity['uploadPath'] . $file['path'] . '.v/' . $file['name'] . '.' . $file['thumbnail_name'] . '.avif';
                        $imgsrcAvif = (file_exists($imgFSPAvif) ? $serendipity['serendipityHTTPPath'] . $serendipity['uploadHTTPPath'] . $file['path'] . '.v/' . $file['name'] . '.' . $file['thumbnail_name'] . '.avif' : '');
                        $imgFSPWebp = $serendipity['serendipityPath'] . $serendipity['uploadPath'] . $file['path'] . '.v/' . $file['name'] . '.' . $file['thumbnail_name'] . '.webp';
                        $imgsrcWebp = (file_exists($imgFSPWebp) ? $serendipity['serendipityHTTPPath'] . $serendipity['uploadHTTPPath'] . $file['path'] . '.v/' . $file['name'] . '.' . $file['thumbnail_name'] . '.webp' : '');
                        $imgsrcAvif = @filesize($imgFSPAvif) < @filesize($imgFSPWebp) ? $imgsrcAvif : '';
                        $imgsrc = $serendipity['serendipityHTTPPath'] . $serendipity['uploadHTTPPath'] . $file['path'] . $file['name'] . '.' . $file['thumbnail_name'] . '.' . $file['extension'];
                        $thumbsize  = @getimagesize($serendipity['serendipityPath'] . $serendipity['uploadPath'] . $file['path'] . $file['name'] . '.' . $file['thumbnail_name'] . '.' . $file['extension']);
                        $img = '
    <!-- s9ymdb:' . $photo['photoid'] . ' -->
    <picture>
        <source type="image/avif" srcset="' . $imgsrcAvif . '">
        <source type="image/webp" srcset="' . $imgsrcWebp . '">
        <img class="serendipity_image_center" src="' . $imgsrc . '" width="' . $thumbsize[0] . '" height="' . $thumbsize[1] . '" loading="lazy" alt="" />
    </picture>
';
                    }

                    if (!isset($photo)) {
                        echo '<p>';
                    }
                    echo '<a href="' . $entryLink . '" title="' . htmlspecialchars($entry['title']) . '">';
                    if (isset($photo)) {
                        echo $img;
                    } else {
                        if (isset($id) && ($id == $entry['id'])) {
                            echo '<b>';
                        }
                        echo $entry['title'];
                        if (isset($id) && ($id == $entry['id'])) {
                            echo '</b>';
                        }
                    }
                    echo '</a>';
                    if (!isset($photo)) {
                        echo '</p>';
                    }
                }
            }
        }
    }

}

/* vim: set sts=4 ts=4 expandtab : */
?>