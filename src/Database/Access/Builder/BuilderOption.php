<?php

namespace Tinkle\Database\Access\Builder;

use Tinkle\Database\Access\Access;

class BuilderOption
{


    protected string $table='';
    protected array $bag=[];
    protected string $query='';

    public function __construct(string $table,array|object $queryBag)
    {
        $this->table = $table;
        $this->bag = $queryBag;
    }


    /**
     * @throws \Tinkle\Exceptions\Display
     */
    public function first()
    {
        Access::prepareQuery($this->table,$this->bag[$this->table]);
        $data = Access::getConnect()->single();
        if(!empty($data))
        {
            return $data;
        }
        return [];

    }


    /**
     * @throws \Tinkle\Exceptions\Display
     */
    public function firstOrFail()
    {
        Access::prepareQuery($this->table,$this->bag[$this->table]);
        $data = Access::getConnect()->single();
        if(!empty($data))
        {
            return $data;
        }
        return false;
    }



    public function take(int $limit)
    {
        if(!empty($limit) && is_int($limit))
        {
            $this->bag[$this->table]['query']['limit'] =  $limit;
        }
        return $this;
    }


    /**
     * @throws \Tinkle\Exceptions\Display
     */
    public function get()
    {
        Access::prepareQuery($this->table,$this->bag[$this->table]);
        $data = Access::getConnect()->resultSet();
        if(!empty($data))
        {
            return $data;
        }
        return false;
    }






}