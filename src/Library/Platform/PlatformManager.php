<?php


namespace Tinkle\Library\Platform;


use App\Provider\PlatformProvider;
use Tinkle\Exceptions\Display;
use Tinkle\Library\Essential\Essential;
use Tinkle\Library\Render\Render;
use Tinkle\Library\Router\Cloner;
use Tinkle\Request;
use Tinkle\Response;
use Tinkle\Tinkle;

class PlatformManager
{

    public const FRONTEND='frontend';
    public const BACKEND='frontend';
    public const PLATFORM_GET='GET';
    public const PLATFORM_POST='POST';
    public const PLATFORM_PUT='PUT';
    public const PLATFORM_DELETE='DELETE';

    protected static PlatformManager $manager;
    protected string $namedUri='';
    protected Request $request;
    protected Response $response;
//    protected static array|object $callback=[];
//    protected static array|string $bigMenu=[];
//    protected static string $providerMethod='';
    protected PlatformProvider $provider;
    protected array $platformRoutes=[];

    public string|object $current_front_theme = '';
    public string|object $current_back_theme = '';
    public string $current_template='';
    protected string|array|int|bool $request_pluginData = [];

    protected array|string|object|int $uriCallBackData=[];
    protected array|string|object|int $uriCommonData=[];
    protected string $uriThemeFor='';
    protected string $location='';


    /**
     * PlatformManager constructor.
     * @param Request $request
     * @param Response $response
     * @param string $namedUri
     * @param array $platformRoutes
     */
    public function __construct(Request $request, Response $response, string $namedUri,array $platformRoutes)
    {
        self::$manager = $this;
        $this->request = $request;
        $this->response = $response;
        $this->namedUri = $namedUri;
        $this->platformRoutes = $platformRoutes;
        $this->provider = new PlatformProvider();
        // $menu = new Menu(); // Initiate here for access static property for no static method;
    }


    public function resolve()
    {
        $this->provider->getPlatformRoutes();

        $this->platformDispatcher();




         return $this->getManagerReport();


    }





    public function getManagerReport()
    {
        return [
            'uri'=> $this->namedUri,
            'themeFor' => $this->uriThemeFor,
            'themeDir'=>$this->location,
            'callback'=>$this->uriCallBackData,
            'frontend'=> $this->current_front_theme,
            'frontendData'=> $this->current_front_theme->getThemeData()??[],
            'backend'=> $this->current_back_theme,
            'backendData'=> $this->current_back_theme->getThemeData()??[],
            'template'=>$this->current_template,
            'provider'=>$this->provider,
            'common'=>$this->provider->getPlatformCommonModules()??[],
        ];
    }










    public function platformDispatcher()
    {
        $method = strtoupper($this->request->getMethod());


        if(isset($this->platformRoutes[$method]))
        {
            $allroutes = $this->platformRoutes[$method];

            foreach ($allroutes as $uri => $value)
            {

                if($this->namedUri === $uri)
                {
                    $this->uriThemeFor = $value['type'];

                    if($value['auth'])
                    {

                        if(!Tinkle::isGuest())
                        {
                            return $this->dispatch($value['callback']);
                        }

                    }else{
                        return $this->dispatch($value['callback']);
                    }

                }
            }


        }else{
            echo "Platform Request Not Found For Uri :".$this->namedUri;
        }


    }



    private function dispatch($callback)
    {

        try{

            if(is_object($callback))
            {
                $cloner = new Cloner($callback);
                $this->uriCallBackData =  $cloner->resolve();
            }elseif(is_string($callback)){
                $result = $callback;
            }elseif($callback === false){
                throw new Display('Request Not Found',404);
            }else{

                if(is_array($callback))
                {
                    if($callback[0] instanceof \Closure)
                    {
                        $this->lambdaDispatcher($callback);
                    }else{
                        // Standard Callback
                        // Create Plugins Instance
                        /** @var \App\Plugins $plugins */
                        $plugins= new $callback[0]();
                        Tinkle::$app->plugins = $plugins;
                        $plugins->action = $callback[1];
                        $callback[0] = $plugins;


                        // Now Configure For Platform Request & Response

                        $this->uriCallBackData = $this->getCallbackData($callback);
                         $this->getPlatformData($callback[0]);


                        return true;


                        // Now Configure For Platform Request & Response


                    }
                    // Standard Callback End
                }

            }


        }catch (Display $e)
        {
            $e->Render();
        }


    }






    // T
    private function getPlatformData(object $object)
    {
        $givenTheme = $object->getLayout();
        $this->current_template = $object->getTemplate();

        if(is_string($givenTheme))
        {
            // current front theme grabbing
            // current back theme grabbing
            $this->getThemeForPlatform($givenTheme);
        }
        return true;

    }


    private function getThemeForPlatform(string $givenTheme)
    {
        if(strtoupper($givenTheme) === 'MASTER')
        {
            $this->location = Tinkle::$ROOT_DIR."resources/themes/".ucfirst($givenTheme).'/';

            if(is_object($this->provider->getDefaultFrontLayout()))
            {
                $thm = $this->provider->getDefaultFrontLayout();
                if($thm->isFront())
                {
                    $this->current_front_theme = $this->provider->getDefaultFrontLayout();
                }

            }


            if(is_object($this->provider->getDefaultBackLayout()))
            {
                $thm = $this->provider->getDefaultBackLayout();
                if($thm->isBack())
                {
                    $this->current_back_theme = $this->provider->getDefaultBackLayout();
                }
            }

        }else{

            $thm = $this->getAdminDefineThemeObject($givenTheme);
            if($thm->isFront())
            {
                $this->current_front_theme = $thm;
            }

            if($thm->isBack())
            {
                $this->current_back_theme = $thm;
            }

        }
        return true;
    }




    private function getAdminDefineThemeObject(string $givenTheme)
    {
        // CUSTOM ADMIN DEFINE THEME
        try {
            if(file_exists(Tinkle::$ROOT_DIR.'resources/themes/'.ucfirst($givenTheme).'/'.ucfirst($givenTheme).'.php'))
            {
                $this->location = Tinkle::$ROOT_DIR.'resources/themes/'.ucfirst($givenTheme).'/';
                $themeClass = 'Themes\\'.ucfirst($givenTheme).'\\'.ucfirst($givenTheme);
                return new $themeClass();

            }elseif (file_exists(Tinkle::$ROOT_DIR.'public/resources/themes/'.ucfirst($givenTheme).'/'.ucfirst($givenTheme).'.php'))
            {
                $this->location = Tinkle::$ROOT_DIR.'public/resources/themes/'.ucfirst($givenTheme).'/';
                //In Case Theme Locate In Public Directory, I assume that you put your theme in same directory structure inside public
                require_once Tinkle::$ROOT_DIR.'public/resources/themes/'.ucfirst($givenTheme).'/'.ucfirst($givenTheme).'.php';
                $themeClass = 'Themes\\'.ucfirst($givenTheme).'\\'.ucfirst($givenTheme);
                return new $themeClass();
            }else{
                throw new Display(ucfirst($givenTheme)." Theme Not Found",Display::HTTP_SERVICE_UNAVAILABLE);
            }
        }catch (Display $e){
            $e->Render();
        }

    }






    private function getCallbackData(array $callback)
    {
        $this->request_pluginData = call_user_func($callback,$this->request,$this->response);
        return $this->request_pluginData;
    }
















// Platform Routes

    public static function add(string $method,string $type, string $uri, array $callback, bool $auth=false)
    {
        self::$manager->platformRoutes[strtoupper($method)][$uri]['callback'] =  $callback;
        self::$manager->platformRoutes[strtoupper($method)][$uri]['auth'] =  $auth;
        self::$manager->platformRoutes[strtoupper($method)][$uri]['type'] =  $type;
    }
























    //Class Ends Here








}