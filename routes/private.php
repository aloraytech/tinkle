<?php

use tinkle\framework\Router;

/**
 * Routers For Auth Management
 */

Router::get('login',[\tinkle\app\controllers\AuthController::class,'login']);
Router::post('login',[\tinkle\app\controllers\AuthController::class,'login']);

Router::get('register',[\tinkle\app\controllers\AuthController::class,'register']);
Router::post('register',[\tinkle\app\controllers\AuthController::class,'register']);



Router::get("-@tinkle-admin",[\tinkle\framework\Library\Developer\Developer::class,'devLogin']);
Router::post("tinkle-admin/register",[\tinkle\framework\Library\Developer\Developer::class,'devDashboard']);

