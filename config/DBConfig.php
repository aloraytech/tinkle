<?php


namespace Config;


use Tinkle\interfaces\ConfigInterface;

class DBConfig
{


    /**
     * @return array
     */
    public function getConfig(): array
    {

        return [
            'tinkle'=> [
                'dsn' => $_ENV['DB_DSN'],
                'driver'=>$_ENV['DB_DRIVER'],
                'host'=> $_ENV['DB_HOST'],
                'port'=>$_ENV['DB_PORT'],
                'name'=>$_ENV['DB_NAME'],
                'user' => $_ENV['DB_USER'],
                'password' => $_ENV['DB_PASSWORD'],
            ],
            'dinkle'=> [
                'dsn' => $_ENV['DB_DSN'],
                'driver'=>$_ENV['DB_DRIVER'],
                'host'=> $_ENV['DB_HOST'],
                'port'=>$_ENV['DB_PORT'],
                'name'=>$_ENV['DB_NAME'],
                'user' => $_ENV['DB_USER'],
                'password' => $_ENV['DB_PASSWORD'],
            ],
        ];
    }



}