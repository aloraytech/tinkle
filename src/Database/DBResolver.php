<?php

namespace Tinkle\Database;

class DBResolver
{
    protected array $config=[];

    public function setConfig(array $dbConfig)
    {
        $this->config = $dbConfig;
    }

    public function getConfig(string $dbName='')
    {
        if(empty($dbName))
        {
            return $this->config;
        }else{
            if(isset($this->config[$dbName]))
            {
                return $this->config[$dbName];
            }
        }
        return null;
    }


}