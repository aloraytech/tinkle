<?php


namespace Tinkle;



use Tinkle\Middlewares\SecurityMiddleware;
use App\middlewares\AppMiddleware;

/**
 * Class Controller
 * @package Tinkle
 *
 */
abstract class Controller
{

    private int $viewStep = 0;
    public string $action = '';
    public Request $request;
    public array $commons=[];
    /**
     * @var Middleware[]
     */
    protected array $middlewares = [];
    protected array $plugins = [];
    public array $pageAttribute=[];



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






    public function render(string $template='')
    {
        $this->viewStep = 1;
        return Tinkle::$app->view->render->render($template,$this->pageAttribute);
    }

    /**
     * @param string|mixed $content
     */
    public function display($content='')
    {
        if($this->viewStep !=0)
        {
            return Tinkle::$app->view->render->output($content);
        }else{
            return View::$view->render::display($content);
        }

    }




    public function registerMiddleware(Middleware $middleware)
    {
        $this->middlewares[] = $middleware;
    }




    /**
     * Get the value of middlewares
     *
     * @return  \Tinkle\Middlewares[]
     */
    public function getMiddlewares(): array
    {
        return $this->middlewares;
    }


    /**
     * @param string $plugin
     * @param array $callback
     */
    public function setPlugin(string $plugin,array $callback)
    {
        $this->plugins[$plugin] = $callback;
        Tinkle::$app->setEvent($plugin,$callback);
    }

    /**
     * @param string $plugin
     * @param mixed $parameter
     * @return mixed
     */
    public function getPlugin(string $plugin, string|array|int $parameter='')
    {
        return Tinkle::$app->getEvent($plugin,$parameter);
    }



}