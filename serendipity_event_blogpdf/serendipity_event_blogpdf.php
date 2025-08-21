<?php

declare(strict_types=1);

if (IN_serendipity !== true) {
    die ("Don't hack!");
}

/* TODO:
- Insert nice formatting, maybe user-defined? (Color, Font face)
*/

@serendipity_plugin_api::load_language(dirname(__FILE__));

class serendipity_event_blogpdf extends serendipity_event
{
    public $title = PLUGIN_EVENT_BLOGPDF_NAME;

    private $pdf;
    private $single = false;
    private $article_show = false;

    function introspect(&$propbag)
    {
        $propbag->add('name',          PLUGIN_EVENT_BLOGPDF_NAME);
        $propbag->add('description',   PLUGIN_EVENT_BLOGPDF_DESC);
        $propbag->add('stackable',     false);
        $propbag->add('author',        'Garvin Hicking, Olivier Plathey, Steven Wittens, Ian Styx');
        $propbag->add('license',       'GPL (Uses LGPL TCPDF');
        $propbag->add('version',       '3.0.1');
        $propbag->add('requirements',  array(
            'serendipity' => '5.0',
            'smarty'      => '4.1',
            'php'         => '8.2'
        ));
        $propbag->add('event_hooks',    array(
            'external_plugin'  => true,
            'entries_footer'   => true,
            'frontend_display' => true
        ));
        $propbag->add('groups', array('FRONTEND_FULL_MODS'));
        #$propbag->add('configuration', array('html2pdf', 'updf', 'fallback'));
    }

    function introspect_config_item($name, &$propbag)
    {
        switch($name) {
            case 'html2pdf':
                $propbag->add('type',        'boolean');
                $propbag->add('name',        'HTML2PDF support');
                $propbag->add('description', '');
                $propbag->add('default',     'false');
                break;

            case 'updf':
                $propbag->add('type',        'boolean');
                $propbag->add('name',        'UPDF / Unicode support');
                $propbag->add('description', '');
                $propbag->add('default',     'false');
                break;

			case 'fallback':
                $propbag->add('type',        'boolean');
                $propbag->add('name',        'Fallback to iso8559');
                $propbag->add('description', 'Should be used when your Blog is in UTF-8 and you use a latin charset, but the UFPDF library doesn\'t work');
                $propbag->add('default',     'false');
                break;

            default:
                return false;
        }
        return true;
    }

    function generate_content(&$title)
    {
        $title = $this->title;
    }

    function event_hook($event, &$bag, &$eventData, $addData = null)
    {
        global $serendipity;

        $hooks = &$bag->get('event_hooks');
        $links = array();

        if (isset($hooks[$event])) {

            switch($event) {
                case 'frontend_display':
                    if (isset($eventData['timestamp']) && isset($serendipity['GET']['id']) && is_numeric($serendipity['GET']['id'])) {
                        $this->article_show = true;
                        $year         = date('Y', serendipity_serverOffsetHour($eventData['timestamp']));
                        $month        = date('m', serendipity_serverOffsetHour($eventData['timestamp']));
                        // no break
                    } else {
                        break;
                    }

                case 'entries_footer':
                    // don't do this in mode preview iframe, we use GET, since $serendipity['preview'] isn't available (yet?) and on staticpages or other plugin pages that are not categories!
                    if (empty($serendipity['GET']['preview']) && isset($serendipity['view']) && in_array($serendipity['view'], ['start', 'entries', 'archives', 'entry', 'categories', 'plugin']) && false === ($serendipity['GET']['action'] === 'empty') && (isset($eventData['id']) || (!isset($serendipity['viewtype']) || $serendipity['viewtype'] != '404_4')) && !isset($serendipity['is_staticpage']) && !isset($eventData['plugin_vars']['tag'])) {
                        // entry views
                        if (isset($serendipity['GET']['id']) && is_numeric($serendipity['GET']['id'])) {
                            $links[] = '<a href="' . $serendipity['baseURL'] . ($serendipity['rewrite'] == 'none' ? $serendipity['indexFile'] . '?/' : '') . 'plugin/articlepdf_' . $serendipity['GET']['id'] . '">' . PLUGIN_EVENT_BLOGPDF_VIEW_ENTRY . '</a>';
                        }

                        // category views
                        if (isset($serendipity['GET']['category'])) {
                            $cid = explode('_', $serendipity['GET']['category']);
                            if (is_numeric($cid[0])) {
                                $cat = serendipity_fetchCategoryInfo($cid[0]);
                                $links[] = '<a href="' . $serendipity['baseURL'] . ($serendipity['rewrite'] == 'none' ? $serendipity['indexFile'] . '?/' : '') . 'plugin/categorypdf_' . $cid[0] . '">' . sprintf(PLUGIN_EVENT_BLOGPDF_VIEW_CATEGORY, $cat['category_name']) . '</a>';
                            }
                        }

                        // ranged entries by timestamps
                        if (empty($year) && empty($month) && isset($serendipity['GET']['range']) && is_numeric($serendipity['GET']['range'])) {
                            $year  = substr($serendipity['GET']['range'], 0, 4);
                            $month = substr($serendipity['GET']['range'], 4, 2);
                        }

                        // entries summary pages
                        if (empty($year) && $serendipity['view'] == 'archives' && isset($serendipity['short_archives']) && $serendipity['short_archives'] == true && isset($serendipity['uriArguments'][3]) && $serendipity['uriArguments'][3] == 'summary') {
                            $year  = $serendipity['uriArguments'][1] ?? date('Y', serendipity_serverOffsetHour());
                            $month = $serendipity['uriArguments'][2] ?? date('m', serendipity_serverOffsetHour());
                        }

                        // break if showcase is in future
                        if (empty($year) && isset($serendipity['uriArguments'][2]) && $serendipity['uriArguments'][1].$serendipity['uriArguments'][2] > date('Y', serendipity_serverOffsetHour()) . date('m', serendipity_serverOffsetHour())) {
                            break;
                        }

                        // calender month view paging
                        if (empty($year) && $serendipity['view'] == 'archives' && !empty($serendipity['uriArguments'][1]) && is_numeric($serendipity['uriArguments'][1]) && !empty($serendipity['uriArguments'][2]) && is_numeric($serendipity['uriArguments'][2])) {
                            $year  = $serendipity['uriArguments'][1] ?? date('Y', serendipity_serverOffsetHour());
                            $month = $serendipity['uriArguments'][2] ?? date('m', serendipity_serverOffsetHour());
                        }

                        // fallback to current year
                        if (empty($year)) {
                            $year = date('Y', serendipity_serverOffsetHour());
                        }

                        // fallback to current month
                        if (empty($month)) {
                            $month = date('m', serendipity_serverOffsetHour());
                        }

                        $links[] = '<a href="' . $serendipity['baseURL'] . ($serendipity['rewrite'] == 'none' ? $serendipity['indexFile'] . '?/' : '') . 'plugin/monthpdf_' . $year . $month . '">' . PLUGIN_EVENT_BLOGPDF_VIEW_MONTH . '</a>';
                        $links[] = '<a href="' . $serendipity['baseURL'] . ($serendipity['rewrite'] == 'none' ? $serendipity['indexFile'] . '?/' : '') . 'plugin/blogpdf">' . PLUGIN_EVENT_BLOGPDF_VIEW_FULL . '</a>';

                        if ($this->article_show) {
                            if (!isset($eventData['add_footer'])) $eventData['add_footer'] = '';
                            $eventData['add_footer'] .= '<div class="serendipity_blogpdf"><strong>' . PLUGIN_EVENT_BLOGPDF_VIEW . '</strong>' . implode(' | ', $links) . '</div>';
                        } else {
                            if (isset($eventData['GET']['hidefooter']) && $eventData['GET']['hidefooter'] && $eventData['smarty']->tpl_vars['footer_totalEntries']->value > 0) {
                                echo '<div class="serendipity_blogpdf mt-n4 mb-4 no-bp4">' . PLUGIN_EVENT_BLOGPDF_VIEW . implode(' | ' , $links) . '</div>';
                            }
                        }
                    }
                    break;

                case 'external_plugin':
                /*
                    if (serendipity_db_bool($this->get_config('html2pdf', 'true'))) {
                        include_once dirname(__FILE__) . '/html2fpdf.php';
                    } elseif (serendipity_db_bool($this->get_config('updf', 'false'))) {
                        include_once dirname(__FILE__) . '/serendipity_blogupdf.inc.php';
                    } else {
                        include_once dirname(__FILE__) . '/serendipity_blogpdf.inc.php';
                    }
                */
                    require_once(realpath(dirname(__FILE__) . '/TCPDF/tcpdf.php'));

                    $parts = explode('_', $eventData);
                    if (!empty($parts[1])) {
                        $param = (int) $parts[1];
                    } else {
                        $param = null;
                    }

                    $methods = array('blogpdf', 'articlepdf', 'monthpdf', 'categorypdf');

                    if (!in_array($parts[0], $methods)) {
                        return;
                    }

                    try {
                        $this->pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, LANG_CHARSET, false);

                        $this->pdf->setPrintHeader(true);
                        $this->pdf->setPrintFooter(true);

                        // set default header data
                        $this->pdf->setHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, 'Serendipity Styx ' . PLUGIN_EVENT_BLOGPDF_EXPORT .': ' . $serendipity['blogTitle'], $serendipity['baseURL'], array(0,64,255), array(0,64,128));
                        $this->pdf->setFooterData(array(0,64,0), array(0,64,128));

                        // set header and footer fonts
                        $this->pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
                        $this->pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

                        // set default monospaced font
                        $this->pdf->setDefaultMonospacedFont(PDF_FONT_MONOSPACED);

                        // set margins
                        $this->pdf->setMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
                        $this->pdf->setHeaderMargin(PDF_MARGIN_HEADER);
                        $this->pdf->setFooterMargin(PDF_MARGIN_FOOTER);

                        // set auto page breaks
                        $this->pdf->setAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

                        // set image scale factor
                        $this->pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

                        // keep this break
                        $joinep = "
                    LEFT JOIN {$serendipity['dbPrefix']}entryproperties AS ep_blogpdf
                           ON (e.id = ep_blogpdf.entryid)";

                        switch($parts[0]) {
                            case 'blogpdf':
                                $feedcache = $serendipity['serendipityPath'] . 'archives/blog.pdf';
                                $entries = serendipity_fetchEntries(null, true, '', false, false, 'timestamp DESC', "ep_blogpdf.property != 'ep_entrypassword'", false, false, null, null, 'array', true, true, $joinep);
                                $this->process(
                                    $feedcache,
                                    $entries
                                );
                                break;

                            case 'articlepdf':
                                $feedcache = $serendipity['serendipityPath'] . 'archives/article' . $param . '.pdf';
                                $this->single = true;
                                $entry = serendipity_fetchEntry('id', $param);
                                // yes, external_plugin has access to $entry['properties'] since after
                                if (!empty($entry['properties']['ep_entrypassword'])) {
                                    $entry['title'] = '';
                                    $entry['body'] = 'Access denied. Password protection in effect!';
                                    $entry['extended'] = null;
                                }
                                $this->process(
                                    $feedcache,
                                    $entry
                                );
                                break;

                            case 'monthpdf':
                                $feedcache = $serendipity['serendipityPath'] . 'archives/month' . $param . '.pdf';
                                $entries = serendipity_fetchEntries($param, true, '', false, false, 'timestamp DESC', "ep_blogpdf.property != 'ep_entrypassword'", false, false, null, null, 'array', true, true, $joinep);
                                $this->process(
                                    $feedcache,
                                    $entries
                                );
                                break;

                            case 'categorypdf':
                                $feedcache = $serendipity['serendipityPath'] . 'archives/category' . $param . '.pdf';
                                $serendipity['GET']['category'] = $param . '_category';
                                $entries = serendipity_fetchEntries(null, true, '', false, false, 'timestamp DESC', "ep_blogpdf.property != 'ep_entrypassword'", false, false, null, null, 'array', true, true, $joinep);
                                $this->process(
                                    $feedcache,
                                    $entries
                                );
                                break;
                        }

                        #$content = '<page style="font-family: freeserif"><br />'.nl2br($this->pdf->buffer).'</page>';
                        $this->pdf->writeHTML($this->pdf->buffer);

                        $this->pdf->Output($param . '.pdf');

                    } catch (\Exception $e) {

                        $error =  '<span class="msg_error"><span class="icon-attention-circled"></span> ' . $e->getMessage() . "</span>\n";
                        $this->pdf->Error('Sorry! Unable to create the PDF document ' . $param . ".pdf for\n" . $error);

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

    function process($feedcache, &$entries)
    {
        $cachetime = 60*60*24; // one day

        if (!file_exists($feedcache) || filesize($feedcache) == 0 || filemtime($feedcache) < (time() - $cachetime)) {
            if ($this->single) {
                $this->print_entry(0, $entries, $this->prep_out(serendipity_formatTime(DATE_FORMAT_ENTRY, (int) $entries['timestamp'])));
            } else {
                $this->print_entries($entries);
            }
            $this->pdf->Close();
            $fp = fopen($feedcache, 'wb');
            fwrite($fp, $this->pdf->buffer);
            fclose($fp);
        } else {
            $this->pdf->buffer = file_get_contents($feedcache);
            $this->pdf->state = 3; // fake closed document to insert cached PDF
        }

        return true;
    }

    function print_entry($x, &$entry, $header = false)
    {
        if ($header) {
            $this->pdf->AddPage();
            $this->pdf->SetFont('pdfahelvetica', '', 10);
            $this->pdf->Cell(0, 10, $header, 1);
            $this->pdf->Ln();
            $this->pdf->Ln();
        }

        $entryLink = serendipity_archiveURL($entry['id'], $entry['title'], 'serendipityHTTPPath', true, array('timestamp' => $entry['timestamp']));
        $addData = array('from' => 'serendipity_event_blogpdf:print_entry', 'no_scramble' => true);
        serendipity_plugin_api::hook_event('frontend_display', $entry, $addData);

        $posted_by = ' ' . POSTED_BY . ' ' . htmlspecialchars($entry['author']);
        if (is_array($entry['categories']) && sizeof($entry['categories']) > 0) {
            $posted_by .= ' ' . IN . ' ';
            $cats = array();
            foreach ($entry['categories'] AS $cat) {
                $cats[] = $cat['category_name'];
            }
            $posted_by .= implode(', ', $cats);
        }

        $posted_by .= ' ' . AT . ' ' . serendipity_strftime('%H:%M', $entry['timestamp']);

        $html = $this->prep_out($entry['body'] . $entry['extended']) . "\n";
        $this->pdf->WriteHTML($html);
        $this->pdf->Ln();

        $this->pdf->SetFont('Courier', '', 9);
        $this->pdf->Write(4, $this->prep_out($posted_by) . "\n");
        $this->pdf->Ln();

        if ($this->single) {
            $this->printComments(serendipity_fetchComments((int) $entry['id']));
        }

    }

    function printComments($comments)
    {
        if (!is_array($comments) || count($comments) < 1) {
            return;
        }

        $addData = array('from' => 'serendipity_event_blogpdf:printComments');

        foreach ($comments AS $i => $comment) {
            $comment['comment'] = htmlspecialchars(strip_tags($comment['body']));
            if (!empty($comment['url']) && substr($comment['url'], 0, 7) != 'http://' && substr($comment['url'], 0, 8) != 'https://') {
                $comment['url'] = 'http://' . $comment['url'];
            }

            serendipity_plugin_api::hook_event('frontend_display', $comment, $addData);

            $name = empty($comment['username']) ? ANONYMOUS : $comment['username'];
            $body = $comment['comment'];

            $this->pdf->SetFont(PDF_FONT_MONOSPACED, '', 9);
            $html = $this->prep_out(
              $body . "\n" .
              '    ' . $name .
              ' ' . ON . ' ' . mb_ucfirst($this->prep_out(serendipity_strftime('%b %e %Y, %H:%M', $comment['timestamp'])))
            ) . "\n";

            $this->pdf->WriteHTML($html);
            $this->pdf->Ln();
            $this->pdf->Ln();
        }
    }

    function prep_out($string)
    {
        #if (serendipity_db_bool($this->get_config('html2pdf', 'true'))) {
            return $string;
        #} elseif (serendipity_db_bool($this->get_config('fallback', 'false'))) {
		#	return html_entity_decode(strip_tags(utf8_decode($string)), ENT_QUOTES | ENT_SUBSTITUTE | ENT_HTML401, LANG_CHARSET);
		#} else {
		#	return html_entity_decode(strip_tags($string), ENT_QUOTES | ENT_SUBSTITUTE | ENT_HTML401, LANG_CHARSET);
		#}
    }

    function print_entries(&$entries)
    {
        $extended = true;
        $preview  = false;

        $addData = array('extended' => $extended, 'preview' => $preview, 'no_scramble' => true);
        serendipity_plugin_api::hook_event('entry_display', $entries, $addData);

        /* pre-walk the array to collect them keyed by date */
        $bydate = array();
        if (!is_array($entries) || $entries[0] == false) {
            return;
        }

        $lastDate = '';
        for ($x = 0, $num_entries = count($entries); $x < $num_entries; $x++) {
            $d = $this->prep_out(serendipity_formatTime(DATE_FORMAT_ENTRY, (int) $entries[$x]['timestamp']));
            $bydate[$d][] = $entries[$x];
        }

        foreach ($bydate AS $date => $ents) {
            $header = $date;
            foreach ($ents AS $x => $entry) {
                $this->print_entry($x, $entry, $header);
                $header = false;
            }
        }
    }

}

/* vim: set sts=4 ts=4 expandtab : */
?>