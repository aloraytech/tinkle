<?php


namespace Tinkle\Library\Commander;


use Tinkle\Tinkle;

abstract class CommandHandler
{

    public array $config=[];
    public string $reserve='';
    public $request;
    public string $commandsPath='';

    abstract public function setConfig(array $config):array;
    abstract public function setCommandsPath(string $path):string;

    public function getConfig()
    {
        return $this->config;
    }

    public function getRequest()
    {
        if(is_array($this->config))
        {
            foreach ($this->config as $key => $value)
            {
                if($key === 0)
                {
                    $this->reserve = $value;
                }else{
                    $_GET[]=$value;
                }
            }
        }
    }



    public function resolve()
    {
        $this->getRequest();
        //print_r($_GET);

        $this->getRoutes();
    }




    public function router()
    {

    }

    private function getRoutes()
    {

    }









}