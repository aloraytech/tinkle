<?php

namespace Tinkle\Library\Events;

use Tinkle\Event;

/**
 * Class Events
 * Author : Krishanu Bhattacharya <krishanu.info@gmail.com>
 * This Package is Free With Tinkle Framework
 * @package Tinkle\Library\Events
 */
class Events
{

    public const EVENT_ON_LOAD = 'onLoad';
    public const EVENT_ON_RUN = 'onRun';
    public const EVENT_ON_END = 'onEnd';
    public const EVENT_ON_REPEAT= 'onRepeat';


    public static Events $event;
    protected Listeners $listeners;
    protected Repeater $repeater;
    protected array $groupsBag=[];
    protected array $pendingBag=[];
    protected array $allowedConfig=['slot'=>1,'wakeup'=>true,'timer'=>1,'period'=>1];
    protected array $allowedTypes = [self::EVENT_ON_RUN,self::EVENT_ON_END,self::EVENT_ON_LOAD,self::EVENT_ON_REPEAT];
    /**
     * Events constructor.
     */
    public function __construct()
    {
        self::$event = $this;
        $this->listeners = new Listeners();
        $this->repeater = new Repeater();
    }


    public function add(string $event_type,string $event_name,array|object $callback,array $config=[])
    {
        if(in_array($event_type,$this->allowedTypes,true))
        {
            if(is_string($event_name) && !empty($event_name))
            {
                if(is_array($config))
                {
                    if(empty($config))
                    {
                        $config = $this->allowedConfig;
                    }
                    $config = $this->filterConfig($config);


                    if(is_object($callback) || is_array($callback))
                    {




                        // Check For Lambda Closure
                        if(is_object($callback) && $callback instanceof \Closure)
                        {
                            $callback = $this->prepareCallback($callback);
                        }

                        if(is_array($callback))
                        {

                            // Check For Lambda Closure
                            if(is_object($callback[0]) && $callback[0] instanceof \Closure)
                            {
                                $callback = $this->prepareCallback($callback[0]);
                            }
                            // Check For Normal Callback


                        }

                        // Now Add Event As Listeners
                        if($event_type != self::EVENT_ON_REPEAT)
                        {
                            $this->listeners->add($event_type,$event_name,$callback,$config);
                        }else{
                            $this->repeater->add($event_type,$event_name,$callback,$config);
                        }


                    }



                }
            }
        }
    }




    // Add Process Helpers


    private function prepareCallback($callback)
    {
        $closure = \Closure::fromCallable($callback);
        return $closure;

    }

    private function filterConfig(array $config)
    {
        if(!empty($config) && is_array($config))
        {

            $tempConfig=[];

            foreach ($config as $key => $value)
            {
                if(array_key_exists($key,$this->allowedConfig))
                {
                    $tempConfig [$key] = $value;
                }
            }


            return array_replace($this->allowedConfig,$tempConfig);
        }


    }





    public function call(string $type, string $event_name, string|int|array $parameter='')
    {


        if($type === self::EVENT_ON_LOAD || $type === self::EVENT_ON_RUN || $type === self::EVENT_ON_END)
        {
            return $this->callListener($type,$event_name,$parameter);
        }

        if ($type === self::EVENT_ON_REPEAT)
        {
            return $this->callRepeater($type,$event_name,$parameter);
        }

    }




    private function callListener (string $type, string $event_name, string|int|array $parameter='')
    {
        if(empty($event_name))
        {
            // One By One Process Random Event
            $allEvents = $this->listeners->get($type);

            if(is_array($allEvents) && !empty($allEvents))
            {
                foreach ($allEvents as $key => $value)
                {
                    $dispatcher = new Dispatcher($value['callback'],$value['config'],$parameter);
                    return $dispatcher->run();
                }
            }



        }else{
            $selectedEvent = $this->listeners->get($type,$event_name);
            if(!empty($selectedEvent['callback']) && !empty($selectedEvent['config']))
            {
                $dispatcher = new Dispatcher($selectedEvent['callback'],$selectedEvent['config'],$parameter);
                return $dispatcher->run();
            }
        }

    }




    private function callRepeater(string $type, string $event_name, string|int|array $parameter='')
    {
        if(empty($event_name))
        {


        }else{

        }
        echo "<br><i><small> <u>$type</u> Not Implemented Yet</small></i><br>";


    }






    // Class End
}