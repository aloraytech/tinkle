<?php


namespace Tinkle;


use Tinkle\Library\Render\Render;
use Tinkle\Library\Render\Themes\Themes;

class View extends Render
{






    /**
     * View constructor.
     * @param Request $request
     * @param Response $response
     */
    public function __construct(Request $request, Response $response)
    {
        parent::__construct($request,$response);
    }










}