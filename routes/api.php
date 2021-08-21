<?php

use tinkle\framework\Router;




Router::api('user/{id}',[\tinkle\app\controllers\ApiController::class,'user']);

