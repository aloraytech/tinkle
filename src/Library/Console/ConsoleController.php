<?php


namespace Tinkle\Library\Console;


use Tinkle\Event;
use Tinkle\Library\Logger\Logger;
use Tinkle\Tinkle;

abstract class ConsoleController
{


    public string $appRoot;
    public string $root;
    public string $config;
    public string $pattern = Console::DIVIDER;

    /**
     * ConsoleController constructor.
     */
    public function __construct()
    {
        $this->root = Tinkle::$ROOT_DIR;
        $this->appRoot = $this->root.'src/Library/Console/Application/';
    }


    /**
     * @param string $event
     * @param array $callback
     */
    public function setEvent(string $event,array $callback)
    {
        Event::set(Event::EVENT_ON_RUN,$event,$callback);
    }

    /**
     * @param string $event
     * @param mixed $parameter
     * @return mixed
     */
    public function callEvent(string $event, string|array|int $parameter='')
    {
        return Event::trigger(Event::EVENT_ON_RUN,$event,$parameter);
    }

    public function scanNget(string $location,string $filename='')
    {
        if(empty($filename))
        {
            if(is_dir($location))
            {
                return scandir($location);
            }
        }else{
            if(is_dir($location))
            {
                $allFiles= scandir($location);
                foreach ($allFiles as $key => $value)
                {
                    if(strtolower($filename) === strtolower($value))
                    {
                        return pathinfo($location.$value);
                    }
                }
            }
        }
        return [];

    }


    public function log(string $message)
    {
        return Logger::Logit($message);
    }



    public function cleanDir(string $location)
    {
        if(is_dir($location))
        {
            $allFiles= scandir($location);
            foreach ($allFiles as $key => $value)
            {
                if($value !='.' && $value !='..')
                {
                    unlink($value);
                }
            }


        }

    }



    public function getLayout(string $layout)
    {
        $layoutInfo = $this->scanNget($this->appRoot.'Layouts/',$layout);
        if(!empty($layoutInfo))
        {
            return file_get_contents($layoutInfo['dirname'].'/'.$layoutInfo['basename']);
        }
        return '';
    }






}