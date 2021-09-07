<?php


namespace Tinkle\Middlewares;


use Tinkle\Exceptions\Display;
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
        //echo "<div style='border: black 3px solid; background-color: #3dd5f3'><h2>Middleware Loaded</h2> <br><b>". ucfirst($this->actions[0])."</b></div>";

        if (Tinkle::isGuest()) {
            if (empty($this->actions) || in_array(Tinkle::$app->controller->action, $this->actions)) {
                throw new Display("User Not Authenticate");
            }
        }
    }



}