<?php


namespace Tinkle\Library\Platform;


use Tinkle\Exceptions\Display;
use Tinkle\Library\Essential\Essential;
use Tinkle\Library\Render\PlatformRender;
use Tinkle\Library\Render\Render;
use Tinkle\Library\Router\Cloner;
use Tinkle\Request;
use Tinkle\Response;
use Tinkle\Tinkle;

class Platform
{

    protected static  Platform $plat;
    protected string $namedUri='';
    protected Request $request;
    protected Response $response;
    protected PlatformManager $platformManager;
    protected array $platformRoutes=[];
    public array|object $platform;




    /**
     * Platform constructor.
     * @param Request $request
     * @param Response $response
     * @param string $namedUri
     */
    public function __construct(Request $request, Response $response, string $namedUri)
    {
        self::$plat = $this;
        $this->request = $request;
        $this->response = $response;
        $this->namedUri = $namedUri;
        $this->platformManager = new PlatformManager($this->request,$this->response,$this->namedUri,$this->platformRoutes);
    }


    public function resolve()
    {
//        $this->platformManager->resolve();
      $this->platform = $this->platformManager->resolve();

      $render = new PlatformRender($this->platform);
      $render->display();


    }



    public function dispatch()
    {
//        return Render::$render->render($this->current_template)->withModules($result)->withTheme('Master')->output();
    }















    // Platform Routes

    public static function getFront(string $uri, array $callback, bool $auth=false)
    {
       self::$plat->platformManager::add(PlatformManager::PLATFORM_GET,PlatformManager::FRONTEND,$uri,$callback,$auth);
    }

    public static function postFront(string $uri, array $callback, bool $auth=false)
    {
        self::$plat->platformManager::add(PlatformManager::PLATFORM_POST,PlatformManager::FRONTEND,$uri,$callback,$auth);
    }


    public static function getBACK(string $uri, array $callback, bool $auth=false)
    {
        self::$plat->platformManager::add(PlatformManager::PLATFORM_GET,PlatformManager::BACKEND,$uri,$callback,$auth);
    }

    public static function postBack(string $uri, array $callback, bool $auth=false)
    {
        self::$plat->platformManager::add(PlatformManager::PLATFORM_POST,PlatformManager::BACKEND,$uri,$callback,$auth);
    }




}