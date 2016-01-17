<?php
/*
 * ULTRA HIGH PRIORITY
 * - get some kind of data-sharing protocol in action.  It is very difficult
 *   tracing out what the hell is going on with this thing. (RQ: ?)
 * - Refactor out the entryproperties depenancy, and use our own space (RQ: ?)
 * - Refactor the external plugin event hook.  Its kind of cruddy. (RQ: ?)
 *
 * TODO:
 * - Refactor code out of the main event dispatch and into its own methods
 * - - convert database structure to a truely 3rd normal form (RQ: ?)
 *
 * - Tag administration
 * - - Describe Tag
 * - - Super-Tag (tags 'php', 'java' and 'scheme' are super-tagged to tag code) (RQ: ?)
 * - - Add Tag
 *
 *  (RQ: We are ten years later now. Shall we keep this?)
 */


if (IN_serendipity !== true) {
    die ("Don't hack!");
}

// Probe for a language include with constants. Still include defines later on, if some constants were missing
$probelang = dirname(__FILE__) . '/' . $serendipity['charset'] . 'lang_' . $serendipity['lang'] . '.inc.php';
if (file_exists($probelang)) {
    include $probelang;
}

include_once dirname(__FILE__) . '/lang_en.inc.php';

// Because I am using GET methods, if you change this, you also have to change the getManageUrlAsHidden
define('FREETAG_MANAGE_URL', '?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=managetags');
define('FREETAG_EDITENTRY_URL', '?serendipity[action]=admin&amp;serendipity[adminModule]=entries&amp;serendipity[adminAction]=edit&amp;serendipity[id]=');

class serendipity_event_freetag extends serendipity_event
{
    var $tags                 = array();
    var $displayTag           = false;
    var $title                = PLUGIN_EVENT_FREETAG_TITLE;
    var $taggedEntries        = null;
    var $supported_properties = array();
    var $dependencies         = array();

    function introspect(&$propbag)
    {
        global $serendipity;

        $propbag->add('name',          PLUGIN_EVENT_FREETAG_TITLE);
        $propbag->add('description',   PLUGIN_EVENT_FREETAG_DESC);
        $propbag->add('stackable',     false);
        $propbag->add('author',        'Garvin Hicking, Jonathan Arkell, Grischa Brockhaus, Lars Strojny, Malte Paskuda, Ian');
        $propbag->add('requirements',  array(
            'serendipity' => '1.3',
            'smarty'      => '2.6.7',
            'php'         => '5.3.0'
        ));
        $propbag->add('version',       '3.70');
        $propbag->add('event_hooks',    array(
            'frontend_fetchentries'                             => true,
            'frontend_fetchentry'                               => true,
            'frontend_display:rss-2.0:per_entry'                => true,
            'frontend_header'                                   => true,
//            'frontend_display:rss-0.92:per_entry'             => true,
            'frontend_display:rss-1.0:per_entry'                => true,
//            'frontend_display:rss-0.91:per_entry'             => true,
            'frontend_display:atom-0.3:per_entry'               => true,
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
            'show_tagcloud',
            'min_percent', 'max_percent', 'max_tags',
            'use_wordcloud',
            'use_rotacloud', 'rotacloud_tag_color', 'rotacloud_tag_border_color', 'rotacloud_width',
            'use_flash', 'flash_tag_color', 'flash_bg_trans', 'flash_bg_color', 'flash_width', 'flash_speed',

            'separator2', 'config_pagegrouper',
            'lowercase_tags', 'meta_keywords',
            'show_related', 'show_related_count',
            'taglist',
            'sortlist',
            'send_http_header',
            'technorati_tag_link', 'technorati_tag_image',
            'embed_footer')
        );
    }

    function introspect_config_item($name, &$propbag) {
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

            case 'technorati_tag_link':
                 $propbag->add('type',        'boolean');
                 $propbag->add('name',        PLUGIN_EVENT_FREETAG_TECHNORATI_TAGLINK);
                 $propbag->add('description', PLUGIN_EVENT_FREETAG_TECHNORATI_TAGLINK_DESC);
                 $propbag->add('default',     false);
                 break;

            case 'technorati_tag_image':
                 $propbag->add('type',        'string');
                 $propbag->add('name',        PLUGIN_EVENT_FREETAG_TECHNORATI_TAGLINK_IMG);
                 $propbag->add('description', '');
                 $propbag->add('default',     'http://static.technorati.com/static/img/pub/icon-utag-16x13.png');
                 break;

            case 'use_rotacloud':
                 $propbag->add('type',        'boolean');
                 $propbag->add('name',        PLUGIN_EVENT_FREETAG_USE_CAROC);
                 $propbag->add('description', PLUGIN_EVENT_FREETAG_USE_CAROC_DESC);
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
                 $propbag->add('description', PLUGIN_EVENT_FREETAG_USE_CAWOC_DESC);
                 $propbag->add('default',     'false');
                 break;

            case 'use_flash':
                 $propbag->add('type',        'boolean');
                 $propbag->add('name',        PLUGIN_EVENT_FREETAG_USE_FLASH);
                 $propbag->add('description', 'Flash is deprecated, please consider using the other tagclouds!'); // i18n?
                 $propbag->add('default',     'false');
                 break;

            case 'flash_bg_trans':
                 $propbag->add('type',        'boolean');
                 $propbag->add('name',        PLUGIN_EVENT_FREETAG_FLASH_TRANSPARENT);
                 $propbag->add('description', '');
                 $propbag->add('default',     'false');
                 break;

            case 'flash_tag_color':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_EVENT_FREETAG_FLASH_TAG_COLOR);
                $propbag->add('description', '');
                $propbag->add('default',     'ff6600');
                break;

            case 'flash_bg_color':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_EVENT_FREETAG_FLASH_BG_COLOR);
                $propbag->add('description', '');
                $propbag->add('default',     'ffffff');
                break;

            case 'flash_width':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_EVENT_FREETAG_FLASH_WIDTH);
                $propbag->add('description', '');
                $propbag->add('default',     '500');
                break;

            case 'flash_speed':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_EVENT_FREETAG_FLASH_SPEED);
                $propbag->add('description', '');
                $propbag->add('default',     '100');
                break;

            default:
                break;
        }
        return true;
    }

    function example() {
        $useRotCanvas = serendipity_db_bool($this->get_config('use_rotacloud', 'false'));
        $useWordCloud = serendipity_db_bool($this->get_config('use_wordcloud', 'false'));
        $useFlash     = serendipity_db_bool($this->get_config('use_flash', 'false'));

        if (($useFlash && ($useRotCanvas || $useWordCloud)) || ($useRotCanvas && $useWordCloud)) {
            $this->set_config('use_flash', 'false');
            $this->set_config('use_rotacloud', 'false');
            $this->set_config('use_wordcloud', 'false');
            echo '<p class="msg_error"><span class="icon-attention-circled"></span> ' . PLUGIN_EVENT_FREETAG_SET_OPTION_ERROR_1;
        }
    }

    function generate_content(&$title) {
        $title = $this->title;
    }

    static function tableCreated($table = 'entrytags')  {
        global $serendipity;

        $q = "SELECT count(tag) FROM {$serendipity['dbPrefix']}" . $table;
        $row = serendipity_db_query($q, true, 'num');

        if (!is_numeric($row[0])) { // if the response we got back was an SQL error.. :P
            return false;
        } else {
            return true;
        }
    }

    static function upgradeFromVersion1() {
        global $serendipity;

        $q = "SELECT count(*) FROM {$serendipity['dbPrefix']}entryproperties WHERE property = 'ep_freetag_name'";
        $result = serendipity_db_query($q);

        if ((int)$result[0] > 0) {
            return true;
        } else {
            return false;
        }
    }

    static function convertEntryPropertiesTags() {
        global $serendipity;

        $q = "SELECT entryid, value FROM {$serendipity['dbPrefix']}entryproperties WHERE property = 'ep_freetag_name'";
        $result = serendipity_db_query($q);

        if (!is_array($result)) {
            return false;
        }

        foreach($result as $entry) {
            $tags = self::makeTagsFromTaglist($entry['value']);
            self::addTagsToEntry($entry['entryid'], $tags);

            printf(PLUGIN_FREETAG_UPGRADE1_2, count($tags), $entry['entryid']);
            echo '<br />';
        }

        $q = "DELETE FROM {$serendipity['dbPrefix']}entryproperties WHERE property = 'ep_freetag_name'";
        $result = serendipity_db_query($q);
    }

    function cleanup() {
        self::static_install();
    }

    function install() {
        self::static_install();
    }

    static function static_install() {
        global $serendipity;

        if (!self::tableCreated('entrytags')) {
            $q = "CREATE TABLE {$serendipity['dbPrefix']}entrytags (" .
                    "entryid int(10) not null, " .
                    "tag varchar(50) not null, " .
                    "primary key (entryid, tag)" .
                ")";

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
                    "primary key (tag)" .
                ")";

            $result = serendipity_db_schema_import($q);
        }

        if (self::upgradeFromVersion1()) {
            self::convertEntryPropertiesTags();
        } else {
            echo '<span class="msg_notice"><span class="icon-info-circled"></span> NOT UPGRADING!</span>'."\n";
        }
    }

    /**
     * Simple redirector method
     *
     * @param   string   $var
     * @return  string   escaped
     */
    function specialchars_mapper($var) {
        return (function_exists('serendipity_specialchars') ? serendipity_specialchars($var) : htmlspecialchars($var, ENT_COMPAT, LANG_CHARSET));
    }

    /**
     * Simple callback method for array_map(), to avoid
     * array_map('htmlspecialchars', $array) missing the PHP 5.4+ changes
     *
     * @param   array   $param tags
     * @return  array
     * @see     specialchars_mapper()
     */
    function callback_map($a) {
        return htmlspecialchars($a, ENT_COMPAT, LANG_CHARSET);
    }

    static function makeURLTag($tag) {
        return str_replace('.', '%FF', urlencode($tag)); // RQ: why is this here ? Isn't %ff not ÿ = %FF = %C3%BF ? And why is this file at all encoded to utf8 without BOM ?
    }

    function getTagHtmlFromCSV($tagString) {
        global $serendipity;
        static $taglink = null;

        if ($taglink == null) {
            $taglink = $this->get_config('taglink');
        }

        $links = array();
        if (empty($tagString)) {
            return array();
        }
        $tags = explode(',', $tagString);
        foreach($tags as $tag) {
            $tag = trim($tag);
            if (empty($tag)) {
                continue;
            }
            $links[] = "\n".'    <a href="' . $taglink . self::makeURLTag($tag) . '"' .
                       ' title="' . self::specialchars_mapper($tag) . '"' .
                       ' rel="tag">' . self::specialchars_mapper($tag) . '</a>';

        }

        return implode(', ', $links);
    }

    function getTagHtml($tags, $extended_smarty = false) {
        global $serendipity;
        static $taglink = null;

        $links = array();

        if ($taglink == null) {
            $taglink = $this->get_config('taglink');
        }

        if (!is_array($tags)) {
            return '';
        }

        $technorati     = $this->get_config('technorati_tag_link');
        $technorati_img = $this->get_config('technorati_tag_image');
        $img_url        = $this->get_config('path_img',$serendipity['serendipityHTTPPath'] . 'plugins/serendipity_event_freetag/img/');

        foreach($tags as $tag) {
            $tag = trim($tag);
            if (empty($tag)) {
                continue;
            }
            $links[] = "\n".'    <a href="' . $taglink . self::makeURLTag($tag) . '"' .
                   ' title="' . self::specialchars_mapper($tag) . '"' .
                   ' rel="tag">' . self::specialchars_mapper($tag) . '</a>' .
                   ($technorati?'<a href="http://technorati.com/tag/' . urlencode($tag) . '" class="serendipity_freeTag_technoratiTag" rel="tag"><img style="border:0;vertical-align:middle;margin-left:.4em" src="' . $technorati_img . '?tag=' . urlencode($tag) . '" alt="technorati" /></a>':'');

        }
        if ($extended_smarty) {
            return $links;
        } else {
            return implode(', ', $links);
        }
    }

    function getRelatedEntries($tags, $postID) {
        global $serendipity;

        if (!is_array($tags)) {
            return false;
        }

        foreach($tags AS $idx => $tag) {
            $tags[$idx] = serendipity_db_escape_string($tag);
        }

        $q = "SELECT DISTINCT e1.entryid,
                     e2.title,
                     e2.timestamp
                FROM {$serendipity['dbPrefix']}entrytags AS e1
           LEFT JOIN {$serendipity['dbPrefix']}entries   AS e2
                  ON e1.entryid = e2.id
               WHERE e1.tag IN ('" . implode("', '", $tags) . "')
                 AND e1.entryid != " . (int)$postID . "
                 AND e2.isdraft = 'false'
                     " . (!serendipity_db_bool($serendipity['showFutureEntries']) ? " AND e2.timestamp <= " . time() : '') . "
            ORDER BY e2.timestamp DESC
               LIMIT " . $this->get_config('show_related_count', 5);

        $result = serendipity_db_query($q, false, 'assoc', false, 'entryid', 'title');

        if (!is_array($result)) {
            return false;
        }

        return $result;
    }

    function getRelatedEntriesHtml(&$entries, $extended_smarty = false) {
        global $serendipity;

        if (!is_array($entries)) {
            return false;
        }

        if ($extended_smarty) {
            $ret = array();
            $ret['description'] = PLUGIN_EVENT_FREETAG_RELATED_ENTRIES;
            foreach($entries AS $entryid => $title) {
                // prepare preset anchor link in a simple array
                $ret['entries'][] = '<a href="' . serendipity_archiveURL($entryid, $title) . '" title="' . self::specialchars_mapper($title) . '">' . self::specialchars_mapper($title) . '</a>';
                // You can have EITHER / OR, NOT both(!), without compat break - that means, switching here by hand or have to add another plugin config option for this case.
                #$ret['entries'][] = array('url' => serendipity_archiveURL($entryid, self::specialchars_mapper($title)) , 'title' => self::specialchars_mapper($title));
                /*
                Returning the entries array this way will need you to extend the array readout in the entries.tpl extended example and may need to run this "flattened" loop as
                foreach($entries AS $entry) {
                    $ret['entries'][] = array('url' => serendipity_archiveURL($entry['id'], self::specialchars_mapper($entry['title'])) , 'title' => self::specialchars_mapper($entry['title']) , 'and so on' => 'for more additions per key' );
                }
                since now being a full multi-dimensional array, if you want to add more like an entries teaser image for expample.
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
                $ret .= '    <li> <a href="' . serendipity_archiveURL($entryid, $title) . '" title="' . self::specialchars_mapper($title) . '">' . self::specialchars_mapper($title) . "</a></li>\n";
            }
            $ret .= "    </ul>\n</div>\n";
        }

        return $ret;
    }

    /**
     * This method can be called statically.
     * Tags should be an array with the key being the tag name, and val being
     * the number of occurances.
     */
    static function displayTags($tags, $xml, $nl, $scaling, $maxSize = 200, $minSize = 100,
                                $useFlash = false, $flashbgtrans = true, $flashtagcolor = 'ff6600', $flashbgcolor = 'ffffff', $flashwidth = 190, $flashspeed = 100,
                                $cfg_taglink, $cfg_template, $xml_image = 'img/xml.gif', $useRotCanvas = false, $rcTagColor = '3E5F81', $rcTagOLColor = 'B1C1D1', $rcTagWidth = 300, $useWordCloud = false)
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
            self::renderTags($tags, $xml, $nl, $scaling, $maxSize, $minSize, $useFlash, $flashbgtrans, $flashtagcolor, $flashbgcolor, $flashwidth, $flashspeed, $taglink, $xml_image, $useRotCanvas, $rcTagColor, $rcTagOLColor, $rcTagWidth, $useWordCloud);
        } else {
            arsort($tags);
            $tagsWithLinks = array();
            foreach ($tags as $tag => $count) {
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


    static function renderTags($tags, $xml, $nl, $scaling, $maxSize, $minSize, $useFlash, $flashbgtrans, $flashtagcolor, $flashbgcolor, $flashwidth, $flashspeed, $taglink, $xml_image = 'img/xml.gif', $useRotCanvas, $rcTagColor, $rcTagOLColor, $rcTagWidth, $useWordCloud)
    {
        global $serendipity;

        // Hey! Do NOT allow mixing clouds !
        if ($flash && ($useRotCanvas || $useWordCloud)) {
            $flash = false;
        }
        if ($useRotCanvas && ($flash || $useWordCloud)) {
            $useRotCanvas = false;
        }
        if ($useWordCloud && ($flash || $useRotCanvas)) {
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

        $scale    = ($biggest - $smallest); // eg 3 - 0.5 = 2.5

        if ($scale < 0) {
            $scale = 1;
        }

        $key = uniqid(rand());

        if ($useFlash) {

            echo '<div id="flashcontent' . $key . '">'. "\n";

            echo "\n". '<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" width="' . $flashwidth .'" height="' . round($flashwidth * 0.75) . '" id="tagcloud' . $key . '" name="tagcloud' . $key . '">'. "\n";
            echo '<param name="movie" value="' . $serendipity['serendipityHTTPPath'] .'plugins/serendipity_event_freetag/tagcloud.swf" />'. "\n";
            echo '<param name="wmode" value="transparent" />'. "\n";
            echo '<param name="flashvars" value="tcolor=0x' . $flashtagcolor . '&amp;mode=tags&amp;distr=true&amp;tspeed=' . $flashspeed .'&amp;tagcloud=%3Ctags%3E';

        } elseif ($useRotCanvas) {

            echo '
                <div id="freeTagCanvas' . $key . '" class="freetag_rotacloud">
                    <canvas id="tagCanvas' . $key . '" class="rotaCanvas" width="' . $rcTagWidth .'" height="' . round($rcTagWidth * 0.75) . '">
                        <!--<p style="color:#222">Sorry! Your browser is too old to support this canvas element!</p>-->
                    </canvas>
                </div>
                <div id="tags" style="margin-top: -' . round($rcTagWidth * 0.75) . 'px;">
                    <ul class="plainList">
                ';// Remember: Why do we set a #tags -margin-top height here? Since it prevents an empty block in case the rotacloud could not display and this taglist is used as a fallback!

        } elseif ($useWordCloud) {

            echo '
                <div id="freetag_wordcloud' . $key . '" class="freetag_wordcloud">
                ';

        } else {
            echo "<ul class=\"plainList\">\n";
        }

        $cont     = $useFlash ? 'span' : 'li';
        $tagparam = '';
        $html     = '';

        echo "\n ";

        foreach($tags AS $name => $quantity) {
            if (empty($name)) {
                continue;
            }

            $title = self::specialchars_mapper($name);

            if (!$first && !$nl) {
                if (!$scaling) {
                    $html .= ', ';
                } else {
                    $html .= ' ';
                }
            }

            // don't use with canvas cloud elements!
            if ($xml && !$useRotCanvas && !$useWordCloud) {
                $html .= '<'.$cont.' class="serendipity_freeTag_xmlTagEntry"><a rel="tag" class="serendipity_xml_icon" href="' . $rsslink . urlencode($name) . '" title="' . $title . '">'.
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

            $html .= '<a rel="tag" href="' . $taglink . self::makeURLTag($name) . '" title="' . $title . ($quantity > 0 ? ' (' . $quantity . ') ' : '') . '">' . $title . '</a>';

            if ($scaling && !$useRotCanvas) {
                $html .= "</span>\n";
            }

            if (($xml || $useRotCanvas) && !$useWordCloud) {
                $html .= "</$cont>\n";
            }

            if (($nl && $cont == 'span') || ($nl && $cont == 'span' && !$useRotCanvas && !$useWordCloud && !$useFlash)) {
                $html .= "<br />\n";
            }

            $first = false;
            $tagparam .= "%3Ca href='" . $taglink . self::makeURLTag($name) . "' style='" . round($fontSize/5) . "'%3E" . str_replace(' ', '&nbsp;', $title) . "%3C/a%3E";
        }

        if ($useFlash) {
            echo $tagparam;
            echo '%3C/tags%3E" />' . "\n";
            echo '<!--[if !IE]>-->' . "\n";
            echo "\n" . '<object type="application/x-shockwave-flash" data="' . $serendipity['serendipityHTTPPath'] .'plugins/serendipity_event_freetag/tagcloud.swf" width="' . $flashwidth .'" height="' . round($flashwidth * 0.75) . '">'. "\n";
            echo '<param name="wmode" value="transparent" />' . "\n";
            echo '<param name="flashvars" value="tcolor=0x' . $flashtagcolor . '&amp;mode=tags&amp;distr=true&amp;tspeed=' . $flashspeed .'&amp;tagcloud=%3Ctags%3E';
            echo $tagparam;
            echo '%3C/tags%3E" />'. "\n";
            echo '<!--<![endif]-->'. "\n";
        }

        echo $html;

        if ($useFlash) {

            echo '<!--[if !IE]>-->'. "\n";
            echo '</object>'. "\n";
            echo '<!--<![endif]-->'. "\n";
            echo '</object>'. "\n";
            echo '</div>'. "\n";

        } elseif ($useRotCanvas) {
            echo '
                    </ul>
                </div>
                <script type="text/javascript">
                    jQuery(document).ready(function() {
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
                    });
                </script>
                ';
        } elseif ($useWordCloud) {

            $grid = ($multiply == 3) ? 3 : 9; // reverse for the grid to reduce render slowdowns with too many tags
            $grid = ($multiply == 2) ? 6 : $grid;  // with a small amount of tags grid could be set to 1 too
            echo '
                </div>
                <script type="text/javascript">
                    jQuery(document).ready(function() {
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
                    });
                </script>
                ';
        } else {
            echo "</ul>\n";
        }
    }

    /**
     * Return case sensitive array_unique
     * @param array
     * @return array
     */
    function array_iunique($a) {
        if (function_exists('mb_strtolower')) {
            return array_intersect_key($a, array_unique(array_map('mb_strtolower', $a)));
        } else {
            return array_intersect_key($a, array_unique(array_map('strtolower', $a)));
        }
    }

    /**
     * Return array_map callback for strtolower
     * @param array
     * @return array
     */
    function array_imap($a) {
        if (function_exists('mb_strtolower')) {
            return array_map('mb_strtolower', $a);
        } else {
            return array_map('strtolower', $a);
        }
    }

    function event_hook($event, &$bag, &$eventData, $addData = null) {
        global $serendipity;

        $hooks = &$bag->get('event_hooks');

        if (isset($hooks[$event])) {

            switch($event) {

                case 'backend_delete_entry':
                    $this->deleteTagsForEntry((int)$eventData);
                    break;

                case 'frontend_header':
                    if (serendipity_db_bool($this->get_config('use_flash', 'false'))) {
                        echo '<script type="text/javascript" src="';
                        echo $serendipity['serendipityHTTPPath'];
                        echo 'plugins/serendipity_event_freetag/swfobject.js"></script>'. "\n";
                        echo '<script type="text/javascript">'. "\n";
                        echo 'swfobject.registerObject("tagcloud", "9.0.0", "expressInstall.swf");'. "\n";
                        echo '</script>'. "\n";
                    }

                    // we load both in either case, as long as the option show_tagcloud is enabled,
                    // since it could be that someone wants to use two different clouds (plain, wordcanvas, rotacanvas, flash), differed by event/sidebar plugin!
                    if (serendipity_db_bool($this->get_config('show_tagcloud', 'true'))) {
                        if (!class_exists('serendipity_event_jquery') && !$serendipity['capabilities']['jquery']) {
                        echo '
    <script type="text/javascript" src="'.$serendipity['serendipityHTTPPath'].'plugins/serendipity_event_freetag/jquery-1.11.3.min.js"></script>
                            ';
                        }
                        echo '
    <script type="text/javascript" src="'.$serendipity['serendipityHTTPPath'].'plugins/serendipity_event_freetag/jquery.tagcanvas.min.js"></script>
    <script type="text/javascript" src="'.$serendipity['serendipityHTTPPath'].'plugins/serendipity_event_freetag/jquery.awesomeCloud-0.2.js"></script>
                        ';
                    }

                    $this->displayMetaKeywords($serendipity['GET']['id'], $this->displayTag);
                    break;

                case 'frontend_display:rss-2.0:per_entry':
                case 'frontend_display:rss-0.91:per_entry':
                    $eventData['display_dat'] .= $this->getFeedXmlForTags('category', $eventData['properties']['freetag_tags']);
                    break;

                case 'frontend_display:rss-1.0:per_entry':
                case 'frontend_display:rss-0.91:per_entry':
                case 'frontend_display:atom-0.3:per_entry':
                case 'frontend_display:atom-1.0:per_entry':
                    $eventData['display_dat'] .= $this->getFeedXmlForTags('dc:subject', $eventData['properties']['freetag_tags']);
                    break;

                case 'external_plugin':

                    $uri_parts      = explode('?', str_replace(array('&amp;', '%FF'), array('&', '.'), $eventData));
                    $taglist        = serendipity_db_bool($this->get_config('taglist', 'false'));
                    $param          = $taglist ? explode('/', str_replace('/taglist', '', $uri_parts[0])) : explode('/', $uri_parts[0]);
                    $plugincode     = array_shift($param);
                    $tagged_as_list = false;

                    // By option or manually added: example.org/plugin/taglist/Serendipity/Blog/Plums - see below
                    if ($plugincode == "taglist") $plugincode = "tags";

                    if (($plugincode == "tag") || ($plugincode == "tags") || ($plugincode == "freetag")) {

                        // Manually added (last) parameter 'taglist' to view tags by list for certain taglinks eg.: example.org/plugin/tag/Serendipity/Blog/Plums/taglist - both need a modified entries.tpl
                        if ($taglist && in_array('taglist', $serendipity['uriArguments'])) {
                            $param = array_map('urldecode', $param);
                            $param = array_map('urldecode', $param); // for doubled encoded tag umlauts via searchengine backlinks
                            $param = is_array($param) ? array_map('strip_tags', $param) : strip_tags($param);
                            $param = array_filter($param); // filter out all left BOOL, NULL and EMPTY elements, which still are possible by removing XSS with strip_tags

                            if (!is_object($serendipity['smarty'])) {
                                serendipity_smarty_init(); // to avoid member function assign() on a non-object error, start Smarty templating
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
                                    $serendipity['smarty']->assign('head_subtitle', sprintf(PLUGIN_EVENT_FREETAG_USING, self::specialchars_mapper($param[0])));
                                }
                            }
                            $serendipity['smarty']->assign('taglist', true);
                            foreach($serendipity['uriArguments'] AS $uak => $uav) {
                                if ($uav == 'taglist') unset($serendipity['uriArguments'][$uak]);
                            }
                            $tagged_as_list = true;
                        }

                        /* Attempt to locate hidden variables within the URI */
                        foreach ($serendipity['uriArguments'] as $k => $v) {
                            if ($v[0] == 'P') { /* Page */
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
                            $param = urldecode($param); // for doubled encoded tag umlauts via searchengine backlinks
                            $param = strip_tags($param);
                            $serendipity['head_subtitle'] = sprintf(PLUGIN_EVENT_FREETAG_USING, self::specialchars_mapper($param));
                            $emit_404 = true;
                        } else {
                            if (!$tagged_as_list) {
                                $param = array_map('urldecode', $param);
                                $param = array_map('urldecode', $param); // for doubled encoded tag umlauts via searchengine backlinks in sprintf
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
                        $param = is_array($param) ? array_map('strip_tags', $param) : strip_tags($param);
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

                        $serendipity['GET']['subpage'] = $eventData;
                        unset($serendipity['GET']['category']); // No restriction should be enforced here.

                        if ($tagged_as_list) {
                            $serendipity['fetchLimit'] = 99; // do not use frontend entries pagination if count < 100 entries
                        }
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
                        ob_end_clean(); // the "missing" ob_start() is defined in serendipity roots index.php file
                        $serendipity['smarty']->assign('raw_data', $raw_data);
                        if (serendipity_db_bool($this->get_config('show_tagcloud', 'true'))) {
                            $serendipity['smarty']->assign('istagcloud', true); // allows to remove a sidebar with a tag cloud, when using an entry cloud
                            // needs to change your template index.tpl sidebar condition(s), eg. {if !$istagcloud}
                        }
                        serendipity_gzCompression();
                        $serendipity['smarty']->display(serendipity_getTemplateFile($serendipity['smarty_file'], 'serendipityPath'));
                        @define('NO_EXIT', true); // RQ: Why did or do we (still) need this? (see index 2.1-alpha2 change)
                    }
                    break;

                case 'backend_sidebar_entries':
                    if ($serendipity['version'][0] < 2) {
                        echo "\n".'                        <li class="serendipitySideBarMenuLink serendipitySideBarMenuEntryLinks"><a href="?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=managetags">' . PLUGIN_EVENT_FREETAG_MANAGETAGS . '</a></li>'."\n";
                    } else {
                        echo "\n".'                        <li><a href="?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=managetags">' . PLUGIN_EVENT_FREETAG_MANAGETAGS . '</a></li>'."\n";
                    }
                    break;

                case 'backend_sidebar_entries_event_display_managetags':
                    $this->eventData = $eventData;
                    $this->displayManageTags($event, $bag, $eventData, $addData);
                    break;

                case 'backend_publish':
                case 'backend_save':
                    if (function_exists('mb_internal_encoding')) {
                        mb_internal_encoding(LANG_CHARSET);
                    }
                    if (!isset($eventData['id'])) {
                        break;
                    }
                    if ($serendipity['GET']['tagview'] == 'tagupdate' && !serendipity_db_bool($this->get_config('keyword2tag', 'false'))) {
                        break;
                    }

                    /*******
                     CLARIFY STATEMENT:
                        TAGS are stored to the database entrytags table like they are written by the user or being tagged already:
                            uppercased, mixed, lowercased, capitalised, etc. To change older tags, use the backend tag administration rename button function.
                        The 'lowercase_tags' option sets TAGS lowercased in every frontend related output at runtime and is used for comparison matters.
                     *******/

                    $to_lower  = serendipity_db_bool($this->get_config('lowercase_tags', 'true'));
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
                    if (!isset($serendipity['POST']['properties']['freetag_tagList']) && $serendipity['GET']['tagview'] != 'tagupdate' && $serendipity['GET']['tagview'] != 'cat2tag') {
                        $serendipity['POST']['properties']['freetag_tagList'] = implode(',', $this->getTagsForEntry($eventData['id'])); // as STRING
                    }
                    if (!empty($serendipity['POST']['properties']['freetag_tagList'])) {
                        $tags = $this->makeTagsFromTagList($serendipity['POST']['properties']['freetag_tagList']);
                    }

                    // check for keyword2tag empty or set cases
                    if (!is_array($tags) && empty($tags)) {
                        $tags = array();
                    }

                    if (empty($tags) && serendipity_db_bool($this->get_config('keyword2tag', 'false'))) {
                        $searchtext = strip_tags($eventData['body'] . $eventData['extended']);
                        // fetch oldtags AS ARRAY for each entry, valid to be checked for keywords
                        $oldtags = $this->makeTagsFromTagList(implode(',', $this->getTagsForEntry($eventData['id']))); // as ARRAY

                        foreach($automated AS $keyword => $ktags) {
                            $keyword = trim($keyword);
                            if (empty($keyword)) { continue; }
                            if (!is_array($ktags) || count($ktags) < 1) { continue; }

                            $keywordtag = array_pop(array_keys($ktags)); // get type key as string
                            if (is_array($oldtags) && in_array($keywordtag, $oldtags)) { continue; } // if automated keywordtag already is in oldtags, do next

                            // only match check those, which have no keywordtag yet
                            if (!is_array($key2tagIDs)) $key2tagIDs = array();
                            $regex = sprintf("/((\s+|[\(\[-]+)%s([-\/,\.\?!'\";\)\]]*+|[\/-]+))/i", $keyword);

                            if (preg_match($regex, $searchtext) > 0) {
                                foreach($ktags AS $tag => $is_assigned) {
                                    if (!is_array($tags) || (!in_array($tag, $tags) && !in_array($tag, $tags))) {

                                        if (!is_array($tags) && !empty($tag)) $tags = array(); // avoid having "[] operator not supported for strings" errors
                                        $tags[] = $tag;
                                        printf("\n<br /> - ".PLUGIN_EVENT_FREETAG_KEYWORDS_ADD, self::specialchars_mapper($keyword), self::specialchars_mapper($tag));
                                        if (!empty($tags)) {
                                            $key2tagIDs[] = $eventData['id']; // gather ids to updertEntries
                                        }
                                    }
                                }
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
                            foreach ($cats as $cat) {
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
                        if (!is_array($oldtags) && empty($oldtags)) {
                            $oldtags = $this->makeTagsFromTagList(implode(',', $this->getTagsForEntry($eventData['id']))); // as ARRAY
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

                    $key2tagIDs = (is_array($key2tagIDs) && !empty($key2tagIDs)) ? array_unique($key2tagIDs) : array();

                    // Only do this to entries which really changed tags!!
                    if ((is_array($tags) && !empty($tags) && $oldtags !== $tags) || (is_array($key2tagIDs) && in_array($eventData['id'], $key2tagIDs) && $oldtags !== $tags)) {
                        $this->deleteTagsForEntry($eventData['id']);
                        $this->addTagsToEntry($eventData['id'], $tags);
                    }
                    unset($key2tagIDs);
                    unset($oldtags);
                    unset($tags);

                    if (isset($serendipity['POST']['properties']['freetag_kill'])) {
                        $this->deleteTagsForEntry($eventData['id']);
                    }
                    // PLEASE NOTE: This modifies the 'last_modified' field for every entry successed in serendipity_updertEntry(), not really being necessary though.
                    // REMEMBER   : Never ever unset($eventData) here, since this can change and hit other plugins content too!
                    break;

                case 'css_backend':
                    if ($serendipity['version'][0] > 1) {
?>

.freetagMenu li {
    display: block;
    margin: 0 0 .5em;
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
        display: inline-block;
        margin: 0 .25em .5em 0;
    }
}

<?php
                    }
                    break;

                case 'js_backend':
                    // autocomplete with serendipity 2.0
                    if (serendipity_db_bool($this->get_config('admin_ftayt', 'false'))) {
                        echo '
function enableAutocomplete() {
    if (typeof(tags) != "undefined") {
        $("#properties_freetag_tagList").autocomplete(tags, {
            minChars: 0,
            multiple: true,
            scrollHeight: 200,
            matchContains: "word",
            autoFill: false
        });
    }
};

addLoadEvent(enableAutocomplete);

';
                    }
                    // keep for 2.0 < 2.1 version, since they do not have this nice config grouper item
                    if ($serendipity['version'][0] == 2 && version_compare($serendipity['version'], '2.0.99', '<')) {
                        echo '
$(document).ready(function() {
    $(\'.configure_plugin div.configuration_group\').each(function() {
        if(!/[\S]/.test($(this).html())) {
            $(this).replaceWith(\'<hr class="config_separator" style="visibility:hidden">\');
        }
    });
});
                        ';
                    }
                    break;

                case 'backend_display':
                    if (function_exists('mb_internal_encoding')) {
                        mb_internal_encoding(LANG_CHARSET);
                    }

                    if (!empty($serendipity['POST']['properties']['freetag_tagList'])) {
                        $tagList = $serendipity['POST']['properties']['freetag_tagList'];
                    } else if (isset($eventData['id'])) {
                        // this is the backend entries tag list input field - the tags already assigned to an entry
                        $tagList = implode(',', $this->getTagsForEntry($eventData['id'])); // as STRING
                    } else {
                        $tagList = '';
                    }

                    // Why should we do this, if already fetched by eventData ID or POST? Seems redundant, thats why I added the empty() check.
                    //     (This was previously part of setting list tags lowercased into the input field)
                    if (empty($tagList)) {
                        $freetags = $this->makeTagsFromTagList($tagList);
                        if (!empty($freetags)) {
                            $tagList = implode(',', $freetags);
                        }
                    }

                    $tagsArray = (array)$this->getAllTags();

                    if (serendipity_db_bool($this->get_config('admin_ftayt', 'false'))) {
                        $wicktags = array();
                        foreach ($tagsArray as $k => $v) {
                            $wicktags[] = '\'' . addslashes($k) . '\'';
                        }
                        // jQuery Migrate is used due to $.browser of autocomplete plugin not being available in jquery 1.9+
                        echo '
                        ' . ($serendipity['version'][0] < 2 ? '<script type="text/javascript" src="' . $serendipity['baseURL'] . 'plugins/serendipity_event_freetag/jquery-1.11.3.min.js"></script>' : '') . '
                        <link rel="stylesheet" type="text/css" href="' . $serendipity['baseURL'] . 'plugins/serendipity_event_freetag/jquery.autocomplete.css" />
                        <script type="text/javascript" src="' . $serendipity['baseURL'] . 'plugins/serendipity_event_freetag/jquery-migrate-1.2.1.min.js"></script>
                        <script type="text/javascript" src="' . $serendipity['baseURL'] . 'plugins/serendipity_event_freetag/jquery.autocomplete.min.js"></script>
                        <script type="text/javascript">
                        var tags = [' . implode(',', $wicktags) . '];
                         ' . ($serendipity['version'][0] < 2 ? '
                        function enableAutocomplete() {
                            $("#properties_freetag_tagList").autocomplete(tags, {
                                        minChars: 0,
                                        multiple: true,
                                        scrollHeight: 200,
                                        matchContains: "word",
                                        autoFill: false
                                    })};
                            addLoadEvent(enableAutocomplete);
                         ' : '') . '
                        </script>'."\n";
                    }

                    if (serendipity_db_bool($this->get_config('admin_show_taglist', 'true'))) { // RQ: ToDo! MOVE SCRIPTs INTO js_backend js with 2.0+ ?
?>

                        <script type="text/javascript">
                        function addTag(addTag)
                        {
                            var elem = document.getElementById("properties_freetag_tagList");
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

                        function trim(str)
                        {
                            if (str) return str.replace(/^\s*|\s*$/g,"");
                             else return '';
                        }
                        </script>

<?php
                        if (serendipity_db_bool($this->get_config('admin_show_taglist', 'true'))) {
?>

                        <a name="tagListAnchor"></a>

<?php
                        }
                    }

                    if ($serendipity['version'][0] < 2) {
?>

                        <fieldset style="margin: 5px">
                            <legend><?php echo PLUGIN_EVENT_FREETAG_TITLE; ?></legend>
                            <label for="serendipity[properties][freetag_tagList]" title="<?php echo PLUGIN_EVENT_FREETAG_TITLE; ?>"><?php echo PLUGIN_EVENT_FREETAG_ENTERDESC; ?>:</label><br/>
                            <input type="text" name="serendipity[properties][freetag_tagList]" id="properties_freetag_tagList" class="wickEnabled input_textbox" value="<?php echo self::specialchars_mapper($tagList) ?>" style="width: 100%" />

                            <input id="properties_freetag_kill" name="serendipity[properties][freetag_kill]" class="input_checkbox" type="checkbox" value="true" />
                            <label for="serendipity[properties][freetag_kill]" title="<?php echo PLUGIN_EVENT_FREETAG_KILL; ?>"><?php echo PLUGIN_EVENT_FREETAG_KILL; ?></label><br/>

<?php
                        if (serendipity_db_bool($this->get_config('admin_show_taglist', 'true'))) {
?>

                            <div id="backend_freetag_list" style="margin: 5px; border: 1px dotted #000; padding: 5px; font-size: 9px;">

<?php
                        }

                    } else {
?>
                        <fieldset id="edit_entry_freetags" class="entryproperties_freetag">
                            <span class="wrap_legend"><legend><?php echo PLUGIN_EVENT_FREETAG_TITLE; ?></legend></span>
                            <div class="form_field">
                                <label for="properties_freetag_tagList" class="block_level"><?php echo PLUGIN_EVENT_FREETAG_ENTERDESC; ?>:</label>
                                <input id="properties_freetag_tagList" type="text" name="serendipity[properties][freetag_tagList]" class="wickEnabled" value="<?php echo self::specialchars_mapper($tagList) ?>">
                            </div>
                            <div class="form_check">
                                <input id="properties_freetag_kill" name="serendipity[properties][freetag_kill]" type="checkbox" value="true">
                                <label for="properties_freetag_kill"><?php echo PLUGIN_EVENT_FREETAG_KILL; ?></label>
                            </div>
<?php
                        if (serendipity_db_bool($this->get_config('admin_show_taglist', 'true'))) {
?>

                            <div id="backend_freetag_list">

<?php
                        }
                    }

                    if (serendipity_db_bool($this->get_config('admin_show_taglist', 'true'))) {
                        $lastletter = '';
                        foreach ($tagsArray as $tag => $count) {
                            if (function_exists('mb_strtoupper')) {
                                $upc = mb_strtoupper(mb_substr($tag, 0, 1, LANG_CHARSET), LANG_CHARSET);
                            } else {
                                $upc = strtoupper(substr($tag, 0, 1));
                            }
                            if (serendipity_db_bool($this->get_config('admin_delimiter', 'true')) && $upc != $lastletter) {
                                // HEY - DO NOT remove this FEATURE(!) for 2.0+!!
                                echo " <strong>|" . $upc . ':</strong> ';
                            }
                            if ($serendipity['version'][0] < 2) {
                                echo "<a href=\"#tagListAnchor\" style=\"text-decoration: none\" onClick=\"addTag('$tag')\">$tag</a>, ";
                            } else {
                                echo "<a href=\"#tagListAnchor\" onClick=\"addTag('$tag')\">$tag</a> ";
                            }
                            $lastletter = $upc;
                        }
                        echo "</div>\n";
                    }
?>

                        </fieldset>

<?php
                    break;


                case 'frontend_entryproperties':
                    $this->importEntryTagsIntoProperties($eventData, $addData);
                    break;

                case 'frontend_fetchentries':
                case 'frontend_fetchentry':
                    if (!empty($this->tags['show'])) {
                        if (is_array($this->tags['show'])) {
                            $showtag = array_map('serendipity_db_escape_string', $this->tags['show']);
                        } else {
                            $showtag = serendipity_db_escape_string($this->tags['show']);
                        }
                    } else if (!empty($serendipity['GET']['tag'])) {
                        $showtag = serendipity_db_escape_string(urldecode($serendipity['GET']['tag']));
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
                        } else if (is_array($showtag)) {
                            $_taglist = array();
                            $cond = '(1=2 ';
                            foreach($showtag AS $_showtag) {
                                $_taglist[] = serendipity_db_escape_string($_showtag);
                                $cond .= " OR entrytags.tag = $collateP '" . serendipity_db_escape_string($_showtag) . "' $collate ";
                            }
                            $cond .= ' ) ';
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
                    break;

                case 'frontend_rss':
                    if (!empty($this->displayTag)) {
                        $eventData['title'] .= serendipity_utf8_encode(self::specialchars_mapper(' (' . sprintf(PLUGIN_EVENT_FREETAG_USING, $this->displayTag) . ')'));
                    }
                    break;

                case 'entries_header':
                    if (isset($eventData['plugin_vars']['tag']) && serendipity_db_bool($this->get_config('show_tagcloud', 'true'))) {
                        if (!is_array($eventData['plugin_vars']['tag'])) {
                            $this->displayTagCloud($eventData['plugin_vars']['tag']); // single url tag only
                        } else {
                            $serendipity['smarty']->assign('freetag_tagTitle', self::specialchars_mapper(is_array($this->displayTag) ? implode(', ',$this->displayTag) : $this->displayTag));
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
                    // check if class exists in CSS, so a user has customized it and we don't need default
                    if (strpos($eventData, '.wordcloud') === false) {
                        $cloudcss .= '

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
.serendipity_plugin_freetag .serendipity_edit_nugget {
    margin-top: 1.5em;
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
                        $eventData .= $cloudcss;
                    }
                    // shutdown, since 2k11 delivers .serendipity_freeTag and some other freetag related selectors
                    if (strpos($eventData, '.serendipity_freeTag') === false) {
                        $this->addToCSS($eventData);
                    }
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
                        $tags = $this->makeTagsFromTagList($eventData['mt_keywords']);
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
                    break;
            }
            return true;
        }

        return false;
    }

    function displayEntry(&$eventData, $addData)
    {
        global $serendipity;

        $show_related = serendipity_db_bool($this->get_config('show_related', 'true'));
        $to_lower     = serendipity_db_bool($this->get_config('lowercase_tags', 'true'));

        $elements = count($eventData);

        // If not using extended-smarty, we want related entries only when
        // showing one single entry. It is better to ask Smarty here than doing
        // this manually for edge cases like overview pages
        if ($serendipity['version'][0] > 1) {
            $manyEntries = ! $serendipity['smarty']->getTemplateVars('is_single_entry');
        } else {
            $manyEntries = ! $serendipity['smarty']->get_template_vars('is_single_entry');
        }

        for ($entry = 0; $entry < $elements; $entry++) {
            // runs everywhere to generate a flattened array of tags
            $tags = $this->getTagsForEntry($eventData[$entry]['id']); // as ARRAY

            if ($to_lower) {
                $tags =  $this->array_imap($tags); // set to_lower for frontend entries (new)
            }

            // when in preview, maybe there are no tags stored yet
            if ($addData['preview'] && empty($tags)) {
                $tags = explode(',', $serendipity['POST']['properties']['freetag_tagList']);
            }
            $eventData = $this->addTags($entry, $tags, $eventData);

            if ($show_related) {
                $relatedEntries = $this->getRelatedEntries($tags, $eventData[$entry]['id']);
                $eventData = $this->addRelatedEntries($entry, $manyEntries, $relatedEntries, $eventData);
            }
        }
    }

    /**
     * Add related entries to eventData[$entry]
     *
     * $entry: number of entry in $eventData
     * for use in displayEntry
     */
    function addRelatedEntries($entry, $manyEntries, $relatedEntries, $eventData) {

        if (is_array($relatedEntries)) {
            if (serendipity_db_bool($this->get_config('extended_smarty', 'false'))) {
                $eventData[$entry]['freetag']['extended'] = true;
                $eventData[$entry]['freetag']['related'] = $this->getRelatedEntriesHtml($relatedEntries, true);
            } else if (!$manyEntries){
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
     * for use in displayEntry
     */
    function addTags($entry, $tags, $eventData) {
        if (!is_array($eventData)) $eventData = array();

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
                $entryText =& $this->getFieldReference($field, $eventData[$entry]);

                $entryText .= "\n".sprintf($msg, $this->getTagHtml($tags));
            }
        }
        return $eventData;
    }

    /**
     * Define and return entry field in eventData by condition
     * @see addRelatedEntries() and addTags()
     */
    function getField($eventData, $entry) {
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
     */
    // static
    static function makeTagsFromTaglist($tagList)
    {
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
     * This performs a memoization operation, so that if we happen to be
     * getting all tags more then one time per request, we only perform
     * the SQL query once
     */
    // static
    static function getAllTags()
    {
        global $serendipity;

        static $memo = false;

        if (is_array($memo)) {
            return $memo;
        }

        $q = "SELECT tag, count(tag) as total
                FROM {$serendipity['dbPrefix']}entrytags
            GROUP BY tag
            ORDER BY tag";

        $rows = serendipity_db_query($q);

        if (!is_array($rows)) {
            return array();
        }

        $memo = array();
        foreach((array)$rows as $r) {
            $memo[$r['tag']] = $r['total'];
        }

        serendipity_plugin_api::hook_event('sort', $memo);

        return $memo;
    }

    function displayTagCloud($tag)
    {
        global $serendipity;

        $tags = $this->getTagCloudTags($tag);

        $serendipity['smarty']->assign('freetag_tagTitle', self::specialchars_mapper(is_array($this->displayTag) ? implode(', ',$this->displayTag) : $this->displayTag));

        if (!empty($tags)) {
            $useRotCanvas = serendipity_db_bool($this->get_config('use_rotacloud', 'false'));
            $useWordCloud = serendipity_db_bool($this->get_config('use_wordcloud', 'false'));
            $serendipity['smarty']->assign('freetag_hasTags', true);

            $min = $this->get_config('min_percent', 100);
            $max = $this->get_config('max_percent', 300);

            ob_start();
            self::displayTags($tags, false, false, true, $max, $min,
                                                   serendipity_db_bool($this->get_config('use_flash', 'false')),
                                                   serendipity_db_bool($this->get_config('flash_bg_trans', 'true')),
                                                   $this->get_config('flash_tag_color', 'ff6600'), $this->get_config('flash_bg_color', 'ffffff'),
                                                   $this->get_config('flash_width', 600), $this->get_config('flash_speed', 100),
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
     */
    function getTagCloudTags($tag, $descend = true)
    {
        $to_lower = serendipity_db_bool($this->get_config('lowercase_tags', 'true'));

        $rows = serendipity_db_query($this->getTagCloudQuery('', $tag));

        if (is_array($rows)) {
            foreach((array)$rows as $r) {

                if ($to_lower) {
                    $r = $this->array_imap($r); // set to_lower for frontend clouds (new)
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

    function getTagCloudQuery($sort = '', $tag)
    {
        global $serendipity;
        if ($tag === true) {
            $q = "SELECT tag, count(tag) as total FROM {$serendipity['dbPrefix']}entrytags GROUP BY tag ORDER BY tag";
        } else {

            if (is_string($tag)) {
                $cond = "main.tag = '$tag'";
                $ncond = "neg.tag != '$tag'";
                $join = "LEFT JOIN {$serendipity['dbPrefix']}entrytags AS neg ".
                      "ON main.entryid = neg.entryid ";
                $totalModifier = '';
            } else if (is_array($tag)) {
                 $join = "LEFT JOIN {$serendipity['dbPrefix']}entrytags AS neg ".
                    "ON main.entryid = neg.entryid ";
                $ccond = '';
                $ncond = '';

                $first = true;
                $total = count($tag);

                $totalModifier = " - $total";

                for ($i = 0; $i < $total; $i++) {
                    if (!$first) {
                        $ncond .= " AND ";
                        $cond .= " AND ";
                    } else {
                        $first = false;
                    }

                    $join .= "LEFT JOIN {$serendipity['dbPrefix']}entrytags AS sub{$i} ".
                                "ON main.entryid = sub{$i}.entryid ";
                    $cond .= "sub{$i}.tag = '{$tag[$i]}' ";
                    $ncond .= "neg.tag != '{$tag[$i]}' ";
                }
            } else {
                return;
            }
            $q = "SELECT neg.tag AS tag, count(neg.tag) {$totalModifier} AS total
                    FROM {$serendipity['dbPrefix']}entrytags AS main
               {$join}
                   WHERE ($cond)
                     AND ($ncond)
                GROUP BY neg.tag";
        }

        if (serendipity_db_bool($this->get_config('use_flash', 'false'))) {
            $mt = $this->get_config('max_tags', 45);
        } else {
            $mt = $this->get_config('max_tags', 0);
        }

        if ($mt > 0 && $sort == '') {
            $q = $q . " LIMIT " . $mt;
        }

        return $q;
    }


    function displayMetaKeywords($id = null, $tag) {
        global $serendipity;
        $id = (int)$id;
        $max_keywords = (int)$this->get_config('meta_keywords', 0);
        if ($max_keywords < 1) {
            return;
        }

        if ($tag !== false && $tag !== true) { //show related tags
            $query = $this->getTagCloudQuery(' ORDER BY total DESC LIMIT ' . $max_keywords, $tag);
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
                    $not_first ? print(', ') : $not_first = true;
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
            $not_first ? print(', ') : $not_first = true;
            echo self::specialchars_mapper($r['tag']);
        }
        echo "\" />\n";
    }

    function getRelatedTags($tag) {
        global $serendipity;

        $q = "SELECT sub.tag AS tag, count(sub.tag) AS total
                FROM {$serendipity['dbPrefix']}entrytags AS main
           LEFT JOIN {$serendipity['dbPrefix']}entrytags AS sub
                  ON main.entryid = sub.entryid
               WHERE main.tag = '$tag'
                 AND sub.tag != '$tag'
            GROUP BY sub.tag
            ORDER BY sub.tag";

        $rows = serendipity_db_query($q);

        if (!is_array($rows)) {
            if (!serendipity_db_bool($rows)) {
                echo $rows;
            }
            return array();
        }

        foreach($rows as $r) {
            $tags[$r['tag']] = $r['total'];
        }

        return $tags;
    }

    function getLeafTags($leafWeight=1) {
        global $serendipity;

        $q = "SELECT tag, count(tag) as total
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
            foreach((array)$rows as $r) {
                $tags[$r['tag']] = $r['total'];
            }
        }
        if (empty($tags)) {
            echo '<span class="msg_notice"><span class="icon-info-circled"></span> ' . PLUGIN_EVENT_FREETAG_MANAGE_LEAFTAGS_NONE . "</span>\n";
        }
        return $tags;
    }

    static function getTagsForEntries($entries) {
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
        foreach($result as $row) {
            if (isset($row['entryid'])) {
                $gt[$row['entryid']][] = $row['tag'];
            }
        }
        return $gt;
    }

    /**
     * Fetches arrified tags by ID
     * Why uses array pop? It turns multi-dimensional arrays into flattened arrays!
     *
     * @param  int   entries $eventData['id']
     * @return array in any case for the tolower array_imap()
     */
    function getTagsForEntry($entryId) {
        $array = $this->getTagsForEntries(array($entryId));
        return (is_array($array) ? array_pop($array) : array());
    }

    function deleteTagsForEntry($entryId) {
        global $serendipity;

        $q = "DELETE FROM {$serendipity['dbPrefix']}entrytags WHERE entryid = ".(int)$entryId;
        serendipity_db_query($q);
    }

    // Static
    static function addTagsToEntry($entryId, $tags) {
        global $serendipity;

        if (!is_array($tags)) {
            return false;
        }

        foreach($tags as $tag) {
            $q = "INSERT INTO {$serendipity['dbPrefix']}entrytags (entryid, tag) VALUES (".(int)$entryId.", '".serendipity_db_escape_string($tag)."')";
            serendipity_db_query($q);
        }
    }

    // This may not be the right way to do this...
    function importEntryTagsIntoProperties(&$eventData, $addData) {
        // we do a dual loop here, which is probably the worst thing to do.
        // A better thing might be some kind of array merge action, but I am not
        // entirely sure how do do that with the arrays we are given.
        //
        // RefactorMe Later.

        // Loop one in getTagsForEntries
        $tagGroups = $this->getTagsForEntries(array_keys($addData));

        // Loop 2
        if (is_array($tagGroups))  {
            foreach($tagGroups as $entryId => $tagList) {
                $eventData[$addData[$entryId]]['properties']['freetag_tags'] = $tagList;
                $eventData[$addData[$entryId]]['properties']['freetag_tagList'] = implode(",", $tagList);
            }
        }
    }

    function getFeedXmlForTags($element, $tagList) {
        $out = '';
        if (!is_array($tagList)) {
            return $out;
        }

        foreach($tagList as $tag) {
            $out .= serendipity_utf8_encode("<$element>" . self::specialchars_mapper($tag) ."</$element>\n");
        }
        return $out;
    }

    function displayManageTags($event, &$bag, &$eventData, $addData) {
        global $serendipity;

        if ($this->get_config('dbversion', 1) != 2) {
            $this->install();
            $this->set_config('dbversion', 2);
        }
        if ($serendipity['version'][0] < 2) {
?>

            <div style="border: 1px solid #000;" class="freetagMenu">
            <ul>

<?php
        } else {
?>

            <h2><?php echo PLUGIN_EVENT_FREETAG_MANAGETAGS; ?></h2>

            <div class="freetagMenu">
                <ul class="plainList clearfix">

<?php
        }
?>

                    <li><a class="button_link" href="<?php echo FREETAG_MANAGE_URL ?>&amp;serendipity[tagview]=all" title="<?php echo PLUGIN_EVENT_FREETAG_MANAGE_ALL ?>">ALL</a></li>
                    <li><a class="button_link" href="<?php echo FREETAG_MANAGE_URL ?>&amp;serendipity[tagview]=leaf" title="<?php echo PLUGIN_EVENT_FREETAG_MANAGE_LEAF ?>">LEAF</a></li>
                    <li><a class="button_link" href="<?php echo FREETAG_MANAGE_URL ?>&amp;serendipity[tagview]=entryuntagged" title="<?php echo PLUGIN_EVENT_FREETAG_MANAGE_UNTAGGED ?>">NOTAG</a></li>
                    <li><a class="button_link" href="<?php echo FREETAG_MANAGE_URL ?>&amp;serendipity[tagview]=entryleaf" title="<?php echo PLUGIN_EVENT_FREETAG_MANAGE_LEAFTAGGED ?>">LEAFTAG</a></li>
                    <li><a class="button_link" href="<?php echo FREETAG_MANAGE_URL ?>&amp;serendipity[tagview]=keywords" title="<?php echo PLUGIN_EVENT_FREETAG_KEYWORDS; ?>">KEYWORD</a></li>
                    <li><a class="button_link" href="<?php echo FREETAG_MANAGE_URL ?>&amp;serendipity[tagview]=cat2tag" title="<?php echo PLUGIN_EVENT_FREETAG_GLOBALLINKS; ?>">CAT2TAG</a></li>
                    <li><a class="button_link" href="<?php echo FREETAG_MANAGE_URL ?>&amp;serendipity[tagview]=tagupdate" onclick="return confirm('<?php echo htmlspecialchars(PLUGIN_EVENT_FREETAG_REBUILD_DESC, ENT_COMPAT, LANG_CHARSET); ?>');" title="<?php echo PLUGIN_EVENT_FREETAG_REBUILD; ?>">AUTOTAG</a></li>
                    <li><a class="button_link" href="<?php echo FREETAG_MANAGE_URL ?>&amp;serendipity[tagview]=cleanupmappings" title="<?php echo PLUGIN_EVENT_FREETAG_MANAGE_CLEANUP; ?>">CLEAN</a></li>
                </ul>
            </div>

<?php
        if (isset($this->eventData['GET']['tagaction']) && !empty($this->eventData['GET']['tagaction'])) {
            $this->displayTagAction();
        }

        if (isset($this->eventData['GET']['tagview'])) {
            switch ($this->eventData['GET']['tagview']) {
                case "entryuntagged":
                    $this->displayUntaggedEntries();
                    break;

                case "entryleaf":
                    $this->displayLeafTaggedEntries();
                    break;

                case "all":
                    $tags = (array)$this->getAllTags();
                    $this->displayEditTags($tags);
                    break;

                case "leaf":
                    $tags = $this->getLeafTags();
                    $this->displayEditTags($tags);
                    break;

                case 'keywords':
                    $tags = (array)$this->getAllTags();
                    $this->displayKeywordAssignment($tags);
                    break;

                case 'tagupdate':
                    if (!serendipity_db_bool($this->get_config('keyword2tag', 'false'))) {
                        echo '<span class="msg_notice"><span class="icon-info-circled"></span>The option "' . PLUGIN_EVENT_FREETAG_KEYWORDS . '" is not set!</span>'."\n"; // i18n?
                        break;
                    }
                    $per_fetch = 25;
                    $page = (isset($serendipity['GET']['page']) ? $serendipity['GET']['page'] : 1);
                    $from = ($page - 1) * $per_fetch;
                    $to = ($page) * $per_fetch;
                    if ($serendipity['version'][0] > 1) {
                        echo '<h3>';
                    }
                    printf(PLUGIN_EVENT_FREETAG_REBUILD_FETCHNO, $from, $to);
                    $entries = serendipity_fetchEntries(
                        null,
                        true,
                        $per_fetch,
                        false,
                        false,
                        'timestamp DESC',
                        '',
                        true
                    );

                    $total = serendipity_getTotalEntries();
                    if ($serendipity['version'][0] < 2) {
                        printf(PLUGIN_EVENT_FREETAG_REBUILD_TOTAL . '<br />', $total);
                    } else {
                        printf(PLUGIN_EVENT_FREETAG_REBUILD_TOTAL, $total);
                        echo '</h3>';
                    }

                    if (is_array($entries)) {
                        if ($serendipity['version'][0] > 1) {
                            echo '<ul class="plainList">'."\n";
                        }
                        foreach ($entries AS $entry) {
                            unset($entry['orderkey']);
                            unset($entry['loginname']);
                            unset($entry['email']);
                            if ($serendipity['version'][0] < 2) {
                                printf('%d - "%s"<br />', $entry['id'], self::specialchars_mapper($entry['title']));
                            } else {
                                printf('    <li>%d - "%s"', $entry['id'], self::specialchars_mapper($entry['title']));
                            }
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
                            if ($serendipity['version'][0] < 2) {
                                echo DONE . "<br />\n";
                            } else {
                                echo ' ... ' . DONE . "</li>\n";
                            }
                        }
                        if ($serendipity['version'][0] > 1) {
                            echo "</ul>\n";
                        }
                    }
                    if ($serendipity['version'][0] < 2) {
                        echo '<br />';
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
                        if ($serendipity['version'][0] < 2) {
                            echo '<div class="serendipity_msg_notice">' . DONE . '</div>';
                        } else {
                            echo '<span class="msg_notice"><span class="icon-info-circled"></span>' . DONE . "</span>\n";
                        }
                    }
                    break;

                case 'cat2tag':
                    $e = serendipity_db_query(
                                     "SELECT e.id, e.title, c.category_name, et.tag
                                        FROM {$serendipity['dbPrefix']}entries AS e
                             LEFT OUTER JOIN {$serendipity['dbPrefix']}entrycat AS ec
                                          ON e.id = ec.entryid
                             LEFT OUTER JOIN {$serendipity['dbPrefix']}category AS c
                                          ON ec.categoryid = c.categoryid
                             LEFT OUTER JOIN {$serendipity['dbPrefix']}entrytags AS et
                                          ON e.id = et.entryid",
                        false,
                        'assoc'
                    );
                    // Get all categories and tags of all entries
                    $entries = array();
                    foreach ($e AS $row) {
                        $entries[$row['id']]['title'] = $row['title'];
                        $entries[$row['id']]['categories'][$row['category_name']] = $row['category_name'];
                        $entries[$row['id']]['tags'][$row['tag']] = $row['tag'];
                    }

                    // Cycle all entries
                    if ($serendipity['version'][0] > 1) {
                        echo '<ul class="plainList">'."\n";
                    }
                    foreach ($entries AS $id => $props) {
                        $newtags = array();
                        // Fetch all tags that should be added
                        foreach ($props['categories'] AS $tag) {
                            if (empty($tag)) continue;
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
                        if ($serendipity['version'][0] < 2) {
                            printf(
                                PLUGIN_EVENT_FREETAG_GLOBALCAT2TAG_ENTRY . '<br />',
                                $id,
                                self::specialchars_mapper($props['title']),
                                self::specialchars_mapper(implode(', ', $newtags))
                            );
                        } else {
                            echo '<li>';
                            printf(
                                PLUGIN_EVENT_FREETAG_GLOBALCAT2TAG_ENTRY,
                                $id,
                                self::specialchars_mapper($props['title']),
                                self::specialchars_mapper(implode(', ', $newtags))
                            );
                            echo "</li>\n";
                        }
                    }
                    if ($serendipity['version'][0] > 1) {
                        echo "</ul>\n";
                    }
                    if ($serendipity['version'][0] < 2) {
                        echo PLUGIN_EVENT_FREETAG_GLOBALCAT2TAG . '<br />';
                    } else {
                        echo '<span class="msg_notice"><span class="icon-info-circled"></span>' . PLUGIN_EVENT_FREETAG_GLOBALCAT2TAG . "</span>\n";
                    }
                    break;

                case 'cleanupmappings':
                    $this->cleanupTagAssignments();
                    break;

                default:
                    if (!empty($this->eventData['GET']['tagview'])) {
                        echo '<span class="msg_notice"><span class="icon-info-circled"></span> ' . "Can't execute tagview</span>\n";
                    }
                    break;
            }
        }
        return true;
    }

    function displayUntaggedEntries() {
        global $serendipity;

        $q = "SELECT e.id as id, e.title as title
                FROM {$serendipity['dbPrefix']}entries AS e
                LEFT OUTER JOIN {$serendipity['dbPrefix']}entrytags AS t
                    ON e.id = t.entryid
                WHERE entryid IS NULL
                GROUP BY e.id, e.title";

        $this->displayEditEntries($q);
    }

    function displayLeafTaggedEntries() {
        global $serendipity;

        $q = "SELECT e.id as id, e.title as title, t.tag, count(t.tag) as total
                FROM {$serendipity['dbPrefix']}entries AS e
                LEFT JOIN {$serendipity['dbPrefix']}entrytags AS t
                    ON e.id = t.entryid
                GROUP BY e.id, e.title
                HAVING total = 1";

        $this->displayEditEntries($q);
    }

    function displayEditEntries($q) {
        global $serendipity;

        $r = serendipity_db_query($q);

        if ($r === true) {
            if ($serendipity['version'][0] < 2) {
                echo PLUGIN_EVENT_FREETAG_MANAGE_UNTAGGED_NONE;
            } else {
                echo '<span class="msg_notice"><span class="icon-info-circled"></span> ' . PLUGIN_EVENT_FREETAG_MANAGE_UNTAGGED_NONE . "</span>\n";
            }
        } else if (!is_array($r)) {
            echo $r;
        } else {
            if ($serendipity['version'][0] > 1) {
                echo '<ul class="plainList freetags_list">'."\n";
            }
            foreach ($r as $row) {
                if ($serendipity['version'][0] < 2) {
                    echo '<p style="margin: 5px; border: 1px dotted #000; padding: 3px;" class="freetagMenu">
                            <a href="' . FREETAG_EDITENTRY_URL . $row['id'] . '"><img style="border: 0px;" src="' . serendipity_getTemplateFile('admin/img/edit.png') . '"></a>
                            ' . $row['title'] . '
                        </p>';
                } else {
                    echo '    <li>
                            <a class="button_link" href="' . FREETAG_EDITENTRY_URL . $row['id'] . '"><span class="icon-edit"></span><span class="visuallyhidden"> ' . EDIT . '</span></a>
                            ' . $row['title'] . (!empty($row['tag']) ? ' ( <strong>Single-Tag:</strong> <em>' . $row['tag'] . '</em> )' : '') . '
                        </li>'."\n"; // i18n?
                }
            }
            if ($serendipity['version'][0] > 1) {
                echo "</ul>\n";
            }
        }
    }

    function displayKeywordAssignment($taglist) {
        global $serendipity;

        if ($serendipity['POST']['keywordsubmit']) {
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
        $url = FREETAG_MANAGE_URL . "&amp;serendipity[tagview]=" . self::specialchars_mapper($this->eventData['GET']['tagview']);

        if ($serendipity['version'][0] < 2) {
            echo '<br />' . PLUGIN_EVENT_FREETAG_KEYWORDS_DESC . '<br /><br />';
        } else {
            echo '<span class="msg_notice"><span class="icon-info-circled"></span>' . PLUGIN_EVENT_FREETAG_KEYWORDS_DESC . "</span>\n";
        }
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
            foreach($taglist as $tag => $weight) {
?>
                <tr>
                    <td> <?php echo $tag; ?> </td>
                    <td>
<?php
            if (urldecode($serendipity['GET']['tag']) == $tag) {
?>
                        <a id="edit"></a>
                        <textarea rows="4" cols="40" name="serendipity[keywords]"><?php echo self::specialchars_mapper($keys[$tag]) ?></textarea>
<?php
            } else {
                        echo $keys[$tag];
            }
?>
                    </td>
                    <td>
<?php
            if (urldecode($serendipity['GET']['tag']) == $tag) {
?>
                        <input type="hidden" name="serendipity[tag]" value="<?php echo urlencode(urldecode($serendipity['GET']['tag'])); ?>" />
<?php
                    if ($serendipity['version'][0] < 2) {
?>
                        <input type="submit" name="serendipity[keywordsubmit]" class="serendipityPrettyButton input_button" value="<?php echo SAVE; ?>" />
<?php
                    } else {
?>
                        <input type="submit" name="serendipity[keywordsubmit]" value="<?php echo SAVE; ?>">
<?php
                    }
            } else {
                    if ($serendipity['version'][0] < 2) {
?>
                        <a href="<?php echo $url ?>&amp;serendipity%5Btag%5D=<?php echo urlencode($tag)?>#edit"><?php echo EDIT ?></a>
<?php
                    } else {
?>
                        <a class="button_link" title="<?php echo EDIT ?>" href="<?php echo $url ?>&amp;serendipity%5Btag%5D=<?php echo urlencode($tag)?>#edit"><span class="icon-edit"></span><span class="visuallyhidden"> <?php echo EDIT ?></span></a>
<?php
                    }
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
     * @param array $taglist
     */
    function displayEditTags(array $taglist = array()) {
        global $serendipity;
        if (count($taglist) === 0) {
            return;
        }
        $url = FREETAG_MANAGE_URL . "&amp;serendipity[tagview]=" . self::specialchars_mapper($this->eventData['GET']['tagview']);
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
            foreach($taglist as $tag => $weight) {
?>

                <tr>
                    <td><?php echo $tag; ?></td>
                    <td><?php echo $weight; ?></td>
                    <td>
<?php
                    if ($serendipity['version'][0] < 2) {
?>

                        <a href="<?php echo $url?>&amp;serendipity[tagaction]=rename&amp;serendipity[tag]=<?php echo urlencode($tag)?>"><?php echo PLUGIN_EVENT_FREETAG_MANAGE_ACTION_RENAME ?></a>
                        <a href="<?php echo $url?>&amp;serendipity[tagaction]=split&amp;serendipity[tag]=<?php echo urlencode($tag)?>"><?php echo  PLUGIN_EVENT_FREETAG_MANAGE_ACTION_SPLIT ?></a>
                        <a href="<?php echo $url?>&amp;serendipity[tagaction]=delete&amp;serendipity[tag]=<?php echo urlencode($tag)?>"><?php echo PLUGIN_EVENT_FREETAG_MANAGE_ACTION_DELETE ?></a>
<?php
                    } else {
?>

                        <a class="button_link" title="<?php echo PLUGIN_EVENT_FREETAG_MANAGE_ACTION_RENAME ?>" href="<?php echo $url?>&amp;serendipity[tagaction]=rename&amp;serendipity[tag]=<?php echo urlencode($tag)?>"><span class="icon-edit"></span><span class="visuallyhidden"> <?php echo PLUGIN_EVENT_FREETAG_MANAGE_ACTION_RENAME ?></span></a>
                        <a class="button_link" title="<?php echo  PLUGIN_EVENT_FREETAG_MANAGE_ACTION_SPLIT ?>" href="<?php echo $url?>&amp;serendipity[tagaction]=split&amp;serendipity[tag]=<?php echo urlencode($tag)?>"><span class="icon-resize-full"></span><span class="visuallyhidden"> <?php echo  PLUGIN_EVENT_FREETAG_MANAGE_ACTION_SPLIT ?></span></a>
                        <a class="button_link" title="<?php echo PLUGIN_EVENT_FREETAG_MANAGE_ACTION_DELETE ?>" href="<?php echo $url?>&amp;serendipity[tagaction]=delete&amp;serendipity[tag]=<?php echo urlencode($tag)?>"><span class="icon-trash"></span><span class="visuallyhidden"> <?php echo PLUGIN_EVENT_FREETAG_MANAGE_ACTION_DELETE ?></span></a>
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

<?php
    }

    /**
     * Here we are going to do a dispatch based on the action.
     * There are 2 dispatches that happen here: The first is the display/query, where
     * we ask the user for any extra information, and/or a confirmation.
     * The next is the actual action itself, where we do a db update/delete of some sort.
     */
    function displayTagAction() {
        $validActions = array('rename', 'split', 'delete');

        // Sanitize user input
        $tag    = urldecode($this->eventData['GET']['tag']);
        $action = urldecode(strtolower($this->eventData['GET']['tagaction']));

        if (!in_array($this->eventData['GET']['tagaction'], $validActions))
            exit ("DON'T HACK!");

        if ($this->eventData['GET']['commit'] == 'true') {
            $method = 'get'.ucfirst($this->eventData['GET']['tagaction']).'TagQuery';
            $q = $this->$method($tag, $this->eventData);
            echo '<span class="msg_success"><span class="icon-ok-circled"></span> ' . $this->eventData['GET']['tagaction'] . " Completed</span>\n"; // i18n?
        } else {
            $method = 'display'.ucfirst($this->eventData['GET']['tagaction']).'Tag';
            $this->$method($tag, $this->eventData);
        }
    }

    function getManageUrlAsHidden(&$eventData) {
        return '            <input type="hidden" name="serendipity[adminModule]" value="event_display" />
            <input type="hidden" name="serendipity[adminAction]" value="managetags" />'."\n";
    }

    function displayRenameTag($tag, &$eventData) {
?>

        <form action="" method="GET">
            <?php echo $this->getManageUrlAsHidden($this->eventData) ?>
            <input type="hidden" name="serendipity[tagview]" value="<?php echo self::specialchars_mapper($this->eventData['GET']['tagview']) ?>">
            <input type="hidden" name="serendipity[tagaction]" value="rename" />
            <input type="hidden" name="serendipity[commit]" value="true" />
            <input type="hidden" name="serendipity[tag]" value="<?php echo self::specialchars_mapper($tag) ?>" />
            <?php echo self::specialchars_mapper($tag) ?> =&gt; <input class="input_textbox" type="text" name="serendipity[newtag]" /> <input class="serendipityPrettyButton input_button" type="submit" name="submit" value="<?php echo PLUGIN_EVENT_FREETAG_MANAGE_ACTION_RENAME ?>" />
        </form>

<?php
    }

    /**
     * Execute a rename of a tag
     * We select all the entries with the old tag name, delete all entry tags
     * with the old tag name, and finally re insert.  The reason we do this is
     * that we might be renaming a tag, to an already exising tag that is
     * already associated to an entry, duplicating the primary key.
     * If we do it via an update, the update fails, and our rename doesn't
     * happen.  This way our update does happen, and we can siltenly fail
     * when we hit a duplicate key condition.
     * Postgres doesnt have an UPDATE IGNORE syntax, so we can't use that
     * method.  Sux0rz.
     */
    function getRenameTagQuery($tag, &$eventData) {
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

        foreach ($r as $row) {
            $q = "INSERT INTO {$serendipity['dbPrefix']}entrytags VALUES ('{$row['entryid']}','$newtag')";
            serendipity_db_query($q);
        }

        return true;
    }

    /* @see method call by displayTagAction */
    function displayDeleteTag($tag, &$eventData) {
        $no  = FREETAG_MANAGE_URL . "&amp;serendipity[tagview]=" . self::specialchars_mapper($this->eventData['GET']['tagview']);
        $yes = FREETAG_MANAGE_URL . "&amp;serendipity[tagview]=" . self::specialchars_mapper($this->eventData['GET']['tagview']).
                    "&amp;serendipity[tagaction]=delete".
                    "&amp;serendipity[tag]=".urlencode($tag)."&amp;serendipity[commit]=true";
?>

        <div class="msg_notice">
            <h3> <?php printf(PLUGIN_EVENT_FREETAG_MANAGE_CONFIRM_DELETE, self::specialchars_mapper($tag)) ?></h3>
            <a class="button_link state_submit" href="<?php echo $yes; ?>"><?php echo YES; ?></a> &nbsp; &nbsp; <a class="button_link state_cancel" href="<?php echo $no; ?>"><?php echo NO; ?></a>
        </div>

<?php
    }

    /* @see method call by displayTagAction */
    function getDeleteTagQuery($tag, &$eventData) {
        global $serendipity;

        $tag = serendipity_db_escape_string($tag);

        $q = "DELETE FROM {$serendipity['dbPrefix']}entrytags
               WHERE tag='$tag'";

        $r = serendipity_db_query($q);
        if ($r !== true) {
            echo $r;
        }
    }

    /* @see method call by displayTagAction */
    function displaySplitTag($tag, &$eventData) {
        if (strstr($tag, ' ')) {
            $newtag = str_replace(' ', ',', $tag);
        } else {
            $newtag = '';
        }
?>

        <form action="" method="GET">
            <?php echo $this->getManageUrlAsHidden($this->eventData) ?>
            <input type="hidden" name="serendipity[tagview]" value="<?php echo self::specialchars_mapper($this->eventData['GET']['tagview']) ?>">
            <input type="hidden" name="serendipity[tagaction]" value="split" />
            <input type="hidden" name="serendipity[commit]" value="true" />
            <input type="hidden" name="serendipity[tag]" value="<?php echo self::specialchars_mapper($tag) ?>" />
            <p> <?php echo PLUGIN_EVENT_FREETAG_MANAGE_INFO_SPLIT ?> <br/>
                foobarbaz =&gt; foo,bar,baz</p>
            <?php echo self::specialchars_mapper($tag) ?> =&gt; <input class="input_textbox" type="text" name="serendipity[newtags]" value="<?php echo self::specialchars_mapper($newtag) ?>" />
            <input class="serendipityPrettyButton input_button" type="submit" name="submit" value="split" />
        </form>

<?php
    }

    /* @see method call by displayTagAction */
    function getSplitTagQuery($tag, &$eventData) {
        global $serendipity;

        $newtags = $this->makeTagsFromTaglist(urldecode($this->eventData['GET']['newtags']));
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

        foreach ($entries as $entryid) {
            foreach ($newtags as $tag) {
                $q = "INSERT INTO {$serendipity['dbPrefix']}entrytags (entryid, tag)
                        VALUES ('{$entryid['entryid']}', '$tag')";
                $r = serendipity_db_query($q);
            }
        }
    }

    function cleanupTagAssignments() {
        global $serendipity;

        if ($serendipity['version'][0] < 2) {
            echo "<br>";
        }

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
                foreach ($mappings as $mapping) {
                    if (!in_array($mapping['entryid'], array_values($entryIDs))) {
                        $entryIDs[] = $mapping['entryid'];
                    }
                }
                $q_cleanup = "DELETE FROM {$serendipity['dbPrefix']}entrytags
                                    WHERE entryid IN (".implode(", ", $entryIDs).")";
                $cleanup = serendipity_db_query($q_cleanup);

                if ($cleanup === TRUE) {
                    if ($serendipity['version'][0] < 2) {
                        echo "<b>".PLUGIN_EVENT_FREETAG_MANAGE_CLEANUP_SUCCESSFUL."</b>";
                    } else {
                        echo '<span class="msg_success"><span class="icon-ok-circled"></span> ' . PLUGIN_EVENT_FREETAG_MANAGE_CLEANUP_SUCCESSFUL . "</span>\n";
                    }
                }
                else {
                    if ($serendipity['version'][0] < 2) {
                        echo "<b>".PLUGIN_EVENT_FREETAG_MANAGE_CLEANUP_FAILED."</b><br><br><b>DB-Error:</b>".$cleanup;
                    } else {
                        echo '<div class="msg_error"><p><span class="icon-attention-circled"></span> ' . PLUGIN_EVENT_FREETAG_MANAGE_CLEANUP_FAILED . '</p><strong>DB-Error:</strong> ' . $cleanup . "</div>\n";
                    }
                }
            }
            else {
                // Show inconsistencies

                foreach ($mappings as $mapping) {
                    $cleanup_tags[$mapping['tag']][] = $mapping['entryid'];
                }
                if ($serendipity['version'][0] < 2) {
                    echo PLUGIN_EVENT_FREETAG_MANAGE_CLEANUP_INFO."<br><br>";
                } else {
                    echo '<span class="msg_notice"><span class="icon-info-circled"></span> ' . PLUGIN_EVENT_FREETAG_MANAGE_CLEANUP_INFO . "</span>\n";
                }

                // Display list of found inconsistencies
                echo "<table class='freetags_manage'>\n<thead>\n";
                echo "    <tr><th>".PLUGIN_EVENT_FREETAG_MANAGE_LIST_TAG."</th><th>".PLUGIN_EVENT_FREETAG_MANAGE_CLEANUP_ENTRIES."</th></tr>\n";
                echo "</thead><tbody>\n";
                foreach ($cleanup_tags as $tag => $entries) {
                    echo "<tr><td>$tag</td><td>".implode(', ', $entries)."</tr>\n";
                }
                echo "</tbody></table>\n";

                // Display submit form to start cleanup process
                echo '<form action="" method="GET">'."\n";
                echo $this->getManageUrlAsHidden($this->eventData);
                echo '    <input type="hidden" name="serendipity[tagview]" value="' . self::specialchars_mapper($this->eventData['GET']['tagview']) . '">'."\n";
                echo '    <input type="hidden" name="serendipity[perform]" value="true" />'."\n";
                if ($serendipity['version'][0] < 2) {
                    echo '    <input class="serendipityPrettyButton input_button" type="submit" name="submit" value="'.PLUGIN_EVENT_FREETAG_MANAGE_CLEANUP_PERFORM.'" />'."\n";
                } else {
                    echo '    <input type="submit" name="submit" value="'.PLUGIN_EVENT_FREETAG_MANAGE_CLEANUP_PERFORM.'">'."\n";
                }
                echo "</form>\n";
            }
        }
        elseif ($mappings === TRUE) {
            // No inconsistencies found
            if ($serendipity['version'][0] < 2) {
                echo "<b>".PLUGIN_EVENT_FREETAG_MANAGE_CLEANUP_NOTHING."</b>";
            } else {
                echo '<span class="msg_notice"><span class="icon-info-circled"></span> ' . PLUGIN_EVENT_FREETAG_MANAGE_CLEANUP_NOTHING . "</span>\n";
            }
        }
        else {
            // An error occures while searching for inconsistencies
            if ($serendipity['version'][0] < 2) {
                echo "<b>".PLUGIN_EVENT_FREETAG_MANAGE_CLEANUP_LOOKUP_ERROR."</b><br><br><b>DB-Error:</b>".$mappings;
            } else {
                echo '<div class="msg_error"><p><span class="icon-attention-circled"></span> ' . PLUGIN_EVENT_FREETAG_MANAGE_CLEANUP_LOOKUP_ERROR . '</p><strong>DB-Error:</strong> ' . $mappings . "</div>\n";
            }
        }
    }

    function addToCSS(&$eventData) {
        $eventData .= '

/* serendipity_event_freetag plugin start */

.serendipity_freeTag
{
    margin-left: auto;
    margin-right: 0px;
    text-align: right;
    font-size: 7pt;
    display: block;
    margin-top: 5px;
    margin-bottom: 0px;
}

.serendipity_freeTag_related
{
    margin-left: 50px;
    margin-right: 0px;
    text-align: left;
    font-size: small;
    display: block;
    margin-top: 20px;
    margin-bottom: 0px;
}

' . (serendipity_db_bool($this->get_config('use_flash', 'false')) ? '
.serendipity_freetag_taglist
{
    margin: 10px;
    border: 1px solid #' . $this->get_config('flash_tag_color', 'ffffff') . ';
    padding: 5px;
    background-color: #' . $this->get_config('flash_bg_color', 'ffffff') . ';
    text-align: justify;
}
' : '') . '

.serendipity_freeTag a
{
    font-size: 7pt;
    text-decoration: none;
}

.serendipity_freeTag a:hover
{
    color: green;
    text-decoration: underline;
}
img.serendipity_freeTag_xmlButton
{
    vertical-align: bottom;
    display: inline;
    border: 0px;
}

/* serendipity_event_freetag plugin end */

';
    }

    function debugMsg($msg) {
        global $serendipity;

        $this->debug_fp = @fopen ( $serendipity ['serendipityPath'] . 'templates_c/freetag.log', 'a' );
        if (! $this->debug_fp) {
            return false;
        }

        if (empty ( $msg )) {
            fwrite ( $this->debug_fp, "failure \n" );
        } else {
            fwrite ( $this->debug_fp, print_r ( $msg, true ) );
        }
        fclose ( $this->debug_fp );
    }
}

/* vim: set sts=4 ts=4 expandtab : */
