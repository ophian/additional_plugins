<?php

declare(strict_types=1);

if (IN_serendipity !== true) {
    die ("Don't hack!");
}

@serendipity_plugin_api::load_language(dirname(__FILE__));

class serendipity_event_google_analytics extends serendipity_event
 {
    public $title = PLUGIN_EVENT_GOOGLE_ANALYTICS_NAME;

    // Docs:
    // - Install Google Tag Manager for web pages: https://developers.google.com/tag-platform/tag-manager/web
    // - [GA4] Enhanced measurement events: https://support.google.com/analytics/answer/9216061
    // - The data layer: https://developers.google.com/tag-platform/tag-manager/web/datalayer
    // - IP masking obsolete: https://support.google.com/analytics/answer/9019185#IP
    // It says:
    // Google Analytics 4-Properties
    // In Google Analytics 4 ist keine Maskierung von IP-Adressen erforderlich, da IP-Adressen weder protokolliert noch gespeichert werden.
    // No masking of IP addresses is required in Google Analytics 4, as IP addresses are neither logged nor stored. (translated)

    function introspect(&$propbag)
    {
        $propbag->add('name', PLUGIN_EVENT_GOOGLE_ANALYTICS_NAME);
        $propbag->add('description', PLUGIN_EVENT_GOOGLE_ANALYTICS_DESC);
        $propbag->add('stackable', false);
        $propbag->add('author', 'Jari Turkia, kleinerChemiker, Ian Styx');
        $propbag->add('version', '3.0.1');
        $propbag->add('requirements',  array(
            'serendipity' => '5.0',
            'smarty'      => '4.1',
            'php'         => '8.2')
        );
        $propbag->add('groups', array('STATISTICS' ));
        $propbag->add('cachable_events', array('frontend_display' => true ));
        $propbag->add('event_hooks', array('frontend_header' => true, 'frontend_display' => true ));

        $this->markup_elements = array (
            array (
                'name' => 'ENTRY_BODY',
                'element' => 'body'
                ),
            array (
                'name' => 'EXTENDED_BODY',
                'element' => 'extended'
                ),
            array (
                'name' => 'COMMENT',
                'element' => 'comment'
                ),
            array (
                'name' => 'HTML_NUGGET',
                'element' => 'html_nugget'
                )
        );

        # Base values
        $conf_array = array ();
        $conf_array[] = 'analytics_measurement_id';
        #$conf_array[] = 'analytics_anonymizeIp';
        $conf_array[] = 'analytics_track_external';

        $conf_array[] = 'analytics_track_downloads';
        $conf_array[] = 'analytics_download_extensions';
        $conf_array[] = 'analytics_internal_hosts';
        $conf_array[] = 'analytics_exclude_groups';

        foreach ($this->markup_elements AS $element ) {
            $conf_array[] = $element['name'];
        }
        $propbag->add('configuration', $conf_array);

        $propbag->add('legal',    array(
            'services' => array(
                'oEmbed' => array(
                    'url' => 'https://www.googletagmanager.com/',
                    'desc' => 'The place where the analytics script is fetched and all further push metadata is sent to'
                ),
            ),
            'frontend' => array(
                'The Google analytics services will receive the URLs and the metadata of the visitors (IP, User Agent, Referrer, etc.).
                For the EU, in special DE, please https://datenschutz-generator.de/google-analytics/ to extend and outline your DSGVO privacy settings.',
            ),
            'backend' => array(
            ),
            'cookies' => array(
                'Google Analytics 4 uses a cookie-less tracking. Users are not recognized on the basis of cookies, but on the basis of so-called "browser fingerprints" or "digital fingerprints". This refers to an individual compilation of information that their browsers send to their providers servers when they access websites. This includes, for example, the IP address, even if masked in the EU, system and browser information, etc.'
            ),
            'stores_user_input'     => false,
            'stores_ip'             => false,
            'uses_ip'               => true,
            'transmits_user_input'  => true
        ));
    }

    function introspect_config_item($name, &$propbag)
    {
        switch ($name) {
            case 'analytics_measurement_id' :
                $propbag->add('type', 'string');
                $propbag->add('name', PLUGIN_EVENT_GOOGLE_ANALYTICS_ACCOUNT_NUMBER);
                $propbag->add('description', PLUGIN_EVENT_GOOGLE_ANALYTICS_ACCOUNT_NUMBER_DESC);
                $propbag->add('validate', '/^G-[0-9A-Z]+$/');
                $propbag->add('default', '');
                break;
/*
            case 'analytics_anonymizeIp' :
                $propbag->add('type', 'boolean');
                $propbag->add('name', PLUGIN_EVENT_GOOGLE_ANALYTICS_ANONYMIZEIP);
                $propbag->add('description', PLUGIN_EVENT_GOOGLE_ANALYTICS_ANONYMIZEIP_DESC);
                $propbag->add('default', 'false');
                break;
*/
            case 'analytics_track_external' :
                $propbag->add('type', 'boolean');
                $propbag->add('name', PLUGIN_EVENT_GOOGLE_ANALYTICS_TRACK_EXTERNAL);
                $propbag->add('description', PLUGIN_EVENT_GOOGLE_ANALYTICS_TRACK_EXTERNAL_DESC);
                $propbag->add('default', 'true');
                break;

            case 'analytics_internal_hosts' :
                $propbag->add('type', 'text');
                $propbag->add('rows', 3);
                $propbag->add('name', PLUGIN_EVENT_GOOGLE_ANALYTICS_INTERNAL_HOSTS);
                $propbag->add('description', PLUGIN_EVENT_GOOGLE_ANALYTICS_INTERNAL_HOSTS_DESC);
                $propbag->add('default', $_SERVER['HTTP_HOST']);
                break;

            case 'analytics_track_downloads' :
                $propbag->add('type', 'boolean');
                $propbag->add('name', PLUGIN_EVENT_GOOGLE_ANALYTICS_TRACK_DOWNLOADS);
                $propbag->add('description', PLUGIN_EVENT_GOOGLE_ANALYTICS_TRACK_DOWNLOADS_DESC);
                $propbag->add('default', 'true');
                break;

            case 'analytics_download_extensions' :
                $propbag->add('type', 'string');
                $propbag->add('name', PLUGIN_EVENT_GOOGLE_ANALYTICS_DOWNLOAD_EXTENSIONS);
                $propbag->add('description', PLUGIN_EVENT_GOOGLE_ANALYTICS_DOWNLOAD_EXTENSIONS_DESC);
                $propbag->add('default', '7z,aac,arc,arj,asf,asx,avi,avif,bin,csv,doc,exe,flv,gif,gz,gzip,hqx,jar,jpeg,jpg,js,mp2g,mp3g,mp4g,mp2eg,mp3eg,mp4eg,mov,movie,msi,msp,pdf,phps,png,ppt,qt,qtm,ram,rar,sea,sit,tar,tgz,torrent,txt,wav,webp,wma,wmv,wpd,xls,xml,xz,z,zip');
                break;

            case 'analytics_exclude_groups' :
                $_groups =& serendipity_getAllGroups();
                if (is_array($_groups)) {
                    foreach($_groups AS $group) {
                        $groups[$group['confkey']] = $group['confvalue'];
                    }
                    $propbag->add('type', 'multiselect');
                    $propbag->add('name', PLUGIN_EVENT_GOOGLE_ANALYTICS_EXCLUDE_GROUPS);
                    $propbag->add('description', PLUGIN_EVENT_GOOGLE_ANALYTICS_EXCLUDE_GROUPS_DESC);
                    $propbag->add('select_size', 5);
                    $propbag->add('select_values', $groups);
                }
                break;

            default :
                $propbag->add('type', 'boolean');
                $propbag->add('name', constant($name));
                $propbag->add('description', sprintf(PLUGIN_EVENT_GOOGLE_ANALYTICS_APPLY_TRACKING_TO_DESC, constant($name)));
                $propbag->add('default', 'true');
        }
        return true;
    }

    function generate_content(&$title)
    {
        $title = $this->get_config ('title');
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

    function trim_value(&$value)
    {
        $value = trim($value);
    }

    function in_array_loop($array1, $array2)
    {
        if (is_array($array1)) {
            foreach($array1 AS $array ) {
                if (in_array($array, $array2)) {
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * matches:
     * 0 = entire regexp match
     * 1 = anything between "<a" and "href"
     * 2 = scheme
     * 3 = address
     * 4 = anything after "href" and ">"
     */
    function analytics_tracker_callback($matches)
    {
        static $internal_hosts = null;
        static $download_extensions = null;
        static $analytics_track_external = null;
        static $analytics_track_downloads = null;

        if ($internal_hosts === null) {
            $internal_hosts = explode("\n", $this->get_config('analytics_internal_hosts'));
            array_walk($internal_hosts, array($this, 'trim_value'));
        }

        if ($download_extensions === null) {
            $download_extensions = explode(",", $this->get_config('analytics_download_extensions'));
            array_walk($download_extensions, array($this, 'trim_value'));
        }

        if ($analytics_track_external === null) {
            $analytics_track_external = serendipity_db_bool($this->get_config('analytics_track_external', true));
        }

        if ($analytics_track_downloads === null) {
            $analytics_track_downloads = serendipity_db_bool($this->get_config('analytics_track_downloads', true));
        }

        $parsed_url = parse_url($matches[2].$matches[3]);

        // Skip tracking for local URLs without scheme, or unknown scheme.
        if (!isset($parsed_url["scheme"]))
            return $matches[0];
        if (!in_array($parsed_url["scheme"], array("http", "https")))
            return $matches[0];

        if (str_starts_with($matches[2], 'http')) {
            $host = str_starts_with($matches[2], 'https') ? parse_url('https://' . $matches[2]) : parse_url('http://' . $matches[2]); // HTTP/S
            $host['path'] = $host['path'] ?? '';
            preg_match('/\.([a-z0-9]+)$/i', $host['path'], $extension);
            if (!in_array($host['host'], $internal_hosts) && $analytics_track_external) {
                return '<a onclick="_gaq.push([\'_trackPageview\', \'/extlink/' . htmlspecialchars($matches[3], encoding: LANG_CHARSET) . '\']);" ' . substr($matches[0], 2);
            } elseif (in_array($host['host'], $internal_hosts) && in_array($extension[1], $download_extensions) && $analytics_track_downloads) {
                return '<a onclick="_gaq.push([\'_trackPageview\', \'/download' . htmlspecialchars($host['path'], encoding: LANG_CHARSET) . '\']);" ' . substr($matches[0], 2);
            } else {
                return $matches[0];
            }
        } else {
            while(str_starts_with($matches[4], '/')) {
                $matches[4] = substr($matches[4], 1);
            }
            $host = parse_url('http://www.example.com/' . $matches[4]);
            $host['path'] = $host['path'] ?? '';
            preg_match('/\.([a-z0-9]+)$/i', $host['path'], $extension);
            if (in_array($extension[1], $download_extensions)) {
                return '<a onclick="_gaq.push([\'_trackPageview\', \'/download' . htmlspecialchars($host['path'], encoding: LANG_CHARSET) . '\']);" ' . substr($matches[0], 2);
            } else {
                return $matches[0];
            }
        }
    }

    function event_hook($event, &$bag, &$eventData, $addData = null)
    {
        global $serendipity;
        #static $analytics_anonymizeIp = null;
        static $analytics_track_external = null;
        static $analytics_track_downloads = null;
        static $analytics_exclude_groups = null;
        static $usergroup = false;

        $hooks = &$bag->get ('event_hooks');

        $analytics_accountID = $this->get_config('analytics_measurement_id');
        if (!isset($analytics_accountID) || !$analytics_accountID) {
            return false;
        }

        #if ($analytics_anonymizeIp === null) {
        #    $analytics_anonymizeIp = serendipity_db_bool($this->get_config('analytics_anonymizeIp', false));
        #}

        if ($analytics_track_downloads === null) {
            $analytics_track_downloads = serendipity_db_bool($this->get_config('analytics_track_downloads', true));
        }

        if ($analytics_track_external === null) {
            $analytics_track_external = serendipity_db_bool($this->get_config('analytics_track_external', true));
        }

        if ($analytics_exclude_groups === null) {
            $analytics_exclude_groups = explode("^", $this->get_config('analytics_exclude_groups', true));
            if (!empty ($analytics_exclude_groups)) {
                $_groups = serendipity_getGroups($serendipity['authorid']);
                if (is_array($_groups)) {
                    foreach($_groups AS $group ) {
                        $usergroup[] = $group['id'];
                    }
                } else {
                    $usergroup = false;
                }
            } else {
                $usergroup = false;
            }
        }
        if (isset ($hooks[$event])) {
            switch ($event) {
                case 'frontend_header' :
                    #$analytics_anonymizeIp_code = $analytics_anonymizeIp ? "_gaq.push(['_gat._anonymizeIp']);\r  " : '';
                    if ($serendipity['authorid'] === null || !$this->in_array_loop($usergroup, $analytics_exclude_groups)) {
                        print <<<EOT
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async="" src="https://www.googletagmanager.com/gtag/js?id={$analytics_accountID}"></script>
<script>
(([w, dataLayerName, streamId] = [window, 'dataLayer', '{$analytics_accountID}']) => {
    w[dataLayerName] = w[dataLayerName] || [];
    function gtag() {
        w[dataLayerName].push(arguments);
    }
    gtag('js', new Date());
    gtag('config', streamId);
})()
</script>
EOT;
                    }

                    return true;
                    break;

                case 'frontend_display' :
                    if ($serendipity['authorid'] && $usergroup !== false && $this->in_array_loop($usergroup, $analytics_exclude_groups)) {
                        return true;
                    }

                    foreach ($this->markup_elements AS $temp) {
                        if (serendipity_db_bool($this->get_config($temp['name'], 'true')) && !empty($eventData[$temp['element']])
                        &&  (!isset($eventData['properties']['ep_disable_markup_' . $this->instance]) || !$eventData['properties']['ep_disable_markup_' . $this->instance])
                        &&  !isset($serendipity['POST']['properties']['disable_markup_' . $this->instance])
                        && ($analytics_track_downloads || $analytics_track_external)) {
                            $element = $temp['element'];
                            $eventData[$element] = preg_replace_callback(
                                                        "#<a\\s+(.*)href\\s*=\\s*[\"|'](https?://|)([^\"']*)[\"|']([^>]*)>#isUm",
                                                        array($this, 'analytics_tracker_callback'),
                                                        $eventData[$element]);
                        }
                    }
                    return true;
                    break;

                default:
                    return false;
            }
        } else {
            return false;
        }
    }

}

?>