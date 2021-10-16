<?php

namespace Tinkle\Database\Drivers;

use Tinkle\Exceptions\Display;

class MySqlDriver
{

    public \PDO $pdo;
    private static array $config;
    private string $driver;
    private string $host;
    private int $port = 3306;
    private string $name;
    private string $user;
    private string $password;
    private string $charset;
    private string $prefix;
    private string $activeDB='';

    private array $options = [\PDO::ATTR_PERSISTENT => true,\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,\PDO::ATTR_EMULATE_PREPARES=>false];

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

        try{

            try{
                //$this->pdo = new \PDO("$this->driver:host=$this->host;port=$this->port;dbname=$this->name",$this->user,$this->password,$this->options);

                $this->pdo = new \PDO("$this->driver:host=$this->host;port=$this->port;charset=$this->charset",$this->user,$this->password,$this->options);


            }catch (\PDOException $e) {
                $msg = '_msg='.$e->getMessage().'&_line='.$e->getline().'&_file='.$e->getFile().'&_code='. $e->getCode().'&_trace='. $e->getTraceAsString();
                throw new Display($msg);
            }

        }catch (Display $e)
        {

            $e->handle();
        }


    }

    public function getConnect()
    {
        return $this->pdo;
    }





}