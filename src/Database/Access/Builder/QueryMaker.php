<?php

namespace Tinkle\Database\Access\Builder;

class QueryMaker
{

    protected string $table='';
    protected array $queryDetail=[];
    protected string $query='';


    public function __construct(string $table,array $QueryData)
    {
        $this->table = $table;
        $this->queryDetail = $QueryData;



        $this->resolve();

    }



    public function getQuery()
    {
        return $this->query;
    }


    private function resolve()
    {
        return $this->buildQuery();
    }


    private function buildQuery()
    {

        foreach ($this->queryDetail as $key => $value)
        {
            if($key === 'query')
            {
                if(isset($value['select']) && !empty($value['select']))
                {
                    $this->query = 'SELECT '.$value['select'];
                }

                if(isset($value['where']) && !empty($value['where']))
                {
                    $this->query .= ' WHERE '.$value['where'];
                }

                if(isset($value['orderBy']) && !empty($value['orderBy']))
                {
                    $this->query .= ' ORDER BY '.$value['orderBy'];
                }


                if(isset($value['limit']) && !empty($value['limit']))
                {
                    $this->query .= ' LIMIT '.$value['limit'];
                }

            }


        }




    }







}