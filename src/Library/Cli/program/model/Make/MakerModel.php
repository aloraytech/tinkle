<?php


namespace tinkle\framework\Library\Cli\program\model\Make;


use tinkle\framework\Controller;
use tinkle\framework\Tinkle;

class MakerModel
{


    protected string $demo='';
    protected string $name='';
    protected string $type='';
    protected string $demoRoot='';
    protected string $namespace='';
    protected string $className='';
    protected string $param='';
    protected string $export_controller='';
    protected string $export_model='';
    protected string $export_middleware='';
    protected string $export_plugins='';
    protected string $export_migration='';
    protected string $export_seeder='';
    const ORG_EXT = ".php";
    const DEMO_EXT = ".txt";
    const TYPE_CONTROLLER = 'controller';
    const TYPE_MODEL = 'model';
    const TYPE_MIDDLEWARE = 'middleware';
    const TYPE_PLUGIN = 'plugin';
    const TYPE_MIGRATION = 'migration';
    const TYPE_SEEDER = 'seeder';

    /**
     * MakerModel constructor.
     * @param string $param
     * @param string $type
     */
    public function __construct(string $param,string $type )
    {
        $this->param = $name;
        $this->type = $type;
        $this->demoRoot = Tinkle::$ROOT_DIR."/src/Library/Cli/program/demos/";
        $this->export_controller = Tinkle::$ROOT_DIR."app/controller/";
        $this->export_middleware = Tinkle::$ROOT_DIR."app/middlewares/";
        $this->export_model = Tinkle::$ROOT_DIR."app/models";
        $this->export_plugins=Tinkle::$ROOT_DIR."app/plugins";
        $this->export_migration = Tinkle::$ROOT_DIR."app/migrations";
    }


     public function create ()
     {

     }







    // PRIVATE FUNCTIONS


    private function getNameAndNameSpace ()
    {

    }



    private function isExist()
    {

        switch ($this->type) {
            case self::TYPE_CONTROLLER:
                return file_exists($this->export_controller.$this->name.self::ORG_EXT) ? true:false;
                break;
            case self::TYPE_MIDDLEWARE:
                return file_exists($this->export_middleware.$this->name.self::ORG_EXT) ? true:false;
                break;
            case self::TYPE_MODEL:
                return file_exists($this->export_model.$this->name.self::ORG_EXT) ? true:false;
                break;
            case self::TYPE_PLUGIN:
                return file_exists($this->export_plugins.$this->name.self::ORG_EXT) ? true:false;
                break;
            case self::TYPE_MIGRATION:
                return file_exists($this->export_migration.$this->name.self::ORG_EXT) ? true:false;
                break;
            case self::TYPE_SEEDER:
                return file_exists($this->export_seeder.$this->name.self::ORG_EXT) ? true:false;
                break;
            default:
                return false;
        }
    }


    private function dirResolver()
    {
        if(preg_match_all('/\//',$this->param,$matches))
        {
            $paramParts = explode("/",$this->param);
            $count = count($paramParts);
            $path =$this->path;
            foreach ($paramParts as $key => $value)
            {
                if(!is_dir($path.$value) && $key != ($count-1))
                {
                    mkdir($path.$value);
                    $namespace .="$value/";
                    $path .= "$value/";
                }
            }

        }
        echo $namespace;
        echo "<br>";
        echo $path;
    }








}