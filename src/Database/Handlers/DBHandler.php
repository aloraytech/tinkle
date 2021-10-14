<?php

namespace Tinkle\Database\Handlers;


use Tinkle\Tinkle;

$serviceType = Tinkle::$app->config['db']['db_service_by'] ?? 'native';
if($serviceType != 'native'){
    class_alias('Tinkle\Database\Handlers\Larabase', 'DB_CONNECTION');
}
else{
    class_alias('Tinkle\Database\DB', 'DB_CONNECTION');
}


class DBHandler extends \DB_CONNECTION
{

}