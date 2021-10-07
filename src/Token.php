<?php


namespace Tinkle;


use Tinkle\Library\Encryption\Hash;

class Token
{


    public static Token $token;
    protected array $sessionToken=[];
    private string $sys_token='';


    /**
     * Token constructor.
     */
    public function __construct()
    {
        self::$token = $this;
        $this->sys_token = Hash::generate(microtime(true).random_bytes(55));
        Tinkle::$app->session->set('sys_token',$this->sys_token);
    }


    public function create()
    {

    }

    public static function generate()
    {

    }

    public function isValid()
    {

    }

    public function has()
    {

    }













}