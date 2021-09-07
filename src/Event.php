<?php


namespace Tinkle;



use Tinkle\Library\Events\Events;

class Event extends Events
{



    /**
     * Event constructor.
     */
    public function __construct()
    {
        parent::__construct();
       $this->loadEventListeners();
    }


    public function loadEventListeners()
    {
        $listenerFile = Tinkle::$ROOT_DIR.'/routes/listeners.php';
        if(file_exists($listenerFile) && is_readable($listenerFile))
        {
            require_once "$listenerFile";
        }else{
            echo "Listner Not Found";
        }
    }


    public static function set(string $event_type,string $event_name,array|object $callback,array $config=[])
    {
        return  self::$event->add($event_type,$event_name,$callback,$config);
    }


    public static function trigger(string $type, string $event_name='', string|int|array $parameter='')
    {
         return self::$event->call($type,$event_name,$parameter);
        // echo "Event Running";
    }



}