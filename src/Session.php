<?php


namespace tinkle\framework;

use tinkle\framework\Library\Essential\Essential;
use tinkle\framework\Library\Http\SessionHandler;

class Session extends SessionHandler
{


    /**
     * Session constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }











































    // CUSTOM SESSION MANAGEMENT SYSTEM
    // IF YOU DON'T WANNA USE SYMFONY SESSION.. JUST DON'T DO PARENT::__CONSTRUCT() AND EXTEND THIS CLASS
    // AND YOU HAVE TO START SESSION AND DESTROY SESSION MANUALLY;


    /**
     * @param $key
     * @param $value
     * @return string
     */
    public function setRaw($key,$value)
    {
        return $_SESSION['tinkle'][$key]=json_encode($value);
    }

    public function getRaw($key)
    {
        if($this->hasRaw($key))
        {
            return json_decode($_SESSION['tinkle'][$key]);
        }
        return null;

    }

    public function alterRaw($key,$value)
    {
        return $_SESSION['tinkle'][$key]=json_encode($value);
    }

    public function removeRaw($key)
    {
        unset($_SESSION['tinkle'][$key]);
        return true;
    }

    public function hasRaw($key)
    {
        if(isset($_SESSION['tinkle'][$key]) && !empty($_SESSION['tinkle'][$key]))
        {
            return true;
        }else{
            return false;
        }
    }







}