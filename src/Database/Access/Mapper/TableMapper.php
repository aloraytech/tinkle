<?php

namespace Tinkle\Database\Access\Mapper;

use Tinkle\Database\Migration\Migration;
use Tinkle\Exceptions\Display;
use Tinkle\Library\Essential\Essential;
use Tinkle\Tinkle;

class TableMapper
{

    protected string $table='';
    protected string|array $pk=[];
    protected array|string $fk=[];
    protected array|object $tableMap=[];
    private array|object $requiredColumn=[];
    private array|object $default=[];
    private string|float $_time='';
    private array|object|string $mFiles=[];

    /**
     * @throws Display
     */
    public function __construct(string $table)
    {

        $this->table = $table;
        if(empty($this->_time))
        {
            $this->_time = microtime(true);
        }


        if(empty($this->tableMap))
        {
            $this->tableMap = $this->findNGetTableMap($this->table);
            $this->mFiles = '';
        }



    }


    /**
     * @throws Display
     */
    private function findNGetTableMap(string $table)
    {
        return $this->updateMap($this->resolve($this->loadFromSchema($table),$table),$table);
    }




    public function get()
    {

        return [
            'table'=>$this->table,
            'pk'=>$this->pk,
            'fk'=>$this->fk,
            'required'=>$this->requiredColumn,
            'default'=>$this->default,
            'map'=>$this->tableMap,
        ];
    }


    /**
     * @throws Display
     */
    private function updateMap(array $tableStructure, string $table)
    {
        if(!empty($tableStructure) && is_array($tableStructure) && !empty($table))
        {

            debugIt($this->table.' - Map Updating',microtime(true)-$this->_time,false);
            return $tableStructure;
        }else{
            throw new Display('Unexpected Error In Table Resolver Update Structure',503);
        }
    }






    private function loadFromSchema(string $schemaFor)
    {
        $mFileName= $this->searchNget(ucfirst($schemaFor));
        $mClass = "Database\migrations\\".str_replace('.php','',$mFileName);
        $instance = new $mClass();
        if($instance instanceof Migration)
        {
            $instance->up(); $instance->alter();
            return $instance->get();
        }
        return [];

    }

    private function searchNget(string $name)
    {

        if(empty($this->mfiles))
        {
            $allFiles = @scandir(Tinkle::$ROOT_DIR.'database/migrations/') ?? [];
            unset($allFiles['.']);
            unset($allFiles['..']);
            $this->mfiles = $allFiles;
        }else{
            $allFiles = $this->mfiles;
        }

        if(is_array($allFiles) && !empty($allFiles))
        {
            foreach ($allFiles as $key => $val)
            {
                if($key !='.' && $key !='..')
                {
                    if(Essential::REGEX()->findMatch($val,"/$name/"))
                    {
                        return $val;
                    }
                }
            }
        }
    }


    // Method Two

    /**
     * @throws Display
     */
    private function resolve(array|object $tableSchema, string $table)
    {
        $result=[];

        foreach ($tableSchema as $tKey => $schema)
        {
            if (is_array($schema))
            {
                foreach ($schema as $key => $value)
                {
                    unset($value['Rule']);
                    unset($value['Detail']);
                    if($value['Pk'])
                    {
                        $this->pk [$value['Field']]= $value;
                    }


                    if($value['Linkable'])
                    {
                        if($value['Fk'])
                        {
                            $reqTable = ucfirst($value['LinkTo']);
                            $foundData = $this->resolve($this->loadFromSchema($reqTable),$reqTable);
                            //$foundData = $this->updateMap($foundData,$reqTable);

                            $tableSchema[$key]['Link'] = $foundData;
                            $tableSchema[$key]['LinkTo'] = $reqTable;
                            if($table === $this->table)
                            {
                                $value['LinkTo'] = $reqTable;
                                $value['Link'] = $foundData;
                                $this->fk[$key] = $value;
                            }
                        }
                    }

//                    if($value['Require'])
//                    {
//                        $this->requiredColumn[$value['Field']] =  $value;
//                    }
//
//                    if($value['Field']==='id' || $value['Field']==='created_at' || $value['Field']==='updated_at' )
//                    {
//                        $this->default[$value['Field']] = $value;
//                    }




                    $result[$value['Field']] = $value;
                }
            }
        }
        return $result;
    }


}