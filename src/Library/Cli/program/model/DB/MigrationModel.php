<?php


namespace tinkle\framework\Library\Cli\program\model\DB;



use tinkle\framework\Library\Cli\CliModel;
use tinkle\framework\Model;
use tinkle\framework\Library\Logger\Logger;


class MigrationModel extends CliModel
{



    public function createDefaultTables()
    {
        $default = $this->getDefaultTableQuery();


            foreach ($default as $table)
            {
                $this->pdo->exec(array_shift($table));
            }
            return true;

    }








//    public function createMigrationsTable()
//    {
//        if($this->execute("CREATE TABLE IF NOT EXISTS migrations(
//                id INT AUTO_INCREMENT PRIMARY KEY,
//                migration VARCHAR(255),
//                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
//            ) ENGINE = INNODB;"))
//        {
//            return true;
//        }else{
//            return false;
//        }
//
//    }




    /**
     * @param string $tableDetails
     * @return bool
     */
    public function createMigrations(string $tableDetails)
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


    public function saveMigrations(array $migrations)
    {
        $str = implode(",", array_map(fn($m) => "('$m')", $migrations));
        //echo '<pre>'; var_dump($migrations); echo '</pre>'; exit;

        $statement = $this->pdo->prepare("INSERT INTO migrations (migration) VALUES {$str} ");
        if ($statement->execute()) {
            return true;
        } else {
            return false;
        }
    }


    public function removeMigrations(string $_record)
    {

        $statement = $this->pdo->prepare("DELETE FROM `migrations` WHERE `migration` = '{$_record}';");

        if($statement->execute())
        {
            return true;
        }else{
            return false;
        }
    }





    public function getAppliedMigrations()
    {
        $statement = $this->pdo->prepare("SELECT migration FROM migrations");
        $statement->execute();
        return $statement->fetchAll(\PDO::FETCH_COLUMN);
    }




    private function getDefaultTableQuery()
    {
        return [
            ["CREATE TABLE IF NOT EXISTS migrations(
                id INT AUTO_INCREMENT PRIMARY KEY,
                migration VARCHAR(255),
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            ) ENGINE = INNODB;"],

//            ["CREATE TABLE IF NOT EXISTS sess(
//                id INT AUTO_INCREMENT PRIMARY KEY,
//                sess VARCHAR(255),
//                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
//            ) ENGINE = INNODB;"],
        ];
    }



    public function reset(string $_table='')
    {
        if(!empty($_table))
        {
            $statement = $this->pdo->prepare("TRUNCATE $_table;");
            if($statement->execute())
            {
                return true;
            }else{
                Logger::Logit( "PDO Error :-\n Cli/Model/DB/MigrationModel.php \n Function : ResetMigration    Line : 136\n Code :".$this->pdo->errorCode()."  \nDetails :\n",false);
                return false;
            }
        }
        return false;
    }







}