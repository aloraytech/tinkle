<?php


namespace tinkle\framework\Library\Essential\Helpers;


class Faker
{

    protected static int $length;



    public static function create(int $length =0)
    {
            self::$length = $length;
            return self::generate();
    }


    private static function generate()
    {

        $sentence = '';
        for ($x = 0; $x <= self::$length; $x++) {
            $sentence .= self::buildEmail() . '   ';
        }

        return $sentence;


    }


    private static function buildWord()
    {
        $word = array_merge(range('a','z'),range('A','Z'));
        shuffle($word);
        $word = substr(implode($word),0,5);
        return $word.'';
    }


    private static function buildEmail()
    {
        $word = self::buildWord();

        $providers = array("gmail.com  ","yahoo.com   ","in.com       ","hotmail.com ");

        shuffle($providers);
        $emailProvider = substr(implode($providers),0,11);

        return trim($word.'@'.$emailProvider);
    }




}