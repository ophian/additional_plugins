<?php

declare(strict_types=1);

if (IN_serendipity !== true) {
    die ("Don't hack!");
}

@serendipity_plugin_api::load_language(dirname(__FILE__));

class serendipity_event_social extends serendipity_event
{
    public $title = PLUGIN_EVENT_SOCIAL_NAME;

    function introspect(&$propbag)
    {
        $propbag->add('name',          PLUGIN_EVENT_SOCIAL_NAME);
        $propbag->add('description',   PLUGIN_EVENT_SOCIAL_DESC);
        $propbag->add('stackable',     false);
        $propbag->add('author',        'onli, Matthias Mees, Thomas Hochstein, Ian Styx, Mario Hommel, Thomas Hochstein');
        $propbag->add('version',       '1.0.1');
        $propbag->add('requirements',  array(
            'serendipity' => '5.0',
            'php'         => '8.2'
        ));
        $propbag->add('event_hooks',   array(
                                        'frontend_display:html:per_entry' => true,
                                        'css' => true,
                                        'frontend_footer' => true,
                                        'frontend_header' => true,
                                        'backend_display' => true,
                                        'backend_publish' => true,
                                        'backend_save' => true
                                        )
        );
        $propbag->add('groups', array('FRONTEND_EXTERNAL_SERVICES'));

        $propbag->add('configuration', array('services', 'theme', 'overview', 'twitter_via', 'social_image', 'lang', 'backend'));
        $propbag->add('legal',    array(
            'services' => array(
                'Multiple' => array(
                    'url' => 'https://github.com/heiseonline/shariff',
                    'desc' => 'All supported social platforms can receive user data and metadata (IP, cookies)'
                ),
                's9y Shariff' => array(
                    'url' => 'https://onli2.uber.space/s9y_shariff/',
                    'desc' => 'When enabled, this shariff backend will receive metadata of URL requests'
                )
            ),
            'frontend' => array(
                'When sharing functions of the plugin are used by the visitor, those selected sharing services will receive the URL and the metadata of the visitor (IP, User Agent, Referrer, etc.).',
            ),
            'backend' => array(
            ),
            'cookies' => array(
            ),
            'stores_user_input'     => false,
            'stores_ip'             => false,
            'uses_ip'               => false,
            'transmits_user_input'  => true
        ));
    }

    function generate_content(&$title)
    {
        $title = $this->title;
    }

    function introspect_config_item($name, &$propbag)
    {
        global $serendipity;

        switch($name) {
            case 'services':
                $propbag->add('type',           'multiselect');
                $propbag->add('name',           PLUGIN_EVENT_SOCIAL_SERVICES);
                $propbag->add('description',    PLUGIN_EVENT_SOCIAL_SERVICES_DESC);
                $propbag->add('default',        'twitter^facebook');
                $propbag->add('select_values',  array('twitter' => 'twitter', 'facebook' => 'facebook', 'googleplus' => 'googleplus', 'linkedin' => 'linkedin', 'pinterest' => 'pinterest', 'xing' => 'xing', 'whatsapp' => 'whatsapp', 'mail' => 'mail', 'info' => 'info', 'addthis' => 'addthis', 'tumblr' => 'tumblr', 'flattr' => 'flattr', 'diaspora' => 'diaspora', 'reddit' => 'reddit', 'stumbleupon' => 'stumbleupon', 'threema' => 'threema', 'weibo' => 'weibo', 'tencent-weibo' => 'tencent-weibo', 'qzone' => 'qzone', 'print' => 'print', 'telegram' => 'telegram', 'vk' => 'vk', 'flipboard' => 'flipboard'));
                break;

            case 'theme':
                $propbag->add('type',           'select');
                $propbag->add('name',           PLUGIN_EVENT_SOCIAL_THEME);
                $propbag->add('description',    PLUGIN_EVENT_SOCIAL_THEME_DESC);
                $propbag->add('select_values',  array('standard' => PLUGIN_EVENT_SOCIAL_THEME_STD, 'white' => PLUGIN_EVENT_SOCIAL_THEME_WHITE, 'grey' => PLUGIN_EVENT_SOCIAL_THEME_GREY));
                $propbag->add('default',        'standard');
                break;

            case 'overview':
                $propbag->add('type',           'boolean');
                $propbag->add('name',           PLUGIN_EVENT_SOCIAL_OVERVIEW);
                $propbag->add('description',    PLUGIN_EVENT_SOCIAL_OVERVIEW_DESC);
                $propbag->add('default',        true);
                break;

            case 'twitter_via':
                $propbag->add('type',           'string');
                $propbag->add('name',           PLUGIN_EVENT_SOCIAL_TWITTERVIA);
                $propbag->add('description',    PLUGIN_EVENT_SOCIAL_TWITTERVIA_DESC);
                $propbag->add('default',        'none');
                break;

            case 'lang':
                $propbag->add('type',           'select');
                $propbag->add('name',           INSTALL_LANG);
                $propbag->add('description',    PLUGIN_EVENT_SOCIAL_LANG_DESC);
                $propbag->add('default',        'en');
                $propbag->add('select_values',  array('bg' => 'bg', 'de' => 'de', 'en' => 'en', 'es' => 'es', 'fi' => 'fi', 'hr' => 'hr', 'hu' => 'hu', 'ja' => 'ja', 'ko' => 'ko', 'no' => 'no', 'pl' => 'pl', 'pt' => 'pt', 'ro' => 'ro', 'ru' => 'ru', 'sk' => 'sk', 'sl' => 'sl', 'sr' => 'sr', 'sv' => 'sv', 'tr' => 'tr', 'zh' => 'zh'));
                break;

            case 'backend':
                $propbag->add('type',           'string');
                $propbag->add('name',           PLUGIN_EVENT_SOCIAL_BACKEND);
                $propbag->add('description',    PLUGIN_EVENT_SOCIAL_BACKEND_DESC);
                $propbag->add('default',        'https://onli2.uber.space/s9y_shariff/');
                break;

            case 'social_image':
                $propbag->add('type',           'media');
                $propbag->add('name',           PLUGIN_EVENT_SOCIAL_IMAGE);
                $propbag->add('description',    PLUGIN_EVENT_SOCIAL_IMAGE_DESC);
                $propbag->add('default',        '');
                break;

        }
        return true;
    }

    function event_hook($event, &$bag, &$eventData, $addData = null)
    {
        global $serendipity;

        $hooks = &$bag->get('event_hooks');

        if (isset($hooks[$event])) {

            switch($event) {
                case 'frontend_display:html:per_entry':
                    $serendipity['view'] = $serendipity['view'] ?? null;
                    if ($serendipity['view'] != 'entry') {
                        if (! serendipity_db_bool($this->get_config('overview', 'true'))) {
                            // We are in overview mode and the user opted to not show the button
                            return;
                        }
                        // when sharing on the frontpage, at least the twitter button is using the page title instead of the entry title, so we set that manually
                        $hardcoded_title = ' data-title="' . $eventData['title'] .'"';
                    } else {
                        $hardcoded_title = '';
                    }
                    $twitter_via = $this->get_config('twitter_via', 'none');
                    if ($twitter_via != 'none') {
                        $twitter_via_tag = ' data-twitter-via="' . str_replace('@', '', $twitter_via) .'"';
                    } else {
                        $twitter_via_tag = '';
                    }
                    $backend = $this->get_config('backend', 'none');
                    if ($backend != 'none') {
                        $backend_tag = ' data-backend-url="' . $backend .'"';
                    } else {
                        $backend_tag = '';
                    }
                    $theme = $this->get_config('theme');
                    $lang = $this->get_config('lang', 'en');
                    $services = $this->get_config('services');
                    $services = '&quot;' . str_replace('^', '&quot;,&quot;', $services) . '&quot;';
                    if (strpos($services, 'info') !== false) {
                        // the info button looks strange if not at the end, hardcode that position
                        $services = str_replace(',&quot;info&quot;', '', $services) . ',&quot;info&quot;';
                    }

                    $eventData['display_dat'] = '<div class="shariff" data-url="' . $eventData['rdf_ident'] .'" data-services="[' . $services . ']" data-lang="' . $lang .'" data-theme="' . $theme . '" data-mail-url="mailto:foo@example.org"'. $hardcoded_title . $twitter_via_tag . $backend_tag . '></div>' . "\n";
                    break;

                case 'css':
                    $eventData .= str_replace('{SOFA_PATH}', $serendipity['serendipityHTTPPath'] . 'plugins/serendipity_event_social/fa/', file_get_contents(dirname(__FILE__) . '/shariff.complete.css'));
                    break;

                case 'frontend_footer':
                    // this script should go into the JS hook, but it has to be at the bottom to work, and the js hook places it at the top
                    echo '    <script src="' . $serendipity['serendipityHTTPPath'] . 'plugins/serendipity_event_social/shariff.min.js' . '"></script>' . "\n";
                    break;

                case 'frontend_header':
                    // Only emit in Single Entry Mode
                    if ((!isset($serendipity['GET']['id']) || !is_numeric($serendipity['GET']['id'])) && $serendipity['view'] != 'entry') {
                        return;
                    }
                    // Facebook & Twitter can profit from having the og-properties set
                    if (strpos($this->get_config('services'), 'facebook') !== false || strpos($this->get_config('services'), 'twitter') !== false) {

                        // we fetch the internal smarty object to get the current entry body
                        if ($serendipity['template'] != 'default-php' && is_object($eventData['smarty'])) {
                            $entry = (array)$eventData['smarty']->tpl_vars['entry']->value;
                        } else {
                            $entry = serendipity_fetchEntry('id', (int)$serendipity['GET']['id']);
                        }

                        $blogURL = 'http' . ($_SERVER['HTTPS'] ? 's' : '') . '://' . $_SERVER['HTTP_HOST'];

                        # /\s+/: multiple newline and whitespaces
                        echo '    <!--serendipity_event_shariff-->' . "\n";
                        echo '    <meta name="twitter:card" content="summary" />' . "\n";
                        echo '    <meta property="og:title" content="' . htmlspecialchars($entry['title'], double_encode: false) . '" />' . "\n";

                        $meta_description = $entry['properties']['meta_description'] ?? '';
                        if (empty($meta_description)) {
                            $description_body = $entry['body'];
                            if (isset($GLOBALS['entry'][0]['plaintext_body'])) {
                                $description_body = trim($GLOBALS['entry'][0]['plaintext_body']); // markdown plugin
                            }
                            $meta_description = trim(preg_replace('/\s+/', ' ', substr(strip_tags($description_body), 0, 200))) . '...';
                        }

                        echo '    <meta property="og:description" content="' . htmlspecialchars($meta_description, double_encode: false) . '" />' . "\n";
                        echo '    <meta property="og:type" content="article" />' . "\n";
                        echo '    <meta property="og:site_name" content="' . $serendipity['blogTitle'] . '" />' . "\n";
                        echo '    <meta property="og:url" content="'. $blogURL . htmlspecialchars($_SERVER['REQUEST_URI']) . '" />' . "\n";

                        // set default image from plugin configuration
                        $social_image = $this->get_config('social_image', '');
                        if (isset($entry['properties']) && isset($entry['properties']['entry_image'])) {
                            // if entry_image is set, use this image instead (first priority)
                            $social_image = $entry['properties']['entry_image'];
                        } else if (isset($entry['properties']) && isset($entry['properties']['timeline_image'])) {
                            // if timeline_image from timeline theme is set, use this image (second priority)
                            $social_image = $entry['properties']['timeline_image'];
                        } else if (isset($entry['properties']) && isset($entry['properties']['ep_featuredImage'])) {
                            // if ep_featuredImage from photo theme is set, use this image (third priority)
                            $social_image = $entry['properties']['ep_featuredImage'];
                        } else {
                            // Fourth priority:
                            // This is searching for the first image in an entry to use as facebook article image.
                            // A better approach would be to register in the entry editor when an image was added
                            if (preg_match_all('@<img.*src=["\'](.+)["\']@imsU', $entry['body'] . $entry['extended'], $images)) {
                                foreach($images[1] AS $im) {
                                    if (strpos($im, '/emoticons/') === false) {
                                        $social_image = $im;
                                        break;
                                    }
                                }
                            }
                        }

                        if (! preg_match('/^http/i', $social_image)) {
                            $social_image = $blogURL . $social_image;
                        }

                        if ($social_image != $blogURL && $social_image != $blogURL . 'none') {
                            echo '    <meta property="og:image" content="' . $social_image . '" />' . "\n";
                        }
                    }
                    break;

                case 'backend_display':
                    if (isset($serendipity['POST']['properties']['entry_image'])) {
                        $entry_image = $serendipity['POST']['properties']['entry_image'];
                    } elseif (!empty($eventData['properties']['entry_image'])) {
                        $entry_image = $eventData['properties']['entry_image'];
                    } else {
                        $entry_image = '';
                    }
?>

            <fieldset id="edit_entry_social_image" class="entryproperties_social_image">
                <span class="wrap_legend"><legend><?php echo PLUGIN_EVENT_SOCIAL_ENTRY_IMAGE; ?></legend></span>
                <textarea data-configitem="properties_entry_image" name="serendipity[properties][entry_image]" class="change_preview" id="properties_entry_image" style="width: 94%"><?php echo htmlspecialchars($entry_image); ?></textarea>
                <button class="customfieldMedia" type="button" name="insImage" title="<?php echo MEDIA ; ?>"><span class="icon-picture" aria-hidden="true"></span><span class="visuallyhidden"><?php echo MEDIA ; ?></span></button>
<?php
            if (!empty($entry_image)) {
?>
                <figure id="properties_entry_image_preview" style="width:auto;max-width:92%;">
                    <figcaption><?php echo PREVIEW; ?></figcaption>
                    <img src="<?php echo $entry_image; ?>"  alt=""/>
                </figure>
<?php
            }
?>
            </fieldset>

<?php
                    break;

                case 'backend_publish':
                case 'backend_save':
                    if (!isset($serendipity['POST']['properties']) || !is_array($serendipity['POST']['properties']) || !isset($eventData['id'])) {
                        return true;
                    }

                    $entry_image = $serendipity['POST']['properties']['entry_image'];

                    // delete old entry, if any
                    $q = "DELETE FROM {$serendipity['dbPrefix']}entryproperties WHERE entryid = " . (int)$eventData['id'] . " AND property = 'entry_image'";
                    serendipity_db_query($q);

                    // save new entry
                    if (!empty($entry_image)) {
                        $q = "INSERT INTO {$serendipity['dbPrefix']}entryproperties (entryid, property, value) VALUES (" . (int)$eventData['id'] . ", 'entry_image', '" . serendipity_db_escape_string($entry_image) . "')";
                        serendipity_db_query($q);
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