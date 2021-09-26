<?php


namespace Tinkle\Library\Console\Application\Controllers;


use Database\DatabaseSeeder;
use Tinkle\Library\Console\ConsoleController;
use Tinkle\Library\Console\Application\Models\DB\MigrationModel;
use Tinkle\Library\Console\Application\Models\DB\SeederModel;
use Tinkle\Tinkle;

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
                    echo "\n $key : Drop $table Table From DBConfig";
                }else{
                    echo "db".$this->pattern."reset process failed when reset DBConfig";
                }
            }

        }elseif (is_string($tableName) && !empty($tableName))
        {
            if($this->migrationModel->drop($tableName))
            {
                echo "\n Drop $tableName Table From DBConfig";
            }else{
                echo "db".$this->pattern."DB reset process failed2";
            }
        }else{
            echo "db".$this->pattern."DBConfig reset process";
        }

        echo "\nDBConfig Reset Process Complete...\n";

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
        //dd($queryList);
        $readyMigration=[];
        $pendingMigration=[];
        foreach ($queryList as $query)
        {
            // fILE nAME
            $migrationFileName = $query['file'];
            // Check for Up Queries

            if(isset($query['up']))
            {
                $upQuery = explode(';',$query['up']); // This Delimiter must have one for qualify db query
                if(preg_match('/^CREATE/',$upQuery[0],$matches))
                {
                    if(!empty($matches))
                    {
                        $readyMigration[$migrationFileName][] = $upQuery[0];
                    }

                }

                unset($upQuery[0]);

                if(!empty($upQuery))
                {
                    foreach ($upQuery as $qkey => $qva)
                    {

                        if(!empty($qva))
                        {

                            if(isset($pendingMigration[$migrationFileName]))
                            {
                                foreach ($pendingMigration as $pKey => $pending)
                                {
                                    if($pending != $qva)
                                    {
                                        if(preg_match('/^ALTER/',$qva,$matches))
                                        {
                                            if(!empty($matches))
                                            {
                                                $pendingMigration[$migrationFileName][]=$qva;
                                            }
                                        }

                                    }
                                }
                            }else{
                                if(preg_match('/^ALTER/',$qvas,$matches))
                                {
                                    if(!empty($matches))
                                    {
                                        $pendingMigration[$migrationFileName][]=$qvas;
                                    }
                                }
                            }

                        }

                    }
                }
            }


            if(isset($query['alter']))
            {
                $altQuery = explode(';',$query['up']); // This Delimiter must have one for qualify db query
                foreach ($altQuery as $qkey => $qvas)
                {
                    if(!empty($qvas))
                    {
                        if(!empty($qvas))
                        {

                            if(isset($pendingMigration[$migrationFileName]))
                            {
                                foreach ($pendingMigration as $pKey => $pending)
                                {
                                    if($pending != $qvas)
                                    {
                                        if(preg_match('/^ALTER/',$qvas,$matches))
                                        {
                                            if(!empty($matches))
                                            {
                                                $pendingMigration[$migrationFileName][]=$qvas;
                                            }
                                        }
                                    }
                                }
                            }else{
                                if(preg_match('/^ALTER/',$qvas,$matches))
                                {
                                    if(!empty($matches))
                                    {
                                        $pendingMigration[$migrationFileName][]=$qvas;
                                    }
                                }
                            }

                        }
                    }
                }
            }



        }


        // NOW WE GET FILTERED QUERY FOR OUR DATABASE
        // SO, RUN THEM
        // Now We Seperated All CREATE AND ALTER CALLS AND STORE THEM IN $readyMigration AND $pendingMigration

        // Take Necessary Action For $readyMigration

//        dd($readyMigration,'','','Ready Migration');
//        dd($pendingMigration,'','','Pending Migration');



        $Bag=[];
        if(!empty($readyMigration))
        {
            if(is_array($readyMigration))
            {
                foreach ($readyMigration as $key=> $migration)
                {
                    if(!empty($migration[0]))
                    {
                        if($this->migrationModel->createMigrations($migration[0]))
                        {
                         continue;
                        }
                        $Bag[] = $key;
                    }
                    unset($readyMigration[$key]);
                }
            }
        }



        if(empty($readyMigration) && !empty($pendingMigration))
        {
            if(is_array($pendingMigration))
            {
                foreach ($pendingMigration as $key=> $migration)
                {
                    if(is_array($migration))
                    {
                        foreach ($migration as $migrate)
                        {
                            if(!empty($migrate))
                            {
                                if($this->migrationModel->createMigrations($migrate))
                                {
                                    continue;
                                }
                            }
                        }
                    }

                    unset($pendingMigration[$key]);

                }
            }
        }




        // Take Record Of Current Query

        if(!empty($Bag))
        {
            foreach ($Bag as $key =>$value)
            {
                if(!in_array($key,$newMigrations,true))
                {
                    $newMigrations[] = $value;
                }
            }
        }

//        $newMigrations[] = $query['file'];










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
//            require_once Tinkle::$ROOT_DIR."database/migrations/".$migration;
//            $className = pathinfo($_fileName,PATHINFO_FILENAME);
//
//            dd($_fileName);
//
//            dd($className,'pink');


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
        foreach ($classList as $key => $migration)
        {

            $object = new $migration['class'];
//            if($object->up())
//            {
//                $_details[0] = ['file' => $migration['details']['basename']??'',];
//                if($object->alter())
//                {
//                    if($object->down())
//                    {
//
//                    }
//                }
//            }

                $object->up();
                $up = $object->getUp()??'';

                $object->alter();
                $alt = $object->getAlter()??'';

                $object->down();
                $dwn = $object->getDown()??'';




                $_details[] = [
                    'file' => $migration['details']['basename']??'',
                    'up' => $up,
                    'alter' => $alt,
                    'down'=> $dwn,
                    'code'=>$object->generate_code(),
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