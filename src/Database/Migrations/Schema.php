<?php


namespace Tinkle\Database\Migrations;

use Tinkle\Tinkle;

/**
 * Class Schema
 * @package Tinkle\Database\Migrations
 */
class Schema
{
    private static string $columnQuery='';
    private static int $attempt = 0;
    private static string $charset = ' CHARACTER SET utf8mb4';
    private static string $collate = ' COLLATE utf8mb4_general_ci';
    /**
     * @var string
     */
    public static string $table;
    /**
     * @var array
     */
    public static array $details;
    /**
     * @var string
     */
    private static string $_mysqlStart = "";
    /**
     * @var string
     */
    private static string $_mysqlEnd = "";


    /**
     * @param string $_table
     * @param array $details
     * @return Schema
     */
    public static function create(string $_table,array $details)
    {
        self::setAttempt(0);
        self::$table = $_table;
        self::$details = $details;
        return new Schema();
    }



    public static function alter(string $_table,array $details)
    {
        self::setAttempt(1);
        self::$table = $_table;
        self::$details = $details;
        return new Schema();
    }

    public static function dropIfExist(string $_table)
    {
        self::setAttempt(2);
        self::$table = $_table;
        self::$details = [];
        return new Schema();
    }











    private static function getTableQuery()
    {
        if(self::$attempt = 1)
        {
            return  implode(", ",self::$details);
        }elseif(self::$attempt = 2){
            return '';
        }else{
            if(self::$attempt = 0)
            {
                return  implode(", ",self::$details);
            }
        }
    }




    private static function setAttempt(int $attempt)
    {
        self::$attempt = $attempt;
    }



    private static function getFormat()
    {

        if (self::$attempt ===1)
        {
            // Alter Table
            if(strtolower(Tinkle::$app->config['db']['driver']) === 'mysql')
            {
                self::$_mysqlStart = "ALTER TABLE ".self::$table;
                self::$_mysqlEnd = ";";
                return true;
            }else{
                echo "Error: Sqlite Format To Be Implemented. Not Found Error!";
                return false;
            }
        }elseif (self::$attempt === 2)
        {
            // Delete Table
            if(strtolower(Tinkle::$app->config['db']['driver']) === 'mysql')
            {
                self::$_mysqlStart = "DROP TABLE IF EXISTS ".self::$table ;
                self::$_mysqlEnd = ";";
                return true;
            }else{
                echo "Error: Sqlite Format To Be Implemented. Not Found Error!";
                return false;
            }
        }else{
            if (self::$attempt ===0)
            {
                // Create Table
                if(strtolower(Tinkle::$app->config['db']['driver']) === 'mysql')
                {
                    self::$_mysqlStart = "CREATE TABLE IF NOT EXISTS ".self::$table ." (";
                    self::$_mysqlEnd = ") ENGINE = InnoDB;";
                    return true;
                }else{
                    echo "Error: Sqlite Format To Be Implemented. Not Found Error!";
                    return false;
                }

            }else{
                echo "Error : Unexpected Migration Attempt ".self::$attempt;
                return false;
            }

        }



    }



    /**
     * @return string
     */
    public function finish()
    {

        if(self::getFormat())
        {
            return $this->__toString();
        }else{
            echo "ERROR: Something Unexpected in Migration File :- ". self::$table;
        }


    }


    /**
     * @return string
     */
    public function __toString()
    {
        return self::$_mysqlStart.self::getTableQuery().self::$_mysqlEnd;
    }




}