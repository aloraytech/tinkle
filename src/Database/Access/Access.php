<?php

namespace Tinkle\Database\Access;

use Tinkle\Database\Access\Builder\Builder as Build;
use Tinkle\Database\Access\Builder\QueryMaker;
use Tinkle\Database\Access\Mapper\TableMapper;
use Tinkle\Database\Connection;
use Tinkle\Database\Database;
use Tinkle\Exceptions\CoreException;
use Tinkle\Exceptions\Display;
use Tinkle\Library\Debugger\Debugger;
use Tinkle\Database\Access\Mapper\Mapper;
class Access
{
    public static Access $access;

    protected static array $int_time=[];
    protected static array $queryBag=[];
    public static string|array $error=[];


    /**
     * @throws Display
     */
    public function __construct()
    {
        self::$access = $this;
        $this->intTime();

    }



    /**
     * @return bool
     */
    private static function intTime()
    {
        if(!isset(self::$int_time[self::getTable()]))
        {
            self::$int_time[self::getTable()]=microtime(true);
        }
        return true;
    }

    /**
     * @param mixed|string $message
     * @return bool
     */
    public static function setDebug(mixed $message='')
    {
        $table = self::getTable();
        self::intTime();
        if(empty($message))
        {
            $message = ' Access[ORM] : Started  (For table '. $table.')';
        }
        $timeTaken = microtime(true) - self::$int_time[$table];

        if(class_exists(\Tinkle\Library\Debugger\Debugger::class))
        {
            Debugger::register($message,$timeTaken,true);
        }
        return true;
    }

    /**
     * @return mixed
     */
    public static function getTable()
    {
        return str_replace('Model','',str_replace('App\\Models\\','',get_called_class()));
    }

    /**
     * @return Connection
     */
    public static function getConnect()
    {
        return Database::$database->getConnect();
    }

    /**
     * @throws Display
     */
    private static function getMapper()
    {
        self::setDebug();
        $tableMap = new TableMapper(self::getTable());
        $map= $tableMap->get();
        if(!empty($map))
        {
            self::setDebug();
            return $map;
        }else{
            throw new Display(self::getTable()." - Table Mapping Failed!",Display::HTTP_SERVICE_UNAVAILABLE);
        }
    }

    public static function verifyWithMapper(string $table='', array|object $bag=[])
    {
        if(empty($table)){$table = strtolower(self::getTable());}
        if(empty($bag)){$bag = self::$queryBag[$table];}
        // Set Mapper
        $mapper = new Mapper($table,$bag);

        if($mapper->verify())
        {
            return true;
        }else{
            self::$error = $mapper->getError();
            return false;
        }
        return false;

    }

    // Preparing Queries

    /**
     * @return bool
     * @throws Display
     */
    public static function prepareQuery(string $table='',array $bag=[])
    {

        if(empty($table)){$table = self::getTable();}
        if(empty($bag)){$bag = self::$queryBag[strtolower(self::getTable())];}

        if(self::verifyWithMapper($table,$bag))
        {
            $maker = new QueryMaker(strtolower($table),$bag);
            $tempQ= $maker->getQuery();
            self::prepareNBindQuery($tempQ,$bag);

        }
        if(empty(self::$error))
        {
            return true;
        }else{
            $errorMessage =  implode("; ", array_map(fn($m) => "$m", self::$error));
            throw  new Display($errorMessage, CoreException::HTTP_SERVICE_UNAVAILABLE);
        }
    }


    private static function prepareNBindQuery(string $query='',array $bag=[])
    {
        if(!empty($query))
        {
            self::getConnect()->query($query);
            foreach ($bag as $key => $value)
            {
                if($key === 'param')
                {
                    if(is_array($value))
                    {
                        foreach ($value as $vKEY =>$vVALUE)
                        {
                           if(is_array($vVALUE))
                           {
                               foreach ($vVALUE as $bindKey => $bindValue)
                               {
                                   self::getConnect()->bind($bindKey,$bindValue);
                               }
                           }else{
                               self::getConnect()->bind($vKEY,$vVALUE);
                           }
                        }
                    }
                }
            }
        }else{
            return false;
        }
        return true;
    }






    // Calling Methods For DB Queries


    public static function create(array $createQuery)
    {
        if(!empty($createQuery) && is_array($createQuery))
        {
            $table = strtolower(self::getTable());
            $allColumns = implode(', ', array_map(fn($m) => "$m", array_keys($createQuery)));
            $allColumnsValues =implode(', ', array_map(fn($m) => ":$m", array_keys($createQuery)));

            self::getConnect()->query("INSERT INTO ".$table." (".$allColumns.") VALUES (".$allColumnsValues.")");
            foreach ($createQuery as $key => $value)
            {
                self::getConnect()->bind(":$key",$value);
            }
            if(self::getConnect()->execute())
            {
                return true;
            }else{
                return false;
            }
        }

    }



    public static  function select()
    {

    }


    /**
     * @throws Display
     */
    public static  function all(bool $all=false)
    {
        $table = strtolower(self::getTable());
        self::$queryBag[$table]['query'] = [
            'select' => ' * FROM '.$table,
        ];

        if($all)
        {
            if(self::prepareQuery($table,self::$queryBag[$table]))
            {
                return self::getConnect()->resultSet();
            }else{
                return self::$error;
            }

        }else{
            return new Build($table,self::$queryBag);
        }




//        self::getConnect()->query("SELECT * FROM {$table}");
//        return self::getConnect()->resultSet();
    }

    /**
     * @throws Display
     */
    public static function get()
    {
        if(self::prepareQuery())
        {
            return self::getConnect()->resultSet();
        }else{
            return self::$error;
        }

    }

    public static function where(string $column, int|string $value)
    {

        $table = strtolower(self::getTable());
        self::$queryBag[$table]['query'] = [
            'select' => ' * FROM '.$table,
            'where'=> $column.' = :'.$column,
        ];
        self::$queryBag[$table]['param']['where'][':'.$column] = $value;
        self::$queryBag[$table]['column'][] = $column;
        return new Build($table,self::$queryBag);

    }


    /**
     * @throws Display
     */
    public static function find(int $id)
    {
        if(!empty($id) && is_int($id))
        {
            $table = strtolower(self::getTable());
            self::$queryBag[$table]['query'] = [
                'select' => ' * FROM '.$table,
                'where'=> 'id = :id',
            ];
            self::$queryBag[$table]['param']['where'][':id'] = $id;
            self::$queryBag[$table]['column'][] = 'id';
            if(self::prepareQuery($table,self::$queryBag[$table]))
            {
                return self::getConnect()->single();
            }else{
                return self::$error;
            }
        }

    }










    // EXTE








}