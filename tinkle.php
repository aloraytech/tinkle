<?php
use tinkle\framework\Tinkle;

    if (PHP_SAPI === 'cli')
    {
echo "\e[92m 
************************************************|
** TINKLE FRAMEWORK CLI  _version 0.2  2021 ****|
************************************************|\n\e[0m";




        require_once __DIR__.'/vendor/autoload.php';
        // Load Environment
        $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
        $dotenv->load();

//        $app = new \tinkle\framework\Library\Cli\CliHandler($argv,__DIR__);

        $config = new \tinkle\config\Config();
        $configDetails = $config->getConfig();
        $configDetails['argv']= $argv;


        $app = new Tinkle(__DIR__,$configDetails);



        // Not try to analyze all Arguments From Our Cli Handler And Then If Everything is Ok.. Just Run our request.
        $app->run();
    }else{
        echo "This is a Command Line Application. Please use CMD or POWERSHELL to run ";
    }


