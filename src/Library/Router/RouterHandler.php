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
    protected const API_GROUP='_API';
    protected const DEFAULT_REDIRECT_GROUP='_REDIRECT';
    protected const PLATFORM_GROUP='_PLATFORM';
    public static RouterHandler $router;
    protected Request $request;
    protected Response $response;
    protected static array $routes=[];
    protected static array $groups=[];
    protected static string $_group='';
    public static string $time_taken='';


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
        $this->loadRoutes();
       $this->dispatcher = new Dispatcher($request,$response);
    }

    abstract protected function loadRoutes():bool;






    public static function resolve()
    {
        self::$time_taken = microtime(true);
        self::$router->dispatcher->dispatch(self::$groups);
    }

    public function getTakenTime()
    {
        return self::$time_taken;
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



    public static function redirect(string $here, string $there, int $status_code=302,bool $auth=false)
    {

        $group = self::DEFAULT_REDIRECT_GROUP;
        $route = new Router();
        $route->setGroup($group);
        $getRoute = $route->add($here,self::_GET,[],$auth,$there,$status_code);
        if(self::updateGroup($getRoute))
        {
            self::$_group ='';
        }



//
    }



    public static function get(string $uri, array|object|string $callback,bool $auth =false)
    {
        $group = self::getGroup();
        $route = new Router();
        $route->setGroup($group);
        $getRoute = $route->add($uri,self::_GET,$callback,$auth);
        if(self::updateGroup($getRoute))
        {
            self::$_group ='';
        }

//        dd($getRoute);
    }


    public static function post(string $uri, array|object|string $callback,bool $auth = false)
    {
        $group = self::getGroup();
        $route = new Router();
        $route->setGroup($group);
        $getRoute = $route->add($uri,self::_POST,$callback,$auth);
        if(self::updateGroup($getRoute))
        {
            self::$_group ='';
        }
    }

    public static function put(string $uri, array|object|string $callback,bool $auth = false)
    {
        $group = self::getGroup();
        $route = new Router();
        $route->setGroup($group);
        $getRoute = $route->add($uri,self::_PUT,$callback,$auth);
        if(self::updateGroup($getRoute))
        {
            self::$_group ='';
        }
    }

    public static function delete(string $uri, array|object|string $callback,bool $auth = false)
    {
        $group = self::getGroup();
        $route = new Router();
        $route->setGroup($group);
        $getRoute = $route->add($uri,self::_DELETE,$callback,$auth);
        if(self::updateGroup($getRoute))
        {
            self::$_group ='';
        }
    }

    public static function any(string $uri, array|object|string $callback,bool $auth = false)
    {
        $group = self::getGroup();
        $route = new Router();
        $route->setGroup($group);
        $getRoute = $route->add($uri,self::_GET,$callback,$auth);
        if(self::updateGroup($getRoute))
        {
            $getRoute = $route->add($uri,self::_POST,$callback,$auth);
            if(self::updateGroup($getRoute))
            {
                $getRoute = $route->add($uri,self::_PUT,$callback,$auth);
                if(self::updateGroup($getRoute))
                {
                    $getRoute = $route->add($uri,self::_DELETE,$callback,$auth);
                    if(self::updateGroup($getRoute))
                    {
                        self::$_group ='';
                    }
                }
            }
        }
    }






    /**
     *
     *      PLAT FORM   ROU  TER
     *
     *
     *
     */









    /**
     * @param string $uri
     * @param string $musk_name
     * @param bool $auth
     */


    public static function getPlatform(string $uri, string $musk_name, bool $auth=false)
    {
//        $router = new Router();
//        $router->updatePlatform($uri,$musk_name,self::_GET,$auth);

        $group = self::PLATFORM_GROUP;
        $route = new Router();
        $route->setGroup($group);
        $getRoute = $route->add($uri,self::_GET,[],$auth,'',0,$musk_name);
        if(self::updateGroup($getRoute))
        {
            self::$_group ='';
        }
    }

    public static function postPlatform(string $uri, string $musk_name, bool $auth=false)
    {
        $group = self::PLATFORM_GROUP;
        $route = new Router();
        $route->setGroup($group);
        $getRoute = $route->add($uri,self::_POST,[],$auth,'',0,$musk_name);
        if(self::updateGroup($getRoute))
        {
            self::$_group ='';
        }
    }

    public static function putPlatform(string $uri, string $musk_name, bool $auth=false)
    {
        $group = self::PLATFORM_GROUP;
        $route = new Router();
        $route->setGroup($group);
        $getRoute = $route->add($uri,self::_PUT,[],$auth,'','',$musk_name);
        if(self::updateGroup($getRoute))
        {
            self::$_group ='';
        }
    }

    public static function deletePlatform(string $uri, string $musk_name, bool $auth=false)
    {
        $group = self::PLATFORM_GROUP;
        $route = new Router();
        $route->setGroup($group);
        $getRoute = $route->add($uri,self::_DELETE,[],$auth,'','',$musk_name);
        if(self::updateGroup($getRoute))
        {
            self::$_group ='';
        }
    }



    public static function getApi(string $uri, array|object $callback,bool $auth = false)
    {
        $group = self::API_GROUP;
        $route = new Router();
        $route->setGroup($group);
        $getRoute = $route->add($uri,self::_GET,$callback,$auth);
        if(self::updateGroup($getRoute))
        {
            self::$_group ='';
        }
    }


    public static function postApi(string $uri, array|object $callback,bool $auth = false)
    {
        $group = self::API_GROUP;
        $route = new Router();
        $route->setGroup($group);
        $getRoute = $route->add($uri,self::_POST,$callback,$auth);
        if(self::updateGroup($getRoute))
        {
            self::$_group ='';
        }
    }
    public static function putApi(string $uri, array|object $callback,bool $auth = false)
    {
        $group = self::API_GROUP;
        $route = new Router();
        $route->setGroup($group);
        $getRoute = $route->add($uri,self::_PUT,$callback,$auth);
        if(self::updateGroup($getRoute))
        {
            self::$_group ='';
        }
    }
    public static function deleteApi(string $uri, array|object $callback,bool $auth = false)
    {
        $group = self::API_GROUP;
        $route = new Router();
        $route->setGroup($group);
        $getRoute = $route->add($uri,self::_DELETE,$callback,$auth);
        if(self::updateGroup($getRoute))
        {
            self::$_group ='';
        }
    }












    // End of Class

}