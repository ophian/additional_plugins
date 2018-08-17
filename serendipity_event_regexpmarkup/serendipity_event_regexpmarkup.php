<?php

if (IN_serendipity !== true) {
    die ("Don't hack!");
}

@serendipity_plugin_api::load_language(dirname(__FILE__));

class serendipity_event_regexpmarkup extends serendipity_event
{
    var $title = PLUGIN_EVENT_REGEXPMARKUP_NAME;

    function introspect(&$propbag)
    {
        global $serendipity;

        $propbag->add('name',          PLUGIN_EVENT_REGEXPMARKUP_NAME);
        $propbag->add('description',   PLUGIN_EVENT_REGEXPMARKUP_DESC);
        $propbag->add('stackable',     false);
        $propbag->add('author',        'Rob Antonishen');
        $propbag->add('version',       '1.0');
        $propbag->add('requirements',  array(
            'serendipity' => '2.0',
            'smarty'      => '3.1.0',
            'php'         => '5.3.0'
        ));
        $propbag->add('cachable_events', array('frontend_display' => true));
        $propbag->add('event_hooks',   array('frontend_display' => true));
        $propbag->add('groups', array('MARKUP'));

        $this->markup_elements = array(
            array(
              'name'     => 'ENTRY_BODY',
              'element'  => 'body',
            ),
            array(
              'name'     => 'EXTENDED_BODY',
              'element'  => 'extended',
            ),
            array(
              'name'     => 'COMMENT',
              'element'  => 'comment',
            ),
            array(
              'name'     => 'HTML_NUGGET',
              'element'  => 'html_nugget',
            )
        );

        $conf_array = array();
        foreach($this->markup_elements as $element) {
            $conf_array[] = $element['name'];
        }
        $propbag->add('configuration', $conf_array);
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

    function generate_content(&$title)
    {
        $title = $this->title;
    }

    function introspect_config_item($name, &$propbag)
    {
        $propbag->add('type',        'boolean');
        $propbag->add('name',        constant($name));
        $propbag->add('description', sprintf(APPLY_MARKUP_TO, constant($name)));
        $propbag->add('default', 'true');
        return true;
    }

    function event_hook($event, &$bag, &$eventData, $addData = null)
    {
        global $serendipity;

        $hooks = &$bag->get('event_hooks');

        if (isset($hooks[$event])) {
            switch($event) {
              case 'frontend_display':

                foreach ($this->markup_elements as $temp) {
                    if (serendipity_db_bool($this->get_config($temp['name'], true)) && isset($eventData[$temp['element']]) &&
                            @!$eventData['properties']['ep_disable_markup_' . $this->instance] &&
                            !isset($serendipity['POST']['properties']['disable_markup_' . $this->instance])) {
                        $element = $temp['element'];
                        $this->markup($eventData[$element]);
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

    function markup(&$messagetext)
	{
	    static $regex = null;

	    if ($regex == null) {
            $modulepath = dirname(__FILE__) . '/regexps/';

    		$regex['SearchArray']  = array();
    		$regex['ReplaceArray'] = array();

    		$last_ts = filemtime($modulepath);
    		if ($last_ts > $this->get_config('last_ts', 0)) {
                $fp = opendir($modulepath);
                while ($file = readdir($fp)) {
                    if ($file != "." && $file != "..") {
                        if (file_exists($modulepath . $file) && !is_dir($modulepath . $file)) {
                          include $modulepath.$file;

                          foreach($regexpArray['SearchArray'] as $searchexp) {
                            $regex['SearchArray'][] = $searchexp;
                          }

                          foreach($regexpArray['ReplaceArray'] as $replaceexp) {
                            $regex['ReplaceArray'][] = $replaceexp;
                          }
                        } //fi
                    } //fi
                } //while
                closedir($fp);

                $this->set_config('last_ts', $last_ts);
                $this->set_config('searchArray', serialize($regex['SearchArray']));
                $this->set_config('replaceArray', serialize($regex['ReplaceArray']));
            } else {
                $regex['SearchArray']  = unserialize($this->get_config('searchArray'));
                $regex['ReplaceArray'] = unserialize($this->get_config('replaceArray'));
            }
        }

		$messagetext = preg_replace($regex['SearchArray'], $regex['ReplaceArray'], $messagetext);

		return true;
	}

}

?>