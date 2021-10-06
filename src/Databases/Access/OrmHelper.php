<?php

namespace Tinkle\Databases\Access;

use Tinkle\Model;
use Tinkle\Tinkle;

class OrmHelper
{

    protected string|array $called='';
    protected array $columns=[];
    protected array $tableFormat=[];


    public function __construct(string $calledClass)
    {
        $this->called = $calledClass;
    }

    public function init()
    {
        if(get_parent_class($this->called) === Model::class)
        {
            if($this->resolve())
            {
                if(!empty($this->tableFormat))
                {
                    return $this->tableFormat;
                }

            }
        }

    }


    private function resolve()
    {
       // dd($this->called);
        if(preg_match('/\w+$/',$this->called,$matches))
        {
            if(!empty($matches))
            {
                $dbClassName = str_replace("Model",'',$matches[0]);
                $dbTableColumns = $this->checkForMigrationFiles($dbClassName);
                $cleanedTableColumns = $this->filterAndCleanedTableColumns($dbClassName);
                return $this->tableFormat=$cleanedTableColumns;
            }
        }
    }


    private function checkForMigrationFiles(string $className)
    {
        if(is_dir(Tinkle::$ROOT_DIR.'database/migrations'))
        {
            $allFiles = scandir(Tinkle::$ROOT_DIR.'database/migrations');
            foreach ($allFiles as $files)
            {
                $files = str_replace('.php','',$files);
                if(preg_match("/$className/",$files,$matches))
                {
                    if(!empty($matches))
                    {
                        $class = "Database\migrations\\".$files;
                        $object = new $class();
                        $object->up();
                        $table = $object->get();
                        $object->alter();
                        $alter = $object->get();

                        if(isset($table[strtolower($className)]))
                        {
                            $this->columns [$className] = $table[strtolower($className)];

                        }

                        if(isset($alter[strtolower($className)]))
                        {
                            $this->columns [$className] = $alter[strtolower($className)];

                        }


                    }
                }
            }


        }

        return $this->columns;
    }

    private function filterAndCleanedTableColumns(string $dbClassName)
    {
        $columnArray = $this->columns[ucfirst($dbClassName)];
        $cleanArray =[];



        foreach ($columnArray as $key => $value)
        {
            if(is_array($value))
            {
                foreach ($value as $vKey => $vValue)
                {
                    if($vKey === 'size')
                    {
                        $cleanArray[$key]['length'] = $vValue;
                    }

                    if($vKey === 'type')
                    {
                        $cleanArray[$key]['type'] = $vValue;
                        $cleanArray[$key]['ext'] = $this->getExt($vValue);
                    }

                    if($vKey === 'rule')
                    {
                        if(preg_match("/NULL/",$vValue,$matches))
                        {

                            if(!empty($matches))
                            {
                                if(preg_match("/NOT NULL/",$vValue,$matches))
                                {
                                    $cleanArray[$key]['required'] = true;
                                }else{
                                    $cleanArray[$key]['required'] = false;
                                }
                            }

                        }

                        if(preg_match("/AUTO_INCREMENT/",$vValue,$matches))
                        {
                            if(!empty($matches))
                            {
                                $cleanArray[$key]['required']=false;
                                $cleanArray[$key]['pk']=true;
                            }
                        }else{
                            $cleanArray[$key]['pk']=false;
                        }

                    }






                    if($vKey === 'detail')
                    {
                        if(preg_match("/REFERENCES/",$vValue,$matches))
                        {
                            if(!empty($matches))
                            {

                                $cleanArray[$key]['fk']=true;

                            }
                        }
                    }

                    if($vKey === 'for')
                    {
                        $cleanArray[$key]['for']=$vValue;
                    }

                    if($vKey === 'on')
                    {
                        $cleanArray[$key]['on']=$vValue;
                    }




                    





                }
            }
        }

        return $cleanArray;




    }

    private function getExt(mixed $vValue)
    {

        return match ($vValue) {
            "BIGINT" => "int",
            "INT" => "int",
            "VARCHAR" => "string",
            "TIMESTAMP"=>'datetime',
            "BOOLEAN"=> 'bool',
            default => "Unknown Column $vValue Type",
        };




    }


}