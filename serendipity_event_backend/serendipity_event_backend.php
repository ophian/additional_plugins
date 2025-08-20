<?php

# (c) 2005 by Alexander 'dma147' Mieland, http://blog.linux-stats.org, <dma147@linux-stats.org>
# Contact me on IRC in #linux-stats, #archlinux, #archlinux.de, #s9y on irc.freenode.net

declare(strict_types=1);

if (IN_serendipity !== true) {
    die ("Don't hack!");
}

@serendipity_plugin_api::load_language(dirname(__FILE__));

class serendipity_event_backend extends serendipity_event
{
    private $debug;

    function introspect(&$propbag)
    {
        global $serendipity;

        $propbag->add('name',          PLUGIN_BACKEND_TITLE);
        $propbag->add('description',   PLUGIN_BACKEND_DESC);
        $propbag->add('version',        '1.0.0');
        $propbag->add('requirements',   array(
            'serendipity' => '5.0',
            'smarty'      => '4.1',
            'php'         => '8.2'
        ));
        $propbag->add('author',       'Alexander Mieland, Ian Styx');
        $propbag->add('stackable',     false);
        $propbag->add('event_hooks',   array(
            'external_plugin'         => true
        ));
        $propbag->add('configuration', array('backendurl'));
        $propbag->add('groups', array('FRONTEND_FULL_MODS'));
        $this->dependencies = array('serendipity_event_entryproperties' => 'keep');
    }

    function introspect_config_item($name, &$propbag)
    {
        global $serendipity;

        switch($name) {
            case 'backendurl' :
                $propbag->add('type', 'string');
                $propbag->add('name', PLUGIN_BACKEND_BACKENDURL);
                $propbag->add('description', PLUGIN_BACKEND_BACKENDURL_BLAHBLAH);
                $propbag->add('default', 'backend');
                break;

            default:
                return false;
        }
        return true;
    }

    function generate_content(&$title)
    {
        $title = PLUGIN_BACKEND_TITLE;
    }

    function event_hook($event, &$bag, &$eventData, $addData = null)
    {
        global $serendipity;

        $hooks = &$bag->get('event_hooks');
        if (isset($hooks[$event])) {
            switch($event) {
                case 'external_plugin':
                    $uri_parts = explode('&', str_replace(array('&amp;', '?'), array('&', '&'), $eventData));

                    // Try to get request parameters from eventData name
                    if (!empty($uri_parts[1])) {
                        $reqs = explode('&', $uri_parts[1]);
                        foreach($reqs AS $id => $req) {
                            $val = explode('=', $req);
                            if (empty($_REQUEST[$val[0]])) {
                                $_REQUEST[$val[0]] = $val[1];
                            }
                        }
                    }

                    $req = trim($uri_parts[0]);

                    switch($req) {
                        case $this->get_config('backendurl'):

                            if (!headers_sent()) {
                                header('HTTP/1.0 200');
                                header('Status: 200 OK');
                            }

                            if (isset($_REQUEST['category']) && !empty($_REQUEST['category'])) {
                                $category = trim(urldecode($_REQUEST['category']));
                            } else {
                                $category = '';
                            }

                            if (!empty($_REQUEST['authorid'])) {
                                $serendipity['GET']['viewAuthor'] = $_REQUEST['authorid'];
                            }

                            if (!empty($_REQUEST['categoryid'])) {
                                $serendipity['GET']['category'] = $_REQUEST['categoryid'];
                            }

                            if (isset($_REQUEST['num']) && !empty($_REQUEST['num'])) {
                                $num = intval(trim(urldecode($_REQUEST['num'])));
                            } else {
                                $num = 10;
                            }

                            $order = (strtolower(trim(urldecode($_REQUEST['order']))) == 'asc' ||
                                          strtolower(trim(urldecode($_REQUEST['order']))) == 'desc'
                                    ? trim(urldecode($_REQUEST['order']))
                                    : "DESC");

                            $showdate = (intval(trim(urldecode($_REQUEST['date']))) >= 1 ? 1 : 0);

                            $dateformat = (trim(urldecode($_REQUEST['dateformat'])) != ''
                                       ? trim(urldecode($_REQUEST['dateformat']))
                                       : "Y-m-d");

                            $showtime = (intval(trim(urldecode($_REQUEST['time']))) >= 1 ? 1 : 0);

                            $timeformat = (trim(urldecode($_REQUEST['timeformat'])) != ''
                                    ? trim(urldecode($_REQUEST['timeformat']))
                                    : "g:ia");

                            $point = (trim(urldecode($_REQUEST['point'])) != ''
                                    ? trim(urldecode($_REQUEST['point']))
                                    : "");

                            $details = (intval(trim(urldecode($_REQUEST['details']))) >= 1 ? 1 : 0);

                            if ($category == "") {
                                $entries = serendipity_fetchEntries(null, true, $num, false, false, 'timestamp '.$order, '', false, true);
                            } else {
                                $entries = serendipity_fetchEntries(null, true, $num, false, false, 'timestamp '.$order, ' c.category_name = \''.serendipity_db_escape_string($category).'\'', false, true);
                            }

                            if (is_array($entries) && !empty($entries)) {
                                #echo "    document.write('<div id=\"backend_request\" class=\"blog_request_id\" />');\n";
                                for ($a=0, $maxa=count($entries); $a<$maxa; $a++) {
                                    if ($showtime == 1 && $showdate == 1) {
                                        $date = date($dateformat." ".$timeformat, $entries[$a]['timestamp']);
                                    } elseif ($showtime == 1) {
                                        $date = date($timeformat, $entries[$a]['timestamp']);
                                    } elseif ($showdate == 1) {
                                        $date = date($dateformat, $entries[$a]['timestamp']);
                                    } else {
                                        $date = "";
                                    }

                                    $entryurl = serendipity_archiveURL($entries[$a]['id'], $entries[$a]['title']);

                                    if ($details <= 0) {
                                        if ($date != "") {
                                            $date = "[".addslashes(htmlspecialchars($date))."] ";
                                        }
                                        echo "    document.write('<span class=\"blog_point\">".(trim($point) !="" ? addslashes(htmlspecialchars(trim($point))." " : "") . "</span><span class=\"blog_date\">" . $date . "</span><a class=\"blog_link\" href=\"" . $entryurl . "\">" . addslashes($entries[$a]['title']) . "</a><br />');\n";
                                    } else {
                                        echo "    document.write('<span class=\"blog_title\">".addslashes($entries[$a]['title'])."</span>');\n";
                                        echo "    document.write('<hr class=\"blog_hr\" />');\n";

                                        serendipity_plugin_api::hook_event('frontend_display', $entries[$a]);

                                        $entries[$a]['body'] = preg_replace('@(href|src)=("|\')(' . preg_quote($serendipity['serendipityHTTPPath']) . ')(.*)("|\')(.*)>@imsU', '\1=\2' . $serendipity['baseURL'] . '\4\2\6>', $entries[$a]['body']);

                                        $body = str_replace("\n", "", str_replace("\r\n", "", trim($entries[$a]['body'])));

                                        if (substr($body, strlen($body)-5, strlen($body)) == "<br />") {
                                            $body = substr($body, 0, strlen($body)-5);
                                        }

                                        if ($date != "") {
                                            $date = ", " . addslashes(htmlspecialchars($date));
                                        }

                                        $body = str_replace("'", "\'", $body);

                                        echo "    document.write('<span class=\"blog_body\">".$body."</span>');\n";
                                        echo "    document.write('<hr class=\"blog_hr\" />');\n";
                                        echo "    document.write('<span class=\"blog_author\">".addslashes($entries[$a]['author'])."</span><span class=\"blog_date\">".$date."</span> <span class=\"blog_link\">[<a class=\"blog_link\" href=\"".$entryurl."\">&raquo;</a>]</span><br /><br />');\n";
                                    }
                                }
                                #echo "    document.write('</div>');\n";
                            }
                            break;
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