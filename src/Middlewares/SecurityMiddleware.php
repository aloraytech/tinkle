<?php


namespace tinkle\framework\Middlewares;


use tinkle\framework\interfaces\MiddlewareInterface;
use tinkle\framework\Library\Essential\Activity;
use tinkle\framework\Library\Http\DomDocumentHandler;
use tinkle\framework\Middleware;
use tinkle\framework\Tinkle;

class SecurityMiddleware extends Middleware implements MiddlewareInterface
{

    public function execute()
    {
       // echo "Security Applied <br>";

        echo "<pre>";
       $this->updateActivity();
       die();
    }


    public function updateActivity()
    {
        $activity = new Activity();
        $activity->resolve();

    }






}