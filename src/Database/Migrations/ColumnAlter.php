<?php


namespace tinkle\framework\Database\Migrations;


class ColumnAlter
{
    public static string $column;
    public static array $details;





    public static function dropColumn(string $string)
    {
        self::$column = " DROP `$string`";
        return new Rule(self::$column);
    }

    public static function fromColumnTo(string $from_Column,string $to_Column,array $_details)
    {
        //self::$column = " CHANGE `$from_Column` `$to_Column`";
        self::$column = " CHANGE `$from_Column` ";
        self::$details = $_details;
        return new ColumnAlter();
    }

    public static function renameIndex(string $string, string $string1)
    {
    }


    public static function after(string $string, Column $param)
    {
    }



    /**
     * @return string
     */
    public function finish()
    {
        return $this->__toString();
    }



    /**
     * @return string
     */
    public function __toString()
    {
        return self::$column .  implode(", ",self::$details);
    }



}