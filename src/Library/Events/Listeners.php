<?php


namespace Tinkle\Library\Events;


use Tinkle\Event;
use Tinkle\Library\Essential\Essential;
use Tinkle\Tinkle;

class Listeners
{

    protected array $listeners=[];
    protected array|string $pending=[];
    private static string $pendingSessionTable='pending_events';


    public function add(string $type,string $name,array|object $callback,array $config=[])
    {
        if(!isset($this->listeners[$type][$name]))
        {
            $this->listeners[$type][$name]['callback']=$callback;
            $this->listeners[$type][$name]['config']=$config;
        }else{
            echo "<br><b>Duplicate Event Found :&nbsp;<u> $name </u><br>";
        }

    }

    public function update(string $type,string $name,array|object $callback,array $config=[])
    {
        if(isset($this->listeners[$type][$name]))
        {
            unset($this->listeners[$type][$name]);
        }
        $this->listeners[$type][$name]['callback']=$callback;
        $this->listeners[$type][$name]['config']=$config;

    }

    public function get(string $type,string $name='')
    {
        if(empty($name))
        {
            if(isset($this->listeners[$type]))
            {
                return $this->listeners[$type];
            }
        }else{
            if(isset($this->listeners[$type][$name]))
            {
                return $this->listeners[$type][$name];
            }
        }
        return [];
    }


    public function getAll()
    {
        return $this->listeners;
    }







}