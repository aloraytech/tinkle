<?php


namespace Tinkle\Library\Console\Application\Controllers;


use Database\DatabaseSeeder;
use Tinkle\Exceptions\Display;
use Tinkle\Library\Console\ConsoleController;
use Tinkle\Tinkle;
use function Sodium\add;


class Make extends ConsoleController
{

    protected string $event_dir='';
    protected string $listener_dir='';

    protected string $controller_dir='';
    protected string $model_dir='';
    protected string $plugin_dir='';

    protected string $theme_dir='';
    protected string $view_dir='';

    protected string $migration_dir='';
    protected string $seeder_dir='';

    protected string $cliController_dir='';
    protected string $cliModel_dir='';

    protected string $skeleton_dir='';

    protected string $skeletonData='';
    protected string $addonLocation='';

    protected string $testLocation='';



    public function __construct()
    {
        $this->controller_dir = Tinkle::$ROOT_DIR."app/Controllers/";
        $this->model_dir = Tinkle::$ROOT_DIR."app/Models/";
        $this->plugin_dir = Tinkle::$ROOT_DIR."app/Plugins/";
        $this->view_dir = Tinkle::$ROOT_DIR."app/Views/";
        $this->theme_dir = Tinkle::$ROOT_DIR."resources/views/";
        $this->migration_dir = Tinkle::$ROOT_DIR."database/migrations/";
        $this->seeder_dir = Tinkle::$ROOT_DIR."database/seeders/";
        $this->cliController_dir = Tinkle::$ROOT_DIR."src/Library/Console/Application/Controllers/";
        $this->cliModel_dir = Tinkle::$ROOT_DIR."src/Library/Console/Application/Models/";
        $this->skeleton_dir = Tinkle::$ROOT_DIR."src/Library/Console/Application/Skeletons/";
        $this->addonLocation='';
        $this->testLocation = Tinkle::$ROOT_DIR.'tests/';
    }

    public function index()
    {
        echo "Make>>Index";
    }


    public function event()
    {
        $layout = $this->getLayout('sample.php');
        print_r($layout);
    }

    public function controller(string $controller)
    {
        $controller = str_replace('\\','/',$controller);
        $controller = str_replace('.php','',$controller);
        $temp=[];
        if(preg_match("/\//",$controller,$matches))
        {
            $temp = explode('/',$controller);
            $length = count($temp);

            $controller = end($temp);
            unset($temp[$length-1]);
            if(!empty($temp))
            {
                $this->addonLocation = implode('/',$temp).'/';
            }

        }

        $controller = str_replace("Create",'',$controller);
        $controller = str_replace("create",'',$controller); // strtolower.. next time..

        $mainName = str_replace("Create",'',str_replace("Controller",'',$controller));


        $this->skeletonData = $this->getSkeleton('controller');
        if(!empty($this->skeletonData))
        {
            echo "Preparing...\n";
            if($this->applySkeleton($controller,$this->controller_dir.$this->addonLocation,$mainName,$temp))
            {
                echo "$controller File Created ...\n";
            }else{
                echo "$controller File Creation Failed! ...\n";
            }

        }else{
            echo "Controller Skeleton Not Found!";
        }
    }

    public function plugin()
    {

    }

    public function model(string $model)
    {
        $model = str_replace('\\','/',$model);
        $model = str_replace('.php','',$model);
        $temp=[];
        if(preg_match("/\//",$model,$matches))
        {
            $temp = explode('/',$model);
            $length = count($temp);

            $model = end($temp);
            unset($temp[$length-1]);
            if(!empty($temp))
            {
                $this->addonLocation = implode('/',$temp).'/';
            }

        }

        $model = str_replace("Create",'',$model);
        $model = str_replace("create",'',$model); // strtolower.. next time..
        $model = str_replace('Model','',$model);
        $model = str_replace('model','',$model);

        $isPlural = substr($model, -1);
        if($isPlural != 's' && $isPlural != 'S')
        {
            $model = $model.'s';
        }


        $mainName = $model;


        $this->skeletonData = $this->getSkeleton('model');
        if(!empty($this->skeletonData))
        {
            echo "Preparing...\n";
            if($this->applySkeleton($model,$this->model_dir.$this->addonLocation,$mainName,$temp))
            {
                echo "$model File Created ...\n";
            }else{
                echo "$model File Creation Failed! ...\n";
            }

        }else{
            echo "Model Skeleton Not Found!";
        }
    }

    public function view()
    {

    }

    public function theme()
    {

    }



    public function test(string $test)
    {
        $test = str_replace('\\','/',$test);
        $test = str_replace('.php','',$test);
        $temp=[];
        if(preg_match("/\//",$test,$matches))
        {
            $temp = explode('/',$test);
            $length = count($temp);

            $test = end($temp);
            unset($temp[$length-1]);
            if(!empty($temp))
            {
                $this->addonLocation = implode('/',$temp).'/';
            }

        }

        $test = str_replace("Create",'',$test);
        $test = str_replace("create",'',$test); // strtolower.. next time..

        $mainName = str_replace("Create",'',$test);


        $this->skeletonData = $this->getSkeleton('test');
        if(!empty($this->addonLocation))
        {
            $this->addonLocation = '\\'.$this->addonLocation;
        }
        if(!empty($this->skeletonData))
        {
            echo "Preparing...\n";
            if($this->applySkeleton($test,$this->testLocation.$this->addonLocation,$mainName,$temp))
            {
                echo "$test File Created ...\n";
            }else{
                echo "$test File Creation Failed! ...\n";
            }

        }else{
            echo "TestClass Skeleton Not Found!";
        }
    }












    public function migration(string $migration)
    {
        $migration = str_replace('\\','/',$migration);
        if(preg_match("/\//",$migration,$matches))
        {
            $temp = explode('/',$migration);
            $migration = $temp[1];
            $this->addonLocation = $temp[0].'/';
        }

        if(Tinkle::$app->config['db']['db_service_by'] != 'native'){
            $this->skeletonData = $this->getSkeleton('eloquent_migration');
        }
        else{
            $this->skeletonData = $this->getSkeleton('migration');
        }




        if(!empty($this->skeletonData))
        {
            echo "Preparing...\n";
          $this->updateNApplyMigrationSkeleton($migration);
            echo "$migration File Created ...\n";
        }else{
            echo "Migration Skeleton Not Found!";
        }
    }

    public function seeder(string $seeder)
    {
        $seeder = str_replace('\\','/',$seeder);
        if(preg_match("/\//",$seeder,$matches))
        {
            $temp = explode('/',$seeder);
            $seeder = $temp[1];
            $this->addonLocation = $temp[0].'/';
        }

        $mainName = str_replace("Table",'',str_replace("Seeder",'',$seeder));


        $this->skeletonData = $this->getSkeleton('seeder');
        if(!empty($this->skeletonData))
        {
            echo "Preparing...\n";
            if($this->applySkeleton($seeder,$this->seeder_dir.$this->addonLocation,$mainName))
            {
                echo "$seeder File Created ...\n";
            }else{
                echo "$seeder File Creation Failed!";
            }

        }else{
            echo "Seeder Skeleton Not Found!";
        }
    }





    // For Console Only

    public function cliController()
    {

    }

    public function cliModel()
    {

    }













    // Private Methods

    private function getSkeleton(string $skeleton_name): bool|string
    {
        if(file_exists($this->skeleton_dir.$skeleton_name.".skeleton"))
        {
            return file_get_contents($this->skeleton_dir.$skeleton_name.".skeleton");
        }
        return '';
    }


    private function applySkeleton(string $fileName, string $location,string $mainName,string|array $namespace='')
    {
        chdir(Tinkle::$ROOT_DIR);
        $namespace_detail = '';
        if(!is_dir($location))
        {
            mkdir($location,0777, true);
        }


        if(!empty($namespace))
        {
            if(is_array($namespace))
            {
                $namespace_detail = '\\'.implode('\\',$namespace);
            }
            if(is_string($namespace))
            {
                $namespace_detail='\\'.$namespace;
            }

        }


        //update Skeleton
        $this->skeletonData = str_replace('{{main}}',strtolower($mainName),$this->skeletonData);
        $this->skeletonData = str_replace('{{class}}',$fileName,$this->skeletonData);
        $this->skeletonData = str_replace('{{author}}',strtolower($_ENV['APP_AUTHOR']??''),$this->skeletonData);
        $this->skeletonData = str_replace('{{version}}',strtolower($_ENV['APP_VERSION']??''),$this->skeletonData);
        $this->skeletonData = str_replace('{{namespace}}',$namespace_detail,$this->skeletonData);



        // Saving File
        try{

            if(!file_exists($location.$fileName.'.php'))
            {

                if($handler = fopen($location.$fileName.'.php','w+'))
                {
                    if(fwrite($handler,$this->skeletonData))
                    {
                        fclose($handler);
                    }else{
                        throw new Display("File Can't be written, Change permission of the file :  $fileName",Display::HTTP_SERVICE_UNAVAILABLE);
                    }
                }else{
                    throw new Display("Location is Not Accessible, Change permission of the location : $location",Display::HTTP_SERVICE_UNAVAILABLE);
                }
            }else{
                throw new Display("<i>$fileName</i> <b> Already Exist! </b>");
            }

        }catch (Display $e){
            $e->Render();
        }


        // Returning Finally
        return true;



    }

        private function updateSkeleton()
        {

        }




    private function updateNApplyMigrationSkeleton(string $className)
    {
        if(!is_dir($this->migration_dir.$this->addonLocation))
        {
            mkdir($this->migration_dir.$this->addonLocation);
        }

        $existingSerial=[];
        // Scan And Get Prefix
        $all = $this->scanNget($this->migration_dir);
        foreach ($all as $mFile)
        {
            if(preg_match('/^m\d+/',$mFile,$matches))
            {
                $existingSerial[]=$matches[0];
            }
        }
        $lastSerial = str_replace('m','',end($existingSerial));
        $Serial = $lastSerial+1;
        $length = strlen($Serial);
        if($length=1)
        {
            $Serial = 'm00'.$Serial;
        }elseif ($length=2)
        {
            $Serial = 'm0'.$Serial;
        }else{
            $Serial = 'm'.$Serial;
        }
        // Setup
        $applicableFileName = $Serial.$className;
        $ParticularClassName=str_replace('Create','',str_replace('Migration','',$className));

        //update Skeleton
        $this->skeletonData = str_replace('{{main}}',strtolower($ParticularClassName),$this->skeletonData);
        $this->skeletonData = str_replace('{{class}}',$applicableFileName,$this->skeletonData);
        $this->skeletonData = str_replace('{{author}}',strtolower($_ENV['APP_AUTHOR']??''),$this->skeletonData);
        $this->skeletonData = str_replace('{{version}}',strtolower($_ENV['APP_VERSION']??''),$this->skeletonData);





        // Saving File
        $handler = fopen($this->migration_dir.$this->addonLocation.$applicableFileName.'.php','w+');
        fwrite($handler,$this->skeletonData);
        fclose($handler);
        // Returning Finally
        return true;
    }




}