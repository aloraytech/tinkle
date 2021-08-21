<?php


namespace tinkle\framework\Library\Cli\program\controller;


use tinkle\database\DatabaseSeeder;
use tinkle\framework\interfaces\CliControllerInterface;
use tinkle\framework\Library\Cli\program\model\DB\MigrationModel;
use tinkle\framework\Library\Cli\program\model\DB\SeederModel;
use tinkle\framework\Library\Cli\program\CliController;
use tinkle\framework\Library\Logger\Logger;
use tinkle\framework\Tinkle;

class DB extends CliController implements CliControllerInterface
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
        $this->migrationPath = $this->getRoot()."database/migrations/";
        $this->seederPath = $this->getRoot()."database/seeders/";

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
            echo "db".$this->getPattern()."migrate process completed";
        }else{
            echo "db".$this->getPattern()."migrate process failed";
        }
    }


    public function dropMigration()
    {
        if($this->migrationDownHelper())
        {
            echo "db".$this->getPattern()."dropmigration  process completed";
        }else{
            echo "db".$this->getPattern()."dropmigration process failed";
        }
    }

    public function reset(string $param=null)
    {
        if(is_null($param))
        {
            if($this->migrationModel->reset('migrations'))
            {
                echo "db".$this->getPattern()."refresh  process completed \n Truncate apply on migrations";
            }else{
                echo "db".$this->getPattern()."refresh process failed1";
            }

        }elseif (is_string($param))
        {
            if($this->migrationModel->reset($param))
            {
                echo "db".$this->getPattern()."refresh  process completed  \n Truncate apply on $param";
            }else{
                echo "db".$this->getPattern()."refresh process failed2";
            }
        }else{
            echo "db".$this->getPattern()."refresh process failed3";
        }


    }



    public function seed()
    {
        if($this->seederHelper())
        {
            echo "db".$this->getPattern()."seed process completed";
        }else{
            echo "db".$this->getPattern()."seed process failed";
        }


    }

    public function refreshSeed()
    {
        echo "db".$this->getPattern()."refreshSeed process not available";
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
                $this->logIt('Save Report Into DataBase And Logs');

            } else {
                $this->logIt("Migration Process Complete Successfully");

            }
        } else {
            $this->logIt("Nothing New For Applied For Migration!");

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
            $_tempObject = "\\tinkle\database\migrations\\".$_fileName;
            $_instance = array_values(class_implements(new $_tempObject));
            $classList [] =[
                'class'=> get_class(new $_tempObject),
                'instance' => array_shift($_instance),
                'details'=> pathinfo(Tinkle::$ROOT_DIR."database/migrations/".$migration),
                'classWithNameSpace'=> "\\tinkle\database\migrations\\".$_fileName,
            ];
        }

        return $classList;



    }

    private function getExistingMigrationFiles()
    {
        $fileList = $this->getAllFilesFrom($this->migrationPath);
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
            $_tempObject = "\\tinkle\database\migrations\\".$_fileName;
            $_instance = array_values(class_implements(new $_tempObject));
            $classList [] =[
                'class'=> get_class(new $_tempObject),
                'instance' => array_shift($_instance),
                'details'=> pathinfo(Tinkle::$ROOT_DIR."database/migrations/".$migration),
                'classWithNameSpace'=> "\\tinkle\database\migrations\\".$_fileName,
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
                    $this->logIt('Save Report Into DataBase And Logs');
                } else {
                    $this->logIt("Migration Process Complete Successfully");
                }
            }


        } else {
            $this->logIt("Nothing New For Applied For Migration!");
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