<?php


namespace Tinkle;


use Tinkle\Library\Encryption\Hash;

class Token
{


    public static Token $token;
    protected array $sessionToken=[];


    /**
     * Token constructor.
     */
    public function __construct()
    {
        self::$token = $this;


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