<?php


namespace tinkle\framework\Library\Cli\program;


use tinkle\framework\interfaces\LibraryInterface;
use tinkle\framework\Library\Cli\CliHandler;
use tinkle\framework\Library\Logger\Logger;
use tinkle\framework\Tinkle;

class CliController implements LibraryInterface
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