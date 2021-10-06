<?php
declare(strict_types=1);
namespace App\Controllers;

use App\Models\PostsModel;
use Tinkle\Controller;
use Tinkle\Database\Database;

use Tinkle\Request;
use Tinkle\Response;

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



       }


       public function check(Database $db)
       {

       }









}