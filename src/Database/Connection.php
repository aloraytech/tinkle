<?php

namespace Tinkle\Database;

use Tinkle\Database\Drivers\MySqlDriver;
use Tinkle\Database\Drivers\SqliteDriver;
use Tinkle\Exceptions\Display;
use Tinkle\Library\Debugger\Debugger;
use Tinkle\Library\Essential\Essential;
use Tinkle\Tinkle;
use PDO;

class Connection
{

    protected \PDO $pdo;
    private \PDOStatement $stmt;
    protected static Connection $connection;
    private static array $availableDrivers = ['mysql','sqlite'];
    private static array $config;
    private string $database='';


    private string $_time='';
    private string $prefix='';


    public function __construct()
    {
        $this->_time = microtime(true);
        self::$connection = $this;
    }




    public function setConfig(array $config)
    {
        self::$config = $config;
        $this->prefix = self::$config['prefix'] ?? '';
    }


    public function resolve()
    {
        if($this->matchDriver())
        {
            if(strtolower(self::$config['driver']) === 'mysql')
            {
                $connect = new MySqlDriver(self::$config);
                $this->pdo = $connect->getConnect();

            }elseif (strtolower(self::$config['driver']) === 'sqlite')
            {
                $connect = new SqliteDriver(self::$config);
                $this->pdo = $connect->getConnect();
            }else{
                echo "Database Connection Error";
            }
        }
    }



    public function setDB(string $database)
    {
        $this->database = $database;
        return $this->exec("USE ".$this->database);
    }

    public function getDB()
    {
        return $this->database;
    }

    public function getConnectionName()
    {
        if($this->database === $_ENV['DB_NAME'])
        {
            return 'default';
        }else{
            return $this->database;
        }
        return 'undefined';
    }


    /**
     * @return PDO
     */
    public function getPdo()
    {
        return $this->pdo;
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




    // METHODS WITH PDO

    public function prepare(string $sql)
    {
        $this->_time = microtime(true);
        $this->pdo->prepare($sql);
    }

    public function exec($statement)
    {
        $time = microtime(true) - $this->_time;
        debugIt($statement,$time,true);
        return $this->pdo->exec($statement);
    }


    public function lastID()
    {
        return $this->pdo->lastInsertId();
    }






    // METHODS WITH PDO STATEMENT

    public function query(string $sql){
        $this->_time = microtime(true);
        $this->stmt = $this->pdo->prepare($sql);
    }



// Bind values
    public function bind($param, $value, $type = null){
        if(is_null($type)){
            $type = match (true) {
                is_int($value) => PDO::PARAM_INT,
                is_bool($value) => PDO::PARAM_BOOL,
                is_null($value) => PDO::PARAM_NULL,
                default => PDO::PARAM_STR,
            };
        }

       $this->stmt->bindValue($param, $value, $type);
    }



    // Execute the prepared statement
    public function execute(){
        $time = microtime(true) - $this->_time;
        debugIt($this->debug(),$time,true);
         return $this->stmt->execute();
    }


    public function executeWith(array $array=[]){
        $time = microtime(true) - $this->_time;
        debugIt($this->debug(),$time,true);
        return $this->stmt->execute($array);
    }



    // Get result set as array of objects
    public function resultSet(){
        $this->execute();
        return $this->stmt->fetchAll(PDO::FETCH_OBJ);
    }

    // Get single record as object
    public function single(){
        $this->execute();
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


    public function close(string $conID='')
    {
        $conID = $conID ?? $this->getConnectionID();
        return $this->query("KILL CONNECTION_ID($conID)");
    }


    public function getStatus()
    {
        return [
            'CONNECTION_ID' => $this->getConnectionID(),
            'STATUS'=>$this->getConStatus(),
            'SCHEMA'=>$this->getSchema(),
            'PROCESS_LIST'=>$this->getProcess(),
        ];
    }

    private function getConnectionID()
    {
        $this->query("SELECT  CONNECTION_ID();");
        return array_values(Essential::getHelper()->ObjectToArray($this->single()))[0];
    }



    private function getConStatus()
    {
        $statusData = [];
        $this->query("show status like '%onn%';");
        $allStatus=  $this->resultSet();
        foreach ($allStatus as $key => $value)
        {
            $statusData[$value->Variable_name] = $value->Value;
        }
        return $statusData;


        //$status = $this->exec("show status like '%onn%';");
//        $processList = $this->exec("SHOW PROCESSLIST");
//        $this->query("SELECT * FROM INFORMATION_SCHEMA.PROCESSLIST WHERE DB = :db;");
//        $this->bind(':db',$this->database);
//        $dbSchema = $this->resultSet();
//        return [
//          'status'=> $status ?? [],
//          'process'=>$processList ?? [],
//          'schema'=>$dbSchema ?? [],
//        ];
    }

    private function getProcess()
    {
        $processData = [];
        $this->query("SHOW PROCESSLIST");
        $allList = $this->resultSet();
        foreach ($allList as $key => $listValue)
        {
            $processData[$listValue->User][]=$listValue;
        }
        return $processData;
    }


    private function getSchema()
    {
        $schemaData=[];
        $this->query("SELECT * FROM INFORMATION_SCHEMA.PROCESSLIST WHERE DB = :db;");
        $this->bind(':db',$this->database);
        $dbSchema = $this->resultSet();

        foreach ($dbSchema as $key =>$schema)
        {
            $schemaData[$schema->USER][] = $schema;
        }

        return $schemaData;
    }













    public function debug()
    {
        ob_start();
        $this->stmt->debugDumpParams();
        $debugDetail = ob_get_contents();
        ob_end_clean();
        return $debugDetail;
    }







}