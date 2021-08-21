<?php


namespace tinkle\framework\Library\Render;



use tinkle\framework\Database\Migrations\Rule;
use tinkle\framework\Request;
use tinkle\framework\Response;
use tinkle\framework\Tinkle;

abstract class Render
{

    public string $layout='';
    public string $template='';
    public array $param=[];
    public object $handler;
    public object $request;
    public object $response;
    private string $existHtml='';
    public static Render $render;

    /**
     * Render constructor.
     * @param Request $request
     * @param Response $response
     */
    public function __construct(Request $request, Response $response)
    {
        self::$render = $this;
        $this->request = $request;
        $this->response = $response;


    }


    public function run(string $template='',array $param=[],bool $isTwig=false)
    {

        if(!empty($template))
        {

            if(!$this->isHTMLExist($template))
            {

                if($isTwig)
                {
                    $this->handler = new TwigHandler($template,$param,$this->getConfig());
                    if($this->handler->resolve())
                    {
                        $this->handler->display();
                    }
                }else{
                    $this->handler = new PhpHandler($template,$param,$this->getConfig());
                    if($this->handler->resolve())
                    {
                        return $this->handler->display();
                    }
                }
            }
        }else{
            return $this->getError();
        }
    }


    private function getConfig()
    {



        return ['path' =>Tinkle::$ROOT_DIR."resources/views/",
            'scheme'=> $this->request->getScheme(),
            'fullUrl'=> $this->request->getUrl(),
            'url' => $this->request->getRequestUrl(),
            'clientIp' => $this->request->getClientIP(),
            'env'=> Tinkle::$app->config['application']['production']
        ];
    }



    private function getError()
    {
        return file_get_contents(__DIR__."/Docs/index.html");
    }



    private function isHTMLExist($template)
    {
        return false;

    }





}