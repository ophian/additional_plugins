<?php

if (IN_serendipity !== true) {
    die ("Don't hack!");
}

@serendipity_plugin_api::load_language(dirname(__FILE__));

class serendipity_event_mymood extends serendipity_event
{

    function introspect(&$propbag)
    {
        global $serendipity;

        $propbag->add('name',          PLUGIN_MYMOOD_TITLE);
        $propbag->add('description',   PLUGIN_MYMOOD_DESC);
        $propbag->add('requirements',  array(
            'serendipity' => '2.0',
            'smarty'      => '3.1',
            'php'         => '7.0'
        ));
        $propbag->add('version',       '0.16');
        $propbag->add('author',       'Brett Profitt');
        $propbag->add('stackable',     false);
        $propbag->add('event_hooks',   array(
            'entry_display'                                     => true,
            'backend_publish'                                   => true,
            'backend_save'                                      => true,
            'backend_display'                                   => true,
            'backend_sidebar_entries'                           => true,
            'backend_sidebar_entries_event_display_mymood'      => true,
        ));

        $propbag->add('groups', array('FRONTEND_ENTRY_RELATED', 'BACKEND_EDITOR'));
        $propbag->add('configuration', array( 'intro',
                                            'outro',
                                            'place_before',
                                            'location',
                                            'display_format',

                                            ));

        #we use this to match entries to moods.  mood metadata get their own db.
        $this->dependencies = array('serendipity_event_entryproperties' => 'keep');
    }

    function introspect_config_item($name, &$propbag)
    {
        switch ($name) {
            case 'intro':
                $propbag->add('type', 'string');
                $propbag->add('name', PLUGIN_MYMOOD_INTRO);
                $propbag->add('description', PLUGIN_MYMOOD_INTRO_DESC);
                $propbag->add('default', PLUGIN_MYMOOD_TODAY_I_FEEL);
                break;
            case 'outro':
                $propbag->add('type', 'string');
                $propbag->add('name', PLUGIN_MYMOOD_OUTRO);
                $propbag->add('description', PLUGIN_MYMOOD_OUTRO_DESC);
                break;
            case 'location':
                $select = array ('body'  => PLUGIN_MYMOOD_PLACE_FIELD_BODY,
#                                'author' => PLUGIN_MYMOOD_PLACE_FIELD_AUTHOR,
                                'footer' => PLUGIN_MYMOOD_PLACE_FIELD_FOOTER,
                                'title'  => PLUGIN_MYMOOD_PLACE_FIELD_TITLE,
                                'smarty' => '{$entry.mymood} Smarty Variable');
                $propbag->add('type', 'select');
                $propbag->add('name', PLUGIN_MYMOOD_PLACE_FIELD);
                $propbag->add('description', PLUGIN_MYMOOD_PLACE_FIELD_DESC);
                $propbag->add('select_values', $select);
                $propbag->add('default', 'body');
                break;
            case 'place_before':
                $propbag->add('type', 'boolean');
                $propbag->add('name', PLUGIN_MYMOOD_PLACE_BEFORE);
                $propbag->add('description', PLUGIN_MYMOOD_PLACE_BEFORE_DESC);
                $propbag->add('default', 'false');
                break;
            case 'display_format':
                $propbag->add('type', 'string');
                $propbag->add('name', PLUGIN_MYMOOD_DISPLAY_FORMAT);
                $propbag->add('description', PLUGIN_MYMOOD_DISPLAY_FORMAT_DESC);
                $propbag->add('default', '{img} {name}');
                break;
        }
        return true;
    }

    function setupDB()
    {
        global $serendipity;

        if (serendipity_db_bool($this->get_config('db_built', false))) {
            return true;
        }

        #mood list.
        #i apologize for the pain this list may cause.
        #format: mood|~|img|~|ascii
        #each mood is separated by |`|
        #why the awful delimiters?  because lots of normal chars are used for the ascii art.
        #this list is from livejournal.  anyone up for some ascii art??
        $img_pre = $serendipity['serendipityHTTPPath'] . $serendipity['templatePath'] . 'default/img/emoticons';

        @define('PLUGIN_MYMOOD_LISTOFMOODS',
                PLUGIN_MYMOOD_ACCOMPLISHED."|~||~||`|".PLUGIN_MYMOOD_AGGRAVATED."|~||~||`|".PLUGIN_MYMOOD_AMUSED."|~||~||`|".PLUGIN_MYMOOD_ANGRY."|~||~||`|".PLUGIN_MYMOOD_ANNOYED."|~||~||`|".PLUGIN_MYMOOD_ANXIOUS."|~||~||`|".PLUGIN_MYMOOD_APATHETIC."|~||~||`|".
                PLUGIN_MYMOOD_ARTISTIC."|~||~||`|".PLUGIN_MYMOOD_AWAKE."|~||~||`|".PLUGIN_MYMOOD_BITCHY."|~||~||`|".PLUGIN_MYMOOD_BLAH."|~||~||`|".PLUGIN_MYMOOD_BLANK."|~||~||`|".PLUGIN_MYMOOD_BORED."|~||~||`|".PLUGIN_MYMOOD_BOUNCY."|~||~||`|".
                PLUGIN_MYMOOD_BUSY."|~||~||`|".PLUGIN_MYMOOD_CALM."|~||~||`|".PLUGIN_MYMOOD_CHEERFUL."|~||~||`|".PLUGIN_MYMOOD_CHIPPER."|~||~||`|".PLUGIN_MYMOOD_COLD."|~||~||`|".PLUGIN_MYMOOD_COMPLACENT."|~||~||`|".PLUGIN_MYMOOD_CONFUSED."|~||~||`|".
                PLUGIN_MYMOOD_CONTEMPLATIVE."|~||~||`|".PLUGIN_MYMOOD_CONTENT."|~||~||`|".PLUGIN_MYMOOD_CRANKY."|~||~||`|".PLUGIN_MYMOOD_CRAPPY."|~||~||`|".PLUGIN_MYMOOD_CRAZY."|~||~||`|".PLUGIN_MYMOOD_CREATIVE."|~||~||`|".PLUGIN_MYMOOD_CRUSHED."|~||~||`|".
                PLUGIN_MYMOOD_CURIOUS."|~||~||`|".PLUGIN_MYMOOD_CYNICAL."|~||~||`|".PLUGIN_MYMOOD_DEPRESSED."|~||~||`|".PLUGIN_MYMOOD_DETERMINED."|~||~||`|".PLUGIN_MYMOOD_DEVIOUS."|~||~||`|".PLUGIN_MYMOOD_DIRTY."|~||~||`|".PLUGIN_MYMOOD_DISAPPOINTED."|~||~||`|".
                PLUGIN_MYMOOD_DISCONTENT."|~||~||`|".PLUGIN_MYMOOD_DISTRESSED."|~||~||`|".PLUGIN_MYMOOD_DITZY."|~||~||`|".PLUGIN_MYMOOD_DORKY."|~||~||`|".PLUGIN_MYMOOD_DRAINED."|~||~||`|".PLUGIN_MYMOOD_DRUNK."|~||~||`|".PLUGIN_MYMOOD_ECSTATIC."|~||~||`|".
                PLUGIN_MYMOOD_EMBARRASSED."|~||~||`|".PLUGIN_MYMOOD_ENERGETIC."|~||~||`|".PLUGIN_MYMOOD_ENRAGED."|~||~||`|".PLUGIN_MYMOOD_ENTHRALLED."|~||~||`|".PLUGIN_MYMOOD_ENVIOUS."|~||~||`|".PLUGIN_MYMOOD_EXANIMATE."|~||~||`|".PLUGIN_MYMOOD_EXCITED."|~||~||`|".
                PLUGIN_MYMOOD_EXHAUSTED."|~||~||`|".PLUGIN_MYMOOD_FLIRTY."|~||~||`|".PLUGIN_MYMOOD_FRUSTRATED."|~||~||`|".PLUGIN_MYMOOD_FULL."|~||~||`|".PLUGIN_MYMOOD_GEEKY."|~||~||`|".PLUGIN_MYMOOD_GIDDY."|~||~||`|".PLUGIN_MYMOOD_GIGGLY."|~||~||`|".
                PLUGIN_MYMOOD_GLOOMY."|~||~||`|".PLUGIN_MYMOOD_GOOD."|~||~||`|".PLUGIN_MYMOOD_GRATEFUL."|~||~||`|".PLUGIN_MYMOOD_GROGGY."|~||~||`|".PLUGIN_MYMOOD_GRUMPY."|~||~||`|".PLUGIN_MYMOOD_GUILTY."|~||~||`|".PLUGIN_MYMOOD_HAPPY."|~|$img_pre/smile.png|~||`|" .
                PLUGIN_MYMOOD_HIGH."|~||~||`|".PLUGIN_MYMOOD_HOPEFUL."|~||~||`|".PLUGIN_MYMOOD_HORNY."|~||~||`|".PLUGIN_MYMOOD_HOT."|~||~||`|".PLUGIN_MYMOOD_HUNGRY."|~||~||`|".PLUGIN_MYMOOD_HYPER."|~||~||`|".PLUGIN_MYMOOD_IMPRESSED."|~||~||`|".
                PLUGIN_MYMOOD_INDESCRIBABLE."|~||~||`|".PLUGIN_MYMOOD_INDIFFERENT."|~||~||`|".PLUGIN_MYMOOD_INFURIATED."|~||~||`|".PLUGIN_MYMOOD_INTIMIDATED."|~||~||`|".PLUGIN_MYMOOD_IRATE."|~||~||`|".PLUGIN_MYMOOD_IRRITATED."|~||~||`|".PLUGIN_MYMOOD_JEALOUS."|~||~||`|".
                PLUGIN_MYMOOD_JUBILANT."|~||~||`|".PLUGIN_MYMOOD_LAZY."|~||~||`|".PLUGIN_MYMOOD_LETHARGIC."|~||~||`|".PLUGIN_MYMOOD_LISTLESS."|~||~||`|".PLUGIN_MYMOOD_LONELY."|~||~||`|".PLUGIN_MYMOOD_LOVED."|~||~||`|".PLUGIN_MYMOOD_MELANCHOLY."|~||~||`|".
                PLUGIN_MYMOOD_MELLOW."|~||~||`|".PLUGIN_MYMOOD_MISCHIEVOUS."|~||~||`|".PLUGIN_MYMOOD_MOODY."|~||~||`|".PLUGIN_MYMOOD_MOROSE."|~||~||`|".PLUGIN_MYMOOD_NAUGHTY."|~||~||`|".PLUGIN_MYMOOD_NAUSEATED."|~||~||`|".PLUGIN_MYMOOD_NERDY."|~||~||`|".
                PLUGIN_MYMOOD_NERVOUS."|~||~||`|".PLUGIN_MYMOOD_NOSTALGIC."|~||~||`|".PLUGIN_MYMOOD_NUMB."|~||~||`|".PLUGIN_MYMOOD_OKAY."|~||~||`|".PLUGIN_MYMOOD_OPTIMISTIC."|~||~||`|".PLUGIN_MYMOOD_PEACEFUL."|~||~||`|".PLUGIN_MYMOOD_PENSIVE."|~||~||`|".
                PLUGIN_MYMOOD_PESSIMISTIC."|~||~||`|".PLUGIN_MYMOOD_PISSED_OFF."|~||~||`|".PLUGIN_MYMOOD_PLEASED."|~||~||`|".PLUGIN_MYMOOD_PREDATORY."|~||~||`|".PLUGIN_MYMOOD_PRETTY."|~||~||`|".PLUGIN_MYMOOD_PRODUCTIVE."|~||~||`|".PLUGIN_MYMOOD_QUIXOTIC."|~||~||`|".PLUGIN_MYMOOD_RECUMBENT."|~||~||`|".
                PLUGIN_MYMOOD_REFRESHED."|~||~||`|".PLUGIN_MYMOOD_REJECTED."|~||~||`|".PLUGIN_MYMOOD_REJUVENATED."|~||~||`|".PLUGIN_MYMOOD_RELAXED."|~||~||`|".PLUGIN_MYMOOD_RELIEVED."|~||~||`|".PLUGIN_MYMOOD_RESTLESS."|~||~||`|".PLUGIN_MYMOOD_RUSHED."|~||~||`|".
                PLUGIN_MYMOOD_SAD."|~|$img_pre/cry.png|~||`|".PLUGIN_MYMOOD_SATISFIED."|~||~||`|".PLUGIN_MYMOOD_SCARED."|~||~||`|".PLUGIN_MYMOOD_SHOCKED."|~||~||`|".PLUGIN_MYMOOD_SICK."|~||~||`|".PLUGIN_MYMOOD_SILLY."|~|$img_pre/tongue.png|~||`|".PLUGIN_MYMOOD_SLEEPY."|~||~||`|".
                PLUGIN_MYMOOD_SORE."|~||~||`|".PLUGIN_MYMOOD_STRESSED."|~||~||`|".PLUGIN_MYMOOD_SURPRISED."|~|$img_pre/eek.png|~||`|".PLUGIN_MYMOOD_SYMPATHETIC."|~||~||`|".PLUGIN_MYMOOD_THANKFUL."|~||~||`|".PLUGIN_MYMOOD_THIRSTY."|~||~||`|".PLUGIN_MYMOOD_THOUGHTFUL."|~||~||`|".
                PLUGIN_MYMOOD_TIRED."|~||~||`|".PLUGIN_MYMOOD_TOUCHED."|~||~||`|".PLUGIN_MYMOOD_UNCOMFORTABLE."|~||~||`|".PLUGIN_MYMOOD_WEIRD."|~||~||`|".PLUGIN_MYMOOD_WORKING."|~||~||`|".PLUGIN_MYMOOD_WORRIED."|~|$img_pre/sad.png|~|"
        );

#FIXME:  Add hooks for XML / exporting to convert images/text to ascii art/text or text-only.
#  That doesn't belong here.
        $sql = "CREATE TABLE IF NOT EXISTS {$serendipity['dbPrefix']}mymood (
                      mood_id {AUTOINCREMENT} {PRIMARY},
                      mood_name     varchar(255) NOT NULL default '',
                      mood_img      varchar(255) NOT NULL default '',
                      mood_ascii    varchar(255) NOT NULL default ''
                    )";

        serendipity_db_schema_import($sql);

        # Setting up some basic moods...
        $moods = array();
        $default_moods = explode('|`|', PLUGIN_MYMOOD_LISTOFMOODS);

        foreach ($default_moods AS $mood_s) {
            $info_array = explode('|~|', $mood_s);
            $moods[]=array(
                'mood_name'  => $info_array[0],
                'mood_img'   => $info_array[1],
                'mood_ascii' => $info_array[2],
            );
        }
#gar!  hafta check if there's already one defined...stupid 5000 'Happy's in my db...
#fixme:  this may need some sort of case insensitive stuff...
# also will want to add that to the adding part..
        foreach ($moods AS $mood_array) {
            $check_q = "SELECT mood_id FROM {$serendipity['dbPrefix']}mymood WHERE mood_name='{$mood_array['mood_name']}'";
            $t=serendipity_db_query($check_q);
            if (!empty($t[0])) { continue; }

            $insert_q = "INSERT INTO {$serendipity['dbPrefix']}mymood
                       (mood_name, mood_img, mood_ascii)
                       VALUES (
                       '{$mood_array['mood_name']}', '{$mood_array['mood_img']}','{$mood_array['mood_ascii']}')";

            serendipity_db_query($insert_q);
        }

        $this->set_config('db_built', 'true');
    }

    function resetDB()
    {
        global $serendipity;

        serendipity_db_query("DELETE FROM {$serendipity['dbPrefix']}mymood");
        $this->set_config('db_built', 'false');
    }


    function get_moods_list()
    {
        global $serendipity;

        $this->setupDB();

        $sql = "SELECT *
                  FROM {$serendipity['dbPrefix']}mymood
              ORDER BY mood_name";

        $items = serendipity_db_query($sql);
        if (!is_array($items)) {
            return array();
        } else {
            return $items;
        }
    }

    function get_entry_moods($e_id)
    {
        global $serendipity;

        $this->setupDB();

        if (empty($e_id)) {
            return array();
        }

        $q = "SELECT value FROM {$serendipity['dbPrefix']}entryproperties WHERE entryid = '$e_id' AND property = 'mymood'";
        $t = serendipity_db_query($q);
        if (is_array($t) && !empty($t[0]['value'])) {
            return explode(',', $t[0]['value']);
        } else {
            return array();
        }
    }

    function get_mood_info($m_id)
    {
        global $serendipity;

        $this->setupDB();
        $q = "SELECT * FROM {$serendipity['dbPrefix']}mymood WHERE mood_id = '$m_id'";
        $t = serendipity_db_query($q);

        if (is_array($t) && !empty($t[0]['mood_name'])) {
            return $t[0];
        } else {
            return array();
        }
    }

    # second param is to ignore the location field and force
    # adding of all 3 fields (used for background stuff)
    function format_mood($mood_info, $forced=FALSE)
    {
        $format = $this->get_config('display_format', '{img} {name}');

        $img_tag = (!empty($mood_info['mood_img'])) ?
            '<img class="mymood_img" alt="' . $mood_info['mood_name'] . '" src="' . $mood_info['mood_img'] . '">' :
            '';
        $ascii = (!empty($mood_info['mood_ascii'])) ? htmlentities($mood_info['mood_ascii'], ENT_COMPAT, LANG_CHARSET) : '';

        $format=str_replace(array('{img}', '{name}', '{ascii}'),
                            array($img_tag, $mood_info['mood_name'], $ascii),
                            $format);

        # if we are to display this in the title, remove all html tags...
        if ($forced!==TRUE and $this->get_config('location', 'body')=='title') {
            $format = strip_tags($format);
        }
        return $format;
    }



####################################
# admin functions
    function a_add_mood()
    {
        global $serendipity;

        $this->setupDB();

        $moods = $this->get_moods_list();

        foreach($serendipity['POST']['mymood'] AS $m_id => $array) {
            if (empty($m_id)) {
                if (empty($array['mood_img']) && empty($array['mood_ascii'])) {
                    continue;
                } elseif (empty($array['mood_name'])) {
                    echo '<div class="msg_error"><span class="icon-attention-circled" aria-hidden="true"></span> ' . PLUGIN_MYMOOD_MISSING_DATA . '</div>';
                } else {
                    $this->a_insert_mood($array);
                }
            } elseif (is_numeric($m_id)) {
                if ($array['mood_delete']==1) {
                    $this->a_delete_mood($m_id, $array);
                } else {
                    $this->a_update_mood($m_id, $array);
                }
            }
        }
    }

    function a_update_mood($m_id, &$array)
    {
        global $serendipity;

        $this->setupDB();
        $q = "UPDATE {$serendipity['dbPrefix']}mymood
                 SET mood_name     = '" . serendipity_db_escape_string($array['mood_name']) . "',
                     mood_img      = '" . serendipity_db_escape_string($array['mood_img']) . "',
                     mood_ascii    = '" . serendipity_db_escape_string($array['mood_ascii']) . "'
               WHERE mood_id       = " . (int)$m_id;
        return serendipity_db_query($q);
    }

    function a_delete_mood($m_id, &$array)
    {
        global $serendipity;

        $this->setupDB();
        $q = "DELETE FROM {$serendipity['dbPrefix']}mymood
                    WHERE mood_id = " . (int)$m_id;
        return serendipity_db_query($q);
    }

    function a_insert_mood(&$array)
    {
        global $serendipity;

        $this->setupDB();
        return serendipity_db_query("INSERT INTO {$serendipity['dbPrefix']}mymood
                                                (mood_name, mood_img, mood_ascii)
                                          VALUES ('" . serendipity_db_escape_string($array['mood_name']) . "','" . serendipity_db_escape_string($array['mood_img']) . "','" . serendipity_db_escape_string($array['mood_ascii']) . "')");
    }

    function a_show_moods()
    {
        global $serendipity;

        if (!empty($serendipity['POST']['mymoodAction'])) {
            $this-> a_add_mood();
        }

        $moods = $this->get_moods_list();
        $moods[] = array(
            'mood_id'       => 0,
            'mood_name'     => '',
            'mood_img'      => '',
            'mood_ascii'    => '',
            'mood_delete'   => ''
        );

        echo '<h2>' . PLUGIN_MYMOOD_TITLE . '</h2>';
        echo PLUGIN_MYMOOD_DESC . '<br /><br />';
        echo PLUGIN_MYMOOD_MOOD_LIST . '<br /><br />';

        echo '
            <form action="?" method="post">
            <div>
                <input type="hidden" name="serendipity[adminModule]" value="event_display" />
                <input type="hidden" name="serendipity[adminAction]" value="mymood" />
            </div>
            <table align="center" width="100%" cellpadding="10" cellspacing="0">
                <tr>
                    <th>#</th>
                    <th>' . PLUGIN_MYMOOD_MOOD_DELETE . '</th>
                    <th>' . PLUGIN_MYMOOD_MOOD_NAME . '</th>
                    <th>' . PLUGIN_MYMOOD_MOOD_IMG . '</th>
                    <th>' . PLUGIN_MYMOOD_MOOD_ASCII . '</th>
                </tr>';
        $count = 1;
        foreach($moods AS $m_id => $mood) {
            $even  = ($m_id % 2 ? 'even' : 'uneven');

            echo "<tr style='padding: 10px;' class='serendipity_admin_list_item serendipity_admin_list_item_$even'>\n";
            echo "  <td><em>$count</em></td>\n";
            echo "  <td style='text-align: center'><input class='input_checkbox' type='checkbox' value='1' name=\"serendipity[mymood][{$mood['mood_id']}][mood_delete]\"></td>\n";
            echo "  <td><input class='input_textbox' type='text' name=\"serendipity[mymood][{$mood['mood_id']}][mood_name]\" value=\"" . (function_exists('serendipity_specialchars') ? serendipity_specialchars($mood['mood_name']) : htmlspecialchars($mood['mood_name'], ENT_COMPAT, LANG_CHARSET)) . "\" /></td>\n";
            echo "  <td><input class='input_textbox' style='width: 100%' type='text' name=\"serendipity[mymood][{$mood['mood_id']}][mood_img]\" value=\"" . (function_exists('serendipity_specialchars') ? serendipity_specialchars($mood['mood_img']) : htmlspecialchars($mood['mood_img'], ENT_COMPAT, LANG_CHARSET)) . "\" /></td>\n";
            echo "  <td style='text-align: center'><input class='input_textbox' style='text-align: center' type='text' size='5' name=\"serendipity[mymood][{$mood['mood_id']}][mood_ascii]\" value=\"" . (function_exists('serendipity_specialchars') ? serendipity_specialchars($mood['mood_ascii']) : htmlspecialchars($mood['mood_ascii'], ENT_COMPAT, LANG_CHARSET)) . "\" /></td>\n";
            echo "</tr>\n";

            $count++;
        }

        echo '
                <tr>
                    <td colspan="4"><br />
                        <input class="serendipityPrettyButton input_button" type="submit" name="serendipity[mymoodAction]" value="' . GO . '" />
                    </td>
                </tr>
              </table>
              </form>

              <script type="text/javascript">
                function confirm_reset() {
                    if (confirm(\'' . PLUGIN_MYMOOD_CONFIRM_RESET . '\')) {
                        document.reset_form.submit();
                    }
                }
              </script>

              <form action="?" method="post" name="reset_form">
                <input type="hidden" name="serendipity[adminModule]" value="event_display" />
                <input type="hidden" name="serendipity[adminAction]" value="mymood" />
                <input type="hidden" name="serendipity[mymood_resetdb]" value="true" />
                <input type="button" class="serendipityPrettyButton input_button" value="' . PLUGIN_MYMOOD_CONFIRM_RESET_BUTTON . '" onclick="confirm_reset()" />
              </form>
              ';
    }



########################
# backend_display functions for entries
#
    function b_pick_moods($e_id)
    {
        global $serendipity;

        $moods = $this->get_moods_list();

        # getting used moods
        if (isset($serendipity['POST']['mymood']) && is_array($serendipity['POST']['mymood'])) {
            $used_moods = $serendipity['POST']['mymood'];
        } else {
            $used_moods = $this->get_entry_moods($e_id);
        }

        # getting moods to add
        $new_moods = array();
        if (isset($serendipity['POST']['mymood_new']) && is_array($serendipity['POST']['mymood_new'])) {
            foreach ($serendipity['POST']['mymood_new'] AS $mood) {
                if (!empty($mood['mood_name'])) {
                    $new_moods[] = $mood;
                }
            }
        }
?>
            <fieldset id="edit_entry_mymood" class="entryproperties_mymood">
                <span class="wrap_legend"><legend><?php echo PLUGIN_MYMOOD_TITLE; ?></legend></span>

                <table class="mood_select" cellpadding="3" cellspacing="0" width="100%">
<?php
        $c = 0;
        $max = 5;
        foreach ($moods AS $mood) {
            $checked = (in_array($mood['mood_id'], $used_moods)) ? 'checked="checked"' : '';
            $label = $this->format_mood($mood, true);
            if ($c == 0) {
?>
                    <tr>;
                        <td>
<?php
            } else {
?>
                        <td>
<?php
            }
?>
                            <input class="input_checkbox" type="checkbox" id="<?=$mood['mood_id']?>" name="serendipity[mymood][]" value="<?=$mood['mood_id']?>" <?=$checked?>>
                            <label for="<?=$mood['mood_id']?>">$label?></label>

<?php
            if ($c == $max-1) {
?>
                        </td>
                    <tr>
<?php
                $c = 0;
            } else {
?>
                        </td>
<?php
                $c++;
            }
        }

        # fill out the rest of the table and close it off...
        if ($c != 0) {
            while ($c<$max) {
?>
                        <td> &nbsp; </td>
<?php
                $c++;
            }
?>
                    <tr>
<?php
        }
?>
                 </table>
<?php
        # letting them add moods.
        #fixme:  if they list a mood that's already there, should we update??
        #some people said they want to be able to have crazy and cRaZy point to two different
        #imgs.  Just keep adding them, I guess....
        $id = count ($new_moods) + 1;
    echo'
                <script type="text/javascript">
                    var id='.$id.';
                    function mymood_new_entry() {
                        var form="";
                        var id_test="";

                        form="'.PLUGIN_MYMOOD_NEW_MOOD.': <input class=\"input_textbox\" type=\"text\" name=\"serendipity[mymood_new][" + id + "][mood_name]\" size=\"10\">" +
                             " '.PLUGIN_MYMOOD_NEW_ASCII.': <input class=\"input_textbox\" type=\"text\" size=\"3\" name=\"serendipity[mymood_new][" + id + "][mood_ascii]\">" +
                             " '.PLUGIN_MYMOOD_NEW_IMAGE.': <input class=\"input_textbox\" type=\"text\" size=\"20\" name=\"serendipity[mymood_new][" + id + "][mood_img]\"><br />" +
                             "<div id=\"mymood_new_mood_" + (id+1) + "\"></div>";
                        id_t="mymood_new_mood_" + (id);
                        document.getElementById(id_t).innerHTML=form;
                        id++;
                    }
                </script>';
        $i=0;
        foreach ($new_moods AS $mood) {
            echo '
                <div class="form_field">
                    <label for="'.str_replace(' ', '_', strtolower(PLUGIN_MYMOOD_NEW_MOOD)).'">'.PLUGIN_MYMOOD_NEW_MOOD.'_'.$i.':</label> <input id="'.str_replace(' ', '_', strtolower(PLUGIN_MYMOOD_NEW_MOOD)).'" class="input_textbox" type="text" name="serendipity[mymood_new]['.$i.'][mood_name]" value="{$mood[\'mood_name\']}" size="10">
                    <label for="'.str_replace(' ', '_', strtolower(PLUGIN_MYMOOD_NEW_ASCII)).'">'.PLUGIN_MYMOOD_NEW_ASCII.'_'.$i.':</label> <input id="'.str_replace(' ', '_', strtolower(PLUGIN_MYMOOD_NEW_ASCII)).'" class="input_textbox" type="text" size="3" name="serendipity[mymood_new]['.$i.'][mood_ascii]" value="{$mood[\'mood_ascii\']}" size="3">
                    <label for="'.str_replace(' ', '_', strtolower(PLUGIN_MYMOOD_NEW_IMAGE)).'">'.PLUGIN_MYMOOD_NEW_IMAGE.'_'.$i.':</label> <input id="'.str_replace(' ', '_', strtolower(PLUGIN_MYMOOD_NEW_IMAGE)).'" class="input_textbox" type="text" size="30" name="serendipity[mymood_new]['.$i.'][mood_img]" value="{$mood[\'mood_img\']}">
                </div>';
            $i++;
        }

        #grawr lazy
        $new_moods = PLUGIN_MYMOOD_MORE_NEW_MOODS;
        $cur_id = $id-1;
        echo '
                <div class="form_field">
                    <label for="'.str_replace(' ', '_', strtolower(PLUGIN_MYMOOD_NEW_MOOD)).'">'.PLUGIN_MYMOOD_NEW_MOOD.':</label> <input id="'.str_replace(' ', '_', strtolower(PLUGIN_MYMOOD_NEW_MOOD)).'" class="input_textbox" type="text" name="serendipity[mymood_new]['.$cur_id.'][mood_name]" size="10">
                    <label for="'.str_replace(' ', '_', strtolower(PLUGIN_MYMOOD_NEW_ASCII)).'">'.PLUGIN_MYMOOD_NEW_ASCII.':</label> <input id="'.str_replace(' ', '_', strtolower(PLUGIN_MYMOOD_NEW_ASCII)).'" class="input_textbox" type="text" size="3" name="serendipity[mymood_new]['.$cur_id.'][mood_ascii]" size="3">
                    <label for="'.str_replace(' ', '_', strtolower(PLUGIN_MYMOOD_NEW_IMAGE)).'">'.PLUGIN_MYMOOD_NEW_IMAGE.':</label> <input id="'.str_replace(' ', '_', strtolower(PLUGIN_MYMOOD_NEW_IMAGE)).'" class="input_textbox" type="text" size=\"30\" name="serendipity[mymood_new]['.$cur_id.'][mood_img]">
                </div>
                <div id="mymood_new_mood_'.$id.'"></div>
                <div class="form_field">
                    <input type="button" class="serendipityPrettyButton input_button" value="'.$new_moods.'" onClick="javascript:mymood_new_entry()" />
                </div>
            </fieldset>
';
    }

    function b_add_moods($e_id)
    {
        global $serendipity;

        # add any new moods...
        # fixme:  there has to be a better way to get the
        # last insert'd id...
        $new_ids = array();
        if (is_array($serendipity['POST']['mymood_new'])) {
            foreach ($serendipity['POST']['mymood_new'] AS $mood) {
                if (!empty($mood['mood_name'])) {
                    $this->a_insert_mood($mood);

                    $id_t=serendipity_db_query("SELECT mood_id FROM {$serendipity['dbPrefix']}mymood
                            WHERE mood_name='{$mood['mood_name']}' AND mood_img='{$mood['mood_img']}' AND mood_ascii='{$mood['mood_ascii']}' LIMIT 1");
                    $new_ids[]=$id_t[0]['mood_id'];
                }
            }
        }
        serendipity_db_query("DELETE FROM {$serendipity['dbPrefix']}entryproperties WHERE entryid = '" . $e_id . "' AND property = 'mymood'");
        if (!empty($serendipity['POST']['mymood'])) {
            $mood_array = array_merge($serendipity['POST']['mymood'], $new_ids);
            $moods_s = implode (',', $mood_array);
            serendipity_db_query("INSERT INTO {$serendipity['dbPrefix']}entryproperties (entryid, value, property) VALUES ('" . $e_id . "', '" . $moods_s . "', 'mymood')");
        }
    }



################################
# frontend functions for entries...
    function f_display_moods($e_id)
    {
        global $serendipity;

        # bail if there is no way to display (pdf plugin, for example)
        if (!isset($serendipity['smarty'])) {
          return false;
        }

        $moods = $this->get_entry_moods($e_id);

        # bail if there are no entries...
        if (count ($moods)<1) { return false; }

        #format moods
        $delimiter = "";
        foreach ($moods AS $mood) {
            $formatted_moods[] = $delimiter.$this->format_mood($this->get_mood_info($mood));
            $delimiter = " | ";
        }

        # grab template
        $tfile = serendipity_getTemplateFile('plugin_mymood.tpl', 'serendipityPath');
        if (!$tfile) {
            $tfile = dirname(__FILE__) . '/plugin_mymood.tpl';
        }
        $serendipity['smarty']->assign('plugin_mymood_intro', $this->get_config('intro', ''));
        $serendipity['smarty']->assign('plugin_mymood_location', $this->get_config('location', 'body'));
        $serendipity['smarty']->assign('plugin_mymood_mood_list', $formatted_moods);
        $serendipity['smarty']->assign('plugin_mymood_outro', $this->get_config('outro', ''));

        $content = $serendipity['smarty']->fetch('file:'. $tfile);

        return $content;
    }

    function generate_content(&$title)
    {
        $title = PLUGIN_MYMOOD_TITLE;
    }

    function event_hook($event, &$bag, &$eventData, $addData = null)
    {
        global $serendipity;

        $hooks = &$bag->get('event_hooks');

        if (isset($hooks[$event])) {
            switch($event) {
                case 'backend_sidebar_entries':
?>
                    <li class="serendipitySideBarMenuLink serendipitySideBarMenuEntryLinks"><a href="?serendipity[adminModule]=event_display&amp;serendipity[adminAction]=mymood"><?php echo PLUGIN_MYMOOD_TITLE; ?></a></li>
<?php
                    break;

                case 'backend_sidebar_entries_event_display_mymood':
                    if (isset($serendipity['POST']['mymood_resetdb']) && $serendipity['POST']['mymood_resetdb'] == 'true') {
                        $this->resetDB();
                        $this->setupDB();
                        echo '<span class="msg_success"><span class="icon icon-ok-circled"></span> Reset the db!</span>';
                    }
                    $this->a_show_moods();
                    break;

                case 'backend_display':
                    $this->b_pick_moods(($eventData['id'] ?? null));
                    break;

                case 'backend_publish':
                case 'backend_save':
                    $this->b_add_moods($eventData['id']);
                    break;

                case 'entry_display':
                    $elements = is_array($eventData) ? count($eventData) : 0;
                    if ($elements < 1) {
                        return true;
                    }
                    for ($i = 0; $i < $elements; $i++) {

                        $location = ($this->get_config('location', 'body'));

                        switch ($location) {
                            case 'body':
                            case 'title':
                            case 'author':
                                $location = $location;
                                break;

                            case 'smarty':
                                $location = 'mymood';
                                break;

                            case 'footer':
                                $location = 'add_footer';
                                $delim = '';
                                break;
                        }

                        # do nothing if we don't have any moods

                        $moods = $this->f_display_moods($eventData[$i]['id']);
                        if (!empty($moods)) {
                            if ($this->get_config('place_before')==false) {
                                $eventData[$i][$location] .= $delim . $moods;
                            } else {
                                $eventData[$i][$location] = $delim . $moods . $eventData[$i][$location];
                            }
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