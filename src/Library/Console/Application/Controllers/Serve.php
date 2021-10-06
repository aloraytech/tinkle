<?php

namespace Tinkle\Library\Console\Application\Controllers;

use Tinkle\Tinkle;
use Twig\NodeVisitor\EscaperNodeVisitor;

class Serve
{


    public function __construct()
    {
    }

    public function index()
    {
        $domain = $_ENV['APP_URL'];
        $fullDomain = $_ENV['URL_SCHEME']."://".$_ENV['APP_URL'];
        $dir = $_ENV['PUBLIC_DIRECTORY'];
        echo "Finding Project... \n";
        sleep(1);
        chdir("$dir");
        sleep(2);
        echo "Preparing... \n";
        sleep(2);
        echo "Ready For Launching.....[Make sure Google Chrome Install In Your System] \n";
        sleep(2);
            echo "Launching... \n";
            shell_exec("start chrome $fullDomain:8000");
            echo "Starting... \n";
            sleep(2);
            return shell_exec("php -S $domain:8000");




    }



}