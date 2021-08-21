<?php


namespace tinkle\framework\Library\Logger;


use tinkle\framework\Tinkle;

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
        $root = $_SERVER['ROOT_PATH'] ?? Tinkle::$ROOT_DIR.'/';
        $logfile = $root."storage/logs/".date("Y-m-d");
        $logfileHandler = fopen($logfile,"a+") or die("Unable to open file!");
        $msg = "[" . date("Y-m-d H:i:s") . "] - " . self::$message . "\n";
        fwrite($logfileHandler,$msg);
        fclose($logfileHandler);

        if (PHP_SAPI === 'cli' && $show != false) {
            echo "\e[35m[" . date("Y-m-d H:i:s") . "] - " . self::$message."\e[0m" . PHP_EOL;
        }

    }




}