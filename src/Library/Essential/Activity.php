<?php


namespace Tinkle\Library\Essential;




use Tinkle\Library\Essential\Essential;
use Tinkle\Request;
use Tinkle\Response;
use Tinkle\Tinkle;

class Activity
{

    const PARENT_KEY = 'activity';
    public static Activity $activity;
    public array $userActivity;
    public array $systemActivity;
    private array $allActivity = [];
    private static string $clientIP='';
    private static string $url='';


    /**
     * Activity constructor.
     */
    public function __construct()
    {
        self::$activity = $this;
        self::$clientIP = Tinkle::$app->request->getClientIP();
        self::$url = Tinkle::$app->request->getFullUrl();
    }


    public function resolve()
    {
        $this->allActivity = $this->getAllActivities();
        if(!empty($this->allActivity))
        {
            echo "Has Record";

            if(isset($this->allActivity['lastVisit']['first'])){}





        }else{
            return $this->registerDefaultActivity();
        }
    }








    // GET ALL ACTIVITIES

    public function getAllActivities()
    {
        if(Tinkle::$app->session->hasRecord(self::PARENT_KEY))
        {
            return Essential::getHelper()->JsonToArray(Tinkle::$app->session->getRecord(self::PARENT_KEY));
        }
        return [];
    }


    // REGISTER RECORD MANAGEMENT


    private function registerDefaultActivity()
    {
        if(!Tinkle::$app->session->hasRecord(self::PARENT_KEY))
        {
            return Tinkle::$app->session->setRecord (self::PARENT_KEY,$this->getDefaultActivityData());
        }
        return true;
    }


    private function registerSameActivity()
    {
        return Tinkle::$app->session->updateRecord (self::PARENT_KEY,$this->getSameActivityData());
    }


    private function registerOtherActivity()
    {
        return Tinkle::$app->session->updateRecord (self::PARENT_KEY,$this->getOtherActivityData());
    }











    // HANDLING ACTIVITY DATA

    // DEFAULT ACTIVITY DATA
    private function getDefaultActivityData()
    {
        $data['visit'] = $this->getDefaultVisit();
        $data['lastVisit'] = $this->getDefaultLastVisit();
        return $data;
    }

    private function getDefaultVisit()
    {
        $data[Tinkle::$app->request->getClientIP()] = [
            'url'=> Tinkle::$app->request->getFullUrl(),
            'time'=> microtime(true),
            'method'=> Tinkle::$app->request->getMethod(),
            'isGuest'=>Tinkle::isGuest(),
            'client'=>Tinkle::$app->request->getClientIP(),
            'counter'=>1
        ];
        return $data;
    }

    private function getDefaultLastVisit()
    {
        $data [Tinkle::$app->request->getClientIP()] = [
            'first'=>[],
            'second'=>[],
            'third'=>[],
        ];
        return $data;
    }

    // SAME ACTIVITY DATA
    private function getSameActivityData()
    {
        $data['visit'] = $this->getDefaultVisit();
        $data['lastVisit'] = [];
        return $data;
    }




}