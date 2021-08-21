<?php


namespace tinkle\framework\Database\BluePrint;


use tinkle\framework\Tinkle;

abstract class BluePrint
{

    public string $table='';

    abstract public function tableName():string;


    public function getColumnInfo()
    {
        $tempFile = Tinkle::$ROOT_DIR."/storage/runtime/table".".json";
        if(file_exists($tempFile))
        {
            $catch = file_get_contents($tempFile);
        }else{
            $foundFile = fopen($tempFile,"w+");
            fwrite($foundFile,json_encode(['users'=> $this->fillColumnInfo()]));
            fclose($foundFile);
            $catch = file_get_contents($tempFile);
        }

        echo "<pre>";
        print_r($catch);


        //return $this->fillColumnInfo();
    }


    private function fetchColumnStructure()
    {
        if(!empty($this->tableName()))
        {
            $this->table = $this->tableName();

            $beFileName = "Create".ucwords($this->table)."Table";
            // Check For The Migration File For Schema Records
            $migrationFiles = scandir(Tinkle::$ROOT_DIR."/database/migrations");

            foreach ($migrationFiles as $migration)
            {
                if(preg_match("/$beFileName/",$migration,$matches))
                {

                    if(file_exists(Tinkle::$ROOT_DIR."/database/migrations/".$migration))
                    {
                        require_once Tinkle::$ROOT_DIR."/database/migrations/".$migration;
                    }
                    $className = "\\tinkle\database\migrations\\$beFileName";
                    $instantiate = new $className();
                    $instantiate->up();
                    $records = $instantiate->get();
                    return $records['columns'];

                }
            }



        }


    }


    private function fillColumnInfo()
    {
        $columnInfo = $this->fetchColumnStructure();
        $columnData = [];
        foreach ($columnInfo as $key => $value)
        {
//            $columnData [$key] = $value['type'];


            if(preg_match('/\d+/',$value['format'],$matches))
            {
                $columnData [$key]['size'] = $matches[0];
            }else{
                $columnData [$key]['size'] = 0;
            }

            if(is_array($value['rules']))
            {
                foreach ($value['rules'] as $ruleKey => $rulesValue)
                {
                    if(preg_match('/NOT NULL/',$rulesValue,$ruleMtches))
                    {
                        $columnData [$key]['required'] = true;
                    }else{
                        $columnData [$key]['required'] = false;
                    }
                }
            }

           $columnData [$key]['format'] = $value['type'];


        }
        return $columnData;
    }

}