<?php

declare(strict_types=1);

if (IN_serendipity !== true) {
    die ("Don't hack!");
}

@serendipity_plugin_api::load_language(dirname(__FILE__));

class serendipity_event_youtube extends serendipity_event
{
    public $title = PLUGIN_EVENT_YOUTUBE_TITLE;

    function introspect(&$propbag)
    {
        global $serendipity;

        $propbag->add('name',          PLUGIN_EVENT_YOUTUBE_TITLE);
        $propbag->add('description',   PLUGIN_EVENT_YOUTUBE_DESC);
        $propbag->add('stackable',     false);
        $propbag->add('author',        'Garvin Hicking, Ian Styx');
        $propbag->add('requirements',  array(
            'serendipity' => '5.0',
            'smarty'      => '4.1',
            'php'         => '8.2.0'
        ));
        $propbag->add('version',       '2.0.1');
        $propbag->add('event_hooks',    array(
            'backend_entry_toolbar_extended' => true,
            'backend_entry_toolbar_body' => true,
            'backend_wysiwyg' => true,
        ));
        $propbag->add('groups', array('BACKEND_EDITOR'));
        $propbag->add('configuration', array('youtube_server', 'youtube_iframe', 'youtube_width', 'youtube_height', 'youtube_rel', 'youtube_border', 'youtube_color1', 'youtube_color2'));
        $propbag->add('legal',    array(
            'services' => array(
                'youtube' => array(
                    'url'  => 'https://www.youtube.com',
                    'desc' => 'Youtube.'
                ),
            ),
            'frontend' => array(
                'When Youtube videos are embedded, Google gets the request metadata (IP address, user agent) of the visitor.',
            ),
            'backend' => array(
            ),
            'cookies' => array(
                'Google can set tracking cookies for videos'
            ),
            'stores_user_input'     => false,
            'stores_ip'             => false,
            'uses_ip'               => false,
            'transmits_user_input'  => true
        ));
    }

    function generate_content(&$title)
    {
        $title = PLUGIN_EVENT_YOUTUBE_TITLE;
    }

    function introspect_config_item($name, &$propbag)
    {
        switch($name) {
            case 'youtube_server':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_EVENT_YOUTUBE_SERVER);
                $propbag->add('default',     'https://www.youtube.com/v/');
                break;

            case 'youtube_width':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_EVENT_YOUTUBE_WIDTH);
                $propbag->add('default',     '425');
                break;

            case 'youtube_height':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_EVENT_YOUTUBE_HEIGHT);
                $propbag->add('default',     '344');
                break;

            case 'youtube_rel':
                $propbag->add('type',        'boolean');
                $propbag->add('name',        PLUGIN_EVENT_YOUTUBE_REL);
                $propbag->add('default',     'true');
                break;

            case 'youtube_iframe':
                $propbag->add('type',        'boolean');
                $propbag->add('name',        PLUGIN_EVENT_YOUTUBE_IFRAME);
                $propbag->add('default',     'true');
                return true;
                break;

            case 'youtube_border':
                $propbag->add('type',        'boolean');
                $propbag->add('name',        PLUGIN_EVENT_YOUTUBE_BORDER);
                $propbag->add('default',     'false');
                break;

            case 'youtube_color1':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_EVENT_YOUTUBE_COLOR1);
                $propbag->add('default',     '0x3a3a3a');
                break;

            case 'youtube_color2':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_EVENT_YOUTUBE_COLOR2);
                $propbag->add('default',     '0x999999');
                break;

            default:
                return false;
        }
        return true;
    }

    function event_hook($event, &$bag, &$eventData, $addData = null)
    {
        global $serendipity;

        $hooks = &$bag->get('event_hooks');

        if (isset($hooks[$event])) {

            switch($event) {
                case 'backend_entry_toolbar_extended':
                    if (!isset($txtarea)) {
                        $txtarea = 'serendipity_textarea_extended';
                        $func    = 'extended';
                    }
                    // no break
                case 'backend_entry_toolbar_body':
                    if (!isset($txtarea)) {
                        if (isset($eventData['backend_entry_toolbar_body:textarea'])) {
                            // event caller has given us the name of the textarea converted
                            // into a WYSIWYG editor(for example, the staticpages plugin)
                            $txtarea = $eventData['backend_entry_toolbar_body:textarea'];
                        } else {
                            // default value
                            $txtarea = 'serendipity_textarea_body';
                        }
                        if (isset($eventData['backend_entry_toolbar_body:nugget'])) {
                            $func = $eventData['backend_entry_toolbar_body:nugget'];
                        } else{
                            $func = 'body';
                        }
                    }
                    // RT-EDITORs and plain text editor need this little switch
                    if (preg_match('/(nugget|quick)/i', $func)) {
                        $area_instance = $func;
                    } else {
                        $area_instance = $txtarea;
                    }

?>
<script type="text/javascript">
<!--
var youtube_server = '<?php echo $this->get_config('youtube_server'); ?>';
var youtube_width  = '<?php echo $this->get_config('youtube_width'); ?>';
var youtube_height = '<?php echo $this->get_config('youtube_height'); ?>';
var youtube_rel    = '<?php echo (serendipity_db_bool($this->get_config('youtube_rel', 'true')) ? '1' : '0'); ?>';
var youtube_border = '<?php echo (serendipity_db_bool($this->get_config('youtube_border', 'false')) ? '1' : '0'); ?>';
var youtube_color1 = '<?php echo $this->get_config('youtube_color1'); ?>';
var youtube_color2 = '<?php echo $this->get_config('youtube_color2'); ?>';
var youtube_iframe = '<?php echo (serendipity_db_bool($this->get_config('youtube_iframe')) ? '1' : '0'); ?>';

function use_text_<?php echo $func; ?>(item) {

    videoid = prompt('<?php echo PLUGIN_EVENT_YOUTUBE_ID; ?>', '');
    
    if (videoid == '') {
        return;
    }

    youtube_url = youtube_server + videoid + '&amp;fs=1&amp;rel=' + youtube_rel + '&amp;border=' + youtube_border + '&amp;color1=' + youtube_color1 + '&amp;color2=' + youtube_color2;
    if (youtube_border == 1) {
        youtube_width  += 20;
        youtube_height += 20;
    }

    if (youtube_iframe) {
        //item = "\n" + '<div class="youtube_player youtube_player_iframe"><iframe allow="encrypted-media" frameborder="0" height="' + youtube_height + '" src="https://www.youtube-nocookie.com/embed/' + videoid + '" width="' + youtube_width + '"><' + '/iframe></div>';
        item = '<div class="youtube_player youtube_player_iframe"><iframe allow="encrypted-media" frameborder="0" height="' + youtube_height + '" src="https://www.youtube-nocookie.com/embed/' + videoid + '" width="' + youtube_width + '"><' + '/iframe></div>';
    } else {
        item = "\n" + '<div class="youtube_player"><object width="' + youtube_width + '" height="' + youtube_height + '">'
            + '<param name="movie" value="' + youtube_url + '"></param>'
            + '<param name="allowFullScreen" value="true"></param>'
            + '<param name="allowscriptaccess" value="always">'
            + '</param>'
            + '<embed src="' + youtube_url + '" type="application/x-shockwave-flash" '
            + '  allowscriptaccess="always" allowfullscreen="true" width="' + youtube_width + '" height="' + youtube_height + '">'
            + '</embed></object></div>'
            + '<noscript><a href="https://www.youtube.com/watch?v='+ videoid + '"></a></noscript>'
            + "\n";
    }

    const use_youtube = 'use_youtube<?php echo $func; ?>';
    const instance = '<?php echo $area_instance; ?>';

    // works on both: enableBackendPopup or MFP- layer
    window[use_youtube] = function (item) {
        try {
            // both do...
            tinyMCE.execInstanceCommand(instance, 'mceInsertContent', false, item);
            //serendipity.serendipity_imageSelector_addToBody(item, instance);
        } catch(ex0) {
          try {
            window.parent.parent.serendipity.serendipity_imageSelector_addToBody(item, instance);
            window.parent.parent.$.magnificPopup.close();
          } catch (ex1) {
            self.opener.serendipity.serendipity_imageSelector_addToBody(item, instance);
            self.close();
          }
        } finally {
            //console.log(item);console.log(instance);
        }
    }
    if (item) use_youtube<?php echo $func; ?>(item); // normally already placed in eventData['buttons'] but used here since this is a JS popup
}
//-->
</script>
<?php
                    if ($serendipity['wysiwyg'] === false) {
                        echo '<a class="serendipityPrettyButton serendipityExtButton" href="javascript:use_text_' . $func . '()" title="' . PLUGIN_EVENT_YOUTUBE_BUTTON . '"><input class="input_button" name="serendipity[addYouTubeID]" value="' . PLUGIN_EVENT_YOUTUBE_BUTTON . '" type="button"></a>&nbsp;';
                    }
                    break;

                case 'backend_wysiwyg':
                    // Due to 'backend_entry_toolbar_body' placed js snippet, except entry form textareas and staticpage with custom|responsive template, don't run in nuggets or plugins where it misses
                    if (!preg_match('/(nugget|quick)/i', $eventData['item']) || preg_match('/(nuggets15|nuggets51)/i', $eventData['item'])) {
                        $open = 'use_text_'.str_replace('serendipity_textarea_', '', $eventData['item']);
                        $eventData['buttons'][] = array(
                            'id'         => 'youtube' . $eventData['item'],
                            'name'       => PLUGIN_EVENT_YOUTUBE_TITLE,
                            'javascript' => 'function() { '.$open.'() }',
                            'js_popup'   => true,
                            'svg'        => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-youtube" viewBox="0 0 16 16"><path d="M8.051 1.999h.089c.822.003 4.987.033 6.11.335a2.01 2.01 0 0 1 1.415 1.42c.101.38.172.883.22 1.402l.01.104.022.26.008.104c.065.914.073 1.77.074 1.957v.075c-.001.194-.01 1.108-.082 2.06l-.008.105-.009.104c-.05.572-.124 1.14-.235 1.558a2.01 2.01 0 0 1-1.415 1.42c-1.16.312-5.569.334-6.18.335h-.142c-.309 0-1.587-.006-2.927-.052l-.17-.006-.087-.004-.171-.007-.171-.007c-1.11-.049-2.167-.128-2.654-.26a2.01 2.01 0 0 1-1.415-1.419c-.111-.417-.185-.986-.235-1.558L.09 9.82l-.008-.104A31 31 0 0 1 0 7.68v-.123c.002-.215.01-.958.064-1.778l.007-.103.003-.052.008-.104.022-.26.01-.104c.048-.519.119-1.023.22-1.402a2.01 2.01 0 0 1 1.415-1.42c.487-.13 1.544-.21 2.654-.26l.17-.007.172-.006.086-.003.171-.007A100 100 0 0 1 7.858 2zM6.4 5.209v4.818l4.157-2.408z"/></svg>',
// no need when we have css_backend hook. Else use this
                            'css'        => '.tox .tox-tbtn svg.bi.bi-youtube { fill: #25f8f8; background: repeating-radial-gradient(black, #fff); }[data-color-mode="dark"] .tox .tox-tbtn svg.bi.bi-youtube { fill: #25f8f8; background: unset; }',
                            'toolbar'    => 'other'
                        );
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