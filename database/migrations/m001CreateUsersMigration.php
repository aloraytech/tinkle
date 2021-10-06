<?php
namespace Database\migrations;
use Tinkle\Databases\Migration\Column;
use Tinkle\Databases\Migration\Migration;
use Tinkle\Databases\Migration\Schema;

/**
 * Class m001CreateUsersMigration
 * @author :
 * @version :
 */
class m001CreateUsersMigration extends Migration
{

    /**
     * Create Database Table With Columns
     */
    public function up()
    {
        Schema::create('users',function (Column $column) {
            $column->id();
            $column->string('username')->nullable();
            $column->string('email')->required()->size(55);
            $column->string('password')->required();
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
       Schema::dropIfExist('users');
    }

}