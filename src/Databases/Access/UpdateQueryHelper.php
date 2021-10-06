<?php

namespace Tinkle\Databases\Access;

class UpdateQueryHelper
{

    public array $data=[];
    public string|array $where=[];

    public function __construct(array $data)
    {
        $this->data = $data;
    }


    public function where(string|array $where=[])
    {
        $this->where = $where;
        return $this;
    }

    public function save()
    {
        Orm::$wherePart = $this->where;
        return Orm::updateRecord();
    }


    public function get()
    {

        Orm::$wherePart = $this->where;

        return Orm::getRecord();
    }






}