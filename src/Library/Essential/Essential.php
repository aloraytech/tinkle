<?php


namespace tinkle\framework\Library\Essential;

use tinkle\framework\Exceptions\Display;
use tinkle\framework\Library\Essential\Helpers\Helper;
use tinkle\framework\Library\Essential\Helpers\RegexHandler;
use tinkle\framework\Library\Essential\Helpers\StringHandler;
use tinkle\framework\Library\Essential\Token;
use tinkle\framework\Tinkle;

class Essential
{

    public static function init()
    {
        $common = __DIR__."/Helpers/Common.php";
        try{
            if(file_exists($common))
            {
                require "$common";
                return true;
            }else{
                throw new Display('Tinkle Common Helper File Not Found',500);
                return false;
            }
        }catch (Display $e)
        {
            $e->Render();
        }




    }

    public static function getHelper()
    {
        return new Helper();
    }


    public static function getWatcher()
    {
        return new Watcher();
    }

    public static function REGEX()
    {
        return new RegexHandler();
    }

    public static function STR()
    {
        return new StringHandler();
    }

    public static function Faker(int $length=0)
    {
        return new Faker($length);
    }






    // Class End
}