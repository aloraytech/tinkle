<?php


namespace App;


use Tinkle\Library\Platform\Menu;

class App
{

        public static function getDefaultDatabase()
        {
            return $_ENV['DB_NAME'];
        }








}