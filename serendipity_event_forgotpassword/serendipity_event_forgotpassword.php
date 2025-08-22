<?php

declare(strict_types=1);

if (IN_serendipity !== true) {
    die ("Don't hack!");
}

@serendipity_plugin_api::load_language(dirname(__FILE__));

class serendipity_event_forgotpassword extends serendipity_event
{
    public $title = PLUGIN_EVENT_FORGOTPASSWORD_NAME;

    function introspect(&$propbag)
    {
        $propbag->add('name',          PLUGIN_EVENT_FORGOTPASSWORD_NAME);
        $propbag->add('description',   PLUGIN_EVENT_FORGOTPASSWORD_DESC);
        $propbag->add('stackable',     false);
        $propbag->add('author',        'Omid Mottaghi, Ian Styx');
        $propbag->add('version',       '1.0.1');
        $propbag->add('requirements',  array(
            'serendipity' => '5.0',
            'smarty'      => '4.1',
            'php'         => '8.2'
        ));
        $propbag->add('event_hooks',   array('backend_login_page' => true));

        $propbag->add('configuration', array('nomailinfo', 'nomailadd', 'nomailtxt'));
        $propbag->add('groups', array('BACKEND_FEATURES'));
        $propbag->add('legal',    array(
            'services' => array(
                'mail' => array(
                    'url'  => '#',
                    'desc' => 'Sends E-Mails to user-specified addresses'
                ),
            ),
            'frontend' => array(
            ),
            'backend' => array(
                'This plugin sends tokens/links via e-mail as the result of a "forgot login" function.',
            ),
            'cookies' => array(
            ),
            'stores_user_input'     => false,
            'stores_ip'             => false,
            'uses_ip'               => false,
            'transmits_user_input'  => true
        ));
    }

    function generate_content(&$title)
    {
        $title = $this->title;
    }

    function introspect_config_item($name, &$propbag)
    {
        switch($name) {
            case 'nomailinfo':
                $propbag->add('type',        'text');
                $propbag->add('name',        PLUGIN_EVENT_FORGOTPASSWORD_MAILER);
                $propbag->add('default',     PLUGIN_EVENT_FORGOTPASSWORD_MAILER_DEFAULT);
                break;

            case 'nomailtxt':
                $propbag->add('type',        'text');
                $propbag->add('name',        PLUGIN_EVENT_FORGOTPASSWORD_MAILER_MAILTXT);
                $propbag->add('default',     PLUGIN_EVENT_FORGOTPASSWORD_MAILER_MAILTXT_DEFAULT);
                break;

            case 'nomailadd':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_EVENT_FORGOTPASSWORD_MAILER_MAIL);
                $propbag->add('default',     '');
                break;
        }
        return true;
    }

    function install()
    {
        global $serendipity;

        //create table xxxx_forgotpassword
        $q = "CREATE TABLE {$serendipity['dbPrefix']}forgotpassword (
                uid varchar(32) not null,
                authorid int(11) not null
            )";
        serendipity_db_schema_import($q);
    }

    function uninstall(&$propbag)
    {
        global $serendipity;

        // Drop tables
        $q = "DROP TABLE ".$serendipity['dbPrefix']."forgotpassword";
        serendipity_db_schema_import($q);
    }

    function event_hook($event, &$bag, &$eventData, $addData = null)
    {
        global $serendipity;

        $hooks = &$bag->get('event_hooks');

        if (isset($hooks[$event])) {

            switch($event) {

                case 'backend_login_page':
                    // first LINK
                    if (!isset($_GET['forgotpassword']) && !isset($_GET['username']) && !isset($_POST['username'])) {
                        $eventData['footer'] = '
        <p class="serendipity_center"><a href="?forgotpassword=1">' . PLUGIN_EVENT_FORGOTPASSWORD_LOST_PASSWORD . '</a></p>';
                        return true;
                    // first FORM
                    } elseif (!isset($_POST['username']) && !isset($_GET['uid'])) {
                        $eventData['footer'] = '
        <form id="auth_fpwd" class="clearfix" action="serendipity_admin.php" method="post">
            <fieldset>
                <span class="wrap_legend"><legend>' . PLUGIN_EVENT_FORGOTPASSWORD_ENTER_USERNAME . '</legend></span>

                <div class="form_field">
                    <label for="auth_uid">'.USERNAME.'</label>
                    <input id="auth_uid" class="input_textbox" name="username" autocomplete="new-password" type="text" autofocus="">
                </div>

                <div class="form_buttons">
                    <input id="auth_fpwd_submit" name="forgot" type="submit" value="' . PLUGIN_EVENT_FORGOTPASSWORD_SEND_EMAIL . '">
                </div>
            </fieldset>
        </form>
';
                        return true;
                    // submitted FORM (send an email to user and show a simple page)
                    } elseif (!isset($_POST['uid']) && isset($_POST['username'])) {
                        $q   = 'SELECT email, authorid FROM '.$serendipity['dbPrefix'].'authors where username = \''.serendipity_db_escape_string($_POST['username']).'\'';
                        $sql = serendipity_db_query($q);
                        if (!is_array($sql) || count($sql) < 1) {
                            $eventData['footer'] = '<div class="msg_error"><span class="icon-attention-circled" aria-hidden="true"></span> ' . PLUGIN_EVENT_FORGOTPASSWORD_USER_NOT_EXIST . ' &raquo;&raquo; <a href="" onClick="history.back()">'.BACK.'</a> &laquo;&laquo;.</div>';
                            return true;
                        }

                        if ($sql && is_array($sql)) {

                            if (empty($sql[0]['email'])) {
                                $eventData['footer'] = '<div class="msg_error"><span class="icon-attention-circled" aria-hidden="true"></span> ' . $this->get_config('nomailinfo') . '</div>';

                                if ($this->get_config('nomailadd') != '') {
                                    $sent = serendipity_sendMail($this->get_config('nomailadd'), PLUGIN_EVENT_FORGOTPASSWORD_EMAIL_SUBJECT, sprintf($this->get_config('nomailtxt'), $_POST['username']), NULL);
                                }
                                return true;
                            }
                            $res = $sql[0];
                            $email = $res['email'];
                            $authorid = $res['authorid'];

                            $hash = hash('xxh128', uniqid((string) time()));

                            $q = 'INSERT INTO '.$serendipity['dbPrefix'].'forgotpassword VALUES (\''.$hash.'\', \''.$authorid.'\')';
                            $sql = serendipity_db_query($q);

                            if (!$sql){
                                $eventData['footer'] = '
        <div class="msg_error"><span class="icon-attention-circled" aria-hidden="true"></span> ' . PLUGIN_EVENT_FORGOTPASSWORD_EMAIL_DB_ERROR . '</div>';
                                break;
                            }

                            $sent = serendipity_sendMail($email, PLUGIN_EVENT_FORGOTPASSWORD_EMAIL_SUBJECT, PLUGIN_EVENT_FORGOTPASSWORD_EMAIL_BODY . $serendipity['baseURL'] . 'serendipity_admin.php?username='.$authorid.'&uid='.$hash, NULL);
                            if ($sent) {
                                $eventData['footer'] = '
        <div class="msg_success"><span class="icon-ok-circled" aria-hidden="true"></span> ' . PLUGIN_EVENT_FORGOTPASSWORD_EMAIL_SENT . '</div>';
                            } else {
                                $eventData['footer'] = '
        <div class="msg_error"><span class="icon-attention-circled" aria-hidden="true"></span> ' . PLUGIN_EVENT_FORGOTPASSWORD_EMAIL_CANNOT_SEND . '</div>';
                            }
                            break;
                        } else {
                            $eventData['footer'] = '
        <div class="msg_error"><span class="icon-attention-circled" aria-hidden="true"></span> ' . PLUGIN_EVENT_FORGOTPASSWORD_EMAIL_DB_ERROR . '</div>';
                            break;
                        }
                    // clicked link in user email
                    } elseif (isset($_GET['uid']) && isset($_GET['username']) && !isset($_POST['password'])){
                        $eventData['footer'] = '
        <form id="auth_fpwd" class="clearfix" action="serendipity_admin.php" method="post">
            <fieldset>
                <span class="wrap_legend"><legend>' . PLUGIN_EVENT_FORGOTPASSWORD_ENTER_PASSWORD . '</legend></span>

                <div class="form_field">
                    <label for="auth_uid">' . PASSWORD . '</label>
                    <input id="auth_uid" class="input_textbox" type="password" autocomplete="new-password" name="password" autofocus="">
                    <input type="hidden" name="username" value="'.htmlspecialchars($_GET['username']).'">
                    <input type="hidden" name="uid" value="'.htmlspecialchars($_GET['uid']).'">
                </div>

                <div class="form_buttons">
                    <input id="auth_fpwd_submit" name="forgot" type="submit" value="' . PLUGIN_EVENT_FORGOTPASSWORD_CHANGE_PASSWORD . '">
                </div>
            </fieldset>
        </form>
';
                        return true;
                    // changed password page
                    } elseif (isset($_POST['uid']) && isset($_POST['username']) && isset($_POST['password'])) {
                        $uname = serendipity_db_escape_string($_POST['username']);
                        $uid = serendipity_db_escape_string($_POST['uid']);
                        $sql = serendipity_db_query("SELECT * FROM {$serendipity['dbPrefix']}forgotpassword WHERE authorid = '$uname' AND uid = '$uid'");

                        if ($sql && is_array($sql)) {
                            $res = $sql[0];
                            $authorid = $res['authorid'];
                            $password = serendipity_hash($_POST['password']);

                            $sql = serendipity_db_query("UPDATE {$serendipity['dbPrefix']}authors SET hashtype=2, password='$password' WHERE authorid = '$uname'");

                            if (!$sql){
                                $eventData['footer'] = '
        <div class="msg_error"><span class="icon-attention-circled" aria-hidden="true"></span> ' . PLUGIN_EVENT_FORGOTPASSWORD_EMAIL_DB_ERROR . '</div>';
                                break;
                            }

                            serendipity_db_query("DELETE FROM {$serendipity['dbPrefix']}forgotpassword WHERE authorid = '$uname'");

                            $eventData['footer'] = '
        <div class="msg_success"><span class="icon-ok-circled" aria-hidden="true"></span> ' . PLUGIN_EVENT_FORGOTPASSWORD_PASSWORD_CHANGED . '</div>';
                            break;
                        } else {
                            $eventData['footer'] = '
        <div class="msg_error"><span class="icon-attention-circled" aria-hidden="true"></span> ' . PLUGIN_EVENT_FORGOTPASSWORD_EMAIL_DB_ERROR . '</div>';
                            break;
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