<?php

if (IN_serendipity !== true) {
    die ("Don't hack!");
}

@serendipity_plugin_api::load_language(dirname(__FILE__));

class serendipity_event_autoupdate extends serendipity_event
{
    var $title = PLUGIN_EVENT_AUTOUPDATE_NAME;

    function introspect(&$propbag)
    {
        global $serendipity;

        $propbag->add('name',          PLUGIN_EVENT_AUTOUPDATE_NAME);
        $propbag->add('description',   PLUGIN_EVENT_AUTOUPDATE_DESC);
        $propbag->add('stackable',     false);
        $propbag->add('author',        'onli, Ian');
        $propbag->add('version',       '1.3.7');
        $propbag->add('configuration', array('download_url', 'releasefile_url'));
        $propbag->add('requirements',  array(
            'serendipity' => '1.6',
            'php'         => '5.2'
        ));
        $propbag->add('event_hooks',   array(
            'css_backend'                                   => true,
            'plugin_dashboard_updater'                      => true,
            'backend_sidebar_entries_event_display_update'  => true
        ));
        $propbag->add('groups', array('BACKEND', 'DASHBOARD', 'BACKEND_FEATURES'));
        if ($serendipity['version'][0] < 2) {
            $this->dependencies = array('serendipity_event_dashboard' => 'keep');
        }
    }

    function introspect_config_item($name, &$propbag)
    {
        switch($name) {
            case 'download_url':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_EVENT_AUTOUPDATE_DL_URL);
                $propbag->add('description', PLUGIN_EVENT_AUTOUPDATE_DL_URL_DESC);
                $propbag->add('default',     'https://github.com/s9y/Serendipity/releases/download/');
                break;

            case 'releasefile_url':
                $propbag->add('type',        'string');
                $propbag->add('name',        PLUGIN_EVENT_AUTOUPDATE_RF_URL);
                $propbag->add('description', PLUGIN_EVENT_AUTOUPDATE_RF_URL_DESC);
                $propbag->add('default',     'https://github.com/s9y/Serendipity/releases/tag/');
                break;

            default:
                return false;

        }
        return true;
    }

    function generate_content(&$title)
    {
        $title = $this->title;
    }

    function install()
    {
        global $serendipity;

        if (!$serendipity['serendipityUserlevel'] >= USERLEVEL_ADMIN) {
            return false;
        }
    }

    /**
     * flush progress or error messages
     */
    function show_message($message='', $pname='', $next='')
    {

        if (!empty($pname)) {
            // Total processes
            $total = 3;

            ob_implicit_flush(1);

            // fake processing loop
            for ($i=1; $i<=$total; $i++) {
                // Calculate the percentation
                $percent = intval($i/$total * 100)."%";

                // Javascript for updating the progress bar and information
                echo '
<script type="text/javascript">
    document.getElementById("progress").innerHTML="<div style=\"width:'.$percent.';background-color:#ddd;\">&nbsp;</div>";
    document.getElementById("information").innerHTML="'.$percent.' processed.";
</script>';

                //this is for the buffer achieve the minimum size in order to flush data
                echo str_repeat(' ',1024*64); // need to keep here since this also flushes the progress bar on fastCGI

                // Send output to browser immediately
                ob_flush();
                flush();

                // Sleep one second so we can see the delay
                 sleep(1);
            }
            $wait = strstr($pname, 'Function') ? ' Please wait ... <span>Processing: '.$next.' ...</span>' : ''; // no attributes possible!
            // Tell user that the process is completed
            echo '<script type="text/javascript">document.getElementById("information").innerHTML="'.$pname.' completed!'.$wait.'"</script>';
        }

        echo "$message\n";
        $levels = ob_get_level();
        for ($i=0; $i<$levels; $i++) {
            ob_end_flush();
        }
        ob_flush();
        flush();
    }

    function event_hook($event, &$bag, &$eventData, $addData = null)
    {
        global $serendipity;

        $hooks = &$bag->get('event_hooks');

        if (isset($hooks[$event])) {

            switch($event) {

                case 'css_backend':
                    $eventData .= '

.button_action { margin-bottom: .5em }

';
                    break;

                case 'plugin_dashboard_updater':
                    $eventData = '
                    <form action="?serendipity[adminModule]=event_display&serendipity[adminAction]=update" method="POST">
                        <input type="hidden" name="serendipity[newVersion]" value="'.$addData.'" />
                        <div id="autobut" class="button_action">' . ($serendipity['version'][0] > 1 ? '<button type="submit">'.PLUGIN_EVENT_AUTOUPDATE_UPDATEBUTTON.'</button>' : '<input type="submit" value="'.PLUGIN_EVENT_AUTOUPDATE_UPDATEBUTTON.'" />') . '</div>
                    </form>';
                    break;

                case 'backend_sidebar_entries_event_display_update':
                    if (!(serendipity_checkPermission('siteConfiguration') || serendipity_checkPermission('blogConfiguration'))) {
                        return;
                    }
                    if (!extension_loaded('zip')) {
                        trigger_error(' ZIP extension has not been compiled or loaded in php.', E_USER_WARNING);
                        return;
                    }
                    @ini_set('max_execution_time', 210); // 180 + (21+9 gui happenings)
                    #@ini_set('memory_limit', '-1'); // extending memory_limit may be prevented by suhosin extension.
                    /*
                       As long scripts are not running within safe_mode they are free to change the memory_limit to whatever value they want.
                       Suhosin changes this fact and disallows setting the memory_limit to a value greater than the one the script started with,
                       when this option is left at 0. A value greater than 0 means that Suhosin will disallows scripts setting the memory_limit
                       to a value above this configured hard limit. This is for example usefull if you want to run the script normaly with a limit
                       of 16M but image processing scripts may raise it to 20M.
                       Edit /etc/php5/conf.d/suhosin.ini and add e.g. suhosin.memory_limit = 512M ...
                    */
                    $self_info = sprintf(USER_SELF_INFO, (function_exists('serendipity_specialchars') ? serendipity_specialchars($serendipity['serendipityUser']) : htmlspecialchars($serendipity['serendipityUser'], ENT_COMPAT, LANG_CHARSET)), $serendipity['permissionLevels'][$serendipity['serendipityUserlevel']]);
                    $lang_char = LANG_CHARSET;
                    $ad_suite  = SERENDIPITY_ADMIN_SUITE;
                    $css_upd   = @file_get_contents(dirname(__FILE__) . '/upgrade.min.css');
                    $bimgpath  = $serendipity['serendipityHTTPPath'] . $serendipity['templatePath'] . 's9y_banner_small.png';
                    $s9ybanner = (file_exists($_SERVER['DOCUMENT_ROOT'].$bimgpath) ? '<img src="' . $bimgpath . '" alt="Serendipity PHP Weblog" title="' . POWERED_BY . ' Serendipity" />' : '');
                    $nv        = (function_exists('serendipity_specialchars') ? serendipity_specialchars($_REQUEST['serendipity']['newVersion']) : htmlspecialchars($_REQUEST['serendipity']['newVersion'], ENT_COMPAT, LANG_CHARSET)); // reduce to POST only?
                    if (trim($nv) == '') return;
                    $logmsg    = '';
                    echo <<<EOS
<!DOCTYPE html>
<html>
    <head>
        <base target="_self"/>
        <title>Startpage - {$ad_suite}</title>
        <meta http-equiv="Content-Type" content="text/html; charset={$lang_char}">
        <style type="text/css">
{$css_upd}
        </style>
    </head>

    <body id="serendipity_admin_page">

    <svg display="none" width="0" height="0" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
        <defs>
            <symbol id="icon-home" viewBox="-34.731 -31.834 69.462 63.668">
                <path d="M34.73,5.319l-12.597,9.617v15.908h-9v-9.038L0,31.833l-34.73-26.513l5.461-7.155l3.741,2.856v-32.856H25.53V1.021 l3.74-2.855L34.73,5.319z M20.53-26.834H9v19H-9v-19h-11.529V4.204L0,19.88L20.53,4.204V-26.834z"></path>
            </symbol>
            <symbol id="icon-clock" viewBox="0 0 1024 1024">
                <title>clock</title>
                <path class="path1" d="M658.744 749.256l-210.744-210.746v-282.51h128v229.49l173.256 173.254zM512 0c-282.77 0-512 229.23-512 512s229.23 512 512 512 512-229.23 512-512-229.23-512-512-512zM512 896c-212.078 0-384-171.922-384-384s171.922-384 384-384c212.078 0 384 171.922 384 384s-171.922 384-384 384z"></path>
            </symbol>
            <symbol id="icon-attention" viewBox="0 0 1024 1024">
                <title>attention</title>
                <path class="path1" d="M512 96c-111.118 0-215.584 43.272-294.156 121.844s-121.844 183.038-121.844 294.156c0 111.118 43.272 215.584 121.844 294.156s183.038 121.844 294.156 121.844c111.118 0 215.584-43.272 294.156-121.844s121.844-183.038 121.844-294.156c0-111.118-43.272-215.584-121.844-294.156s-183.038-121.844-294.156-121.844zM512 0v0c282.77 0 512 229.23 512 512s-229.23 512-512 512c-282.77 0-512-229.23-512-512s229.23-512 512-512zM448 704h128v128h-128zM448 192h128v384h-128z"></path>
            </symbol>
            <symbol id="icon-info" viewBox="0 0 1024 1024">
                <title>info</title>
                <path class="path1" d="M448 304c0-26.4 21.6-48 48-48h32c26.4 0 48 21.6 48 48v32c0 26.4-21.6 48-48 48h-32c-26.4 0-48-21.6-48-48v-32z"></path>
                <path class="path2" d="M640 768h-256v-64h64v-192h-64v-64h192v256h64z"></path>
                <path class="path3" d="M512 0c-282.77 0-512 229.23-512 512s229.23 512 512 512 512-229.23 512-512-229.23-512-512-512zM512 928c-229.75 0-416-186.25-416-416s186.25-416 416-416 416 186.25 416 416-186.25 416-416 416z"></path>
            </symbol>
            <symbol id="icon-error" viewBox="0 0 1024 1024">
                <title>error</title>
                <path class="path1" d="M874.040 149.96c-96.706-96.702-225.28-149.96-362.040-149.96s-265.334 53.258-362.040 149.96c-96.702 96.706-149.96 225.28-149.96 362.040s53.258 265.334 149.96 362.040c96.706 96.702 225.28 149.96 362.040 149.96s265.334-53.258 362.040-149.96c96.702-96.706 149.96-225.28 149.96-362.040s-53.258-265.334-149.96-362.040zM896 512c0 82.814-26.354 159.588-71.112 222.38l-535.266-535.268c62.792-44.758 139.564-71.112 222.378-71.112 211.738 0 384 172.262 384 384zM128 512c0-82.814 26.354-159.586 71.112-222.378l535.27 535.268c-62.794 44.756-139.568 71.11-222.382 71.11-211.738 0-384-172.262-384-384z"></path>
            </symbol>
            <symbol id="icon-ok" viewBox="0 0 1024 1024">
                <title>ok</title>
                <path class="path1" d="M864 128l-480 480-224-224-160 160 384 384 640-640z"></path>
            </symbol>
        </defs>
    </svg>
    <header id="top">
        <div class="clearfix">
            <div id="banner">
                <h1>{$ad_suite}</h1>
                <span class="block_level">{$s9ybanner}{$self_info}</span>
            </div>
            <nav id="user_menu">
                <h2 class="visuallyhidden">User menu</h2>
                <ul>
                    <li><a class="icon_link" href="serendipity_admin.php" title="Startpage"><svg class="icon icon-home" title="Serendipity backend home"><use xlink:href="#icon-home" width="69.462" height="63.668" x="-34.731" y="-31.834" transform="matrix(1 0 0 -1 34.731 31.8335)" overflow="visible"></use></svg><span class="visuallyhidden"> Startpage</span></a></li>
                </ul>
            </nav>
        </div>
    </header>
    <div id="main" class="clearfix">
        <div id="serendipity_updater" class="clearfix">
            <header>
                <h2>Serendipity Auto-Upgrade Processor</h2>
                <!-- Progress bar holder -->
                <div id="progress" style="width:500px;border:1px solid #ccc;"></div>
                <!-- Progress information -->
                <div id="information" style="width"></div>
                <div id="loader"><span></span><span></span><span></span></div>
            </header>
            <article>
EOS;

                    $this->show_message('<p class="msg_notice"><svg class="icon icon-attention" title="attention"><use xlink:href="#icon-attention"></use></svg>To download, verify, check, unzip, copy and remove temporary stuff for the Serendipity Update: "' . $_REQUEST['serendipity']['newVersion'] . '" may take a little while...<br>Please don\'t get nervous and do not close this page while in progress!</p>');
                    #moved to page end, due to get another freed line for processing stuff#$this->show_message('<p class="msg_notice" style="font-size: small;color: #999;"><svg class="icon icon-attention" title="attention"><use xlink:href="#icon-attention"></use></svg>PLEASE NOTE: If this page ever stops with an error message during procession, you can normally just RELOAD your browser [<em>by keyboard shortcut, eg. F5</em>] to get another run. This does not do any harm to a continued upgrade.</p>');
                    $this->show_message('<p class="msg_notice"><svg class="icon icon-attention" title="attention"><use xlink:href="#icon-attention"></use></svg>PHP max execution time set to 210 seconds</p>');
                    $start = microtime(true);
                    if (false === ($update = $this->fetchUpdate($nv))) {
                        $this->close_page(true);
                    }
                    usleep(3);
                    $time = microtime(true) - $start;
                    $logmsg .= $lmsg = sprintf("In %0.4d seconds run fcn fetchUpdate()...\n", $time); // print in readable format 1.2345
                    $this->show_message('<p class="msg_run"><svg class="icon icon-clock" title="clock"><use xlink:href="#icon-clock"></use></svg><em>'.$lmsg.'</em></p>', 'Function fetch update', 'verify the update pack');
                    if (!empty($update)) {
                        $start = microtime(true);
                        if ($this->verifyUpdate($update, $nv)) {
                            usleep(3);
                            $time = microtime(true) - $start;
                            $logmsg .= $lmsg = sprintf("In %0.4d seconds run fcn verifyUpdate()...\n", $time); // print in readable format 1.2345
                            $this->show_message('<p class="msg_run"><svg class="icon icon-clock" title="clock"><use xlink:href="#icon-clock"></use></svg><em>'.$lmsg.'</em></p>', 'Function verify update', 'checking write permissions');
                            $start = microtime(true);
                            if ($this->checkWritePermissions($update)) {
                                usleep(3);
                                $time = microtime(true) - $start;
                                $logmsg .= $lmsg = sprintf("In %0.4d seconds run fcn checkWritePermissions()...\n", $time); // print in readable format 1.2345
                                $this->show_message('<p class="msg_run"><svg class="icon icon-clock" title="clock"><use xlink:href="#icon-clock"></use></svg><em>'.$lmsg.'</em></p>', 'Function check write permissions', 'unpacking the update');
                                $start = microtime(true);
                                $unpacked = $this->unpackUpdate($nv);
                                usleep(3);
                                $time = microtime(true) - $start;
                                $logmsg .= $lmsg = sprintf("In %0.4d seconds run fcn unpackUpdate()...\n", $time); // print in readable format 1.2345
                                $this->show_message('<p class="msg_run"><svg class="icon icon-clock" title="clock"><use xlink:href="#icon-clock"></use></svg><em>'.$lmsg.'</em></p>', 'Function unpack update', 'checking integrity');
                                if ($unpacked) {
                                    $start = microtime(true);
                                    if ($this->checkIntegrity($nv)) {
                                        usleep(3);
                                        $time = microtime(true) - $start;
                                        $logmsg .= $lmsg = sprintf("In %0.4d seconds run fcn checkIntegrity()...\n", $time); // print in readable format 1.2345
                                        $this->show_message('<p class="msg_run"><svg class="icon icon-clock" title="clock"><use xlink:href="#icon-clock"></use></svg><em>'.$lmsg.'</em></p>', 'Function check integrity', 'finally copy update');
                                        $start = microtime(true);
                                        $copied = $this->copyUpdate($nv);
                                        usleep(3);
                                        $time = microtime(true) - $start;
                                        $logmsg .= $lmsg = sprintf("In %0.4d seconds run fcn copyUpdate()...\n", $time); // print in readable format 1.2345
                                        $this->show_message('<p class="msg_run"><svg class="icon icon-clock" title="clock"><use xlink:href="#icon-clock"></use></svg><em>'.$lmsg.'</em></p>', 'Function copy update', 'cleaning up temporary directory');
                                        if ($copied) {
                                            $start = microtime(true);
                                            if (true === $this->cleanTemplatesC($nv, true) ) {
                                                $this->show_message('<p class="msg_success"><svg class="icon icon-ok" title="success"><use xlink:href="#icon-ok"></use></svg>Cleanup download temp done!</p>');
                                            }
                                            usleep(3);
                                            $time = microtime(true) - $start;
                                            $logmsg .= $lmsg = sprintf("In %0.4d seconds run fcn cleanTemplatesC()...\n", $time); // print in readable format 1.2345
                                            $this->show_message('<p class="msg_run"><svg class="icon icon-clock" title="clock"><use xlink:href="#icon-clock"></use></svg><em>'.$lmsg.'</em></p>', 'Function cleanup templates_c', 'finish processing unit');
                                            sleep(2);
                                            echo '<script type="text/javascript">var el = document.getElementById("loader"); el.style.display = "none";</script>';
                                            sleep(2);
                                            $this->show_message('<p class="msg_notice"><svg class="icon icon-attention" title="attention"><use xlink:href="#icon-attention"></use></svg><a href="'.$serendipity['serendipityHTTPPath'].'">click to start Serendipity Installer here</a>!</p>');
                                            sleep(1);
                                           $this->doUpdate();//$logmsg
                                        } else {
                                             $this->show_message('<p class="msg_error"><svg class="icon icon-error" title="error"><use xlink:href="#icon-error"></use></svg>Copying the files for the update failed!</p>');
                                        }
                                     } else {
                                        $this->showChecksumErrors($nv);
                                        echo '<form action="?serendipity[adminModule]=event_display&serendipity[adminAction]=update" method="POST">
                                             <input type="hidden" name="serendipity[newVersion]" value="'.$nv.'" />
                                             <input type="submit" value="'.PLUGIN_EVENT_AUTOUPDATE_UPDATEBUTTON.'" />
                                             </form>';
                                    }
                                } else {
                                    $this->show_message('<p class="msg_error"><svg class="icon icon-error" title="error"><use xlink:href="#icon-error"></use></svg>Unpacking the update zop file failed!</p>');
                                    if (true === $this->cleanTemplatesC($nv, false)) {
                                        $this->show_message('<p class="msg_success"><svg class="icon icon-ok" title="success"><use xlink:href="#icon-ok"></use></svg>Cleaning up the failed unpack directory!</p>');
                                    }
                                    $this->show_message('<p class="msg_notice"><svg class="icon icon-attention" title="attention"><use xlink:href="#icon-attention"></use></svg>Please <a href="?serendipity[newVersion]='.$version.'">reload</a> this page (or by F5) to have another try to upgrade your Blog successful!</p>');
                                }

                            } else {
                               $this->showNotWriteable($update);
                               echo '<form action="?serendipity[adminModule]=event_display&serendipity[adminAction]=update" method="POST">
                                    <input type="hidden" name="serendipity[newVersion]" value="'.$nv.'" />
                                    <input type="submit" value="'.PLUGIN_EVENT_AUTOUPDATE_UPDATEBUTTON.'" />
                                    </form>';
                            }
                        }
                    }
                    $this->close_page(true);
                    break;

                default:
                    return false;

            }
            return true;
        } else {
            return false;
        }
    }

    /**
     * fetch the zip file from server
     * @param string $version Version
     * @return mixed updatepath/bool
     */
    function fetchUpdate($version)
    {
        global $serendipity;

        $geturl = $this->get_config('download_url', 'https://github.com/s9y/Serendipity/releases/download/');
        #$url    = (string)"http://prdownloads.sourceforge.net/php-blog/serendipity-$version.zip?download";
        $url    = (string)"$geturl$version/serendipity-$version.zip";
        $update = (string)$serendipity ['serendipityPath'] . 'templates_c/' . "serendipity-$version.zip";

        // do we already have it and is it eventually broken?
        if (file_exists($update)) {
            $zip = new ZipArchive;
            $res = $zip->open($update);
            if ($res === TRUE) {
                $done = true;
            } else {
                $this->show_message('<p class="msg_error"><svg class="icon icon-error" title="error"><use xlink:href="#icon-error"></use></svg>Existing zip file error; Code:' . $res. '. The autoupdater will try to download again...');
                @unlink($update);
                sleep(1);
                $done = @copy($url, $update) ? true : false;
                sleep(1);
            }
            @$zip->close();
        } else {
            $done = @copy($url, $update) ? true : false;
            sleep(1);
        }

        if (!$done) {
            //try it again with curl if copy was forbidden
            if (function_exists('curl_init')) {
                $out = @fopen($update, 'wb');
                $ch  = @curl_init();

                @curl_setopt($ch, CURLOPT_FILE, $out);
                @curl_setopt($ch, CURLOPT_HEADER, 0);
                @curl_setopt($ch, CURLOPT_URL, $url);

                $success = @curl_exec($ch);
                if (!$success) {
                    $this->show_message('<p class="msg_error"><svg class="icon icon-error" title="error"><use xlink:href="#icon-error"></use></svg>Downloading update failed (curl installed, but failed)! Does it  '. $url .' exist? <a href="?serendipity[newVersion]='.$version.'">Reload</a> page or return to your blogs <a href="serendipity_admin.php">backend</a>.</p>');
                    return false;
                }
            } else {
                $this->show_message('<p class="msg_error"><svg class="icon icon-error" title="error"><use xlink:href="#icon-error"></use></svg>Downloading update failed (copy failed, curl not available)! Does it  '. $url .' exist? <a href="?serendipity[newVersion]='.$version.'">Reload</a> page or return to your blogs <a href="serendipity_admin.php">backend</a>.</p>');
                return false;
            }
        }

        if (file_exists($update)) {
            $this->show_message('<p class="msg_success"><svg class="icon icon-ok" title="success"><use xlink:href="#icon-ok"></use></svg>Fetch download to templates_c done</p>');
            return $update;
        } else {
            return false;
        }
    }

    /**
     * compare the md5 of downloaded archive with the md5 posted on the downloadpage
     * @param   string updatePath
     * @param   string version
     * @return  boolean
     */
    function verifyUpdate($update, $version)
    {
        $geturl = $this->get_config('download_url', 'https://github.com/s9y/Serendipity/releases/download/');
        $md5url = $this->get_config('releasefile_url', 'https://github.com/s9y/Serendipity/releases/tag/');

        #$url          = (string)"http://prdownloads.sourceforge.net/php-blog/serendipity-$version.zip?download";
        $url          = (string)"$geturl$version/serendipity-$version.zip";
        #$updatePage   = (string)$this->getPage("http://www.s9y.org/12.html");
        $updatePage   = (string)$this->getPage("$md5url$version");

        #$downloadLink = substr($updatePage, strpos($updatePage, $url), 200);
        $found        = array();
        // grep the checksum
        #preg_match("/\(MD5: (.*)\)/", $downloadLink, $found);
        preg_match("/\(MD5: (.*)\)/", $updatePage, $found);
        $checksum = $found[1];
        $this->show_message('<p class="msg_notice"><svg class="icon icon-attention" title="attention"><use xlink:href="#icon-attention"></use></svg>Checking MD5 zip file checksum: ' . $checksum . '</p>');
        $check = md5_file($update);

        if ($check == $checksum) {
            return true;
        } else {
            $this->show_message('<p class="msg_error"><svg class="icon icon-error" title="error"><use xlink:href="#icon-error"></use></svg>Error! Could not verify the update. <a href="?serendipity[newVersion]='.$version.'">Reload</a> page or return to your blogs <a href="serendipity_admin.php">backend</a>.</p>');
            return false;
        }
    }

    /**
     * get file content of updatePage
     * @param   string url
     * @return  page content
     */
    function getPage($url)
    {
        $page = @file_get_contents($url);
        if (empty($page)) {
            //try it again with curl if fopen was forbidden
            if (function_exists('curl_init')) {
                $ch = curl_init($url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_TIMEOUT, "20");
                $page = curl_exec($ch);
                curl_close($ch);
            }
        }
        return $page;
    }

    /**
     * unpack the update to templates_c
     * @param   string version
     * @return  boolean
     */
    function unpackUpdate($version)
    {
        global $serendipity;

        $update    = (string)$serendipity['serendipityPath'] . 'templates_c/' . "serendipity-$version.zip";
        $updateDir = (string)$serendipity['serendipityPath'] . 'templates_c/' . "serendipity-$version/";

        // do we already have it?
        if (is_dir($updateDir) && is_file($updateDir . '/serendipity/README.markdown') && is_file($updateDir . '/serendipity/checksums.inc.php')) {
            return true;
        }
        $zip = new ZipArchive;

        if ($zip->open($update) === true) {
            // 1.get all filenames apart from the root 'serendipity'
            $i=1;
            $files = array();
            $name = $zip->getNameIndex($i);
            while (!empty($name)) {
                $files[] = $name;
                $name = $zip->getNameIndex($i);
                $i+=1;
            }
            // 2.extraxt all files to temp
            $zip->extractTo($updateDir);
            $this->show_message('<p class="msg_success"><svg class="icon icon-ok" title="success"><use xlink:href="#icon-ok"></use></svg>Extracting the zip in templates_c done</p>');
            $zip->close();
        } else {
            return false;
        }
        return true;
    }

    /**
     * copy the update from templates_c over the existing files
     * @param   string version
     * @return  boolean
     */
    function copyUpdate($version)
    {
        global $serendipity;

        $update    = (string)$serendipity['serendipityPath'] . 'templates_c/' . "serendipity-$version.zip";
        $updateDir = (string)$serendipity['serendipityPath'] . 'templates_c/' . "serendipity-$version/";

        $zip = new ZipArchive;

        if ($zip->open($update) === true) {
            // 1.get all filenames apart from the root 'serendipity'
            $i=1;
            $files = array();
            $name = $zip->getNameIndex($i);
            while ( !empty($name) ) {
                $files[] = $name;
                $name = $zip->getNameIndex($i);
                $i+=1;
            }
            $zip->close();
            // 2. copy them over
            foreach ($files AS $file) {
                $target = $serendipity['serendipityPath'] . preg_replace('/[^\/]*/', '', $file, 1); // we always remove the first directory 'serendipity/' path part, though this additionally allows source (beta versioned) zips. Zip Releases, beta or not, should always be personally maintained and touched by the release script!
                if (is_dir($updateDir .$file)) {
                    if (!file_exists($target)) {
                        $success = mkdir($target);
                    } else {
                        $success = true;
                    }
                } else {
                    $success = @copy($updateDir . $file, $target);
                }
                if (!$success) {
                    $this->show_message('<p class="msg_error"><svg class="icon icon-error" title="error"><use xlink:href="#icon-error"></use></svg>Error! Copying file '. $updateDir . $file .' to '. $target .' failed! <a href="?serendipity[newVersion]='.$version.'">Reload</a> page or return to your blogs <a href="serendipity_admin.php">backend</a>.</p>');
                    return false;
                }
            }

        } else {
            return false;
        }
        return true;
    }

    /**
     * check write permissions
     * @param   string updatePath
     * @return  boolean
     */
    function checkWritePermissions($update)
    {
        global $serendipity;

        $zip = new ZipArchive;

        if ($zip->open($update) === true) {
            $i=0;
            $files = array();
            $name = $zip->getNameIndex($i);
            while (!empty($name)) {
                $files[] = $name;
                $name = $zip->getNameIndex($i);
                $i+=1;
            }
            $zip->close();
            foreach ($files AS $file) {
                $target = $serendipity['serendipityPath'] . substr($file, 12);
                if ((!is_writable($target)) && file_exists($target)) {
                    return false;
                }
            }
        }
        return true;
    }

    /**
     * show not writable
     * @param   string updatePath
     * @return  error
     */
    function showNotWriteable($update)
    {
        global $serendipity;

        $zip = new ZipArchive;

        if ($zip->open($update) === true) {
            $i=0;
            $files = array();
            $name = $zip->getNameIndex($i);
            while (!empty($name)) {
                $files[] = $name;
                $name = $zip->getNameIndex($i);
                $i+=1;
            }
            $zip->close();

            $notWritable = array();

            foreach ($files AS $file) {
                $target = $serendipity['serendipityPath'] . substr($file, 12);
                if ((!is_writable($target)) && file_exists($target)) {
                    $notWriteable[] = $target;
                }
            }
        }
        ob_start();
        echo '<p class="msg_error"><svg class="icon icon-error" title="error"><use xlink:href="#icon-error"></use></svg>Unpacking the update zip file failed, while the following files were not writeable:</p>';
        echo "<ul>";
        foreach  ($notWriteable AS $file) {
            echo "<li>$file</li>";
        }
        echo "</ul>";
        $write_error = ob_get_contents();
        ob_end_clean();
        $this->show_message($write_error);
    }

    /**
     * checks updates checksum file array with updates realfiles
     * @param   string version
     * @return  boolean
     */
    function checkIntegrity($version)
    {
        global $serendipity;

        $updateDir    = (string)$serendipity['serendipityPath'] . 'templates_c/' . "serendipity-$version/";
        $checksumFile = (string)$updateDir . "serendipity/checksums.inc.php";

        // Styx beta version prior 2.1-beta2 did not have checksums
        if (strpos($version, '2.1-beta1') !== FALSE) {
            return true;
        }
        include_once $checksumFile;

        $checksums = $serendipity['checksums_' . $version];

        foreach ($checksums AS $file => $checksum) {
            $check = serendipity_FTPChecksum($updateDir . "serendipity/" . $file);
            if ($checksum != $check) {
                return false;
            }
        }
        return true;
    }

    /**
     * checks updates checksum file array with updates realfiles
     * @param   string version
     * @return  error
     */
    function showChecksumErrors($version)
    {
        global $serendipity;

        $updateDir    = (string)$serendipity['serendipityPath'] . 'templates_c/' . "serendipity-$version/";
        $checksumFile = (string)$updateDir . "serendipity/checksums.inc.php";

        include_once $checksumFile;

        $checksums = $serendipity['checksums_' . $version];
        $errors    = array();

        foreach ($checksums AS $file => $checksum) {
            $check = serendipity_FTPChecksum($updateDir . "serendipity/" . $file);
            if ($checksum != $check) {
                $errors[] = $updateDir . "serendipity/" . $file;
            }
        }
        ob_start();
        echo '<p class="msg_error"><svg class="icon icon-error" title="error"><use xlink:href="#icon-error"></use></svg>Updating failed, while the integrity-test for the following files failed:</p>';
        echo "<ul>";
        foreach ($errors AS $file) {
            echo "<li>$file</li>";
        }
        echo "</ul>";
        $integrity_error = ob_get_contents();
        ob_end_clean();
        $this->show_message($integrity_error);
    }

    /**
     * close the autoupdate progress page
     * @param   bool 007 title ;-)
     */
    function close_page($terminate = false)
    {
        echo <<<EOS
            </article>
        </div>
    </div>
EOS;
        if ($terminate) {
            $this->show_message('<p id="terminator" style="font-size: smaller;"><svg class="icon icon-attention" title="attention"><use xlink:href="#icon-attention"></use></svg>PLEASE NOTE:<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; If this page ever stops with an error message during procession, you can normally just RELOAD your browser [<em>by keyboard shortcut, eg. F5</em>] to get another run. This does not do any harm to a continued upgrade.</p>');
            echo <<<EOS
    </body>
</html>
EOS;
        }
        if ($terminate) die();
    }

    /**
     * visit the rootpage to manually start the update installer process
     * @param   string update messages
     * @return  refresh page
     */
    function doUpdate()
    {
        global $serendipity;

        $msg = "Autoupdate successfully done!\\nWe now refresh to Serendipity Installer!\\n"; // escape for js
        $this->show_message('<p class="msg_success"><svg class="icon icon-ok" title="success"><use xlink:href="#icon-ok"></use></svg>Autoupdate successfully done - refresh to Serendipity Installer</p>', 'Autoupdate');
        $this->close_page();

        // this is working for me.... is it for you?
        if (die('<script type="text/javascript">alert("'.$msg.'"); window.location = "'.$serendipity['serendipityHTTPPath'].'";</script>'."\n    </body>\n</html>")) {
            return;
        } else {
            if (!headers_sent()) {
                if (header('Location: http://' . $_SERVER['HTTP_HOST'] . $serendipity['serendipityHTTPPath'])) exit;
            } else {
                echo '<script type="text/javascript">';
                echo '    window.location.href="' . $serendipity['serendipityHTTPPath'] . '"';
                echo '</script>'."\n";
                echo '<noscript>';
                echo '    <meta http-equiv="refresh" content="0;url=' . $serendipity['serendipityHTTPPath'] . '" />';
                echo '</noscript>';
                exit;
            }
        }
    }

    /**
     * empty a directory using the Standard PHP Library (SPL) iterator
     * @param   string directory
     */
    function empty_dir($dir)
    {
        if (!is_dir($dir)) return;
        try {
            $_dir = new RecursiveDirectoryIterator($dir);
            // NOTE: UnexpectedValueException thrown for PHP >= 5.3
            } catch (Exception $e) {
                return;
            }
        $iterator = new RecursiveIteratorIterator($_dir, RecursiveIteratorIterator::CHILD_FIRST);
        //$iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir), RecursiveIteratorIterator::CHILD_FIRST);
        foreach ($iterator AS $file) {
            if ($file->isFile()) {
                unlink($file->__toString());
            } else {
                @rmdir($file->__toString());
            }
        }
    }

    /**
     * delete all cache-files in cache templates_c to prevent display-errors after update
     * @param   string version
     * @return  boolean
     */
    function cleanTemplatesC($version, $finish)
    {
        global $serendipity;
        $zip    = (string)$serendipity['serendipityPath'] . 'templates_c/' . "serendipity-$version.zip";
        $zipDir = (string)$serendipity['serendipityPath'] . 'templates_c/' . "serendipity-$version";

        // leave rm zip untouched here as not causing any errors
        #unlink($zip);// if (unlink($zip)) { else error note?
        #$this->show_message('<p class="msg_success"><svg class="icon icon-ok" title="success"><use xlink:href="#icon-ok"></use></svg>Removing the zip file in templates_c done</p>');

        // As trying to remove a directory that php is still using, we use open/closedir($handle) to be sure
        if ($handle = opendir($zipDir)) {
            $this->empty_dir($zipDir);
            $this->show_message('<p class="msg_success"><svg class="icon icon-ok" title="success"><use xlink:href="#icon-ok"></use></svg>Removing all files in '.$zipDir.' done</p>');
            closedir($handle);
        }
        if (rmdir($zipDir)) {
            $this->show_message('<p class="msg_success"><svg class="icon icon-ok" title="success"><use xlink:href="#icon-ok"></use></svg>Removing the empty directory: '.$zipDir.' done</p>');
        } else {
            $this->show_message('<p class="msg_error"><svg class="icon icon-error" title="error"><use xlink:href="#icon-error"></use></svg>Removing the empty directory: '.$zipDir.' failed!</p>');
        }
        // We clear all compiles smarty template files in templates_c which only leaves the page we are on: /serendipity/templates/default/admin/index.tpl
        if ($finish) {
            // We have to reduce this call() = all tpl files, to clear the blogs template only, to not have the following automated recompile, force the servers memory
            // to get exhausted, when using serendipity_event_gravatar plugin, which can eat up some MB...
            if (method_exists($serendipity['smarty'], 'clearCompiledTemplate')) { // SMARTY 3
                if ($serendipity['smarty']->clearCompiledTemplate($serendipity['template'], $serendipity['template'])) {
                    return true;
                }
            }
            if (method_exists($serendipity['smarty'], 'clear_compiled_tpl')) { // SMARTY 2
                if ($serendipity['smarty']->clear_compiled_tpl(null, $serendipity['template'])) {
                    return true;
                }
            }
        }
    }

    /**
     * debug
     * @param   string msg
     */
    function debugMsg($msg)
    {
        global $serendipity;

        $this->debug_fp = @fopen ($serendipity ['serendipityPath'] . 'templates_c/autoupdate.log', 'a');
        if (!$this->debug_fp) {
            return false;
        }

        if (empty($msg)) {
            fwrite($this->debug_fp, "failure \n");
        } else {
            fwrite($this->debug_fp, print_r( $msg, true ));
        }
        fclose ( $this->debug_fp );
    }

}

/* vim: set sts=4 ts=4 expandtab : */
?>