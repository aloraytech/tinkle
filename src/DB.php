<?php
/*
 * Package : DB.php
 * Project : tinkle
 * Created : 22/09/21, 9:18 PM
 * Last Modified : 22/09/21, 9:18 PM
 * Author : Krishanu Bhattacharya
 * Email :krishanu.info@gmail.com
 * Copyright (c) 2021.
 *
 *
 */

namespace Tinkle;


use Tinkle\Database\Access;
use Tinkle\Database\DBHandler;

class DB
{

    public DBHandler $handler;
    public Access $access;


    public function __construct()
    {
        $this->handler = new DBHandler();
        $this->handler->setConfig(Tinkle::$app->config['db']);

        $this->access = new Access($this->handler->getConnection());

    }


}