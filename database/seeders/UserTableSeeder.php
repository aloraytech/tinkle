<?php


namespace tinkle\database\seeders;


use tinkle\framework\Database\Migrations\Seeder;
use tinkle\framework\Library\Encryption\Hash;
use tinkle\framework\Token;

/**
 * Class UserTableSeeder
 * @package tinkle\database\seeders
 */
class UserTableSeeder extends Seeder
{


    /**
     * @return string
     */
    public function run()
    {
        return Seeder::table('users')->insert([
            // First Record
            [

                'username'=>'Admin Name',
                'email'=>'admin@gmail.com',
                'password'=>Hash::make('1124z1'),
                'role'=>'admin',
                'status'=>1,
            ],
            // First Record
            [
                'username'=>'Second Name',
                'email'=>'second@gmail.com',
                'password'=>Hash::make('1124z1'),
                'role'=>'user',
                'status'=>1,
            ],
        ])->finish();
    }








}