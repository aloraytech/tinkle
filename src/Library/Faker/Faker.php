<?php
/*
 * Package : Faker.php
 * Project : tinkle
 * Created : 22/09/21, 3:49 PM
 * Last Modified : 22/09/21, 3:49 PM
 * Author : Krishanu Bhattacharya
 * Email :krishanu.info@gmail.com
 * Copyright (c) 2021.
 *
 *
 */

namespace Tinkle\Library\Faker;

class Faker
{


    public static function name(int $count=1)
    {
        $nameDB = FakerData::$firstName;
        foreach ($nameDB as $key => $name)
        {
            for ($key = 0; $key <= $count-1; $key++) {
                echo "The number is: $name <br>";
            }
        }
    }

    public static function email(int $count=1)
    {

    }

    public static function country(int $count=1)
    {

    }

    public static function mobile(int $count=1)
    {

    }







}