<?php

namespace Tinkle\Database;
use PDO;
use Tinkle\Exceptions\Display;
use Tinkle\Library\Essential\Essential;
use Tinkle\Library\Essential\Helpers\RegexHandler;
use Tinkle\Tinkle;

class Database
{


    protected Connection $connection;
    public static Database $database;
    protected DBResolver $resolver;

    private string $db='';




    public function __construct(array $config)
    {
        self::$database = $this;
        $this->connection = new Connection();
        $this->resolver = new DBResolver();
        $this->resolver->setConfig($config);
    }



    public function getConnect()
    {
        return $this->connection;
    }



    // Methods

    public function setDefaultConnection()
    {
        $this->db = $_ENV['DB_NAME'];
        $this->connection->setConfig($this->resolver->getConfig($this->db));
        $this->connection->resolve();
        $this->connection->setDB($this->db);
    }




    public function createDB(string $db_name)
    {

        if(is_string($db_name))
        {
            if(Essential::REGEX()->findMatch($db_name,RegexHandler::REGEX_ALPHA_NUMERIC))
            {
                if(!$this->dbExist($db_name) && !$this->resolver->getConfig($db_name) !== null)
                {
                    $this->connection->query("CREATE DATABASE $db_name");
                    if($this->connection->execute())
                    {
                        return true;
                    }
                }
            }

        }
        return false;

    }

    public function set(string $database)
    {
        if($this->resolver->getConfig($database) !== null)
        {
            $this->db = $database;
            $this->connection->setConfig($this->resolver->getConfig($this->db));
            $this->connection->resolve();
            $this->connection->setDB($this->db);
        }
    }


    public function switch(string $database)
    {
        if($this->resolver->getConfig($database) !== null)
        {
            $this->db = $database;
            return $this->connection->setDB($this->db);
        }
    }




    public function export(string $database='')
    {

        throw new Display("Method Not Ready For Use",Display::HTTP_METHOD_NOT_ALLOWED);

    }



    public function dropDB(string $database)
    {
        if($this->dbExist($database))
        {
            $this->connection->query("DROP DATABASE $database");
            if($this->connection->execute())
            {
                return true;
            }
        }
    }







    public function dbExist(string $dbName)
    {
        $this->connection->query("SHOW DATABASES");
        $result = $this->connection->resultSet();
        foreach ($result as $dbDetails)
        {
            if($dbDetails->Database === $dbName)
            {
                return true;
            }
        }
        return false;

    }

    public function tableExist(string $tbl_name)
    {
        $attr = 'Tables_in_'.$this->db;
        $allTable = $this->getAllTables();
        foreach ($allTable as  $table)
        {
            if($tbl_name === $table->$attr)
            {
                return true;
            }
        }
        return false;
    }



    public function columnExist(string $column,string $table)
    {

        $tableDetail = $this->getTable($table);
        foreach ($tableDetail as  $detail)
        {
            if($column === $detail->Field)
            {
                return true;
            }
        }
        return false;
    }





    public function getAllTables()
    {
        $this->connection->query("SHOW TABLES");
        return $this->connection->resultSet();
    }

    public function getTable(string $tbl_name)
    {
        $table = strtolower($tbl_name);
        if($this->tableExist($table))
        {
            $this->connection->query("SHOW COLUMNS FROM $table");
            return $this->connection->resultSet();
        }

        return null;

    }














}