<?php

namespace Plugins\Debugger;

use Tinkle\Plugins;
use Tinkle\Tinkle;

class Debugger extends Plugins
{

    public function show()
    {
        return \Tinkle\Library\Debugger\Debugger::display();
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