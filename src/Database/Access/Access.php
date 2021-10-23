<?php

namespace Tinkle\Database\Access;

use Tinkle\Database\Access\Builder\Builder as Build;
use Tinkle\Database\Access\Builder\QueryMaker;
use Tinkle\Database\Access\Mapper\TableMapper;
use Tinkle\Database\Connection;
use Tinkle\Database\Database;
use Tinkle\Exceptions\CoreException;
use Tinkle\Exceptions\Display;
use Tinkle\interfaces\AccessOrmModelInterface;
use Tinkle\Library\Debugger\Debugger;
use Tinkle\Database\Access\Mapper\Mapper;
use Tinkle\Library\Essential\Essential;

abstract class Access
{
    public static Access $access;

    protected static array $int_time=[];
    protected static array $queryBag=[];
    public static string|array $error=[];
    public string $connection='';
    public string $table='';
    public int $perPage=15;
//    public bool $exists=false;
//    public array|object $attributes=[];
//    public array|object $original=[];
//    public array $appends=[];
//    public array|object $relations=[];
//    public array $casts=[];
//    public array $guarded =[];
    private static array|object $pk=[];
    private static array|object $relations=[];
    private static array $preQuery=[];



    /**
     * @throws Display
     */
    public function __construct()
    {
        self::$access = $this;
        $this->connection = self::getConnect()->getConnectionName();
        if(empty($this->table))
        {
            $this->table = self::getTable();
        }

    }


    public function populate()
    {

    }


    public static function populateNReturn($content,string $table='')
    {
        if(empty($table))
        {
            $table = strtolower(self::getTable());
        }

        $countValue = count(Essential::getHelper()->ObjectToArray($content));
        $data = [
            'table'=> $table,
            "$table"=> $content,
            'primarykey'=> array_keys(self::$pk)[0],
            'attributes'=> $content,
            'original'=> $content,
            "meta"=> [
                'total' => $countValue,
            ],
            'guard'=> [],
            'map'=>['primarykey'=> self::$pk,'relation'=>self::$relations[strtolower(self::getTable())],],

        ];

        // Here All Require Action will be taken before send back data to controller/plugin/callable class
//        if(is_object($content))
//        {
//            $result = Essential::getHelper()->ObjectToArray($content);
//
//
////            if(is_array($result))
////            {
////                foreach ($result as $key => $value)
////                {
////
////                    if(is_array($value))
////                    {
////                        foreach ($value as $vKey =>$vValue)
////                        {
////                            if(is_array($vValue))
////                            {
////                                foreach ($vValue as $vvK => $vvValue)
////                                {
////                                    //self::$vvK = $vvValue;
////                                    $newObject->{$vvK} = $vvValue;
////                                }
////                            }else{
////                                $newObject->{$vKey} = $vValue;
////                            }
////                        }
////                    }else{
////                        $newObject->{$key}  = $value;
////                    }
////                }
////            }
//        }
//      //  $object = (object) $content;
//        //dryDump($object);
        return json_decode(json_encode($data,JSON_PRETTY_PRINT));
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
    public static function setDebug(mixed $message='',bool $isDebug=true)
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
            Debugger::register($message,$timeTaken,$isDebug);
        }
        return true;
    }

    /**
     * @return mixed
     */
    public static function getTable()
    {
        $table = str_replace('Model','',str_replace('App\\Models\\','',get_called_class()));
        $tableParts = explode('\\',$table);
        $partsCount = count($tableParts);
        return $tableParts[$partsCount-1];
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
    public static function verifyWithMapper(string $table='', array|object $bag=[])
    {
        if(empty($table)){$table = strtolower(self::getTable());}
        if(empty($bag)){$bag = self::$queryBag[$table];}
        // Set Mapper
        $mapper = new Mapper($table,$bag);

        if($mapper->verify())
        {
            self::$pk = $mapper->getPrimaryKey();
            self::$relations[strtolower(self::getTable())] = $mapper->getRelation();
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
                unset(self::$queryBag[$table]);
                return self::populateNReturn(self::getConnect()->resultSet(),$table);
            }else{
                return self::$error;
            }

        }else{
            return new Build($table,self::$queryBag);
        }

    }


    public static function findAll(bool $deep=false)
    {
        if($deep)
        {
            return self::all(true);
        }else{
            $table = strtolower(self::getTable());
            self::$queryBag[$table]['query'] = [
                'select' => ' * FROM '.$table,
            ];
            return new Build($table,self::$queryBag);
        }

    }


    /**
     * @throws Display
     */
    public static function get()
    {
        if(self::prepareQuery())
        {
            unset(self::$queryBag[self::getTable()]);
            return self::populateNReturn(self::getConnect()->resultSet(),strtolower(self::getTable()));
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
    public static function find(int|string $id='')
    {

        $table = strtolower(self::getTable());
        unset(self::$queryBag[$table]);
        if(empty($id))
        {
            self::$queryBag[$table]['query'] = [
                'select' => ' * FROM '.$table,
                'where'=> '',
            ];
//            self::$queryBag[$table]['param']['where'][':id'] = $id;
//            self::$queryBag[$table]['column'][] = 'id';
            return new Build($table,self::$queryBag);

        }else{

            self::$queryBag[$table]['query'] = [
                'select' => ' * FROM '.$table,
                'where'=> 'id = :id',
            ];
            self::$queryBag[$table]['param']['where'][':id'] = $id;
            self::$queryBag[$table]['column'][] = 'id';
            if(self::prepareQuery($table,self::$queryBag[$table]))
            {
                unset(self::$queryBag[$table]);
                return self::populateNReturn(self::getConnect()->single(),$table);
            }else{
                return self::$error;
            }
        }




    }


    /**
     * @throws Display
     */
    public static function load(string $relation_table)
    {
        $relation_table = strtolower($relation_table);
        $table = strtolower(self::getTable());
        // Set Mapper
        $mapper = new Mapper($table,[]);
        $pField = implode(', ', array_map(fn($m) => "$table.$m as $table".ucfirst($m), array_keys($mapper->getParentTableField())));
        $relation = $mapper->getChildTableField($relation_table);
        $rFields = implode(', ', array_map(fn($m) => "$relation_table.$m as $relation_table".ucfirst($m), array_keys($relation['Link'])));


        unset(self::$queryBag[$table]);


        self::$queryBag[$table]['query'] = [
            'select' => $pField.', '.$rFields.'  FROM '.$table. " INNER JOIN ". strtolower($relation['LinkTo'])." ON ".$table.".".strtolower($relation['Field'])." = ".strtolower($relation['LinkTo']).'.'.strtolower($relation['LinkOn']),
        ];
        return new Build($table,self::$queryBag);

    }











}