<?php

declare(strict_types=1);

if (IN_serendipity !== true) {
    die ("Don't hack!");
}

// Load possible language files.
@serendipity_plugin_api::load_language(dirname(__FILE__));

class serendipity_event_contactform extends serendipity_event
{
    var $title = PLUGIN_CONTACTFORM_TITLE;

    function introspect(&$propbag)
    {
        global $serendipity;

        $subtitle = $this->get_config('backend_title', '');
        if (!empty($subtitle)) {
            $desc = '(' . $subtitle . ') ' . PLUGIN_CONTACTFORM_TITLE_BLAHBLAH;
        } else {
            $desc = PLUGIN_CONTACTFORM_TITLE_BLAHBLAH;
        }

        $propbag->add('name', PLUGIN_CONTACTFORM_TITLE);
        $propbag->add('description', $desc);
        $propbag->add('event_hooks',  array('entries_header' => true, 'entry_display' => true, 'genpage' => true));
        $propbag->add('configuration', array('permalink', 'pagetitle', 'backend_title', 'email', 'subject', 'counter', 'intro', 'sent', 'articleformat', 'dynamic_tpl', 'dynamic_fields', 'dynamic_fields_tpl', 'dynamic_fields_desc'));
        $propbag->add('author', 'Garvin Hicking, Ian Styx');
        $propbag->add('version', '2.0.0');
        $propbag->add('requirements',  array(
            'serendipity' => '5.0',
            'smarty'      => '4.1',
            'php'         => '8.2'
        ));
        $propbag->add('stackable', true);
        $propbag->add('groups', array('FRONTEND_FEATURES'));
        $propbag->add('legal',    array(
            'services' => array(
                'mail' => array(
                    'url' => '?serendipity[adminModule]=plugins&serendipity[plugin_to_conf]=serendipity_event_contactform%3A'.$this->instance,
                    'desc' => 'Visitor feedback of the contact form is transferred via e-mail [Do NOT copy this INTERNAL link!]'
                )
            ),
            'frontend' => array(
                'desc' => 'Visitor feedback of the contact form is transferred via e-mail'
            ),
            'backend' => array(
            ),
            'cookies' => array(
            ),
            'stores_user_input'     => false,
            'stores_ip'             => false,
            'uses_ip'               => true,
            'transmits_user_input'  => true
        ));
    }

    function introspect_config_item($name, &$propbag)
    {
        global $serendipity;

        switch($name) {
            case 'subject':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_CONTACTFORM_SUBJECT);
                $propbag->add('description', PLUGIN_CONTACTFORM_SUBJECT_DESC);
                $propbag->add('default',     NEW_COMMENT_TO . ' %s');
                break;

            case 'counter':
                $propbag->add('type',        'boolean');
                $propbag->add('name',        PLUGIN_CONTACTFORM_ISSUECOUNTER);
                $propbag->add('description', PLUGIN_CONTACTFORM_ISSUECOUNTER_DESC);
                $propbag->add('default',     'false');
                break;

            case 'backend_title':
                $propbag->add('type',        'string');
                $propbag->add('name',        BACKEND_TITLE);
                $propbag->add('description', BACKEND_TITLE_FOR_NUGGET);
                $propbag->add('default',     '');
                break;

            case 'permalink':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_CONTACTFORM_PERMALINK);
                $propbag->add('description', PLUGIN_CONTACTFORM_PERMALINK_BLAHBLAH);
                $propbag->add('default',     $serendipity['rewrite'] != 'none'
                                             ? $serendipity['serendipityHTTPPath'] . 'pages/contactform.html'
                                             : $serendipity['serendipityHTTPPath'] . $serendipity['indexFile'] . '?/pages/contactform.html');
                break;

            case 'email':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_CONTACTFORM_EMAIL);
                $propbag->add('description', '');
                $propbag->add('default',     '');
                break;

            case 'intro':
                $propbag->add('type',        'html');
                $propbag->add('name',        PLUGIN_CONTACTFORM_INTRO);
                $propbag->add('description', '');
                $propbag->add('default',     '');
                break;

            case 'sent':
                $propbag->add('type',        'text');
                $propbag->add('rows',        6);
                $propbag->add('name',        PLUGIN_CONTACTFORM_SENT);
                $propbag->add('description', '');
                $propbag->add('default',     PLUGIN_CONTACTFORM_SENT_HTML);
                break;

            case 'pagetitle':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_CONTACTFORM_PAGETITLE);
                $propbag->add('description', PLUGIN_CONTACTFORM_PAGETITLE_DESC);
                $propbag->add('default',     PLUGIN_CONTACTFORM_TITLE);
                break;

            case 'articleformat':
                $propbag->add('type',        'boolean');
                $propbag->add('name',        PLUGIN_CONTACTFORM_ARTICLEFORMAT);
                $propbag->add('description', PLUGIN_CONTACTFORM_ARTICLEFORMAT_BLAHBLAH);
                $propbag->add('default',     'true');
                break;

            case 'dynamic_tpl':
                $select = array();
                $select["standard"]     = PLUGIN_CONTACTFORM_DYNAMICTPL_STANDARD;
                $select["small_biz"]    = PLUGIN_CONTACTFORM_DYNAMICTPL_SMALLBIZ;
                $select["detailed"]     = PLUGIN_CONTACTFORM_DYNAMICTPL_DETAILED;
                $select["full_dynamic"] = PLUGIN_CONTACTFORM_DYNAMICTPL_FULLDYNAMIC;
                $propbag->add('type', 'select');
                $propbag->add('name', PLUGIN_CONTACTFORM_DYNAMICTPL);
                $propbag->add('description', PLUGIN_CONTACTFORM_DYNAMICTPL_DESC);
                $propbag->add('select_values', $select);
                $propbag->add('default', 'standard');
                break;

            case 'dynamic_fields':
                if ($this->get_config('dynamic_tpl', 'standard') == 'full_dynamic') {
                    $propbag->add('type',        'text');
                    $propbag->add('name',        PLUGIN_CONTACTFORM_DYNAMICFIELDS);
                    $propbag->add('description', PLUGIN_CONTACTFORM_DYNAMICFIELDS_DESC);
                    $propbag->add('default',     'require;'.NAME.';text:'.'require;'.EMAIL.';text:'.'require;'.HOMEPAGE.';text:'.'require;'.PLUGIN_CONTACTFORM_MESSAGE.';textarea;');
                }
                break;

            case 'dynamic_fields_desc':
                if ($this->get_config('dynamic_tpl','standard') == 'full_dynamic') {
                     $propbag->add('type',  'content');
                     $propbag->add('default', '<div class="msg_hint">'.PLUGIN_CONTACTFORM_DYNAMICFIELDS_DESC_NOTE.'</div>');
                }
                break;

            case 'dynamic_fields_tpl':
                if ($this->get_config('dynamic_tpl','standard') == 'full_dynamic') {
                    $propbag->add('type',        'string');
                    $propbag->add('name',        PLUGIN_CONTACTFORM_TEMPLATE);
                    $propbag->add('description', PLUGIN_CONTACTFORM_TEMPLATE_DESC);
                    $propbag->add('default',     'plugin_dynamicform.tpl');
                }
                break;

            default:
                return false;
        }
        return true;
    }

    /**
     * Place and send the contact data via email
     *
     * @access public
     * @param   string  The recipient address of the mail
     * @param   string  The name of the sender
     * @param   string  The sender mail address of the mail
     * @param   string  A possible URL
     * @param   string  The body of the mail
     * @param   boolean The template form used
     *
     * @return  int     Return code of the PHP mail() function
     * @see core serendipity_sendMail()
     */
    function sendComment($to, $fromName, $fromEmail, $fromUrl, $comment, $dynamic = false)
    {
        global $serendipity;

        if (empty($fromName)) {
            $fromName = ANONYMOUS;
        }

        $title = $this->get_config('pagetitle');

        $subject = sprintf($this->get_config('subject'), $title);

        $text = '';

        if (serendipity_db_bool($this->get_config('counter'))) {
            $this->set_config('counternumber', $this->get_config('counternumber')+1);
            $subject = '[' . $this->get_config('counternumber') . '] ' . $subject;
            $text .= sprintf(PLUGIN_CONTACTFORM_MAIL_ISSUECOUNTER, $this->get_config('counternumber')) . "\n";
        }

        $text .= sprintf(A_NEW_COMMENT_BLAHBLAH, $serendipity['blogTitle'], $title)
              . "\n"
              . "\n" . USER . ' ' . IP_ADDRESS . ': ' . $_SERVER['REMOTE_ADDR'];

        if (!$dynamic) {
              $text = $text. "\n" . USER . ' ' . NAME       . ': ' . $fromName
                    . "\n" . USER . ' ' . EMAIL      . ': ' . $fromEmail
                    . "\n" . USER . ' ' . HOMEPAGE   . ': ' . $fromUrl
                    . "\n"
                    . "\n" . COMMENTS                . ': ';
        }

        $text = $text . "\n" . $comment
              . "\n"
              . "\n" . '----';

        // reset encoded quotes for text and subject
        $subject = str_replace('&quot;', '"', $subject);
        $text    = str_replace('&quot;', '"', $text);

        return serendipity_sendMail($to, $subject, $text, $fromEmail, null, $fromName);
    }

    function checkSubmit()
    {
        global $serendipity;

        if (empty($serendipity['POST']['commentform'])) {
            return false;
        }

        if (empty($serendipity['POST']['name']) || empty($serendipity['POST']['email']) || empty($serendipity['POST']['comment'])) {
            $serendipity['smarty']->assign(
                array(
                    'is_contactform_error'     => true,
                    'plugin_contactform_error' => PLUGIN_CONTACTFORM_ERROR_DATA
                )
            );
            return false;
        }

        // Fake call to spamblock/captcha and other comment plugins.
        $ca = array(
            'id'                => 0,
            'allow_comments'    => 'true',
            'moderate_comments' => false,
            'last_modified'     => time(),
            'timestamp'         => 10 // make those entries old so that captcha_ttl will be enabled.
        );

        $commentInfo = array(
            'type'    => 'NORMAL',
            'source'  => 'commentform',
            'name'    => htmlspecialchars(strip_tags($serendipity['POST']['name'])),
            'url'     => htmlspecialchars(strip_tags($serendipity['POST']['url'])),
            'comment' => htmlspecialchars(strip_tags($serendipity['POST']['comment'])),
            'email'   => htmlspecialchars(strip_tags($serendipity['POST']['email'])),
            'source2' => 'adduser' // Allow the contactform to bypass "only registered users may post" option of the adduser-plugin

        );
        serendipity_plugin_api::hook_event('frontend_saveComment', $ca, $commentInfo);

        if ($ca['allow_comments'] === false) {
            $serendipity['smarty']->assign(
                array(
                    'is_contactform_error'     => true,
                    'plugin_contactform_error' => PLUGIN_CONTACTFORM_ERROR_DATA
                )
            );
            return false;
        }
        // End of fake call.

        if ($this->sendComment(
                $this->get_config('email'),
                htmlspecialchars(strip_tags($serendipity['POST']['name'])),
                htmlspecialchars(strip_tags($serendipity['POST']['email'])),
                htmlspecialchars(strip_tags($serendipity['POST']['url'])),
                htmlspecialchars(strip_tags($serendipity['POST']['comment']))
        )) {

            $serendipity['smarty']->assign('is_contactform_sent', true);
            return true;
        } else {
            // Unknown error occurred.
            $serendipity['smarty']->assign(
                array(
                    'is_contactform_error'     => true,
                    'plugin_contactform_error' => PLUGIN_CONTACTFORM_ERROR_HTML
                )
            );
        }
        return false;
    }

    function checkextendedSubmit($form_fields)
    {
        global $serendipity;

        $empty_error = false;
        $comment = '';

        if (empty($serendipity['POST']['commentform'])) {
            return false;
        }

        foreach($form_fields AS $field) {
            if ($field['type'] == 'radio' || $field['type'] == 'checkbox' || $field['type'] == 'select') {
                if (!empty($_POST[$field['id']])) {
                    $defaults[$field['id']]['name'] = $field['name'];
                    $defaults[$field['id']]['value'] = $_POST[$field['id']];
                    $comment = $comment. "\nField  '" . $field['name'] . "': " . $_POST[$field['id']];
                }
            } else {
                if (!empty($serendipity['POST'][$field['id']])) {
                    $defaults[$field['id']]['name'] = $field['name'];
                    $defaults[$field['id']]['value'] = $serendipity['POST'][$field['id']];
                    $comment = $comment. "\nField  '" . $field['name'] . "': " . $serendipity['POST'][$field['id']];
                }
            }
            if ($field['required'] && (empty($serendipity['POST'][$field['id']]) && empty($_POST[$field['id']]))) {
                $empty_error = true;
            }
        }

        if ($empty_error) {
            $serendipity['smarty']->assign(
                array(
                    'is_contactform_error'     => true,
                    'plugin_contactform_error' => PLUGIN_CONTACTFORM_DYNAMIC_ERROR_DATA
                )
            );

            return ($defaults ?? null);
        }

        // Fake call to spamblock/captcha and other comment plugins.
        $ca = array(
            'id'                => 0,
            'allow_comments'    => 'true',
            'moderate_comments' => false,
            'last_modified'     => time(),
            'timestamp'         => 10 // make those entries old so that captcha_ttl will be enabled.
        );

        // Some clarification. The array commentInfo
        // relies on data which is defined as required_fields in spamblock, and which can be "name, email, url, replyTo, comment"
        // (replyTo does not have have any relation to contactform fields and will probably never be put in via the "form field string" by a user, else you would have to put in     'replyTo' => 'x',).
        // Since this is a "fake" call to make it accessible with Captchas and some primitive checks, name - email - url - comment could probably be set to any string with a certain length and the only real value they have here is to be (spamblock) logged with real data.
        // This is why it does not really matter, when dynamic contactform field items for these fields are named in a differentially manner, e.g. like email to E-mail, Homepage for url, etc.
        // So why don't all possible 5 POST check fields error about not being isset then? It's a matter of error reporting and PHP version.
        $commentInfo = array(
            'type'    => 'NORMAL',
            'source'  => 'commentform',
            'name'    => htmlspecialchars(strip_tags($serendipity['POST']['name'] ?? '')),
            'url'     => htmlspecialchars(strip_tags($serendipity['POST']['url'] ?? '')),
            'comment' => htmlspecialchars(strip_tags($comment ?? '')),
            'email'   => htmlspecialchars(strip_tags($serendipity['POST']['email'] ?? '')),
            'source2' => 'adduser' // Allow the contactform to bypass "only registered users may post" option of the adduser-plugin
        );
        serendipity_plugin_api::hook_event('frontend_saveComment', $ca, $commentInfo);

        if ($ca['allow_comments'] === false) {
            $serendipity['smarty']->assign(
                array(
                    'is_contactform_error'     => true,
                    'plugin_contactform_error' => PLUGIN_CONTACTFORM_ERROR_DATA
                )
            );

            return $defaults;
        }
        // End of fake call.

        if ($this->sendComment(
                $this->get_config('email'),
                htmlspecialchars(strip_tags($serendipity['POST']['name'] ?? '')),
                htmlspecialchars(strip_tags($serendipity['POST']['email'] ?? '')),
                htmlspecialchars(strip_tags($serendipity['POST']['url'] ?? '')),
                htmlspecialchars(strip_tags($comment ?? '')),
                true
        )) {

            $serendipity['smarty']->assign('is_contactform_sent', true);
            return true;
        } else {
            // Unknown error occurred.
            $serendipity['smarty']->assign(
                array(
                    'is_contactform_error'     => true,
                    'plugin_contactform_error' => PLUGIN_CONTACTFORM_ERROR_HTML
                )
            );
        }

        return $defaults;
    }

    function show()
    {
        global $serendipity;

        if ($this->selected()) {
            $form_fields = array();
            $dynamic_tpl = $this->get_config('dynamic_tpl', 'standard');
            if (!headers_sent()) {
                header(serendipity_getServerProtocol() . ' 200');
                header('Status: 200 OK');
            }

            if (!isset($serendipity['smarty']) || !is_object($serendipity['smarty'])) {
                serendipity_smarty_init();
            }
            $serendipity['smarty']->assign('staticpage_pagetitle', preg_replace('@[^a-z0-9]@i', '_', trim($this->get_config('pagetitle'))));
            if ($dynamic_tpl == 'standard'){
                if ($this->checkSubmit()) {
                    // do what?
                } else {
                    // fallback
                }
            } else {
                $form_fields = $this->parse_form_fields($dynamic_tpl);
                $defaults = $this->checkextendedSubmit($form_fields);

                if (is_array($defaults)) {
                    foreach($defaults AS $item) {
                        switch ($form_fields[$item['name']]['type']) {
                            case 'radio':
                                foreach($form_fields[$item['name']]['options'] AS $option) {
                                    if ($option['id'] == $item['value']) {
                                        $form_fields[$item['name']]['options'][$option['name']]['default'] = 'checked="checked"';
                                    } else {
                                        $form_fields[$item['name']]['options'][$option['name']]['default'] = '';
                                    }
                                }
                                break;

                            case 'select':
                                foreach ($form_fields[$item['name']]['options'] AS $option) {
                                    if ($option['id'] == $item['value']) {
                                        $form_fields[$item['name']]['options'][$option['name']]['default'] = 'selected';
                                    } else {
                                        $form_fields[$item['name']]['options'][$option['name']]['default'] = '';
                                    }
                                }
                                break;

                            case 'checkbox':
                                $form_fields[$item['name']]['default'] = 'checked="checked"';
                                break;

                            default:
                                $form_fields[$item['name']]['default'] = htmlspecialchars(strip_tags($item['value']));
                                break;
                        }
                    }
                }
            }

            $serendipity['smarty']->assign(
                array(
                    'plugin_contactform_articleformat' => $this->get_config('articleformat'),
                    'plugin_contactform_name'          => PLUGIN_CONTACTFORM_TITLE,
                    'plugin_contactform_pagetitle'     => $this->get_config('pagetitle'),

                    'plugin_contactform_preface' => $this->get_config('intro'),
                    'plugin_contactform_sent'    => $this->get_config('sent', PLUGIN_CONTACTFORM_SENT_HTML),
                    'plugin_contactform_message' => PLUGIN_CONTACTFORM_MESSAGE,
                    'commentform_action'         => $serendipity['baseURL'] . $serendipity['indexFile'],
                    'commentform_sname'          => htmlspecialchars($serendipity['GET']['subpage']),
                    'commentform_name'           => isset($serendipity['POST']['name']) ? htmlspecialchars(strip_tags($serendipity['POST']['name'])) : null,
                    'commentform_url'            => isset($serendipity['POST']['url']) ? htmlspecialchars(strip_tags($serendipity['POST']['url'])) : null,
                    'commentform_email'          => isset($serendipity['POST']['email']) ? htmlspecialchars(strip_tags($serendipity['POST']['email'])) : null,
                    'commentform_data'           => isset($serendipity['POST']['comment']) ? htmlspecialchars(strip_tags($serendipity['POST']['comment'])) : null,
                    'comments_messagestack'      => $serendipity['messagestack']['comments'] ?? null,
                    'commentform_entry'          => array(
                                                        'timestamp' => 1, // force captchas!
                                                    ),
                    'commentform_dynamicfields'  => $form_fields
                )
            );

            if ($dynamic_tpl == 'standard') {
                $filename = 'plugin_contactform.tpl';
            } else {
                $filename = $this->get_config('dynamic_fields_tpl');
                if (empty($filename)) {
                    $filename = 'plugin_dynamicform.tpl';
                }
            }
            echo $this->parseTemplate($filename);
        }
    }

    function selected()
    {
        global $serendipity;

        if (!empty($serendipity['POST']['subpage'])) {
            $serendipity['GET']['subpage'] = $serendipity['POST']['subpage'];
        }

        if (!isset($serendipity['GET']['subpage'])) return false;

        if ($serendipity['GET']['subpage'] == $this->get_config('pagetitle') ||
            preg_match('@^' . preg_quote($this->get_config('permalink')) . '@i', $serendipity['GET']['subpage'])) {
            return true;
        }

        return false;
    }

    function generate_content(&$title)
    {
        $title = PLUGIN_CONTACTFORM_TITLE.' (' . $this->get_config('pagetitle') . ')';
    }

    function event_hook($event, &$bag, &$eventData, $addData = null)
    {
        global $serendipity;

        $hooks = &$bag->get('event_hooks');

        if (isset($hooks[$event])) {

            switch($event) {

                case 'genpage':
                    if ($serendipity['rewrite'] != 'none') {
                        $nice_url = $serendipity['serendipityHTTPPath'] . $addData['uriargs'];
                    } else {
                        $nice_url = $serendipity['serendipityHTTPPath'] . $serendipity['indexFile'] . '?/' . $addData['uriargs'];
                    }
                    $oldsubpage = $serendipity['GET']['subpage'] ?? null;
                    if (empty($serendipity['GET']['subpage'])) {
                        $serendipity['GET']['subpage'] = $nice_url;
                    }
                    if ($this->selected()) {
                        $serendipity['head_title']    = $this->get_config('pagetitle');
                        $serendipity['head_subtitle'] = htmlspecialchars($serendipity['blogTitle']);
                    } else {
                        // Put subpage back so staticpage plugin will work
                        $serendipity['GET']['subpage'] = $oldsubpage;
                    }
                    break;

                case 'entry_display':
                    if ($this->selected()) {
                        if (is_array($eventData)) {
                            $eventData['clean_page'] = true; // This is important to not display an entry list!
                        } else {
                            $eventData = array('clean_page' => true);
                        }
                    }
                    break;

                case 'entries_header':
                    $this->show();
                    break;

                default:
                    return false;

            }
            return true;
        } else {
            return false;
        }
    }

    function parse_form_fields($dynamic_tpl)
    {
        global $serendipity;

        $return_array = array();

        switch ($dynamic_tpl) {

            case 'small_biz':
                $fields = 'require;'.PLUGIN_CONTACTFORM_FNAME.';text:require;'.PLUGIN_CONTACTFORM_LNAME.';text:'.'require;'.EMAIL.';text:'.'require;'.PLUGIN_CONTACTFORM_MESSAGE.';textarea;';
                break;

            case 'detailed':
                $fields = 'require;'.PLUGIN_CONTACTFORM_FNAME.';text:require;'.PLUGIN_CONTACTFORM_LNAME.';text:'.'require;'.EMAIL.';text:'.'require;'.PLUGIN_CONTACTFORM_ADDRESS.';textarea:'.'require;'.PLUGIN_CONTACTFORM_MESSAGE.';textarea;';
                break;

            default:
                $fields = $this->get_config('dynamic_fields', 'require;'.NAME.';text:'.'require;'.EMAIL.';text:'.'require;'.HOMEPAGE.';text:'.'require;'.PLUGIN_CONTACTFORM_MESSAGE.';textarea;');
                break;

        }
        $fields = explode(':', $fields);
        foreach($fields AS $field) {
            $field_array = explode(';', $field);
            $field_count = count($field_array);
            if ($field_count > 1) {
                $options = array();
                if (strtolower($field_array[0]) == 'require') {
                    array_shift($field_array);
                    $return_array[$field_array[0]]['required'] = true;
                } else {
                    $return_array[$field_array[0]]['required'] = false;
                }
                $return_array[$field_array[0]]['name'] = $field_array[0];
                $return_array[$field_array[0]]['id'] = strtolower(preg_replace('@[^a-z0-9]@i', '_', $field_array[0]));

                $field_array[2] = $field_array[2] ?? null;

                // Let's figure out what kind it is...
                switch(strtolower($field_array[1])) {

                    case 'checkbox';
                        $return_array[$field_array[0]]['type'] = 'checkbox';
                        //need to get options
                        $option_array = explode(',', $field_array[2]);
                        if (is_array($option_array)) {
                            foreach($option_array AS $option) {
                               if (strtolower($option) == 'checked') {
                                  $return_array[$field_array[0]]['default'] = 'checked="checked"';
                               } else {
                                  $return_array[$field_array[0]]['message'] = $option;
                               }
                            }
                        }
                        break;

                    case 'radio':
                        $return_array[$field_array[0]]['type'] = 'radio';
                        $option_array = explode('|', $field_array[2]);
                        if (is_array($option_array)) {
                            foreach($option_array AS $option) {
                               $option_details = explode(',', $option);
                               $options[$option_details[0]]['name'] = $option_details[0];
                               $options[$option_details[0]]['id'] = strtolower(preg_replace('@[^a-z0-9]@i', '_', $option_details[0]));

                               if (count($option_details) > 1) {
                                  $options[$option_details[0]]['value'] = $option_details[1];
                               }
                               if (count($option_details) > 2 && strtolower($option_details[2]) == 'checked') {
                                  $options[$option_details[0]]['default'] = 'checked="checked"';
                               }
                            }
                        }
                        $return_array[$field_array[0]]['options'] = $options;
                        $return_array[$field_array[0]]['default'] = $field_array[3] ?? null;
                        break;

                    case 'select':
                        $return_array[$field_array[0]]['type'] = 'select';
                        $option_array = explode('|', $field_array[2]);
                        if (is_array($option_array)) {
                            foreach($option_array AS $option) {
                               $option_details = explode(',', $option);
                               $options[$option_details[0]]['name'] = $option_details[0];
                               $options[$option_details[0]]['id'] = strtolower(preg_replace('@[^a-z0-9]@i', '_', $option_details[0]));

                               if (count($option_details) > 1) {
                                  $options[$option_details[0]]['value'] = $option_details[1];
                               }
                               if (count($option_details) > 2 && strtolower($option_details[2]) == 'selected') {
                                  $options[$option_details[0]]['default'] = 'selected';
                               }
                            }
                        }
                        $return_array[$field_array[0]]['options'] = $options;
                        $return_array[$field_array[0]]['default'] = $field_array[3] ?? null;
                        break;

                    case 'hidden':
                        $return_array[$field_array[0]]['type'] = 'hidden';
                         $return_array[$field_array[0]]['default'] = $field_array[2];
                        break;

                    case 'password':
                        $return_array[$field_array[0]]['type'] = 'password';
                        $return_array[$field_array[0]]['default'] = $field_array[2];
                        break;

                    // Remember, main message textareas selector must be named statically to 'serendipity_commentform_comment', since other plugins like emoticonchooser use it and else fail
                    case 'textarea':
                        $return_array[$field_array[0]]['type'] = 'textarea';
                        $return_array[$field_array[0]]['default'] = $field_array[2];
                        break;

                    case 'text':
                        $return_array[$field_array[0]]['type'] = 'text';
                        $return_array[$field_array[0]]['default'] = $field_array[2];
                        break;

                    case 'email':
                        $return_array[$field_array[0]]['type'] = 'email';
                        $return_array[$field_array[0]]['default'] = $field_array[2];
                        break;

                    default:
                        $return_array[$field_array[0]]['type'] = $field_array[1];
                        $return_array[$field_array[0]]['default'] = $field_array[2];
                        break;
                }
            }
        }
        return $return_array;
    }

}
/* vim: set sts=4 ts=4 expandtab : */
?>