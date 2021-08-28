<?php


namespace Tinkle\Library\Cli\program\controller;


use Tinkle\interfaces\CliControllerInterface;
use Tinkle\Library\Cli\program\model\Make\ControllerModel;
use Tinkle\Library\Cli\program\model\Make\MakerModel;
use Tinkle\Library\Cli\program\model\Make\ModelMaker;
use Tinkle\Library\Cli\program\model\Make\MigrationMaker;
use Tinkle\Library\Cli\program\CliController;

class Make extends CliController implements CliControllerInterface
{

    const TYPE_CONTROLLER = 'controller';
    const TYPE_MODEL = 'model';
    const TYPE_MIDDLEWARE = 'middleware';
    const TYPE_PLUGIN = 'plugin';
    const TYPE_MIGRATION = 'migration';
    const TYPE_SEEDER = 'seeder';



    public function Controller($param)
    {
        if(is_string($param))
        {
            $controller = new ControllerModel($param);
            if($controller->create())
            {
                echo "$param Controller Created Successfully";
            }else{
                echo "Error: Controller Exist or Location is Write Error!";
            }
        }

    }



    public function Model($param)
    {
        if(is_string($param))
        {
            $model = new ModelMaker($param);
            if($model->create())
            {
                echo "$param Model Created Successfully";
            }else{
                echo "Error: Model Already Exist or Location is Write Error!";
            }
        }

    }



    public function Migration($param)
    {
        if(is_string($param))
        {
            $model = new MigrationMaker($param);
            if($model->create())
            {
                echo "$param Model Created Successfully";
            }else{
                echo "Error: Model Already Exist or Location is Write Error!";
            }
        }

    }



    public function Seeder($param)
    {
        if(is_string($param))
        {
            $model = new MakerModel($param,self::TYPE_SEEDER);
            if($model->create())
            {
                echo "$param Model Created Successfully";
            }else{
                echo "Error: Model Already Exist or Location is Write Error!";
            }
        }

    }









    public function index()
    {
        // TODO: Implement index() method.
    }
}