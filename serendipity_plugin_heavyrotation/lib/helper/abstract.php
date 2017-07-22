<?php
/**
 * Abstract helper class for REST-based services
 *
 * @author Lars Strojny <lars@strojny.net>
 * @todo The HTTP-fetch stuff can be replaced with a decorator alike pattern
 */
abstract class serendipity_plugin_heavyrotation_helper_abstract
{
    /**
     * Helper function to fetch HTTP-URLs
     *
     * @param string $url
     * @return string
     * @todo Error handling is missing
     */
    protected function _fetch($url)
    {
        if (function_exists('serendipity_request_url')) {
            $response = serendipity_request_url($url, 'GET');
            $response = unserialize($response);
            return $response;
        } else {
            require_once S9Y_PEAR_PATH . 'HTTP/Request.php';
            serendipity_request_start();
            $request = new HTTP_Request($url);
            $request->setMethod(HTTP_REQUEST_METHOD_GET);
            $request->sendRequest();
            $response = unserialize($request->getResponseBody());
            serendipity_request_end();
            return $request->getResponseBody();
        }
    }

}
