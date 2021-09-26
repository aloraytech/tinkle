<?php


namespace Database\seeders;


use Tinkle\Database\Migration\Seeder;
use Tinkle\Library\Encryption\Hash;
use Tinkle\Token;

/**
 * Class UserTableSeeder
 * @package tinkle\database\seeders
 */
class UserTableSeeder extends Seeder
{


    /**
     * @return array
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