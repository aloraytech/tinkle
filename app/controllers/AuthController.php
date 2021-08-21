<?php

namespace tinkle\app\controllers;

use tinkle\app\models\Auth\LoginModel;
use tinkle\app\models\UsersModel;
use tinkle\framework\Controller;
use tinkle\framework\interfaces\ControllerInterface;
use tinkle\framework\Middlewares\AuthMiddleware;
use tinkle\framework\Request;
use tinkle\framework\Response;

/**
 * Class AuthController
 * @package tinkle\app\controllers
 */
class AuthController extends Controller implements ControllerInterface
{


    public function __construct()
    {
        $this->registerMiddleware(new AuthMiddleware(['profile']));
        parent::__construct();
    }

    /**
     * @param Request $request
     * @param Response $response
     */
    public function login(Request $request, Response $response)
    {
        $loginForm = new LoginModel();

        if($request->isPost())
        {

            $loginForm->loadData($request->getAllContent());
            if($loginForm->validate() && $loginForm->login())
            {
                // On Success

                $response->redirect('dashboard');
                return;
            }
        }








//        $this->setLayout('auth');
//        return $this->render('login', [
//            'model'=> $loginForm
//        ]);

        return $this->render('Auth/login',[
            'model'=> $loginForm
        ]);

    }






}
