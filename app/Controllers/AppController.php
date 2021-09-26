<?php

namespace App\Controllers;

use App\App;
use App\middlewares\AppMiddleware;
use App\Models\PostsModel;
use App\models\UsersModel;

use Database\migrations\CreatePostsMigration;
use Tinkle\Controller;
use Tinkle\Database\DBAccess;
use Tinkle\Database\Migration\Blueprint;
use Tinkle\Database\Migration\Column;
use Tinkle\Database\Migration\Schema;
use Tinkle\Event;
use Tinkle\Framework;
use Tinkle\interfaces\ControllerInterface;
use Tinkle\Library\Console\Console;
use Tinkle\Library\Console\ConsoleHandler;
use Tinkle\Library\Faker\Faker;
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
            echo "<h1>HOMEPAGE</h1>";



//        $post = new PostsModel();

       dd($app = ConsoleHandler::dbMigrate());








//        $this->title = 'homepage';
//        $this->description = 'custom web app maker';
//
//      echo "<h1>Welcome :</h1>";










//        $this->getMiddlewares();
//        $this->pageAttribute = ['title'=>'Homepage','favicon'=>'png','slogan'=>'Awesome'];
//
        $userModel = new UsersModel();
//        $this->render('templateName')->withTheme('themeName')->withModules([$userModel]);
//        //$this->display();

        //View::render('front.index','master')->withModules($userModel)->withHeader()->withExternal()->cssHost(true,'blogger.com,pink.com')->applyExternal()->applyHeader()->display();

        //$this->render('index','default')->withModules($userModel)->display();

        //View::display($userModel);


//        Schema::create('flights', function (Blueprint $table) {
//            $table->id();
//            $table->string('name');
//            $table->string('airline');
//            $table->timestamps();
//        });








//            $userModel = new UsersModel();
//            $this->prepareView('homepage')->withModels([$userModel])->responseCode(200);
//            $this->display();
    }



    public function check(\Closure $given)
    {
        dd($given);
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



//            echo "Load methods";
            return "Loading method For Api ";


    }


}