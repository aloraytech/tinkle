<?php

namespace Tinkle\Database;


use Tinkle\Tinkle;

if(Tinkle::$app->config['db']['db_service_by'] === 'native'){
    class_alias('Tinkle\Database\Database', 'DB_SERVICE');
}
else{
    class_alias('Tinkle\Database\EloquentHandler', 'DB_SERVICE');
}


class DatabaseHandler extends \DB_SERVICE
{




}