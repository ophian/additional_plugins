<?php

declare(strict_types=1);

if (IN_serendipity !== true) {
    die ("Don't hack!");
}

@serendipity_plugin_api::load_language(dirname(__FILE__));

class serendipity_plugin_amazon extends serendipity_plugin
{

    function introspect(&$propbag)
    {
        $propbag->add('name',           PLUGIN_AMAZON_TITLE);
        $propbag->add('description',    PLUGIN_AMAZON_DESC);
        $propbag->add('configuration',  array('title','server', 'newwindows', 'small_medium_large','button','asin','cnt','cache','tracking'));
        $propbag->add('author',         'Matthew Groeninger, (original plugin by Thomas Nesges)');
        $propbag->add('stackable',      true);
        $propbag->add('version',        '2.0.0');
        $propbag->add('requirements',  array(
            'serendipity' => '5.0',
            'smarty'      => '4.1',
            'php'         => '8.2.0'
        ));
        $this->dependencies = array('serendipity_event_amazonchooser' => 'keep');
        $propbag->add('groups', array('FRONTEND_EXTERNAL_SERVICES'));
    }

    function introspect_config_item($name, &$propbag)
    {
        switch($name) {
            case 'title':
                $propbag->add('type',           'string');
                $propbag->add('name',           PLUGIN_AMAZON_PROP_TITLE);
                $propbag->add('description',    PLUGIN_AMAZON_PROP_TITLE_DESC);
                $propbag->add('default',        PLUGIN_AMAZON_TITLE);
                break;

            case 'cnt':
                $propbag->add('type',           'string');
                $propbag->add('name',           PLUGIN_AMAZON_ASIN_CNT);
                $propbag->add('description',    '');
                $propbag->add('default',        1);
                break;

            case 'cache':
                $propbag->add('type',           'string');
                $propbag->add('name',           PLUGIN_AMAZON_SIDEBAR_CACHE);
                $propbag->add('description',    PLUGIN_AMAZON_SIDEBAR_CACHE_DESC);
                $propbag->add('default',        60);
                break;

            case 'button':
                $propbag->add('type',           'content');
                $data['textbox'] =  '[plugin][asin]';
                serendipity_plugin_api::hook_event('serendipity_event_amazonchooser_button', $data);
                $propbag->add('default',        $data['button_out']);
                break;

             case 'server':
                $propbag->add('type',           'radio');
                $propbag->add('name',           PLUGIN_AMAZON_SERVER);
                $propbag->add('description',    PLUGIN_AMAZON_SERVER_DESC);
                $propbag->add('radio',          array(
                    'value' => array('ca','de','fr', 'jp', 'uk', 'us'),
                    'desc'  => array(PLUGIN_AMAZON_CA,PLUGIN_AMAZON_GERMANY,PLUGIN_AMAZON_FR,PLUGIN_AMAZON_JAPAN,PLUGIN_AMAZON_UK,PLUGIN_AMAZON_US)
                ));
                $propbag->add('radio_per_row',  '1');
                $propbag->add('default',        'us');
                break;

            case 'asin':
                $propbag->add('type',           'text');
                $propbag->add('name',           PLUGIN_AMAZON_ASIN);
                $propbag->add('description',    PLUGIN_AMAZON_ASIN_DESC);
                $propbag->add('default',        '');
                break;

            case 'newwindows':
                $propbag->add('type',           'boolean');
                $propbag->add('name',           PLUGIN_AMAZON_NEW_WINDOW);
                $propbag->add('description',    '');
                $propbag->add('default',        'true');
                break;

            case 'small_medium_large':
                $propbag->add('type',           'radio');
                $propbag->add('name',           PLUGIN_AMAZON_SMALL_MED);
                $propbag->add('description',    '');
                $propbag->add('radio',          array(
                    'value' => array('smallurl','mediumurl','largeurl'),
                    'desc'  => array(PLUGIN_AMAZON_SMALL,PLUGIN_AMAZON_MEDIUM,PLUGIN_AMAZON_LARGE)
                ));
                $propbag->add('radio_per_row',  '1');
                $propbag->add('default',        'small');
                break;

            case 'tracking':
                $propbag->add('type',           'boolean');
                $propbag->add('name',           PLUGIN_AMAZON_TRACK_GOOGLE);
                $propbag->add('description',    DESC_PLUGIN_AMAZON_TRACK_GOOGLE);
                $propbag->add('default',        'false');
                break;

            default:
                return false;
        }
        return true;
    }

    function generate_content(&$title)
    {
        if (!class_exists('serendipity_event_amazonchooser')) {
           echo PLUGIN_AMAZON_DEPENDS_ON;
           return;
        }
        $title = $this->get_config('title');
        $cache = $this->get_config('cache', '60');

        if ($cache > 0) {
            $content = serendipity_getCacheItem('amazonsidebar_content'.$title);
        }
        if (!$content) {
            $cnt = $this->get_config('cnt', 1);
            $config_asin  = $this->get_config('asin', 'blah');
            $config_asins = explode(",", $config_asin);
            $arraylen = count($config_asins);
            if ($cnt > $arraylen) {
                $cnt = $arraylen;
            }
            $asins = array_rand($config_asins, (int) $cnt);
            $cache_it = false;
            if (count((array)$asins) == 1 ) {
                $content = $this->generate_amazon_content($config_asins[$asins]);
                $content_out = $content['string'];
                if ($content['cache']) {
                    $cache_it = true;
                }
            } else {
                $content_out = '';
                foreach ($asins AS $asinnum) {
                    $content = $this->generate_amazon_content($config_asins[$asinnum]);
                    $content_out .= $content['string'];
                    if ($content['cache']) {
                        $cache_it = true;
                    }
                }
            }
            if (is_object($content) && ($cache > 0) && $cache_it) {
                serendipity_cacheItem('amazonsidebar_content'.$title, $content_out, $cache*60);
            }
        } else {
            $content_out = $content;
        }
        $content_out = str_replace('&', '&amp;', $content_out);
        echo $content_out;
    }

    function generate_amazon_content($asinbase)
    {
        $asinbase = preg_replace('/\s+/', '', $asinbase);
        list($asin,$mode) = explode("-", $asinbase);

        $content = serendipity_getCacheItem('amazonsidebar_'.$asin);
        $cache = 1;

        if (!$content) {
            $result = $this->amazon_fetch($asin, $mode);
            if ($result) {
                if (($result['count'] == 1) && ($result['return_count'] == 1)) {
                    $return_date = $result['return_date'];
                    $strings = $result['items'][0]['strings'];
                    $target = '';
                    if (serendipity_db_bool($this->get_config('newwindows', 'true'))) {
                       $target = ' target="_new" ';
                    }
                    $google_tracking = '';
                    if (serendipity_db_bool($this->get_config('tracking', 'false')) && class_exists('serendipity_event_google_analytics')) {
                        $google_tracking = "onclick=\"_gaq.push(['_trackEvent', 'Amazon', 'Click', '" . $strings['title'] . "']);\"";
                    }
                    $file_size = $this->get_config('small_medium_large','smallurl');
                    $content = '<div class="amazon_sidebar">';
                    if (isset($strings["$file_size"])) {
                       $content .= '<a ' . $google_tracking . 'href="'.$strings['DETAILPAGEURL'].'" '.$target.'><img src="'.$strings["$file_size"].'"/></a>';
                    } else {
                       $content .= '<a ' . $google_tracking . 'href="'.$strings['DETAILPAGEURL'].'" '.$target.'>'.PLUGIN_EVENT_AMAZONCHOOSER_NOIMAGE.'</a>';
                    }
                    $content .= '<div class="amazon_sidebar_details"><a ' . $google_tracking . 'href="'.$strings['DETAILPAGEURL'].'" '.$target.'>'.$strings['title'].'</a></div>';
                    $content .= '</div>';
                    serendipity_cacheItem('amazonsidebar_'.$asin, $content);
                    $cache = 1;
                } else {
                    $cache = 0;
                    $content = $result['error_message'] . "<br />" . $result['error_result']."<br />";
                }
            }
        }
        return array('string' => $content,'cache' => $cache);
    }

    function amazon_fetch($asin, $mode)
    {
        if (!class_exists('serendipity_event_amazonchooser')) {
           return;
        }

        $country = trim($this->get_config('server'));

        list($country_url,$mode_list) = Amazon_country_code($country);
        $mode_names = Amazon_return_mode_array();

        if (!(in_array($mode, $mode_list))) {
            $mode = "All";
        }
        $data = array();
        serendipity_plugin_api::hook_event('serendipity_event_amazonchooser_devinfo', $data);
        $AWSAccessKey = $data['dtoken'];
        $secretKey = $data['secretKey'];
        $AssociateTag = $data['aaid'];

        $results = serendipity_getCacheItem('amazonlookup'.$asin);
        if (!$results['return_date']) {
            $results = Amazon_ItemLookup($AWSAccessKey, $AssociateTag, $secretKey, $mode, $asin, $country_url);
            if ($results['return_date']) {
                serendipity_cacheItem('amazonlookup'.$asin, $results);
            }
        }
        if ($results['count'] == 0 || $results['return_count'] == 0) {
            $results['items'] = "";
        }
        return $results;
    }

}

/* vim: set sts=4 ts=4 expandtab : */
?>