<?php


namespace Tinkle\Middlewares;


use Tinkle\interfaces\MiddlewareInterface;
use Tinkle\Middleware;

class ApiMiddleware extends Middleware implements MiddlewareInterface
{


    protected array $actions = [];

    public function __construct($actions = [])
    {
        $this->actions = $actions;

    }



    public function execute()
    {
        print_r($this->actions);
    }
}