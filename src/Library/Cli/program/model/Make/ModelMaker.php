<?php


namespace tinkle\framework\Library\Cli\program\model\Make;


use tinkle\framework\Library\Cli\program\Model;
use tinkle\framework\Library\Cli\CliHandler;
use tinkle\framework\Tinkle;

class ModelMaker extends Model
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
        $this->path = Tinkle::$ROOT_DIR.'app/models/';
    }


    public function create()
    {
        if(file_exists($this->path.$this->param.'.php'))
        {
            return false;
        }else{
            // Create New Controller
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

            $controller_file = @fopen($this->path.$this->param.'.php',"w+") or die("Unable to open file!");;
            $data = $this->getLayer('make/BlankModel',$this->param,$namespace);
            if(!is_null($data))
            {
                $data = str_replace("{{lowname}}",strtolower(str_replace("model","",strtolower(str_replace($namespace,$this->param,$this->param)))),$data);
                fwrite($controller_file,$data);
                fclose($controller_file);
                return true;
            }else{
                return false;
            }

        }
    }





}