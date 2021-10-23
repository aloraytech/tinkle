<?php


namespace Config;
use Dotenv\Dotenv;
use Tinkle\Library\Essential\Essential;

class Config
{


    protected Config|array $config;
    protected Client $client;
    protected DBConfig $database;
    protected App $app;
    protected static string $authModel = "App\Models\Auth\Users";

    /**
     * Config constructor.
     */
    public function __construct()
    {
        // Load Environment
        $dotenv = Dotenv::createImmutable(dirname(__DIR__));
        $dotenv->load();
        $this->app = new App();
        $this->client = new Client();
        $this->database = new DBConfig();
        $this->overRideSystem();



    }


    private function overRideSystem()
    {
        /**
         * REMEMBER THIS SETTING USEFULL IF YOU NEED A CUSTOM ENVIRONMENT WHERE YOU DON'T SEND SOME CUSTOM
         * PRE SETTINGS DEFINE IN START UP TINKLE
         */
            return [

            ];

    }





    public function getConfig()
    {
        $this->config ['app']= Essential::getHelper()->JsonToArray($this->app->getConfig());
        $this->config ['db']= $this->database->getConfig();
        $this->config ['client']= Essential::getHelper()->JsonToArray($this->client->getConfig());
        $this->config['userModel'] = self::$authModel;
        return $this->config;
    }








}