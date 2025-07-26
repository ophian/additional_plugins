<?php

declare(strict_types=1);

class media_sidebar extends subplug_sidebar {

    var $title = PLUGIN_SIDEBAR_IMAGESIDEBAR_NAME;

    function introspect_custom()
    {
        return array('media_hotlinks_only',
                     'media_hotlink_base',
                     'media_base_directory',
                     'media_image_strict',
                     'media_gal_styles',
                     'media_rotate_time',
                     'media_number_images',
                     'media_fixed_width',
                     'media_fixed_range',
                     'media_linkbehavior',
                     'media_url',
                     'media_gal_permalink',
                     'media_lightbox',
                     'media_intro',
                     'media_summery',
                     'media_next_update',
                     'media_cache_output');
    }

    function introspect_config_item_custom($name, &$propbag)
    {
        global $serendipity;

        switch($name) {
            case 'media_base_directory':
                if ($this->get_config('media_hotlinks_only', 'no') == 'no') {
                    $select['gallery'] = ALL_DIRECTORIES;
                    if ($serendipity['version'][0] >= 3) {
                        $mediaExcludeDirs = array('CVS' => true, '.svn' => true, '.git' => true, '.v' => true); // the last is about Variations
                        $paths = serendipity_traversePath($serendipity['serendipityPath'] . $serendipity['uploadPath'], '', true, NULL, 1, NULL, false, $mediaExcludeDirs);
                    } else {
                        $paths = serendipity_traversePath($serendipity['serendipityPath'] . $serendipity['uploadPath']);
                    }
                    foreach($paths AS $folder) {
                        $select[$folder['relpath']] = str_repeat('-', $folder['depth']) . ' '. $folder['name'];
                    }
                    $propbag->add('type', 'select');
                    $propbag->add('name', PLUGIN_SIDEBAR_MEDIASIDEBAR_DIRECTORY_NAME);
                    $propbag->add('description', PLUGIN_SIDEBAR_MEDIASIDEBAR_DIRECTORY_DESC);
                    $propbag->add('select_values', $select);
                } else $propbag->add('type', 'suboption');
                break;

            case 'media_image_strict':
                if ($this->get_config('media_hotlinks_only', 'no') == 'no') {
                    $propbag->add('type', 'radio');
                    $propbag->add('name', PLUGIN_SIDEBAR_MEDIASIDEBAR_NOSUBDIRS_NAME);
                    $propbag->add('description', PLUGIN_SIDEBAR_MEDIASIDEBAR_NOSUBDIRS_DESC);
                    $propbag->add('radio',
                                array(  'value' => array('yes', 'no'),
                                        'desc'  => array(YES, NO)
                                ));
                    $propbag->add('radio_per_row', '2');
                    $propbag->add('default', 'yes');
                } else $propbag->add('type', 'suboption');
                break;

            case 'media_number_images':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_SIDEBAR_MEDIASIDEBAR_NUMIMAGES_NAME);
                $propbag->add('description', PLUGIN_SIDEBAR_MEDIASIDEBAR_NUMIMAGES_DESC);
                $propbag->add('default',     '1');
                break;

            case 'media_rotate_time':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_SIDEBAR_MEDIASIDEBAR_ROTATETIME_NAME);
                $propbag->add('description', PLUGIN_SIDEBAR_MEDIASIDEBAR_ROTATETIME_DESC);
                $propbag->add('default',     '60');
                break;

            case 'media_linkbehavior':
                $select["inpage"] = PLUGIN_SIDEBAR_MEDIASIDEBAR_LINKBEHAVIOR_INPAGE;
                $select["popup"]  = PLUGIN_SIDEBAR_MEDIASIDEBAR_LINKBEHAVIOR_POPUP;
                $select["url"]    = PLUGIN_SIDEBAR_MEDIASIDEBAR_LINKBEHAVIOR_URL;
                $select["entry"]  = PLUGIN_SIDEBAR_MEDIASIDEBAR_LINKBEHAVIOR_ENTRY;
                if (class_exists('serendipity_event_usergallery')){
                    $select["gallery"] = PLUGIN_SIDEBAR_MEDIASIDEBAR_LINKBEHAVIOR_GALLERY;
                }
                $select["none"]   = 'none';
                $propbag->add('type',          'select');
                $propbag->add('name',          PLUGIN_SIDEBAR_MEDIASIDEBAR_LINKBEHAVIOR_NAME);
                $propbag->add('description',   PLUGIN_SIDEBAR_MEDIASIDEBAR_LINKBEHAVIOR_DESC);
                $propbag->add('select_values', $select);
                $propbag->add('default',       'inpage');
                break;

            case 'media_lightbox':
                $propbag->add('type',           'string');
                $propbag->add('name',           PLUGIN_SIDEBAR_MEDIASIDEBAR_LIGHTBOX_NAME);
                $propbag->add('description',    PLUGIN_SIDEBAR_MEDIASIDEBAR_LIGHTBOX_DESC);
                $propbag->add('default',        '');
                break;

            case 'media_fixed_width':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_SIDEBAR_MEDIASIDEBAR_WIDTH_NAME);
                $propbag->add('description', PLUGIN_SIDEBAR_MEDIASIDEBAR_WIDTH_DESC);
                $propbag->add('default',     '260');
                break;

            case 'media_fixed_range':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_SIDEBAR_MEDIASIDEBAR_DIMENSION_RANGE_NAME);
                $propbag->add('description', PLUGIN_SIDEBAR_MEDIASIDEBAR_DIMENSION_RANGE_DESC);
                $propbag->add('default',     '180,3600');
                break;

            case 'media_url':
                if ($this->get_config('media_linkbehavior') == 'url') {
                    $propbag->add('type',        'string');
                    $propbag->add('name',        PLUGIN_SIDEBAR_MEDIASIDEBAR_URL_NAME);
                    $propbag->add('description', PLUGIN_SIDEBAR_MEDIASIDEBAR_URL_DESC);
                    $propbag->add('default',     $serendipity['baseURL']);
                } else $propbag->add('type', 'suboption');
                break;

            case 'media_gal_permalink':
                if ($this->get_config('media_linkbehavior') == 'gallery') {
                    $propbag->add('type',        'string');
                    $propbag->add('name',        PLUGIN_SIDEBAR_MEDIASIDEBAR_GALPERM_NAME);
                    $propbag->add('description', PLUGIN_SIDEBAR_MEDIASIDEBAR_GALPERM_DESC);
                    $propbag->add('default',     $serendipity['rewrite'] != 'none'
                                                ? $serendipity['serendipityHTTPPath'] . 'pages/gallery.html'
                                                : $serendipity['serendipityHTTPPath'] . $serendipity['indexFile'] . '?serendipity[subpage]=gallery');
                } else $propbag->add('type', 'suboption');
                break;

            case 'media_gal_styles':
                $propbag->add('type',           'radio');
                $propbag->add('name',         PLUGIN_SIDEBAR_MEDIASIDEBAR_GAL_STYLES);
                $propbag->add('description',  PLUGIN_SIDEBAR_MEDIASIDEBAR_GAL_STYLES_DESC);
                $propbag->add('radio',
                            array(  'value' => array('yes', 'no', 'img'),
                                    'desc'  => array(YES, NO, 'compat')
                            ));
                $propbag->add('radio_per_row',  '3');
                $propbag->add('default',        'yes');// sadly we need this set to 'yes' for compat, better value is 'no' or simpler 'compat' (for img styles only)
                break;

            case 'media_intro':
                $propbag->add('type',           'html');
                $propbag->add('name',           PLUGIN_SIDEBAR_MEDIASIDEBAR_INTRO);
                $propbag->add('description',    '');
                $propbag->add('default',        '');
                break;

            case 'media_summery':
                $propbag->add('type',        'html');
                $propbag->add('name',        PLUGIN_SIDEBAR_MEDIASIDEBAR_SUMMERY);
                $propbag->add('description', '');
                $propbag->add('default',     '');
                break;

            case 'media_hotlinks_only':
                $propbag->add('type',           'radio');
                $propbag->add('name',           PLUGIN_SIDEBAR_MEDIASIDEBAR_HOTLINKS_NAME);
                $propbag->add('description',    PLUGIN_SIDEBAR_MEDIASIDEBAR_HOTLINKS_DESC);
                $propbag->add('radio',
                            array(  'value' => array('yes', 'no'),
                                    'desc'  => array(YES, NO)
                            ));
                $propbag->add('radio_per_row',  '2');
                $propbag->add('default',        'no');
                break;

            case 'media_hotlink_base':
                if ($this->get_config('media_hotlinks_only', 'no') == 'yes') {
                    $propbag->add('type',        'string');
                    $propbag->add('name',        PLUGIN_SIDEBAR_MEDIASIDEBAR_HOTLINKBASE_NAME);
                    $propbag->add('description', PLUGIN_SIDEBAR_MEDIASIDEBAR_HOTLINKBASE_DESC);
                    $propbag->add('default',     '');
                } else $propbag->add('type',     'suboption');
                break;

            default:
                return false;
        }
        return true;
    }

    function generate_content_custom(&$title)
    {
        global $serendipity;

        $update = true;
        $rotate_time = $this->get_config('media_rotate_time', 0);
        $next_update = $this->get_config('media_next_update', '');

        if ($rotate_time != 0) {
            $cache_output = serendipity_getCacheItem('mediasidebar_cache');
            if ($cache_output && $cache_output !== false) {
                $cache_output = unserialize($cache_output);
                $update = false;
            }
        } else {
            $cache_output = $this->get_config('media_cache_output', '');
        }

        if ($rotate_time != 0) {
            if ($next_update > time()) {
                $update = false;
            } else {
                $next_update = $this->calc_update_time($rotate_time, $next_update);
                $this->set_config('media_next_update', $next_update);
            }
        }

        $title = $this->get_config('title', $this->title);

        if ($update || $cache_output == '') {
            $output_str = '';
            if ($this->get_config('media_image_strict') == 'yes') {
                $strict = true;
            } else {
                $strict = false;
            }

            if ($this->get_config('media_hotlinks_only', 'no') == 'yes') {
                $dir_extension = $this->get_config('media_hotlink_base', '');
                if ($dir_extension != '' ) {
                    $dir_extension = $dir_extension . '%';
                }
                $directory = "http%://%" . $dir_extension;
                $strict = false;
            } else {
                $directory = $this->get_config('media_base_directory');
            }

            if ($directory == 'gallery') {
                $directory = '';
            }

            list($x,$y) = explode(',', $this->get_config('media_fixed_range', '240,2400'));
            $filter     = ((int)$x > 0) ? array('i.dimensions_width' => array('from' => (int)trim($x), 'to' => (int)trim($y)), 'fileCategory' => 'image') : array('fileCategory' => 'image');

            $images_all  = serendipity_fetchImagesFromDatabase(0, 0, $total, false, false, $directory, '', '', $filter, $strict);
            $number      = $this->get_config('media_number_images');
            $total_count = count($images_all);

            if ($total_count < $number) {
                $number = $total_count;
            }

            $images       = array();
            $random_check = array();

            for ($counter = 0; $counter < $number; $counter += 1) {
                $checkit = rand(0, $total_count-1);
                while (in_array($checkit, $random_check)) {
                    $checkit = rand(0, $total_count);
                }
                $random_check[] = $checkit;
                $images[] = $images_all[$checkit];
            }

            $width_fix = $this->get_config('media_fixed_width', '0');
            $width_str = ($width_fix > 0) ? ' width:'.$width_fix.'px;' : '';

            $gallery_styles = $this->get_config('media_gal_styles', 'yes');
            if ($gallery_styles != 'no') {
                ob_start();
                if ($gallery_styles == 'yes') {
?>
<style>
#mediasidebar .mediasidebar_link {
    display: inline-table;
    text-decoration: none transparent;
    color: transparent;
    border: 0 none;
}
.mediasidebaritem img {
    border: 1px solid #bbb;
    border-radius: 5px;
    box-shadow: 2px 2px 2px #dfdfdf;
    box-sizing: border-box;
    margin-bottom: .25rem;
}
</style>
<?php
                } else {
?>
<style>
.mediasidebaritem img {
    border: 1px solid #bbb;
    border-radius: 5px;
    box-shadow: 2px 2px 2px #dfdfdf;
    box-sizing: border-box;
    margin-bottom: .25rem;
    width: auto;
}
</style>
<?php
                }
                $output_styles = ob_get_contents();
                ob_end_clean();
            }

            if (is_array($images)) {
                $output_str .= $output_styles ?? '';
                $output_str .= $this->get_config('media_intro');
                $output_str .= '<div id="mediasidebar">'."\n";
                foreach ($images AS $image) {
                    if (isset($image['name'])) {
                        if ($image['hotlink'] == 1) {
                            $thumb_path = $image_link = $image_path = $image['path'];
                            $thumb_webp = '';
                        } else {
                            $image_path = $serendipity['serendipityHTTPPath'].$serendipity['uploadPath'].$image['path'].$image['name'].'.'.$image['extension'];
                            $image_link = ($image['hotlink'] != 1 && file_exists($serendipity['serendipityPath'].$serendipity['uploadPath'].$image['path'].'.v/'.$image['name'].'.webp'))
                                        ? $serendipity['serendipityHTTPPath'].$serendipity['uploadPath'].$image['path'].'.v/'.$image['name'].'.webp'
                                        : $serendipity['serendipityHTTPPath'].$serendipity['uploadPath'].$image['path'].$image['name'].'.'.$image['extension'];
                            $thumb_path = $serendipity['serendipityHTTPPath'].$serendipity['uploadPath'].$image['path'].$image['name'].'.'.$image['thumbnail_name'].'.'.$image['extension'];
                            $thumb_webp = file_exists($serendipity['serendipityPath'].$serendipity['uploadPath'].$image['path'].'.v/'.$image['name'].'.'.$image['thumbnail_name'].'.webp')
                                        ? $serendipity['serendipityHTTPPath'].$serendipity['uploadPath'].$image['path'].'.v/'.$image['name'].'.'.$image['thumbnail_name'].'.webp'
                                        : '';
                            if (!serendipity_isImage($image)) {
                                $thumb_path = serendipity_getTemplateFile('admin/img/mime_unknown.png');
                                $_widthtmp  = $width_str;
                                $width_str  = '';
                            }
                        }

                        $gstyles = ($gallery_styles != 'no') ? ' style="border: 0px;'.$width_str.'"' : '';
                        $picture = ($serendipity['version'][0] == 3 && !empty($thumb_webp)) ? '<picture><source srcset="'.$thumb_webp.'" type="image/webp"><img'.$gstyles.' src="'.$thumb_path.'" loading=lazy alt=""></picture>' : '<img'.$gstyles.' src="'.$thumb_path.'" loading=lazy alt="">';
                        $width_str = $_widthtmp ?? $width_str;
                        $output_str .= '                        <div class="mediasidebaritem">'."\n";

                        switch ($this->get_config("media_linkbehavior")) {

                            case 'entry':
                                $e = $this->fetchLinkedEntries($image['id'], $image_path, $thumb_path, true);
                                if (is_array($e)) {
                                    $link = serendipity_archiveURL($e[0]['id'], $e[0]['title'], 'serendipityHTTPPath', true, array('timestamp' => $e[0]['timestamp']));
                                } else {
                                    $link = $image_link;
                                }
                                $linktitle = $e[0]['title'] ?? ''; // do not call it title, since that overwrites (extends) the generate_content config option set title!
                                $output_str .= '                            <a href="' . $link . '" title="' . (function_exists('serendipity_specialchars') ? serendipity_specialchars($linktitle) : htmlspecialchars($linktitle, ENT_COMPAT, LANG_CHARSET)) . '">'.$picture."</a>\n";
                                break;

                            case 'popup':
                                $output_str .= '                            <a href="'.$image_link.'" onclick="F1 = window.open(\''.$image_link.'\',\'Zoom\',\'height='.$image['dimensions_height'].',width='.$image['dimensions_width'].',top=298,left=354,toolbar=no,menubar=no,location=no,resize=1,resizable=1,scrollbars=yes\'); return false;">'.$picture."</a>\n";
                                break;

                            case 'url':
                                $output_str .= '                            <a href="'.$this->get_config('media_url').'">'.$picture."</a>\n";
                                break;

                            case 'gallery':
                                $gallery_str = $this->get_config('media_gal_permalink');
                                if (strstr($gallery_str,'?')) {
                                    $gallery_str = $gallery_str.'&serendipity[image]='.$image['id'];
                                } else {
                                    $gallery_str = $gallery_str.'?serendipity[image]='.$image['id'];
                                }
                                $output_str .= '                            <a href="'.$gallery_str.'">'.$picture."</a>\n";
                                break;

                            case 'inpage':
                                $output_str .= '                            <a class="mediasidebar_link" ' . $this->get_config('media_lightbox', '') . ' href="'.$image_link.'">'.$picture."</a>\n";
                                break;

                            default:
                            case 'none':
                                $output_str .= $picture."\n";
                                break;

                        }

                        $output_str .= "                        </div>\n";
                    }
                }
                $output_str .= "                    </div>\n"; // #mediasidebar end
                $output_str .= $this->get_config('media_summery');
            } else {
                $output_str = 'Error accessing images.';
            }

            if ($rotate_time != 0) {
                serendipity_cacheItem('mediasidebar_cache', serialize($output_str), $rotate_time*60);
            } else {
                $this->set_config('media_cache_output', $output_str);
            }
        } else {
            $output_str = $cache_output;
        }
        echo $output_str;

    }

    function cleanup_custom()
    {
        $this->set_config('media_next_update','');
    }

    function calc_update_time($rotate_time, $last_update)
    {
        $next_time = mktime((int) date("H"), date("i"), (int) 0, (int) date("m"), (int) date("d"), (int) date("Y"));
        if ($last_update == '') {
            $last_update = mktime((int) date("H"), (int) 0, (int) 0, (int) date("m"), (int) date("d"), (int) date("Y"));
        }
        if ($rotate_time != 0) {
            if ($rotate_time > 1440) {
               $rotate_time = 1440;
            }
            $day = (int) ($rotate_time / 1440);
            $hours = (int) (($rotate_time % 1440)/ 60);
            $minutes = (int) ((($rotate_time % 1440) % 60)/1);
            while ($next_time < time()) {
                $next_time  = mktime((int) date("H",$last_update)+$hours, date("i",$last_update)+$minutes, (int) 0, (int) date("m",$last_update), (int) date("d",$last_update)+ $day, (int) date("Y",$last_update));
                $last_update = $next_time;
            }
        }
        return $next_time;
    }

    // Fetches a list of referenced entries
    function fetchLinkedEntries($id, $big, $thumb, $single = false)
    {
        global $serendipity;

        if (strtolower($serendipity['dbType']) != 'mysql' && strtolower($serendipity['dbType']) != 'mysqli') {
            return false;
        }

        $q = "SELECT e.id, e.timestamp, e.title
                FROM {$serendipity['dbPrefix']}entries AS e
               WHERE (MATCH(e.title, e.body, e.extended) AGAINST ('" . serendipity_db_escape_string($big) . "')
                  OR MATCH(e.title, e.body, e.extended) AGAINST ('" . serendipity_db_escape_string($thumb) . "'))
                 AND (e.body    REGEXP '(" . preg_quote(serendipity_db_escape_String($thumb)) . "|" . preg_quote(serendipity_db_escape_string($big)) . ")'
                  OR e.extended REGEXP '(" . preg_quote(serendipity_db_escape_String($thumb)) . "|" . preg_quote(serendipity_db_escape_string($big)) . ")')
                 AND e.isdraft = 'false'
            ORDER BY e.timestamp DESC";
        $e = serendipity_db_query($q, false, 'assoc');

        if (is_array($e)) {
            $_e = $e;
            $e = array();
            foreach($_e AS $idx => $item) {
                $e[$item['id']] = $item;
            }
        }

        if ($single && is_array($e)) {
            reset($e);
            $return = array(
                0 => current($e)
            );
            return $return;
        }

        return $e;
    }

}

/* vim: set sts=4 ts=4 expandtab : */
?>