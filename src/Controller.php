<?php


namespace Tinkle;



use Plugins\Layer\Layer;
use Tinkle\Library\Console\Application\Controllers\Make;
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
//    public string $action = '';
    public Request $request;
    public array $commons=[];
    /**
     * @var Middleware[]
     */
    protected array $middlewares = [];
    protected array $plugins = [];
    public string $title='';
    public string $description='';
    public array $result=[];



    // ESSENTIAL PUBLIC METHODS FOR EVERY CONTROLLER

    /**
     * Controller constructor.
     */
    public function __construct()
    {
        $this->setPlugin('layout.menu',[Layer::class,'getMenu']);
        $this->registerMiddleware(new SecurityMiddleware());

    }

    public function result(array $array)
    {
        $this->result = $array;
    }

    public function getResult()
    {
        return [
            'title'=>$this->title,
            'description'=>$this->description,
            'result'=>$this->result,
        ];
    }






    /**
     * @param string $template
     * @param string $theme
     * @return Library\Render\Config\Config
     */
    public function render(string $template='',string $theme='')
    {
        Tinkle::$app->view->setLayoutParams('title',$this->title);
        Tinkle::$app->view->setLayoutParams('description',$this->description);
        $config = $this->getPlugin('layout.menu');
        foreach ($config as $key=>$param)
        {
            Tinkle::$app->view->setLayoutParams($key,$param);
        }
        return Tinkle::$app->view->render($template,$theme);
    }

    /**
     * @param string|mixed $content
     */
    public function display(string|int|array|object $content)
    {
        View::display($content);

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

// Need To Fix

//    /**
//     * @return array
//     * need to fix, cause router updated
//     */
//    public function get_allDefineParams()
//    {
//        return Tinkle::$app->router->incomingAttributes ?? [];
//    }
//
//    /**
//     * @param string $paramKey
//     * need to fix , cause router updated
//     * @return array|mixed
//     */
//    public function get_defineParam(string $paramKey)
//    {
//        $all_params = $this->get_allDefineParams();
//        if(is_array($all_params))
//        {
//            foreach ($all_params as $a_key => $value)
//            {
//                if($paramKey == $a_key)
//                {
//                    return $value;
//                }
//            }
//        }else{
//            return $all_params;
//        }
//    }


    public function create()
    {
        return new Make();
    }




}