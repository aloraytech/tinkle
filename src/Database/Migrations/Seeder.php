<?php


namespace Tinkle\Database\Migrations;


class Seeder
{

    private static string $table='';
    private static array $_details=[];
    private static string $column='';
    private static string $attributes='';
    private static array $query=[];

    public static function table(string $_table)
    {
        self::$table = $_table;
        return new Seeder();
    }

    public  function insert(array $_details=[])
    {
        self::$_details = $_details;
        return new Seeder();
    }



    public function finish()
    {


        foreach (self::$_details as $details)
        {
            self::$query [] = 'INSERT INTO `'.self::$table.'`('.$this->getColumns($details).') VALUES ('.$this->getAttributes($details).');';
        }

        return self::$query;
    }




    private function getColumns(array $details)
    {
        $array = [];
        foreach ($details as $key => $val)
        {
            $array []= "`$key`";
        }
        return implode(", ",$array);
    }

    private function getAttributes(array $details)
    {
        $array = [];
        foreach ($details as $key => $val)
        {
            $array []= "'$val'";
        }
        return implode(", ",$array);
    }




    public function __toString()
    {
        return implode(', ',self::$query);
    }


}