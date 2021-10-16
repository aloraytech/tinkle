<?php

namespace Tinkle\Database\Access\Builder;

use Tinkle\Database\Access\Access;
use Tinkle\Database\Connection;

class Builder
{

    protected string $table='';
    protected array $bag=[];

    public function __construct(string $table,array|object $queryBag)
    {

        $this->table = $table;
        $this->bag = $queryBag;
    }


    public function where(array $wh)
    {

        if(!empty($wh) && is_array($wh))
        {
            if(count($wh) >1)
            {
                $whereQ = implode(' AND ', array_map(fn($m) => "$m = :$m", array_keys($wh)));
            }else{
                $whereQ = implode('', array_map(fn($m) => "$m = :$m", array_keys($wh)));
            }

            foreach ($wh as $key => $value)
            {
                $this->bag[$this->table]['param']['where'][':'.$key] = $value;
                $this->bag[$this->table]['column'][] = $key;
            }

            if(isset($this->bag[$this->table]['where']))
            {
                $this->bag[$this->table]['query']['where'] = $this->bag[$this->table]['where'] . $whereQ;
            }else{
                $this->bag[$this->table]['query']['where'] =  $whereQ;
            }

        }else{
            return false;
        }
        return new BuilderOption($this->table,$this->bag);
    }

    /**
     * @throws \Tinkle\Exceptions\Display
     */
    public function get()
    {
        Access::prepareQuery($this->table,$this->bag[$this->table]);
        return Access::getConnect()->single();
    }

    /**
     * @throws \Tinkle\Exceptions\Display
     */
    public function getAll()
    {
        Access::prepareQuery($this->table,$this->bag[$this->table]);
        return Access::getConnect()->resultSet();
    }
    
    
    public function orderBy(string $column)
    {
        if(!empty($column) && is_string($column))
        {
            $this->bag[$this->table]['query']['orderBy'] =  $column;
            $this->bag[$this->table]['column'][] = $column;
        }
        return new BuilderOption($this->table,$this->bag);

    }








}