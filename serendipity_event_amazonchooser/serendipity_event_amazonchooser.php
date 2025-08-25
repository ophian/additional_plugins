<?php

// outdated! Convert for https://webservices.amazon.com/paapi5/searchitems
//                       https://webservices.amazon.com/paapi5/documentation/register-for-pa-api.html

declare(strict_types=1);

if (IN_serendipity !== true) {
    die ("Don't hack!");
}

@serendipity_plugin_api::load_language(dirname(__FILE__));

if (!function_exists('Amazon_country_code')) {
   include(dirname(__FILE__) . '/Amazon_s9y_lib.php');
}

class serendipity_event_amazonchooser extends serendipity_event
{
    public $title = PLUGIN_EVENT_AMAZONCHOOSER_TITLE;

    function introspect(&$propbag)
    {
        global $serendipity;

        $propbag->add('name',          PLUGIN_EVENT_AMAZONCHOOSER_TITLE);
        $propbag->add('description',   PLUGIN_EVENT_AMAZONCHOOSER_DESC);
        $propbag->add('stackable',     false);
        $propbag->add('author',        'Matthew Groeninger, Ian Styx');
        $propbag->add('version',       '1.2.2');
        $propbag->add('requirements',  array(
            'serendipity' => '5.0',
            'smarty'      => '4.1',
            'php'         => '8.2'
        ));
        $propbag->add('cachable_events', array('frontend_display' => true));
        $propbag->add('event_hooks',    array(
            'backend_entry_toolbar_extended'    => true,
            'backend_entry_toolbar_body'        => true,
            'external_plugin'                   => true,
            'css_backend'                       => true,
            'css'                               => true,
            'frontend_display'                  => true,
            'backend_wysiwyg'                   => true,
            'serendipity_event_amazonchooser_button' => true,
            'serendipity_event_amazonchooser_devinfo' => true
        ));
        $propbag->add('groups', array('BACKEND_EDITOR'));
        $propbag->add('configuration',  array(
            'dtoken',
            'secretKey',
            'aaid',
            'server'
          ));
        $this->markup_elements = array(
            array(
              'name'     => 'ENTRY_BODY',
              'element'  => 'body',
            ),
            array(
              'name'     => 'EXTENDED_BODY',
              'element'  => 'extended'
           )
        );
    }

    function introspect_config_item($name, &$propbag)
    {
        switch($name) {
            case 'secretKey':
                $propbag->add('type', 'string');
                $propbag->add('name', PLUGIN_EVENT_AMAZONCHOOSER_DEV_SECRET);
                $propbag->add('description', PLUGIN_EVENT_AMAZONCHOOSER_DEV_SECRET_DESC);
                $propbag->add('default', '');
                break;
            case 'dtoken':
                $propbag->add('type', 'string');
                $propbag->add('name', PLUGIN_EVENT_AMAZONCHOOSER_DEV_TOKEN);
                $propbag->add('description', PLUGIN_EVENT_AMAZONCHOOSER_DEV_TOKEN_DESC);
                $propbag->add('default', '');
                break;
            case 'aaid':
                $propbag->add('type', 'string');
                $propbag->add('name', PLUGIN_EVENT_AMAZONCHOOSER_ASSOCIATE_ID);
                $propbag->add('description', PLUGIN_EVENT_AMAZONCHOOSER_ASSOCIATE_ID_DESC);
                break;
            case 'server':
                $propbag->add('type', 'radio');
                $propbag->add('name', PLUGIN_EVENT_AMAZONCHOOSER_SERVER);
                $propbag->add('description', PLUGIN_EVENT_AMAZONCHOOSER_SERVER_DESC);
                $propbag->add('radio', array(
                    'value' => array('ca', 'cn', 'de', 'es', 'fr', 'it', 'jp', 'uk', 'us'),
                    'desc'  => array(PLUGIN_EVENT_AMAZONCHOOSER_CA,PLUGIN_EVENT_AMAZONCHOOSER_CN,PLUGIN_EVENT_AMAZONCHOOSER_GERMANY,PLUGIN_EVENT_AMAZONCHOOSER_ES,PLUGIN_EVENT_AMAZONCHOOSER_FR,PLUGIN_EVENT_AMAZONCHOOSER_IT,PLUGIN_EVENT_AMAZONCHOOSER_JAPAN,PLUGIN_EVENT_AMAZONCHOOSER_UK,PLUGIN_EVENT_AMAZONCHOOSER_US)
                ));
                $propbag->add('radio_per_row', '1');
                $propbag->add('default', 'us');
                break;

            default:
                return false;
        }
        return true;
    }

    function event_hook($event, &$bag, &$eventData, $addData = null)
    {
        global $serendipity;

        $hooks = &$bag->get('event_hooks');

        if (isset($hooks[$event])) {

            switch($event) {

                case 'backend_entry_toolbar_extended':
                    if (isset($eventData['backend_entry_toolbar_extended:textarea'])) {
                        $txtarea = $eventData['backend_entry_toolbar_extended:nugget'];
                    } else {
                        $txtarea = 'serendipity_textarea_extended';
                    }
                    if (!$serendipity['wysiwyg']) {
                        $this->generate_button($txtarea,false);
                        return true;
                    } else {
                        return false;
                    }
                    break;

                case 'backend_entry_toolbar_body':
                    if (isset($eventData['backend_entry_toolbar_body:textarea'])) {
                        $txtarea = $eventData['backend_entry_toolbar_body:nugget'];
                    } else {
                        $txtarea = 'serendipity_textarea_body';
                    }
                    if (!$serendipity['wysiwyg']) {
                        $this->generate_button($txtarea,false);
                        return true;
                    } else {
                        return false;
                    }
                    break;

                case 'frontend_display':
                    foreach ($this->markup_elements AS $temp) {
                        if (serendipity_db_bool($this->get_config($temp['name'], 'true')) && !empty($eventData[$temp['element']])
                        &&  (!isset($eventData['properties']['ep_disable_markup_' . $this->instance]) || !$eventData['properties']['ep_disable_markup_' . $this->instance])
                        &&  !isset($serendipity['POST']['properties']['disable_markup_' . $this->instance])) {
                            $element = $temp['element'];
                            $eventData[$element] = preg_replace_callback('/(?<!\\\\)\[amazon_chooser\](.*?),(.*?)\[\/amazon_chooser\]/', array(&$this,'get_amazon_item'), $eventData[$element]);
                       }
                    }
                    break;

                case 'backend_wysiwyg':
                    $link = serendipity_rewriteURL('plugin/amazonch') . ($serendipity['rewrite'] != 'none' ? '?' : '&amp;') . 'txtarea=' . 'amazonchooser'.$eventData['item'];
                    $open = 'serendipity.openPopup';
                    $eventData['buttons'][] = array(
                        'id'         => 'amazonchooser' . $eventData['item'],
                        'name'       => PLUGIN_EVENT_AMAZONCHOOSER_MEDIA_BUTTON,
                        'javascript' => 'function() { '.$open.'(\'' . $link . '\', \'AmazonImageSel\', \'width=800,height=600,toolbar=no,scrollbars=1,scrollbars,resize=1,resizable=1\') }',
                        'svg'        => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-amazon" viewBox="0 0 16 16"><path d="M10.813 11.968c.157.083.36.074.5-.05l.005.005a90 90 0 0 1 1.623-1.405c.173-.143.143-.372.006-.563l-.125-.17c-.345-.465-.673-.906-.673-1.791v-3.3l.001-.335c.008-1.265.014-2.421-.933-3.305C10.404.274 9.06 0 8.03 0 6.017 0 3.77.75 3.296 3.24c-.047.264.143.404.316.443l2.054.22c.19-.009.33-.196.366-.387.176-.857.896-1.271 1.703-1.271.435 0 .929.16 1.188.55.264.39.26.91.257 1.376v.432q-.3.033-.621.065c-1.113.114-2.397.246-3.36.67C3.873 5.91 2.94 7.08 2.94 8.798c0 2.2 1.387 3.298 3.168 3.298 1.506 0 2.328-.354 3.489-1.54l.167.246c.274.405.456.675 1.047 1.166ZM6.03 8.431C6.03 6.627 7.647 6.3 9.177 6.3v.57c.001.776.002 1.434-.396 2.133-.336.595-.87.961-1.465.961-.812 0-1.286-.619-1.286-1.533M.435 12.174c2.629 1.603 6.698 4.084 13.183.997.28-.116.475.078.199.431C13.538 13.96 11.312 16 7.57 16 3.832 16 .968 13.446.094 12.386c-.24-.275.036-.4.199-.299z"/><path d="M13.828 11.943c.567-.07 1.468-.027 1.645.204.135.176-.004.966-.233 1.533-.23.563-.572.961-.762 1.115s-.333.094-.23-.137c.105-.23.684-1.663.455-1.963-.213-.278-1.177-.177-1.625-.13l-.09.009q-.142.013-.233.024c-.193.021-.245.027-.274-.032-.074-.209.779-.556 1.347-.623"/></svg>',
// no need when we have css_backend hook. Else use this
                        'css'        => '.tox .tox-tbtn svg.bi.bi-amazon { fill: #b87f32; }[data-color-mode="dark"] .tox .tox-tbtn svg.bi.bi-amazon { fill: #d2b48c; }',
                        'toolbar'    => 'other'
                    );
                    break;

                case 'css_backend':
                case 'css':
                    $out = serendipity_getTemplateFile('serendipity_event_amazonchooser.css', 'serendipityPath');
                    if ($out && $out != 'serendipity_event_amazonchooser.css') {
                        $eventData .= file_get_contents($out);
                    } else {
                        $eventData .= file_get_contents(dirname(__FILE__) . '/serendipity_event_amazonchooser.css');
                    }
                    break;


                case 'serendipity_event_amazonchooser_button':
                    $eventData['button_out'] = $this->generate_button($eventData['textbox'],true);
                    break;

                case 'serendipity_event_amazonchooser_devinfo':
                    $eventData['dtoken']    = trim($this->get_config('dtoken'));
                    $eventData['secretKey'] = trim($this->get_config('secretKey'));
                    $eventData['aaid']      = trim($this->get_config('aaid'));
                    break;

                case 'external_plugin':
                    $uri_parts = explode('?', str_replace('&amp;', '&', $eventData));
                    $parts     = explode('&', $uri_parts[0]);

                    $uri_part = $parts[0];
                    $parts = array_pop($parts);

                    if (is_array($parts) && count($parts) > 1) {
                       foreach($parts AS $key => $value) {
                            $val = explode('=', $value);
                            $_GET[$val[0]] = $val[1];
                       }
                    } else {
                       $val = explode('=', $parts[0]);
                       if (isset($val[1])) $_GET[$val[0]] = $val[1];
                    }

                    if (!isset($_GET['txtarea'])) {
                        if (isset($uri_parts[1])) {
                            $parts = explode('&', $uri_parts[1]);
                            if (is_array($parts) && count($parts) > 1) {
                                foreach($parts AS $key => $value) {
                                     $val = explode('=', $value);
                                     $_GET[$val[0]] = $val[1];
                                }
                            } else {
                                $val = explode('=', $parts[0]);
                                $_GET[$val[0]] = $val[1];
                            }
                        }
                    }

                    switch($uri_part) {
                        case 'amazonch-js':
                            header('Content-Type: text/javascript');
                            echo file_get_contents(dirname(__FILE__) . '/serendipity_event_amazonchooser.js');
                            break;

                        case 'plugin_amazonchooser.gif':
                            header('Content-Type: image/gif');
                            echo file_get_contents(dirname(__FILE__) . '/serendipity_event_amazonchooser.gif');
                            break;

                        case 'amazonch':
                            session_start();
                            include('serendipity_config.inc.php');
                            if (IN_serendipity !== true) {
                                die ("Don't hack!");
                            }

                            if (!isset($serendipity['smarty']) || !is_object($serendipity['smarty'])) {
                                serendipity_smarty_init();
                            }


                            if ($_SESSION['serendipityAuthedUser'] !== true)  {
                                die(HAVE_TO_BE_LOGGED_ON);
                            }

                            $country = trim($this->get_config('server'));
                            list($country_url,$mode) = Amazon_country_code($country);
                            $mode_names = Amazon_return_mode_array();

                            header('Content-Type: text/html; charset=' . LANG_CHARSET);


                            $tfile = serendipity_getTemplateFile('plugin_amazon_search.tpl', 'serendipityPath');
                            if (!$tfile || $tfile == 'plugin_amazon_search.tpl') {
                               $tfile = dirname(__FILE__) . '/plugin_amazon_search.tpl';
                            }


                            $tdisplayfile = serendipity_getTemplateFile('plugin_amazon_display.tpl', 'serendipityPath');
                            if (!$tdisplayfile || $tdisplayfile == 'plugin_amazon_display.tpl') {
                                $tdisplayfile = dirname(__FILE__) . '/plugin_amazon_display.tpl';
                            }

                            $serendipity['smarty']->assign(
                                 array(
                                      'plugin_amazonchooser_css' => serendipity_rewriteURL('serendipity_admin.css'),
                                      'plugin_amazonchooser_js'  => serendipity_rewriteURL('plugin/amazonch-js'),
                                      'plugin_amazonchooser_darkmode' => isset($serendipity['dark_mode']) && $serendipity['dark_mode'] === true
                                 ));

                            $_step = $_REQUEST['step'] ?? null;
                            switch ($_step) {
                                case '1':
                                    $page = 1;
                                    if (isset($_REQUEST['page'])) {
                                       $page = (int)$_REQUEST['page'];
                                    }
                                    if (isset($_REQUEST['simple']) && ($_REQUEST['simple'])) {
                                       $simple = "&amp;simple=1";
                                    } else {
                                        $simple = "";
                                    }
                                    $request_mode = trim(htmlspecialchars(rawurlencode($_REQUEST['mode'])));
                                    if (in_array($_REQUEST['mode'],$mode)) {
                                        $results = $this->Amazon_Call("search", $request_mode, trim(htmlspecialchars(rawurlencode($_REQUEST['keyword']))), $country_url, $page);
                                    } else {
                                        $results['return_count'] = 0;
                                        $results['count'] = 0;
                                        $results['error_message'] = PLUGIN_EVENT_AMAZONCHOOSER_INVALIDINDEX . ": " .trim(htmlspecialchars(rawurlencode($_REQUEST['mode'])));
                                    }
                                    if ($page > 1) {
                                       $previous_page = $page - 1;
                                       $serendipity['smarty']->assign(array('plugin_amazonchooser_previouspage'=>$previous_page));
                                    }
                                    if (($page < 400) && ($results['return_count'] > 10)) {
                                       $next_page = $page + 1;
                                       $serendipity['smarty']->assign(array('plugin_amazonchooser_nextpage'=>$next_page));
                                    }
                                    $serendipity['smarty']->assign(
                                      array(
                                            'plugin_amazonchooser_page'             => "Search",
                                            'plugin_amazonchooser_displaytemplate'  => $tdisplayfile,
                                            'plugin_amazonchooser_currentpage'      => $page,
                                            'plugin_amazonchooser_totalpages'       => $results['totalpages'],
                                            'plugin_amazonchooser_item_count'       => $results['count'],
                                            'plugin_amazonchooser_return_count'     => $results['return_count'],
                                            'plugin_amazonchooser_error_message'    => $results['error_message'],
                                            'plugin_amazonchooser_error_result'     => $results['error_result'],
                                            'plugin_amazonchooser_cache_time'       => $results['return_date'],
                                            'plugin_amazonchooser_items'            => $results['items'],
                                            'plugin_amazonchooser_search_url'       => serendipity_rewriteURL('plugin/amazonch') . ($serendipity['rewrite'] != 'none' ? '?' : '&amp;') . 'txtarea=' . htmlspecialchars($_REQUEST['txtarea']).$simple.'&amp;keyword='.trim(htmlspecialchars(rawurlencode($_REQUEST['keyword']))).'&amp;mode='.$request_mode,
                                            'plugin_amazonchooser_this_url'         => serendipity_rewriteURL('plugin/amazonch') . ($serendipity['rewrite'] != 'none' ? '?' : '&amp;') . '&amp;mode='.trim(htmlspecialchars(rawurlencode($_REQUEST['mode']))).'&amp;txtarea=' . htmlspecialchars($_REQUEST['txtarea']) .$simple. '&amp;step=1&amp;keyword='.trim(htmlspecialchars(rawurlencode($_REQUEST['keyword']))).'&amp;page=',
                                            'plugin_amazonchooser_select_url'       => serendipity_rewriteURL('plugin/amazonch') . ($serendipity['rewrite'] != 'none' ? '?' : '&amp;') . '&amp;mode='.trim(htmlspecialchars(rawurlencode($_REQUEST['mode']))).$simple.'&amp;txtarea=' . htmlspecialchars($_REQUEST['txtarea']) . '&amp;step=2&amp;asin='
                                      )
                                    );
                                    break;

                                case '2':
                                    if (isset($_REQUEST['asin'])) {
                                        $result = $this->Amazon_Call("lookup", trim(htmlspecialchars(rawurlencode($_REQUEST['mode']))), trim(htmlspecialchars(rawurlencode($_REQUEST['asin']))), $country_url, $page);
                                    } else {
                                        $result['count'] = 0;
                                        $result['error_message'] = PLUGIN_EVENT_AMAZONCHOOSER_NOASIN;
                                    }
                                    if (isset($_REQUEST['simple']) && ($_REQUEST['simple'])) {
                                       $simple = 1;
                                    } else {
                                        $simple = "";
                                    }
                                    $serendipity['smarty']->assign(
                                        array(
                                            'plugin_amazonchooser_page'             => "Lookup",
                                            'plugin_amazonchooser_displaytemplate'  => $tdisplayfile,
                                            'plugin_amazonchooser_txtarea'          => $_REQUEST['txtarea'],
                                            'plugin_amazonchooser_item_count'       => $result['count'],
                                            'plugin_amazonchooser_return_count'     => $result['return_count'],
                                            'plugin_amazonchooser_searchmode'       => trim(htmlspecialchars(rawurlencode($_REQUEST['mode']))),
                                            'plugin_amazonchooser_simple'           => $simple,
                                            'plugin_amazonchooser_error_message'    => $result['error_message'],
                                            'plugin_amazonchooser_cache_time'       => $result['return_date'],
                                            'plugin_amazonchooser_error_result'     => $result['error_result'],
                                            'thingy'                                => $result['items'][0]
                                        )
                                    );
                                    break;

                                default:
                                    $defaultmode = isset($_REQUEST['mode']) ? rawurlencode($_REQUEST['mode']) : null;
                                    $link = serendipity_rewriteURL('plugin/amazonch') . ($serendipity['rewrite'] != 'none' ? '?' : '&amp;');
                                    foreach($mode AS $type) {
                                      $mode_out[$type] = isset($mode_names[$type]) ? $mode_names[$type] : null;
                                    }
                                    if (isset($_REQUEST['simple']) && ($_REQUEST['simple'])) {
                                       $simple = "1";
                                    } else {
                                        $simple = "0";
                                    }
                                    asort($mode_out);
                                    $serendipity['smarty']->assign(
                                        array(
                                            'plugin_amazonchooser_page'          => "default",
                                            'plugin_amazonchooser_keyword'       => isset($_REQUEST['keyword']) ? rawurldecode($_REQUEST['keyword']) : null,
                                            'plugin_amazonchooser_link'          => $link,
                                            'plugin_amazonchooser_txtarea'       => trim(htmlspecialchars(rawurlencode($_REQUEST['txtarea']))),
                                            'plugin_amazonchooser_simple'        => $simple,
                                            'plugin_amazonchooser_mode'          => $mode_out,
                                            'plugin_amazonchooser_defaultmode'   => $defaultmode
                                        )
                                    );
                                    break;
                            } // switch end

                            // use native API here - extends s9y version >= 1.3'
                            $content = $this->parseTemplate($tfile);
                            echo $content;
                            break;
                    };
                    break; // external_plugin end

                default:
                    return false;

            }
            return true;
        } else {
            return false;
        }
    }

    function generate_content(&$title)
    {
        $title = PLUGIN_EVENT_AMAZONCHOOSER_TITLE;
    }

    function generate_button($txtarea, $return_output)
    {
        global $serendipity;

        if (!isset($txtarea)) {
            $txtarea = 'serendipity_textarea_body';
        }
        $link =  serendipity_rewriteURL('plugin/amazonch') . ($serendipity['rewrite'] != 'none' ? '?' : '&amp;') . 'txtarea=' . $txtarea;
        $open = 'serendipity.openPopup';

        if ($return_output) {
            $button = '<input type="button" class="input_button" name="insAmazonImage" value="'.PLUGIN_EVENT_AMAZONCHOOSER_MEDIA_BUTTON.'" style="" onclick="'.$open.'(\''.$link."&amp;simple=1".'\', \'AmazonImageSel\', \'width=800,height=600,toolbar=no,scrollbars=1,scrollbars,resize=1,resizable=1\');">';
            return $button;
        } else {
            $button = '<input type="button" class="input_button" name="insAmazonImage" value="'.PLUGIN_EVENT_AMAZONCHOOSER_MEDIA_BUTTON.'" style="" onclick="'.$open.'(\''.$link.'\', \'AmazonImageSel\', \'width=800,height=600,toolbar=no,scrollbars=1,scrollbars,resize=1,resizable=1\');">';
            echo $button;
        }
    }

    function get_amazon_item($matches)
    {
        global $serendipity;

        $content = false;
        $asin = $matches[1];
        $Searchindex = $matches[2];
        $country = trim($this->get_config('server'));
        list($country_url,$mode) = Amazon_country_code($country);
        $content = serendipity_getCacheItem('amazonchooser'.$asin);
        if (!$content) {
            if (!isset($serendipity['smarty']) || !is_object($serendipity['smarty'])) {
                serendipity_smarty_init();
            }

            if (isset($asin)) {
                $method = "lookup";
                $result = $this->Amazon_Call($method, $Searchindex, $asin, $country_url, 0);
            } else {
                $item_count = -1;
                $error_message = PLUGIN_EVENT_AMAZONCHOOSER_NOASIN;
            }
            $serendipity['smarty']->assign(
                array(
                    'plugin_amazonchooser_item_count'    => $result['count'],
                    'plugin_amazonchooser_return_count'  => $result['return_count'],
                    'plugin_amazonchooser_error_message' => $result['error_message'],
                    'plugin_amazonchooser_error_result'  => $result['error_result'],
                    'plugin_amazonchooser_cache_time'    => $result['return_date'],
                    'thingy'                             => $result['items'][0]
                )
            );

            // use native API here - extends s9y version >= 1.3'
            $content = $this->parseTemplate('plugin_amazon_display.tpl');

            $content = str_replace("\n", '', $content);
            serendipity_cacheItem('amazonchooser'.$asin, $content);
        }
        return($content);
    }

    function Amazon_Call($method, $mode, $searchstring, $country_url, $page)
    {
        global $serendipity;

        $AWSAccessKey = trim($this->get_config('dtoken'));
        $AssociateTag = trim($this->get_config('aaid', ''));
        $secretKey = trim($this->get_config('secretKey'));
        if ($method == "search") {
            $results = Amazon_SearchItems($AWSAccessKey, $AssociateTag, $secretKey, $mode, $searchstring, $country_url, $page);
        } else {
            $results = serendipity_getCacheItem('amazonlookup'.$searchstring); // previously cached into templates_c/amazonget/ - does it matter to use the simple_cache dir per default?
            if (!$results['return_date']) {
                $results = Amazon_ItemLookup($AWSAccessKey, $AssociateTag, $secretKey, $mode, $searchstring, $country_url);
                if ($results['return_date'] && is_object($results)) {
                    serendipity_cacheItem('amazonlookup'.$searchstring, $results, 43200);
                }
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