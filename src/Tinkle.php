<?php
//declare(strict_types=1);

namespace Tinkle;

use App\Models\Auth\Users;
use App\models\UsersModel;


use Tinkle\Databases\DBHandler;
use Tinkle\Exceptions\ExceptionMagic;
use Tinkle\Library\Auth\Auth;
use Tinkle\Library\Console\Console;
use Tinkle\Library\Debugger\Debugger;
use Tinkle\Library\Essential\Essential;
use Tinkle\Exceptions\Display;
use Tinkle\Databases\Database;
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
    public DB $db;
    public View $view;
    public ?Controller $controller = null;
    public ?Plugins $plugins = null;
    public array $config;
    public Designer $designer;
    public Token $token;
    protected static Console $console;
    public ?Users $user;
    public Auth $auth;


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


        try {

            if($this->welcome())
            {
                if(is_string($rootPath) && is_array($config) && !empty($rootPath) && !empty($config))
                {
                    self::$ROOT_DIR = $rootPath.'/';
                    self::$app = $this;
                    $this->config = $config;
                    Essential::init();
                    $this->db = new DB($this->config['db']);
                    $this->db->setDefaultConnection();

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
                        $this->userClass = $this->config['userModel'];
                        $this->auth = new Auth();


                        // USER CREDENTIAL CHECKING
                        //$primaryValue = $this->session->get('user');
//                        if($primaryValue){
//                            $primaryKey = $this->userClass::primaryKey();
//
//                            $this->user = $this->userClass::findOne([$primaryKey => $primaryValue]);
//                        }else{
//                            $this->user = null;
//                        }
//                        $this->user = null;

                    }else{
                        self::$console = new Console($rootPath);
                    }
                }else{
                    throw new Display('Unexpected Error Found, Please Update or Reset Your Application',Display::HTTP_SERVICE_UNAVAILABLE);
                }
            }

        }catch (Display $e){
            if($this->isCli())
            {
                $e->Render();
            }else{
                $e->Render(true);
            }
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


    // PRE METHODS

     /**
      * @return bool
      */
     protected function load_event_listners()
     {
         require_once Tinkle::$ROOT_DIR.'/routes/listeners.php';
         return true;
     }

     /**
      * @return bool
      */
     protected function welcome()
     {
         restore_exception_handler();
         set_exception_handler([new ExceptionMagic(), 'handle']);
         restore_error_handler();
         set_error_handler(array($this, 'ErrorHandler'));
         return true;
     }

     /**
      * @param $severity
      * @param $message
      * @param $file
      * @param $line
      */
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
             $e->handle();
         }


     }


    // SYSTEM METHODS

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

     /**
      * @return Plugins|null
      */
     public function getPlugin()
     {
         return $this->plugins;
     }

     /**
      * @param $plugins
      * @return $this
      */
     public function setPlugin($plugins)
     {
         $this->plugins = $plugins;
         return $this;
     }

     /**
      * @return bool
      */
     public function isCli()
     {
         if(PHP_SAPI === 'cli')
         {
             return true;
         }
         return false;
     }



     // EVENT MANAGEMENT  |||||||||||||||||||||||||||||||||||||||||||||||

     /**
      * @param string $event
      * @param array $callback
      */
     public function setEvent(string $event,array $callback)
     {
         Event::set(Event::EVENT_ON_RUN,$event,$callback);
     }

     /**
      * @param string $event
      * @param mixed $parameter
      * @return mixed
      */
     public function getEvent(string $event, string|array|int $parameter='')
     {
         return Event::trigger(Event::EVENT_ON_RUN,$event,$parameter);
     }




     // SYSTEM USER METHODS |||||||||||||||||||||||||||||||||||||||||||||

     /**
      * @return bool
      */
    public static function isGuest()
    {
        return !self::$app->user;
    }

     /**
      * @param Users $user
      * @return bool
      */
    public function login(Users $user)
    {
        $this->user = $user;
        $primaryKey = $user->primaryKey();
        $value = $user->{$primaryKey};
        Tinkle::$app->session->set('user', $value);

        return true;
    }


    public function logout()
    {
      //  $this->user = null;
        if($this->db->getConnect()->close())
        {
            $this->response->redirect('/');
        }
        self::$app->session->remove('user');

    }




}