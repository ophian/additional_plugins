<?php

if (IN_serendipity !== true) {
    die ("Don't hack!");
}

// Load possible language files.
@serendipity_plugin_api::load_language(dirname(__FILE__));

class serendipity_event_entrypaging extends serendipity_event
{
    private $smartylinks = array();

    function introspect(&$propbag)
    {
        global $serendipity;

        $propbag->add('name',          PLUGIN_ENTRYPAGING_NAME);
        $propbag->add('description',   PLUGIN_ENTRYPAGING_BLAHBLAH);
        $propbag->add('stackable',     false);
        $propbag->add('author',        'Garvin Hicking, Wesley Hwang-Chung, Ian Styx');
        $propbag->add('version',       '1.77');
        $propbag->add('requirements',  array(
            'serendipity' => '2.0',
            'smarty'      => '3.1.0',
            'php'         => '7.0.0'
        ));
        $propbag->add('groups', array('FRONTEND_ENTRY_RELATED'));
        $propbag->add('event_hooks',   array('entry_display' => true, 'css' => true, 'entries_header' => true, 'entries_footer' => true));
        $propbag->add('configuration', array('placement', 'showrandom', 'next', 'prev', 'use_category'));
    }

    function introspect_config_item($name, &$propbag)
    {
        switch($name) {
            case 'placement':
                $select = array('top'    => PLUGIN_ENTRYPAGING_TOP,
                                'bottom' => PLUGIN_ENTRYPAGING_BOTTOM,
                                'smarty' => 'Smarty {$pagination_(next|prev|random)_(title|link)}');
                $propbag->add('type',        'select');
                $propbag->add('select_values', $select);
                $propbag->add('name',        PLUGIN_ENTRYPAGING_PLACE);
                $propbag->add('description', '');
                $propbag->add('default',     'top');
                break;

            case 'showrandom':
                $propbag->add('type',        'boolean');
                $propbag->add('name',        PLUGIN_ENTRYPAGING_RANDOM);
                $propbag->add('description', PLUGIN_ENTRYPAGING_RANDOM_BLAHBLAH);
                $propbag->add('default',     'false');
                break;

            case 'use_category':
                $propbag->add('type',        'boolean');
                $propbag->add('name',        PLUGIN_ENTRYPAGING_USECATEGORY);
                $propbag->add('description', PLUGIN_ENTRYPAGING_USECATEGORY_BLAHBLAH);
                $propbag->add('default',     'false');
                break;

            case 'next':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_ENTRYPAGING_RANDOM_TEXT_NEXT);
                $propbag->add('description', PLUGIN_ENTRYPAGING_RANDOM_TEXT_NEXT_DESC);
                $propbag->add('default',     '');
                break;

            case 'prev':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_ENTRYPAGING_RANDOM_TEXT_PREV);
                $propbag->add('description', PLUGIN_ENTRYPAGING_RANDOM_TEXT_NEXT_DESC);
                $propbag->add('default',     '');
                break;

            default:
                return false;
        }
        return true;
    }

    function generate_content(&$title)
    {
        $title = PLUGIN_ENTRYPAGING_NAME;
    }

    function example()
    {
        global $serendipity;
        $base = $serendipity['baseURL'].'plugins/serendipity_event_entrypaging';
        return '<p class="msg_notice"><span class="icon icon-info-circled"></span> Please also read the entrypages <a href="' . $base . '/README_FOR_SMARTY_TEMPLATING.txt" target="_blank" rel="noopener">README_FOR_SMARTY_TEMPLATING</a> file for custom Smarty entrypaging!</p>';
    }

    function makeLink($resultset, $type = 'next')
    {
        if (is_array($resultset) && is_numeric($resultset[0]['id'])) {
            // multilingual title support
            global $serendipity;
            
            if (class_exists('serendipity_event_multilingual')) {
                $localtitle = serendipity_db_query("SELECT value FROM {$serendipity['dbPrefix']}entryproperties WHERE entryid = {$resultset[0]['id']} AND property = 'multilingual_title_{$serendipity['lang']}'", true, "both", false, false, false, true);
            }
            if (!isset($localtitle) || !is_array($localtitle)) {
                $localtitle = array(0 => $resultset[0]['title']);
            }

            // what above does, is to retrieve the multilingual title, if available
            $title = serendipity_specialchars($localtitle[0]);
            if ($this->get_config($type) != '') {
                $title = serendipity_specialchars($this->get_config($type));
            }
            if (empty($title)) {
                if ($type == 'next') {
                    $title = NEXT;
                } elseif ($type == 'prev') {
                    $title = PREVIOUS;
                }
            }
            $url = serendipity_archiveURL($resultset[0]['id'], $resultset[0]['title'], 'baseURL', true, array('timestamp' => $resultset[0]['timestamp']));

            $this->smartylinks['pagination_' . $type . '_link']  = $url;
            $this->smartylinks['pagination_' . $type . '_title'] = $title;

            $link = '<a href="' . $url . '">' . $title . '</a>';
            return $link;
        }

        return false;
    }

    function event_hook($event, &$bag, &$eventData, $addData = null)
    {
        global $serendipity;

        $hooks = &$bag->get('event_hooks');

        if (isset($hooks[$event])) {

            switch ($event) {
                case 'css':
                    if (stristr($eventData, '.serendipity_entrypaging') || false !== strpos($eventData, 'serendipity_smarty_entrypaging')) {
                        // class exists in CSS, so a user has customized it and we don't need default
                        return true;
                    }
                    // append css
                    $eventData .= '

/* serendipity_event entrypaging start */

.serendipity_entrypaging {
    text-align: center;
    margin-left: auto;
    margin-right: auto;
    border: 0px;
    display: block;
}

/* serendipity_event entrypaging end */

';
                    break;

                case 'entry_display':
                case 'entries_header':
                case 'entries_footer':
                    if (isset($serendipity['GET']['id']) && is_numeric($serendipity['GET']['id'])) {
                        $placement = $this->get_config('placement', 'top');
                        if (($placement == 'top' || $placement == 'smarty') && $event == 'entries_header') {
                            $disp = '1';
                        }
                        elseif ($placement == 'bottom' && $event == 'entries_footer') {
                            $disp = '2';
                        } else {
                            if ($placement != 'smarty') {
                                return false;
                            }
                        }

                        if ($event == 'entry_display' || (isset($disp) && !isset($serendipity['entrypaging']))) {

                            if (class_exists('serendipity_event_categorytemplates')) {
                                $bycategory = serendipity_db_query("SELECT categoryid, template FROM {$serendipity['dbPrefix']}categorytemplates WHERE hide = 1", false, 'assoc');
                            }

                            // showPaging function integrated here
                            $id     = $serendipity['GET']['id'];
                            $links  = array();
                            $cond   = array();

                            $currentTimeSQL = serendipity_db_query("SELECT e.timestamp, ec.categoryid
                                                                      FROM {$serendipity['dbPrefix']}entries AS e
                                                           LEFT OUTER JOIN {$serendipity['dbPrefix']}entrycat AS ec
                                                                        ON ec.entryid = e.id
                                                                     WHERE e.id = " . (int)$id . "
                                                                  ORDER BY ec.categoryid
                                                                     LIMIT 1", true);
                            if (is_array($currentTimeSQL)) {
                                $cond['compare'] = "e.timestamp [%1] " . $currentTimeSQL['timestamp'];
                            } else {
                                $cond['compare'] = "e.id [%1] " . (int)$id;
                            }

                            $cond['and'] = " AND e.isdraft = 'false' AND e.timestamp <= " . serendipity_serverOffsetHour(time(), true);
                            serendipity_plugin_api::hook_event('frontend_fetchentry', $cond);

                            $cond['joins'] = $cond['joins'] ?? '';
                            $cond['where'] = $cond['where'] ?? '';
                            if (serendipity_db_bool($this->get_config('use_category')) && !empty($currentTimeSQL['categoryid'])) {
                                $cond['joins'] .= " JOIN {$serendipity['dbPrefix']}entrycat AS ec ON (ec.categoryid = " . (int)$currentTimeSQL['categoryid'] . " AND ec.entryid = e.id)";
                            }
                            else if (isset($bycategory[0]['categoryid'])) {
                                $cond['joinct'] = " LEFT JOIN {$serendipity['dbPrefix']}entrycat AS ec ON (ec.entryid IS NULL OR ec.entryid = e.id)";
                                $cond['joins'] .= $cond['joinct'];
                                foreach ($bycategory AS $bcat) {
                                    if ($bcat['template'] == $serendipity['template']) {
                                        $cond['where'] .= "(ec.categoryid = " . (int)$bcat['categoryid'] . ") AND";
                                    } else {
                                        $cond['where'] .= "(ec.categoryid != " . (int)$bcat['categoryid'] . " OR ec.categoryid IS NULL) AND";
                                    }
                                }
                            }

                            $querystring = "SELECT
                                                e.id, e.title, e.timestamp
                                              FROM
                                                {$serendipity['dbPrefix']}entries e
                                                {$cond['joins']}
                                             WHERE
                                                {$cond['where']}
                                                {$cond['compare']}
                                                {$cond['and']}
                                          ORDER BY e.timestamp [%2]
                                             LIMIT 1";

                            // We cannot use sprintf() for parameterizing, because "%" strings can occur in checks for "LIKE '%serendipity...%'" SQL parts!
                            $prevID = $serendipity['entrypaging']['prevID'] = serendipity_db_query(str_replace(array('[%1]', '[%2]'), array('<', 'DESC'), $querystring));
                            $nextID = $serendipity['entrypaging']['nextID'] = serendipity_db_query(str_replace(array('[%1]', '[%2]'), array('>', 'ASC'), $querystring));

                            // display random link if selected
                            $randomlink = '';
                            if (serendipity_db_bool($this->get_config('showrandom', 'false'))) {
                                $cond['compare2'] = " e.id <> " . (int)$id ." AND e.isdraft = 'false' AND e.timestamp <= " . serendipity_serverOffsetHour(time(), true);

                                if (!isset($cond['joinct'])) {
                                    $cond['joinct'] = '';
                                }
                                if ($serendipity['dbType'] ==  'mysql' || $serendipity['dbType'] == 'mysqli') {
                                    $sql_order = "ORDER BY RAND()";
                                } else {
                                    // SQLite and PostgreSQL support this, hooray.
                                    $sql_order = "ORDER BY RANDOM()";
                                }

                                $querystring = "SELECT
                                                    e.id, e.title, e.timestamp
                                                  FROM
                                                    {$serendipity['dbPrefix']}entries e
                                                    {$cond['joinct']}
                                                 WHERE
                                                    {$cond['where']}
                                                    {$cond['compare2']}
                                                    $sql_order
                                                 LIMIT 1";
                                $randID = serendipity_db_query($querystring);

                                if ($link = $this->makeLink($randID, 'random')) {
                                    $randomlink = $serendipity['entrypaging']['randomlink'] = '<span class="serendipity_entrypaging_random">' . PLUGIN_ENTRYPAGING_RANDOM_TEXT . $link . '<br /></span>';
                                }
                            }
                        } else {
                            $prevID = $prevID ?? '';
                            $nextID = $nextID ?? '';
                            unset($serendipity['entrypaging']['prevID']);
                            unset($serendipity['entrypaging']['nextID']);
                            unset($serendipity['entrypaging']['randomlink']);
                        }

                        $links = array();
                        $randomlink = $serendipity['entrypaging']['randomlink'] ?? '';

                        if ($link = $this->makeLink(($serendipity['entrypaging']['prevID'] ?? $prevID), 'prev')) {
                            $links[] = '<span class="serendipity_entrypaging_left"><span class="epicon">&lt;</span> ' . $link . '</span>';
                        }

                        if ($link = $this->makeLink(($serendipity['entrypaging']['nextID'] ?? $nextID), 'next')) {
                            $links[] = '<span class="serendipity_entrypaging_right">' . $link . ' <span class="epicon">&gt;</span></span>';
                        }

                        // choose method of display
                        if ($placement == 'smarty' && is_object($serendipity['smarty'])) {
                            $serendipity['smarty']->assign('smarty_entrypaging', true);
                            $serendipity['smarty']->assign($this->smartylinks);
                        } elseif ($disp == '1' && $event == 'entries_header') {
                            echo '<div class="serendipity_entrypaging">' . $randomlink . implode(' <span class="epicon">|</span> ', $links) . '</div>';
                        } elseif ($disp == '2' && $event == 'entries_footer') {
                            echo '<div class="serendipity_entrypaging">' . $randomlink . implode(' <span class="epicon">|</span> ', $links) . '</div>';
                        } else {
                            return false;
                        }
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