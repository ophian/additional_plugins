<?php

if (IN_serendipity !== true) {
    die ("Don't hack!");
}

@serendipity_plugin_api::load_language(dirname(__FILE__));

class serendipity_event_emoticonchooser extends serendipity_event
{
    var $title = PLUGIN_EVENT_EMOTICONCHOOSER_TITLE;

    function introspect(&$propbag)
    {
        global $serendipity;

        $propbag->add('name',          PLUGIN_EVENT_EMOTICONCHOOSER_TITLE);
        $propbag->add('description',   PLUGIN_EVENT_EMOTICONCHOOSER_DESC);
        $propbag->add('stackable',     false);
        $propbag->add('author',        'Garvin Hicking, Jay Bertrandt, Ian');
        $propbag->add('requirements',  array(
            'serendipity' => '2.1.0',
            'smarty'      => '3.1.8',
            'php'         => '5.3.0'
        ));
        $propbag->add('version',       '3.01');
        $propbag->add('event_hooks',    array(
            'backend_entry_toolbar_extended' => true,
            'backend_entry_toolbar_body'     => true,
            'backend_wysiwyg'                => true,
            'external_plugin'                => true,
            'frontend_comment'               => true,
            'backend_header'                 => true,
            'frontend_footer'                => true,
            'css_backend'                    => true
        ));
        $propbag->add('groups', array('BACKEND_EDITOR'));
        $propbag->add('configuration', array('frontend', 'popup', 'button', 'popuptext'));
    }

    function generate_content(&$title)
    {
        $title = PLUGIN_EVENT_EMOTICONCHOOSER_TITLE;
    }

    function introspect_config_item($name, &$propbag)
    {
        switch($name) {
            case 'frontend':
                $propbag->add('type',        'boolean');
                $propbag->add('name',        PLUGIN_EVENT_EMOTICONCHOOSER_FRONTEND);
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
     * Creates the popup template for the WYSIWYG-Editor popup
     */
    function show()
    {
        global $serendipity;

        if (IN_serendipity !== true) {
            die ("Don't hack!");
        }
        $file = $this->get_config('emotics');
// we cannot access $serendipity['enablePopup'] here correctly, which is weird, so in either case switching around it won't work properly. So we check first but make a try catch to workaround this....
?>
<!doctype html>
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="<?=$serendipity['language']?>"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="<?=$serendipity['language']?>"> <!--<![endif]-->
<head>
    <meta charset="<?=LANG_CHARSET?>">
    <title><?=PLUGIN_LINKTRIMMER_NAME?></title>
    <link rel="stylesheet" href="<?=$serendipity['baseURL']?>serendipity.css.php?serendipity[css_mode]=serendipity_admin.css">
    <script>
        function emoticonchooser(instance_name, this_instance, cke_txtarea) {
            if (!instance_name) var instance_name = '';
            if (!this_instance) var this_instance = '';
            if (!cke_txtarea)   var cke_txtarea   = '';

            var editor_instance = 'editor'+instance_name;
            var use_emoticon    = 'use_emoticon_'+instance_name;

            window[use_emoticon] = function (img) {
                <?php if ($serendipity['enablePopup'] != true): ?>
                try {
                    window.parent.parent.serendipity.serendipity_imageSelector_addToBody(img+' ', editor_instance);
                    window.parent.parent.$.magnificPopup.close();
                }
                catch (e) {
                    self.opener.serendipity_imageSelector_addToBody(img+' ', editor_instance);
                    self.close();
                }
                <?php else: ?>
                self.opener.serendipity_imageSelector_addToBody(img+' ', editor_instance);
                self.close();
                <?php endif; ?>
            }
        }
    </script>
    <style>
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
    </style>
</head>

<body id="serendipity_admin_page" class="serendipity_emoticonchooser_page">
    <main id="workspace" class="clearfix">
        <div id="content" class="clearfix">

            <div class="emoticonchooser">
                <form action="" method="post">
                    <input type="hidden" name="txtarea" value="<?php echo serendipity_specialchars($_GET['txtarea']) ?>">
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

        if (isset($hooks[$event])) {

            switch($event) {

                case 'frontend_comment':
                    if (serendipity_db_bool($this->get_config('frontend', 'false')) === false) {
                        break;
                    }
                    $txtarea = 'serendipity_commentform_comment';
                    $func    = 'comment';
                    $style   = '';
                    $popcl   = '';
                    // no break
                case 'backend_entry_toolbar_extended':
                    if (!isset($txtarea)) {
                        $txtarea = 'serendipity[extended]';
                        #$txtarea = 'extended';//linktrimmer usage
                        $func    = 'extended';
                    }
                    // no break
                case 'backend_entry_toolbar_body':
                    if (!isset($txtarea)) {
                        if (isset($eventData['backend_entry_toolbar_body:textarea'])) {
                            // event caller has given us the name of the textarea converted
                            // into a wysiwg editor(for example, the staticpages plugin)
                            $txtarea = $eventData['backend_entry_toolbar_body:textarea'];
                        } else {
                            // default value
                            $txtarea = 'serendipity[body]';
                            #$txtarea = 'body';//linktrimmer usage
                        }
                        if (isset($eventData['backend_entry_toolbar_body:nugget'])) {
                            $func = $eventData['backend_entry_toolbar_body:nugget'];
                        } else{
                            $func = 'body';
                        }
                    }

                    // CKEDITOR and plain editor need this little switch
                    if (preg_match('@^nugget@i', $func)) {
                        $cke_txtarea = $func;
                    } else {
                        $cke_txtarea = $txtarea;
                    }

                    if (!$serendipity['wysiwyg']) {
                        if (!isset($popcl)) {
                            $popcl = ' serendipityPrettyButton';
                        }

                        if (!isset($style)) {
                            $style = 'margin-top: 5px; vertical-align: bottom';
                        }

                        $popupstyle = '';
                        $popuplink  = '';
                        if (serendipity_db_bool($this->get_config('popup', 'false'))) {
                            $popupstyle = '; display: none';
                            $popuplink  = serendipity_db_bool($this->get_config('button', 'false'))
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
                    while(list($plugin, $plugin_data) = each($plugins)) {
                        if (strpos($plugin, 'serendipity_event_emoticate') !== FALSE) {
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
                    // script include has to stick to backend_header, while using inline onclick (see above)
                    if (IN_serendipity_admin === true) {
                        if (!$serendipity['wysiwyg']) {
                            echo "    $popuplink\n"; // append toolbar button in backend entries in PLAIN EDITOR toolbar

?>

<div class="serendipity_emoticon_bar">
    <script type="text/javascript">
        emoticonchooser('<?php echo $func; ?>', '<?php echo $txtarea; ?>', '<?php echo $cke_txtarea; ?>');
    </script>

<?php
                        }
                        if ($serendipity['wysiwyg']) {
                            echo "    $popuplink\n"; // add toolbar button in backend entries above CKEDITOR toolbar
                        }
                    } else { // in frontend footer
?>

<div class="serendipity_emoticon_bar">
    <script type="text/javascript">
        document.onreadystatechange = function () {
            if (document.readyState == "interactive") {
                emoticonchooser('<?php echo $func; ?>', '<?php echo $txtarea; ?>', '<?php echo $cke_txtarea; ?>');
            }
        }
    </script>

<?php
                        echo "    $popuplink\n";
                    }

                    $emotics = ''; // init

                    if ($serendipity['wysiwyg']) {
                        $style = '';
                        $popupstyle = 'display: inline-flex;';
                        $emotics .= "

    <script type=\"text/javascript\">
        emoticonchooser('$func', '$txtarea', '$cke_txtarea');
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
                    if (!$serendipity['wysiwyg']) {
                        $emotics .= "</div><!-- emoticon_bar end -->\n\n";
                    }
                    if ($serendipity['wysiwyg']) {
                        $this->set_config('emotics', $emotics); //cache this extra?
                    } else {
                        echo $emotics;
                    }
                    break;

                case 'backend_header':
                    if ($serendipity['wysiwyg']) $noemojs = true;
                case 'frontend_footer':
                    if (!isset($noemojs) || !$noemojs) {
?>
    <script type="text/javascript" src="<?php echo $serendipity['serendipityHTTPPath'] . 'plugins/serendipity_event_emoticonchooser/emoticonchooser.js'; ?>"></script>
<?php
                    }
                    break;

                case 'backend_wysiwyg':
                    $link = $serendipity['serendipityHTTPPath'] . ($serendipity['rewrite'] == 'none' ? $serendipity['indexFile'] . '?/' : '') . 'plugin/emoticonchooser' . ($serendipity['rewrite'] != 'none' ? '?' : '&amp;') . 'txtarea=emoticonchooser_'.$eventData['item'];
                    $eventData['buttons'][] = array(
                        'id'         => 'emoticon' . $eventData['item'],
                        'name'       => PLUGIN_EVENT_EMOTICONCHOOSER_TITLE,
                        'javascript' => 'function() { serendipity.openPopup(\'' . $link . '\', \'EmoticonChooser\') }',
                        'img_url'    => $serendipity['serendipityHTTPPath'] . ($serendipity['rewrite'] == 'none' ? $serendipity['indexFile'] . '?/' : '') . 'plugin/plugin_emoticon.png',
                        'toolbar'    => 'other'
                    );
                    break;

                case 'css_backend':
                    $eventData .= '

/* emoticonchooser plugin start */

.serendipity_toggle_emoticon_bar.serendipityPrettyButton {
    display: inline-flex;
    margin: 0 auto 1px;
}
.serendipity_emoticon_bar {
    text-align: right;
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
                    $parts = array_pop($parts);
                    if (count($parts) > 1) {
                       foreach($parts AS $key => $value) {
                            $val = explode('=', $value);
                            $_GET[$val[0]] = $val[1];
                       }
                    } else {
                       $val = explode('=', $parts[0]);
                       $_GET[$val[0]] = $val[1];
                    }
                    if (!isset($_GET['txtarea'])) {
                        $parts = explode('&', $uri_parts[1]);
                        if (count($parts) > 1) {
                            foreach($parts AS $key => $value) {
                                 $val = explode('=', $value);
                                 $_GET[$val[0]] = $val[1];
                            }
                        } else {
                            $val = explode('=', $parts[0]);
                            $_GET[$val[0]] = $val[1];
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