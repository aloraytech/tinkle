<?php
declare(strict_types=1);
use tinkle\framework\Tinkle;



require_once __DIR__.'/../vendor/autoload.php';

$configuration = new \tinkle\config\Config();

    if(class_exists(Tinkle::class))
    {
        $app = new Tinkle(dirname(__DIR__),$configuration->getConfig());
        $app->run();
    }





