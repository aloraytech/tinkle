<?php
declare(strict_types=1);
namespace App\Controllers;

use App\App;
use App\Models\PostsModel;
use App\models\UsersModel;
use Database\seeders\UserTableSeeder;
use Tinkle\Controller;
use Tinkle\interfaces\ControllerInterface;
use Tinkle\Library\Console\Application\Controllers\DB;
use Tinkle\Library\Console\Application\Controllers\Make;
use Tinkle\Middlewares\AuthMiddleware;
use Tinkle\Request;
use Tinkle\Response;
use Tinkle\Tinkle;
use Tinkle\View;


class AppController extends Controller
{

    public function __construct()
    {
        $this->registerMiddleware(new AuthMiddleware(['profile']));

        //$this->registerMiddleware(new TestMiddleware());
        parent::__construct();


    }


    /**
     * @param Request $request
     * @param Response $response
     */
    public function home(Request $request, Response $response)
    {
            echo "<h1>HOMEPAGE</h1>";



            $postModel = new PostsModel();
            $postModel->title = 'Moon';
            $postModel->description = 'MoonLight';
            $postModel->author_id = 3;
            $postModel->category_id = 2;

            $postModel->save();

//            $data=[
//                'title'=>'Sun Orbital',
//                'description'=>'This is a Nasa Mission.',
//                'author_id'=>4,
//                'category_id'=>2,
//
//            ];
            //$postModel->insert($data);
            // dd($postModel->find(['title','category_id','id','created_at'])->where(['author_id'=> 2])->get());
            //dd($postModel->update($data)->where(['id'=>8])->save());
            // $postModel->delete(['id'=>3]);
          // $postModel->find()->where(['author_id'=>1])->get();

        //    dd();


            //$postModel::select(['id','title']);
//




       //$this->create()->controller('Front/CreateUsersController');
















//        $this->title = 'homepage';
//        $this->description = 'custom web app maker';
//
//      echo "<h1>Welcome :</h1>";










//        $this->getMiddlewares();
//        $this->pageAttribute = ['title'=>'Homepage','favicon'=>'png','slogan'=>'Awesome'];
//
//        $userModel = new UsersModel();
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