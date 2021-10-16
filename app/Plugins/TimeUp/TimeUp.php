<?php

namespace Plugins\TimeUp;

use Tinkle\Exceptions\Display;
use Tinkle\Tinkle;

class TimeUp
{


    /**
     * @throws Display
     */
    public function maxTimeup()
    {
        $timeLeft = microtime(true) - Tinkle::$app->config['app']['startOn'];
        if($timeLeft > 2)
        {
            throw new Display("Max Execution Limit Over, <br> Please Try Again,",503);
            exit(0);
        }
    }





}