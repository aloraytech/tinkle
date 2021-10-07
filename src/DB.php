<?php
/*
 * Package : DB.php
 * Project : tinkle
 * Created : 22/09/21, 9:18 PM
 * Last Modified : 22/09/21, 9:18 PM
 * Author : Krishanu Bhattacharya
 * Email :krishanu.info@gmail.com
 * Copyright (c) 2021.
 *
 *
 */

namespace Tinkle;

if(Tinkle::$app->config['db']['db_service_by'] != 'native'){
    class_alias('Tinkle\Database\EloquentHandler', 'DB_SERVICE');
}
else{
    class_alias('Tinkle\Database\DatabaseHandler', 'DB_SERVICE');
}

class DB extends \DB_SERVICE
{







}