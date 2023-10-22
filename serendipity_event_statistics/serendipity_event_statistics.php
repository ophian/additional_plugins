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
        $propbag->add('version',       '4.0.1');
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
                             * [ last checked 2023-10-18 10:59 MEZ ]
                             * Official list of user agents that are regarded as robots/spiders by Project COUNTER (https://www.projectcounter.org/)
                             * https://github.com/atmire/COUNTER-Robots/blob/master/generated/COUNTER_Robots_list.txt
                             * $array = explode("\n", file_get_contents(dirname(__FILE__).'/botlist.txt'));
                             * echo '<pre>'.var_export($array,true).'</pre>';
                             * $x = array_diff($new, $bannbots);
                             * echo '<pre>'.var_export($x,true).'</pre>'; // ATTEND this removes double backslash to single backslash
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
                              9 => '^脝脝陆芒潞贸碌脛$',
                              10 => '^破解后的$',
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
                              29 => 'axios\\/\\d',
                              30 => 'BDFetch',
                              31 => 'Betsie',
                              32 => 'baidu',
                              33 => 'biglotron',
                              34 => 'BingPreview',
                              35 => 'binlar',
                              36 => 'bjaaland',
                              37 => 'Blackboard[\\+\\s]Safeassign',
                              38 => 'blaiz-bee',
                              39 => 'bloglines',
                              40 => 'blogpulse',
                              41 => 'boitho\\.com-dc',
                              42 => 'bookmark-manager',
                              43 => 'Brutus\\/AET',
                              44 => 'BUbiNG',
                              45 => 'bwh3_user_agent',
                              46 => 'CakePHP',
                              47 => 'celestial',
                              48 => 'cfnetwork',
                              49 => 'checklink',
                              50 => 'checkprivacy',
                              51 => 'China\\sLocal\\sBrowse\\s2\\.6',
                              52 => 'Citoid',
                              53 => 'cloakDetect',
                              54 => 'coccoc\\/1\\.0',
                              55 => 'Code\\sSample\\sWeb\\sClient',
                              56 => 'ColdFusion',
                              57 => 'collection@infegy.com',
                              58 => 'com\\.plumanalytics',
                              59 => 'combine',
                              60 => 'contentmatch',
                              61 => 'ContentSmartz',
                              62 => 'convera',
                              63 => 'core',
                              64 => 'Cortana',
                              65 => 'CoverScout',
                              66 => 'crusty\\/\\d',
                              67 => 'curl\\/',
                              68 => 'cursor',
                              69 => 'custo',
                              70 => 'DataCha0s\\/2\\.0',
                              71 => 'daum(oa)?',
                              72 => '^\\%?default\\%?$',
                              73 => 'DeuSu\\/',
                              74 => 'Dispatch\\/\\d',
                              75 => 'Docoloc',
                              76 => 'docomo',
                              77 => 'Download\\+Master',
                              78 => 'Drupal',
                              79 => 'DSurf',
                              80 => 'DTS Agent',
                              81 => 'EasyBib[\\+\\s]AutoCite[\\+\\s]',
                              82 => 'easydl',
                              83 => 'EBSCO\\sEJS\\sContent\\sServer',
                              84 => 'EcoSearch',
                              85 => 'ELinks\\/',
                              86 => 'EmailSiphon',
                              87 => 'EmailWolf',
                              88 => 'Embedly',
                              89 => 'EThOS\\+\\(British\\+Library\\)',
                              90 => 'facebookexternalhit\\/',
                              91 => 'favorg',
                              92 => 'Faveeo\\/\\d',
                              93 => 'FDM(\\s|\\+)\\d',
                              94 => 'Feedbin',
                              95 => 'feedburner',
                              96 => 'FeedFetcher',
                              97 => 'feedreader',
                              98 => 'ferret',
                              99 => 'Fetch(\\s|\\+)API(\\s|\\+)Request',
                              100 => 'findlinks',
                              101 => 'findthatfile',
                              102 => '^FileDown$',
                              103 => '^Filter$',
                              104 => '^firefox$',
                              105 => '^FOCA',
                              106 => 'Fulltext',
                              107 => 'Funnelback',
                              108 => 'Genieo',
                              109 => 'GetRight',
                              110 => 'geturl',
                              111 => 'GigablastOpenSource',
                              112 => 'G-i-g-a-b-o-t',
                              113 => 'GLMSLinkAnalysis',
                              114 => 'Goldfire(\\s|\\+)Server',
                              115 => 'google',
                              116 => 'Grammarly',
                              117 => 'GroupHigh\\/\\d',
                              118 => 'grub',
                              119 => 'gulliver',
                              120 => 'gvfs\\/',
                              121 => 'harvest',
                              122 => 'heritrix',
                              123 => 'holmes',
                              124 => 'htdig',
                              125 => 'htmlparser',
                              126 => 'HeadlessChrome',
                              127 => 'HttpComponents\\/1.1',
                              128 => 'HTTPFetcher',
                              129 => 'http.?client',
                              130 => 'httpget',
                              131 => 'httpx',
                              132 => 'httrack',
                              133 => 'ia_archiver',
                              134 => 'ichiro',
                              135 => 'iktomi',
                              136 => 'ilse',
                              137 => 'Indy Library',
                              138 => '^integrity\\/\\d',
                              139 => 'internetseer',
                              140 => 'intute',
                              141 => 'iSiloX',
                              142 => 'iskanie',
                              143 => '^java\\/\\d{1,2}.\\d',
                              144 => 'jeeves',
                              145 => 'Jersey\\/\\d',
                              146 => 'jobo',
                              147 => 'Koha',
                              148 => 'kyluka',
                              149 => 'larbin',
                              150 => 'libcurl',
                              151 => 'libhttp',
                              152 => 'libwww',
                              153 => 'lilina',
                              154 => '^LinkAnalyser',
                              155 => 'link.?check',
                              156 => 'LinkLint-checkonly',
                              157 => '^LinkParser\\/',
                              158 => '^LinkSaver\\/',
                              159 => 'linkscan',
                              160 => 'LinkTiger',
                              161 => 'linkwalker',
                              162 => 'lipperhey',
                              163 => 'livejournal\\.com',
                              164 => 'LOCKSS',
                              165 => 'LongURL.API',
                              166 => 'ltx71',
                              167 => 'lwp',
                              168 => 'lycos[_+]',
                              169 => 'MaCoCu',
                              170 => 'mail\\.ru',
                              171 => 'MarcEdit',
                              172 => 'mediapartners-google',
                              173 => 'megite',
                              174 => 'MetaURI[\\+\\s]API\\/\\d\\.\\d',
                              175 => 'Microsoft(\\s|\\+)URL(\\s|\\+)Control',
                              176 => 'Microsoft Office Existence Discovery',
                              177 => 'Microsoft Office Protocol Discovery',
                              178 => 'Microsoft-WebDAV-MiniRedir',
                              179 => 'mimas',
                              180 => 'mnogosearch',
                              181 => 'moget',
                              182 => 'motor',
                              183 => '^Mozilla$',
                              184 => '^Mozilla.4\\.0$',
                              185 => '^Mozilla\\/4\\.0\\+\\(compatible;\\)$',
                              186 => '^Mozilla\\/4\\.0\\+\\(compatible;\\+ICS\\)$',
                              187 => '^Mozilla\\/4\\.5\\+\\[en]\\+\\(Win98;\\+I\\)$',
                              188 => '^Mozilla.5\\.0$',
                              189 => '^Mozilla\\/5.0\\+\\(compatible;\\+MSIE\\+6\\.0;\\+Windows\\+NT\\+5\\.0\\)$',
                              190 => '^Mozilla\\/5\\.0\\+like\\+Gecko$',
                              191 => '^Mozilla\\/5.0(\\s|\\+)Gecko\\/20100115(\\s|\\+)Firefox\\/3.6$',
                              192 => '^MSIE',
                              193 => 'MuscatFerre',
                              194 => 'myweb',
                              195 => 'nagios',
                              196 => '^NetAnts\\/\\d',
                              197 => 'netcraft',
                              198 => 'netluchs',
                              199 => 'newspaper\\/\\d',
                              200 => 'ng\\/2\\.',
                              201 => '^Ning\\/\\d',
                              202 => 'no_user_agent',
                              203 => 'nomad',
                              204 => 'nutch',
                              205 => '^oaDOI$',
                              206 => 'ocelli',
                              207 => 'Offline(\\s|\\+)Navigator',
                              208 => 'OgScrper',
                              209 => 'okhttp',
                              210 => 'onetszukaj',
                              211 => '^Opera\\/4$',
                              212 => 'OurBrowser',
                              213 => 'panscient',
                              214 => 'parsijoo',
                              215 => '^Pattern\\/\\d',
                              216 => 'Pcore-HTTP',
                              217 => 'pear\\.php\\.net',
                              218 => 'perman',
                              219 => 'PHP\\/',
                              220 => 'pidcheck',
                              221 => 'pioneer',
                              222 => 'playmusic\\.com',
                              223 => 'playstarmusic\\.com',
                              224 => '^Postgenomic(\\s|\\+)v2',
                              225 => 'powermarks',
                              226 => 'proximic',
                              227 => 'PycURL',
                              228 => 'python',
                              229 => 'Qwantify',
                              230 => 'rambler',
                              231 => 'ReactorNetty\\/\\d',
                              232 => 'Readpaper',
                              233 => 'redalert',
                              234 => 'Riddler',
                              235 => 'robozilla',
                              236 => 'rss',
                              237 => 'scan4mail',
                              238 => 'scientificcommons',
                              239 => 'scirus',
                              240 => 'scooter',
                              241 => 'Scrapy\\/\\d',
                              242 => 'ScoutJet',
                              243 => '^scrutiny\\/\\d',
                              244 => 'SearchBloxIntra',
                              245 => 'shoutcast',
                              246 => 'Site24x7',
                              247 => 'SkypeUriPreview',
                              248 => 'slurp',
                              249 => 'sogou',
                              250 => 'speedy',
                              251 => 'sqlmap',
                              252 => 'SrceDAMP',
                              253 => 'Strider',
                              254 => 'summify',
                              255 => 'sunrise',
                              256 => 'Sysomos',
                              257 => 'T\\-H\\-U\\-N\\-D\\-E\\-R\\-S\\-T\\-O\\-N\\-E',
                              258 => 'tailrank',
                              259 => 'Teleport(\\s|\\+)Pro',
                              260 => 'Teoma',
                              261 => 'The[\\+\\s]Knowledge[\\+\\s]AI',
                              262 => 'titan',
                              263 => '^Traackr\\.com$',
                              264 => 'Trello',
                              265 => 'Trove',
                              266 => 'Turnitin',
                              267 => 'twiceler',
                              268 => 'Typhoeus',
                              269 => 'ucsd',
                              270 => 'ultraseek',
                              271 => '^undefined$',
                              272 => '^unknown$',
                              273 => 'Unpaywall',
                              274 => 'URL2File',
                              275 => 'urlaliasbuilder',
                              276 => 'urllib',
                              277 => '^user.?agent$',
                              278 => '^User-Agent',
                              279 => 'validator',
                              280 => 'virus.detector',
                              281 => 'voila',
                              282 => '^voltron$',
                              283 => 'voyager\\/',
                              284 => 'w3af\\.org',
                              285 => 'Wanadoo',
                              286 => 'Web(\\s|\\+)Downloader',
                              287 => 'WebCloner',
                              288 => 'webcollage',
                              289 => 'WebCopier',
                              290 => 'Webinator',
                              291 => 'weblayers',
                              292 => 'Webmetrics',
                              293 => 'webmirror',
                              294 => 'webmon',
                              295 => 'weborama-fetcher',
                              296 => 'webreaper',
                              297 => 'WebStripper',
                              298 => 'WebZIP',
                              299 => 'Wget',
                              300 => 'WhatsApp',
                              301 => 'wordpress',
                              302 => 'worm',
                              303 => 'www\\.gnip\\.com',
                              304 => 'WWW-Mechanize',
                              305 => 'xenu',
                              306 => 'y!j',
                              307 => 'yacy',
                              308 => 'yahoo',
                              309 => 'yandex',
                              310 => 'Yeti\\/\\d',
                              311 => 'Zabbix',
                              312 => 'ZoteroTranslationServer',
                              313 => 'zeus',
                              314 => 'zyborg',
                              315 => '7siters',
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
.stats_imagecell > span {
    height: 100%;
    display: inline-block;
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

        $todaY = (date('Y')-1).'-'.date('m-d');
        serendipity_db_query("DELETE FROM {$serendipity['dbPrefix']}visitors WHERE day < '$todaY'", true);
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

        if (serendipity_db_bool($this->get_config('autoclean', 'true'))
        && (!isset($_COOKIE['serendipity']['autoCleanStats']) || $_COOKIE['serendipity']['autoCleanStats'] < time())) {
            $this->autoCleanStats();
            setCookie('serendipity[autoCleanStats]', time()+43200); // + 12 h
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
                    foreach($cry AS $key => $val){
                        $combined[$key] = $val + [2 => $lry[$key][1]];
                    }

                    $perc = @round($this->percent($max2, $max));
                    $maxVisHeigh = 100/$max*2;
                    $maxVisHeighex = $perc/$max2*2;

                    foreach (array_reverse($combined) AS $n) {
                        $monthHeight = @round($n[1]*$maxVisHeigh, 3); // be as precise as possible eg. 12.321px
                        $mhex = @round($n[2]*$maxVisHeighex, 3); // ditto
                        $numCountInt = @($n[1]*$maxVisHeigh/2);
                        echo '<td class="stats_imagecell">
                                <span class="co_mo"><img src="plugins/serendipity_event_statistics/gray.png" title="'.$n[2].'" width="8" height="'.@round($mhex).'" style="height:'.$mhex.'px" alt="o" /></span>
                                <span class="di_ff"><img src="plugins/serendipity_event_statistics/transparent.png" width="8" height="200" style="height:200px" alt="°" /></span>
                                <span class="cu_mo"><img src="plugins/serendipity_event_statistics/';
                        if ($numCountInt <= 33) {
                            echo 'red.png';
                        } else if ($numCountInt > 33 && $numCountInt < 66) {
                            echo 'yellow.png';
                        } else {
                            echo 'green.png';
                        }
                        echo '" title="'.$n[1].'" width="8" height="'.@round($monthHeight).'" style="height:'.$monthHeight.'px" alt="';
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