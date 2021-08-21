<?php


namespace tinkle\framework\Library\Cli;


use tinkle\framework\Database\Database;
use tinkle\framework\Tinkle;

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