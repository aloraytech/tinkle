<?php


namespace tinkle\framework\Library\Commander;


class Commands
{

    public static array $commands=[];


    public static function get(string $path,array $callback)
    {
        self::$commands['get'][$path]=$callback;
    }

    public static function post(string $path,array $callback)
    {
        self::$commands[SD][$path]=$callback;
    }


    public function getCommands(){}


}