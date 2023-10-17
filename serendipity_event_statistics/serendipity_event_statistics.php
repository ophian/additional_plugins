<?php

if (IN_serendipity !== true) {
    die ("Don't hack!");
}

@serendipity_plugin_api::load_language(dirname(__FILE__));

class serendipity_event_statistics extends serendipity_event
{
    var $title = PLUGIN_EVENT_STATISTICS_NAME;

    /**
     * API
     */
    function introspect(&$propbag)
    {
        global $serendipity;

        $propbag->add('name',          PLUGIN_EVENT_STATISTICS_NAME);
        $propbag->add('description',   PLUGIN_EVENT_STATISTICS_DESC);
        $propbag->add('stackable',     false);
        $propbag->add('author',        'Arnan de Gans, Garvin Hicking, Fredrik Sandberg, kalkin, Matthias Mees, Ian Styx');
        $propbag->add('version',       '3.9.0');
        $propbag->add('requirements',  array(
            'serendipity' => '3.2',
            'php'         => '7.4'
        ));
        $propbag->add('groups', array('STATISTICS'));
        $propbag->add('event_hooks',   array(
            'backend_sidebar_admin_appearance' => true,
            'backend_sidebar_entries_event_display_statistics' => true,
            'frontend_configure' => true,
            'css_backend'        => true
        ));

        $propbag->add('configuration', array('max_items','ext_vis_stat','stat_all','banned_bots','gethostbyaddr','autoclean'));
        $propbag->add('legal',    array(
            'services' => array(
            ),
            'frontend' => array(
                'Saves user visitor data to the local database (visitors) for statistical analysis. Tracks IP, User Agent, HTTP Referrer',
            ),
            'backend' => array(
            ),
            'cookies' => array(
            ),
            'stores_user_input'     => true,
            'stores_ip'             => true,
            'uses_ip'               => true,
            'transmits_user_input'  => false
        ));
    }

    /**
     * API
     */
    function introspect_config_item($name, &$propbag)
    {
        switch($name) {
            case 'max_items':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_EVENT_STATISTICS_MAX_ITEMS);
                $propbag->add('description', PLUGIN_EVENT_STATISTICS_MAX_ITEMS_DESC);
                $propbag->add('default',     20);
                break;

            case 'ext_vis_stat':
                $select = array('no'     => PLUGIN_EVENT_STATISTICS_EXT_OPT1,
                                'yesBot' => PLUGIN_EVENT_STATISTICS_EXT_OPT2,
                                'yesTop' => PLUGIN_EVENT_STATISTICS_EXT_OPT3);

                $propbag->add('type',          'select');
                $propbag->add('name',          PLUGIN_EVENT_STATISTICS_EXT_ADD);
                $propbag->add('description',   PLUGIN_EVENT_STATISTICS_EXT_ADD_DESC);
                $propbag->add('select_values', $select);
                $propbag->add('default',       'no');
                break;

            case 'stat_all':
                $select = array('no' => PLUGIN_EVENT_STATISTICS_EXT_ALL1,
                                'yes' => PLUGIN_EVENT_STATISTICS_EXT_ALL2);

                $propbag->add('type',          'select');
                $propbag->add('name',          PLUGIN_EVENT_STATISTICS_EXT_ALL);
                $propbag->add('description',   PLUGIN_EVENT_STATISTICS_EXT_ALL_DESC);
                $propbag->add('select_values', $select);
                $propbag->add('default',       'yes');
                break;

           case 'banned_bots':
                $select = array('yes' => PLUGIN_EVENT_STATISTICS_BANNED_HOSTS1,
                                'no' => PLUGIN_EVENT_STATISTICS_BANNED_HOSTS2);

                $propbag->add('type',          'select');
                $propbag->add('name',          PLUGIN_EVENT_STATISTICS_BANNED_HOSTS);
                $propbag->add('description',   PLUGIN_EVENT_STATISTICS_BANNED_HOSTS_DESC);
                $propbag->add('select_values', $select);
                $propbag->add('default',       'yes');
                break;

            case 'gethostbyaddr':
                $propbag->add('type',        'boolean');
                $propbag->add('name',        PLUGIN_EVENT_STATISTICS_CHECKDNS);
                $propbag->add('description', PLUGIN_EVENT_STATISTICS_CHECKDNS_DESC);
                $propbag->add('default',     'true');
                break;

            case 'autoclean':
                $propbag->add('type',        'boolean');
                $propbag->add('name',        PLUGIN_EVENT_STATISTICS_AUTOCLEAN);
                $propbag->add('description', PLUGIN_EVENT_STATISTICS_AUTOCLEAN_DESC);
                $propbag->add('default',     'true');
                break;
        }

        return true;
    }

    /**
     * API
     */
    function generate_content(&$title)
    {
        $title = $this->title;
    }

    /**
     * API
     */
    function event_hook($event, &$bag, &$eventData, $addData = null)
    {
        global $serendipity;

        $debug = false;
        $logtag = 'PLUGIN_STATISTICS::';

        $hooks = &$bag->get('event_hooks');

        if (isset($hooks[$event])) {

            switch($event) {

                case 'frontend_configure':
                    if ($this->get_config('ext_vis_stat') == 'no') {
                        return;
                    }

                    // checking if db tables exists, otherwise install them
                    try {
                        $tableChecker = serendipity_db_query("SELECT counter_id FROM {$serendipity['dbPrefix']}visitors LIMIT 1", true);
                    } catch (\Throwable|\Error|\Exception $e) {
                        // catch a case where tables are installed but haven't seen a single visitor yet
                        if ($e->getMessage() == "Table '{$serendipity['dbName']}.{$serendipity['dbPrefix']}visitors' already exist") {
                            $tableChecker = [];
                        }
                    }
                    if (isset($tableChecker) && !is_array($tableChecker)) {
                        $this->createTables();
                    }

                    if ((int)$this->get_config('db_indices_created', '0') === 0) {
                        $this->updateTables();
                    }
                    if ((int)$this->get_config('db_indices_created', '1') === 1) {
                        $this->updateTables(1);
                    }

                    // Unique visitors are being registered and counted here. Calling function below.
                    $sessionChecker = serendipity_db_query("SELECT count(sessID) FROM {$serendipity['dbPrefix']}visitors WHERE '".serendipity_db_escape_string(session_id())."' = sessID GROUP BY sessID", true);
                    if (!is_array($sessionChecker) || (is_array($sessionChecker) && $sessionChecker[0] == 0)) {

                        $referer = $useragent = $remoteaddr = 'unknown';

                        // gathering visitor meta
                        if (isset($_SERVER['REMOTE_ADDR'])) {
                            $remoteaddr = $_SERVER['REMOTE_ADDR'];
                        }
                        if (isset($_SERVER['HTTP_USER_AGENT'])) {
                            $useragent = substr($_SERVER['HTTP_USER_AGENT'], 0, 255);
                        }
                        if (isset($_SERVER['HTTP_REFERER'])) {
                            $referer = substr($_SERVER['HTTP_REFERER'], 0, 255);
                        }

                        $found = 0;

                        // avoiding banned browsers
                        if ($this->get_config('banned_bots') == 'yes') {
                            // excludelist spider/botagents
                            /**
                             * # MIT License
                             * https://github.com/atmire/COUNTER-Robots/
                             * Official list of user agents that are regarded as robots/spiders by Project COUNTER (https://www.projectcounter.org/)
                             * https://github.com/atmire/COUNTER-Robots/blob/master/generated/COUNTER_Robots_list.txt
                             * $array = explode("\n", file_get_contents(dirname(__FILE__).'/botlist.txt'));
                             * echo '<pre>'.var_export($array,true).'</pre>';
                             * Fixed for preg_match()
                             */
                            $bannbots = array (
                              0 => 'bot',
                              1 => '^Buck\\/[0-9]',
                              2 => 'spider',
                              3 => 'crawl',
                              4 => '^.?$',
                              5 => '[^a]fish',
                              6 => '^IDA$',
                              7 => '^ruby$',
                              8 => '^@ozilla\\/\\d',
                              9 => '^\?\?\?\?\?\?\?\?$',
                              10 => '^\?\?\?\?$',
                              11 => 'AddThis',
                              12 => 'A6-Indexer',
                              13 => 'ADmantX',
                              14 => 'alexa',
                              15 => 'Alexandria(\\s|\\+)prototype(\\s|\\+)project',
                              16 => 'AllenTrack',
                              17 => 'almaden',
                              18 => 'appie',
                              19 => 'API[\\+\\s]scraper',
                              20 => 'Arachni',
                              21 => 'Arachmo',
                              22 => 'architext',
                              23 => 'ArchiveTeam',
                              24 => 'aria2\\/\\d',
                              25 => 'arks',
                              26 => '^Array$',
                              27 => 'asterias',
                              28 => 'atomz',
                              29 => 'BDFetch',
                              30 => 'Betsie',
                              31 => 'baidu',
                              32 => 'biglotron',
                              33 => 'BingPreview',
                              34 => 'binlar',
                              35 => 'bjaaland',
                              36 => 'Blackboard[\\+\\s]Safeassign',
                              37 => 'blaiz-bee',
                              38 => 'bloglines',
                              39 => 'blogpulse',
                              40 => 'boitho\\.com-dc',
                              41 => 'bookmark-manager',
                              42 => 'Brutus\\/AET',
                              43 => 'BUbiNG',
                              44 => 'bwh3_user_agent',
                              45 => 'CakePHP',
                              46 => 'celestial',
                              47 => 'cfnetwork',
                              48 => 'checklink',
                              49 => 'checkprivacy',
                              50 => 'China\\sLocal\\sBrowse\\s2\\.6',
                              51 => 'cloakDetect',
                              52 => 'coccoc\\/1\\.0',
                              53 => 'Code\\sSample\\sWeb\\sClient',
                              54 => 'ColdFusion',
                              55 => 'collection@infegy.com',
                              56 => 'com\\.plumanalytics',
                              57 => 'combine',
                              58 => 'contentmatch',
                              59 => 'ContentSmartz',
                              60 => 'convera',
                              61 => 'core',
                              62 => 'Cortana',
                              63 => 'CoverScout',
                              64 => 'curl\\/',
                              65 => 'cursor',
                              66 => 'custo',
                              67 => 'DataCha0s\\/2\\.0',
                              68 => 'daumoa',
                              69 => '^\\%?default\\%?$',
                              70 => 'DeuSu\\/',
                              71 => 'Dispatch\\/\\d',
                              72 => 'Docoloc',
                              73 => 'docomo',
                              74 => 'Download\\+Master',
                              75 => 'DSurf',
                              76 => 'DTS Agent',
                              77 => 'EasyBib[\\+\\s]AutoCite[\\+\\s]',
                              78 => 'easydl',
                              79 => 'EBSCO\\sEJS\\sContent\\sServer',
                              80 => 'EcoSearch',
                              81 => 'ELinks\\/',
                              82 => 'EmailSiphon',
                              83 => 'EmailWolf',
                              84 => 'Embedly',
                              85 => 'EThOS\\+\\(British\\+Library\\)',
                              86 => 'facebookexternalhit\\/',
                              87 => 'favorg',
                              88 => 'FDM(\\s|\\+)\\d',
                              89 => 'Feedbin',
                              90 => 'feedburner',
                              91 => 'FeedFetcher',
                              92 => 'feedreader',
                              93 => 'ferret',
                              94 => 'Fetch(\\s|\\+)API(\\s|\\+)Request',
                              95 => 'findlinks',
                              96 => 'findthatfile',
                              97 => '^FileDown$',
                              98 => '^Filter$',
                              99 => '^firefox$',
                              100 => '^FOCA',
                              101 => 'Fulltext',
                              102 => 'Funnelback',
                              103 => 'Genieo',
                              104 => 'GetRight',
                              105 => 'geturl',
                              106 => 'GigablastOpenSource',
                              107 => 'G-i-g-a-b-o-t',
                              108 => 'GLMSLinkAnalysis',
                              109 => 'Goldfire(\\s|\\+)Server',
                              110 => 'google',
                              111 => 'Grammarly',
                              112 => 'grub',
                              113 => 'gulliver',
                              114 => 'gvfs\\/',
                              115 => 'harvest',
                              116 => 'heritrix',
                              117 => 'holmes',
                              118 => 'htdig',
                              119 => 'htmlparser',
                              120 => 'HttpComponents\\/1.1',
                              121 => 'HTTPFetcher',
                              122 => 'http.?client',
                              123 => 'httpget',
                              124 => 'httrack',
                              125 => 'ia_archiver',
                              126 => 'ichiro',
                              127 => 'iktomi',
                              128 => 'ilse',
                              129 => 'Indy Library',
                              130 => '^integrity\\/\\d',
                              131 => 'internetseer',
                              132 => 'intute',
                              133 => 'iSiloX',
                              134 => 'iskanie',
                              135 => '^java\\/\\d{1,2}.\\d',
                              136 => 'jeeves',
                              137 => 'Jersey\\/\\d',
                              138 => 'jobo',
                              139 => 'kyluka',
                              140 => 'larbin',
                              141 => 'libcurl',
                              142 => 'libhttp',
                              143 => 'libwww',
                              144 => 'lilina',
                              145 => '^LinkAnalyser',
                              146 => 'link.?check',
                              147 => 'LinkLint-checkonly',
                              148 => '^LinkParser\\/',
                              149 => '^LinkSaver\\/',
                              150 => 'linkscan',
                              151 => 'LinkTiger',
                              152 => 'linkwalker',
                              153 => 'lipperhey',
                              154 => 'livejournal\\.com',
                              155 => 'LOCKSS',
                              156 => 'LongURL.API',
                              157 => 'ltx71',
                              158 => 'lwp',
                              159 => 'lycos[_+]',
                              160 => 'mail.ru',
                              161 => 'MarcEdit',
                              162 => 'mediapartners-google',
                              163 => 'megite',
                              164 => 'MetaURI[\\+\\s]API\\/\\d\\.\\d',
                              165 => 'Microsoft(\\s|\\+)URL(\\s|\\+)Control',
                              166 => 'Microsoft Office Existence Discovery',
                              167 => 'Microsoft Office Protocol Discovery',
                              168 => 'Microsoft-WebDAV-MiniRedir',
                              169 => 'mimas',
                              170 => 'mnogosearch',
                              171 => 'moget',
                              172 => 'motor',
                              173 => '^Mozilla$',
                              174 => '^Mozilla.4\\.0$',
                              175 => '^Mozilla\\/4\\.0\\+\\(compatible;\\)$',
                              176 => '^Mozilla\\/4\\.0\\+\\(compatible;\\+ICS\\)$',
                              177 => '^Mozilla\\/4\\.5\\+\\[en]\\+\\(Win98;\\+I\\)$',
                              178 => '^Mozilla.5\\.0$',
                              179 => '^Mozilla\\/5.0\\+\\(compatible;\\+MSIE\\+6\\.0;\\+Windows\\+NT\\+5\\.0\\)$',
                              180 => '^Mozilla\\/5\\.0\\+like\\+Gecko$',
                              181 => '^Mozilla\\/5.0(\\s|\\+)Gecko\\/20100115(\\s|\\+)Firefox\\/3.6$',
                              182 => '^MSIE',
                              183 => 'MuscatFerre',
                              184 => 'myweb',
                              185 => 'nagios',
                              186 => '^NetAnts\\/\\d',
                              187 => 'netcraft',
                              188 => 'netluchs',
                              189 => 'ng\\/2\\.',
                              190 => '^Ning\\/\\d',
                              191 => 'no_user_agent',
                              192 => 'nomad',
                              193 => 'nutch',
                              194 => '^oaDOI$',
                              195 => 'ocelli',
                              196 => 'Offline(\\s|\\+)Navigator',
                              197 => 'OgScrper',
                              198 => '^okhttp$',
                              199 => 'onetszukaj',
                              200 => '^Opera\\/4$',
                              201 => 'OurBrowser',
                              202 => 'panscient',
                              203 => 'parsijoo',
                              204 => 'Pcore-HTTP',
                              205 => 'pear.php.net',
                              206 => 'perman',
                              207 => 'PHP\\/',
                              208 => 'pidcheck',
                              209 => 'pioneer',
                              210 => 'playmusic\\.com',
                              211 => 'playstarmusic\\.com',
                              212 => '^Postgenomic(\\s|\\+)v2',
                              213 => 'powermarks',
                              214 => 'proximic',
                              215 => 'PycURL',
                              216 => 'python',
                              217 => 'Qwantify',
                              218 => 'rambler',
                              219 => 'ReactorNetty\\/\\d',
                              220 => 'Readpaper',
                              221 => 'redalert',
                              222 => 'Riddler',
                              223 => 'robozilla',
                              224 => 'rss',
                              225 => 'scan4mail',
                              226 => 'scientificcommons',
                              227 => 'scirus',
                              228 => 'scooter',
                              229 => 'Scrapy\\/\\d',
                              230 => 'ScoutJet',
                              231 => '^scrutiny\\/\\d',
                              232 => 'SearchBloxIntra',
                              233 => 'shoutcast',
                              234 => 'SkypeUriPreview',
                              235 => 'slurp',
                              236 => 'sogou',
                              237 => 'speedy',
                              238 => 'Strider',
                              239 => 'summify',
                              240 => 'sunrise',
                              241 => 'Sysomos',
                              242 => 'T\\-H\\-U\\-N\\-D\\-E\\-R\\-S\\-T\\-O\\-N\\-E',
                              243 => 'tailrank',
                              244 => 'Teleport(\\s|\\+)Pro',
                              245 => 'Teoma',
                              246 => 'The\\+Knowledge\\+AI',
                              247 => 'titan',
                              248 => '^Traackr\\.com$',
                              249 => 'Trove',
                              250 => 'twiceler',
                              251 => 'ucsd',
                              252 => 'ultraseek',
                              253 => '^undefined$',
                              254 => '^unknown$',
                              255 => 'Unpaywall',
                              256 => 'URL2File',
                              257 => 'urlaliasbuilder',
                              258 => 'urllib',
                              259 => '^user.?agent$',
                              260 => '^User-Agent',
                              261 => 'validator',
                              262 => 'virus.detector',
                              263 => 'voila',
                              264 => '^voltron$',
                              265 => 'voyager\\/',
                              266 => 'w3af.org',
                              267 => 'Wanadoo',
                              268 => 'Web(\\s|\\+)Downloader',
                              269 => 'WebCloner',
                              270 => 'webcollage',
                              271 => 'WebCopier',
                              272 => 'Webinator',
                              273 => 'weblayers',
                              274 => 'Webmetrics',
                              275 => 'webmirror',
                              276 => 'webmon',
                              277 => 'weborama-fetcher',
                              278 => 'webreaper',
                              279 => 'WebStripper',
                              280 => 'WebZIP',
                              281 => 'Wget',
                              282 => 'wordpress',
                              283 => 'worm',
                              284 => 'www\\.gnip\\.com',
                              285 => 'WWW-Mechanize',
                              286 => 'xenu',
                              287 => 'y!j',
                              288 => 'yacy',
                              289 => 'yahoo',
                              290 => 'yandex',
                              291 => 'Yeti\\/\\d',
                              292 => 'zeus',
                              293 => 'zyborg',
                            );
                            $bannbots[] = 'crawler\\.infotiger\\.com';

                            foreach($bannbots AS $ban) {
                                if (preg_match('/'.$ban.'/i', $useragent, $m)) {
                                    $found = 1;
                                    if ($debug) { $serendipity['logger']->debug("L_".__LINE__.":: $logtag FoundBot[useragent]: $ban - $useragent"); }
                                    break;
                                }
                            }
                        }

                        if ($found == 0){
                            $this->countVisitor($useragent, $remoteaddr, $referer);
                        }
                    } else {
                        // Update visitor timestamp
                        $this->updateVisitor();
                    }
                    break;

                case 'css_backend':
                    $eventData .= '

/* serendipity_event_statistics BACKEND START */

.serendipity_statistics table {
    background: #eaeaea;
    background-image: -webkit-linear-gradient(#fff, #eaeaea);
    background-image: linear-gradient(#fff, #eaeaea);
    border-color: #ddd #bbb #999;
    color: #222;
    text-shadow: #fff 0 1px 1px;
    width: 100%;
}
[data-color-mode="dark"] .serendipity_statistics table {
    background-image: linear-gradient(var(--color-auto-gray-4), var(--color-auto-gray-1));
    color: var(--color-text-primary);
    text-shadow: none;
}
.stats_imagecell, .stats_imagecell img {
    vertical-align: bottom;
}
#statistics_yearbox table tr:nth-child(4) td {
  color: #533753;
  text-shadow: 1px 2px 3px #bbb;
}
[data-color-mode="dark"] #statistics_yearbox table tr:nth-child(4) td {
  color: var(--color-counter-text);
  text-shadow: none;
}
.stats_imagecell .co_mo img {
  background-image: linear-gradient(#666, #aaa);
}
[data-color-mode="dark"] .stats_imagecell .co_mo img {
  /*transform: scaleY(-1);*/
  background-image: linear-gradient(var(--color-auto-gray-8), var(--color-auto-gray-3));
}
.stats_header {
    width: auto;
    display: block;
    background: #eee;
}
.stats_header span {
    text-align: right;
    width: 50%;
    float: right;
}
[data-color-mode="dark"] .stats_header {
    background-color: var(--color-bg-overlay);
}
.serendipity_statistics .wide_box dl {
    clear: left;
    display: table;
    width: 100%;
}
.serendipity_statistics .wide_box dt {
    display: table-row;
}
.serendipity_statistics .wide_box dd {
    margin-left: 0;
    padding: 0px 0.5em 0.5em 0;
}
.serendipity_statistics .serendipityReferer {
    margin: 1em 0;
    display: inline-block;
}
.serendipity_statistics .serendipityReferer span.block_level {
    display: flow-root list-item;
    list-style: symbols;
    margin-left: 2em;
}
@media only screen and (min-width: 768px) {
  .serendipity_statistics:not(.extended_statistics) {
    display: block;
    width: 98%;
    column-count: 2;
    column-gap: 1em;
  }
  .serendipity_statistics:not(.extended_statistics) > section {
    float: none;
    clear: left;
    margin: auto auto 1.5em auto;
    width: auto;
    break-inside: avoid;
  }
}

/* serendipity_event_statistics BACKEND STOP */

';
                    break;

                case 'backend_sidebar_admin_appearance':
?>
                        <li><a id="#plugin_stats" href="?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=statistics"><?php echo PLUGIN_EVENT_STATISTICS_NAME; ?></a></li>
<?php
                    break;

                case 'backend_sidebar_entries_event_display_statistics':
                    $max_items    = $this->get_config('max_items');
                    $ext_vis_stat = $this->get_config('ext_vis_stat');

                    if (!$max_items || !is_numeric($max_items) || $max_items < 1) {
                        $max_items = 20;
                    }

                    if ($ext_vis_stat == 'yesTop') {
                        $this->extendedVisitorStatistics($max_items);
                    }

                    if ($this->get_config('stat_all') == 'yes') {
                        $first_entry    = serendipity_db_query("SELECT timestamp FROM {$serendipity['dbPrefix']}entries ORDER BY timestamp ASC limit 1", true);
                        $last_entry     = serendipity_db_query("SELECT timestamp FROM {$serendipity['dbPrefix']}entries ORDER BY timestamp DESC limit 1", true);
                        $total_count    = serendipity_db_query("SELECT count(id) FROM {$serendipity['dbPrefix']}entries", true);
                        $draft_count    = serendipity_db_query("SELECT count(id) FROM {$serendipity['dbPrefix']}entries WHERE isdraft = 'true'", true);
                        $publish_count  = serendipity_db_query("SELECT count(id) FROM {$serendipity['dbPrefix']}entries WHERE isdraft = 'false'", true);
                        $author_rows    = serendipity_db_query("SELECT author, count(author) AS entries FROM {$serendipity['dbPrefix']}entries GROUP BY author ORDER BY author");
                        $category_count = serendipity_db_query("SELECT count(categoryid) FROM {$serendipity['dbPrefix']}category", true);
                        $cat_sql        = "SELECT c.category_name, count(e.id) AS postings
                                                        FROM {$serendipity['dbPrefix']}entrycat ec,
                                                             {$serendipity['dbPrefix']}category c,
                                                             {$serendipity['dbPrefix']}entries e
                                                        WHERE ec.categoryid = c.categoryid AND ec.entryid = e.id
                                                        GROUP BY ec.categoryid, c.category_name
                                                        ORDER BY postings DESC";
                        $category_rows  = serendipity_db_query($cat_sql);

                        $image_count = serendipity_db_query("SELECT count(id) FROM {$serendipity['dbPrefix']}images", true);
                        $image_rows  = serendipity_db_query("SELECT extension, count(id) AS images FROM {$serendipity['dbPrefix']}images GROUP BY extension ORDER BY images DESC");

                        $subscriber_count = serendipity_db_query("SELECT count(id) FROM {$serendipity['dbPrefix']}comments WHERE type = 'NORMAL' AND subscribed = 'true' GROUP BY email", true);
                        $subscriber_rows  = serendipity_db_query("SELECT e.timestamp, e.id, e.title, count(c.id) AS postings
                                                        FROM {$serendipity['dbPrefix']}comments c,
                                                             {$serendipity['dbPrefix']}entries e
                                                        WHERE e.id = c.entry_id AND type = 'NORMAL' AND subscribed = 'true'
                                                        GROUP BY e.id, c.email, e.title, e.timestamp
                                                        ORDER BY postings DESC
                                                        LIMIT $max_items");

                        $comment_count = serendipity_db_query("SELECT count(id) FROM {$serendipity['dbPrefix']}comments WHERE type = 'NORMAL'", true);
                        $comment_rows  = serendipity_db_query("SELECT e.timestamp, e.id, e.title, count(c.id) AS postings
                                                        FROM {$serendipity['dbPrefix']}comments c,
                                                             {$serendipity['dbPrefix']}entries e
                                                        WHERE e.id = c.entry_id AND type = 'NORMAL'
                                                        GROUP BY e.id, e.title, e.timestamp
                                                        ORDER BY postings DESC
                                                        LIMIT $max_items");

                        $commentor_rows = serendipity_db_query("SELECT author, max(email) AS email, max(url) AS url, count(id) AS postings
                                                        FROM {$serendipity['dbPrefix']}comments c
                                                        WHERE type = 'NORMAL'
                                                        GROUP BY author
                                                        ORDER BY postings DESC
                                                        LIMIT $max_items");

                        $tb_count = serendipity_db_query("SELECT count(id) FROM {$serendipity['dbPrefix']}comments WHERE type = 'TRACKBACK'", true);
                        $tb_rows  = serendipity_db_query("SELECT e.timestamp, e.id, e.title, count(c.id) AS postings
                                                        FROM {$serendipity['dbPrefix']}comments c,
                                                             {$serendipity['dbPrefix']}entries e
                                                        WHERE e.id = c.entry_id AND type = 'TRACKBACK'
                                                        GROUP BY e.timestamp, e.id, e.title
                                                        ORDER BY postings DESC
                                                        LIMIT $max_items");

                        $tbr_rows = serendipity_db_query("SELECT author, max(email) AS email, max(url) AS url, count(id) AS postings
                                                        FROM {$serendipity['dbPrefix']}comments c
                                                        WHERE type = 'TRACKBACK'
                                                        GROUP BY author
                                                        ORDER BY postings DESC
                                                        LIMIT $max_items");

                        $length      = serendipity_db_query("SELECT SUM(LENGTH(body) + LENGTH(extended)) FROM {$serendipity['dbPrefix']}entries", true);
                        $length_rows = serendipity_db_query("SELECT id, title, timestamp, (LENGTH(body) + LENGTH(extended)) AS full_length
                                                        FROM {$serendipity['dbPrefix']}entries
                                                        ORDER BY full_length
                                                        DESC LIMIT $max_items");

                        if (is_bool($first_entry)) {
                            $first_entry = [];
                        }
                        if (is_bool($last_entry)) {
                            $last_entry = [];
                        }
                        $first_entry[0] = $first_entry[0] ?? 0; // init
                        $last_entry[0] = $last_entry[0] ?? 0; // ditto
?>
    <h2><?php echo PLUGIN_EVENT_STATISTICS_OUT_STATISTICS; ?></h2>

    <div class="serendipity_statistics clearfix">
        <section>
            <h3><?php echo ENTRIES; ?></h3>

            <dl>
                <dt><?php echo PLUGIN_EVENT_STATISTICS_OUT_FIRST_ENTRY; ?></dt>
                <dd><?php echo serendipity_formatTime(DATE_FORMAT_ENTRY . ' %H:%m', $first_entry[0]); ?></dd>
                <dt><?php echo PLUGIN_EVENT_STATISTICS_OUT_LAST_ENTRY; ?></dt>
                <dd><?php echo serendipity_formatTime(DATE_FORMAT_ENTRY . ' %H:%m', $last_entry[0]); ?></dd>
                <dt><?php echo PLUGIN_EVENT_STATISTICS_OUT_TOTAL_ENTRIES; ?></dt>
                <dd><?php echo $total_count[0]; ?> <?php echo PLUGIN_EVENT_STATISTICS_OUT_ENTRIES; ?>
                    <dl>
                        <dt><?php echo PLUGIN_EVENT_STATISTICS_OUT_TOTAL_PUBLIC; ?></dt>
                        <dd><?php echo $publish_count[0]; ?> <?php echo PLUGIN_EVENT_STATISTICS_OUT_ENTRIES; ?></dd>
                        <dt><?php echo PLUGIN_EVENT_STATISTICS_OUT_TOTAL_DRAFTS; ?></dt>
                        <dd><?php echo ($draft_count[0] ?? 0); ?> <?php echo PLUGIN_EVENT_STATISTICS_OUT_ENTRIES; ?></dd>
                    </dl>
                </dd>
            </dl>
        </section>

        <section>
            <h3><?php echo PLUGIN_EVENT_STATISTICS_OUT_PER_AUTHOR; ?></h3>

            <dl>
<?php
                    if (is_array($author_rows)) {
                        foreach($author_rows AS $author => $author_stat) {
?>
                <dt><?php echo $author_stat['author']; ?></dt>
                <dd><?php echo $author_stat['entries']; ?> <?php echo PLUGIN_EVENT_STATISTICS_OUT_ENTRIES; ?> (<?php echo 100*round($author_stat['entries'] / max($total_count[0], 1), 3); ?>%)</dd>
<?php
                        }
                    }
?>
            </dl>
        </section>

        <section>
            <h3><?php echo PLUGIN_EVENT_STATISTICS_OUT_CATEGORIES; ?></h3>

            <p><?php echo ($category_count[0] ?? 0); ?> <?php echo PLUGIN_EVENT_STATISTICS_OUT_CATEGORIES2; ?></p>

            <h4><?php echo PLUGIN_EVENT_STATISTICS_OUT_DISTRIBUTION_CATEGORIES; ?></h4>

            <dl>
<?php
                    if (is_array($category_rows)) {
                        foreach($category_rows AS $category => $cat_stat) {
?>
                <dt><?php echo $cat_stat['category_name']; ?></dt>
                <dd><?php echo $cat_stat['postings']; ?> <?php echo PLUGIN_EVENT_STATISTICS_OUT_DISTRIBUTION_CATEGORIES2; ?></dd>
<?php
                        }
                    }
?>
            </dl>
        </section>

        <section>
            <h3><?php echo PLUGIN_EVENT_STATISTICS_OUT_UPLOADED_IMAGES; ?></h3>

            <p><?php echo ($image_count[0] ?? 0); ?> <?php echo PLUGIN_EVENT_STATISTICS_OUT_UPLOADED_IMAGES2; ?></p>

            <h4><?php echo PLUGIN_EVENT_STATISTICS_OUT_DISTRIBUTION_IMAGES; ?></h4>

            <dl>
<?php
                    if (is_array($image_rows)) {
                        foreach($image_rows AS $image => $image_stat) {
?>
                <dt><?php echo $image_stat['extension']; ?></dt>
                <dd><?php echo $image_stat['images']; ?> <?php echo PLUGIN_EVENT_STATISTICS_OUT_DISTRIBUTION_IMAGES2; ?></dd>
<?php
                        }
                    }
?>
            </dl>
        </section>

        <section>
            <h3><?php echo COMMENTS; ?></h3>

            <dl>
                <dt><?php echo PLUGIN_EVENT_STATISTICS_OUT_COMMENTS; ?></dt>
                <dd><?php echo ($comment_count[0] ?? 0); ?> <?php echo PLUGIN_EVENT_STATISTICS_OUT_COMMENTS2; ?></dd>
            </dl>

            <h4><?php echo PLUGIN_EVENT_STATISTICS_OUT_COMMENTS3; ?></h4>

            <dl>
<?php
                    if (is_array($comment_rows)) {
                        foreach($comment_rows AS $comment => $com_stat) {
?>
                <dt><a href="<?php echo serendipity_archiveURL($com_stat['id'], $com_stat['title'], 'serendipityHTTPPath', true, array('timestamp' => $com_stat['timestamp'])); ?>"><?php echo $com_stat['title']; ?></a></dt>
                <dd><?php echo $com_stat['postings']; ?> <?php echo PLUGIN_EVENT_STATISTICS_OUT_COMMENTS2; ?></dd>
<?php
                        }
                    }
?>
            </dl>
        </section>

        <section>
            <h3><?php echo PLUGIN_EVENT_STATISTICS_OUT_TOPCOMMENTS; ?></h3>

            <dl>
<?php
                    if (is_array($commentor_rows)) {
                        foreach($commentor_rows AS $comment => $com_stat) {
                            $link_start = '';
                            $link_end   = '';
                            $link_url   = '';

                            if (!empty($com_stat['email'])) {
                                $link_start = '<a href="mailto:' . serendipity_specialchars($com_stat['email']) . '">';
                                $link_end   = '</a>';
                            }

                            if (!empty($com_stat['url'])) {
                                if (substr($com_stat['url'], 0, 7) != 'http://' && substr($com_stat['url'], 0, 8) != 'https://') {
                                    $com_stat['url'] = 'http://' . $com_stat['url'];
                                }

                                $link_url = ' (<a href="' . serendipity_specialchars($com_stat['url']) . '">' . PLUGIN_EVENT_STATISTICS_OUT_LINK . '</a>)';
                            }

                            if (empty($com_stat['author'])) {
                                $com_stat['author'] = ANONYMOUS;
                            }
?>
                <dt><?php echo $link_start . $com_stat['author'] . $link_end . $link_url; ?> </dt>
                <dd><?php echo $com_stat['postings']; ?> <?php echo PLUGIN_EVENT_STATISTICS_OUT_COMMENTS2; ?></dd>
<?php
                        }
                    }
?>
            </dl>
        </section>

        <section>
            <h3><?php echo PLUGIN_EVENT_STATISTICS_OUT_SUBSCRIBERS; ?></h3>

            <p><?php echo ($subscriber_count[0] ?? 0); ?> <?php echo PLUGIN_EVENT_STATISTICS_OUT_SUBSCRIBERS2; ?></p>

            <h4><?php echo PLUGIN_EVENT_STATISTICS_OUT_TOPSUBSCRIBERS; ?></h4>

            <dl>
<?php
                    if (is_array($subscriber_rows)) {
                        foreach($subscriber_rows AS $subscriber => $subscriber_stat) {
?>
                <dt><a href="<?php echo serendipity_archiveURL($subscriber_stat['id'], $subscriber_stat['title'], 'serendipityHTTPPath', true, array('timestamp' => $subscriber_stat['timestamp'])); ?>"><?php echo $subscriber_stat['title']; ?></a></dt>
                <dd><?php echo $subscriber_stat['postings']; ?> <?php echo PLUGIN_EVENT_STATISTICS_OUT_TOPSUBSCRIBERS2; ?></dd>
<?php
                        }
                    }
?>
            </dl>
        </section>

        <section>
            <h3><?php echo PLUGIN_EVENT_STATISTICS_OUT_TRACKBACKS; ?></h3>

            <p><?php echo ($tb_count[0] ?? 0); ?> <?php echo PLUGIN_EVENT_STATISTICS_OUT_TRACKBACKS2; ?></p>

            <h4><?php echo PLUGIN_EVENT_STATISTICS_OUT_TOPTRACKBACK; ?></h4>

            <dl>
<?php
                    if (is_array($tb_rows)) {
                        foreach($tb_rows AS $tb => $tb_stat) {
?>
                <dt><a href="<?php echo serendipity_archiveURL($tb_stat['id'], $tb_stat['title'], 'serendipityHTTPPath', true, array('timestamp' => $tb_stat['timestamp'])); ?>"><?php echo $tb_stat['title']; ?></a></dt>
                <dd><?php echo $tb_stat['postings']; ?> <?php echo PLUGIN_EVENT_STATISTICS_OUT_TOPTRACKBACK2; ?></dd>
<?php
                        }
                    }
?>
            </dl>
        </section>

        <section>
            <h3><?php echo PLUGIN_EVENT_STATISTICS_OUT_TOPTRACKBACKS3; ?></h3>

            <dl>
<?php
                    if (is_array($tbr_rows)) {
                        foreach($tbr_rows AS $tb => $tb_stat) {
                            if (empty($tb_stat['author'])) {
                                $tb_stat['author'] = ANONYMOUS;
                            }
?>
                <dt><a href="<?php echo serendipity_specialchars($tb_stat['url']); ?>"><?php echo serendipity_specialchars($tb_stat['author']); ?></a></dt>
                <dd><?php echo $tb_stat['postings']; ?> <?php echo PLUGIN_EVENT_STATISTICS_OUT_TOPTRACKBACK2; ?></dd>
<?php
                        }
                    }
?>
            </dl>
        </section>

        <section>
            <h3><?php echo PLUGIN_EVENT_STATISTICS_OUT_AVERAGES; ?></h3>

            <dl>
                <dt><?php echo PLUGIN_EVENT_STATISTICS_OUT_COMMENTS_PER_ARTICLE; ?></dt>
                <dd><?php echo round($comment_count[0] / max($publish_count[0], 1), 2); ?> <?php echo PLUGIN_EVENT_STATISTICS_OUT_COMMENTS_PER_ARTICLE2; ?></dd>
                <dt><?php echo PLUGIN_EVENT_STATISTICS_OUT_TRACKBACKS_PER_ARTICLE; ?></dt>
                <dd><?php echo round($tb_count[0] / max($publish_count[0], 1), 2); ?> <?php echo PLUGIN_EVENT_STATISTICS_OUT_TRACKBACKS_PER_ARTICLE2; ?></dd>
                <dt><?php echo PLUGIN_EVENT_STATISTICS_OUT_ARTICLES_PER_DAY; ?></dt>
                <dd><?php echo round($publish_count[0] / ((time() - $first_entry[0]) / (60*60*24)), 2);?> <?php echo PLUGIN_EVENT_STATISTICS_OUT_ARTICLES_PER_DAY2; ?></dd>
                <dt><?php echo PLUGIN_EVENT_STATISTICS_OUT_ARTICLES_PER_WEEK; ?></dt>
                <dd><?php echo round($publish_count[0] / ((time() - $first_entry[0]) / (60*60*24*7)), 2);?> <?php echo PLUGIN_EVENT_STATISTICS_OUT_ARTICLES_PER_WEEK2; ?></dd>
                <dt><?php echo PLUGIN_EVENT_STATISTICS_OUT_ARTICLES_PER_MONTH; ?></dt>
                <dd><?php echo round($publish_count[0] / ((time() - $first_entry[0]) / (60*60*24*31)), 2);?> <?php echo PLUGIN_EVENT_STATISTICS_OUT_ARTICLES_PER_MONTH2; ?></dd>
                <dt><?php echo PLUGIN_EVENT_STATISTICS_OUT_CHARS; ?></dt>
                <dd><?php echo $length[0]; ?> <?php echo PLUGIN_EVENT_STATISTICS_OUT_CHARS2; ?></dd>
                <dt><?php echo PLUGIN_EVENT_STATISTICS_OUT_CHARS_PER_ARTICLE; ?></dt>
                <dd><?php echo round($length[0] / max($publish_count[0], 1), 2); ?> <?php echo PLUGIN_EVENT_STATISTICS_OUT_CHARS_PER_ARTICLE2; ?></dd>
            </dl>
        </section>

        <section>
            <h3><?php printf(PLUGIN_EVENT_STATISTICS_OUT_LONGEST_ARTICLES, $max_items); ?></h3>

            <dl>
<?php
                    if (is_array($length_rows)) {
                        foreach($length_rows AS $tb => $length_stat) {
?>
                <dt><a href="<?php echo serendipity_archiveURL($length_stat['id'], $length_stat['title'], 'serendipityHTTPPath', true, array('timestamp' => $length_stat['timestamp'])); ?>"><?php echo $length_stat['title']; ?></a></dt>
                <dd><?php echo $length_stat['full_length']; ?> <?php echo PLUGIN_EVENT_STATISTICS_OUT_CHARS2; ?></dd>
<?php
                        }
                    }
?>
            </dl>
        </section>

        <section>
            <h3><?php echo TOP_REFERRER; ?></h3>

            <?php echo serendipity_displayTopReferrers($max_items, true); ?>
        </section>

        <section>
            <h3><?php echo TOP_EXITS; ?></h3>

            <?php echo serendipity_displayTopExits($max_items, true); ?>
        </section>
    <?php serendipity_plugin_api::hook_event('event_additional_statistics', $eventData, array('maxitems' => $max_items)); ?>
    </div>
<?php
                    }

                    if ($ext_vis_stat == 'yesBot') {
                        $this->extendedVisitorStatistics($max_items);
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
     * Statistics
     */
    function updatestats($action)
    {
        global $serendipity;

        list($year, $month, $day) = explode('-', date('Y-m-d'));
        $sql = serendipity_db_query("SELECT COUNT(year) AS result FROM {$serendipity['dbPrefix']}visitors_count WHERE year='$year' AND month='$month' AND day='$day'", true);

        $sql_hit_update = "UPDATE {$serendipity['dbPrefix']}visitors_count SET hits = hits+1 WHERE year='$year' AND month='$month' AND day='$day'";
        $sql_day_new    = "INSERT INTO {$serendipity['dbPrefix']}visitors_count (year, month, day, visits, hits) VALUES ('$year','$month','$day',1,1)";
        $sql_day_update = "UPDATE {$serendipity['dbPrefix']}visitors_count SET visits = visits+1, hits = hits+1 WHERE year='$year' AND month='$month' AND day='$day'";

        switch($action) {
            case "update":
                if($sql['result'] >= 1) {
                    serendipity_db_query($sql_hit_update);
                } else {
                    serendipity_db_query($sql_day_new);
                }
                break;

            case "new":
                if($sql['result'] >= 1) {
                       serendipity_db_query($sql_day_update);
                } else {
                    serendipity_db_query($sql_day_new);
                }
                break;
        }
    }

    /**
     * Update Visitor Stats
     */
    function updateVisitor()
    {
        global $serendipity;

        $this->updatestats('update');

        $time = date('H:i');
        $day  = date('Y-m-d');
        return serendipity_db_query("UPDATE {$serendipity['dbPrefix']}visitors SET time = '$time', day = '$day' WHERE sessID = '" . serendipity_db_escape_string(strip_tags(session_id())) . "'");
    }

    /**
     * Count Visitor Stats
     */
    function countVisitor($useragent, $remoteaddr, $referer)
    {
        global $serendipity;

        $thedate = date('Y-m-d');
        $ip      = strip_tags($remoteaddr);
        $ip_how_often = serendipity_db_query("SELECT COUNT(ip) AS result FROM {$serendipity['dbPrefix']}visitors WHERE ip = '$ip' and day = '$thedate'", true);

        if ($ip_how_often['result'] >= 1) {
            $this->updatestats('update');
        } else {
            $this->updatestats('new');
        }
        $values = array(
            'sessID' => strip_tags(session_id()),
            'day'    => $thedate,
            'time'   => date('H:i'),
            'ref'    => strip_tags($referer),
            'browser'=> strip_tags($useragent),
            'ip'     => strip_tags($remoteaddr)
        );

        serendipity_db_insert('visitors', $values);

        // updating the referrer-table
        if (strlen($referer) >= 1) {

            // retrieving the referrer base URL
            $temp_array = explode('?', $referer);
            $urlA = $temp_array[0];

            // removing "http://" & trailing subdirectories
            $temp_array3 = explode('//', $urlA);
            $urlB = $temp_array3[1] ?? '';
            $temp_array4 = explode('/', $urlB);
            $urlB = $temp_array4[0];

            // removing www
            $urlC = serendipity_db_escape_string(str_replace('www.', '', $urlB));

            // if referer == 'unknown' $urlC is NULL
            if (is_null($urlC) || strlen($urlC) < 1) {
                $urlC = 'unknown';
            }

            // updating db
            $q = serendipity_db_query("SELECT count(refs) AS referrer FROM {$serendipity['dbPrefix']}refs WHERE refs = '$urlC' GROUP BY refs", true);
            if (isset($q['referrer']) && $q['referrer'] >= 1){
                serendipity_db_query("UPDATE {$serendipity['dbPrefix']}refs SET count=count+1 WHERE (refs = '$urlC')");
            } else {
                serendipity_db_query("INSERT INTO {$serendipity['dbPrefix']}refs (refs, count) VALUES ('$urlC', 1)");
            }
        }

    } // end of function countVisitor

    /**
     * Calculate a rolling year
     */
    function statistics_rollingYear()
    {
        $date = mktime(0, 0, 0, date('n'), 1);
        $months[] = [date('m', $date), date('Y', $date)];
        // get 24 months as 2 rolling years for comparison
        for($i = -1; $i >= -23; $i--) {
            list($year, $month) = explode('-', date('Y-m', strtotime($i.' month', $date)));
            $months[] = [$month, $year];
        }
        return $months;
    }

    /**
     * Calculate daily stats
     */
    function statistics_getdailystats()
    {
        global $serendipity;

        list($year, $month) = explode('-', date("Y-m"));
        $sql = "SELECT SUM(visits) AS dailyvisit FROM {$serendipity['dbPrefix']}visitors_count WHERE day";
        for ($i=1; $i<32; $i++)    {
            $myDay = ($i < 10) ? "0" . $i : $i;
            $sqlfire = $sql . " = '$myDay' AND year = '$year' AND month = '$month'";
            $res = serendipity_db_query($sqlfire, true);
            $container[$i] = $res['dailyvisit'];
        }
        return $container;
    }

    /**
     * Calculate monthly stats
     */
    function statistics_getmonthlystats()
    {
        global $serendipity;

        $i = 1;
        $sql = "SELECT SUM(visits) AS monthlyvisit FROM {$serendipity['dbPrefix']}visitors_count WHERE month";
        foreach ($this->statistics_rollingYear() AS $month) {
            $sqlfire = $sql . " = '$month[0]' AND year = '$month[1]'";
            $res = serendipity_db_query($sqlfire, true);
            $container[$i] = [$month[0], $res['monthlyvisit']];
            $i++;
        }
        return $container;
    }

    /**
     * Auto clean stats
     */
    private function autoCleanStats()
    {
        global $serendipity;

        $today = (date('Y')-1).'-'.date('m-d');
        serendipity_db_query("DELETE FROM {$serendipity['dbPrefix']}visitors WHERE day < '$today'", true);
    }

    /**
     * Helper method to get the percentage of the current rolling year highest MAX var
     * against the MAX var of the comparison year.
     */
    function percent($num, $total)
    {
        return number_format((100.0*$num)/$total, 2);
    }

    /**
     * Extend Visitor Statistics Sum-ups
     */
    function extendedVisitorStatistics($max_items)
    {
        global $serendipity;

        $debug = false;
        $logtag = 'PLUGIN_STATISTICS::';

        if (serendipity_db_bool($this->get_config('autoclean', 'true'))) {
            $this->autoCleanStats();
        }
        // ---------------QUERIES for Viewing statistics ----------------------------------------------
        $day = date('Y-m-d');
        list($year, $month, $day) = explode('-', $day);

        $visitors_count_firstday = serendipity_db_query("SELECT UNIX_TIMESTAMP(STR_TO_DATE(CONCAT(year,'-',month,'-',day), '%Y-%m-%d')) AS tdate FROM {$serendipity['dbPrefix']}visitors_count ORDER BY year, month, day ASC LIMIT 1", true);
        $visitors_count_today    = serendipity_db_query("SELECT visits FROM {$serendipity['dbPrefix']}visitors_count WHERE year = '$year' AND month = '$month' AND day = '$day'", true);
        $visitors_count_curryear = serendipity_db_query("SELECT SUM(visits) FROM {$serendipity['dbPrefix']}visitors_count WHERE year = '$year'", true);
        $visitors_count_lastyear = serendipity_db_query("SELECT SUM(visits) FROM {$serendipity['dbPrefix']}visitors_count WHERE year = '".($year-1)."'", true);
        $visitors_count_all      = serendipity_db_query("SELECT SUM(visits) FROM {$serendipity['dbPrefix']}visitors_count", true);
        $hits_count_today        = serendipity_db_query("SELECT hits FROM {$serendipity['dbPrefix']}visitors_count WHERE year = '$year' AND month = '$month' AND day = '$day'", true);
        $hits_count_curryear     = serendipity_db_query("SELECT SUM(hits) FROM {$serendipity['dbPrefix']}visitors_count WHERE year = '$year'", true);
        $hits_count_lastyear     = serendipity_db_query("SELECT SUM(hits) FROM {$serendipity['dbPrefix']}visitors_count WHERE year = '".($year-1)."'", true);
        $hits_count_all          = serendipity_db_query("SELECT SUM(hits) FROM {$serendipity['dbPrefix']}visitors_count", true);
        $visitors_latest         = serendipity_db_query("SELECT counter_id, day, time, ref, browser, ip FROM {$serendipity['dbPrefix']}visitors ORDER BY counter_id DESC LIMIT $max_items");
        $top_refs                = serendipity_db_query("SELECT refs, count FROM {$serendipity['dbPrefix']}refs ORDER BY count DESC LIMIT 20");
        ?>
        <h2><?php echo PLUGIN_EVENT_STATISTICS_OUT_EXT_STATISTICS; ?></h2>

        <div class="serendipity_statistics extended_statistics clearfix">
            <section>
                <h3><?php echo PLUGIN_EVENT_STATISTICS_EXT_VISITORS; ?></h3>

                <dl>
                    <dt><?php echo PLUGIN_EVENT_STATISTICS_EXT_VISTODAY; ?></dt>
                    <dd><?php echo $visitors_count_today[0]; ?></dd>
                    <dt><?php echo PLUGIN_EVENT_STATISTICS_EXT_VISCURYR; ?></dt>
                    <dd><?php echo $visitors_count_curryear[0]; ?></dd>
                    <dt><?php echo PLUGIN_EVENT_STATISTICS_EXT_VISLSTYR; ?></dt>
                    <dd><?php echo $visitors_count_lastyear[0]; ?></dd>
                    <dt><?php echo sprintf(PLUGIN_EVENT_STATISTICS_EXT_VISTOTAL, '<em>'.str_replace(' 00:00', '', serendipity_formatTime(DATE_FORMAT_SHORT, $visitors_count_firstday[0])).'</em>'); ?></dt>
                    <dd><?php echo $visitors_count_all[0]; ?></dd>
                    <dd>-------------------------------------
                        <a class="statistics_info toggle_info button_link" href="#statstics_countdesc" title="Statistics Count description Information">
                            <span class="icon-info-circled" aria-hidden="true"></span>
                            <span class="visuallyhidden"> Statistics Count description Information</span>
                        </a>
                    </dd>
                    <dt><?php echo PLUGIN_EVENT_STATISTICS_EXT_HITSTODAY; ?></dt>
                    <dd><?php echo $hits_count_today[0]; ?></dd>
                    <dt><?php echo PLUGIN_EVENT_STATISTICS_EXT_HITSCURYR; ?></dt>
                    <dd><?php echo $hits_count_curryear[0]; ?></dd>
                    <dt><?php echo PLUGIN_EVENT_STATISTICS_EXT_HITSLSTYR; ?></dt>
                    <dd><?php echo $hits_count_lastyear[0]; ?></dd>
                    <dt><?php echo sprintf(PLUGIN_EVENT_STATISTICS_EXT_HITSTOTAL, '<em>'.str_replace(' 00:00', '', serendipity_formatTime(DATE_FORMAT_SHORT, $visitors_count_firstday[0])).'</em>'); ?></dt>
                    <dd><?php echo $hits_count_all[0]; ?></dd>
                </dl>

                <footer id="statstics_countdesc" class="statistics_info additional_info">
                    <span class="msg_notice"><span class="icon-info-circled" aria-hidden="true"></span> <?php echo PLUGIN_EVENT_STATISTICS_EXT_COUNTDESC; ?></span>
                </footer>
            </section>

            <section>
                <h3><?php echo PLUGIN_EVENT_STATISTICS_EXT_TOPREFS; ?></h3>
        <?php
            if (is_array($top_refs)) {
                echo "<ol>\n";
                foreach($top_refs AS $key => $row) {
                    if ($row['refs'] == 'unknown') {
                        echo '<li>'.$row['refs'].' ('.$row['count'].")</li>\n";
                    } else {
                        echo '<li><a href="//'.$row['refs'].'" target="_blank" rel="noopener">'.$row['refs'].'</a> ('.$row['count'].")</li>\n";
                    }
                }
                echo "</ol>\n";
            } else {
                echo '<span class="msg_notice"><span class="icon-info-circled"></span> '.PLUGIN_EVENT_STATISTICS_EXT_TOPREFS_NONE."</span>\n";
            }
        ?>
            </section>

            <section id="statistics_yearbox" class="wide_box">
                <h3><?php echo PLUGIN_EVENT_STATISTICS_EXT_MONTHGRAPH;?> (<em>rolling year</em>)</h3>

        <?php if ($visitors_count_all[0] > 0) {
                $num = $this->statistics_getmonthlystats();
                // split out the added old comparison year from $num to a current_rolling_year ($cry) and a last_rolling_year ($lry)
                list($cry, $lry) = array_chunk($num, ceil(count($num) / 2));
            ?>
                <table>
                    <tbody>
                    <tr>
                        <th scope="row"><?php echo MONTHS; ?></th>
                <?php
                    foreach (array_reverse($cry) AS $month) {
                        echo '<td>' . serendipity_strftime('%b', mktime(0, 0, 0, $month[0], 1, 2000)) . "</td>\n";
                    }
                ?>
                    </tr>
                    <tr>
                        <th scope="row">Visits</th>
                <?php
                    foreach (array_reverse($cry) AS $visits) {
                        echo '<td>' . $visits[1] . "</td>\n";
                    }
                ?>
                    </tr>
                    <tr>
                        <th scope="row">+/~/-</th>
                <?php
                    foreach (array_reverse($cry) AS $r) {
                        $rep[(int)$r[0]] = $r[1]; // flatten array for max
                    }
                    $max = max(array_values($rep)); // Get the highest entry visitor stat

                    foreach (array_reverse($lry) AS $r) {
                        $rep2[(int)$r[0]] = $r[1]; // flatten array for max2
                    }
                    $max2 = max(array_values($rep2)); // Get the highest entry visitor stat
                    $max2 = $max2 ?? 1; // avoids Division by Zero error and further on issues with empty $lry[1}

                    // merge old current year sums into the current rolling year array as an additional key 2
                    $combined = [];
                    foreach($cry as $key=>$val){
                        $combined[$key] = $val + [2 => $lry[$key][1]];
                    }

                    $perc = @round($this->percent($max2, $max));
                    $maxVisHeigh = 100/$max*2;
                    $maxVisHeighex = $perc/$max2*2;

                    foreach (array_reverse($combined) AS $n) {
                        $monthHeight = @round($n[1]*$maxVisHeigh);
                        $mhex = @round($n[2]*$maxVisHeighex);
                        $numCountInt = @($n[1]*$maxVisHeigh/2);
                        echo '<td class="stats_imagecell">
                                <span class="co_mo"><img src="plugins/serendipity_event_statistics/gray.png" title="'.$n[2].'" width="8" height="'.$mhex.'" style="height:'.$mhex.'px" alt="o" /></span>
                                <span class="di_ff"><img src="plugins/serendipity_event_statistics/transparent.png" width="8" height="200" style="height:200px" alt="°" /></span>
                                <span class="cu_mo"><img src="plugins/serendipity_event_statistics/';
                        if ($numCountInt <= 33) {
                            echo 'red.png';
                        } else if ($numCountInt > 33 && $numCountInt < 66) {
                            echo 'yellow.png';
                        } else {
                            echo 'green.png';
                        }
                        echo '" title="'.$n[1].'" width="8" height="'.$monthHeight.'" style="height:'.$monthHeight.'px" alt="';
                        if ($numCountInt <= 33) {
                            echo '-';
                        } else if ($numCountInt > 33 && $numCountInt < 66) {
                            echo '~';
                        } else {
                            echo '+';
                        }
                        echo '" /></span>
                            </td>'."\n";
                    }
                ?>
                    </tr>
                <?php
                    if ($maxVisHeighex > 0) {
                ?>
                    <tr>
                        <th scope="row">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-calendar4-range" viewBox="0 0 16 16">
                              <title>Gray scaled Visits -1 year in past for comparison</title>
                              <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM2 2a1 1 0 0 0-1 1v1h14V3a1 1 0 0 0-1-1H2zm13 3H1v9a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V5z"/>
                              <path d="M9 7.5a.5.5 0 0 1 .5-.5H15v2H9.5a.5.5 0 0 1-.5-.5v-1zm-2 3v1a.5.5 0 0 1-.5.5H1v-2h5.5a.5.5 0 0 1 .5.5z"/>
                            </svg>
                        </th>
                <?php
                    }
                    foreach (array_reverse($lry) AS $visits) {
                        echo '<td>' . $visits[1] . "</td>\n";
                    }
                ?>
                    </tr>
                    </tbody>
                </table>
        <?php } ?>
            </section>

            <section class="wide_box">
                <h3><?php echo PLUGIN_EVENT_STATISTICS_EXT_DAYGRAPH;?></h3>

        <?php if ($visitors_count_all[0] > 0) { ?>
                <table>
                    <tbody>
                    <tr>
                        <th scope="row"><?php echo DAYS; ?></th>
                <?php
                    for ($i=1; $i < 32; $i++) {
                        echo '<td>'. $i ."</td>\n";
                    }
                ?>
                    </tr>
                    <tr>
                        <th scope="row">Visits</th>
                <?php
                    $num = $this->statistics_getdailystats();
                    for ($i=1; $i < 32; $i++) {
                        echo '<td>' . $num[$i] . "</td>\n";
                    }
                ?>
                    </tr>
                    <tr>
                        <th scope="row">+/~/-</th>
                <?php
                    $rep = $num;
                    rsort($rep); // Now $ret[0] is the highest max vis height

                    for ($i=1; $i < 32; $i++) {
                        $maxVisHeigh = 100/$rep[0]*2;
                        $dailyHeight = @round($num[$i]*$maxVisHeigh);
                        $numCountInt = @($num[$i]*$maxVisHeigh/2);
                        echo '<td class="stats_imagecell"><img src="plugins/serendipity_event_statistics/';
                        if ($numCountInt <= 33) {
                            echo 'red.png';
                        } else if ($numCountInt > 33 && $numCountInt < 66) {
                            echo 'yellow.png';
                        } else {
                            echo 'green.png';
                        }
                        echo '" width="8" height="'.$dailyHeight.'" style="height:'.$dailyHeight.'px" alt="';
                        if ($numCountInt <= 33) {
                            echo '-';
                        } else if ($numCountInt > 33 && $numCountInt < 66) {
                            echo '~';
                        } else {
                            echo '+';
                        }
                        echo '" /></td>'."\n";
                    }
                ?>
                    </tr>
                </table>
        <?php } ?>
            </section>

            <section class="wide_box">
                <h3><?php echo PLUGIN_EVENT_STATISTICS_EXT_VISLATEST;?> (TZ <?=date('e')?>)</h3>

                <dl>
<?php
    $checkdns = serendipity_db_bool($this->get_config('gethostbyaddr', 'true'));
    if (is_array($visitors_latest)) {
        $address = [];
        foreach ($visitors_latest AS $key => $row) {
            if ($checkdns && !in_array($row['ip'], $address)) {
                $address[$row['ip']] = gethostbyaddr($row['ip']);
            }
            echo '    <dt class="stats_header">'.$row['day'].' ('.$row['time'].')';
            echo $checkdns ? '<span>' . ($address[$row['ip']] ?? '-') . '</span>' : '<span>' . $row['ip'] . '</span>';
            echo "</dt>\n";

            if ($row['ref'] != 'unknown') {
                echo "    <dd><a href=\"{$row['ref']}\">{$row['ref']}</a></dd>\n";
            }
            if ($row['ref'] == 'unknown') {
                echo '    <dd>'.$row['ref']."</dd>\n";
            }
            echo '    <dd>'.$row['browser']."</dd>\n";
        }
        if ($debug) { $serendipity['logger']->debug("L_".__LINE__.":: $logtag CACHED IP DNS check for last_visitors [20] array ".print_r($address,true)); }
    }
?>
                </dl>
            </section>
        </div>
<?php
    } //end of function extendedVisitorStatistics()

    /**
     * Install tables
     */
    function createTables()
    {
        global $serendipity;

        // create table xxxx_visitors
        $q   = "CREATE TABLE {$serendipity['dbPrefix']}visitors (
            counter_id {AUTOINCREMENT} {PRIMARY},
            sessID varchar(35) not null default '',
            day varchar(10) not null default '',
            time varchar(5) not null default '',
            ref varchar(255) default null,
            browser varchar(255) default null,
            ip varchar(45) default null
        )";

       serendipity_db_schema_import($q);

        // create table xxxx_visitors_counts
        $q   = "CREATE TABLE {$serendipity['dbPrefix']}visitors_count (
            year int(4) not null,
            month int(2) not null,
            day int(2) not null,
            visits int(11) not null,
            hits int(11) not null
        )";

       serendipity_db_schema_import($q);

        // create table xxxx_refs
        $q   = "CREATE TABLE {$serendipity['dbPrefix']}refs (
            id {AUTOINCREMENT} {PRIMARY},
            refs varchar(255) not null default '',
            count int(11) not null default '0'
        )";
        serendipity_db_schema_import($q);

        $this->updateTables();
    }

    /**
     * Update tables
     */
    function updateTables($dbic=0)
    {
        global $serendipity;

        if ($dbic == 0) {
            // create indices
            $q = "CREATE INDEX visitorses ON {$serendipity['dbPrefix']}visitors (sessID);";
            serendipity_db_schema_import($q);
            $q = "CREATE INDEX visitorday ON {$serendipity['dbPrefix']}visitors (day);";
            serendipity_db_schema_import($q);
            $q = "CREATE INDEX visitortime ON {$serendipity['dbPrefix']}visitors (time);";
            serendipity_db_schema_import($q);
            $q = "CREATE INDEX visitortimeb ON {$serendipity['dbPrefix']}visitors_count (year, month, day);";
            serendipity_db_schema_import($q);
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
                        $q = "CREATE INDEX refsrefs ON {$serendipity['dbPrefix']}refs (refs);";
                    } elseif (version_compare($db_version_match[0], '10.3.0', '>=')) {
                        $q = "CREATE INDEX refsrefs ON {$serendipity['dbPrefix']}refs (refs(250));"; // max key 1000 bytes
                    } else {
                        $q = "CREATE INDEX refsrefs ON {$serendipity['dbPrefix']}refs (refs(191));"; // 191 - old MyISAMs
                    }
                } else {
                    // Oracle MySQL - https://dev.mysql.com/doc/refman/5.7/en/innodb-limits.html
                    if (version_compare($db_version_match[0], '5.7.7', '>=')) {
                        $q = "CREATE INDEX refsrefs ON {$serendipity['dbPrefix']}refs (refs);"; // Oracle Mysql/InnoDB max key up to 3072 bytes
                    } else {
                        $q = "CREATE INDEX refsrefs ON {$serendipity['dbPrefix']}refs (refs(191));"; // Oracle Mysql/InnoDB max key 767 bytes
                    }
                }
            } else {
                $q = "CREATE INDEX refsrefs ON {$serendipity['dbPrefix']}refs (refs);";
            }
            serendipity_db_schema_import($q);
            $q = "CREATE INDEX refscount ON {$serendipity['dbPrefix']}refs (count);";
            serendipity_db_schema_import($q);

            // Create first visitors entry for DB back-check on install
            $this->updateVisitor();

            $this->set_config('db_indices_created', '2');
        }

        if ($dbic == 1) {
            if (preg_match('@(postgres|pgsql)@i', $serendipity['dbType'])) {
                $q = "ALTER TABLE {$serendipity['dbPrefix']}visitors ALTER COLUMN ip TYPE VARCHAR(45)";
            } else {
                $q = "ALTER TABLE {$serendipity['dbPrefix']}visitors CHANGE COLUMN ip ip VARCHAR(45)";
            }
            serendipity_db_schema_import($q);

            $this->set_config('db_indices_created', '2');
        }
    }

    /**
     * Drop tables
     */
    function dropTables()
    {
        global $serendipity;

        // Drop tables
        $q   = "DROP TABLE ".$serendipity['dbPrefix']."visitors";
        $sql = serendipity_db_schema_import($q);
        $q   = "DROP TABLE ".$serendipity['dbPrefix']."visitors_count";
        $sql = serendipity_db_schema_import($q);
        $q   = "DROP TABLE ".$serendipity['dbPrefix']."refs";
        $sql = serendipity_db_schema_import($q);

    }

    /**
     * API
     */
    function install()
    {
        $this->createTables();
    }

    /**
     * API
     */
    function uninstall(&$propbag)
    {
        $this->dropTables();
    }

}

/* vim: set sts=4 ts=4 expandtab : */
?>