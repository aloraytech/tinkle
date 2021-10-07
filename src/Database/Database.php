<?php

namespace Tinkle\Database;
use PDO;
use Tinkle\Tinkle;

class Database
{

    private array $allDbConfig=[];
    private array $currentDbConfig=[];
    private string $dsn='';
    private object $connection;
    private \PDOStatement|bool $stmt;
    private string $currentDB='';
    public static Database $database;
    private string|int $processing_time='';
    public static object $connect;

    public function __construct(array $config)
    {
        $this->processing_time = microtime(true);
        self::$database = $this;
        $this->allDbConfig = $config;

        if(empty($this->currentDbConfig))
        {
            $this->currentDbConfig = $this->getCurrentDbConfig();
        }

        $this->connection = $this->connect($this->currentDbConfig);
        $this->setDefaultDB();
        self::$connect = $this->connection;

    }



    public function getConnect()
    {
        return $this->connection;
    }

    /**
     * @return string
     */
    public function getCurrentDB()
    {
        return $this->currentDB;
    }


    /**
     * @return array
     */
    public function getCurrentDBDetails()
    {
        $tables = $this->connection->getAllTables();
        return [
            'database'=> $this->currentDB,
            'tables'=> $tables,
            'count'=>count($tables),
            'timeTaken'=>microtime(true)-$this->processing_time,
        ];
    }






    public function switchDB(string $database_name='')
    {
        $this->currentDB = $database_name;
        return $this->connection->setDB($this->currentDB);
    }


    public function switchToExternalDB(string $database_name='')
    {
        $this->currentDB = $database_name;
        $this->currentDbConfig = $this->getCurrentDbConfig();
        $this->connection = $this->connect($this->currentDbConfig);
        return $this->connection->setDB($this->currentDB);
    }



    // Database Base Methods














































    // PRIVATE METHODS FOR DATABASE

    private function connect(array $dbConfig)
    {
        $this->connection = new Connection($dbConfig);
        return $this->connection;
    }



    /**
     * @param string $database_name
     * @return array
     */
    private function getCurrentDbConfig(string $database_name='')
    {
        if(empty($database_name))
        {
            $database_name = $_ENV['DB_NAME'];
        }
        return $this->allDbConfig[$database_name] ?? null;
    }

    private function setDefaultDB()
    {
        $this->currentDB = $_ENV['DB_NAME'];
        return $this->connection->setDB($this->currentDB);
    }









}