<?php


namespace Tinkle\Library\Console\Application\Controllers;


use Tinkle\Library\Console\ConsoleController;


class Make extends ConsoleController
{




    public function index()
    {
        echo "Make>>Index";
    }


    public function event()
    {
        $layout = $this->getLayout('sample.php');
        print_r($layout);
    }












}