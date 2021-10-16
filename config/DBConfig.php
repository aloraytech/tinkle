<?php
namespace Config;
use Tinkle\interfaces\ConfigInterface;
class DBConfig
{

    private const NATIVE_DB_HANDLER='native';
    private const ELOQUENT_DB_HANDLER='eloquent';

    /**
     * @return array
     */
    public function getConfig(): array
    {

        return [
            'db_service_by'=> self::NATIVE_DB_HANDLER,
            'tinkle'=> [
                'driver'=>$_ENV['DB_DRIVER'],
                'host'=> $_ENV['DB_HOST'],
                'database'=>$_ENV['DB_NAME'],
                'username' => $_ENV['DB_USER'],
                'password' => $_ENV['DB_PASSWORD'],
                'charset' => 'utf8',
                'collation' => 'utf8_unicode_ci',
                'prefix' => '',
            ],
            'dinkle'=> [
                'driver'=>$_ENV['DB_DRIVER'],
                'host'=> $_ENV['DB_HOST'],
                'database'=>$_ENV['DB_NAME'],
                'username' => $_ENV['DB_USER'],
                'password' => $_ENV['DB_PASSWORD'],
                'charset' => 'utf8',
                'collation' => 'utf8_unicode_ci',
                'prefix' => '',
            ],
        ];
    }



}