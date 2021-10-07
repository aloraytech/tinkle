<?php

namespace Tinkle\Database;

class DatabaseHandler extends Database
{


    public function select(string $query,array $binding=[])
    {
        self::$connect->getConnect()->query($query);
        return self::$connect->getConnect()->resultSet($binding);
    }







}