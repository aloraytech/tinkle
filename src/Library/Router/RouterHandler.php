<?php


namespace Tinkle\Library\Router;


use Tinkle\Exceptions\Display;
use Tinkle\Request;
use Tinkle\Response;

abstract class RouterHandler
{




    protected const _GET='GET';
    protected const _POST='POST';
    protected const _PUT='PUT';
    protected const _DELETE='DELETE';
    protected const DEFAULT_GROUP='_WEB';
    public static RouterHandler $router;
    protected Request $request;
    protected Response $response;
    protected static array $routes=[];
    protected static array $groups=[];

    protected static string $_group='';
    /**
     * @var Dispatcher
     */
    private Dispatcher $dispatcher;


    /**
     * RouterHandler constructor.
     * @param Request $request
     * @param Response $response
     */
    public function __construct(Request $request,Response $response)
    {
        self::$router = $this;
        $this->request = $request;
        $this->response = $response;
       $this->dispatcher = new Dispatcher($request,$response);
    }


    public static function group(string $group_name)
    {
        self::$_group=$group_name;
        //return new Router($group_name);
        return self::$router;

    }


    protected static function getGroup()
    {
        if(!empty(self::$_group))
        {
            return self::$_group;
        }else{
            return self::DEFAULT_GROUP;
        }
    }


    /**
     * @param array $routes
     * @return bool
     */
    protected static function updateGroup(array $routes)
    {
        try{

            if(is_array($routes))
            {
                foreach ($routes as $key => $value)
                {
                    if(is_array($value))
                    {
                        foreach ($value as $v_key => $val)
                        {
                            if(is_array($val))
                            {
                                foreach ($val as $valKey => $details)
                                {
                                    self::$groups [strtoupper($key)][strtoupper($v_key)][$valKey] = $details;
                                    return true;
                                }
                            }

                        }
                    }
                }
            }else{
                throw new Display("Routes Must be Array When Updating Group",Display::HTTP_SERVICE_UNAVAILABLE);
            }

        }catch (Display $e)
        {
            $e->Render();
        }

    }







    public static function get(string $uri, array|object $callback)
    {
        $group = self::getGroup();
        $route = new Router($group);
        $getRoute = $route->add($uri,$callback,self::_GET);
        if(self::updateGroup($getRoute))
        {
            self::$_group ='';
        }

//        dd($getRoute);
    }


    public static function post(string $uri, array|object $callback)
    {
        $group = self::getGroup();
        $route = new Router($group);
        $getRoute = $route->add($uri,$callback,self::_POST);
        if(self::updateGroup($getRoute))
        {
            self::$_group ='';
        }
    }

    public static function put(string $uri, array|object $callback)
    {
        $group = self::getGroup();
        $route = new Router($group);
        $getRoute = $route->add($uri,$callback,self::_PUT);
        if(self::updateGroup($getRoute))
        {
            self::$_group ='';
        }
    }

    public static function delete(string $uri, array|object $callback)
    {
        $group = self::getGroup();
        $route = new Router($group);
        $getRoute = $route->add($uri,$callback,self::_DELETE);
        if(self::updateGroup($getRoute))
        {
            self::$_group ='';
        }
    }








    public static function resolve()
    {
        //dd(self::$groups);
        self::$router->dispatcher->dispatch(self::$groups);
    }




    // End of Class

}