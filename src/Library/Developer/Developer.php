<?php


namespace tinkle\framework\Library\Developer;


use tinkle\framework\Controller;
use tinkle\framework\Request;
use tinkle\framework\Response;

class Developer extends Controller
{




    public function devLogin(Request $request, Response $response)
    {

        echo "Developer Login";

        $this->render('register');

    }








}