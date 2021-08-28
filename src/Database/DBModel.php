<?php

namespace Tinkle\Database;


use Tinkle\Database\Manager\DBManager;
use Tinkle\Tinkle;

abstract class DBModel extends DBManager
{



    /**
     * @param $sql
     * @return \PDOStatement
     */
    public static function prepare($sql): \PDOStatement
    {

        return Tinkle::$app->db->prepare($sql);
    }





    public function find()
    {
        $statement = $this->pdo->query("SELECT * FROM $this->table WHERE email = :email");
        $str = 'abc@gmail.com';
        $statement->bindColumn(":email", $str);
        $statement->execute();
    }



    public function remove(){}




    /**
     * @return bool
     */
    public function save()
    {
        $tableName = $this->tableName();
        $attributes = $this->attributes();
        $params = array_map(fn($attr) => ":$attr", $attributes);
        $statement = self::prepare("INSERT INTO $tableName (" . implode(",", $attributes) . ") 
                VALUES (" . implode(",", $params) . ")");
        foreach ($attributes as $attribute) {
            $statement->bindValue(":$attribute", $this->{$attribute});
        }
        $statement->execute();
        return true;
    }



    /**
     * @param $where
     * @return mixed
     */
    public static function findOne($where)
    {
        $tableName = static::tableName();
        $attributes = array_keys($where);
        $sql = implode("AND", array_map(fn($attr) => "$attr = :$attr", $attributes));
        $statement = self::prepare("SELECT * FROM $tableName WHERE $sql");
        foreach ($where as $key => $item) {
            $statement->bindValue(":$key", $item);
        }
        $statement->execute();
        return $statement->fetchObject(static::class);
    }



    // Class End
}