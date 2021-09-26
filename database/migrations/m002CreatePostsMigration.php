<?php

namespace Database\migrations;

use Tinkle\Database\Migration\Column;
use Tinkle\Database\Migration\Migration;
use Tinkle\Database\Migration\Schema;

use Tinkle\interfaces\MigrationInterface;

/**
 * Class CreatePostsMigration
 * @package tinkle\database\migrations
 */
class m002CreatePostsMigration extends Migration
{





    // Class Ends

    public function up()
    {
         Schema::create('posts',function (Column $column) {
            $column->id();
            $column->string('title')->nullable();
            $column->string('description')->required();
            $column->foreign('author_id')->reference('users','id');
             $column->foreign('category_id')->reference('categories','id');
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
//        Schema::alter('posts',function (Column $column) {
//            $column->string('title')->required()->size(55);
//        });
    }

    /**
     * @return string
     */
    public function down(): string
    {
        return Schema::dropIfExist('posts');
    }


    /**
     * @return mixed
     */
    public function generate_code()
    {
        return '0002';
    }
}