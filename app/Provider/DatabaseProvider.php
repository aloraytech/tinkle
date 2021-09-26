<?php
/*
 * Package : DatabaseProvider.php
 * Project : tinkle
 * Created : 22/09/21, 9:39 PM
 * Last Modified : 22/09/21, 9:39 PM
 * Author : Krishanu Bhattacharya
 * Email :krishanu.info@gmail.com
 * Copyright (c) 2021.
 *
 *
 */

namespace App\Provider;

class DatabaseProvider
{
    protected const MYSQL_DRIVER='mysql';
    protected const SQLITE_DRIVER = 'sqlite';
    protected const DEFAULT_MYSQL_PORT =3306;


    public function dbConnections()
    {
        return [
            'tinkle' =>  [
                'driver'=> self::MYSQL_DRIVER,
                'host'=> 'localhost',
                'port'=> self::DEFAULT_MYSQL_PORT
            ],
            'dinkle' =>  '{"driver": "mysql","host": "localhost","port": "3306","name": "dinkle","user": "root","password": ""}',
        ];
    }

//'{"driver": "mysql","host": "localhost","port": "3306","name": "tinkle","user": "root","password": ""}',

}