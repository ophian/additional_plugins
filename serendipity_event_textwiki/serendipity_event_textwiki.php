<?php

declare(strict_types=1);

if (IN_serendipity !== true) {
    die ("Don't hack!");
}

@serendipity_plugin_api::load_language(dirname(__FILE__));

class serendipity_event_textwiki extends serendipity_event
{

    var $wikiRules  = array(
        'prefilter' => array(
            'file' => 'Text/Wiki/Parse/Default/Prefilter.php',
            'name' => 'Text_Wiki_Rule_prefilter',
            'flag' => true,
            'conf' => array(),
            'desc' => PLUGIN_EVENT_TEXTWIKI_RULE_DESC_PREFILETER
        ),

        'delimiter' => array(
            'file' => 'Text/Wiki/Parse/Default/Delimiter.php',
            'name' => 'Text_Wiki_Rule_delimiter',
            'flag' => true,
            'conf' => array(),
            'desc' => PLUGIN_EVENT_TEXTWIKI_RULE_DESC_DELIMITER
        ),

        'code' => array(
            'file' => 'Text/Wiki/Parse/Default/Code.php',
            'name' => 'Text_Wiki_Rule_code',
            'flag' => true,
            'conf' => array(),
            'desc' => PLUGIN_EVENT_TEXTWIKI_RULE_DESC_CODE
        ),

        'phpcode' => array(
            'file' => 'Text/Wiki/Parse/Default/Phpcode.php',
            'name' => 'Text_Wiki_Rule_phpcode',
            'flag' => true,
            'conf' => array(),
            'desc' => PLUGIN_EVENT_TEXTWIKI_RULE_DESC_PHPCODE
        ),

        'html' => array(
            'file' => 'Text/Wiki/Parse/Default/Html.php',
            'name' => 'Text_Wiki_Rule_html',
            'flag' => false,
            'conf' => array(),
            'desc' => PLUGIN_EVENT_TEXTWIKI_RULE_DESC_HTML
        ),

        'raw' => array(
            'file' => 'Text/Wiki/Parse/Default/Raw.php',
            'name' => 'Text_Wiki_Rule_raw',
            'flag' => true,
            'conf' => array(),
            'desc' => PLUGIN_EVENT_TEXTWIKI_RULE_DESC_RAW
        ),

        'include' => array(
            'file' => 'Text/Wiki/Parse/Default/Include.php',
            'name' => 'Text_Wiki_Rule_include',
            'flag' => false,
            'conf' => array(
                'base' => '/path/to/scripts/'
            ),
            'desc' => PLUGIN_EVENT_TEXTWIKI_RULE_DESC_INCLUDE,
            's9yc' => array(
                 'base' => array(
                     'type' => 'string',
                     'desc' => PLUGIN_EVENT_TEXTWIKI_RULE_INCLUDE_DESC_BASE))
        ),

        'heading' => array(
            'file' => 'Text/Wiki/Parse/Default/Heading.php',
            'name' => 'Text_Wiki_Rule_heading',
            'flag' => true,
            'conf' => array(),
            'desc' => PLUGIN_EVENT_TEXTWIKI_RULE_DESC_HEADING
        ),

        'horiz' => array(
            'file' => 'Text/Wiki/Parse/Default/Horiz.php',
            'name' => 'Text_Wiki_Rule_horiz',
            'flag' => true,
            'conf' => array(),
            'desc' => PLUGIN_EVENT_TEXTWIKI_RULE_DESC_HORIZ
        ),

        'break' => array(
            'file' => 'Text/Wiki/Parse/Default/Break.php',
            'name' => 'Text_Wiki_Rule_break',
            'flag' => true,
            'conf' => array(),
            'desc' => PLUGIN_EVENT_TEXTWIKI_RULE_DESC_BREAK
        ),

        'blockquote' => array(
            'file' => 'Text/Wiki/Parse/Default/Blockquote.php',
            'name' => 'Text_Wiki_Rule_blockquote',
            'flag' => true,
            'conf' => array(),
            'desc' => PLUGIN_EVENT_TEXTWIKI_RULE_DESC_BLOCKQUOTE
        ),

        'list' => array(
            'file' => 'Text/Wiki/Parse/Default/List.php',
            'name' => 'Text_Wiki_Rule_list',
            'flag' => true,
            'conf' => array(),
            'desc' => PLUGIN_EVENT_TEXTWIKI_RULE_DESC_LIST
        ),

        'deflist' => array(
            'file' => 'Text/Wiki/Parse/Default/Deflist.php',
            'name' => 'Text_Wiki_Rule_deflist',
            'flag' => true,
            'conf' => array(),
            'desc' => PLUGIN_EVENT_TEXTWIKI_RULE_DESC_DEFLIST
        ),

        'table' => array(
            'file' => 'Text/Wiki/Parse/Default/Table.php',
            'name' => 'Text_Wiki_Rule_table',
            'flag' => true,
            'conf' => array(
                'border'  => 1,
                'spacing' => 0,
                'padding' => 4
            ),
            'desc' => PLUGIN_EVENT_TEXTWIKI_RULE_DESC_TABLE
        ),

        'embed' => array(
            'file' => 'Text/Wiki/Parse/Default/Embed.php',
            'name' => 'Text_Wiki_Rule_embed',
            'flag' => false,
            'conf' => array(
                'base' => '/path/to/scripts/'
            ),
            'desc' => PLUGIN_EVENT_TEXTWIKI_RULE_DESC_EMBED,
            's9yc' => array(
                 'base' => array(
                     'type' => 'string',
                     'desc' => PLUGIN_EVENT_TEXTWIKI_RULE_EMBED_DESC_BASE))
        ),

        'image' => array(
            'file' => 'Text/Wiki/Parse/Default/Image.php',
            'name' => 'Text_Wiki_Rule_image',
            'flag' => true,
            'conf' => array(
                'base' => ''
            ),
            'desc' => PLUGIN_EVENT_TEXTWIKI_RULE_DESC_IMAGE,
            's9yc' => array(
                 'base' => array(
                     'type' => 'string',
                     'desc' => PLUGIN_EVENT_TEXTWIKI_RULE_IMAGE_DESC_BASE))
        ),

        'phplookup' => array(
            'file' => 'Text/Wiki/Parse/Default/Phplookup.php',
            'name' => 'Text_Wiki_Rule_phplookup',
            'flag' => true,
            'conf' => array(),
            'desc' => PLUGIN_EVENT_TEXTWIKI_RULE_DESC_PHPLOOKUP
        ),

        'toc' => array(
            'file' => 'Text/Wiki/Parse/Default/Toc.php',
            'name' => 'Text_Wiki_Rule_toc',
            'flag' => true,
            'conf' => array(),
            'desc' => PLUGIN_EVENT_TEXTWIKI_RULE_DESC_TOC
        ),

        'newline' => array(
            'file' => 'Text/Wiki/Parse/Default/Newline.php',
            'name' => 'Text_Wiki_Rule_newline',
            'flag' => true,
            'conf' => array(
                'skip' => array(
                    'code',
                    'phpcode',
                    'heading',
                    'horiz',
                    'deflist',
                    'table',
                    'list',
                    'toc'
                )
            ),
            'desc' => PLUGIN_EVENT_TEXTWIKI_RULE_DESC_NEWLINE
        ),

        'center' => array(
            'file' => 'Text/Wiki/Parse/Default/Center.php',
            'name' => 'Text_Wiki_Rule_center',
            'flag' => true,
            'conf' => array(),
            'desc' => PLUGIN_EVENT_TEXTWIKI_RULE_DESC_CENTER
        ),

        'paragraph' => array(
            'file' => 'Text/Wiki/Parse/Default/Paragraph.php',
            'name' => 'Text_Wiki_Rule_paragraph',
            'flag' => true,
            'conf' => array(
                'skip' => array(
                    'blockquote',
                    'code',
                    'phpcode',
                    'heading',
                    'horiz',
                    'deflist',
                    'table',
                    'list',
                    'toc'
                )
            ),
            'desc' => PLUGIN_EVENT_TEXTWIKI_RULE_DESC_PARAGRAPH
        ),

        'url' => array(
            'file' => 'Text/Wiki/Parse/Default/Url.php',
            'name' => 'Text_Wiki_Rule_url',
            'flag' => true,
            'conf' => array(
                'target' => '_BLANK'
            ),
            'desc' => PLUGIN_EVENT_TEXTWIKI_RULE_DESC_URL,
            's9yc' => array(
                 'target' => array(
                     'type' => 'string',
                     'desc' => PLUGIN_EVENT_TEXTWIKI_RULE_URL_DESC_TARGET)),
        ),

        'freelink' => array(
            'file' => 'Text/Wiki/Parse/Default/Freelink.php',
            'name' => 'Text_Wiki_Rule_freelink',
            'flag' => false,
            'conf' => array(
                'pages'       => array(),
                'view_url' => 'http://example.com/index.php?page=%s',
                'new_url'  => 'http://example.com/new.php?page=%s',
                'new_text' => '?'
            ),
            'desc' => PLUGIN_EVENT_TEXTWIKI_RULE_DESC_FREELINK,
            's9yc' => array(
                 'pages' => array(
                     'type' => 'string',
                     'desc' => PLUGIN_EVENT_TEXTWIKI_RULE_FREELINK_DESC_PAGES),
                 'view_url' => array(
                     'type' => 'string',
                     'desc' => PLUGIN_EVENT_TEXTWIKI_RULE_FREELINK_DESC_VIEWURL),
                 'new_url' => array(
                     'type' => 'string',
                     'desc' => PLUGIN_EVENT_TEXTWIKI_RULE_FREELINK_DESC_NEWURL),
                 'new_text' => array(
                     'type' => 'string',
                     'desc' => PLUGIN_EVENT_TEXTWIKI_RULE_FREELINK_DESC_NEWTEXT),
                 'cachetime' => array(
                     'type' => 'string',
                     'desc' => PLUGIN_EVENT_TEXTWIKI_RULE_WIKILINK_DESC_CACHETIME))
        ),

        'interwiki' => array(
            'file' => 'Text/Wiki/Parse/Default/Interwiki.php',
            'name' => 'Text_Wiki_Rule_interwiki',
            'flag' => true,
            'conf' => array(
                'sites' => array(
                    'MeatBall' => 'http://www.usemod.com/cgi-bin/mb.pl?%s',
                    'Advogato' => 'http://advogato.org/%s',
                    'Wiki'     => 'http://c2.com/cgi/wiki?%s'
                ),
                'target' => '_BLANK'
            ),
            'desc' => PLUGIN_EVENT_TEXTWIKI_RULE_DESC_INTERWIKI,
            's9yc' => array(
                 'pages' => array(
                     'target' => 'string',
                     'desc' => PLUGIN_EVENT_TEXTWIKI_RULE_INTERWIKI_DESC_TARGET))
        ),

        'wikilink' => array(
            'file' => 'Text/Wiki/Parse/Default/Wikilink.php',
            'name' => 'Text_Wiki_Rule_wikilink',
            'flag' => false,
            'conf' => array(
                'pages'       => array(),
                'view_url' => 'http://example.com/index.php?page=%s',
                'new_url'  => 'http://example.com/new.php?page=%s',
                'new_text' => '?'
            ),
            'desc' => PLUGIN_EVENT_TEXTWIKI_RULE_DESC_WIKILINK,
            's9yc' => array(
                 'pages' => array(
                     'type' => 'string',
                     'desc' => PLUGIN_EVENT_TEXTWIKI_RULE_WIKILINK_DESC_PAGES),
                 'view_url' => array(
                     'type' => 'string',
                     'desc' => PLUGIN_EVENT_TEXTWIKI_RULE_WIKILINK_DESC_VIEWURL),
                 'new_url' => array(
                     'type' => 'string',
                     'desc' => PLUGIN_EVENT_TEXTWIKI_RULE_WIKILINK_DESC_NEWURL),
                 'new_text' => array(
                     'type' => 'string',
                     'desc' => PLUGIN_EVENT_TEXTWIKI_RULE_WIKILINK_DESC_NEWTEXT),
                 'cachetime' => array(
                     'type' => 'string',
                     'desc' => PLUGIN_EVENT_TEXTWIKI_RULE_WIKILINK_DESC_CACHETIME))
        ),

        'colortext' => array(
            'file' => 'Text/Wiki/Parse/Default/Colortext.php',
            'name' => 'Text_Wiki_Rule_colortext',
            'flag' => true,
            'conf' => array(),
            'desc' => PLUGIN_EVENT_TEXTWIKI_RULE_DESC_COLORTEXT
        ),

        'strong' => array(
            'file' => 'Text/Wiki/Parse/Default/Strong.php',
            'name' => 'Text_Wiki_Rule_strong',
            'flag' => true,
            'conf' => array(),
            'desc' => PLUGIN_EVENT_TEXTWIKI_RULE_DESC_STRONG
        ),

        'bold' => array(
            'file' => 'Text/Wiki/Parse/Default/Bold.php',
            'name' => 'Text_Wiki_Rule_bold',
            'flag' => true,
            'conf' => array(),
            'desc' => PLUGIN_EVENT_TEXTWIKI_RULE_DESC_BOLD
        ),

        'emphasis' => array(
            'file' => 'Text/Wiki/Parse/Default/Emphasis.php',
            'name' => 'Text_Wiki_Rule_emphasis',
            'flag' => true,
            'conf' => array(),
            'desc' => PLUGIN_EVENT_TEXTWIKI_RULE_DESC_EMPHASIS
        ),

        'italic' => array(
            'file' => 'Text/Wiki/Parse/Default/Italic.php',
            'name' => 'Text_Wiki_Rule_italic',
            'flag' => true,
            'conf' => array(),
            'desc' => PLUGIN_EVENT_TEXTWIKI_RULE_DESC_ITALIC
        ),

        'underline' => array(
            'file' => 'Text/Wiki/Parse/Default/Underline.php',
            'name' => 'Text_Wiki_Rule_underline',
            'flag' => true,
            'conf' => array(),
            'desc' => PLUGIN_EVENT_TEXTWIKI_RULE_DESC_UNDERLINE
        ),

        'tt' => array(
            'file' => 'Text/Wiki/Parse/Default/Tt.php',
            'name' => 'Text_Wiki_Rule_tt',
            'flag' => true,
            'conf' => array(),
            'desc' => PLUGIN_EVENT_TEXTWIKI_RULE_DESC_TT
        ),

        'superscript' => array(
            'file' => 'Text/Wiki/Parse/Default/Superscript.php',
            'name' => 'Text_Wiki_Rule_superscript',
            'flag' => true,
            'conf' => array(),
            'desc' => PLUGIN_EVENT_TEXTWIKI_RULE_DESC_SUPERSCRIPT
        ),

        'subscript' => array(
            'file' => 'Text/Wiki/Parse/Default/Subscript.php',
            'name' => 'Text_Wiki_Rule_subscript',
            'flag' => true,
            'conf' => array(),
            'desc' => PLUGIN_EVENT_TEXTWIKI_RULE_DESC_SUBSCRIPT
        ),

        'revise' => array(
            'file' => 'Text/Wiki/Parse/Default/Revise.php',
            'name' => 'Text_Wiki_Rule_revise',
            'flag' => true,
            'conf' => array(),
            'desc' => PLUGIN_EVENT_TEXTWIKI_RULE_DESC_REVISE
        ),

        'tighten' => array(
            'file' => 'Text/Wiki/Parse/Default/Tighten.php',
            'name' => 'Text_Wiki_Rule_tighten',
            'flag' => true,
            'conf' => array(),
            'desc' => PLUGIN_EVENT_TEXTWIKI_RULE_DESC_TIGHTEN
        ),

        'entities' => array(
            'file' => 'Text/Wiki/Parse/Default/Entities.php',
            'name' => 'Text_Wiki_Rule_entities',
            'flag' => true,
            'conf' => array(),
            'desc' => PLUGIN_EVENT_TEXTWIKI_RULE_DESC_ENTITIES
        )
    );

    public $title = PLUGIN_EVENT_TEXTWIKI_NAME;

    private $nonWikiRules = array();

    function introspect(&$propbag)
    {
        global $serendipity;

        $propbag->add('name',          PLUGIN_EVENT_TEXTWIKI_NAME);
        $propbag->add('description',   PLUGIN_EVENT_TEXTWIKI_DESC);
        $propbag->add('stackable',     false);
        $propbag->add('author',        'Tobias Schlitt, Ian Styx');
        $propbag->add('version',       '2.0.0');
        $propbag->add('requirements',  array(
            'serendipity' => '5.0',
            'smarty'      => '4.1',
            'php'         => '8.2'
        ));
        $propbag->add('cachable_events', array('frontend_display' => true));
        $propbag->add('event_hooks',   array('frontend_display' => true, 'frontend_comment' => true));
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
        // Add markup elements config
        foreach($this->markup_elements AS $element) {
            $conf_array[] = $element['name'];
        }
        // Save non wiki-rule configuration
        $this->nonWikiRules = $conf_array;
        // Separate markup elements from wiki-rule config
        $conf_array[] = "internal_separator";
        // Add wiki-rule config
        $this->_introspect_rule_config($conf_array);
        $propbag->add('configuration', $conf_array);
    }

    function _introspect_rule_config(&$conf_array)
    {
        foreach($this->wikiRules AS $name => $rule) {
            // If sub configurations exist
            if (isset($rule['s9yc']) && is_array($rule['s9yc'])) {
                if ($conf_array[(count($conf_array) - 1)] != 'internal_separator') {
                    $conf_array[] = 'internal_separator';
                }
                // Add wiki-rule config itself
                $conf_array[] = $name;
                foreach ($rule['s9yc'] AS $confname => $conf) {
                    $conf_array[] = $name . '_' . $confname;
                }
                $conf_array[] = "internal_separator";
            } else {
                // Add only wiki-rule config itself
                $conf_array[] = $name;
            }
        }
    }

    function generate_content(&$title)
    {
        $title = $this->title;
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

    function introspect_config_item($name, &$propbag)
    {
        if (in_array($name, $this->nonWikiRules)) {
            $propbag->add('type',        'boolean');
            $propbag->add('name',        defined($name) ? constant($name) : $name);
            $propbag->add('description', sprintf(APPLY_MARKUP_TO, defined($name) ? constant($name) : $name));
            $propbag->add('default', true);
        } else if ($name == 'internal_separator') {
            $propbag->add('type',        'separator');
            $propbag->add('name',        'Separator');
            $propbag->add('description', 'Separator');
        } else {
            $this->_introspect_rule_config_item($name, $propbag);
        }
        return true;
    }

    function _introspect_rule_config_item($name, &$propbag)
    {
        if (strpos($name, '_') === false) {
            $propbag->add('type',        'boolean');
            $propbag->add('name',        ucfirst($name));
            $propbag->add('description', $this->wikiRules[$name]['desc']);
            $propbag->add('default', $this->wikiRules[$name]['flag']);
            return true;
        } else {
            $parts = explode('_', $name, 2);
            $conf = $this->wikiRules[$parts[0]]['s9yc'][$parts[1]];
            $propbag->add('type',        $conf['type']);
            $propbag->add('name',        ucfirst($parts[0]).' '.ucwords((str_replace('_', ' ',$parts[1]))));
            $propbag->add('description', $conf['desc']);
            $propbag->add('default', '');
            return true;
        }
    }

    function event_hook($event, &$bag, &$eventData, $addData = null)
    {
        global $serendipity;

        $hooks = &$bag->get('event_hooks');

        if (!isset($this->wiki) || !is_a($this->wiki, 'text_wiki')) {
            $this->_init_wiki($bag);
        }

        if (isset($hooks[$event])) {

            switch($event) {

                case 'frontend_display':
                    foreach ($this->markup_elements AS $temp) {
                        if (serendipity_db_bool($this->get_config($temp['name'], 'true')) && !empty($eventData[$temp['element']])
                        &&  (!isset($eventData['properties']['ep_disable_markup_' . $this->instance]) || !$eventData['properties']['ep_disable_markup_' . $this->instance])
                        &&  !isset($serendipity['POST']['properties']['disable_markup_' . $this->instance])) {
                            $element = $temp['element'];
                            $eventData[$element] = $this->wiki->transform($eventData[$element]);
                        }
                    }
                    break;

                case 'frontend_comment':
                    if (serendipity_db_bool($this->get_config('COMMENT', true))) {
                        echo '<div class="serendipity_commentDirection serendipity_comment_textwiki">' . PLUGIN_EVENT_TEXTWIKI_TRANSFORM . '</div>';
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

    function _init_wiki(&$bag)
    {
        include_once dirname(__FILE__) . '/Text/Wiki.php';

        if (class_exists('Text_Wiki')) {
            $this->wiki = new Text_Wiki;
            $this->wiki->setFormatConf('Xhtml', 'translate', null);
            $this->wiki->setFormatConf('Xhtml', 'charset', LANG_CHARSET);
        } else {
            return false;
        }
        foreach ($this->wikiRules AS $name => $rule) {
            if (serendipity_db_bool($this->get_config($name, $rule['flag']))) {
                $this->_add_wiki_rule($bag, $name, $rule);
            } else {
                $this->_remove_wiki_rule($bag, $name);
            }
        }
        return true;
    }

    function _remove_wiki_rule(&$bag, $name)
    {
        $this->wiki->disableRule($name);
    }

    function _add_wiki_rule(&$bag, $name, $rule)
    {
        $rule_info = $rule;
        $rule_info['flag'] = true;
        if (isset($rule['s9yc']) && is_array($rule['s9yc'])) {
            foreach ($rule['s9yc'] AS $confName => $confVals) {
                if ($confName === 'pages') {
                    $rule_info['conf']['pages'] = $this->_get_link_pages($bag, $name);
                } else {
                    $rule_info['conf'][$confName] = $this->get_config($name.'_'.$confName, $rule_info['conf'][$confName]);
                }
            }
        }
        $this->wiki->enableRule($name);
        $this->wiki->setRenderConf("Xhtml", $name, $rule_info);
        return true;
    }

    function _get_link_pages(&$bag, $ruleName)
    {
        global $serendipity;
        if ($this->get_config($ruleName.'_pages') === null) {
            return array();
        }
        $pagesFile = $this->get_config($ruleName.'_pages');
        if (!is_file($pagesFile)) {
            $cacheFile = $serendipity['uploadPath']."serendipity_plugin_event_wiki_".$ruleName.".cache";
            $cacheTime = (int)$this->get_config($ruleName.'_cachetime', 3600);
            if (!is_file($cacheFile) || (filemtime($cacheFile) + $cacheTime) < time()) {
                $pagesArray = @file($pagesFile);
                if (!$pagesArray) { return array(); }
                $putCache = @fopen($cacheFile, 'w');
                if (!$putCache) { return array(); }
                fputs($putCache, implode("", $pagesArray));
                fclose($putCache);
            }
            $pagesFile = $cacheFile;
        }
        $pagesArray = array_map(trim, file($pagesFile));
        return (is_array($pagesArray)) ? $pagesArray : array();
    }
}

/* vim: set sts=4 ts=4 expandtab : */
?>