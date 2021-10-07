<?php

namespace Tinkle\Database;

use JetBrains\PhpStorm\Pure;
use Tinkle\Tinkle;

class DBModel
{

    private Database $db;

    #[Pure] public function __construct()
    {
        $this->db = Tinkle::$app->db->getConnect();
    }








}