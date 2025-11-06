<?php

declare(strict_types=1);

if (IN_serendipity !== true) {
    die ("Don't hack!");
}

// Load possible language files.
@serendipity_plugin_api::load_language(dirname(__FILE__));

// Extend the base class
class serendipity_event_feed extends serendipity_plugin
{
    public $title = PLUGIN_DASHBOARD_FEEDME_PLUGIN_TITLE;

    // Setup metadata
    function introspect(&$propbag)
    {
        $propbag->add('name', PLUGIN_DASHBOARD_FEEDME_PLUGIN_TITLE);
        $propbag->add('description',    PLUGIN_DASHBOARD_FEEDME_PLUGIN_DESC);
        $propbag->add('stackable',      false);
        $propbag->add('author',         'Ian Styx');
        $propbag->add('version',        '2.0.2');
        $propbag->add('requirements',   array(
            'serendipity' => '5.0',
            'smarty'      => '4.1',
            'php'         => '8.2'
        ));
        $propbag->add('groups', array('BACKEND_ADMIN', 'BACKEND_DASHBOARD', 'BACKEND_FEATURES'));
        $propbag->add('event_hooks',    array(
            'backend_dashboard'         => true,
            'css_backend'               => true
        ));
        $propbag->add('configuration',  array(
            'show_feeds',
            'show_num',
            'feed',
            'show_feedcontent',
            'show_feedauthors',
            'show_feedcomments'
        ));
    }

    function introspect_config_item($name, &$propbag)
    {
        switch($name) {
            case 'show_feeds':
                $propbag->add('type',        'boolean');
                $propbag->add('name',        PLUGIN_EVENT_FEED_SHOW_FEEDS);
                $propbag->add('description', '');
                $propbag->add('default',     'true');
                break;

            case 'show_num':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_EVENT_FEED_SHOW_FEEDNUM);
                $propbag->add('description', '');
                $propbag->add('default',     '3');
                break;

            case 'feed':
                $feeds = array(
                    'http://blog.s9y.org/feeds/index.rss2'  => 's9y-blog',
                    'http://board.s9y.org/feed.php'         => 's9y-forum'
                );
                $propbag->add('type',        'select');
                $propbag->add('select_values', $feeds);
                $propbag->add('name',        PLUGIN_EVENT_FEED_FEEDS);
                $propbag->add('description', '');
                $propbag->add('default',     's9y-blog');
                break;

            case 'show_feedcontent':
                $propbag->add('type',        'boolean');
                $propbag->add('name',        PLUGIN_EVENT_FEED_SHOW_CONTENT);
                $propbag->add('description', '');
                $propbag->add('default',     'true');
                break;

            case 'show_feedauthors':
                $propbag->add('type',        'boolean');
                $propbag->add('name',        PLUGIN_EVENT_FEED_SHOW_AUTHOR);
                $propbag->add('description', '');
                $propbag->add('default',     'true');
                break;

            case 'show_feedcomments':
                $propbag->add('type',        'boolean');
                $propbag->add('name',        PLUGIN_EVENT_FEED_SHOW_COMMENTS);
                $propbag->add('description', '');
                $propbag->add('default',     'true');
                break;

            default:
                return false;
        }
        return true;
    }

    // Setup title
    function generate_content(&$title)
    {
        $title = $this->title;
    }

    /**
     * Select the RSS feed content
     *
     * thanks to Stuart Herbert http://blog.stuartherbert.com/php/2007/01/07/using-simplexml-to-parse-rss-feeds/
     *
     * @access    private
     * @param     string     feedContent
     * @param     int        Limit entries
     * @return    array      articles
     **/
    private static function select_simple_xml_rss($xml, $num)
    {
        /* what we might need to extract
        <item>
            <title></title>
            <link></link>
                <category>Announcements</category>
                <category>Development</category>
                <category>Personal</category>
            <comments></comments>
            <wfw:comment></wfw:comment>
            <slash:comment></slash:comment>
            <author></author>
            <content:encoded></content:encoded>
            <pubDate></pubDate>
            <feedburner:origLink></feedburner:origLink>
        </item>
        */
        // define the namespaces that we are interested in
        $ns = array
        (
            'content' => 'http://purl.org/rss/1.0/modules/content/',
            'wfw' => 'http://wellformedweb.org/CommentAPI/',
            'dc' => 'http://purl.org/dc/elements/1.1/',
            'slash' => 'http://purl.org/rss/1.0/modules/slash/'
        );

        // obtain the articles in the feeds, and construct an array of articles
        $articles = array();

        // step 1: get the feed (we already have that by function get_url_contents($url), so param $content = $xml)
        #$xml = @new SimpleXmlElement($content);

        // step 2: extract the channel metadata
        $channel = array();
        $channel['title']       = $xml->channel->title;
        $channel['link']        = $xml->channel->link;
        $channel['description'] = $xml->channel->description;
        $channel['pubDate']     = $xml->pubDate;
        $channel['timestamp']   = strtotime($xml->pubDate);
        $channel['generator']   = $xml->generator;
        $channel['language']    = $xml->language;

        // step 3: extract the articles
        $i = 1;
        foreach ($xml->channel->item AS $item)
        {
            $article = array();
            $article['channel'] = $blog;
            $article['title'] = $item->title;
            $article['author'] = $item->author;
            $article['link'] = $item->link;
            $article['comments'] = $item->comments;
            $article['pubDate'] = $item->pubDate;
            $article['timestamp'] = strtotime($item->pubDate);
            $article['description'] = (string) trim($item->description);
            $article['isPermaLink'] = $item->guid['isPermaLink'];

            // get data held in namespaces
            $content = $item->children($ns['content']);
            $dc      = $item->children($ns['dc']);
            $wfw     = $item->children($ns['wfw']);
            $slash   = $item->children($ns['slash']);

            $article['creator'] = (string) $dc->creator;
            foreach ($dc->subject AS $subject)
                $article['subject'][] = (string)$subject;

            $article['content'] = (string)trim($content->encoded);
            $article['commentRss'] = $wfw->commentRss;
            $article['countcomments'] = $slash->comments;

            // add this article to the list
            $articles[$article['timestamp']] = $article;
            if ($i >= $num) break;
            $i++;
        }

        // a users note
        // Another way to get the CDATA is to load the xml using
        // $xml = simplexml_load_string($rawFeed, ?SimpleXMLElement?, LIBXML_NOCDATA); //(PHP >= 5.1.0)
        // ~
        // Then you just get the CDATA elements without complications.
        // See: http://us.php.net/manual/en/function.simplexml-load-string.php

        // at this point, $channel contains all the metadata about the RSS feed,
        // and $articles contains an array of articles for us to repurpose
        return $articles;
    }

    /**
     * Parses the Serendipity forum atom feed
     *
     * @access    private
     * @param   object  the XML feeddata
     * @return  array
     */
    private function parseAtom($xml, $n = 3)
    {
        $a = array();
        $i = 1;
        foreach ($xml->entry AS $item) {
            $author = (string) $item->author->name;
            $updated = (string) strtotime($item->updated);
            $published = (string) strtotime($item->published);
            $url = (string) $item->id;
            $title = (string) $item->title[0];
            #$cat = $item->category->attributes();
            $desc = str_replace("<br /><br />", "<br>", preg_replace('/<p>Statistics:+.*$/', '', trim($item->content)));
            $a[] = array(
                        'author'    => $author,
                        'updated'   => $updated,
                        'published' => $published,
                        'comments'  => NULL,
                        'link'      => $url,
                        'content'   => $desc,
                        'title'     => $title/*,
                        'cat'       => $cat*/
                    );
            if ($i >= $n) break;
            $i++;
        }
        return $a;
    }

    /**
     * Read the RSS feed Content
     *
     * @access    private
     * @param     string     url
     * @return    array      get_url_contents
     */
    private static function get_url_contents($url)
    {
        $feed = file_get_contents($url);
        if (empty($feed)) {
            // try it again with curl if fopen was forbidden
            if (function_exists('curl_init')) {
                $ch = curl_init($url);
                $timeout = 5;
                $useragent = "Googlebot/2.1 ( http://www.googlebot.com/bot.html)";
                curl_setopt ($ch, CURLOPT_USERAGENT, $useragent);
                curl_setopt ($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
                #curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
                $feed = curl_exec($ch);
                $ch = NULL;
            }
        }
        return $feed;
    }

    /**
     * Get Element Info Feed
     *
     * @access    private
     * @return    string     XML-feed
     */
    private function showElementInfoFeed()
    {
        $blockFeedUrl = $this->get_config('feed',  'http://blog.s9y.org/feeds/index.rss2');
        $num = $this->get_config('show_num', 3);

        if (strpos($blockFeedUrl,'rss2') == false) {
            // read the rss feed
            $feeddata = $this->get_url_contents($blockFeedUrl); // ToDo: cache this for a day.., see updater
            // error_reporting
            try { $xmlData = @new SimpleXMLElement($feeddata, LIBXML_NOCDATA); } catch (\Throwable $t) {
                $feed[0]['content'] = 'There was an error ("<em>'.$t->getMessage().'</em>") fetching the selected RSS Feed. Try again later.';
                return $feed;
            }
        } else {
            // this is RSS2
            $xmlData = simplexml_load_file($blockFeedUrl); // ToDo: cache this for a day.., see updater
        }

        // Now that SimpleXML has the RSS data, lets dectect witch type of feed it is.
        if (isset($xmlData->channel)) {
            $feed = $this->select_simple_xml_rss($xmlData, $num);
        }
        if (isset($xmlData->entry)) {
            $feed = $this->parseAtom($xmlData, $num);
        }
        return $feed;
    }

    // Listen on events
    function event_hook($event, &$bag, &$eventData, $addData = null)
    {
        global $serendipity;

        $hooks = &$bag->get('event_hooks');

        if (isset($hooks[$event])) {

            switch($event) {

                case 'backend_dashboard':
                    if (!serendipity_checkPermission('adminUsers')) {
                        return false;
                    }
                    if (serendipity_checkPermission('siteConfiguration') || serendipity_checkPermission('blogConfiguration')) {
                        // gather the rss-data
                        $feed = $this->showElementInfoFeed();
                        if (is_array($feed) && !empty($feed)) {
                            $serendipity['smarty']->assign(
                                array(
                                    'thefeed'           => $feed,
                                    'show_feedcontent'  => $this->get_config('show_feedcontent', 'true'),
                                    'show_feedauthor'   => $this->get_config('show_feedauthors', 'true'),
                                    'show_feedconum'    => $this->get_config('show_feedcomments', 'true')
                                )
                            );
                    }
                    /* get the template file */
                    $content = $this->parseTemplate('feedblock.tpl');
                    // We need to set (float) this dashboard widget box to the right, since all others use float:left
                    // and -if not- would make the height-size per row like an equal-height box, which is NOT want we want to have!
                    // We want the dashboard widgets to easily float into the 2-grid (>= medium screen) space available in height.
?>

    <section id="dashboard_feedly" class="<?php if (!empty($eq)) { ?>equal_heights <?php } ?>quick_list dashboard_widget widget_right">
        <h3><?php echo PLUGIN_DASHBOARD_FEEDME_TITLE; ?></h3>
        <div class="feedlies">
            <?php echo $content; ?>
        </div>
    </section>

<?php
                    }
                    break;

                case 'css_backend':
                    // append!
                    $eventData .= '

/* serendipity event_feed start */

/* if in specific order, we need to reset the nth-child(2n) left margin for other boxes - no need with 2.4
#dashboard > .dashboard_widget:nth-child(2n) { margin: 0 0 1em 0; } */

/* MEDIUM SCREEN UP */
@media only screen and (min-width: 768px) {
    #dashboard > .widget_right {
        float: right;
    }
}
#dashboard_feedly .feedlies { margin: .5em 0;}
#dashboard_feedly .feed_data { margin-top: .5em; margin-bottom: .5em; }
#dashboard_feedly .feed_text { display: inline-table; padding: 0 .5em; border: 1px solid #DDD; background: #F9F9F9; width: 96%; font-size: smaller; line-height: 1.7; }
#dashboard_feedly .feed_fields { margin-top: 0px; margin-bottom: 1.5em; }
#dashboard_feedly dl, #dashboard_feedly dl.codebox, #dashboard_feedly code { margin: 0px; }
#dashboard_feedly dl.codebox { background: #fff; padding: .2em; }
#dashboard_feedly blockquote { margin: 0.5em; padding: 5px; background-color: #EBEADD; border-color: #DBDBCE; }
#dashboard_feedly label span { display: inline; }
#dashboard_feedly blockquote,
#dashboard_feedly dl.codebox,
#dashboard_feedly label .feed_headline { font-size: 0.95em; }
#dashboard_feedly details.open summary .sumtitle { color: #999; }

/* serendipity event_feed end */

';
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

?>