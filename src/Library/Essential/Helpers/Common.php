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

//
//    function ddDump()
//    {
//        foreach (func_get_args() as $x) {
//            dump($x);
//        }
//        die;
//    }



    function dryDump($param,$bg_color='yellow',$text_color='black',$title='Direct Display')
    {
        $title = ucfirst($title);
        if(!empty($param))
        {
            $bg_color = strtolower($bg_color);
            $text_color = strtolower($text_color);

            ob_start();
            echo "
<div style='background-color: $bg_color; color: $text_color;border-style: solid; border-width: thick; border-color: black'>
<h2 style='margin: auto;padding: 2px;background-color: $text_color; color: $bg_color;'  align='left'>[ ] $title:-</h2>
<pre style='padding: 5px;word-wrap: break-word;word-break: break-all;'>";
            print_r($param);
            echo "<br></pre></div>";
            ob_end_flush();
            
        }
    }

if (!function_exists('dryDump')) {
    function dryDump($param,$bg_color='yellow',$text_color='black')
{
    if(!empty($param))
    {
        $bg_color = strtolower($bg_color);
        $text_color = strtolower($text_color);

        echo "<div style='background-color: $bg_color; color: $text_color;border-style: solid;'><h1 style='margin: 4px;'>Direct Display:-</h1><pre style='padding: 5px;margin: 5px;'>";
        var_dump($param);
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
    function debugIt(string|array|object $subject, int|string|float $timeTaken='', bool $isDBDebug=false, int $traceLimit=5)
    {
        if (class_exists(\Tinkle\Library\Debugger\Debugger::class)) {
           return \Tinkle\Library\Debugger\Debugger::register($subject,$timeTaken,$isDBDebug,$traceLimit);
        }

    }
}



