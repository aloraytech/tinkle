<?php


namespace Tinkle\Library\Router;



use App\Controllers\AppController;
use Tinkle\Exceptions\Display;
use Tinkle\Library\Essential\Essential;
use Tinkle\Request;
use Tinkle\Response;
use Tinkle\Tinkle;

class Dispatcher
{

    protected array $routes=[];
    protected const DEFAULT_GROUP='_WEB';
    protected Request $request;
    protected Response $response;
    protected string $_current_url='';
    protected string $_current_method='';
    protected array $_current_route=[];
    protected array $params = [];
    protected array $_groups =[];
    protected static array $_callback=[];
    protected static object $_closure;


    /**
     * Dispatcher constructor.
     * @param Request $request
     * @param Response $response
     * @param array $routes
     */
    public function __construct(Request $request,Response $response)
    {
        $this->request = $request;
        $this->response = $response;
        $this->_current_url =  preg_replace('/^\//', '', $this->request->getRequestUrl());
        $this->_current_method = strtoupper($this->request->getMethod());

    }




    public function dispatch(array $routes_group)
    {
        $this->_groups = $routes_group;
        if($this->match())
        {
            $this->send();
        }
    }




    protected function match()
    {

        $this->_current_route = $this->getMatchingCurrentRouteFromGroup($this->_groups);

        //dd($this->_current_route);

        if($this->_current_route != null)
        {
            foreach ($this->_current_route as $key => $value)
            {
                if(is_array($value['callback']))
                {
                    foreach ($value as $v_key => $val)
                    {
                        if($v_key === 'param')
                        {
                            $this->_current_route[$key][$v_key] = $this->params;
                        }
                        if($v_key === 'callback')
                        {
                            self::$_callback =  $val;
                        }
                    }
                }

                if(is_object($value['callback']))
                {


                    if($value['callback'] instanceof \Closure)
                    {
                       // dd($value['callback']);
                        self::$_closure =  \Closure::fromCallable($value['callback']);
                        self::$_callback['callback'] = self::$_closure;
                    }else{
                        echo "Here";
                    }





                    if(is_array($value['param']))
                    {
                        foreach ($value as $v_key => $val)
                        {
                            if($v_key === 'param')
                            {
                                $this->_current_route[$key][$v_key] = $this->params;
                                $this->_current_route[$key]['callback'] = self::$_closure;
                                self::$_callback['param'] = $this->params;
                            }

                        }
                    }
                }

            }

            return true;
        }
        return false;

    }






    protected function getMatchingCurrentRouteFromGroup(array $groups)
    {
        if(is_array($groups))
        {
            // Filter According Request Method Like GET, POST,PUT etc.
            if(array_key_exists($this->_current_method,$groups))
            {
                // Now Only Take Matched Method Group From All Groups
                $availableRoutes = $groups[$this->_current_method];
                // Now Check Any Group Name Exist As Namespace
                $urlParts = $this->getParts();

                if(array_key_exists(strtoupper($urlParts[0]),$availableRoutes))
                {
                    // Lets step forward [GROUP CALL]
                    $availableRoutes = $groups[$this->_current_method][strtoupper($urlParts[0])];
                    $this->_current_route = $this->getCurrentRoute($availableRoutes);

                    return $this->_current_route;

                }else{
                    // LETS STEP FORWARD [_WEB CALL]
                    $availableRoutes = $groups[$this->_current_method][self::DEFAULT_GROUP];
                    $this->_current_route = $this->getCurrentRoute($availableRoutes);

                    return $this->_current_route;
                }

                return null;

            }
        }
    }



    protected function getCurrentRoute($availableRoutes)
    {
        try{
           // dd($availableRoutes);
            if(is_array($availableRoutes))
            {

                foreach ($availableRoutes as $uri => $route)
                {
                    if(is_array($route))
                    {

                        if(preg_match($uri,$this->_current_url,$matches))
                        {

                            $this->_current_route [$uri] = $route;
                            $params = [];
                            foreach ($matches as $_key => $match) {
                                if (is_string($_key)) {
                                    $params[$_key] = $match;
                                }

                            }

                            $this->params = $params;
                            $this->_current_route [$uri]['param'] = $this->params;
                        }
                    }

                }



                if(!empty($this->_current_route))
                {
                    return $this->_current_route;
                }else{
                    throw new Display("No Valid Route Found For This Url",Display::HTTP_SERVICE_UNAVAILABLE);
                }

            }
            return null;


        }catch (Display $e)
        {
            $e->Render();
        }
    }



    protected function getParts()
    {
        return explode('/',$this->_current_url);
    }





    protected function send()
    {

        try{
           //dd($this->_current_route);
           foreach ($this->_current_route as $route)
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
           }











        }catch (Display $e){
            $e->Render();
        }


    }










}