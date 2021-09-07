<?php


namespace Tinkle\Library\Render\Themes;



use Tinkle\interfaces\ThemeInterface;
use Tinkle\Library\Render\Engine\Engine;
use Tinkle\Library\Render\Render;
use Tinkle\Library\Render\RenderConfiguration;
use Tinkle\Tinkle;
use Tinkle\View;

class Themes
{
    private const DEFAULT_THEME = "Themes\DefaultTheme\DefaultTheme";
    private const DEFAULT_THEME_METHOD='getInfo';
    protected array $config;
    protected object $theme;
    protected string|array $template;
    protected string $layout;
    protected string $thmDir='';





    public function __construct(array $current_config)
    {
        $this->config = $current_config;
        $this->process();
    }

    public function getAll()
    {

        return [
            'theme' => $this->theme ??'',
            'layout'=> $this->layout ?? '',
            'template'=> $this->template ?? '',
            'dir'=> $this->thmDir?? '',
            'engine'=> $this->theme->getTemplateEngine() ?? Engine::NATIVE_ENGINE,
            'css'=> $this->theme->getAvailableCss() ?? [],
            'js'=> $this->theme->getAvailableJs() ?? [],
            'media'=> $this->theme->getAvailableMedia() ?? [],
            'info'=> $this->theme->getInfo() ?? [],
            'config'=> $this->theme->getConfig() ?? [],
            'frontend'=> $this->theme->isFrontend() ?? false,
            'backend'=> $this->theme->isBackend() ?? false,
        ];

    }


    private function process()
    {
        if($this->loadTheme())
        {
            if($this->findOrFailTemplate())
            {
                if(!empty($this->template))
                {
                    return true;
                }
            }
        }
    }


    private function loadTheme()
    {
        // First Check Theme File From Root Location
        $thmFile = Tinkle::$ROOT_DIR."resources/themes/".$this->config['theme']."/".$this->config['theme'].".php";
        if(file_exists($thmFile))
        {
            $thmClass = "Themes\\".ucfirst($this->config['theme'])."\\".ucfirst($this->config['theme']);
            $this->thmDir = Tinkle::$ROOT_DIR."resources/themes/";
        }else{

            // Now Check For Public Folder For Theme
            $thmFile = Tinkle::$ROOT_DIR."public/resources/themes/".$this->config['theme']."/".$this->config['theme'].".php";
            if(file_exists($thmFile))
            {
                require_once "$thmFile";
                $thmClass = "Themes\\".ucfirst($this->config['theme'])."\\".ucfirst($this->config['theme']);
                $this->thmDir = Tinkle::$ROOT_DIR."public/resources/themes/";
            }else{

                // Load Default Theme File
                $thmClass = self::DEFAULT_THEME;
                $this->thmDir = Tinkle::$ROOT_DIR."resources/themes/";
            }
        }
        $this->theme = new $thmClass();
        if(is_callable([$this->theme,self::DEFAULT_THEME_METHOD]))
        {
            if($this->theme instanceof ThemeInterface)
            {
                return true;
            }else{
                return false;
            }

        }else{
            return false;
        }
    }


    private function findOrFailTemplate()
    {
        $availablePages = $this->theme->getAvailablePages();
        $templateName = $this->getTemplateName();

        foreach ($availablePages as $type => $pages)
        {
            if(strtolower($type) === strtolower($templateName[0]))
            {
                if(is_array($pages))
                {
                    foreach ($pages as $key => $value)
                    {
                        if(strtolower($key) === strtolower($templateName[1]))
                        {
                            if(file_exists($value) && is_readable($value))
                            {
                                $this->template = $value;
                            }

                        }
                    }

                }
            }

        }

        // Now Also Take Define Layout If Provide

        if(isset($availablePages['layout']))
        {
            foreach ($availablePages['layout'] as $type => $value)
            {
                if(strtolower($templateName[0]) === strtolower($type))
                {
                    $this->layout = $value;
                }
            }
        }



        return $this->template;

    }



    private function getTemplateName()
    {
        if(preg_match('/^([a-z]+|[A-Z]+)\/([a-z]+|[A-Z]+)/',$this->config['template'],$matches))
        {
            if(!empty($matches))
            {
                $this->template = explode('/',$this->config['template']);
            }
        }elseif (preg_match('/^([a-z]+|[A-Z]+).([a-z]+|[A-Z]+)/',$this->config['template'],$matches))
        {
            if(!empty($matches))
            {
                $this->template = explode('.',$this->config['template']);
            }
        }else{
            $this->template = [];
        }
        return $this->template;
    }








    // Class End here


}

