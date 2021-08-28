<?php


namespace Tinkle\Library\Cli\program\controller;

use Tinkle\interfaces\CliControllerInterface;
use Tinkle\Library\Cli\CliHandler;
use Tinkle\Library\Cli\program\CliController;

/**
 * Class Help
 * @package Tinkle\Library\Cli\program\controller
 */
class Help extends CliController implements CliControllerInterface
{





    public function index()
    {
        echo "New Controller Syntax : php tinkle.php make".CliHandler::$pattern."controller MyController  
        \nInside Custom Folder Syntax : php tinkle.php make".CliHandler::$pattern."controller CustomFolder/MyController  \n";
    }






}