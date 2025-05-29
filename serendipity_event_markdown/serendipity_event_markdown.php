<?php

use \Michelf\Markdown, \Michelf\MarkdownExtra, \Michelf\SmartyPants, \Michelf\SmartyPantsTypographer;

if (IN_serendipity !== true) {
    die ("Don't hack!");
}

@serendipity_plugin_api::load_language(dirname(__FILE__));

class serendipity_event_markdown extends serendipity_event
{
    var $title = PLUGIN_EVENT_MARKDOWN_NAME;

    function introspect(&$propbag)
    {
        global $serendipity;

        $propbag->add('name',          PLUGIN_EVENT_MARKDOWN_NAME);
        $propbag->add('description',   PLUGIN_EVENT_MARKDOWN_DESC);
        $propbag->add('stackable',     false);
        $propbag->add('author',        'Serendipity Team and Jan Lehnardt, Ian Styx');
        $propbag->add('requirements',  array(
            'serendipity' => '2.0',
            'smarty'      => '3.1',
            'php'         => '7.4'
        ));
        $propbag->add('version',       '1.44');
        $propbag->add('cachable_events', array('frontend_display' => true));
        $propbag->add('event_hooks',   array(
            'backend_entryform' => true,
            'backend_configure' => true,
            'frontend_display'  => true,
            'frontend_comment'  => true,
            'css'               => true
        ));
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
        $conf_array[] = 'MARKDOWN_EXTRA';
        $conf_array[] = 'MARKDOWN_SMARTYPANTS';

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
        switch($name) {
            case 'ENTRY_BODY':
            case 'EXTENDED_BODY':
            case 'COMMENT':
            case 'HTML_NUGGET':
                $propbag->add('type',        'boolean');
                $propbag->add('name',        constant($name));
                $propbag->add('description', sprintf(APPLY_MARKUP_TO, constant($name)));
                $propbag->add('default',     'true');
                break;

            case 'MARKDOWN_EXTRA':
                $propbag->add('type',        'boolean');
                $propbag->add('name',        PLUGIN_EVENT_MARKDOWN_EXTRA_NAME);
                $propbag->add('description', PLUGIN_EVENT_MARKDOWN_EXTRA_DESC);
                $propbag->add('default',     'false');
                break;

            case 'MARKDOWN_SMARTYPANTS':
                $propbag->add('type',        'radio');
                $propbag->add('name',        PLUGIN_EVENT_MARKDOWN_SMARTYPANTS_NAME);
                $propbag->add('description', PLUGIN_EVENT_MARKDOWN_SMARTYPANTS_DESC);
                $propbag->add('radio',       array(
                                                'value' => array(1, 2, 0),
                                                'desc'  => array(PLUGIN_EVENT_MARKDOWN_SMARTYPANTS, PLUGIN_EVENT_MARKDOWN_SMARTYPANTS_EXTENDED, PLUGIN_EVENT_MARKDOWN_SMARTYPANTS_NEVER)
                                             ));
                $propbag->add('default',     0);
                break;

            default:
                return false;
        }
        return true;
    }

    function example()
    {
        return '<span class="msg_hint"><span class="icon-attention-circled" aria-hidden="true"></span> ' . PLUGIN_EVENT_MARKDOWN_ATTENT_NOTE . '</span>';
    }

    function event_hook($event, &$bag, &$eventData, $addData = null)
    {
        global $serendipity;
        static $strict = null;

        $mdsp = $this->get_config('MARKDOWN_SMARTYPANTS');
        $mdex = serendipity_db_bool($this->get_config('MARKDOWN_EXTRA', 'false'));

        if ($mdex) {
            require_once dirname(__FILE__) . '/lib/Michelf/MarkdownExtra.inc.php';
        } else {
            require_once dirname(__FILE__) . '/lib/Michelf/Markdown.inc.php';
        }
        if ($mdsp > 0) {
            require_once dirname(__FILE__) . '/lib/Michelf/SmartyPants.php';
        }
        if ($mdsp == 2) {
            require_once dirname(__FILE__) . '/lib/Michelf/SmartyPantsTypographer.php';
        }

        if ($strict === null) {
            $strict = $serendipity['strict_markup_editors'] ?? true; // override per manually set user (local) config var
        }

        $hooks = &$bag->get('event_hooks');

        if (isset($hooks[$event])) {
            switch($event) {
                case 'backend_entryform':
                case 'backend_configure':
                    if ($strict) {
                        $serendipity['pdata']['markupeditor'] = $eventData['markupeditor'] = true;
                    }
                    // We don't want users to provide two active concurrent markup plugins. Without throwing a notice make it notable that the user has them installed!
                    if (!empty($eventData['markupeditortype'])) {
                        $serendipity['pdata']['markupeditortype'] = $eventData['markupeditortype'] .= ' <span title="Having 2 concurrent markup plugins active is not recommended!" class="icon-attention-circled alertinfo" aria-hidden="true"></span> <a href="https://daringfireball.net/projects/markdown/syntax" target="_blank">Markdown</a>';
                    } else {
                        $serendipity['pdata']['markupeditortype'] = $eventData['markupeditortype'] = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-arrow-up-right" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M8.636 3.5a.5.5 0 0 0-.5-.5H1.5A1.5 1.5 0 0 0 0 4.5v10A1.5 1.5 0 0 0 1.5 16h10a1.5 1.5 0 0 0 1.5-1.5V7.864a.5.5 0 0 0-1 0V14.5a.5.5 0 0 1-.5.5h-10a.5.5 0 0 1-.5-.5v-10a.5.5 0 0 1 .5-.5h6.636a.5.5 0 0 0 .5-.5z"/><path fill-rule="evenodd" d="M16 .5a.5.5 0 0 0-.5-.5h-5a.5.5 0 0 0 0 1h3.793L6.146 9.146a.5.5 0 1 0 .708.708L15 1.707V5.5a.5.5 0 0 0 1 0v-5z"/><title>External link(s)</title></svg> ' . PLUGIN_EVENT_MARKDOWN_TRANSFORM;
                    }
                    break;

                case 'frontend_display':

                    foreach ($this->markup_elements AS $temp) {
                        if (serendipity_db_bool($this->get_config($temp['name'], 'true')) && !empty($eventData[$temp['element']])
                        && (!isset($eventData['properties']['ep_disable_markup_' . $this->instance]) || !$eventData['properties']['ep_disable_markup_' . $this->instance])
                        && !isset($serendipity['POST']['properties']['disable_markup_' . $this->instance])) {
                            $element = $temp['element'];

                            if ($element == 'comment' && isset($eventData['comment'])) {
                                $_comment = $eventData['comment']; // the comment "body" IN data copy to compare to (see below)
                            }

                            # HTML special chars like ">" in comments may have been replaced by entities ("&gt;")
                            # by serendipity_event_unstrip_tags; we have to - partially - undo that, as ">" is
                            # used for blockquotes in Markdown.
                            # The regexp will only match "&gt;" preceded by the start of the line or another "&gt;",
                            # both optionally followed by whitespace.
                            if ($element == 'comment' && (is_array($addData) && isset($addData['comment_escaped']))) {
                                $eventData[$element] = preg_replace('/(^|(?<=&gt;))\s*&gt;/m', '>', $eventData[$element]);
                            }
                            if ($mdex) {
                                $eventData[$element] = str_replace('javascript:', '', MarkdownExtra::defaultTransform($eventData[$element]));
                            } else {
                                $eventData[$element] = str_replace('javascript:', '', Markdown::defaultTransform($eventData[$element]));
                            }
                            if ($mdsp == 1) $eventData[$element] = SmartyPants::defaultTransform($eventData[$element]);
                            if ($mdsp == 2) $eventData[$element] = SmartyPantsTypographer::defaultTransform($eventData[$element]);

                            if (isset($_comment) && $_comment !== $eventData['comment']) {
                                // no escape parsing, since changed
                                $eventData['dismark'] = true;
                            }
                        }
                    }
                    if (is_array($eventData)) {
                        $this->setPlaintextBody($eventData, $mdex, $mdsp);
                    }
                    break;

                case 'frontend_comment':
                    // eventData allow_comments variable is only available in single page view commentform (not in eg. adduser sidebar)
                    if (serendipity_db_bool($this->get_config('COMMENT', 'true')) && !empty($eventData['allow_comments'])) {
                        echo '                                <div class="serendipity_commentDirection serendipity_comment_markdown">' . PLUGIN_EVENT_MARKDOWN_TRANSFORM . '</div>';
                    }
                    break;

                case 'css':
                    if (false === strpos($eventData, '.footnotes')) {
                        $eventData .= '

/* Footnotes (generated by serendipity_event_markdown) */

a.footnote-ref:after {
    content: ")";
}

.footnotes hr {
    border-top: dashed #cccccc;
    border-width: 1px;
}

/* mostly taken from http://www.456bereastreet.com/archive/201105/styling_ordered_list_numbers/ */
.footnotes ol {
    counter-reset: li;
    margin-top: 0.2em;
    margin-left: 1.5em;
    padding-left: 0;
}
.footnotes ol > li {
    list-style: none;
    position: relative;
    padding-left: 0.5em;
    font-size: 90%;
}
.footnotes ol > li:before {
    content: counter(li)")";
    counter-increment: li;
    position: absolute;
    left: -2em;
    top: -0.1em;
    width: 2em;
    text-align: right;
    font-size: 80%;
    font-weight: bold;
}

/* --- end of Footnotes */

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

    /**
     * Sets a GLOBAL plaintext body by first transforming the body to HTML, then stripping HTML tags from the body
     * @see http://board.s9y.org/viewtopic.php?f=11&t=18351 Discussion of this feature in the S9y forum.
     *
     * @param array $eventData
     * @param bool  $extra      Markdown Extra           default false
     * @param int   $version    Markdown Classic or Lib  default 2
     * @param int   $pants      SmartyPants option       default 0
     * @return      $GLOBALS['entry'][0]['plaintext_body']
     */
    function setPlaintextBody(array $eventData, $extra=false, $pants=0)
    {
        if (isset($GLOBALS['entry'][0]['plaintext_body'])) {
            $plaintext_body = $GLOBALS['entry'][0]['plaintext_body'];
        } else {
            if (!isset($eventData['body'])) return;
            $plaintext_body = html_entity_decode($eventData['body'], ENT_COMPAT, LANG_CHARSET);
        }

        if ($extra) {
            $html = MarkdownExtra::defaultTransform($plaintext_body);
        } else {
            $html = Markdown::defaultTransform($plaintext_body);
        }

        if ($pants > 0) $html = ($pants == 2) ? SmartyPantsTypographer::defaultTransform($html) : SmartyPants::defaultTransform($html);
        $GLOBALS['entry'][0]['plaintext_body'] = trim(strip_tags(str_replace('javascript:', '', $html)));
    }

    /* disabled, probably used in later versions
    function _markdown_markup($text) {
        return Markdown($text);
    }
    */

}

?>