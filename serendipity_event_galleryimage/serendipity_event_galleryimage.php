<?php

// A plugin to work with very old Menalto Gallery Series 1 and Series 2 revisions.
// It was never checked to work without flaws with Gallery 3 Versions.
// The official Gallery (3) development even stopped in 2014 and was delayed for years, even if there are people like https://github.com/bwdutton/gallery3 trying to keep it alive.
//
// Code based on the WP-Gallery plugin by Geoff Hutchison http://geoffhutchison.net/blog/categories/computers/web/wp-plugins/
//
// Basic usage is:
//             [GImage]album/image.ext[/GImage] with .ext needed if not the default .jpg
// full syntax is:
//             [GImage size=sized|full|thumb; link=image|image_sized|album|page|none; align=left|center|right|none; caption=text string; style=link|fancy|image][album/]image.ext[/GImage]
//
//

if (IN_serendipity !== true) {
    die ("Don't hack!");
}

@serendipity_plugin_api::load_language(dirname(__FILE__));

class serendipity_event_galleryimage extends serendipity_event
{
    var $title = PLUGIN_EVENT_GALLERYIMAGE_NAME;

    function introspect(&$propbag)
    {
        global $serendipity;

        $propbag->add('name',          PLUGIN_EVENT_GALLERYIMAGE_NAME);
        $propbag->add('description',   PLUGIN_EVENT_GALLERYIMAGE_DESC);
        $propbag->add('stackable',     false);
        $propbag->add('author',        'Rob Antonishen, Alexander Mieland, Ian Styx');
        $propbag->add('version',       '1.20');
        $propbag->add('requirements',  array(
            'serendipity' => '3.0',
            'smarty'      => '3.1.0',
            'php'         => '7.3.0'
        ));
        $propbag->add('cachable_events', array('frontend_display' => true));
        $propbag->add('event_hooks',   array(
                'frontend_display' => true,
                'external_plugin'  => true
        ));

        $this->markup_elements = array(
            array(
              'name'     => 'ENTRY_BODY',
              'element'  => 'body',
            ),
            array(
              'name'     => 'EXTENDED_BODY',
              'element'  => 'extended',
            ),
            array(
              'name'     => 'HTML_NUGGET',
              'element'  => 'html_nugget',
            )
        );

        $conf_array = array();
        $conf_array[] = 'gversion';
        $conf_array[] = 'gallery_base';
        $conf_array[] = 'album_base';
        $conf_array[] = 'gallery_abs';
        $conf_array[] = 'album_abs';
        $conf_array[] = 'popup_max';
        $conf_array[] = 'thumb_max';
        foreach($this->markup_elements AS $element) {
            $conf_array[] = $element['name'];
        }
        $propbag->add('configuration', $conf_array);
        $propbag->add('groups', array('MARKUP', 'IMAGES'));
    }

    function generate_content(&$title)
    {
        $title = $this->title;
    }

    function introspect_config_item($name, &$propbag)
    {
        global $serendipity;

        switch($name) {
            case 'gversion':
                $propbag->add('type',        'select');
                $propbag->add('name',        PLUGIN_EVENT_GALLERYIMAGE_VERSION);
                $propbag->add('description', '');
                $propbag->add('default',     1);
                $propbag->add('select_values', array(
                                                1  => '1.x',
                                                2  => '2.x'
                ));
                break;

            case 'gallery_base':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_EVENT_GALLERYIMAGE_GALLERY_BASE);
                $propbag->add('description', PLUGIN_EVENT_GALLERYIMAGE_GALLERY_BASE_BLAHBLAH);
                $propbag->add('default',     'https://mywebsite.com/gallery');
                break;

            case 'album_base':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_EVENT_GALLERYIMAGE_ALBUM_BASE);
                $propbag->add('description', PLUGIN_EVENT_GALLERYIMAGE_ALBUM_BASE_BLAHBLAH);
                $propbag->add('default',     'https://mywebsite.com/albums');
                break;

            case 'gallery_abs':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_EVENT_GALLERYIMAGE_GALLERY_ABS);
                $propbag->add('description', PLUGIN_EVENT_GALLERYIMAGE_GALLERY_ABS_BLAHBLAH);
                $propbag->add('default',     $serendipity['serendipityPath'] . 'gallery');
                break;

            case 'album_abs':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_EVENT_GALLERYIMAGE_ALBUM_ABS);
                $propbag->add('description', PLUGIN_EVENT_GALLERYIMAGE_ALBUM_ABS_BLAHBLAH);
                $propbag->add('default',     $serendipity['serendipityPath'] . 'albums');
                break;

            case 'popup_max':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_EVENT_GALLERYIMAGE_ALBUM_MAXPOPUPSIZE);
                $propbag->add('description', PLUGIN_EVENT_GALLERYIMAGE_ALBUM_MAXPOPUPSIZE_BLAHBLAH);
                $propbag->add('default',     '640');
                break;

            case 'thumb_max':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_EVENT_GALLERYIMAGE_ALBUM_MAXTHUMBSIZE);
                $propbag->add('description', PLUGIN_EVENT_GALLERYIMAGE_ALBUM_MAXTHUMBSIZE_BLAHBLAH);
                $propbag->add('default',     '120');
                break;

            default:
                $propbag->add('type',        'boolean');
                $propbag->add('name',        constant($name));
                $propbag->add('description', sprintf(APPLY_MARKUP_TO, constant($name)));
                $propbag->add('default',     'true');
                break;

        }
        return true;
    }

    function install()
    {
        serendipity_plugin_api::hook_event('backend_cache_entries', $this->title);
    }

    function uninstall(&$propbag)
    {
        serendipity_plugin_api::hook_event('backend_cache_purge', $this->title);
        serendipity_plugin_api::hook_event('backend_cache_entries', $this->title);
    }

    function g2_imagesize($width, $height, $maxsize)
    {
        $maxwidth = $maxsize;
        $maxheight= $maxsize;
        if ($width > $maxwidth || $height > $maxheight) {
            if ($width > $maxwidth) {
                $factor_width = round(($width / $maxwidth), 2);
                $newwidth = $maxwidth;
                $newheight = round(($height / $factor_width));
            } else {
                $newwidth = $width;
                $newheight = $height;
            }
            if ($newheight > $maxheight) {
                $factor_height = round(($newheight / $maxheight), 2);
                $newwidth = round(($newwidth / $factor_height));
                $newheight = $maxheight;
            }
        } elseif ($width < $maxwidth || $height < $maxheight) {
            if ($width < $maxwidth) {
                $factor_width = round(($maxwidth / $width), 2);
                $newwidth = $maxwidth;
                $newheight = round(($height * $factor_width));
            } else {
                $newwidth = $width;
                $newheight = $height;
            }
            if ($newheight < $maxheight) {
                $factor_height = round(($maxheight / $newheight), 2);
                $newwidth = round(($newwidth * $factor_height));
                $newheight = $maxheight;
            }
            if ($newwidth > $maxwidth) {
                $factor_width = round(($newwidth / $maxwidth), 2);
                $newwidth = $maxwidth;
                $newheight = round(($newheight / $factor_width));
            } elseif ($newheight > $maxheight) {
                $factor_height = round(($newheight / $maxheight), 2);
                $newwidth = round(($newwidth / $factor_height));
                $newheight = $maxheight;
            }
        } else {
            $newwidth = $width;
            $newheight = $height;
        }
        $newsize = array($newwidth, $newheight);
        return $newsize;
    }

    function g2image_scale($album, $photo, $extension, $method = 'thumb')
    {
        global $serendipity;

        $gallery_base = $this->get_config('gallery_base');
        $album_base   = $this->get_config('album_base')."/albums";
        $album_abs    = $this->get_config('album_abs');
        $photo_ext    = $extension ?? 'jpg';

        $infile = $album_abs . '/albums/' . $album . '/' . $photo.'.' . $photo_ext;

        if ($method == 'thumb') {
            $outfile = $album_abs . '/tmp/' . $photo . '.thumb.' . $photo_ext;
            $size = $this->get_config('thumb_max');
        } else {
            $outfile = $album_abs . '/tmp/' . $photo . '.sized.' . $photo_ext;
            $size = $this->get_config('popup_max');
        }

        $fdim = @serendipity_getImageSize($infile, '', $extension);

        if (isset($fdim['noimage'])) {
            $r = array(0, 0);
        } else {
            if ($serendipity['magick'] !== true) {
                $r = serendipity_resizeImageGD($infile, $outfile, $size);
            } else {
                $r = array($size, $size);
                $newSize = $size . 'x' . $size;
                if ($fdim['mime'] == 'application/pdf') {
                    // too much to fix these two occurrences to use the better Styx 3.0 serendipity_passToCMD() methods since Plugin this is going to Plugin Heaven soon...
                   $cmd = escapeshellcmd($serendipity['convert']) . ' -antialias -flatten -scale '. serendipity_escapeshellarg($newSize) .' '. serendipity_escapeshellarg($infile) .' '. serendipity_escapeshellarg($outfile . '.png');
                } else {
                   $cmd = escapeshellcmd($serendipity['convert']) . ' -antialias -scale '. serendipity_escapeshellarg($newSize) .' '. serendipity_escapeshellarg($infile) .' '. serendipity_escapeshellarg($outfile);
                }

                exec($cmd, $output, $result);

                if ( $result != 0 ) {
                    echo '<div class="msg_error"><span class="icon-attention-circled" aria-hidden="true"></span> '. sprintf(IMAGICK_EXEC_ERROR, $cmd, $output[0], $result) .'</div>';
                    $r = false; // return failure
                } else {
                   touch($outfile);
                }
                unset($output, $result);
            }
        }
    }

    function event_hook($event, &$bag, &$eventData, $addData = null)
    {
        global $serendipity;

        $hooks = &$bag->get('event_hooks');

        if (isset($hooks[$event])) {
            switch($event) {
                case 'frontend_display':

                    foreach ($this->markup_elements AS $temp) {
                        if (serendipity_db_bool($this->get_config($temp['name'], 'true')) && !empty($eventData[$temp['element']])
                        &&  (!isset($eventData['properties']['ep_disable_markup_' . $this->instance]) || !$eventData['properties']['ep_disable_markup_' . $this->instance])
                        &&  !isset($serendipity['POST']['properties']['disable_markup_' . $this->instance])) {
                            $element = $temp['element'];
                            $eventData[$element] = $this->gimage_markup($eventData[$element]);
                        }
                    }
                    break;

                case 'external_plugin':

                    $uri_parts = explode('?', str_replace('&amp;', '&', $eventData));

                    // Try to get request parameters from eventData name
                    if (!empty($uri_parts[1])) {
                        $reqs = explode('&', $uri_parts[1]);
                        foreach($reqs AS $id => $req) {
                            $val = explode('=', $req);
                            if (empty($_REQUEST[$val[0]])) {
                                $_REQUEST[$val[0]] = $val[1];
                            }
                        }
                    }

                    $req = trim($uri_parts[0]);
                    switch($req) {
                        case 'g2wrapper':

                            if (isset($_REQUEST['album']) && !empty($_REQUEST['album'])) {
                                $album = trim(urldecode($_REQUEST['album']));
                            } else {
                                $album = '';
                            }

                            if (isset($_REQUEST['image']) && !empty($_REQUEST['image'])) {
                                $image = trim(urldecode($_REQUEST['image']));
                            } else {
                                $image = '';
                            }

                            if (isset($_REQUEST['ext']) && !empty($_REQUEST['ext'])) {
                                $ext = trim(urldecode($_REQUEST['ext']));
                            } else {
                                $ext = '';
                            }

                            if (isset($_REQUEST['size']) && !empty($_REQUEST['size'])) {
                                $size = trim(urldecode($_REQUEST['size']));
                            } else {
                                $size = '';
                               }
                            if ($size != 'thumb' && $size != 'sized') {
                                $size = '';
                            }

                            $album = str_replace("..", "", $album);
                            #$album = str_replace("/", "", $album);
                            $album = str_replace("\\", "", $album);

                            $image = str_replace("..", "", $image);
                            $image = str_replace("/", "", $image);
                            $image = str_replace("\\", "", $image);

                            $ext = str_replace(".", "", $ext);
                            $ext = str_replace("/", "", $ext);
                            $ext = str_replace("\\", "", $ext);

                            $size = str_replace(".", "", $size);
                            $size = str_replace("/", "", $size);
                            $size = str_replace("\\", "", $size);

                            $gallery_base = $this->get_config('gallery_base');
                            $album_base   = $this->get_config('album_base')."/albums";
                            $album_abs    = $this->get_config('album_abs');
                            $photo_ext    = $ext ?? 'jpg';

                            if ($photo_ext == "jpeg") {
                                $content_type = "image/jpeg";
                            } elseif ($photo_ext == "jpg") {
                                $content_type = "image/jpeg";
                            } elseif ($photo_ext == "gif") {
                                $content_type = "image/gif";
                            } elseif ($photo_ext == "png") {
                                $content_type = "image/png";
                            }

                            if ($size == 'thumb') {
                                $target = $album_abs . "/tmp/" . $image . ".thumb." . $photo_ext;
                                $this->g2image_scale($album, $image, $photo_ext, $size);
                            } elseif ($size == 'sized') {
                                $target = $album_abs . "/tmp/" . $image . ".sized." . $photo_ext;
                                $this->g2image_scale($album, $image, $photo_ext, $size);
                            } else {
                                $target = $album_abs . "/albums/" . $album . "/".$image . "." . $photo_ext;
                            }

                            header("Content-Type: $content_type");
                            $fp = fopen($target, "rb");
                            $image = fread($fp, filesize($target));
                            fclose($fp);
                            echo $image;

                            break;

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

    function gimage_markup ($text, $case_sensitive=false)
    {
        $preg_flags = $case_sensitive ? '' : 'i';
        $output = preg_replace_callback("'\[GImage\s*([^\]]*)]([^[]*)\[/GImage]'$preg_flags", function($matches){ return $this->gimage_thumb($matches[2], trim($matches[1])); }, $text);         

        return $output;
    }

    function gimage_thumb($photo_path, $params)
    {
        global $serendipity;

        $path_parts = pathinfo($photo_path);
        // The pathinfo function returns 'filename' from PHP 5.2 upwards, but until that has wide support, the below returns it too...
        if (strlen($path_parts["extension"]) > 0) {
            $path_parts['filename'] = substr($path_parts["basename"],0,strlen($path_parts["basename"]) - (strlen($path_parts["extension"]) + 1) );
        } else {
            $path_parts['filename'] = $path_parts["basename"];
        }

        $album = $path_parts['dirname'];
        $photo = $path_parts['filename'];
        $extension = $path_parts['extension'];

        $gallery_base = $this->get_config('gallery_base');
        $album_base   = $this->get_config('album_base');
        $album_abs    = $this->get_config('album_abs');
        $photo_ext    = $extension ?? 'jpg';

        if ($this->get_config('gversion') == 2) {
            $album_base = $this->get_config('album_base') . "/albums";
        }

        // get popup max image size, default if not good.
        $popup_max = $this->get_config('popup_max');
        if ($popup_max < 100) {
            $popup_max = 640;
        }

        $paramlist = explode(";", $params);

        // split up the parameters
        $param_array = array();
        foreach($paramlist AS $parameter) {
            $temp = explode("=", $parameter);
            $param_array[trim(strtolower($temp[0]))] = trim($temp[1]);
        }

        if ($this->get_config('gversion') == 2) {
            $image = $album_abs . '/albums/' . $album . '/' . $photo . '.' . $photo_ext;
            $image_path  = $serendipity['baseURL'] . ($serendipity['rewrite'] == "none" ? $serendipity['indexFile'] . "?/" : "/") . "plugin/g2wrapper?";
            $image_path .= "album=" . $album;
            $image_path .= "&amp;image=" . $photo;
            $image_path .= "&amp;ext=" . $photo_ext;
            // handle the parameters
            // size = thumb sized or full image?
            switch(strtolower($param_array['size'])) {
                case 'sized':
                    $image_path .= "&amp;size=sized";
                    break;

                case 'full':
                    $image_path .= "&amp;size=full";
                    break;

                case 'thumb':
                default:
                    $image_path .= "&amp;size=thumb";
                    break;
            }

        }
        // handle the parameters
        // size = thumb sized or full image?
        switch(strtolower($param_array['size'])) {
            case 'sized':
                $image_size = ".sized.";
                break;

            case 'full':
                $image_size = ".";
                break;

            case 'thumb':
            default:
                $image_size = ".thumb.";
                break;
        }

        // link = image, page, album, none?
        if ($this->get_config('gversion') == 2) {

            switch(strtolower($param_array['link'])) {
                case 'image':
                    $image_link  = $serendipity['baseURL'] . ($serendipity['rewrite'] == "none" ? $serendipity['indexFile'] . "?/" : "/") . "plugin/g2wrapper?";
                    $image_link .= "album=".$album;
                    $image_link .= "&amp;image=".$photo;
                    $image_link .= "&amp;ext=".$photo_ext;
                    $image_link .= "&amp;size=";
                    break;

                case 'image_sized':
                    $image_link  = $serendipity['baseURL'] . ($serendipity['rewrite'] == "none" ? $serendipity['indexFile'] . "?/" : "/") . "plugin/g2wrapper?";
                    $image_link .= "album=".$album;
                    $image_link .= "&amp;image=".$photo;
                    $image_link .= "&amp;ext=".$photo_ext;
                    $image_link .= "&amp;size=sized";
                    break;

                case 'album':

                    include_once($this->get_config('gallery_abs') . "/embed.php");
                    if (!class_exists('GalleryEmbed')) {
                        break;
                    }

                    $ret = GalleryEmbed::init(array('fullInit' => true, 'activeUserId' => ''));
                    if (is_object($ret) && $ret->isError()) {
                        echo $ret->getAsHtml();
                        exit;
                    }

                    $ret_aid  = GalleryCoreApi::fetchItemIdByPath($album);
                    $album_id = (is_array($ret_aid) && intval($ret_aid[1]) >= 1) ? intval($ret_aid[1]) : 0;

                    $image_link = $gallery_base . '/main.php?g2_view=core.ShowItem&amp;g2_itemId=' . $album_id;
                    break;

                case 'page':
                default:
                    include_once($this->get_config('gallery_abs') . "/embed.php");
                    if (!class_exists('GalleryEmbed')) {
                        break;
                    }

                    $ret = GalleryEmbed::init(array('fullInit' => true, 'activeUserId' => ''));
                    if (is_object($ret) && $ret->isError()) {
                        echo $ret->getAsHtml();
                        exit;
                    }

                    $ret_iid = GalleryCoreApi::fetchItemIdByPath($album . "/" . $photo . "." . $photo_ext);
                    $fullsize_id = (is_array($ret_iid) && intval($ret_iid[1]) >=1 ) ? intval($ret_iid[1]) : 0;

                    $image_link = $gallery_base.'/main.php?g2_view=core.ShowItem&amp;g2_itemId=' . $fullsize_id;
                    break;
            }

        } else {
            switch(strtolower($param_array['link'])) {
                case 'image':
                    $image_link = $album_base . '/'.$album . '/'. $photo . '.' . $photo_ext;
                    break;

                case 'image_sized':
                    $image_link = $album_base . '/'.$album . '/' . $photo . '.sized.' . $photo_ext;
                    break;

                case 'album':
                    $image_link = $gallery_base . '/view_album.php?set_albumName=' . $album;
                    break;

                case 'page':
                default:
                    $image_link = $gallery_base . '/view_photo.php?set_albumName=' . $album . '&amp;id=' . $photo;
                    break;
            }
        }
        if ($this->get_config('gversion') != 2) {
            // get thumbnail image attributes
            list($width, $height, $type, $attr) = getimagesize($album_base . '/' . $album . '/' . $photo . $image_size . $photo_ext);
        } else {
            $thissize = getimagesize($album_abs . '/albums/' . $album . '/' . $photo . "." . $photo_ext);
            if (strtolower($param_array['size']) == 'sized') {
                $newsize = $this->g2_imagesize($thissize[0], $thissize[1], $this->get_config('popup_max'));
                $width= $newsize[0];
                $height = $newsize[1];
                $attr = 'width="' . $width . '" height="' . $height . '"';
            } elseif (strtolower($param_array['size']) == 'thumb') {
                $newsize = $this->g2_imagesize($thissize[0], $thissize[1], $this->get_config('thumb_max'));
                $width= $newsize[0];
                $height = $newsize[1];
                $attr = 'width="' . $width . '" height="' . $height . '"';
            } else {
                list($width, $height, $type, $attr) = getimagesize($album_abs . "/albums/" . $album . "/" . $photo . "." . $photo_ext);
            }
        }

        // target=default|new|popup only allow popup for link=image and link-image_sized
        switch(strtolower($param_array['target'])) {

            case 'popup':
                if ($this->get_config('gversion') != 2) {
                    if ((strtolower($param_array['link']) == 'image') || (strtolower($param_array['link']) == 'image_sized')) {
                        // get target image attributes
                        list($pwidth, $pheight, $ptype, $pattr) = getimagesize($image_link);

                        // work out popup image window size
                        if (($pwidth >= $pheight) && ($pwidth > $popup_max)) {
                            $pwidth = $popup_max;
                            $pheight = round($popup_max * $height / $width);  // from thumbnail
                        } elseif (($pheight >= $pwidth) && ($pheight > $popup_max)) {
                            $pheight = $popup_max;
                            $pwidth = round($popup_max * $width / $height);   // from thumbnail
                        }

                        // standard spacing for windows and title bars
                        $pwidth += 30;
                        $pheight += 50;

                        $link_target = '<a href="javascript:;" ';
                        $link_target .= ' onclick="w = window.open(';
                        $link_target .= "'" . $image_link . "', 'GImage Popup','width=$pwidth,height=$pheight,menubar=no,resizable=yes,scrollbars=yes,status=no,toolbar=no');";
                        $link_target .= 'w.resizeTo(' . $pwidth . ',' . $pheight . ')">';
                    } else {
                        $link_target = '<a href="' . $image_link . '">';
                    }
                } else {
                    $link_target = '<a href="' . $image_link . '">';
                }
                break;

            case 'new':
                $link_target = '<a href="' . $image_link . '" target="_blank" rel="noopener">';
                break;

            case 'none':
                $link_target = '';
                break;

            case 'default':
            default:
                $link_target = '<a href="' . $image_link . '">';
                break;
        }

        // align = left, center, right? default center
        switch(strtolower($param_array['align'])) {
            case 'left':
                $div_align = 'left';
                $img_align = 'align=left';
                $img_pre = '';
                $img_post = '';
                break;

            case 'right':
                $div_align = 'right';
                $img_align = 'align=right';
                $img_pre = '';
                $img_post = '';
                break;

            case 'center':
                $div_align = 'center';
                $img_align = '';
                $img_pre = '<center>';
                $img_post = '</center>';
                break;

            case 'none':
            default:
                $div_align = 'center';
                $img_align = '';
                $img_pre = '';
                $img_post = '';
                break;

        }

        // caption = image alt text or caption
        if ($param_array['caption'] == "") {
            $param_array['caption'] = "[PHOTO]";
        }
        $param_array['caption'] = str_replace("\"", "", $param_array['caption']);
        $param_array['caption'] = str_replace("'", "", $param_array['caption']);
        $param_array['caption'] = str_replace("&quot;", "", $param_array['caption']);

        // style = link, image or fancy (s9y stylesheet image amanager style)?
        switch(strtolower($param_array['style'])) {
            case 'image':
                if ($this->get_config('gversion') == 2) {
                    $output = $img_pre.'<img ' . $img_align . ' src="' . $image_path . '" alt="' . $param_array['caption'].'" />' . $img_post;
                } else {
                    $output = $img_pre.'<img ' . $img_align . ' src="' . $album_base . '/' . $album . '/' . $photo . $image_size . $photo_ext . '" alt="' . $param_array['caption'].'" />' . $img_post;
                }
                break;

            case 'fancy':
                $output = '<div class="serendipity_imageComment_' . $div_align . '" style="width: ' . $width . 'px">';
                $output .= '<div class="serendipity_imageComment_img">';
                if ($this->get_config('gversion') == 2) {
                    $output .= $link_target . '<img src="' . $image_path . '" border="0" hspace="5" ' . $attr . ' /></a>';
                } else {
                    $output .= $link_target . '<img src="' . $album_base . '/' . $album . '/' . $photo . $image_size . $photo_ext . '" border="0" hspace="5" ' . $attr . ' /></a>';
                }
                $output .= '</div><div class="serendipity_imageComment_txt">' . $param_array['caption'] . '</div></div>';
                break;

            case 'link':
            default:
                if ($this->get_config('gversion') == 2) {
                    $output = $img_pre . $link_target . '<img ' . $img_align . ' src="' . $image_path . '" alt="' . $param_array['caption'] . '" /></a>' . $img_post;
                } else {
                    $output = $img_pre . $link_target . '<img ' . $img_align . ' src="' . $album_base . '/' . $album . '/' . $photo . $image_size . $photo_ext . '" alt="' . $param_array['caption'] . '" /></a>' . $img_post;
                }
                break;
        }

        return $output;
    }

}

?>