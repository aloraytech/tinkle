<?php

namespace Tinkle\Database\Access;

class Action
{

    private array $tableQuery=[];
    private array $mapper=[];
    private string $query='';
    private array $binder=[];
    private array|object $result=[];

    public function __construct(array $tableArray)
    {
        $this->tableQuery = $tableArray;
        //$this->mapper = $tableMap;
    }



    private function PrepareNUpdateQuery()
    {
        foreach ($this->tableQuery as $key => $value)
        {
            if ($key === 'query') {
                if (isset($value['select']) && !empty($value['select'])) {
                    $this->query = 'SELECT ' . $value['select'];
                }

                if (isset($value['where']) && !empty($value['where'])) {
                    $this->query .= ' WHERE ' . $value['where'];
                }

                if (isset($value['orderBy']) && !empty($value['orderBy'])) {
                    $this->query .= ' ORDER BY ' . $value['orderBy'];
                }


                if (isset($value['limit']) && !empty($value['limit'])) {
                    $this->query .= ' LIMIT ' . $value['limit'];
                }


            }
        }
    }




    private function if_select(){}
    private function if_where(){}
    private function if_orderBy(){}
    private function if_limit(){}
    private function if_groupBy(){}




}