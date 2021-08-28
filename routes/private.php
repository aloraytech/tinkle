<?php

use Tinkle\Router;

/**
 * Routers For Auth Management
 */

Router::get('login',[\App\controllers\AuthController::class,'login']);
Router::post('login',[\App\controllers\AuthController::class,'login']);

Router::get('register',[\App\controllers\AuthController::class,'register']);
Router::post('register',[\App\controllers\AuthController::class,'register']);



//Router::get("-@tinkle-admin",[\Tinkle\Library\Developer\Developer::class,'devLogin']);
//Router::post("tinkle-admin/register",[\Tinkle\Library\Developer\Developer::class,'devDashboard']);

