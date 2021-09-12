<?php


namespace App;


use Tinkle\Event;
use Tinkle\Library\Platform\Menu;
use Tinkle\Library\Router\Platform;
use Tinkle\Middlewares\AuthMiddleware;
use Tinkle\Tinkle;

class PlatformProvider
{

    protected array $provider=[];

    public function getPlatformRoutes()
    {

        return [

            'post.hello'=>[
                App::PLATFORM_METHOD => App::GET,
                App::PLATFORM_CALLBACK => [\Plugins\Posts\Posts::class,'getPost'],
            ],


        ];


    }


    public function getMenu()
    {
        return [

            'post.hello'=>[
                App::PLATFORM_MENU => App::GET,
            ],


        ];
    }




    public function getProvider()
    {
        return array_merge_recursive($this->getPlatformRoutes(),$this->getMenu());
    }




}