<?php

declare(strict_types=1);

if (IN_serendipity !== true) {
    die ("Don't hack!");
}

@serendipity_plugin_api::load_language(dirname(__FILE__));

class serendipity_event_flickrcss extends serendipity_event
{
    function introspect(&$propbag)
    {
        $propbag->add('name',        PLUGIN_EVENT_FLICKRCSS);
        $propbag->add('description', PLUGIN_EVENT_FLICKRCSS_DESC);
        $propbag->add('stackable',   false);
        $propbag->add('author',      'Michael Kaiser, Ian Styx');
        $propbag->add('version',        '2.0.0');
        $propbag->add('requirements',   array(
            'serendipity' => '5.0',
            'smarty'      => '4.1',
            'php'         => '8.2'
        ));
        $propbag->add('groups', array('FRONTEND_EXTERNAL_SERVICES'));
        $propbag->add('event_hooks', array(
            'css'    => true
        ));


        // Register (multiple) dependencies. KEY is the name of the depending plugin. VALUE is a mode of either 'remove' or 'keep'.
        // If the mode 'remove' is set, removing the plugin results in a removal of the depending plugin. 'Keep' means to
        // not touch the depending plugin.
        $this->dependencies = array('serendipity_plugin_flickr' => 'remove');
    }


    function generate_content(&$title)
    {
        $title = PLUGIN_EVENT_FLICKRCSS;
    }

    function event_hook($event, &$bag, &$eventData, $addData = null)
    {
        global $serendipity;
        
        $hooks = &$bag->get('event_hooks');

        if (isset($hooks[$event])) {
            switch($event) {
                case 'css':
                    if (strpos($eventData, 'serendipity_plugin_flickr') !== FALSE) {
                        // class exists in CSS, so a user has customized it and we don't need default
                        return true;
                    }
                    $this->addToCSS($eventData);
                    break;

                default:
                    return false;
            }
            return true;
        }
        else {
            return false;
        }
    }
    
    function addToCSS(&$eventData)
    {
        $eventData .= '

/* serendipity_event_flickrcss start*/

dl.serendipity_plugin_flickr  {
    text-align:center; font-size:9px;
    }
dl.serendipity_plugin_flickr img {
    border: none;
    }
.serendipity_plugin_flickr dd {
    margin: 0; padding: 0;
    margin-bottom: 5px;
    margin-right: 5px;
    float:left;
    }
.serendipity_plugin_flickr dt {
    margin: 0; padding: 0;
    float:left;
    color: #444;
    background-color: #fff;
    font-weight: bold;
    overflow: hidden;
    visibility: hidden;
    filter: alpha(opacity=70); /* internet explorer */
    -khtml-opacity: 0.7;      /* khtml, old safari */
    -moz-opacity: 0.7;       /* mozilla, netscape */
    opacity: 0.7;           /* fx, safari, opera */
    }
.serendipity_plugin_flickr dt:hover, .serendipity_plugin_flickr dd:hover+dt {
    visibility: visible;
    border-top: 1px solid #aaa;
    border-bottom: 1px solid #444;
    }
.serendipity_plugin_flickr_date {
    display: block;
    font-weight: normal;
    color: #444;
}
.serendipity_plugin_flickr_title {
    display: block;
    font-weight: bold;
    color: #000;
}
.serendipity_plugin_flickr_links {
    clear: both;
}
.serendipity_plugin_flickr_errors {
    color: #fff;
    background-color: #600;
}

/* serendipity_event_flickrcss start*/

';
    }

}

/* vim: set sts=4 ts=4 expandtab : */
?>