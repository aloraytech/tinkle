<?php

namespace Plugins\Posts;

use App\Models\UsersModel;
use Tinkle\Plugins;
use Tinkle\Request;
use Tinkle\Response;

/**
 * Class Posts
 * @package Plugins\Posts
 */
class Posts extends Plugins
{

    public function newPost(array $data)
    {
        return "Post Created With : ". implode(',', $data);
    }



    public function addPost(Request $request, Response $response)
    {
        //$this->setLayout('kartoos');
        $this->setTemplate('newPost');
        $userModel = new UsersModel();
        $data=[
            'name'=> 'Krishanu',
            'age'=> 31,
            'userModel'=>$userModel,
            'country'=> 'America','Russia','India','England',
            'bird'=>[['name'=>'rosy','type'=>'lovebird'],['name'=>'lutino','type'=>'cocktail']]
        ];

        return $data;

    }





    public function updatePost(Request $request, Response $response)
    {
        echo "Posts Update Method : ";
    }



}