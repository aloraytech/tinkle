<?php

namespace Plugins\Posts;

use Plugins\Plugins;

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



    public function getPost(int $id)
    {
        echo "Posts id : ".$id;
    }



}