<?php


namespace Tinkle\Library\Designer\Div;
use Tinkle\Library\Designer\Div\Card as CardDesigner;
use Tinkle\Library\Designer\Nav\Nav;

class Div
{


    public function start(string $_class='', string $_attributes='')
    {
        echo sprintf('<div class="%s" %s>', $_class, $_attributes);
        return new Div();
    }

    public function end()
    {
        echo '</div>';
    }




    public function card()
    {
        return new CardDesigner();
    }






}