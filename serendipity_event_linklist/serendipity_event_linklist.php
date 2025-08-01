<?php

declare(strict_types=1);

if (IN_serendipity !== true) {
    die ("Don't hack!");
}

@serendipity_plugin_api::load_language(dirname(__FILE__));

@define('CANT_EXECUTE_EXTENSION', 'Cannot execute the %s extension library. Please allow in PHP.ini or load the missing module via servers package manager.');

class serendipity_event_linklist extends serendipity_event
{
    var $title = PLUGIN_LINKLIST_TITLE;

    function introspect(&$propbag)
    {
        global $serendipity;

        $propbag->add('name', PLUGIN_LINKLIST_TITLE);
        $propbag->add('description', PLUGIN_LINKLIST_DESC);
        $propbag->add('event_hooks',  array('backend_sidebar_entries_event_display_linklist'  => true,
                                            'backend_sidebar_admin_appearance'                => true,
                                            'plugins_linklist_input'                          => true,
                                            'css'                                             => true,
                                            'plugins_linklist_conf'                           => true,
                                            'external_plugin'                                 => true
                                            ));
        $propbag->add('author',        'Matthew Groeninger, Omid Mottaghi Rad, Ian Styx');
        $propbag->add('version',       '4.1.0');
        $propbag->add('requirements',  array(
            'serendipity' => '5.0',
            'smarty'      => '4.1',
            'php'         => '8.2'
        ));
        $propbag->add('stackable',     false);
        $propbag->add('groups', array('FRONTEND_VIEWS', 'BACKEND_FEATURES'));
    }

    function generate_content(&$title)
    {
        $title = $this->title;
    }

    function generate_output($ignorecache)
    {
        global $serendipity;

        $cache = $this->get_config('cache');
        if ($cache == 'yes' && $ignorecache == false) {
            if (empty($output = serendipity_getCacheItem('linklist_cache'))) {
                $output = $this->get_config('cached_output');
            }
        }
        if (empty($output)) {
            $display = $this->get_config('display');
            if ($display == 'category' || $display == '') {
                if ($this->get_config('category') == 'custom') {
                    $table = $serendipity['dbPrefix'].'link_category';
                } else {
                   $table  = $serendipity['dbPrefix'].'category';
                }
                $output = $this->category_output($table, 0, 0);
            } else {
                $q   = $this->set_query($display);
                $sql = serendipity_db_query($q);
                if ($sql && is_array($sql)) {
                    foreach($sql AS $key => $row) {
                        $name = $row['name'];
                        $link = $row['link'];
                        $id   = $row['id'];
                        $descrip = $row['descrip'];
                        $output .= '<link name="'.htmlspecialchars($name).'" link="http://'.$link.'" descrip="'.htmlspecialchars($descrip).'" />'."\n";
                    }
                }
            }
            if ($cache == 'yes') {
                if (false === serendipity_cacheItem('linklist_cache', $output, 43200)) {
                    $output = $this->set_config('cached_output',$output);
                }
            }
        }
        return $output;
    }

    function category_output($table, $catid, $level)
    {
        global $serendipity;

        $cat_open = false;
        $output = '';
        $indent = '';
        $indent_link = '';
        $indent_int = ($level-1)*5;
        for ($counter = 0; $counter < $indent_int; $counter++) {
            $indent = $indent.' ';
        }
        $indent_int = ($level)*5;
        for ($counter = 0; $counter < $indent_int; $counter++) {
            $indent_link = $indent_link.' ';
        }

        $open_category = $indent.'<dir name="_catname_">'."\n";
        $close_category = $indent.'</dir>'."\n";
        $link_style = $indent_link.'<link name="_name_" link="http://_link_" descrip="_descrip_" />'."\n";

        if ($level == 0) {
            $catid = $level;
        } else {
            $q = 'SELECT s.* FROM '.$table.' AS s WHERE categoryid='.(int)$catid.' ORDER BY s.category_name ASC';
            $sql = serendipity_db_query($q);
            if ($sql && is_array($sql)) {
                $replace_name = "_catname_";
                $cat_name = $sql[0]['category_name'];

                $cat_open = true;
                $open_category = str_replace($replace_name, htmlspecialchars($cat_name), $open_category);
                $output .= $open_category;
            }
        }

        $q = 'SELECT s.* FROM '.$table.' AS s WHERE parentid='.(int)$catid.' ORDER BY s.category_name ASC';
        $sql = serendipity_db_query($q);
        if ($sql && is_array($sql)) {
            foreach($sql AS $key => $row) {
                 $output .= $this->category_output($table, $row['categoryid'], $level+1);
            }
        }
        $q = 'SELECT     s.link              AS link,
                         s.title             AS name,
                         s.descrip           AS descrip,
                         s.category          AS cat_id,
                         s.id                AS id
                         FROM    '.$serendipity['dbPrefix'].'links AS s
                         WHERE    s.category='.(int)$catid.' ORDER BY s.title ASC';
        $sql = serendipity_db_query($q);
        if ($sql && is_array($sql)) {
            foreach($sql AS $key => $row) {
                $link_out = $link_style;
                $name = $row['name'];
                $link = $row['link'];
                $id = $row['id'];
                $descrip = $row['descrip'];


                $replace_linkname = "_name_";
                $replace_link = "_link_";
                $replace_descrip = "_descrip_";

                $link_out = str_replace($replace_linkname, htmlspecialchars($name), $link_out);
                $link_out = str_replace($replace_link,$link,$link_out);
                $link_out = str_replace($replace_descrip, htmlspecialchars($descrip), $link_out);
                $output .=  $link_out;
            }
        }
        if ($cat_open == true) {
            $output .= $close_category;
        }
        return $output;
    }

    function cleanup()
    {
        global $serendipity;

        if ($this->get_config('cache') == 'yes') {
            $output = $this->generate_output();
            if (false === serendipity_cacheItem('linklist_cache', $output, 43200)) {
                $this->set_config('cached_output',$output);
            }
        }
        return true;
    }

    function install()
    {
        global $serendipity;
        // Create table
        $q   = "CREATE TABLE {$serendipity['dbPrefix']}links (
                    id {AUTOINCREMENT} {PRIMARY},
                    date_added int(10) {UNSIGNED} NULL,
                    link varchar(250) default NULL,
                    title varchar(250) default NULL,
                    descrip text,
                    order_num int(4),
                    category int(11),
                    last_result int(4),
                    last_result_time int(10) {UNSIGNED} NULL,
                    num_bad_results int(11)
                )";

        $sql = serendipity_db_schema_import($q);

        $q   = "CREATE INDEX dateind ON {$serendipity['dbPrefix']}links (date_added);";
        $sql = serendipity_db_schema_import($q);

        if ($serendipity['dbType'] == 'mysqli') {
            $serendipity['db_server_info'] = $serendipity['db_server_info'] ?? mysqli_get_server_info($serendipity['dbConn']); // eg.  == 5.5.5-10.4.11-MariaDB
            // be a little paranoid...
            if (substr($serendipity['db_server_info'], 0, 6) === '5.5.5-') {
                // strip any possible added prefix having this 5.5.5 version string (which was never released). PHP up from 8.0.16 now strips it correctly.
                $serendipity['db_server_info'] = str_replace('5.5.5-', '', $serendipity['db_server_info']);
            }
            $db_version_match = explode('-', $serendipity['db_server_info']);
            if (stristr(strtolower($serendipity['db_server_info']), 'mariadb')) {
                if (version_compare($db_version_match[0], '10.5.0', '>=')) {
                    $q = "CREATE INDEX titleind ON {$serendipity['dbPrefix']}links (title);";
                } elseif (version_compare($db_version_match[0], '10.3.0', '>=')) {
                    $q = "CREATE INDEX titleind ON {$serendipity['dbPrefix']}links (title(250));"; // max key 1000 bytes
                } else {
                    $q = "CREATE INDEX titleind ON {$serendipity['dbPrefix']}links (title(191));"; // 191 - old MyISAMs
                }
            } else {
                // Oracle MySQL - https://dev.mysql.com/doc/refman/5.7/en/innodb-limits.html
                if (version_compare($db_version_match[0], '5.7.7', '>=')) {
                    $q = "CREATE INDEX titleind ON {$serendipity['dbPrefix']}links (title);"; // Oracle Mysql/InnoDB max key up to 3072 bytes
                } else {
                    $q = "CREATE INDEX titleind ON {$serendipity['dbPrefix']}links (title(191));"; // Oracle Mysql/InnoDB max key 767 bytes
                }
            }
        } else {
            $q = "CREATE INDEX titleind ON {$serendipity['dbPrefix']}links (title);";
        }
        $sql = serendipity_db_schema_import($q);

        $q   = "CREATE INDEX catind ON {$serendipity['dbPrefix']}links (category);";
        $sql = serendipity_db_schema_import($q);

        $q   = "CREATE TABLE {$serendipity['dbPrefix']}link_category (
                    categoryid {AUTOINCREMENT} {PRIMARY},
                    category_name varchar(255) default NULL,
                    parentid int(11) default 0
                )";
        $sql = serendipity_db_schema_import($q);

        $this->set_config('active', 'false');
        $this->set_config('style', 'no');
        $this->set_config('display', 'category');
        $this->set_config('category', 'custom');
        $this->set_config('cache', 'false');
        $this->set_config('category','custom');
    }

    function uninstall(&$propbag)
    {
        global $serendipity;
        // Drop table
        $q   = "DROP TABLE {$serendipity['dbPrefix']}links";
        $sql = serendipity_db_schema_import($q);
        $q   = "DROP TABLE {$serendipity['dbPrefix']}link_category";
        $sql = serendipity_db_schema_import($q);
    }

    function decode($string)
    {
        if (LANG_CHARSET != 'UTF-8') {
            return utf8_decode($string);
        }

        return $string;
    }

    function event_hook($event, &$bag, &$eventData, $addData = null)
    {
        global $serendipity;

        $hooks = &$bag->get('event_hooks');

        if (isset($hooks[$event])) {

            switch($event) {

                case 'backend_sidebar_entries_event_display_linklist':
                    if (!serendipity_db_bool($this->get_config('active'))) {
                        return false;
                    }
                    if (isset($_POST['REMOVE'])) {
                        if (isset($_POST['serendipity']['link_to_remove'])) {
                            foreach($_POST['serendipity']['link_to_remove'] AS $key) {
                                $this->del_link($key);
                            }
                        } else {
                            if (isset($_POST['serendipity']['category_to_remove'])) {
                                foreach($_POST['serendipity']['category_to_remove'] AS $key) {
                                    $this->del_category($key);
                                }
                            }
                        }
                    }

                    if (isset($_POST['SAVE'])) {
                        foreach($_POST['serendipity']['link_to_recat'] AS $key => $row) {
                            $this->update_cat($key,$row);
                        }
                    }

                    if (isset($_POST['ADD'])) {
                       if (isset($_POST['serendipity']['add_link']['title']) && isset($_POST['serendipity']['add_link']['link'])) {
                            $this->add_link($_POST['serendipity']['add_link']['link'], $_POST['serendipity']['add_link']['title'], $_POST['serendipity']['add_link']['desc'], $_POST['serendipity']['link_to_recat']['cat']);
                       } else {
                           if (isset($_POST['serendipity']['add_category']['title'])) {
                               $this->add_cat($_POST['serendipity']['add_category']['title'],$_POST['serendipity']['link_to_recat']['cat']);
                           }
                       }
                    }

                    if (isset($_POST['EDIT'])) {
                       if (isset($_POST['serendipity']['add_link']['title']) && isset($_POST['serendipity']['add_link']['link'])&& isset($_POST['serendipity']['add_link']['id'])) {
                            $this->update_link($_POST['serendipity']['add_link']['id'], $_POST['serendipity']['add_link']['link'], $_POST['serendipity']['add_link']['title'], $_POST['serendipity']['add_link']['desc'], $_POST['serendipity']['link_to_recat']['cat']);
                       }
                    }
                    if (isset($_GET['submit'])) {
                        switch ($_GET['submit']) {
                            case 'move up':
                                $this->move_up($_GET['serendipity']['link_to_move']);
                            break;

                            case 'move down':
                                $this->move_down($_GET['serendipity']['link_to_move']);
                            break;
                        }
                    }

                    if ($this->get_config('cache') == 'yes') {
                        $output = $this->generate_output(true);
                        if (false === serendipity_cacheItem('linklist_cache', $output, 43200)) {
                            $this->set_config('cached_output', $output);
                        }
                    }
                    if (isset($_GET['serendipity']['edit_link'])) {
                        $this->output_add_edit_linkadmin(TRUE, $_GET['serendipity']['edit_link']);
                    } else {
                        if (isset($_GET['serendipity']['manage_category'])) {
                            $this->output_categoryadmin();
                        } else {
                            $this->output_add_edit_linkadmin(FALSE);
                            $this->output_linkadmin();
                        }
                    }
                    break;

                case 'backend_sidebar_admin_appearance':
                    if (serendipity_db_bool($this->get_config('active', 'false'))) {
                        echo "\n".'                        <li class="list-flex"><div class="flex-column-1"><a href="?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=linklist">' . PLUGIN_LINKLIST_ADMINLINK . '</a></div></li>'."\n";
                    }
                    break;

                case 'css':
                    if ($this->get_config('style') == 'dtree') {
                        $searchstr = '.dtree';
                        $filename = 'serendipity_event_dtree.css';
                    } else {
                        $searchstr = '.linklist';
                        $filename = 'serendipity_event_linklist.css';
                    }
                    // CSS class does NOT exist by user customized template styles, include default
                    // OR added by another Plugin
                    if (strpos($eventData, $searchstr) === false) {

                        $tfile = serendipity_getTemplateFile($filename, 'serendipityPath');
                        if (!$tfile || $tfile == $filename) {
                            $tfile = dirname(__FILE__) . '/' . $filename;
                        }
                        $eventData .= file_get_contents($tfile);
                    }
                    break;

                case 'external_plugin':
                    $uri_parts = explode('?', str_replace('&amp;', '&', $eventData));
                    $parts     = explode('&', $uri_parts[0]);
                    $uri_part = $parts[0];
                    switch($uri_part) {
                        case 'lldtree.js': // name unique!
                            header('Content-Type: text/javascript');
                            echo file_get_contents(dirname(__FILE__).'/dtree.js');
                            break;
                        case 'linklist.js':
                            header('Content-Type: text/javascript');
                            echo file_get_contents(dirname(__FILE__).'/linklist.js');
                            break;
                    }
                    break;

                case 'plugins_linklist_input':
                    $eventData['links'] = $this->generate_output(false);
                    break;

                case 'plugins_linklist_conf':
                    $this->set_config('style', $eventData['style']);
                    $this->set_config('display', $eventData['display']);
                    $this->set_config('category', $eventData['category']);
                    $this->set_config('cache', $eventData['cache']);

                    $eventData['changed'] = 'false';
                    if ($eventData['enabled'] == 'true') {
                        if (!serendipity_db_bool($this->get_config('active'))) {
                            $eventData['changed'] = 'true';
                            $this->set_config('active', 'true');
                            $this->set_config('category', 'custom');
                            $q   = 'SELECT count(id) FROM '.$serendipity['dbPrefix'].'links';
                            $sql = serendipity_db_query($q);
                            if ($sql[0][0] == 0) {
                                // Check for xml_parser_create()
                                if (!function_exists('xml_parser_create')) {
                                    echo '<span class="msg_error"><span class="icon-attention-circled"></span> ' . sprintf(CANT_EXECUTE_EXTENSION, 'php-xml (PHP)') . "</span>\n";
                                }
                                $xml = xml_parser_create('UTF-8');
                                xml_parse_into_struct($xml, '<list>'.serendipity_utf8_encode($eventData['links']).'</list>', $struct, $index);
                                xml_parser_free($xml);
                                $depth = -1;
                                for($level[]=0, $i=1, $j=1; isset($struct[$i]); $i++, $j++) {
                                    if (isset($struct[$i]['type'])) {
                                        if ($struct[$i]['type'] == 'open' && strtolower($struct[$i]['tag']) == 'dir') {
                                            if (!isset($in_cat[0])) {
                                                $in_cat[0] = null;
                                            }
                                            $this->add_cat($this->decode($struct[$i]['attributes']['NAME']), $in_cat[0]);
                                            $q   = 'SELECT categoryid FROM '.$serendipity['dbPrefix'].'link_category WHERE category_name = "'.serendipity_db_escape_string($this->decode($struct[$i]['attributes']['NAME'])).'"';
                                            $sql = serendipity_db_query($q);
                                            $in_cat[] = $sql[0][0];
                                            $depth++;
                                        } else if ($struct[$i]['type'] == 'close' && strtolower($struct[$i]['tag']) == 'dir') {
                                            $blah = array_pop($in_cat);
                                            $depth--;
                                        } else if ($struct[$i]['type'] == 'complete' && strtolower($struct[$i]['tag']) == 'link') {
                                            if (!isset($struct[$i]['attributes']['DESCRIP'])) {
                                                $struct[$i]['attributes']['DESCRIP'] = null;
                                            }
                                            $this->add_link($this->decode($struct[$i]['attributes']['LINK']), $this->decode($struct[$i]['attributes']['NAME']), $this->decode($struct[$i]['attributes']['DESCRIP']), $in_cat[$depth]);
                                        }
                                    }
                                }
                            }
                            if ($eventData['cache'] == 'yes') {
                                $output = $this->generate_output(true);
                                $eventData['links'] = $output;
                                if (false === serendipity_cacheItem('linklist_cache', $output, 43200)) {
                                    $this->set_config('cached_output',$output);
                                }
                            }
                        }
                    } else {
                        if (serendipity_db_bool($this->get_config('active'))) {
                            $this->set_config('active', 'false');
                            $this->set_config('cache', 'no');
                            $this->set_config('display', 'category');
                            $eventData['links'] = $this->generate_output(true);
                            if (false === serendipity_removeCacheItem('linklist_cache')) {
                                $this->set_config('cached_output','');
                            }
                            $eventData['changed'] = 'true';
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

    function add_link($link, $name, $desc, $catid = 0)
    {
        global $serendipity;

        $link = $this->clean_link($link);

        $q   = 'SELECT count(id) FROM '.$serendipity['dbPrefix'].'links';
        $sql = serendipity_db_query($q);

        $values['date_added'] = time();
        $values['link'] = $link;
        $values['title'] = $name;
        $values['descrip'] = $desc;
        $values['order_num'] = count($sql);
        $values['category'] = $catid;
        $values['order_num'] = $sql[0][0];
        serendipity_db_insert('links', $values);
    }

    function update_link($id, $link, $title, $desc, $catid)
    {
        global $serendipity;

        $link = $this->clean_link($link);

        $values['link'] = $link;
        $values['title'] = $title;
        $values['descrip'] = $desc;
        $values['category'] = $catid;
        $key['id'] = $id;
        serendipity_db_update('links', $key, $values);
    }

    function del_link($id)
    {
        global $serendipity;

        $q   = 'SELECT order_num FROM '.$serendipity['dbPrefix'].'links WHERE id='.(int)$id;
        $sql = serendipity_db_query($q);

        if ($sql && is_array($sql)) {
            $res = $sql[0];
            $order_num = $res['order_num'];
            $q   = 'DELETE FROM '.$serendipity['dbPrefix'].'links WHERE id='.(int)$id;
            $sql = serendipity_db_query($q);

            $q   = 'UPDATE '.$serendipity['dbPrefix'].'links SET order_num=order_num-1 WHERE order_num > '.(int)$order_num;
            $sql = serendipity_db_query($q);
        }
    }

    function add_cat($name,$parent)
    {
        global $serendipity;

        $values['category_name'] = $name;
        $values['parentid'] = (empty($parent) ? 0 : $parent);
        serendipity_db_insert('link_category', $values);
    }

    function del_category($id)
    {
        global $serendipity;

        $q   = 'DELETE FROM '.$serendipity['dbPrefix'].'link_category WHERE categoryid='.(int)$id;
        $sql = serendipity_db_query($q);

        $values['category'] = 0;
        $key['category'] = $id;
        serendipity_db_update('links', $key, $values);
    }

    function update_cat($id,$cat)
    {
        global $serendipity;

        $q   = 'UPDATE '.$serendipity['dbPrefix'].'links SET category = '.serendipity_db_escape_string($cat).' WHERE id = '.(int)$id;
        $sql = serendipity_db_query($q);
    }

    function move_up($id)
    {
        global $serendipity;

        $q   = 'SELECT order_num FROM '.$serendipity['dbPrefix'].'links WHERE id='.(int)$id;
        $sql = serendipity_db_query($q);

        if ($sql && is_array($sql)) {
            $res = $sql[0];
            $order_num = $res['order_num']-1;
            if ($order_num >= 0)
            {
                $q   = 'UPDATE '.$serendipity['dbPrefix'].'links SET order_num=order_num-1 WHERE id = '.(int)$id;
                $sql = serendipity_db_query($q);

                $q   = 'UPDATE '.$serendipity['dbPrefix'].'links SET order_num=order_num+1 WHERE order_num = '.(int)$order_num.' AND id !='.$id;
                $sql = serendipity_db_query($q);
            }
        }
    }

    function move_down($id)
    {
        global $serendipity;

        $q   = 'SELECT count(id) AS countit FROM '.$serendipity['dbPrefix'].'links';
        $sql = serendipity_db_query($q);
        if ($sql && is_array($sql)) {
            $res = $sql[0];
            $count = $res['countit'];
        } else {
            $count = 0;
        }

        $q   = 'SELECT order_num FROM '.$serendipity['dbPrefix'].'links WHERE id='.(int)$id;
        $sql = serendipity_db_query($q);

        if ($sql && is_array($sql)) {
            $res = $sql[0];
            $order_num = $res['order_num']+1;
            if ($order_num <= $count)
            {
                $q   = 'UPDATE '.$serendipity['dbPrefix'].'links SET order_num=order_num+1 WHERE id = '.(int)$id;
                $sql = serendipity_db_query($q);

                $q   = 'UPDATE '.$serendipity['dbPrefix'].'links SET order_num=order_num-1 WHERE order_num = '.(int)$order_num.' AND id !='.$id;
                $sql = serendipity_db_query($q);
            }
        }
    }

    function output_linkadmin()
    {
        global $serendipity;

        $display = $this->get_config('display');
        $q = $this->set_query($display);
        $categories = $this->build_categories();

        echo '<h3>'.PLUGIN_LINKLIST_ADMINLINK.'</h3>'."\n\n";
?>
        <form action="?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=linklist" method="post">
        <table border="0" cellpadding="5" cellspacing="0" width="100%">
            <tr>
                <td>&nbsp;</td>
                <td><strong><?php echo PLUGIN_LINKLIST_LINK_NAME; ?></strong></td>
                <td><strong><?php echo PLUGIN_LINKLIST_LINK; ?></strong></td>
                <td><strong><?php echo CATEGORY; ?></strong></td>
                <?php echo isset($tdoutput) ? $tdoutput : ''; ?>
            </tr>
<?php


        $sql = serendipity_db_query($q);
        if ($sql && is_array($sql)) {
            $sort_idx = 0;
            foreach($sql AS $key => $row) {
                $name = $row['name'];
                $link = $row['link'];
                $current_category = $row['cat_id'];
                $id = $row['id'];
                if ($display == 'order_num') {
                    if ($sort_idx == 0) {
                        $moveup   = '<td style="border-bottom: 1px solid #000000">&nbsp;</td>';
                    } else {
                        $moveup   = '<td style="border-bottom: 1px solid #000000"><a href="?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=linklist&amp;submit=move+up&amp;serendipity[link_to_move]=' . $id . '" style="border: 0"><img src="' . serendipity_getTemplateFile('admin/img/uparrow.png') .'" border="0" alt="' . UP . '" /></a></td>';
                    }
                    if ($sort_idx == (count($sql)-1)) {
                        $movedown = '<td style="border-bottom: 1px solid #000000">&nbsp;</td>';
                    } else {
                        $movedown = '<td style="border-bottom: 1px solid #000000">'.($moveup != '' ? '&nbsp;' : '') . '<a href="?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=linklist&amp;submit=move+down&serendipity[link_to_move]=' . $id . '" style="border: 0"><img src="' . serendipity_getTemplateFile('admin/img/downarrow.png') . '" alt="'. DOWN .'" border="0" /></a></td>';
                    }
                }
?>
                <tr>
                    <td style="border-bottom: 1px solid #000000" align="right">
                        <div>
                           <input class="input_checkbox" type="checkbox" name="serendipity[link_to_remove][]" value="<?php echo $id; ?>" />
                         </div>
                    </td>
                    <td style="border-bottom: 1px solid #000000"><strong><a href="?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=linklist&amp;serendipity[edit_link]=<?php echo $id; ?>"><?php echo $name; ?></a></strong></td>
                    <td style="border-bottom: 1px solid #000000" nowrap="nowrap">
                        <div><?php echo $link?></div>
                    </td>
                    <td style="border-bottom: 1px solid #000000">
                    <?php echo $this->category_box($id, $categories, $current_category); ?>

                    </td>
                    <?php echo isset($moveup) ? $moveup : '<td style="border-bottom: 1px solid #000000">&nbsp;</td>';?>
                    <?php echo isset($movedown) ? $movedown : '<td style="border-bottom: 1px solid #000000">&nbsp;</td>';?>
                </tr>
<?php
                $sort_idx++;
            }
            echo '
            </table>
        <div>
            <input type="submit" name="REMOVE" title="'.DELETE.'"  value="'.DELETE.'" class="input_button state_cancel">
            <span>&nbsp;</span>
            <input type="submit" name="SAVE" title="'.SAVE.'"  value="'.SAVE.'" class="input_button">
        </div>
    </form>';
        }
    }

    function category_box($id, $categories, $current_category = 0)
    {
        $x = "\n<select name=\"serendipity[link_to_recat][".$id."]\">\n";
        foreach($categories AS $k => $v) {
            $x .= "    <option value=\"$k\"" . ($k == $current_category ? ' selected="selected"' : '') . ">$v</option>\n";
        }
        return $x . "</select>\n";
    }

    function output_add_edit_linkadmin($edit = FALSE, $id = -1)
    {
        global $serendipity;

        $display = $this->get_config('display');
        $categories = $this->build_categories();
        if ($edit) {
            $maintitle = PLUGIN_LINKLIST_EDITLINK;
            $q = 'SELECT link,title,category,descrip FROM '.$serendipity['dbPrefix'].'links WHERE id = '.(int)$id;
            $sql = serendipity_db_query($q);
            if ($sql && is_array($sql)) {
                $res = $sql[0];
                $link = $res['link'];
                $title = $res['title'];
                $cat = $res['category'];
                $desc = $res['descrip'];
            }
            $button = '<input type="submit" name="EDIT" title="EDIT" value="EDIT" class="input_button">';
        } else {
            $link = $title = $desc = '';
            $cat = array();
            $maintitle = PLUGIN_LINKLIST_ADDLINK;
            $button = '<input type="submit" name="ADD" title="ADD" value="ADD" class="input_button">';
        }

        $catlink = $this->get_config('category') == 'custom' ? '(<a href="?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=linklist&amp;serendipity[manage_category]=1">'.PLUGIN_LINKLIST_ADD_CAT.'</a>)' : '';
        echo '<h3>'.$maintitle.'</h3>';
?>
        <form action="?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=linklist" method="post">
            <input type="hidden" name="serendipity[add_link][id]" value="<?php echo $id; ?>">
            <table border="0" cellpadding="5" cellspacing="0" width="100%">
                <tr><td><?php echo PLUGIN_LINKLIST_LINK.'<div style="font-size: smaller;">'.PLUGIN_LINKLIST_LINK_EXAMPLE.'</div>'; ?></td><td><input class="input_textbox" type="text" name="serendipity[add_link][link]" value="<?php echo $link; ?>" size="30"></td></tr>
                <tr><td><?php echo PLUGIN_LINKLIST_LINK_NAME; ?></td><td><input class="input_textbox" type="text" name="serendipity[add_link][title]" value="<?php echo $title; ?>" size="30"></td></tr>
                <tr><td><?php echo CATEGORY; ?> <?php echo $catlink;?></td><td><?php echo $this->category_box('cat', $categories, $cat); ?></td></tr>
                <tr><td valign="top"><?php echo PLUGIN_LINKLIST_LINKDESC; ?></td><td><textarea style="width: 100%" name="serendipity[add_link][desc]" id="serendipity[add_link][desc]" cols="80" rows="3"><?php echo $desc; ?></textarea></td></tr>

<?php
        echo '
            </table>
            <div>
                ' . $button . '
            </div>
        </form>';
    }

    function output_categoryadmin()
    {
        global $serendipity;

        $display = $this->get_config('display');
        $categories = $this->build_categories();
        $maintitle = PLUGIN_LINKLIST_MAINTAIN_CAT;
        $button = '<input type="submit" name="ADD" title="' . PLUGIN_LINKLIST_ADD_CAT . '"  value="' . PLUGIN_LINKLIST_ADD_CAT . '" class="input_button" />';

        echo '<h3>'.$maintitle.'</h3>';
?>
        <form action="?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=linklist&amp;serendipity[manage_category]=1" method="post">
            <input type="hidden" name="serendipity[add_link][id]" value="<?php echo ($id ?? ''); ?>">
            <table border="0" cellpadding="5" cellspacing="0" width="100%">
                <tr>
                    <td><?php echo PLUGIN_LINKLIST_CAT_NAME; ?></td>
                    <td><input class="input_textbox" type="text" name="serendipity[add_category][title]" size="30"></td>
                </tr>
                <tr>
                    <td><?php echo PLUGIN_LINKLIST_PARENT_CATEGORY; ?></td>
                    <td><?php echo $this->category_box('cat', $categories, ($cat ?? null)); ?></td>
                </tr>
<?php
        echo '
            </table>
            <div>
                ' . $button . '
            </div>
        </form>

        <h3>' . PLUGIN_LINKLIST_ADMINCAT . '</h3>
        <a href="?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=linklist">' . PLUGIN_LINKLIST_ADMINLINK . '</a>';

?>
        <form action="?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=linklist&amp;serendipity[manage_category]=1" method="post">
        <table border="0" cellpadding="1" cellspacing="0" width="100%">
            <tr>
                <td></td>
                <td><strong><?php echo CATEGORY; ?></strong></td>
            </tr>
<?php
        $q = 'SELECT s.* FROM '.$serendipity['dbPrefix'].'link_category AS s ORDER BY s.category_name DESC';

        $categories = serendipity_db_query($q);
        $categories = @serendipity_walkRecursive($categories, 'categoryid', 'parentid', VIEWMODE_THREADED);

        foreach($categories AS $category) {
?>
            <tr>
                <td width="16">
                    <input class="input_checkbox" type="checkbox" name="serendipity[category_to_remove][]" value="<?php echo $category['categoryid']; ?>">
                </td>
                <td width="300" style="padding-left: <?php echo ($category['depth']*15)+20 ?>px">
                    <img src="<?php echo serendipity_getTemplateFile('admin/img/folder.png') ?>" style="vertical-align: bottom;"> <?php echo htmlspecialchars($category['category_name']) ?>
                </td>
            </tr>
<?php
        }
        echo '
            </table>
        <div>
            <input type="submit" name="REMOVE" title="' . CATEGORIES . ' ' . DELETE . '"  value="' . DELETE . '" class="input_button state_cancel">
        </div>
        <div style="font-size: smaller;">' . PLUGIN_LINKLIST_DELETE_WARN . '</div>
    </form>';

    }

    function set_query($display)
    {
        global $serendipity;

        $q = 'SELECT s.link     AS link,
                    s.title    AS name,
                    s.descrip  AS descrip,
                    s.category AS cat_id,
                    s.id       AS id
               FROM '.$serendipity['dbPrefix'].'links AS s ';

        switch($display) {
            case 'category':
                   $q .= 'ORDER BY s.category';
                break;
            case 'order_num':
                   $q .= 'ORDER BY s.order_num ASC';
                break;

            case 'dateacs':
                   $q .= 'ORDER BY date_added ASC';
                break;

            case 'datedesc':
                   $q .= 'ORDER BY date_added DESC';
                break;
            default:
                   $q .= 'ORDER BY s.title ASC';
                break;
        }
        return $q;
    }

    function build_categories()
    {
         global $serendipity;

         if ($this->get_config('category') == 'custom') {
             $table = $serendipity['dbPrefix'].'link_category';
         } else {
             $table = $serendipity['dbPrefix'].'category';
         }

         $q = 'SELECT s.categoryid AS id,
                      s.category_name AS name
                 FROM '.$table.' AS s
             ORDER BY s.category_name DESC';
         $sql = serendipity_db_query($q);

         $categories['0'] = '';

         if ($sql && is_array($sql)) {
             foreach($sql AS $key => $row) {
                 $categories[$row['id']] = $row['name'];
             }
         }
        return $categories;
    }

    function clean_link($link)
    {
        $ret_url = '';
        $parts_arr = parse_url($link);
        if (isset($parts_arr['pass']) && strcmp($parts_arr['pass'], '') != 0) {
            $ret_url .= $parts_arr['user'];
        }
        if ((isset($parts_arr['user']) && strcmp($parts_arr['user'], '') != 0) || (isset($parts_arr['pass']) && strcmp($parts_arr['pass'], '') != 0)) {
            $ret_url .= '@';
        }
        $ret_url .= isset($parts_arr['host']) ? $parts_arr['host'] : '';
        if (isset($parts_arr['port']) && strcmp($parts_arr['port'], '') != 0) {
            $ret_url .= ':' . $parts_arr['port'];
        }
        $ret_url .= isset($parts_arr['path']) ? $parts_arr['path'] : '';
        if (isset($parts_arr['query']) && strcmp($parts_arr['query'], '') != 0) {
            $ret_url .= '?' . $parts_arr['query'];
        }
        if (isset($parts_arr['fragment']) && strcmp($parts_arr['fragment'], '') != 0) {
            $ret_url .= '#' . $parts_arr['fragment'];
        }
        return $ret_url;
    }

}

/* vim: set sts=4 ts=4 expandtab : */
?>