<?php

declare(strict_types=1);

if (IN_serendipity !== true) {
    die ("Don't hack!");
}

@serendipity_plugin_api::load_language(dirname(__FILE__));

class serendipity_event_metadesc extends serendipity_event
{
    public $title = PLUGIN_METADESC_NAME;

    private $save_title = '';
    private $save_subtitle = '';
    private $meta_title = '';

    function introspect(&$propbag)
    {
        global $serendipity;

        $propbag->add('name',          PLUGIN_METADESC_NAME);
        $propbag->add('description',   PLUGIN_METADESC_DESC);
        $propbag->add('stackable',     false);
        $propbag->add('author',        'Garvin Hicking, Judebert, Don Chambers, Ian Styx');
        $propbag->add('version',       '1.0.1');
        $propbag->add('requirements',  array(
            'serendipity' => '5.0',
            'php'         => '8.2'
        ));

        $propbag->add('event_hooks', array(
            'genpage'                       => true,
            'frontend_header'               => true,
            'backend_publish'               => true,
            'backend_save'                  => true,
            'backend_display'               => true,
            'backend_delete_entry'          => true,
            'frontend_entryproperties'      => true,
            'frontend_fetchentry'           => true,
            'xmlrpc_updertEntry'            => true,
            'xmlrpc_fetchEntry'             => true,
            'xmlrpc_deleteEntry'            => true,
            'css_backend'                   => true
        ));
        $propbag->add('groups', array('FRONTEND_ENTRY_RELATED', 'BACKEND_METAINFORMATION'));
        $propbag->add('configuration', array('tag_names', 'default_description', 'default_keywords', 'escape'));
        $this->supported_properties = array('meta_description', 'meta_keywords', 'meta_head_title');
    }

    function introspect_config_item($name, &$propbag)
    {
        switch($name) {
            case 'tag_names':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_METADESC_TAGNAMES);
                $propbag->add('description', PLUGIN_METADESC_TAGNAMES_DESC);
                $propbag->add('default',     'b,strong');
                break;

            case 'default_description':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_METADESC_DEFAULT_DESCRIPTION);
                $propbag->add('description', PLUGIN_METADESC_DEFAULT_DESCRIPTION_DESC);
                $propbag->add('default',     '');
                break;

            case 'default_keywords':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_METADESC_DEFAULT_KEYWORDS);
                $propbag->add('description', PLUGIN_METADESC_DEFAULT_KEYWORDS_DESC);
                $propbag->add('default',     '');
                break;

            case 'escape':
                $propbag->add('type',        'boolean');
                $propbag->add('name',        PLUGIN_METADESC_ESCAPE);
                $propbag->add('description', PLUGIN_METADESC_ESCAPE_DESC);
                $propbag->add('default',     true);
                break;

            default:
                return false;
        }
        return true;
    }

    function example()
    {
        return "\n".'<p class="msg_notice"><span class="icon-attention-circled" aria-hidden="true"></span> ' . PLUGIN_METADESC_MARKDOWN_DEPENDENCY . "</p>\n\n";
    }

    function generate_content(&$title)
    {
        $title = $this->title;
    }

    function extract_description( string $text)
    {
        $string     = strip_tags(trim($text));
        $metastring = trim(preg_replace('/\s+/', ' ', $string));

        // keeping word boundary character and Unicode ranges
        if (preg_match('/(*UTF8)^.{1,120}\b/us', $metastring, $match)) {
            $metadesc = $match[0];
        }
        preg_match('/<p class=\"[content|excerpt|initial|meta](.*?)\">(.*?)<\/p>/si', trim($text), $excerpt);

        return ($excerpt[2] ?? ($metadesc ?? false));
    }

    function extract_keywords($text)
    {
        $tag_names = $this->get_config('tag_names');
        $tags = explode(",", $tag_names);
        $tags_count = count($tags);
        $results = array();
        for ($i=0; $i < $tags_count; $i++) {
            if (preg_match_all('/<' . $tags[$i] . '[^>]*>([^>]*)<\/' . $tags[$i] . '>/si', $text, $match)) {
                $results = array_merge($results, $match[1]);
            }
        }
        return $results;
    }

    function event_hook($event, &$bag, &$eventData, $addData = null)
    {
        global $serendipity;

        $hooks = &$bag->get('event_hooks');

        if (isset($hooks[$event])) {

            switch($event) {
                case 'genpage':
                    // The 'genpage' hook is our last chance to modify Smarty
                    // variables before the template is called for the HTML head.

                    // Only modify the title on single-entry pages
                    if ($addData['view'] == 'entry') {
                        // Get the properties for this entry
                        $myid = (int) $serendipity['GET']['id'];
                        // Requires a database fetch, but the only other way
                        // get the entry properties is to wait until we
                        // generate the entry; by the time that hook is
                        // called, the <title> tag has already been emitted.
                        // We need those properties now!
                        if (is_numeric($myid)) {
                            $property = serendipity_fetchEntryProperties($myid);
                        }
                        // Set a title, if one was defined for this entry
                        if (!empty($property['meta_head_title'])) {
                            // Make the variable name a little less unwieldy
                            $this->meta_title = $property['meta_head_title'];
                            $this->save_title = $serendipity['head_title'];
                            $this->save_subtitle = $serendipity['head_subtitle'];
                            $serendipity['head_title'] = htmlspecialchars($this->meta_title);
                            // Clear the subtitle (many templates use it along with the title)
                            $serendipity['head_subtitle'] = '';
                        }
                    }
                    break;

                case 'frontend_header':
                    $default_description = $this->get_config('default_description');
                    $default_keywords = $this->get_config('default_keywords');

                    // Only emit in Single Entry Mode
                    if (!empty($serendipity['GET']['id']) && $serendipity['view'] == 'entry') {
                        // we fetch the internal smarty object to get the current entry body
                        if ($serendipity['template'] != 'default-php' && is_object($eventData['smarty'])) {
                            $entry = (array)$eventData['smarty']->tpl_vars['entry']->value;
                        } else {
                            $entry = serendipity_fetchEntry('id', (int)$serendipity['GET']['id']);
                        }

                        // If we modified the <title>...
                        if (!empty($this->meta_title)) {
                            // We've messed up the banner.  Put it back the way it was.
                            // Set smarty variables for banner back to normal "entry title - blog description"
                            $serendipity['smarty']->assign(
                                array(
                                'head_title'    => $this->save_title,
                                'head_subtitle' => $this->save_subtitle
                                )
                            );
                        }

                        $meta_description = $entry['properties']['meta_description'] ?? null;
                        if (empty($meta_description)) {
                            $description_body = $entry['body'];
                            if (isset($GLOBALS['entry'][0]['plaintext_body'])) {
                                $description_body = trim($GLOBALS['entry'][0]['plaintext_body']); // markdown plugin
                            }
                            $meta_description = $this->extract_description($description_body);
                        }

                        $meta_keywords = $entry['properties']['meta_keywords'] ?? null;
                        if (empty($meta_keywords)) {
                            $meta_keywords = (array)$this->extract_keywords($entry['body']);
                            if (!empty($meta_keywords)) {
                                $meta_keywords = implode(',', $meta_keywords);
                            } else {
                                // no entry specific keywords for this entry and extract_keywords was returned empty
                                $meta_keywords = $default_keywords;
                            }
                        }

                        if (serendipity_db_bool($this->get_config('escape'))) {
                            $md = htmlspecialchars($meta_description, double_encode: false);
                            $mk = htmlspecialchars($meta_keywords, double_encode: false);
                        } else {
                            $md = $meta_description;
                            $mk = $meta_keywords;
                        }
                        echo "\n";
                        echo '    <meta name="description" content="' . $md . '" />' . "\n";
                        if (!empty($meta_keywords)) {
                            echo '    <meta name="keywords" content="' . $mk . '" />' . "\n";
                        }
                    } else {
                        // emit default meta description and meta keyword, if not blank, for pages other than single entry

                        if (serendipity_db_bool($this->get_config('escape'))) {
                            $md = htmlspecialchars($default_description, double_encode: false);
                            $mk = htmlspecialchars($default_keywords, double_encode: false);
                        } else {
                            $md = $default_description;
                            $mk = $default_keywords;
                        }

                        if (!empty($default_description)) {
                            echo '    <meta name="description" content="' . $md . '" />' . "\n";
                        }
                        if (!empty($default_keywords)) {
                            echo '    <meta name="keywords" content="' . $mk . '" />' . "\n";
                        }
                    }
                    break;

                case 'css_backend':
                        $eventData .= '

/* serendipity_event_metadesk start */

#edit_entry_metadesc legend {
    margin-top: 1em;
    margin-bottom: 1em;
}
#edit_entry_metadesc .meta_string_length {
    font-size: .875em;
    color: orange;
    font-style: italic;
}
#edit_entry_metadesc .msg_notice {
    margin: 0;
}

#edit_entry_metadesc .toggle_info.button_link {
    margin-bottom: .25em;
}

.meta_stringlength_disclaimer em { font-size: .875em; }

@media only screen and (min-width: 768px) {
    #metadesc_tab_info,
    #metaheadtitle_tab_info {
        width: 100%;
    }
}

/* serendipity_event_metadesk end */
';
                    break;

                case 'backend_publish':
                case 'backend_save':
                    if (!isset($serendipity['POST']['properties']) || !is_array($serendipity['POST']['properties']) || !isset($eventData['id'])) {
                        return;
                    }

                    // Get existing data
                    $property = serendipity_fetchEntryProperties((int) $eventData['id']);

                    foreach($this->supported_properties AS $prop_key) {
                        $prop_val = $serendipity['POST']['properties'][$prop_key] ?? null;
                        if (!isset($property[$prop_key]) && !empty($prop_val)) {
                            $q = "INSERT INTO {$serendipity['dbPrefix']}entryproperties (entryid, property, value) VALUES (" . (int)$eventData['id'] . ", '" . serendipity_db_escape_string($prop_key) . "', '" . serendipity_db_escape_string($prop_val) . "')";
                        } elseif (!empty($prop_key) && !empty($prop_val) && $property[$prop_key] != $prop_val) {
                            $q = "UPDATE {$serendipity['dbPrefix']}entryproperties SET value = '" . serendipity_db_escape_string($prop_val) . "' WHERE entryid = " . (int)$eventData['id'] . " AND property = '" . serendipity_db_escape_string($prop_key) . "'";
                        } else {
                            if (!empty($prop_key)) {
                                $q = "DELETE FROM {$serendipity['dbPrefix']}entryproperties WHERE entryid = " . (int)$eventData['id'] . " AND property = '" . serendipity_db_escape_string($prop_key) . "'";
                            }
                        }

                        if (isset($q)) serendipity_db_query($q);
                    }
                    break;

                case 'backend_display':
                    if (isset($serendipity['POST']['properties']['meta_description'])) {
                        $meta_description = $serendipity['POST']['properties']['meta_description'];
                    } elseif (isset($eventData['properties']['meta_description'])) {
                        $meta_description = $eventData['properties']['meta_description'];
                    } else {
                        $meta_description = '';
                    }

                    if (isset($serendipity['POST']['properties']['meta_keywords'])) {
                        $meta_keywords = $serendipity['POST']['properties']['meta_keywords'];
                    } elseif (isset($eventData['properties']['meta_keywords'])) {
                        $meta_keywords = $eventData['properties']['meta_keywords'];
                    } else {
                        $meta_keywords = '';
                    }

                    if (isset($serendipity['POST']['properties']['meta_head_title'])) {
                        $meta_head_title = $serendipity['POST']['properties']['meta_head_title'];
                    } elseif (isset($eventData['properties']['meta_head_title'])) {
                        $meta_head_title = $eventData['properties']['meta_head_title'];
                    } else {
                        $meta_head_title = '';
                    }
?>
            <fieldset id="edit_entry_metadesc" class="entryproperties_metadesc">
                <span class="wrap_legend"><legend><?php echo PLUGIN_METADESC_NAME; ?></legend></span>

                <div class="form_field">
                    <label for="serendipity[properties][meta_description]"><?php echo PLUGIN_METADESC_DESCRIPTION; ?></label> <span class="meta_string_length">(<?php echo PLUGIN_METADESC_LENGTH . ': ' . str_word_count($meta_description) . ' '. PLUGIN_METADESC_WORDS . ', ' . strlen($meta_description) . ' ' . PLUGIN_METADESC_CHARACTERS; ?>)</span>
                    <button class="toggle_info button_link" type="button" data-href="#metadesc_tab_info"><span class="icon-info-circled" aria-hidden="true"></span><span class="visuallyhidden">Mehr</span></button>
                    <div id="metadesc_tab_info" class="clearfix field_info additional_info">
                        <?php echo PLUGIN_METADESC_FORM; ?>
                    </div>
                    <input id="properties_meta_description" class="input_textbox" style="width: 100%" value="<?php echo htmlspecialchars($meta_description, ENT_COMPAT, LANG_CHARSET); ?>" name="serendipity[properties][meta_description]" type="text">
                    <br />
                    <label for="serendipity[properties][meta_keywords]"><?php echo PLUGIN_METADESC_KEYWORDS; ?></label> <span class="meta_string_length">(<?php echo PLUGIN_METADESC_LENGTH . ': ' . str_word_count($meta_keywords) . ' '. PLUGIN_METADESC_WORDS . ', ' . strlen($meta_keywords) . ' ' . PLUGIN_METADESC_CHARACTERS; ?>)</span>
                    <input id="properties_meta_keywords" class="input_textbox" style="width: 100%" value="<?php echo htmlspecialchars($meta_keywords, ENT_COMPAT, LANG_CHARSET); ?>" name="serendipity[properties][meta_keywords]" type="text">
                </div>

                <div class="form_field">
                    <label for="serendipity[properties][meta_head_title]"><?php echo PLUGIN_METADESC_HEADTITLE; ?></label> <span class="meta_string_length">(<?php echo PLUGIN_METADESC_LENGTH . ': ' . str_word_count($meta_head_title) . ' '. PLUGIN_METADESC_WORDS . ', ' . strlen($meta_head_title) . ' ' . PLUGIN_METADESC_CHARACTERS; ?>)</span>
                    <button class="toggle_info button_link" type="button" data-href="#metaheadtitle_tab_info"><span class="icon-info-circled" aria-hidden="true"></span><span class="visuallyhidden">Mehr</span></button>
                    <div id="metaheadtitle_tab_info" class="clearfix field_info additional_info">
                        <?php echo PLUGIN_METADESC_HEADTITLE_DESC; ?>
                    </div>
                    <input id="properties_headtitle" class="input_textbox" style="width: 100%" value="<?php echo htmlspecialchars($meta_head_title, ENT_COMPAT, LANG_CHARSET); ?>" name="serendipity[properties][meta_head_title]" type="text">
                </div>

                <span class="meta_stringlength_disclaimer"><sup>(*)</sup> <em><?php echo PLUGIN_METADESC_STRINGLENGTH_DISCLAIMER; ?></em></span>
            </fieldset>

<?php
                    break;

                case 'xmlrpc_deleteEntry':
                case 'backend_delete_entry':
                    $q = "DELETE FROM {$serendipity['dbPrefix']}entryproperties WHERE entryid = " . (int)$eventData['id'] . " AND property LIKE '%meta_%'";
                    serendipity_db_query($q);
                    break;

                case 'frontend_entryproperties':
                    if (class_exists('serendipity_event_entryproperties') || !is_array($addData)) {
                        // Fetching of properties is already done there, so this is just for poor users who don't have the entryproperties plugin enabled
                        return;
                    }
                    $q = "SELECT entryid, property, value FROM {$serendipity['dbPrefix']}entryproperties WHERE entryid IN (" . implode(', ', array_keys($addData)) . ") AND property LIKE '%meta_%'";
                    $properties = serendipity_db_query($q);
                    if (!is_array($properties)) {
                        return;
                    }
                    foreach($properties AS $idx => $row) {
                        $eventData[$addData[$row['entryid']]]['properties'][$row['property']] = $row['value'];
                    }
                    break;

/* MAYBE FOR FUTURE
                case 'frontend_fetchentry':
                    $cond  = "meta_d.value AS meta_description,\n";
                    $cond .= "meta_k.value AS meta_keywords,\n";
                    if (empty($eventData['addkey'])) {
                        $eventData['addkey'] = $cond;
                    } else {
                        $eventData['addkey'] .= $cond;
                    }
                    $cond  = "\nLEFT OUTER JOIN {$serendipity['dbPrefix']}entryproperties meta_d
                                                 ON (e.id = meta_d.entryid AND meta_d.property = 'meta_description')";
                    $cond .= "\nLEFT OUTER JOIN {$serendipity['dbPrefix']}entryproperties meta_k
                                                 ON (e.id = meta_k.entryid AND meta_d.property = 'meta_keywords')";

                    if (empty($eventData['joins'])) {
                        $eventData['joins'] = $cond;
                    } else {
                        $eventData['joins'] .= $cond;
                    }
                    break;
*/

                case 'xmlrpc_updertEntry':
                    if (isset($eventData['id'])) {
                        //XMLRPC call

                        if (!empty($eventData['mt_keywords'])) {
                            $property = serendipity_fetchEntryProperties((int) $eventData['id']);
                            if (!isset($property['meta_keywords'])) {
                                 $q = "INSERT INTO {$serendipity['dbPrefix']}entryproperties (entryid, property, value) VALUES (" . (int)$eventData['id'] . ", 'meta_keywords', '" . serendipity_db_escape_string($eventData['mt_keywords']) . "')";
                            } elseif ($property['mt_keywords'] != $eventData['mt_keywords']) {
                                 $q = "UPDATE {$serendipity['dbPrefix']}entryproperties SET value = '" . serendipity_db_escape_string($eventData['mt_keywords']) . "' WHERE entryid = " . (int)$eventData['id'] . " AND property = 'meta_keywords'";
                            } else {
                                 $q = "DELETE FROM {$serendipity['dbPrefix']}entryproperties WHERE entryid = " . (int)$eventData['id'] . " AND property = 'meta_keywords'";
                            }
                            serendipity_db_query($q);
                       }
                    }
                    break;

                case 'xmlrpc_fetchEntry':
                    if (isset($eventData['id'])) {
                        // XMLRPC call
                        $q = "SELECT entryid, property, value FROM {$serendipity['dbPrefix']}entryproperties WHERE entryid IN (" . $eventData['id'] . ") AND property LIKE '%meta_keywords%'";
                        $properties = serendipity_db_query($q);
                        if (!is_array($properties)) {
                            return true;
                        }
                        // wow, this is hack... is there a better way?
                        $properties = $properties[0];
                        $eventData['mt_keywords'] = $properties['value'];
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