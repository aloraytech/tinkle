<?php


namespace App\middlewares;


use Tinkle\interfaces\MiddlewareInterface;
use Tinkle\Middleware;

class TestMiddleware extends Middleware implements MiddlewareInterface
{

    public function execute()
    {
        echo "<br>Test Middleware <br>";
        // TODO: Implement execute() method.
    }
}