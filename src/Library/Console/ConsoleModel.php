<?php


namespace Tinkle\Library\Console;

use Tinkle\Tinkle;
use Tinkle\Database\Database;

class ConsoleModel extends Database
{

    public function __construct()
    {
        parent::__construct(Tinkle::$app->config['db']);
    }

}