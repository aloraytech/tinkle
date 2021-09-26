<?php


namespace Tinkle\Library\Console\Application\Controllers;


use Tinkle\Library\Console\ConsoleController;
use Tinkle\Tinkle;


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

    public function controller()
    {

    }

    public function plugin()
    {

    }

    public function model()
    {

    }

    public function view()
    {

    }

    public function theme()
    {

    }

    public function migration()
    {

    }

    public function seeder()
    {

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
        $data = '';
        if(file_exists($this->skeleton_dir.$skeleton_name.".php"))
        {
            $data = file_get_contents($this->skeleton_dir.$skeleton_name.".php");
        }
        return $data;
    }


    private function applySkeleton(string $fileName, string $location)
    {

    }











}