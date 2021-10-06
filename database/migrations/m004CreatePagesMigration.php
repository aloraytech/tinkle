<?php
namespace Database\migrations;
use Tinkle\Databases\Migration\Column;
use Tinkle\Databases\Migration\Migration;
use Tinkle\Databases\Migration\Schema;

/**
 * Class m004CreatePagesMigration
 * @package tinkle\database
 * @author : krishanu.info@gmail.com
 * @version : 1.0
 */
class m004CreatePagesMigration extends Migration
{

    /**
     * Create Database Table With Columns
     */
    public function up()
    {
        Schema::create('pages',function (Column $column) {
            $column->id();
            // TODO: Implement columns.
            $column->timestamps();
        });
    }






    /**
     * Alter or Modify Database Tables
     */
     public function alter()
     {
         // TODO: Implement alter() method.
     }






    /**
     * Remove Or Delete Or Drop Database Tables
     */
    public function down()
    {
       Schema::dropIfExist('pages');
    }

}