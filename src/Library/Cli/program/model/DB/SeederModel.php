<?php


namespace tinkle\framework\Library\Cli\program\model\DB;


use tinkle\framework\Library\Cli\CliModel;
use tinkle\framework\Library\Logger\Logger;

class SeederModel extends CliModel
{



    public function createSeeder(string $tableDetails)
    {
        if(!empty($tableDetails) && is_string($tableDetails))
        {

            if($this->pdo->exec($tableDetails))
            {
                return true;
            }else{
                Logger::Logit( "Unknown PDO Error :-\n Code :00000  \nDetails :\n $tableDetails",false);
                return false;
            }
        }else{
            return false;
        }
    }






}