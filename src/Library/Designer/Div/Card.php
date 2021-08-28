<?php


namespace Tinkle\Designer\Div;


class Card
{


    public function start(string $card_class='')
    {
        echo sprintf('<div class="card %s">', $card_class);
        return new Card();
    }


    public function header(string $card_header_class ='')
    {
        echo sprintf('<div class="card-header %s">', $card_header_class);
    }

    public function body(string $card_body_class ='')
    {
        echo sprintf('<div class="card-body %s">', $card_body_class);
    }

    public function footer(string $card_footer_class ='')
    {
        echo sprintf('<div class="card-footer %s">', $card_footer_class);
    }



    public function end()
    {
        echo '</div>';
    }







}