<?php

namespace Tinkle\Database\Handlers;

use Illuminate\Container\Container;
use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Events\Dispatcher;
use Tinkle\Library\Essential\Essential;
use Tinkle\Library\Essential\Helpers\RegexHandler;

class Larabase
{

    private Capsule $capsule;
    public static Larabase $database;
    public object $connection;
    private static array $availableDrivers = ['mysql','sqlite'];
    private array $dbBag=[];
    private string $db='';

    private string $activeDB='';



    public function __construct(array $config)
    {
        self::$database = $this;
        $this->dbBag = $config;
        $this->capsule = new Capsule;

    }


    public function getConnect()
    {
        return $this->capsule->getConnection();
    }


    private function resolve(array $config)
    {
        $this->capsule->addConnection([
            'driver' => $config['driver'],
            'host' => $config['host'],
            'database' => $config['database'],
            'username' => $config['username'],
            'password' => $config['password'],
            'charset' => $config['charset'] ?? 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => $config['prefix']??'',
        ]);

        $this->capsule->setEventDispatcher(new Dispatcher(new Container));
// Make this Capsule instance available globally via static methods... (optional)
        $this->capsule->setAsGlobal();
// Setup the Eloquent ORM... (optional; unless you've used setEventDispatcher())
        $this->capsule->bootEloquent();
        $this->connection = $this->capsule->getConnection();
    }

    private function getDefaultConfig()
    {
        $this->db = $_ENV['DB_NAME'];
        if(isset($this->dbBag[$this->db]))
        {
            return $this->dbBag[$this->db];
        }
        return [];
    }


    public function setDefaultConnection()
    {
        $this->resolve($this->getDefaultConfig());
    }



    public function switch(string $dbName)
    {
        $this->db = $dbName;
        if(isset($this->dbBag[$this->db]))
        {
            return $this->connection->setDatabaseName($this->db);
        }
            return false;
    }


    public function createDB(string $db_name)
    {
        if(Essential::REGEX()->findMatch($db_name,RegexHandler::REGEX_ALPHA_NUMERIC))
        {
            if(!isset($this->dbBag[$db_name]))
            {
                if($this->connection->getPdo()->exec("CREATE DATABASE $db_name"))
                {
                    return true;
                }
            }
        }

        return false;
    }

    public function dropDB(string $db_name)
    {
        if(isset($this->dbBag[$db_name]))
        {
            if($this->dbExist($db_name))
            {
                if($this->connection->getPdo()->exec("DROP DATABASE $db_name"))
                {
                    return true;
                }else{
                    return false;
                }
            }else{
                return true;
            }
        }else{
            return true;
        }

    }

    public function dbExist(string $dbName)
    {
        $result = $this->connection->getPdo()->query("SHOW DATABASES")->fetchAll();

        foreach ($result as $dbDetails)
        {
            if($dbDetails['Database'] === $dbName)
            {
                return true;
            }
        }
        return false;

    }


}