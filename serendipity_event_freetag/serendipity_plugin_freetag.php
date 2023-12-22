<?php

if (IN_serendipity !== true) {
    die ("Don't hack!");
}

@serendipity_plugin_api::load_language(dirname(__FILE__));

class serendipity_plugin_freetag extends serendipity_plugin
{
    var $title = PLUGIN_FREETAG_NAME;

    private $bycategory = [];

    function introspect(&$propbag)
    {
        global $serendipity;

        $this->title = $this->get_config('title', $this->title);

        $propbag->add('name',          PLUGIN_FREETAG_NAME);
        $propbag->add('description',   PLUGIN_FREETAG_BLAHBLAH);
        $propbag->add('stackable',     false);
        $propbag->add('author',        'Garvin Hicking, Jonathan Arkell, Grischa Brockhaus, Lars Strojny, Ian Styx');
        $propbag->add('requirements',  array(
            'serendipity' => '2.1.0',
            'smarty'      => '3.1.0',
            'php'         => '5.3.0'
        ));
        $propbag->add('version',       '4.00');
        $propbag->add('groups',        array('FRONTEND_ENTRY_RELATED'));
        $propbag->add('configuration', array(
            'config_pagegrouper',
            'title',
            'taglink',
            'show_xml','xml_image',

            'lowercase_tags',
            'scale_tag', 'min_percent', 'max_percent', 'show_newline',
            'treshold_tag_count', 'max_tags',
            'order_by', 'sort_desc',
            'template',

            'separator2', 'config_cloudgrouper',
            'use_wordcloud',
            'use_rotacloud', 'rotacloud_tag_color', 'rotacloud_tag_border_color', 'rotacloud_width'
        ));
        $this->dependencies = array('serendipity_event_freetag' => 'keep');
    }

    function introspect_config_item($name, &$propbag)
    {
        global $serendipity;
        switch($name) {
            case 'separator1':
            case 'separator2':
                $propbag->add('type',        'separator');
                break;

            case 'config_pagegrouper':
                $propbag->add('type',        'content');
                $propbag->add('name',        FREETAG_CONFIGGROUP_CONFIG);
                $propbag->add('default',     '<h3>' . PLUGIN_FREETAG_CONFIGGROUP_CONFIG . '</h3>');
                break;

            case 'config_cloudgrouper':
                $propbag->add('type',        'content');
                $propbag->add('name',        FREETAG_CONFIGGROUP_CLOUD);
                $propbag->add('default',     '<h3>' . FREETAG_CONFIGGROUP_CLOUD_DESC . '</h3>');
                break;

            case 'title':
                 $propbag->add('type',        'string');
                 $propbag->add('name',        TITLE);
                 $propbag->add('description', TITLE_FOR_NUGGET);
                 $propbag->add('default',     PLUGIN_FREETAG_NAME);
                 break;

            case 'taglink':
                 $propbag->add('type',        'string');
                 $propbag->add('name',        PLUGIN_EVENT_FREETAG_TAGLINK);
                 $propbag->add('description', '');
                 $propbag->add('default',     $serendipity['baseURL'] . ($serendipity['rewrite'] == 'none' ? $serendipity['indexFile'] . '?/' : '') . 'plugin/tag/');
                 break;

            case 'scale_tag':
                 $propbag->add('type',        'boolean');
                 $propbag->add('name',        PLUGIN_FREETAG_SCALE);
                 $propbag->add('description', '');
                 $propbag->add('default',     'false');
                 break;

            case 'show_xml':
                $propbag->add('type',        'boolean');
                $propbag->add('name',        PLUGIN_FREETAG_XML);
                $propbag->add('description', '');
                $propbag->add('default',     'true');
                break;

            case 'show_newline':
                $propbag->add('type',        'boolean');
                $propbag->add('name',        PLUGIN_FREETAG_NEWLINE);
                $propbag->add('description', '');
                $propbag->add('default',     'true');
                break;

            case 'lowercase_tags':
                 $propbag->add('type',        'boolean');
                 $propbag->add('name',        PLUGIN_EVENT_FREETAG_LOWERCASE_TAGS);
                 $propbag->add('description', PLUGIN_EVENT_FREETAG_LOWERCASE_TAGS_DESC);
                 $propbag->add('default',     'true');
                 break;

            case 'min_percent':
                 $propbag->add('type',        'string');
                 $propbag->add('name',        PLUGIN_EVENT_FREETAG_TAGCLOUD_MIN);
                 $propbag->add('description', '');
                 $propbag->add('default',     '100');
                 break;

            case 'max_percent':
                 $propbag->add('type',        'string');
                 $propbag->add('name',        PLUGIN_EVENT_FREETAG_TAGCLOUD_MAX);
                 $propbag->add('description', '');
                 $propbag->add('default',     '300');
                 break;

            case 'max_tags':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_FREETAG_MAX_TAGS);
                $propbag->add('description', '');
                $propbag->add('default',     '100');
                break;

            case 'treshold_tag_count':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_FREETAG_TRESHOLD_TAG_COUNT);
                $propbag->add('description', '');
                $propbag->add('default',     '2');
                break;

            case 'order_by':
                $order     = array('tag' => PLUGIN_EVENT_FREETAG_ORDER_TAGNAME, 'total' => PLUGIN_EVENT_FREETAG_ORDER_TAGCOUNT);
                $propbag->add('type',        'select');
                $propbag->add('select_values', $order);
                $propbag->add('name',        SORT_ORDER);
                $propbag->add('description', '');
                $propbag->add('default',     'tag');
                break;

            case 'sort_desc':
                 $propbag->add('type',        'boolean');
                 $propbag->add('name',        PLUGIN_EVENT_FREETAG_SORT_DESC_FOR_TOTAL);
                 $propbag->add('description', '');
                 $propbag->add('default',     'false');
                 break;

            case 'xml_image':
                 $propbag->add('type',        'string');
                 $propbag->add('name',        PLUGIN_EVENT_FREETAG_XMLIMAGE);
                 $propbag->add('description', '');
                 $propbag->add('default',     'img/xml.gif');
                 break;

            case 'use_rotacloud':
                 $propbag->add('type',        'boolean');
                 $propbag->add('name',        PLUGIN_EVENT_FREETAG_USE_CAROC);
                 $propbag->add('description', sprintf(PLUGIN_EVENT_FREETAG_USE_CAROC_DESC, PLUGIN_EVENT_FREETAG_USE_CANVAS_PLUGIN_SPRINT) . ' ' . PLUGIN_FREETAG_USE_CANVAS_SCRIPTS_DESC);
                 $propbag->add('default',     'false');
                 break;

            case 'rotacloud_tag_color':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_EVENT_FREETAG_CAROC_TAG_COLOR);
                $propbag->add('description', PLUGIN_EVENT_FREETAG_CAROC_TAG_COLOR_DESC);
                $propbag->add('default',     '3E5F81');
                break;

            case 'rotacloud_tag_border_color':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_EVENT_FREETAG_CAROC_TAG_BORDER_COLOR);
                $propbag->add('description', '');
                $propbag->add('default',     'B1C1D1');
                break;

            case 'rotacloud_width':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_EVENT_FREETAG_CAROC_BOXWIDTH);
                $propbag->add('description', '');
                $propbag->add('default',     '300');
                break;

            case 'use_wordcloud':
                 $propbag->add('type',        'boolean');
                 $propbag->add('name',        PLUGIN_EVENT_FREETAG_USE_CAWOC);
                 $propbag->add('description', sprintf(PLUGIN_EVENT_FREETAG_USE_CAWOC_DESC, PLUGIN_EVENT_FREETAG_USE_CANVAS_PLUGIN_SPRINT) . ' ' . PLUGIN_FREETAG_USE_CANVAS_SCRIPTS_DESC);
                 $propbag->add('default',     'false');
                 break;

            case 'template':
                $propbag->add('type',         'string');
                $propbag->add('name',         PLUGIN_EVENT_FREETAG_TEMPLATE);
                $propbag->add('description',  PLUGIN_EVENT_FREETAG_TEMPLATE_DESCRIPTION);
                $propbag->add('default',      '');
                break;
            }

        return true;
    }

    function example()
    {
        $useRotCanvas = serendipity_db_bool($this->get_config('use_rotacloud', 'false'));
        $useWordCloud = serendipity_db_bool($this->get_config('use_wordcloud', 'false'));

        if ($useRotCanvas && $useWordCloud) {
            $this->set_config('use_rotacloud', 'false');
            $this->set_config('use_wordcloud', 'false');
            echo '<p class="msg_error"><span class="icon-attention-circled" aria-hidden="true"></span> ' . PLUGIN_EVENT_FREETAG_SET_OPTION_ERROR_1;
        }
    }

    /**
     * Fetch and memorize possible hidden set categories by categorytemplates
     */
    function fetchHiddenCategoryTemplates()
    {
        global $serendipity;

        if (!isset($this->bycategory[0]) && class_exists('serendipity_event_categorytemplates')) {
            #echo 'NOCACHEUsed Freetag';
            $this->bycategory = serendipity_db_query("SELECT categoryid, template FROM {$serendipity['dbPrefix']}categorytemplates WHERE hide = 1", false, 'assoc');
        }
    }

    function generate_content(&$title)
    {
        global $serendipity;

        $title = $this->get_config('title', $this->title);
        $to_lower = serendipity_db_bool($this->get_config('lowercase_tags', 'true'));

        if ($this->get_config('max_tags', 0) != 0) {
            $limit = "LIMIT " . $this->get_config('max_tags', 0);
        } else {
            $limit = '';
        }

        $ct_conds = '';
        $ct_joins = '';

        $this->fetchHiddenCategoryTemplates();

        if (!empty($this->bycategory[0]['template'])) {
            $ct_joins .= " LEFT OUTER JOIN {$serendipity['dbPrefix']}entrycat AS ec ON (et.entryid = ec.entryid)";
            $ct_joins .= " LEFT OUTER JOIN {$serendipity['dbPrefix']}categorytemplates AS ct ON (ec.categoryid = ct.categoryid)";
            foreach ($this->bycategory AS $bcat) {
                if ($bcat['template'] == $serendipity['template']) {
                    $ct_conds .= " AND (ec.categoryid = " . (int)$bcat['categoryid'] . ")";
                } else {
                    $ct_conds .= " AND (ec.categoryid != " . (int)$bcat['categoryid'] . " OR ec.categoryid IS NULL)";
                }
            }
        }

        $query = "SELECT et.tag, count(et.tag) AS total
                    FROM {$serendipity['dbPrefix']}entrytags AS et
         LEFT OUTER JOIN {$serendipity['dbPrefix']}entries AS e
                      ON et.entryid = e.id
                    $ct_joins
                   WHERE e.isdraft = 'false'
                   " . (!serendipity_db_bool($serendipity['showFutureEntries']) ? " AND e.timestamp <= " . time() : '') . "
                    $ct_conds
                GROUP BY et.tag
                  HAVING count(et.tag) >= " . $this->get_config('treshold_tag_count') . "
                ORDER BY total DESC $limit";

        $rows = serendipity_db_query($query);

        if (!is_array($rows)) {
            return;
        }

        // not sure if we can optimize this loop... :/
        // Probably through some SQL magic.
        foreach($rows AS $r) {
            if ($to_lower) {
                 // set to_lower for frontend sidebar list/clouds (new)
                foreach ($r AS &$t) {
                    if (function_exists('mb_strtolower')) {
                        $t = mb_strtolower($t);
                    } else {
                        $t = strtolower($t);
                    }
                }
            }
            $tags[$r['tag']] = $r['total'];
        }
        if ($this->get_config('order_by') == 'tag'){
            uksort($tags, 'strnatcasecmp');
            serendipity_plugin_api::hook_event('sort', $tags);
        } else if ($this->get_config('order_by') == 'total'){
            serendipity_db_bool($this->get_config('sort_desc', 'false')) ? arsort($tags) : asort($tags);
        }

        $xml          = serendipity_db_bool($this->get_config('show_xml', 'true'));
        $nl           = serendipity_db_bool($this->get_config('show_newline', 'true'));
        $scaling      = serendipity_db_bool($this->get_config('scale_tag', 'false'));
        $useRotCanvas = serendipity_db_bool($this->get_config('use_rotacloud', 'false'));
        $useWordCloud = serendipity_db_bool($this->get_config('use_wordcloud', 'false'));

        serendipity_event_freetag::displayTags($tags, $xml, $nl, $scaling, $this->get_config('max_percent', 300), $this->get_config('min_percent', 100),
                                               $this->get_config('taglink'), $this->get_config('template'), $this->get_config('xml_image','img/xml.gif'),
                                               $useRotCanvas, $this->get_config('rotacloud_tag_color', '3E5F81'), $this->get_config('rotacloud_tag_border_color', 'B1C1D1'), $this->get_config('rotacloud_width', '300'),
                                               $useWordCloud);
    }

    function cleanup()
    {
        serendipity_event_freetag::static_install();
    }

}

/* vim: set sts=4 ts=4 expandtab : */
?>