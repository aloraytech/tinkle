<?php

namespace App\Controllers;

use App\Models\UsersModel;
use Tinkle\Controller;


use Tinkle\interfaces\ControllerInterface;
use Tinkle\Tinkle;
use Tinkle\Request;
use Tinkle\Response;
use Tinkle\Token;



class ApiController extends Controller implements ControllerInterface
{


    public function users()
    {
        $userModel = new UsersModel();

       $this->result([
           'userModel'=>$userModel
       ]);


    }












}