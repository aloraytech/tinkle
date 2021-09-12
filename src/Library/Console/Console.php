<?php


namespace Tinkle\Library\Console;



use Tinkle\Framework;
use Tinkle\Tinkle;

class Console
{
    public const DIVIDER=':';
    public static Console $console;
    public string $root;
    public string $setRequest='';
    protected Command $command;



    /**
     * Console constructor.
     * @param string $root
     */
    public function __construct(string $root='')
    {
        self::$console = $this;
        $this->root = $root ?? Tinkle::$ROOT_DIR;



    }

    public function run()
    {
       $dispatcher = new Dispatcher();
       $dispatcher->run();
    }



    public static function resolve()
    {

           if(!Console::$console->isCli())
           {
               echo "\e[35m 
    ************************************************|
    ** WARNING - Please Run On Any Cli Application
    ************************************************|\n\e[0m";
           }else{
               self::$console->run();
           }



    }


    public function isCli()
    {
        if (PHP_SAPI === 'cli')
        {
            if(defined('STDIN'))
            {
                return true;
            }
            if(isset($_SERVER['argv']) && isset($_SERVER['argc']))
            {
                return true;
            }
        }
        return false;

    }









}