<?php


namespace Tinkle\interfaces;


interface RenderHandlerInterface
{

    public function resolve():bool;

    public function display();


}