<?php


namespace Tinkle\Library\Render\Template;


class Template
{

    private array $tempConfig=[];
    /**
     * Template constructor.
     * @param array $templateConfiguration
     */
    public function __construct(array $templateConfiguration)
    {
        $this->tempConfig = $templateConfiguration;
    }


    public function getOutput()
    {
        return "Template Output";
    }



}