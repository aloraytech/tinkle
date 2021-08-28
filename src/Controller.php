<?php


namespace Tinkle;




use Tinkle\interfaces\ControllerInterface;
use Tinkle\Middlewares\SecurityMiddleware;

/**
 * Class Controller
 * @package Tinkle
 *
 */
abstract class Controller
{

    public string $layout = 'main';
    public string $action = '';
    public Request $request;

    /**
     * @var \app\core\middlewares\BaseMiddleware[]
     */
    protected array $middlewares = [];




    // ESSENTIAL PUBLIC METHODS FOR EVERY CONTROLLER

    /**
     * Controller constructor.
     */
    public function __construct()
    {
        $this->registerMiddleware(new SecurityMiddleware());
    }

    public function get_allDefineParams()
    {
        return Tinkle::$app->router->incomingAttributes ?? [];
    }

    /**
     * @param string $paramKey
     * @return array|mixed
     */
    public function get_defineParam(string $paramKey)
    {
        $all_params = $this->get_allDefineParams();
        if(is_array($all_params))
        {
            foreach ($all_params as $a_key => $value)
            {
                if($paramKey == $a_key)
                {
                    return $value;
                }
            }
        }else{
            return $all_params;
        }
    }










    public function render(string $template,array $params=[],bool $isTwig=false)
    {
        $template = str_replace('.','/',$template);
        return Tinkle::$app->view->render(trim($template),$params,$isTwig);
    }


    public function prepareView(string $template)
    {
        return View::setView($template);
    }

    public function display()
    {
        return View::getView();
    }


//    /**
//     * @param $layout
//     */
//    public function setLayout($layout)
//    {
//        $this->layout = $layout;
//    }
//
//
//
//    public function render(string $view, array $param=[])
//    {
//        return Tinkle::$app->view->renderView($view,$param);
//    }


    public function registerMiddleware(Middleware $middleware)
    {
        $this->middlewares[] = $middleware;
    }






    /**
     * Get the value of middlewares
     *
     * @return  \tinkle\app\middlewares\BaseMiddleware[]
     */
    public function getMiddlewares(): array
    {
        return $this->middlewares;
    }





}