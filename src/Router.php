<?php


namespace tinkle\framework;


//use Symfony\Component\HttpFoundation\Request;
//use Symfony\Component\HttpFoundation\Response;
use tinkle\framework\Exceptions\Display;
use tinkle\framework\interfaces\ControllerInterface;
use tinkle\framework\interfaces\LibraryInterface;
use tinkle\framework\interfaces\MiddlewareInterface;
use tinkle\framework\interfaces\MigrationInterface;
use tinkle\framework\interfaces\ModelInterface;
use tinkle\framework\interfaces\TinkleInterface;
use tinkle\framework\Request;
use tinkle\framework\Response;

class Router
{
    private Request $request;
    private Response $response;
    protected array $routes = [];
    protected array $paramName=[];
    protected array $params=[];
    public static Router $router;
    public  array $incomingAttributes=[];


    /**
     * Router constructor.
     * @param Request $request
     * @param Response $response
     */
    public function __construct(Request $request,Response $response)
    {
        $this->request = $request;
        $this->response = $response;

        self::$router = $this;
        $this->paramName = [];

    }


    // Routes Entry Methods

    /**
     * @param string $path
     * @param array $callback
     */
    public static function get(string $path,array $callback)
    {

        $path = self::$router->routePathAnalyzer($path);
        self::$router->routes['get'][$path]['callback'] = $callback;
        self::$router->routes['get'][$path]['param'] = self::$router->paramName ?? [];

    }

    /**
     * @param string $path
     * @param array $callback
     */
    public static function post(string $path,array $callback)
    {
        $path = self::$router->routePathAnalyzer($path);
        self::$router->routes['post'][$path]['callback'] = $callback;
        self::$router->routes['post'][$path]['param'] = self::$router->paramName;
    }

    /**
     * @param string $path
     * @param array $callback
     */
    public static function put(string $path,array $callback)
    {
        $path = self::$router->routePathAnalyzer($path);
        self::$router->routes['put'][$path]['callback'] = $callback;
        self::$router->routes['put'][$path]['param'] = self::$router->paramName;
    }

    /**
     * @param string $path
     * @param array $callback
     */
    public static function delete(string $path,array $callback)
    {
        $path = self::$router->routePathAnalyzer($path);
        self::$router->routes['delete'][$path]['callback'] = $callback;
        self::$router->routes['delete'][$path]['param'] = self::$router->paramName;
    }



    public static function api(string $path,array $callback)
    {


    }






    // Finally Call Routes For Action

    public function resolve()
    {

            if(self::$router->match())
            {
                if($this->checkAndPrepareForResolve())
                {



                    $callback =$this->params['callback'] ?? false;
                    $methods = $this->params ?? false; unset($methods['callback']);
                    $this->setIncomingAttributes($methods);

                    $this->dispatch($callback,$methods);
                }else{
                    echo "Error: Found UnReadable Router Configuration For This URL";
                }


            }else{
                echo "Not Match";
            }
    }


    /**
     * @param $callback
     * @param $methods
     * @return mixed|void
     */
    protected function dispatch($callback, $methods)
    {
        try{

                if(is_callable($callback))
                {
                        if($callback === false){
                            throw new Display('Request Not Found',404);
                        }
                        if(is_string($callback)){
                            return Tinkle::$app->view->renderView($callback);
                        }

                        // load methods and make instance of class
                        if(is_array($callback))
                        {

                                // Create Controller Instance
                                /** @var $controller \tinkle\framework\Controller */
                                $controller= new $callback[0];
                                Tinkle::$app->controller = $controller;
                                $controller->action = $callback[1];
                                $callback[0] = $controller;





                            //Check For Middlewares
                            foreach($controller->getMiddlewares() as $middleware)
                            {
                                $middleware->execute();
                            }
                        }

                        /**
                         * $this->request argument help us to use Request $request in class method.
                         *still missing error for missing request method.like get have but post none
                         */

                        if($this->verifyClass($callback))
                        {
                            return call_user_func($callback,$this->request,$this->response);
                        }else{
                            throw new Display("$callback[0] -This Not Supported By Tinkle",503);
                        }




                }else{
                    throw new Display("Given Class/Method/Function Details Calling Failed!",503);
                }

        }catch (Display $e){
            $e->WrongTypeParameter();
        }
    }





    /**
     *  NOW PRIVATE METHODS OF ROUTES ARE IMPLEMENTS HERE
     * YOU CAN REFACTORING BELLOW PROCESS
     * BASICALLY ALL METHODS ARE PRIVATE OR PROTECTED MOOD
     * JUST FOR THIS CLASS IT SELF
     */


    /**
     * @return string|string[]|null
     */
    private function getCleanPathInfo()
    {
        return preg_replace('/^\//', '', $this->request->getRequestUrl());
    }

    /**
     * @return string
     */
    private function getCleanMethod()
    {
        return $this->request->getMethod();
    }



    /**
     * ROUTER ENTRY HELPERS
     * **********************************************************
     * **********************************************************
     */


    /**
     * @param string $path
     * @return string
     */
    private function routePathAnalyzer(string $path)
    {
        self::$router->paramName = [];
        $path = $this->preparePath($path);
        $path = str_replace("{id}","{id:\d+}",$path);

        // Convert The Route To A Regular Expression, Escaping Forward Slashes
        $path = preg_replace('/\//','\\/',$path);
        // Convert Variable e.g. {Controller} , Convert into Captcha Group [Normal {word}]
        $path = preg_replace('/\{([a-z]+)\}/','(?P<\1>[a-z-]+)',$path);

        // Convert Variable e.g. {Controller} , Convert into Captcha Group [Normal {word_89_pr5o}]
        $path = preg_replace('/\{(\w+)}/','(?P<\1>[\w+]+)',$path);

        // Convert variables with custom regular expression for e.g. {id:/d+}
        $path = preg_replace('/\{([a-z]+):([^\}]+)\}/','(?P<\1>\2)', $path);
        // Add start and end delimiters, and case insensitive flag.
        $path = '/^' . $path . '$/i';

        return $path;

    }


    /**
     * @param string $path
     * @return string
     */
    private function preparePath(string $path)
    {
        if(preg_match_all('/{[a-z]+}/',$path,$matches))
        {

            $this->paramName = array_shift($matches);
            foreach ($this->paramName as $key =>$value)
            {
                $this->paramName[$key] = str_replace('{','',$value);
                $this->paramName[$key] = str_replace('}','',$this->paramName[$key]);
            }

        }

        if(preg_match_all('/{\w+}/',$path,$matches))
        {
            $this->paramName = array_shift($matches);

            foreach ($this->paramName as $key =>$value)
            {
                $this->paramName[$key] = str_replace('{','',$value);
                $this->paramName[$key] = str_replace('}','',$this->paramName[$key]);
            }
        }

        return $path;
    }






    /**
     *  ROUTER RESOLVING AND DISPATCHING HELPERS
     * **********************************************************
     * **********************************************************
     */



    /**
     * @return bool
     */
    public function match()
    {

        $url = $this->getCleanPathInfo();
        $method = $this->getCleanMethod();
        if(array_key_exists($method,$this->routes))
        {
            foreach ($this->routes[$method] as $route => $params) {

                if (preg_match($route, $url, $matches)) {
                    foreach ($matches as $key => $match) {
                        if (is_string($key)) {
                            $params[$key] = $match;

                        }

                    }

                    $this->params = $params;

                    return true;
                }

            }

            return false;
        }else{

            return false;
        }
    }


    /**
     * @return bool
     */
    public function checkAndPrepareForResolve()
    {

        if(count($this->params['param'])+2 == count($this->params))
        {

            $check =0;
            foreach ($this->params['param'] as $attribute)
            {
                if(array_key_exists($attribute,$this->params))
                {
                    $check += 1;
                }
            }
            if($check == count($this->params['param']))
            {
                unset($this->params['param']);

                return true;
            }

            return false;
        }

        return false;
    }



    // For Data Manipulations

    private function setIncomingAttributes(array $methods)
    {
        $this->incomingAttributes = $methods;

    }





    private function verifyClass($callback)
    {
        if(new $callback[0] instanceof ControllerInterface)
        {
            return true;
        }elseif(new $callback[0] instanceof LibraryInterface)
        {
            return true;
        }elseif (new $callback[0] instanceof ModelInterface)
        {
            return true;
        }elseif (new $callback[0] instanceof MiddlewareInterface)
        {
            return true;
        }elseif(new $callback[0] instanceof TinkleInterface)
        {
            return true;
        }elseif(empty(class_implements(new $callback[0]))) // Not Working Because Magic of Composer ; Only work for Controllers
        {
            return false;
        }else{
            return false;
        }


    }









    // END OF CLASS

}