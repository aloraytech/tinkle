<?php


namespace Tinkle\Library\Router;

use http\Exception;
use Tinkle\Exceptions\Display;

class Router
{



    protected string $url='';
    protected array $callback=[];
    protected string $method='';
    protected string $group='';
    public static array $platformRoutes = [];
    protected array $routes = [];
    protected static array $_param=[];
    protected const DEFAULT_GROUP='_WEB';
    protected const DEFAULT_REDIRECT_GROUP='_REDIRECT';
    protected Platform $platform;
    public static Router $router;

    /**
     * Router constructor.
     * @param string $url
     * @param array $callback
     * @param string $method
     * @param string $group
     */
    public function __construct()
    {

        self::$_param = [];
        self::$router = $this;

    }

    public function setGroup(string $group)
    {
        $this->group = $group;
    }


    public function updatePlatform(string $uri, string $musk_name,string $method)
    {
        if(isset(self::$platformRoutes[$method][$uri]))
        {
            unset(self::$platformRoutes[$method][$uri]);
            self::$platformRoutes[$method][$this->buildUri($uri)] = $musk_name;
        }else{
            self::$platformRoutes[$method][$this->buildUri($uri)] = $musk_name;
        }
    }

    public static function getPlatform(string $method='')
    {
        if(empty($method))
        {
            return self::$platformRoutes;
        }else{
            if(isset(self::$platformRoutes[$method]))
            {
                return self::$platformRoutes[$method];
            }
        }


    }




    public function add(string $uri, array|object $callback,string $method)
    {



        if(strtoupper($this->group) === self::DEFAULT_GROUP)
        {
            $this->routes[$method][$this->group][$this->buildUri($uri)] ['callback'] = $this->buildCallback($callback);
            $this->routes[$method][$this->group][$this->buildUri($uri)] ['param'] = self::$_param;
        }elseif (strtoupper($this->group) === self::DEFAULT_REDIRECT_GROUP)
        {
            $this->routes[$method][$this->group][$this->buildUri($uri)] ['callback'] = $callback[0];
            $this->routes[$method][$this->group][$this->buildUri($uri)] ['param'] = $callback[1];

        }else{
            $this->routes[$method][$this->group][$this->buildUri(strtolower($this->group).'/'.$uri)] ['callback'] = $this->buildCallback($callback);
            $this->routes[$method][$this->group][$this->buildUri(strtolower($this->group).'/'.$uri)] ['param'] = self::$_param;

        }


        return $this->routes;
    }




    private function buildUri(string $uri)
    {
        try{
            $uri = $this->prepareUri($uri);
            $uri = str_replace("{id}","{id:\d+}",$uri);

            // Convert The Route To A Regular Expression, Escaping Forward Slashes
            $uri = preg_replace('/\//','\\/',$uri);
            // Convert Variable e.g. {Controller} , Convert into Captcha Group [Normal {word}]
            $uri = preg_replace('/\{([a-z]+)\}/','(?P<\1>[a-z-]+)',$uri);

            // Convert Variable e.g. {Controller} , Convert into Captcha Group [Normal {word_89_pr5o}]
            $uri = preg_replace('/\{(\w+)}/','(?P<\1>[\w+]+)',$uri);

            // Convert variables with custom regular expression for e.g. {id:/d+}
            $uri = preg_replace('/\{([a-z]+):([^\}]+)\}/','(?P<\1>\2)', $uri);
            // Add start and end delimiters, and case insensitive flag.
            $uri = '/^' . $uri . '$/i';

            return $uri;
        }catch (Display $e)
        {
            $e->Render();
        }

    }


    private function prepareUri(string $uri)
    {
        try{
            // get params from given uri

            if(preg_match_all('/{[a-z]+}/',$uri,$matches))
            {

                self::$_param = array_shift($matches);
                foreach (self::$_param as $key =>$value)
                {
                    self::$_param[$key] = str_replace('{','',$value);
                    self::$_param[$key] = str_replace('}','',self::$_param[$key]);
                }

            }

            if(preg_match_all('/{\w+}/',$uri,$matches))
            {
                self::$_param = array_shift($matches);

                foreach (self::$_param as $key =>$value)
                {
                    self::$_param[$key] = str_replace('{','',$value);
                    self::$_param[$key] = str_replace('}','',self::$_param[$key]);
                }
            }
            return $uri;
        }catch (Display $e)
        {
            $e->Render();
        }
    }



    protected function buildCallback(array|object $callback)
    {
        if(!empty($callback))
        {
            if(is_array($callback))
            {

                if($this->isClosure($callback[0]))
                {
//                    dd($callback[0]);
//                    if(!isset($callback[1]))
//                    {
//                        $callback[1] = \Tinkle\Middlewares\AnonymousMiddleware::class;
//                    }
                    //$tmp = new $callback[1];
//                    if(assert($tmp instanceof \Tinkle\Middleware) || assert($tmp instanceof \Tinkle\Controller))
//                    {
//                        $closure = \Closure::fromCallable($callback[0]);
//                        $callback[0] = $closure->bindTo($tmp,'static');
//                    }
                    //unset($callback[1]);
                    return $callback;
                }


                return $callback;

            }else{
                if(is_object($callback))
                {
                    // Sending Closure Callback To Execute As it Is...
                    return $callback;

                }
                return false;
            }

        }
    }

    protected function isClosure($callback)
    {
        if($callback instanceof \Closure)
        {
            return true;
        }
        return false;
    }






    // End of Class



}