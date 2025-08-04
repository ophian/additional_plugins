<?php

declare(strict_types=1);

if (IN_serendipity !== true) {
    die ("Don't hack!");
}

@serendipity_plugin_api::load_language(dirname(__FILE__));

class serendipity_event_xsstrust extends serendipity_event
{
    public $title = PLUGIN_EVENT_XSSTRUST_NAME;

    private $protected = true;
    private $trusted_authors = null;

    function introspect(&$propbag)
    {
        global $serendipity;

        $propbag->add('name',          PLUGIN_EVENT_XSSTRUST_NAME);
        $propbag->add('description',   PLUGIN_EVENT_XSSTRUST_DESC);
        $propbag->add('stackable',     false);
        $propbag->add('author',        'Garvin Hicking, Ian Styx');
        $propbag->add('requirements',  array(
            'serendipity' => '5.0',
            'smarty'      => '4.1',
            'php'         => '8.2'
        ));
        $propbag->add('version', '2.1.1');
        $propbag->add('event_hooks', array(
            'frontend_display' => true,
            'backend_media_check' => true,
            'backend_entry_presave' => true,
        ));
        $propbag->add('groups', array('FRONTEND_ENTRY_RELATED', 'BACKEND_USERMANAGEMENT', 'MARKUP'));

        $propbag->add('configuration', array('trusted_authors', 'htmlpurifier'));

        $this->init_trusted();
    }

    function generate_content(&$title)
    {
        $title = $this->title;
    }

    /* This is a per method workaround for correct introspect_config_item configuration element pair consistency (clearfix enables bottom padding) */
    function getAuthors()
    {
        global $serendipity;

        $html = '<div class="clearfix form_select">
                        <label for="serendipity_trusted_authors">' . PLUGIN_EVENT_XSSTRUST_AUTHORS . '</label>';

        $users = (array)serendipity_fetchUsers();
        $valid =& $this->trusted_authors;

        $html .= '
                        <select id="serendipity_trusted_authors" name="serendipity[plugin][trusted_authors][]" multiple="true">
';
        foreach($users AS $user) {
            $html .= '<option value="' . $user['authorid'] . '"' . (isset($valid[$user['authorid']]) ? ' selected="selected"' : '') . '>' . htmlspecialchars($user['realname'], ENT_COMPAT, LANG_CHARSET) . '</option>' . "\n";
        }

        $html .= '                        </select>
                    </div>';

        return $html;
    }

    /* Fetches a configuration value for this plugin */
    function get_config($name, $defaultvalue = null, $empty = true)
    {
        $_res = serendipity_get_config_var($this->instance . '/' . $name, '', $empty);

        if (is_null($_res)) {
            // A protected plugin by a specific owner may not have its values stored in $serendipity
            // because of the special authorid. To display such contents, we need to fetch it
            // separately from the DB.
            $_res = serendipity_get_user_config_var($this->instance . '/' . $name, null, '');
        }

        if (is_null($_res)) {
            return '';
        }

        return $_res;
    }

    function init_trusted()
    {
        $ta = (array)explode(',', $this->get_config('trusted_authors'));
        $this->trusted_authors = array();

        foreach($ta AS $taidx => $authorid) {
            $this->trusted_authors[$authorid] = true;
        }
    }

    function set_config($name, $value, $implodekey = '^')
    {
        $fname = $this->instance . '/' . $name;

        if (is_array($value)) {
            $dbval = implode(',', $value);
        } else {
            $dbval = $value;
        }

        $_POST['serendipity']['plugin'][$name] = $dbval;

        $set = serendipity_set_config_var($fname, $dbval);
        $this->init_trusted();
        return $set;
    }

    function introspect_config_item($name, &$propbag)
    {
        switch ($name) {

            case 'trusted_authors':
                $propbag->add('type', 'content');
                $propbag->add('default', $this->getAuthors());
                break;

            case 'htmlpurifier':
                $propbag->add('type', 'boolean');
                $propbag->add('name', PLUGIN_XSSTRUST_HTMLPURIFIER);
                $propbag->add('description', PLUGIN_XSSTRUST_HTMLPURIFIER_DESC);
                $propbag->add('default', 'false');
                break;

            default:
                return false;
        }
        return true;
    }

    function recursive_purify(&$element, &$purifier)
    {
        if (is_array($element)) {
            foreach($element AS &$new_element) {
                $this->recursive_purify($new_element, $purifier);
            }
        } else {
            $element = $purifier->purify($element);
        }
    }

    function event_hook($event, &$bag, &$eventData, $addData = null)
    {
        global $serendipity;

        $hooks = &$bag->get('event_hooks');

        if (isset($hooks[$event])) {

            switch($event) {

                case 'backend_entry_presave':
                    if (serendipity_db_bool($this->get_config('htmlpurifier', 'false')) && !isset($this->trusted_authors[$serendipity['authorid']])) {
                        require_once dirname(__FILE__) . '/htmlpurifier-4.15.0-standalone/HTMLPurifier.standalone.php';
                        $config = HTMLPurifier_Config::createDefault();
                        $config->set('Cache.SerializerPath', $serendipity['serendipityPath'] . PATH_SMARTY_COMPILE);
                        $config->set('Core.Encoding', LANG_CHARSET);
                        $config->set('CSS.AllowImportant', true);
                        $purifier = new HTMLPurifier($config);

                        // We purify ALL THE STRINGS ! [because custom entry properties etc. should not be allowed to have invalid markup]
                        $this->recursive_purify($eventData, $purifier);
                    }
                    break;

                case 'backend_media_check':
                    // Do not allow active files
                    $plug = preg_match('@\.(html?|js)$@i', $addData);
                    if ($plug) {
                        $eventData = true;
                    }
                    break;

                case 'frontend_display':
                    if (!isset($this->trusted_authors[$eventData['authorid']]) && !serendipity_db_bool($this->get_config('htmlpurifier'))) {
                        // Not trusted.
                        #if (!empty($eventData['title'])) $eventData['title']    = htmlspecialchars($eventData['title']);
                        if (!empty($eventData['body'])) {
                            $eventData['body']     = htmlspecialchars(strip_tags($eventData['body']), ENT_COMPAT, LANG_CHARSET);
                        }
                        if (!empty($eventData['extended'])) {
                            $eventData['extended'] = htmlspecialchars(strip_tags($eventData['extended']), ENT_COMPAT, LANG_CHARSET);
                        }
                    } else {
                        // Trusted.
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