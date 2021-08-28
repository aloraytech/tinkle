<?php


namespace Tinkle\Middlewares;


use Tinkle\interfaces\MiddlewareInterface;
use Tinkle\Library\Essential\Activity;
use Tinkle\Library\Http\DomDocumentHandler;
use Tinkle\Middleware;
use Tinkle\Tinkle;

class SecurityMiddleware extends Middleware implements MiddlewareInterface
{

    public function execute()
    {
       // echo "Security Applied <br>";

     //   echo "<pre>";
//       $this->updateActivity();
//       die();
    }


    public function updateActivity()
    {
        $activity = new Activity();
        $activity->resolve();

    }






}