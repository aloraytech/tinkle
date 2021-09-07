<?php


namespace Tinkle\Library\Render;



use Tinkle\Event;
use Tinkle\Library\Render\Engine\Engine;
use Tinkle\Library\Render\Engine\Native\NativeEngine;
use Tinkle\Library\Render\Engine\Twig\TwigEngine;
use Tinkle\Library\Render\Themes\Themes;
use Tinkle\Request;
use Tinkle\Response;
use Tinkle\Tinkle;
use Tinkle\View;

abstract class Render
{


    public static Render $render;
    public Themes $theme;
    public Engine $engine;
    protected Request $request;
    protected Response $response;

    protected array|object|string|int $config;
    protected string $output ='';
    private static bool $isStepByStep=false;
    private static string|int|array $content;
    protected TemplateHandler $templateHandler;

    protected string|array|object $current_config;



    /**
     * Render constructor.
     * @param Request $request
     * @param Response $response
     */
    public function __construct(Request $request, Response $response)
    {
        self::$render = $this;
        $this->config = Tinkle::$app->config['app'];

        $this->request = $request;
        $this->response = $response;




    }



    public function fetch()
    {
        self::$isStepByStep=true;
        return new RenderConfiguration();
    }




    public function output($contain='')
    {
        self::$content = $contain;

            $this->resolve();

            ob_start();
            //echo $this->output;
            echo sprintf('%s',$this->output??'');
            ob_flush();

    }

    public function resolve()
    {
        if(self::$isStepByStep)
        {
            // If Step By Step Process Setup
            $this->output = $this->prepare() ?? '';
        }else{
            // Direct Calling Without Step By Step
            if(!empty(self::$content))
            {
                if(is_string(self::$content) || !is_array(self::$content) || !is_object(self::$content)) {
                    $this->output = sprintf('<html><head></head><body><div>%s</div></body></html>', self::$content);
                }else{
                    if(is_array(self::$content))
                    {
                        $this->output = sprintf('<html><head></head><body>%s</body></html>',implode(';',self::$content));
                    }
                }
            }else{
                $this->output = "<html><head></head><body><h1>This is Your Default Empty Tinkle View.</h1></body></html>";
            }

        }
        return $this->output;

    }



    private function prepare()
    {
        $this->current_config = RenderConfiguration::getViewConfig();
        $this->theme = new Themes($this->current_config);
        $themeConfig = $this->theme->getAll();
        if(isset($themeConfig['theme']) && !empty($themeConfig['theme'])){
            if(is_array($themeConfig) && !empty($themeConfig))
            {
                $this->templateHandler = new TemplateHandler($themeConfig,$this->current_config);
                if($this->templateHandler->resolve())
                {
                    $this->output = $this->templateHandler->getOutput();
                }
                return $this->output;
            }
        }


    }














// Class End

}