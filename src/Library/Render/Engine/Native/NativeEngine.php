<?php


namespace Tinkle\Library\Render\Engine\Native;


use Tinkle\Library\Render\RenderInterface;

/**
 * Class Native
 * @package Tinkle\Library\Render\Engine\Native
 */
class NativeEngine
{

    protected array $themeConfig;
    protected array $viewConfig;
    protected LayoutFilter $layoutFilter;
    protected TemplateFilter $templateFilter;
    protected string $layout='';
    protected string $template='';
    protected array|string|int|object $data;

    protected object $theme;
    protected string $themeDir='';
    protected array $allCss=[];
    protected array $allJs=[];
    protected array $allMedia=[];
    protected array $info=[];
    protected bool $frontend=false;
    protected bool $backend=false;

    protected string $type='';

    /**
     * NativeEngine constructor.
     * @param array $themeConfig
     * @param array $viewConfig
     * @param string $templateType
     */
    public function __construct(array $themeConfig, array $viewConfig)
    {
        $this->themeConfig = $themeConfig;
        $this->viewConfig = $viewConfig;



        dd($viewConfig['template']);

    }


    /**
     * @param string $layout
     * @param string $template
     * @param mixed $data
     * @return mixed|void
     */
    public function resolve(string $layout,string $template,array|string|int|object $data=[])
    {
        $this->layout = $layout;
        $this->template = $template;
        $this->data = $data;
        if($this->updateProcess())
        {
            return true;
        }
    }

    /**

     * @return mixed|void
     */
    public function getOutput()
    {


        return '';
    }

    protected function updateProcess()
    {

        $this->layoutFilter = new LayoutFilter($this->themeConfig,$this->layout,$this->viewConfig);
        echo $this->layoutFilter->getCleanLayout();

//        $this->templateFilter = new TemplateFilter();

    }


}