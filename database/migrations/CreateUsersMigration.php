<?php


namespace Database\migrations;

use Tinkle\Database\Migrations\Schema;
use Tinkle\Database\Migrations\Column;
use Tinkle\Database\Migrations\RULE;
use Tinkle\interfaces\MigrationInterface;

class CreateUsersMigration implements MigrationInterface
{


    public function up()
    {

        return Schema::create('users',[
            'id' => Column::bigIncrements('id')->require()->primaryKey()->autoIncrement()->finish(),
            'username'=> Column::string('username',20)->require()->finish(),
            'email'=> Column::string('email',50)->require()->finish(),
            'password'=> Column::string('password',512)->require()->finish(),
            'role'=> Column::string('role')->require()->finish(),
            'created_at' => Column::timestamps('created_at')->nullable()->default()->current()->finish(),
            'updated_at' => Column::timestamps('updated_at')->require()->default()->current()->finish(),
            'status'=> Column::tinyInteger('status')->require()->finish(),
        ])->finish();


    }




     public function alter()
     {
         // TODO: Implement alter() method.
     }




    public function down()
    {
        return Schema::dropIfExist('users')->finish();
    }






    // Class Ends
}