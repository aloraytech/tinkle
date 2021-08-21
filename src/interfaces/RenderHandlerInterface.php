<?php


namespace tinkle\framework\interfaces;


interface RenderHandlerInterface
{

    public function resolve():bool;

    public function display();


}