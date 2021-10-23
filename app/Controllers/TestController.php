<?php
declare(strict_types=1);
namespace App\Controllers;

use App\Models\Posts;

use App\Models\UsersModel;
use Database\migrations\m001CreateUsersMigration;
use Tinkle\Controller;
use Tinkle\Database\Database;

use Tinkle\DB;
use Tinkle\Library\Auth\Auth;
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

            $credential =
                //Auth::attempt($request->getAllContent());
          //  ddump($request->getAllContent());

                $data = [
                    'email' => 'hello@gmail.com','password' => 'abcd123daf','passwordConfirm' => 'abcd123daf',
                ];

            Auth::attempt($data);










       }


       public function check(Database $db)
       {

       }









}