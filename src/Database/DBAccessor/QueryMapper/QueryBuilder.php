<?php

namespace Tinkle\Database\DBAccessor\QueryMapper;

class QueryBuilder
{
    protected array $where=[];
    protected array $join=[];
    protected string $select='';




    public function findOrNew(){}

    public function find(int|string $column)
    {
        $this->select = $column;
        return new WhereBuilder();
    }








}