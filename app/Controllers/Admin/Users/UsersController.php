<?php
declare(strict_types=1);
namespace App\Controllers\Admin\Users;

use Tinkle\Controller;
use Tinkle\Request;
use Tinkle\Response;

/**
 * Class UsersController
 * @package tinkle\app\controllers
 * @author : krishanu.info@gmail.com
 * @version : 1.0
 */
class UsersController extends Controller
{

       /**
        * UsersController constructor.
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
       public function my_custom_method(Request $request, Response $response)
       {
            // Todo implement my_custom_method
       }










}