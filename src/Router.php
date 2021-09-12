<?php
namespace Tinkle;


use Tinkle\Exceptions\Display;
use Tinkle\Library\Router\RouterHandler;

/**
 * Class Router
 * @package Tinkle
 */
class Router extends RouterHandler
{

    protected static string $route_dir;
    /**
     * Router constructor.
     * @param Request $request
     * @param Response $response
     */
    public function __construct(Request $request,Response $response)
    {
        self::$route_dir = Tinkle::$ROOT_DIR.'/routes/';
        parent::__construct($request,$response);

    }



    protected function loadRoutes():bool
    {
        require_once self::$route_dir.'platform.php';
        require_once self::$route_dir.'api.php';
        require_once self::$route_dir.'private.php';
        require_once self::$route_dir.'web.php';
        return true;
    }







    // End of Script


}