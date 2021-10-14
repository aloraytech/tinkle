<?php

namespace Tinkle\Database\DBAccessor;

use Tinkle\Database\Connection;


use Tinkle\Database\Database;
use Tinkle\Database\DB;
use Tinkle\Database\DBAccessor\QueryMapper\QueryBuilder;
use Tinkle\Exceptions\Display;
use Tinkle\Tinkle;

abstract class DBExplorer
{

    protected string|array|object $table='';
    protected Connection $connection;
    protected array|object $tableMap;
    protected ModelExplorer $model;
    protected float|string|int $_time='';





    public function __construct()
    {
        if(empty($this->_time))
        {
            $this->_time = microtime(true);
        }
        if(empty($this->connection))
        {
            $this->connection = DB::$database->getConnect();
        }
        $this->builder = new QueryBuilder();

        if(empty($this->table))
        {
            $this->table = str_replace('Model','',str_replace('App\\Models\\','',get_called_class()));
        }


        if(empty($this->tableMap))
        {
            $this->tableMap = $this->getTableMap($this->table); // currently db queries using.. try to based on schema
            $this->resolve();
        }





    }

    /**
     * @param string $table
     * @return array|object
     * @throws Display
     */
    private function getTableMap(string $table)
    {
        debugIt($this->table.' - getTableMap',microtime(true)-$this->_time);
        $resolver = new TableResolver($table);
        $map= $resolver->get();
        if(!empty($map))
        {
            debugIt($this->table.' - TableMap Found',microtime(true)-$this->_time);
            return $map;
        }else{
            throw new Display("$table - Table Mapping Failed!",Display::HTTP_SERVICE_UNAVAILABLE);
        }
    }


    private function resolve()
    {
        if(!empty($this->tableMap['map']) && is_array($this->tableMap['map']))
        {
            foreach ($this->tableMap['map'] as $key => $value)
            {

                if(!isset($this->{$key}))
                {
                    if($value['Ext'] === 'int' || $value['Ext'] ==='float')
                    {
                        $this->{$key} = 0;
                    }else{
                        $this->{$key} = '';
                    }

                }


            }
        }
    }



    public static function where(string $key,string $value)
    {
        echo $key;
    }



    public  function select(){}


    public function get(){}















}