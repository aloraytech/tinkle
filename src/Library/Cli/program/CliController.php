<?php


namespace Tinkle\Library\Cli\program;


use Tinkle\interfaces\LibraryInterface;
use Tinkle\Library\Cli\CliHandler;
use Tinkle\Library\Logger\Logger;
use Tinkle\Tinkle;

class CliController
{


    public function getRoot()
    {
        return Tinkle::$ROOT_DIR;
    }

    public function getPattern()
    {
        return CliHandler::$pattern;
    }

    public function logIt(string $_msg)
    {
        return Logger::Log($_msg);
    }

    public function keepRecord(string $_msg)
    {
        return Logger::Log($_msg);
    }

    public function getAllFilesFrom(string $_location)
    {
        if(is_dir($_location))
        {
            return scandir($_location);
        }
        return null;
    }






}