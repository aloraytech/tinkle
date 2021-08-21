<?php


namespace tinkle\framework\interfaces;


interface MigrationInterface
{

    public function up();

    public function alter();

    public function down();
    



}