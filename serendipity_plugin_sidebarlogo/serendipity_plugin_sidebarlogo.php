<?php
/* Contributed by Adam Krause (http://www.pigslipstick.com/), Oliver Gerlach (http://www.stumblingpilgrim.net/) */

declare(strict_types=1);

if (IN_serendipity !== true) {
    die ("Don't hack!");
}

@serendipity_plugin_api::load_language(dirname(__FILE__));

class serendipity_plugin_sidebarlogo extends serendipity_plugin
{
    public  $title = PLUGIN_SIDEBARLOGO_NAME;

    function introspect(&$propbag)
    {
        global $serendipity;

        $propbag->add('name',          PLUGIN_SIDEBARLOGO_NAME);
        $propbag->add('description',   PLUGIN_SIDEBARLOGO_DESC);
        $propbag->add('stackable',     true);
        $propbag->add('author',        'Adam Krause & Oliver Gerlach, Ian Styx');
        $propbag->add('version',       '1.0.0');
        $propbag->add('requirements',  array(
            'serendipity' => '5.0',
            'smarty'      => '4.1',
            'php'         => '8.2'
        ));

        $propbag->add('configuration', array('title',
                                             'image',
                                             'imagewidth',
                                             'imageheight',
                                             'imagetext',
                                             'description',
                                             'imagestyle',
                                             'descriptionstyle',
                                             'sitename',
                                             'sitenamestyle',
                                             'sitetag',
                                             'sitetagstyle',
                                             'contact',
                                             'contactstyle',
                                             'copyright',
                                             'copyrightstyle',
                                             'delimiterstyle',
                                             'sequence',
                                             ));
        // select the appropriate groups in spartacus that match this plugin
        $propbag->add('groups',        array('FRONTEND_FEATURES'));
        // group config options. All options not in this list remain ungrouped and are visible always
        $propbag->add('config_groups', array(
                    PLUGIN_SIDEBARLOGO_GROUP_MOREOPTIONS => array(
                    'sitename',
                    'sitetag',
                    'contact',
                    'copyright',
                    'sequence'
                ),
                    PLUGIN_SIDEBARLOGO_GROUP_STYLES => array(
                    'imagestyle',
                    'descriptionstyle',
                    'sitenamestyle',
                    'sitetagstyle',
                    'contactstyle',
                    'copyrightstyle',
                    'delimiterstyle'
                )
        ));
    }

    function introspect_config_item($name, &$propbag)
    {
        switch($name)
        {
            case 'title':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_SIDEBARLOGO_TITLE);
                $propbag->add('description', PLUGIN_SIDEBARLOGO_TITLE_DESC);
                $propbag->add('default',     'My Logo');
                break;

            case 'image':
                $propbag->add('type',        'media');
                $propbag->add('name',        PLUGIN_SIDEBARLOGO_IMAGE);
                $propbag->add('description', PLUGIN_SIDEBARLOGO_IMAGE_DESC);
                $propbag->add('default',     '');
                break;

            case 'imagewidth':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_SIDEBARLOGO_IMAGEWIDTH);
                $propbag->add('description', PLUGIN_SIDEBARLOGO_IMAGEWIDTH_DESC);
                $propbag->add('default',     '');
                break;

            case 'imageheight':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_SIDEBARLOGO_IMAGEHEIGHT);
                $propbag->add('description', PLUGIN_SIDEBARLOGO_IMAGEHEIGHT_DESC);
                $propbag->add('default',     '');
                break;

            case 'imagetext':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_SIDEBARLOGO_IMAGETEXT);
                $propbag->add('description', PLUGIN_SIDEBARLOGO_IMAGETEXT_DESC);
                $propbag->add('default',     PLUGIN_SIDEBARLOGO_IMAGETEXT_MISSING);
                break;

            case 'description':
                $propbag->add('type',        'text');
                $propbag->add('name',        PLUGIN_SIDEBARLOGO_DESCRIPTION);
                $propbag->add('description', PLUGIN_SIDEBARLOGO_DESCRIPTION_DESC);
                $propbag->add('default',     PLUGIN_SIDEBARLOGO_DEFAULT_DESCRIPTION);
                break;

            case 'imagestyle':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_SIDEBARLOGO_IMAGESTYLE);
                $propbag->add('description', PLUGIN_SIDEBARLOGO_IMAGESTYLE_DESC);
                $propbag->add('default',     '.serendipity_imageComment_left');
                break;

            case 'descriptionstyle':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_SIDEBARLOGO_DESCRIPTIONSTYLE);
                $propbag->add('description', PLUGIN_SIDEBARLOGO_DESCRIPTIONSTYLE_DESC);
                $propbag->add('default',     '');
                break;

            case 'sitename':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_SIDEBARLOGO_SITENAME);
                $propbag->add('description', PLUGIN_SIDEBARLOGO_SITENAME_DESC);
                $propbag->add('default',     '');
                break;

            case 'sitenamestyle':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_SIDEBARLOGO_SITENAMESTYLE);
                $propbag->add('description', PLUGIN_SIDEBARLOGO_SITENAMESTYLE_DESC);
                $propbag->add('default',     'text-align: center; font-size: 120%; font-weight: bold; text-decoration: none;');
                break;

            case 'sitetag':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_SIDEBARLOGO_SITETAG);
                $propbag->add('description', PLUGIN_SIDEBARLOGO_SITETAG_DESC);
                $propbag->add('default',     '');
                break;

            case 'sitetagstyle':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_SIDEBARLOGO_SITETAGSTYLE);
                $propbag->add('description', PLUGIN_SIDEBARLOGO_SITETAGSTYLE_DESC);
                $propbag->add('default',     'text-align: center; font-size: 105%; font-weight: bold; text-decoration: none;');
                break;

            case 'contact':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_SIDEBARLOGO_CONTACT);
                $propbag->add('description', PLUGIN_SIDEBARLOGO_CONTACT_DESC);
                $propbag->add('default',     '');
                break;

            case 'contactstyle':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_SIDEBARLOGO_CONTACTSTYLE);
                $propbag->add('description', PLUGIN_SIDEBARLOGO_CONTACTSTYLE_DESC);
                $propbag->add('default',     'text-align: right; font-size: 100%; font-weight: normal; text-decoration: none;');
                break;

            case 'copyright':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_SIDEBARLOGO_COPYRIGHT);
                $propbag->add('description', PLUGIN_SIDEBARLOGO_COPYRIGHT_DESC);
                $propbag->add('default',     '');
                break;

            case 'copyrightstyle':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_SIDEBARLOGO_COPYRIGHTSTYLE);
                $propbag->add('description', PLUGIN_SIDEBARLOGO_COPYRIGHTSTYLE_DESC);
                $propbag->add('default',     'text-align: right; font-size: 80%; font-weight: normal; text-decoration: overline underline;');
                break;

            case 'delimiterstyle':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_SIDEBARLOGO_DELIMITERSTYLE);
                $propbag->add('description', PLUGIN_SIDEBARLOGO_DELIMITERSTYLE_DESC);
                $propbag->add('default',     '');
                break;

            case 'sequence':
                $propbag->add('var',         'category_sequence');
                $propbag->add('type',        'sequence');
                $propbag->add('name',        PLUGIN_SIDEBARLOGO_SEQUENCE);
                $propbag->add('description', PLUGIN_SIDEBARLOGO_SEQUENCE_DESC);
                $propbag->add('checkable', true);
                $propbag->add('values',      array(
                                                   'delimiter'   => array('display' => PLUGIN_SIDEBARLOGO_DELIMITER),
                                                   'sitename'    => array('display' => PLUGIN_SIDEBARLOGO_SITENAME),
                                                   'sitetag'     => array('display' => PLUGIN_SIDEBARLOGO_SITETAG),
                                                   'image'       => array('display' => PLUGIN_SIDEBARLOGO_IMAGE),
                                                   'description' => array('display' => PLUGIN_SIDEBARLOGO_DESCRIPTION),
                                                   'contact'     => array('display' => PLUGIN_SIDEBARLOGO_CONTACT),
                                                   'copyright'   => array('display' => PLUGIN_SIDEBARLOGO_COPYRIGHT)
                                                   ));
                $propbag->add('default',     'image,description');
                break;

            default:
                return false;
        }
    return true;
    }

    function generate_content(&$title)
    {
        global $serendipity;

        $title              = $this->get_config('title');
        $image              = $this->get_config('image');
        $imagewidth         = $this->get_config('imagewidth');
        $imageheight        = $this->get_config('imageheight');
        $imagetext          = $this->get_config('imagetext') ?? '';
        $description        = $this->get_config('description');
        $imagestyle         = $this->get_config('imagestyle') ?? '';
        $descriptionstyle   = $this->get_config('descriptionstyle');
        $sitename           = $this->get_config('sitename');
        $sitenamestyle      = $this->get_config('sitenamestyle');
        $sitetag            = $this->get_config('sitetag');
        $sitetagstyle       = $this->get_config('sitetagstyle');
        $contact            = $this->get_config('contact');
        $contactstyle       = $this->get_config('contactstyle');
        $copyright          = $this->get_config('copyright');
        $copyrightstyle     = $this->get_config('copyrightstyle');
        $delimiterstyle     = $this->get_config('delimiterstyle');
        $sequence           = $this->get_config('sequence');

        // prepare for output
        $sequence           = explode(",", $sequence);

        if ($imagewidth != "") {
            $iwidth = "width='".$imagewidth."'";
        } else {
            $iwidth = '';
        }

        if ($imageheight != "") {
            $iheight = "height='".$imageheight."'";
        } else {
            $iheight = '';
        }

        $imagestyle = $this->generate_style_attribute($imagestyle);
        $descriptionstyle = $this->generate_style_attribute($descriptionstyle);
        $sitenamestyle = $this->generate_style_attribute($sitenamestyle);
        $sitetagstyle = $this->generate_style_attribute($sitetagstyle);
        $contactstyle = $this->generate_style_attribute($contactstyle);
        $copyrightstyle = $this->generate_style_attribute($copyrightstyle);
        $delimiterstyle = $this->generate_style_attribute($delimiterstyle);

        $sbl_bname  = basename($image); // to get base file name w/ ext
        $sbl_vpath  = str_replace($sbl_bname, '', $image); // get file path
        #$sbl_vbext  = pathinfo($image, PATHINFO_EXTENSION); // get extension
        $sbl_fname  = pathinfo($image, PATHINFO_FILENAME); // get file name w/o extension
        $sbl_rpath  = $sbl_vpath . '.v/' . $sbl_fname . '.avif'; // the relative document root image filepath
        $image_avif = file_exists(str_replace($serendipity['serendipityHTTPPath'], '', $serendipity['serendipityPath']) . $sbl_rpath) ? $sbl_rpath : null; // file exist needs full path to check
        $sbl_rpath  = $sbl_vpath . '.v/' . $sbl_fname . '.webp'; // the relative document root image filepath
        $image_webp = file_exists(str_replace($serendipity['serendipityHTTPPath'], '', $serendipity['serendipityPath']) . $sbl_rpath) ? $sbl_rpath : null; // file exist needs full path to check

        // output
        foreach( $sequence AS $val ) {
            switch( $val ) {
                case 'image':
                    if (!empty($image)) {
                        echo '<picture><source type="image/avif" srcset="'.$image_avif.'"/><source type="image/webp" srcset="'.$image_webp.'"/><img src="'.$image.'" class="sidebarlogo_img" '.$iwidth.' '.$iheight.' alt="'.$imagetext.'" '.$imagestyle.'/></picture>';
                    }
                    break;

                case 'description':
                    if (!empty($descriptionstyle)) {
                        echo "<div ".$descriptionstyle.">\n";
                    }
                    if (!empty($description)) {
                        echo $description."\n";
                    }
                    if (!empty($descriptionstyle)) {
                        echo "</div>\n";
                    }
                    break;

                case 'delimiter':
                    if (!empty($delimiterstyle)) {
                        echo "<div ".$delimiterstyle."></div>";
                    }
                    break;

                case 'sitename':
                    if (!empty($sitenamestyle)) {
                        echo "<div ".$sitenamestyle.">\n";
                    }
                    if (!empty($sitename)) {
                        echo $sitename."\n";
                    }
                    if (!empty($sitenamestyle)) {
                        echo "</div>\n";
                    }
                    break;

                case 'sitetag':
                    if (!empty($sitetagstyle)) {
                        echo "<div ".$sitetagstyle.">\n";
                    }
                    if (!empty($sitetag)) {
                        echo $sitetag."\n";
                    }
                    if (!empty($sitetagstyle)) {
                        echo "</div>\n";
                    }
                    break;

                case 'contact':
                    if (!empty($contactstyle)) {
                        echo "<div ".$contactstyle.">\n";
                    }
                    if (!empty($contact)) {
                        echo $contact."\n";
                    }
                    if (!empty($contactstyle)) {
                        echo "</div>\n";
                    }
                    break;

                case 'copyright':
                    if (!empty($copyrightstyle)) {
                        echo "<div ".$copyrightstyle.">\n";
                    }
                    if (!empty($copyright)) {
                        echo $copyright."\n";
                    }
                    if (!empty($copyrightstyle)) {
                        echo "</div>\n";
                    }
                    break;
            }
        }
    }

    /**
     * @brief create a full HTML attribute from style information
     * @param stylestring input string to parse for style information
     * @return attribute containing the resulting attribute
     *
     * Depending on the input string this method either creates a style attribute, a class attribute or an id attribute.
     * The choice is made on the first character of the input string.
     * A leading '#' denotes an id while a leading '.' denotes a class and everything else is taken as inline CSS.
     */
    function generate_style_attribute(&$stylestring)
    {
        if ( $stylestring != "" ) {
            if ( $stylestring[0] == "." )
                return "class='".substr($stylestring,1)."'";
            else if ( $stylestring[0] == "#" )
                return "id='".substr($stylestring,1)."'";
            else
                return "style='".$stylestring."'";
            return "";
        }
        return "";
    }

}

/* vim: set sts=4 ts=4 expandtab : */
?>