<?php

declare(strict_types=1);

if (IN_serendipity !== true) {
    die ("Don't hack!");
}

@serendipity_plugin_api::load_language(dirname(__FILE__));

class serendipity_event_usergallery extends serendipity_event
{
    /**
     * Plug-in head_title [base_directory]
     * @var string
     */
    private $headtitle = null;

    function introspect(&$propbag)
    {
        $propbag->add('name',          PLUGIN_EVENT_USERGALLERY_TITLE);
        $propbag->add('description',   PLUGIN_EVENT_USERGALLERY_DESC);
        $propbag->add('stackable',     true);
        $propbag->add('author',        'Arnan de Gans, Matthew Groeninger, Stefan Willoughby, Ian Styx');
        $propbag->add('version',       '4.1.0');
        $propbag->add('requirements',  array(
            'serendipity' => '5.0',
            'smarty'      => '4.1',
            'php'         => '8.2'
        ));
        $propbag->add('event_hooks', array(
            'css'                 => true,
            'entry_display'       => true,
            'entries_header'      => true,
            'genpage'             => true,
//            'frontend_rss'        => true,
            'frontend_configure'  => true,
            'frontend_header'     => true,
            'frontend_footer'     => true
        ));
        $propbag->add('groups', array('IMAGES'));
        $propbag->add('configuration', array('title', 'num_cols', 'subpage', 'frontpage', 'permalink', 'style', 'base_directory', 'dir_list', 'show_1lvl_sub',
        'display_dir_tree', 'dir_tab', 'images_per_page', 'image_order', 'separator1', 'intro', 'separator2', 'image_display', 'show_lightbox', 'lightbox_type', 'lightbox_path', 'jquery', 'show_objects', 'image_strict', 'fixed_width', 'image_width',
        /*'feed_width', 'feed_linked_only', 'feed_body', */'separator3', 'exif_show_data', 'exif_data', 'show_media_properties', 'media_properties', 'directory_properties', 'linked_entries'));
    }

    function introspect_config_item($name, &$propbag)
    {
        global $serendipity;

        switch ($name) {
            case 'separator3':
            case 'separator2':
            case 'separator1':
                $propbag->add('type',        'separator');
                break;

            case 'title':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_EVENT_USERGALLERY_PRETTY_NAME);
                $propbag->add('description', PLUGIN_EVENT_USERGALLERY_PRETTY_DESC);
                $propbag->add('default',     PLUGIN_EVENT_USERGALLERY_TITLE);
                break;

            case 'num_cols':
                $select = array_combine(range(2,5),range(2,5));
                $propbag->add('type', 'select');
                $propbag->add('name', PLUGIN_EVENT_USERGALLERY_NUMCOLS_NAME);
                $propbag->add('description', PLUGIN_EVENT_USERGALLERY_NUMCOLS_DESC);
                $propbag->add('select_values', $select);
                $propbag->add('default', '2');
                break;

            case 'subpage':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_EVENT_USERGALLERY_SUBNAME_NAME);
                $propbag->add('description', PLUGIN_EVENT_USERGALLERY_SUBNAME_DESC);
                $propbag->add('default',     'gallery');
                break;

            case 'permalink':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_EVENT_USERGALLERY_PERMALINK_NAME);
                $propbag->add('description', PLUGIN_EVENT_USERGALLERY_PERMALINK_DESC);
                $propbag->add('default',     $serendipity['rewrite'] != 'none'
                                                ? $serendipity['serendipityHTTPPath'] . 'pages/gallery.html'
                                                : $serendipity['serendipityHTTPPath'] . $serendipity['indexFile'] . '?/pages/gallery.html');
                break;

            case 'frontpage':
                $propbag->add('type',           'radio');
                $propbag->add('name',           PLUGIN_EVENT_USERGALLERY_FRONTPAGE_NAME);
                $propbag->add('description',    PLUGIN_EVENT_USERGALLERY_FRONTPAGE_DESC);
                $propbag->add('radio',          array('value' => array('yes','no'),
                                                      'desc'  => array(YES,NO)));
                $propbag->add('radio_per_row', '2');
                $propbag->add('default',       'no');
                break;

            case 'style':
                $select["serendipity"] = PLUGIN_EVENT_USERGALLERY_STYLE_SERENDIPITY;
                $select["thumbpage"]   = PLUGIN_EVENT_USERGALLERY_STYLE_THUMBPAGE;
                $propbag->add('type',          'select');
                $propbag->add('name',          PLUGIN_EVENT_USERGALLERY_STYLE_NAME);
                $propbag->add('description',   PLUGIN_EVENT_USERGALLERY_STYLE_DESC);
                $propbag->add('select_values', $select);
                $propbag->add('default',       'thumbpage');
                break;

            case 'base_directory':
                if ($this->get_config('style') == "thumbpage") {
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
                    $propbag->add('name', PLUGIN_EVENT_USERGALLERY_DIRECTORY_NAME);
                    $propbag->add('description', PLUGIN_EVENT_USERGALLERY_DIRECTORY_DESC);
                    $propbag->add('select_values', $select);
                } else $propbag->add('type', 'suboption');
                break;

            case 'dir_list':
                if ($this->get_config('style') == 'thumbpage') {
                    $propbag->add('type',              'radio');
                    $propbag->add('name',              PLUGIN_EVENT_USERGALLERY_DIRLIST_NAME);
                    $propbag->add('description',       PLUGIN_EVENT_USERGALLERY_DIRLIST_DESC);
                    $propbag->add('radio',             array('value' => array('yes', 'no'),
                                                             'desc'  => array(YES, NO)));
                    $propbag->add('radio_per_row',     '2');
                    $propbag->add('default',           'no');
                } else $propbag->add('type', 'suboption');
                break;

            case 'intro':
                if ($this->get_config('style') == 'thumbpage') {
                    $propbag->add('type',        'html');
                    $propbag->add('name',        PLUGIN_EVENT_USERGALLERY_INTRO);
                    $propbag->add('description', '');
                    $propbag->add('default',     '');
                } else $propbag->add('type', 'suboption');
                break;

            case 'fixed_width':
                if ($this->get_config('style') == 'thumbpage') {
                    $propbag->add('type',        'string');
                    $propbag->add('name',        PLUGIN_EVENT_USERGALLERY_FIXED_WIDTH);
                    $propbag->add('description', PLUGIN_EVENT_USERGALLERY_FIXED_DESC);
                    $propbag->add('default',     '0');
                } else $propbag->add('type', 'suboption');
                break;

            case 'image_width':
                if ($this->get_config('image_display') == 'inpage') {
                    $propbag->add('type',        'string');
                    $propbag->add('name',        PLUGIN_EVENT_USERGALLERY_IMAGE_WIDTH_NAME);
                    $propbag->add('description', PLUGIN_EVENT_USERGALLERY_IMAGE_WIDTH_DESC);
                    $propbag->add('default',     '600');
                } else $propbag->add('type', 'suboption');
                break;

            case 'image_display':
                if ($this->get_config('style') == 'thumbpage') {
                    $select["inpage"] = PLUGIN_EVENT_USERGALLERY_IMAGEDISPLAY_INPAGE;
                    $select["popup"]  = PLUGIN_EVENT_USERGALLERY_IMAGEDISPLAY_POPUP;
                    $propbag->add('type',          'select');
                    $propbag->add('name',          PLUGIN_EVENT_USERGALLERY_IMAGEDISPLAY_NAME);
                    $propbag->add('description',   PLUGIN_EVENT_USERGALLERY_IMAGEDISPLAY_DESC);
                    $propbag->add('select_values', $select);
                    $propbag->add('default',       'inpage');
                } else $propbag->add('type', 'suboption');
                break;

            case 'show_lightbox':
                $propbag->add('type',          'radio');
                $propbag->add('name',          PLUGIN_EVENT_USERGALLERY_SHOWLIGHTBOX_NAME);
                $propbag->add('description',   PLUGIN_EVENT_USERGALLERY_SHOWLIGHTBOX_DESC);
                $propbag->add('radio',         array('value' => array('true', 'false', 'bottom'),
                                                     'desc'  => array(YES, NO, 'API')));
                $propbag->add('radio_per_row', '3');
                $propbag->add('default',       'false');
                break;

            case 'lightbox_type':
                $select_type["lightbox"]     = 'Lightbox2 jQuery';
                $select_type["prettyphoto"]  = 'Prettyphoto';
                $select_type["colorbox"]     = 'Colorbox';
                $select_type["magnific"]     = 'Magnific-Popup';
                $propbag->add('type',          'select');
                $propbag->add('name',          PLUGIN_EVENT_USERGALLERY_LIGHTBOXTYPE_NAME);
                $propbag->add('description',   PLUGIN_EVENT_USERGALLERY_LIGHTBOXTYPE_DESC);
                $propbag->add('select_values', $select_type);
                $propbag->add('default',       'lightbox');
                break;

            case 'lightbox_path':
                $propbag->add('type',           'string');
                $propbag->add('name',           PLUGIN_EVENT_USERGALLERY_LIGHTBOX_PATH);
                $propbag->add('default',        $serendipity['serendipityHTTPPath'] . 'plugins/serendipity_event_lightbox');
                break;

            case 'jquery':
                $propbag->add('type',           'boolean');
                $propbag->add('name',           PLUGIN_EVENT_USERGALLERY_JQUERY);
                $propbag->add('description',    PLUGIN_EVENT_USERGALLERY_JQUERY_DESC);
                $propbag->add('default',        'false');
                break;

            case 'show_objects':
                $propbag->add('type',          'radio');
                $propbag->add('name',          PLUGIN_EVENT_USERGALLERY_SHOWOBJECTS_NAME);
                $propbag->add('description',   PLUGIN_EVENT_USERGALLERY_SHOWOBJECTS_DESC);
                $propbag->add('radio',         array('value' => array('true', 'false'),
                                                     'desc'  => array(YES, NO)));
                $propbag->add('radio_per_row', '2');
                $propbag->add('default',       'false');
                break;

            case 'image_strict':
                if ($this->get_config('style') == 'thumbpage') {
                    $propbag->add('type',           'radio');
                    $propbag->add('name',           PLUGIN_EVENT_USERGALLERY_IMAGESTRICT_NAME);
                    $propbag->add('description',    PLUGIN_EVENT_USERGALLERY_IMAGESTRICT_DESC);
                    $propbag->add('radio',          array('value' => array('yes', 'no'),
                                                          'desc'  => array(YES, NO)));
                    $propbag->add('radio_per_row', '2');
                    $propbag->add('default',       'yes');
                } else $propbag->add('type', 'suboption');
                break;

            case 'image_order':
                if ($this->get_config('style') == 'thumbpage') {
                    $select["nameacs"]  = PLUGIN_EVENT_USERGALLERY_IMAGEORDER_NAMEACS;
                    $select["namedesc"] = PLUGIN_EVENT_USERGALLERY_IMAGEORDER_NAMEDESC;
                    $select["dateacs"]  = PLUGIN_EVENT_USERGALLERY_IMAGEORDER_DATEACS;
                    $select["datedesc"] = PLUGIN_EVENT_USERGALLERY_IMAGEORDER_DATEDESC;
                    $propbag->add('type',          'select');
                    $propbag->add('name',          PLUGIN_EVENT_USERGALLERY_IMAGEORDER_NAME);
                    $propbag->add('description',   PLUGIN_EVENT_USERGALLERY_IMAGEORDER_DESC);
                    $propbag->add('select_values', $select);
                    $propbag->add('default',       'nameacs');
                } else $propbag->add('type', 'suboption');
                break;

            case 'display_dir_tree':
                if ($this->get_config('style') == 'thumbpage' && $this->get_config('dir_list') == 'yes') {
                    $propbag->add('type',          'radio');
                    $propbag->add('name',          PLUGIN_EVENT_USERGALLERY_DISPLAYDIR_NAME);
                    $propbag->add('description',   PLUGIN_EVENT_USERGALLERY_DISPLAYDIR_DESC);
                    $propbag->add('radio',         array('value' => array('yes', 'no'),
                                                         'desc'  => array(YES, NO)));
                    $propbag->add('radio_per_row', '2');
                    $propbag->add('default',       'no');
                } else $propbag->add('type', 'suboption');
                break;

            case 'dir_tab':
                if ($this->get_config('style') == 'thumbpage' && $this->get_config('dir_list') == 'yes') {
                    $propbag->add('type',        'string');
                    $propbag->add('name',        PLUGIN_EVENT_USERGALLERY_DIRTAB_NAME);
                    $propbag->add('description', PLUGIN_EVENT_USERGALLERY_DIRTAB_DESC);
                    $propbag->add('default',     '10');
                } else $propbag->add('type', 'suboption');
                break;

            case 'show_1lvl_sub':
                if ($this->get_config('style') == 'thumbpage' && $this->get_config('dir_list') == 'yes' && $this->get_config('display_dir_tree', 'no') == 'no') {
                    $propbag->add('type',          'radio');
                    $propbag->add('name',          PLUGIN_EVENT_USERGALLERY_1SUBLVL_NAME);
                    $propbag->add('description',   PLUGIN_EVENT_USERGALLERY_1SUBLVL_DESC);
                    $propbag->add('radio',         array('value' => array('yes', 'no'),
                                                         'desc'  => array(YES, NO)));
                    $propbag->add('radio_per_row', '2');
                    $propbag->add('default',       'no');
                } else $propbag->add('type', 'suboption');
                break;

            case 'images_per_page':
                if ($this->get_config('style') == 'thumbpage') {
                    $propbag->add('type',        'string');
                    $propbag->add('name',        PLUGIN_EVENT_USERGALLERY_IMAGESPERPAGE_NAME);
                    $propbag->add('description', PLUGIN_EVENT_USERGALLERY_IMAGESPERPAGE_DESC);
                    $propbag->add('default',     '20');
                }
                break;

            case 'exif_show_data':
                $propbag->add('type',          'radio');
                $propbag->add('name',          PLUGIN_EVENT_USERGALLERY_EXIFDATA_SHOW_NAME);
                $propbag->add('description',   PLUGIN_EVENT_USERGALLERY_EXIFDATA_SHOW_DESC);
                $propbag->add('radio',         array('value' => array('yes', 'no'),
                                                     'desc'  => array(YES, NO)));
                $propbag->add('radio_per_row', '2');
                $propbag->add('default',       'no');
                break;

            case 'exif_data':
                if ($this->get_config('exif_show_data') == 'yes') {
                    $propbag->add('type',        'content');
                    $propbag->add('name',       PLUGIN_EVENT_USERGALLERY_DISPLAYDIR_NAME);
                    $propbag->add('description', PLUGIN_EVENT_USERGALLERY_DISPLAYDIR_DESC);
                    $propbag->add('default',     '<table id="exif">' . $this->makeExifSelector() . '</table>');
                } else $propbag->add('type', 'suboption');
                break;
/*
            case 'feed_width':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_EVENT_USERGALLERY_RSS_FEED);
                $propbag->add('description', sprintf(PLUGIN_EVENT_USERGALLERY_RSS_FEED_DESC, $serendipity['baseURL'] . 'rss.php?version=2.0&amp;gallery=true'));
                $propbag->add('default',     $serendipity['thumbSize']);
                break;

            case 'feed_linked_only':
                $propbag->add('type',        'boolean');
                $propbag->add('name',        PLUGIN_EVENT_USERGALLERY_RSS_FEED_LINKONLY);
                $propbag->add('description', PLUGIN_EVENT_USERGALLERY_RSS_FEED_LINKONLY_DESC);
                $propbag->add('default',     'false');
                break;

            case 'feed_body':
                $propbag->add('type',        'boolean');
                $propbag->add('name',        PLUGIN_EVENT_USERGALLERY_RSS_FEED_BODY);
                $propbag->add('description', PLUGIN_EVENT_USERGALLERY_RSS_FEED_BODY_DESC);
                $propbag->add('default',     'false');
                break;
*/
            case 'show_media_properties':
                $propbag->add('type',          'radio');
                $propbag->add('name',          PLUGIN_EVENT_USERGALLERY_MEDIA_PROPERTIES_SHOW_NAME);
                $propbag->add('description',   PLUGIN_EVENT_USERGALLERY_MEDIA_PROPERTIES_SHOW_DESC);
                $propbag->add('radio',         array('value' => array('yes', 'no'),
                                                     'desc'  => array(YES, NO)));
                $propbag->add('radio_per_row', '2');
                $propbag->add('default',       'no');
                break;

            case 'media_properties':
                if ($this->get_config('show_media_properties') == 'yes') {
                    $propbag->add('type',        'string');
                    $propbag->add('name',        PLUGIN_EVENT_USERGALLERY_MEDIA_PROPERTIES_NAME);
                    $propbag->add('description', PLUGIN_EVENT_USERGALLERY_MEDIA_PROPERTIES_DESC);
                    $propbag->add('default',     'COPYRIGHT:Copyright;TITLE:Title;COMMENT1:Comment');
                } else $propbag->add('type', 'suboption');
                break;

            case 'directory_properties':
                if ($this->get_config('show_media_properties') == 'yes') {
                    $propbag->add('type',        'text');
                    $propbag->add('name',        PLUGIN_EVENT_USERGALLERY_ADDDIR_PROPERTIES_NAME);
                    $propbag->add('description', PLUGIN_EVENT_USERGALLERY_ADDDIR_PROPERTIES_DESC);
                    $propbag->add('default',     'put:Enigma for maniacs;art:Pure agony and other depressions');
                }
                break;

            case 'linked_entries':
                $propbag->add('type',        'boolean');
                $propbag->add('name',        PLUGIN_EVENT_USERGALLERY_SHOW_LINKED_ENTRY);
                $propbag->add('description', '');
                $propbag->add('default',     'true');
                break;

            default:
                return false;
        }
        return true;
    }

    function example()
    {
        $styles = '<style> #exif tr:not(:first-of-type):nth-child(odd) { background: white; } #exif td {vertical-align: top; width: 80% } #exif td:not(2) { } #exif span.msg_hint { font-size: small; background: white; color: rgb(94, 122, 148); } #exif td.radio { white-space: nowrap } [data-color-mode="dark"] #exif span.msg_hint{background:var(--color-bg-info);color:var(--color-text-primary);border-color:var(--color-border-primary);text-shadow:none} [data-color-mode="dark"] #exif tr:not(:first-of-type):nth-child(2n+1) {background-color: var(--color-bg-primary);} </style>'."\n";
        return $styles.'<span id="suboptions" class="msg_notice">' . PLUGIN_API_GENERIC_SUBOPTION_DESC ."</span>\n";
    }

    function generate_content(&$title)
    {
        $title = $this->get_config('title', PLUGIN_EVENT_USERGALLERY_TITLE);
    }

    function show()
    {
        global $serendipity;

        if (!headers_sent()) {
            header('HTTP/1.0 200');
            header('Status: 200');
        }

        if (!isset($serendipity['smarty']) || !is_object($serendipity['smarty'])) {
            serendipity_smarty_init();
        }

        $_ENV['staticpage_pagetitle'] = $this->headtitle = preg_replace('@[^a-z0-9]@i', '_', str_replace('/', '', $this->get_config('base_directory'))); // remove the dir slash
        $serendipity['smarty']->assign('staticpage_pagetitle', $_ENV['staticpage_pagetitle']);

        $sub_page  = $this->get_config('subpage');
        $permalink = $this->get_config('permalink');

        $serendipity['smarty']->assign('plugin_usergallery_url', $serendipity['rewrite'] != 'none'
                                                 ? $permalink
                                                 : $serendipity['indexFile'] . '?serendipity[subpage]=' . $sub_page);
        $serendipity['smarty']->assign('plugin_usergallery_urlplus', $serendipity['rewrite'] != 'none'
                                                 ? $permalink.'?'
                                                 : $serendipity['indexFile'] . '?serendipity[subpage]= '. $sub_page . '&amp;');

        // Can't trust $serendipity['GET'] on all servers.... so we build it ourselves from subpage
        if (!empty($serendipity['GET']['subpage']) && $serendipity['rewrite'] != 'none') {
            $uri_parts = explode('?', str_replace('&amp;', '&', $serendipity['GET']['subpage']));
            $parts     = isset($uri_parts[1]) ? explode('&', $uri_parts[1]) : null;
            if (is_array($parts) && count($parts) > 1) {
                foreach($parts AS $key => $value) {
                    $val = explode('=', $value);
                    $val0 = str_replace('serendipity[', '', $val[0]);
                    if ($val[0] == $val0) {
                        $_GET[$val[0]] = $val[1];
                    } else {
                        $val0 = str_replace(']', '', $val0);
                        $serendipity['GET'][$val0] = $val[1];
                    }
                }
            } else {
                if (!empty($parts[0])) {
                    $val = isset($parts[0]) ? explode('=', $parts[0]) : [0];
                    $val0 = str_replace('serendipity[', '', $val[0]);
                    if ($val[0] == $val0 &&  isset($val[1])) {
                        $_GET[$val[0]] = $val[1];
                    } else {
                        $val0 = str_replace(']', '', $val0);
                        $serendipity['GET'][$val0] = $val[1] ?? null;
                    }
                }
            }
        }

        switch ($this->get_config("image_order")) {
            case 'nameacs':
                $orderby = 'i.name';
                $order = 'ASC';
                break;
            case 'namedesc':
                $orderby = 'i.name';
                $order = 'DESC';
                break;
            case 'dateacs':
                $orderby = 'i.date';
                $order = 'ASC';
                break;
            case 'datedesc':
                $orderby = 'i.date';
                $order = 'DESC';
                break;
        }

        if (isset($serendipity['GET']['image'])) {
            $this->displayImage($serendipity['GET']['image'], $orderby, $order);
        } else {
            $num_cols       = $this->get_config('num_cols');
            $base_directory = $this->get_config('base_directory');
            $show_objects   = serendipity_db_bool($this->get_config('show_objects', 'false'));

            if ($this->get_config('style') == "thumbpage")  {
                $images_per_page   = $this->get_config('images_per_page');
                $display_dir_tree  = $this->get_config('display_dir_tree', 'no');
                $show_1lvl_sub     = $this->get_config('show_1lvl_sub', 'no');
                $dir_list          = $this->get_config('dir_list');
                $permitted_gallery = false;

                $limit_directory = ($base_directory == 'gallery') ? '' : $base_directory;
                $limit_images_directory = $limit_directory;
                $limit_output = $limit_directory;
                $serendipity['smarty']->assign(
                    array(
                        'plugin_usergallery_currentgal' => '',
                        'plugin_usergallery_uppath' => '',
                        'plugin_usergallery_toplevel' => 'yes'
                    )
                );
                // Let's get a directory listing that has all our ACLs applied already!
                $directories_temp = serendipity_traversePath($serendipity['serendipityPath'] . $serendipity['uploadPath'],
                                                                $limit_directory, true, NULL, 1, NULL, 'read',
                                                                array('CVS' => true, '.svn' => true, '.thumbs' => true, '.git' => true, '.v' => true));

                // Check to see if we are calling a sub gallery directly
                if (!empty($_GET['gallery'])) {
                    // replace weird characters.  Was more important before we used the database.
                    $getpathtemp =  str_replace("//", "/", str_replace("..", "", urldecode($_GET['gallery'])));
                    // Ok, let's check the out directory is actually in the returned directories.
                    if (is_array($directories_temp)) {
                        foreach($directories_temp AS $f => $dir) {
                            if ($getpathtemp == $dir['relpath']) {
                                // yay! We have access to the directory.
                                $permitted_gallery = true;
                                break;
                            }
                        }
                    }

                    // If we have a matching directory, let's set the gallery up.
                    if ($permitted_gallery) {
                        $limit_images_directory = $getpathtemp;
                        $temp_array = explode('/', $getpathtemp);
                        array_pop($temp_array);
                        $limit_output = array_pop($temp_array);
                        if ($display_dir_tree == 'no') {
                            $up_path = implode('/', $temp_array);
                            if ($up_path != '') {
                                $up_path = $up_path . '/';
                            }
                        }
                        $serendipity['smarty']->assign(
                            array(
                                'plugin_usergallery_currentgal' => $getpathtemp,
                                'plugin_usergallery_uppath'     => $up_path ?? '',
                                'plugin_usergallery_toplevel'   => 'no'
                            )
                        );
                    }
                } else {
                    // We weren't calling a gallery directory, so it is set up in the configuration. If it is the base 'uploads' directory there are never any permissions on it.
                    if ($limit_images_directory != '') {
                        $perm_test_array = array(array('name' => str_replace("/", "", $limit_images_directory), 'depth'=>1, 'relpath' => $limit_images_directory, 'directory' => 1));
                        if (serendipity_directoryACL($perm_test_array, 'read')) {
                            $permitted_gallery = true;
                        }
                    } else {
                        $permitted_gallery = true;
                    }
                }

                // append the directory properties
                if ($this->get_config('show_media_properties','no') == 'yes' && !empty($this->get_config('directory_properties'))) {
                    $dirprops = explode(';', $this->get_config('directory_properties'));

                    $dps = [];
                    foreach ($dirprops AS $dprop) {
                        list($k, $v) = explode(':', $dprop);
                        $dps[$k] = $v;
                    }
                    // now merge $dp in directory list
                    foreach ($dps AS $dpk => $dpv) {
                        if ($dpk == $limit_output) {
                            $limit_output = preg_replace('@[^a-z0-9]@i', ' ', $limit_output); // previously in 'plugin_usergallery_limit_directory' assign (see below)
                            $limit_output .= " [ <span>$dpv</span> ]";
                        }
                    }
                } else {
                    $limit_output = preg_replace('@[^a-z0-9]@i', ' ', $limit_output); // previously in 'plugin_usergallery_limit_directory' assign (see below)
                }

                // SQL counted items of each dir
                $where = $show_objects ? '' : "WHERE mime LIKE 'image/%'";
                $query = "SELECT path, count(id) FROM {$serendipity['dbPrefix']}images " . $where . " GROUP BY path";
                $rs    = serendipity_db_query($query, false, 'assoc');

                if (is_array($rs)) {
                    $full_filecounter = 0;
                    foreach($rs AS $f => $record) {
                        if ($limit_directory != '') {
                            $temp_count = strlen($limit_directory);
                            if (strcmp(substr($record['path'], 0, $temp_count), $limit_directory) == 0) {
                                $temp_filecount[$record['path']] = $record['count(id)'];
                                $full_filecounter = $full_filecounter + $record['count(id)'];
                            }
                        } else {
                            $temp_filecount[$record['path']] = $record['count(id)'];
                            $full_filecounter = $full_filecounter + $record['count(id)'];
                        }
                    }
                }

                if ($dir_list == 'yes') {
                    if ($display_dir_tree == 'yes') {
                        if (!isset($temp_filecount[$limit_directory])) {
                            $temp_filecount[$limit_directory] = '0';
                        }
                        $serendipity['smarty']->assign('plugin_usergallery_maindir_filecount', $temp_filecount[$limit_directory]);
                    } else {
                        if (empty($up_path)) {
                            $up_path = null;
                        }
                        if (!isset($temp_filecount[$up_path])) {
                            $temp_filecount[$up_path] = '0';
                        }
                        $serendipity['smarty']->assign('plugin_usergallery_maindir_filecount', $temp_filecount[$up_path]);
                    }
                }

               if (is_array($directories_temp)) {
                    usort($directories_temp, 'serendipity_sortPath');
                    foreach($directories_temp AS $f => $dir) {
                        $directory = $dir['relpath'];
                        $dir['filecount'] = $temp_filecount[$directory] ?? 0;

                        if (isset($dir['depth'])) {
                            $dir['pxdepth'] = ($dir['depth'] * $this->get_config('dir_tab', 10));
                        }
                        if ($dir['filecount'] == '') {
                            $dir['filecount'] = 0;
                        }
                        if ($display_dir_tree == 'yes' ) {
                            $directories[$dir['relpath']] = $dir;
                        } else {
                            if ($show_1lvl_sub == 'yes') {
                                $temp_count = strlen($limit_images_directory);
                                if (strcmp(substr($directory, 0, $temp_count), $limit_images_directory) == 0 && $directory != $limit_images_directory) {
                                    $full_length = strlen($directory);
                                    if (substr_count(substr($directory, $temp_count, $full_length), '/') == 1) {
                                        $directories[$dir['relpath']] = $dir;
                                    } else {
                                        $temp_count = $temp_count + 1 + strpos(substr($directory, $temp_count, $full_length), '/');
                                        $directories[substr($directory, 0, $temp_count)]['filecount'] = $directories[substr($directory, 0, $temp_count)]['filecount'] + $dir['filecount'];
                                    }
                                }
                            } else {
                                $temp_count = strlen($limit_images_directory);
                                if (strcmp(substr($directory, 0, $temp_count), $limit_images_directory) == 0 && $directory != $limit_images_directory) {
                                    $directories[$directory] = $dir;
                                }
                            }
                        }
                    }
                }

                $serendipity['smarty']->assign('plugin_usergallery_subdirectories', ($directories ?? array()));

                $temp_filecount[$limit_images_directory] = $temp_filecount[$limit_images_directory] ?? 0;

                // Yes, we don't need full filecounter if $temp_filecount[$limit_images_directory] is set for list dir pagination
                if ($dir_list == 'yes' && $temp_filecount[$limit_images_directory] < ($full_filecounter ?? 0)) {
                    $full_filecounter = $temp_filecount[$limit_images_directory];
                }
                // Check up total file count of current directory or use fall-through counter
                $totalfilesct = (isset($full_filecounter) && $temp_filecount[$limit_images_directory] <= $full_filecounter) ? $full_filecounter : $temp_filecount[$limit_images_directory];

                $lower_limit = 0;
                $showpage = false;
                if ($images_per_page != 0 && $permitted_gallery) {
                    $showpage = true;
                    $total_count = $totalfilesct ?? 0;
                    if ($total_count <= $images_per_page ) {
                        $showpage = false;
                    }
                    if ($showpage) {
                        if (isset($_GET['page']) && $_GET['page'] != '' && $_GET['page'] > 0) {
                            $current_page = intval($_GET['page']);
                        } else {
                            $current_page = 1;
                        }
                        $total_pages = ceil($total_count/$images_per_page);
                        $previous_page = $current_page-1;
                        if ($previous_page == 0) {
                            $lower_limit = 0;
                        } else {
                            $lower_limit = ($previous_page * $images_per_page);
                        }
                    }
                }

                $serendipity['smarty']->assign(
                    array(
                       'plugin_usergallery_pagination'      => $showpage,
                       'plugin_usergallery_total_count'     => $total_count ?? 0,
                       'plugin_usergallery_total_pages'     => $total_pages ?? null,
                       'plugin_usergallery_current_page'    => $current_page ?? null,
                       'plugin_usergallery_next_page'       => isset($current_page) ? $current_page+1 : null,
                       'plugin_usergallery_previous_page'   => isset($current_page) ? $current_page-1 : null
                    )
                );

                if ($this->get_config('image_strict') == 'yes') {
                    $images = serendipity_fetchImagesFromDatabase($lower_limit, $images_per_page, $total, $orderby, $order, $limit_images_directory, '', '', array(), true);
                } else {
                    $images = serendipity_fetchImagesFromDatabase($lower_limit, $images_per_page, $total, $orderby, $order, $limit_images_directory);
                }

                if (is_array($images)) {
                    foreach($images AS $f => $image) {
                        $is_image = serendipity_isImage($image);
                        if (!$is_image && !$show_objects) continue; // do not include Non-Image objects to array
                        if ($is_image) {
                            $image['link'] = $serendipity['serendipityHTTPPath'] . $serendipity['uploadHTTPPath'] . $image['path'] . $image['name'] . '.' . $image['thumbnail_name'] . '.' . $image['extension'];

                            #$image['src']  = $serendipity['serendipityPath']     . $serendipity['uploadHTTPPath'] . $image['path'] . $image['name'] . '.' . $image['thumbnail_name'] . '.' . $image['extension'];
                            $_image['srcavif'] = $serendipity['serendipityPath'] . $serendipity['uploadHTTPPath'] . $image['path'] . '.v/' . $image['name'] . '.' . $image['thumbnail_name'] . '.' . 'avif';
                            $_image['srcwebp'] = $serendipity['serendipityPath'] . $serendipity['uploadHTTPPath'] . $image['path'] . '.v/' . $image['name'] . '.' . $image['thumbnail_name'] . '.' . 'webp';

                            $image['thumbavif'] = $serendipity['serendipityHTTPPath'] . $serendipity['uploadHTTPPath'] . $image['path'] . '.v/' . $image['name'] . '.' . $image['thumbnail_name'] . '.' . 'avif';
                            $image['thumbwebp'] = $serendipity['serendipityHTTPPath'] . $serendipity['uploadHTTPPath'] . $image['path'] . '.v/' . $image['name'] . '.' . $image['thumbnail_name'] . '.' . 'webp';

                            $image['thumbavif'] = file_exists($_image['srcavif']) ? $image['thumbavif'] : ''; // Conversion to ...
                            $image['thumbwebp'] = file_exists($_image['srcwebp']) ? $image['thumbwebp'] : ''; // ... HTTP path

                            if (!empty($image['thumbwebp']) && ($image['thumbavif'] != '' && filesize($_image['srcavif']) >= filesize($_image['srcwebp']))) {
                                $image['thumbavif'] = ''; // reset empty when webp thumb variation is equal or smaller in filesize
                            }

                            $image['dimension'] = $image['dimensions_width'].'x' . $image['dimensions_height'];
                            $image['isimage'] = true;
                        } else {
                            $image['isimage'] = false;
                            $image['link'] = serendipity_getTemplateFile('admin/img/mime_unknown.png');
                        }
                        // fullsize preparations
                        $image['fullimage'] = $serendipity['serendipityHTTPPath'] . $serendipity['uploadHTTPPath'] . $image['path'] . $image['name'] . '.' . $image['extension']; // relevant for plugin_usergallery_file single image view

                        $_image['srcfullavif']  = $serendipity['serendipityPath'] . $serendipity['uploadHTTPPath'] . $image['path'] . '.v/' . $image['name'] . '.' . 'avif';
                        $_image['srcfullwebp']  = $serendipity['serendipityPath'] . $serendipity['uploadHTTPPath'] . $image['path'] . '.v/' . $image['name'] . '.' . 'webp';

                        $image['fullavif']  = $serendipity['serendipityHTTPPath'] . $serendipity['uploadHTTPPath'] . $image['path'] . '.v/' . $image['name'] . '.' . 'avif';
                        $image['fullwebp']  = $serendipity['serendipityHTTPPath'] . $serendipity['uploadHTTPPath'] . $image['path'] . '.v/' . $image['name'] . '.' . 'webp';

                        $image['fullavif']  = file_exists($_image['srcfullavif']) ? $image['fullavif'] : ''; // Conversion to ...
                        $image['fullwebp']  = file_exists($_image['srcfullwebp']) ? $image['fullwebp'] : ''; // ... HTTP path

                        if (!empty($image['fullwebp']) && ($image['fullavif'] != '' && filesize($_image['srcfullavif']) >= filesize($_image['srcfullwebp']))) {
                            $image['fullavif'] = ''; // reset empty when webp full variation is equal or smaller in filesize
                        }
                        $image['varimage']  = ($image['fullavif'] != '' && filesize($_image['srcfullavif']) < filesize($_image['srcfullwebp'])) ? $image['fullavif'] : $image['fullwebp']; // relevant for plugin_usergallery_file single image view
                        $image['filesize']  = round($image['size']/1024);

                        $image['title'] = $image['name'];
                        $image['popupwidth']  = ($is_image ? ($image['dimensions_width'] + 20) : 600);
                        $image['popupheight'] = ($is_image ? ($image['dimensions_height'] + 20) : 500);
                        $process_images[$image['name']] = $image;
                    }
                }

                $gallery_array = explode('/', ($up_path ?? ''));
                foreach($gallery_array AS $f => $gallery) {
                    $gallery_path = ($gallery_path ?? '') . $gallery . '/';
                    if ($gallery_path != $base_directory ) {
                        $path_array[$gallery]['path'] = $gallery_path;
                        $path_array[$gallery]['name'] = $gallery;
                    }
                }
                unset($path_array['']);
                if ($limit_output == $base_directory) {
                   $limit_output = '';
                }

                $_show_lightbox = $this->get_config('show_lightbox', 'false');
                $show_lightbox = $_show_lightbox == 'bottom' ? true : serendipity_db_bool($_show_lightbox);
                // this needs the latest >= v. 2.0 lightbox plugin installed, hidden or active!
                $lightbox_type = $this->get_config('lightbox_type');
                $lbtype = 'rel="lightbox[]"';
                if ($lightbox_type == 'prettyphoto')  $lbtype = 'rel="prettyPhoto[]"';
                elseif ($lightbox_type == 'colorbox') $lbtype = 'rel="colorbox[]"';
                elseif ($lightbox_type == 'magnific') $lbtype = 'rel="magnificPopup[]"';

                $serendipity['smarty']->assign(
                   array(
                       'plugin_usergallery_title'           => $this->get_config('title'),
                       'plugin_usergallery_cols'            => $num_cols,
                       'plugin_usergallery_preface'         => $this->get_config('intro'),
                       'plugin_usergallery_fixed_width'     => $this->get_config('fixed_width'),
                       'plugin_usergallery_image_display'   => $this->get_config('image_display', 'inpage'),
                       'plugin_usergallery_bcrumb'          => $path_array,
                       'plugin_usergallery_dir_list'        => $dir_list,
                       'plugin_usergallery_display_dir_tree'=> $display_dir_tree,
                       'plugin_usergallery_colwidth'        => round((10/$num_cols*10)-6,2),
                       'plugin_usergallery_limit_directory' => $limit_output,
                       'plugin_usergallery_uselightbox'     => $show_lightbox,
                       'plugin_usergallery_use_reltype'     => ($_show_lightbox == 'bottom'),
                       'plugin_usergallery_lightbox_append' => true,
                       'plugin_usergallery_lightbox_script' => $lightbox_type,
                       'plugin_usergallery_lightbox_dir'    => $this->get_config('lightbox_path'),
                       'plugin_usergallery_lightbox_jquery' => (false === $serendipity['capabilities']['jquery'] && serendipity_db_bool($this->get_config('jquery', 'false'))),
                       'plugin_usergallery_lightbox_type'   => $lbtype,
                       'plugin_usergallery_images'          => $process_images ?? null
                        )
                   );

                $content = $this->parseTemplate('plugin_usergallery.tpl');
                echo $content;
            // "thumbpage" usergallery end
            } else {
                $msg = '<h2> Disarmed Option </h2>
                <p>This tries to show something equally to the MediaLibrary backend, including sort and filter management actions in the frontend, via the serendipity_displayImageList and serendipity_showMedia methods.</p>
                <p>This approach - to clone the MediaLibrary to the public - seems weird, since the "%s" select option is doing very well. The only things missing are filter and search actions.</p>
                <p>So for the 3.x usergallery plugin release, this "old" approach is being disabled, since that would need some love and security grains in the core and - as ever - someone to prove the real need nowadays!</p>';
                /*
                $add_url = '?serendipity[subpage]=' . $this->get_config('subpage');
                if ($base_directory == 'gallery') {
                    $limit_directory =  '';
                } else {
                    $limit_directory =  $base_directory;
                }
                // 2cd param $num_cols = items per row got removed with Styx 3.6
                echo serendipity_displayImageList(
                        $serendipity['GET']['page'] ?? 1,
                        $num_cols,
                        false,
                        $add_url,
                        false,
                        $limit_directory
                );
                */
                echo '<span class="serendipity_msg_notice msg_notice alert alert-secondary" style="display: block">' . sprintf($msg, PLUGIN_EVENT_USERGALLERY_STYLE_THUMBPAGE) . "<span>\n";
            }
        }
    }

    function event_hook($event, &$bag, &$eventData, $addData = null)
    {
        global $serendipity;
        static $pluginDir = null;

        $hooks = &$bag->get('event_hooks');

        if (isset($hooks[$event])) {

            if ($pluginDir === null) {
                $pluginDir = $this->get_config('lightbox_path');
            }

            switch($event) {

                case 'entry_display':
                    if ($this->selected()) {
                    // Avoid loading lightbox assets if not in usergallery; Don't use env staticpage variable since that might be sticky on possible follow-up pages; Check reserved word 'gallery' for ALL DIRS
                        if (is_array($eventData)) {
                            $eventData['clean_page'] = true; // This is important to not display an entry list!
                        } else {
                            $eventData = array('clean_page' => true);
                        }
                    }
                    break;

                case 'entries_header':
                    if ($this->selected()) {
                        $this->show();
                    }
                    break;

                case 'css':
                    // CSS class does NOT exist by user customized template styles, include default
                    if (strpos($eventData, '.exif_info') === false) {
                        $out = serendipity_getTemplateFile('serendipity_event_usergallery.css', 'serendipityPath');
                        if ($out && $out != 'serendipity_event_usergallery.css') {
                            $eventData .= file_get_contents($out);
                            // do not echo here and there, since this prevents the strpos check to work, which multiplies gallery css added to stream for multiple stacked galleries
                        } else {
                            $eventData .= file_get_contents(dirname(__FILE__) . '/serendipity_event_usergallery.css');
                        }
                    }
                    break;

                case 'frontend_header':
                    $frontend_head = true;
                case 'frontend_footer':
                    // Avoid loading lightbox assets if not in usergallery; Don't use env staticpage variable since that might be sticky on possible follow-up pages; Check reserved word 'gallery' for ALL DIRS
                    if (is_null($this->headtitle) || ($this->headtitle != 'gallery' && $serendipity['head_title'] != $this->headtitle)) {
                        break;
                    }
                    // We need to get underneath an already loaded jQuery lib!
                    if ($this->get_config('show_lightbox') === 'bottom') {
                        $lightbox_type = $this->get_config('lightbox_type');
                        $lightbox_dir  = $this->get_config('lightbox_path');

                        if ($lightbox_type == 'colorbox') {
if (isset($frontend_head)) {
echo '
    <link rel="stylesheet" type="text/css" href="' . $lightbox_dir . '/colorbox/colorbox.css">
'.PHP_EOL;
} else {
echo '
    <script src="' . $lightbox_dir . '/colorbox/jquery.colorbox-min.js" charset="utf-8"></script>
    <script type="text/javascript">
        jQuery(\'a[rel^="colorbox"]\').colorbox({
            slideshow: true,
            slideshowAuto: false,
            slideshowSpeed: 6000,
            scalePhotos: true,
            maxWidth: \'98%\'
        });
    </script>
'.PHP_EOL;
}
                        } elseif ($lightbox_type == 'lightbox') {
if (isset($frontend_head)) {
echo '
    <link rel="stylesheet" type="text/css" href="' . $lightbox_dir . '/lightbox2-jquery/css/lightbox.min.css">
'.PHP_EOL;
} else {
echo '
    <script type="text/javascript"> jQuery(document).ready(function(){ jQuery(\'a[rel^="lightbox"]\').removeAttr("onclick"); }); </script>
    <script src="' . $lightbox_dir . '/lightbox2-jquery/js/lightbox.min.js" charset="utf-8"></script>
'.PHP_EOL;
}
                        } elseif ($lightbox_type == 'magnific') {
if (isset($frontend_head)) {
echo '
    <link rel="stylesheet" type="text/css" href="' . $lightbox_dir . '/magnific-popup/magnific-popup.css">
'.PHP_EOL;
} else {
echo '
    <script src="' . $lightbox_dir . '/magnific-popup/jquery.magnific-popup.min.js" charset="utf-8"></script>
    <script type="text/javascript">
        jQuery(document).ready(function(){
            jQuery(\'a[rel^="magnificPopup"]\').magnificPopup({
                gallery:{
                    enabled:true
                },
                type:\'image\'
            });
        });
    </script>
'.PHP_EOL;
}
                        } elseif ($lightbox_type == 'prettyphoto') {
if (isset($frontend_head)) {
echo '
    <link rel="stylesheet" type="text/css" href="' . $lightbox_dir . '/prettyphoto/css/prettyPhoto.css">
'.PHP_EOL;
} else {
echo '
    <script src="' . $lightbox_dir . '/prettyphoto/js/jquery.prettyPhoto.min.js" charset="utf-8"></script>
    <script type="text/javascript">
        jQuery(document).ready(function(){
            jQuery(\'a[rel^="prettyPhoto"]\').prettyPhoto({
                social_tools: false
            });
        });
    </script>
'.PHP_EOL;
}
                        }
                    }
                    break;

                case 'frontend_configure':
                    if (isset($_REQUEST['gallery'])) {
                        // Disallow RSS-caching, because the entry age that is used for caching does not apply here.
                        $_GET['nocache'] = $_REQUEST['nocache'] = true;
                        // We need to set this variable to circumvent FeedBurner relocation
                        $_GET['type']    = 'comments';
                    }
                    break;
/*
                case 'frontend_rss':
                    $this->showRSS($eventData);
                    break;
*/

                case 'genpage':
                    if ((empty($addData['uriargs']) || trim($addData['uriargs']) == $serendipity['indexFile']) && empty($serendipity['GET']['subpage'])) {
                        if ($this->get_config('frontpage','no') == 'yes') {
                            $serendipity['GET']['subpage'] = $this->get_config('subpage');
                        }
                    }

                    if ($serendipity['rewrite'] != 'none') {
                        $nice_url = $serendipity['serendipityHTTPPath'] . $addData['uriargs'];
                    } else {
                        $nice_url = $serendipity['serendipityHTTPPath'] . $serendipity['indexFile'] . '?/' . $addData['uriargs'];
                    }
                    if (empty($serendipity['GET']['subpage'])) {
                        $serendipity['GET']['subpage'] = $nice_url;
                    }

                    if ($this->selected()) {
                        if ($this->get_config('base_directory') == 'gallery') {
                            // this is to avoid having the word "gallery" as blog title [[what ???]] gallery is a kind of reserved name for the directories value
                            $serendipity['head_title'] = preg_replace('@[^a-z0-9]@i', ' ', $this->get_config('title'));
                        } else {
                            $base_dir = explode('/', substr($this->get_config('base_directory'), 0, -1)); // remove the last dir slash
                            $keylast = array_key_last($base_dir);
                            $serendipity['head_title'] = $base_dir[$keylast];
                        }
                        $serendipity['head_subtitle'] = $serendipity['blogTitle'];
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

    function setResData($res, $unit)
    {
        $dir_arr = explode(' ', $res);
        $dir_arr[1] = trim($dir_arr[1], '()');
        $res_unit = rtrim($unit, 'es');
        $exif_res = $dir_arr[1] . ' ' . $dir_arr[2] . ' ' . $dir_arr[3] . ' ' . $res_unit;
        return($exif_res);
    }

    function changeExifDate($date)
    {
        $date = str_replace(array('-', 'T'), array(':', ' '), preg_replace('/\+.*/', '', $date)); // sets a date string 2014-03-18T10:11:31+01:00 to (Format: YYYY:MM:DD HH:mm:SS)
        #echo $date . ' ';
        $dt_arr   = explode(' ', $date);
        $date_arr = explode(':', $dt_arr[0]);
        $time_arr = explode(':', $dt_arr[1]);
        $year  = $date_arr[0];
        $month = $date_arr[1];
        $day   = $date_arr[2];
        $hour   = $time_arr[0];
        $minute = $time_arr[1];
        $second = $time_arr[2];
        $timestamp = mktime($hour, $minute, $second, $month, $day, $year);
        if ($timestamp != -1) {
            $date_str = date('M j Y H:i:s \G\M\T O', $timestamp);
        } else {
            $date_str = 'Unknown';
        }
        $exif_date = $date_str;
        return $exif_date;
    }

    function getExifTags($path, $name, $type)
    {
        global $serendipity;

        $exif_data = array();
        // Display additional EXIF information if allowed.
        $JPEG_TOOLKIT = $serendipity['baseURL'] . 'plugins/serendipity_event_usergallery/JPEG_TOOLKIT/';
        if (is_file($JPEG_TOOLKIT . 'EXIF.php')) {
            include_once $JPEG_TOOLKIT . 'EXIF.php';
            if (strtolower($type) == 'jpeg' || strtolower($type) == 'jpg') {
                $filename = $name . '.' . $type;
                if ($exif = get_EXIF_JPEG($path . $filename)) {
                    $exif_arr_num_1 = array(116 => 'Copyright Notice',
                                            271 => 'Camera Make',
                                            272 => 'Camera Model',
                                            274 => 'Orientation',
                                            296 => 'Resolution Unit',
                                            282 => 'X Resolution',
                                            283 => 'Y Resolution',
                                            306 => 'Date and Time',
                                            531 => 'YCbCr Positioning',
                                            34665 => '');
                    $exif_arr_num_2 = array(33434 => 'Exposure Time',
                                            33437 => 'Aperture',
                                            34850 => 'Exposure Program',
                                            34855 => 'ISO',
                                            36864 => 'Exif Version',
                                            36867 => 'Date (Original)',
                                            36868 => 'Date (Digitized)',
                                            37380 => 'APEX Exposure Bias',
                                            37381 => 'APEX Max Aperture',
                                            37383 => 'Metering Mode',
                                            37384 => 'Light Source',
                                            37385 => 'Flash',
                                            37386 => 'FocalLength',
                                            37510 => 'User Comment',
                                            40960 => 'FlashPix Version',
                                            40961 => 'Colour Space',
                                            40962 => 'Pixel X Dimension',
                                            40963 => 'Pixel Y Dimension',
                                            41728 => 'File Source',
                                            41985 => 'Special Processing',
                                            41986 => 'Exposure Mode',
                                            41987 => 'White Balance',
                                            41988 => 'Digital Zoom Ratio',
                                            41990 => 'Scene Capture Type',
                                            41991 => 'Gain Control',
                                            41992 => 'Contrast',
                                            41993 => 'Saturation',
                                            41994 => 'Sharpness',
                                            37121 => 'Components Config');

                    foreach($exif_arr_num_1 AS $num1 => $value1) {
                        if ($num1 != 34665) {
                            if (isset($exif[0][$num1]['Text Value'])) {
                                if ($exif[0][$num1]['Text Value'] == '') { $exif_data[$value1] = 'Unknown'; }
                                else { $exif_data[$value1] = $exif[0][$num1]['Text Value']; }
                            }
                        } else {
                            foreach($exif_arr_num_2 AS $num2 => $value2)    {
                                if (isset($exif[0][$num1]['Data'][0][$num2]['Text Value'])) {
                                    if ($exif[0][$num1]['Data'][0][$num2]['Text Value'] == '') { $exif_data[$value2] = 'Unknown'; }
                                    else { $exif_data[$value2] = $exif[0][$num1]['Data'][0][$num2]['Text Value']; }
                                }
                            }
                        }
                    }
                } else {
                    $exif_data = array();
                }
            } else {
                $exif_data = array();
            }

            if (isset($exif_data['X Resolution']) && isset($exif_data['Resolution Unit'])) {
                $exif_data['X Resolution'] = $this->setResData($exif_data['X Resolution'], $exif_data['Resolution Unit']);
            }

            if (isset($exif_data['Y Resolution']) && isset($exif_data['Resolution Unit'])) {
                $exif_data['Y Resolution'] = $this->setResData($exif_data['Y Resolution'], $exif_data['Resolution Unit']);
            }

            if (isset($exif_data['Date and Time'])) {
                $exif_data['Date and Time'] = $this->changeExifDate($exif_data['Date and Time']);
            }

            if (isset($exif_data['Orientation'])) {
                $pos = explode(' ', $exif_data['Orientation']);
                $exif_data['Orientation'] = $pos[0] . ' ' . $pos[1] . ' ' . $pos[2] . ' ' . $pos[3];
            }

            if (isset($exif_data['YCbCr Positioning'])) {
                $exif_data['YCbCr Positioning'] = str_replace('components', '', $exif_data['YCbCr Positioning']);
            }

        } else {
            $exif_data = array();
        }
        return($exif_data);
    }

    function &makeExifSelector()
    {
        global $serendipity;

        $selector  = '';
        $selector .= '<tr><td><strong>'.PLUGIN_EVENT_USERGALLERY_EXIFDATA_NAME.'</strong></td>';
        $selector .= '<td><strong>Options</strong></td></tr>'."\n";
        $selector .= '<tr><td colspan="2"><span class="msg_hint">'.PLUGIN_EVENT_USERGALLERY_EXIFDATA_DESC.'<br>'.PLUGIN_EVENT_USERGALLERY_EXIFDATA_CAMERA."</span>\n</td></tr>\n";

        if (isset($serendipity['POST']['plugin']['exifdata']) && is_array($serendipity['POST']['plugin']['exifdata'])) {
            // create new array
            $exif_array = array();
            foreach($serendipity['POST']['plugin']['exifdata'] AS $key => $value) {
                $exif_array[$key] = $key . '-' . $value;
            }

            // build new option string and save it
            $newexifstring = implode(',', array_values($exif_array));
            $this->set_config('exif_data', $newexifstring);
            // break down the array and rebuild for immediate recycling on the page
            foreach($exif_array AS $key => $value) {
                list($newkey, $newvalue) = explode('-', $value);
                $res1_exif_array[] = $newkey;
                $res2_exif_array[] = $newvalue;
            }
            $exif_array = array_combine($res1_exif_array, $res2_exif_array);
        } else {
            // get the option string
            $exifsettings = $this->get_config('exif_data','Copyright Notice-no,Camera Make-no,Camera Model-no,Orientation-no,Resolution Unit-no,X Resolution-no,Y Resolution-no,Date and Time-no,YCbCr Positioning-no,Exposure Time-no,Aperture-no,Exposure Program-no,ISO-no,Exif Version-no,Date (Original)-no,Date (Digitized)-no,APEX Exposure Bias-no,APEX Max Aperture-no,Metering Mode-no,Light Source-no,Flash-no,FocalLength-no,User Comment-no,FlashPix Version-no,Colour Space-no,Pixel X Dimension-no,Pixel Y Dimension-no,File Source-no,Special Processing-no,Exposure Mode-no,White Balance-no,Digital Zoom Ratio-no,Scene Capture Type-no,Gain Control-no,Contrast-no,Saturation-no,Sharpness-no,Components Config-no');
            if (!$exifsettings) {
                // return empty array if invalid or non-existent
                $exifsettings = array();
                $selector .= '<tr><td colspan="2"><span class="msg_error">
                    An error occurred. Your website will function AS NORMAL. But EXIF tags cannot be shown.<br>
                    Error: $this->get_config(\'exif_data\') is not fetched from the database properly.
                    Please contact support at https://github.com/ophian/styx/discussions.</span></td></tr>';
            } else {
                // split the string into options
                $exifstring = explode(',', $exifsettings);
                // split the options into name and value
                foreach($exifstring AS $key => $value) {
                    $display = explode('-', $exifstring[$key]);
                    $exif_array[$display[0]] = $display[1];
                }
            }
        }

        // output options
        foreach($exif_array AS $key => $value) {
            $selector .= '<tr><td>' . $key . '</td>';
            $selector .= '<td class="radio"><input name="serendipity[plugin][exifdata][' . $key . ']" type="radio" value="yes"';
            if ($value == "yes") {
                $selector .= ' checked="checked"';
            }
            $selector .= '> ' . YES . ' <input name="serendipity[plugin][exifdata][' . $key . ']" type="radio" value="no"';
            if ($value == "no") {
                $selector .= ' checked="checked"';
            }
            $selector .= '> ' . NO . '</td></tr>'."\n";
        }
        return $selector;
    }

    function displayImage($id, $orderby, $order)
    {
        global $serendipity;

        $extended_data  = array();
        $base_directory = $this->get_config('base_directory');
        $file = serendipity_fetchImageFromDatabase($id);
        $file['link'] = $serendipity['serendipityHTTPPath'] . $serendipity['uploadHTTPPath'] . $file['path'] . $file['name'] . '.' . $file['extension'];
        $file['fullimage'] = $serendipity['serendipityHTTPPath'] . $serendipity['uploadHTTPPath'] . $file['path'] . $file['name'] . '.' . $file['extension'];
        $_file['srcfullavif']  = $serendipity['serendipityPath'] . $serendipity['uploadHTTPPath'] . $file['path'] . '.v/' . $file['name'] . '.' . 'avif';
        $_file['srcfullwebp']  = $serendipity['serendipityPath'] . $serendipity['uploadHTTPPath'] . $file['path'] . '.v/' . $file['name'] . '.' . 'webp';
        $file['fullavif']  = $serendipity['serendipityHTTPPath'] . $serendipity['uploadHTTPPath'] . $file['path'] . '.v/' . $file['name'] . '.' . 'avif';
        $file['fullwebp']  = $serendipity['serendipityHTTPPath'] . $serendipity['uploadHTTPPath'] . $file['path'] . '.v/' . $file['name'] . '.' . 'webp';
        #$_file['fullwebp'] = $serendipity['serendipityPath']     . $serendipity['uploadHTTPPath'] . $file['path'] . '.v/' . $file['name'] . '.' . 'webp';
        $file['fullavif']  = file_exists($_file['srcfullavif']) ? $file['fullavif'] : '';
        $file['fullwebp']  = file_exists($_file['srcfullwebp']) ? $file['fullwebp'] : '';
        if (!empty($file['fullwebp']) && ($file['fullavif'] != '' && filesize($_file['srcfullavif']) >= filesize($_file['srcfullwebp']))) {
            $file['fullavif'] = ''; // reset empty when webp full variation is equal or smaller in filesize
        }
        $file['varimage']  = ($file['fullavif'] != '' && filesize($_file['srcfullavif']) < filesize($_file['srcfullwebp'])) ? $file['fullavif'] : $file['fullwebp'];
        if (isset($file['id'])) {
            $file['size_txt'] = round($file['size']/1024);
            $file['is_image'] = serendipity_isImage($file);
            $max_width = $this->get_config('image_width', 600);
            $max_size  = false;
            if ($file['dimensions_width'] > $max_width && $max_width != 0) {
                $file['alt_width']  = $max_width;
                $file['alt_height'] = round(($max_width/$file['dimensions_width']) * $file['dimensions_height']);
            } else {
                $file['alt_width']  = $file['dimensions_width'];
                $file['alt_height'] = $file['dimensions_height'];
                $max_size = true;
            }

            if ($this->get_config('image_strict') == 'yes') {
                $images = serendipity_fetchImagesFromDatabase(0, 0, $total, $orderby, $order, $file['path'], '', '', array(), true);
            } else {
                $images = serendipity_fetchImagesFromDatabase(0, 0, $total, $orderby, $order, $file['path']);
            }

            $extended_data = serendipity_fetchMediaProperties($id);
            $base_directory = str_replace('gallery', '', $base_directory);
            $previous_attempt = -1;
            $previous_id = -1;
            $next_id = -1;

            if (is_array($images)) {
                $stop = false;
                $onecount = false;
                foreach($images AS $f => $image) {
                    if (!$stop) {
                        if ($image['id'] == $file['id']) {
                            $path = $image['path'];
                            $previous_id = $previous_attempt;
                            $onecount = true;
                        } else {
                            if ($onecount == true) {
                                $next_id = $image['id'];
                                $stop = true;
                            } else {
                                $previous_attempt = $image['id'];
                            }
                        }
                    }
                }
            }

            $gallery_array = explode('/', rtrim($path, '/'));
            foreach($gallery_array AS $f => $gallery) {
                $gallery_path = ($gallery_path ?? '') . $gallery . '/';
                if ($gallery_path != $base_directory ) {
                    $path_array[$gallery]['path'] = $gallery_path;
                    $path_array[$gallery]['name'] = $gallery;
                }
            }

            // EXIF DATA
            if ($this->get_config('exif_show_data') == 'yes') {
                // If any EXIF tags that are available.
                $filepath  = $serendipity['serendipityPath'] . $serendipity['uploadHTTPPath'] . $file['path'];
                $exif_data = $this->getExifTags($filepath, $file['name'], $file['extension']);
                $exifsettings_one = $this->get_config('exif_data', $this->makeExifSelector());
                // Create array of EXIF display settings for main information table.
                $exif_arr = explode(',', $exifsettings_one);
                foreach($exif_arr AS $key => $value) {
                    $display = explode('-', $exif_arr[$key]);
                    $exif_display_one[$display[0]] = $display[1];
                }

                $data_written = false;
                $exif_output  = '<div class="all_img_info">'."\n";
                $exif_output .= '<div class="exif_info_row"><div class="exif_info_head"><strong>' . PLUGIN_EVENT_USERGALLERY_EXIFDATA_ADDITIONALDATA . "</strong></div></div>\n";
                foreach($exif_data AS $tag => $value) {
                    if ($value != 'Unknown' && $exif_display_one[$tag] == 'yes') {
                        $data_written = true;
                        $exif_output .= '<div class="exif_info_row"><span class="exif_info_tag">' . $tag . '</span><span class="exif_info">' . $value . "</span></div>\n";
                    }
                }
                if (!$data_written) {
                    $exif_output .= '<div class="exif_info_row"><em>' . PLUGIN_EVENT_USERGALLERY_EXIFDATA_NOADDITIONALDATA . "</em></div>\n";
                }
                $exif_output .= "</div>\n";
            }
            // END EXIF DATA

            // Show Media Library Properties
            if ($this->get_config('show_media_properties','no') == 'yes') {
                if (is_array($extended_data) && isset($extended_data['base_property']) && isset($extended_data['base_property']['ALL'])) {
                    $extended_data = array_merge($extended_data['base_property'], (array)$extended_data['base_property']['ALL']);
                } else {
                    $extended_data = array();
                }
                $extended_data_out = array();
                $extended_output = explode(';', $this->get_config('media_properties', 'COPYRIGHT:Copyright;TITLE:Title;COMMENT1:Comment1'));

                foreach($extended_output AS $option) {
                    $option = explode(':', $option);
                    foreach($extended_data AS $ex_name => $ex_data) {
                        if (($ex_name == $option[0]) && isset($option[1]) && $ex_data != '') {
                            $extended_data_out[] = array('name' => $option[1], 'value' => $ex_data);
                            if (($ex_name == 'TITLE') && $ex_data != '') {
                                $file['title'] = $ex_data;
                            }
                        }
                    }
                }
            }

            if (!isset($file['title'])) {
                 $file['title'] = $file['name'];
            }

            if (serendipity_db_bool($this->get_config('linked_entries'))) {
                $_filename   = $file['name'] . '.' . $file['extension'];
                $_thumbname  = $file['name'] . '.' . $file['thumbnail_name'] . '.' . $file['extension'];

                $e = $this->fetchLinkedEntries($file['id'], $file['path'] . $_filename, $file['path'] . $_thumbname);
                if (is_array($e)) {
                    $file['entries'] = array();
                    foreach($e AS $_item) {
                        $file['entries'][] = array(
                            'href'  => serendipity_archiveURL($_item['id'], $_item['title'], 'serendipityHTTPPath', true, array('timestamp' => $_item['timestamp'])),
                            'title' => $_item['title']
                        );
                    }
                }

                if (class_exists('serendipity_event_staticpage')) {
                    $s = $this->fetchStaticPages($file['id'], $file['path'] . $_filename, $file['path'] . $_thumbname);
                    if (is_array($s)) {
                        $file['staticpage_results'] = array();
                        foreach($s AS $_item) {
                            $staticpage_title = $_item['headline'];
                            if ($staticpage_title == '') {
                                $staticpage_title = $_item['pagetitle'];
                            }
                            if ($serendipity['rewrite'] == 'none') {
                                $staticpage_link = $serendipity['serendipityHTTPPath'] . $serendipity['indexFile'] . '?serendipity[subpage]=' . $_item['subpage'];
                            } else {
                                $staticpage_link = $_item['permalink'];
                            }
                            $file['staticpage_results'][] = array(
                                'href'  => $staticpage_link,
                                'title' => $staticpage_title
                            );
                        }
                    }
                }
            }

            $file['staticpage_results'] = $file['staticpage_results'] ?? array();
            $file['entries'] = $file['entries'] ?? array();

            $_show_lightbox = $this->get_config('show_lightbox', 'false');
            $show_lightbox = $_show_lightbox == 'bottom' ? true : serendipity_db_bool($_show_lightbox);

            unset($path_array['']);
            $serendipity['smarty']->assign(
                array( 'plugin_usergallery_title'           => $this->get_config('title'),
                       'plugin_usergallery_nextid'          => $next_id,
                       'plugin_usergallery_bcrumb'          => $path_array,
                       'plugin_usergallery_previousid'      => $previous_id,
                       'plugin_usergallery_xtra_info'       => $exif_output ?? null,
                       'plugin_usergallery_extended_info'   => $extended_data_out ?? null,
                       'plugin_usergallery_uselightbox'     => $show_lightbox,
                       'plugin_usergallery_file'            => $file,
                       'plugin_usergallery_is_endsize'      => $max_size
                    )
            );
            $content = $this->parseTemplate('plugin_usergallery_imagedisplay.tpl');
            echo $content;

            return true;
        } else {
            echo "Invalid file.";
            return false;
        }
    }

    function selected()
    {
        global $serendipity;

        if (isset($serendipity['GET']['subpage'])
        && ($serendipity['GET']['subpage'] == $this->get_config('subpage') || preg_match('@^' . preg_quote($this->get_config('permalink')) . '@i', $serendipity['GET']['subpage']))) {
            return true;
        }

        return false;
    }

    // Fetches a list of referenced entries
    function fetchLinkedEntries($id, $big, $thumb, $single = false, $getBody = false)
    {
        global $serendipity;

        if (strtolower($serendipity['dbType']) != 'mysql' && strtolower($serendipity['dbType']) != 'mysqli') {
            return false;
        }

        $q = "SELECT e.id, e.timestamp, e.title " . ($getBody ? ', e.body' : '') . "
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

        if (!$single) {
            $q2 = "SELECT e.id, e.timestamp, e.title
                     FROM {$serendipity['dbPrefix']}entryproperties AS ep
                LEFT JOIN {$serendipity['dbPrefix']}entries AS e
                       ON (e.id = ep.entryid)
                    WHERE ep.property = 'fotokasten_picture'
                      AND ep.value = '" . $id . "'";
            $e2 = serendipity_db_query($q2, false, 'assoc');

            if (is_array($e2) && count($e2) > 0) {
                if (!is_array($e)) {
                    $e = array();
                }
                foreach($e2 AS $idx => $item) {
                    $e[$item['id']] = $item;
                }
            }
        }

        if ($single && is_array($e)) {
            reset($e);
            $return = array(0 => current($e));
            return $return;
        }

        return $e;
    }

    // Fetches a list of referenced static pages
    function fetchStaticPages($id, $big, $thumb)
    {
        global $serendipity;

        if (strtolower($serendipity['dbType']) != 'mysql' && strtolower($serendipity['dbType']) != 'mysqli') {
            return false;
        }// ToDo remove limitation!

        $q = "SELECT s.*
                FROM {$serendipity['dbPrefix']}staticpages AS s
               WHERE (MATCH(headline,content) AGAINST('" . serendipity_db_escape_string($big) . "')
                  OR MATCH(headline,content) AGAINST('" . serendipity_db_escape_string($thumb) . "'))
                 AND (s.content REGEXP '(" . preg_quote(serendipity_db_escape_String($thumb)) . "|" . preg_quote(serendipity_db_escape_string($big)) . ")'
                  OR  s.content REGEXP '(" . preg_quote(serendipity_db_escape_String($thumb)) . "|" . preg_quote(serendipity_db_escape_string($big)) . ")')
                 AND s.publishstatus = 1
                 AND s.pass = ''
                 GROUP BY s.id
            ORDER BY s.timestamp DESC";
        $e = serendipity_db_query($q, false, 'assoc');

        if (is_array($e)) {
            $_e = $e;
            $e  = array();
            foreach($_e AS $idx => $item) {
                $e[$item['id']] = $item;
            }
        }

        return $e;
    }
#disabled since found no working use case
    // Create an RSS-Feed. Called via URL like:
    // http://yourblog/rss.php?version=2.0&gallery=true&limit=A&picdir=B&feed_width=C&hide_title=D
    // Variables:
    //    A: Number of images to show
    //    B: Path to a picture directory to limit to
    //    C: Width of the thumbnail pictures. Takes precedence over configured thumbnail size in this plugin and globally
    //    D: If set, no titles will be shown in the RSS feed.
    function showRSS(&$eventData, $offset = 0)
    {
        global $serendipity;
        static $entries = array();

        if (!isset($_REQUEST['gallery'])) {
            return false;
        }

        $total      = 0;
        $limit      = (!empty($_REQUEST['limit']) ? (int)$_REQUEST['limit'] : $serendipity['RSSfetchLimit']);
        $dir        = (!empty($_REQUEST['picdir']) ? $_REQUEST['picdir'] : '');
        $size       = (!empty($_REQUEST['feed_width']) ? (int)$_REQUEST['feed_width'] : $this->get_config('feed_width'));
        $hide_title = (!empty($_REQUEST['hide_title']) ? true : false);
        $basepath   = $serendipity['serendipityPath'] . $serendipity['uploadPath'];
        $baseurl    = $serendipity['baseURL'] . $serendipity['uploadHTTPPath'];
        $lo         = serendipity_db_bool($this->get_config('feed_linked_only'));
        $feed_body  = serendipity_db_bool($this->get_config('feed_body'));

        if (empty($limit)) {
            $limit = 15;
        }
        $images = serendipity_fetchImagesFromDatabase($offset, $limit, $total, 'i.date', 'DESC', $dir);

        // Let's push the $images array into the destination $entries format.
        foreach($images AS $idx => $image) {
            if (count($entries) > $limit) {
                continue;
            }

            $filename   = $image['name'] . '.' . $image['extension'];
            $thumbname  = $image['name'] . '.' . $image['thumbnail_name'] . '.' . $image['extension'];
            $sourcefile = $basepath . $image['path'] . $filename;
            $thumbfile  = $basepath . $image['path'] . $thumbname;

            $sourcefile_http = $baseurl . $image['path'] . $filename;
            $thumbfile_http  = $baseurl . $image['path'] . $thumbname;

            // Creating temporary thumbnails
            if ($serendipity['thumbSize'] != $size) {
                $thumbname      = $image['name'] . '.serendipityGallery.' . $image['extension'];
                $thumbfile      = $serendipity['serendipityPath'] . PATH_SMARTY_COMPILE . '/' . $thumbname;
                $thumbfile_http = $serendipity['baseURL'] . PATH_SMARTY_COMPILE . '/' . $thumbname;

                if (!file_exists($thumbfile)) {
                    serendipity_makeThumbnail($filename, $image['path'], $size, $thumbfile, true);
                }
            }

            $fdim = @serendipity_getImageSize($thumbfile, '', '');

            $e = $this->fetchLinkedEntries($image['id'], $image['path'] . $filename, $image['path'] . $thumbname, true, $feed_body);
            if (is_array($e)) {
                $link = serendipity_archiveURL($e[0]['id'], $e[0]['title'], 'serendipityHTTPPath', true, array('timestamp' => $e[0]['timestamp']));
                $lid = $e[0]['id'];
            } elseif ($lo) {
                // Images without links will be discarded
                continue;
            } else {
                $link = $sourcefile_http;
                $lid  = $image['id'];
            }

            if ($feed_body && is_array($e)) {
                // Replace big image with thumbnail
                $body = preg_replace('@(["\'])[^"\']*' . preg_quote($image['path'] . $filename, '@') . '@imsU', '\1' . $thumbfile_http, $e[0]['body']);
                // Nuke a possible width attributes of <img> tags to not screw up display
                $body = preg_replace('@(<img[^>]*)\s*width\s*=["\'][0-9]+["\']@imsU', '\1', $body);
                $body = preg_replace('@(<img[^>]*)\s*height\s*=["\'][0-9]+["\']@imsU', '\1', $body);
            }

            $body = '<a href="' . $link . '"><img src="' . $thumbfile_http . '" alt="" width="' . $fdim[0] . '" height="' . $fdim[1] . '"></a>';
            $entries[] = array(
                'title'         => ($hide_title ? '' : $filename),
                'entryid'       => $lid,
                'timestamp'     => $image['date'],
                'author'        => $image['authorname'],
                'body'          => $body,
                'extended'      => '',
                'authorid'      => $image['authorid'],
                'email'         => $image['authorname'],
                'category_name' => $image['path'],
                'last_modified' => $image['date'],
            );
        }

        if (count($entries) < $limit && count($images) == $limit) {
            $this->showRSS($eventData, $offset + $limit);
        }

        if ($offset == 0) {
            // We are Borg. Resistance is futile. Sue us.
            $GLOBALS['entries'] =& $entries;
            $GLOBALS['comments'] = false;
            $_GET['type'] = 'content';
        }

        return true;
    }

}

/* vim: set sts=4 ts=4 expandtab : */
?>