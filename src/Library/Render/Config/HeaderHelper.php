<?php


namespace Tinkle\Library\Render\Config;


use Tinkle\Tinkle;

/**
 * Class AdditionalConfigHelper
 * This is A Helper Class For Library/Render/Config
 * @package Tinkle\Library\Render
 */
class HeaderHelper
{

    protected  Config $config;
    /**
     * HeaderHelper constructor.
     * @param Config $config
     */
    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    public function streamable(bool $status=false)
    {
        Config::streamable($status);
        return $this;
    }

    public function withPoweredBy(string $name='Tinkle')
    {
        Config::withPoweredBy($name);
        return $this;
    }

    public function withExternal()
    {
        return new ExternalHeaders($this);
    }



    public  function withExternalIframe(bool $status=false)
    {
        Config::withExternalIframe($status);
        return $this;
    }

    public  function withExternalMedia(bool $status=false)
    {
        Config::withExternalMedia($status);
        return $this;
    }

    public function withImageBase64(bool $status=true)
    {
        Config::withImageBase64($status);
        return $this;
    }

    public function withHeaderMaxAge(int $time_second=60)
    {
        Config::withHeaderMaxAge($time_second);
        return $this;
    }

    // This should be mail sending type or log type in future version
    public function getCSPReportToThisFile(string $report_public_file_location='')
    {
        Config::getCSPReportToThisFile($report_public_file_location);
        return $this;
    }



    public function applyHeader()
    {
        return $this->config;
    }


}