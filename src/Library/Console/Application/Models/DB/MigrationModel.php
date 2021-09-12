<?php


namespace Tinkle\Library\Console\Application\Models\DB;


use Tinkle\Library\Console\ConsoleModel;
use Tinkle\Library\Logger\Logger;

class MigrationModel extends ConsoleModel
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

            ["CREATE TABLE IF NOT EXISTS config(
                id INT AUTO_INCREMENT PRIMARY KEY,
                title VARCHAR(255),
                description TEXT,
                status TINYINT(1) NOT NULL,
                created_at TIMESTAMP NOT NULL ,updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP                
            ) ENGINE = INNODB;"],

            ["CREATE TABLE IF NOT EXISTS plugins(
                id INT AUTO_INCREMENT PRIMARY KEY,
                plugin VARCHAR(255),
                version VARCHAR(255),
                category VARCHAR(255),
                info VARCHAR(255),
                status TINYINT(1) NOT NULL,
                created_at TIMESTAMP NOT NULL ,updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL 
            ) ENGINE = INNODB;"],
        ];
    }



    public function getAllTables()
    {
        $statement = $this->pdo->prepare("SHOW TABLES;");
        if($statement->execute())
        {
            $allTables= $statement->fetchAll();
            $tableList=[];
            if(is_array($allTables) && !empty($allTables))
            {
                foreach ($allTables as $tables)
                {
                    if(is_array($tables))
                    {
                        foreach ($tables as $key => $value)
                        {
                            if($key ===0)
                            {
                                $tableList[]=$value;
                            }
                        }
                    }
                }

            }
            return $tableList;

        }else{
            return [];
        }
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


    public function drop(string $_table='')
    {
        if(!empty($_table))
        {
            $statement = $this->pdo->prepare("DROP TABLE $_table;");
            if($statement->execute())
            {
                return true;
            }else{
                Logger::Logit( "PDO Error :-\n Cli/Model/DB/MigrationModel.php \n Function : Drop Table    Line : 136\n Code :".$this->pdo->errorCode()."  \nDetails :\n",false);
                return false;
            }
        }
        return false;
    }




}