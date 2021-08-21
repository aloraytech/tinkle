<?php


namespace tinkle\database\migrations;

use tinkle\framework\Database\Migrations\Column;
use tinkle\framework\Database\Migrations\ColumnAlter;
use tinkle\framework\interfaces\MigrationInterface;
use tinkle\framework\Database\Migrations\Schema;

class CreatePagesMigration implements MigrationInterface
{


    public function up()
    {
        return Schema::create('pages',[
            'id' => Column::bigIncrements('id')->require()->primaryKey()->autoIncrement()->finish(),
            'title'=> Column::string('title')->require()->finish(),
            'description'=> Column::text('description')->require()->finish(),
            'created_at' => Column::timestamps('created_at')->require()->default()->current()->finish(),
            'status'=> Column::tinyInteger('status')->require()->finish(),
        ])->finish();
    }




     public function alter()
     {
         // TODO: Implement alter() method.
           // ToDO: Example
         //return Schema::alter('pages',[
         //  'existColumnName' => ColumnAlter::fromColumnTo('existColumnName','newColumnName',
                            //['newColumnName'=> Column::string('newColumnName')->require()->finish(),]
                            //)->finish(),
         //  'existColumnName2' => ColumnAlter::fromColumnTo('existColumnName2','newColumnName2',
                            //['newColumnName2'=> Column::string('newColumnName2')->require()->finish(),]
                            //)->finish(),
         //])->finish();
     }



    /**
     * @return string
    */
    public function down()
    {
        return Schema::dropIfExist('pages')->finish();
    }




}