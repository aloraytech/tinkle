<?php


namespace Tinkle\Library\Console;

use Tinkle\Tinkle;
use Tinkle\Databases\Database;

class ConsoleModel
{

    public object $pdo;

    public function __construct()
    {
        $this->pdo = Tinkle::$app->db->handler->getConnection()->pdo;

    }


}