<?php


namespace tinkle\framework\Library\Http;


use tinkle\framework\Request;
use tinkle\framework\Tinkle;

class DomDocumentHandler
{

    public static DomDocumentHandler $domHandler;
    public object $dom;
    public array $tags;
    protected string $currentUrl='';

    /**
     * DomDocumentHandler constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        self::$domHandler = $this;
        $this->dom = new \DOMDocument();

        //$this->dom->loadHTML($request->getFullUrl());
//        $data = file_get_contents(Tinkle::$ROOT_DIR."storage/views/_login_Auth.login.html");
//        file_put_contents(Tinkle::$ROOT_DIR."abcd.html",base64_decode($data));
        $this->dom->loadHTMLFile(Tinkle::$ROOT_DIR."abcd.html");
        $this->currentUrl = Tinkle::$app->request->getBaseUrl();

    }




    public function getAll()
    {
//        $this->dom->
        $result = $this->dom->getElementsByTagName('meta')->item(0);
        //$result = $this->dom->count();
        echo "<pre>";
        print_r($result->getAttributeNode('viewport'));
    }



}