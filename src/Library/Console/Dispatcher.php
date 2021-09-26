<?php


namespace Tinkle\Library\Console;


use Tinkle\Exceptions\Display;

class Dispatcher
{

    protected string $controllerPart='';
    protected string $methodPart='index';
    protected string|array $parameterPart=[];

    /**
     * Dispatcher constructor.
     */
    public function __construct()
    {
        $this->buildRequest();
    }



    private function buildRequest()
    {
        if(Console::$console->isCli())
        {
            $pattern=Console::DIVIDER;
            foreach ($_SERVER['argv'] as $key => $value)
            {
                if($key===0)
                {
                    continue;
                }else{
                    if($key ===1)
                    {
                        if(preg_match("/([a-z]+|[A-Z]+)$pattern([a-z]+|[A-Z]+)/",$value,$matches))
                        {
                            if(!empty($matches) && isset($matches[2]))
                            {
                                $this->controllerPart = $matches[1];
                                $this->methodPart = $matches[2];
                            }
                        }else{
                            $this->controllerPart = $value;

                        }

                    }

                    if($key ===2)
                    {
                        if(empty($this->methodPart))
                        {
                            $this->methodPart = $value;
                        }else{
                            $this->parameterPart [] = $value;
                        }
                    }
                    if($key !=0 && $key!=1 && $key !=2)
                    {
                        $this->parameterPart [] = $value;
                    }




                }
            }
        }
    }



    public function run()
    {
       try{
           if(!empty($this->controllerPart))
           {
               $controller = "Tinkle\Library\Console\Application\Controllers\\".ucfirst($this->controllerPart);
               // Create Controller Instance

               $instance = new $controller();


               if(is_callable([$instance,$this->methodPart]))
               {
                   $callback[0]=$instance;
                   $callback[1]=$this->methodPart;
                   $param = implode(',',$this->parameterPart);
                   echo "Searching... \n"; sleep(2);
                   return call_user_func($callback,$param);
               }else{
                   throw new Display('This Tinkle Command Is Not Available');
               }
           }else{
               throw new Display('Type Help Keyword before Any Command To Know It Better');
           }
       }catch (Display $e)
       {
           $e->Render();
       }
    }




}