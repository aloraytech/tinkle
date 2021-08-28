<?php


namespace Tinkle\Library\Cli\program\controller;


use Tinkle\interfaces\CliControllerInterface;
use Tinkle\Library\Cli\program\CliController;
use Tinkle\Library\Logger\Logger;
use Tinkle\Tinkle;

class Clear extends CliController implements CliControllerInterface
{


    public function index()
    {
        // TODO: Implement index() method.
    }




    public function all()
    {
        Logger::Logit("** ALL CLEARING PROCESS START ** \n");
            $this->logs();
            $this->views();
            $this->cache();
        Logger::Logit("** ALL CLEARING PROCESS FINISH ** \n");

    }

    public function logs()
    {
        $path = Tinkle::$ROOT_DIR."storage/logs/";
        Logger::Logit("Logs Clearing Process Start\n");
        if ($this->removeOnlyFilesFromDirectory($path))
        {
            Logger::Logit("All Logs Clearing Process Successfully Finish\n");
        }else{
            Logger::Logit("Logs Clearing Process Failed\n");
        }

    }




    public function views()
    {
        $path = Tinkle::$ROOT_DIR."storage/runtime/demos/";
        Logger::Logit("Views Clearing Process Start\n");
       if ($this->removeOnlyFilesFromDirectory($path))
       {
           Logger::Logit("All View Clearing Process Successfully Finish\n");
       }else{
           Logger::Logit("View Clearing Process Failed\n");
       }

    }


    public function cache()
    {
        $path = Tinkle::$ROOT_DIR."storage/cache/";
        $sessPath = Tinkle::$ROOT_DIR."storage/sessions/";
        Logger::Logit("Cache Clearing Process Start\n");
        if ($this->removeOnlyFilesFromDirectory($path) && $this->removeOnlyFilesFromDirectory($sessPath))
        {
            Logger::Logit("All Cache Clearing Process Successfully Finish\n");
        }else{
            Logger::Logit("Cache Clearing Process Failed\n");
        }

    }








    /**
     * @param string $path
     * @return bool
     */
    private function removeOnlyFilesFromDirectory(string $path)
    {

        if(!empty($path))
        {
            $fileList = scandir($path);
            foreach ($fileList as $key => $value)
            {
                if($value != '.' && $value!='..')
                {
                    Logger::Logit("$value - File Found \n");
                    unlink($path.'/'.$value);
                    Logger::Logit("$value - File Removed \n");
                }
            }
            if(empty(scandir($path)))
            {

            }else{
                return true;
            }
        }else{
            Logger::Logit("Tinkle CLI incompatible Error: Please Update Your Application. \n");
            return false;
        }
    }



}