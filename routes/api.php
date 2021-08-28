<?php

use Tinkle\Router;
use Tinkle\Request;


Router::get("",[\App\controllers\AppController::class,'home']);
//    Router::group('admin')->get('posts/item/{id}',[\App\Controllers\AppController::class,'item']);
//    Router::group('admin')->get('pages/item/{id}',[\App\Controllers\AppController::class,'item']);
//    Router::group('admin')->post('posts/item/{id}',[\App\Controllers\AppController::class,'item']);
    Router::get('user/hello',[\App\Controllers\AppController::class,'load']);
    Router::post('posting/hello',[\App\Controllers\AppController::class,'loader']);
    Router::get('posting/hello',[\App\Controllers\AppController::class,'loader']);
    Router::put('user/hello/update',[\App\Controllers\AppController::class,'update']);

    Router::get('posts/name/{id}',function (){echo "Hello World";});
//Router::get('posts/name/{id}',[\App\controllers\AppController::class,'load']);



Router::get("pages/show/{author}/{id}",[\App\controllers\AppController::class,'load']);
//
Router::get("posts/load/{aut_5v}/{id}",[\App\controllers\AppController::class,'load']);


Router::get("",[\App\controllers\AppController::class,'home']);
//Router::any("drive",[\App\controllers\AppController::class,'MyFolder']);
Router::post("contact/now",[\App\controllers\AppController::class,'contact']);

Router::get("api/users/{id}.{token}.{key}",[\App\controllers\AppController::class,'show']);