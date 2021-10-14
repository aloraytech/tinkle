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

namespace Tinkle\Database\Migration;

abstract class Migration
{
    protected array $table=[];

    protected Schema $schema;

    public function __construct()
    {
        $this->schema = new Schema();
    }


    abstract public function up();

    abstract public function alter();

    abstract public function down();



    public function getUp()
    {

       return $this->schema->getQuery(1);
    }

    public function getAlter()
    {
        return $this->schema->getQuery(2);
    }


    public function getDown()
    {
        return $this->schema->getQuery(3);
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

    public function getSchema()
    {
        return $this->schema;
    }

    public function get()
    {
        return $this->schema->getColumnDetail();
    }





}