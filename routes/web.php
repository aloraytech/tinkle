<?php
use tinkle\framework\Router;
require "private.php";
// Still Need A Work
// Escape Full Controller Namespace or use tag.. load it in router with Env Controller Path or From Config

//Tinkle::$app->router->get("pages/show/{author}/{id}",[\tinkle\app\controllers\AppController::class,'load']);
//
//Tinkle::$app->router->get("posts/load/{aut_5v}/{id}",[\tinkle\app\controllers\AppController::class,'load']);
//
//Router::get("pages/view/{id}",[\tinkle\app\controllers\AppController::class,'show']);

Router::get("",[\tinkle\app\controllers\AppController::class,'home']);
Router::get("drive",[\tinkle\app\controllers\AppController::class,'MyFolder']);
Router::post("contact/now",[\tinkle\app\controllers\AppController::class,'contact']);

Router::get("show",[\tinkle\app\controllers\AppController::class,'show']);


