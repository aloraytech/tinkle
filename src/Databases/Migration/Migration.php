<?php
/*
 * Package : Migration.php
 * Project : tinkle
 * Created : 26/09/21, 4:26 AM
 * Last Modified : 26/09/21, 4:26 AM
 * Author : Krishanu Bhattacharya
 * Email :krishanu.info@gmail.com
 * Copyright (c) 2021.
 *
 *
 */

namespace Tinkle\Databases\Migration;

abstract class Migration
{
    protected array $table=[];


    abstract public function up();

    abstract public function alter();

    abstract public function down();



    public function getUp()
    {
        $schema = new Schema();
       return $schema->getQuery(1);
    }

    public function getAlter()
    {
        $schema = new Schema();
        return $schema->getQuery(2);
    }


    public function getDown()
    {
        $schema = new Schema();
        return $schema->getQuery(3);
    }


    public function getColumns()
    {

    }

    public function getTable()
    {

    }

    public function getPrimarkyKey()
    {

    }

    public function getForignKeys()
    {

    }



    public static function get()
    {
        return Column::get();
    }





}