<?php


namespace Tinkle\Library\Events;


use Tinkle\Exceptions\Display;
use Tinkle\Library\Router\Cloner;

class Dispatcher
{

    protected array|object $callback=[];
    protected array|string|int $param=[];
    protected array $config=[];

    protected string|int $slot='';
    protected bool $wakeup = false;
    protected string|int $timer='';
    protected string|int $period='';
    /**
     * Dispatcher constructor.
     * @param array|object $callback
     * @param array $config
     * @param array|int|string $parameters
     */
    public function __construct(array|object $callback,array $config, array|string|int $parameters='')
    {
        $this->callback = $callback;
        $this->param = $parameters;
        $this->config = $config;
        $this->slot = $this->config['slot'];
        $this->wakeup = $this->config['wakeup'];
        $this->timer = $this->config['timer'];
        $this->period = $this->config['period'];
    }




    public function run()
    {

        try{

            if(is_object($this->callback) || is_object($this->callback[0]))
            {
                if($this->callback instanceof \Closure)
                {
                    return $this->runLambdaEvents($this->callback,$this->param);
                }
                if($this->callback[0] instanceof \Closure)
                {
                    return $this->runLambdaEvents($this->callback,$this->param);
                }
            }



            if(!is_object($this->callback)  && is_array($this->callback))
            {
                if(!is_callable($this->callback))
                {
                    $this->callback[0] = new $this->callback[0]();
                }

                return call_user_func($this->callback,$this->param);

            }

        }catch (Display $e){
            $e->Render();
        }





    }







    protected function runLambdaEvents(array|object $callback,$param)
    {

        try {
            if($callback === false){
                throw new Display('Request Not Found',404);
            }
            if(is_string($callback)){
                dd($callback);
            }

            if($param && is_array($param)) {
                return call_user_func_array($callback, $param);
            }
            elseif ($param && !is_array($param)) {
                return call_user_func($callback, $param);
            }
            else {
                return call_user_func($callback);
            }

        } catch (Display $e) {
            $e->Render();
        }
    }












    public function runRepeatedly()
    {
        //dd($this->config);





    }
















    protected function getParams()
    {
        if(is_array($this->param))
        {
            return implode(',',$this->param);
        }else{
            return $this->param;
        }
    }


}