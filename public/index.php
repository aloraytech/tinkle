<?php
declare(strict_types=1);
use Tinkle\Framework;
use Tinkle\Exceptions\Display;



    try {
        require_once __DIR__.'/../vendor/autoload.php';
        $configuration = new \Config\Config();



        if(class_exists(Framework::class))
        {
            $app = new Framework(dirname(__DIR__),$configuration->getConfig());
            $app->run();
        }else{
            throw new Display('Framework Initialization Failed',Display::HTTP_SERVICE_UNAVAILABLE);
        }

    }catch (Display $e){
        $e->Render();
    }





