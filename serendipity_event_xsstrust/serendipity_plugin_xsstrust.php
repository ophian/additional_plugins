<?php

/* Author: Nicola Zanoni, (nicola.zanoni@gmail.com) */

declare(strict_types=1);

if (IN_serendipity !== true) {
    die ("Don't hack!");
}

@serendipity_plugin_api::load_language(dirname(__FILE__));

class serendipity_plugin_xsstrust extends serendipity_plugin
{
    public $title = PLUGIN_ETHICS_NAME;

    function introspect(&$propbag)
    {
        global $serendipity;

        $propbag->add('name',          PLUGIN_ETHICS_NAME);
        $propbag->add('description',   PLUGIN_ETHICS_BLAHBLAH);
        $propbag->add('stackable',     false);
        $propbag->add('author',        'Loris Zena, Ian Styx');
        $propbag->add('version',       '2.0.1');
        $propbag->add('requirements',  array(
            'serendipity' => '5.0',
            'smarty'      => '4.1',
            'php'         => '8.2'
        ));

        $propbag->add('configuration', array('base_val'));
        $propbag->add('groups', array('FRONTEND_VIEWS'));
    }

    function introspect_config_item($name, &$propbag)
    {
        switch($name) {
            case 'base_val':
                $propbag->add('type', 'string');
                $propbag->add('name', PLUGIN_ETHICS_BASEVAL);
                $propbag->add('description', PLUGIN_ETHICS_BASEVAL_BLAHBLAH);
                $propbag->add('default',     1);
                break;

            default:
                return false;
        }
        return true;
    }

    function generate_content(&$title)
    {
        global $serendipity;

        $title    = $this->title;
        $base_val = $this->get_config('base_val');

        // Create table, if not yet existant
        if ($this->get_config('version') != '1.0') {
            $q   = "CREATE TABLE IF NOT EXISTS {$serendipity['dbPrefix']}ethics (
                        id int(10) {PRIMARY},
                        ethics int(1) default 1,
                        pwd varchar(32),
                        last_banned int(10) {UNSIGNED} default null
                    )";
            $sql = serendipity_db_schema_import($q);
            $this->set_config('version', '1.0');

            $q = 'SELECT   authorid              AS villan_id,
                           realname              AS villan
                  FROM     '.$serendipity['dbPrefix'].'authors
                  WHERE    userlevel < '.USERLEVEL_ADMIN;

            $sql = serendipity_db_query($q);
            if ($sql && is_array($sql)) {
                $e_val = (int)$base_val;
                if (!$e_val || !is_numeric($e_val) || $e_val < 1 || $e_val > 3) {
                    $e_val = 1;
                }

                foreach($sql AS $key => $row) {
                    $villan_id = $row['villan_id'];

                    $q1 = "INSERT INTO {$serendipity['dbPrefix']}ethics (id, ethics, pwd, last_banned)
                           VALUES(" . (int)$villan_id . ", " . (int)$e_val . ", '', 0);";
                    $sql = serendipity_db_query($q1);
                }
            }
        }

        $q = 'SELECT   a.authorid              AS villan_id,
                       a.realname              AS villan
              FROM     '.$serendipity['dbPrefix'].'authors AS a
   LEFT OUTER JOIN     '.$serendipity['dbPrefix'].'ethics AS e
                ON     e.id = a.authorid
             WHERE     userlevel < '.USERLEVEL_ADMIN . '
               AND     e.id IS NULL';
        $sql = serendipity_db_query($q);
        if ($sql && is_array($sql)) {
            foreach($sql AS $key => $row) {
                $villan_id = $row['villan_id'];
                $e_val     = $base_val;

                if (!$e_val || !is_numeric($e_val) || $e_val < 1 || $e_val > 3) {
                    $e_val = 1;
                }

                $q1 = "INSERT INTO {$serendipity['dbPrefix']}ethics (id, ethics, pwd, last_banned)
                            VALUES(".(int)$villan_id.", ".(int)$e_val.", '', 0);";
                $sqli = serendipity_db_query($q1);
            }
        }

        // Modify ethic value, only if administrator
        if ($serendipity['serendipityUserlevel'] >= USERLEVEL_ADMIN) {
            $act  = $_REQUEST['ethic_act'];
            $vill = (int)$_REQUEST['ethic_vill'];
            $ethic_received = (int)$_REQUEST['ethic_ethic'];

            $q = "SELECT ethics FROM {$serendipity['dbPrefix']}ethics
                  WHERE  id = $vill";
            $sql = serendipity_db_query($q);

            if ($sql && is_array($sql)) {
                 foreach($sql AS $key => $row) {
                      $eti = $row['ethics'];
                 }
            }

            if ($act != "" && $vill != "" && $ethic_received == $eti) {
                 if ($act == "m") {
                     if ($eti > 1) {
                         $q = "UPDATE {$serendipity['dbPrefix']}ethics SET ethics = ethics - 1
                               WHERE id = $vill";
                         $sql = serendipity_db_query($q);
                     }
                     if ($eti == 3) {
                         $q1 = "SELECT pwd FROM {$serendipity['dbPrefix']}ethics
                                WHERE  id = $vill";
                         $sql = serendipity_db_query($q1);
                         if ($sql && is_array($sql)) {
                             foreach($sql AS $key => $row) {
                                 $password = $row['pwd'];
                             }
                         }
                         $q2 = "UPDATE {$serendipity['dbPrefix']}authors SET password = '$password'
                                WHERE authorid = $vill";
                         $sql = serendipity_db_query($q2);
                     }
                 } else if ($act == "p") {
                     if ($eti < 3) {
                         $q = "UPDATE {$serendipity['dbPrefix']}ethics SET ethics = ethics + 1
                               WHERE id = $vill";
                         $sql = serendipity_db_query($q);
                     }
                     if ($eti == 2) {
                         $q1 = "SELECT password FROM {$serendipity['dbPrefix']}authors
                                 WHERE authorid = $vill";
                         $sql = serendipity_db_query($q1);
                         if ($sql && is_array($sql)) {
                             foreach($sql AS $key => $row) {
                                 $password = $row['password'];
                             }
                         }
                         $today = getdate();
                         $q2 = "UPDATE {$serendipity['dbPrefix']}ethics
                                SET pwd = '$password', last_banned = '" . time() . "'
                                WHERE id = $vill";
                         $sql = serendipity_db_query($q2);
                         $new_password = "banned_for_a_while";
                         $q3 = "UPDATE {$serendipity['dbPrefix']}authors SET password = '$new_password'
                                WHERE authorid = $vill";
                         $sql = serendipity_db_query($q3);
                     }
                 }
            }
        } // end of admin part

        $q = 'SELECT    a.authorid              AS villan_id,
                        a.realname              AS villan,
                        a.password              AS pwd,
                        e.id                    AS ethic_id,
                        e.ethics                AS ethics
                FROM    '.$serendipity['dbPrefix'].'authors AS a,
                        '.$serendipity['dbPrefix'].'ethics AS e
                WHERE   a.authorid = e.id
            ORDER BY    a.realname ASC';
?>
        <div style="margin: 0px; padding: 0px; text-align: justify;">
        <p>
<?php
        echo PLUGIN_ETHICS_INTRO;
?>
        <br>
<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="green" class="bi bi-stoplights" viewBox="0 0 16 16" style="vertical-align: middle;">
  <title><?=PLUGIN_ETHICS_GREENLIGHT?></title>
  <path d="M8 5a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3m0 4a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3m1.5 2.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0"/>
  <path d="M4 2a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2h2c-.167.5-.8 1.6-2 2v2h2c-.167.5-.8 1.6-2 2v2h2c-.167.5-.8 1.6-2 2v1a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2v-1c-1.2-.4-1.833-1.5-2-2h2V8c-1.2-.4-1.833-1.5-2-2h2V4c-1.2-.4-1.833-1.5-2-2zm2-1a1 1 0 0 0-1 1v11a1 1 0 0 0 1 1h4a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1z"/>
</svg>
<?php
        echo PLUGIN_ETHICS_GREENLIGHT."  ";
?>
<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="yellow" class="bi bi-stoplights" viewBox="0 0 16 16" style="vertical-align: middle;">
  <title><?=PLUGIN_ETHICS_YELLOWLIGHT?></title>
  <path d="M8 5a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3m0 4a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3m1.5 2.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0"/>
  <path d="M4 2a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2h2c-.167.5-.8 1.6-2 2v2h2c-.167.5-.8 1.6-2 2v2h2c-.167.5-.8 1.6-2 2v1a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2v-1c-1.2-.4-1.833-1.5-2-2h2V8c-1.2-.4-1.833-1.5-2-2h2V4c-1.2-.4-1.833-1.5-2-2zm2-1a1 1 0 0 0-1 1v11a1 1 0 0 0 1 1h4a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1z"/>
</svg>
<?php
        echo PLUGIN_ETHICS_YELLOWLIGHT."  ";
?>
<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="red" class="bi bi-stoplights" viewBox="0 0 16 16" style="vertical-align: middle;">
  <title><?=PLUGIN_ETHICS_REDLIGHT?></title>
  <path d="M8 5a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3m0 4a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3m1.5 2.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0"/>
  <path d="M4 2a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2h2c-.167.5-.8 1.6-2 2v2h2c-.167.5-.8 1.6-2 2v2h2c-.167.5-.8 1.6-2 2v1a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2v-1c-1.2-.4-1.833-1.5-2-2h2V8c-1.2-.4-1.833-1.5-2-2h2V4c-1.2-.4-1.833-1.5-2-2zm2-1a1 1 0 0 0-1 1v11a1 1 0 0 0 1 1h4a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1z"/>
</svg>
<?php
        echo PLUGIN_ETHICS_REDLIGHT;
?>
        </p>
        <table class="table" align="center" width="100%">
<?php
        $sql = serendipity_db_query($q);
        if ($sql && is_array($sql)) {
            foreach($sql AS $key => $row) {
                echo "<tr><td>";
                echo htmlspecialchars($row['villan'], ENT_COMPAT, LANG_CHARSET)."</td><td>";
                if ($row['ethics'] == 3) {
?>
<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="red" class="bi bi-stoplights" viewBox="0 0 16 16">
  <title><?=PLUGIN_ETHICS_REDLIGHT?></title>
  <path d="M8 5a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3m0 4a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3m1.5 2.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0"/>
  <path d="M4 2a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2h2c-.167.5-.8 1.6-2 2v2h2c-.167.5-.8 1.6-2 2v2h2c-.167.5-.8 1.6-2 2v1a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2v-1c-1.2-.4-1.833-1.5-2-2h2V8c-1.2-.4-1.833-1.5-2-2h2V4c-1.2-.4-1.833-1.5-2-2zm2-1a1 1 0 0 0-1 1v11a1 1 0 0 0 1 1h4a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1z"/>
</svg>
<?php
                } else if ($row['ethics'] == 2) {
?>
<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="yellow" class="bi bi-stoplights" viewBox="0 0 16 16">
  <title><?=PLUGIN_ETHICS_YELLOWLIGHT?></title>
  <path d="M8 5a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3m0 4a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3m1.5 2.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0"/>
  <path d="M4 2a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2h2c-.167.5-.8 1.6-2 2v2h2c-.167.5-.8 1.6-2 2v2h2c-.167.5-.8 1.6-2 2v1a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2v-1c-1.2-.4-1.833-1.5-2-2h2V8c-1.2-.4-1.833-1.5-2-2h2V4c-1.2-.4-1.833-1.5-2-2zm2-1a1 1 0 0 0-1 1v11a1 1 0 0 0 1 1h4a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1z"/>
</svg>
<?php
                } else {
?>
<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="green" class="bi bi-stoplights" viewBox="0 0 16 16">
  <title><?=PLUGIN_ETHICS_GREENLIGHT?></title>
  <path d="M8 5a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3m0 4a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3m1.5 2.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0"/>
  <path d="M4 2a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2h2c-.167.5-.8 1.6-2 2v2h2c-.167.5-.8 1.6-2 2v2h2c-.167.5-.8 1.6-2 2v1a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2v-1c-1.2-.4-1.833-1.5-2-2h2V8c-1.2-.4-1.833-1.5-2-2h2V4c-1.2-.4-1.833-1.5-2-2zm2-1a1 1 0 0 0-1 1v11a1 1 0 0 0 1 1h4a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1z"/>
</svg>
<?php
                }
                echo "</td>";
                if ($serendipity['serendipityUserlevel'] >= USERLEVEL_ADMIN) {
                    echo "<td>";
                    if ($row['ethics'] < 3)
                        echo "<a href=\"".$serendipity['serendipityHTTPPath'] . $serendipity['indexFile']."?ethic_vill=".$row['villan_id']."&amp;ethic_act=p&amp;ethic_ethic=".$row['ethics']."\">";
                    echo '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-caret-down-square" viewBox="0 0 16 16"><path d="M3.626 6.832A.5.5 0 0 1 4 6h8a.5.5 0 0 1 .374.832l-4 4.5a.5.5 0 0 1-.748 0z"/><path d="M0 2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2zm15 0a1 1 0 0 0-1-1H2a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1z"/></svg>';
                    if ($row['ethics'] < 3)
                        echo "</a>";
                    echo "&nbsp&nbsp;";
                    if ($row['ethics'] > 1)
                        echo "<a href=\"".$serendipity['serendipityHTTPPath'] . $serendipity['indexFile']."?ethic_vill=".$row['villan_id']."&amp;ethic_act=m&amp;ethic_ethic=".$row['ethics']."\">";
                    echo '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-caret-up-square" viewBox="0 0 16 16"><path d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2z"/><path d="M3.544 10.705A.5.5 0 0 0 4 11h8a.5.5 0 0 0 .374-.832l-4-4.5a.5.5 0 0 0-.748 0l-4 4.5a.5.5 0 0 0-.082.537"/></svg>';
                    if ($row['ethics'] > 1)
                        echo "</a>";
                    echo "</td>";
                }
                echo "</tr>";
            }
        }
?>
</table>
</div>
<?php
    }

}

?>