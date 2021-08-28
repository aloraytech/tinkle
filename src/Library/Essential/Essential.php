<?php


namespace Tinkle\Library\Essential;

use Tinkle\Exceptions\Display;
use Tinkle\Library\Essential\Helpers\Faker;
use Tinkle\Library\Essential\Helpers\Helper;
use Tinkle\Library\Essential\Helpers\RegexHandler;
use Tinkle\Library\Essential\Helpers\StringHandler;
use Tinkle\Library\Essential\Token;
use Tinkle\Tinkle;

class Essential
{
    public static Helper $helper;
    public static RegexHandler $regex;
    public static StringHandler $str;
    public static Faker $faker;

    /**
     * Essential constructor.
     */
    public function __construct()
    {
        self::$helper = self::getHelper();
        self::$regex = new RegexHandler();
        self::$str = new StringHandler();
        self::$faker = new Faker();
    }


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