<?php

use Config\Config;

use Tinkle\Exceptions\Display;

    try{

        if (PHP_SAPI === 'cli')
        {
            _cli_StartUp_Message();

            try {
                $composer = __DIR__.'/vendor/autoload.php';
                if(file_exists($composer))
                {
                    require_once "$composer";
                }else{
                    throw new Display("Composer Not Found. Please Setup Connection With Composer Autoload",500);
                }

                $configDetails =[];
                if(class_exists(Config::class))
                {
                    $config = new Config();
                    $configDetails = $config->getConfig();
                    $configDetails['argv']= $argv;
                }else{
                    throw new Display("Configuration Not Found",500);
                }



                if(class_exists(\Tinkle\Framework::class))
                {
                    $app = new \Tinkle\Framework(__DIR__, $configDetails);
                    $app->run();
                }else{
                    throw new Display("Framework Init Failed",500);
                }


            } catch (Display $e) {
                $e->CliError();
            }




        }else{
            throw new Display("This is a Php Cli Program, Can't be run in Web Browser",500);
        }




    }catch (Display $e)
    {
        $e->CliError();
    }




    function _cli_StartUp_Message()
    {
        echo "\e[92m 
    ************************************************|
    ** TINKLE FRAMEWORK CLI  _version 0.2  2021 ****|
    ************************************************|\n\e[0m";
    }