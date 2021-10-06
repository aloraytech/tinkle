<?php

namespace Tinkle\Database;

class Database
{

    private array $allDbConfig=[];
    private array $currentDbConfig=[];
    private string $dsn='';
    private Connection $connection;

    public function __construct(array $config)
    {
        $this->allDbConfig = $config;

        $this->currentDbConfig = $this->getCurrentDbConfig();
        $this->connection = $this->connect($this->currentDbConfig);
        $this->setDefaultDB();




    }



    public function getConnect()
    {
        $this->connection->pdo;
    }



    public function switchDB(string $database_name='')
    {

        return $this->connection->setDB($database_name);
    }






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

    private function setDefaultDB(string $database_name='')
    {

        return $this->connection->setDB($_ENV['DB_NAME']);
    }









}