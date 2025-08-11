<?php

declare(strict_types=1);

if (IN_serendipity !== true) {
    die ("Don't hack!");
}

@serendipity_plugin_api::load_language(dirname(__FILE__));

class serendipity_event_newsbox extends serendipity_event
{
    private $html = '<div class="newsbox"><i>No news today.</i></div>';
    private $isFrontPage = false;
    private $got_content = array();

    function introspect(&$propbag)
    {
        global $serendipity;

        $propbag->add('name',          PLUGIN_EVENT_NEWSBOX_TITLE);
        $propbag->add('description',   PLUGIN_EVENT_NEWSBOX_DESC);
        $propbag->add('copyright',     'GPL');
        $propbag->add('groups',        array('FRONTEND_VIEWS', 'FRONTEND_FEATURES'));
        $propbag->add('stackable',     true);
        $propbag->add('author',        'Jude Anthony, Ian Styx');
        $propbag->add('version',       '2.0.0');
        $propbag->add('requirements',  array(
            'serendipity' => '5.0',
            'smarty'      => '4.1',
            'php'         => '8.2'
        ));
        $propbag->add('event_hooks',    array(
            'genpage'                => true,
            'frontend_fetchentries'  => true,
            'css'                    => true,
            'frontend_header'        => true,
            'entries_header'         => true,
            'entries_footer'         => true,
            'frontend_footer'        => true,
            'newsbox:get_containers' => true,
            'newsbox:get_content'    => true,
        ));
        $propbag->add('configuration', array('title', 'content_type', 'news_cats', 'max_entries', 'placement'));
    }

    function introspect_config_item($name, &$propbag)
    {
        switch($name) {
            case 'title':
                $propbag->add('type', 'string');
                $propbag->add('name', PLUGIN_EVENT_NEWSBOX_TITLEFIELD);
                $propbag->add('description', PLUGIN_EVENT_NEWSBOX_TITLEFIELD_DESC);
                $propbag->add('default', 'News');
                break;

            case 'news_cats':
                $cats = $this->getCategorySelector();
                $propbag->add('type', 'multiselect');
                $propbag->add('name', PLUGIN_EVENT_NEWSBOX_NEWSCATS);
                $propbag->add('description', PLUGIN_EVENT_NEWSBOX_NEWSCATS_DESC);
                $propbag->add('select_values', $cats);
                $propbag->add('select_size',   5);
                $propbag->add('default', '');
                break;

            case 'max_entries':
                $propbag->add('type', 'string');
                $propbag->add('name', PLUGIN_EVENT_NEWSBOX_NUMENTRIES);
                $propbag->add('description', PLUGIN_EVENT_NEWSBOX_NUMENTRIES_DESC);
                $propbag->add('default', '5');
                break;

            case 'placement':
                $propbag->add('type', 'select');
                $propbag->add('name', PLUGIN_EVENT_NEWSBOX_PLACEMENT);
                $propbag->add('description', PLUGIN_EVENT_NEWSBOX_PLACEMENT_DESC);
                $select = array(
                    'page header'  => PLUGIN_EVENT_NEWSBOX_PLACEMENT_PAGE_TOP,
                    'entry top'    => PLUGIN_EVENT_NEWSBOX_PLACEMENT_ENTRY_TOP,
                    'entry bottom' => PLUGIN_EVENT_NEWSBOX_PLACEMENT_ENTRY_BOTTOM,
                    'page footer'  => PLUGIN_EVENT_NEWSBOX_PLACEMENT_PAGE_BOTTOM
                    );
                // Get all the newsbox containers (except me)
                $containers = array();
                serendipity_plugin_api::hook_event('newsbox:get_containers', $containers, array('id' => $this->instance));
                foreach($containers AS $container) {
                    $cid = $container['id'];
                    $cname = $container['name'];
                    $select[$cid] = $cname;
                }
                $select['hidden'] = PLUGIN_EVENT_NEWSBOX_PLACEMENT_HIDDEN;
                $propbag->add('select_values', $select);
                $propbag->add('default', 'entry top');
                break;

            case 'content_type':
                $propbag->add('type', 'radio');
                $propbag->add('name', PLUGIN_EVENT_NEWSBOX_CONTENTTYPE);
                $propbag->add('description', PLUGIN_EVENT_NEWSBOX_CONTENTTYPE_DESC);
                $radio = array();
                $radio['desc'] = array('Newsboxes', 'Categories');
                $radio['value'] = array('newsboxes', 'categories');
                $propbag->add('radio', $radio);
                $propbag->add('radio_per_row', 1);
                $propbag->add('default', 'categories');
                break;
        }
        return true;
    }

    function &getCategorySelector()
    {
        if (is_array($cats = serendipity_fetchCategories())) {
            $cats = serendipity_walkRecursive($cats, 'categoryid', 'parentid', VIEWMODE_THREADED);
            foreach($cats AS $cat) {
                $categories[$cat['categoryid']] = str_repeat('^ ', $cat['depth']) . $cat['category_name'];
            }
        }
        return $categories;
    }

    function generate_content(&$title)
    {
        $title = 'Newsbox: ' . $this->get_config('title');
    }

    function event_hook($event, &$bag, &$eventData, $addData = null)
    {
        global $serendipity;

        $hooks = &$bag->get('event_hooks');

        // I'm not really certain why this is here (since we only get called
        // for the events we hooked), but Garvin uses it, so it must be
        // important.
        if (isset($hooks[$event])) {
            $content_type = $this->get_config('content_type', 'categories');
            $placement = $this->get_config('placement', 'entry top');
            $news_cats = $this->get_config('news_cats');

            switch($event) {
                case 'genpage':
                    // Is this the frontpage? (Garvin's algorithm; works
                    // for all cases except index.html, on my server)
                    if ($addData['startpage']) {
                        $this->isFrontPage = true;
                    } else {
                        $this->isFrontPage = false;
                        break;
                    }
                    // Get this newsbox's entries
                    //

                    // Hidden newsboxes don't need to waste time doing this.
                    if ($placement == 'hidden') {
                        break;
                    }

                    // If I don't contain categories, I don't generate HTML from categories.
                    if ($content_type != 'categories') {
                        break;
                    }

                    // If this newsbox is empty, we'd get an SQL error.
                    if (empty($news_cats)) {
                        $this->html = '<div class="newsbox"><i>No ' .
                            $this->get_config('title', PLUGIN_EVENT_NEWSBOX_DEFAULT_TITLE) .
                            " today.</i></div>\n";
                        break;
                    }

                    if (!isset($serendipity['smarty']) || !is_object($serendipity['smarty'])) {
                        // never init in genpage without adding previously set $vars, which is $view etc!
                        serendipity_smarty_init($serendipity['plugindata']['smartyvars']);
                    }

                    // Create the SQL to fetch my entries
                    $sql = "\n" . ' e.id IN ' . "\n"
                        . '(SELECT entryid FROM '
                        . $serendipity['dbPrefix'] . 'entrycat'
                        . "\n" . ' WHERE categoryid IN ('
                        . $news_cats . ')' . "\n" . ')';

                    // We don't want our exclusion logic to execute on *this*
                    // fetchEntries call!
                    $serendipity['newsbox'] = 'no_exclude';
                    //--JAM: yeah, it looks like a bug to me.  I wonder what else gets accidentally overwritten?
                    $oldLimit = $serendipity['fetchLimit'];
                    // We want the number of entries configurable
                    $max_entries = $this->get_config('max_entries', 5);
                    if (!is_numeric($max_entries)) {
                        $max_entries = 5;
                    }
                    $entries = serendipity_fetchEntries(null, true, $max_entries, false, false, 'timestamp DESC', $sql);

                    $amount = is_array($entries) ? count($entries) : 0;
                    $serendipity['fetchLimit'] = $oldLimit;
                    unset($serendipity['newsbox']);

                    // Process our input data with new printEntries:
                    // $entries, no extended, no preview, block NEWSBOX, no Smarty fetch, no hooks, footer
                    serendipity_printEntries($entries, false, false, 'NEWSBOX', false, false, false);
                    $newsbox_data = array();
                    $newsbox_data['title'] = $this->get_config('title', PLUGIN_EVENT_NEWSBOX_DEFAULT_TITLE);
                    $newsbox_data['cats'] = explode(',', $news_cats);
                    $newsbox_data['content_type'] = $content_type;
                    $newsbox_data['isContainer'] = ($content_type != 'categories');
                    $newsbox_data['multicat_action'] = $serendipity['baseURL'] . $serendipity['indexFile'];
                    $serendipity['smarty']->assign('newsbox_data', $newsbox_data);
                    $serendipity['smarty']->assign(array(
                        'plugin_clean_page' => true,
                        'view'              => $serendipity['view'])
                    );
                    // NOTE: 'plugin clean_page' just avoids to apply the entries footer container for the newsbox run (a "second" time). It is not set while fetching the normal entries list.

                    $filename = 'newsbox.tpl';
                    $tfile = serendipity_getTemplateFile($filename, 'serendipityPath');

                    if (!$tfile || $tfile == $filename) {
                        $tfile = dirname(__FILE__) . '/' . $filename;
                    }
                    if (file_exists($tfile)) {
                        // if to add pagination
                        $serendipity['smarty']->assign('is_nbpagination', ($amount > $max_entries));
                        $this->html = $this->parseTemplate($tfile);
                    } else {
                        // Set the newsbox variable for the template, in case it's newsbox-aware
                        $serendipity['smarty']->assign('isNewsbox', true);

                        // add pagination if there is any more
                        if ($amount > $max_entries) {
                            // Modify the footer link
                            $more = '<form style="display:inline;" action="' . $serendipity['baseURL'] . $serendipity['indexFile'] . '" method="post">';
                            foreach(explode(',', $news_cats) AS $cat) {
                                $more .= '<input type="hidden" name="serendipity[multiCat][]" value="' . $cat . '">';
                            }
                            $more .= '<input class="serendipityPrettyButton input_button" type="submit" name="serendipity[isMultiCat]" value="' . MORE . ' ' . $this->get_config('title', PLUGIN_EVENT_NEWSBOX_DEFAULT_TITLE) . '"></form>';
                            $serendipity['smarty']->assign('footer_info', $more);
                        }

                        // just in case we have a theme template with weired conditions - unset normal entries pagination variables
                        $serendipity['smarty']->assign('footer_prev_page', null);
                        $serendipity['smarty']->assign('footer_next_page', null);

                        // Get the HTML
                        $serendipity['skip_smarty_hooks'] = true;  // Don't call 'entries_header' from the template!
                        $this->html = serendipity_smarty_fetch('NEWSBOX', 'entries.tpl', false);
                        unset($serendipity['skip_smarty_hooks']);// is equal to false
                    }

                    // Don't leave the newsbox variable set for the regular fetch
                    $serendipity['smarty']->clearAssign('isNewsbox');

                    // Check if the template supports newsboxes

                    /* Matches class = "whatever_newsbox_whatever", taking care to allow
                       whitespace where legal and match quote types (I don't think you
                       can use a quote in a class name, but hey...) */
                    if (preg_match('/class\\s*=\\s*(["\'])[^\\1]*newsbox/', $this->html) == 0) {
                        // Add the div; give it the default class "newsbox" and a title
                        $title = $this->get_config('title');
                        $this->html = "\n<div class=\"newsbox\"><h3 class=\"newsbox_title\">$title</h3>\n" . $this->html . "\n</div><!--newsbox-->\n";
                    }
                    // Done processing the newsbox
                    break;

                case 'frontend_fetchentries':
                    /* is executed twice - once for the newsbox genpage entries, next for the normal entries list without the newsbox entries of the first */
                    // Only on the frontpage
                    if (!$this->isFrontPage) {
                        break;
                    }

                    // Don't even call this hook if we're already in this hook
                    if (isset($serendipity['newsbox']) && $serendipity['newsbox'] == 'no_exclude') {
                        break;
                    }

                    // If we don't contain categories, we don't want to
                    // exclude categories accidentally
                    if ($content_type != 'categories') {
                        break;
                    }

                    // Don't restrict the calendar, etc; only the main listing
                    $source = $addData['source'];
                    if ($source != 'entries') {
                        break;
                    }

                    // No joins required!
                    // $joins = array();
                    $conds = array();

                    if (isset($news_cats) && !empty($news_cats)) {
                        // Exclude entries of the newbox
                        $conds[] =
                        ' (e.id NOT IN (SELECT entryid from '
                        . $serendipity['dbPrefix'] . 'entrycat'
                        . ' WHERE categoryid IN (' . $news_cats . ')))';
                    }

                    if (count($conds) > 0) {
                        $cond = implode(' AND ', $conds);
                        if (empty($eventData['and'])) {
                            $eventData['and'] = " WHERE $cond ";
                        } else {
                            $eventData['and'] .= " AND $cond ";
                        }
                    }
                    break;

                case 'css':
                    if (false !== strpos($eventData, 'newsbox')) {
                        // This CSS is already newsbox-aware.
                        break;
                    }
                    $eventData .= '

/* serendipity_event_newsbox start */

.newsbox {
    border: 1px solid #DDD;
    padding: 0 .5em;
    margin-bottom: 1em;
    text-align: left;
}
.newsbox_title {
    font-style: italic;
}
.newsbox_container {
    border: 1px solid #DDD;
    padding: 0 .5em;
    margin-bottom: 1em;
    text-align: center;
    margin: 2px auto;
}
.newsbox_container .cbox {
    clear: both;
}
.newsbox_container .newsbox {
    border: none;
    width: 48%;
    float: left;
    text-align: left;
    margin: 2px;
    display: inline;
}

/* serendipity_event_newsbox end */
';
                    break;

                /* Placement cases: if configured placement equals the hook,
                   print my HTML.  Hidden takes care of itself: there is no
                   matching hook, so it never gets printed.  Contained
                   newsboxes will also never match a hook; their HTML is
                   requested by the containing newsbox.*/
                case 'frontend_header':
                    if ($this->isFrontPage && $placement == 'page header') {
                        echo $this->getHTML();
                    }
                    break;

                case 'entries_header':
                    if ($this->isFrontPage && $placement == 'entry top') {
                        echo $this->getHTML();
                    }
                    break;

                case 'entries_footer':
                    if ($this->isFrontPage && $placement == 'entry bottom') {
                        echo $this->getHTML();
                    }
                    break;

                case 'frontend_footer':
                    if ($this->isFrontPage && $placement == 'page footer') {
                        echo $this->getHTML();
                    }
                    break;

                case 'newsbox:get_content':
                    // Custom hook to retrieve data for contained newsboxes.
                    // If the container asking for content is my container,
                    // add my content to the data array.
                    if ($addData['id'] == $placement) {
                        // 1. Avoid recursion.
                        // 2. Go to step 1.
                        if (empty($this->got_content[$addData['id']])) {
                            $this->got_content[$addData['id']] = true;
                            $eventData[] = $this->getHTML();
                        }
                        break;
                    }
                    break;

                case 'newsbox:get_containers':
                    // Custom hook to find newsbox containers.  If I'm a newsbox
                    // container, return my instance ID and store the title in plugin config placement select box
                    if (($addData['id'] != $this->instance) && ($this->get_config('content_type', 'categories') == 'newsboxes')) {
                        $eventData[] = array(
                            'id' => $this->instance,
                            'name' => 'Newsbox: ' . $this->get_config('title', PLUGIN_EVENT_NEWSBOX_DEFAULT_TITLE));
                    }
                    break;

                default:
                    return false;
                    break;
            }
        } else {
            return false;
        }
        return true;
    }

    /**
     * Convenience function to avoid duplicating code in every possible
     * placement of output.
     */
    function getHTML()
    {
        global $serendipity;

        $content_type = $this->get_config('content_type', 'categories');
        if ($content_type == 'newsboxes') {
            // Wrap content from my contained newsboxes.
            $contents = array();
            serendipity_plugin_api::hook_event('newsbox:get_content', $contents, array('id' => $this->instance));
            $nb = serendipity_getTemplateFile('newsbox.tpl', 'serendipityPath');
            if ($nb && $nb != 'newsbox.tpl') {
                // The template should be able to handle this
                $serendipity['smarty']->assign('NEWSBOX', $contents);
                $newsbox_data = array();
                $newsbox_data['title'] = $this->get_config('title', PLUGIN_EVENT_NEWSBOX_DEFAULT_TITLE);
                $newsbox_data['cats'] = '';
                $newsbox_data['content_type'] = $content_type;
                $newsbox_data['isContainer'] = true;
                $newsbox_data['multicat_action'] = '';
                $serendipity['smarty']->assign('newsbox_data', $newsbox_data);
                $this->html = serendipity_smarty_fetch('NEWSBOX', 'newsbox.tpl', false);
            } else {
                $this->html = "\n<div class=\"newsbox_container\">\n    <h3 class=\"newsbox_title\">" . $this->get_config('title') . "</h3>\n";
                foreach($contents AS $box) {
                    $this->html .= $box . "\n";
                }
                $this->html .= '<div class="cbox"><br></div>' . "\n";
                $this->html .= "\n</div><!--newsbox_container-->\n";
            }
        }
        return $this->html;
    }
}

/* vim: set sts=4 ts=4 expandtab : */
?>