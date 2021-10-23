<?php

namespace Plugins\Debugger;

use Tinkle\Plugins;
use Tinkle\Tinkle;

class Debugger extends Plugins
{

    public function show()
    {
        echo "<div style='background-color: blueviolet'> <h3 style='color: white;padding: 2px;margin: 2px;'>Tinkle Debugger</h3> ";
        \Tinkle\Library\Debugger\Debugger::display();
        echo "</div>";
    }


   public function set(string|array|object $subject, int|string|float $timeTaken='', bool $isDBDebug=false, int $traceLimit=5)
   {
       \Tinkle\Library\Debugger\Debugger::register($subject,$timeTaken,$isDBDebug,$traceLimit);
   }

   public function get()
   {
       return \Tinkle\Library\Debugger\Debugger::get();
   }



}