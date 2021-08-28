<?php


namespace Tinkle\Library\Cli\program\model\Make;


use Tinkle\Library\Cli\CliHandler;
use Tinkle\Library\Cli\program\Model;
use Tinkle\Tinkle;

class MigrationMaker extends Model
{




    public string $contFile='';
    public string $path='';
    public string $param='';

    /**
     * ControllerModel constructor.
     * @param string $param
     */
    public function __construct(string $param)
    {
        $this->param = $param;
        $this->path = Tinkle::$ROOT_DIR.'database/migrations/';
    }


    public function create()
    {
        if(file_exists($this->path.$this->getPrefix().$this->param.'.php'))
        {
            return false;
        }else{
            // Create New Migration
            $namespace = '';
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

//            $controller_file = @fopen($this->path.$this->getPrefix().$this->param.'.php',"w+") or die("Unable to open file!");
            // NOTE : IF I PUT PREFIX FOR MIGRATION CLASS FILE NAME. I HAVE TO PUT SAME INSIDE AS CLASS NAME, OR NEED TO REFACTORING A LOT
            // AS PER THIS FILES CREATE FOR SINGLE INDIVIDUAL TABLES, I REMOVE PREFIX FUNCTION.


            $controller_file = @fopen($this->path.$this->param.'.php',"w+") or die("Unable to open file!");
            $data = $this->getLayer('make/BlankMigration',$this->param,$namespace);

            $tableName = str_replace("Create",'',$this->param);
            $tableName = str_replace("Migration",'',$tableName);
            $tableName = str_replace("Table",'',$tableName);

            if(!is_null($data))
            {
                $data = str_replace("{{table}}",strtolower($tableName),$data);
                fwrite($controller_file,$data);
                fclose($controller_file);
                return true;
            }else{
                return false;
            }

        }
    }



    private function getPrefix()
    {
        return date("Ymd");
    }




}