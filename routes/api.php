<?php

use Tinkle\Router;
use Tinkle\Request;




//Router::getApi("category/show/{id}",[\App\controllers\ApiController::class,'category']);
Router::getApi("users",[\App\controllers\ApiController::class,'users']);

Router::getApi("posts/load/{aut_5v}/{id}",[\App\controllers\AppController::class,'load']);

Router::getApi("",[\App\controllers\AppController::class,'load']);
Router::getApi("contact/now",[\App\controllers\AppController::class,'load']);

Router::getApi("users/{id}.{token}.{key}",[\App\controllers\AppController::class,'load']);