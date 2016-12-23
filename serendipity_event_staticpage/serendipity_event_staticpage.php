<?php

if (IN_serendipity !== true) {
    die ("Don't hack!");
}

// Note: @access cased private method phpDOC notations, without(!) a private method keyword, were wished to make public again by Garvin. ;-)

@define ('DEBUG_STATICPAGE', false); // for related category debugging only

@serendipity_plugin_api::load_language(dirname(__FILE__));

class serendipity_event_staticpage extends serendipity_event
{
    var $staticpage = array();
    var $pagetype = array();
    var $pluginstats = array();
    var $error_404 = FALSE;

    var $config = array(
            'headline',
            'permalink',
            'pagetitle',
            'articletype',
            'publishstatus',
            'language',
            'content',
            'markup',
            'articleformat',
            'articleformattitle',

            'authorid',
            'parent_id',
            'related_category_id',
            'show_childpages',
            'pre_content',

            'pass',
            'filename',
            'is_startpage',
            'is_404_page',
            'pageorder',
            'shownavi',
            'showonnavi',
            'showmeta',
            'timestamp',
            'show_breadcrumb',
            'title_element',
            'meta_description',
            'meta_keywords'
        );

    var $config_types = array(
            'description',
            'template',
            'image'
        );

    /**
     * The introspection function to setup properties about the plugin.
     *
     * @access public
     * @param   object  A property bag object you can manipulate
     * @return true
     */
    public function introspect(&$propbag)
    {
        global $serendipity;

        $propbag->add('name', STATICPAGE_TITLE);
        $propbag->add('description', STATICPAGE_TITLE_BLAHBLAH);
        $propbag->add('website', 'http://board.s9y.org');

        $propbag->add('event_hooks', array(
            'backend_category_addNew'                           => true,
            'backend_category_update'                           => true,
            'backend_category_delete'                           => true,
            'backend_category_showForm'                         => true,
            'backend_sidebar_entries_event_display_staticpages' => true,
            'backend_sidebar_entries'                           => true,
            'entries_header'                                    => true,
            'entries_footer'                                    => true,
            'external_plugin'                                   => true,
            'entry_display'                                     => true,
            'genpage'                                           => true,
            'css'                                               => true,
            'backend_media_rename'                              => true,
            'frontend_fetchentries'                             => true,
            'frontend_rss'                                      => true,
            'backend_header'                                    => true,
            'frontend_header'                                   => true
        ));

        $propbag->add('page_configuration', $this->config);
        $propbag->add('type_configuration', $this->config_types);
        $propbag->add('author', 'Marco Rinck, Garvin Hicking, David Rolston, Falk Doering, Stephan Manske, Pascal Uhlmann, Ian, Don Chambers');
        $propbag->add('version', '5.13');
        $propbag->add('requirements', array(
            'serendipity' => '2.0.99',
            'smarty'      => '3.1.0',
            'php'         => '5.3.0'
        ));
        $propbag->add('stackable', false);
        $propbag->add('groups', array('BACKEND_EDITOR', 'BACKEND_FEATURES'));
        $propbag->add('configuration', array(
            'config_formgrouper',
            'markup',
            'articleformat',
            'publishstatus',
            'show_childpages',
            'shownavi',
            'show_breadcrumb',
            'showonnavi',
            'showmeta',
            'separator2',
            'config_frontendgrouper',
            'showtextorheadline',
            'use_lmdate',
            'use_quicksearch',
            'separator',
            'config_configgrouper',
            'showlist',
            'listpp'
        ));
        $this->cachefile = $serendipity['serendipityPath'] . PATH_SMARTY_COMPILE . '/staticpage_pagelist.dat';
    }

    /**
     * Introspection of this plugins configuration items
     *
     * Called by serendipity when it wants to display the configuration
     * editor for your plugin.
     *
     * @access    public
     * @param     string    Name of the config item
     * @param     object    A property bag object you can store the configuration in
     * @return bool
     */
    public function introspect_config_item($name, &$propbag)
    {
        global $serendipity;

        switch ($name) {
            case 'listpp':
                $propbag->add('type',           'string');
                $propbag->add('name',           STATICPAGE_SHOWLIST_NUMLIST);
                $propbag->add('description',    '');
                $propbag->add('default',        '6');
                break;

            case 'showlist':
                $propbag->add('type',           'boolean');
                $propbag->add('name',           STATICPAGE_SHOWLIST_DEFAULT);
                $propbag->add('description',    STATICPAGE_SHOWLIST_DESC);
                $propbag->add('default',        'true');
                break;

            case 'separator2':
            case 'separator':
                $propbag->add('type',           'separator');
                break;

            case 'config_formgrouper':
                $propbag->add('type',           'content');
                $propbag->add('name',           'Form Preferences');
                $propbag->add('default',        '<h3>' . STATICPAGE_CONFIGGROUP_FORM . '</h3>');
                break;

            case 'config_frontendgrouper':
                $propbag->add('type',           'content');
                $propbag->add('name',           'Frontend Preferences');
                $propbag->add('default',        '<h3>' . STATICPAGE_CONFIGGROUP_FRONTEND . '</h3>');
                break;

            case 'config_configgrouper':
                $propbag->add('type',           'content');
                $propbag->add('name',           'Configuration Preferences');
                $propbag->add('default',        '<h3>' . STATICPAGE_CONFIGGROUP_BACKEND . '</h3>');
                break;

            case 'use_quicksearch':
                $propbag->add('type',           'boolean');
                $propbag->add('name',           QUICKSEARCH);
                $propbag->add('description',    STATICPAGE_QUICKSEARCH_DESC);
                $propbag->add('default',        'true');
                break;

            case 'use_lmdate':
                $propbag->add('type',           'boolean');
                $propbag->add('name',           STATICPAGE_USELMDATE_DEFAULT);
                $propbag->add('description',    '');
                $propbag->add('default',        'true');
                break;

            case 'shownavi':
                $propbag->add('type',           'boolean');
                $propbag->add('name',           STATICPAGE_SHOWNAVI_DEFAULT);
                $propbag->add('description',    STATICPAGE_DEFAULT_DESC);
                $propbag->add('default',        'true');
                break;

            case 'showonnavi':
                $propbag->add('type',           'boolean');
                $propbag->add('name',           STATICPAGE_SHOWONNAVI_DEFAULT);
                $propbag->add('description',    STATICPAGE_DEFAULT_DESC);
                $propbag->add('default',        'true');
                break;

            case 'showmeta':
                $propbag->add('type',           'boolean');
                $propbag->add('name',           STATICPAGE_SHOWMETA_DEFAULT);
                $propbag->add('description',    STATICPAGE_DEFAULT_DESC);
                $propbag->add('default',        'true');
                break;

            case 'show_breadcrumb':
                $propbag->add('type',           'boolean');
                $propbag->add('name',           STATICPAGE_SHOW_BREADCRUMB_DEFAULT);
                $propbag->add('description',    STATICPAGE_DEFAULT_DESC);
                $propbag->add('default',        'true');
                break;

            case 'markup':
                $propbag->add('type',           'boolean');
                $propbag->add('name',           STATICPAGE_SHOWMARKUP_DEFAULT);
                $propbag->add('description',    STATICPAGE_DEFAULT_DESC);
                $propbag->add('default',        'true');
                break;

            case 'articleformat':
                $propbag->add('type',           'boolean');
                $propbag->add('name',           STATICPAGE_SHOWARTICLEFORMAT_DEFAULT);
                $propbag->add('description',    STATICPAGE_DEFAULT_DESC);
                $propbag->add('default',        'true');
                break;

            case 'publishstatus':
                $propbag->add('type',           'select');
                $propbag->add('name',           STATICPAGE_PUBLISHSTATUS);
                $propbag->add('description',    STATICPAGE_DEFAULT_DESC);
                $propbag->add('select_values',  array(DRAFT, PUBLISH));
                $propbag->add('default',        '');
                break;

            case 'show_childpages':
                $propbag->add('type',           'boolean');
                $propbag->add('name',           STATICPAGE_SHOWCHILDPAGES_DEFAULT);
                $propbag->add('description',    STATICPAGE_DEFAULT_DESC);
                $propbag->add('default',        'true');
                break;

            case 'showtextorheadline':
                $propbag->add('type',           'radio');
                $propbag->add('name',           STATICPAGE_SHOWTEXTORHEADLINE_NAME);
                $propbag->add('description',    '');
                $propbag->add('radio',          array(
                                                    'value' => array('true', 'false'),
                                                    'desc'  => array(STATICPAGE_SHOWTEXTORHEADLINE_TEXT, STATICPAGE_SHOWTEXTORHEADLINE_HEADLINE)
                                                ));
                $propbag->add('default',        'false');
                break;

            default:
                return false;
        }
        return true;
    }

    /**
     * Introspection of this plugins form items
     *
     * Called, when the (Smarty)InspectConfig is gathered for form generation elements
     *
     * @access    private
     * @param     string    Name of the config item
     * @param     object    A property bag object you can store the configuration in
     * @return bool
     */
    function introspect_item($name, &$propbag)
    {
        global $serendipity;

        switch ($name) {
            case 'headline':
                $propbag->add('type',           'string');
                $propbag->add('name',           STATICPAGE_HEADLINE);
                $propbag->add('description',    STATICPAGE_HEADLINE_BLAHBLAH);
                $propbag->add('default',        '');
                break;

            case 'filename':
                $propbag->add('type',           'hidden');
                $propbag->add('name',           STATICPAGE_FILENAME_NAME);
                $propbag->add('description',    STATICPAGE_FILENAME_DESC);
                $propbag->add('default',        'plugin_staticpage.tpl');
                break;

            case 'title_element':
                $propbag->add('type',          'string');
                $propbag->add('name',           STATICPAGES_CUSTOM_META_TITLE);
                $propbag->add('description',    STATICPAGES_CUSTOM_META_TITLE_BLAH_BLAH);
                $propbag->add('default',        '');
                break;

            case 'meta_description':
                $propbag->add('type',          'string');
                $propbag->add('name',           STATICPAGES_CUSTOM_META_DESC);
                $propbag->add('description',    STATICPAGES_CUSTOM_META_DESC_BLAH_BLAH);
                $propbag->add('default',        '');
                break;

            case 'meta_keywords':
                 $propbag->add('type',          'string');
                $propbag->add('name',           STATICPAGES_CUSTOM_META_KEYS);
                $propbag->add('description',    STATICPAGES_CUSTOM_META_KEYS_BLAH_BLAH);
                $propbag->add('default',        '');
                break;

            case 'content':
                $propbag->add('type',           'html');
                $propbag->add('name',           CONTENT);
                $propbag->add('description',    CONTENT_BLAHBLAH);
                $propbag->add('default',        '');
                break;

            case 'permalink':
                $propbag->add('type',           'string');
                $propbag->add('name',           STATICPAGE_PERMALINK);
                $propbag->add('description',    STATICPAGE_PERMALINK_BLAHBLAH);
                $propbag->add('default',        $serendipity['rewrite'] != 'none'
                                                ? $serendipity['serendipityHTTPPath'] . 'pages/pagetitle.html'
                                                : $serendipity['serendipityHTTPPath'] . $serendipity['indexFile'] . '?/pages/pagetitle.html');
                break;

            case 'pagetitle':
                $propbag->add('type',           'string');
                $propbag->add('name',           STATICPAGE_PAGETITLE);
                $propbag->add('description',    '');
                $propbag->add('default',        'pagetitle');
                break;

            case 'timestamp':
                $propbag->add('type',           'timestamp');
                $propbag->add('name',           DATE);
                $propbag->add('description',    GENERAL_PLUGIN_DATEFORMAT . ': ' . DATE_FORMAT_SHORT);
                $propbag->add('default',        '');
                break;

            case 'pass':
                $propbag->add('type',           'string');
                $propbag->add('name',           PASSWORD);
                $propbag->add('description',    STATICPAGE_PASSWORD_NOTICE);
                $propbag->add('default',        '');
                break;

            case 'markup':
                $propbag->add('type',           'boolean');
                $propbag->add('name',           DO_MARKUP);
                $propbag->add('description',    DO_MARKUP_DESCRIPTION);
                $propbag->add('default',        $this->get_config('markup', 'true'));
                break;

            case 'articleformat':
                $propbag->add('type',           'boolean');
                $propbag->add('name',           STATICPAGE_ARTICLEFORMAT);
                $propbag->add('description',    STATICPAGE_ARTICLEFORMAT_BLAHBLAH);
                $propbag->add('default',        $this->get_config('articleformat', 'true'));
                break;

            case 'articleformattitle':
                $propbag->add('type',           'string');
                $propbag->add('name',           STATICPAGE_ARTICLEFORMAT_PAGETITLE);
                $propbag->add('description',    STATICPAGE_ARTICLEFORMAT_PAGETITLE_BLAHBLAH);
                $propbag->add('default',        $serendipity['blogTitle'] . ' :: ' . $this->pagetitle);
                break;

            case 'parent_id':
                $propbag->add('type',           'select');
                $propbag->add('name',           STATICPAGE_PARENTPAGES_NAME);
                $propbag->add('description',    STATICPAGE_PARENTPAGE_DESC);
                $propbag->add('select_values',  $this->selectPages());
                $propbag->add('default',        STATICPAGE_PARENTPAGE_PARENT);
                break;

            case 'authorid':
                $propbag->add('type',           'select');
                $propbag->add('name',           STATICPAGE_AUTHORS_NAME);
                $propbag->add('description',    STATICPAGE_AUTHORS_DESC);
                $propbag->add('select_values',  $this->selectAuthors());
                $propbag->add('default',        $serendipity['authorid']);
                break;

            case 'show_childpages':
                $propbag->add('type',           'boolean');
                $propbag->add('name',           STATICPAGE_SHOWCHILDPAGES_NAME);
                $propbag->add('description',    STATICPAGE_SHOWCHILDPAGES_DESC);
                $propbag->add('default',        $this->get_config('show_childpages', 'true'));
                break;

            case 'pre_content':
                $propbag->add('type',           'html');
                $propbag->add('name',           STATICPAGE_PRECONTENT_NAME);
                $propbag->add('description',    STATICPAGE_PRECONTENT_DESC);
                $propbag->add('default',        '');
                break;

            case 'is_startpage':
                $propbag->add('type',           'boolean');
                $propbag->add('name',           STATICPAGE_IS_STARTPAGE);
                $propbag->add('description',    STATICPAGE_IS_STARTPAGE_DESC);
                $propbag->add('default',        'false');
                break;

            case 'is_404_page':
                $propbag->add('type',           'boolean');
                $propbag->add('name',           STATICPAGE_IS_404_PAGE);
                $propbag->add('description',    STATICPAGE_IS_404_PAGE_DESC);
                $propbag->add('default',        'false');
                break;

            case 'articletype':
                $propbag->add('type',           'select');
                $propbag->add('name',           STATICPAGE_ARTICLETYPE);
                $propbag->add('description',    STATICPAGE_ARTICLETYPE_DESC);
                $propbag->add('select_values',  $this->selectPageTypes());
                $propbag->add('default',        $serendipity['POST']['articletype']);
                break;

            case 'shownavi':
                $propbag->add('type',            'boolean');
                $propbag->add('name',            STATICPAGE_SHOWNAVI);
                $propbag->add('description',     STATICPAGE_SHOWNAVI_DESC);
                $propbag->add('default',         $this->get_config('shownavi', 'true'));
                break;

            case 'showonnavi':
                $propbag->add('type',            'boolean');
                $propbag->add('name',            STATICPAGE_SHOWONNAVI);
                $propbag->add('description',     STATICPAGE_SHOWONNAVI_DESC);
                $propbag->add('default',         $this->get_config('showonnavi', 'true'));
                break;

            case 'show_breadcrumb':
                $propbag->add('type',            'boolean');
                $propbag->add('name',            STATICPAGE_SHOW_BREADCRUMB);
                $propbag->add('description',     STATICPAGE_SHOW_BREADCRUMB_DESC);
                $propbag->add('default',         $this->get_config('show_breadcrumb', 'true'));
                break;

            case 'publishstatus':
                $propbag->add('type',           'select');
                $propbag->add('name',           STATICPAGE_PUBLISHSTATUS);
                $propbag->add('description',    STATICPAGE_PUBLISHSTATUS_DESC);
                $propbag->add('select_values',  array(DRAFT, PUBLISH));
                $propbag->add('default',        '');
                break;

            case 'language':
                $propbag->add('type',           'select');
                $propbag->add('name',           INSTALL_LANG);
                $propbag->add('description',    STATICPAGE_LANGUAGE_DESC);
                $propbag->add('select_values',  $this->getLanguages());
                $propbag->add('default',        $serendipity['lang']);
                break;

            case 'related_category_id':
                $propbag->add('type',           'select');
                $propbag->add('name',           STATICPAGE_RELATED_CATEGORY);
                $propbag->add('description',    STATICPAGE_RELATED_CATEGORY_DESCRIPTION);
                $propbag->add('select_values',  $this->getRelatedCategories());
                $propbag->add('default',        '');
                break;

            default:
                return false;
        }
        return true;
    }

    /**
     * Introspection of this plugins form item types
     *
     * Called, when the (Smarty)InspectConfig is gathered for form generation elements
     *
     * @access    private
     * @param     string    Name of the config item
     * @param     object    A property bag object you can store the configuration in
     * @return bool
     */
    function introspect_item_type($name, &$propbag)
    {
        global $serendipity;

        switch ($name) {
            case 'description':
                $propbag->add('type',           'string');
                $propbag->add('name',           STATICPAGE_ARTICLETYPE_DESCRIPTION);
                $propbag->add('description',    STATICPAGE_ARTICLETYPE_DESCRIPTION_DESC);
                $propbag->add('default',        '');
                break;

            case 'template':
                $propbag->add('type',           'string');
                $propbag->add('name',           STATICPAGE_ARTICLETYPE_TEMPLATE);
                $propbag->add('description',    STATICPAGE_ARTICLETYPE_TEMPLATE_DESC);
                $propbag->add('default',        '');
                break;

            case 'image':
                $propbag->add('type',           'string');
                $propbag->add('name',           STATICPAGE_ARTICLETYPE_IMAGE);
                $propbag->add('description',    STATICPAGE_ARTICLETYPE_IMAGE_DESC);
                $propbag->add('default',        '');
                break;

            default:
                return false;
        }
        return true;
    }

    /**
     * Generate content title
     *
     * @param  string    The referenced variable that holds the sidebar title of this plugin
     * @access public
     * @return void
     */
    public function generate_content(&$title)
    {
        $title = STATICPAGE_TITLE;
    }

    /**
     * Install the staticpage database tables
     *
     * @access public
     * @return void
     */
    public function install()
    {
        $this->setupDB();
    }

    /**
     * Extract the realname from all authors
     *
     * @access  private
     * @return  array     key: userid, value: realname
     *
     */
    function selectAuthors()
    {
        global $serendipity;

        $users = (array)serendipity_fetchUsers();
        foreach ($users AS $user) {
            if ($this->checkUser($user)) {
                $u[$user['authorid']] = $user['realname'];
            }
        }
        return $u;
    }

    /**
     * Get Serendipity languages
     *
     * @access  private
     * @return  array
     */
    function getLanguages()
    {
        global $serendipity;

        $lang['all'] = LANG_ALL;
        $lang = array_merge($lang, $serendipity['languages']);
        return $lang;
    }

    /**
     * Fetch and get related categories
     *
     * @access  private
     * @return  array
     */
    function getRelatedCategories()
    {
        global $serendipity;

        $res = serendipity_fetchCategories($serendipity['authorid']);
        $ret[0] = NONE;
        if (is_array($res)) {
            foreach ($res AS $value) {
                $ret[$value['categoryid']] = $value['category_name'];
            }
        }
        return $ret;
    }

    /**
     * Extract the realname from the author id
     *
     * @param   int       authors ID
     * @access  private
     * @return  mixed     realname if match, else false
     *
     */
    function selectAuthor($id)
    {
        global $serendipity;

        $users = (array)serendipity_fetchUsers();
        foreach ($users AS $user) {
            if ($user['authorid'] == $id) {
                return $user['realname'];
            }
        }
        return false;
    }

    /**
     * check if the user has the rights to do something by user array
     *
     * @param   array     user access
     * @access  private
     * @return  boolean
     *
     */
    function checkUser(&$user)
    {
        global $serendipity;

        return (($user['userlevel'] < $serendipity['serendipityUserlevel']) || ($user['authorid'] == $serendipity['authorid']) || ($serendipity['serendipityUserlevel'] >= USERLEVEL_ADMIN));
    }

    /**
     * check if the user has the rights to do something by userid
     *
     * @see     checkUser
     * @param   int       authors ID
     * @access  private
     * @return  boolean
     *
     */
    function checkPageUser($authorid)
    {
        global $serendipity;

        if ((empty($authorid)) || ((int)$authorid === 0)) {
            return true;
        }

        $user = (array)serendipity_fetchUsers($authorid);

        return $this->checkUser($user[0]);
    }

    /**
     * Fetch all created staticpages
     *
     * @access  private
     * @return  array     array of pages
     *
     */
    function selectPages()
    {
        global $serendipity;

        $p = array('0' => STATICPAGE_PARENTPAGE_PARENT);

        $q = 'SELECT id, authorid, pagetitle, parent_id
                FROM '.$serendipity['dbPrefix'].'staticpages
               WHERE content != \'plugin\'
            ORDER BY parent_id, pageorder';

        $pages = serendipity_db_query($q, false, 'assoc');

        if (is_array($pages)) {
            $pages = serendipity_walkRecursive($pages);
            foreach ($pages AS $page) {
                if ($this->checkPageUser($page['authorid']) && $serendipity['POST']['staticpage'] != $page['id']) {
                    $p[$page['id']] = str_repeat('', $page['depth']) . $page['pagetitle'];
                }
            }
        }

        return $p;
    }

    /**
     * Fetch a list of all pagetypes
     *
     * @access  private
     * @return  mixed     array if pagetypes, else false
     *
     */
    function selectPageTypes()
    {
        global $serendipity;

        $q = 'SELECT id, description
                FROM '.$serendipity['dbPrefix'].'staticpages_types';

        $types = serendipity_db_query($q, false, 'assoc');

        if (is_array($types)) {
            foreach ($types AS $type) {
                $t[$type['id']] = $type['description'];
            }
            return $t;
        }

        return false;
    }

    /**
     * check if sidebar plugin is available for install
     *
     * @access  private
     * @return  bool
     */
    function sb_plugin_status()
    {
        $plugins = serendipity_plugin_api::enum_plugins('*', false, 'serendipity_plugin_staticpage');
        if (is_array($plugins) && !empty($plugins[0]['name'])) {
            return true;
        }
        return false;
    }

    /**
     * are plugins installed, available or not
     *
     * @access  private
     * @return  void
     */
    function pluginstatus()
    {
        global $serendipity;

        $uplugs = array(
            'serendipity_event_downloadmanager',
            'serendipity_event_guestbook',
            'serendipity_event_forum',
            'serendipity_event_contactform',
            'serendipity_event_thumbnails',
            'serendipity_event_usergallery',
            'serendipity_event_faq'
        );
        $plugins = serendipity_plugin_api::get_installed_plugins('event');
        $classes = serendipity_plugin_api::enum_plugin_classes('event');

        foreach ($uplugs AS $plugin) {
            if (in_array($plugin, $plugins)) {
                $this->pluginstats[$plugin] = array(
                    'status' => STATICPAGE_PLUGINS_INSTALLED,
                    'color' => 'Green'
                );
            } elseif (isset($classes[$plugin])) {
                $this->pluginstats[$plugin] = array(
                    'status' => STATICPAGE_PLUGIN_AVAILABLE,
                    'color' => 'Yellow'
                );
            } else {
                $this->pluginstats[$plugin] = array(
                    'status' =>STATICPAGE_PLUGIN_NOTAVAILABLE,
                    'color' => 'Red'
                );
            }
        }
    }

    /**
     * prepare a list with available plugins for use in staticpage
     *
     * @access  private
     * @return  array
     *
     */
    function selectPlugins()
    {
        global $serendipity;

        $plugins = serendipity_plugin_api::get_installed_plugins('event');

        foreach ($plugins AS $plugin) {
            switch ($plugin) {

                case 'serendipity_event_downloadmanager':
                    if ($serendipity['rewrite'] == 'none') {
                        $q = 'SELECT value
                                FROM '.$serendipity['dbPrefix'].'config
                               WHERE name LIKE \'serendipity_event_downloadmanager%pageurl\'';
                    } else {
                        $q = 'SELECT value
                                FROM '.$serendipity['dbPrefix'].'config
                               WHERE name LIKE \'serendipity_event_downloadmanager%permalink\'';
                    }
                    $ret = serendipity_db_query($q, true, 'assoc');
                    if (is_array($ret)) {
                        if ($serendipity['rewrite'] == 'none') {
                            $page[$plugin]['link'] = $serendipity['serendipityHTTPPath'].$serendipity['indexFile'].'?serendipity[subpage]='.$ret['value'];
                        } else {
                            $page[$plugin]['link'] = $ret['value'];
                        }
                        $page[$plugin]['name'] = PLUGIN_DOWNLOADMANAGER_TITLE;
                    }
                    break;

                case 'serendipity_event_guestbook':
                    $q = 'SELECT value
                            FROM '.$serendipity['dbPrefix'].'config
                           WHERE name LIKE \'serendipity_event_guestbook%'.(($serendipity['rewrite'] != 'none') ? 'permalink' : 'pagetitle').'\'';
                    $ret = serendipity_db_query($q, true, 'assoc');
                    if (is_array($ret)) {
                        $page[$plugin]['name'] = (defined('GUESTBOOK_TITLE') ? GUESTBOOK_TITLE : PLUGIN_GUESTBOOK_TITLE);
                        if ($serendipity['rewrite'] != 'none') {
                            $page[$plugin]['link'] = $ret['value'];
                        } else {
                            $page[$plugin]['link'] = $serendipity['serendipityHTTPPath'].$serendipity['indexFile'].'?serendipity[subpage]='.$ret['value'];
                        }
                    }
                    break;

                case 'serendipity_event_forum':
                    $q = 'SELECT value
                            FROM '.$serendipity['dbPrefix'].'config
                           WHERE name LIKE \'serendipity_event_forum%pageurl\'';
                    $ret = serendipity_db_query($q, true, 'assoc');
                    if (is_array($ret)) {
                        $page[$plugin] = array(
                            'name' => PLUGIN_FORUM_TITLE,
                            'link' => $serendipity['serendipityHTTPPath'].$serendipity['indexFile'].'?serendipity[subpage]='.$ret['value']
                        );
                    }
                    break;

                case 'serendipity_event_contactform':
                    $q = 'SELECT value
                            FROM '.$serendipity['dbPrefix'].'config
                           WHERE name LIKE \'serendipity_event_contactform%'.(($serendipity['rewrite'] != 'none') ? 'permalink' : 'pagetitle').'\'';
                    $ret = serendipity_db_query($q, true, 'assoc');
                    if (is_array($ret)) {
                        if ($serendipity['rewrite'] != 'none') {
                            $page[$plugin]['link'] = $ret['value'];
                        } else {
                            $page[$plugin]['link'] = $serendipity['serendipityHTTPPath'].$serendipity['indexFile'].'?serendipity[subpage]='.$ret['value'];
                        }
                    }
                    $page[$plugin]['name'] = PLUGIN_CONTACTFORM_TITLE;
                    break;

                case 'serendipity_event_thumbnails':
                    $page[$plugin] = array(
                        'name' => THUMBPAGE_TITLE,
                        'link' => $serendipity['serendipityHTTPPath'].$serendipity['indexFile'].'?serendipity[page]=thumbs'
                    );
                    break;

                case 'serendipity_event_usergallery':
                    if ($serendipity['rewrite'] == 'none') {
                        $q = 'SELECT value
                                FROM '.$serendipity['dbPrefix'].'config
                               WHERE name LIKE \'serendipity_event_usergallery%subpage\'';
                    } else {
                        $q = 'SELECT value
                                FROM '.$serendipity['dbPrefix'].'config
                               WHERE name LIKE \'serendipity_event_usergallery%permalink\'';
                    }
                    $ret = serendipity_db_query($q, true, 'assoc');
                    if (is_array($ret)) {
                        if ($serendipity['rewrite'] == 'none') {
                            $page[$plugin]['link'] = $serendipity['serendipityHTTPPath'].$serendipity['indexFile'].'?serendipity[subpage]='.$ret['value'];
                        } else {
                            $page[$plugin]['link'] = $ret['value'];
                        }
                        $page[$plugin]['name'] = PLUGIN_EVENT_USERGALLERY_TITLE;
                    }
                    break;

                case 'serendipity_event_faq':
                    $q = 'SELECT value
                            FROM '.$serendipity['dbPrefix'].'config
                           WHERE name LIKE \'serendipity_event_faq%faqurl\'';
                    $ret = serendipity_db_query($q, true, 'assoc');
                    if (is_array($ret)) {
                        if ($serendipity['rewrite'] == 'none') {
                            $page[$plugin]['link'] = $serendipity['serendipityHTTPPath'].$serendipity['indexFile'].'?/'.$serendipity['permalinkPluginPath'].'/'.$ret['value'];
                        } else {
                            $page[$plugin]['link'] = $serendipity['serendipityHTTPPath'].$serendipity['permalinkPluginPath'].'/'.$ret['value'];
                        }
                        $page[$plugin]['name'] = FAQ_NAME;
                    }
                    break;

            }
        }
        return $page;
    }

    /**
     * Check for db error string in backend environment only
     * Avoids errors placed into the admin/serendipity_editor.js and the frontend!
     *
     * @param   mixed   serendipity_db_schema_import() result
     * @access  private
     * @return  boolean
     */
    function check_error($result)
    {
        if (is_string($result) && defined('IN_serendipity_admin')) {
            return true;
        }
        return false;
    }

    /**
     * Manage and setup the database tables for staticpage
     *
     * @access  private
     * @return  void
     *
     */
    function setupDB()
    {
        global $serendipity;

        $built = $this->get_config('db_built', null);
        $fresh = false;

        if ((empty($built)) && (!defined('STATICPAGE_UPGRADE_DONE')) && stristr($serendipity['dbType'], 'sqlite') === FALSE) {
            serendipity_db_schema_import("CREATE TABLE {$serendipity['dbPrefix']}staticpages (
                    id {AUTOINCREMENT} {PRIMARY},
                    parent_id int(11) default '0',
                    articleformattitle varchar(255) not null default '',
                    articleformat int(1) default '1',
                    markup int(1) default '1',
                    pagetitle varchar(255) not null default '',
                    permalink varchar(255) not null default '',
                    is_startpage int(1) default '0',
                    is_404_page int(1) default '0',
                    show_childpages int(1) not null default '0',
                    content text,
                    pre_content text,
                    headline varchar(255) not null default '',
                    filename varchar(255) not null default '',
                    pass varchar(255) not null default '',
                    timestamp int(10) {UNSIGNED} default null,
                    last_modified int(10) {UNSIGNED} default null,
                    authorid int(11) default '0',
                    pageorder int(4) default '0',
                    articletype int(4) default '0',
                    related_category_id int(4) default 0,
                    shownavi int(4) default '1',
                    showonnavi int(4) default '1',
                    show_breadcrumb int(4) default '1',
                    publishstatus int(4) default '1',
                    language varchar(10) default '',
                    title_element varchar(255) not null default '',
                    meta_description varchar(255) not null default '',
                    meta_keywords varchar(255) not null default '') {UTF_8}");

            $old_stuff = serendipity_db_query("SELECT * FROM {$serendipity['dbPrefix']}config WHERE name LIKE 'serendipity_event_staticpage:%'");

            $import = array();
            if (is_array($old_stuff)) {
                foreach ($old_stuff AS $item) {
                    $names = explode('/', $item['name']);
                    if (!isset($import[$names[0]])) {
                        $import[$names[0]] = array('authorid' => $item['authorid']);
                    }

                    $import[$names[0]][$names[1]] = serendipity_get_bool($item['value']);
                }
            }

            foreach ($import AS $page) {
                if (is_array($page)) {
                    serendipity_db_insert('staticpages', $page);
                    @unlink($this->cachefile);
                }
            }

            serendipity_db_query("DELETE FROM {$serendipity['dbPrefix']}config  WHERE name LIKE 'serendipity_event_staticpage:%'");
            serendipity_db_query("DELETE FROM {$serendipity['dbPrefix']}plugins WHERE name LIKE 'serendipity_event_staticpage:%' AND name NOT LIKE '" . serendipity_db_escape_string($this->instance) . "'");

            $this->set_config('db_built', '7');
            $fresh = true;
            @define('STATICPAGE_UPGRADE_DONE', true); // No further static pages may be called!
        }
        // workaround for sqlite not being able to alter complicated things later
        if (stristr($serendipity['dbType'], 'sqlite') !== FALSE) {

            serendipity_db_schema_import("CREATE TABLE IF NOT EXISTS {$serendipity['dbPrefix']}staticpages (
                                            id {AUTOINCREMENT} {PRIMARY},
                                            parent_id int(11) DEFAULT '0',
                                            articleformattitle varchar(255) NOT NULL DEFAULT '',
                                            articleformat int(1) DEFAULT '1',
                                            markup int(1) DEFAULT '1',
                                            pagetitle varchar(255) NOT NULL DEFAULT '',
                                            permalink varchar(255) NOT NULL DEFAULT '',
                                            is_startpage int(1) DEFAULT '0',
                                            is_404_page int(1) DEFAULT '0',
                                            show_childpages int(1) NOT NULL DEFAULT '0',
                                            content text,
                                            pre_content text,
                                            headline varchar(255) NOT NULL DEFAULT '',
                                            filename varchar(255) NOT NULL DEFAULT '',
                                            pass varchar(255) NOT NULL DEFAULT '',
                                            timestamp int(10) unsigned DEFAULT NULL,
                                            last_modified int(10) unsigned DEFAULT NULL,
                                            authorid int(11) DEFAULT '0',
                                            pageorder int(4) DEFAULT '0',
                                            articletype int(4) DEFAULT '0',
                                            related_category_id int(4) DEFAULT '0',
                                            shownavi int(4) DEFAULT '1',
                                            showonnavi int(4) DEFAULT '1',
                                            show_breadcrumb int(4) DEFAULT '1',
                                            publishstatus int(4) DEFAULT '1',
                                            language varchar(10) DEFAULT '',
                                            title_element varchar(255) NOT NULL DEFAULT '',
                                            meta_description varchar(255) NOT NULL DEFAULT '',
                                            meta_keywords varchar(255) NOT NULL DEFAULT '') {UTF_8}");

            serendipity_db_schema_import("CREATE TABLE IF NOT EXISTS {$serendipity['dbPrefix']}staticpages_types (
                                            id {AUTOINCREMENT} {PRIMARY},
                                            description varchar(100) NOT NULL DEFAULT '',
                                            template varchar(255) NOT NULL DEFAULT '',
                                            image varchar(255) NOT NULL DEFAULT '') {UTF_8}");

            serendipity_db_schema_import("CREATE TABLE IF NOT EXISTS {$serendipity['dbPrefix']}staticpage_categorypage (
                                            categoryid int(4) DEFAULT '0',
                                            staticpage_categorypage int(4) DEFAULT '0') {UTF_8}");

            serendipity_db_schema_import("CREATE TABLE IF NOT EXISTS {$serendipity['dbPrefix']}staticpage_custom (
                                            staticpage int(11) DEFAULT NULL,
                                            name varchar(128) DEFAULT NULL,
                                            value text) {UTF_8}");

            // Set fulltext indizes of tables ? Is that working here? Should not... and just return true without accessing serendipity_db_query() method
            #serendipity_db_schema_import("CREATE {FULLTEXT_MYSQL} INDEX staticentry_idx on {$serendipity['dbPrefix']}staticpages (headline, content);");

            // set to latest build
            $this->set_config('db_built', 22);
            $build = 22;
            $fresh = true;
            @define('STATICPAGE_UPGRADE_DONE', true); // don't do this again!
        }

        switch ($built) {
            case 1: // password not included
                $q = "ALTER TABLE {$serendipity['dbPrefix']}staticpages ADD COLUMN pass varchar(255) not null default ''";
                serendipity_db_schema_import($q);
            case 2: // parent-id not included
                $q = "ALTER TABLE {$serendipity['dbPrefix']}staticpages ADD COLUMN parent_id int(11) default '0'";
                serendipity_db_schema_import($q);
            case 3:
                $q = "ALTER TABLE {$serendipity['dbPrefix']}staticpages ADD COLUMN show_childpages int(1) not null default '0'";
                serendipity_db_schema_import($q); // list of child-pages on parent-page
                $q = "ALTER TABLE {$serendipity['dbPrefix']}staticpages ADD COLUMN pre_content text";
                serendipity_db_schema_import($q); // content
            case 4:
                $q = "ALTER TABLE {$serendipity['dbPrefix']}staticpages ADD COLUMN is_startpage int(1) default '0'";
                serendipity_db_schema_import($q);
            case 5: // enum to re-order staticpages
                $q = "ALTER TABLE {$serendipity['dbPrefix']}staticpages ADD COLUMN pageorder int(4) default '0'";
                serendipity_db_schema_import($q);
            case 6:
                $q = "ALTER TABLE {$serendipity['dbPrefix']}staticpages ADD COLUMN articletype int(4) default '0'";
                serendipity_db_schema_import($q);
            case 7:
                $q = "CREATE TABLE {$serendipity['dbPrefix']}staticpages_types (
                        id {AUTOINCREMENT} {PRIMARY},
                        description varchar(100) not null default '',
                        template varchar(255) not null default '',
                        image varchar(255) not null default '') {UTF_8}";
                serendipity_db_schema_import($q);
                $existing = serendipity_db_query("SELECT * FROM {$serendipity['dbPrefix']}staticpages_types LIMIT 1");
                if (!is_array($existing) || !isset($existing[0]['template'])) {
                    $this->pagetype = array(
                        'description' => 'Article',
                        'template' => 'plugin_staticpage.tpl'
                    );
                    serendipity_db_insert('staticpages_types', $this->pagetype);
                    $this->pagetype = array(
                        'description' => 'Overview',
                        'template' => 'plugin_staticpage_aboutpage.tpl'
                    );
                    serendipity_db_insert('staticpages_types', $this->pagetype);
                    $set = array(
                        'articletype' => 1,
                        'pageorder' => 0
                    );
                    serendipity_db_update('staticpages', array(), $set);
                    @unlink($this->cachefile);
                }
            case 8:
            case 9:
            case 10:
                if (!$fresh) {
                    $q = "ALTER TABLE {$serendipity['dbPrefix']}staticpages ADD COLUMN shownavi int(4) default '1';";
                    serendipity_db_schema_import($q);
                    $q = "ALTER TABLE {$serendipity['dbPrefix']}staticpages ADD COLUMN showonnavi int(4) default '1'";
                    serendipity_db_schema_import($q);
                    $q = "ALTER TABLE {$serendipity['dbPrefix']}staticpages ADD COLUMN publishstatus int(4) default '1';";
                    serendipity_db_schema_import($q);
                    $q = "DROP TABLE {$serendipity['dbPrefix']}staticpages_plugins";
                    serendipity_db_schema_import($q);
                    $q = "ALTER TABLE {$serendipity['dbPrefix']}staticpages ADD COLUMN language varchar(10) default ''";
                    serendipity_db_schema_import($q);
                }
            case 11:
                serendipity_db_update('staticpages_types', array('description' => 'Aboutpage'), array('description' => 'Overview'));
            case 12:
                $q = "CREATE {FULLTEXT_MYSQL} INDEX staticentry_idx on {$serendipity['dbPrefix']}staticpages (headline, content);";
                serendipity_db_schema_import($q);
            case 13:
            case 14:
                if (!$fresh) {
                    $q = "ALTER TABLE {$serendipity['dbPrefix']}staticpages ADD COLUMN last_modified int(10)";
                    serendipity_db_schema_import($q);
                    serendipity_db_query("UPDATE {$serendipity['dbPrefix']}staticpages SET last_modified = timestamp");
                }
            case 15:
                if (!$fresh) {
                    $sql = "ALTER TABLE {$serendipity['dbPrefix']}staticpages ADD COLUMN related_category_id int(4) default 0";
                    serendipity_db_schema_import($sql);
                }
            case 16:
                $this->pagetype = array(
                    'description' => 'Staticpage with related category',
                    'template'    => 'plugin_staticpage_related_category.tpl'
                );
                serendipity_db_insert('staticpages_types', $this->pagetype);

                $sql = 'CREATE TABLE '.$serendipity['dbPrefix'].'staticpage_categorypage (
                            categoryid int(4) default 0,
                            staticpage_categorypage int(4) default 0
                        ) {UTF_8}';
                serendipity_db_schema_import($sql);
            case 17:
                $sql = 'CREATE TABLE '.$serendipity['dbPrefix'].'staticpage_custom (
                            staticpage int(11),
                            name varchar(128),
                            value text
                        ) {UTF_8}';
                serendipity_db_schema_import($sql);
            case 18:
                    $sql = "ALTER TABLE {$serendipity['dbPrefix']}staticpages ADD COLUMN is_404_page int(1) default 0";
                    if ($serendipity['dbType'] == 'mysql' || $serendipity['dbType'] == 'mysqli') {
                        $sql .= ' AFTER is_startpage';
                    }
                    serendipity_db_schema_import($sql);
            case 19:
                if (!$fresh) {
                    $q = "ALTER TABLE {$serendipity['dbPrefix']}staticpages ADD COLUMN show_breadcrumb int(4) default '1'";
                    if ($serendipity['dbType'] == 'mysql' || $serendipity['dbType'] == 'mysqli') {
                        $q .= ' AFTER showonnavi';
                    }
                    serendipity_db_schema_import($q);
                }
            case 20:
                if (!$fresh) {
                    $q = "ALTER TABLE {$serendipity['dbPrefix']}staticpages ADD COLUMN title_element varchar(255) not null default ''";
                    serendipity_db_schema_import($q);
                    $q = "ALTER TABLE {$serendipity['dbPrefix']}staticpages ADD COLUMN meta_description varchar(255) not null default ''";
                    serendipity_db_schema_import($q);
                    $q = "ALTER TABLE {$serendipity['dbPrefix']}staticpages ADD COLUMN meta_keywords varchar(255) not null default ''";
                    serendipity_db_schema_import($q);
                }
            case 21:
                // ALTER table permission errors just die away silently, we now offer an error for cases since v.3.97
                /*
                https://github.com/s9y/additional_plugins/commit/43e0f86e4c965faf3e4f526fd707be0b3efec566#diff-a69dc3666716dfa0368134079aebb5b9
                43e0f86 Breadcrumb navigation as an independent option
                */
                // correct missing case 19
                $repairfield  = false;
                $altererror   = false;
                $has_sbcfield = serendipity_db_query("SELECT show_breadcrumb FROM {$serendipity['dbPrefix']}staticpages LIMIT 1", true, 'assoc');
                if (!is_array($has_sbcfield) && !empty($has_sbcfield)) {
                    $q = "ALTER TABLE {$serendipity['dbPrefix']}staticpages ADD COLUMN show_breadcrumb int(4) default '1'";
                    if ($serendipity['dbType'] == 'mysql' || $serendipity['dbType'] == 'mysqli') {
                        $q .= ' AFTER showonnavi';
                    }
                    $r = serendipity_db_schema_import($q);
                    if ($r === true) {
                        $repairfield = true;
                    } else {
                        $altererror = $this->check_error($r);
                    }
                }
                // correct case 19 for mysql type dbs, which did not use the AFTER extension before
                if ($repairfield === false && ($serendipity['dbType'] == 'mysql' || $serendipity['dbType'] == 'mysqli')) {
                    $q = "ALTER TABLE {$serendipity['dbPrefix']}staticpages MODIFY COLUMN show_breadcrumb int(4) DEFAULT '1' AFTER showonnavi";
                    $r = serendipity_db_schema_import($q);
                    $altererror = $this->check_error($r);
                }
                /*
                https://github.com/s9y/additional_plugins/commit/36fd48b5bc17d7395e4e1c9c38c60936925e184e#diff-a69dc3666716dfa0368134079aebb5b9
                36fd48b Changed meta fields, no longer custom properties
                */
                // correct case 20 for upgraders, which did not use them in fresh before ( since v.4.09 )
                $has_metafields = serendipity_db_query("SELECT title_element, meta_description, meta_keywords FROM {$serendipity['dbPrefix']}staticpages LIMIT 1", false, 'assoc');
                if (!is_array($has_metafields) && !empty($has_metafields)) {
                    $q = "ALTER TABLE {$serendipity['dbPrefix']}staticpages ADD COLUMN title_element varchar(255) not null default ''";
                    $r = serendipity_db_schema_import($q);
                    $altererror = $this->check_error($r);
                    $q = "ALTER TABLE {$serendipity['dbPrefix']}staticpages ADD COLUMN meta_description varchar(255) not null default ''";
                    $r = serendipity_db_schema_import($q);
                    $altererror = $this->check_error($r);
                    $q = "ALTER TABLE {$serendipity['dbPrefix']}staticpages ADD COLUMN meta_keywords varchar(255) not null default ''";
                    $r = serendipity_db_schema_import($q);
                    $altererror = $this->check_error($r);
                }
                if ($altererror === true) {
                    echo '<span class="msg_error"><span class="icon-attention-circled" aria-hidden="true"></span> <strong>Error:</strong> '.$r.'. Please check your privileges to this table; triggered in serendipity_event_staticpages, db_build() method, case 21 checks.</span>'; // ALTER command denied
                } else // strictly secure this by IN_serendipity_admin backend, else $altererror will be false
                if ($altererror === false && defined('IN_serendipity_admin')) {
                    $this->set_config('db_built', 22);
                } else {
                    $this->set_config('db_built', 21);
                }
                break;
        }
    }

    /**
     * Walk through the staticpage item array and return the value by key
     *
     * @see     var staticpage
     * @param   array     key
     * @param   string
     * @access  private
     * @return  string
     *
     */
    function get_static($key, $default = null) /* no more & */
    {
        return (isset($this->staticpage[$key]) ? $this->staticpage[$key] : $default);
    }

    /**
     * Walk through the pagetype item type array and return the value by key
     *
     * @see     var pagetype
     * @param   array     key
     * @param   string
     * @access  private
     * @return  string
     *
     */
    function get_type($key, $default = null) /* no more & */
    {
        return (isset($this->pagetype[$key]) ? $this->pagetype[$key] : $default);
    }

    /**
     * Creates admin link and checks user rights
     *
     * @access  private
     * @return  array
     */
    function getEditlinkData()
    {
        global $serendipity;

        $adminlink = array(
            'link_edit' => $serendipity['serendipityHTTPPath'].'serendipity_admin.php?serendipity[action]=admin&amp;serendipity[adminModule]=event_display&amp;serendipity[adminAction]=staticpages&amp;serendipity[staticid]='.(int)$this->getPageID(),
            'link_name' => STATICPAGE_LINKNAME,
            'page_user' => $this->checkPageUser($this->staticpage['authorid'])
        );

        return $adminlink;
    }

    /**
     * Extract child breadcrumb navigation ids downwards
     *
     * @param   array    $pages
     * @param   int      $id
     * @param   array    recursive return
     * @access  private
     * @return  array
     */
    function recursive_childs($pages, $id, $p = array())
    {
        $p = array_merge($p, array($id));
        foreach ($pages AS $page) {
            if ($page['parent_id'] == $id) {
                $p = $this->recursive_childs($pages, $page['id'], $p);
                break;
            }
        }
        return $p;
    }

    /**
     * Extract frontend pages array index key by childs id
     *
     * @param   array    $pages
     * @param   int      $id
     * @access  private
     * @return  mixed    int/bool
     */
    function getPagesKey($p, $id)
    {
        foreach ($p AS $key => $item) {
            if ($item['id'] == $id) {
                return $key;
            }
        }
        return false;
    }

    /**
     * Rewind and set internal pointer for next and prev frontend navigation returns
     * since $expages may have excluded/removed keys, without setting a new index, for comparison checks with $pages
     * that is why the previous coded loops $i+1/$i-1 in $nav for prev and next did not help
     *
     * @param   array     $pages
     * @param   int       for $index
     * @param   boolean   next or prev
     * @param   string    key name
     * @access  private
     * @return  mixed     string/bool
     */
    function get_nav($array, $index, $prev, $s='')
    {
        if (!is_array($array)) {
            return null;
        }
        // handle case end of array
        end($array);         // move the internal pointer to the end of the array
        $key = key($array);  // fetches the key of the element pointed to by the internal pointer
        if (!$prev && ($key == $index)) {
            return false;
        }
        if ( $prev && ($key == $index)) {
            prev($array);
            return $array[key($array)][$s];
        }
        // rewind and iterate through for normal case navigations
        unset($key);
        reset($array);
        foreach ($array AS $key => $item) {
            if ($key == $index) {
                if (!$prev) {
                    return $array[key($array)][$s]; // is next() index key already
                }
                prev($array); // set pointer to current key, see above
                prev($array); // set pointer to real prev() key
                return $array[key($array)][$s];
            }
        }
        return false;
    }

    /**
     * Get all recursive childs of a given parent top id
     *
     * @param   array    $pages
     * @param   int      $id
     * @param   boolean  $parent
     * @param   array    recursive return
     * @access  private
     * @return  array
     */
    function recursive_tree($array, $id, $parent=false, $tree=array())
    {
        foreach($array AS $item) {
            if ( (!$parent && $item['id'] == $id) || $item['parent_id'] == $id) {
                $itemdata = array();
                foreach($item AS $k => $v) {
                    $itemdata[$k] = $v;
                }
                $tree[] = $itemdata;
                if ($item['parent_id'] == $id) {
                    $tree = array_merge($tree, $this->recursive_tree($array, $item['id'], true));
                }
            }
        }
        return $tree;
    }

    /**
     * Fetch and build navigation data for frontend navigations
     *
     * @access  private
     * @return  mixed array/bool
     */
    function getNavigationData()
    {
        global $serendipity;

        $target  = $this->cachefile;
        $timeout = 86400; // One day
        if (file_exists($target) && filemtime($target) > time()-$timeout) {
            $pages = unserialize(file_get_contents($target));
        } else {
            $pages = $this->fetchPublishedStaticPages();
            $pages = (is_array($pages) ? serendipity_walkRecursive($pages) : array()); // builds depth flag

            // builds an exclude flag, referenced, in case of a level 0 top page with no navis set at all
            foreach ($pages AS $lkey => &$lval) {
                if ($lval['depth'] == 0 && $lval['shownavi'] == 0 && $lval['show_breadcrumb'] == 0) {
                    $lval['excludenav'] = true;
                }
            }
            // add to all recursive childs of a level 0 top parent with set flag
            foreach ($pages AS $addkey => $addvalue) {
                if ($addvalue['excludenav']) {
                    $rtree = $this->recursive_tree($pages, $addvalue['id']);
                    foreach ($rtree AS $tkey => $tval) {
                        // referenced
                        foreach ($pages AS $rkey => &$rval) {
                            if ($rval['id'] == $tval['id'] && $rval['shownavi'] == 0) $rval['excludenav'] = true;
                        }
                    }
                }
            }

            $fp = fopen($target, 'w');
            fwrite($fp, serialize($pages));
            fclose($fp);
        }

        $thispage = (int)$this->getPageID();
        $navname  = serendipity_db_bool($this->get_config('showtextorheadline', 'false'));

        // clone pages array for shownavi navigation, but remove flagged item keys
        foreach ($pages AS $k => $v) {
            if (!$v['excludenav']) { $expages[$k] = $v; } // keep index key for strict comparison with pages array!
        }

        for ($i = 0, $maxcount = count($pages); $i < $maxcount; $i++) {
            if ($pages[$i]['depth'] == 0) {
                $top['name']      = $pages[$i]['pagetitle'];
                $top['permalink'] = $pages[$i]['permalink'];
                $top['id']        = $pages[$i]['id'];
            }
            if ($pages[$i]['id'] == $thispage) {
                $previstop = ($top['id'] == $i) ? true : false; // case when top_parents id equals previous_key id
                $childcase = ($pages[$i]['depth'] > 1) ? true : false;
                // Keep im mind, the 'top' in $nav['top'] is just a synonym for 'current page', or 'top parent', or 'exit'
                $nav = array(
                    'prev' => array(
                        'name' => $navname ? PREVIOUS : $this->get_nav($expages, $i, true, 'pagetitle'),
                        'link' => $this->get_nav($expages, $i, true, 'permalink')
                    ),
                    'next' => array(
                        'name' => $navname ? NEXT : $this->get_nav($expages, $i, false, 'pagetitle'),
                        'link' => $this->get_nav($expages, $i, false, 'permalink')
                    ),
                    'top' => array(
                        'topp_name' => $childcase ? ($navname ? STATICPAGE_TOP : $top['name']) : '',
                        'topp_link' => $childcase ? $top['permalink'] : '',
                        'curr_name' => $pages[$i]['pagetitle'],
                        'curr_link' => $pages[$i]['permalink'],
                        'exit_name' => $previstop ? HOMEPAGE : '',
                        'exit_link' => $previstop ? $serendipity['serendipityHTTPPath'] : '',
                        'new'       => true,
                        // this is old compat view, reduced to a plain link of current page. Disabled top_parent here, while too expensive!
                        'name' => $pages[$i]['pagetitle'],
                        'link' => $pages[$i]['permalink'],
                    )
                );

                if (empty($nav['prev']['link'])){
                    $nav['prev']['name'] = '';
                }

                if (empty($nav['next']['link'])){
                    $nav['next']['name'] = '';
                }

                if (empty($nav['top']['link'])){
                    $nav['top']['name'] = '';
                }

                // Include breadcrumbs
                // gather upwards from $thispage
                $crumbs = array();
                // Add the current page
                $j = $i;
                $pages[$j]['name'] = $pages[$j]['pagetitle'];
                $pages[$j]['link'] = $pages[$j]['permalink'];
                $crumbs[] = $pages[$j];

                $childs = $this->recursive_childs($pages, $pages[$j]['id']);

                $up = $pages[$j]['parent_id'];

                while (($j >= 0) && ($up != 0)) {
                    // Find the parent page index! (Backwards for efficiency)
                    for (; ($j >= 0) && ($pages[$j]['id'] != $up); $j--) {}
                    if (($j >= 0) && ($pages[$j]['id'] == $up)) {
                        // Add the current page
                        $pages[$j]['name'] = $pages[$j]['pagetitle'];
                        $pages[$j]['link'] = $pages[$j]['permalink'];
                        $crumbs[] = $pages[$j];
                        $up = $pages[$j]['parent_id'];
                    }
                }
                // gather downwards from $thispage
                foreach($childs As $child) {
                    $pkey = $this->getPagesKey($pages, $child);
                    $pages[$pkey]['name'] = $pages[$pkey]['pagetitle'];
                    $pages[$pkey]['link'] = $pages[$pkey]['permalink'];
                    if (is_int($pkey)) $crumbs[] = $pages[$pkey];
                }
                // merge the upwards and downwards breadcrumb array
                $crumbs = array_unique($crumbs, SORT_REGULAR);
                // sort breadcrumb array by depth key
                usort($crumbs, function($a, $b) {
                    return $a['depth'] - $b['depth'];
                });

                $nav['crumbs'] = $crumbs;

                return $nav;
            }

        }
        return false;
    }

    /**
     * Fetch template for pagetypes by given ID
     *
     * @param   int       template ID
     * @access  private
     * @return  string
     */
    function getTemplate($id)
    {
        global $serendipity;

        $q = "SELECT template
                FROM {$serendipity['dbPrefix']}staticpages_types
               WHERE id = '{$id}'";
        $t = serendipity_db_query($q, true, 'assoc');
        return $t['template'];
    }

    /**
     * Fetch pagetype images
     *
     * @param   int       image ID
     * @access  private
     * @return  string
     */
    function getImage($id)
    {
        global $serendipity;

        $q = "SELECT image
                FROM {$serendipity['dbPrefix']}staticpages_types
               WHERE id = '{$id}'";
        $t = serendipity_db_query($q, true, 'assoc');
        return $t['image'];
    }

    /**
     * Smarty init for related categories
     *
     * @access  private
     * @return  void
     */
    function smarty_init()
    {
        global $serendipity;

        if (!isset($this->smarty_init)) {
            include_once dirname(__FILE__) . '/smarty.inc.php';
            if (isset($serendipity['smarty'])) {
                $staticpage_cat = $this->fetchCatProp((int)$serendipity['GET']['category']);
                $serendipity['smarty']->assign('staticpage_categorypage', $this->fetchStaticPageForCat($staticpage_cat));
                $serendipity['smarty']->assign('serendipityArchiveURL', getArchiveURL());
                $serendipity['smarty']->registerPlugin('function', 'getCategoryLinkByID', 'smarty_getCategoryLinkByID');
                $serendipity['smarty']->registerPlugin('function', 'staticpage_display', 'staticpage_display');
                $serendipity['staticpage_plugin'] =& $this;
                #var_dump($this);
                $this->smarty_init = true;
            }
        }
    }

    /**
     * Fix double encoded entities by htmlspeciachars() for ISO-8859-1 charset cases
     *
     * @param   string
     * @access  public
     * @return  string
     * @static
     * @see     child sidebar plugin access
     */
    public static function fixUTFEntity($string)
    {
        return preg_replace('/&amp;#(x[a-f0-9]{1,4}|[0-9]{1,5});/', '&#$1;', $string);
    }

    /**
     * Staticpage wrapper for htmlspecialchars charset switch with PHP 5.4
     * 
     * @access  public
     * @return  string
     * @static
     * @see     child sidebar plugin access
     */
    public static function html_specialchars($string, $flags = null, $encoding = LANG_CHARSET, $double_encode = true)
    {
        if ($flags == null) {
            if (defined('ENT_HTML401')) {
                // Added with PHP 5.4.x
                $flags = ENT_COMPAT | ENT_HTML401 | ENT_SUBSTITUTE;
            } else {
                // For PHP < 5.4 compatibility
                $flags = ENT_COMPAT;
            }
        }
        if ($encoding == 'LANG_CHARSET') {
            $encoding = 'UTF-8'; // fallback, if constant is not available
        }
        // Native ISO-8859-1 charsets will encode stored unicode ampersand (&) again with $double_encode(true),
        // which is the default, so this is set to false on demand in some places
        // ( see headline, etc. in Smarty template files, or fixed by this fixUTFEntity() )
        return htmlspecialchars($string, $flags, $encoding, $double_encode);
    }

    /**
     * Parse static page
     *
     * @param   string    pagevar prefix
     * @param   string    template name
     * @access  private
     * @return  template string
     */
    function parseStaticPage($pagevar = 'staticpage_', $template = 'plugin_staticpage.tpl') /* No more & */
    {
        global $serendipity;

        $filename = $this->get_static('filename');
        if (empty($filename) || $filename == 'none.html') {
            $filename = $template;
        }

        if ($template != 'plugin_staticpage.tpl') {
            $filename = $template;
        } else if ($this->get_static('articletype')) {
            $filename = $this->getTemplate($this->get_static('articletype'));
        }

        if (!is_object($serendipity['smarty'])) {
            serendipity_smarty_init();
        }

        foreach($this->config AS $staticpage_config) {
            $cvar = $this->get_static($staticpage_config);
            // this is, where eg {$staticpage_articleformattitle} and headline etc are assigned, which needs the fixUTFEntity or single escape with double_encode:false on Smarty side, or overwrite assignment at line 1576 ff
            $serendipity['smarty']->assign($pagevar . $staticpage_config, $cvar);
            // This is a global variable assignment, so that within entries.tpl you can access $smarty.env.staticpage_pagetitle. Otherwise, $staticpage_pagetitle would only be available to index.tpl and content.tpl
            $_ENV[$pagevar . $staticpage_config] = $cvar;
        }

        if (serendipity_db_bool($this->get_static('markup'))) {
            // check if it was marked written true by wysiwyg-editor
            $q = "SELECT * FROM {$serendipity['dbPrefix']}staticpage_custom WHERE staticpage = " . (int)$this->get_static('id') . " AND name = 'wysiwyg'";
            $sp_no_nl2br = serendipity_db_query($q, true, 'assoc');
            if (is_array($sp_no_nl2br)) {
                $plugins = serendipity_plugin_api::get_event_plugins();
                if (is_array($plugins)) {
                    foreach($plugins AS $plugin => $plugin_data) {
                        if ($plugin_data['p']->act_pluginPath == 'serendipity_event_nl2br') {
                            $serendipity['POST']['properties']['ep_no_nl2br'] = true;
                        }
                    }
                }
            }
            $entry = array('body' => $this->get_static('content'));
            $entry['staticpage'] =& $entry['body']; // this will be $eventData['staticpage'] for the smartymarkup plugin!
            serendipity_plugin_api::hook_event('frontend_display', $entry);
            if (isset($entry['markup_staticpage'])) {
                $staticpage_content = $entry['staticpage'];
            } else {
                $staticpage_content = $entry['body'];
            }

            $entry = array('body' => $this->get_static('pre_content'));
            $entry['staticpage'] =& $entry['body'];
            if (!empty($entry['body'])) {
                serendipity_plugin_api::hook_event('frontend_display', $entry);
            }
            if (isset($entry['markup_staticpage'])) {
                $staticpage_precontent = $entry['staticpage'];
            } else {
                $staticpage_precontent = $entry['body'];
            }
            if (isset($serendipity['POST']['properties']['ep_no_nl2br']) && !isset($serendipity['POST']['pass'])) {
                unset($serendipity['POST']);
            }
        } else {
            $staticpage_content    = $this->get_static('content'); // no more &
            $staticpage_precontent = $this->get_static('pre_content'); // no more &
        }
        // get the next level childpage downwards; to be viewed with (simple) option 'show childpages'
        if ($cpids = $this->getChildPagesID()) {

            foreach($cpids AS $cpid) {
                $cpages[] = $this->getStaticPage($cpid);
            }

            foreach($cpages AS $cpage) {
                if (strlen($cpage['pre_content'])) {
                    $precontent = $cpage['pre_content']; // no more &
                } else {
                    $precontent = $cpage['content']; // no more &
                }

                if (serendipity_db_bool($cpage['markup'])) {
                    $entry = array('body' => $precontent);
                    $entry['staticpage'] =& $entry['body'];
                    if (!empty($entry['body'])) {
                        serendipity_plugin_api::hook_event('frontend_display', $entry);
                    }
                    if (isset($entry['markup_staticpage'])) {
                        $precontent = $entry['staticpage'];
                    } else {
                        $precontent = $entry['body'];
                    }
                }
                $imgid = ($cpage['articletype'] ? $cpage['articletype'] : 1);
                $childpages[] = array(
                    'image'      => $this->getImage($imgid),
                    'precontent' => $precontent,
                    'permalink'  => $cpage['permalink'],
                    'pagetitle'  => $cpage['pagetitle'],
                    'headline'   => $cpage['headline']
                );

            }
        }
        // the #uncommented are already assigned [see line 1492, which assigns $this->config vars]
        $serendipity['smarty']->assign(
            array(
                $pagevar . 'articleformat'      => serendipity_db_bool($this->get_static('articleformat')),// already assigned, but overwrite as boolean
                $pagevar . 'form_pass'          => isset($serendipity['POST']['pass']) ? $serendipity['POST']['pass'] : '',
                $pagevar . 'form_url'           => $serendipity['baseURL'] . $serendipity['indexFile'] . '?serendipity[subpage]=' . self::html_specialchars($this->get_static('pagetitle')),
                $pagevar . 'content'            => $staticpage_content,
                $pagevar . 'childpages'         => serendipity_db_bool($this->get_static('show_childpages')) ? $this->getChildPages() : false,
                $pagevar . 'extchildpages'      => serendipity_db_bool($this->get_static('show_childpages')) ? $childpages : false,
                $pagevar . 'pid'                => $this->get_static('id'),
                $pagevar . 'precontent'         => $staticpage_precontent,
                $pagevar . 'adminlink'          => $this->getEditlinkData(),
                $pagevar . 'navigation'         => $this->getNavigationData(),
                $pagevar . 'author'             => $this->selectAuthor($this->staticpage['authorid']),
                $pagevar . 'created_on'         => $this->get_static('timestamp'),
                $pagevar . 'lastchange'         => $this->get_static('last_modified'),
                $pagevar . 'use_lmdate'         => serendipity_db_bool($this->get_config('use_lmdate', 'true')),
                $pagevar . 'shownavi'           => serendipity_db_bool($this->get_static('shownavi')),// already assigned, but overwrite as boolean
                $pagevar . 'show_breadcrumb'    => serendipity_db_bool($this->get_static('show_breadcrumb')),// already assigned, but overwrite as boolean
                $pagevar . 'custom'             => $this->get_static('custom'),
                #$pagevar . 'title_element'      => self::fixUTFEntity(self::html_specialchars($this->get_static('title_element'))),// these three metas are not set, fixed and escaped here,
                #$pagevar . 'meta_description'   => self::fixUTFEntity(self::html_specialchars($this->get_static('meta_description'))),// since nowhere used as a Smarty var yet
                #$pagevar . 'meta_keywords'      => self::fixUTFEntity(self::html_specialchars($this->get_static('meta_keywords'))),// and being already assigned and properly escaped in SmartyInspectConfig()
                $pagevar . 'articleformattitle' => self::fixUTFEntity(self::html_specialchars($this->get_static('articleformattitle'))), // overwrite already assigned and possibly unproperly escaped
                $pagevar . 'headline'           => self::fixUTFEntity(self::html_specialchars($this->get_static('headline'))), // in SmartyInspectConfig()
                $pagevar . 'doublesc'           => ((LANG_CHARSET === 'ISO-8859-1') ? false : true)
            )
        );

        $filename = basename($filename);
        // force simple fallback if possible
        $tfile    = serendipity_getTemplateFile($filename, 'serendipityPath', true, true);
        if (!$tfile || $tfile == $filename) {
            $tfile = dirname(__FILE__) . '/' . $filename;
        }
        $content = $serendipity['smarty']->fetch('file:'. $tfile);

        return $content;
    }


    /**
     * Show selected static page
     *
     * @access  private
     * @return  string by echo
     */
    function show()
    {
        global $serendipity;

        if ($this->selected()) {
            if ($this->error_404 === FALSE) {
                serendipity_header($_SERVER['SERVER_PROTOCOL'].' 200 OK');
                serendipity_header('Status: 200 OK');
            }
            else {
                serendipity_header($_SERVER['SERVER_PROTOCOL'].' 404 Not Found');
                serendipity_header('Status: 404 Not Found');
            }

            echo $this->parseStaticPage();
        }
    }

    /**
     * Fetch page ID
     *
     * @access  private
     * @return  mixed array/bool
     */
    function getPageID()
    {
        global $serendipity;

        if (isset($this->staticpage['id'])) {
            return $this->staticpage['id'];
        }

        $q = "SELECT id
                FROM {$serendipity['dbPrefix']}staticpages
               WHERE pagetitle = '" . serendipity_db_escape_string($serendipity['GET']['subpage']) . "'
                  OR permalink = '" . serendipity_db_escape_string($serendipity['GET']['subpage']) . "'";

        $page = serendipity_db_query($q, true, 'assoc');

        return isset($page['id']) ? $page['id'] : false;
    }

    /**
     * Fetch child pages by current parent ID
     *
     * @access  private
     * @return  mixed array/bool
     */
    function getChildPages()
    {
        global $serendipity;

        $id = (int)$this->getPageID();

        $q = 'SELECT pagetitle, permalink
                FROM '.$serendipity['dbPrefix'].'staticpages
               WHERE parent_id = '.$id.'
                 AND publishstatus = 1
            ORDER BY pageorder';

        $pages = serendipity_db_query($q, false, 'assoc');

        return is_array($pages) ? $pages : false;
    }

    /**
     * Fetch child pages ID by current parent ID
     *
     * @access  private
     * @return  mixed array/bool
     */
    function getChildPagesID()
    {
        global $serendipity;

        $id = (int)$this->getPageID();

        $q = 'SELECT id
                FROM '.$serendipity['dbPrefix'].'staticpages
               WHERE parent_id = '.$id.'
                 AND publishstatus = 1
            ORDER BY pageorder';

        $p = serendipity_db_query($q, false, 'assoc');

        if (is_array($p)) {
            foreach($p AS $page) {
                $pages[] = $page['id'];
            }
            return $pages;
        }

        return false;
    }

    /**
     * Fetch child pages by given parent ID
     *
     * @param   int       parent ID
     * @access  private
     * @return  mixed array/bool
     */
    function getChildPage($id) // no more &
    {
        global $serendipity;

        $q = 'SELECT pagetitle, permalink
                FROM '.$serendipity['dbPrefix'].'staticpages
               WHERE parent_id = '.(int)$id.'
                 AND publishstatus = 1';

        $page = serendipity_db_query($q, false, 'assoc');

        return is_array($page) ? $page : false;
    }

    /**
     * Fetch static page by ID
     *
     * @param   int       entry ID
     * @access  private
     * @return  mixed array/bool
     */
    function getStaticPage($id) // no more &
    {
        global $serendipity;

        $q = 'SELECT *
                FROM '.$serendipity['dbPrefix'].'staticpages
               WHERE id = '.(int)$id.'
               LIMIT 1';

        $page = serendipity_db_query($q, true, 'assoc');

        return is_array($page) ? $page : false;
    }

    /**
     * Select static page
     *
     * @access  private
     * @return  bool
     */
    function selected()
    {
        global $serendipity;

        static $cached = false;

        if (empty($serendipity['GET']['subpage']) && empty($serendipity['GET']['staticid'])) {
            return false;
        }

        if ($cached) {
            return true;
        }

        $sql_where = '';
        if (serendipity_userLoggedIn()) {
            // User is authenticated; drafts and published pages are displayed as equals
            // Previews will thus only work when being logged in.
        } else {
            // User is not authenticated. Only published documents shall be revealed.
            $sql_where .= ' AND publishstatus = 1 ';
        }

        if (empty($serendipity['GET']['staticid']))
        {
            $q = "SELECT *
                    FROM {$serendipity['dbPrefix']}staticpages
                   WHERE (pagetitle = '" . serendipity_db_escape_string($serendipity['GET']['subpage']) . "'
                      OR permalink = '" . serendipity_db_escape_string($serendipity['GET']['subpage']) . "') $sql_where
                   LIMIT 1";
        } else {
            $q = "SELECT *
                    FROM {$serendipity['dbPrefix']}staticpages
                  WHERE (id = '" . serendipity_db_escape_string($serendipity['GET']['staticid']) . "') $sql_where
                  LIMIT 1";
        }

        $page = serendipity_db_query($q, true, 'assoc');

        if (is_array($page)) {
            $this->staticpage =& $page;
            $this->checkPage();
            $cached = true;
            $serendipity['is_staticpage'] = true;
            return true;
        }

        return false;
    }

    /**
     * Fetch static page by ID
     *
     * @param   int       entry ID
     * @access  private
     * @return  void
     */
    function fetchStaticPage($id) // no more &
    {
        global $serendipity;

        $q = 'SELECT *
                FROM '.$serendipity['dbPrefix'].'staticpages
               WHERE id = '.(int)$id.'
               LIMIT 1';

        $page = serendipity_db_query($q, true, 'assoc');

        if (is_array($page)) {
            $this->staticpage =& $page;
            $this->checkPage();
        }
    }

    /**
     * Fetch static pagetype by ID
     *
     * @param   int       entry ID
     * @access  private
     * @return  void
     */
    function fetchPageType($id) // no more &
    {
        global $serendipity;

        $q = 'SELECT *
                FROM '.$serendipity['dbPrefix'].'staticpages_types
               WHERE id = '.(int)$id.'
              LIMIT 1';

        $type = serendipity_db_query($q, true, 'assoc');

        if (is_array($type)) {
            $this->pagetype = $type; // no more &
        }
    }

    /**
     * This function checks the values of a staticpage entry, and maybe adjusts the right values to use.
     * Yeah. PostgreSQL is picky about this.
     *
     * @access  private
     * @return  void
     */
    function checkPage()
    {
        global $serendipity;

        if (empty($this->staticpage['filename'])) {
            $this->staticpage['filename'] = 'none.html';
        }
        if (empty($this->staticpage['timestamp'])) {
            $this->staticpage['timestamp'] = time();
        }

        // Try to auto-detect a timestamp
        if (preg_match('@[:\.]@i', $this->staticpage['timestamp'])) {
            if (function_exists('date_parse_from_format')) {
                // Need to convert strftime format (with %) to plain date format (without %)
                $d = DATE_FORMAT_SHORT;
                $d = str_replace('%M', 'i', $d); // Minute is %M in one and i in the other format
                $d = str_replace('%', '', $d); // All other modifiers (%d, %m, %Y %H) stay the same

                $t = date_parse_from_format($d, $this->staticpage['timestamp']);
                $this->staticpage['timestamp'] = mktime($t['hour'], $t['minute'], $t['second'], $t['month'], $t['day'], $t['year']);
            } elseif (function_exists('strptime')) {
                $t = strptime($this->staticpage['timestamp'], DATE_FORMAT_SHORT);
                $this->staticpage['timestamp'] = mktime($t['tm_hour'], $t['tm_min'], $t['tm_sec'], $t['tm_mon'], $t['tm_mday'], $t['tm_year']);
            } else {
                $this->staticpage['timestamp'] = strtotime($this->staticpage['timestamp']);
            }
        }

        // make definit ints for postgresql on int fields
        if (empty($this->staticpage['last_modified'])) {
            $this->staticpage['last_modified'] = time();
        }
        if (empty($this->staticpage['show_childpages'])) {
            $this->staticpage['show_childpages'] = '0';
        }
        if (empty($this->staticpage['is_startpage'])) {
            $this->staticpage['is_startpage'] = '0';
        }
        if (empty($this->staticpage['is_404_page'])) {
            $this->staticpage['is_404_page'] = '0';
        }

        if (!isset($this->staticpage['markup'])) {
            $this->staticpage['markup'] = '1';
        }
        if (!isset($this->staticpage['publishstatus'])) {
            $this->staticpage['publishstatus'] = '1';
        }
        if (!isset($this->staticpage['shownavi'])) {
            $this->staticpage['shownavi'] = '1';
        }
        if (!isset($this->staticpage['showonnavi'])) {
            $this->staticpage['showonnavi'] = '1';
        }
        if (!isset($this->staticpage['show_breadcrumb'])) {
            $this->staticpage['show_breadcrumb'] = '1';
        }

        if (empty($this->staticpage['markup'])) {
            $this->staticpage['markup'] = '0';
        }
        if (empty($this->staticpage['publishstatus'])) {
            $this->staticpage['publishstatus'] = '0';
        }
        if (empty($this->staticpage['shownavi'])) {
            $this->staticpage['shownavi'] = '0';
        }
        if (empty($this->staticpage['showonnavi'])) {
            $this->staticpage['showonnavi'] = '0';
        }
        if (empty($this->staticpage['show_breadcrumb'])) {
            $this->staticpage['show_breadcrumb'] = '0';
        }
        if (empty($this->staticpage['articletype'])) {
            $this->staticpage['articletype'] = '0';
        }
        if (empty($this->staticpage['pageorder'])) {
            $this->staticpage['pageorder'] = '0';
        }
        if (empty($this->staticpage['authorid'])) {
            $this->staticpage['authorid'] = '0';
        }
        if (empty($this->staticpage['articleformat'])) {
            $this->staticpage['articleformat'] = '0';
        }
        if (empty($this->staticpage['parent_id'])) {
            $this->staticpage['parent_id'] = '0';
        }

        // Fetch Custom properties!
        $q = 'SELECT *
                FROM ' . $serendipity['dbPrefix'] . 'staticpage_custom
               WHERE staticpage = ' . (int)$this->staticpage['id'];

        $custom = serendipity_db_query($q, false, 'assoc');

        if (is_array($custom)) {
            foreach($custom AS $idx => $row) {
                $parts = explode('~', $row['value']);
                if (count($parts) > 1) {
                    $this->staticpage['custom'][$row['name']] = $parts;
                } else {
                    $this->staticpage['custom'][$row['name']] = $row['value'];
                }
            }
        }
    }

    /**
     * Fetch static page startpage
     *
     * @access  private
     * @return  mixed array/bool
     */
    function getStartpage()
    {
        global $serendipity;

        $q = 'SELECT pagetitle
                FROM '.$serendipity['dbPrefix'].'staticpages
               WHERE is_startpage = 1
                 AND (language = \'' . $serendipity['lang'] . '\'
                  OR  language = \'all\'
                  OR  language = \'\')
            ORDER BY id DESC
               LIMIT 1';

        $page = serendipity_db_query($q, true, 'assoc');

        return (is_array($page) && isset($page['pagetitle'])) ? $page['pagetitle'] : false;
    }

    /**
     *  Fetch static page errorpage
     *
     * @access  private
     * @return  mixed array/bool
     */
    function get404Errorpage()
    {
        global $serendipity;

        $q = 'SELECT pagetitle
                FROM '.$serendipity['dbPrefix'].'staticpages
               WHERE is_404_page = 1
                 AND (language = \'' . $serendipity['lang'] . '\'
                  OR  language = \'all\'
                  OR  language = \'\')
            ORDER BY last_modified DESC
               LIMIT 1';

        $page = serendipity_db_query($q, true, 'assoc');

        return (is_array($page) && isset($page['pagetitle'])) ? $page['pagetitle'] : false;
    }

    /**
     * Update static page
     *
     * @access  private
     * @return  array
     */
    function updateStaticPage()
    {
        global $serendipity;

        $this->checkPage();
        $this->staticpage['last_modified'] = time();

        $insert_page = $this->staticpage;

        $rcid = (int)$insert_page['related_category_id'];

        // remove previous custom sets
        if (isset($insert_page['custom'])) unset($insert_page['custom']);

        if (!isset($this->staticpage['id'])) {
            $cpo = $this->getChildPage($insert_page['parent_id']); // case new
            if (is_bool($cpo)) {
                $this->staticpage['pageorder'] = 1;
            } else {
                $this->staticpage['pageorder'] = count($cpo)+1; // set a next dedicated pageorder place by counted parents
            }
            @unlink($this->cachefile);
            $result = serendipity_db_insert('staticpages', $insert_page);
            $serendipity['POST']['staticpage'] = $pid = serendipity_db_insert_id('staticpages', 'id'); // fetch last inserted id

            // Associate relcat table entry with set data, if this new staticpage 'related_category_id' field was set as related to a category in form
            if (!empty($rcid) && $rcid > 0) {
                $data = array(
                        'categoryid '               => $rcid,
                        'staticpage_categorypage'   => (int)$pid,
                );
                $this->setCatProps($rcid, $data);
            }
            serendipity_plugin_api::hook_event('backend_staticpages_insert', $insert_page); // these hooks are used for up-to-date URL builds,
        }
        else {
            @unlink($this->cachefile);
            $pid    = (int)$insert_page['id'];
            $result = serendipity_db_update('staticpages', array('id' => $insert_page['id']), $insert_page);

            // Associate relcat table with set data, if this 'related_category_id' field was changed or set in form on update
            if (!empty($rcid) && $rcid > 0) {
                // Note to user, that this has changed an already otherwise set category related staticpage and what to do
                $pcp     = $this->fetchCatProp($rcid); // $pcp = previous category page
                $pcpdata = $this->getStaticPage($pcp);
                // case no entry had been set before, or case previous category id was gt 0 and != $pid
                if (empty($pcp) || $pcp > 0 && $pcp != $pid) {
                    // only assign note to smarty in the latter case, where an entry was really changed
                    if (!empty($pcp) && $pcp != $pid) {
                        $serendipity['smarty']->assign(array(
                            'sp_relcatchange' => true,
                            'prev_relcat_staticpage' => $pcp . ' ("' . $pcpdata['pagetitle'] . '")',
                            'this_relcat_staticpage' => $pid . ' ("' . $insert_page['pagetitle'] . '")')
                        );
                    } else {
                        if (DEBUG_STATICPAGE) {
                            echo 'DEBUG: This POSTed staticpage #';
                            echo $pid;
                            echo ', with related category #';
                            echo $rcid;
                            echo ' will associate with relcat table.';
                            echo "<br>\n";
                       }
                    }
                    // proceed and set new relation to categorypage table
                    $data = array(
                            'categoryid '               => $rcid,
                            'staticpage_categorypage'   => $pid,
                    );
                    $this->setCatProps($rcid, $data);
                }
            }

            // a (previously set) 'related_category_id' field was set (back) to 0
            if ($rcid == 0) {
                // check previous relcat table categoryid ($pcid) for a match with given staticpage $pid}
                $pcid = serendipity_db_query("SELECT categoryid FROM {$serendipity['dbPrefix']}staticpage_categorypage WHERE staticpage_categorypage = " . $pid . " LIMIT 1", true, 'assoc');
                if (is_numeric($pcid['categoryid']) && $pcid['categoryid'] > 0) {
                    if (DEBUG_STATICPAGE) {
                        echo 'DEBUG: This POSTed staticpage #';
                        echo $pid;
                        echo ', with related_category_id == 0, has an association with category #';
                        echo $pcid['categoryid'];
                        echo ' which will now be deleted from relcat table.';
                        echo "<br>\n";
                    }
                    $this->setCatProps((int)$pcid['categoryid'], null, true); // set to 0, mean delete from table
                }
                // RQ: Shall we note table combine to user? (No, since we do not do this on new staticpages either.)
            }

            serendipity_plugin_api::hook_event('backend_staticpages_update', $insert_page); // (see hook above) eg in the google_sitemap plugin
        }

        // automatically disable nl2br format markup by custom field entry if WYSIWYG is true (a granular faking entryproperties ep_no_nl2br)
        if ($serendipity['wysiwyg']) {
            // always automark true by default, or set on demand within custom template radio option!
            // case new or default or set to false
            if (!isset($serendipity['POST']['plugin']['custom']) || $serendipity['POST']['plugin']['custom']['wysiwyg'] != '') $serendipity['POST']['plugin']['custom']['wysiwyg'] = 1;
            // in case textformat was set false, we don't need this all - this markup option has higher priority
            if ($serendipity['POST']['plugin']['markup'] == 'false') $serendipity['POST']['plugin']['custom']['wysiwyg'] = '';
        } else {
            // remove custom wysiwyg entry
            $serendipity['POST']['plugin']['custom']['wysiwyg'] = '';
        }

        // Store custom properties
        if (is_array($serendipity['POST']['plugin']['custom'])) {
            // here we need to purge all values, that weren't posted (again) - like a reset sidebars value for example
            foreach($serendipity['POST']['plugin']['custom'] AS $custom_name => $custom_value) {
                if (is_array($custom_value)) {
                    $custom_value = implode('~', $custom_value);
                }
                // Delete first. Might not exist, but then we can safely issue an INSERT statement.
                serendipity_db_query("DELETE FROM {$serendipity['dbPrefix']}staticpage_custom
                                            WHERE staticpage = " . (int)$pid . "
                                              AND name = '" . serendipity_db_escape_string($custom_name) . "'");

                if (strtolower($custom_value) != 'none' && trim($custom_value) != '') {
                    serendipity_db_query("INSERT INTO {$serendipity['dbPrefix']}staticpage_custom (staticpage, name, value)
                                           VALUES (" . (int)$pid . ", '" . serendipity_db_escape_string($custom_name) . "', '" . serendipity_db_escape_string($custom_value) . "')");
                }
            }
            $this->staticpage['custom'] = $serendipity['POST']['plugin']['custom'];
        }
        //unset($serendipity['POST']); // RQ: is this eventually a need?
        return $result;
    }

    /**
     * Update pagetype
     *
     * @access  private
     * @return  void
     */
    function updatePageType()
    {
        global $serendipity;

        if (!isset($this->pagetype['id'])) {
            $result = serendipity_db_insert('staticpages_types', $this->pagetype);
            $serendipity["POST"]["pagetype"] = serendipity_db_insert_id('staticpages_types', 'id');
        } else {
            $result = serendipity_db_update('staticpages_types', array('id' => $this->pagetype['id']), $this->pagetype);
        }
        if (is_string($result)) $serendipity['smarty']->assign('sp_pagetype_update', true);

        $serendipity['smarty']->assign('sp_pagetype_mixedresult', $result);
    }

    /**
     * Fetch static pages by event
     *
     * @param   boolean
     * @param   string    permalink
     * @access  private
     * @return  array
     */
    function fetchStaticPages($plugins = false, $match_permalink = '') // no more &
    {
        global $serendipity;

        $q = 'SELECT *
                FROM '.$serendipity['dbPrefix'].'staticpages
               WHERE 1 = 1';

        if (!$plugins) {
            $q .= " AND content != 'plugin'";
        }
        if ($match_permalink != '') {
            $q .= " AND permalink = '" . serendipity_db_escape_string($match_permalink) . "'";
        }
        $q .= ' ORDER BY parent_id, pageorder';

        return serendipity_db_query($q);
    }

    /**
     * Fetch pageorder for sequencer mover
     *
     * @param   boolean   (future use)
     * @access  private
     * @return  mixed array/bool
     */
    function fetchStaticPagesOrder($simple=false)
    {
        global $serendipity;

        if ($simple) {
            $q = 'SELECT id, parent_id, pagetitle, headline ';
        } else {
            $q = 'SELECT id, parent_id, pagetitle, headline, timestamp, last_modified, publishstatus ';
        }
        $q .= 'FROM '.$serendipity['dbPrefix'].'staticpages ORDER BY pageorder';

        return serendipity_db_query($q);
    }

    /**
     * Fetch published static page for frontend navigation data
     * exclude other lang, error pages and faked staticpages
     *
     * @access  private
     * @return  mixed array/bool
     */
    function fetchPublishedStaticPages() // no more &
    {
        global $serendipity;

        $q = "SELECT id, pagetitle, parent_id, permalink, shownavi, show_breadcrumb
                FROM {$serendipity['dbPrefix']}staticpages
               WHERE publishstatus = 1
                 AND articletype != 0
                 AND is_404_page = 0
                 AND (shownavi = 1 OR show_breadcrumb = 1 OR (parent_id = 0 AND shownavi = 0 AND show_breadcrumb = 0))
                 AND (language = '{$serendipity['lang']}' OR language = '' OR language = 'all')
               ORDER BY parent_id, pageorder";
        $pub = serendipity_db_query($q);

        return is_array($pub) ? $pub : false;
    }

    /**
     * Fetch static page pagetypes
     *
     * @access  private
     * @return  array
     */
    function fetchPageTypes() // no more &
    {
        global $serendipity;

        return serendipity_db_query("SELECT * FROM {$serendipity['dbPrefix']}staticpages_types", false, 'assoc');
    }

    /**
     * Fetch plugins
     *
     * @access  private
     * @return  array
     */
    function fetchPlugins() // no more &
    {
        global $serendipity;

        $q = "SELECT id, pagetitle, permalink, pre_content
                FROM {$serendipity['dbPrefix']}staticpages
               WHERE content = 'plugin'
            ORDER BY pageorder";

        $res = (array)serendipity_db_query($q, false, 'assoc');

        foreach($res AS $plugin){
            $ret[$plugin['pre_content']] = array(
                'pagetitle' => $plugin['pagetitle'],
                'permalink' => $plugin['permalink'],
                'id'        => $plugin['id']
            );
        }

        return $ret;
    }

    /**
     * Show backend
     *
     * @access  private
     * @return  string by echo template
     */
    function showBackend()
    {
        global $serendipity;

        // check sidebar plugin availability
        $sbplav = (!$this->sb_plugin_status() ? true : false);

        if (isset($serendipity['GET']['staticid']) && !isset($serendipity['POST']['staticpage'])) {
             $serendipity['POST']['staticpage'] = (int)$serendipity['GET']['staticid'];
        }

        if (isset($serendipity['GET']['pre']) && is_array($serendipity['GET']['pre'])) {
            // Allow to create a new staticpage from a bookmark link
            $serendipity['POST']['plugin']       = $serendipity['GET']['pre'];
            $serendipity['POST']['staticpage']   = '__new';
            $serendipity['POST']['staticSubmit'] = true;
        }

        $serendipity['smarty']->assign( array (
                     's9y_get_cat' => $serendipity['GET']['staticpagecategory'],
                     's9y_post_cat' => $serendipity['POST']['staticpagecategory']
        ));

        $spcat = !empty($serendipity['GET']['staticpagecategory']) ? $serendipity['GET']['staticpagecategory'] : $serendipity['POST']['staticpagecategory'];

        $serendipity['smarty']->assign('switch_spcat', $spcat);

        switch($spcat) {
            case 'pageorder':
                if ($serendipity['GET']['moveto'] == 'move') {
                    $new_order = explode(',', self::html_specialchars($serendipity['GET']['pagemoveorder']));
                    $this->move_sequence($new_order);
                }

                $pages = $this->fetchStaticPagesOrder(true);
                if (is_array($pages)) {
                    $serendipity['smarty']->assign('sp_pageorder_pages', $pages);
                }
                break;

            case 'pagetype':

                if ($serendipity['POST']['pagetype'] != '__new') {
                    $this->fetchPageType($serendipity['POST']['pagetype']);
                }

                if ($serendipity['POST']['typeSave'] == 'true' && !empty($serendipity['POST']['SAVECONF'])) {
                    $serendipity['POST']['typeSubmit'] = true;
                    $bag = new serendipity_property_bag();
                    $this->introspect($bag);
                    // actually no need, since unused in staticpage pageforms
                    #$name = self::html_specialchars($bag->get('name')); // Normally constant data ...
                    #$desc = self::html_specialchars($bag->get('description')); // ... but now it is POST data!
                    $config_t = $bag->get('type_configuration');

                    foreach($config_t AS $config_item) {
                        $cbag = new serendipity_property_bag();
                        if ($this->introspect_item_type($config_item, $cbag)) {
                            $this->pagetype[$config_item] = serendipity_get_bool($serendipity['POST']['plugin'][$config_item]);
                        }
                    }
                    $serendipity['smarty']->assign('sp_pagetype_saveconf', true);
                    $this->updatePageType();
                }

                if (!empty($serendipity['POST']['typeDelete']) && $serendipity['POST']['pagetype'] != '__new') {
                    serendipity_db_query("DELETE FROM {$serendipity['dbPrefix']}staticpages_types WHERE id = " . (int)$serendipity['POST']['pagetype']);
                    $serendipity['smarty']->assign( array (
                                 'sp_pagetype_ripped' => (int)$serendipity['POST']['pagetype'] . ' (' . $this->pagetype['description'] . ')',
                                 'sp_pagetype_purged' => true
                    ));
                }

                // case switching from existing pagetype to a new form on submit
                if (empty($this->pagetype) && $serendipity['POST']['pagetype'] == '__new') {
                    unset($serendipity['POST']['typeSave']);
                    unset($serendipity['POST']['plugin']);
                }

                $types = $this->fetchPageTypes();
                $serendipity['smarty']->assign( array (
                             'sp_pagetype' => true,
                             'sp_pagetype_types' => $types
                ));

                if (isset($serendipity['POST']['typeSubmit'])) {
                    $serendipity['POST']['staticSubmit'] = true; // RQ: Is this a need?
                    $serendipity['POST']['backend_template'] = 'typeform_staticpage_backend.tpl';
                    $bag = new serendipity_property_bag();
                    $this->introspect($bag);
                    // actually no need, since unused in staticpage pageforms
                    #$name = self::html_specialchars($bag->get('name')); // Normally constant data ...
                    #$desc = self::html_specialchars($bag->get('description')); // ... but now it is POST data!
                    $config_t = $bag->get('type_configuration');

                    foreach($config_t AS $config_item) {
                        $cbag = new serendipity_property_bag();
                        if ($this->introspect_item_type($config_item, $cbag)) {
                            $this->pagetype[$config_item] = serendipity_get_bool($serendipity['POST']['plugin'][$config_item]);
                        }
                    }
                    $serendipity['smarty']->assign('sp_pagetype_submit', true);
                    ob_start();
                      $this->showForm($this->config_types, $this->pagetype, 'introspect_item_type', 'get_type', 'typeSubmit');
                      $smarty_pagetypeshowform = ob_get_contents();
                    ob_end_clean();
                    $serendipity['smarty']->assign( array(
                                 'sp_pagetype_isshowform' => true,
                                 'sp_pagetype_showform' => trim($smarty_pagetypeshowform)
                    )); // showform is a string!
                }
                break;

            case 'pageadd':

                if (isset($serendipity['POST']['staticpagecategory']) && isset($serendipity['POST']['typeSubmit'])) {
                    if ($serendipity['POST']['staticpagecategory'] == 'pageadd'/* && (is_array($serendipity['POST']['externalPlugins']) && !empty($serendipity['POST']['externalPlugins']))*/) { // RQ: externalPlugins shall do what here?
                        $serendipity['smarty']->assign('sp_addsubmit', true);
                    }
                }
                $plugins    = $this->selectPlugins();
                $insplugins = $this->fetchPlugins();

                if (isset($serendipity['POST']['typeSubmit'])) {
                    foreach($insplugins AS $key => $values) {
                        if (empty($serendipity['POST']['externalPlugins'][$key])) {
                            serendipity_db_query('DELETE FROM '.$serendipity['dbPrefix'].'staticpages WHERE id = '.(int)$values['id']);
                        }
                    }
                    if (count($serendipity['POST']['externalPlugins'])) {
                        foreach($serendipity['POST']['externalPlugins'] AS $plugin) {
                            $this->staticpage =  array(
                                'permalink'   => $plugins[$plugin]['link'],
                                'content'     => 'plugin',
                                'pre_content' => $plugin,
                                'pagetitle'   => $plugins[$plugin]['name'],
                                'headline'    => $plugins[$plugin]['name']
                            );
                            $this->updateStaticPage();
                        }
                    }
                    $insplugins = $this->fetchPlugins(); // fetch again
                }

                if (is_array($plugins)) {
                    $serendipity['smarty']->assign( array (
                                 'sp_pageadd_plugins' => $plugins,
                                 'sp_pageadd_insplugins' => $insplugins
                    ));
                }

                $this->pluginstatus();

                $serendipity['smarty']->assign('sp_pageadd_plugstats', $this->pluginstats);
                break;

            case 'pages':
            default:

                $serendipity['smarty']->assign('sp_listpp', (int)$this->get_config('listpp', '6')); // is case 'pagedit' and '' = default by backend sidebar link
                if ($serendipity['POST']['staticpage'] != '__new') {
                    $this->fetchStaticPage($serendipity['POST']['staticpage']);
                }
                if ($serendipity['POST']['staticSave'] == 'true' && !empty($serendipity['POST']['SAVECONF'])) {
                    $serendipity['POST']['staticSubmit'] = true;
                    $serendipity['smarty']->assign('sp_staticsubmit', true);
                    $bag  = new serendipity_property_bag;
                    $this->introspect($bag);
                    // actually no need, since unused in staticpage pageforms
                    #$name = self::html_specialchars($bag->get('name')); // Normally constant data ...
                    #$desc = self::html_specialchars($bag->get('description')); // ... but now it is POST data!
                    $config_names = $bag->get('page_configuration');

                    foreach ($config_names AS $config_item) {
                        $cbag = new serendipity_property_bag;
                        if ($this->introspect_item($config_item, $cbag)) {
                            $this->staticpage[$config_item] = serendipity_get_bool($serendipity['POST']['plugin'][$config_item]);
                        }
                    }

                    $result = $this->updateStaticPage();

                    $serendipity['smarty']->assign('sp_defpages_upd_result', is_string($result) ? $result : null);
                }

                if (!empty($serendipity['POST']['staticDelete']) && $serendipity['POST']['staticpage'] != '__new') {
                    $serendipity['smarty']->assign('sp_staticdelete', true);
                    if (!$this->getChildPage($serendipity['POST']['staticpage'])) {
                        // check previous relcat table categoryid ($pcid) for a match with given staticpage $pid
                        $pcid = serendipity_db_query("SELECT categoryid FROM {$serendipity['dbPrefix']}staticpage_categorypage WHERE staticpage_categorypage = " . (int)$serendipity['POST']['staticpage'] . " LIMIT 1", true, 'assoc');
                        serendipity_db_query("DELETE FROM {$serendipity['dbPrefix']}staticpages WHERE id = " . (int)$serendipity['POST']['staticpage']);
                        // case delete staticpage by id - keep track on relcat table
                        if (is_numeric($pcid['categoryid']) && $pcid['categoryid'] > 0) {
                            $this->setCatProps((int)$pcid['categoryid'], null, true);
                        }
                        // RQ: note table combine to user? (No, since we do not do this on new staticpages either.)
                        $serendipity['smarty']->assign('sp_defpages_rip_success', DONE .': '. sprintf(RIP_ENTRY, (int)$serendipity['POST']['staticpage'] . ' (' . $this->staticpage['pagetitle'] . ')'));
                    }
                }

                if (false === serendipity_db_bool($this->get_config('showlist', 'true')) || isset($serendipity['POST']['staticpage']) ) {
                    // this is the default SELECT list block
                    $serendipity['smarty']->assign('sp_defpages_showlist', false);

                    // case start, or update, or expired cookie - make sure to get a form selected
                    if (empty($serendipity['POST']['backend_template'])) {
                        if (!empty($serendipity['COOKIE']['backend_template'])) {
                            $serendipity['POST']['backend_template'] = $serendipity['COOKIE']['backend_template'];
                        } else {
                            $serendipity['POST']['backend_template'] = 'responsive_template.tpl'; // set as (new) default form selected
                        }
                        $serendipity['smarty']->assign('sp_defpages_jsCookie', '');
                    } else {
                        $serendipity['smarty']->assign('sp_cookie_value', urlencode($serendipity['POST']['backend_template']));
                    }

                    // this file is located in backend_template dir, but needs to be excluded from select form array.
                    // ToDo: we might want to live and push all other used backend templates here also ...?
                    $exclude_files = array ('typeform_staticpage_backend.tpl');
                    $dh = @opendir(dirname(__FILE__) . '/backend_templates');
                    if ($dh) {
                        while ($file = readdir($dh)) {
                            if (!in_array($file, $exclude_files) && preg_match('@^(.*).tpl$@i', $file, $m)) {
                                if (isset($m[1]) && !empty($m[1])) $templateName = ucwords(str_replace('_', ' ', $m[1]));
                                // This is, while the file was named 'default_staticpage_backend.tpl' before.
                                // To not have compat issues with new staticpage backend form templates,
                                // new files follow naming scheme in sp_templateselector select form:
                                // eg. 'responsive_template.tpl', to show up as 'Responsive Template'
                                if ($templateName == 'Default Staticpage Backend') $templateName = STATICPAGE_TEMPLATE_EXTERNAL;
                                $ts_option[] = '<option' . ($file == $serendipity['POST']['backend_template'] ? ' selected="selected" ' : ' ') . 'value="' . self::html_specialchars($file) . '">' . self::html_specialchars($templateName) . '</option>'."\n";
                            }
                        }
                    }
                    $dh = @opendir($serendipity['serendipityPath'] . $serendipity['templatePath'] . $serendipity['template'] . '/backend_templates');
                    if ($dh) {
                        while ($file = readdir($dh)) {
                            if (!in_array($file, $exclude_files) && preg_match('@^(.*).tpl$@i', $file, $m)) {
                                if (isset($m[1]) && !empty($m[1])) $templateName = ucwords(str_replace('_', ' ', $m[1]));
                                // see upper naming convention note
                                if ($templateName == 'Default Staticpage Backend') $templateName = STATICPAGE_TEMPLATE_EXTERNAL;
                                $ts_option[] = '<option' . ($file == $serendipity['POST']['backend_template'] ? ' selected="selected" ' : ' ') . 'value="' . self::html_specialchars($file) . '">' . self::html_specialchars($templateName) .'</option>'."\n";
                            }
                        }
                    }
                    if (isset($ts_option) && is_array($ts_option)) {
                        $serendipity['smarty']->assign('sp_defpages_top', array_keys(array_flip($ts_option)));
                    }

                    $pages = $this->fetchStaticPages();
                    if (is_array($pages)) {
                        $pages = serendipity_walkRecursive($pages);
                        foreach ($pages AS $page) {
                            if ($this->checkPageUser($page['authorid'])) {
                                $ps_option[] = '<option value="' . $page['id'] . '"' . ($serendipity['POST']['staticpage'] == $page['id'] ? ' selected="selected"' : '') . '>' . str_repeat('&nbsp;&nbsp;', $page['depth']) . self::html_specialchars($page['pagetitle']) . '</option>'."\n";
                                if ($serendipity['POST']['staticpage'] == $page['id']) {
                                    $this_selected_id = $page['id'];
                                    $this_selected_name = self::html_specialchars($page['pagetitle']);
                                }
                            }
                        }
                    }
                    if (isset($ps_option) && is_array($ps_option)) {
                        $serendipity['smarty']->assign('sp_defpages_pop', $ps_option);
                    }
                    if (isset($this_selected_id)) $serendipity['smarty']->assign(array('sp_selected_id' => $this_selected_id, 'sp_selected_name' => $this_selected_name));

                    if ($sbplav) {
                        $serendipity['smarty']->assign('sp_defpages_sbplav', true);
                    }

                    if (!empty($serendipity['POST']['staticPreview'])) {
                        $link = $serendipity['baseURL'] . $serendipity['indexFile'] . '?serendipity[staticid]=' . $this->staticpage['id'] . '&serendipity[staticPreview]=1';
                        $serendipity['smarty']->assign('sp_defpages_link', $link);
                        $serendipity['POST']['staticSubmit'] = true;
                        $serendipity['smarty']->assign('sp_defpages_pagetitle', $this->staticpage['pagetitle']);
                    }

                    if ($serendipity['POST']['staticSubmit'] || isset($serendipity['GET']['staticid'])) {
                        $serendipity['POST']['plugin']['custom'] = $this->staticpage['custom'];
                        $serendipity['smarty']->assign('sp_defpages_staticsave', true);
                        ob_start();
                          $this->showForm($this->config, $this->staticpage, 'introspect_item', 'get_static', 'staticSubmit');
                          $smarty_showform = ob_get_contents();
                        ob_end_clean();
                        $serendipity['smarty']->assign('sp_defpages_showform', $smarty_showform);
                    }

                } else {
                    if (empty($serendipity['POST']['backend_template'])) {
                        if (!empty($serendipity['COOKIE']['backend_template'])) {
                            $serendipity['POST']['backend_template'] = $serendipity['COOKIE']['backend_template'];
                        }
                    }
                    if ($serendipity['POST']['listentries_formSubmit'] || $serendipity['GET']['staticid']) {
                        ob_start();
                          $this->showForm($this->config, $this->staticpage, 'introspect_item', 'get_static', 'staticSubmit');
                          $smarty_showform = ob_get_contents();
                        ob_end_clean();
                        $serendipity['smarty']->assign('sp_defpages_showform', $smarty_showform);
                    } else {
                        $serendipity['smarty']->assign( array (
                                     'sp_listentries_entries' => $this->fetchStaticPages(),
                                     'sp_listentries_authors' => $this->selectAuthors()
                        ));
                    }
                    // TODO: possibly here, real entryList pagination... (only in case there are too much entries; but then also needed for selectbox default option) - via php and external_plugins?
                    // But as long as the full fetch does not slow down, the javascript pagination is truly the best!!
                } //get_config('showlist') end
                break;
        } //end switch

        // backend escape modifier param staticpage_articleformattitle and staticpage_headline already escaped and fixed with fixUTFEntity (see 1599/1600) for ISO-8859-1

        $filename = 'backend_staticpage.tpl';

        $content = $this->parseTemplate($filename);

        echo $content;
    }

    /**
     * Sequence Drag&Drop pageorder mover
     * 
     * @param   array     new sorted id list
     * @access  private
     * @return  void
     */
    function move_sequence($order)
    {
        foreach ($order AS $key => $id) {
            serendipity_db_update('staticpages', array('id' => $id), array('pageorder' => $key));
        }
        @unlink($this->cachefile);
    }

    /**
     * Inspect config templater
     *
     * @param   string    Smarty parameter what
     * @param   int       loop counter for nugget ids
     * @param   string    config item name
     * @param   string    config value name
     * @param   string    cache type
     * @param   string    cache name
     * @param   string    cache description
     * @param   string    value
     * @param   string    cache default value
     * @param   string    lang direction
     * @param   string    config item / value
     * @param   array     radio
     * @param   array     cache radio
     * @param   array     select
     * @param   int       per row
     * @param   int       cache per row
     * @param   int       Serendipity configuration parameters (wysiwyg, iso2br)
     * @access  private
     * @return  mixed bool/string The configuration type form HTML
     */
    function inspectConfig($what, $elcount, $config_item, $config_value, $type, $cname, $cdesc, $value, $default, $lang_direction, $hvalue, $radio, $radio2, $select, $per_row, $per_row2, $conf)
    {
        global $inspectConfig;

        if ($what == 'desc') {
            echo $cdesc;
            unset($inspectConfig);
            return true;
        }

        if ($what == 'name') {
            echo $cname;
            unset($inspectConfig);
            return true;
        }

        $inspectConfig = array();

        // add some $serendipity items to check for
        $inspectConfig = $conf;

        // create global inspectConfig vars for class
        $inspectConfig['config_item']    = $config_item;
        $inspectConfig['config_value']   = $config_value;
        $inspectConfig['lang_direction'] = $lang_direction;
        $inspectConfig['type']     = $type;
        $inspectConfig['cname']    = $cname;
        $inspectConfig['cdesc']    = $cdesc;
        $inspectConfig['value']    = $value;
        $inspectConfig['elcount']  = $elcount;
        $inspectConfig['default']  = $default;
        $inspectConfig['hvalue']   = $hvalue;
        $inspectConfig['radio']    = $radio;
        $inspectConfig['radio2']   = $radio2;
        $inspectConfig['select']   = $select;
        $inspectConfig['per_row']  = $per_row;
        $inspectConfig['per_row2'] = $per_row2;

        // to make the fallback case to radio easily work, we just run these two types in here
        if ($type == 'tristate') {
            $inspectConfig['per_row'] = 3;
            $inspectConfig['radio']['value'][] = 'default';
            $inspectConfig['radio']['desc'][]  = USE_DEFAULT;
        }
        if ($type == 'boolean') {
            $inspectConfig['radio']['value'][] = 'true';
            $inspectConfig['radio']['desc'][]  = YES;

            $inspectConfig['radio']['value'][] = 'false';
            $inspectConfig['radio']['desc'][]  = NO;
        }

        // Call moduled class constructors by type
        if ($type) {
            if ($type == 'seperator') $type = 'separator'; // due to long run misspelled usage
            if ($type == 'html') $type = 'text'; // since a type class redirector errors and we only need a simple type text box creator class object for both
            if ($type == 'boolean' || $type == 'tristate') $type = 'radio'; // we only need a simple type radio creator class object
            echo "<!-- modul-type::$type - class_inspectConfig.php -->\n"; // tag dynamic form items
            $ctype = 'ic'.ucfirst($type);
            ${$ctype} = new $ctype();
            if ($type == 'text' && $conf['s9y']['wysiwyg']) {
                $this->htmlnugget[] = $elcount;
                serendipity_emit_htmlarea_code('nuggets', 'nuggets', true);
            }
            // Destroy the object - freeing memory
            unset(${$ctype});
        }
    }

    /**
     * Public Smarty inspect config templater since called by templates
     *
     * @param   array  Smarty parameter input array:
     * @param   object Smarty object
     * @access  public
     * @return  template string
     */
    public function SmartyInspectConfig($params, $smarty)
    {
        static $elcount = 0;
        global $serendipity;

        $config_item = $params['item'];
        $what = $params['what'];

        if (empty($what)) {
            $what = 'input';
        }
        // set double_escape entities check for htmlspecialchars (default true)
        $double = true;
        // allow single encode only for the ISO-8859-1 native charset
        if (LANG_CHARSET === 'ISO-8859-1') {
            $exclude = array('headline', 'articleformattitle', 'content', 'pre_content', 'title_element', 'meta_description', 'meta_keywords');
            if (in_array($config_item, $exclude)) $double = false;
        }
        // this brings pagetype into "scope". Without, value will not work, which is strange ...
        if (!empty($this->pagetype) && $serendipity['POST']['pagetype'] != '__new') {
            $this->fetchPageType($this->pagetype['id']);
        }
        // get global set show publishstatus for smartified showform and new
        if (empty($this->pagetype) && $serendipity['POST']['pagetype'] == '__new') {
            $this->staticpage['publishstatus'] = serendipity_db_bool($this->get_config('publishstatus'));
        }
        $elcount++;
        $config_value = empty($this->pagetype) ? $this->get_static($config_item, 'unset') : $this->pagetype[$config_item];
        $cbag = new serendipity_property_bag;
        // $this->staticpage can be an empty or a fullfilled array - since pagetype is only empty, if the request fetches the default_staticpage_backend.tpl template.
        if (empty($this->pagetype)) {
            $this->introspect_item($config_item, $cbag);
        } else {
            $this->introspect_item_type($config_item, $cbag);
        }

        $cname = self::html_specialchars($cbag->get('name'));
        $cdesc = self::html_specialchars($cbag->get('description'));
        $value = empty($this->pagetype) ? $this->get_static($config_item, 'unset') : $this->get_type($config_item, 'unset');

        $lang_direction = self::html_specialchars($cbag->get('lang_direction'));
        if (empty($lang_direction)) {
            $lang_direction = LANG_DIRECTION;
        }

        // Apparently no value was set for this config item
        if ($value === 'unset') {
            // Try and set the default value for the config item
            $value = $cbag->get('default');
        }

        $hvalue   = ((!isset($serendipity['POST']['staticSubmit']) || is_array($serendipity['GET']['pre'])) && isset($serendipity['POST']['plugin'][$config_item])
                    ? self::html_specialchars($serendipity['POST']['plugin'][$config_item], null, LANG_CHARSET, $double)
                    : self::html_specialchars($value, null, LANG_CHARSET, $double));

        $radio    = array();
        $select   = array();
        $per_row  = null;

        $type     = $cbag->get('type');
        $select   = $cbag->get('select_values');
        $radio2   = $cbag->get('radio');
        $per_row2 = $cbag->get('radio_per_row');
        $default  = $cbag->get('default');

        // add some $serendipity items to check for
        $conf['s9y']['wysiwyg'] = $serendipity['wysiwyg'];
        $conf['s9y']['nl2br']['iso2br'] = $serendipity['nl2br']['iso2br'];

        ob_start();
          $this->inspectConfig($what, $elcount, $config_item, $config_value, $type, $cname, $cdesc, $value, $default, $lang_direction, $hvalue, $radio, $radio2, $select, $per_row, $per_row2, $conf);
          $out = ob_get_contents();
        ob_end_clean();

        return $out;
    }

    /**
     * Public Smarty inspect config finish templater since called by templates
     *
     * @param   array  Smarty parameter input array:
     * @param   object Smarty object
     * @access  public
     * @return  template string
     */
    public function SmartyInspectConfigFinish($params, $smarty)
    {
        global $serendipity;

        ob_start();

        if (isset($serendipity['wysiwyg']) && $serendipity['wysiwyg'] && count($this->htmlnugget) > 0) {
            $ev = array('nuggets' => $this->htmlnugget, 'skip_nuggets' => false);
            serendipity_plugin_api::hook_event('backend_wysiwyg_nuggets', $ev);

            if ($ev['skip_nuggets'] === false) {
                $serendipity['smarty']->assign( array(
                             'sp_pagetype_showform_isnuggets' => true,
                             'sp_pagetype_showform_htmlnuggets' => $this->htmlnugget
                ));
            }
        }
        serendipity_plugin_api::hook_event('backend_staticpages_showform', $this->staticpage);

        $out = ob_get_contents();
        ob_end_clean();

        return $out;
    }

    /**
     * Show form templater
     *
     * @param   array     config types
     * @param   array     pagetype
     * @param   string    introspec_func name
     * @param   string    value_func name
     * @param   string    submit name
     * @access  private
     * @return  void
     */
    function showForm(&$form_values, &$form_container, $introspec_func = 'introspect_item', $value_func = 'get_static', $submit_name = 'staticSubmit')
    {
        global $serendipity;

        $this->htmlnugget = array();
        $GLOBALS['staticpage_htmlnugget'] = &$this->htmlnugget;

        if (!function_exists('serendipity_emit_htmlarea_code')) {
            include_once S9Y_INCLUDE_PATH . 'include/functions_entries_admin.inc.php';
        }

        // call moduled abstract class for form items
        if (!is_callable('inspectConfig')) {
            require_once dirname(__FILE__) . '/class_inspectConfig.php';
        }

        // get global set show publishstatus for new forms
        if ($serendipity['POST']['staticpage'] == '__new') {
            $this->staticpage['publishstatus'] = serendipity_db_bool($this->get_config('publishstatus'));
        }

        if (!is_object($serendipity['smarty'])) {
            serendipity_smarty_init();
        }
        $serendipity['smarty']->registerPlugin('function', 'staticpage_input', array($this, 'SmartyInspectConfig'));
        $serendipity['smarty']->registerPlugin('function', 'staticpage_input_finish', array($this, 'SmartyInspectConfigFinish'));

        if ($serendipity['wysiwyg']) $serendipity['smarty']->assign('custom_wysiwyg', true);

        $filename = preg_replace('@[^a-z0-9\._-]@i', '', $serendipity['POST']['backend_template']);
        // check for other templates, else set default and check for old staticpage used internal, which is removed
        if (empty($filename) || $serendipity['POST']['backend_template'] == 'internal') {
            $filename = 'responsive_template.tpl'; // set as (new) default form file
        }

        $tfile = serendipity_getTemplateFile('backend_templates/' . $filename, 'serendipityPath', true); // force fallback
        if (!$tfile || $tfile == 'backend_templates/' . $filename) {
            $tfile = serendipity_getTemplateFile($filename, 'serendipityPath');
            if (!$tfile || $tfile == $filename) {
                $tfile = dirname(__FILE__) . '/backend_templates/' . $filename;
            }
        }
        $serendipity['smarty']->assign(
                array(
                    'showmeta'       => serendipity_db_bool($this->get_config('showmeta', 'true')),
                    'form_keys'      => $form_values,
                    'form_container' => ($this->staticpage ? $this->staticpage : $this->pagetype),
                    'form_post'      => $serendipity['POST']['plugin'],
                    'form_values'    => (is_array($serendipity['POST']['plugin']) ? $serendipity['POST']['plugin'] : $this->staticpage)
                )
        );
        echo $serendipity['smarty']->fetch('file:'. $tfile);

    }

    /**
     * Is Plugin check
     *
     * @access  private
     * @return  bool
     */
    function isplugin()
    {
        global $serendipity;

        $id = $this->getPageID();
        if (is_numeric($id)) {
            $q = 'SELECT content
                    FROM '.$serendipity['dbPrefix'].'staticpages
                   WHERE id = '.$id;
            $res = serendipity_db_query($q, true, 'assoc');
            if ($res['content'] == 'plugin') {
                return true;
            }
        }
        return false;
    }

    /**
     * Show search templater
     *
     * @access  public
     * @return  string by echo template
     */
    public function showSearch()
    {
        global $serendipity;

        $term = serendipity_db_escape_string($serendipity['GET']['searchTerm']);
        if ($serendipity['dbType'] == 'postgres') {
            $group     = '';
            $distinct  = 'DISTINCT';
            $find_part = "(headline ILIKE '%$term%' OR content ILIKE '%$term%')";
        } elseif ($serendipity['dbType'] == 'sqlite' || $serendipity['dbType'] == 'sqlite3' || $serendipity['dbType'] == 'sqlite3oo' || $serendipity['dbType'] == 'pdo-sqlite') {
            $group     = 'GROUP BY id';
            $distinct  = '';
            $term      = serendipity_mb('strtolower', $term);
            $find_part = "(lower(headline) LIKE '%$term%' OR lower(content) LIKE '%$term%')";
        } else {
            $group     = 'GROUP BY id';
            $distinct  = '';
            $term      = str_replace('&quot;', '"', $term);
            if (preg_match('@["\+\-\*~<>\(\)]+@', $term)) {
                $find_part = "MATCH(headline,content) AGAINST('{$term}' IN BOOLEAN MODE)";
            } else {
                $find_part = "MATCH(headline,content) AGAINST('{$term}')";
            }
        }

        $querystring = "SELECT {$distinct} s.*, a.realname
                          FROM {$serendipity['dbPrefix']}staticpages AS s
               LEFT OUTER JOIN {$serendipity['dbPrefix']}authors AS a
                            ON a.authorid = s.authorid
                         WHERE {$find_part}
                           AND s.publishstatus = 1
                           AND s.pass = ''
                           {$group}
                      ORDER BY timestamp DESC";

        $results = serendipity_db_query($querystring);

        if (!is_array($results)) {
            if ($results !== 1 && $results !== true) {
                echo '<div class="serendipity_msg_important msg_error msg-error" style="margin: 1em 2em;">'.$results.'</div>'; // error message already escaped by serendipity_db_query()
            }
            $results = array();
        }
        // escape & fix result
        foreach ($results AS &$result) {
            foreach ($result AS &$resval) {
                $rval = self::fixUTFEntity(self::html_specialchars($resval));
            }
        }
        $serendipity['smarty']->assign(
            array(
                'staticpage_searchresults' => count($results),
                'staticpage_results'       => $results
            )
        );

        $filename = 'plugin_staticpage_searchresults.tpl';
        $content = $this->parseTemplate($filename);
        echo $content;
    }


    /**
     * -stm:
     * Fetch the id of the staticpage for a given category-id
     *
     * @param   int       cache ID
     * @param   string    key name
     * @access  private
     * @return  mixed array/bool    int if match, else false
     *
     */
    function fetchCatProp($cid, $key = 'staticpage_categorypage')
    {
        global $serendipity;

        static $cache = array();

        if (isset($cache[$cid][$key])) {
            return $cache[$cid][$key];
        }

        $props = serendipity_db_query("SELECT * FROM {$serendipity['dbPrefix']}staticpage_categorypage WHERE categoryid = " . (int)$cid . " LIMIT 1");

        if (is_array($props)) {
            $cache[$cid] = $props[0];
            return $cache[$cid][$key];
        }

        return false;
    }


    /**
     * -stm:
     * Fetch some elements of a staticpage for a given staticpage ID
     *
     * @param   int       entry ID
     * @access  private
     * @return  mixed array/bool
     *
     */
    function fetchStaticPageForCat($staticpage_id)
    {
        global $serendipity;

        $q = 'SELECT *
                FROM '.$serendipity['dbPrefix'].'staticpages
               WHERE id = '.(int)$staticpage_id.'
               LIMIT 1';

        $cache =  serendipity_db_query($q, true, 'assoc');

        if (is_array($cache)) {
             return $cache;
        }

        return false;
    }


    /**
     * -stm:
     * set the pair (categoryid, staticpage) for a given categoryid
     *
     * @param   int       cache ID
     * @param   boolean
     * @param   boolean
     * @access  private
     * @return  mixed array/bool
     *
     */
    function setCatProps($cid, $val = false, $deleteOnly = false)
    {
        global $serendipity;

        if (DEBUG_STATICPAGE) {
            echo "DEBUG: setCatProps() :: ";
            echo "category ";
            echo $cid;
            echo " staticpage ";
            echo $val['staticpage_categorypage'];
            echo "<br>\n";
        }

        serendipity_db_query("DELETE FROM {$serendipity['dbPrefix']}staticpage_categorypage
                                    WHERE categoryid = " . (int)$cid);

        if ($deleteOnly === false) {
            return serendipity_db_insert('staticpage_categorypage', $val);
        }

        return true;
    }

    /**
     * update related category property for a valid given staticpage
     *
     * @param   int       staticpage ID
     * @param   int       related category ID
     * @access  private
     * @return  boolean
     *
     */
    function setCatPropForStaticpage($id = 0, $cid)
    {
        if ($id > 0) {
            global $serendipity;

            $q = "UPDATE {$serendipity['dbPrefix']}staticpages
                     SET related_category_id = " . $cid . "
                   WHERE id = " . $id;
            serendipity_db_query($q);

            return true;
        }
        return false;
    }

    /**
     * Get related config setting of a child dependency plugin
     * gc - getChild by self instance since the sidebar being stackable
     * ci - childsInstance by value
     * cv - childsConfigValue by name
     *
     * @param   string       config name
     * @param   string       default value
     * @access  private
     * @return  boolean/null
     *
     */
    private function check_config($name, $default = NULL)
    {
        global $serendipity;

        $gc = serendipity_db_query("SELECT * FROM {$serendipity['dbPrefix']}config WHERE value LIKE '" . $this->instance . "%' LIMIT 1", true, 'assoc');
        if (is_array($gc)) {
            $ci = (string)str_replace('/dependencies', '', $gc['name']) . '/' . $name;
        }
        $cv = serendipity_db_query("SELECT * FROM {$serendipity['dbPrefix']}config WHERE name like '" . $ci . "' LIMIT 1", true, 'assoc');
        if (is_array($cv) && $gc['authorid'] == $cv['authorid']) {
            return serendipity_db_bool($cv['value']);
        } else {
            return $default;
        }
    }

    /**
     * Hook for Serendipity events, initialize plug-in "listen" to an event
     *
     * This method is called by the main plugin API for every event, that is executed.
     * You need to implement each actions that shall be performed by your plugin here.
     *
     * @access  public
     * @param   string    The name of the executed event
     * @param   object    A property bag for the current plugin
     * @param   mixed     Any referenced event data from the serendipity_plugin_api::hook_event() function
     * @param   mixed     Any additional data from the hook_event call
     * @return  bool
     */
    public function event_hook($event, &$bag, &$eventData, $addData = null)
    {
        global $serendipity;

        // check access if user is in admin group levels (admin/chief)
        $access_granted = serendipity_checkPermission('adminPlugins');

        $hooks = &$bag->get('event_hooks');

        if (isset($hooks[$event])) {
            switch ($event) {

                case 'backend_category_showForm':
                    if (!$access_granted) {
                        break;
                    }
                    // this markup happens inside backend categories, which was non smartified with 1.7 Series and below
                    $pages = $this->fetchStaticPages(true);
                    $categorypage = $this->fetchCatProp((int)$eventData);

                    if (DEBUG_STATICPAGE) {
                        echo 'DEBUG: ' . $event . " hook :: ";
                        echo "category ";
                        echo (int)$eventData . " ";
                        echo " staticpage ";
                        echo $this->fetchCatProp((int)$eventData);
                        echo "<br>\n";
                    }
                    // hooked into category.inc.tpl
?>
<div id="category_staticpage" class="clearfix">
    <div class="form_field">
        <label for="staticpage_categorypage"><?php echo STATICPAGE_CATEGORYPAGE; ?></label>
        <select name="serendipity[cat][staticpage_categorypage]">
                <option value=""><?php echo NONE; ?></option>
<?php
                $pages = $this->fetchStaticPages();
                if (is_array($pages)) {
                    $pages = serendipity_walkRecursive($pages);
                    foreach ($pages AS $page) {
                        if ($this->checkPageUser($page['authorid'])) {
                            echo ' <option value="' . $page['id'] . '"' . ($page['id'] == $this->fetchCatProp((int)$eventData) ? ' selected="selected"' : '') . '>';
                            echo str_repeat('&nbsp;&nbsp;', $page['depth']) . self::html_specialchars($page['pagetitle']) . '</option>'."\n";
                        }
                    }
                }

?>
        </select>
    </div>
</div>
<?php
                    break;

                case 'backend_category_delete':
                    if (!$access_granted) {
                        break;
                    }
                    $cid = (int)$eventData;
                    $pcp = (int)$this->fetchCatProp($cid); // fetch previous set staticpage ID from relcat table ($pcp = previous category page)

                    $this->setCatProps($cid, null, true); // do job on staticpage_categorypage table

                    // Associate this staticpage ID field 'related_category_id' to 0 for a given staticpage ID > 0
                    if ($pcp > 0) {
                        $this->setCatPropForStaticpage($pcp, 0);
                        if (DEBUG_STATICPAGE) {
                            echo 'DEBUG: ' . $event . " hook :: ";
                            echo "reset related_category_id field ";
                            echo $cid . " ";
                            echo " to 0 ON staticpage ID ";
                            echo $pcp;
                            echo "<br>\n";
                        }
                        // note this to user
                        echo '<div class="msg_notice spmsg"><span class="icon-error" aria-hidden="true"></span> ' . IMPORT_NOTES . ': ' . sprintf(RELATED_CATEGORY_CHANGE_DEL_MSG, $pcp) . '</div>';
                    }
                    break;

                case 'backend_category_update':
                case 'backend_category_addNew':
                    if (!$access_granted) {
                        break;
                    }
                    $cid = (int)$eventData;
                    $pcp = (int)$this->fetchCatProp($cid); // fetch previous set staticpage ID from relcat table ($pcp = previous category page)
                    $pid = (int)$serendipity['POST']['cat']['staticpage_categorypage'];

                    $val = array(
                        'categoryid'                => $cid,
                        'staticpage_categorypage'   => $pid,
                    );
                    // check if this is a valid staticpage_categorypage and not 0
                    if ($pid == 0) {
                        // remove from relcat table
                        $this->setCatProps($cid, null, true);
                        // and set to 0 in that associated staticpage 'related_category_field'
                        $this->setCatPropForStaticpage($pcp, 0);
                    } else {
                        $this->setCatProps($cid, $val); // do job on staticpage_categorypage table
                    }

                    // Associate this staticpage ID field 'related_category_id' for a given staticpage ID, if both are > 0 AND old and new IDs are different
                    if ($cid > 0 && $pid > 0 && $pid != $pcp) {
                        if (DEBUG_STATICPAGE) {
                            echo 'DEBUG: ' . $event . " hook :: ";
                            echo "update related_category_id field to ";
                            echo $cid . " ";
                            echo " ON staticpage ID ";
                            echo $pid;
                            echo "<br>\n";
                        }
                        $this->setCatPropForStaticpage($pid, $cid);

                        if ($event == 'backend_category_update') {
                            // and reset old staticpage related_categoryfield to 0
                            if (DEBUG_STATICPAGE) echo ' and reset old staticpage ID '.$pcp . ' related_category_id field to 0.'."<br>\n";
                            $this->setCatPropForStaticpage($pcp, 0);
                        }
                    }

                    if ($pid > 0 && $pcp != $pid) {
                        // note this to user in case we had updated real data
                        echo '<div class="msg_notice spmsg"><span class="icon-error" aria-hidden="true"></span> ' . IMPORT_NOTES . ': ' . sprintf(RELATED_CATEGORY_CHANGE_MSG, $pcp, $pid) . '</div>';
                    }
                    break;

                case 'frontend_fetchentries':
                case 'frontend_rss':
                    $this->smarty_init();
                    break;

                case 'genpage':
                    $this->setupDB();
                    if ($serendipity['rewrite'] != 'none') {
                        $nice_url = $serendipity['serendipityHTTPPath'] . $addData['uriargs'];
                    } else {
                        $nice_url = $serendipity['serendipityHTTPPath'] . $serendipity['indexFile'] . '?/' . $addData['uriargs'];
                    }
// Manko10 patch: http://board.s9y.org/viewtopic.php?f=3&t=17910&p=10426432#p10426432

                    // Check if static page exists or if this is an error 404
                    // 
                    // NOTE: as soon as you set a static page to be a 404 handler
                    // from within the backend, you need to add a specific redirect rule
                    // to your .htaccess for each static page generated by other
                    // plugins such as serendipity_event_contactform
                    // This behavior might change in future releases.
                    $this->error_404 = ($_SERVER['REDIRECT_STATUS'] == '404');

                    $pages = $this->fetchStaticPages(true, $nice_url);
                    if (is_array($pages)) {
                        foreach ($pages AS $page) {
                            if ($page['permalink'] == $nice_url) {
                                $this->error_404 = FALSE;
                                if ($pages['is_404_page']) {
                                    $this->error_404 = TRUE;
                                }
                                break;
                            }
                        }
                    }

                    // Set static page to 404 error document if page not found
                    if ($this->error_404) {
                        $serendipity['GET']['subpage'] = $this->get404Errorpage();
                    }

                    // Set static page with is_startpage flag set as startpage
                    if ((empty($args) || preg_match('@' . $serendipity['indexFile'] . '\??$@', trim($args))) && empty($serendipity['GET']['subpage'])) {
                        $serendipity['GET']['subpage'] = $this->getStartpage();
                    }

                    // Set static page according to requested URL
                    if (empty($serendipity['GET']['subpage'])) {
                        $serendipity['GET']['subpage'] = $nice_url;
                    }

                    if ($this->selected()) {
                        $te = $this->get_static('title_element');
                        if (!empty($te)) {
                            $serendipity['head_title']    = self::fixUTFEntity(self::html_specialchars($te));
                            $serendipity['head_subtitle'] = '';
                        } else {
                            $serendipity['head_title']    = self::fixUTFEntity($this->get_static('headline'));
                            $serendipity['head_subtitle'] = $serendipity['blogTitle'];
                        }
                    }
                    break;

                case 'backend_header':
                    if (!$access_granted) {
                        break;
                    }
                    // exclude this from preview.tpl entry previews
                    if (!isset($serendipity['POST']['preview'])) {
?>
    <link rel="stylesheet" href="<?php echo $serendipity['serendipityHTTPPath']; ?>plugins/serendipity_event_staticpage/staticpage_backend.css">
<?php
                    }
                    break;

                case 'frontend_header':
                    $md = self::fixUTFEntity(self::html_specialchars($this->get_static('meta_description')));
                    $mk = self::fixUTFEntity(self::html_specialchars($this->get_static('meta_keywords')));
                    if (!empty($md)) {
                        echo '    <meta name="description" content="' . $md . '">' . "\n";
                    }
                    if (!empty($mk)) {
                        echo '    <meta name="keywords" content="' . $mk . '">' . "\n";
                    }
                    break;

                case 'frontend_fetchentries':
                    if ($serendipity['GET']['action'] == 'search') {
                        serendipity_smarty_fetch('ENTRIES', 'entries.tpl', true);
                    }
                    break;

                case 'entry_display':
                    $this->smarty_init();

                    if ($this->selected()) {
                        if (is_array($eventData)) {
                            $eventData['clean_page'] = true; // This is important to not display an entry list!
                        } else {
                            $eventData = array('clean_page' => true);
                        }
                    }
                    break;

                case 'backend_sidebar_entries':
                    if (!$access_granted) {
                        break;
                    }
                    $this->setupDB(); // RQ: why here too? It is already done in genpage ?!
                    echo "\n".'                        <li><a href="?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=staticpages">' . STATICPAGE_TITLE . '</a></li>'."\n";
                    break;

                case 'backend_sidebar_entries_event_display_staticpages':
                    if (!$access_granted) {
                        break;
                    }
                    $this->showBackend(serendipity_smarty_init());
                    break;


                case 'backend_media_rename':
                    if (!$access_granted) {
                        break;
                    }
                    // Only MySQL supported, since I don't know how to use REGEXPs differently. // RQ: this is an old dev note. What shall we do about it, to enable this for other db layers?
                    if ($serendipity['dbType'] != 'mysql' && $serendipity['dbType'] != 'mysqli') {
                        echo '<span class="msg_notice"><span class="icon-info-circled" aria-hidden="true"></span> ' . STATICPAGE_MEDIA_DIRECTORY_MOVE_ENTRY . "</span>\n";
                        break;
                    }

                    // isset '' == true! Serendipity 2.1 will now support an empty oldDir to remove files to 'uploads/' root
                    if (!isset($eventData[0]['oldDir'])) {
                        break;
                    }

                    if ($eventData[0]['type'] == 'filedir' || $eventData[0]['type'] == 'file') {
                        // Path patterns to SELECT en detail
                        $oldDirThumb = $eventData[0]['oldDir'] . $eventData[0]['file']['name'] . '.' . $eventData[0]['file']['thumbnail_name'] . (($eventData[0]['file']['extension']) ? '.'.$eventData[0]['file']['extension'] : '');
                        $newDirThumb = $eventData[0]['newDir'] . $eventData[0]['file']['name'] . '.' . $eventData[0]['file']['thumbnail_name'] . (($eventData[0]['file']['extension']) ? '.'.$eventData[0]['file']['extension'] : '');
                        $oldDirFile  = $eventData[0]['oldDir'] . $eventData[0]['file']['name'] . (($eventData[0]['file']['extension']) ? '.'.$eventData[0]['file']['extension'] : '');
                        $newDirFile  = $eventData[0]['newDir'] . $eventData[0]['file']['name'] . (($eventData[0]['file']['extension']) ? '.'.$eventData[0]['file']['extension'] : '');
                        // REPLACE BY Path and Name only to also match Thumbs
                        $fromFile = $eventData[0]['oldDir'] . $eventData[0]['file']['name'];
                        $toFile   = $eventData[0]['newDir'] . $eventData[0]['file']['name'];
                        $q = "SELECT id, content, pre_content
                                FROM {$serendipity['dbPrefix']}staticpages
                               WHERE content     REGEXP '(src=|href=|window.open.)(\'|\")(" . serendipity_db_escape_String($serendipity['baseURL'] . $serendipity['uploadHTTPPath'] . $oldDirFile) . "|" . serendipity_db_escape_String($serendipity['serendipityHTTPPath'] . $serendipity['uploadHTTPPath'] . $oldDirFile) . "|" . serendipity_db_escape_String($serendipity['baseURL'] . $serendipity['uploadHTTPPath'] . $oldDirThumb) . "|" . serendipity_db_escape_String($serendipity['serendipityHTTPPath'] . $serendipity['uploadHTTPPath'] . $oldDirThumb) . ")'
                                  OR pre_content REGEXP '(src=|href=|window.open.)(\'|\")(" . serendipity_db_escape_String($serendipity['baseURL'] . $serendipity['uploadHTTPPath'] . $oldDirFile) . "|" . serendipity_db_escape_String($serendipity['serendipityHTTPPath'] . $serendipity['uploadHTTPPath'] . $oldDirFile) . "|" . serendipity_db_escape_String($serendipity['baseURL'] . $serendipity['uploadHTTPPath'] . $oldDirThumb) . "|" . serendipity_db_escape_String($serendipity['serendipityHTTPPath'] . $serendipity['uploadHTTPPath'] . $oldDirThumb) . ")'";
                    } elseif ($eventData[0]['type'] == 'dir') {
                        // RENAME vars to oldDir and newDir for the SELECT regex match and simplify query
                        // and REPLACE BY Path only to also match Thumbs
                        $fromFile = $oldDir = $eventData[0]['oldDir'];
                        $toFile   = $newDir = $eventData[0]['newDir'];
                        $q = "SELECT id, content, pre_content
                                FROM {$serendipity['dbPrefix']}staticpages
                               WHERE content     REGEXP '(src=|href=|window.open.)(\'|\")(" . serendipity_db_escape_String($serendipity['baseURL'] . $serendipity['uploadHTTPPath'] . $oldDir) . "|" . serendipity_db_escape_String($serendipity['serendipityHTTPPath'] . $serendipity['uploadHTTPPath'] . $oldDir) . ")'
                                  OR pre_content REGEXP '(src=|href=|window.open.)(\'|\")(" . serendipity_db_escape_String($serendipity['baseURL'] . $serendipity['uploadHTTPPath'] . $oldDir) . "|" . serendipity_db_escape_String($serendipity['serendipityHTTPPath'] . $serendipity['uploadHTTPPath'] . $oldDir) . ")'";
                    }
                    $dirs = serendipity_db_query($q);

                    if (is_array($dirs)) {
                        foreach($dirs AS $dir) {

                            $dir['content']     = preg_replace('@(src=|href=|window.open.)(\'|")(' . preg_quote($serendipity['baseURL'] . $serendipity['uploadHTTPPath'] . $fromFile) . '|' . preg_quote($serendipity['serendipityHTTPPath'] . $serendipity['uploadHTTPPath'] . $fromFile) . ')@', '\1\2' . $serendipity['serendipityHTTPPath'] . $serendipity['uploadHTTPPath'] . $toFile, $dir['content']);
                            $dir['pre_content'] = preg_replace('@(src=|href=|window.open.)(\'|")(' . preg_quote($serendipity['baseURL'] . $serendipity['uploadHTTPPath'] . $fromFile) . '|' . preg_quote($serendipity['serendipityHTTPPath'] . $serendipity['uploadHTTPPath'] . $fromFile) . ')@', '\1\2' . $serendipity['serendipityHTTPPath'] . $serendipity['uploadHTTPPath'] . $toFile, $dir['pre_content']);

                            $uq = "UPDATE {$serendipity['dbPrefix']}staticpages
                                      SET content     = '" . serendipity_db_escape_string($dir['content']) . "' ,
                                          pre_content = '" . serendipity_db_escape_string($dir['pre_content']) . "'
                                    WHERE id          = " . serendipity_db_escape_string($dir['id']);
                            serendipity_db_query($uq);// RQ: does it matter to serendipity_db_escape_string() content which already has been escaped ??
                        }

                        $spimgmovedtodir = sprintf(STATICPAGE_MEDIA_DIRECTORY_MOVE_ENTRIES, count($dirs));
                        printf('<span class="msg_notice"><span class="icon-info-circled" aria-hidden="true"></span> ' . $spimgmovedtodir . "</span>\n");
                    }
                    break;

                case 'external_plugin':
                    $parts = explode('_', $eventData);
                    if (!empty($parts[1])) {
                        $param = (int)$parts[1];
                    } else {
                        $param = null;
                    }
                    // might need a lib refresh some day - Please note to use this with a unique single name only, since you could else get this lib bound-in more than once!
                    if ($parts[0] == 'spdtree.js') {
                        header('Content-Type: text/javascript');
                        echo file_get_contents(dirname(__FILE__) . '/dtree.js');
                    }
                    break;

                case 'entries_header':
                    if (!$this->isplugin()) {
                        $this->show();
                    }
                    break;

                case 'entries_footer':
                    if ($serendipity['GET']['action'] == 'search' && serendipity_db_bool($this->get_config('use_quicksearch', 'true'))) {
                        $this->showSearch();
                    }
                    break;

                case 'css':
                    ob_start();
?>

/*** START staticpage event plugin css ***/

/*
 shorten very long staticpage titles by CSS,
 width: 16em is for small sidebars.
 Please overwrite for your templates needs.
*/
.sidebar_content .spp_title,
.serendipitySideBarContent .spp_title,
.sidebar_content .node,
.serendipitySideBarContent .node {
    padding-left: 0px;
    text-overflow: ellipsis;
    display: inline-block;
    width: 16em;
    white-space: nowrap;
    overflow: hidden;
    vertical-align: top;
    font-weight: normal;
}

.staticpage_index_navigation {
    margin: 0 2em 1em;
}
#staticpage_nav {
    border: 1px solid #aaa;
    margin-bottom: 1em;
}
#staticpage_nav .staticpage_navigation {
    text-align: center;
    padding: 0.2em 0.5em;
    margin: 0;
    display: block;
    border: 0 none;
    background-color: inherit;
}
#staticpage_nav .staticpage_navigation li,
#staticpage_nav .staticpage_navigation_breadcrumb {
    display: inline-block;
}
#staticpage_nav .staticpage_navigation_left {
    float: left;
}
#staticpage_nav .staticpage_navigation_center {
    text-align: center;
}
#staticpage_nav .staticpage_navigation_right {
    float: right;
}
#staticpage_nav .staticpage_navigation_breadcrumb {
    background: none repeat scroll 0% 0% #EEE;
    padding: 0.2em 0.5em;
}
#staticpage_nav .staticpage_navigation_dummy {
    color: #bbb;
}

.staticpage_metainfo {
    margin-top: 1em;
}

<?php // break after anchor - see serendipity_plugin_staticpage.php non-smarty usage not using list markup change ?>
.sidebar_content .spp_title:after,
.serendipitySideBarContent .spp_title:after {
    content:"\a";
    white-space: pre;
}

/*** END staticpage event plugin css ***/


<?php
                    $staticpage_frontpage_css = ob_get_contents();
                    ob_end_clean();

                    $eventData .= $staticpage_frontpage_css; // append CSS

                    // CSS class does NOT exist by user customized template styles, include default
                    // OR already being used by another plugin - while searching for plugin css data, we need to append - not echo - else strpos() can not access it.
                    if (strpos($eventData, '.dtree') === false) {
                        if ($this->check_config('showIcons', false)) {
                            $filename = 'dtree.css';
                            $tfile = serendipity_getTemplateFile($filename, 'serendipityPath');
                            if (!$tfile || $tfile == $filename) {
                                $tfile = dirname(__FILE__) . '/' . $filename;
                            }
                            $eventData .= file_get_contents($tfile);
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