<?php


namespace Tinkle\Library\Cli;


use Tinkle\Database\Database;
use Tinkle\Tinkle;

class CliModel extends Database
{


    /**
     * CliModel constructor.
     */
    public function __construct()
    {
        parent::__construct(Tinkle::$app->config['db']);
    }


}