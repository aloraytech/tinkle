<?php


namespace Tinkle\Library\Render;


use Tinkle\Library\Render\Engine\Engine;
use Tinkle\Library\Render\Engine\Native\NativeEngine;
use Tinkle\Library\Render\Engine\Twig\TwigEngine;

class TemplateHandler
{
    protected array $themeConfig;
    protected array $viewConfig;
    protected object $engine;
    protected string $layout;
    protected string $output='Default View';


    /**
     * TemplateHandler constructor.
     * @param array $themeConfig
     * @param array $viewConfig
     */
    public function __construct(array $themeConfig, array $viewConfig)
    {
        $this->themeConfig = $themeConfig;
        $this->viewConfig = $viewConfig;



    }

    public function getOutput()
    {

        return $this->output;
    }

    public function resolve()
    {
        $this->layout = $this->checkTemplateForLayout();
        if($this->viewConfig['engine'] === Engine::NATIVE_ENGINE)
        {
            $this->engine = new NativeEngine($this->themeConfig,$this->viewConfig);
            $this->engine->resolve($this->layout,$this->themeConfig['template'],$this->viewConfig['modules']);
            $this->output = $this->engine->getOutput();
        }else{
            $this->engine = new TwigEngine();
        }



        return true;

    }





    private function checkEngine()
    {

        if(strtolower($this->themeConfig['engine']) === strtolower($this->viewConfig['engine']))
        {
            if($this->viewConfig['engine'] === Engine::NATIVE_ENGINE)
            {
                $this->engine = new NativeEngine();

            }else{
                if($this->viewConfig['engine'] === Engine::TWIG_ENGINE)
                {
                    $this->engine = new TwigEngine();

                }
            }
        }
        return $this->engine;

    }


    private function checkTemplateForLayout()
    {
        $layout = $this->themeConfig['layout'];

        $existLayout = str_replace($this->themeConfig['info']['name'].'/','',str_replace(str_replace('\\','/',$this->themeConfig['dir']),'',str_replace('\\','/',$this->themeConfig['layout'])));
        $template = $this->themeConfig['template'];

        if (file_exists($template))
        {
            $templateData = file_get_contents($template);
            $givenLayoutName = '';
            if(preg_match("/{{extend\(.+\}}/",$templateData,$matches))
            {
                $givenLayoutName = str_replace("')}}","",str_replace("{{extend('","",$matches[0]));

            }
        }

        if(!empty($givenLayoutName))
        {
            $layout = $this->themeConfig['dir'].$this->themeConfig['info']['name'].'/'.$givenLayoutName;
            if(file_exists($layout.'.php'))
            {
                $this->layout = $layout.'.php';
            }elseif (file_exists($layout.'.html'))
            {
                $this->layout = $layout.'.html';
            }else{
                $this->layout = $this->themeConfig['layout'];
            }
        }else{
            $this->layout = $this->themeConfig['layout'];
        }

        return $this->layout;


    }





}