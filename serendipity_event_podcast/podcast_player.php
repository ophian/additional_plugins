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
<div class="media_object_container">
    <object type="video/quicktime"
        class="qtplayer"
        data="#url#"
        #height# #width# #align#>
        <param name="src" value="#url#"/>
        <param name="autoplay" value="false"/>
        <param name="controller" value="true"/>
        <param name="scale" value="ASPECT"/>
    </object>
</div>
');

// Windows Media Player
@DEFINE('PLUGIN_PODCAST_WMPLAYER','
<div class="media_object_container">
    <object type="application/x-mplayer2"
        class="wmplayer"
        data="#url#"
        #height# #width# #align#>
        <param name="fileName" value="#url#" />
        <param name="animationatStart" value="true" />
        <param name="transparentatStart" value="false" />
        <param name="autoStart" value="0" />
        <param name="showControls" value="1" />
        <param name="showstatusbar" value="0" />
        <param name="showtracker" value="1" />
        <param name="loop" value="0" />
    </object>
</div>
');

@DEFINE('PLUGIN_PODCAST_MP3PLAYER','
<div class="media_object_container">
    <object type="video/quicktime"
        data="#url#"
        class="qtsmallplayer"
        width="50" height="15" #align#>
        <param name="src" value="#url#"/>
        <param name="autoplay" value="false"/>
        <param name="controller" value="true"/>
        <param name="scale" value="ASPECT"/>
    </object>
</div>
');

@DEFINE('PLUGIN_PODCAST_HTML5_AUDIOPLAYER','
<div class="media_object_container">
    <audio controls=1 preload="none" src="#url#" type="#mime#">&nbsp;</audio>
</div>
');

@DEFINE('PLUGIN_PODCAST_HTML5_VIDEOPLAYER','
<div class="media_object_container">
    <video controls=1 preload="none" src="#url#" type="#mime#">&nbsp;</video>
</div>
');
