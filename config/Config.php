<?php


namespace tinkle\config;
use Dotenv\Dotenv;
use tinkle\app\models\UsersModel;

class Config
{


    protected array $config;

    /**
     * Config constructor.
     */
    public function __construct()
    {
        // Load Environment
        $dotenv = Dotenv::createImmutable(dirname(__DIR__));
        $dotenv->load();
        $this->getDBConfig();
        $this->getAppConfig();
        $this->getClientConfig();
        $this->getSecurityConfig();

    }


    protected function getDBConfig()
    {
        $this->config['db']= [
            'dsn' => $_ENV['DB_DSN'],
            'driver'=>$_ENV['DB_DRIVER'],
            'host'=> $_ENV['DB_HOST'],
            'port'=>$_ENV['DB_PORT'],
            'name'=>$_ENV['DB_NAME'],
            'user' => $_ENV['DB_USER'],
            'password' => $_ENV['DB_PASSWORD'],
        ];
    }

    protected function getAppConfig()
    {
        $this->config['application'] =[
            'production' => false
        ];
    }

    protected function getClientConfig()
    {

    }

    protected function getSecurityConfig()
    {
        $this->config['userClass'] = "tinkle\app\models\UsersModel";
        //$this->config['userClass'] = new UsersModel();
        $this->config['security'] = [
            'spellCheck' => false,
            'imageBase64'=> true,
            'cache' => true,
            'autoToken'=>true,

        ];
    }


    public function getConfig()
    {
        return $this->config;
    }








}