<?php

namespace Tinkle\Database;

use Tinkle\Database\DBExplorer\DBExplorer;
use Tinkle\Tinkle;

if(Tinkle::$app->config['db']['db_service_by'] != 'native'){
    class_alias('Illuminate\Database\Eloquent\Model', 'ORM_SERVICE');
}
else{
    class_alias('Tinkle\Database\DBExplorer\DBExplorer', 'ORM_SERVICE');
}

class ModelHandler extends \ORM_SERVICE
{




}