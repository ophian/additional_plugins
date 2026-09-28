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
            'php'         => '8.2'
        ));
        $propbag->add('version',       '2.3.0');
        $propbag->add('event_hooks',    array(
            'backend_entry_toolbar_extended' => true,
            'backend_entry_toolbar_body' => true,
            'js_backend' => true,
            'backend_wysiwyg' => true
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

                    if ($serendipity['wysiwyg'] === false) {
                        echo '<a class="serendipityPrettyButton serendipityExtButton" href="javascript:use_text_' . $func . '()" title="' . PLUGIN_EVENT_YOUTUBE_BUTTON . '"><input class="input_button" name="serendipity[addYouTubeID]" value="' . PLUGIN_EVENT_YOUTUBE_BUTTON . '" type="button"></a>&nbsp;';
                    }
                    break;

                case 'js_backend':
                    // Pre-calculate configuration variables
                    $yt_server   = addslashes($this->get_config('youtube_server'));
                    $yt_width    = (int)$this->get_config('youtube_width', 560);
                    $yt_height   = (int)$this->get_config('youtube_height', 315);
                    $yt_rel      = serendipity_db_bool($this->get_config('youtube_rel', 'true')) ? '1' : '0';
                    $yt_border   = serendipity_db_bool($this->get_config('youtube_border', 'false')) ? '1' : '0';
                    $yt_color1   = addslashes($this->get_config('youtube_color1'));
                    $yt_color2   = addslashes($this->get_config('youtube_color2'));
                    $yt_iframe   = serendipity_db_bool($this->get_config('youtube_iframe', 'true')) ? 'true' : 'false';
                    $yt_prompt   = addslashes(PLUGIN_EVENT_YOUTUBE_ID);

                    // Append JS payload directly to $eventData instead of echoing to avoid Headers already sent problems
                    $eventData .= "
/* YouTube Plugin Scriptlet Start */

(() => {

    'use strict';

    // Configuration
    const ytConfig = {
        server: '{$yt_server}',
        width: {$yt_width},
        height: {$yt_height},
        rel: {$yt_rel},
        border: {$yt_border},
        color1: '{$yt_color1}',
        color2: '{$yt_color2}',
        useIframe: {$yt_iframe}
    };

    /**
     * Extracts a YouTube Video ID even if a full URL was entered.
     * @param {string} input
     * @returns {string|null}
     */
    const parseVideoId = (input) => {
        if (!input) return null;
        const trimmed = input.trim();
        const regExp = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=)([^#\&\?]*).*/;
        const match = trimmed.match(regExp);
        return (match && match[2].length === 11) ? match[2] : trimmed;
    };

    /**
     * Register insertion handlers for a given suffix & target textarea instance
     * @param {string} funcSuffix (e.g. 'body', 'extended', 'nugget')
     * @param {string} instance (e.g. 'serendipity_textarea_body')
     */
    const registerYouTubeHandler = (funcSuffix, instance) => {

        const useYoutubeHandler = function(itemToInsert) {
            try {
                // 1. Try direct TinyMCE Command
                if (typeof tinyMCE !== 'undefined' && tinyMCE.execInstanceCommand) {
                    tinyMCE.execInstanceCommand(instance, 'mceInsertContent', false, itemToInsert);
                    return;
                }
                throw new Error('TinyMCE not available directly, attempting fallback.');
            } catch (ex0) {
                try {
                    // Resolve best available parent/top window context
                    const targetWin = window.parent?.parent || window.parent || window;

                    // 1. Insert content into editor via Serendipity standard callback
                    if (targetWin.serendipity?.serendipity_imageSelector_addToBody) {
                        targetWin.serendipity.serendipity_imageSelector_addToBody(itemToInsert, instance);
                    }

                    // 2. Close Overlay (Styx Modal OR Legacy MagnificPopup)
                    if (typeof targetWin.serendipity?.closeMediaModal === 'function') {
                        targetWin.serendipity.closeMediaModal();
                    } else if (typeof targetWin.StyxModalInstance?.close === 'function') {
                        targetWin.StyxModalInstance.close();
                    } else if (targetWin.$?.magnificPopup) {
                        targetWin.$.magnificPopup.close();
                    }
                } catch (ex1) {
                    // Legacy Browser Popup Fallback (window.open)
                    if (self.opener?.serendipity) {
                        self.opener.serendipity.serendipity_imageSelector_addToBody(itemToInsert, instance);
                        self.close();
                    }
                }
            }
        };

        // Assign `use_youtube_{suffix}` to window
        window[`use_youtube\${funcSuffix}`] = useYoutubeHandler;

        // Assign `use_text_{suffix}` to window
        window[`use_text_\${funcSuffix}`] = function(presetItem) {
            let rawInput = prompt('{$yt_prompt}', '');
            if (!rawInput) return;

            const videoId = parseVideoId(rawInput);
            if (!videoId) return;

            let width = ytConfig.width;
            let height = ytConfig.height;

            if (ytConfig.border === 1) {
                width += 20;
                height += 20;
            }

            const embedUrl = `https://www.youtube-nocookie.com/embed/\${videoId}?rel=\${ytConfig.rel}`;
            const generatedItem = `<div class=\"youtube_player youtube_player_iframe\"><iframe src=\"\${embedUrl}\" width=\"\${width}\" height=\"\${height}\" frameborder=\"0\" allow=\"accelerated-execution; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture\" allowfullscreen loading=\"lazy\"></iframe></div>`;

            const finalMarkup = presetItem || generatedItem;
            if (finalMarkup) {
                useYoutubeHandler(finalMarkup);
            }
        };
    };

    // Register all active instances directly
    const instances = [
        { suffix: 'body', instance: 'serendipity_textarea_body' },
        { suffix: 'extended', instance: 'serendipity_textarea_extended' },
        { suffix: 'nugget', instance: 'nugget' },
        { suffix: 'quick', instance: 'quick' },
        { suffix: 'nuggets15', instance: 'nuggets15' },
        { suffix: 'nuggets51', instance: 'nuggets51' }
    ];

    instances.forEach(item => registerYouTubeHandler(item.suffix, item.instance));
})();

/* YouTube Plugin Scriptlet End */
\n";
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