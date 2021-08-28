<?php


namespace Tinkle\Library\Cli;


use Tinkle\Library\Cli\program\CliController;
use Tinkle\Library\Logger\Logger;
use Tinkle\Tinkle;

class CliHandler
{

    protected array $url=[];
    protected string $controller ='';
    protected string $method='';
    protected  $params;
    public Model $model;
    public static CliHandler $app;
    public static string $ROOT_DIR;
    public static string $pattern = '::';



    public function __construct(array $config,string $path)
    {
       $this->url = $config['argv'];
        self::$app = $this;
    }

    public function run()
    {
        if($this->analyze())
        {
            $this->dispatch();
        }

    }




    public function analyze()
    {

        if(!empty($this->url[1]))
            {
            $this->controller = $this->url[1];
            if(preg_match('/'.self::$pattern.'/',$this->controller,$match))
            {
                if(!empty($match)){
                    $part = explode("::",$this->controller);
                    $this->controller = $part[0];
                    $this->method = $part[1];
                }

            }else{

                $this->method = $this->url[2] ?? '';
            }

                if(!empty($this->url[2]))
            {
                $this->params = $this->url[2];
            }
            return true;
        }else{
            //Logger::Logit("Tinkle Cli Get Unknown Arguments like  \n Controller : ".$this->url[1]??''." \n Action : ".$this->url[2]??''." \n");
            echo "Welcome User \n\e[92m 
************************************************|
* HOWTO : php tinkle controller::model param ***|
* tinkle,tinkle.php | String,Array Param *******|
************************************************|\n\e[0m";
        }
    }









    public function statusMessage()
    {
            echo "\e[92m
                ************************************************
                 TINKLE>CONTROLLER>METHOD
                ************************************************\n
             \e[0m";
    }



    public function errorMessage()
    {
        echo "\e[31m 
                 TINKLE>ERROR>
                 Message: Requested Command Not Available
                 TINKLE>SUGGESSTION> 
                 Get Help Command: php tinkle help howto\n
             \e[0m";
    }

    private function dispatch()
    {

        $namespace = "tinkle\\framework\Library\Cli\program\controller";
        $controller = $namespace.'\\'.$this->controller;
        if(class_exists($controller))
        {
            $controller = new $controller();
            if(!empty($this->method))
            {
                $method = $this->method;
                $param = $this->params;
                $controller->$method($param);
            }else{
                $method = 'index';
                $controller->$method();
            }

        }else{
            Logger::Logit("Request Class not Found \n Controller : $this->controller \n Action : $this->method \n");
        }


    // Pore Update Korbo Ok


    }

//    public function __toString()
//    {
//        return self::$ROOT_DIR;
//    }


}