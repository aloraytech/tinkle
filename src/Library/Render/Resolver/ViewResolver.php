<?php


namespace Tinkle\Library\Render\Resolver;


use Tinkle\Exceptions\Display;
use Tinkle\Library\Essential\Essential;
use Tinkle\Tinkle;

class ViewResolver
{

    protected array $config=[];
    protected array $layoutConfig=[];
    protected string $output='';
    protected string $template='';
    protected string $theme='';
    protected string $root='';

    /**
     * ViewResolver constructor.
     * @param array $config
     * @param array $layoutConfig
     */
    public function __construct(array $config,array $layoutConfig=[])
    {
        $this->config = $config;
        $this->layoutConfig = $layoutConfig;
        $this->root = Tinkle::$ROOT_DIR.'resources/views/';
    }

    public function resolve(array|object|string $content)
    {

        if(!empty($content))
        {
            if(is_object($content))
            {
                if(isset($content->template))
                {
                    $this->template = $content->template;
                    return $this->resolving();
                }else{
                    return json_encode(Essential::getHelper()->ObjectToArray($content));
                }
            }
            if (is_array($content))
            {
                if(!isset($content['template']) || !isset($content->template))
                {
                    $this->template = $content['template'];
                    return json_encode($content);
                }else{
                    return $this->resolving();
                }
            }
        }else{
            return $this->resolving();
        }

    }




    private function resolving()
    {
        if(empty($this->template))
        {
            if(isset($this->config['template']))
            {
                $this->template = $this->config['template'];
                if(isset($this->config['theme']))
                {
                    $this->theme = $this->config['theme'];
                }
            }
        }
        $this->prepareTemplate();
        $this->updateTemplate();

    }



    private function prepareTemplate()
    {
        try{

            if(!empty($this->theme))
            {
                $this->template = ucfirst($this->theme).'.'.$this->template;
            }
            $this->template = str_replace('.','/',$this->template);

            if(file_exists($this->root.$this->template.'.php'))
            {
                $this->template = file_get_contents($this->root.$this->template.'.php');
            }elseif (file_exists($this->root.$this->template.'.html'))
            {
                $this->template = file_get_contents($this->root.$this->template.'.html');
            }elseif (file_exists($this->root.$this->template.'.tinkle.php'))
            {
                $this->template = file_get_contents($this->root.$this->template.'.tinkle.php');
            }elseif (file_exists($this->root.$this->template.'.twig'))
            {
                $this->template = file_get_contents($this->root.$this->template.'.twig');
            }else{
                throw new Display("This Template : ".$this->template." Not Found",Display::HTTP_SERVICE_UNAVAILABLE);
            }


        }catch (Display $e)
        {
            $e->Render();
        }



    }




    public function updateTemplate()
    {
        dd($this->layoutConfig);
    }




}