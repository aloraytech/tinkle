<?php


namespace Tinkle\Library\Console\Application\Models\DB;


use Tinkle\Library\Console\ConsoleModel;
use Tinkle\Library\Logger\Logger;

class SeederModel extends ConsoleModel
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