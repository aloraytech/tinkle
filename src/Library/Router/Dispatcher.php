<?php


namespace Tinkle\Library\Router;


use Tinkle\Library\Platform\Platform;
use App\Controllers\AppController;
use Tinkle\Exceptions\Display;
use Tinkle\Library\Essential\Essential;
use Tinkle\Request;
use Tinkle\Response;
use Tinkle\Tinkle;
use Tinkle\View;

class Dispatcher
{

    protected array $routes=[];
    protected const DEFAULT_GROUP='_WEB';
    protected const DEFAULT_REDIRECT_GROUP='_REDIRECT';
    protected const API_GROUP='_API';
    protected const PLATFORM_GROUP='_PLATFORM';
    protected Request $request;
    protected Response $response;
    protected string $_current_url='';
    protected string $_current_method='';
    protected array $_current_route=[];
    protected string $_current_platform='';
    protected array $params = [];
    protected array $_groups =[];
    protected static array $_callback=[];
    protected static object $_closure;
    protected static int $redirectStatus=302;
    protected static int $dispatchType=0;
    protected static array $platform=[];

    /**
     * Dispatcher constructor.
     * @param Request $request
     * @param Response $response
     */
    public function __construct(Request $request,Response $response)
    {
        $this->request = $request;
        $this->response = $response;
        $this->_current_url =  @preg_replace('/^\//', '', $this->request->getRequestUrl());
        $this->_current_method = @strtoupper($this->request->getMethod());

    }




    public function dispatch(array $routes_group)
    {

        $this->_groups = $routes_group;

        $matcher = new Matcher($routes_group,$this->_current_url,$this->_current_method);
        $this->_current_route = $matcher->findOrFail() ??[];
        if(!empty($this->_current_route))
        {
            $currentGroup = $this->detectCurrentGroup();

            foreach ($this->_current_route as $route)
            {
                switch ($currentGroup) {
                    case self::API_GROUP:
                        $this->apiDispatcher($route);
                        break;
                    case self::PLATFORM_GROUP:
                        $this->platformDispatcher($route);
                        break;
                    case self::DEFAULT_REDIRECT_GROUP:
                        $this->redirectDispatcher($route);
                        break;
                    default:
                        $this->groupDispatcher($route);
                }

            }



        }else{
            throw new Display('Request Not Found',Display::HTTP_SERVICE_UNAVAILABLE);
        }


    }




    private function detectCurrentGroup()
    {
        if(!empty($this->_current_route))
        {
            foreach ($this->_current_route as $uri => $value)
            {
               return $value['group'];
            }
        }
    }


    protected function apiDispatcher(array $route)
    {
        try{
            $callback = $route['callback'];
            if(is_object($callback))
            {
                $this->lambdaDispatcher($route);
            }elseif(is_string($callback)){
                $this->defaultDispatcher($route);
            }elseif($callback === false){
                throw new Display('Request Not Found',404);
            }else{

                if(is_array($callback))
                {
                    if($route['callback'][0] instanceof \Closure)
                    {
                        $this->lambdaDispatcher($route);
                    }else{
                        // Create Controller Instance
                        /** @var \App\Controllers $controller */
                        $controller= new $callback[0]();
                        Tinkle::$app->controller = $controller;
                        $controller->action = $callback[1];
                        $callback[0] = $controller;

                        //Check For Middlewares
                        foreach($controller->getMiddlewares() as $middleware)
                        {
                            $middleware->execute();
                        }

                         call_user_func($callback,$this->request,$this->response);
                        $result = $callback[0]->getResult();
                        if(!empty($result))
                        {
                            //SEND RESULT OR DISPLAY AS JSON RESPONSE
                            $this->response->sendJson($result);
                        }else{
                            throw new Display('Api Have No Return Value As Result',Display::HTTP_SERVICE_UNAVAILABLE);
                        }

                    }
                }
            }


        }catch (Display $e)
        {
            $e->Render();
        }



    }

    protected function platformDispatcher(array $route)
    {
        try{
            if(empty($route['callback']))
            {

                if(!empty($route['mask']))
                {
                    $platformObject = new Platform($this->request,$this->response,$route['mask']);
                    $platformObject->resolve();
                }
            }


        }catch (Display $e)
        {
            $e->Render();
        }
    }



    protected function redirectDispatcher(array $route)
    {
        try{
            $callback = $route['callback'];
            if(is_object($callback))
            {
                $this->lambdaDispatcher($route);
            }elseif(is_string($callback)){
                $this->defaultDispatcher($route);
            }elseif($callback === false){
                throw new Display('Request Not Found',404);
            }else{

                if(empty($callback))
                {
                    if(!empty($route['redirectTo']) && !empty($route['redirectStatus']))
                    {
                        Tinkle::$app->response->redirect($route['redirectTo'],$route['redirectStatus']);
                    }else{
                        throw new Display('Redirection For This URL  Is Wrongly Configured',Display::HTTP_SERVICE_UNAVAILABLE);
                    }

                }
            }


        }catch (Display $e)
        {
            $e->Render();
        }
    }






    protected function groupDispatcher(array $route)
    {

        try{
            $callback = $route['callback'];
            if(is_object($callback))
            {
                $this->lambdaDispatcher($route);
            }elseif(is_string($callback)){
                $this->defaultDispatcher($route);
            }elseif($callback === false){
                throw new Display('Request Not Found',404);
            }else{

                if(is_array($callback))
                {
                    if($route['callback'][0] instanceof \Closure)
                    {
                        $this->lambdaDispatcher($route);
                    }else{
                        // Create Controller Instance
                        /** @var \App\Controllers $controller */
                        $controller= new $callback[0]();
                        Tinkle::$app->controller = $controller;
                        $controller->action = $callback[1];
                        $callback[0] = $controller;

                        //Check For Middlewares
                        foreach($controller->getMiddlewares() as $middleware)
                        {
                            $middleware->execute();
                        }

                        return call_user_func($callback,$this->request,$this->response);
                    }
                }
            }


        }catch (Display $e)
        {
            $e->Render();
        }

    }





    protected function defaultDispatcher(array $route)
    {
        if(is_string($route['callback']))
        {
            return Tinkle::$app->view->render::display($route['callback']);
        }
    }


    protected function lambdaDispatcher(array $route)
    {

        $callback = $route['callback'];
        if($callback[0] instanceof \Closure)
        {
            $cloner = new Cloner($callback);
            return $cloner->resolve($route['param']??[]);

        }
    }













    protected function send()
    {

        try{

           foreach ($this->_current_route as $route)
           {
               if(self::$dispatchType !=1)
               {
                   if(!is_object($route['callback']))
                   {
                       $callback = $route['callback'];
                       if($callback === false){
                           throw new Display('Request Not Found',404);
                       }
                       if(is_string($callback)){
                           return Tinkle::$app->view->display($callback);
                       }

                       if(is_array($callback))
                       {
                           if($route['callback'][0] instanceof \Closure)
                           {
                               $cloner = new Cloner($callback);
                               $cloner->resolve($route['param']??[]);

                           }else{
                               // Create Controller Instance
                               /** @var \App\Controllers $controller */
                               $controller= new $callback[0]();
                               Tinkle::$app->controller = $controller;
                               $controller->action = $callback[1];
                               $callback[0] = $controller;

                               //Check For Middlewares
                               foreach($controller->getMiddlewares() as $middleware)
                               {
                                   $middleware->execute();
                               }

                               return call_user_func($callback,$this->request,$this->response);
                           }


                       }
                   }else{
                       $callback = $route['callback'];
                       if(is_object($callback))
                       {
                           $cloner = new Cloner($callback);
                           $cloner->resolve($route['param']??[]);

                       }
                   }
               }else{
                   // Redirect Case

                   Tinkle::$app->response->redirect($route['callback'],$route['param']);
               }
           }











        }catch (Display $e){
            $e->Render();
        }


    }




}