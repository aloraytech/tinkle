<?php


namespace Tinkle\Middlewares;


use Tinkle\interfaces\MiddlewareInterface;
use Tinkle\Middleware;
use Tinkle\Tinkle;

class AuthMiddleware extends Middleware implements MiddlewareInterface
{


    protected array $actions = [];

    public function __construct($actions = [])
    {
        $this->actions = $actions;
    }

    public function execute()
    {
        if (Tinkle::isGuest()) {
            if (empty($this->actions) || in_array(Tinkle::$app->controller->action, $this->actions)) {
                throw new ForbiddenException();
            }
        }
    }



}