<?php

namespace Tinkle\Database;

use Tinkle\Exceptions\Display;
use Tinkle\Library\Essential\Essential;
use Tinkle\Tinkle;
use PDO;

class Connection
{

    public \PDO $pdo;
    protected static array $availableDrivers = ['mysql','sqlite'];
    protected static array $config;

    protected string $driver;
    protected string $host;
    protected int $port;
    protected string $name;
    protected string $user;
    protected string $password;
    protected string $charset;
    protected string $prefix;
    private string $activeDB='';
    /**
     * @var bool|\PDOStatement
     */
    private $stmt;
    protected array $options = [\PDO::ATTR_PERSISTENT => true,\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,\PDO::ATTR_EMULATE_PREPARES=>false];


    public function __construct(array $config)
    {

        self::$config = $config;
        $this->prefix = self::$config['prefix'] ?? '';
        $this->driver = self::$config['driver'] ?? '';
        $this->host = self::$config['host'] ?? '';
        $this->charset = self::$config['charset'] ?? '';
        $this->name = self::$config['database'] ?? '';
        $this->user = self::$config['username'] ?? '';
        $this->password = self::$config['password'] ?? '';



        if($this->matchDriver())
        {
            if(strtolower(self::$config['driver']) === 'mysql')
            {
                $this->port = 3306;
                return $this->getMysqlConnection();
            }elseif (strtolower(self::$config['driver']) === 'sqlite')
            {
                $this->port = 0666;
                return $this->getSqlite3Connection();
            }else{
                echo "Database Connection Error";
            }
        }





    }


    public function setDB(string $database)
    {
        $this->activeDB = $database;
        return $this->pdo->exec("USE $database");
    }






    private  function getMysqlConnection()
    {
        //[dsn] => mysql:host=localhost;port=3306;dbname=tinkle
        //$this->pdo = new \PDO($this->dsn,$this->user,$this->password,$this->options);
        try{

            try{
                //$this->pdo = new \PDO("$this->driver:host=$this->host;port=$this->port;dbname=$this->name",$this->user,$this->password,$this->options);

                $this->pdo = new \PDO("$this->driver:host=$this->host;port=$this->port;",$this->user,$this->password,$this->options);

            }catch (\PDOException $e) {
                $msg = '_msg='.$e->getMessage().'&_line='.$e->getline().'&_file='.$e->getFile().'&_code='. $e->getCode().'&_trace='. $e->getTraceAsString();
                throw new Display($msg);
            }

        }catch (Display $e)
        {

            $e->handle();
        } finally {
            return $this->pdo;
        }

    }


    private function getSqlite3Connection()
    {
        $sqlPath = Tinkle::$ROOT_DIR."database/$this->name.sq3";
        if(!file_exists($sqlPath));
        {
            $sqlite = fopen($sqlPath,'w+');
            fclose($sqlite);
        }

        try{

            try{
                $this->pdo = new PDO( "sqlite:$sqlPath",$this->user,$this->password,$this->options);

            }catch (\PDOException $e) {
                $msg = '_msg='.$e->getMessage().'&_line='.$e->getline().'&_file='.$e->getFile().'&_code='. $e->getCode().'&_trace='. $e->getTraceAsString();
                throw new Display($msg);
            }

        }catch (Display $e)
        {

            $e->handle();
        } finally {
            return $this->pdo;
        }

    }








    private function matchDriver()
    {

        if(array_intersect(\PDO::getAvailableDrivers(),self::$availableDrivers,self::$config))
        {
            return true;
        }else{
            return false;
        }

    }


    // METHODS LISTED


    public function dbExist(string $dbName)
    {
        $this->query("SHOW DATABASES");
        $result = $this->resultSet();
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
        $attr = 'Tables_in_'.$this->activeDB;
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
        $this->query("SHOW TABLES");
       return $this->resultSet();
    }

    public function getTable(string $tbl_name)
    {

        if($this->tableExist($tbl_name))
        {

            $this->query("SHOW COLUMNS FROM $tbl_name");
            return $this->resultSet();
        }

        return null;

    }




    public function lastID()
    {
        return $this->pdo->lastInsertId();
    }





    public function query($sql){
        $this->stmt = $this->pdo->prepare($sql);
    }





    // Bind values
    public function bind($param, $value, $type = null){
        if(is_null($type)){
            switch(true){
                case is_int($value):
                    $type = PDO::PARAM_INT;
                    break;
                case is_bool($value):
                    $type = PDO::PARAM_BOOL;
                    break;
                case is_null($value):
                    $type = PDO::PARAM_NULL;
                    break;
                default:
                    $type = PDO::PARAM_STR;
            }
        }

        $this->stmt->bindValue($param, $value, $type);
    }

    // Execute the prepared statement
    public function execute(string|array $array=[]){
        return $this->stmt->execute($array);
    }


    public function debug()
    {
        return $this->stmt->debugDumpParams();
    }




    // Get result set as array of objects
    public function resultSet(string|array $array=[]){
        $this->execute($array);
        return $this->stmt->fetchAll(PDO::FETCH_OBJ);
    }

    // Get single record as object
    public function single(string|array $array=[]){
        $this->execute($array);
        return $this->stmt->fetch(PDO::FETCH_OBJ);
    }

    // Get row count
    public function rowCount(){
        return $this->stmt->rowCount();
    }
    // Get row count
    public function check(){
        if(empty($this->stmt->fetchAll(PDO::FETCH_OBJ))) {
            return false;
        } else {
            return true;
        }

    }






}