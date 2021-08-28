<?php


namespace Tinkle\Library\Cli\program\model\Make;



use Tinkle\Library\Cli\CliModel;
use Tinkle\Tinkle;

class ControllerModel extends CliModel
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
        $this->path = Tinkle::$ROOT_DIR.'app/controllers/';
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

            $controller_file = @fopen($this->path.$this->param.'.php',"w+") or die("Unable to open file!");
            $data = $this->getLayer('make/BlankController',$this->param,$namespace);
            if(!is_null($data))
            {
                fwrite($controller_file,$data);
                fclose($controller_file);
                return true;
            }else{
                return false;
            }

        }
    }




}