<?php

declare(strict_types=1);

if (IN_serendipity !== true) {
    die ("Don't hack!");
}

@serendipity_plugin_api::load_language(dirname(__FILE__));

class serendipity_event_portier extends serendipity_event
{
    function introspect(&$propbag)
    {
        global $serendipity;

        $propbag->add('name',        PLUGIN_PORTIER_NAME);
        $propbag->add('description', PLUGIN_PORTIER_DESC);
        $propbag->add('stackable',   false);
        $propbag->add('author',      'Grischa Brockhaus, Malte Paskuda, Ian Styx');
        $propbag->add('version',        '2.0.2');
        $propbag->add('requirements',   array(
            'serendipity' => '5.0',
            'php'         => '8.2'
        ));
        $propbag->add('groups', array('BACKEND_USERMANAGEMENT'));
        $propbag->add('event_hooks', array(
            'backend_login'             => true,
            'backend_login_page'        => true,
            'external_plugin'           => true,
            'css_backend'               => true
        ));

        $propbag->add('configuration', array(
            'plugin_desc'
        ));

        $propbag->add('legal',    array(
            'services' => array(
                'portier' => array(
                    'url'  => 'https://broker.portier.io',
                    'desc' => 'Default broker origin for Portier, which is an email-based, passwordless authentication service that you can (but don\'t have to) host yourself.'
                ),
            ),
            'frontend' => array(
                'Does something with browserID/portier',
            ),
            'backend' => array(
                'Does something with browserID/portier',
            ),
            'cookies' => array(
                'Does something with browserID/portier, might save cookies',
            ),
            // I do not know if any of this is true
            'stores_user_input'     => true,
            'stores_ip'             => true,
            'uses_ip'               => true,
            'transmits_user_input'  => true
        ));
    }

    function introspect_config_item($name, &$propbag)
    {
        switch($name) {
            case 'plugin_desc':
                $propbag->add('type',        'content');
                $propbag->add('name',        'About');
                $propbag->add('default',     PLUGIN_PORTIER_DESCRIPTION);
                break;

            default:
                return false;
        }
        return true;
    }

    function generate_content(&$title)
    {
        $title = PLUGIN_PORTIER_NAME;
    }

    function event_hook($event, &$bag, &$eventData, $addData = null)
    {
        global $serendipity;

        require __DIR__ . '/vendor/autoload.php';
        require_once 'S9yStore.php';
        $verify_url = $serendipity['baseURL'] . 'index.php?/plugin/portier_verify';

        $this->portier = new \Portier\Client\Client(
            new \Portier\Client\S9yStore($this),
            $verify_url
        );

        $hooks = &$bag->get('event_hooks');

        if (isset($hooks[$event])) {

            switch($event) {
                case 'external_plugin':
                    if ($eventData == 'portier_auth') {
                        $this->auth($serendipity['POST']['portier_email']);
                    }
                    else if ($eventData == 'portier_verify') {
                        $this->verify($_POST['id_token']);
                    }
                    break;

                case 'backend_login_page':
                    $this->print_loginpage($eventData);
                    break;

                case 'backend_login':
                    if ($eventData) {
                        return true;
                    }
                    if (isset($_SESSION['serendipityAuthedUser']) && $_SESSION['serendipityAuthedUser'] === true) {
                        $eventData = $this->reauth();
                    }
                    return;

                case 'css_backend':
                    $eventData .= '

/* serendipity_event_portier start*/

#portier {
    margin: 4em auto 8em;
    max-width: 25em;
    border-radius: 2px;
    box-sizing: border-box;
    padding: 0 1em;
    border: 1px solid #aaa;
}
#login {
    display: none;
    visibility: hidden;
}
#portier fieldset > span {
    display: block;
    font-weight: bold;
    background: #ddd;
    background-image: none;
    background-image: -webkit-linear-gradient(#fff, #ddd);
    background-image: linear-gradient(#fff, #ddd);
    border-bottom: 1px solid #aaa;
    color: #666;
    font-size: 1em;
    margin: 0 -1em;
    padding: .5em 1em;
}

/* serendipity_event_portier end*/

';

                default:
                    return false;
            }
        } else {
            return false;
        }
    }

    function verify($idToken)
    {
        global $serendipity;

        $email = $this->portier->verify($idToken);
        $this->login_user($email);
        header("Location: {$_SESSION['serendipity_portier_loginurl']}", true, 303);
    }

    function auth($email)
    {
        global $serendipity;

        $authUrl = $this->portier->authenticate($email);
        header("Location: $authUrl", true, 303);
    }

    function login_user($email)
    {
        global $serendipity;

        $query = "SELECT DISTINCT a.email, a.authorid, a.userlevel, a.right_publish, a.realname
                    FROM
                        {$serendipity['dbPrefix']}authors AS a
                   WHERE
                        a.email = '{$email}'";
        $row = serendipity_db_query($query, true, 'assoc');

        if (is_array($row)) {
            serendipity_setCookie('old_session', session_id());
            serendipity_setAuthorToken();

            $_SESSION['serendipityUser']        = $serendipity['serendipityUser']         = $row['realname'];
            $_SESSION['serendipityPassword']    = $serendipity['serendipityPassword']     = serendipity_hash($email);
            $_SESSION['serendipityEmail']       = $serendipity['serendipityEmail']        = $email;
            $_SESSION['serendipityAuthorid']    = $serendipity['authorid']                = $row['authorid'];
            $_SESSION['serendipityUserlevel']   = $serendipity['serendipityUserlevel']    = $row['userlevel'];
            $_SESSION['serendipityAuthedUser']  = $serendipity['serendipityAuthedUser']   = true;
            $_SESSION['serendipityRightPublish']= $serendipity['serendipityRightPublish'] = $row['right_publish'];

            serendipity_load_configuration($serendipity['authorid']);
        }
        else { // No user found for that email!
            echo "found no such user";
            $response->status = 's9yunknown';
            $response->message= "Sorry, we don't have a user for $email";
            $_SESSION['serendipityAuthedUser'] = false;
            @session_destroy();
        }
    }

    function reauth()
    {
        global $serendipity;

        // Re-auth only, if valid session
        if ($_SESSION['serendipityAuthedUser']) {
            $serendipity['serendipityUser']         = $_SESSION['serendipityUser'];
            $serendipity['serendipityPassword']     = $_SESSION['serendipityPassword'];
            $serendipity['serendipityEmail']        = $_SESSION['serendipityEmail'];
            $serendipity['authorid']                = $_SESSION['serendipityAuthorid'];
            $serendipity['serendipityUserlevel']    = $_SESSION['serendipityUserlevel'];
            $serendipity['serendipityAuthedUser']   = $_SESSION['serendipityAuthedUser'];
            $serendipity['serendipityRightPublish'] = $_SESSION['serendipityRightPublish'];
            serendipity_load_configuration($serendipity['authorid']);
            return true;
        }
        return false;
    }

    function print_loginpage(&$eventData)
    {
        global $serendipity;

        $_SESSION['serendipity_portier_loginurl'] = $_SERVER['REDIRECT_SCRIPT_URI'] . '?' . $_SERVER['QUERY_STRING'];
        $auth_url = $serendipity['baseURL'] . 'index.php?/plugin/portier_auth';
        $email = EMAIL;
        $btb   = BACK_TO_BLOG;

        print <<<EOF
        <form id="portier" class="clearfix" method="post" action="$auth_url">
            <fieldset>
                <span class="wrap_legend"><legend>Please enter your email</legend></span>
                <div class="form_field">
                    <label for="login_email">$email</label>
                    <input id="login_email" name="serendipity[portier_email]" type="email">
                </div>
                <div class="form_buttons">
                    <input id="portier_send" name="submit" value="Login" type="submit">
                    <a class="button_link" href="{$serendipity['baseURL']}">$btb</a>
                </div>
            </fieldset>
        </form>
EOF;
    }

}

/* vim: set sts=4 ts=4 expandtab : */
?>