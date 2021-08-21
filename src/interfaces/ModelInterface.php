<?php


namespace tinkle\framework\interfaces;


interface ModelInterface
{


    public function tableName():string;

    public function attributes():array;

    public function labels():array;

    public function primaryKey():string;



}