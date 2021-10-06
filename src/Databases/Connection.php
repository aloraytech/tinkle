<?php

namespace Tinkle\Databases;

use Tinkle\Databases\Access\Access;
use Tinkle\Tinkle;

class Connection
{

    public Connection $connection;

    public function __construct()
    {
        $this->connection = Tinkle::$app->db->handler->getConnection();
    }

}