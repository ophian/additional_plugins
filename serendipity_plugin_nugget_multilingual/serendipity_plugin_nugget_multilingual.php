<?php

declare(strict_types=1);

if (IN_serendipity !== true) {
    die ("Don't hack!");
}

@serendipity_plugin_api::load_language(dirname(__FILE__));

class serendipity_plugin_nugget_multilingual extends serendipity_plugin
{
    public $title = PLUGIN_NUGGET_MULTI_NAME;

    function introspect(&$propbag)
    {
        $this->title = $this->get_config('title', $this->title);
        $propbag->add('name',          PLUGIN_NUGGET_MULTI_NAME);
        $propbag->add('description',   PLUGIN_NUGGET_MULTI_DESC);
        $propbag->add('stackable',     true);
        $propbag->add('author',        'Wesley Hwang-Chung');
        $propbag->add('requirements',  array(
            'serendipity' => '5.0',
            'smarty'      => '4.1',
            'php'         => '8.2'
        ));

        $propbag->add('version',       '2.0.0');
        $propbag->add('configuration', array('language', 'title', 'content', 'markup', 'show_where'));
        $propbag->add('groups',        array('FRONTEND_VIEWS'));

        $this->protected = TRUE; // If set to TRUE, only allows the owner of the plugin to modify its configuration
    }

    function introspect_config_item($name, &$propbag)
    {
        switch($name) {

            case 'language':
                $propbag->add('type',           'select');
                $propbag->add('name',           PLUGIN_NUGGET_MULTI_LANG);
                $propbag->add('select_values',  $this->getLanguages());
                $propbag->add('default',        LANG_ALL);
                break;

            case 'title':
                $propbag->add('type',        'string');
                $propbag->add('name',        TITLE);
                $propbag->add('description', TITLE_FOR_NUGGET);
                $propbag->add('default',     '');
                break;

            case 'content':
                $propbag->add('type',        'html');
                $propbag->add('name',        CONTENT);
                $propbag->add('description', THE_NUGGET);
                $propbag->add('default',     '');
                break;

            case 'markup':
                $propbag->add('type',        'boolean');
                $propbag->add('name',        DO_MARKUP);
                $propbag->add('description', DO_MARKUP_DESCRIPTION);
                $propbag->add('default',     'true');
                break;

            case 'show_where':
                $select = array('extended' => PLUGIN_ITEM_DISPLAY_EXTENDED, 'overview' => PLUGIN_ITEM_DISPLAY_OVERVIEW, 'both' => PLUGIN_ITEM_DISPLAY_BOTH);
                $propbag->add('type',        'select');
                $propbag->add('select_values', $select);
                $propbag->add('name',        PLUGIN_ITEM_DISPLAY);
                $propbag->add('default',     'both');
                break;

            default:
                return false;
        }
        return true;
    }

    /**
     * Get Serendipity languages
     *
     * @access  private
     * @return  array
     */
    function getLanguages()
    {
        global $serendipity;

        $lang['all'] = LANG_ALL;
        $lang = array_merge($lang, $serendipity['languages']);
        return $lang;
    }

    function generate_content(&$title)
    {
        global $serendipity;

        $title = $this->get_config('title');
        $language = $this->get_config('language', 'all');
        $show_where = $this->get_config('show_where', 'both');

        // if the language does not match, do not display
        if ($language != 'all' && $serendipity['lang'] != $language) {
            return false;
        }
        // where to show
        if ($show_where == 'extended' && (!isset($serendipity['GET']['id']) || !is_numeric($serendipity['GET']['id']))) {
            return false;
        } else if ($show_where == 'overview' && isset($serendipity['GET']['id']) && is_numeric($serendipity['GET']['id'])) {
            return false;
        }

        // apply markup?
        if (serendipity_db_bool($this->get_config('markup', 'true'))) {
            // This is the only workable solution for (sidebar?) plugins, to explicitly allow to apply nl2br plugin changes to markup (if we want to),
            $serendipity['POST']['properties']['disable_markups'] = array(false); // since in_array() expects 2cd param to be an array
            $entry = array('html_nugget' => $this->get_config('content'));
            serendipity_plugin_api::hook_event('frontend_display', $entry);
            echo $entry['html_nugget'];
        } else {
            echo $this->get_config('content');
        }
    }

}

?>