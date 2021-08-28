<?php

namespace App\Controllers;

use App\models\UsersModel;
use Tinkle\Controller;
use Tinkle\interfaces\ControllerInterface;
use Tinkle\Library\Cli\program\controller\DB;
use Tinkle\Library\Explorer\Explorer;
use Tinkle\Library\Robo\Robo;
use Tinkle\Tinkle;
use Tinkle\Request;
use Tinkle\Response;
use Tinkle\Token;
use Tinkle\View;


class AppController extends Controller implements ControllerInterface
{




    public function home(Request $request, Response $response)
    {
     //  $meta = file_get_contents_curl('http://myproject.test/');

//        echo "<br> Lets Check :" . Tinkle::$app->system->resolve() . "<br>";


//        $ch = curl_init();
//        curl_setopt($ch, CURLOPT_URL,'http://myproject.test/login');
//        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
//        $output = curl_exec($ch);
//        curl_close($ch);

        //$data = getAllContentFrom('http://myproject.test/show');

        $app = new Robo();



//
//            $app = new DB();
//             $app->migrate();
//        //   $app->dropMigration();

//            $img = "http://myproject.test/resources/upload/example.png";
//            $imgData = base64_encode(file_get_contents($img));
//            $format = 'data: ' . mime_content_type($img) . ';base64,'.$imgData;

 //       echo "<div><div><img src='/resources/upload/example.png' height='250px' width='350px'></div> <br><br>";

     //   echo "<div><img src='".$format."' height='250px' width='350px'></div></div>";
//


//        $app = new Installer($request, $response);
//        $app->check();
//
//        die;
            $userModel = new UsersModel();
            $this->prepareView('homepage')->withModels([$userModel])->responseCode(200);
            $this->display();
    }


    public function MyFolder(Request $request, Response $response)
    {

        $app = new Explorer($request, $response);
        $result = ['title'=>$app->explore('')];


        $this->render('filemanager',$result);

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