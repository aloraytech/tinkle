<?php

namespace Tinkle\Database;

use Tinkle\Exceptions\Display;
use Tinkle\Tinkle;

class Connection
{

    public \PDO $pdo;
    protected static array $availableDrivers = ['mysql','sqlite'];
    protected static array $config;
    protected string $dsn;
    protected string $driver;
    protected string $host;
    protected int $port;
    protected string $name;
    protected string $user;
    protected string $password;
    /**
     * @var bool|\PDOStatement
     */
    private $stmt;
    protected array $options = [\PDO::ATTR_PERSISTENT => true,\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,\PDO::ATTR_EMULATE_PREPARES=>false];


    public function __construct(array $config)
    {

        self::$config = $config;

        $this->driver = self::$config['driver'] ?? '';
        $this->dsn = self::$config['dsn'] ?? '';
        $this->host = self::$config['host'] ?? '';
        $this->port = self::$config['port'] ?? 0;
        $this->name = self::$config['name'] ?? '';
        $this->user = self::$config['user'] ?? '';
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









}