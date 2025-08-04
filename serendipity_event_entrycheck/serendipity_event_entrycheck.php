<?php

declare(strict_types=1);

if (IN_serendipity !== true) {
    die ("Don't hack!");
}

@serendipity_plugin_api::load_language(dirname(__FILE__));

class serendipity_event_entrycheck extends serendipity_event
{
    public $title = PLUGIN_EVENT_ENTRYCHECK_TITLE;

    function introspect(&$propbag)
    {
        global $serendipity;

        $propbag->add('name',          PLUGIN_EVENT_ENTRYCHECK_TITLE);
        $propbag->add('description',   PLUGIN_EVENT_ENTRYCHECK_DESC);
        $propbag->add('stackable',     false);
        $propbag->add('author',        'Garvin Hicking, Gregor Voeltz, Ian Styx');
        $propbag->add('version',       '2.0.1');
        $propbag->add('requirements',  array(
            'serendipity' => '5.0',
            'smarty'      => '4.1',
            'php'         => '8.2'
        ));
        $propbag->add('event_hooks',    array(
            'backend_entry_updertEntry' => true,
            'backend_entry_checkSave'   => true,
            'backend_entryform'         => true,
            'css'                       => true
        ));
        $propbag->add('groups', array('BACKEND_EDITOR'));
        $propbag->add('configuration', array('emptyCategories', 'emptyTitle', 'emptyBody', 'emptyExtended', 'defaultCat', 'locking'));
    }

    function introspect_config_item($name, &$propbag)
    {
        global $serendipity;

        switch($name) {
            case 'locking':
                $propbag->add('type',        'boolean');
                $propbag->add('name',        PLUGIN_EVENT_ENTRYCHECK_LOCKING);
                $propbag->add('description', PLUGIN_EVENT_ENTRYCHECK_LOCKING_DESC);
                $propbag->add('default',     'false');
                break;

            case 'emptyCategories':
                $propbag->add('type',        'boolean');
                $propbag->add('name',        PLUGIN_EVENT_ENTRYCHECK_EMPTYCATEGORIES);
                $propbag->add('description', PLUGIN_EVENT_ENTRYCHECK_EMPTYCATEGORIES_DESC);
                $propbag->add('default',     'false');
                break;

            case 'emptyTitle':
                $propbag->add('type',        'boolean');
                $propbag->add('name',        PLUGIN_EVENT_ENTRYCHECK_EMPTYTITLE);
                $propbag->add('description', PLUGIN_EVENT_ENTRYCHECK_EMPTYTITLE_DESC);
                $propbag->add('default',     'false');
                break;

            case 'emptyBody':
                $propbag->add('type',        'boolean');
                $propbag->add('name',        PLUGIN_EVENT_ENTRYCHECK_EMPTYBODY);
                $propbag->add('description', PLUGIN_EVENT_ENTRYCHECK_EMPTYBODY_DESC);
                $propbag->add('default',     'false');
                break;

            case 'emptyExtended':
                $propbag->add('type',        'boolean');
                $propbag->add('name',        PLUGIN_EVENT_ENTRYCHECK_EMPTYEXTENDED);
                $propbag->add('description', PLUGIN_EVENT_ENTRYCHECK_EMPTYEXTENDED_DESC);
                $propbag->add('default',     'false');
                break;

            case 'defaultCat':
                $cats = serendipity_fetchCategories($serendipity['authorid']);
                if (!is_array($cats)) {
                    return false;
                }

                $catlist = serendipity_generateCategoryList($cats, array(0), 4, 0, 0, '', ' . ');
                $tmp_select_cats = explode('@@@', $catlist);

                if (!is_array($tmp_select_cats)) {
                    return false;
                }

                $select_cats = array();
                $select_cats['none'] = NONE;
                foreach($tmp_select_cats AS $cidx => $tmp_select_cat) {
                    $select_cat = explode('|||', $tmp_select_cat);
                    if (!empty($select_cat[0]) && !empty($select_cat[1])) {
                        $select_cats[$select_cat[0]] = $select_cat[1];
                    }
                }

                $propbag->add('type',          'select');
                $propbag->add('select_values', $select_cats);
                $propbag->add('name',          PLUGIN_EVENT_ENTRYCHECK_DEFAULTCAT);
                $propbag->add('description',   PLUGIN_EVENT_ENTRYCHECK_DEFAULTCAT_DESC);
                $propbag->add('default',       'none');
                break;
        }
        return true;
    }

    function generate_content(&$title)
    {
        $title = $this->title;
    }

    function checkLock(&$state, $id)
    {
        global $serendipity;

        $locked = serendipity_db_query("SELECT property, value FROM {$serendipity['dbPrefix']}entryproperties WHERE (property = 'locked' OR property = 'lock_owner') AND entryid = " . (int)$id, false, 'assoc', false, 'property', 'value');
        if (is_array($locked) && $locked['locked'] > 0 ) {
            // Entry is locked

            // Check if it should timeout after one hour
            if ($locked['locked'] < (time() - 3600) || (isset($serendipity['GET']['unlock']) && $serendipity['GET']['unlock'] == 'true')) {
                serendipity_db_query("DELETE FROM {$serendipity['dbPrefix']}entryproperties WHERE (property = 'locked' OR property = 'lock_owner') AND entryid = " . (int)$id);
                $state = 'liberate';
            } else {
                $state = 'locked';
            }
        }

        if ($state == 'locked' && $locked['lock_owner'] != $serendipity['authorid']) {
            return false;
        } else {
            return true;
        }
    }

    function event_hook($event, &$bag, &$eventData, $addData = null)
    {
        global $serendipity;
        static $state, $locked;

        $hooks = &$bag->get('event_hooks');

        if (isset($hooks[$event])) {

            switch($event) {
                case 'css':
                    $eventData .= '

/* entrycheck plugin start */

body.save_preview_body .msg_error {
    font-size: inherit;
}

/* entrycheck plugin end */

';
                    break;

                case 'backend_entryform':
                    if (!isset($eventData['id']) || $eventData['id'] < 1) {
                        return true;
                    }

                    $time  = time();
                    $state = 'unlocked';
                    if (serendipity_db_bool($this->get_config('locking', 'false')) === true) {
                        $this->checkLock($state, $eventData['id']);

                        if ($state == 'unlocked') {
                            // Entry is not yet locked
                            serendipity_db_query("INSERT INTO {$serendipity['dbPrefix']}entryproperties (property, value, entryid) VALUES ('locked', '$time', {$eventData['id']})");
                            serendipity_db_query("INSERT INTO {$serendipity['dbPrefix']}entryproperties (property, value, entryid) VALUES ('lock_owner', '{$serendipity['authorid']}', {$eventData['id']})");
                            $locked = array('lock_owner' => $serendipity['authorid'], 'locked' => $time);
                            // By now it is locked
                        }

                        if ($state != 'liberate' && !empty($locked['lock_owner'])) {
                            $owner = serendipity_fetchAuthor($locked['lock_owner']);
                            $link = '<a href="serendipity_admin.php?serendipity[action]=admin&amp;serendipity[adminModule]=entries&amp;serendipity[adminAction]=edit&amp;serendipity[id]=' . (int)$eventData['id'] . '&amp;serendipity[unlock]=true&amp;' . serendipity_setFormToken('url') . '" class="link_button">' . PLUGIN_EVENT_ENTRYCHECK_UNLOCK . '</a>';
                            printf('<div class="msg_notice">' . PLUGIN_EVENT_ENTRYCHECK_LOCKED . ' ' . $link . '</div>', $owner[0]['realname'], serendipity_strftime(DATE_FORMAT_SHORT, (int)$locked['locked']));
                        }
                    }
                    break;

                case 'backend_entry_updertEntry':
                    if (serendipity_db_bool($this->get_config('emptyCategories', 'false') === true) && (isset($addData['categories']) && count($addData['categories']) < 1) || (isset($addData['categories'][0]) && $addData['categories'][0] == '0')) {
                        $eventData[] = PLUGIN_EVENT_ENTRYCHECK_EMPTYCATEGORIES_WARNING;
                    }

                    if (serendipity_db_bool($this->get_config('emptyTitle', 'false') === true) && strlen($addData['title']) < 1) {
                        $eventData[] = PLUGIN_EVENT_ENTRYCHECK_EMPTYTITLE_WARNING;
                    }

                    if (serendipity_db_bool($this->get_config('emptyBody', 'false') === true) && strlen($addData['body']) < 1) {
                        $eventData[] = PLUGIN_EVENT_ENTRYCHECK_EMPTYBODY_WARNING;
                    }

                    if (serendipity_db_bool($this->get_config('emptyExtended', 'false') === true) && strlen($addData['extended']) < 1) {
                        $eventData[] = PLUGIN_EVENT_ENTRYCHECK_EMPTYEXTENDED_WARNING;
                    }

                    if ($addData['id'] > 0 && serendipity_db_bool($this->get_config('locking', 'false')) === true) {
                        $state = 'unlocked';
                        if (!$this->checkLock($state, $addData['id'])) {
                            $eventData[] = PLUGIN_EVENT_ENTRYCHECK_LOCK_WARNING;
                        }
                    }
                    break;

                case 'backend_entry_checkSave':
                    // Emit JavaScript
?>
                        if (document.getElementById) {
                            <?php if ($state == 'locked' && $locked['lock_owner'] != $serendipity['authorid']) { ?>
                            alert('<?php echo str_replace("'", "\\'", PLUGIN_EVENT_ENTRYCHECK_LOCK_WARNING); ?>');
                            error = true;
                            <?php } ?>

                            defaultcat = '<?php echo $this->get_config('defaultCat'); ?>';
                            el = document.getElementById('categoryselector');
                            empty_category = false;
                            if (el.options[0].selected) {
                                empty_category = true;
                            }

                            for (i = 1; i < el.options.length; i++) {
                                if (el.options[i].selected) {
                                    empty_category = false;
                                }
                            }

                            error = false;
                            if (empty_category) {
                                showerror = true;
                                if (defaultcat != 'none' && defaultcat != '') {
                                    for (i = 1; i < el.options.length; i++) {
                                        if (el.options[i].value == defaultcat) {
                                            el.options[i].selected = true;
                                            showerror = false;
                                            el.selectedIndex = i;
                                        }
                                    }
                                }

<?php if (serendipity_db_bool($this->get_config('emptyCategories', 'false'))) { ?>
                                if (showerror) {
                                    alert('<?php echo str_replace("'", "\\'", PLUGIN_EVENT_ENTRYCHECK_EMPTYCATEGORIES_WARNING); ?>');
                                    error = true;
                                }
<?php } ?>
                            }

                            <?php if (serendipity_db_bool($this->get_config('emptyTitle', 'false')) == true) { ?>
                            if (document.getElementById('entryTitle').value.length < 1) {
                                alert('<?php echo str_replace("'", "\\'", PLUGIN_EVENT_ENTRYCHECK_EMPTYTITLE_WARNING); ?>');
                                error = true;
                            }
                            <?php } ?>

                            <?php if (serendipity_db_bool($this->get_config('emptyBody', 'false')) == true) { ?>
                            if (typeof(editorbody) != "undefined") {
                                editorbody.setMode('textmode');
                                var serendipitybody = document.getElementById('serendipity[body]').value.replace(/(<([^>]+)>)/ig,"");
                            } else {
                                var serendipitybody = document.getElementById('serendipity[body]').value;
                            }
                            if (serendipitybody.length < 1) {
                                alert('<?php echo str_replace("'", "\\'", PLUGIN_EVENT_ENTRYCHECK_EMPTYBODY_WARNING); ?>');
                                error = true;
                            }
                            if (typeof(editorbody) != "undefined") {
                                editorbody.setMode('wysiwyg');
                            }
                            <?php } ?>

                            <?php if (serendipity_db_bool($this->get_config('emptyExtended', 'false')) == true) { ?>
                            if (typeof(editorextended) != "undefined") {
                                editorextended.setMode('textmode');
                                var serendipityextended = document.getElementById('serendipity[extended]').value.replace(/(<([^>]+)>)/ig,"");
                            } else {
                                var serendipityextended = document.getElementById('serendipity[extended]').value;
                            }
                            if (serendipityextended.length < 1) {
                                alert('<?php echo str_replace("'", "\\'", PLUGIN_EVENT_ENTRYCHECK_EMPTYEXTENDED_WARNING); ?>');
                                error = true;
                            }
                            if (typeof(editorextended) != "undefined") {
                                editorextended.setMode('wysiwyg');
                            }
                            <?php } ?>

                            if (error) {
                                return false;
                            }
                        }
<?php
                    break;
            }
            return true;
        } else {
            return false;
        }
    }

}

/* vim: set sts=4 ts=4 expandtab : */
?>