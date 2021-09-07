<?php
//declare(strict_types=1);

namespace Tinkle;

use App\models\UsersModel;


use Tinkle\Exceptions\ExceptionMagic;
use Tinkle\Library\Console\Console;
use Tinkle\Library\Essential\Essential;
use Tinkle\Exceptions\Display;
use Tinkle\Database\Database;
use Tinkle\Library\Designer\Designer;


 class Tinkle {

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
    protected static Console $console;
    public ?UsersModel $user;



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
      //  restore_error_handler();
        restore_exception_handler();
        set_exception_handler([new ExceptionMagic(), 'handle']);
        set_error_handler(array($this, 'ErrorHandler'));
        try {

            if($this->welcome())
            {


                if(is_string($rootPath) && is_array($config) && !empty($rootPath) && !empty($config))
                {

                    self::$ROOT_DIR = $rootPath.'/';
                    self::$app = $this;
                    $this->config = $config;
                    Essential::init();
                    $this->db = new Database ($this->config['db']);

                    if (!$this->isCli())
                    {
                        $this->request =  new Request();
                        $this->response = new Response();
                        $this->session = new Session();
                        $this->event = new Event();
                        $this->token = new Token();
                        $this->router = new Router($this->request,$this->response);
                        $this->designer = new Designer();
                        $this->view = new View($this->request,$this->response);
                        //$this->load_event_listners();

                        $this->userClass = $this->config['userModel'];

                        $primaryValue = $this->session->get('user');

                        if($primaryValue){
                            $primaryKey = $this->userClass::primaryKey();

                            $this->user = $this->userClass::findOne([$primaryKey => $primaryValue]);
                        }else{
                            $this->user = null;
                        }

                    }else{
                        self::$console = new Console($rootPath);
                    }

                }else{
                    throw new Display('Unexpected Error Found, Please Update or Reset Your Application',Display::HTTP_SERVICE_UNAVAILABLE);
                }
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

        if ($this->isCli())
        {
           self::$console->resolve();
        }else{

            Event::trigger(Event::EVENT_ON_LOAD);
            $this->router->resolve();
            Event::trigger(Event::EVENT_ON_END);
        }

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



    protected function welcome()
    {
        restore_error_handler();
        set_error_handler(array($this, 'ErrorHandler'));
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


    public function isCli()
    {
        if(PHP_SAPI === 'cli')
        {
            return true;
        }
        return false;
    }





}