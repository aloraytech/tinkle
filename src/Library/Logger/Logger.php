<?php


namespace Tinkle\Library\Logger;


use Tinkle\Tinkle;

class Logger
{


    public static string $message;


    /**
     * @param string $message
     * @param bool $show
     */
    public static function Logit(string $message,bool $show = true)
    {
        self::$message = $message;
        self::makeLog($show);
    }


    public static function Log(string $message,bool $show = false)
    {
        self::$message = $message;
        self::makeLog($show);
    }




    /**
     * @param bool $show
     */
    private static function makeLog(bool $show=true)
    {
        $logfile = self::getLogFile();
        $logfileHandler = fopen($logfile,"a+") or die("Unable to open file!");
        $msg = "[" . date("Y-m-d H:i:s") . "] - " . self::$message . "\n";
        fwrite($logfileHandler,$msg);
        fclose($logfileHandler);

        if (PHP_SAPI === 'cli' && $show != false) {
            echo "\e[35m[" . date("Y-m-d H:i:s") . "] - " . self::$message."\e[0m" . PHP_EOL;
        }

    }


    protected static function getLogFile()
    {
        $logStorage = Tinkle::$ROOT_DIR."storage/logs/";
        if(!is_dir($logStorage))
        {
            if(is_dir(Tinkle::$ROOT_DIR."storage/"))
            {
                mkdir(Tinkle::$ROOT_DIR."storage/logs/");
            }else{
                mkdir(Tinkle::$ROOT_DIR."storage");
                mkdir(Tinkle::$ROOT_DIR."storage/logs/");
            }

        }

        $logfile = $logStorage.date("Y-m-d");


        return $logfile;

    }



}