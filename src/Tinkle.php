<?php
//declare(strict_types=1);

namespace Tinkle;

use App\models\UsersModel;

use Tinkle\Library\Cli\CliHandler;
use Tinkle\Library\Commander\Commander;
use Tinkle\Library\Essential\Essential;
use Tinkle\Exceptions\Display;
use Tinkle\Database\Database;
use Tinkle\Library\Designer\Designer;
use Tinkle\System\System;

abstract class Tinkle {

    public string $layout = 'main';
    public static string $ROOT_DIR;
    public static Tinkle $app;
    public Event $event;
    public Router $router;
    public Request $request;
    public Response $response;
    public Session $session;
    public Database $db;
    public View $view;
    public ?Controller $controller = null;
    public array $config;
    public Designer $designer;
    public Token $token;
    public System $system;
    public ?UsersModel $user;
    private static CliHandler $CLI;
    private static Commander $commander;


      // Put ? sign infront for Null Value like Visitor
    /**
     * @var mixed
     */
    private $userClass;


    /**
     * Application constructor.
     * @param array $config
     * @param string $rootPath
     * @throws Display
     */
    public function __construct(string $rootPath,array $config)
    {





        // First Thing First
//        restore_error_handler();
//        set_error_handler(array($this, 'ErrorHandler'));
        try {

            if(is_string($rootPath) && is_array($config) && !empty($rootPath) && !empty($config))
            {

                self::$ROOT_DIR = $rootPath.'/';
                self::$app = $this;
                $this->config = $config;
                $this->db = new Database ($this->config['db']);
                $this->request =  new Request();
                $this->response = new Response();
                if (PHP_SAPI === 'cli')
                {
                    self::$CLI = new CliHandler($this->config,self::$ROOT_DIR);

//            self::$commander = new Commander();
//            self::$commander->setConfig($this->config['argv']);

                }else{



                    $this->session = new Session();
                    Essential::init();
                    $this->token = new Token();
                    $this->router = new Router($this->request,$this->response);
                    $this->designer = new Designer();
                    $this->view = new View($this->request,$this->response);
                    $this->event = new Event();
                    $this->load_event_listners();

                    $this->userClass = $this->config['userModel'];
                    // $this->session->set('user',1);

                    $primaryValue = $this->session->get('user');

                    if($primaryValue){
                        $primaryKey = $this->userClass::primaryKey();

                        $this->user = $this->userClass::findOne([$primaryKey => $primaryValue]);
                    }else{
                        $this->user = null;
                    }


                }

            }else{
                throw new Display('Unexpected Error Happen In Tinkle',500);
            }



        }catch (Display $e){
            $e->Render();
        }





    }




    /**
     * @throws \Symfony\Component\HttpFoundation\Exception\SuspiciousOperationException
     */
    public function run()
    {
        if (PHP_SAPI === 'cli')
        {
           self::$CLI->run();
            //   self::$commander->resolve();
        }else{
            $this->router->resolve();
        }





        //Apply Event on Process
//        $this->triggerEvent(self::EVENT_BEFORE_REQUEST);
//
//
//
//        // Just Echo it
//        //echo  $this->router->resolve();
//
//        //Use Try n Catch For Exception Handeling
//        try{
//            echo  $this->router->resolve();
//        }catch(\Exception $e){
//            $this->response->setStatusCode($e->getCode());
//            echo $this->view->renderView('_error',[
//                'exception' => $e
//            ]);
//        }

    }


    /**
     * @return Controller|null
     */
    public function getController()
    {
        return $this->controller;
    }


    /**
     * @param $controller
     * @return $this
     */
    public function setController($controller)
    {
        $this->controller = $controller;
        return $this;
    }






    protected function load_event_listners()
    {
       require_once Tinkle::$ROOT_DIR.'/routes/listeners.php';
        return true;
    }







    public static function ErrorHandler($severity, $message, $file, $line)
    {

        try {
            if (!empty($severity) && !empty($message)) {
                // This error code is not included in error_reporting
                $msg = "_msg=$message"."&_line=$line"."&_file=$file"."&_severity=$severity";
                throw new Display("$msg");
            }else{
                return;
            }

        } catch (Display $e) {
            $e->ErrorToException();
        }


    }

    public static function isGuest()
    {
        return !self::$app->user;
    }

    public function login(UserHandler $user)
    {
        $this->user = $user;
        $primaryKey = $user->primaryKey();
        $value = $user->{$primaryKey};
        Tinkle::$app->session->set('user', $value);

        return true;
    }

    public function logout()
    {
        $this->user = null;
        self::$app->session->remove('user');
    }


    // Php Closers





}