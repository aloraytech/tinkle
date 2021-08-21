<?php


namespace tinkle\framework\Library\Explorer;


use tinkle\framework\Request;
use tinkle\framework\Response;
use tinkle\framework\Tinkle;

class Explorer
{


    private Request $request;
    private Response $response;
    protected string $currentFile='';
    protected string $currentDir='';
    public string $directory = '';

    /**
     * Explorer constructor.
     * @param Request $request
     * @param Response $response
     * @param string $root_directory
     */
    public function __construct(Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;
        $this->directory = Tinkle::$ROOT_DIR."public/resources/";
    }









    public function explore(string $template='')
    {
        if($this->getExplorerDetails())
        {
            return $this->run();
        }
    }

    private function getExplorerDetails()
    {

        $files = scandir($this->directory);
        echo "<pre>";
        print_r($files);

        return true;
    }

    private function run()
    {
        return "<h1>Tinkle Explorer</h1>";
    }


}