<?php

namespace Tinkle\Database\Migrations;

/**
 * Class Column
 * @package Tinkle\Database\Migrations
 */
class Column
{

    public static string $column;
    public static string $table;

//CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci
//    /**
//     * Column constructor.
//     * @param string $table
//     */
//    public function __construct(string $table)
//    {
//        self::$table = $table;
//    }

    /**
     * @param string $string
     * @param int $length
     * @return Rule
     */
    public function id(string $string,int $length=11)
    {
        self::$column = "`$string` INT($length)";
        return new Rule(self::$column);
    }

    /**
     * @param string $string
     * @param int $length
     * @return Rule
     */
    public static function string(string $string,int $length=255)
    {
        self::$column = "`$string` VARCHAR($length)";
        return new Rule(self::$column);
    }

//    public static function timestamp(string $string)
//    {
//        return new Rule();
//    }

    /**
     * @param string $string
     * @return Rule
     */
    public static function text(string $string)
    {
        //self::$column = "`$string` TEXT($length)";
        self::$column = "`$string` TEXT";
        return new Rule(self::$column);
    }

    /**
     * @param string $string
     * @param array $array
     * @return Rule
     */
    public static function enum(string $string, array $array)
    {
        return new Rule($array);
    }


    public static function rememberToken()
    {
    }

    /**
     * @param string $string
     * @return Rule
     */
    public static function timestamps(string $string)
    {
        self::$column = "`$string` TIMESTAMP";
        return new Rule(self::$column);
    }

    /**
     * @param string $string
     * @param int $length
     * @return Rule
     */
    public static function integer(string $string,int $length=11)
    {
        self::$column = "`$string` INT($length)";
        return new Rule(self::$column);
    }

    /**
     * @param string $string
     * @param int $length
     * @return Rule
     */
    public static function tinyInteger(string $string,int $length=1)
    {
        self::$column = "`$string` TINYINT($length)";
        return new Rule(self::$column);
    }


    /**
     * @param string $string
     * @param int $length
     * @return Rule
     */
    public static function bigIncrements(string $string,int $length=20)
    {

         self::$column = "`$string` BIGINT($length)";
        return new Rule(self::$column);
    }


    /**
     * @param string $string
     * @return Rule
     */
    public static function mediumText(string $string)
    {
        self::$column = "`$string` MEDIUMTEXT";
        return new Rule(self::$column);
    }

    /**
     * @param string $string
     * @return Rule
     */
    public static function longText(string $string)
    {
        self::$column = "`$string` LONGTEXT";
        return new Rule(self::$column);
    }

    public static function temporary()
    {
    }

    public static function char(string $string, int $int)
    {
    }

    public static function foreignId(string $string)
    {
    }

//    public static function increments(string $string)
//    {
//        self::$column = "`$string` AUTO INCREMENT";
//        return new Rule(self::$column);
//    }

    /**
     * @param string $string
     * @return Rule
     */
    public function json(string $string)
    {
        self::$column = "`$string` JSON";
        return new Rule(self::$column);
    }



    /**
     * @param string $string
     * @return Rule
     */
    public static function boolean(string $string)
    {
        self::$column = "`$string` BOOLEAN";
        return new Rule(self::$column);
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
        return self::$column;
    }



}