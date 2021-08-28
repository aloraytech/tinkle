<?php


namespace Tinkle\Library\Cli\program\model\DB;


use Tinkle\Library\Cli\CliModel;
use Tinkle\Library\Logger\Logger;

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