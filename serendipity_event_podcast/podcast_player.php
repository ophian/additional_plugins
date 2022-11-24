<?php

/**
 * This file contains all players used by the Easy Podcast Plugin and default extensions
 */

@DEFINE('PLUGIN_PODCAST_QTEXT_DEFAULT',     '3gp,mov,mp4,mqv,qt');
@DEFINE('PLUGIN_PODCAST_WMEXT_DEFAULT',     'avi,mpg,mpeg,wmv');
@DEFINE('PLUGIN_PODCAST_AUEXT_DEFAULT',     'ogg,m3u,pls,m4b');
@DEFINE('PLUGIN_PODCAST_HTML5_AUDIO_DEFAULT','mp3');
@DEFINE('PLUGIN_PODCAST_HTML5_VIDEO_DEFAULT','');


// Quicktime Player
@DEFINE('PLUGIN_PODCAST_QUICKTIMEPLAYER','
<!--[if !IE]> -->
<object type="video/quicktime"
    class="qtplayer"
    data="#url#"
    #height# #width# #align#>
<!-- <![endif]-->
<!--[if IE]>
<object classid="clsid:02BF25D5-8C17-4B23-BC80-D3488ABDDC6B"
    codebase="http://www.apple.com/qtactivex/qtplugin.cab"
    class="qtplayer"
    #height# #width# #align#>
<!--><!---->
    <param name="src" value="#url#"/>
    <param name="autoplay" value="false"/>
    <param name="controller" value="true"/>
    <param name="scale" value="ASPECT"/>
</object>
<!-- <![endif]-->
');

// Windows Media Player
@DEFINE('PLUGIN_PODCAST_WMPLAYER','
<!--[if !IE]> -->
<object type="application/x-mplayer2"
    class="wmplayer"
    data="#url#"
    #height# #width# #align#>
<!-- <![endif]-->
<!--[if IE]>
<object classid="CLSID:22d6f312-b0f6-11d0-94ab-0080c74c7e95"
    codebase="http://activex.microsoft.com/activex/controls/mplayer/en/nsmp2inf.cab#Version=5,1,52,701"
    standby="Media is loading..." type="application/x-oleobject"
    class="wmplayer"
    #height# #width# #align#>
<!--><!---->
    <param name="fileName" value="#url#" />
    <param name="animationatStart" value="true" />
    <param name="transparentatStart" value="false" />
    <param name="autoStart" value="0" />
    <param name="showControls" value="1" />
    <param name="showstatusbar" value="0" />
    <param name="showtracker" value="1" />
    <param name="loop" value="0" />
</object>
<!-- <![endif]-->
');

@DEFINE('PLUGIN_PODCAST_MP3PLAYER','
<!--[if !IE]> -->
<object type="video/quicktime"
    data="#url#"
    class="qtsmallplayer"
    width="50" height="15" #align#>
<!-- <![endif]-->
<!--[if IE]>
<object classid="clsid:02BF25D5-8C17-4B23-BC80-D3488ABDDC6B"
    codebase="http://www.apple.com/qtactivex/qtplugin.cab"
    class="qtsmallplayer"
    width="50" height="15" #align#>
<!--><!---->
    <param name="src" value="#url#"/>
    <param name="autoplay" value="false"/>
    <param name="controller" value="true"/>
    <param name="scale" value="ASPECT"/>
</object>
<!-- <![endif]-->
');

@DEFINE('PLUGIN_PODCAST_HTML5_AUDIOPLAYER','
<audio controls=1 preload="none">
    <source src="#url#" type="#mime#" />
    ' . PLUGIN_PODCAST_FLOWPLAYER . '
</audio>
');

@DEFINE('PLUGIN_PODCAST_HTML5_VIDEOPLAYER','
<video controls=1 preload="none">
    <source src="#url#" type="#mime#" />
    ' . PLUGIN_PODCAST_FLOWPLAYER . '
</video>
');