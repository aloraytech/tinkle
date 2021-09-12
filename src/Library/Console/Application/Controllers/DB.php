<?php


namespace Tinkle\Library\Console\Application\Controllers;


use Database\DatabaseSeeder;
use Tinkle\Library\Console\ConsoleController;
use Tinkle\Library\Console\Application\Models\DB\MigrationModel;
use Tinkle\Library\Console\Application\Models\DB\SeederModel;

class DB extends ConsoleController
{


    private string $migrationPath = '';
    private string $seederPath = '';
    private string $prefix = 'm0000';
    private object $migrationModel;
    private object $seederModel;


    /**
     * DB constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->migrationPath = $this->root."database/migrations/";
        $this->seederPath = $this->root."database/seeders/";

        $this->migrationModel = new MigrationModel();
        $this->seederModel = new SeederModel();
        $this->resolveDefaultDatabaseTable();


    }


    public function index()
    {
        echo "Looking You Missing SomeThing : ";
    }


    public function migrate()
    {
        if($this->migrationHelper())
        {
            echo "db".$this->pattern."migrate process completed";
        }else{
            echo "db".$this->pattern."migrate process failed";
        }
    }


    public function dropMigration()
    {
        if($this->migrationDownHelper())
        {
            echo "db".$this->pattern."dropmigration  process completed";
        }else{
            echo "db".$this->pattern."dropmigration process failed";
        }
    }

    public function reset(string $tableName=null)
    {
        if(empty($tableName))
        {
            $allTables = $this->migrationModel->getAllTables();


            foreach ($allTables as $key => $table)
            {
                if($this->migrationModel->drop($table))
                {
                    echo "\n $key : Drop $table Table From Database";
                }else{
                    echo "db".$this->pattern."reset process failed when reset Database";
                }
            }

        }elseif (is_string($tableName) && !empty($tableName))
        {
            if($this->migrationModel->drop($tableName))
            {
                echo "\n Drop $tableName Table From Database";
            }else{
                echo "db".$this->pattern."DB reset process failed2";
            }
        }else{
            echo "db".$this->pattern."Database reset process";
        }

        echo "\nDatabase Reset Process Complete...\n";

    }



    public function refresh(string $tableName=null)
    {
        if(empty($tableName))
        {
            $allTables = $this->migrationModel->getAllTables();


            foreach ($allTables as $key => $table)
            {
                if($this->migrationModel->reset($table))
                {
                    echo "db".$this->pattern."refresh  process completed \n Truncate apply on $table";
                }else{
                    echo "db".$this->pattern."refresh process failed when reset $table";
                }
            }

        }elseif (is_string($tableName) && !empty($tableName))
        {
            if($this->migrationModel->reset($tableName))
            {
                echo "db".$this->pattern."refresh  process completed  \n Truncate apply on $tableName";
            }else{
                echo "db".$this->pattern."refresh process failed2";
            }
        }else{
            echo "db".$this->pattern."refresh process failed3";
        }


    }



    public function seed()
    {
        if($this->seederHelper())
        {
            echo "db".$this->pattern."seed process completed";
        }else{
            echo "db".$this->pattern."seed process failed";
        }


    }

    public function refreshSeed()
    {
        echo "db".$this->pattern."refreshSeed process not available";
    }












    /**
     *  PRIVATE FUNCTIONS FOR DB CONTROLLER
     */


    private function resolveDefaultDatabaseTable()
    {
        $this->migrationModel->createDefaultTables();
        //$this->migrationModel->createSymfonyTables();
        return true;
    }







    private function migrationHelper()
    {
        // Check And Load All Migration Files
        $classList = $this->getAllMigrationClasses();
        // Check And Load All Sql Queries From Migration Files
        $queryList = $this->getQueryFromMigrationFiles($classList);
        $newMigrations = [];

        foreach ($queryList as $query)
        {
            if($this->migrationModel->createMigrations($query['up']))
            {
                if(!empty($query['alter']))
                {
                    $this->migrationModel->createMigrations($query['alter']);
                }

            }
            $newMigrations[] = $query['file'];
        }

        if (!empty($newMigrations)) {

            if ($this->migrationModel->saveMigrations($newMigrations)) {
                $this->log('Save Report Into DataBase And Logs');

            } else {
                $this->log("Migration Process Complete Successfully");

            }
        } else {
            $this->log("Nothing New For Applied For Migration!");

        }

        return true;
    }




    private function getAllMigrationClasses()
    {
        $allMigrations = $this->getExistingMigrationFiles();
        $appliedMigrations = $this->migrationModel->getAppliedMigrations();
        @$toApplyMigrations = array_diff($allMigrations, $appliedMigrations);
        $classList = [];
        foreach ($toApplyMigrations as $migration)
        {
            $_fileName = str_replace(".php",'',$migration);
            $_tempObject = "\\Database\migrations\\".$_fileName;
            $_instance = array_values(class_implements(new $_tempObject));
            $classList [] =[
                'class'=> get_class(new $_tempObject),
                'instance' => array_shift($_instance),
                'details'=> pathinfo($this->root."database/migrations/".$migration),
                'classWithNameSpace'=> "\\Database\migrations\\".$_fileName,
            ];
        }

        return $classList;



    }

    private function getExistingMigrationFiles()
    {
        $fileList = $this->scanNget($this->migrationPath);
        $classList = [];
        foreach ($fileList as $single)
        {
            if($single === '.' || $single ==='..')
            {
                continue;
            }else{
                $classList[]= $single;
            }
        }
        return $classList;
    }


    private function getQueryFromMigrationFiles(array $classList)
    {

        $_details = [];
        foreach ($classList as $migration)
        {

            $object = new $migration['class'];
            $_details[] = [
                'file' => $migration['details']['basename'],
                'up' => $object->up(),
                'alter' => $object->alter(),
                'down'=> $object->down(),
            ];

        }
        return $_details;

    }





    private function migrationDownHelper()
    {
        $allMigrations = $this->getExistingMigrationFiles();
        $classList = [];
        foreach ($allMigrations as $migration)
        {
            $_fileName = str_replace(".php",'',$migration);
            $_tempObject = "\\Database\migrations\\".$_fileName;
            $_instance = array_values(class_implements(new $_tempObject));
            $classList [] =[
                'class'=> get_class(new $_tempObject),
                'instance' => array_shift($_instance),
                'details'=> pathinfo($this->root."database/migrations/".$migration),
                'classWithNameSpace'=> "\\Database\migrations\\".$_fileName,
            ];
        }


        // Check And Load All Sql Queries From Migration Files
        $queryList = $this->getQueryFromMigrationFiles($classList);

        foreach ($queryList as $query)
        {
            if($this->migrationModel->createMigrations($query['down']))
            {
                continue;
            }
            $newMigrations[] = $query['file'];

        }

        if (!empty($newMigrations)) {
            foreach ($newMigrations as $migration)
            {

                if ($this->migrationModel->removeMigrations($migration)) {
                    $this->log('Save Report Into DataBase And Logs');
                } else {
                    $this->log("Migration Down Process Complete Successfully");
                }
            }


        } else {
            $this->log("Nothing New For Applied For Migration!");
        }

        return true;
    }





    private function seederHelper()
    {
        //$allSeeders = $this->getAllFilesFrom($this->seederPath);

        $_seedRecord = [];
        $seeder = new DatabaseSeeder();
        $allSeeders =$seeder->getSeeder();
        foreach ($allSeeders as $seed)
        {
            $object = new $seed[0];
            $_seedRecord [] = $object->run();

        }

        foreach ($_seedRecord as $record)
        {
            if(is_array($record))
            {
                foreach ($record as $query)
                {
                    if($this->seederModel->createSeeder($query))
                    {
                        continue;
                    }
                }
            }
        }

        return true;



    }







}