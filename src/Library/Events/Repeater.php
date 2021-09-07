<?php


namespace Tinkle\Library\Events;


class Repeater
{
    protected array $repeater=[];

    public function add(string $type,string $name,array|object $callback,array $config=[])
    {
        if(!isset($this->repeater[$type][$name]))
        {
            $this->repeater[$type][$name]['callback']=$callback;
            $this->repeater[$type][$name]['config']=$config;
        }else{
            echo "<br><b>Duplicate Event Found :&nbsp;<u> $name </u><br>";
        }

    }

    public function update(string $type,string $name,array|object $callback,array $config=[])
    {
        if(isset($this->repeater[$type][$name]))
        {
            unset($this->repeater[$type][$name]);
        }
        $this->repeater[$type][$name]['callback']=$callback;
        $this->repeater[$type][$name]['config']=$config;

    }

    public function get(string $type,string $name='')
    {
        if(empty($name))
        {
            if(isset($this->repeater[$type]))
            {
                return $this->repeater[$type];
            }
        }else{
            if(isset($this->repeater[$type][$name]))
            {
                return $this->repeater[$type][$name];
            }
        }
        return [];
    }


    public function getAll()
    {
        return $this->repeater;
    }




}