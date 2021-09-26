<?php


namespace App\Provider;


use Plugins\Posts\Posts;
use Themes\Master\Master;
use Tinkle\Library\Platform\Platform;

class PlatformProvider
{

    public function getDefaultBackLayout()
    {
        return new Master();
    }
    public function getDefaultFrontLayout()
    {
        return new Master();
    }



    public function getDefaultPagesConfig()
    {

    }


    public function getPlatformCommonModules()
    {
        return new \App\Plugins\Platform\Platform();
    }










    public function getPlatformRoutes()
    {
        return [
            Platform::getFront('post.go.hello',[Posts::class,'addPost']),
            Platform::getFront('homepage',[Posts::class,'addPost']),
            Platform::getFront('pages.hello.top',[Posts::class,'addPost']),
        ];
    }







    public function buildMenu()
    {


    }






}