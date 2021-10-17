<?php
declare(strict_types=1);
namespace App\Controllers;

use App\Models\Posts;

use App\Models\UsersModel;
use Database\migrations\m001CreateUsersMigration;
use Tinkle\Controller;
use Tinkle\Database\Database;

use Tinkle\DB;
use Tinkle\Library\Debugger\Debugger;
use Tinkle\Request;
use Tinkle\Response;
use Tinkle\Tinkle;

/**
 * Class TestController
 * @package tinkle\app\controllers
 * @author : krishanu.info@gmail.com
 * @version : 1.0
 */
class TestController extends Controller
{

       /**
        * TestController constructor.
        */
       public function __construct()
       {
           // Todo $this->registerMiddleware('middleware_name');
           parent::__construct();
           // Todo $this->setPlugin('plugin_name',['callbackClass','method']);
       }


        /**
         * @param Request $request
         * @param Response $response
         */
       public function home(Request $request, Response $response)
       {
            echo "<h1>Test Controller Home</h1>";

           // $post = new PostsModel();

           //dd(Tinkle::$app->db->getConnect());

//
     //     dd(Tinkle::$app->db->table('posts')->all()->where(['id'=> 1])->get());
//           dd(Tinkle::$app->db->getConnect()->dbExist('tinkle'));

           //dd(Tinkle::$app->db->getConnect()->columnExist('username','users'));
//           $post = new Posts();
//                 ddump($post);
//           $post->author_id = 2;

//          $post = new Posts();
//          $post->find(1);

//          ddump();
           //  ddump($post->findAll());


//           $user = new UsersModel();
//           ddump($user);


//          $posts =  Posts::all()->get();
//          dryDump($posts);
//           ddump($posts);
//           ddump($posts->find(1));
//
            $pp = new Posts();
//            $pp->method();
//
            dryDump($pp->all()->where(['id'=>5,'author_id'=>2])->first());
//
//           dryDump(Posts::all()->where(['id'=>5,'author_id'=>2])->first());
//           echo "Here";

            dryDump(Posts::all()->where(['id'=>5,'author_id'=>2])->firstOrFail());
//           dryDump(Posts::find()->where(['id'=>5,'author_id'=>2])->first());
           dryDump(Posts::find(25));
//
//
//           Posts::create([
//               'title' => 'Taylorss',
//               'description' => 'Otwellss',
//               'author_id' => 1,
//               'category_id'=> 1
//           ]);


           dryDump(Posts::where('author_id', 3)
               ->orderBy('category_id')
               ->take(10)
               ->get());


           //dd(Posts::find(9)->title);
//           echo "<pre>";
     //     print_r(Posts::find(9));





          dryDump(Posts::find(1));

//           $flight = Posts::find(1);
//
//           $flight->name = 'Paris to London';
//
//           $flight->save();





          // $results = DB::select('select * from users where id = ?', [1]);
          //dd(DB::select('select * from users where id = ?', [1]));


//            $app = new m001CreateUsersMigration();
//           $app->up();









       }


       public function check(Database $db)
       {

       }









}