<?php


namespace Tinkle;


use Tinkle\Library\Designer\Designer;
use Tinkle\Library\Render\Render;


class View
{

    public Render $render;
    public Designer $designer;
    public static View $view;
    private Request $request;
    private Response $response;



    /**
     * View constructor.
     * @param Request $request
     * @param Response $response
     */
    public function __construct(Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;
        $viewRender = new Render($this->request,$this->response);
        $this->render = $viewRender::$render;
        $this->designer = new Designer();

    }










}