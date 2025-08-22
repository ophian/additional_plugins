<?php

/**
 * Abstract class for showForm methods
 * As of now we are able to include this only once (by form) outside the foreach config item loop
 * and run each inspectConfig item switch in a separate class
 */
abstract class inspectConfig extends serendipity_event_faq
{
    public function showFAQForm(){}
    public function showCategoryForm(){}
}

class icSeparator extends inspectConfig
{
    public function __construct()
    {
        return;//void
    }
}

class icSelect extends inspectConfig
{
    public function __construct()
    {
        global $inspectConfig;

        $select = $inspectConfig['select_values'];
?>

        <div id="item_config_select" class="form_field clear">
            <label for="<?php echo $inspectConfig['cname']; ?><?php echo $inspectConfig['elcount']; ?>"><?php echo $inspectConfig['cname']; ?></label>

<?php
        if ($inspectConfig['cdesc'] != '') {
?>
            <span class="title_descriptor"><span class="faq_config_desc">&nbsp;<?php echo $inspectConfig['cdesc']; ?></span></span>
<?php
        }
?>

            <div class="action_field">

                <select id="<?php echo $inspectConfig['cname']; ?><?php echo $inspectConfig['elcount']; ?>" class="direction_<?php echo $inspectConfig['lang_direction']; ?>" name="serendipity[plugin][<?php echo $inspectConfig['config_item']; ?>]">
<?php
        foreach($select AS $select_value => $select_desc) {
            $id = htmlspecialchars($inspectConfig['config_item'] . $select_value);
?>
                    <option value="<?php echo $select_value; ?>"<?php echo ($select_value == $inspectConfig['hvalue'] ? ' selected="selected"' : ''); ?> title="<?php echo htmlspecialchars($select_desc); ?>">
                        <?php echo htmlspecialchars($select_desc)."\n"; ?>
                    </option>
<?php
        }
?>
                </select>

            </div>
        </div>

<?php
    }
}

class icTristate extends inspectConfig
{
    public function __construct()
    {
        global $inspectConfig;

        $inspectConfig['per_row'] = 3;
        $inspectConfig['radio']['value'][] = 'default';
        $inspectConfig['radio']['desc'][]  = USE_DEFAULT;
        // return fall through
    }
}

class icBoolean extends inspectConfig
{
    public function __construct()
    {
        global $inspectConfig;

        $inspectConfig['radio']['value'][] = 'true';
        $inspectConfig['radio']['desc'][]  = YES;

        $inspectConfig['radio']['value'][] = 'false';
        $inspectConfig['radio']['desc'][]  = NO;
        // return fall through
    }
}

class icRadio extends inspectConfig
{
    /**
     * Radio form field generator. May have pre set dependencies in tristate and boolean.
     */
    public function __construct()
    {
        global $inspectConfig;

        if (!count($inspectConfig['radio']) > 0) {
            $radio = $inspectConfig['radio'];
        }

        if (empty($inspectConfig['per_row'])) {
            $per_row = $inspectConfig['radio_per_row'];
            if (empty($per_row)) {
                $per_row = 2;
            }
        }
?>

        <label for="<?php echo $inspectConfig['cname']; ?><?php echo $inspectConfig['elcount']; ?>"><?php echo $inspectConfig['cname']; ?></label>

<?php
        if ($inspectConfig['cdesc'] != '') {
?>
        <span class="title_descriptor"><span class="faq_config_desc">&nbsp;<?php echo $inspectConfig['cdesc']; ?></span></span>
<?php
        }
?>

        <div id="item_config_radio" class="form_field clear action_field">

<?php
        $counter = 0;
        foreach($radio['value'] AS $radio_index => $radio_value) {
            $id = htmlspecialchars($inspectConfig['config_item'] . $radio_value);
            $counter++;
            $checked = "";

            if ($radio_value == 'true' && ($inspectConfig['hvalue'] === '1' || $inspectConfig['hvalue'] === 'true')) {
                $checked = " checked";
            } elseif ($radio_value == 'false' && ($inspectConfig['hvalue'] === '' || $inspectConfig['hvalue'] ==='0' || $inspectConfig['hvalue'] === 'false')) {
                $checked = " checked";
            } elseif ($radio_value == $inspectConfig['hvalue']) {
                $checked = " checked";
            }

            if ($counter == 1) {
?>
            <div class="radio_field">
<?php
            }
?>
                <input class="direction_<?php echo $inspectConfig['lang_direction']; ?> input_radio" type="radio" id="serendipity_plugin_<?php echo $id; ?>" name="serendipity[plugin][<?php echo $inspectConfig['config_item']; ?>]" value="<?php echo $radio_value; ?>" <?php echo $checked ?> title="<?php echo htmlspecialchars($radio['desc'][$radio_index]); ?>" />
                <label for="serendipity_plugin_<?php echo $id; ?>"><?php echo htmlspecialchars($radio['desc'][$radio_index]); ?></label>
<?php
            if ($counter == $per_row) {
                $counter = 0;
?>
            </div>
<?php
            }
        }
?>

        </div>

<?php
    }
}

class icString extends inspectConfig
{
    public function __construct()
    {
        global $inspectConfig;
?>

        <div class="form_field clear text_field">
            <label for="<?php echo $inspectConfig['cname']; ?><?php echo $inspectConfig['elcount']; ?>"><?php echo $inspectConfig['cname']; ?></label>
            <span class="title_descriptor"><span class="faq_config_desc">&nbsp;<?php echo $inspectConfig['cdesc']; ?></span></span>
        </div>

        <div class="form_field clear action_field">
            <input id="<?php echo $inspectConfig['cname']; ?><?php echo $inspectConfig['elcount']; ?>" class="direction_<?php echo $inspectConfig['lang_direction']; ?> input_field" type="text" name="serendipity[plugin][<?php echo $inspectConfig['config_item']; ?>]" value="<?php echo $inspectConfig['hvalue']; ?>" size="30" />
        </div>

<?php
    }
}

class icText extends inspectConfig
{
    public function __construct()
    {
        global $inspectConfig;

        if (!$inspectConfig['pdata']['wysiwyg']) {
?>

        <div class="form_field clear text_field">
            <label for="<?php echo $inspectConfig['cname']; ?><?php echo $inspectConfig['elcount']; ?>"><?php echo $inspectConfig['cname']; ?></label>
            <span class="title_descriptor">&nbsp;<span class="faq_config_desc">&nbsp;<?php echo $inspectConfig['cdesc']; ?></span></span>
        </div>

        <div class="form_editor">
            <div class="form_field clear plain_editor">

                <nobr><span id="tools_<?php echo $inspectConfig['config_item']; ?>" class="editor_toolbar" style="display: none">
                <?php if ( isset($inspectConfig['pdata']['markupeditor']) ) { ?>
                    <button class="wrap_insgal" type="button" name="insG" title="Media Gallery" data-tarea="nuggets<?php echo $inspectConfig['elcount']; ?>"><span class="icon-gallery" aria-hidden="true"></span><span class="visuallyhidden"> Media Gallery</span></button>
                    <button class="wrap_insmedia" type="button" data-tarea="nuggets<?php echo $inspectConfig['elcount']; ?>" name="insImage"><span class="icon-s9yml" aria-hidden="true"></span><span class="visuallyhidden"> <?php echo MEDIA ?></span></button>
                    <?php if ( isset($inspectConfig['pdata']['markupeditortype']) ) { ?><span class="infobox_markupeditortype"> [ <?php echo $inspectConfig['pdata']['markupeditortype']; ?> ]</span><?php } ?>
                <?php } else { ?>
                <?php if ( $inspectConfig['pdata']['nl2br']['iso2br'] ) { ?>
                    <button class="wrap_selection lang-html" type="button" name="insX" data-tarea="nuggets<?php echo $inspectConfig['elcount']; ?>" data-tag-open="nl" data-tag-close="nl">NoBR</button>
                <?php } ?>
                    <button class="hilite_i wrap_selection lang-html" type="button" data-tarea="nuggets<?php echo $inspectConfig['elcount']; ?>" data-tag-open="em" data-tag-close="em" name="insI">i</button>
                    <button class="hilite_b wrap_selection lang-html" type="button" data-tarea="nuggets<?php echo $inspectConfig['elcount']; ?>" data-tag-open="strong" data-tag-close="strong" name="insB">b</button>
                    <button class="wrap_selection lang-html" type="button" data-tarea="nuggets<?php echo $inspectConfig['elcount']; ?>" data-tag-open="blockquote" data-tag-close="blockquote" name="insQ"><?php echo QUOTE ?></button>
                    <button class="wrap_insimg" type="button" data-tarea="nuggets<?php echo $inspectConfig['elcount']; ?>" name="insJ">img</button>
                    <button class="wrap_insgal" type="button" name="insG" title="Media Gallery" data-tarea="nuggets<?php echo $inspectConfig['elcount']; ?>"><span class="icon-gallery" aria-hidden="true"></span><span class="visuallyhidden"> Media Gallery</span></button>
                    <button class="wrap_insmedia" type="button" data-tarea="nuggets<?php echo $inspectConfig['elcount']; ?>" name="insImage"><span class="icon-s9yml" aria-hidden="true"></span><span class="visuallyhidden"> <?php echo MEDIA ?></span></button>
                    <button class="wrap_insurl" type="button" data-tarea="nuggets<?php echo $inspectConfig['elcount']; ?>" name="insURL">URL</button>
                    <?php if ( isset($inspectConfig['pdata']['markupeditortype']) ) { ?><span class="infobox_markupeditortype"> [ <?php echo $inspectConfig['pdata']['markupeditortype']; ?> ]</span><?php } ?>
                <?php } ?>
                </span></nobr>

                <script type="text/javascript">
                    var tb_<?php echo $inspectConfig['config_item']; ?> = document.getElementById('tools_<?php echo $inspectConfig['config_item']; ?>');
                        tb_<?php echo $inspectConfig['config_item']; ?>.style.display = '';
                </script>

<?php

            // add extra data into the entry's array so that the emoticonchooser plugin
            // behaves well with WYSIWYG-editors, then clean up ;-) (same applies below)
            $entry['backend_entry_toolbar_body:nugget'] = 'nuggets' . $inspectConfig['elcount'];
            $entry['backend_entry_toolbar_body:textarea'] = 'serendipity[plugin]['.$inspectConfig['config_item'].']';
?>
                <div class="hook_buttons">
<?php
            serendipity_plugin_api::hook_event('backend_entry_toolbar_body', $entry); // add hooked buttons
?>
                </div>
            </div>
        </div><!-- form_editor end -->

<?php
            $tdimension = $inspectConfig['config_item'] == 'question' ? ' rows="5" cols="80"' : ' rows="20" cols="80"';
        } else { // case WYSIWYG EDITOR
            $tdimension = ' rows="10" cols="80"';
            serendipity_emit_htmlarea_code("nuggets{$inspectConfig['elcount']}","");
            $entry['backend_entry_toolbar_body:nugget'] = 'nuggets' . $inspectConfig['elcount'];
            $entry['backend_entry_toolbar_body:textarea'] = 'serendipity[plugin]['.$inspectConfig['config_item'].']';
?>

        <div class="form_field clear text_field">
            <label for="nuggets<?php echo $inspectConfig['elcount']; ?>"><?php echo $inspectConfig['cname']; ?></label>
            <span class="title_descriptor">&nbsp;<span class="faq_config_desc">&nbsp;<?php echo $inspectConfig['cdesc']; ?></span></span>
        </div>

        <div class="form_field clear plain_editor">
            <div class="hook_buttons">
<?php
            serendipity_plugin_api::hook_event('backend_entry_toolbar_body', $entry);
?>
            </div>
        </div>
<?php
        }
?>

        <div class="form_field clear">
            <textarea id="nuggets<?php echo $inspectConfig['elcount']; ?>" class="direction_<?php echo $inspectConfig['lang_direction']; ?>"<?php echo $tdimension; ?> name="serendipity[plugin][<?php echo $inspectConfig['config_item']; ?>]"><?php echo $inspectConfig['hvalue']; ?></textarea>
        </div>

<?php
    }
}

class icHtml extends inspectConfig
{
    public function __construct()
    {
        $icText::icText();
    }
}

class icContent extends inspectConfig
{
    public function __construct()
    {
        global $inspectConfig;
?>

        <div class="default_faq_content"><?php echo $inspectConfig['default']; ?></div>

<?php
    }
}

class icHidden extends inspectConfig
{
    public function __construct()
    {
        global $inspectConfig;
?>

        <div class="form_field clear">
            <input class="direction_<?php echo $inspectConfig['lang_direction']; ?>" type="hidden" name="serendipity[plugin][<?php echo $inspectConfig['config_item']; ?>]" value="<?php echo $inspectConfig['value']; ?>" />
        </div>

<?php
    }
}

?>