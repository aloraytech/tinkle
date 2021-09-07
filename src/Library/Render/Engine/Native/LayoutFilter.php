<?php


namespace Tinkle\Library\Render\Engine\Native;


use Tinkle\Tinkle;

class LayoutFilter
{
    protected object $theme;
    protected string $themeDir='';
    protected array $allCss=[];
    protected array $allJs=[];
    protected array $allMedia=[];
    protected array $info=[];
    protected bool $frontend=false;
    protected bool $backend=false;

    protected string $layout='';
    protected string $type='';


    /**
     * LayoutFilter constructor.
     * @param array $themeConfig
     * @param string $layout
     * @param array $viewConfig
     */
    public function __construct(array $themeConfig,string $layout,array $viewConfig)
    {

        $this->theme = $themeConfig['theme'];
        $this->themeDir = $themeConfig['dir'];
        $this->allCss = $themeConfig['css'];
        $this->allJs = $themeConfig['js'];
        $this->allMedia = $themeConfig['media'];
        $this->info = $themeConfig['info'];
        $this->frontend = $themeConfig['frontend'];
        $this->backend = $themeConfig['backend'];
        $this->type = $viewConfig['type'];

        if(file_exists($layout) && is_readable($layout))
        {
            $this->layout = file_get_contents($layout);

        }

    }


    public function getCleanLayout()
    {
        $this->check();
        return $this->layout;
    }


    private function check()
    {
        $this->updateMetaCSRF();
        $this->updateFavicon();
        $this->updateTitle();
        $this->updateCSS();
        $this->updateJS();
    }

    private function updateMetaCSRF()
    {
        $tag = '<meta name="csrf-token" content="8NJENTCuvQT9JMvUjV7T3H7SrEHoakgCDZTQn6Nq">';
        if(preg_match('/@CSRF/',$this->layout,$matches))
        {
            $this->layout = str_replace("@CSRF",$tag,$this->layout);
        }
    }

    private function updateFavicon()
    {

        $favicon = Tinkle::$ROOT_DIR."public/assets/favicon.png";
        if(!file_exists($favicon))
        {
            // Make One For Client
            $favicon = $this->getDefaultFavicon();
        }


        $tag = '<link rel="icon" href="'.Tinkle::$app->request->getFullUrl()."/assets/favicon.png".'" sizes="16x16" type="image/png">';

        if(preg_match('/@FAVICON/',$this->layout,$matches))
        {
            $this->layout = str_replace("@FAVICON",$tag,$this->layout);
        }



    }

    private function updateTitle()
    {
    }

    private function updateCSS()
    {
    }

    private function updateJS()
    {
    }

    private function getDefaultFavicon()
    {
        return 'wait';
    }


}