<?php
/**
 * Here Are Listed All Common Helpers..Which can call directly any time anywhere..
 */

use Symfony\Component\VarDumper\VarDumper;
use Tinkle\Tinkle;








function Auth()
{
    if(!\Tinkle\Framework::isGuest())
    {
        return true;
    }else{
        return false;
    }
}


    function eventConfig(int $slot=1, bool $wakeup=false,int $timer=1, int $period_day=1)
    {
        return [
            'slot'=>$slot,
            'wakeup'=>$wakeup,
            'timer'=>$timer,
            'period'=>$period_day,
        ];
    }




if (!function_exists('dryDump')) {
    function dryDump(mixed $param,string $text='Direct Display',$bg_color='yellow',$text_color='black')
{
    if(!empty($param))
    {
        $bg_color = strtolower($bg_color);
        $text_color = strtolower($text_color);

        echo "<div style='background-color: $bg_color; color: $text_color;border-style: solid;'><h1 style='margin: 4px;'>$text:-</h1><pre style='padding: 5px;margin: 5px;'>";
        print_r($param);
        echo "<br></pre></div>";

    }
}
}



if (!function_exists('ddump')) {
    function ddump(...$vars)
    {
        foreach ($vars as $v) {
            VarDumper::dump($v);
        }


    }
}


if (!function_exists('debugIt')) {
    // For Register Debug Process And Time In Debugger For Testing Purpose
    function debugIt(string|array|object $subject, int|string|float $timeTaken='', bool $isDBDebug=false, int $traceLimit=5)
    {
        if (class_exists(\Tinkle\Library\Debugger\Debugger::class)) {
           return \Tinkle\Library\Debugger\Debugger::register($subject,$timeTaken,$isDBDebug,$traceLimit);
        }

    }
}





