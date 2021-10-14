<?php

namespace Tinkle\Database\DBAccessor;


use Tinkle\Database\DBAccessor\QueryMapper\QueryBuilder;
use Tinkle\Tinkle;



class DBExHandler extends DBExplorer
{

    protected QueryBuilder $builder;

    public function __construct()
    {
        parent::__construct();
        $this->builder = new QueryBuilder();
    }

    public function find(int $int)
    {
        return $this->builder->find($int);

//        $theTable = strtolower($this->table);
//        $this->connection->query("SELECT * FROM {$theTable} WHERE id =:id");
//        $this->connection->bind(':id',$int);
//        return $this->connection->single();
    }


    public function findAll()
    {
        $theTable = strtolower($this->table);
        $this->connection->query("SELECT * FROM {$theTable}");
        return $this->connection->resultSet();
    }






}