<?php


namespace tinkle\framework;


use tinkle\framework\Library\Encryption\Hash;

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












}