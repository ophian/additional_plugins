<?php

if (IN_serendipity !== true) {
    die ("Don't hack!");
}

@serendipity_plugin_api::load_language(dirname(__FILE__));

class serendipity_plugin_staticpage extends serendipity_plugin
{
    var $staticpage_config = array();

    function introspect(&$propbag)
    {
        $propbag->add('name',        PLUGIN_STATICPAGELIST_NAME);
        $propbag->add('description', PLUGIN_STATICPAGELIST_NAME_DESC);
        $propbag->add('author',      "Rob Antonishen, Falk Doering, Ian Styx");
        $propbag->add('stackable',   true);
        $propbag->add('version',     '1.34');
        $propbag->add('configuration', array(
                'title',
                'limit',
                'parentsonly',
                'frontpage',
                'smartify',
                'showIcons',
                'useIcons',
                'imgdir'
        ));
        $propbag->add('requirements', array(
            'serendipity' => '2.1.0',
            'smarty'      => '3.1.0',
            'php'         => '5.3.0'
        ));
        $propbag->add('groups', array('FRONTEND_VIEWS'));
        $this->dependencies = array(
            'serendipity_event_staticpage' => 'keep',
            'serendipity_plugin_multilingual' => 'keep'
        );
    }

    function introspect_config_item($name, &$propbag)
    {
        global $serendipity;

        switch($name) {
            case 'title':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_STATICPAGELIST_TITLE);
                $propbag->add('description', PLUGIN_STATICPAGELIST_TITLE_DESC);
                $propbag->add('default',     PLUGIN_STATICPAGELIST_TITLE_DEFAULT);
                break;

            case 'limit':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_STATICPAGELIST_LIMIT);
                $propbag->add('description', PLUGIN_STATICPAGELIST_LIMIT_DESC);
                $propbag->add('default',     0);
                break;

            case 'parentsonly':
                $propbag->add('type',        'boolean');
                $propbag->add('name',        PLUGIN_STATICPAGELIST_PARENTSONLY);
                $propbag->add('description', PLUGIN_STATICPAGELIST_PARENTSONLY_DESC);
                $propbag->add('default',     'false');
                break;

            case 'frontpage':
                $propbag->add('type',        'boolean');
                $propbag->add('name',        PLUGIN_STATICPAGELIST_FRONTPAGE_NAME);
                $propbag->add('description', PLUGIN_STATICPAGELIST_FRONTPAGE_DESC);
                $propbag->add('default',     'true');
                break;

            case 'smartify':
                $propbag->add('type',        'boolean');
                $propbag->add('name',        PLUGIN_STATICPAGELIST_SMARTIFY);
                $propbag->add('description', PLUGIN_STATICPAGELIST_SMARTIFY_BLAHBLAH);
                $propbag->add('default',     'false');
                break;

            case 'useIcons':
                $propbag->add('type',        'boolean');
                $propbag->add('name',        PLUGIN_STATICPAGELIST_IMG_NAME);
                $propbag->add('description', '');
                $propbag->add('default',     'true');
                break;

            case 'imgdir':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_LINKS_IMGDIR);
                $propbag->add('description', PLUGIN_LINKS_IMGDIR_BLAHBLAH);
                $propbag->add('default',     $serendipity['baseURL'] . 'plugins/' . basename(dirname(__FILE__)));
                break;

            case 'showIcons':
                $propbag->add('type',        'radio');
                $propbag->add('name',        PLUGIN_STATICPAGELIST_SHOWICONS_NAME);
                $propbag->add('description', PLUGIN_STATICPAGELIST_SHOWICONS_DESC);
                $propbag->add('radio',       array(
                                                'value' => array('true', 'false'),
                                                'desc'  => array(PLUGIN_STATICPAGELIST_ICON, PLUGIN_STATICPAGELIST_TEXT)
                                             ));
                $propbag->add('default',     'false');
                break;

            default:
                return false;
        }
        return true;
    }

    function generate_content(&$title)
    {
        $title = $this->get_config('title');
        // do not load the tpl in backend
        if (!defined('IN_serendipity_admin')) {
            $this->show_content();
        }
    }

    function show_content()
    {
        global $serendipity;
        static $smartify = null;

        if ($smartify === null) {
            $smartify = serendipity_db_bool($this->get_config('smartify', 'false'));
        }        

        $title      = $this->get_config('title');
        $frontpage  = serendipity_db_bool($this->get_config('frontpage', 'true'));
        $parentonly = serendipity_db_bool($this->get_config('parentsonly', 'false'));
        $plugin_dir = basename(dirname(__FILE__));
        $smartcar   = array();
        $str        = "\n";

        if (!serendipity_db_bool($this->get_config('showIcons', 'false'))) {
            if ($frontpage) {
                if ($smartify) {
                    $serendipity['smarty']->assign('frontpage_path', $serendipity['serendipityHTTPPath'] . $serendipity['indexFile']);
                } else {
                    $str .= '<a class="spp_title" title="' . PLUGIN_STATICPAGELIST_FRONTPAGE_LINKNAME . '" href="' . $serendipity['serendipityHTTPPath'] . $serendipity['indexFile'].'">' . PLUGIN_STATICPAGELIST_FRONTPAGE_LINKNAME . '</a>'."\n";
                }
            }
            if ($smartify) {
                $smartcar = $this->displayPageList((int)$this->get_config('limit'), $parentonly, $smartify);
            } else {
                $str .= $this->displayPageList((int)$this->get_config('limit'), $parentonly);
            }
        } else {
            $str .= '<script src="' . $serendipity['serendipityHTTPPath'] . ($serendipity['rewrite'] == 'none' ? $serendipity['indexFile'] . '?/' : '') . 'plugin/spdtree.js" type="text/javascript"></script>'."\n";

            $serendipity['staticpageplugin']['JS_init'] = true; // RQ: probably only available within templates config later on... or so. NO, this happens after event plugin processing, but will later on not be available. Why is that?

            $imgdir = $this->get_config('imgdir');
            if ($imgdir == 'true' || $imgdir == 'yes') {
                $imgdir = $serendipity['baseURL'] . 'plugins/' . $plugin_dir;
            }
            if ($imgdir == 'false' || $imgdir == 'no') {
                $imgdir = $serendipity['baseURL'] . $serendipity['templatePath'] . 'default';
            }
            $fdid = md5(uniqid(mt_rand(), true));//str_replace(':', '_', $this->instance);// randomness does not matter since dynamically

            $str .= '<script type="text/javascript">
            <!--
            fd_' . $fdid . ' = new dTree("fd_' . $fdid . '","' . $imgdir . '");'."\n";

            /* configuration section*/
            if (!serendipity_db_bool($this->get_config('useIcons', 'true')) || $imgdir == '') {
                $str .= "fd_$fdid.config.useIcons  = false;\n";
            }
            $str .= "fd_$fdid.config.useSelection  = false;\n";
            $str .= "fd_$fdid.config.useCookies    = false;\n";
            $str .= "fd_$fdid.config.useLines      = false;\n";
            $str .= "fd_$fdid.config.useStatusText = true;\n";
            $str .= "fd_$fdid.config.closeSameLevel= true;\n";
            $str .= "fd_$fdid.config.target        = '_self'\n";

            if ($frontpage) {
                $str .= 'fd_' . $fdid . '.add(0,-1,"' . PLUGIN_STATICPAGELIST_FRONTPAGE_LINKNAME . '","' . $serendipity['serendipityHTTPPath'] . $serendipity['indexFile'] . '");'."\n";
            } else {
                $str .= 'fd_' . $fdid . '.add(0,-1,"","");'."\n";
            }

            if ($struct = $this->getPageList($parentonly)) {
                $this->addJSTags($struct);
                foreach ($struct AS $value) {
                    $str .= 'fd_' . $fdid . '.add('
                            . $value['id'] . ','
                            . $value['parent_id'] . ','
                            . '"' . serendipity_event_staticpage::fixUTFEntity(serendipity_event_staticpage::html_specialchars((empty($value['headline']) ? $value['pagetitle'] : $value['headline']))) . '",'
                            . '"' . serendipity_event_staticpage::html_specialchars($value['permalink']) . '",'
                            . '"' . serendipity_event_staticpage::html_specialchars($value['pagetitle']) .'",'
                            . '"",'
                            . '"",'
                            . '"",'
                            . '"' . $value['type'] . '");'
                            . "\n";
                }
            }

            $str .= 'document.write(fd_' . $fdid . ');
            //-->
            </script>';
            $str .= "\n";
        }

        if ($smartify) {
            $serendipity['smarty']->assign(array(
                'staticpage_jsStr'       => trim($str),
                'staticpage_listContent' => $smartcar
            ));
            $filename = 'plugin_staticpage_sidebar.tpl';
            $content = $this->parseTemplate($filename);
            echo $content;
        } else {
            echo $str;
        }
    }

    function getPageList($parentsonly = false)
    {
        global $serendipity;

        $PID = $parentsonly ? ' AND parent_id = 0' : '';
        $q = "SELECT id, headline, parent_id, permalink, pagetitle, is_startpage
                FROM {$serendipity['dbPrefix']}staticpages
               WHERE showonnavi = 1
                 AND publishstatus = 1
                 AND language IN ('{$serendipity['lang']}', 'all', '')
                 $PID
            ORDER BY parent_id, pageorder";
        $pagelist = serendipity_db_query($q, false, 'assoc');
        if (is_array($pagelist)) {
            self::iteratePageList($pagelist);
            $pagelist = serendipity_walkRecursive($pagelist, 'id', 'parent_id', VIEWMODE_THREADED);
            return $pagelist;
        }
        return false;
    }

    function addJSTags(&$pagelist)
    {
        global $serendipity;

        $pc_count = count($pagelist);
        for ($i = 0; $i < $pc_count; $i++) {
            $p = array(
                'type' => 'open',
                'tag'  => ($pagelist[$i]['parent_id'] == 0) ? 'link' : 'dir'
            );
            $pagelist[$i] = array_merge($pagelist[$i], $p);
        }
    }

    function iteratePageList(&$pagelist)
    {
        global $serendipity;

        if (is_array($pagelist)) {
            foreach($pagelist AS $idx => $page) {
                if ($page['is_startpage'] > 0) {
                    $pagelist[$idx]['permalink'] = $serendipity['serendipityHTTPPath'] . $serendipity['indexFile'];
                }
            }
        }
        return true;
    }

    function displayPageList($limit, $parentsonly, $tpl=false)
    {
        global $serendipity;

        $PID = $parentsonly ? ' AND parent_id = 0' : '';
        $q = "SELECT id, headline, parent_id, permalink, pagetitle, is_startpage
                FROM {$serendipity['dbPrefix']}staticpages
               WHERE showonnavi = 1
                 AND publishstatus = 1
                 AND language IN ('{$serendipity['lang']}', 'all', '')
                 $PID
            ORDER BY parent_id, pageorder";
        if ($limit) {
            $q .= " LIMIT $limit";
        }
        $pagelist = serendipity_db_query($q, false, 'assoc');
        if (is_array($pagelist)) {
            self::iteratePageList($pagelist);
            $pagelist = serendipity_walkRecursive($pagelist, 'id', 'parent_id', VIEWMODE_THREADED); // childs follow parent
            $content  = $tpl ? array() : (string)'';

            foreach($pagelist AS $page) {
                if (is_array($content)) {
                    /* smartify the staticpage sidebar plugin */
                    $content[] = array(
                        'id'           => $page['id'],
                        'headline'     => serendipity_event_staticpage::fixUTFEntity(!empty($page['headline']) ? serendipity_event_staticpage::html_specialchars($page['headline']) : serendipity_event_staticpage::html_specialchars($page['pagetitle'])),
                        'parent_id'    => $page['parent_id'],
                        'permalink'    => !empty($page['permalink']) ? $page['permalink'] : NULL,
                        'pagetitle'    => !empty($page['permalink']) ? serendipity_event_staticpage::html_specialchars($page['pagetitle']) : NULL,
                        'is_startpage' => $page['is_startpage'],
                        'depth'        => $page['depth']*10
                    );
                } elseif (is_string($content)) {
                    $content .= (!empty($page['permalink'])
                        ? sprintf(
                            "<a href=\"%s\" title=\"%s\" class=\"spp_title\" style=\"padding-left: %dpx;\">%s</a>\n",
                            $page['permalink'],
                            serendipity_event_staticpage::html_specialchars($page['pagetitle']),
                            $page['depth']*10,
                            serendipity_event_staticpage::fixUTFEntity(!empty($page['headline']) ? serendipity_event_staticpage::html_specialchars($page['headline']) : serendipity_event_staticpage::html_specialchars($page['pagetitle'])))
                        : sprintf(
                            "<div style=\"padding-left: %dpx;\">%s</div>",
                            $page['depth']*10,
                            serendipity_event_staticpage::fixUTFEntity(!empty($page['headline']) ? serendipity_event_staticpage::html_specialchars($page['headline']) : serendipity_event_staticpage::html_specialchars($page['pagetitle']))));
                }
            }

            return $content;
        }

        return null;
    }

}

?>