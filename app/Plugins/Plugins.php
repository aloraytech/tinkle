<?php


namespace Plugins;



use Tinkle\Framework;
use Tinkle\Library\Essential\Essential;
use Tinkle\Request;
use Tinkle\Response;

abstract class Plugins
{

    public Request $request;
    public Response $response;
    /**
     * Plugins constructor.
     */
    public function __construct()
    {
        $this->request = Framework::$app->request;
        $this->response = Framework::$app->response;
    }


    public function isAuth()
    {
        if(!Framework::isGuest())
        {
            return true;
        }
        return false;
    }


    public function tools()
    {
        return Essential::$essential;
    }

}