<?php

namespace Tinkle\Database\Handlers;

use Tinkle\Tinkle;

    $serviceType = Tinkle::$app->config['db']['db_service_by'] ?? 'native';
    if($serviceType != 'native'){
        class_alias('Tinkle\Database\Handlers\EloquentHandler', 'MODEL_CONNECTION');
    }
    else{
        class_alias('Tinkle\Database\DBAccessor\DBExHandler', 'MODEL_CONNECTION');
    }


class ModelHandler extends \MODEL_CONNECTION
{

}