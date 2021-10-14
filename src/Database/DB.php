<?php

namespace Tinkle\Database;

class DB  extends Database
{


    public function __construct(array $config)
    {
        parent::__construct($config);
    }




    public static function select(string $query, array $binding=[])
    {
        self::$database->getConnect()->query($query);
        return self::$database->getConnect()->resultSet($binding);
    }



}