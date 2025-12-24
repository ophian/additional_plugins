<?php

declare(strict_types=1);

if (IN_serendipity !== true) {
    die ("Don't hack!");
}

@serendipity_plugin_api::load_language(dirname(__FILE__));

class serendipity_event_emoticonchooser extends serendipity_event
{
    public $title = PLUGIN_EVENT_EMOTICONCHOOSER_TITLE;

    function cleanup()
    {
        // Cleanup. Remove all empty configuration sets on SAVECONF-Submit.
        serendipity_plugin_api::remove_plugin_value($this->instance, array('frontend'));

        return true;
    }

    function introspect(&$propbag)
    {
        global $serendipity;

        $propbag->add('name',          PLUGIN_EVENT_EMOTICONCHOOSER_TITLE);
        $propbag->add('description',   PLUGIN_EVENT_EMOTICONCHOOSER_DESC);
        $propbag->add('stackable',     false);
        $propbag->add('author',        'Garvin Hicking, Jay Bertrandt, Ian Styx');
        $propbag->add('requirements',  array(
            'serendipity' => '5.0',
            'smarty'      => '4.1',
            'php'         => '8.2'
        ));
        $propbag->add('version',       '4.1.4');
        $propbag->add('event_hooks',    array(
            'backend_entry_toolbar_extended' => true,
            'backend_entry_toolbar_body'     => true,
            'backend_wysiwyg'                => true,
            'external_plugin'                => true,
            'frontend_comment'               => true,
            'backend_header'                 => true,
            'frontend_footer'                => true,
            'css_backend'                    => true,
            'css'                            => true
        ));
        $propbag->add('groups', array('BACKEND_EDITOR'));
        $propbag->add('configuration', array('comments', 'popup', 'button', 'popuptext'));
    }

    function performConfig(&$bag)
    {
        $old_var = serendipity_db_bool($this->get_config('frontend', '', false)); // must be an empty string value with false. Else it gets created by this call again (even for an not existing configuration item var) every time you open the emoticonchooser plugin config
        // set 'frontend' to 'comments' option on Plugin configuration call
        if (isset($old_var) && $old_var === true) {
            $this->set_config('comments', 'true');
            $this->set_config('frontend', ''); // unset the value to an empty for auto cleanup gc
        };
    }

    function generate_content(&$title)
    {
        $title = PLUGIN_EVENT_EMOTICONCHOOSER_TITLE;
    }

    function introspect_config_item($name, &$propbag)
    {
        switch($name) {
            case 'comments':
                $propbag->add('type',        'boolean');
                $propbag->add('name',        PLUGIN_EVENT_EMOTICONCHOOSER_COMMENTS);
                $propbag->add('description', '');
                $propbag->add('default',     'false');
                break;

            case 'popup':
                $propbag->add('type',        'boolean');
                $propbag->add('name',        PLUGIN_EVENT_EMOTICONCHOOSER_POPUP);
                $propbag->add('description', '');
                $propbag->add('default',     'false');
                break;

            case 'button':
                $propbag->add('type',        'boolean');
                $propbag->add('name',        PLUGIN_EVENT_EMOTICONCHOOSER_POPUP_BUTTON);
                $propbag->add('description', 'default: as link');
                $propbag->add('default',     'false');
                break;

            case 'popuptext':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_EVENT_EMOTICONCHOOSER_POPUPTEXT);
                $propbag->add('description', '');
                $propbag->add('default',     PLUGIN_EVENT_EMOTICONCHOOSER_POPUPTEXT_DEFAULT);
                break;

            default:
                return false;
        }
        return true;
    }

    function example() {
        return '<span class="msg_notice"><span class="icon-info-circled" aria-hidden="true"></span> ' . PLUGIN_EVENT_EMOTICONCHOOSER_TOOLBAR_DESC . '</span>';
    }

    /**
     * Creates the template for either the WYSIWYG-Editor OR the magnific/popup window
     */
    function show()
    {
        global $serendipity;

        if (IN_serendipity !== true) {
            die ("Don't hack!");
        }
        // get the stored "cache"
        $area = $_area = str_replace(['emoticonchooser_serendipity_textarea_', 'emoticonchooser_'], '', $_GET['txtarea']);
        $file = $this->get_config("emotics[$area]");
        if (empty($file)) {
            $file = $this->get_config('emotics'); // get the fallback body cache
            $file = @str_replace('serendipity_textarea_body', "$_area", $file); // catch empty nuggets or quicknote - hide possible error in virgin case
        }
        $file = @str_replace(array(' style="; display: none"', ' style="display: none;"', '</div><!-- emoticon_bar end -->'), '', $file); // we don't want this here! (see "lazy cache")
        $mode = (isset($serendipity['dark_mode']) && $serendipity['dark_mode'] === true) ? 'data-color-mode="dark" ' : 'data-color-mode="slight" ';
        /* THE LAYER VIEW */
?>
<!DOCTYPE html>
<html <?=$mode?>class="no-js page_emochr" dir="ltr" lang="<?=$serendipity['lang']?>">
<head>
    <meta charset="<?=LANG_CHARSET?>">
    <title>Serendipity <?=PLUGIN_EVENT_EMOTICONCHOOSER_POPUPTEXT_DEFAULT?></title>
    <link rel="stylesheet" href="<?=$serendipity['baseURL']?>serendipity.css.php?serendipity[css_mode]=serendipity_admin.css">
    <style>
        html[data-color-mode="dark"].page_emochr {
            background: #22272e;
            color: #adbac7;
        }
        .serendipity_emoticonchooser_page .emoticonchooser {
            display: block;
            margin: 1em auto auto;
        }
        #main_emoticonchooser {
            border: 1px solid #BBB;
            background: none repeat scroll 0% 0% #EEE;
            padding: 0.75em;
            margin: 0px 0px 1em;
        }
        #main_emoticonchooser legend {
            border: 1px solid #72878A;
            background: none repeat scroll 0% 0% #DDD;
            padding: 2px 5px;
        }
        [data-color-mode="dark"] #main_emoticonchooser {
            border-color: #444c56;
            background: #1c2128cc;
        }
        [data-color-mode="dark"] #main_emoticonchooser legend {
            border-color: #444c56;
            background: #323941;
        }
    </style>
    <script>
        function emoticonchooser(instance_name = '', this_instance = '') {
            const capturingRegex = /(?<area>nugget|quick)/; //all nuggets(\d+) and plugin adminnotes quicknote // NO QUOTES !!!!
            const found = instance_name.match(capturingRegex);
            const instance = (found !== null) ? instance_name : this_instance;
            const use_emoticon = 'use_emoticon_'+instance_name;

            // works on both: enableBackendPopup or MFP- layer
            window[use_emoticon] = function (item) {
                try {
                    window.parent.parent.serendipity.serendipity_imageSelector_addToBody(item, instance);
                    window.parent.parent.$.magnificPopup.close();
                }
                catch (e) {
                    self.opener.serendipity.serendipity_imageSelector_addToBody(item, instance);
                    self.close();
                }
            }
        }
    </script>
</head>

<body id="serendipity_admin_page" class="serendipity_emoticonchooser_page">
    <main id="workspace" class="clearfix">
        <div id="content" class="clearfix">

            <div class="emoticonchooser">
                <form action="" method="post">
                    <input type="hidden" name="txtarea" value="<?php echo htmlspecialchars($_GET['txtarea']) ?>">
                    <fieldset id="main_emoticonchooser" class="">
                        <legend><?php echo PLUGIN_EVENT_EMOTICONCHOOSER_POPUPTEXT_DEFAULT ?></legend>

                        <?php echo $file; ?>

                    </fieldset>
                </form>
            </div>

        </div>
    </main>
</body>
</html>
<?php
    }

    function event_hook($event, &$bag, &$eventData, $addData = null)
    {
        global $serendipity, $emotics;

        if (!class_exists('serendipity_event_emoticate')) {
            return false;
        }

        $hooks = &$bag->get('event_hooks');

        $comments = false;

        if (isset($hooks[$event])) {

            switch($event) {

                // frontend commentform, backend comments edit/reply commentform
                case 'frontend_comment':
                    // per option OR per state allowHtmlComment true, so break PLAIN TEXT (editor) only building button, script and content
                    if (serendipity_db_bool($this->get_config('comments', 'false')) === false || $serendipity['allowHtmlComment']) {
                        break; // TinyMCE itself has Emojis and isn't able to place emoticons like CKE was... (see conditional below for the js file binding)
                    }

                    $txtarea = 'serendipity_commentform_comment';
                    $func    = 'comment';
                    $style   = '';
                    $popcl   = '';
                    $comments = true; // have in mind, this is also true in the Backend while having added the {serendipity_hookPlugin hook="frontend_comment"} hook call
                                      // to the admin/commentform.tpl for s9ymarkup/spamblock/emoticonchooser alike plugins.
                    // no break [PSR-2] - extends backend_entry_toolbar_extended

                case 'backend_entry_toolbar_extended':
                    if (!isset($txtarea)) {
                        $txtarea = 'serendipity_textarea_extended';
                        $func    = 'extended';
                    }
                    // no break [PSR-2] - extends backend_entry_toolbar_body

                case 'backend_entry_toolbar_body':
                    if (!isset($txtarea)) {
                        if (isset($eventData['backend_entry_toolbar_body:textarea'])) {
                            // event caller has given us the name of the textarea converted
                            // into a WYSIWYG editor (for example, the staticpages plugin)
                            $txtarea = $eventData['backend_entry_toolbar_body:textarea'];
                        } else {
                            // default value
                            $txtarea = 'serendipity_textarea_body';
                        }
                        if (isset($eventData['backend_entry_toolbar_body:nugget'])) {
                            $func = $eventData['backend_entry_toolbar_body:nugget'];
                        } else {
                            $func = 'body';
                        }
                    }

                    if ((!isset($serendipity['wysiwyg']) || !$serendipity['wysiwyg']) || $comments) {
                        $popcl = ' serendipityPrettyButton';

                        if (!isset($style)) {
                            $style = 'margin-top: 5px; vertical-align: bottom';
                        }

                        $popupstyle = '';
                        $popuplink  = '';
                        $button = serendipity_db_bool($this->get_config('button', 'false'));
                        $backend = (defined('IN_serendipity_admin') && IN_serendipity_admin === true);
                        if (serendipity_db_bool($this->get_config('popup', 'false'))) {
                            $popupstyle = !empty($style) ? '; display: none' : '';
                            $popuplink  = ($backend || (!$backend && $button))
                                        ? '<input type="button" onclick="toggle_emoticon_bar_' . $func . '(); return false" href="#" class="serendipity_toggle_emoticon_bar' . $popcl . '" value="'.$this->get_config('popuptext').'">'
                                        : '<a class="serendipity_toggle_emoticon_bar' . $popcl . '" href="#" onclick="toggle_emoticon_bar_' . $func . '(); return false">' . $this->get_config('popuptext') . '</a>';
                        }
                    }

                    $i = 1;

                    // This plugin wants to access serendipity_event_emoticate. Its methods are non-static
                    // and it's not properly working with PHP5 to call. So to perform properly, let's take
                    // the actual plugin:
                    $plugins = serendipity_plugin_api::get_event_plugins();
                    $emoticate_plugin = null;
                    foreach($plugins AS $plugin => &$plugin_data) {
                        if (FALSE !== strpos($plugin, 'serendipity_event_emoticate')) {
                            $emoticate_plugin =& $plugin_data['p'];
                            break;
                        }
                    }

                    if ($emoticate_plugin === null) {
                        return;
                    }

                    $emoticons = $emoticate_plugin->getEmoticons();
                    $unique = array();
                    foreach($emoticons AS $key => $value) {
                        if (is_callable(array($emoticate_plugin, 'humanReadableEmoticon'))) {
                            $key = $emoticate_plugin->humanReadableEmoticon($key);
                        }
                        $unique[$value] = $key;
                    }

                    $emoticon_bar = null;

                    // script include has to stick to backend_header, while using an inline onclick (see above)
                    if (defined('IN_serendipity_admin') && IN_serendipity_admin === true) { // This is case entries, isn't it?! YES, and staticpages nuggets!
                        if (empty($serendipity['wysiwyg'])) {
                            $next = '';
                            echo "$popuplink\n"; // append toolbar button to backend entries in PLAIN EDITOR toolbar. NO onready state loading !! - root indent & linespace after for consistency, please !
                            if ($serendipity['GET']['adminModule'] == 'comments' && ($serendipity['GET']['adminAction'] == 'edit' || $serendipity['GET']['adminAction'] == 'reply' || $serendipity['POST']['preview'])) {
                                $next = ' emotin';
                            }

?>

<div class="serendipity_emoticon_bar<?php echo $next; ?>">
    <script type="text/javascript">
        emoticonchooser('<?php echo $func; ?>', '<?php echo $txtarea; ?>');
    </script>

<?php
                            $emoticon_bar = true;
                        }
                        if (isset($serendipity['wysiwyg']) && $serendipity['wysiwyg'] && isset($popuplink) && !$serendipity['allowHtmlComment']) {
                            echo "    $popuplink\n"; // add toolbar button in backend entries above RT-EDITOR toolbar or below in case of PLAIN TEXT comment editing
                        }
                    } else { // in frontend footer ONLY!
                        if (empty($serendipity['allowHtmlComment'])) {
                            $emoticon_bar = true;
?>

<div class="serendipity_emoticon_bar">
    <script type="text/javascript">
        document.onreadystatechange = function () {
            if (document.readyState == "interactive") {
                emoticonchooser('<?php echo $func; ?>', '<?php echo $txtarea; ?>');
            }
        }
    </script>

<?php
                            echo "    $popuplink\n";
                        }
                    }

                    $emotics = ''; // init default

                    // this is case WYSIWYG (magnific) popup backend mode AND/OR comment backend mode
                    if ((isset($serendipity['wysiwyg']) && $serendipity['wysiwyg']) && (defined('IN_serendipity_admin') && IN_serendipity_admin === true)) {
                        $style = '';
                        if ($serendipity['GET']['adminModule'] == 'comments' && ($serendipity['GET']['adminAction'] == 'edit' || $serendipity['GET']['adminAction'] == 'reply' || $serendipity['POST']['preview'])) {
                            // void
                            // YEAH this works well for FRONTEND entries in either/or WYSIWYG mode,
                            // BACKEND comments [non-wysiwyg] edit, reply, preview, icon-insert and
                            // BACKEND comments [wysiwyg] edit, reply, preview, (simple textarea-mode) icon-insert, since it is in WYSIWYG insert mode
                            if (!isset($serendipity['GET']['adminModule']) && $serendipity['GET']['adminModule'] == 'plugins') {
                                $popupstyle = 'display: none;';
                            }
                        } else {
                            // BACKEND normal [wysiwyg] case in entries, staticpages, but NOT for the simplified ones in nuggets or comments
                            $popupstyle = 'display: inline-flex;';
                        }

                        $emotics .= "

    <script type=\"text/javascript\">
        document.onreadystatechange = function () {
            if (document.readyState == 'interactive') {
                emoticonchooser('$func', '$txtarea');
            }
        }
    </script>

";
                    }

                    $emotics .= '    <div id="serendipity_emoticonchooser_' . $func . '" style="' . $style . $popupstyle . '">'."\n";
                    foreach($unique AS $value => $key) {
                        $emotics .= '        <a href="javascript:use_emoticon_' . $func . '(\'' . addslashes($key) . '\')" title="' . $key . '"><img src="'. $value .'" style="border: 0px" alt="' . $key . '" /></a>&nbsp;'."\n";
                        if ($i++ % 10 == 0) {
                            $emotics .= "        <br />\n";
                        }
                    }
                    $emotics .= "    </div>\n\n";
                    // Close in all frontend AND all non-wysiwyg backend modes - but NOT in HTML nuggets
                    if (((!isset($serendipity['GET']['adminModule']) || !isset($serendipity['wysiwyg']) || !$serendipity['wysiwyg'])
                      || (isset($serendipity['GET']['adminModule']) && $serendipity['GET']['adminModule'] != 'comments' && $comments))
                      && $emoticon_bar === true) {
                        $emotics .= "</div><!-- emoticon_bar end -->\n\n";
                    }
                    if (isset($serendipity['wysiwyg']) && $serendipity['wysiwyg']) {
                        $name = "emotics[{$func}]";
                        // we still have unfilled nuggets or quicknote caches placed to config assumingly done by plugin API somewhere... strange... but not by here
                        $this->set_config($name, $emotics); //cache this differently by area name
                        if ($func == 'body') {
                            $this->set_config('emotics', $emotics); //cache this extra? Yes, as a fallback for other nuggets and adminnotes with runtime replacements!
                        }
                        if ($comments) {
                            echo $emotics;
                        }
                    } else {
                        echo $emotics;
                    }
                    break;

                case 'backend_header':
                    if (isset($serendipity['wysiwyg']) && $serendipity['wysiwyg']) {
                        $noemojs = true;
                    }
                    // no-BREAK! [PSR-2] - extends frontend_footer

                case 'frontend_footer':
                    // don't load with allowHtmlComment true for TinyMCE in frontend commentform
                    if ((empty($serendipity['allowHtmlComment']) && empty($noemojs)) || (isset($serendipity['GET']['adminModule']) && $serendipity['GET']['adminModule'] == 'comments' && empty($serendipity['allowHtmlComment']) && ($serendipity['GET']['adminAction'] == 'edit' || $serendipity['GET']['adminAction'] == 'reply' || isset($serendipity['POST']['preview'])))) {
?>
    <script type="text/javascript" src="<?php echo $serendipity['serendipityHTTPPath'] . 'plugins/serendipity_event_emoticonchooser/emoticonchooser.js'; ?>"></script>
<?php
                    }
                    break;

                case 'backend_wysiwyg':
                    $link = $serendipity['serendipityHTTPPath'] . ($serendipity['rewrite'] == 'none' ? $serendipity['indexFile'] . '?/' : '') . 'plugin/emoticonchooser' . ($serendipity['rewrite'] != 'none' ? '?' : '&amp;') . 'txtarea=emoticonchooser_'.$eventData['item'];
                    $eventData['buttons'][] = array(
                        'id'         => 'emoticon_' . $eventData['item'],
                        'name'       => PLUGIN_EVENT_EMOTICONCHOOSER_TITLE,
                        'javascript' => 'function() { serendipity.openPopup(\'' . $link . '\', \'EmoticonChooser\') }',
//                        'img_url'    => $serendipity['serendipityHTTPPath'] . ($serendipity['rewrite'] == 'none' ? $serendipity['indexFile'] . '?/' : '') . 'plugin/plugin_emoticon.png',
                        'svg'        => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="yellow" class="bi bi-emoji-smile-fill bi-emoji-smile-fillCo" viewBox="0 0 16 16"><path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16M7 6.5C7 7.328 6.552 8 6 8s-1-.672-1-1.5S5.448 5 6 5s1 .672 1 1.5M4.285 9.567a.5.5 0 0 1 .683.183A3.5 3.5 0 0 0 8 11.5a3.5 3.5 0 0 0 3.032-1.75.5.5 0 1 1 .866.5A4.5 4.5 0 0 1 8 12.5a4.5 4.5 0 0 1-3.898-2.25.5.5 0 0 1 .183-.683M10 8c-.552 0-1-.672-1-1.5S9.448 5 10 5s1 .672 1 1.5S10.552 8 10 8"/></svg>',
// no need, since we have a css_backend hook. Else use this
//                        'css'        => '.bi.bi-emoji-smile-fill.bi-emoji-smile-fillCo { fill: gold; border-radius: 1rem; background-color: black; }[data-color-mode="dark"] .bi.bi-emoji-smile-fill.bi-emoji-smile-fillCo { border-radius: unset; background-color: unset; }',
                        'toolbar'    => 'other'
                    );
                    break;

                case 'css_backend':
                    $eventData .= '

/* emoticonchooser plugin start */

.bi.bi-emoji-smile-fill.bi-emoji-smile-fillCo { fill: gold; border-radius: 1rem; background-color: black; }
[data-color-mode="dark"] .bi.bi-emoji-smile-fill.bi-emoji-smile-fillCo { border-radius: unset; background-color: unset; }

.serendipity_toggle_emoticon_bar.serendipityPrettyButton {
    margin: 1em auto 1px;
}
.serendipity_emoticon_bar {
    text-align: right;
}
.serendipity_emoticon_bar.emotin {
    display: inline;
}

/* emoticonchooser plugin end */

';
                    break;

                case 'css':
                    $eventData .= '

/* emoticonchooser plugin start */

.serendipity_emoticon_bar {
    margin-bottom: .75em;
}

/* emoticonchooser plugin end */

';
                    break;

                case 'external_plugin':
                    if ($_SESSION['serendipityAuthedUser'] !== true)  {
                        return true;
                    }
                    $uri_parts = explode('?', str_replace('&amp;', '&', $eventData));
                    $parts     = explode('&', $uri_parts[0]);
                    $uri_part  = $parts[0];
                    $parts     = array_pop($parts);
                    if (is_array($parts) && count($parts) > 1) {
                        foreach($parts AS $key => $value) {
                            $val = explode('=', $value);
                            $_GET[$val[0]] = $val[1];
                        }
                    } else {
                        $val = explode('=', $parts[0]);
                        $_GET[$val[0]] = isset($val[1]) ? $val[1] : $val[0]; //?
                    }
                    if (!isset($_GET['txtarea'])) {
                        $parts = isset($uri_parts[1]) ? explode('&', $uri_parts[1]) : $uri_parts[0];
                        if (is_array($parts) && count($parts) > 1) {
                            foreach($parts AS $key => $value) {
                                 $val = explode('=', $value);
                                 $_GET[$val[0]] = $val[1];
                            }
                        } else {
                            $val = explode('=', $parts[0]);
                            $_GET[$val[0]] = isset($val[1]) ? $val[1] : $val[0]; //?
                        }
                    }
                    switch($uri_part) {
                        case 'plugin_emoticon.png':
                            header('Content-Type: image/png');
                            echo file_get_contents(dirname(__FILE__) . '/plugin_emoticon.png');
                            break;
                        case 'emoticonchooser':
                            $this->show(true);
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