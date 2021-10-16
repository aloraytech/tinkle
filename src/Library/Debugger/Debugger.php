<?php

namespace Tinkle\Library\Debugger;

use Tinkle\Tinkle;

class Debugger
{

    private const DEBUG_DB='dbQueries';
    private const DEBUG='methodOrFunctions';


    public static array $debugBag=[];
    private static string $loadOn='';



    public function __construct()
    {
        if(!isset(self::$debugBag[self::DEBUG])){ self::$debugBag[self::DEBUG] = [];}
        if(!isset(self::$debugBag[self::DEBUG_DB])){ self::$debugBag[self::DEBUG_DB] = [];}
    }

    public function set(string|array|object $subject, int|string|float $timeTaken='', bool $isDBDebug=false, int $traceLimit=5)
    {
        return self::register($subject,$timeTaken,$isDBDebug,$traceLimit);
    }

    public static function register(string|array|object $subject, int|string|float $timeTaken='', bool $isDBDebug=false, int $traceLimit=5)
    {
        $startOn = Tinkle::$app->config['app']['startOn'];
        if($isDBDebug)
        {
            $debugType = self::DEBUG_DB;
        }else{
            $debugType=self::DEBUG;
        }

        if(empty($timeTaken))
        {
            $timeTaken = microtime(true) - $startOn .' approx sec ';
        }

        $trace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS,$traceLimit);
        unset($trace[0]);
        if(isset($trace[1]['function']))
        {
            if(function_exists('debugIt'))
            {
                if($trace[1]['function'] === 'debugIt')
                {
                    unset($trace[1]);
                }
            }
        }

//        $trace = array_map(fn($attr) => "$attr", $trace);


        // Subject
        if(is_string($subject))
        {
            $subject = trim(str_replace("\n",'; ',$subject));
        }

        if(is_array($subject))
        {
            $subject = array_map(fn($attr) => ";$attr", $subject);
        }



        self::$debugBag[$debugType][]= [
            'debug_on' =>trim(str_replace("\n",'; ',$subject)),
            'time_taken'=>$timeTaken,
            'trace' =>$trace,
        ];

    }







    public static function get()
    {
        $maxTime = 2;
        $netTime= microtime(true)-Tinkle::$app->config['app']['startOn'];
        $leftTime = $maxTime - number_format((float)$netTime, 4, '.', '');
        return [
            'max_time'=> $maxTime . ' seconds only',
            'time_consume'=> number_format((float)$netTime, 4, '.', '').' seconds only',
            'time_left'=>$leftTime . ' seconds only',
            'debug'=>self::$debugBag,
        ];
    }

    public static function display()
    {
        ddump(self::get());
    }


}