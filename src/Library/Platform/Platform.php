<?php


namespace Tinkle\Library\Platform;


use App\PlatformProvider;
use Tinkle\Library\Essential\Essential;
use Tinkle\Request;
use Tinkle\Response;
use Tinkle\Tinkle;

class Platform
{

    protected string $namedUri='';
    protected static array|object $callback=[];
    protected static array|string $bigMenu=[];
    protected static string $providerMethod='';
    protected PlatformProvider $provider;




    /**
     * Platform constructor.
     * @param Request $request
     * @param Response $response
     * @param string $namedUri
     */
    public function __construct(Request $request, Response $response, string $namedUri='')
    {
        $this->namedUri = $namedUri;
        $this->provider = new PlatformProvider();
        $menu = new Menu(); // Initiate here for access static property for no static method;
    }


    public function resolve()
    {
        if($this->prepare())
        {
            echo "Found";
        }else{
            echo "Not Found";
        }
    }

    private function prepare()
    {
        $allRoute = $this->provider->getProvider();



        foreach ($allRoute as $key => $value)
        {
            if($key === $this->namedUri)
            {

                self::$providerMethod = $value['method'];
                self::$callback = $value['callback'];
                self::$bigMenu = $value['menu'];
                return true;
            }

        }
        return false;
    }

















}