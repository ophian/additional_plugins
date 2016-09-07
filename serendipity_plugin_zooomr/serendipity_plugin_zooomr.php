<?php

if (IN_serendipity !== true) {
    die ("Don't hack!");
}

@serendipity_plugin_api::load_language(dirname(__FILE__));

class serendipity_plugin_zooomr extends serendipity_plugin
{
	/**
     * serendipity_plugin_zooomr::introspect()
     *
     * @param  $propbag
     * @return
     */
    function introspect(&$propbag)
    {
        global $serendipity;

        $propbag->add('name', PLUGIN_ZOOOMR_NAME);
        $propbag->add('description', PLUGIN_ZOOOMR_DESC);
        $propbag->add('requirements',  array(
            'serendipity' => '1.6',
            'smarty'      => '2.6.7',
            'php'         => '4.1.0'
        ));
        $propbag->add('version',  '0.4');
        $propbag->add('author',  'Stefan Lange-Hegermann');
        $propbag->add('configuration', array('title', 'feed', 'imagecount', 'imagewidth', 'dlink', 'logo'));

        $propbag->add('groups', array('FRONTEND_EXTERNAL_SERVICES'));
    }

	/**
     * serendipity_plugin_zooomr::introspect_config_item()
     *
     * @param  $name
     * @param  $propbag
     * @return
     */
	function introspect_config_item($name, &$propbag)
	{
		switch ($name) {
	        case 'title':
				$propbag->add('type', 'string');
				$propbag->add('name', TITLE);
				$propbag->add('description', TITLE);
				$propbag->add('default', 'Zooomr');
				break;
			case 'feed':
				$propbag->add('type', 'string');
				$propbag->add('name', PLUGIN_ZOOOMR_FEEDURL);
				$propbag->add('description', PLUGIN_ZOOOMR_FEEDDESC);
				$propbag->add('default', 'http://beta.zooomr.com/bluenote/feeds:rss/tags/bird');
				break;
			case 'imagecount':
				$propbag->add('type', 'string');
				$propbag->add('name', PLUGIN_ZOOOMR_IMGCOUNT);
				$propbag->add('description', PLUGIN_ZOOOMR_IMGCOUNTDESC);
				$propbag->add('default', '4');
				break;
			case 'imagewidth':
				$propbag->add('type', 'string');
				$propbag->add('name', PLUGIN_ZOOOMR_IMGWIDTH);
				$propbag->add('default', '65');
				break;
			case 'dlink':
				$propbag->add('type', 'boolean');
				$propbag->add('name', PLUGIN_ZOOOMR_DLINK);
				$propbag->add('description', PLUGIN_ZOOOMR_DLINKDESC);
				$propbag->add('default', 'false');
				break;
			case 'logo':
				$propbag->add('type', 'boolean');
				$propbag->add('name', PLUGIN_ZOOOMR_LOGO);
				$propbag->add('default', 'true');
				break;
		}
		return true;
	}

	/**
	 * serendipity_plugin_zooomr::getURL()
	 * downloads the content from an URL and returns it as a string
	 *
	 * @author Stefan Lange-Hegermann
	 * @since 02.08.2006
	 * @param string $url URL to get
	 * @return string downloaded Data from "$url"
	 */
	function get_url($url)
	{
        if (function_exists('serendipity_request_object')) {
            $req = serendipity_request_object($url);
            $response = $req->send();
            if (PEAR::isError($req->send()) || $response->getStatus() != '200') {
                $store = file_get_contents($url);
            } else {
                $store = $response->getBody();
            }
        } else {
            require_once (defined('S9Y_PEAR_PATH') ? S9Y_PEAR_PATH : S9Y_INCLUDE_PATH . 'bundled-libs/') . 'HTTP/Request.php';
            $req = new HTTP_Request($url);
            if (PEAR::isError($req->sendRequest()) || $req->getResponseCode() != '200') {
                $store = file_get_contents($url);
            } else {
                $store = $req->getResponseBody();
            }
        }

		return $store;
	}

    /**
     * serendipity_plugin_zooomr::generate_content()
     *
     * @param  $title
     * @return
     */
	function generate_content(&$title)
    {
		$feedurl	=		$this->get_config('feed');
		$count		=(int)	$this->get_config('imagecount');
		$imgwidth	=(int)	$this->get_config('imagewidth');
		$dlink		=		serendipity_db_bool($this->get_config('dlink', 'false'));
		$logo		=		serendipity_db_bool($this->get_config('logo', 'true'));
		$title		=		$this->get_config('title');;
		$buffer		=		$this->get_url($feedurl);
		$content    =       '<div class="serendipityPluginZooomr">';
		$allitems   =       preg_split ( "/<\/*item>/", $buffer);

		for ($a=1;$a<($count*2);$a+=2) {
			if ($allitems[$a]) {
				preg_match ( '/<media:thumbnail url="([^"]*)"/', $allitems[$a] , $thumbhits);
				preg_match ( '/<media:content url="([^"]*)"/', $allitems[$a] , $bighits);
				preg_match ( '/<link\>([^<]*)/', $allitems[$a] , $linkhits);

				if ($linkhits[1]) {
					if ($dlink) {
						$linkurl=$bighits[1];
						$rellink=' rel="lightbox[sidebar]"';
					} else {
						$linkurl=$linkhits[1];
						$rellink='';
					}
					$content .= "\n".'<a href="'.$linkurl.'"'.$rellink.'><img style="width:'.$imgwidth.'px" src="'.$thumbhits[1].'" /></a>';
				}
			}
		}

		if ($logo) {
			$content.='Hosted on <strong>Zooom<span style="color:#9EAE15;">r</span></strong>';
        }
		$content .= '</div>';

		echo $content;
	}

}

?>