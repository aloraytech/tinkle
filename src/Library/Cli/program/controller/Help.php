<?php


namespace tinkle\framework\Library\Cli\program\controller;

use tinkle\framework\interfaces\CliControllerInterface;
use tinkle\framework\Library\Cli\CliHandler;
use tinkle\framework\Library\Cli\program\CliController;

/**
 * Class Help
 * @package tinkle\framework\Library\Cli\program\controller
 */
class Help extends CliController implements CliControllerInterface
{





    public function index()
    {
        echo "New Controller Syntax : php tinkle.php make".CliHandler::$pattern."controller MyController  
        \nInside Custom Folder Syntax : php tinkle.php make".CliHandler::$pattern."controller CustomFolder/MyController  \n";
    }






}