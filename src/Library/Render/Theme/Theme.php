<?php


namespace Tinkle\Library\Render\Theme;


class Theme
{

    private array $thmConfig=[];
    /**
     * Theme constructor.
     * @param array $themeConfiguration
     */
    public function __construct(array $themeConfiguration)
    {
        $this->thmConfig = $themeConfiguration;
    }


    public function getOutput()
    {
        return "Theme Output";
    }





}