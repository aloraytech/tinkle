<?php

namespace Database\migrations;

use Tinkle\Databases\Migration\Column;
use Tinkle\Databases\Migration\Migration;
use Tinkle\Databases\Migration\Schema;

use Tinkle\interfaces\MigrationInterface;

/**
 * Class CreatePostsMigration
 * @package tinkle\database\migrations
 */
class m003CreateCategoriesMigration extends Migration
{





    // Class Ends

    public function up()
    {
         Schema::create('categories',function (Column $column) {
            $column->id();
            $column->string('title')->nullable();
            $column->string('description')->required();
            $column->timestamps();
        });





//                return Schema::create('users',[
//            'id' => Column::bigIncrements('id')->require()->primaryKey()->autoIncrement()->finish(),
//            'username'=> Column::string('username',20)->require()->finish(),
//            'email'=> Column::string('email',50)->require()->finish(),
//            'password'=> Column::string('password',512)->require()->finish(),
//            'role'=> Column::string('role')->require()->finish(),
//            'created_at' => Column::timestamps('created_at')->nullable()->default()->current()->finish(),
//            'updated_at' => Column::timestamps('updated_at')->require()->default()->current()->finish(),
//            'status'=> Column::tinyInteger('status')->require()->finish(),
//        ])->finish();













    }

    public function alter()
    {
//        Schema::alter('categories',function (Column $column) {
//            $column->string('title')->required()->size(55);
//        });
    }

    /**
     * @return string
     */
    public function down(): string
    {
        return Schema::dropIfExist('categories');
    }


    /**
     * @return mixed
     */
    public function generate_code()
    {
        return '0002';
    }
}