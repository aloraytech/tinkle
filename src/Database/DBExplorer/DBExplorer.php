<?php

namespace Tinkle\Database\DBExplorer;

use Tinkle\Database\Connection;
use Tinkle\Tinkle;

class DBExplorer
{

    protected Connection $connection;

    public function __construct()
    {
        $this->connection = Tinkle::$app->db->getConnect();

    }





}