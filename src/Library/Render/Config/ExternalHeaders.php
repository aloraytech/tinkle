<?php


namespace Tinkle\Library\Render\Config;


class ExternalHeaders
{

    private HeaderHelper $config;

    /**
     * ConfigurationHelper constructor.
     * @param HeaderHelper $config
     */
    public function __construct(HeaderHelper $config)
    {
        $this->config = $config;
    }


    public function cssHost(bool $status=false,string $cssHost='')
    {
        Config::withExternalCSS($status,$cssHost);
        return $this;
    }

    public function jsHost(bool $status=false,string $jsHost='')
    {
        Config::withExternalJS($status,$jsHost);
        return $this;
    }

    public function applyExternal()
    {
        return $this->config;
    }



}