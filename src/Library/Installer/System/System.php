<?php


namespace tinkle\framework\Library\Installer\System;


use tinkle\framework\Library\Essential\Essential;
use tinkle\framework\Tinkle;

class System
{

    private string $_report = '';
    public int $errors=0;
    private string $errorData = '';
    private string $errorFor='';
    public array $appDir=[
        'controllers' => 1,
    'models' => 1,
    'middlewares' => 1,
    'plugins' => 1,
    'config' => 1,
    'migrations' => 1,
    'seeders' => 1,
    'views' => 1,
    'routes' => 1,
    'cache' => 1,
    'logs' => 1,
    'runtime' => 1,
    ];
    public array  $appFile = [
    'AppController' => 1,
    'AuthController' => 1,
    'Config' => 1,
    'web' => 1,
    'private' => 1,
    'api' => 1,
    'listeners' => 1,
    'env' => 1,
    'tinkle' => 1,
    ];

    /**
     * System constructor.
     */
    public function __construct()
    {
        $this->_report = Tinkle::$ROOT_DIR."storage/runtime/system/_structure.json";
    }

    public function verify()
    {

//        if(Tinkle::$app->session->get('system_check_time'))
//        {
//
//        }


        if($this->verifyRecord())
        {

            return true;
        }else{
            if(empty(array_diff_assoc($this->checkDirs(),$this->appDir)))
            {
                if(empty(array_diff_assoc($this->checkPreExistingFiles(),$this->appFile)))
                {
                    if(!empty($this->getEnvSecretAppCode()))
                    {
                        if($this->getDBConnectionStatus())
                        {

                            if($this->verifyRecord())
                            {
                                return true;
                            }
                            return false;
                        }
                    }
                }
                Tinkle::$app->session->set('system_error','System File Error; For More system_error_details');
                return false;
            }
            Tinkle::$app->session->set('system_error','System Directory Error; For More system_error_details');
            return false;
        }
        return false;
    }




    private function checkDirs()
    {
        $data = [
          'controllers' => is_dir(Tinkle::$ROOT_DIR."app/controllers") ? true : false,
          'models' => is_dir(Tinkle::$ROOT_DIR."app/models") ? true : false,
          'middlewares' => is_dir(Tinkle::$ROOT_DIR."app/middlewares") ? true : false,
          'plugins' => is_dir(Tinkle::$ROOT_DIR."app/plugins") ? true : false,
          'config' => is_dir(Tinkle::$ROOT_DIR."config") ? true : false,
          'migrations' => is_dir(Tinkle::$ROOT_DIR."database/migrations") ? true : false,
          'seeders' => is_dir(Tinkle::$ROOT_DIR."database/seeders") ? true : false,
          'views' => is_dir(Tinkle::$ROOT_DIR."resources/views") ? true : false,
          'routes' => is_dir(Tinkle::$ROOT_DIR."routes") ? true : false,
          'cache' => is_dir(Tinkle::$ROOT_DIR."storage/cache") ? true : false,
          'logs' => is_dir(Tinkle::$ROOT_DIR."storage/logs") ? true : false,
          'runtime' => is_dir(Tinkle::$ROOT_DIR."storage/runtime") ? true : false,
        ];
        foreach ($data as $key => $value)
        {
            if($value)
            {
                continue;
            }else{
                Tinkle::$app->session->set('system_error_details',$key);
            }
        }
        $this->keepRecord($data);
        return $data;
    }




    private  function checkPreExistingFiles()
    {
        $data = [
            'AppController' => is_readable(Tinkle::$ROOT_DIR."app/controllers/AppController.php") ? true:false,
            'AuthController' => is_readable(Tinkle::$ROOT_DIR."app/controllers/AuthController.php") ? true : false,
            'Config' => is_readable(Tinkle::$ROOT_DIR."config/Config.php") ? true:false,
            'web' =>is_readable(Tinkle::$ROOT_DIR."routes/web.php") ? true:false,
            'private' =>is_readable(Tinkle::$ROOT_DIR."routes/private.php") ? true:false,
            'api' =>is_readable(Tinkle::$ROOT_DIR."routes/api.php") ? true:false,
            'listeners' =>is_readable(Tinkle::$ROOT_DIR."routes/listeners.php") ? true:false,
            'env' =>is_readable(Tinkle::$ROOT_DIR.".env") ? true:false,
            'tinkle' =>is_readable(Tinkle::$ROOT_DIR."tinkle.php") ? true:false,
        ];
        foreach ($data as $key => $value)
        {
            if($value)
            {
                continue;
            }else{
                Tinkle::$app->session->set('system_error_details',$key);
            }
        }
        $this->keepRecord($data);
        return $data;
    }



    private function getEnvSecretAppCode ()
    {
        return $_ENV['APP_SECRET'];
    }


    private function getDBConnectionStatus()
    {

       return Tinkle::$app->db->prepare("USE ".$_ENV['DB_NAME'])->execute();
    }


    private function keepRecord(array $array)
    {

        if(!file_exists($this->_report))
        {
            fclose(fopen($this->_report,'w+'));
        }
        $data = Essential::getHelper()->ObjectToArray(json_decode(file_get_contents($this->_report)));

        if(!empty($data) && is_array($data) || !is_null($data))
        {
            $newData = array_merge($data,$array);
        }else{
            $newData =$array;
        }

        file_put_contents($this->_report,json_encode($newData));

        return true;

    }

    private function verifyRecord()
    {

        if(file_exists($this->_report))
        {
            $data = Essential::getHelper()->ObjectToArray(json_decode(file_get_contents($this->_report)));
            if(is_array($data))
            {

                foreach ($data as $arg)
                {
                    if($arg)
                    {
                       continue;
                    }else{
                        $this->errors += 1;
                        Tinkle::$app->session->set('system_error_details',$arg);
                    }
                }
                    if($this->errors !=0)
                    {
                        return false;
                    }else{
                        Tinkle::$app->session->set('system_check_time',time());

                        return true;
                    }
            }
            return false;
        }
        return false;

    }


}