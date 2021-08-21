<?php

namespace tinkle\database\migrations;

use tinkle\framework\Database\Migrations\Column;
use tinkle\framework\Database\Migrations\ColumnAlter;
use tinkle\framework\interfaces\MigrationInterface;
use tinkle\framework\Database\Migrations\Schema;

/**
 * Class CreatePostsMigration
 * @package tinkle\database\migrations
 */
class CreatePostsMigration  implements MigrationInterface
{


    /**
     * @return string
     */
    public function up()
    {
        return Schema::create('posts',[
            'id' => Column::bigIncrements('id')->require()->primaryKey()->autoIncrement()->finish(),
            'title'=> Column::string('title')->require()->finish(),
            'description'=> Column::text('description')->require()->finish(),
            'created_at' => Column::timestamps('created_at')->require()->default()->current()->finish(),
            'status'=> Column::tinyInteger('status')->require()->finish(),
        ])->finish();
    }


    /**
     * @return string
     */
     public function alter()
     {
//         return Schema::alter('posts',[
//
//           'username' => ColumnAlter::fromColumnTo('username','myname',[
//               'myname'=> Column::string('myname')->require()->finish(),
//           ])->finish(),
//
//           'email' => ColumnAlter::fromColumnTo('email','useremail',[
//               'useremail'=> Column::string('useremail')->require()->finish(),
//           ])->finish(),
//
//         ])->finish();
     }


    /**
     * @return string
     */
    public function down()
    {
        return Schema::dropIfExist('posts')->finish();
    }



    // Class Ends
}