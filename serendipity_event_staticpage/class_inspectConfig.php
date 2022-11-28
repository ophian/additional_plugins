<?php

/**
 * Abstract class for showForm/SmartyInspectConfig/inspectConfig method
 * As of now we are able to include this only once (by form) outside any loop
 * and run each inspectConfig item switch in a separate class
 */
abstract class inspectConfig extends serendipity_event_staticpage
{
    public function __construct(){}

    public function __destruct(){}

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
        #echo '<pre>' . print_r($inspectConfig, true) . '</pre>';
?>
                <select class="direction_<?php echo $inspectConfig['lang_direction']; ?>" name="serendipity[plugin][<?php echo $inspectConfig['config_item'] ?>]">
<?php
        if (is_array($inspectConfig['select']) && !empty($inspectConfig['select'])) {
            foreach($inspectConfig['select'] AS $select_value => $select_desc) {
?>
                    <option title="<?php echo $this->html_specialchars($select_desc); ?>"<?php echo ($select_value == $inspectConfig['hvalue'] ? ' selected="selected"' : ''); ?> value="<?php echo $select_value; ?>"><?php echo $this->html_specialchars($select_desc); ?></option>
<?php
            }
        }
?>
                </select>
<?php
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
            $radio = $inspectConfig['radio2'];
        } else $radio = $inspectConfig['radio'];

        if (empty($inspectConfig['per_row'])) {
            $per_row = $inspectConfig['per_row2'];
            if (empty($per_row)) {
                $per_row = 2;
            }
        }

        $counter = 0;
        foreach($radio['value'] AS $radio_index => $radio_value) {
            $id = $this->html_specialchars($inspectConfig['config_item'] . $radio_value);
            $counter++;
            $checked = '';

            if ($radio_value == 'true' && ($inspectConfig['hvalue'] === '1' || $inspectConfig['hvalue'] === 'true')) {
                $checked = " checked";
            } elseif ($radio_value == 'false' && ($inspectConfig['hvalue'] === '' || $inspectConfig['hvalue'] ==='0' || $inspectConfig['hvalue'] === 'false')) {
                $checked = " checked";
            } elseif ($radio_value == $inspectConfig['hvalue']) {
                $checked = " checked";
            }

            if ($counter == 1) {
?>
                <div class="sp_input_radio">
<?php
            }
?>
                    <input class="input_radio direction_<?php echo $inspectConfig['lang_direction']; ?>" type="radio" id="serendipity_plugin_<?php echo $id; ?>" name="serendipity[plugin][<?php echo $inspectConfig['config_item']; ?>]" value="<?php echo $radio_value; ?>" <?php echo $checked ?> title="<?php echo $this->html_specialchars($radio['desc'][$radio_index]); ?>">
                        <label for="serendipity_plugin_<?php echo $id; ?>"><?php echo $this->html_specialchars($radio['desc'][$radio_index]); ?></label>
<?php
            if ($counter == $per_row) {
                $counter = 0;
?>
                </div>
<?php
            }
        }
    }

}

class icString extends inspectConfig
{
    public function __construct()
    {
        global $inspectConfig;

?>
                    <input class="input_textbox direction_<?php echo $inspectConfig['lang_direction']; ?>" type="text" name="serendipity[plugin][<?php echo $inspectConfig['config_item']; ?>]" value="<?php echo $inspectConfig['hvalue']; ?>" size="30">
<?php
    }

}

class icText extends inspectConfig
{
    public function __construct()
    {
        global $inspectConfig;

        #echo '<pre>' . print_r($inspectConfig, true) . '</pre>';
        if (!$inspectConfig['s9y']['wysiwyg']) {
?>
            <nobr><span id="tools_<?php echo $inspectConfig['config_item']; ?>" class="editor_toolbar" style="display: none">
            <?php if ( isset($inspectConfig['s9y']['markupeditor']) ) { ?>
                <button class="wrap_insgal" type="button" name="insG" title="Media Gallery" data-tarea="nuggets<?php echo $inspectConfig['elcount']; ?>"><span class="icon-gallery" aria-hidden="true"></span><span class="visuallyhidden"> Media Gallery</span></button>
                <button class="wrap_insmedia" type="button" name="insImage" title="<?php echo MEDIA ?>" data-tarea="nuggets<?php echo $inspectConfig['elcount']; ?>"><span class="icon-s9yml" aria-hidden="true"></span><span class="visuallyhidden"> <?php echo MEDIA ?></span></button>
                <?php if ( isset($inspectConfig['s9y']['markupeditortype']) ) { ?> [ <?php echo $inspectConfig['s9y']['markupeditortype']; ?> ]<?php } ?>
            <?php } else { ?>
            <?php if ( $inspectConfig['s9y']['nl2br']['iso2br'] ) { ?>
                <button class="wrap_selection lang-html" type="button" name="insX" data-tarea="nuggets<?php echo $inspectConfig['elcount']; ?>" data-tag-open="nl" data-tag-close="nl">noBR</button>
            <?php } ?>
                <button class="hilite_i wrap_selection lang-html" type="button" data-tarea="nuggets<?php echo $inspectConfig['elcount']; ?>" data-tag-open="em" data-tag-close="em" name="insI">i</button>
                <button class="hilite_b wrap_selection lang-html" type="button" data-tarea="nuggets<?php echo $inspectConfig['elcount']; ?>" data-tag-open="strong" data-tag-close="strong" name="insB">b</button>
                <button class="wrap_selection lang-html" type="button" data-tarea="nuggets<?php echo $inspectConfig['elcount']; ?>" data-tag-open="blockquote" data-tag-close="blockquote" name="insQ"><?php echo QUOTE ?></button>
                <button class="wrap_insimg" type="button" data-tarea="nuggets<?php echo $inspectConfig['elcount']; ?>" name="insJ">img</button>
                <button class="wrap_insgal" type="button" name="insG" title="Media Gallery" data-tarea="nuggets<?php echo $inspectConfig['elcount']; ?>"><span class="icon-gallery" aria-hidden="true"></span><span class="visuallyhidden"> Media Gallery</span></button>
                <button class="wrap_insmedia" type="button" name="insImage" title="<?php echo MEDIA ?>" data-tarea="nuggets<?php echo $inspectConfig['elcount']; ?>"><span class="icon-s9yml" aria-hidden="true"></span><span class="visuallyhidden"> <?php echo MEDIA ?></span></button>
                <button class="wrap_insurl" type="button" data-tarea="nuggets<?php echo $inspectConfig['elcount']; ?>" name="insURL">URL</button>
                <?php if ( isset($inspectConfig['s9y']['markupeditortype']) ) { ?> [ <?php echo $inspectConfig['s9y']['markupeditortype']; ?> ]<?php } ?>
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
            echo "            <div class=\"hook_buttons\">\n\n"; // append inlined

            serendipity_plugin_api::hook_event('backend_entry_toolbar_body', $entry); // add hooked buttons

            echo "\n            </div>\n\n";

            $tdimension = $inspectConfig['config_item'] == 'question' ? ' rows="5" cols="80"' : ' rows="20" cols="80"';

        } else { // case WYSIWYG EDITOR

            $tdimension = ' rows="10" cols="80"';
            serendipity_emit_htmlarea_code("nuggets{$inspectConfig['elcount']}","");
            $entry['backend_entry_toolbar_body:nugget'] = 'nuggets' . $inspectConfig['elcount'];
            $entry['backend_entry_toolbar_body:textarea'] = 'serendipity[plugin]['.$inspectConfig['config_item'].']';
            echo "            <div class=\"hook_buttons\">\n"; // append inlined

            serendipity_plugin_api::hook_event('backend_entry_toolbar_body', $entry);

            echo "            </div>\n\n";

        }
?>

        <div class="form_field clear">
            <textarea id="nuggets<?php echo $inspectConfig['elcount']; ?>" class="direction_<?php echo $inspectConfig['lang_direction']; ?>"<?php echo $tdimension; ?> name="serendipity[plugin][<?php echo $inspectConfig['config_item']; ?>]"><?php echo $inspectConfig['hvalue']; ?></textarea>
        </div>

<?php
    }

}

class icContent extends inspectConfig
{
    public function __construct()
    {
        global $inspectConfig;

        echo $inspectConfig['default'];
    }

}

class icHidden extends inspectConfig
{
    public function __construct()
    {
        global $inspectConfig;

?>
                <input class="direction_<?php echo $inspectConfig['lang_direction']; ?>" type="hidden" name="serendipity[plugin][<?php echo $inspectConfig['config_item']; ?>]" value="<?php echo $inspectConfig['value']; ?>">
<?php
    }

}

class icTimestamp extends inspectConfig
{
    public function __construct()
    {
        global $inspectConfig;

        // fallback to empty form for fail and to avoid passing '01.01.1970 01:00'
        if (false !== strpos($inspectConfig['hvalue'], '.')) {
            $inspectConfig['hvalue'] = date_create($inspectConfig['hvalue'])->getTimestamp();
        }
?>
                <input class="input_textbox direction_<?php echo $inspectConfig['lang_direction']; ?>" type="text" name="serendipity[plugin][<?php echo $inspectConfig['config_item']; ?>]" value="<?php echo serendipity_strftime(DATE_FORMAT_SHORT, $inspectConfig['hvalue']); ?>" size="30">
<?php
    }

}

?>