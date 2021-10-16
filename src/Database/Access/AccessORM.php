<?php

namespace Tinkle\Database\Access;

use Tinkle\Database\Access\Mapper\TableMapper;
use Tinkle\Database\Connection;
use Tinkle\Database\Database;
use Tinkle\Exceptions\Display;

abstract class AccessORM
{

    public static AccessORM $access;
    protected static Connection $connection;
    public static string $table='';
    public array|object $mapper;
    protected float|string|int $_time='';


    /**
     * @throws Display
     */
    public function __construct()
    {
        self::$access = $this;
        if(empty($this->_time))
        {
            $this->_time = microtime(true);
        }
        self::$connection = Database::$database->getConnect();
        self::$table = str_replace('Model','',str_replace('App\\Models\\','',get_called_class()));

        if(empty($this->mapper))
        {
            $this->mapper = $this->getMapper(); // currently db queries using.. try to based on schema
            $this->initilization();
        }

    }

    /**
     * @throws Display
     */
    private function getMapper()
    {
        debugIt(self::$table.' - getTableMap',microtime(true)-$this->_time);
        $tableMap = new TableMapper(self::$table);
        $map= $tableMap->get();
        if(!empty($map))
        {
            debugIt(self::$table.' - TableMap Found',microtime(true)-$this->_time);
            return $map;
        }else{
            throw new Display(self::$table." - Table Mapping Failed!",Display::HTTP_SERVICE_UNAVAILABLE);
        }

    }

    private function initilization()
    {
        if(!empty($this->mapper['map']) && is_array($this->mapper['map']))
        {
            foreach ($this->mapper['map'] as $key => $value)
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










    // Class End

}