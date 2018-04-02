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
        $propbag->add('author',        'Serendipity Team');
        $propbag->add('version',       '1.25');
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
                'css'                   => true
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
            'cookie_consent_path'
        ));
        $propbag->add('config_groups', array(
            PLUGIN_EVENT_DSGVO_GDPR_MENU => array('gdpr_url', 'gdpr_info', 'gdpr_content'),
            PLUGIN_EVENT_DSGVO_GDPR_COOKIE_MENU => array('cookie_consent', 'cookie_consent_text', 'cookie_consent_path')
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
                $propbag->add('description', PLUGIN_EVENT_DSGVO_GDPR_COMMENTFORM_TEXT_DESC);
                $propbag->add('default',     PLUGIN_EVENT_DSGVO_GDPR_COMMENTFORM_TEXT_DEFAULT);
                break;

            case 'commentform_checkbox':
                $propbag->add('type',        'boolean');
                $propbag->add('name',        PLUGIN_EVENT_DSGVO_GDPR_COMMENTFORM_CHECKBOX);
                $propbag->add('description', PLUGIN_EVENT_DSGVO_GDPR_COMMENTFORM_CHECKBOX_DESC);
                $propbag->add('default',     'true');
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
                $propbag->add('description', PLUGIN_EVENT_DSGVO_GDPR_SHOW_IN_FOOTER_TEXT_DESC);
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
                $propbag->add('default',     'true');
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

    function inspect_gdpr()
    {
        $out = PLUGIN_EVENT_DSGVO_GDPR_SERENDIPITY_CORE;

        $classes = serendipity_plugin_api::enum_plugins('hide', true); // reverse is all installed, except hidden plugins
        foreach ($classes AS $class_data) {
            // classname does not and pluginPath may not exist yet
            $class_data['classname']  = explode(':', $class_data['name'])[0];
            $class_data['pluginPath'] = !empty($class_data['path']) ? $class_data['path'] : $class_data['classname'];

            if ($class_data['classname'] != 'serendipity_event_dsgvo_gdpr') {
                $pluginFile =  serendipity_plugin_api::probePlugin($class_data['name'], $class_data['classname'], $class_data['pluginPath']);
                $plugin     =& serendipity_plugin_api::getPluginInfo($pluginFile, $class_data, 'event');
                $plugin     =& serendipity_plugin_api::getPluginInfo($pluginFile, $class_data, 'sidebar');

                if (is_object($plugin)) {
                    // Object is returned when a plugin could not be cached.
                    $bag = new serendipity_property_bag;
                    $plugin->introspect($bag);

                    $legal = $bag->get('legal');
                    if (is_array($legal)) {
                        $out .= '<h3>' . $class_data['classname'] . "</h3>\n\n";

                        if (is_array($legal['services']) && count($legal['services']) > 0) {
                            $out .= '<h4>'.PLUGIN_EVENT_DSGVO_GDPR_PLUGINS_SERVICES_HEAD."</h4>\n";
                            $out .= "<ul>\n";
                            foreach($legal['services'] AS $servicename => $servicedata) {
                                $out .= '    <li><a href="' . $servicedata['url'] . '">' . $servicename . '</a>: ' . $servicedata['desc'] . "</li>\n";
                            }
                            $out .= "</ul>\n";
                        }

                        if (is_array($legal['frontend']) && count($legal['frontend']) > 0) {
                            $out .= "<h4>Frontend</h4>\n";
                            $out .= '<ul>';
                            foreach($legal['frontend'] AS $servicename => $servicedata) {
                                $out .= '    <li>' . $servicedata . "</li>\n";
                            }
                            $out .= "</ul>\n";
                        }

                        if (is_array($legal['backend']) && count($legal['backend']) > 0) {
                            $out .= "<h4>Backend</h4>\n";
                            $out .= '<ul>';
                            foreach($legal['backend'] AS $servicename => $servicedata) {
                                $out .= '    <li>' . $servicedata . "</li>\n";
                            }
                            $out .= "</ul>\n";
                        }

                        if (is_array($legal['cookies']) && count($legal['cookies']) > 0) {
                            $out .= "<h4>Cookies</h4>\n";
                            $out .= '<ul>';
                            foreach($legal['cookies'] AS $servicename => $servicedata) {
                                $out .= '    <li>' . $servicedata . "</li>\n";
                            }
                            $out .= "</ul>\n";
                        }

                        if (is_array($legal['sessiondata']) && count($legal['sessiondata']) > 0) {
                            $out .= '<h4>'.PLUGIN_EVENT_DSGVO_GDPR_PLUGINS_SESSIONDATA_HEAD."</h4>\n";
                            $out .= '<ul>';
                            foreach($legal['sessiondata'] AS $servicename => $servicedata) {
                                $out .= '    <li>' . $servicedata . "</li>\n";
                            }
                            $out .= "</ul>\n\n";
                        }

                        $out .= '<h4>'.PLUGIN_EVENT_DSGVO_GDPR_PLUGINS_ATTR_HEAD."</h4>\n";
                        $out .= '<ul>';
                        if ($legal['stores_user_input']) {
                            $out .= '<li>'.PLUGIN_EVENT_DSGVO_GDPR_PLUGINS_ATTR_STORAGE_USER_YES."</li>\n";
                        } else {
                            $out .= '<li>'.PLUGIN_EVENT_DSGVO_GDPR_PLUGINS_ATTR_STORAGE_USER_NO."</li>\n";
                        }

                        if ($legal['stores_ip']) {
                            $out .= '<li>'.PLUGIN_EVENT_DSGVO_GDPR_PLUGINS_ATTR_STORAGE_IP_YES."</li>\n";
                        } else {
                            $out .= '<li>'.PLUGIN_EVENT_DSGVO_GDPR_PLUGINS_ATTR_STORAGE_IP_NO."</li>\n";
                        }

                        if ($legal['uses_ip']) {
                            $out .= '<li>'.PLUGIN_EVENT_DSGVO_GDPR_PLUGINS_ATTR_USES_IP_YES."</li>\n";
                        } else {
                            $out .= '<li>'.PLUGIN_EVENT_DSGVO_GDPR_PLUGINS_ATTR_USES_IP_NO."</li>\n";
                        }

                        if ($legal['transmits_user_input']) {
                            $out .= '<li>'.PLUGIN_EVENT_DSGVO_GDPR_PLUGINS_ATTR_TRANSMITS_YES."</li>\n";
                        } else {
                            $out .= '<li>'.PLUGIN_EVENT_DSGVO_GDPR_PLUGINS_ATTR_TRANSMITS_NO."</li>\n";
                        }

                        $out .= "</ul>\n";
                    }
                }
            }
        }
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

        if ($serendipity['GET']['subpage'] == 'dsgvo_gdpr_privacy') {
            return true;
        }

        return false;
    }

    function event_hook($event, &$bag, &$eventData, $addData = null)
    {
        global $serendipity;

        $hooks = &$bag->get('event_hooks');

        if (isset($hooks[$event])) {

            switch($event) {

                case 'frontend_saveComment':
                    if (serendipity_db_bool($this->get_config('commentform_checkbox', 'true'))) {
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
                    if (serendipity_db_bool($this->get_config('commentform_checkbox', 'true'))) {
?>
                        <fieldset class="form_toolbar dsgvo_gdpr_comment">
                            <div class="form_box">
                                <input id="checkbox_dsgvo_gdpr" name="serendipity[accept_privacy]" value="1" type="checkbox"<?php echo ($serendipity['POST']['accept_privacy'] == 1 ? ' checked="checked"' : ''); ?>><label for="checkbox_dsgvo_gdpr"><?php echo $this->parseText($this->get_config('commentform_text')); ?></label>
                            </div>
                        </fieldset>
<?php
                    }
                    break;

                case 'genpage':
                    if ($this->isActive()) {
                        $serendipity['is_staticpage'] = true;
                    }
                    break;

                case 'entry_display':
                    if ($this->isActive()) {
                        if (is_array($eventData)) {
                            $eventData['clean_page'] = true; // This is important to not display an entry list!
                        } else {
                            $eventData = array('clean_page' => true);
                        }
                    }
                    break;

                case 'entries_header':
                    if ($this->isActive()) {
                        serendipity_header($_SERVER['SERVER_PROTOCOL'].' 200 OK');
                        serendipity_header('Status: 200 OK');

                        $statement = $this->get_config('gdpr_content');

                        if (empty($statement)) {
                            $statement = '<div class="dsgvo_gdpr_statement_error">' . PLUGIN_EVENT_DSGVO_GDPR_STATEMENT_ERROR . "</div>\n";
                        }

                        echo '<div class="dsgvo_gdpr_statement">' . $statement . '</div>';
                    }
                    break;

                case 'frontend_footer':
                    if (serendipity_db_bool($this->get_config('show_in_footer', 'true'))) {
                        echo '<div class="dsgvo_gdpr_footer">' . $this->parseText($this->get_config('show_in_footer_text')) . "</div>\n";
                    }

                    if (serendipity_db_bool($this->get_config('cookie_consent', 'true'))) {
?>
                        <link rel="stylesheet" type="text/css" href="<?php echo $this->get_config('cookie_consent_path'); ?>/cookieconsent.min.css" />
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

/* vim: set sts=4 ts=4 expandtab : */
?>