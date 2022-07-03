<?php
/*
 * PRIORITY
 * - get some kind of data-sharing protocol in action.  It is very difficult
 *   tracing out what the hell is going on with this thing. (RQ: ?)
 *
 * TODO:
 * - - convert database structure to a truly 3rd normal form (RQ: ?)
 *
 *  (RQ: We are ten years later now. Shall we keep this?)
 */


if (IN_serendipity !== true) {
    die ("Don't hack!");
}

@serendipity_plugin_api::load_language(dirname(__FILE__));

define('FREETAG_MANAGE_URL', '?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=managetags');
define('FREETAG_EDITENTRY_URL', '?serendipity[action]=admin&amp;serendipity[adminModule]=entries&amp;serendipity[adminAction]=edit&amp;'.serendipity_setFormToken('url').'&amp;serendipity[id]=');

class serendipity_event_freetag extends serendipity_event
{
    var $tags                 = array();
    var $displayTag           = false;
    var $title                = PLUGIN_EVENT_FREETAG_TITLE;
    var $taggedEntries        = null;
    var $supported_properties = array();
    var $dependencies         = array();

    private $bycategory = [];

    function introspect(&$propbag)
    {
        global $serendipity;

        $propbag->add('name',          PLUGIN_EVENT_FREETAG_TITLE);
        $propbag->add('description',   PLUGIN_EVENT_FREETAG_DESC);
        $propbag->add('stackable',     false);
        $propbag->add('author',        'Garvin Hicking, Jonathan Arkell, Grischa Brockhaus, Lars Strojny, Malte Paskuda, Ian Styx');
        $propbag->add('requirements',  array(
            'serendipity' => '2.1.0',
            'smarty'      => '3.1.0',
            'php'         => '5.3.0'
        ));
        $propbag->add('version',       '5.22');
        $propbag->add('event_hooks',    array(
            'frontend_fetchentries'                             => true,
            'frontend_fetchentry'                               => true,
            'frontend_display:rss-2.0:per_entry'                => true,
            'frontend_footer'                                   => true,
            'frontend_display:rss-1.0:per_entry'                => true,
            'frontend_display:atom-1.0:per_entry'               => true,
            'frontend_entryproperties'                          => true,
            'frontend_rss'                                      => true,
            'entry_display'                                     => true,
            'entries_header'                                    => true,
            'backend_publish'                                   => true,
            'backend_save'                                      => true,
            'backend_display'                                   => true,
            'backend_sidebar_entries'                           => true,
            'backend_sidebar_entries_event_display_managetags'  => true,
            'backend_delete_entry'                              => true,
            'external_plugin'                                   => true,
            'xmlrpc_updertEntry'                                => true,
            'xmlrpc_fetchEntry'                                 => true,
            'xmlrpc_deleteEntry'                                => true,
            'css'                                               => true,
            'css_backend'                                       => true,
            'js_backend'                                        => true
        ));
        $propbag->add('groups', array('BACKEND_EDITOR'));

        $this->supported_properties = array('freetag_name', 'freetag_tagList');
        $this->dependencies = array('serendipity_plugin_freetag' => 'keep');

        $propbag->add('configuration', array(
            'config_configgrouper',
            'cat2tag', 'keyword2tag',
            'taglink',
            'extended_smarty',
            'collation',
            'admin_show_taglist', 'admin_delimiter', 'admin_ftayt',

            'separator1', 'config_cloudgrouper',
            'show_tagcloud', 'show_ft_jquery',
            'min_percent', 'max_percent', 'max_tags',
            'use_wordcloud',
            'use_rotacloud', 'rotacloud_tag_color', 'rotacloud_tag_border_color', 'rotacloud_width',

            'separator2', 'config_pagegrouper',
            'lowercase_tags', 'meta_keywords',
            'show_related', 'show_related_count',
            'taglist',
            'sortlist',
            'send_http_header',
            'embed_footer')
        );
    }

    function introspect_config_item($name, &$propbag)
    {
        global $serendipity;

        switch($name) {
            case 'separator2':
            case 'separator1':
                $propbag->add('type',        'separator');
                break;

            case 'config_cloudgrouper':
                $propbag->add('type',        'content');
                $propbag->add('name',        FREETAG_CONFIGGROUP_CLOUD);
                $propbag->add('default',     '<h3>' . FREETAG_CONFIGGROUP_CLOUD_DESC . '</h3>');
                break;

            case 'config_pagegrouper':
                $propbag->add('type',        'content');
                $propbag->add('name',        FREETAG_CONFIGGROUP_ENTRYPAGE);
                $propbag->add('default',     '<h3>' . FREETAG_CONFIGGROUP_ENTRYPAGE_DESC . '</h3>');
                break;

            case 'config_configgrouper':
                $propbag->add('type',        'content');
                $propbag->add('name',        FREETAG_CONFIGGROUP_CONFIG);
                $propbag->add('default',     '<h3>' . FREETAG_CONFIGGROUP_CONFIG_DESC . '</h3>');
                break;

            case 'show_tagcloud':
                $propbag->add('type',        'boolean');
                $propbag->add('name',        PLUGIN_EVENT_FREETAG_SHOW_TAGCLOUD);
                $propbag->add('description', '');
                $propbag->add('default',     'true');
                break;

            case 'show_ft_jquery':
                $propbag->add('type',        'boolean');
                $propbag->add('name',        PLUGIN_EVENT_FREETAG_ALLOW_JQUERYLIB);
                $propbag->add('description', PLUGIN_EVENT_FREETAG_ALLOW_JQUERYLIB_DESC);
                $propbag->add('default',     'false');
                break;

            case 'cat2tag':
                $propbag->add('type',        'boolean');
                $propbag->add('name',        PLUGIN_EVENT_FREETAG_CAT2TAG);
                $propbag->add('description', PLUGIN_EVENT_FREETAG_CAT2TAG_DESC);
                $propbag->add('default',     'false');
                break;

            case 'keyword2tag':
                $propbag->add('type',        'boolean');
                $propbag->add('name',        PLUGIN_EVENT_FREETAG_KEYWORD2TAG);
                $propbag->add('description', PLUGIN_EVENT_FREETAG_KEYWORD2TAG_DESC);
                $propbag->add('default',     'false');
                break;

            case 'embed_footer':
                $propbag->add('type',        'select');
                $propbag->add('name',        PLUGIN_EVENT_FREETAG_EMBED_FOOTER);
                $propbag->add('description', PLUGIN_EVENT_FREETAG_EMBED_FOOTER_DESC . ' ' . PLUGIN_EVENT_FREETAG_EMBED_FOOTER_DESC2);
                $propbag->add('select_values', array(
                                                    'yes'    => YES,
                                                    'no'     => NO,
                                                    'smarty' => 'Smarty'
                                                ));
                $propbag->add('default',     'true');
                break;

            case 'extended_smarty':
                $propbag->add('type',        'boolean');
                $propbag->add('name',        PLUGIN_EVENT_FREETAG_EXTENDED_SMARTY);
                $propbag->add('description', PLUGIN_EVENT_FREETAG_EXTENDED_SMARTY_DESC);
                $propbag->add('default',     'false');
                break;

            case 'taglist':
                $propbag->add('type',        'boolean');
                $propbag->add('name',        PLUGIN_EVENT_FREETAG_TAGSASLIST);
                $propbag->add('description', PLUGIN_EVENT_FREETAG_TAGSASLIST_DESC);
                $propbag->add('default',     'false');
                break;

            case 'sortlist':
                $propbag->add('type',        'boolean');
                $propbag->add('name',        PLUGIN_EVENT_FREETAG_SORTTAGSBYCOUNT);
                $propbag->add('description', PLUGIN_EVENT_FREETAG_SORTTAGSBYCOUNT_DESC);
                $propbag->add('default',     'false');
                break;

            case 'taglink':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_EVENT_FREETAG_TAGLINK);
                $propbag->add('description', PLUGIN_EVENT_FREETAG_TAGLINK_DESC);
                $propbag->add('default',     $serendipity['baseURL'] . ($serendipity['rewrite'] == 'none' ? $serendipity['indexFile'] . '?/' : '') . 'plugin/tag/');
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

            case 'collation':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_EVENT_FREETAG_COLLATION);
                $propbag->add('description', '');
                $propbag->add('default',     '');
                break;

            case 'max_tags':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_FREETAG_MAX_TAGS);
                $propbag->add('description', '');
                $propbag->add('default',     '45');
                break;

            case 'meta_keywords':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_FREETAG_META_KEYWORDS);
                $propbag->add('description', '');
                $propbag->add('default',     '0');
                break;

            case 'show_related':
                $propbag->add('type',         'boolean');
                $propbag->add('name',         PLUGIN_EVENT_FREETAG_SHOW_RELATED);
                $propbag->add('description',  '');
                $propbag->add('default',      'true');
                break;

            case 'show_related_count':
                $propbag->add('type',         'string');
                $propbag->add('name',         PLUGIN_EVENT_FREETAG_SHOW_RELATED_COUNT);
                $propbag->add('description',  '');
                $propbag->add('default',      '5');
                break;

            case 'lowercase_tags':
                $propbag->add('type',        'boolean');
                $propbag->add('name',        PLUGIN_EVENT_FREETAG_LOWERCASE_TAGS);
                $propbag->add('description', PLUGIN_EVENT_FREETAG_LOWERCASE_TAGS_DESC);
                $propbag->add('default',     'true');
                break;

            case 'send_http_header':
                $propbag->add('type',        'boolean');
                $propbag->add('name',        PLUGIN_EVENT_FREETAG_SEND_HTTP_HEADER);
                $propbag->add('description', '');
                $propbag->add('default',     'true');
                break;

            case 'admin_show_taglist':
                $propbag->add('type',        'boolean');
                $propbag->add('name',        PLUGIN_EVENT_FREETAG_ADMIN_TAGLIST);
                $propbag->add('description', '');
                $propbag->add('default',     'true');
                break;

            case 'admin_ftayt':
                $propbag->add('type',        'boolean');
                $propbag->add('name',        PLUGIN_EVENT_FREETAG_ADMIN_FTAYT);
                $propbag->add('description', '');
                $propbag->add('default',     'false');
                break;

            case 'admin_delimiter':
                $propbag->add('type',        'boolean');
                $propbag->add('name',        PLUGIN_EVENT_FREETAG_ADMIN_DELIMITER);
                $propbag->add('description', '');
                $propbag->add('default',     'true');
                break;

            case 'use_rotacloud':
                $propbag->add('type',        'boolean');
                $propbag->add('name',        PLUGIN_EVENT_FREETAG_USE_CAROC);
                $propbag->add('description', sprintf(PLUGIN_EVENT_FREETAG_USE_CAROC_DESC, PLUGIN_EVENT_FREETAG_USE_CANVAS_EVENT_SPRINT));
                $propbag->add('default',     'false');
                break;

            case 'rotacloud_tag_color':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_EVENT_FREETAG_CAROC_TAG_COLOR);
                $propbag->add('description', '');
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
                $propbag->add('default',     '500');
                break;

            case 'use_wordcloud':
                $propbag->add('type',        'boolean');
                $propbag->add('name',        PLUGIN_EVENT_FREETAG_USE_CAWOC);
                $propbag->add('description', sprintf(PLUGIN_EVENT_FREETAG_USE_CAWOC_DESC, PLUGIN_EVENT_FREETAG_USE_CANVAS_EVENT_SPRINT));
                $propbag->add('default',     'false');
                break;

            default:
                return false;
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
        // Delete old config options and flash objects
        if (null !== $this->get_config('use_flash')) {
            if (!file_exists(dirname(__FILE__) . '/swfobject.js')) {
                return;
            }
            global $serendipity;

            $fcitems = array('use_flash', 'flash_bg_trans', 'flash_tag_color', 'flash_bg_color', 'flash_width', 'flash_speed');
            foreach($fcitems AS $del) {
                serendipity_db_query("DELETE FROM {$serendipity['dbPrefix']}config WHERE name LIKE 'serendipity_%_freetag:%/$del'");
            }
            @unlink(dirname(__FILE__) . '/swfobject.js');
            @unlink(dirname(__FILE__) . '/tagcloud.swf');
        }
    }

    function generate_content(&$title)
    {
        $title = $this->title;
    }

    function cleanup()
    {
        self::static_install();
    }

    function install()
    {
        self::static_install();
    }

    /**
     * Installer method for both plugins
     *
     * @static
     * @see     cleanup()
     */
    static function static_install()
    {
        global $serendipity;

        if (!self::tableCreated('entrytags')) {
            $q = "CREATE TABLE {$serendipity['dbPrefix']}entrytags (" .
                    "entryid int(10) not null, " .
                    "tag varchar(50) not null, " .
                    "PRIMARY KEY (entryid, tag)" .
                ") {UTF_8}";

            $result = serendipity_db_schema_import($q);

            if ($result !== true) {
                return;
            }

            serendipity_db_schema_import("CREATE INDEX tagsentryindex ON {$serendipity['dbPrefix']}entrytags (entryid)");
            serendipity_db_schema_import("CREATE INDEX tagsTagIndex ON {$serendipity['dbPrefix']}entrytags (tag)");
        }

        if (!self::tableCreated('tagkeywords')) {
            $q = "CREATE TABLE {$serendipity['dbPrefix']}tagkeywords (" .
                    "keywords text, " .
                    "tag varchar(50) not null, " .
                    "PRIMARY KEY (tag)" .
                ") {UTF_8}";

            $result = serendipity_db_schema_import($q);
        }

        if (self::upgradeFromVersion1()) {
            self::convertEntryPropertiesTags();
        } else {
            echo '<span class="msg_notice"><span class="icon-info-circled" aria-hidden="true"></span> NOT UPGRADING!</span>'."\n";
        }
    }

    /**
     * Response table created
     *
     * @param   string  table name
     * @return  boolean
     * @static
     * @see     static_install()
     */
    static function tableCreated($table = 'entrytags')
    {
        global $serendipity;

        $q = "SELECT count(tag) FROM {$serendipity['dbPrefix']}" . $table;
        $row = serendipity_db_query($q, true, 'num', false, false, false, true); // set single true and last expectError true, since table is known to fail when not exist

        if (!isset($row[0]) || !is_numeric($row[0])) { // if the response we got back was an SQL error.. :P
            return false;
        } else {
            return true;
        }
    }

    /**
     * Response upgrade from version 1
     *
     * @return  boolean
     * @static
     * @see     static_install()
     */
    static function upgradeFromVersion1()
    {
        global $serendipity;

        $q = "SELECT count(*) FROM {$serendipity['dbPrefix']}entryproperties WHERE property = 'ep_freetag_name'";
        $result = serendipity_db_query($q);

        if ((int)$result[0] > 0) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Convert entryproperties tags
     *
     * @static
     * @see     static_install()
     */
    static function convertEntryPropertiesTags()
    {
        global $serendipity;

        $q = "SELECT entryid, value FROM {$serendipity['dbPrefix']}entryproperties WHERE property = 'ep_freetag_name'";
        $result = serendipity_db_query($q);

        if (!is_array($result)) {
            return false;
        }

        foreach($result AS $entry) {
            $tags = self::makeTagsFromTaglist($entry['value']);
            self::addTagsToEntry($entry['entryid'], $tags);

            printf(PLUGIN_FREETAG_UPGRADE1_2, count($tags), $entry['entryid']);
            echo '<br />';
        }

        $q = "DELETE FROM {$serendipity['dbPrefix']}entryproperties WHERE property = 'ep_freetag_name'";
        $result = serendipity_db_query($q);
    }

    /**
     * Prepare URL ready tag
     *
     * @param   string  $tag
     * @return  string  $tag
     * @static
     * @see     displayTags()
     */
    static function makeURLTag($tag)
    {
        return str_replace('.', '%FF', urlencode($tag)); // RQ: why is this here ? Isn't %ff not ÿ = %FF = %C3%BF ?
    }

    /**
     * Simple callback method for array_map(), to avoid
     * array_map('htmlspecialchars', $array) missing the PHP 5.4+ changes
     *
     * @param   array   $param tags
     * @return  array
     * @see     specialchars_mapper()
     */
    function callback_map($a)
    {
        return htmlspecialchars($a, ENT_COMPAT, LANG_CHARSET);
    }

    /**
     * Creates displayEntry tag links markup
     *
     * @param   array   $tags
     * @param   boolean $extended_smarty
     * @return  mixed   $links
     * @see     addTags()
     */
    function getTagHtml($tags, $extended_smarty = false)
    {
        global $serendipity;
        static $taglink = null;

        $links = array();

        if ($taglink == null) {
            $taglink = $this->get_config('taglink');
        }

        if (!is_array($tags)) {
            return '';
        }

        foreach($tags AS $tag) {
            $tag = trim($tag);
            if (empty($tag)) {
                continue;
            }
            $links[] = "\n".'    <a href="' . $taglink . self::makeURLTag($tag) . '" title="' . serendipity_specialchars($tag) . '" rel="tag">' . serendipity_specialchars($tag) . '</a>';
        }

        if ($extended_smarty) {
            return $links;
        } else {
            return implode(', ', $links);
        }
    }

    /**
     * Get related entries by entry id
     *
     * @param   array   $tags
     * @param   int     $eventData[$entry]['id']
     * @return  mixed   $result
     * @see     displayEntry()
     */
    function getRelatedEntries($tags, $postID)
    {
        global $serendipity;

        if (!is_array($tags)) {
            return false;
        }

        foreach($tags AS $idx => $tag) {
            $tags[$idx] = serendipity_db_escape_string($tag);
        }

        $this->fetchHiddenCategoryTemplates();

        $conds = '';
        $join0 = $join1 = $join2 = '';
        $join0 = " LEFT JOIN {$serendipity['dbPrefix']}entries AS e2 ON e1.entryid = e2.id";

        if (!empty($this->bycategory[0]['template'])) {
            $join1  = " LEFT OUTER JOIN {$serendipity['dbPrefix']}entrycat AS ec ON (e1.entryid = ec.entryid)";
            $join0  = " LEFT JOIN {$serendipity['dbPrefix']}entries AS e2 ON ec.entryid = e2.id";
            $join2  = " LEFT OUTER JOIN {$serendipity['dbPrefix']}categorytemplates AS ct ON (ec.categoryid = ct.categoryid)";
            foreach ($this->bycategory AS $bcat) {
                if ($bcat['template'] == $serendipity['template']) {
                    $conds .= " AND (ec.categoryid = " . (int)$bcat['categoryid'] . ")";
                } else {
                    $conds .= " AND (ec.categoryid != " . (int)$bcat['categoryid'] . " OR ec.categoryid IS NULL)";
                }
            }
        }
        $q = "SELECT DISTINCT e1.entryid,
                     e2.title,
                     e2.timestamp
                FROM {$serendipity['dbPrefix']}entrytags AS e1
            $join1
            $join0
            $join2
               WHERE e1.tag IN ('" . implode("', '", $tags) . "')
                 AND e1.entryid != " . (int)$postID . "
                 AND e2.isdraft = 'false'
                " . (!serendipity_db_bool($serendipity['showFutureEntries']) ? " AND e2.timestamp <= " . time() : '') . "
                $conds
            ORDER BY e2.timestamp DESC
               LIMIT " . $this->get_config('show_related_count', 5);

        $result = serendipity_db_query($q, false, 'assoc', false, 'entryid', 'title');

        if (!is_array($result)) {
            return false;
        }

        return $result;
    }

    /**
     * Prepare related entries html markup
     *
     * @param   array       $entries
     * @param   boolean     $extended_smarty
     * @see     addRelatedEntries()
     */
    function getRelatedEntriesHtml(&$entries, $extended_smarty = false)
    {
        global $serendipity;

        if (!is_array($entries)) {
            return false;
        }

        $fakets = time();
        if ($extended_smarty) {
            $ret = array();
            $ret['description'] = PLUGIN_EVENT_FREETAG_RELATED_ENTRIES;
            foreach($entries AS $entryid => $title) {
                // prepare preset anchor link in a simple array
                $ret['entries'][] = '<a href="' . serendipity_archiveURL($entryid, $title, 'baseURL', true, array('timestamp' => $fakets)) . '" title="' . serendipity_specialchars($title) . '">' . serendipity_specialchars($title) . '</a>';
                // You can have EITHER / OR, NOT both(!), without compat break - that means, switching here by hand or have to add another plugin config option for this case.
                #$ret['entries'][] = array('url' => serendipity_archiveURL($entryid, serendipity_specialchars($title), 'baseURL', true, array('timestamp' => $fakets)) , 'title' => serendipity_specialchars($title));
                /*
                Returning the entries array this way will need you to extend the array readout in the entries.tpl extended example and may need to run this "flattened" loop as
                foreach($entries AS $entry) {
                    $ret['entries'][] = array('url' => serendipity_archiveURL($entry['id'], serendipity_specialchars($entry['title']), 'baseURL', true, array('timestamp' => $fakets)) , 'title' => serendipity_specialchars($entry['title']) , 'and so on' => 'for more additions per key' );
                }
                since now being a full multi-dimensional array, if you want to add more like an entries teaser image for example.
                See: http://board.s9y.org/viewtopic.php?f=4&t=20260&p=10443603#p10443603 ff
                */
                // OR better keep this first and use some Smarty split regex for the {$link} var (see extended_smarty example) to separate title and url again, eg.
                // {assign var="title" value=$link|strip_tags} and {assign var="url" value=$link|replace:'<a href="':''|regex_replace:'/" title="[\w\s]+">[\w\s]+/':''}
            }
            // echo '<pre>';print_r($ret);echo '</pre>';
        } else {
            // this is single entries related entries!
            $ret  = "\n".'<div class="serendipity_freeTag_related">' . PLUGIN_EVENT_FREETAG_RELATED_ENTRIES;
            $ret .= "\n    <ul class=\"plainList\">\n";
            foreach($entries AS $entryid => $title) {
                $ret .= '    <li> <a href="' . serendipity_archiveURL($entryid, $title, 'baseURL', true, array('timestamp' => $fakets)) . '" title="' . serendipity_specialchars($title) . '">' . serendipity_specialchars($title) . "</a></li>\n";
            }
            $ret .= "    </ul>\n</div>\n";
        }

        return $ret;
    }

    /**
     * Display tags for both plugins
     *  Tags should be an array with the key being the tag name, and val being
     *  the number of occurrences.
     *
     * @static
     * @see     generateContent()
     */
    static function displayTags($tags, $xml, $nl, $scaling, $maxSize = 200, $minSize = 100,
                                $cfg_taglink = '', $cfg_template = '', $xml_image = 'img/xml.gif', $useRotCanvas = false, $rcTagColor = '3E5F81', $rcTagOLColor = 'B1C1D1', $rcTagWidth = 300, $useWordCloud = false)
    {
        global $serendipity;

        if (!is_array($tags)) {
            return false;
        }

        static $taglink = null;
        if ($taglink == null) {
            $taglink = $cfg_taglink;
        }

        $template = $cfg_template;
        if (!$template) {
            self::renderTags($tags, $xml, $nl, $scaling, $maxSize, $minSize, $taglink, $xml_image, $useRotCanvas, $rcTagColor, $rcTagOLColor, $rcTagWidth, $useWordCloud);
        } else {
            arsort($tags);
            $tagsWithLinks = array();
            foreach ($tags AS $tag => $count) {
                $tagsWithLinks[$tag] = array(
                    'count' => $count,
                    'href'  => $taglink . self::makeUrlTag($tag),
                );
            }
            $serendipity['smarty']->assign('tags', $tagsWithLinks);
            $template = serendipity_getTemplateFile($template, 'serendipityPath');
            $serendipity['smarty']->display($template);
        }
    }

    /**
     * Render the tags
     *
     * @static
     * @see     displayTags()
     */
    static function renderTags($tags, $xml, $nl, $scaling, $maxSize, $minSize, $taglink, $xml_image, $useRotCanvas, $rcTagColor, $rcTagOLColor, $rcTagWidth, $useWordCloud)
    {
        global $serendipity;

        // Hey! Do NOT allow mixing clouds !
        if ($useRotCanvas && $useWordCloud) {
            $useRotCanvas = false;
        }
        if ($useWordCloud && $useRotCanvas) {
            $useWordCloud = false;
        }
        if ($useRotCanvas && $useWordCloud) {
            $useRotCanvas = false;
        }
        // wordcloud needs scaling! I am sorry for this hardcoded exception!
        if (!$scaling && $useWordCloud) {
            $scaling = true;
        }

        $rsslink  = $serendipity['serendipityHTTPPath'] . 'rss.php?serendipity%5Btag%5D=';
        $xmlImg   = serendipity_getTemplateFile($xml_image);

        $first    = true;
        $biggest  = max($tags); // these 2 are weight counts by tag (which already are in the array)
        $smallest = min($tags); // eg 0.5

        // get a descending multiplier for useWordCloud by tags (does this really work and change the actual scale?)
        $cTags    = count($tags);
        $multiply = ($cTags > 33) ? 2 : 3;
        $multiply = ($cTags > 66) ? 1 : $multiply;

        $scale    = ($biggest - $smallest); // eg. 3 - 0.5 = 2.5

        if ($scale < 0) {
            $scale = 1;
        }

        $key = uniqid(rand());

        if ($useRotCanvas) {

            echo '
                <div id="freeTagCanvas' . $key . '" class="freetag_rotacloud">
                    <canvas id="tagCanvas' . $key . '" class="rotaCanvas" width="' . $rcTagWidth .'" height="' . round($rcTagWidth * 0.75) . '">
                        <!--<p style="color:#222">Sorry! Your browser is too old to support this canvas element!</p>-->
                    </canvas>
                </div>
                <div id="tags" style="z-index: -1; margin-top: -' . round($rcTagWidth * 0.33) . 'rem">
                    <ul class="plainList">
                ';// Remember: Why do we set a #tags -margin-top height here? Since it prevents an empty block in case the rotacloud could not display and this taglist is used as a fallback!

        } elseif ($useWordCloud) {

            echo '
                <div id="freetag_wordcloud' . $key . '" class="freetag_wordcloud">
                ';

        } else {
            echo "<ul class=\"plainList\">\n";
        }

        $tagparam = '';
        $html     = '';

        echo "\n ";

        foreach($tags AS $name => $quantity) {
            if (empty($name)) {
                continue;
            }

            $title = serendipity_specialchars($name);

            if (!$first && !$nl) {
                if (!$scaling) {
                    $html .= ', ';
                } else {
                    $html .= ' ';
                }
            }

            // don't use with canvas cloud elements!
            if ($xml && !$useRotCanvas && !$useWordCloud) {
                $html .= '<li class="serendipity_freeTag_xmlTagEntry"><a rel="tag" class="serendipity_xml_icon" href="' . $rsslink . urlencode($name) . '" title="' . $title . '">'.
                         '<img alt="xml" src="' . $xmlImg . '" class="serendipity_freeTag_xmlButton" /></a> ';
            }
            if ($useRotCanvas) {
                $html .= '<li>';
            }

            // scaling does not work with jquery rotating Canvas
            if ($scaling && !$useRotCanvas) {
                if ($scale == 0) {
                    $fontSize = $maxSize;
                } elseif ($scale == 1) {
                    $fontSize = ($quantity == $biggest) ? $maxSize : $minSize;
                } else {
                    $fontSize = round(($quantity - $smallest)*(($maxSize - $minSize)/($scale))) + $minSize;
                }
                if ($useWordCloud) {
                    $weight = round(($fontSize / 10) * $multiply);
                    $xmlweight = $xml ? ' style="font-size: '. $fontSize .'%; white-space: normal;"' : '';
                    $html .= '<span class="tag_weight_' . $fontSize . '" data-weight="' . $weight . '" title="' . $title . '"'.$xmlweight.'>';
                } else {
                    $html .= '<span class="tag tag_weight_' . $fontSize . '" style="font-size: '. $fontSize .'%; white-space: normal;">';
                }
            } else {
                $fontSize = 100;
            }

            $html .= '<a rel="tag" href="' . $taglink . self::makeURLTag($name) . '" title="' . $title . ($quantity > 0 ? ' (' . $quantity . ')' : '') . '">' . $title . '</a>';

            if ($scaling && !$useRotCanvas) {
                $html .= "</span>\n";
            }

            if (($xml || $useRotCanvas) && !$useWordCloud) {
                $html .= "</li>\n";
            }

            if ($nl && !$useRotCanvas && !$useWordCloud) {
                $html .= "<br />\n";
            }

            $first = false;
            $tagparam .= "%3Ca href='" . $taglink . self::makeURLTag($name) . "' style='" . round($fontSize/5) . "'%3E" . str_replace(' ', '&nbsp;', $title) . "%3C/a%3E";
        }

        echo $html;

        if ($useRotCanvas) {
            echo '
                    </ul>
                </div>
                <script type="text/javascript">
                    window.onload = function() {
                        if (!jQuery.isFunction(jQuery.fn.tagcanvas) ) { return false; }
                        if(!jQuery("#tagCanvas' . $key . '").tagcanvas({
                                textColour: "#'.$rcTagColor.'",
                                outlineColour: "#'.$rcTagOLColor.'",
                                reverse: true,
                                depth: 0.8,
                                maxSpeed: 0.05
                                },"tags")) {
                            // something went wrong, hide the canvas container
                            jQuery("#freeTagCanvas' . $key . '").hide();
                        }
                    };
                </script>
                ';
        } elseif ($useWordCloud) {

            $grid = ($multiply == 3) ? 3 : 9; // reverse for the grid to reduce render slowdowns with too many tags
            $grid = ($multiply == 2) ? 6 : $grid;  // with a small amount of tags grid could be set to 1 too
            echo '
                </div>
                <script type="text/javascript">
                    window.onload = function() {
                        if (!jQuery.isFunction(jQuery.fn.awesomeCloud) ) { return false; }
                        jQuery("#freetag_wordcloud' . $key . '").awesomeCloud({
                            "size" : {
                                "grid" : '.$grid.',
                                "factor" : 0
                            },
                            "options" : {
                                "color" : "random-dark",
                                "rotationRatio" : 0.35
                            },
                            "font" : "\'Times New Roman\', Times, serif",
                            "shape" : "circle"
                        });
                    };
                </script>
                ';
        } else {
            echo "</ul>\n";
        }
    }

    /**
     * Return case sensitive array_unique
     *
     * @param   array
     * @return  array
     * @see     various self methods
     */
    function array_iunique($a)
    {
        if (function_exists('mb_strtolower')) {
            return array_intersect_key($a, array_unique(array_map('mb_strtolower', $a)));
        } else {
            return array_intersect_key($a, array_unique(array_map('strtolower', $a)));
        }
    }

    /**
     * Return array_map callback for strtolower
     *
     * @param   array
     * @return  array
     * @see     displayEntry() and getTagCloudTags()
     */
    function array_imap($a)
    {
        if (function_exists('mb_strtolower')) {
            return array_map('mb_strtolower', $a);
        } else {
            return array_map('strtolower', $a);
        }
    }

    /**
     * Hook for Serendipity events, initializes plug-in features
     *
     * This method is called by the main plugin API for every event, that is executed.
     * You need to implement each actions that shall be performed by your plugin here.
     *
     * @access  public
     * @param   string    The name of the executed event
     * @param   object    A property bag for the current plugin
     * @param   mixed     Any referenced event data from the serendipity_plugin_api::hook_event() function
     * @param   mixed     Any additional data from the hook_event call
     * @return  bool
     */
    function event_hook($event, &$bag, &$eventData, $addData = null)
    {
        global $serendipity;
        static $jquery = null;

        $hooks = &$bag->get('event_hooks');

        if (isset($hooks[$event])) {

            // Do not output when core jQuery is already used in page head OR by theme in page foot
            if ($jquery === null) {
                $jquery = (false === $serendipity['capabilities']['jquery'] && serendipity_db_bool($this->get_config('show_ft_jquery', 'false')));
            }

            switch($event) {

                case 'frontend_footer':
                    // Don't run in/via commentpopup
                    if (!empty($serendipity['GET']['entry_id']) && isset($serendipity['GET']['type']) && in_array($serendipity['GET']['type'], ['comments', 'trackbacks'])) {
                        break;
                    }
                    // we load both in either case, as long as the option show_tagcloud is enabled,
                    // since it could be that someone wants to use two different clouds (plain, wordcanvas, rotacanvas), differed by event/sidebar plugin!
                    // Changed to use by option and / or freetag sidebar class installed
                    if (serendipity_db_bool($this->get_config('show_tagcloud', 'true')) && (serendipity_db_bool($this->get_config('use_wordcloud', 'true')) || serendipity_db_bool($this->get_config('use_rotacloud', 'true')) || class_exists('serendipity_plugin_freetag'))) {
                        if ($jquery) {
                        echo '
    <script type="text/javascript" src="'.$serendipity['serendipityHTTPPath'].'plugins/serendipity_event_freetag/jquery-1.11.3.min.js"></script>
';
                        }
                        echo '
    <script type="text/javascript" src="'.$serendipity['serendipityHTTPPath'].'plugins/serendipity_event_freetag/jquery.tagcanvas.min.js"></script>
    <script type="text/javascript" src="'.$serendipity['serendipityHTTPPath'].'plugins/serendipity_event_freetag/jquery.awesomeCloud-0.2.js"></script>
';
                    }

                    if (isset($serendipity['GET']['id'])) {
                        $this->displayMetaKeywords($serendipity['GET']['id'], $this->displayTag);
                    }
                    break;

                case 'frontend_display:rss-2.0:per_entry':
                    if (!isset($eventData['display_dat'])) $eventData['display_dat'] = '';
                    if (isset($eventData['properties']['freetag_tags'])) {
                        $eventData['display_dat'] .= $this->getFeedXmlForTags('category', $eventData['properties']['freetag_tags']);
                    }
                    break;

                case 'frontend_display:rss-1.0:per_entry':
                case 'frontend_display:atom-1.0:per_entry':
                    if (!isset($eventData['display_dat'])) $eventData['display_dat'] = '';
                    if (isset($eventData['properties']['freetag_tags'])) {
                        $eventData['display_dat'] .= $this->getFeedXmlForTags('dc:subject', $eventData['properties']['freetag_tags']);
                    }
                    break;

                case 'external_plugin':
                    $uri_parts      = explode('?', str_replace(array('&amp;', '%FF'), array('&', '.'), $eventData));// RQ: see makeURLTag() RQ
                    $ctaglist       = serendipity_db_bool($this->get_config('taglist', 'false'));
                    $param          = $ctaglist ? explode('/', str_replace('/taglist', '', $uri_parts[0])) : explode('/', $uri_parts[0]);
                    $plugincode     = array_shift($param);

                    // Added by option or manually: example.org/plugin/taglist/Serendipity/Blog/Plums - see in displayExternalTaglist()
                    if ($plugincode == 'taglist') {
                        $plugincode = 'tags';
                    }

                    if ($plugincode == 'tag' || $plugincode == 'tags' || $plugincode == 'freetag') {
                        $this->displayExternalTaglist($param, $ctaglist);
                    }
                    break;

                case 'backend_delete_entry':
                    $this->deleteTagsForEntry((int)$eventData);
                    break;

                case 'backend_sidebar_entries':
                    echo "\n".'                        <li><a href="?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=managetags">' . PLUGIN_EVENT_FREETAG_MANAGETAGS . '</a></li>'."\n";
                    break;

                case 'backend_sidebar_entries_event_display_managetags':
                    $this->eventData = $eventData; // sets "global" object array eventData
                    $this->displayManageTags();
                    break;

                case 'backend_publish':
                case 'backend_save':
                    if (!isset($eventData['id'])) {
                        break;
                    }
                    if (isset($serendipity['GET']['tagview']) && $serendipity['GET']['tagview'] == 'tagupdate' && !serendipity_db_bool($this->get_config('keyword2tag', 'false'))) {
                        break;
                    }

                    // run old tags, automated tags, category tags list merge for addTagsToEntry/deleteTagsForEntry
                    $this->backend_fetch_tags_for_saving($eventData);

                    // PLEASE NOTE: This action modifies the 'last_modified' field for every entry success in serendipity_updertEntry(), not really being necessary though.
                    // REMEMBER   : Never ever unset($eventData) here, since this can change and hit other plugins content too!
                    break;

                case 'css_backend':
                    // temporarily check beneath Styx 3.4
                    if (false === strpos($eventData, '.x-button_link.x-button_up svg.bi.bi-arrow-up-square-fill')) {
                        $eventData .= '
.x-button_link.x-button_up svg.bi.bi-arrow-up-square-fill {
    width: 1.75rem;
    height: 1.75rem;
    fill: #222;
}
';
                    }
                    $eventData .= '

/* freetag plugin start */

a.button_link.tagview_active {
    box-shadow: 0 4px 6px -3px #0066ff;
    z-index: 1;
}
[data-color-mode="dark"] a.button_link.tagview_active {
    background: var(--color-bg-primary);
    box-shadow: 0 4px 6px -3px #cdd9e5;
}

.freetagMenu svg[class^="icon-"]:before, .freetagMenu svg[class*=" icon-"]:before {
  font-style: normal;
  font-weight: normal;
  speak: none;
  display: inline-block;
  text-decoration: inherit;
  width: 1em;
  margin-right: .2em;
  text-align: center;
  font-variant: normal;
  text-transform: none;
  /* Font smoothing. That was taken from TWBS */
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
}

.freetagMenu svg.icon {
    width: 1rem;
    height: 1rem;
    vertical-align: middle;
}
.freetagMenu svg.icon-tags:before { content: \'\e805\'; }
.freetagMenu svg.icon-tag:before { content: \'\e804\'; }
.freetagMenu svg.icon-notag:before { content: \'\f0f6\'; }
.freetagMenu svg.icon-leaftag:before { content: \'\f15c\'; }
.freetagMenu svg.icon-keytag:before { content: \'\e803\'; }
.freetagMenu svg.icon-ctag:before { content: \'\e807\'; }
.freetagMenu svg.icon-autotag:before { content: \'\e802\'; }
.freetagMenu svg.icon-cleantag:before { content: \'\e806\'; }

.freetagMenu svg.icon-notag,
.freetagMenu svg.icon-leaftag,
.freetagMenu svg.icon-ctag,
.freetagMenu svg.icon-autotag,
.freetagMenu svg.icon-cleantag {
    vertical-align: baseline;
    -webkit-transform: rotate(180deg);
    -moz-transform: rotate(180deg);
    -ms-transform: rotate(180deg);
    -o-transform: rotate(180deg);
    transform: rotate(180deg);
}

#backend_freetag_list a.tagzoom {
    font-size: 0.875em;
}

.plainList.freetags_list .odd {
    background-color: #EEE;
    border: 1px solid #DDD;
}

#edit_entry_freetags .freetag_entry_submit {
    top: 1em; /* without core #adv_opts background: 0; */
}
/* unset up button block for .mfp-content layer */
.mfp-content #edit_entry_freetags .freetag_entry_submit {
    top: unset;
}
.mfp-content #edit_entry_freetags div {
    position: unset;
    right: unset;
    margin-right: unset;
}
.mfp-content #edit_entry_submit {
    display: none;
    visibility: hidden;
}

.freetagMenu li {
    display: inline-block;
    margin: 0 0 .5em;
    vertical-align: middle;
}
.freetagMenu li:nth-child(1) .button_link {
    padding: 5px 8px;
}
.freetagMenu li:nth-child(2) .button_link {
    padding: 5px 8px;
}
.freetagMenu li:nth-child(6) .button_link {
    padding: 4px 10px 4px 4px;
}

.freetags_manage {
    border: 1px solid #aaa;
    border-bottom: 0 none;
    width: 100%;
}

.freetags_manage thead tr {
    background-color: #eee;
}

.freetags_manage tr {
    border-bottom: 1px solid #aaa;
}

.freetags_manage th,
.freetags_manage td {
    padding: .125em .25em;
}

.freetags_list li {
    margin: 0 0 .25em;
}

@media only screen and (min-width: 768px) {
    .freetagMenu li {
        margin: 0 .25em .5em 0;
    }
}

/* freetag plugin end */

';
                    break;

                case 'js_backend':
                    $close = false;
                    // show_taglist adding function
                    if (serendipity_db_bool($this->get_config('admin_show_taglist', 'true'))) {
                        $close = true;

?>

/* serendipity_event_freetag start */

function addTag(addTag) {
    var elem = document.getElementById('properties_freetag_tagList');
    var freetags = elem.value.split(',');

    inList = false;
    for (var freetag = 0; freetag < freetags.length; freetag++) {
        if (freetags[freetag] && trim(freetags[freetag].toLowerCase()) == addTag.toLowerCase()) {
            inList = true;
        }
    }

    if (!inList) {
        if (elem.value.lastIndexOf(',') == (elem.value.length-1)) {
            sepChar = '';
        } else {
            sepChar = ',';
        }

        elem.value = elem.value + sepChar + addTag;
        elem.focus();
    }
}

function trim(str) {
    if (str) return str.replace(/^\s*|\s*$/g,'');
    else return '';
}

<?php

                    }
                    // autocomplete with serendipity 2.0
                    if (serendipity_db_bool($this->get_config('admin_ftayt', 'false'))) {

?>

function enableAutocomplete() {
    if (typeof(tags) != 'undefined') {
        function split(val) {
            return val.split(/,\s*/);
        }
        function extractLast(term) {
            return split(term).pop();
        }
        $('#properties_freetag_tagList')
            .bind('keydown', function (event) {
                // dont navigate away from the field on tab when selecting an item
                if (event.keyCode === 9 && $(this).data('ui-autocomplete').menu.active) {
                    event.preventDefault();
                }
            })
            .autocomplete({
                minLength: 0,
                source: function (request, response) {
                    // delegate back to autocomplete, but extract the last term
                    response($.ui.autocomplete.filter(tags, extractLast(request.term)));
                },
                focus: function () {
                    // prevent value inserted on focus
                    return false;
                },
                select: function (event, ui) {
                    var terms = split(this.value);
                    // remove the current input
                    terms.pop();
                    // add the selected item
                    terms.push(ui.item.value);
                    // add placeholder to get the comma-and-space at the end
                    terms.push('');
                    this.value = terms.join(',');
                    return false;
                }
            });
    }
};

document.addEventListener("DOMContentLoaded", function() {
    enableAutocomplete();
});

<?php
                    }
                    if ($close) {
?>
/* serendipity_event_freetag end */
<?php
                    }
                    break;

                case 'backend_display':
                    $this->backend_display(($eventData['id'] ?? null)); // new entry forms don't have $eventData['id'] set
                    break;

                case 'frontend_entryproperties':
                    $this->importEntryTagsIntoProperties($eventData, $addData);
                    break;

                case 'frontend_fetchentries':
                case 'frontend_fetchentry':
                    $this->frontend_fetch_showtag($eventData);
                    break;

                case 'frontend_rss':
                    if (!empty($this->displayTag)) {
                        $eventData['title'] .= serendipity_utf8_encode(serendipity_specialchars(' (' . sprintf(PLUGIN_EVENT_FREETAG_USING, $this->displayTag) . ')'));
                    }
                    break;

                case 'entries_header':
                    if (isset($eventData['plugin_vars']['tag']) && serendipity_db_bool($this->get_config('show_tagcloud', 'true'))) {
                        if (!is_array($eventData['plugin_vars']['tag'])) {
                            $this->displayTagCloud($eventData['plugin_vars']['tag']); // single url tag only
                        } else {
                            $serendipity['smarty']->assign('freetag_tagTitle', serendipity_specialchars(is_array($this->displayTag) ? implode(', ',$this->displayTag) : $this->displayTag));
                            $serendipity['smarty']->assign('freetag_isList', true); // do not show the related tags cloud markup itself!
                            echo $this->parseTemplate('plugin_freetag.tpl');
                        }
                    }
                    // assign two helper vars, to remove certain CSS by document ready DOM overwriting scripts at the end of your templates index.tpl, for example
                    // works for relatedTags clouds and sidebar environments - because of (a possible) /archive (hooked cloud) it has to be in this (more global) hook, else it could be in 'frontend_fetchentr***'
                    $serendipity['smarty']->assign(
                        array(
                            'tagcanvasrotate' => serendipity_db_bool($this->get_config('use_rotacloud', 'false')),
                            'tagcanvascloud'  => serendipity_db_bool($this->get_config('use_wordcloud', 'false'))
                        )
                    );
                    break;

                case 'css':
                    // CSS class does NOT exist by user customized template styles, include the default styles
                    if (strpos($eventData, '.wordcloud') === false) {
                        $this->cloudToCSS($eventData);
                    }
                    // shutdown the more old styles, since 2k11 delivers .serendipity_freeTag and some other freetag related selectors
                    if (strpos($eventData, '.serendipity_freeTag') === false) {
                        $this->addToCSS($eventData);
                    }
                    $eventData .= '
/* additional freetag styles */
.serendipity_freetag_taglist .ftr-empty {
    margin-left: 1rem;
    font-style: italic;
    color: #6495ed;
}

';
                    break;

                case 'entry_display':
                    if (is_array($eventData)) {
                        $this->taggedEntries = count($eventData);
                        if (serendipity_db_bool($this->get_config('send_http_header', 'true'))) {
                            @header('X-FreeTag-Count: Array');
                        }
                    } else {
                        if (serendipity_db_bool($this->get_config('send_http_header', 'true'))) {
                            @header('X-FreeTag-Count: Empty');
                        }
                        $this->taggedEntries = 0;
                    }
                    // Don't display entries if passed true by 'external_plugin'
                    if ($this->displayTag === true) {
                        $eventData['clean_page'] = true;
                        break;
                    }
                    // places the entries tags in entry footer
                    $this->displayEntry($eventData, $addData);
                    break;

                case 'xmlrpc_updertEntry':
                    if (isset($eventData['id']) && isset($eventData['mt_keywords'])) {
                        //XMLRPC call
                        $tags = self::makeTagsFromTagList($eventData['mt_keywords']);
                        if (!empty($tags)) {
                            $this->deleteTagsForEntry($eventData['id']);
                            $this->addTagsToEntry($eventData['id'], $tags);
                        }
                    }
                    break;

                case 'xmlrpc_fetchEntry':
                    $eventData['mt_keywords'] = implode(',', $this->getTagsForEntry($eventData['id'])); // as STRING

                    break;

                case 'xmlrpc_deleteEntry':
                    if (isset($eventData["id"])) {
                        $this->deleteTagsForEntry($eventData["id"]);
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
     * Fetch and memorize possible hidden set categories by categorytemplates
     */
    function fetchHiddenCategoryTemplates()
    {
        global $serendipity;

        if (!isset($this->bycategory[0]) && class_exists('serendipity_event_categorytemplates')) {
            $this->bycategory = serendipity_db_query("SELECT categoryid, template FROM {$serendipity['dbPrefix']}categorytemplates WHERE hide = 1", false, 'assoc');
        }
    }

    /**
     * Exclude possible [categorytemplates] hidden set category items from main blog entries
     *         when searched by tag(s)
     * @see frontend_fetch_showtag()
     * @param   string      $cond by reference
     */
    function addCategoryTemplatesCondition(&$cond)
    {
        $conds = array();

        $this->fetchHiddenCategoryTemplates();

        if (!empty($this->bycategory[0]['template'])) {
            foreach ($this->bycategory AS $bcat) {
                $conds[] = "(ec.categoryid != " . (int)$bcat['categoryid'] . " OR ec.categoryid IS NULL)";
            }
        }
        $cond .= !empty($conds) ? ' AND (' .implode(' AND ', $conds) .') ' : '';
    }

    /**
     * Places the entries tags in entry footer
     *
     * @param   array       $eventData by reference
     * @param   array       $addData possible hooked plugin data by entryproperties
     */
    function displayEntry(&$eventData, $addData)
    {
        global $serendipity;

        $show_related = serendipity_db_bool($this->get_config('show_related', 'true'));
        $to_lower     = serendipity_db_bool($this->get_config('lowercase_tags', 'true'));

        $elements = is_array($eventData) ? count($eventData) : 0;

        // If not using extended-smarty, we want related entries only when
        // showing one single entry. It is better to ask Smarty here than doing
        // this manually for edge cases like overview pages
        $manyEntries = ! $serendipity['smarty']->getTemplateVars('is_single_entry');

        for ($entry = 0; $entry < $elements; $entry++) {
            if (isset($eventData[$entry]['id'])) {
                // runs everywhere to generate a flattened array of tags
                $tags = $this->getTagsForEntry($eventData[$entry]['id']); // as ARRAY

                if ($to_lower) {
                    $tags =  $this->array_imap($tags); // set to_lower for frontend entries (new)
                }

                // when in preview, maybe there are no tags stored yet
                if ($addData['preview'] && empty($tags)) {
                    $tags = explode(',', (isset($serendipity['POST']['properties']['freetag_tagList']) ? $serendipity['POST']['properties']['freetag_tagList'] : ''));
                }
                $eventData = $this->addTags($entry, $tags, $eventData);

                if ($show_related) {
                    $relatedEntries = $this->getRelatedEntries($tags, $eventData[$entry]['id']);
                    $eventData = $this->addRelatedEntries($entry, $manyEntries, $relatedEntries, $eventData);
                }
            }
        }
    }

    /**
     * Add related entries to eventData[$entry]
     *
     * @param   array   $entry
     * @param   boolean $manyEntries Smarty 'is_single_entry' templateVar
     * @param   array   $relatedEntries
     * @param   array   $eventData as copy
     * @return  array   $eventData
     * @see     displayEntry()
     */
    function addRelatedEntries($entry, $manyEntries, $relatedEntries, $eventData)
    {
        if (is_array($relatedEntries)) {
            if (serendipity_db_bool($this->get_config('extended_smarty', 'false'))) {
                $eventData[$entry]['freetag']['extended'] = true;
                $eventData[$entry]['freetag']['related'] = $this->getRelatedEntriesHtml($relatedEntries, true);
            } else if (!$manyEntries) {
                $field = $this->getField($eventData, $entry);
                // work with getFieldReference to prevent caching-issues
                $entryText =& $this->getFieldReference($field, $eventData[$entry]);
                $entryText .= $this->getRelatedEntriesHtml($relatedEntries);
            }
        }
        return $eventData;
    }

    /**
     * $entry: number of entry in $eventData
     *
     * @param   array   $entry
     * @param   boolean $manyEntries Smarty 'is_single_entry' templateVar
     * @param   array   $eventData as copy
     * @see     displayEntry()
     */
    function addTags($entry, $tags, $eventData)
    {
        if (!is_array($eventData)) {
            $eventData = array();
        }

        if (serendipity_db_bool($this->get_config('extended_smarty', 'false'))) {
            $eventData[$entry]['freetag']['extended'] = true;
            $eventData[$entry]['freetag']['tags']['description'] = str_replace('%s', '', PLUGIN_EVENT_FREETAG_LIST);
            $eventData[$entry]['freetag']['tags']['tags'] = $this->getTagHtml($tags, true);
        } else {
            if (!empty($tags)) {
                $field = $this->getField($eventData, $entry);
                $msg   = '<div class="serendipity_freeTag">' . PLUGIN_EVENT_FREETAG_LIST . "\n</div>\n";
                // in preview, $eventData may not contain the field at this point
                if (!isset($eventData[$entry][$field])) {
                    $eventData[$entry][$field] = '';
                }
                // work with getFieldReference to prevent caching-issues
                $entryText =& $this->getFieldReference($field, $eventData[$entry]);
                $entryText .= "\n".sprintf($msg, $this->getTagHtml($tags));
            }
        }
        return $eventData;
    }

    /**
     * Define and return entry field in eventData by condition
     *
     * @param   array   $eventData as copy
     * @param   int     entry id
     * @see     addRelatedEntries() and addTags()
     */
    function getField($eventData, $entry)
    {
        $embed_footer = $this->get_config('embed_footer', 'true');
        if ($embed_footer === 'yes' || ($embed_footer !== 'no' && serendipity_db_bool($embed_footer))) {
            $field = 'add_footer';
        } else if ($embed_footer === 'smarty') {
            $field = 'freetag';
        } else {
            if (strlen($eventData[$entry]['extended']) > 0) {
                $field = 'extended';
            } else {
                $field = 'body';
            }
        }
        return $field;
    }

    /**
     * Returns an array of string tagList
     *
     * @param   string   tagList
     * @return  array
     * @static
     * @see     convertEntryPropertiesTags()
     */
    static function makeTagsFromTaglist($tagList)
    {
        $tags = array();
        $freetags = explode(',', $tagList);
        foreach($freetags AS $tag) {
            $tag = trim($tag);
            if (!empty($tag)) {
                $tags[] = $tag;
            }
        }
        return $tags;
    }

    /**
     * Returns a list of all tags
     *
     *  This performs a memorization operation, so that if we happen to be
     *  getting all tags more then one time per request, we only perform
     *  the SQL query once
     *
     * @static  ?? (RQ: while using $memo ?)
     * @see     displayManageTags() case 1/5 and backend_display()
     */
    static function getAllTags()
    {
        global $serendipity;

        static $memo = false;

        if (is_array($memo)) {
            return $memo;
        }

        $q = "SELECT tag, count(tag) AS total
                FROM {$serendipity['dbPrefix']}entrytags
            GROUP BY tag
            ORDER BY tag";

        $rows = serendipity_db_query($q);

        if (!is_array($rows)) {
            return array();
        }

        $memo = array();
        foreach((array)$rows AS $r) {
            $memo[$r['tag']] = $r['total'];
        }

        serendipity_plugin_api::hook_event('sort', $memo);

        return $memo;
    }

    /**
     * event hook: entries_header executor
     *
     * @param   string  $tag is single URL tag only $eventData['plugin_vars']['tag']
     */
    function displayTagCloud($tag)
    {
        global $serendipity;

        $tags = $this->getTagCloudTags($tag);

        $serendipity['smarty']->assign('freetag_tagTitle', serendipity_specialchars(is_array($this->displayTag) ? implode(', ',$this->displayTag) : $this->displayTag));

        if (!empty($tags)) {
            $useRotCanvas = serendipity_db_bool($this->get_config('use_rotacloud', 'false'));
            $useWordCloud = serendipity_db_bool($this->get_config('use_wordcloud', 'false'));
            $serendipity['smarty']->assign('freetag_hasTags', true);

            $min = $this->get_config('min_percent', 100);
            $max = $this->get_config('max_percent', 300);

            ob_start();
            self::displayTags($tags, false, false, true, $max, $min,
                                                   $this->get_config('taglink'), $this->get_config('template'), $this->get_config('xml_image', 'img/xml.gif'),
                                                   $useRotCanvas, $this->get_config('rotacloud_tag_color', '3E5F81'), $this->get_config('rotacloud_tag_border_color', 'B1C1D1'), $this->get_config('rotacloud_width', '500'),
                                                   $useWordCloud);
            $tagout = ob_get_contents();
            ob_end_clean();
            $serendipity['smarty']->assign('freetag_displayTags', $tagout);
        } else {
            $serendipity['smarty']->assign('freetag_hasTags', false);
        }

        $content = $this->parseTemplate('plugin_freetag.tpl');
        echo $content;
    }

    /**
     * descend: if true, get the related tags of the related tags of given tag
     *
     * @param   string  $tag
     * @param   boolean $descend
     * @return  array   $tags
     * @see     displayTagCloud() and displayMetaKeywords()
     */
    function getTagCloudTags($tag, $descend = true)
    {
        $to_lower = serendipity_db_bool($this->get_config('lowercase_tags', 'true'));

        $rows = serendipity_db_query($this->getTagCloudQuery($tag));

        $tags = array();
        if (is_array($rows)) {
            foreach((array)$rows AS $r) {

                if ($to_lower) {
                    $r = $this->array_imap($r); // set to_lower for Frontend clouds (new)
                }
                $tags[$r['tag']] = $r['total'];

                // get also tags which are related only by other tags
                if ($descend) {
                    $descended_tags = $this->getTagCloudTags($r['tag'], false);
                    if (is_array($descended_tags)) {
                        foreach($descended_tags AS $dtag => $value) {
                            $descended_tags[$dtag] = $value / 2;
                        }
                        #$tags = array_merge($tags, $descended_tags);
                        $tags = $tags + $descended_tags;
                    }
                }
            }
        }
        unset($tags["$tag"]);
        return $tags;
    }

    /**
     * Prepare tag cloud query
     *
     * @param   string  $sort
     * @return  array   $tags
     * @see     getTagCloudTags()
     */
    function getTagCloudQuery($tag, $sort = '')
    {
        global $serendipity;

        $ct_where = '';
        $ct_conds = '';
        $ct_joins = '';

        $this->fetchHiddenCategoryTemplates();

        if (!empty($this->bycategory[0]['template'])) {
            $ct_joins .= " LEFT OUTER JOIN {$serendipity['dbPrefix']}entrycat AS ec ON (et.entryid = ec.entryid)";
            $ct_joins .= " LEFT OUTER JOIN {$serendipity['dbPrefix']}categorytemplates AS ct ON (ec.categoryid = ct.categoryid)";
            $ct_where .= " WHERE 1=1 ";
            foreach ($this->bycategory AS $bcat) {
                if ($bcat['template'] == $serendipity['template']) {
                    $ct_conds .= " AND (ec.categoryid = " . (int)$bcat['categoryid'] . ")";
                } else {
                    $ct_conds .= " AND (ec.categoryid != " . (int)$bcat['categoryid'] . " OR ec.categoryid IS NULL)";
                }
            }
        }

        if ($tag === true) {
            $q = "SELECT et.tag, count(et.tag) AS total
                    FROM {$serendipity['dbPrefix']}entrytags AS et
                    $ct_joins
                    $ct_where
                    $ct_conds
                GROUP BY tag ORDER BY tag";
        } else {

            if (is_string($tag)) {
                $cond  = "et.tag = '" . serendipity_db_escape_string($tag) . "'";
                $ncond = "neg.tag != '" . serendipity_db_escape_string($tag) . "'";
                $join  = "LEFT JOIN {$serendipity['dbPrefix']}entrytags AS neg ".
                                "ON et.entryid = neg.entryid ";
                $totalModifier = '';
            } else if (is_array($tag)) {
                 $join = "LEFT JOIN {$serendipity['dbPrefix']}entrytags AS neg ".
                                "ON et.entryid = neg.entryid ";
                $ccond = '';
                $ncond = '';

                $first = true;
                $total = count($tag);

                $totalModifier = " - $total";

                for ($i = 0; $i < $total; $i++) {
                    if (!$first) {
                        $ncond .= " AND ";
                        $cond  .= " AND ";
                    } else {
                        $first = false;
                    }

                    $join  .= "LEFT JOIN {$serendipity['dbPrefix']}entrytags AS sub{$i} ".
                                     "ON et.entryid = sub{$i}.entryid ";
                    $cond  .= "sub{$i}.tag = '" . serendipity_db_escape_string($tag[$i]) . "' ";
                    $ncond .= "neg.tag != '" . serendipity_db_escape_string($tag[$i]) . "' ";
                }
            } else {
                return;
            }
            $q = "SELECT neg.tag AS tag, count(neg.tag) {$totalModifier} AS total
                    FROM {$serendipity['dbPrefix']}entrytags AS et
               {$join}
                $ct_joins
                   WHERE ($cond)
                     AND ($ncond)
                    $ct_conds
                GROUP BY neg.tag";
        }

        $mt = $this->get_config('max_tags', 0);

        if ($mt > 0 && $sort == '') {
            $q = $q . " LIMIT " . $mt;
        }

        return $q;
    }

    /**
     * event hook: frontend_header/frontend_footer meta field executor
     *  uses global object variable tag
     *
     * @param   int  GET id
     */
    function displayMetaKeywords($id, $tag)
    {
        global $serendipity;

        $id = (int)$id; // cast secure
        $max_keywords = (int)$this->get_config('meta_keywords', 0);
        if ($max_keywords < 1) {
            return;
        }

        if ($tag !== false && $tag !== true) { //show related tags
            $query = $this->getTagCloudQuery($tag, ' ORDER BY total DESC LIMIT ' . $max_keywords);
        } else if ($id == null) { // show all tags
            // select most used tags in descending order
            $query = "SELECT tag,
                             count(tag) AS total
                        FROM {$serendipity['dbPrefix']}entrytags
                    GROUP BY tag
                    ORDER BY total DESC
                       LIMIT " . $max_keywords;
        } else { // show tags for entry
            // select tags from entry $id ordered by most usage descending
            $query = "SELECT one.tag,
                             two.entryid,
                             count(two.tag) AS total
                        FROM {$serendipity['dbPrefix']}entrytags
                          AS one
                        JOIN {$serendipity['dbPrefix']}entrytags AS two
                          ON two.entryid = " . $id . "
                         AND one.tag = two.tag
                    GROUP BY one.tag, two.entryid
                    ORDER BY total DESC
                       LIMIT " . $max_keywords;
        }
        $rows = serendipity_db_query($query);
        if (!is_array($rows)) {
            return;
        }

        echo '    <meta name="keywords" content="';
        if (isset($this->tags['show'])) {
            if (is_array($this->tags['show'])) {
                $not_first = false;
                foreach($this->tags['show'] AS $r) {
                    if (isset($not_first) && $not_first === true) {
                        print(', ');
                    } else {
                        $not_first = true;
                    }
                    echo $r;
                }
            } else {
                echo $this->tags['show'];
                $not_first = true;
            }
        }
        foreach($rows AS $r) {
            if (empty($r['tag'])) {
                continue;
            }
            if (isset($not_first) && $not_first === true) {
                print(', ');
            } else {
                $not_first = true;
            }
            echo serendipity_specialchars($r['tag']);
        }
        echo "\" />\n";
    }

    /**
     * Prepare and fetch all leaf tags
     *
     * @return  array   $tags
     * @see     displayManageTags() case 2
     */
    function getLeafTags($leafWeight=1)
    {
        global $serendipity;

        $q = "SELECT tag, count(tag) AS total
                FROM {$serendipity['dbPrefix']}entrytags
            GROUP BY tag
              HAVING count(tag) <= $leafWeight
            ORDER BY tag";

        $rows = serendipity_db_query($q);

        if (!is_array($rows) && $rows !== true && $rows !== 1 && $rows !== 'true') {
            echo $rows;
        }

        $tags = array();
        if (is_array($rows) && !empty($rows)) {
            foreach((array)$rows AS $r) {
                $tags[$r['tag']] = $r['total'];
            }
        }
        if (empty($tags)) {
            echo '<span class="msg_notice"><span class="icon-info-circled" aria-hidden="true"></span> ' . PLUGIN_EVENT_FREETAG_MANAGE_LEAFTAGS_NONE . "</span>\n";
        }
        return $tags;
    }

    /**
     * Fetch tags for (related) entries
     *
     * @return  array    $entries
     * @see     getTagsForEntry() and importEntryTagsIntoProperties()
     */
    static function getTagsForEntries($entries)
    {
        global $serendipity;

        if (!is_array($entries) || count($entries) < 1 || implode(',', $entries) == '') {
            return false;
        }

        $q = "SELECT entryid, tag FROM {$serendipity['dbPrefix']}entrytags WHERE entryid IN (".implode(',', $entries).") ORDER BY entryid, tag";
        $result = serendipity_db_query($q);

        if (!is_array($result)) {
            return false;
        }

        $gt = array();
        foreach($result AS $row) {
            if (isset($row['entryid'])) {
                $gt[$row['entryid']][] = $row['tag'];
            }
        }
        return $gt;
    }

    /**
     * Fetches arrayed tags by ID
     *  Why does it use array pop? It turns multi-dimensional arrays into flattened arrays!
     *
     * @param   int      entries $eventData['id']
     * @return  array    in any case for the "tolower" array_imap()
     * @see     diverse methods like backend_fetch_tags_for_saving()
     */
    function getTagsForEntry($entryId)
    {
        $array = $this->getTagsForEntries(array($entryId));
        return (is_array($array) ? array_pop($array) : array());
    }

    /**
     * event hook: (diverse)
     *
     * @param   int     $entryId
     * @see     backend_fetch_tags_for_saving()
     */
    function deleteTagsForEntry($entryId)
    {
        global $serendipity;

        $q = "DELETE FROM {$serendipity['dbPrefix']}entrytags WHERE entryid = ".(int)$entryId;
        serendipity_db_query($q);
    }

    /**
     * Add tags to entry
     *
     * @static
     * @see     convertEntryPropertiesTags()
     */
    static function addTagsToEntry($entryId, $tags)
    {
        global $serendipity;

        if (!is_array($tags)) {
            return false;
        }

        foreach($tags AS $tag) {
            // Avoid Uncaught mysqli_sql_exception: Duplicate entry 'id-tag' for key 'PRIMARY'
            $q = "DELETE FROM {$serendipity['dbPrefix']}entrytags WHERE entryid = '".(int)$entryId."' AND tag = '".serendipity_db_escape_string($tag)."'";
            serendipity_db_query($q);
            $q = "INSERT INTO {$serendipity['dbPrefix']}entrytags (entryid, tag) VALUES (".(int)$entryId.", '".serendipity_db_escape_string($tag)."')";
            serendipity_db_query($q);
        }
    }

    /**
     * event hook: frontend_entryproperties
     *   This may not be the right way to do this...
     *
     * @param   array       $eventData by reference
     * @param   array       $addData possible hooked plugin data by entryproperties
     */
    function importEntryTagsIntoProperties(&$eventData, $addData)
    {
        // we do a dual loop here, which is probably the worst thing to do.
        // A better thing might be some kind of array merge action, but I am not
        // entirely sure how do do that with the arrays we are given.
        //
        // RefactorMe Later.

        // Loop one in getTagsForEntries
        $tagGroups = $this->getTagsForEntries(array_keys($addData));

        // Loop 2
        if (is_array($tagGroups))  {
            foreach($tagGroups AS $entryId => $tagList) {
                $eventData[$addData[$entryId]]['properties']['freetag_tags'] = $tagList;
                $eventData[$addData[$entryId]]['properties']['freetag_tagList'] = implode(",", $tagList);
            }
        }
    }

    /**
     * event hook: frontend_fetchentries and frontend_fetchentry
     *      Gathers SQL query data for frontend fetches
     *
     * @param   string  $eventData by reference
     */
    function frontend_fetch_showtag(&$eventData)
    {
        global $serendipity;

        if (!empty($this->tags['show'])) {
            if (is_array($this->tags['show'])) {
                $showtag = array_map('serendipity_db_escape_string', $this->tags['show']);
            } else {
                $showtag = serendipity_db_escape_string($this->tags['show']);
            }
        } else if (!empty($serendipity['GET']['tag'])) {
            $showtag = serendipity_db_escape_string(urldecode($serendipity['GET']['tag']));
        }

        if (!isset($showtag)) {
            $showtag = '';
        }

        if (is_array($showtag)) {
            $arr_showtag = $showtag;
        } else {
            $arr_showtag = explode(';', $showtag);
        }

        $multimode = 'and';
        if (count($arr_showtag) > 1) {
            $showtag = $arr_showtag;
            $multimode = 'or';
        }

        if (!empty($show_tag) && is_string($show_tag) && serendipity_db_bool($this->get_config('lowercase_tags', 'true'))) {
            if (function_exists('mb_strtolower')) {
                if (function_exists('mb_internal_encoding')) {
                    mb_internal_encoding(LANG_CHARSET);
                }
                $showtag = mb_strtolower($showtag);
            } else {
                $showtag = strtolower($showtag);
            }
        }

        $coll_target = $this->get_config('collation', '');
        if (empty($coll_target) && stristr($serendipity['dbType'], 'mysql') ) {
            $cd = serendipity_db_query("SHOW FULL COLUMNS FROM {$serendipity['dbPrefix']}entrytags LIKE 'tag'");
            if (!empty($cd[0]['Collation'])) {
                $coll_target = $cd[0]['Collation'];
                $this->set_config('collation', $coll_target);
            }
        }

        if (!empty($showtag)) {
            if (LANG_CHARSET == 'UTF-8' && stristr($serendipity['dbType'], 'mysql') && !stristr($coll_target, 'utf8')) {
                $collate = "COLLATE utf8_general_ci";
                $collateP = '_utf8 ';
            } else {
                $collate = $collateP = "";
            }

            $cond = $join = '';
            if (is_string($showtag)) {
                $join = " INNER JOIN {$serendipity['dbPrefix']}entrytags AS entrytags ON (e.id = entrytags.entryid) ";
                $cond = "entrytags.tag = $collateP '$showtag' $collate";
                $this->addCategoryTemplatesCondition($cond); // exclude items which live in hidden set categories
            } else if (is_array($showtag)) {
                $_taglist = array();
                $cond = '(1=2 ';
                foreach($showtag AS $_showtag) {
                    $_taglist[] = serendipity_db_escape_string($_showtag);
                    $cond .= " OR entrytags.tag = $collateP '" . serendipity_db_escape_string($_showtag) . "' $collate ";
                }
                $cond .= ' ) ';
                $this->addCategoryTemplatesCondition($cond); // exclude items which live in hidden set categories
                $total = count($showtag);
                $join = " INNER JOIN {$serendipity['dbPrefix']}entrytags AS entrytags ".
                        "         ON e.id = entrytags.entryid ";

                if ($multimode == 'and') {
                    $eventData['having'] = " HAVING count(entrytags.tag) = $total";
                }
                if (serendipity_db_bool($this->get_config('sortlist', 'false'))) {
                    $eventData['orderby'] = "count(entrytags.tag) DESC";
                }
            }

            if (empty($eventData['and'])) {
                $eventData['and'] = " WHERE $cond ";
            } else {
                $eventData['and'] .= " AND $cond ";
            }

            if (empty($eventData['joins'])) {
                $eventData['joins'] = $join;
            } else {
                $eventData['joins'] .= $join;
            }

            $this->displayTag = $showtag;
            $serendipity['plugin_vars']['displayTag'] = $showtag;
            // http://stackoverflow.com/questions/3803349/is-it-possible-to-declare-an-array-as-constant
            if (is_array($showtag)) {
                @define('PLUGIN_VARS_DISPLAYTAG', implode(', ', $showtag)); // Without stringify you get a Warning: Constants may only evaluate to scalar values
                // we better use implode() than the slight faster serialize(), to have the same list delimiter approach as for head_subtitle and constant listings, ie. PLUGIN_EVENT_FREETAG_USING!
            } else {
                @define('PLUGIN_VARS_DISPLAYTAG', $showtag);
            }
        }
    }

    /**
     * event hook: frontend_display:feeds (rss/atom)
     *
     * @param   string  XML element
     * @param   array   $eventData['properties']['freetag_tags']
     * @return  string  XML element per tag
     */
    function getFeedXmlForTags($element, $tagList)
    {
        $out = '';
        if (!is_array($tagList)) {
            return $out;
        }

        foreach($tagList AS $tag) {
            $out .= serendipity_utf8_encode("<$element>" . serendipity_specialchars($tag) ."</$element>\n");
        }
        return $out;
    }

    /**
     * event hook: external_plugin
     *
     * @param   array   GET parameters
     * @param   boolean config var
     */
    function displayExternalTaglist($param, $ctaglist=false)
    {
        global $serendipity;

        $tagged_as_list = false;
        $emit_404 = false;

        // Manually added (last) parameter 'taglist' to view tags by list for certain taglinks eg.: example.org/plugin/tag/Serendipity/Blog/Plums/taglist - both need a modified entries.tpl
        if ($ctaglist && in_array('taglist', $serendipity['uriArguments'])) {
            $param = array_map('urldecode', $param);
            $param = array_map('urldecode', $param); // for doubled encoded tag umlauts via search engine backlinks
            $param = is_array($param) ? array_map('strip_tags', $param) : strip_tags($param);
            $param = array_filter($param); // filter out all left BOOL, NULL and EMPTY elements, which still are possible by removing XSS with strip_tags

            if (!isset($serendipity['smarty']) || !is_object($serendipity['smarty'])) {
                serendipity_smarty_init();
            }
            if (false === serendipity_db_bool($this->get_config('show_tagcloud', 'true'))) {
                // Since this is extra stuff, we need to regular assign the subtitle header and not use $serendipity['head_subtitle'] !
                if (count($param) > 1) {
                    if (function_exists('serendipity_specialchars')) {
                        $serendipity['smarty']->assign('head_subtitle', sprintf(PLUGIN_EVENT_FREETAG_USING, implode(', ', array_map('serendipity_specialchars', $param))));
                    } else {
                        $serendipity['smarty']->assign('head_subtitle', sprintf(PLUGIN_EVENT_FREETAG_USING, implode(', ', array_map('self::callback_map', $param))));
                    }
                } else {
                    $serendipity['smarty']->assign('head_subtitle', sprintf(PLUGIN_EVENT_FREETAG_USING, serendipity_specialchars($param[0])));
                }
            }

            $serendipity['smarty']->assign('taglist', true);

            foreach($serendipity['uriArguments'] AS $uak => $uav) {
                if ($uav == 'taglist') {
                    unset($serendipity['uriArguments'][$uak]);
                }
            }
            $tagged_as_list = true;
        }

        /* Attempt to locate hidden variables within the URI */
        foreach ($serendipity['uriArguments'] AS $k => $v) {
            if ($k === array_key_last($serendipity['uriArguments']) && isset($v[0]) && $v[0] == 'P') { /* Page */
                $page = substr($v, 1);
                if (is_numeric($page)) {
                    $serendipity['GET']['page'] = $page;
                    unset($serendipity['uriArguments'][$k]);
                    if ($param[count($param)-1] == "P{$page}.html") {
                        array_pop($param);  // knock it off of the param array as well
                    }
                }
            }
        }

        if (count($param) == 0 || empty($param[0])) {
            $serendipity['head_subtitle'] = PLUGIN_EVENT_FREETAG_ALLTAGS;
            $this->displayTag = true;
            $param = null;
        } else if (count($param) == 1) {
            $param = urldecode($param[0]);
            $param = urldecode($param); // for doubled encoded tag umlauts via search engine backlinks
            $param = strip_tags($param);
            $serendipity['head_subtitle'] = sprintf(PLUGIN_EVENT_FREETAG_USING, serendipity_specialchars($param));
            $emit_404 = true;
        } else {
            if (!$tagged_as_list) {
                $param = array_map('urldecode', $param);
                $param = array_map('urldecode', $param); // for doubled encoded tag umlauts via search engine backlinks in sprintf
            }
            $param = array_map('strip_tags', $param);
            $param = array_filter($param); // filter out all left BOOL, NULL and EMPTY elements, which still are possible by removing XSS with strip_tags
            if (function_exists('serendipity_specialchars')) {
                $serendipity['head_subtitle'] = sprintf(PLUGIN_EVENT_FREETAG_USING, implode(', ', array_map('serendipity_specialchars', $param)));
            } else {
                $serendipity['head_subtitle'] = sprintf(PLUGIN_EVENT_FREETAG_USING, implode(', ', array_map('self::callback_map', $param)));
            }
            $emit_404 = true;
        }
        // for XSS secureness, while using doubled decode
        $param = is_array($param) ? array_map('strip_tags', ($param ?? '')) : strip_tags(($param ?? ''));
        if (is_array($param)) {
            array_filter($param); // filter out all left BOOL, NULL and EMPTY elements, which still are possible by removing XSS with strip_tags
        }
        if (function_exists('serendipity_specialchars')) {
            $param = is_array($param) ? array_map('serendipity_specialchars', $param) : serendipity_specialchars($param);
        } else {
            $param = is_array($param) ? array_map('self::callback_map', $param) : htmlspecialchars($param, ENT_COMPAT, LANG_CHARSET);
        }

        $this->tags['show'] = $param;
        $serendipity['plugin_vars']['tag'] = $param;

        if (is_array($param)) {
            @define('PLUGIN_VARS_TAG', implode(',', $param));
        } else {
            @define('PLUGIN_VARS_TAG', $param);
        }

        $serendipity['GET']['subpage'] = isset($eventData) ? $eventData : null;
        unset($serendipity['GET']['category']); // No restriction should be enforced here.

        $_tmpFetchLimit = $serendipity['fetchLimit'];
        if ($tagged_as_list) {
            $serendipity['fetchLimit'] = 99; // do not use frontend entries pagination if count < 100 entries
        }
        ob_start();
        include_once(S9Y_INCLUDE_PATH . 'include/genpage.inc.php');

        if ($emit_404 && $this->taggedEntries !== null && $this->taggedEntries < 1) {
            @header('HTTP/1.0 404 Not found');
            @header('Status: 404 Not found');
            if (serendipity_db_bool($this->get_config('send_http_header', 'true'))) {
                @header('X-FreeTag: not found');
            }
        } else {
            if (serendipity_db_bool($this->get_config('send_http_header', 'true'))) {
                @header('X-FreeTag: ' . $this->taggedEntries);
            }
        }
        $raw_data = ob_get_contents();
        ob_end_clean();
        $serendipity['fetchLimit'] = $_tmpFetchLimit;
        $serendipity['smarty']->assign('raw_data', $raw_data);
        // out of scope
        if ($tagged_as_list) {
            $serendipity['smarty']->assign('view', ($serendipity['view'] ?? 'plugin')); // being consistent to simple /plugin/tag/some or NULL initialized for "noindex,follow" in index.tpl, else set to 'entries'
        }

        if (serendipity_db_bool($this->get_config('show_tagcloud', 'true'))) {
            $serendipity['smarty']->assign('istagcloud', true); // allows to remove a sidebar with a tag cloud, when using an entry cloud
            // @see changeLog - needs to change your template index.tpl sidebar condition(s), eg. {if NOT $istagcloud}
        }
        serendipity_gzCompression();
        $serendipity['smarty']->display(serendipity_getTemplateFile($serendipity['smarty_file'], 'serendipityPath'));
        @define('NO_EXIT', true); // RQ: Why did or do we (still) need this? (see index.php file change in 2.1-alpha2) - with 2.1 obsolete!
    }

    /**
     * event hook: backend_sidebar_entries_event_display_managetags
     *  uses global object array eventData
     */
    function displayManageTags()
    {
        global $serendipity;

        if ($this->get_config('dbversion', 1) != 2) {
            $this->install();
            $this->set_config('dbversion', 2);
        }

        $full_permission = serendipity_checkPermission('adminPlugins'); // AFAIS, BY USERLEVEL permission checks are being deprecated

        $tagview = array('all', 'entryleaf', 'leaf', 'entryuntagged', 'keywords', 'cat2tag', 'tagupdate', 'cleanupmappings');// strange issue occurs, when first comes 'leaf', then 'entryleaf' is not replaced correct, so we need to check the latter first!
        $tagviewtitle = array(PLUGIN_EVENT_FREETAG_MANAGE_ALL, PLUGIN_EVENT_FREETAG_MANAGE_LEAFTAGGED, PLUGIN_EVENT_FREETAG_MANAGE_LEAF, PLUGIN_EVENT_FREETAG_MANAGE_UNTAGGED, PLUGIN_EVENT_FREETAG_KEYWORDS, PLUGIN_EVENT_FREETAG_GLOBALLINKS, PLUGIN_EVENT_FREETAG_REBUILD, PLUGIN_EVENT_FREETAG_MANAGE_CLEANUP);
        if (!empty($serendipity['GET']['tagview'])) {
            $freetag_section = str_replace($tagview, $tagviewtitle, $serendipity['GET']['tagview']);
        }
?>

            <h2 id="freetag_adminer_title"><?php echo (empty($freetag_section) ? PLUGIN_EVENT_FREETAG_MANAGETAGS : $freetag_section); ?></h2>

            <div class="freetagMenu">
                <svg display="none" width="0" height="0" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                    <defs>
                        <symbol id="icon-tags" viewBox="0 0 1024 1024">
                            <title>tags</title>
                            <path glyph-name="tags" unicode="&#xe805;" d="M250 600q0 30-21 51t-50 20-51-20-21-51 21-50 51-21 50 21 21 50z m595-321q0-30-20-51l-274-274q-22-21-51-21-30 0-50 21l-399 399q-21 21-36 57t-15 65v232q0 29 21 50t50 22h233q29 0 65-15t57-36l399-399q20-21 20-50z m215 0q0-30-21-51l-274-274q-22-21-51-21-20 0-33 8t-29 25l262 262q21 21 21 51 0 29-21 50l-399 399q-21 21-57 36t-65 15h125q29 0 65-15t57-36l399-399q21-21 21-50z" horiz-adv-x="1071.4" />
                        </symbol>
                        <symbol id="icon-tag" viewBox="0 0 1024 1024">
                            <title>tag</title>
                            <path glyph-name="tag" unicode="&#xe804;" d="M250 600q0 30-21 51t-50 20-51-20-21-51 21-50 51-21 50 21 21 50z m595-321q0-30-20-51l-274-274q-22-21-51-21-30 0-50 21l-399 399q-21 21-36 57t-15 65v232q0 29 21 50t50 22h233q29 0 65-15t57-36l399-399q20-21 20-50z" horiz-adv-x="857.1" />
                        </symbol>
                        <symbol id="icon-notag" viewBox="0 0 1024 1024">
                            <title>entries-notag</title>
                            <path glyph-name="notag" unicode="&#xf0f6;" d="M819 638q16-16 27-42t11-50v-642q0-23-15-38t-38-16h-750q-23 0-38 16t-16 38v892q0 23 16 38t38 16h500q22 0 49-11t42-27z m-248 136v-210h210q-5 16-12 23l-175 175q-6 7-23 12z m215-853v572h-232q-23 0-38 15t-16 38v233h-429v-858h715z m-572 483q0 7 5 12t13 5h393q8 0 13-5t5-12v-36q0-8-5-13t-13-5h-393q-8 0-13 5t-5 13v36z m411-125q8 0 13-5t5-13v-36q0-8-5-13t-13-5h-393q-8 0-13 5t-5 13v36q0 8 5 13t13 5h393z m0-143q8 0 13-5t5-13v-36q0-8-5-13t-13-5h-393q-8 0-13 5t-5 13v36q0 8 5 13t13 5h393z" horiz-adv-x="857.1" />
                        </symbol>
                        <symbol id="icon-leaftag" viewBox="0 0 1024 1024">
                            <title>entries-leaftag</title>
                            <path glyph-name="leaftag" unicode="&#xf15c;" d="M819 584q8-7 16-20h-264v264q13-8 21-16z m-265-91h303v-589q0-23-15-38t-38-16h-750q-23 0-38 16t-16 38v892q0 23 16 38t38 16h446v-304q0-22 16-38t38-15z m89-411v36q0 8-5 13t-13 5h-393q-8 0-13-5t-5-13v-36q0-8 5-13t13-5h393q8 0 13 5t5 13z m0 143v36q0 8-5 13t-13 5h-393q-8 0-13-5t-5-13v-36q0-8 5-13t13-5h393q8 0 13 5t5 13z m0 143v36q0 7-5 12t-13 5h-393q-8 0-13-5t-5-12v-36q0-8 5-13t13-5h393q8 0 13 5t5 13z" horiz-adv-x="857.1" />
                        </symbol>
                        <symbol id="icon-keytag" viewBox="0 0 1024 1024">
                            <title>key-to-tag</title>
                            <path glyph-name="keytag" unicode="&#xe803;" d="M464 564q0 45-31 76t-76 31-76-31-31-76q0-23 11-46-23 11-47 11-44 0-76-32t-31-76 31-75 76-32 76 32 31 75q0 24-10 47 23-11 46-11 45 0 76 31t31 76z m475-393q0-9-27-36t-37-28q-5 0-16 9t-20 19-22 22-13 14l-54-53 123-123q15-16 15-38 0-23-21-45t-46-22q-22 0-38 16l-374 374q-98-73-204-73-91 0-148 57t-57 149q0 89 53 174t138 139 175 53q91 0 148-58t57-148q0-105-73-203l198-199 54 54q-2 2-15 14t-22 21-18 21-9 15q0 10 27 37t37 28q7 0 13-6 3-3 26-25t45-44 49-48 40-44 16-23z" horiz-adv-x="1000" />
                        </symbol>
                        <symbol id="icon-ctag" fill="#3aaadf" viewBox="0 0 1024 1024">
                            <title>category-tags</title>
                            <path glyph-name="ctag" unicode="&#xe807;" d="M429 493q0 59-42 101t-101 42-101-42-42-101 42-101 101-42 101 42 42 101z m142 0q0-61-18-100l-203-432q-9-18-27-29t-37-11-38 11-26 29l-204 432q-18 39-18 100 0 118 84 202t202 84 202-84 83-202z" horiz-adv-x="571.4" />
                        </symbol>
                        <symbol id="icon-autotag" fill="#3aaadf" viewBox="0 0 1024 1024">
                            <title>automatic-key-tags</title>
                            <path glyph-name="autotag" unicode="&#xe802;" d="M620 294v2l-13 179q-1 7-7 13t-12 5h-104q-7 0-13-5t-6-13l-14-179v-2q0-6 5-11t12-4h136q7 0 12 4t4 11z m424-260q0-41-26-41h-393q7 0 12 5t5 13l-11 143q-1 7-7 12t-12 5h-152q-7 0-13-5t-6-12l-11-143q-1-8 4-13t12-5h-392q-26 0-26 41 0 30 14 64l233 583q5 11 15 18t21 8h189q-7 0-13-5t-6-13l-8-107q-1-8 4-13t12-5h93q7 0 12 5t5 13l-9 107q0 8-6 13t-13 5h190q11 0 21-8t14-18l233-583q15-34 15-64z" horiz-adv-x="1071.4" />
                        </symbol>
                        <symbol id="icon-cleantag" fill="#e5534b" viewBox="0 0 1024 1024">
                            <title>clean-unused-tags</title>
                            <path glyph-name="cleantag" unicode="&#xe806;" d="M286 439v-321q0-8-5-13t-13-5h-36q-8 0-13 5t-5 13v321q0 8 5 13t13 5h36q8 0 13-5t5-13z m143 0v-321q0-8-5-13t-13-5h-36q-8 0-13 5t-5 13v321q0 8 5 13t13 5h36q8 0 13-5t5-13z m142 0v-321q0-8-5-13t-12-5h-36q-8 0-13 5t-5 13v321q0 8 5 13t13 5h36q7 0 12-5t5-13z m72-404v529h-500v-529q0-12 4-22t8-15 6-5h464q2 0 6 5t8 15 4 22z m-375 601h250l-27 65q-4 5-9 6h-177q-6-1-10-6z m518-18v-36q0-8-5-13t-13-5h-54v-529q0-46-26-80t-63-34h-464q-37 0-63 33t-27 79v531h-53q-8 0-13 5t-5 13v36q0 8 5 13t13 5h172l39 93q9 21 31 35t44 15h178q22 0 44-15t30-35l39-93h173q8 0 13-5t5-13z" horiz-adv-x="785.7" />
                        </symbol>
                    </defs>
                </svg>
                <ul class="plainList clearfix">
<?php
        $taction  = array('all', 'leaf', 'entryuntagged', 'entryleaf', 'keywords', 'cat2tag', 'tagupdate', 'cleanupmappings'); //re-ordered for button usage (see above)
        $tagtitle = array(PLUGIN_EVENT_FREETAG_MANAGE_ALL, PLUGIN_EVENT_FREETAG_MANAGE_LEAF, PLUGIN_EVENT_FREETAG_MANAGE_UNTAGGED, PLUGIN_EVENT_FREETAG_MANAGE_LEAFTAGGED, PLUGIN_EVENT_FREETAG_KEYWORDS, PLUGIN_EVENT_FREETAG_GLOBALLINKS, PLUGIN_EVENT_FREETAG_REBUILD, PLUGIN_EVENT_FREETAG_MANAGE_CLEANUP);
        $svgsrc   = array('tags', 'tag', 'notag', 'leaftag', 'keytag', 'ctag', 'autotag', 'cleantag');
        $svgtitle = array('tags', 'tag', 'no-tags', 'leaf-tag', 'key-to-tag', 'category-tags', 'autotag', 'clean-tag');
        foreach ($taction AS $tk => $tv) {
            if ($tk > 1) {
                if ($full_permission === false) { break; }
            }
            $active  = (isset($serendipity['GET']['tagview']) && $serendipity['GET']['tagview'] == $tv) ? ' tagview_active' : '';
            $confirm = ($tk == 6 && $tv == 'tagupdate') ? ' onclick="return confirm(\'' . htmlspecialchars(PLUGIN_EVENT_FREETAG_REBUILD_DESC, ENT_COMPAT, LANG_CHARSET) . '\')"' : '';
            echo '<li><a class="button_link' . $active . '" href="' . FREETAG_MANAGE_URL . '&amp;serendipity[tagview]=' . $tv . '"' . $confirm . ' title="'. $tagtitle[$tk] .'"><svg class="icon icon-' . $svgsrc[$tk] . '" title="' . $svgtitle[$tk] . '"><use xlink:href="#icon-' . $svgsrc[$tk] . '"></use></svg></a></li>'."\n";
        }
?>
                </ul>
            </div>
            <script type="text/javascript">
                var deftitle = "<?php echo (empty($freetag_section) ? PLUGIN_EVENT_FREETAG_MANAGETAGS : $freetag_section); ?>";
                $('.freetagMenu .button_link').mouseover( function() {
                  $('#freetag_adminer_title').empty().append( '<span>' + this.title + '</span>' );
                });
                $('.freetagMenu .button_link').mouseout( function() {
                  $('#freetag_adminer_title').empty().append( '<span>' + deftitle + '</span>' );
                });
            </script>

<?php
        if (isset($this->eventData['GET']['tagaction']) && !empty($this->eventData['GET']['tagaction'])) {
            $this->displayTagAction($full_permission);
        }

        // backend menu cases
        if (isset($this->eventData['GET']['tagview'])) {

            switch ($this->eventData['GET']['tagview']) {

                case 'all': // 1
                    $tags = (array)$this->getAllTags();
                    $this->displayEditTags($tags);
                    break;

                case 'leaf': // 2
                    $tags = (array)$this->getLeafTags();
                    $this->displayEditTags($tags);
                    break;

                case 'entryuntagged': // 3
                    if ($full_permission === true) {
                        $this->displayUntaggedEntries();
                    }
                    break;

                case 'entryleaf': // 4
                    if ($full_permission === true) {
                        $this->displayLeafTaggedEntries();
                    }
                    break;

                case 'keywords': // 5
                    if ($full_permission === true) {
                        $tags = (array)$this->getAllTags();
                        $this->displayKeywordAssignment($tags);
                    }
                    break;

                case 'cat2tag': // 6
                    if ($full_permission === true) {
                        $this->displayCategoryToTags();
                    }
                    break;

                case 'tagupdate': // 7
                    if ($full_permission === true) {
                        break;
                    }
                    if (!serendipity_db_bool($this->get_config('keyword2tag', 'false'))) {
                        echo '<span class="msg_notice"><span class="icon-info-circled" aria-hidden="true"></span> The option "' . PLUGIN_EVENT_FREETAG_KEYWORDS . '" is not set!</span>'."\n"; // i18n?
                        break;
                    }
                    $this->displayTagUpdate();
                    break;

                case 'cleanupmappings': // 8
                    if ($full_permission === true) {
                        $this->cleanupTagAssignments();
                    }
                    break;

                default:
                    if (!empty($this->eventData['GET']['tagview'])) {
                        echo '<span class="msg_notice"><span class="icon-info-circled" aria-hidden="true"></span> ' . "Can't execute tagview</span>\n";
                    }
                    break;
            }

        }
        return true;
    }

    /**
     * Backend Administration Method (1/2): edit all/leaf tags
     *
     * @param   array   $taglist
     * @see     displayManageTags() case 1/2
     */
    function displayEditTags($taglist)
    {
        global $serendipity;
        if (count($taglist) === 0) {
            return;
        }
        $url = FREETAG_MANAGE_URL . "&amp;serendipity[tagview]=" . serendipity_specialchars($this->eventData['GET']['tagview']);
?>

        <table class="freetags_manage">
            <thead>
                <tr>
                    <th><?php echo PLUGIN_EVENT_FREETAG_MANAGE_LIST_TAG ?></th>
                    <th><?php echo PLUGIN_EVENT_FREETAG_MANAGE_LIST_WEIGHT ?></th>
                    <th><?php echo PLUGIN_EVENT_FREETAG_MANAGE_LIST_ACTIONS ?></th>
                </tr>
            </thead>
            <tbody>
<?php
            foreach($taglist AS $tag => $weight) {
?>

                <tr>
                    <td><?php echo $tag; ?></td>
                    <td><?php echo $weight; ?></td>
                    <td>
                        <a class="button_link" title="<?php echo PLUGIN_EVENT_FREETAG_MANAGE_ACTION_RENAME ?>" href="<?php echo $url?>&amp;serendipity[tagaction]=rename&amp;serendipity[tag]=<?php echo urlencode($tag)?>"><span class="icon-edit" aria-hidden="true"></span><span class="visuallyhidden"> <?php echo PLUGIN_EVENT_FREETAG_MANAGE_ACTION_RENAME ?></span></a>
                        <a class="button_link" title="<?php echo  PLUGIN_EVENT_FREETAG_MANAGE_ACTION_SPLIT ?>" href="<?php echo $url?>&amp;serendipity[tagaction]=split&amp;serendipity[tag]=<?php echo urlencode($tag)?>"><span class="icon-resize-full" aria-hidden="true"></span><span class="visuallyhidden"> <?php echo  PLUGIN_EVENT_FREETAG_MANAGE_ACTION_SPLIT ?></span></a>
                        <a class="button_link" title="<?php echo PLUGIN_EVENT_FREETAG_MANAGE_ACTION_DELETE ?>" href="<?php echo $url?>&amp;serendipity[tagaction]=delete&amp;serendipity[tag]=<?php echo urlencode($tag)?>"><span class="icon-trash" aria-hidden="true"></span><span class="visuallyhidden"> <?php echo PLUGIN_EVENT_FREETAG_MANAGE_ACTION_DELETE ?></span></a>
                    </td>
                </tr>
<?php
            }
?>

            </tbody>
        </table>

<?php
    }

    /**
     * Display Manage Tags case 3
     *
     * @see     displayManageTags()
     */
    function displayUntaggedEntries()
    {
        global $serendipity;

        $q = "SELECT e.id AS id, e.title AS title
                FROM {$serendipity['dbPrefix']}entries AS e
                LEFT OUTER JOIN {$serendipity['dbPrefix']}entrytags AS t
                    ON e.id = t.entryid
                WHERE entryid IS NULL
                GROUP BY e.id, e.title";

        $this->displayEditEntries($q);
    }

    /**
     * Display Manage Tags case 4
     *
     * @see     displayManageTags()
     */
    function displayLeafTaggedEntries()
    {
        global $serendipity;

        $q = "SELECT e.id AS id, e.title AS title, t.tag, count(t.tag) AS total
                FROM {$serendipity['dbPrefix']}entries AS e
                LEFT JOIN {$serendipity['dbPrefix']}entrytags AS t
                    ON e.id = t.entryid
                GROUP BY e.id, e.title
                HAVING total = 1";

        $this->displayEditEntries($q);
    }

    /**
     * Backend Administration Method (3/4): Edit untagged/leaf-tag entries
     *
     * @param   string  SQL query
     * @see     displayUntaggedEntries() and displayLeafTaggedEntries()
     */
    function displayEditEntries($q)
    {
        global $serendipity;

        $r = serendipity_db_query($q);

        if ($r === true) {
            echo '<span class="msg_notice"><span class="icon-info-circled" aria-hidden="true"></span> ' . PLUGIN_EVENT_FREETAG_MANAGE_UNTAGGED_NONE . "</span>\n";
        } else if (!is_array($r)) {
            echo $r;
        } else {
            $index = 0;
            echo '<ul class="plainList freetags_list">'."\n";
            foreach ($r AS $row) {
                echo '    <li class="' . (++$index%2 ? "odd" : "even") . '">
                        <a class="button_link" title="' . EDIT . '" href="' . FREETAG_EDITENTRY_URL . $row['id'] . '"><span class="icon-edit" aria-hidden="true"></span><span class="visuallyhidden"> ' . EDIT . '</span></a>
                        ' . $row['title'] . (!empty($row['tag']) ? ' ( <strong>Single-Tag:</strong> <em>' . $row['tag'] . '</em> )' : '') . '
                    </li>'."\n"; // i18n?
            }
            echo "</ul>\n";
        }
    }

    /**
     * Backend Administration Method (5): Set sub tag auto-keyword tags
     *
     * @param   array   $taglist
     * @see     displayManageTags() case 5
     */
    function displayKeywordAssignment($taglist)
    {
        global $serendipity;

        if (isset($serendipity['POST']['keywordsubmit'])) {
            serendipity_db_query("DELETE FROM {$serendipity['dbPrefix']}tagkeywords WHERE tag = '" . serendipity_db_escape_string(urldecode($serendipity['POST']['tag'])) . "'");
            serendipity_db_query("INSERT INTO {$serendipity['dbPrefix']}tagkeywords (tag, keywords) VALUES ('" . serendipity_db_escape_string(urldecode($serendipity['POST']['tag'])) . "', '" . serendipity_db_escape_string($serendipity['POST']['keywords']) . "')");
        }

        $keys = array();
        $keylist = serendipity_db_query("SELECT tag, keywords FROM {$serendipity['dbPrefix']}tagkeywords ORDER BY tag");
        if (is_array($keylist)) {
            foreach($keylist AS $key) {
                $keys[$key['tag']] = $key['keywords'];
            }
        }
        $url = FREETAG_MANAGE_URL . "&amp;serendipity[tagview]=" . serendipity_specialchars($this->eventData['GET']['tagview']);

        echo '<span class="msg_notice"><span class="icon-info-circled" aria-hidden="true"></span> ' . PLUGIN_EVENT_FREETAG_KEYWORDS_DESC . "</span>\n";
?>
        <form action="<?php echo $url; ?>" method="post">
        <table class="freetags_manage">
            <thead>
                <tr>
                    <th><?php echo PLUGIN_EVENT_FREETAG_MANAGE_LIST_TAG ?></th>
                    <th><?php echo PLUGIN_EVENT_FREETAG_KEYWORDS ?></th>
                    <th><?php echo PLUGIN_EVENT_FREETAG_MANAGE_LIST_ACTIONS ?></th>
                </tr>
            </thead>
            <tbody>
<?php
            foreach($taglist AS $tag => $weight) {
?>
                <tr>
                    <td> <?php echo $tag; ?> </td>
                    <td>
<?php
                if (isset($serendipity['GET']['tag']) && urldecode($serendipity['GET']['tag']) == $tag) {
?>
                        <a id="edit"></a>
                        <textarea rows="4" cols="40" name="serendipity[keywords]"><?php echo serendipity_specialchars((isset($keys[$tag]) ? $keys[$tag] :'')) ?></textarea>
<?php
                } else {
                        if (isset($keys[$tag])) echo $keys[$tag];
                }
?>
                    </td>
                    <td>
<?php
                if (isset($serendipity['GET']['tag']) && urldecode($serendipity['GET']['tag']) == $tag) {
?>
                        <input type="hidden" name="serendipity[tag]" value="<?php echo urlencode(urldecode($serendipity['GET']['tag'])); ?>" />
                        <input type="submit" name="serendipity[keywordsubmit]" value="<?php echo SAVE; ?>">
<?php
                } else {
?>
                        <a class="button_link" title="<?php echo EDIT ?>" href="<?php echo $url ?>&amp;serendipity%5Btag%5D=<?php echo urlencode($tag)?>#edit"><span class="icon-edit" aria-hidden="true"></span><span class="visuallyhidden"> <?php echo EDIT ?></span></a>
<?php
                }
?>
                    </td>
                </tr>
<?php
        }
?>
            </tbody>
        </table>
        </form>
<?php

    }

    /**
     * Backend Administration Method (6): Set category names to tags
     *
     * @see     displayManageTags() case 6
     */
    function displayCategoryToTags()
    {
        global $serendipity;

        $e =    serendipity_db_query("SELECT e.id, e.title, c.category_name, et.tag
                                        FROM {$serendipity['dbPrefix']}entries AS e
                             LEFT OUTER JOIN {$serendipity['dbPrefix']}entrycat AS ec
                                          ON e.id = ec.entryid
                             LEFT OUTER JOIN {$serendipity['dbPrefix']}category AS c
                                          ON ec.categoryid = c.categoryid
                             LEFT OUTER JOIN {$serendipity['dbPrefix']}entrytags AS et
                                          ON e.id = et.entryid",
                                          false,
                                          'assoc');

        if (!is_array($e)) {
            return; // empty case
        }

        // Get all categories and tags of all entries
        $entries = array();
        foreach ($e AS $row) {
            $entries[$row['id']]['title'] = $row['title'];
            $entries[$row['id']]['categories'][$row['category_name']] = $row['category_name'];
            $entries[$row['id']]['tags'][$row['tag']] = $row['tag'];
        }

        // Cycle all entries
        echo '<ul class="plainList">'."\n";
        foreach ($entries AS $id => $props) {
            $newtags = array();
            // Fetch all tags that should be added
            foreach ($props['categories'] AS $tag) {
                if (empty($tag)) {
                    continue;
                }
                $newtags[$tag] = $tag;
            }

            // Subtract all tags that already exist
            foreach ($props['tags'] AS $tag) {
                unset($newtags[$tag]);
            }

            if (count($newtags) < 1) {
                continue;
            }

            $this->addTagsToEntry($id, $newtags);
            echo '<li>';
            printf(
                PLUGIN_EVENT_FREETAG_GLOBALCAT2TAG_ENTRY,
                $id,
                serendipity_specialchars($props['title']),
                serendipity_specialchars(implode(', ', $newtags))
            );
            echo "</li>\n";
        }
        echo "</ul>\n";
        echo '<span class="msg_notice"><span class="icon-info-circled" aria-hidden="true"></span> ' . PLUGIN_EVENT_FREETAG_GLOBALCAT2TAG . "</span>\n";
    }

    /**
     * Backend Administration Method (7): Rebuild entry auto-keyword tags
     *
     * @see     displayManageTags() case 7
     */
    function displayTagUpdate()
    {
        global $serendipity;

        $limit = 25;
        $page  = (isset($serendipity['GET']['page']) ? $serendipity['GET']['page'] : 1);
        $from  = ($page - 1) * $limit;
        $to    = ($page) * $limit;

        echo '<h3>';
        printf(PLUGIN_EVENT_FREETAG_REBUILD_FETCHNO, $from, $to);

        $entries = serendipity_fetchEntries(
            null,
            true,
            $limit,
            false,
            false,
            'timestamp DESC',
            '',
            true
        );

        $total = serendipity_getTotalEntries();
        printf(PLUGIN_EVENT_FREETAG_REBUILD_TOTAL, $total);
        echo '</h3>';

        if (is_array($entries)) {
            echo '<ul class="plainList">'."\n";
            foreach ($entries AS $entry) {
                unset($entry['orderkey']);
                unset($entry['loginname']);
                unset($entry['email']);
                printf('    <li>%d - "%s"', $entry['id'], serendipity_specialchars($entry['title']));
                $serendipity['POST']['properties']['fake'] = 'fake';
                $current_cat = $entry['categories'];
                $entry['categories'] = array();
                foreach ($current_cat AS $categoryidx => $category_data) {
                    $entry['categories'][$category_data['categoryid']] = $category_data['categoryid'];
                }

                $up = serendipity_updertEntry($entry);
                if (is_string($up)) {
                    echo "<div>$up</div>\n";
                }
                echo ' ... ' . DONE . "</li>\n";
            }
            echo "</ul>\n";
        }

        if ($to < $total) {
?>

            <script type="text/javascript">
                if (confirm("<?php echo htmlspecialchars(PLUGIN_EVENT_FREETAG_REBUILD_FETCHNEXT, ENT_COMPAT, LANG_CHARSET); ?>")) {
                    location.href = "?serendipity[adminModule]=event_display&serendipity[adminAction]=managetags&serendipity[tagview]=tagupdate&serendipity[page]=<?php echo (int)($page+1); ?>";
                } else {
                    alert("<?php echo DONE; ?>");
                }
            </script>

<?php
        } else {
            echo '<span class="msg_notice"><span class="icon-info-circled" aria-hidden="true"></span> ' . DONE . "</span>\n";
        }
    }

    /**
     * Backend Administration Method (8): Clean up entry tag assignments
     *
     * @see     displayManageTags() case 8
     */
    function cleanupTagAssignments()
    {
        global $serendipity;

        // Search for inconsistencies
        $q_search = "SELECT et.tag AS tag, et.entryid AS entryid, e.id
                       FROM {$serendipity['dbPrefix']}entrytags AS et
                  LEFT JOIN {$serendipity['dbPrefix']}entries AS e
                         ON et.entryid = e.id
                      WHERE e.id IS NULL
                   ORDER BY et.tag ASC";
        $mappings = serendipity_db_query($q_search, FALSE, 'assoc', TRUE);

        if (is_array($mappings) && count($mappings) > 0) {
            // Inconsistencies found

            if ($this->eventData['GET']['perform'] == 'true') {
                // Perform cleanup

                $entryIDs = array();
                foreach ($mappings AS $mapping) {
                    if (!in_array($mapping['entryid'], array_values($entryIDs))) {
                        $entryIDs[] = $mapping['entryid'];
                    }
                }
                $q_cleanup = "DELETE FROM {$serendipity['dbPrefix']}entrytags
                                    WHERE entryid IN (".implode(", ", $entryIDs).")";
                $cleanup = serendipity_db_query($q_cleanup);

                if ($cleanup === TRUE) {
                    echo '<span class="msg_success"><span class="icon-ok-circled" aria-hidden="true"></span> ' . PLUGIN_EVENT_FREETAG_MANAGE_CLEANUP_SUCCESSFUL . "</span>\n";
                }
                else {
                    echo '<div class="msg_error"><p><span class="icon-attention-circled" aria-hidden="true"></span> ' . PLUGIN_EVENT_FREETAG_MANAGE_CLEANUP_FAILED . '</p><strong>DB-Error:</strong> ' . $cleanup . "</div>\n";
                }
            }
            else {
                // Show inconsistencies

                foreach ($mappings AS $mapping) {
                    $cleanup_tags[$mapping['tag']][] = $mapping['entryid'];
                }
                echo '<span class="msg_notice"><span class="icon-info-circled" aria-hidden="true"></span> ' . PLUGIN_EVENT_FREETAG_MANAGE_CLEANUP_INFO . "</span>\n";

                // Display list of found inconsistencies
                echo "<table class=\"freetags_manage\">\n<thead>\n";
                echo "    <tr><th>".PLUGIN_EVENT_FREETAG_MANAGE_LIST_TAG."</th><th>".PLUGIN_EVENT_FREETAG_MANAGE_CLEANUP_ENTRIES."</th></tr>\n";
                echo "</thead><tbody>\n";
                foreach ($cleanup_tags AS $tag => $entries) {
                    echo "<tr><td>$tag</td><td>".implode(', ', $entries)."</tr>\n";
                }
                echo "</tbody></table>\n";

                // Display submit form to start cleanup process
                echo '<form action="" method="GET">'."\n";
                echo '    <input type="hidden" name="serendipity[adminModule]" value="event_display" />';
                echo '    <input type="hidden" name="serendipity[adminAction]" value="managetags" />';
                echo '    <input type="hidden" name="serendipity[tagview]" value="' . serendipity_specialchars($this->eventData['GET']['tagview']) . '">'."\n";
                echo '    <input type="hidden" name="serendipity[perform]" value="true" />'."\n";
                echo '    <input type="submit" name="submit" value="'.PLUGIN_EVENT_FREETAG_MANAGE_CLEANUP_PERFORM.'">'."\n";
                echo "</form>\n";
            }
        }
        elseif ($mappings === TRUE) {
            // No inconsistencies found
            echo '<span class="msg_notice"><span class="icon-info-circled" aria-hidden="true"></span> ' . PLUGIN_EVENT_FREETAG_MANAGE_CLEANUP_NOTHING . "</span>\n";
        }
        else {
            // An error occurs while searching for inconsistencies
            echo '<div class="msg_error"><p><span class="icon-attention-circled" aria-hidden="true"></span> ' . PLUGIN_EVENT_FREETAG_MANAGE_CLEANUP_LOOKUP_ERROR . '</p><strong>DB-Error:</strong> ' . $mappings . "</div>\n";
        }
    }

    /**
     * event hook: 'backend_publish' and 'backend_save'
     *      old tags, automated tags, category tags
     *
     * CLARIFY STATEMENT:
     *      TAGS are stored to the database entrytags table like they are written by the user or being tagged already:
     *      uppercased, mixed, lowercased, capitalized, etc. To change older tags, use the backend tag administration rename button function.
     *      The 'lowercase_tags' option sets TAGS lowercased in every frontend related output at runtime and is used for comparison matters.
     *
     * @param   array   $eventData as copy
     */
    function backend_fetch_tags_for_saving($eventData)
    {
        global $serendipity;

        if (function_exists('mb_internal_encoding')) {
            mb_internal_encoding(LANG_CHARSET);
        }

        #$to_lower  = serendipity_db_bool($this->get_config('lowercase_tags', 'true')); // see clarify statement!
        $keylist   = serendipity_db_query("SELECT tag, keywords FROM {$serendipity['dbPrefix']}tagkeywords", false, 'assoc');
        $automated = array(array());

        if (is_array($keylist)) {
            foreach($keylist AS $key) {
                $keywords = explode(',', $key['keywords']);
                foreach($keywords AS $keyword) {
                    $automated[trim($keyword)][$key['tag']] = true;
                }
            }
        }
        $automated = array_filter($automated); // filter out all left BOOL, NULL and EMPTY elements

        // When this variable is not set, the entry might be saved i.e. by recreating cache or automated trackback.
        // Do not loose such tags. :)
        // And do not use it with multiple entry cases, since this would always get the first of multiple IDs!!
        if (!isset($serendipity['POST']['properties']['freetag_tagList']) && isset($serendipity['GET']['tagview']) && $serendipity['GET']['tagview'] != 'tagupdate' && $serendipity['GET']['tagview'] != 'cat2tag') {
            $serendipity['POST']['properties']['freetag_tagList'] = implode(',', $this->getTagsForEntry($eventData['id'])); // as STRING
        }
        if (!empty($serendipity['POST']['properties']['freetag_tagList'])) {
            $tags = self::makeTagsFromTagList($serendipity['POST']['properties']['freetag_tagList']);
        }

        // check for keyword2tag empty or set cases
        if (empty($tags) || !is_array($tags)) {
            $tags = array();
        }

        if (empty($tags) && serendipity_db_bool($this->get_config('keyword2tag', 'false'))) {
            $searchtext = strip_tags($eventData['body'] . @$eventData['extended']);
            // fetch oldtags AS ARRAY for each entry, valid to be checked for keywords
            $oldtags = self::makeTagsFromTagList(implode(',', $this->getTagsForEntry($eventData['id']))); // as ARRAY

            foreach($automated AS $keyword => $ktags) {
                $keyword = trim($keyword);
                if (empty($keyword)) {
                    continue;
                }
                if (!is_array($ktags) || count($ktags) < 1) {
                    continue;
                }

                $_ktags = array_keys($ktags); // avoids Only variables should be passed by reference error
                $keywordtag = array_pop($_ktags); // get type key as string
                if (is_array($oldtags) && in_array($keywordtag, $oldtags)) {
                    continue; // if automated keyword-tag already is in oldtags, do next
                }

                // only match check those, which have no keyword-tag yet
                if (!isset($key2tagIDs) || !is_array($key2tagIDs)) {
                    $key2tagIDs = array();
                }
                $regex = sprintf("/((\s+|[\(\[-]+)%s([-\/,\.\?!'\";\)\]]*+|[\/-]+))/i", $keyword);

                $kaddmsg = '';
                if (preg_match($regex, $searchtext) > 0) {
                    foreach($ktags AS $tag => $is_assigned) {
                        if (!is_array($tags) || (!in_array($tag, $tags) && !in_array($tag, $tags))) {

                            if (!is_array($tags) && !empty($tag)) {
                                $tags = array(); // avoid having "[] operator not supported for strings" errors
                            }
                            $tags[] = $tag;
                            $kaddmsg .= sprintf('    <li>' . PLUGIN_EVENT_FREETAG_KEYWORDS_ADD . "</li>\n", serendipity_specialchars($keyword), serendipity_specialchars($tag));
                            if (!empty($tags)) {
                                $key2tagIDs[] = $eventData['id']; // gather ids to updertEntries
                            }
                        }
                    }
                    echo '<span class="msg_success"><span class="icon-ok-circled"></span><ul class="plainText">' . "\n    <li>FreeTag:</li>\n $kaddmsg </ul></span>";
                } else {
                    // get the other entries tags
                    if (is_array($key2tagIDs) && !in_array($eventData['id'], $key2tagIDs)) {
                        unset($key2tagIDs);
                        $tags = $oldtags;
                    }
                }
            }
        }

        // check for cat2tag empty or set cases
        if (!is_array($tags) && empty($tags)) {
            $tags = array();
        }

        // In this case, tags are just added to the tags array
        if (serendipity_db_bool($this->get_config('cat2tag', 'false'))) {
            if (is_array($cats = serendipity_fetchCategories())) {
                $cats = serendipity_walkRecursive($cats, 'categoryid', 'parentid', VIEWMODE_THREADED);
                foreach ($cats AS $cat) {
                    $names = explode(',', $cat['category_name']);
                    foreach($names AS $name) {
                        $name = trim($name);
                        if (is_array($eventData['categories']) && in_array($cat['categoryid'], $eventData['categories']) && !in_array($name, $tags)) {
                            $tags[] = $name;
                        }
                    }
                }
            }
        }

        // Merge kept oldtags with automated and/or category tags into tagList - may partly be or look a little redundant, but catches every case
        if (is_array($tags) && !empty($tags)) {
            if (empty($oldtags) || !is_array($oldtags)) {
                $oldtags = self::makeTagsFromTagList(implode(',', $this->getTagsForEntry($eventData['id']))); // as ARRAY
            }
            if (!is_array($oldtags)) { $oldtags = array(); }
            // Condition could be used with checking the given arrays before, with ' && $oldtags !== $tags',
            // but our tags arrays are so small, that this merge and unique does not really matter for performance
            if (!empty($oldtags)) {
                $tags = array_merge($oldtags, $tags); // merge
            }
            if (count($tags) > 1) {
                $tags = $this->array_iunique($tags); // remove (last added) duplicates (and possible strtolowered added tags)
            }
        }

        $key2tagIDs = (!empty($key2tagIDs) && is_array($key2tagIDs)) ? array_unique($key2tagIDs) : array();

        // ACTIONS - Only do this to entries which really changed tags!!
        if ((is_array($tags) && !empty($tags) && $oldtags !== $tags)
                || (is_array($key2tagIDs) && in_array($eventData['id'], $key2tagIDs) && $oldtags !== $tags)) {
            $this->deleteTagsForEntry($eventData['id']);
            $this->addTagsToEntry($eventData['id'], $tags);
        }

        if (isset($serendipity['POST']['properties']['freetag_kill'])) {
            $this->deleteTagsForEntry($eventData['id']);
        }

        unset($key2tagIDs);
        unset($oldtags);
        unset($tags);
    }

    /**
     * event hook: backend_display executor
     *
     * @param   int   $entryID = $eventData['id']
     */
    function backend_display($entryID)
    {
        global $serendipity;

        if (function_exists('mb_internal_encoding')) {
            mb_internal_encoding(LANG_CHARSET);
        }

        $admin_show_taglist = serendipity_db_bool($this->get_config('admin_show_taglist', 'true'));

        if (!empty($serendipity['POST']['properties']['freetag_tagList'])) {
            $tagList = $serendipity['POST']['properties']['freetag_tagList'];
        } else if (isset($entryID)) {
            // this is the backend entries tag list input field - the tags already assigned to an entry
            $tagList = implode(',', $this->getTagsForEntry($entryID)); // as STRING
        } else {
            $tagList = '';
        }

        // Why should we do this, if already fetched by eventData ID or POST? Seems redundant, thats why I added the empty() check.
        //     (This was previously part of setting list tags lowercased into the input field)
        if (empty($tagList)) {
            $freetags = self::makeTagsFromTagList($tagList);
            if (!empty($freetags)) {
                $tagList = implode(',', $freetags);
            }
        }

        $tagsArray = (array)$this->getAllTags();

        if (serendipity_db_bool($this->get_config('admin_ftayt', 'false'))) {
            $wicktags = array();
            foreach ($tagsArray AS $k => $v) {
                $wicktags[] = '\'' . addslashes($k) . '\'';
            }
            echo '
            <link rel="stylesheet" type="text/css" href="' . $serendipity['baseURL'] . 'plugins/serendipity_event_freetag/jquery.autocomplete.min.css" />
            <script type="text/javascript" src="' . $serendipity['baseURL'] . 'plugins/serendipity_event_freetag/jquery.autocomplete.min.js"></script>
            <script type="text/javascript">
                var tags = [' . implode(',', $wicktags) . '];
            </script>'."\n";
        }

        $dir_reverse = (LANG_DIRECTION == 'rtl') ? 'ltr' : 'rtl';
?>

            <a name="tagListAnchor"></a>
            <fieldset id="edit_entry_freetags" class="entryproperties_freetag">
                <span class="wrap_legend"><legend><?php echo PLUGIN_EVENT_FREETAG_TITLE; ?></legend></span>
                <div class="form_field">
                    <label for="properties_freetag_tagList" class="block_level"><?php echo PLUGIN_EVENT_FREETAG_ENTERDESC; ?>:</label>
                    <input id="properties_freetag_tagList" class="wickEnabled" dir="<?php echo $dir_reverse; ?>" type="text" name="serendipity[properties][freetag_tagList]" value="<?php echo serendipity_specialchars($tagList) ?>">
                </div>
                <div class="form_check">
                    <input id="properties_freetag_kill" name="serendipity[properties][freetag_kill]" type="checkbox" value="true">
                    <label for="properties_freetag_kill"><?php echo PLUGIN_EVENT_FREETAG_KILL; ?></label>
                </div>
                <div id="edit_entry_submit" class="freetag_entry_submit">
                    <a href="#top" class="x-button_link x-button_up" title="<?php echo UP; ?>">
                        <svg xmlns="http://www.w3.org/2000/svg" class="bi bi-arrow-up-square-fill" viewBox="0 0 16 16">
                          <path d="M2 16a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2zm6.5-4.5V5.707l2.146 2.147a.5.5 0 0 0 .708-.708l-3-3a.5.5 0 0 0-.708 0l-3 3a.5.5 0 1 0 .708.708L7.5 5.707V11.5a.5.5 0 0 0 1 0z"/>
                        </svg>
                    </a>
                </div>
<?php

        if ($admin_show_taglist) {
            echo '                <div id="backend_freetag_list">'."\n";
            $index = serendipity_db_bool($this->get_config('admin_delimiter', 'true'));
            $class = $index ? 'class="tagzoom" ' : '';
            $lastletter = '';
            foreach ($tagsArray AS $tag => $count) {
                if (function_exists('mb_strtoupper')) {
                    $upc = mb_strtoupper(mb_substr($tag, 0, 1, LANG_CHARSET), LANG_CHARSET);
                } else {
                    $upc = strtoupper(substr($tag, 0, 1));
                }
                if ($index && $upc != $lastletter) {
                    // HEY - do NOT remove this FEATURE(!) for 2.0+!! Is configurable by option!
                    echo "<strong>|" . $upc . ':</strong> ';
                }
                echo "<a {$class}href=\"#tagListAnchor\" onClick=\"addTag('{$tag}')\">{$tag}</a> ";
                $lastletter = $upc;
            }
            echo "\n                </div>\n";
        }

        echo "            </fieldset>\n\n";
    }

    /**
     * Backend Administration Method: Actions
     *  Here we are going to do a dispatch based on the action.
     *  There are 2 dispatches that happen here: The first is the display/query, where
     *  we ask the user for any extra information, and/or a confirmation.
     *  The next is the actual action itself, where we do a db update/delete of some sort.
     *
     * @access  private
     * @see     displayManageTags() main
     */
    private function displayTagAction($fperm=false)
    {
        if ($fperm === false) {
            echo '<span class="msg_notice"><span class="icon-info-circled" aria-hidden="true"></span> Action: "' . $this->eventData['GET']['tagaction'] . '"' . " permission is set read-only!</span>\n"; // i18n?
            return false;
        }
        $validActions = array('rename', 'split', 'delete');

        // Sanitize user input
        $tag    = urldecode($this->eventData['GET']['tag']);
        $action = urldecode(strtolower($this->eventData['GET']['tagaction']));

        if (!in_array($this->eventData['GET']['tagaction'], $validActions)) {
            exit ("DON'T HACK!");
        }

        if (isset($this->eventData['GET']['commit']) && $this->eventData['GET']['commit'] == 'true') {
            $method = 'get'.ucfirst($this->eventData['GET']['tagaction']).'TagQuery';
            $q = $this->$method($tag, $this->eventData);
            echo '<span class="msg_success"><span class="icon-ok-circled" aria-hidden="true"></span> ' . $this->eventData['GET']['tagaction'] . " Completed</span>\n"; // i18n?
        } else {
            $method = 'display'.ucfirst($this->eventData['GET']['tagaction']).'Tag';
            $this->$method($tag, $this->eventData);
        }
    }

    /**
     * Combined method for display/get tag buttons, called by
     * @see displayTagAction
     * @access  private
     */
    private function displayRenameTag($tag, &$eventData)
    {
?>

        <form action="" method="GET">
            <input type="hidden" name="serendipity[adminModule]" value="event_display" />
            <input type="hidden" name="serendipity[adminAction]" value="managetags" />
            <input type="hidden" name="serendipity[tagview]" value="<?php echo serendipity_specialchars($this->eventData['GET']['tagview']) ?>">
            <input type="hidden" name="serendipity[tagaction]" value="rename" />
            <input type="hidden" name="serendipity[commit]" value="true" />
            <input type="hidden" name="serendipity[tag]" value="<?php echo serendipity_specialchars($tag) ?>" />
            <?php echo serendipity_specialchars($tag) ?> =&gt; <input class="input_textbox" type="text" name="serendipity[newtag]" /> <input class="serendipityPrettyButton input_button" type="submit" name="submit" value="<?php echo PLUGIN_EVENT_FREETAG_MANAGE_ACTION_RENAME ?>" />
        </form>

<?php
    }

    /**
     * Execute a rename of a tag
     *  We select all the entries with the old tag name, delete all entry tags
     *  with the old tag name, and finally re insert.  The reason we do this is
     *  that we might be renaming a tag, to an already existing tag that is
     *  already associated to an entry, duplicating the primary key.
     *  If we do it via an update, the update fails, and our rename doesn't
     *  happen.  This way our update does happen, and we can silently fail
     *  when we hit a duplicate key condition.
     *  Postgres doesn't have an UPDATE IGNORE syntax, so we can't use that
     *  method.  Sux0rz.
     *
     * Combined method for get tag button, called by
     * @see displayTagAction
     * @access  private
     */
    private function getRenameTagQuery($tag, &$eventData)
    {
        global $serendipity;

        $tag = serendipity_db_escape_string($tag);
        $newtag = serendipity_db_escape_string(urldecode($serendipity['GET']['newtag']));

        $q = "SELECT entryid FROM {$serendipity['dbPrefix']}entrytags WHERE tag = '$tag'";

        $r = serendipity_db_query($q);
        if (!is_array($r)) {
            echo $r;
            return false;
        }

        $q = "DELETE FROM {$serendipity['dbPrefix']}entrytags WHERE tag = '$tag'";
        serendipity_db_query($q);

        foreach ($r AS $row) {
            $q = "INSERT INTO {$serendipity['dbPrefix']}entrytags VALUES ('{$row['entryid']}','$newtag')";
            serendipity_db_query($q);
        }

        return true;
    }

    /**
     * Combined method for display tag button, called by
     * @see displayTagAction
     * @access  private
     */
    private function displayDeleteTag($tag, &$eventData)
    {
        $no  = FREETAG_MANAGE_URL . "&amp;serendipity[tagview]=" . serendipity_specialchars($this->eventData['GET']['tagview']);
        $yes = FREETAG_MANAGE_URL . "&amp;serendipity[tagview]=" . serendipity_specialchars($this->eventData['GET']['tagview']).
                    "&amp;serendipity[tagaction]=delete".
                    "&amp;serendipity[tag]=".urlencode($tag)."&amp;serendipity[commit]=true";
?>

        <div class="msg_notice">
            <h3> <?php printf(PLUGIN_EVENT_FREETAG_MANAGE_CONFIRM_DELETE, serendipity_specialchars($tag)) ?></h3>
            <a class="button_link state_submit" href="<?php echo $yes; ?>"><?php echo YES; ?></a> &nbsp; &nbsp; <a class="button_link state_cancel" href="<?php echo $no; ?>"><?php echo NO; ?></a>
        </div>

<?php
    }

    /**
     * Combined method for get tag button, called by
     * @see displayTagAction
     * @access  private
     */
    private function getDeleteTagQuery($tag, &$eventData)
    {
        global $serendipity;

        $tag = serendipity_db_escape_string($tag);

        $q = "DELETE FROM {$serendipity['dbPrefix']}entrytags WHERE tag = '$tag'";

        $r = serendipity_db_query($q);
        if ($r !== true) {
            echo $r;
        }
    }

    /**
     * Combined method for display tag button, called by
     * @see displayTagAction
     * @access  private
     */
    private function displaySplitTag($tag, &$eventData)
    {
        if (strstr($tag, ' ')) {
            $newtag = str_replace(' ', ',', $tag);
        } else {
            $newtag = '';
        }
?>

        <form action="" method="GET">
            <input type="hidden" name="serendipity[adminModule]" value="event_display" />
            <input type="hidden" name="serendipity[adminAction]" value="managetags" />
            <input type="hidden" name="serendipity[tagview]" value="<?php echo serendipity_specialchars($this->eventData['GET']['tagview']) ?>">
            <input type="hidden" name="serendipity[tagaction]" value="split" />
            <input type="hidden" name="serendipity[commit]" value="true" />
            <input type="hidden" name="serendipity[tag]" value="<?php echo serendipity_specialchars($tag) ?>" />
            <p> <?php echo PLUGIN_EVENT_FREETAG_MANAGE_INFO_SPLIT ?> <br/>
                foobarbaz =&gt; foo,bar,baz</p>
            <?php echo serendipity_specialchars($tag) ?> =&gt; <input class="input_textbox" type="text" name="serendipity[newtags]" value="<?php echo serendipity_specialchars($newtag) ?>" />
            <input class="serendipityPrettyButton input_button" type="submit" name="submit" value="split" />
        </form>

<?php
    }

    /**
     * Combined method for get tag button, called by
     * @see displayTagAction
     * @access  private
     */
    private function getSplitTagQuery($tag, &$eventData)
    {
        global $serendipity;

        $newtags = self::makeTagsFromTagList(urldecode($this->eventData['GET']['newtags']));
        $tag = serendipity_db_escape_string($tag);

        $q = "SELECT entryid FROM {$serendipity['dbPrefix']}entrytags WHERE tag = '$tag'";
        $entries = serendipity_db_query($q);

        if (!is_array($entries)) {
            echo $entries;
            return false;
        }

        $q = "DELETE FROM {$serendipity['dbPrefix']}entrytags WHERE tag = '$tag'";
        $r = serendipity_db_query($q);
        if ($r !== true) {
            echo $r;
            return false;
        }

        foreach ($entries AS $entryid) {
            foreach ($newtags AS $tag) {
                $q = "INSERT INTO {$serendipity['dbPrefix']}entrytags (entryid, tag)
                        VALUES ('{$entryid['entryid']}', '$tag')";
                $r = serendipity_db_query($q);
            }
        }
    }

    /**
     * Append cloud and main selectors to streamed CSS
     *
     * @param   string       $eventData by reference
     */
    function cloudToCSS(&$eventData)
    {
        $eventData .= '

/* serendipity_event_freetag plugin and cloud selectors start */

.container_serendipity_plugin_freetag ul,
.serendipity_freetag_taglist ul,
.serendipity_plugin_freetag ul {
    margin: 0;
    padding: 0;
    width: 100%;
}
.serendipity_freetag_taglist ul span,
.serendipity_freetag_taglist ul span a,
.container_serendipity_plugin_freetag ul span,
.container_serendipity_plugin_freetag ul span a,
.serendipity_plugin_freetag ul span,
.serendipity_plugin_freetag ul span a {
    line-height: 1rem;
/*    color: #666;*/
    hyphens: auto;
    word-wrap: break-word;
}
.container_serendipity_plugin_freetag ul span a:hover,
.serendipity_freetag_taglist ul span a:hover,
.serendipity_plugin_freetag ul span a:hover {
    text-decoration: underline;
}
.serendipity_freetag_taglist ul span a,
.container_serendipity_plugin_freetag ul span a,
.serendipity_plugin_freetag ul span a {
    text-decoration: none;
}
.serendipity_freeTag_xmlTagEntry {
    white-space: nowrap;
    display: inline;
    width: 100%;
}
.serendipitySideBarItem.serendipity_plugin_freetag {
  padding-bottom: 1rem;
}
.serendipity_plugin_freetag .serendipity_edit_nugget {
    margin-top: 1.5em;
    margin-bottom: -.25em;
}
.serendipity_freetag_taglist {
    background: inherit;
    border: 0 none;
    padding: 0;
    font-size: initial;
}

/* canvas clouds */

.serendipity_plugin_freetag #tags ul li {
    display: inline;
}
.freetag_wordcloud {
    width: 100%;
    height: 320px;
    margin: 0px;
    padding: 0;
    background: transparent;
    page-break-after: always;
    page-break-inside: avoid;
}
.freetag_wordcloud span { white-space: normal; }

.freetag_rotacloud {
    margin: 0px;
    padding: 0;
    width: 100%;
    overflow: visible;
}

/* serendipity_event_freetag plugin and cloud selectors end */

';
    }

    /**
     * Append older selectors to streamed CSS
     *
     * @param   string       $eventData by reference
     */
    function addToCSS(&$eventData)
    {
        $eventData .= '

/* serendipity_event_freetag plugin start */

.serendipity_freeTag {
    margin-left: auto;
    margin-right: 0px;
    text-align: right;
    font-size: 7pt;
    display: block;
    margin-top: 5px;
    margin-bottom: 0px;
}
.serendipity_freeTag_related {
    margin-left: 50px;
    margin-right: 0px;
    text-align: left;
    font-size: small;
    display: block;
    margin-top: 20px;
    margin-bottom: 0px;
}
.serendipity_freeTag a {
    font-size: 7pt;
    text-decoration: none;
}
.serendipity_freeTag a:hover {
    color: green;
    text-decoration: underline;
}
img.serendipity_freeTag_xmlButton {
    vertical-align: bottom;
    display: inline;
    border: 0px;
}

/* serendipity_event_freetag plugin end */

';
    }

    /**
     * Debug message logger method
     */
    function debugMsg($msg)
    {
        global $serendipity;

        $this->debug_fp = @fopen($serendipity['serendipityPath'] . 'templates_c/freetag.log', 'a');
        if (!$this->debug_fp) {
            return false;
        }

        if (empty($msg)) {
            fwrite($this->debug_fp, "failure \n");
        } else {
            fwrite($this->debug_fp, print_r($msg, true));
        }
        fclose($this->debug_fp);
    }

}

/* vim: set sts=4 ts=4 expandtab : */
?>