<?php

namespace App\Controllers;

use App\middlewares\AppMiddleware;
use App\models\UsersModel;

use Tinkle\Controller;
use Tinkle\Event;
use Tinkle\Framework;
use Tinkle\interfaces\ControllerInterface;
use Tinkle\Library\Console\Console;
use Tinkle\Library\Render\Engine\Engine;
use Tinkle\Library\Render\Engine\Native\NativeEngine;
use Tinkle\Middlewares\AuthMiddleware;
use Tinkle\Request;
use Tinkle\Response;
use Tinkle\Tinkle;
use Tinkle\View;


class AppController extends Controller implements ControllerInterface
{

    public function __construct()
    {
        $this->registerMiddleware(new AuthMiddleware(['profile']));

        //$this->registerMiddleware(new TestMiddleware());
        parent::__construct();

    }


    public function home(Request $request, Response $response)
    {


      //  echo "<h1>Welcome :</h1>";

        $this->getMiddlewares();
        $this->pageAttribute = ['title'=>'Homepage','favicon'=>'png','slogan'=>'Awesome'];

        $userModel = new UsersModel();
        $this->render('templateName')->withTheme('themeName')->withModules([$userModel]);
        //$this->display();

       








//            $userModel = new UsersModel();
//            $this->prepareView('homepage')->withModels([$userModel])->responseCode(200);
//            $this->display();
    }









    public function MyFolder(Request $request, Response $response)
    {

        $userModel = new UsersModel();
        $this->prepareView('homepage')->withModels([$userModel])->responseCode(200);
        $this->display();

    }


    public function item(Request $request, Response $response)
    {

        echo "<h1>Item Loaded</h1>";

    }
















    public function contact(Request $request, Response $response)
    {
        $userModel = new User();

        if($request->isPost())
        {
            $uImage = $request->request->get('userImage');
            $userModel->loadData($request->getAllContent());
            if($userModel->validate() && $userModel->login())
            {
                echo "Hello";
            }else{
                echo "gello";
            }
        }

        echo "Hello";


    }






    public function show(Request $request, Response $response)
    {
//        $userModel = new UsersModel();
//
//        if($request->isPost())
//        {
//
//
//
//            $uImage = $request->prepareUpload('userImage');
//
//            if(is_array($uImage))
//            {
//                if($request->upload($uImage,''))
//                {
//                    echo "Upload Complete";
//                }else{
//                    echo "Upload Failed";
//                }
//            }else{
//                echo "Upload Failed";
//            }
//
//
//
//
//            $data = ['data'=>$request->getAllContent(),'image'=>$uImage['details']['hash']];
//
//
//            $userModel->loadData($data);
//
//            if($userModel->validate() && $userModel->login())
//            {
//                echo "Hello";
//            }else{
//                echo "gello";
//            }
//        }

        $userModel = new UsersModel();
        $this->prepareView('test')->withModels([$userModel])->responseCode(200);
        $this->display();


    }


    public function load(Request $request, Response $response)
    {

//        $_token = new Token();
//        $_token->create();
//        echo "<pre>";
//        print_r($_token->getTokenBag());


            echo "Hello";



//        $this->setLayout('sample');
//        $this->render('contact');
    }


}