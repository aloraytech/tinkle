<?php


namespace Database\migrations;

use Tinkle\Database\Migration\Migration;
use Tinkle\Database\Migration\Schema;
use Tinkle\Database\Migration\Column;
use Tinkle\interfaces\MigrationInterface;

class m001CreateUsersMigration extends Migration implements MigrationInterface
{


    public function up()
    {

        Schema::create('users',function (Column $column) {
            $column->id();
            $column->string('username')->nullable();
            $column->string('email')->required()->size(24);

            $column->timestamps();
        });


    }




     public function alter()
     {
         // TODO: Implement alter() method.
     }




    public function down()
    {
        return Schema::dropIfExist('users');
    }






    // Class Ends

    /**
     * @return mixed
     */
    public function generate_code()
    {
        return '0001';
    }
}