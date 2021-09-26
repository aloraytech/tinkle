<?php
/*
 * Package : DBHandler.php
 * Project : tinkle
 * Created : 22/09/21, 9:53 PM
 * Last Modified : 22/09/21, 9:53 PM
 * Author : Krishanu Bhattacharya
 * Email :krishanu.info@gmail.com
 * Copyright (c) 2021.
 *
 *
 */

namespace Tinkle\Database;

use App\App;
use Tinkle\Exceptions\Display;
use Tinkle\Library\Essential\Essential;


class DBHandler
{

    protected array|string $allDbConfig=[];
    protected array $currentDBConfig=[];
    protected Database $db;




    public function setConfig(array|string $dbConfiguration)
    {
        if(is_string($dbConfiguration))
        {
            $this->allDbConfig = json_decode($dbConfiguration);
        }else{
            $this->allDbConfig = $dbConfiguration;
        }
        $this->allDbConfig = Essential::getHelper()->ObjectToArray($this->allDbConfig);

        //dd($this->allDbConfig);
    }




    public function setDB(string $dbname)
    {
        try{
            if(isset($this->allDbConfig[$dbname]))
            {
                $this->currentDBConfig = $this->allDbConfig[$dbname];

                $this->db = new Database($this->currentDBConfig);

            }else{
                throw new Display("$dbname DBConfig Configuration Not Found, Connection Not Established!",Display::HTTP_SERVICE_UNAVAILABLE);
            }

        }catch (Display $e)
        {
            $e->Render();
        }

    }

    public function switchDB(string $dbname)
    {
        try{
            if(isset($this->allDbConfig[$dbname]))
            {
                $this->db->close();
                $this->currentDBConfig = $this->allDbConfig[$dbname];
                $this->db = new Database($this->currentDBConfig);

            }else{
                throw new Display("$dbname DBConfig Configuration Not Found, Connection Not Established!",Display::HTTP_SERVICE_UNAVAILABLE);
            }

        }catch (Display $e)
        {
            $e->Render();
        }

    }



    public function getConnection()
    {

        $this->resolve();
        return $this->db;

    }



    private function resolve()
    {
        if(empty($this->db))
        {
            $this->setDB(App::getDefaultDatabase());
        }
    }



}