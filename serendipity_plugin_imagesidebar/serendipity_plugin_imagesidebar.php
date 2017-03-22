<?php

if (IN_serendipity !== true) {
    die ("Don't hack!");
}

@serendipity_plugin_api::load_language(dirname(__FILE__));

//WARNING!!!  HORRIBLY NON-STANDARD PLUGIN!!!!!
//This plugin extends the sidebar plugin class to add a simple framework for subplugins.

class subplug_sidebar
{
    var $changed = false;

    function __construct($setting_array = NULL)
    {
       if (is_array($setting_array)) {
           foreach ($setting_array AS $name => $value) {
               $this->value_array[$name] = $value;
           }
       }
    }

    function get_config($setting,$default = NULL)
    {
       if (isset($this->value_array[$setting])) {
           $setting = $this->value_array[$setting];
       } else {
           $setting=$default;
       }
       return $setting;
    }

    function set_config($setting,$value)
    {
       $this->value_array[$setting] = $value;
        if (!is_array($this->changed)) {
            $this->changed = array();
        }
        array_push($this->changed,$setting);
    }

    function cleanup_custom()
    {
        //void
    }

    //sometimes we update settings somewhere other than the admin screen
    function update_conf()
    {
        if (is_array($this->changed)) {
            foreach ($this->changed AS $name) {
                $setting_array[$name] = $this->value_array[$name];
            }
            return $setting_array;
        } else {
            return false;
        }
    }

}

class serendipity_plugin_imagesidebar extends serendipity_plugin
{
    var $title = PLUGIN_SIDEBAR_IMAGESIDEBAR_NAME;
    var $object_extend = '';

    function introspect(&$propbag)
    {
        $this->title = $this->get_config('title', $this->title);

        $propbag->add('name',          PLUGIN_SIDEBAR_IMAGESIDEBAR_NAME);
        $propbag->add('description',   PLUGIN_SIDEBAR_IMAGESIDEBAR_DESC . ' PLEASE NOTE: This plugin has been checked working with recent Serendipity installs for the Serendipity Media Library only. You will find limitations and old legacy code with at least the Menalto Gallery (dead project) and modern PHP using old MySQL extension code API calls.');
        $propbag->add('stackable',     true);
        $propbag->add('author',        'Andrew Brown (Menalto code), Matthew Groeninger (Unified/Media Lib. Code), Stefan Lange-Hegermann (Zooomr Code), Matthew Maude (Coppermine code), Ian');
        $propbag->add('version',       '1.11');
        $propbag->add('license',       'BSD');
        $propbag->add('requirements',  array(
            'serendipity' => '1.6',
            'smarty'      => '2.6.7',
            'php'         => '4.1.0'
        ));
        $propbag->add('groups', array('IMAGES'));

        //And now, off the beaten path.  Here we check to see if the configuration is being saved.  If so, lets just 'borrow' display_source so we can get the configuration right.
        if (isset($_POST['SAVECONF']) && serendipity_checkFormToken()) {
            $this->set_config('display_source', $_POST['serendipity']['plugin']['display_source']);
        }

        //Ok, now let's set the sub_plugin to the right one/ create the sub_plugin object.
        $this->object_extend = $this->create_sub_class(true);

        //add an array generated by 'set_configuration_array' to the propbag configuration.
        $config_array = $this->set_configuration_array ($this->object_extend);
        $propbag->add('configuration', $config_array);
    }

    //this function merges the configuration with the sub_plugin's configuration.
    function set_configuration_array ($object_extend = NULL)
    {
        $configuration_array = array('title','display_source');

        if (is_object($object_extend)) {
            $configuration_array = array_merge($configuration_array, $object_extend->introspect_custom());
        }
        return $configuration_array;
    }

    function introspect_config_item($name, &$propbag)
    {
        global $serendipity;

        switch($name) {
            case 'title':
                $propbag->add('type', 'string');
                $propbag->add('name', TITLE);
                $propbag->add('description', TITLE);
                $propbag->add('default', '');
                break;

            case 'display_source':
                $select["none"]       = PLUGIN_SIDEBAR_IMAGESIDEBAR_DISPLAYSRC_NONE;
                $select["menalto"]    = PLUGIN_SIDEBAR_IMAGESIDEBAR_DISPLAYSRC_MENALTO;
                $select["coppermine"] = PLUGIN_SIDEBAR_IMAGESIDEBAR_DISPLAYSRC_COPPERMINE;
                $select["medialib"]   = PLUGIN_SIDEBAR_IMAGESIDEBAR_DISPLAYSRC_MEDIALIB;
                $select["zooomr"]     = PLUGIN_SIDEBAR_IMAGESIDEBAR_DISPLAYSRC_ZOOOMR;
                $propbag->add('type', 'select');
                $propbag->add('name', PLUGIN_SIDEBAR_IMAGESIDEBAR_DISPLAYSRC_NAME);
                $propbag->add('description', PLUGIN_SIDEBAR_IMAGESIDEBAR_DISPLAYSRC_DESC);
                $propbag->add('select_values', $select);
                $propbag->add('default', 'none');
                break;

            default:
                break;
        }

        // normal until here... here we add the sub_plugins config array to the main plugin.
        if (is_object($this->object_extend)) {
            $this->object_extend->introspect_config_item_custom($name, $propbag);
        }

        return true;
    }

    /**
     * this function will create the right class object based on the main configuration setting.
     */
    function create_sub_class($full_object = true, $object_extend = NULL)
    {
        if ($full_object && !is_object($object_extend)) {
            $object_extend = $this->create_sub_class(false);
        }

        if (is_object($object_extend)) {
           $settings = $this->set_configuration_array($object_extend);
           foreach ($settings AS $name) {
              $setting_array[$name] = $this->get_config($name);
           }
        }

        switch ($this->get_config('display_source', 'none')) {
            case 'menalto':
                if (file_exists(dirname(__FILE__) . '/menalto_sidebar.php')) {
                    include_once dirname(__FILE__) . '/menalto_sidebar.php';
                }
                $showit = new menalto_sidebar($setting_array);
                break;

            case 'coppermine':
                if (file_exists(dirname(__FILE__) . '/coppermine_sidebar.php')) {
                    include_once dirname(__FILE__) . '/coppermine_sidebar.php';
                }
                $showit = new coppermine_sidebar($setting_array);
                break;

            case 'medialib':
                if (file_exists(dirname(__FILE__) . '/media_sidebar.php')) {
                    include_once dirname(__FILE__) . '/media_sidebar.php';
                }
                $showit = new media_sidebar ($setting_array);
                break;

            case 'zooomr':
                if (file_exists(dirname(__FILE__) . '/zooomr_sidebar.php')) {
                    include_once dirname(__FILE__) . '/zooomr_sidebar.php';
                }
                $showit = new zooomr_sidebar ($setting_array);
                break;

            default:
                $showit = '';
                break;
        }
        return $showit;
    }

    function generate_content(&$title)
    {
        global $serendipity;

        if (!is_object($this->object_extend)) {
            $this->object_extend = $this->create_sub_class(true);
            if (method_exists($this->object_extend, 'generate_content_custom')) {
                $this->object_extend->generate_content_custom($title);
            } else {
                $this->object_extend = $this->get_config('title', $this->title); // the display_source none selection is useless and this here only to avoid errors, since class and methods don't exist
            }
            $this->save_subconfig();
        }
    }

    function cleanup()
    {
        if (is_object($this->object_extend)) {
            $this->object_extend->cleanup_custom();
        }
        $this->save_subconfig();
        $this->object_extend = $this->create_sub_class(true, $this->object_extend);
    }

    function save_subconfig()
    {
        if (is_object($this->object_extend)) {
            $settings = $this->object_extend->update_conf();
        }
        if (is_array($settings)) {
            foreach ($settings AS $name => $value) {
                $this->set_config($name, $value);
            }
        }
    }

}

/* vim: set sts=4 ts=4 expandtab : */
?>