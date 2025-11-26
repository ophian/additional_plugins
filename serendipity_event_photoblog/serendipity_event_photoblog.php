<?php

declare(strict_types=1);

if (IN_serendipity !== true) {
    die ("Don't hack!");
}

@define('PLUGIN_EVENT_PHOTOBLOG_VERSION', '2.1.0');// necessary, as used for db install checkScheme

@serendipity_plugin_api::load_language(dirname(__FILE__));

class serendipity_event_photoblog extends serendipity_event
{
    public $title = PLUGIN_EVENT_PHOTOBLOG_TITLE;

    function introspect(&$propbag)
    {
        global $serendipity;

        $propbag->add('name',          PLUGIN_EVENT_PHOTOBLOG_TITLE);
        $propbag->add('description',   PLUGIN_EVENT_PHOTOBLOG_DESC);
        $propbag->add('stackable',     false);
        $propbag->add('author',        'Cameron MacFarland, Ian Styx');
        $propbag->add('requirements',  array(
            'serendipity' => '5.0',
            'smarty'      => '4.1',
            'php'         => '8.2'
        ));
        $propbag->add('version',   PLUGIN_EVENT_PHOTOBLOG_VERSION);

        $propbag->add('event_hooks',    array(
            'backend_display'   => true,
            'frontend_display'  => true,
            'entry_display'     => true
        ));
        $propbag->add('groups', array('IMAGES'));

        $this->supported_properties = array('photoname');
    }

    function generate_content(&$title)
    {
        $title = $this->title;
    }

    function install()
    {
        $this->checkScheme();
    }

    function checkScheme()
    {
        global $serendipity;

        $version = $this->get_config('version', '0.9');

        if ($version != PLUGIN_EVENT_PHOTOBLOG_VERSION) {
            if (version_compare($version, '1.0', '<'))  {
                $q   = "CREATE TABLE {$serendipity['dbPrefix']}photoblog (
                            entryid int(11) default null,
                            photoid int(11) default null
                        )";
                $sql = serendipity_db_schema_import($q);

                $q   = "CREATE INDEX kentryid ON {$serendipity['dbPrefix']}photoblog (entryid);";
                $sql = serendipity_db_schema_import($q);

            }
            if (version_compare($version, '1.2', '<')) {
                $q   = "ALTER TABLE {$serendipity['dbPrefix']}photoblog ADD use_thumbnail {BOOLEAN};";
                $sql = serendipity_db_schema_import($q);
                $q   = "UPDATE {$serendipity['dbPrefix']}photoblog SET use_thumbnail = '';";
                serendipity_db_query($q);
            }
            $this->set_config('version', PLUGIN_EVENT_PHOTOBLOG_VERSION);
        }
    }

    function addPhoto($entryid, $photoid, $thumb = false)
    {
        global $serendipity;

        $q = "INSERT INTO {$serendipity['dbPrefix']}photoblog (entryid, photoid, use_thumbnail) VALUES (" . (int)$entryid . ", " . (int)$photoid . ", " . (int)$thumb .")";
        serendipity_db_query($q);
    }

    function updatePhoto($entryid, $photoid, $thumb = false)
    {
        global $serendipity;

        $q = "UPDATE {$serendipity['dbPrefix']}photoblog SET photoid = " . (int)$photoid . ", use_thumbnail = " . (int)$thumb ." WHERE entryid = " . (int)$entryid;
        serendipity_db_query($q);
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

    function deletePhoto($entryid)
    {
        global $serendipity;

        $q = "DELETE FROM {$serendipity['dbPrefix']}photoblog WHERE entryid = " . (int)$entryid;
        serendipity_db_query($q);
    }

    function parsePhotoname($name)
    {
        global $serendipity;

        $use_thumbnail = 0;
        $bits = explode("/", $name);
        $filename = array_pop($bits);
        $filebits = explode(".", $filename);
        if (in_array($serendipity['thumbSuffix'], $filebits) || in_array("serendipityThumb", $filebits)) {
            $use_thumbnail = 1;
        }
        $ext = array_pop($filebits);
        $f = $filebits[0];
        $fullpath = implode("/", $bits);
        $uploads = $serendipity['serendipityHTTPPath'] . $serendipity['uploadHTTPPath'];
        $path = substr($fullpath, strlen($uploads)) . "/";
        if ($path == '/') {
            $path = '';
        }
        $q = "SELECT * FROM {$serendipity['dbPrefix']}images WHERE name='" . serendipity_db_escape_string($f) . "' and extension='" . serendipity_db_escape_string($ext) . "' and path='" . serendipity_db_escape_string($path) . "'" ;
        $file = serendipity_db_query($q, true);

        if (!isset($file) || !is_array($file)) {
// redundant
#            $thumb = array_pop($filebits);
#            $f = $filebits[0];
#            $q = "SELECT * FROM {$serendipity['dbPrefix']}images WHERE name='" . serendipity_db_escape_string($f) . "' and extension='" . serendipity_db_escape_string($ext) . "' and path='" . serendipity_db_escape_string($path) . "'" ;
#            $file = serendipity_db_query($q, true);
#            if (!isset($file) || !is_array($file)) {
                echo "Photoblog: Couldn't find file";
                $file = null;
#               }
        }
        if (is_array($file)) {
            $file['use_thumbnail'] = $use_thumbnail;
        }

        return $file;
    }

    function pb_backend_display()
    {
        global $serendipity;

        if ($this->get_config('version') != PLUGIN_EVENT_PHOTOBLOG_VERSION) {
            $this->checkScheme();
        }

        $photoname = '';
        if (!empty($serendipity['POST']['properties']['photoname'])) {
            $file = $this->parsePhotoname($serendipity['POST']['properties']['photoname']);
        } elseif (isset($serendipity['GET']['id'])) {
            $row = $this->getPhoto($serendipity['GET']['id']);
            if (isset($row)) {
                $file = serendipity_fetchImageFromDatabase((int) $row['photoid']);
                if ($row['use_thumbnail'] === 'true' || $row['use_thumbnail'] === 't' || $row['use_thumbnail'] === 1) {
                    $file['use_thumbnail'] = 'true';
                }
            }
        }
        if (isset($file)) {
            $thumbstring = $this->return_thumbstr($file);
            $photoname = $serendipity['serendipityHTTPPath'] . $serendipity['uploadHTTPPath'] . $file['path'] . $file['name'] .$thumbstring.'.'. $file['extension'];
        }
        $window = $serendipity['enableBackendPopup'] === false ? 'serendipity.openPopup' : 'window.open';

?>

            <fieldset id="edit_entry_photoblog" class="entryproperties_photoblog">
                <span class="wrap_legend"><legend><?php echo PLUGIN_EVENT_PHOTOBLOG_TITLE; ?></legend></span>
                <span class="msg_notice"><span class="icon-info-circled" aria-hidden="true"></span> <?php echo PLUGIN_EVENT_PHOTOBLOG_SELECTPHOTO; ?></span>
                <div class="form_field">
                    <input class="input_textbox" id="photoname" type="text" name="serendipity[properties][photoname]" readonly="true" size="30" value="<?php echo $photoname; ?>" />
                    <input class="serendipityPrettyButton input_button" type="button" name="addPhoto" value="Photo" onclick="<?=$window?>('serendipity_admin.php?serendipity[adminModule]=media&serendipity[filename_only]=true&serendipity[htmltarget]=photoname&serendipity[noBanner]=true&serendipity[noSidebar]=true&serendipity[noFooter]=true&serendipity[showMediaToolbar]=false&serendipity[showUpload]=false', 'ImageSel', 'width=800,height=600,toolbar=no,scrollbars=1,scrollbars,resize=1,resizable=1');" />
                    <input class="serendipityPrettyButton input_button" type="button" name="delPhoto" value="Clear" onclick="document.getElementById('photoname').value = '';" />
                </div>
            </fieldset>

<?php
    }

    function pb_backend_save($eventData)
    {
        global $serendipity;

        if (!isset($serendipity['POST']['properties']) ||
            !is_array($serendipity['POST']['properties']) ||
            !isset($eventData['id']) ||
            (isset($serendipity['POST']['preview']) && $serendipity['POST']['preview'] == 'true') ) {
            return true;
        }

        $prop_val = $serendipity['POST']['properties']['photoname'] ?? null;

        $row = $this->getPhoto($eventData['id']);

        if (isset($row)) {
            if (!empty($prop_val)) {
                $file = $this->parsePhotoname($prop_val);
                $this->updatePhoto($eventData['id'], $file['id'], $file['use_thumbnail']);
            } else {
                $this->deletePhoto($eventData['id']);
            }
        } elseif (!empty($prop_val)) {
            $file = $this->parsePhotoname($prop_val);
            $this->addPhoto($eventData['id'], $file['id'], $file['use_thumbnail']);
        }
    }

    function pb_entry_display(&$eventData)
    {
        global $serendipity;

        if (isset($eventData[0]['properties']) && is_array($eventData[0]['properties'])) {
            unset($eventData[0]['properties']['ep_cache_body']);
            unset($eventData[0]['properties']['ep_cache_extended']);
        }
        if (isset($serendipity['POST']['preview']) && $serendipity['POST']['preview'] == 'true') {
            $prop_val = $serendipity['POST']['properties']['photoname'] ?? null;
            if (!empty($prop_val)) {
                $file = $this->parsePhotoname($prop_val);
                $thumbstring = $this->return_thumbstr($file);
                $imgFSPAvif = $serendipity['serendipityPath'] . $serendipity['uploadPath'] . $file['path'] . '.v/' . $file['name'] . $thumbstring . '.avif';
                $imgsrcAvif = (file_exists($imgFSPAvif) ? $serendipity['serendipityHTTPPath'] . $serendipity['uploadHTTPPath'] . $file['path'] . '.v/' . $file['name'] . $thumbstring . '.avif' : '');
                $imgFSPWebp = $serendipity['serendipityPath'] . $serendipity['uploadPath'] . $file['path'] . '.v/' . $file['name'] . $thumbstring . '.webp';
                $imgsrcWebp = (file_exists($imgFSPWebp) ? $serendipity['serendipityHTTPPath'] . $serendipity['uploadHTTPPath'] . $file['path'] . '.v/' . $file['name'] . $thumbstring . '.webp' : '');
                $imgsrcAvif = @filesize($imgFSPAvif) < @filesize($imgFSPWebp) ? $imgsrcAvif : '';
                $imgsrc = $serendipity['serendipityHTTPPath'] . $serendipity['uploadHTTPPath'] . $file['path'] . $file['name'] . $thumbstring . '.' . $file['extension'];
                $thumbsize  = @getimagesize($serendipity['serendipityPath'] . $serendipity['uploadPath'] . $file['path'] . $file['name'] . $thumbstring . '.' . $file['extension']);
                $img = '
    <!-- s9ymdb:' . $file['id'] . ' -->
    <picture>
        <source type="image/avif" srcset="' . $imgsrcAvif . '">
        <source type="image/webp" srcset="' . $imgsrcWebp . '">
        <img class="serendipity_image_center" src="' . $imgsrc . '" width="' . $thumbsize[0] . '" height="' . $thumbsize[1] . '" loading="lazy" alt="" />
    </picture>
';
                $eventData[0]['body'] = $img . $eventData[0]['body'];
            }
        } else {

            $elements = is_array($eventData) ? count($eventData) : 0;
            for ($i=0; $i < $elements; $i++) {
                if (isset($eventData[$i]['id'])) {
                    $row = $this->getPhoto($eventData[$i]['id']);
                }
                if (isset($row)) {
                    $file = serendipity_fetchImageFromDatabase((int) $row['photoid']);
                    if (!empty($file)) {
                        $thumbstring = $this->return_thumbstr($row);
                        $imgFSPAvif = $serendipity['serendipityPath'] . $serendipity['uploadPath'] . $file['path'] . '.v/' . $file['name'] . $thumbstring . '.avif';
                        $imgsrcAvif = (file_exists($imgFSPAvif) ? $serendipity['serendipityHTTPPath'] . $serendipity['uploadHTTPPath'] . $file['path'] . '.v/' . $file['name'] . $thumbstring . '.avif' : '');
                        $imgFSPWebp = $serendipity['serendipityPath'] . $serendipity['uploadPath'] . $file['path'] . '.v/' . $file['name'] . $thumbstring . '.webp';
                        $imgsrcWebp = (file_exists($imgFSPWebp) ? $serendipity['serendipityHTTPPath'] . $serendipity['uploadHTTPPath'] . $file['path'] . '.v/' . $file['name'] . $thumbstring . '.webp' : '');
                        $imgsrcAvif = @filesize($imgFSPAvif) < @filesize($imgFSPWebp) ? $imgsrcAvif : '';
                        $imgsrc = $serendipity['serendipityHTTPPath'] . $serendipity['uploadHTTPPath'] . $file['path'] . $file['name'] . $thumbstring . '.' . $file['extension'];
                        $thumbsize  = @getimagesize($serendipity['serendipityPath'] . $serendipity['uploadPath'] . $file['path'] . $file['name'] . $thumbstring . '.' . $file['extension']);
                        $img = '
    <!-- s9ymdb:' . $row['photoid'] . ' -->
    <picture>
        <source type="image/avif" srcset="' . $imgsrcAvif . '">
        <source type="image/webp" srcset="' . $imgsrcWebp . '">
        <img class="serendipity_image_center" src="' . $imgsrc . '" width="' . $thumbsize[0] . '" height="' . $thumbsize[1] . '" loading="lazy" alt="" />
    </picture>
';
                        $eventData[$i]['body'] = $img . $eventData[$i]['body'];
                    }
                }
            }
        }
    }

    function event_hook($event, &$bag, &$eventData, $addData = null)
    {
        global $serendipity;

        $hooks = &$bag->get('event_hooks');

        if (isset($hooks[$event])) {
            switch($event) {
                case 'backend_display':
                    $this->pb_backend_display();
                    return true;
                case 'frontend_display':
                    $this->pb_backend_save($eventData);
                    return true;
                case 'entry_display':
                    $this->pb_entry_display($eventData);
                    return true;
                default:
                    return false;
            }
        } else {
            return false;
        }
    }

    function return_thumbstr($file)
    {
        $thumbstring = "";
        $thumbSuffix = $serendipity['thumbSuffix'] ?? 'serendipityThumb';
        if (isset($file['use_thumbnail']) && $file['use_thumbnail']) {
            $thumbstring = ".$thumbSuffix";
        }
        return $thumbstring;
    }

}

/* vim: set sts=4 ts=4 expandtab : */
?>