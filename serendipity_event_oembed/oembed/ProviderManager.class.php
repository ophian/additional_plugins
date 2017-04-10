<?php

class ProviderManager
{
    private $providers;
    private static $_instance;
    private $config;

    private function __construct($maxwidth=null, $maxheight=null, $config = array())
    {
        $this->providers=array();
        $this->config = $config;
        $xml = simplexml_load_string(file_get_contents(PLUGIN_OEMBED_PROVIDER_XML_FILE));// PROVIDER_XML comes from config.php
        foreach($xml->provider as $provider){
            if(!isset($provider->class) && isset($provider->endpoint)){
                $onlyJson = isset($provider->jsononly);
                $dimensionsSupported = !isset($provider->nodimensionsupport);
                $this->register(new OEmbedProvider($provider->url,$provider->endpoint, $onlyJson, $maxwidth, $maxheight, $dimensionsSupported));
            } else {
                $classname="".$provider->class; // force to be string :)
                $reflection = new ReflectionClass($classname);
                $this->register($reflection->newInstance($provider));//so we could pass config vars
            }
        }
    }

    static function getInstance($maxwidth=null, $maxheight=null, $config = array())
    {
        if(!isset($_instance) || $_instance==null){
            $_instance = new ProviderManager($maxwidth, $maxheight, $config);
        }
        return $_instance;
    }

    public function register($provider)
    {
        if (!empty($this->config)) $provider->set_config($this->config);
        $this->providers[]=$provider;
    }

    public function provide($url,$format)
    {
        foreach ($this->providers as $provider){
            if ($provider->match($url)){
                return $provider->provide($url,$format);
            }
        }
        return null;
    }

}
