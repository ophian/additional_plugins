<?php

if (IN_serendipity !== true) {
    die ("Don't hack!");
}

@serendipity_plugin_api::load_language(dirname(__FILE__));

class serendipity_event_multilingual extends serendipity_event
{
    var $tags  = array();
    var $title = PLUGIN_EVENT_MULTILINGUAL_TITLE;
    var $showlang = '';
    var $switch_keys = array('title', 'body', 'extended');
    var $lang_display;

    function introspect(&$propbag)
    {
        global $serendipity;

        $propbag->add('name',           PLUGIN_EVENT_MULTILINGUAL_TITLE);
        $propbag->add('description',    PLUGIN_EVENT_MULTILINGUAL_DESC);
        $propbag->add('stackable',      false);
        $propbag->add('author',         'Garvin Hicking, Wesley Hwang-Chung, Ian Styx');
        $propbag->add('requirements',   array(
            'serendipity' => '3.0',
            'smarty'      => '3.1',
            'php'         => '7.4'
        ));
        $propbag->add('groups',         array('FRONTEND_ENTRY_RELATED', 'BACKEND_EDITOR'));
        $propbag->add('version',        '3.12');
        $propbag->add('configuration',  array('copytext', 'placement', 'langified', 'tagged_title', 'tagged_entries', 'tagged_sidebar', 'langswitch'));
        $propbag->add('event_hooks',    array(
                'frontend_fetchentries'     => true,
                'frontend_fetchentry'       => true,
                'entry_display'             => true,
                'backend_configure'         => true,
                'backend_publish'           => true,
                'backend_save'              => true,
                'backend_display'           => true,
                'frontend_entryproperties'  => true,
                'backend_sidebar_entries'   => true,
                'css'                       => true,
                'backend_entryform'         => true,
                'backend_entry_presave'     => true,
                'backend_entry_updertEntry' => true,
                'frontend_entries_rss'      => true,
                'frontend_comment'          => true,
                'frontend_sidebar_plugins'  => true,
                'frontend_media_showitem'   => true,
                'frontend_rss'              => true,
                'genpage'                   => true,
        ));
        $propbag->add('legal',    array(
            'services' => array(
            ),
            'frontend' => array(
                'To remember the last selected language, it is stored in a session and cookie variable (last_lang, serendipityLanguage)',
            ),
            'backend' => array(
            ),
            'cookies' => array(
                'Cookies are used to store the selected language of blog entries'
            ),
            'stores_user_input'     => false,
            'stores_ip'             => false,
            'uses_ip'               => false,
            'transmits_user_input'  => false
        ));

        $this->supported_properties = array('lang_selected', 'lang_display');
        $this->dependencies = array('serendipity_plugin_multilingual' => 'remove');

        // Okay, Garv. I explain this to you ONCE and ONLY.
        // $this->lang_display is the variable that FORCES translations of entries. If a translation does not exist,
        //                     an entry is NOT SHOWN.
        // $this->showlang     is the variable that indicates which language of an entry to prefer.
        if (isset($serendipity['GET']['lang_display'])) {
            $this->lang_display = serendipity_db_escape_string($serendipity['GET']['lang_display']);
            if ($serendipity['expose_s9y']) serendipity_header('X-Serendipity-ML-LD-1: ' . $this->cleanheader($this->lang_display));
        }
        $langswitch = serendipity_db_bool($this->get_config('langswitch', 'true'));

        // frontend only
        if (!defined('IN_serendipity_admin')) {
            $resetlang = false;
            // GET is either a forced session or a single entry lang and we normally do not use it with cookies set, since they have preference
            if ($langswitch && (!isset($_POST['user_language']) || !isset($_COOKIE['serendipityLanguage']))) {
                // check for REQUESTs being sent (imagine the user in a DE blog links an EN entry version and force option is set TRUE)
                // $_REQUEST was somehow disabled and not available, but used here and in serendipity_getSessionLanguage()
                $_REQUEST['user_language'] = $serendipity['GET']['user_language'] ?? null;
                // normal fallback
                if (!isset($serendipity['GET']['lang_selected']) && !isset($_REQUEST['user_language'])) {
                    if (!empty($_SESSION['serendipityLanguage'])) {
                        $this->showlang = $_SESSION['serendipityLanguage'];
                    }
                }
            } elseif (!isset($_COOKIE['serendipityLanguage'])) $resetlang = true; // force == false and we only want the translated article, nothing else being touched multilingual
        }

        if (!isset($serendipity['expose_s9y'])) {
            $serendipity['expose_s9y'] = true;
        }
        if (empty($this->showlang) && isset($serendipity['POST']['properties']['lang_selected'])) {
            $this->showlang = serendipity_db_escape_string($serendipity['POST']['properties']['lang_selected']);
            $_SESSION['last_lang'] = $this->showlang;
            if ($serendipity['expose_s9y']) serendipity_header('X-Serendipity-ML-SL-1: ' . $this->cleanheader($this->showlang));
        } elseif (empty($this->showlang) && isset($serendipity['GET']['lang_selected'])) {
            $this->showlang = serendipity_db_escape_string($serendipity['GET']['lang_selected']);
            $_SESSION['last_lang'] = $this->showlang;
            if ($serendipity['expose_s9y']) serendipity_header('X-Serendipity-ML-SL-2: ' . $this->cleanheader($this->showlang));
        } elseif (empty($this->showlang) && isset($_REQUEST['user_language'])) {
            $this->showlang = serendipity_db_escape_string($_REQUEST['user_language']);
            if ($serendipity['expose_s9y']) serendipity_header('X-Serendipity-ML-SL-3: ' . $this->cleanheader($this->showlang));
        } elseif (empty($this->showlang) && isset($_REQUEST['serendipity']['serendipityLanguage'])) {
            $this->showlang = serendipity_db_escape_string($_REQUEST['serendipity']['serendipityLanguage']);
            if ($serendipity['expose_s9y']) serendipity_header('X-Serendipity-ML-SL-4: ' . $this->cleanheader($this->showlang));
        } elseif (empty($this->showlang) && isset($serendipity['lang']) && !isset($_SESSION['last_lang'])) {
            $this->showlang = $serendipity['lang'];
            if ($serendipity['expose_s9y']) serendipity_header('X-Serendipity-ML-SL-5: ' . $this->cleanheader($this->showlang));
        }

        // frontend only
        if (!defined('IN_serendipity_admin')) {
            // case reset TRUE without POST cookies
            if ($resetlang && !isset($_COOKIE['serendipityLanguage'])) {
                $serendipity['lang'] = $this->showlang = $_SESSION['serendipityLanguage'] = $_SESSION['last_lang'] = $serendipity['default_lang']; // reset strictly to default global language
            }
            // case "force langswitch" to default, normally without POST cookies set, since they have preference
            if ($langswitch && (!isset($_POST['user_language']) || !isset($_COOKIE['serendipityLanguage']))) {
                // a user has already set a forced language and now wants to return to the default language - doing such here after all, avoids a doubleclick need..
                if ($this->showlang == 'default' || (isset($_SESSION['last_lang']) && $_SESSION['last_lang'] == 'default')) {
                    $serendipity['lang'] = $this->showlang = $_SESSION['serendipityLanguage'] = $_REQUEST['user_language'] = $serendipity['default_lang'];
                    if ($_SESSION['last_lang'] == 'default') $_SESSION['last_lang'] = $serendipity['default_lang'];
                } // the entry is shown in default language as a fallback, when another language is chosen that has no entryproperties translation
            }
            // case repair cookie array - this runs in any case, since $_COOKIE['serendipity']['serendipityLanguage'] should be set anyway
            if (isset($_COOKIE['serendipity']['serendipityLanguage'])) {
                $_COOKIE['serendipityLanguage'] = $_COOKIE['serendipity']['serendipityLanguage'];
            }

            // case unforced language entry lang links
            if (isset($serendipity['GET']['lang_selected']) && !isset($serendipity['GET']['user_language'])) {
                $this->lang_display = $this->showlang = serendipity_db_escape_string($serendipity['GET']['lang_selected']);
            }
            if (isset($serendipity['GET']['lang_selected']) && $serendipity['GET']['lang_selected'] == 'default' && !isset($serendipity['GET']['user_language'])) {
                $this->lang_display = ''; // sets entry lang to default
            }
        }

        if (!isset($serendipity['languages'][$this->showlang])) {
            $this->showlang = '';
            if ($serendipity['expose_s9y']) serendipity_header('X-Serendipity-ML-SL-RESET: ' . $this->cleanheader(($serendipity['default_lang'] ?? '')));
        }

        if (!headers_sent()) {
            if ($serendipity['expose_s9y']) serendipity_header('X-Serendipity-ContentLang: ' . $this->cleanheader($this->showlang));
        }
    }

    function setupDB()
    {
        global $serendipity;

        $built = $this->get_config('db_built', null);

        if (empty($built)) {
            $q = "@CREATE {FULLTEXT_MYSQL} INDEX fulltext_idx on {$serendipity['dbPrefix']}entryproperties (value);";
            if (serendipity_db_schema_import($q)) {
                $this->set_config('db_built', 2);
            }
        }
        if ($built == 2) {
            $q = "SHOW INDEXES FROM {$serendipity['dbPrefix']}entryproperties";
            if (!is_array(serendipity_db_query($q))) {
                echo '<span class="msg_error"><span class="icon-attention-circled" aria-hidden="true"></span> <strong>Error:</strong> '.$r.'. Does it exist? Please check your privileges to this table; triggered in serendipity_event_multilingual, setupDB() method.</span>';
            } else {
                $this->set_config('db_built', 3);
            }
        }
        if ($built == 3 || $built == 4) {
            // Presumably by calling this method via this introspect() method, a config set [serendipity_event_multilingual/db_built] entry was build without any instance ID and with an empty value. This forced the plugin API to act wild!
            serendipity_db_query("DELETE FROM {$serendipity['dbPrefix']}config WHERE name LIKE '%serendipity_event_multilingual/db_built%'");
            $this->set_config('db_built', 5);
        }
    }

    function cleanheader($string)
    {
        if (is_null($string)) $string = '';
        $string = preg_replace('@[^0-9a-z_-]@imsU', '', $string);
    }

    function introspect_config_item($name, &$propbag)
    {
        switch($name) {
            case 'tagged_title':
                $propbag->add('type',        'boolean');
                $propbag->add('name',        PLUGIN_EVENT_MULTILINGUAL_TAGTITLE);
                $propbag->add('description', PLUGIN_EVENT_MULTILINGUAL_TAGTITLE_DESC);
                $propbag->add('default',     'true');
                break;

            case 'tagged_entries':
                $propbag->add('type',        'boolean');
                $propbag->add('name',        PLUGIN_EVENT_MULTILINGUAL_TAGENTRIES);
                $propbag->add('description', PLUGIN_EVENT_MULTILINGUAL_TAGENTRIES_DESC);
                $propbag->add('default',     'false');
                break;

            case 'langswitch':
                $propbag->add('type',        'boolean');
                $propbag->add('name',        PLUGIN_EVENT_MULTILINGUAL_LANGSWITCH);
                $propbag->add('description', PLUGIN_EVENT_MULTILINGUAL_LANGSWITCH_DESC);
                $propbag->add('default',     'true');
                break;

            case 'tagged_sidebar':
                $propbag->add('type',        'boolean');
                $propbag->add('name',        PLUGIN_EVENT_MULTILINGUAL_TAGSIDEBAR);
                $propbag->add('description', PLUGIN_EVENT_MULTILINGUAL_TAGSIDEBAR_DESC);
                $propbag->add('default',     'true');
                break;

            case 'placement':
                $propbag->add('type',        'radio');
                $propbag->add('name',        PLUGIN_EVENT_MULTILINGUAL_PLACE);
                $propbag->add('description', '');
                $propbag->add('radio',        array(
                    'value' => array('add_footer', 'multilingual_footer'),
                    'desc'  => array(PLUGIN_EVENT_MULTILINGUAL_PLACE_ADDFOOTER, PLUGIN_EVENT_MULTILINGUAL_PLACE_ADDSPECIAL)
                ));
                $propbag->add('radio_per_row', '1');
                $propbag->add('default',     'add_footer');
                break;

            case 'langified':
                $propbag->add('type',        'boolean');
                $propbag->add('name',        PLUGIN_EVENT_MULTILINGUAL_LANGIFIED);
                $propbag->add('description', PLUGIN_EVENT_MULTILINGUAL_LANGIFIED_DESC);
                $propbag->add('default',     'false');
                break;

            case 'copytext':
                $propbag->add('type',        'boolean');
                $propbag->add('name',        PLUGIN_EVENT_MULTILINGUAL_COPY);
                $propbag->add('description', PLUGIN_EVENT_MULTILINGUAL_COPYDESC);
                $propbag->add('default',     'true');
                break;

            default:
                return false;
        }
        return true;
    }

    function example()
    {
        return '<span class="msg_notice"><span class="icon-info-circled"></span> ' . PLUGIN_EVENT_MULTILINGUAL_EXAMPLE_READMEHINT . "</span>\n";
    }

    function generate_content(&$title)
    {
        $title = $this->title;
    }

    function urlparam($key)
    {
        static $langswitch = null;

        if ($langswitch === null) {
            $langswitch = serendipity_db_bool($this->get_config('langswitch', 'true'));
        }

        if ($langswitch) {
        // user_language
            return 'serendipity[lang_selected]=' . $key . '&amp;serendipity[user_language]=' . $key;
        } else {
            return 'serendipity[lang_selected]=' . $key;
        }
    }

    function &getLang($id, &$properties)
    {
        global $serendipity;
        static $default_lang = null;

        $langs = array();
        // list/each can use references
        if (!is_array($properties)) {
            return false;
        }

        $probelang = dirname(__FILE__) . '/' . $serendipity['charset'] . 'lang_names.inc.php';
        if (file_exists($probelang)) {
            include $probelang;
        }

        $languages = serendipity_db_bool($this->get_config('langified', 'false')) ? $mlp['lang'] : $serendipity['languages'];

        foreach($properties AS $key => $lang) {
            preg_match('@^multilingual_body_(.+)$@', $key, $match);
            if (isset($match[1])) {
                $langs[$match[1]] = '<a class="multilingual_' . $match[1] . '" href="' . $serendipity['serendipityHTTPPath'] . $serendipity['indexFile'] . '?' . serendipity_archiveURL($id, $serendipity['languages'][$match[1]], 'serendipityHTTPPath', false, array('timestamp' => time())) . '&amp;' . $this->urlparam($match[1]) . '">' . $languages[$match[1]] . '</a>';
            }
        }

        if (count($langs) < 1) {
            return false;
        }

        // retrieve the default language of the blog...
        if ($default_lang === null) {
            if (isset($serendipity['default_lang'])) {
                $default_lang = $serendipity['languages'][$serendipity['default_lang']];
                $lang_title = $languages[$serendipity['default_lang']];
            } else {
                $default_lang_sql = serendipity_db_query("SELECT value FROM {$serendipity['dbPrefix']}config WHERE name = 'lang'", true, 'assoc');
                if (is_array($default_lang_sql)) {
                    $default_lang = $serendipity['languages'][$default_lang_sql['value']];
                    $lang_title = $languages[$default_lang_sql['value']];
                } else {
                    $default_lang = $lang_title = USE_DEFAULT;
                }
            }
        }

        if (!isset($langs[$default_lang])) {
            $langs[$default_lang] = '<a class="multilingual_default multilingual_' . $default_lang . '" href="' . $serendipity['serendipityHTTPPath'] . $serendipity['indexFile'] . '?' . serendipity_archiveURL($id, 'Default', 'serendipityHTTPPath', false, array('timestamp' => time())) . '&amp;' . $this->urlparam('default') . '">' . ($lang_title ?? '') . '</a>';
        }
        $lang = implode(', ', $langs);

        return $lang;
    }

    static function strip_langs($msg)
    {
        global $serendipity;

        if (!preg_match('@{{@', $msg)) return $msg;

        $language = (isset($serendipity['GET']['lang_selected']) && $serendipity['GET']['lang_selected'] != 'default') ? $serendipity['GET']['lang_selected'] : $serendipity['lang'];

        /* Handle escaping of {} chars. If someone is up for it,
           they're welcome to try and find a better way. As it is,
           this appears to work. */
        $msg = str_replace('\{', chr(1), $msg);
        $msg = str_replace('\}', chr(2), $msg);

        // The explode actually makes sure that each latter array part will end on either the full string end or {{--}}.
        // {{--}} will also never be contained inside the string, so we don't need to rule it out any longer.
        $parts = explode('{{--}}', $msg);
        $out   = '';
        $tr9   = false;
        // Iterate each sub-block and inspect if its language matches.
        foreach($parts AS $idx => $match) {
            if (empty($match)) continue; // Last block part, skip it.
            if (stristr($match, '{{!' . $language . '}}')) {
                // Current language found. Keep the string, minus the {{!xx}} part.
                $out .= preg_replace('@\{\{!' . $language . '\}\}@', '', $match);
                $tr9 = true;
            } else {
                // Current language not found. Remove everything after {{!xx}}.
                $out .= preg_replace('@\{\{![^\}]+\}\}.+$@s', '', $match);
            }
        }

        if (!$tr9) {
            // iterate again since we do not want any empty theme banner or navigation tab titles, which ie. is the case when title language does not match a chosen sidebar selector language
            foreach($parts AS $idx => $match) {
                $out = preg_replace('@\{\{!([a-z]){2}+\}\}@s', '', $match); // take the first matching language as fallback
                break;
            }
        }

        $msg = $out;

        /* Put back escaped {} chars */
        $msg = str_replace(chr(1), '{', $msg);
        $msg = str_replace(chr(2), '}', $msg);

        return $msg;
    }

    function tag_title($forced = null, $fallback = null)
    {
        global $serendipity;
        static $runit = null;
/*
// Trying to sort this out: We are talking about a single entry view only!
// serendipity_getSessionLanguage() and/or cookie stored lang is the current used backend language which is set in Configuration - General Settings
// serendipity['lang'] as well as sidebar selected lang is the PersonalPreferences lang and (probably) is the current set language of authorid 0, which is used for non-logged in matters in the frontend as a fallback
//  Case 1: A multilingual entry is chosen in the frontend without any preferences - it uses serendipity['lang']
//  Case 2: the entries multilingual language target links are used appending ['GET']['lang_selected'] - getSessionLanguage changes
//  Case 3: The multilingual sidebar language selection is used - getSessionLanguage AND serendipity['lang'] change and you have to deal with a possible lang Cookie.
// So generally it can get quite complicated to deal with all possible nested lang descriptions (also see this introspect language deals):
// Best use is to set Configuration lang the same as the Preferences language and better NOT use the multilingual sidebar language selection at all!
*/
        // do not run twice or more
        if (isset($serendipity['smarty']) && $runit === null) {
            if (isset($serendipity['view']) && $serendipity['view'] == 'entry' && !empty($forced)) {
                //Debug// echo ' forced='.$forced." fallback=".$fallback . " ".$serendipity['smarty']->getTemplateVars('head_title');
                if ($forced === $fallback) {
                    // getTemplateVars('head_title') is the entries title in the default language - now grab the correct banner title
                    $lang = $forced;
                    $r = serendipity_db_query("SELECT value AS title FROM {$serendipity['dbPrefix']}entryproperties WHERE entryid = '".(int)$serendipity['GET']['id']."' AND property = 'multilingual_title_$lang'");
                    $serendipity['blogTitle'] = $blogTitle = isset($r[0]['title']) ? $r[0]['title'] : $serendipity['smarty']->getTemplateVars('head_title'); // fallback if not available
                } else {
                    $serendipity['blogTitle'] = $blogTitle = $serendipity['smarty']->getTemplateVars('head_title');
                }
                if (isset($serendipity['GET']['lang_selected'])) {
                    $serendipity['head_title'] = null; // since the index.tpl template does {$head_title|default:$blogTitle|truncate....
                    // and we need the entries title as blogTitle to be displayed in case the selected language has either a match or falls back
                }
                $runit = 1;
            }
            $serendipity['smarty']->assign('blogTitle', $serendipity['blogTitle']); // strip_lang already done in genpage
            $serendipity['smarty']->assign('blogDescription', $serendipity['blogDescription']); // dito

            $head_title = isset($blogTitle) ? $blogTitle : $serendipity['smarty']->getTemplateVars('head_title');
            $head_subtitle = $serendipity['smarty']->getTemplateVars('head_subtitle');

            if (!empty($head_title)) {
                $serendipity['smarty']->assign('head_title', $this->strip_langs($head_title));
            }
            if (!empty($head_subtitle)) {
                $serendipity['smarty']->assign('head_subtitle', $this->strip_langs($head_subtitle));
            }
        }
        $runit = 2;
    }

    function event_hook($event, &$bag, &$eventData, $addData = null)
    {
        global $serendipity;

        $hooks = &$bag->get('event_hooks');
        if (isset($hooks[$event])) {
            switch($event) {

                case 'backend_configure':
                    if (!is_array($eventData)) {
                        return false;
                    }
                    if (!isset($serendipity['smarty']) || !is_object($serendipity['smarty'])) {
                        serendipity_smarty_init();
                    }
                    $serendipity['smarty']->assign('blogTitle', $this->strip_langs($eventData['blogTitle']));
                    $serendipity['smarty']->assign('blogDescription', $this->strip_langs($serendipity['blogDescription']));
                    break;

                case 'backend_entry_updertEntry':
                    if (isset($serendipity['POST']['no_save'])) {
                        $eventData['error'] = true;
                    }
                    break;

                case 'backend_entry_presave':
                    if (!isset($serendipity['POST']['properties']) || !is_array($serendipity['POST']['properties']) || !isset($eventData['id']) || empty($serendipity['POST']['properties']['lang_selected'])) {
                        return true;
                    }

                    // Restore native language version, ONLY if a different language is being submitted.
                    $restore = serendipity_db_query("SELECT title, body, extended FROM {$serendipity['dbPrefix']}entries WHERE id = " . (int)$eventData['id']);
                    if (is_array($restore)) {
                        foreach($restore AS $row) {
                            foreach($this->switch_keys AS $restorekey) {
                                $eventData[$restorekey] = $row[$restorekey];
                            }
                        }
                    }
                    break;

                case 'backend_publish':
                case 'backend_save':
                    if (!isset($serendipity['POST']['properties']) || !is_array($serendipity['POST']['properties']) || !isset($eventData['id']) || empty($serendipity['POST']['properties']['lang_selected'])) {
                        return true;
                    }

                    $ls = &$serendipity['POST']['properties']['lang_selected'];

                    $this->supported_properties[] = 'multilingual_title_' . $ls;
                    $serendipity['POST']['properties']['multilingual_title_' . $ls]    = $serendipity['POST']['title'];

                    $this->supported_properties[] = 'multilingual_body_' . $ls;
                    $serendipity['POST']['properties']['multilingual_body_' . $ls]     = $serendipity['POST']['body'];

                    $this->supported_properties[] = 'multilingual_extended_' . $ls;
                    $serendipity['POST']['properties']['multilingual_extended_' . $ls] = $serendipity['POST']['extended'];

                    // Get existing data
                    $property = serendipity_fetchEntryProperties($eventData['id']);

                    foreach($this->supported_properties AS $prop_key) {
                        $prop_val = (isset($serendipity['POST']['properties'][$prop_key]) ? $serendipity['POST']['properties'][$prop_key] : null);
                        if (!isset($property[$prop_key]) && !empty($prop_val)) {
                            $q = "INSERT INTO {$serendipity['dbPrefix']}entryproperties (entryid, property, value) VALUES (" . (int)$eventData['id'] . ", '" . serendipity_db_escape_string($prop_key) . "', '" . serendipity_db_escape_string($prop_val) . "')";
                        } elseif ($property[$propkey] != $prop_val && !empty($prop_val)) {
                            $q = "UPDATE {$serendipity['dbPrefix']}entryproperties SET value = '" . serendipity_db_escape_string($prop_val) . "' WHERE entryid = " . (int)$eventData['id'] . " AND property = '" . serendipity_db_escape_string($prop_key) . "'";
                        } else {
                            $q = "DELETE FROM {$serendipity['dbPrefix']}entryproperties WHERE entryid = " . (int)$eventData['id'] . " AND property = '" . serendipity_db_escape_string($prop_key) . "'";
                        }

                        serendipity_db_query($q);
                    }
                    break;

                case 'genpage':
                    if (!isset($serendipity['smarty']) || !is_object($serendipity['smarty'])) {
                        // never init in genpage without adding previously set $vars, which is $view etc!
                        serendipity_smarty_init($serendipity['plugindata']['smartyvars']);
                    }
                    $this->setupDB();

                    //Debug// echo "getSessionLang=".serendipity_getSessionLanguage() . ' S9L='.$serendipity['lang']. ' showPreferedLang='.$this->showlang.' ';
                    if (serendipity_db_bool($this->get_config('tagged_title', 'true'))) {
                        // set lang strip change more global, since we need this in the email subject too for example
                        $serendipity['blogTitle'] = $this->strip_langs($serendipity['blogTitle']);
                        $serendipity['blogDescription'] = $this->strip_langs($serendipity['blogDescription']);
                        if (empty(trim($serendipity['blogTitle']))) $serendipity['blogTitle'] = 'Unknown translation title';

                        if (isset($eventData['properties']['multilingual_title_'.$this->showlang])
                        || !empty($serendipity['GET']['searchTerm'])
                        || !empty($serendipity['GET']['lang_selected'])
                        || in_array($serendipity['view'], ['archive', 'entry', 'plugin'])) {
                            if (empty($this->lang_display) && empty($this->showlang)) {
                                $this->showlang = $serendipity['lang'];
                            }
                            if (empty($this->lang_display)) $this->lang_display = '';
                            //Debug// echo 'FoLa='.$this->lang_display . ' LaPf='.$this->showlang.' ';
                            $this->tag_title($this->lang_display, $this->showlang);
                        }
                    }

                    if (!isset($serendipity['smarty']->registered_plugins['modifier']['multilingual_lang'])) {
                        $serendipity['smarty']->registerPlugin('modifier', 'multilingual_lang', array($this, 'strip_langs'));
                    }
                    break;

                case 'backend_entryform':
                    // existing entries only
                    if (!empty($eventData['id'])) {
                        if (!empty($this->showlang)) {
                            // language is given (user wants a translation)
                            $props = serendipity_fetchEntryProperties($eventData['id']);
                            // this is a language change, not a save -- we want the DB values
                            // unless the user chooses to retain previous language content
                            if (isset($serendipity['POST']['no_save'])) {
                                foreach($this->switch_keys AS $key) {
                                    if (!serendipity_db_bool($this->get_config('copytext', 'true')) || !empty($props['multilingual_' . $key . '_' . $this->showlang])) {
                                        $eventData[$key] = $props['multilingual_' . $key . '_' . $this->showlang];
                                    }
                                }
                            }
                        } else {
                            // language is NOT given (user wants the default language)
                            $props = serendipity_fetchEntry('id', $eventData['id']);
                            if (!is_array($props)) {
                                return true;
                            }
                            // this is a language change, not a save -- we want the DB values
                            if (isset($serendipity['POST']['no_save'])) {
                                foreach($this->switch_keys AS $key) {
                                    $eventData[$key] = $props[$key];
                                }
                            }
                        }
                    }
                    break;

                case 'css':
                    // CSS class does NOT exist by user customized template styles, include default
                    if (strpos($eventData, '.serendipity_multilingualInfo') === false) {
                        $eventData .= '

/* serendipity_event_multilingual start */

.serendipity_multilingualInfo {
    margin-left: auto;
    margin-right: 0px;
    text-align: right;
    font-size: 7pt;
    display: block;
    margin-top: 5px;
    margin-bottom: 0px;
}

.serendipity_multilingualInfo a {
    font-size: 7pt;
    text-decoration: none;
}

.serendipity_multilingualInfo a:hover {
    color: green;
}

/* serendipity_event_multilingual end */

';
                    }
                    break;

                case 'entry_display':
                    if (!is_array($eventData)) {
                        return false;
                    }
                    $place = $this->get_config('placement', 'add_footer');
                    $msg = '<div class="serendipity_multilingualInfo">' . PLUGIN_EVENT_MULTILINGUAL_SWITCH . ': %s</div>';
                    if ($addData['extended'] || $addData['preview']) {
                        if (isset($eventData[0]['id']) && $langs = $this->getLang($eventData[0]['id'], $eventData[0]['properties'])) {
                            if (!empty($this->showlang)) {
                                $props = &$eventData[0]['properties'];
                                foreach($this->switch_keys AS $key) {
                                    if (!empty($props['multilingual_' . $key . '_' . $this->showlang])) {
                                        $eventData[0][$key] = $props['multilingual_' . $key . '_' . $this->showlang];
                                    }
                                }
                                unset($eventData[0]['properties']['ep_cache_body']);
                                unset($eventData[0]['properties']['ep_cache_extended']);
                            }
                            if (!isset($eventData[0][$place])) $eventData[0][$place] = '';
                            $eventData[0][$place] .= sprintf($msg, $langs);
                        }
                    } else {
                        $elements = is_array($eventData) ? count($eventData) : 0;

                        // Walk entry array and insert karma voting line.
                        for ($i = 0; $i < $elements; $i++) {
                            if (!isset($eventData[$i][$place])) {
                                $eventData[$i][$place] = '';
                            }

                            if (!empty($this->lang_display)) {
                                $this->showlang = $this->lang_display;
                            }

                            if (!empty($this->showlang)) {
                                // Not sure if it's the best way to get translations shown instead of the
                                // original entries

                                $props = &$eventData[$i]['properties'];
                                foreach($this->switch_keys AS $key) {
                                    if (!empty($props['multilingual_' . $key . '_' . $this->showlang])) {
                                        $eventData[$i][$key] = $props['multilingual_' . $key . '_' . $this->showlang];
                                    }
                                }
                                unset($eventData[$i]['properties']['ep_cache_body']);
                                unset($eventData[$i]['properties']['ep_cache_extended']);
                            }

                            if (isset($eventData[$i]['id']) && $langs = $this->getLang($eventData[$i]['id'], $eventData[$i]['properties'])) {
                                $eventData[$i][$place] .= sprintf($msg, $langs);
                                // this may throw two for the same, eg. when already linked as <en>, them set to POST cookie <en> too in the sidebar selection.
                                // In this case the lang link and the default lang link are both named 'english'
                            }
                        }
                    }
                    // Tagged translation of Blog title and description
                    $this->tag_title();

                    if (serendipity_db_bool($this->get_config('tagged_entries', 'true'))) {
                        foreach ($eventData AS $key => $entry) {
                            if (isset($eventData[$key]['title'])) {
                                $eventData[$key]['title'] = $this->strip_langs($eventData[$key]['title']);
                                $eventData[$key]['body'] = $this->strip_langs($eventData[$key]['body']);
                                if (isset($eventData[$key]['categories']) && is_array($eventData[$key]['categories'])) {
                                    foreach($eventData[$key]['categories'] AS $ec_key => $ec_val) {
                                        if (isset($ec_val['category_name'])) {
                                            $eventData[$key]['categories'][$ec_key]['category_name'] = $this->strip_langs($ec_val['category_name']);
                                        }
                                    }
                                }
                            }
                        }
                    }
                    break;

                case 'backend_display':
                    if (isset($serendipity['POST']['properties']['lang_selected'])) {
                        $lang_selected = $serendipity['POST']['properties']['lang_selected'];
                    } else {
                        $lang_selected = '';
                    }

                    $use_lang = $serendipity['languages'];
                    unset($use_lang[$serendipity['lang']]); // Unset 'default' language. Easier handling.

                    $langs = '';
                    //asort($use_lang); //sorts by value ASC, but if so we should do it everywhere though
                    foreach($use_lang AS $code => $desc) {
                        $langs .= '                        <option value="' . $code . '"' . ($lang_selected == $code ? ' selected="selected"' : '') . '>' . serendipity_specialchars($desc) . "</option>\n";
                    }
?>
            <fieldset id="edit_entry_multilingual" class="entryproperties_multilingual">
                <span class="wrap_legend"><legend><?php echo PLUGIN_EVENT_MULTILINGUAL_TITLE; ?></legend></span>
                <div class="form_field">
<?php
                    if (isset($eventData['id'])) { ?>
                    <label for="serendipity[properties][lang_selected]"><?php echo PLUGIN_EVENT_MULTILINGUAL_CURRENT; ?></label><br>
                    <select id="properties_lang_selected" name="serendipity[properties][lang_selected]">
                        <option value=""><?php echo USE_DEFAULT; ?></option>
<?php echo $langs; ?>
                    </select>
                    <input class="serendipityPrettyButton input_button" type="submit" name="serendipity[no_save]" value="<?php echo PLUGIN_EVENT_MULTILINGUAL_SWITCH; ?>">
<?php
                    } else {
                        echo '                        <span class="msg_notice"><span class="icon-info-circled" aria-hidden="true"></span> ' . PLUGIN_EVENT_MULTILINGUAL_NEEDTOSAVE . "</span>\n";
                    }
?>
                </div>
            </fieldset>

<?php
                    break;

                case 'frontend_entryproperties':
                    if (class_exists('serendipity_event_entryproperties')) {
                        // Fetching of properties is already done there, so this is just for poor users who don't have the entryproperties plugin enabled
                        return true;
                    }
                    $q = "SELECT entryid, property, value FROM {$serendipity['dbPrefix']}entryproperties WHERE entryid IN (" . implode(', ', array_keys($addData)) . ") AND property LIKE '%multilingual_%'";
                    $properties = serendipity_db_query($q);
                    if (!is_array($properties)) {
                        return true;
                    }
                    foreach($properties AS $idx => $row) {
                        $eventData[$addData[$row['entryid']]]['properties'][$row['property']] = $row['value'];
                    }
                    break;

                case 'frontend_media_showitem':
                    // Take care of translatable modules in blogTitle and head_subtitle, split by {{--}} if using the multilingual event plugin.
                    $parts = explode('{{--}}', $serendipity['smarty']->getTemplateVars('blogTitle'));
                    foreach($parts AS $idx => $match) {
                        $serendipity['smarty']->assign('blogTitle', preg_replace('@\{\{!([a-z]){2}+\}\}@s', '', $match)); // take the first matching language to be displayed
                        break;
                    }
                    $parts = explode('{{--}}', $serendipity['smarty']->getTemplateVars('head_subtitle'));
                    foreach($parts AS $idx => $match) {
                        $serendipity['smarty']->assign('head_subtitle', preg_replace('@\{\{!([a-z]){2}+\}\}@s', '', $match)); // take the first matching language to be displayed
                        break;
                    }
                    break;

                case 'frontend_entries_rss':
                    if (is_array($eventData)) {
                        foreach($eventData AS $i => $entry) {
                            if (!empty($this->lang_display)) {
                                $this->showlang = $this->lang_display;
                            }

                            if (!empty($this->showlang)) {
                                // Not sure if it's the best way to get translations shown instead of the
                                // original entries

                                $props = &$eventData[$i]['properties'];
                                foreach($this->switch_keys AS $key) {
                                    if (!empty($props['multilingual_' . $key . '_' . $this->showlang])) {
                                        $eventData[$i][$key] = $props['multilingual_' . $key . '_' . $this->showlang];
                                    }
                                }
                                unset($eventData[$i]['properties']['ep_cache_body']);
                                unset($eventData[$i]['properties']['ep_cache_extended']);
                            }
                        }
                    }
                    if (serendipity_db_bool($this->get_config('tagged_entries', 'true'))) {
                        foreach ($eventData AS $key => $entry) {
                            $eventData[$key]['title'] = $this->strip_langs($eventData[$key]['title']);
                            $eventData[$key]['body'] = $this->strip_langs($eventData[$key]['body']);
                        }
                    }
                    break;

                case 'frontend_fetchentries':
                case 'frontend_fetchentry':
                    $entrieslist = false;
                    if (!empty($this->lang_display)) {
                        $this->showlang = $this->lang_display;
                    }

                    if (defined('IN_serendipity_admin') && serendipity_checkPermission('adminEntries') && $serendipity['GET']['adminAction'] == 'editSelect') {
                        $entrieslist = true;
                    }

                    if (isset($addData['source']) && $addData['source'] == 'search' && empty($this->showlang) && !empty($_SESSION['last_lang'])) {
                        header('X-SearchLangOverride: ' . $_SESSION['last_lang']);
                        $this->showlang = $_SESSION['last_lang'];
                    }

                    if (empty($this->showlang) && !$entrieslist) {
                        return;
                    }

                    if (!$entrieslist) {
                        $cond  = "                    multilingual_body.value AS multilingual_body,\n";
                        $cond .= "                    multilingual_extended.value AS multilingual_extended,\n";
                        $cond .= "                    multilingual_title.value AS multilingual_title,\n";
                    } else {
                        $cond = "ep_lang.value AS multilingual_lang,\n";
                    }

                    if (empty($eventData['addkey'])) {
                        $eventData['addkey'] = $cond;
                    } else {
                        $eventData['addkey'] .= $cond;
                    }
                    // new $cond

                    if (!$entrieslist) {
                        $cond  = "\n                    LEFT OUTER JOIN {$serendipity['dbPrefix']}entryproperties multilingual_body
                           ON (e.id = multilingual_body.entryid AND multilingual_body.property = 'multilingual_body_" . $this->showlang . "')";
                        $cond .= "\n                    LEFT OUTER JOIN {$serendipity['dbPrefix']}entryproperties multilingual_extended
                           ON (e.id = multilingual_extended.entryid AND multilingual_extended.property = 'multilingual_extended_" . $this->showlang . "')";
                        $cond .= "\n                    LEFT OUTER JOIN {$serendipity['dbPrefix']}entryproperties multilingual_title
                           ON (e.id = multilingual_title.entryid AND multilingual_title.property = 'multilingual_title_" . $this->showlang . "')";
                    } else {
                        $cond = "\n                    LEFT JOIN {$serendipity['dbPrefix']}entryproperties AS ep_lang
                           ON (e.id = ep_lang.entryid AND ep_lang.property = 'lang_selected')\n                   ";
                    }

                    if (!empty($this->lang_display)) {
                        // If lang_display is set - we want ONLY the entries which have translation
                        $eventData['and'] .= " AND multilingual_body.value IS NOT NULL";
                    }

                    if (empty($eventData['joins'])) {
                        $eventData['joins'] = $cond;
                    } else {
                        $eventData['joins'] .= $cond;
                    }

                    if (isset($addData['source']) && $addData['source'] == 'search' && isset($eventData['find_part'])) {
                        $term =& $addData['term'];
                        $cond =& $eventData;
                        if (stristr($serendipity['dbType'], 'postgres')) {
                            $cond['find_part'] .= " OR (multilingual_body.value ILIKE '%$term%' OR multilingual_extended.value ILIKE '%$term%' OR multilingual_title.value ILIKE '%$term%')";
                        } elseif (stristr($serendipity['dbType'], 'sqlite')) {
                            $term = serendipity_mb('strtolower', $term);
                            $cond['find_part'] .= " OR (lower(multilingual_body.value) LIKE '%$term%' OR lower(multilingual_extended.value) LIKE '%$term%' OR lower(multilingual_title.value) LIKE '%$term%')";
                        } else {
                            // See notes on limitations with Chinese, Japanese, and Korean languages in function_entries.inc
                            if (preg_match('@["\+\-\*~<>\(\)]+@', $term)) {
                                #$term = str_replace(' + ', ' +', $term); // be strict for boolean mode
                                $bool = ' IN BOOLEAN MODE';
                            } else {
                                $bool = '';
                            }
                            $cond['find_part'] .= " OR (
                                                         MATCH(multilingual_body.value)        AGAINST('$term' $bool)
                                                         OR MATCH(multilingual_extended.value) AGAINST('$term' $bool)
                                                         OR MATCH(multilingual_title.value)    AGAINST('$term' $bool)
                                                       )";
                        }
                    }
                    break;

                case 'frontend_comment':
                    if (serendipity_db_bool($this->get_config('tagged_entries', 'true'))) {
                        $serendipity['smarty']->assign('head_title', $this->strip_langs($serendipity['head_title']));
                    }
                    if (serendipity_db_bool($this->get_config('tagged_title', 'true'))) {
                        $serendipity['smarty']->assign('head_subtitle', $this->strip_langs($serendipity['head_subtitle']));
                    }
                    break;

                case 'frontend_sidebar_plugins':
                    if (serendipity_db_bool($this->get_config('tagged_sidebar', 'true'))) {
                        foreach ($eventData AS $key => $entry) {
                            $eventData[$key]['title'] = $this->strip_langs($eventData[$key]['title']);
                            $eventData[$key]['content'] = $this->strip_langs($eventData[$key]['content']);
                        }
                    }
                    break;

                case 'frontend_rss':
                    if (is_array($eventData)) {
                        $eventData['title'] = $this->strip_langs($eventData['title']);
                        $eventData['description'] = $this->strip_langs($eventData['description']);
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

}

/* vim: set sts=4 ts=4 expandtab : */
?>