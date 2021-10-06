<?php
namespace Database\seeders;

use Tinkle\Databases\Seeder\Seeder;
use Tinkle\Library\Encryption\Hash;
use Tinkle\DB;
use Tinkle\Library\Essential\Essential;
use Tinkle\Library\Essential\Helpers\StringHandler as STR;

/**
 * Class UserTableSeeder
 * @package tinkle\database\seeders
 * @author : krishanu.info@gmail.com
 * @version : 1.0
 */
class PostTableSeeder extends Seeder
{


    public function run()
    {
        DB::table('post')->insert([
            // TODO: Implement Columns Fields.
            // Example
            // 'username' => Essential::STR()->random(10),
            // 'email' => STR::$str->random(10).'@gmail.com',
            // 'password' => Hash::make('password'),
        ]);
    }


}