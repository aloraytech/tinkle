<?php

namespace Tinkle\Databases\Access;

use mysql_xdevapi\ColumnResult;
use Tinkle\Databases\Connection;
use Tinkle\Exceptions\Display;
use Tinkle\Library\Essential\Essential;
use Tinkle\Model;
use Tinkle\Tinkle;

abstract class Orm
{

    public static Orm $orm;
    protected static OrmHelper $OrmHelper;
    protected static  array|object $currentTableFormat=[];
    protected static  array $currentColumns=[];
    protected static string $table='';
    public object $connection;

    protected static array|string $currentData=[];
    public  array|string $currentWhere=[];

    private array|string|object $givenData=[];
    public static string|array|object $wherePart=[];
    protected object|array|string $calledClass='';




    public function __construct($tableModel='')
    {
        self::$orm = $this;
        // Analyze DB Table Name From Given Model
        self::$table = $tableModel;
        // Get DB Connection
        $this->connection = Tinkle::$app->db->handler->getConnection();
        // Load Default Called Class
        $this->calledClass = get_called_class();
        // If Custom Table Model Given In Constructor
        if(!empty($tableModel))
        {
            // Set Called Class As per Table Model Name
            $this->calledClass = "App\Models\\".ucfirst($tableModel)."Model";
        }else{
            // Get DB Table Name From Called Class, When DB Table Is Not Set
            $_table_name = str_replace("Models",'',$this->calledClass);
            $_table_name = str_replace("App",'',str_replace("Model",'',$_table_name));
            self::$table = str_replace("\\",'',$_table_name);
        }


        // Now Check For Parent Class And If This is Tinkle\Model then we go further

        if(get_parent_class($this->calledClass) === Model::class)
        {
            self::$OrmHelper = new OrmHelper($this->calledClass);
            // Get Table Format from Access helper
            self::$currentTableFormat = self::$OrmHelper->init();
        }
       // End of Constructor
    }



    

    private function resolve(array $ColumnDataArray)
    {

        try{
            foreach ($ColumnDataArray as $key => $data)
            {
                if(array_key_exists($key,self::$currentTableFormat))
                {

                    if(self::$currentTableFormat[$key]['required'])
                    {
                        if(empty($data))
                        {
                            throw new Display($key."is required field, can't be empty",Display::HTTP_BAD_REQUEST);
                        }
                    }

                    $type = 'is_'.self::$currentTableFormat[$key]['ext'];
                    if($type($data))
                    {

                        if(strlen($data) <= self::$currentTableFormat[$key]['length'])
                        {
                            $this->$key = $data;
                            self::$currentColumns[$key] = $data;
                        }else{
                            throw new Display(" <b>$key </b> have  <b> maximum accept chars :".self::$currentTableFormat[$key]['length']. " </b> where given for Quering : <b>".strlen($data)."</b>",Display::HTTP_SERVICE_UNAVAILABLE);
                        }

                    }

                }
            }

            return true;

        }catch (Display $e)
        {
            $e->Render();
        }

    }


    public function insert(array $data)
    {

        if($this->resolve($data))
        {


            $tableName = "`".strtolower(self::$table)."`";
            $allColumns = implode(', ', array_map(fn($m) => "$m", array_keys(self::$currentColumns)));
            $allColumnsValues =implode(', ', array_map(fn($m) => ":$m", array_keys(self::$currentColumns)));



            $this->connection->query("INSERT INTO ".$tableName." (".$allColumns.") VALUES (".$allColumnsValues.")");

            foreach (self::$currentColumns as $key => $value)
            {
                $this->connection->bind(":$key",$value);
            }

            if($this->connection->execute())
            {
               return true;
            }else{
                return false;
            }
        }







    }





    public function find(array $column=[])
    {
        if(!empty($column))
        {
            self::$orm->givenData = $column;
        }
        return new UpdateQueryHelper($column);
    }


    public static function getRecord()
    {
        $tableName = "`".strtolower(self::$table)."`";

        if(!empty(self::$orm->givenData))
        {

            $getPart = implode(', ', array_map(fn($m) => "$m", self::$orm->givenData));
           if(empty(self::$wherePart))
           {

               self::$orm->connection->query("SELECT ".$getPart." FROM ".$tableName);
               $result = self::$orm->connection->resultSet();
               if(!empty($result))
               {
                   return $result;
               }else{
                   return false;
               }
           }else{

              $wherePart =implode(', ', array_map(fn($m) => "$m=:$m", array_keys(self::$wherePart)));
               self::$orm->connection->query("SELECT ".$getPart." FROM ".$tableName." WHERE ". $wherePart);

               foreach (self::$wherePart as $key => $value)
               {
                   self::$orm->connection->bind(":$key",$value);
               }

               $result = self::$orm->connection->resultSet();
               if(!empty($result))
               {
                   return $result;
               }else{
                   return false;
               }
           }



        }else{
            //Fetch All
            if(empty(self::$wherePart))
            {
                self::$orm->connection->query("SELECT * FROM ".$tableName);
                $result = self::$orm->connection->resultSet();
                if(!empty($result))
                {
                    return $result;
                }else{
                    return false;
                }
            }else{

                $wherePart =implode(', ', array_map(fn($m) => "$m=:$m", array_keys(self::$wherePart)));
                self::$orm->connection->query("SELECT * FROM ".$tableName." WHERE ". $wherePart);
                foreach (self::$wherePart as $key => $value)
                {
                    self::$orm->connection->bind(":$key",$value);
                }
                $result = self::$orm->connection->resultSet();
                if(!empty($result))
                {
                    return $result;
                }else{
                    return false;
                }
            }






        }

    }






    public function update(array $data)
    {
        if($this->resolve($data)) {
            if (!empty($data) && is_array($data)) {
                $this->givenData = $data;
            }
            return new UpdateQueryHelper($data);
        }
    }



    public static function updateRecord()
    {

        $updatePart = implode(', ', array_map(fn($m) => "`$m` = :$m", array_keys(self::$currentColumns)));
        $where =implode(', ', array_map(fn($m) => "$m = :$m", array_keys(self::$wherePart)));
        $tableName = "`".strtolower(self::$table)."`";

        self::$orm->connection->query("UPDATE ".$tableName." SET ".$updatePart." WHERE ".$where."");

        foreach (self::$currentColumns as $key => $value)
        {
            self::$orm->connection->bind(":$key",$value);
        }

        foreach (self::$wherePart as $key => $value)
        {
            self::$orm->connection->bind(":$key",$value);
        }


        if(self::$orm->connection->execute())
        {
           return true;
        }else{

            return false;
        }
    }
    
    
    public function delete(array $data)
    {
        if(!empty($data))
        {
            $where =implode(', ', array_map(fn($m) => "$m = :$m", array_keys($data)));
            $tableName = "`".strtolower(self::$table)."`";

            self::$orm->connection->query("DELETE FROM ".$tableName." WHERE ".$where);

            foreach ($data as $key => $value)
            {
                self::$orm->connection->bind(":$key",$value);
            }


            if(self::$orm->connection->execute())
            {
                return true;
            }else{

                return false;
            }
        }

    }





    public function save()
    {
        $allClassVars = get_class_vars($this->calledClass);

        $okVars = [];

        foreach ($allClassVars as $key => $vars)
        {
           if($key === 'orm')
           {
               $vars = Essential::getHelper()->ObjectToArray($vars);
               if(is_array($vars))
               {

                   foreach ($vars as $vKey => $var)
                   {
                       if(array_key_exists($vKey,self::$currentTableFormat))
                       {
                           $okVars[$vKey] = $var;
                       }
                   }
               }
           }
        }




            $tableName = "`".strtolower(self::$table)."`";
            $allColumns = implode(', ', array_map(fn($m) => "$m", array_keys($okVars)));
            $allColumnsValues =implode(', ', array_map(fn($m) => ":$m", array_keys($okVars)));



            $this->connection->query("INSERT INTO ".$tableName." (".$allColumns.") VALUES (".$allColumnsValues.")");



            foreach ($okVars as $key => $value)
            {
                $this->connection->bind(":$key",$value);
            }

            if($this->connection->execute())
            {
                return true;
            }else{
                return false;
            }
        }






}