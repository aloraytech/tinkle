<?php

namespace Tinkle\Database;
use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Events\Dispatcher;
use Illuminate\Container\Container;

class EloquentHandler
{

    protected array $config=[];
    protected object $connection;
    public static object $connect;
    protected static array $availableDrivers = ['mysql','sqlite'];


    private string $activeDB='';



    public function __construct(array $config)
    {

        $this->config = $config;
        $this->connection = new Capsule;
        $this->connection->addConnection([
            'driver' => $this->config[$_ENV['DB_NAME']]['driver'],
            'host' => $this->config[$_ENV['DB_NAME']]['host'],
            'database' => $this->config[$_ENV['DB_NAME']]['database'],
            'username' => $this->config[$_ENV['DB_NAME']]['username'],
            'password' => $this->config[$_ENV['DB_NAME']]['password'],
            'charset' => $this->config[$_ENV['DB_NAME']]['charset'] ?? 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => $this->config[$_ENV['DB_NAME']]['prefix']??'',
        ]);


        $this->connection->setEventDispatcher(new Dispatcher(new Container));

// Make this Capsule instance available globally via static methods... (optional)
        $this->connection->setAsGlobal();

// Setup the Eloquent ORM... (optional; unless you've used setEventDispatcher())
        $this->connection->bootEloquent();
        self::$connect = $this->connection->getConnection();
    }


    public function getConnect()
    {
        return $this->connection->getConnection();
    }





}