<?php

if (IN_serendipity !== true) {
    die ("Don't hack!");
}

@serendipity_plugin_api::load_language(dirname(__FILE__));

class serendipity_event_dsgvo_gdpr extends serendipity_event
{
    var $title = PLUGIN_EVENT_DSGVO_GDPR_NAME;

    function introspect(&$propbag)
    {
        global $serendipity;

        $propbag->add('name',          PLUGIN_EVENT_DSGVO_GDPR_NAME);
        $propbag->add('description',   PLUGIN_EVENT_DSGVO_GDPR_DESC);
        $propbag->add('stackable',     false);
        $propbag->add('author',        'Serendipity Team, Ian Styx');
        $propbag->add('version',       '2.04');
        $propbag->add('requirements',  array(
            'serendipity' => '2.0',
            'smarty'      => '3.1.0',
            'php'         => '5.3.3'
        ));
        $propbag->add('groups', array('FRONTEND_FEATURES', 'BACKEND_FEATURES'));
        $propbag->add('event_hooks',
            array(
                'frontend_saveComment'  => true,
                'frontend_comment'      => true,
                'entries_header'        => true,
                'entry_display'         => true,
                'genpage'               => true,
                'frontend_footer'       => true,
                'frontend_configure'    => true,
                'css'                   => true,
                'css_backend'           => true,
                'backend_sidebar_admin_appearance' => true,
                'backend_sidebar_entries_event_display_dsgvo'  => true,
                'backend_deletecomment' => true
            )
        );

        $propbag->add('configuration', array(
            'commentform_checkbox',
            'commentform_text',
            'gdpr_url',
            'gdpr_info',
            'gdpr_content',
            'show_in_footer',
            'show_in_footer_text',
            'cookie_consent',
            'cookie_consent_text',
            'cookie_consent_path',
            'anonymizeIp'
        ));
        $propbag->add('config_groups', array(
            PLUGIN_EVENT_DSGVO_GDPR_MENU => array('gdpr_url', 'gdpr_info', 'gdpr_content'),
            PLUGIN_EVENT_DSGVO_GDPR_COOKIE_MENU => array('cookie_consent', 'cookie_consent_text', 'cookie_consent_path')
        ));
        $propbag->add('legal',         array(
            'services' => array(),
            'frontend' => array(
                'This plugin helps the user to comply with the European General Data Protection Regulation Act and adds easy links to your sites legal notes. Optionally it adds the comment consent checkbox and/or the CookieConsent JavaScript for alerting users about the use of Cookies on this website.',
            ),
            'backend' => array(
                'Adds Backend actions to CSV extract or delete user data.',
            ),
            'cookies' => array(
                'The CookieConsent by Osano option stores a consent-cookie which is build by several third-party location API services itself for country code, geoIP-location, hostname, organization and other data types.',
            ),
            'stores_user_input'     => false,
            'stores_ip'             => false,
            'uses_ip'               => false,
            'transmits_user_input'  => false
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
            case 'gdpr_url':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_EVENT_DSGVO_GDPR_URL);
                $propbag->add('description', PLUGIN_EVENT_DSGVO_GDPR_URL_DESC);
                $propbag->add('default',     '');
                break;

            case 'gdpr_content':
                $propbag->add('type',        'html');
                $propbag->add('name',        PLUGIN_EVENT_DSGVO_GDPR_STATEMENT);
                $propbag->add('description', PLUGIN_EVENT_DSGVO_GDPR_STATEMENT_DESC);
                $propbag->add('default',     '');
                break;

            case 'commentform_text':
                $propbag->add('type',        'html');
                $propbag->add('name',        PLUGIN_EVENT_DSGVO_GDPR_COMMENTFORM_TEXT);
                $propbag->add('description', PLUGIN_EVENT_DSGVO_GDPR_COMMENTFORM_TEXT_DESC . ' '. PLUGIN_EVENT_DSGVO_GDPR_SAVENEWLANG);
                $propbag->add('default',     PLUGIN_EVENT_DSGVO_GDPR_COMMENTFORM_TEXT_DEFAULT);
                break;

            case 'commentform_checkbox':
                $propbag->add('type',        'boolean');
                $propbag->add('name',        PLUGIN_EVENT_DSGVO_GDPR_COMMENTFORM_CHECKBOX);
                $propbag->add('description', PLUGIN_EVENT_DSGVO_GDPR_COMMENTFORM_CHECKBOX_DESC);
                $propbag->add('default',     'true');
                break;

            case 'anonymizeIp':
                $propbag->add('type',        'boolean');
                $propbag->add('name',        PLUGIN_EVENT_DSGVO_GDPR_ANONYMIZE);
                $propbag->add('description', PLUGIN_EVENT_DSGVO_GDPR_ANONYMIZE_DESC);
                $propbag->add('default',     'false');
                break;

            case 'show_in_footer':
                $propbag->add('type',        'boolean');
                $propbag->add('name',        PLUGIN_EVENT_DSGVO_GDPR_SHOW_IN_FOOTER);
                $propbag->add('description', PLUGIN_EVENT_DSGVO_GDPR_SHOW_IN_FOOTER_DESC);
                $propbag->add('default',     'true');
                break;

            case 'show_in_footer_text':
                $propbag->add('type',        'html');
                $propbag->add('name',        PLUGIN_EVENT_DSGVO_GDPR_SHOW_IN_FOOTER_TEXT);
                $propbag->add('description', PLUGIN_EVENT_DSGVO_GDPR_SHOW_IN_FOOTER_TEXT_DESC . ' '. PLUGIN_EVENT_DSGVO_GDPR_SAVENEWLANG);
                $propbag->add('default',     PLUGIN_EVENT_DSGVO_GDPR_SHOW_IN_FOOTER_TEXT_DEFAULT);
                break;

            case 'gdpr_info':
                $propbag->add('type',        'content');
                $propbag->add('name',        PLUGIN_EVENT_DSGVO_GDPR_INFO);
                $propbag->add('description', PLUGIN_EVENT_DSGVO_GDPR_INFO_DESC);
                $propbag->add('default',     $this->inspect_gdpr());
                break;

            case 'cookie_consent':
                $propbag->add('type',        'boolean');
                $propbag->add('name',        PLUGIN_EVENT_DSGVO_GDPR_COOKIE_CONSENT);
                $propbag->add('description', PLUGIN_EVENT_DSGVO_GDPR_COOKIE_CONSENT_DESC);
                $propbag->add('default',     'false');
                break;

            case 'cookie_consent_text':
                $propbag->add('type',        'text');
                $propbag->add('name',        PLUGIN_EVENT_DSGVO_GDPR_COOKIE_CONSENT_TEXT);
                $propbag->add('description', PLUGIN_EVENT_DSGVO_GDPR_COOKIE_CONSENT_TEXT_DESC);
                $propbag->add('default',     PLUGIN_EVENT_DSGVO_GDPR_COOKIE_CONSENT_TEXT_DEFAULT);
                break;

            case 'cookie_consent_path':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_EVENT_DSGVO_GDPR_COOKIE_CONSENT_PATH);
                $propbag->add('description', PLUGIN_EVENT_DSGVO_GDPR_COOKIE_CONSENT_PATH_DESC);
                $propbag->add('default',     $serendipity['serendipityHTTPPath'] . 'plugins/serendipity_event_dsgvo_gdpr/');
                break;

        }

        return true;
    }

    function file_get_contents_utf8($str)
    {
        $content = file_get_contents($str);
        return mb_convert_encoding($content, LANG_CHARSET,
               mb_detect_encoding($content, (LANG_CHARSET.', UTF-8, ISO-8859-1'), true));
    }

    function inspect_gdpr()
    {
        global $serendipity;

        $out = PLUGIN_EVENT_DSGVO_GDPR_SERENDIPITY_CORE;

        $classes = serendipity_plugin_api::enum_plugins('hide', true); // reverse is all installed, except hidden plugins
        foreach ($classes AS $class_data) {
            // classname does not and pluginPath may not exist yet
            $class_data['classname']  = explode(':', $class_data['name'])[0];
            $class_data['pluginPath'] = !empty($class_data['path']) ? $class_data['path'] : $class_data['classname'];

            $pluginFile =  serendipity_plugin_api::probePlugin($class_data['name'], $class_data['classname'], $class_data['pluginPath']);
            $plugin     =& serendipity_plugin_api::getPluginInfo($pluginFile, $class_data, 'event');
            $plugin     =& serendipity_plugin_api::getPluginInfo($pluginFile, $class_data, 'sidebar');
            // Object is returned when a plugin could not be cached. So we need to work on objects for db pluginlist too.
            if (is_array($plugin)) {
                $plugin =& serendipity_plugin_api::load_plugin($class_data['name'], null, $class_data['path'], $pluginFile);
            }

            if (is_object($plugin)) {
                $bag = new serendipity_property_bag;
                $plugin->introspect($bag);

                $legal = $bag->get('legal');
                if (is_array($legal)) {
                    $out .= '<h3>' . $class_data['classname'] . "</h3>\n\n";

                    // "services" should list every service that a plugin connects to via a HTTP or other API interface,
                    // and describe what each service does, and which data it gets.
                    // Only services that are executed on visitor input must be listed; services that the blog server (instead
                    // of a client) connects to are nice to have, but are only required to be shown if it includes visitor (meta)data.
                    if (is_array($legal['services']) && count($legal['services']) > 0) {
                        $out .= '<h4>'.PLUGIN_EVENT_DSGVO_GDPR_PLUGINS_SERVICES_HEAD."</h4>\n";
                        $out .= "<ul>\n";
                        foreach($legal['services'] AS $servicename => $servicedata) {
                            $out .= '    <li><a href="' . $servicedata['url'] . '">' . $servicename . '</a>: ' . $servicedata['desc'] . "</li>\n";
                        }
                        $out .= "</ul>\n\n";
                    }

                    // "frontend" lists descriptions what the plugin does on the frontendside and where it uses visitor data or metadata
                    if (is_array($legal['frontend']) && count($legal['frontend']) > 0) {
                        $out .= "<h4>Frontend</h4>\n";
                        $out .= "<ul>\n";
                        foreach($legal['frontend'] AS $servicename => $servicedata) {
                            $out .= '    <li>' . $servicedata . "</li>\n";
                        }
                        $out .= "</ul>\n\n";
                    }

                    // "backend" lists descriptions what the plugin does on the backend and where it uses visitor data or metadata
                    if (isset($legal['backend']) && is_array($legal['backend']) && count($legal['backend']) > 0) {
                        $out .= "<h4>Backend</h4>\n";
                        $out .= "<ul>\n";
                        foreach($legal['backend'] AS $servicename => $servicedata) {
                            $out .= '    <li>' . $servicedata . "</li>\n";
                        }
                        $out .= "</ul>\n\n";
                    }

                    // "cookies" lists an array of which cookies might be set a a plugin and why. If a plugin makes use of
                    // session features, also mention that it relies on that session id.
                    if (is_array($legal['cookies']) && count($legal['cookies']) > 0) {
                        $out .= "<h4>Cookies</h4>\n";
                        $out .= "<ul>\n";
                        foreach($legal['cookies'] AS $servicename => $servicedata) {
                            $out .= '    <li>' . $servicedata . "</li>\n";
                        }
                        $out .= "</ul>\n\n";
                    }

                    // "sessiondata" lists an array of which PHP session data values are (temporarily) saved
                    if (isset($legal['sessiondata']) && is_array($legal['sessiondata']) && count($legal['sessiondata']) > 0) {
                        $out .= '<h4>'.PLUGIN_EVENT_DSGVO_GDPR_PLUGINS_SESSIONDATA_HEAD."</h4>\n";
                        $out .= "<ul>\n";
                        foreach($legal['sessiondata'] AS $servicename => $servicedata) {
                            $out .= '    <li>' . $servicedata . "</li>\n";
                        }
                        $out .= "</ul>\n\n";
                    }

                    // This is a list of TRUE/FALSE boolean toggles
                    $out .= '<h4>'.PLUGIN_EVENT_DSGVO_GDPR_PLUGINS_ATTR_HEAD."</h4>\n";
                    $out .= '<div class="dsgvo_gdpr_properties">'."\n";
                    $out .= "<ul>\n";
                    if ($legal['stores_user_input']) {
                        $out .= '    <li>'.PLUGIN_EVENT_DSGVO_GDPR_PLUGINS_ATTR_STORAGE_USER_YES."</li>\n";
                    } else {
                        $out .= '    <li>'.PLUGIN_EVENT_DSGVO_GDPR_PLUGINS_ATTR_STORAGE_USER_NO."</li>\n";
                    }

                    if ($legal['stores_ip']) {
                        $out .= '    <li>'.PLUGIN_EVENT_DSGVO_GDPR_PLUGINS_ATTR_STORAGE_IP_YES."</li>\n";
                    } else {
                        $out .= '    <li>'.PLUGIN_EVENT_DSGVO_GDPR_PLUGINS_ATTR_STORAGE_IP_NO."</li>\n";
                    }

                    if ($legal['uses_ip']) {
                        $out .= '    <li>'.PLUGIN_EVENT_DSGVO_GDPR_PLUGINS_ATTR_USES_IP_YES."</li>\n";
                    } else {
                        $out .= '    <li>'.PLUGIN_EVENT_DSGVO_GDPR_PLUGINS_ATTR_USES_IP_NO."</li>\n";
                    }

                    if ($legal['transmits_user_input']) {
                        $out .= '    <li>'.PLUGIN_EVENT_DSGVO_GDPR_PLUGINS_ATTR_TRANSMITS_YES."</li>\n";
                    } else {
                        $out .= '    <li>'.PLUGIN_EVENT_DSGVO_GDPR_PLUGINS_ATTR_TRANSMITS_NO."</li>\n";
                    }

                    $out .= "</ul>\n</div>\n\n";
                }
            }
        }

        // Themes
        $stack = array();
        serendipity_plugin_api::hook_event('backend_templates_fetchlist', $stack);
        $themes = serendipity_fetchTemplates();
        foreach($themes AS $theme) {
            $stack[$theme] = serendipity_fetchTemplateInfo($theme);
        }
        ksort($stack);

        $theme_active = '';
        $theme_other = '';

        $static_info =  array(
                '2k11' => array(
                    'This theme can optionally use webfonts. If enabled, webfonts are loaded from Google/CDN servers, who will receive the IP address of the visitor and his metadata (browser, referrer, user agent, possible cookies).'
                ),
                'next' => array(
                    'This theme can optionally use webfonts. If enabled, webfonts are loaded from Google/CDN servers, who will receive the IP address of the visitor and his metadata (browser, referrer, user agent, possible cookies).'
                ),
                'clean-blog' => array(
                    'This theme uses javascript libraries via bootstrap CDN services (maxcdn.bootstrapcdn.com) and some polyfill libraries via the (oss.maxcdn.com) CDN service for old browsers. These services might track your metadata and IP. It can also optionally use webfonts. If enabled, webfonts are loaded from Google/CDN servers, who will receive the IP address of the visitor and his metadata (browser, referrer, user agent, possible cookies).'
                ),
                'skeleton' => array(
                    'This theme can optionally use webfonts. If enabled, webfonts are loaded from Google/CDN servers, who will receive the IP address of the visitor and his metadata (browser, referrer, user agent, possible cookies).'
                ),
                'timeline' => array(
                    'This theme uses javascript libraries via bootstrap CDN services (maxcdn.bootstrapcdn.com), which might track your metadata and IP. It can also optionally use webfonts. If enabled, webfonts are loaded from Google/CDN servers, who will receive the IP address of the visitor and his metadata (browser, referrer, user agent, possible cookies).'
                ),

        );

        $out .= PLUGIN_EVENT_DSGVO_GDPR_SERENDIPITY_CORE_THEMES;

        foreach ($stack AS $theme => $info) {
            if (file_exists($serendipity["serendipityPath"] . $serendipity["templatePath"] . $theme . "/legal.txt") || isset($static_info[$theme])) {
                if ($theme == $serendipity['template']) {
                    $pointer = 'theme_active';

                    $$pointer .= '<h3>Active Theme "' . $theme .  "\"</h3>\n";
                } else {
                    $pointer = 'theme_other';

                    $$pointer .= '<h3>Available Theme "' . $theme .  "\"</h3>\n";
                }

                $$pointer .= "<ul>\n";
                if (isset($static_info[$theme])) {
                    foreach($static_info[$theme] AS $themeout) {
                        $$pointer .= '    <li>' . $themeout . "</li>\n";
                    }
                } else if (file_exists($serendipity["serendipityPath"] . $serendipity["templatePath"] . $theme . "/legal.txt")) {
                    $$pointer .= '    <li>' . htmlspecialchars($this->file_get_contents_utf8($serendipity["serendipityPath"] . $serendipity["templatePath"] . $theme . "/legal.txt"), ENT_COMPAT, LANG_CHARSET, false) . "</li>\n";
                }
                $$pointer .= "</ul>\n";
            }
        }

        $out .= $theme_active . $theme_other;

        return $out;
    }

    function parseText($text)
    {
        global $serendipity;

        $url = $this->get_config('gdpr_url');
        if (empty($url)) {
            $url = $serendipity['serendipityHTTPPath'] . $serendipity['indexFile'] . '?serendipity[subpage]=dsgvo_gdpr_privacy';
        }
        $text = str_replace('%gdpr_url%', $url, $text);
        return $text;
    }

    function isActive()
    {
        global $serendipity;

        if (isset($serendipity['GET']['subpage']) && $serendipity['GET']['subpage'] == 'dsgvo_gdpr_privacy') {
            return true;
        }

        return false;
    }

    function parseParts($string)
    {
        $out = array();
        $parts = explode("\n", $string);
        foreach($parts AS $part) {
            $part = trim($part);
            if (empty($part)) continue;
            $out[] = "'" . serendipity_db_escape_string($part) . "'";
        }
        return $out;
    }

    function showBackend()
    {
        global $serendipity;

        if ($serendipity['serendipityUserlevel'] < USERLEVEL_ADMIN) {
            return false;
        }

        if (!isset($serendipity['POST']['export'])) {
            echo '<h2>' . PLUGIN_EVENT_DSGVO_GDPR_BACKEND_TITLE . "</h2>\n";
        }

        $clist = array();
        if (isset($serendipity['POST']['delete']) || isset($serendipity['POST']['export'])) {

            $author_list = $this->parseParts($serendipity['POST']['filter']['author']);
            $email_list  = $this->parseParts($serendipity['POST']['filter']['email']);

            if (count($author_list) == 0 && count($email_list) == 0) {
                echo '<span class="msg_error"><span class="icon-attention-circled"></span> ' . PLUGIN_EVENT_DSGVO_GDPR_BACKEND_DELFAIL . "</span>\n";
            } else {
                $where = array();

                if (count($author_list) > 0) {
                    $where[] = 'author IN (' . implode(', ', $author_list) . ')';
                }

                if (count($email_list) > 0) {
                    $where[] = 'email IN (' . implode(', ', $email_list) . ')';
                }

                $clist = serendipity_db_query("SELECT *
                                                 FROM {$serendipity['dbPrefix']}comments
                                                WHERE " . implode(' OR ', $where), false, 'assoc');
            }

            if (!is_array($clist) || count($clist) == 0) {
                echo '<span class="msg_notice"><span class="icon-info-circled"></span> ' . NO_COMMENTS . "</span>\n";
            } else {

                if (isset($serendipity['POST']['delete'])) {
                    foreach($clist AS $comment) {
                        if (serendipity_deleteComment($comment['id'], $comment['entry_id'])) {
                            echo '<span class="msg_success"><span class="icon-ok-circled"></span> ' . sprintf(COMMENT_DELETED, $comment['id']) . "</span>\n";
                        }
                    }
                }

                if (isset($serendipity['POST']['export'])) {
                    $csvdata  = '';
                    header('Content-Type: application/csv; charset=' . LANG_CHARSET);
                    header('Content-Disposition: attachment; filename=blog-userData.csv');
                    $csvdata .= '#';
                    foreach($clist[0] AS $key => $val) {
                        $csvdata .= '"' . $key . '";';
                    }
                    $csvdata .= "\n";
                    foreach($clist AS $comment) {
                        foreach($comment AS $key => $val) {
                            $csvdata .= '"' . $val . '";';
                        }
                        $csvdata .= "\n";
                    }
                    echo $csvdata;
                    die();
                }
            }
        }
?>

<form action="?" method="post">
    <?= serendipity_setFormToken() ?>

    <input type="hidden" name="serendipity[adminModule]" value="event_display">
    <input type="hidden" name="serendipity[adminAction]" value="dsgvo">

    <p><?= PLUGIN_EVENT_DSGVO_GDPR_BACKEND_INFO ?></p>

    <fieldset id="filter_dsgvo" class="filter_pane">
        <legend class="visuallyhidden"><?php echo PLUGIN_EVENT_DSGVO_GDPR_BACKEND; ?></legend>
        <div class="clearfix inputs">
            <div class="form_field">
                <label for="filter_author"><?php echo AUTHOR; ?></label>
                <textarea id="filter_author" name="serendipity[filter][author]"><?php echo isset($serendipity['POST']['filter']['author']) ? serendipity_specialchars($serendipity['POST']['filter']['author']) : ''; ?></textarea>
            </div>

            <div class="form_field">
                <label for="filter_email"><?php echo EMAIL; ?></label>
                <textarea id="filter_email" name="serendipity[filter][email]"><?php echo isset($serendipity['POST']['filter']['email']) ? serendipity_specialchars($serendipity['POST']['filter']['email']) : ''; ?></textarea>
            </div>

        </div>

        <div class="form_buttons">
            <input name="serendipity[export]" value="CSV" type="submit">
            <input name="serendipity[delete]" class="state_cancel comments_multidelete" data-delmsg="<?php echo COMMENTS_DELETE_CONFIRM; ?>" value="<?php echo DELETE; ?>" type="submit">
        </div>
    </fieldset>

</form>

<p><em><?= PLUGIN_EVENT_DSGVO_GDPR_BACKEND_CHECK_REQUESTS ?></em></p>
<?php
    }

    function event_hook($event, &$bag, &$eventData, $addData = null)
    {
        global $serendipity;

        $hooks = &$bag->get('event_hooks');

        if (isset($hooks[$event])) {

            switch($event) {

                case 'backend_sidebar_admin_appearance':
                    if ($serendipity['serendipityUserlevel'] < USERLEVEL_ADMIN) {
                        break;
                    }
                    echo '                        <li><a href="?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=dsgvo">' . PLUGIN_EVENT_DSGVO_GDPR_BACKEND_SB_TITLE . "</a></li>\n";
                    break;

                case 'backend_sidebar_entries_event_display_dsgvo':
                    $this->showBackend();
                    break;

                case 'css_backend':
                    $eventData .= '

/* serendipity_event_dsgvo_gdpr start */

.dsgvo_gdpr_properties {
    background-color: #EEE;
    border: 1px solid #DDD;
}

/* serendipity_event_dsgvo_gdpr end */

';
                    break;

                case 'frontend_configure':
                    if (serendipity_db_bool($this->get_config('anonymizeIp', 'false'))) {
                        $_SERVER['REMOTE_ADDR'] = IpAnonymizer::anonymizeIp($_SERVER['REMOTE_ADDR']);
                    }
                    break;

                case 'frontend_saveComment':
                    if (serendipity_db_bool($this->get_config('commentform_checkbox', 'true')) && (!isset($serendipity['serendipityUserlevel']) || $serendipity['serendipityUserlevel'] < USERLEVEL_ADMIN)) {
                        if ($addData['type'] == 'NORMAL') {
                            // Only act to comments. Trackbacks are an API so we cannot add checks there.
                            if (empty($serendipity['POST']['accept_privacy'])) {
                                $eventData = array('allow_comments' => false);
                                $serendipity['messagestack']['comments'][] = PLUGIN_EVENT_DSGVO_GDPR_COMMENTFORM_ERROR;
                                return false;
                            }
                        }
                    }
                    break;

                case 'frontend_comment':
                    if (serendipity_db_bool($this->get_config('commentform_checkbox', 'true')) && (!isset($serendipity['serendipityUserlevel']) || $serendipity['serendipityUserlevel'] < USERLEVEL_ADMIN)) {
?>
                        <div class="form_toolbar dsgvo_gdpr_comment">
                            <div class="form_box">
                                <input id="checkbox_dsgvo_gdpr" name="serendipity[accept_privacy]" value="1" type="checkbox"<?php echo (isset($serendipity['POST']['accept_privacy']) && $serendipity['POST']['accept_privacy'] == 1 ? ' checked="checked"' : ''); ?>><label for="checkbox_dsgvo_gdpr"><?php echo $this->parseText($this->get_config('commentform_text')); ?></label>
                            </div>
                        </div>
<?php
                    }
                    break;

                case 'genpage':
                    if ($this->isActive()) {
                        $serendipity['is_staticpage'] = true;
                    }
                    break;

                case 'backend_deletecomment':
                    // Vanilla s9y does not delete all metadata of a comment that has threaded replies, it only sets the body to "Deleted".
                    // Here we take care that all metadata is cleared in that case.
                    serendipity_db_query("UPDATE {$serendipity['dbPrefix']}comments
                                             SET title = '', author = '', email = '', url = '', ip = '', referer = ''
                                           WHERE id = {$addData['cid']}");
                    break;

                case 'entry_display':
                    if ($this->isActive()) {
                        if (is_array($eventData)) {
                            $eventData['clean_page'] = true; // This is important to not display an entry list!
                        } else {
                            $eventData = array('clean_page' => true);
                        }
                         // Assign Smarty defaults for pagination
                        $serendipity['smarty']->assign('footer_prev_page', null);
                        $serendipity['smarty']->assign('footer_next_page', null);
                    }
                    break;

                case 'entries_header':
                    if ($this->isActive()) {
                        serendipity_header($_SERVER['SERVER_PROTOCOL'].' 200 OK');
                        serendipity_header('Status: 200 OK');

                        $statement = $this->get_config('gdpr_content');

                        if (empty($statement)) {
                            if (empty($url)) {
                                $statement = '<div class="dsgvo_gdpr_statement_error">' . PLUGIN_EVENT_DSGVO_GDPR_STATEMENT_ERROR . "</div>\n";
                            } else {
                                $statement = $this->parseText($this->get_config('commentform_text'));
                            }
                        }

                        echo '<div class="dsgvo_gdpr_statement">' . $statement . '</div>';
                    }
                    break;

                case 'frontend_footer':
                    if (isset($serendipity['serendipityUserlevel']) && $serendipity['serendipityUserlevel'] == USERLEVEL_ADMIN) {
                        break;
                    }
                    if (serendipity_db_bool($this->get_config('show_in_footer', 'true'))) {
                        echo '<div class="dsgvo_gdpr_footer">' . $this->parseText($this->get_config('show_in_footer_text')) . "</div>\n";
                    }

                    if (serendipity_db_bool($this->get_config('cookie_consent', 'false'))) {
?>
    <link rel="stylesheet" type="text/css" href="<?php echo $this->get_config('cookie_consent_path'); ?>cookieconsent.min.css" />
    <script type="text/javascript" src="<?php echo $this->get_config('cookie_consent_path'); ?>cookieconsent.min.js"></script>
<?php
                        echo $this->parseText($this->get_config('cookie_consent_text'));
                    }
                    break;

                case 'css':
                    // class exists in CSS, so a user has customized it and we don't need default
                    if (false === strpos($eventData, '.dsgvo_gdpr')) {
                        $eventData .= '

/* serendipity_event_dsgvo_gdpr start */

.dsgvo_gdpr_footer {
    text-align: center;
}

.dsgvo_gdpr_statement {
    margin: 1em;
}

#checkbox_dsgvo_gdpr {
    margin-right: .4em;
}

/* serendipity_event_dsgvo_gdpr end */

';
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

/*
https://github.com/geertw/php-ip-anonymizer/blob/master/LICENSE

MIT License

Copyright (c) 2016 Geert Wirken

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
 */
class IpAnonymizer
{
    /**
     * @var string IPv4 netmask used to anonymize IPv4 address.
     */
    public $ipv4NetMask = "255.255.255.0";

    /**
     * @var string IPv6 netmask used to anonymize IPv6 address.
     */
    public $ipv6NetMask = "ffff:ffff:ffff:ffff:0000:0000:0000:0000";

    /**
     * Anonymize an IPv4 or IPv6 address.
     *
     * @param $address string IP address that must be anonymized
     * @return string The anonymized IP address. Returns an empty string when the IP address is invalid.
     */
    public static function anonymizeIp($address)
    {
        $anonymizer = new IpAnonymizer();
        return $anonymizer->anonymize($address);
    }

    /**
     * Anonymize an IPv4 or IPv6 address.
     *
     * @param $address string IP address that must be anonymized
     * @return string The anonymized IP address. Returns an empty string when the IP address is invalid.
     */
    public function anonymize($address)
    {
        $packedAddress = inet_pton($address);
        if (strlen($packedAddress) == 4) {
            return $this->anonymizeIPv4($address);
        } elseif (strlen($packedAddress) == 16) {
            return $this->anonymizeIPv6($address);
        } else {
            return "";
        }
    }

    /**
     * Anonymize an IPv4 address
     * @param $address string IPv4 address
     * @return string Anonymized address
     */
    public function anonymizeIPv4($address)
    {
        return inet_ntop(inet_pton($address) & inet_pton($this->ipv4NetMask));
    }

    /**
     * Anonymize an IPv6 address
     * @param $address string IPv6 address
     * @return string Anonymized address
     */
    public function anonymizeIPv6($address)
    {
        return inet_ntop(inet_pton($address) & inet_pton($this->ipv6NetMask));
    }

}

/* vim: set sts=4 ts=4 expandtab : */
?>