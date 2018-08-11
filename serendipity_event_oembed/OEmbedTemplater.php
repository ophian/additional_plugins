<?php
class OEmbedTemplater
{
    /* get the right template (s9y template path, then plugin path) and expand it */
    static function fetchTemplate($filename, $oembed, $url)
    {
        global $serendipity;

        if (!is_object($serendipity['smarty']))
            serendipity_smarty_init();

        // Declare the oembed to smarty
        $serendipity['smarty']->assign('oembedurl',$url);
        $serendipity['smarty']->assign('oembed',(array)$oembed);
        $tfile = serendipity_getTemplateFile($filename, 'serendipityPath');
        if (!$tfile || $filename == $tfile) {
            $tfile = dirname(__FILE__) . '/' . $filename;
        }

        $serendipity['smarty']->disableSecurity();

        $content = $serendipity['smarty']->fetch('file:'. $tfile);

        return $content;
    }

}