<?php


namespace Tinkle\Library\Render;


use Tinkle\Library\Render\Config\Config;
use Tinkle\Library\Render\Resolver\ViewResolver;
use Tinkle\Request;
use Tinkle\Response;

class ViewHandler
{

    private static ViewHandler $view;
    public Request $request;
    public Response $response;
    public static array $layoutContent=[];
    public string $template='_default/index';
    protected static ViewResolver $resolver;
    protected static array|object $viewConfig=[];


    /**
     * ViewHandler constructor.
     * @param Request $request
     * @param Response $response
     */
    public function __construct(Request $request, Response $response)
    {
        self::$view = $this;
        $this->request = $request;
        $this->response = $response;

    }



    // Predefine Page Parameters And Views
    // ||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||

    public function setLayoutParams(string $content, array|string|object $parameters)
    {
        self::$layoutContent[$content]=$parameters;
    }

    // ||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
    public static function json($content)
    {
        return json_encode($content);
    }


    public static function handle(string|array|object|int $content,array $settings)
    {
        self::$viewConfig = $settings??[];
        self::display($content);
    }

    // Accessor For Generate Views
    // ||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
    public static function display(string|array|object|int $content)
    {
        self::$resolver = new ViewResolver(self::$viewConfig,self::$layoutContent);
        if($content = self::$resolver->resolve($content))
        {

            ob_start();
            echo $content;
            ob_flush();
        }
    }




    public function render(string $template='',string $theme='')
    {
        Config::$template = $template;
        Config::$theme = $theme;
        return new Config();
    }





}