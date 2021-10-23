<?php

namespace Tinkle\Helpers;

class STR
{


    private const ADD_UPPER_SLASH = 'A..Z';
    private const ADD_LOWER_SLASH = 'a..z';



    public static function random(int $length,bool $strOnly=true)
    {
        if($strOnly)
        {
            $allowedChars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        }else{
            $allowedChars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        }

        $allowedCharsLength = strlen($allowedChars);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $allowedChars[rand(0, $allowedCharsLength - 1)];
        }
        if(is_string($randomString))
        {
            return $randomString;
        }

    }


    public static function replace(string $subject,string $search,string $replace)
    {
        return str_replace($search,$replace,$subject);
    }

    public static function upper(string $var)
    {
        return strtoupper($var);
    }

    public static function lower(string $var)
    {
        return strtolower($var);
    }

    public static function count(string $var)
    {
        return str_word_count($var);
    }


    public static function reverse(string $var)
    {
        return strrev($var);
    }

    public static function getPosition(string $subject,string $find)
    {
        return strpos($subject,$find);
    }

    public static function addSlash(string $var)
    {
        return addslashes($var);
    }

    public static function addSlashOn(string $subject, $type)
    {
        return addcslashes($subject,$type);
    }

    public static function addSlashOnRange(string $subject,string $start_range,string $end_range)
    {
        return addcslashes($subject,"$start_range..$end_range");
    }

    public static function splitString(string $subject,int $startChar_position,string $with)
    {
        return chunk_split($subject,$startChar_position,$with);
    }

    public static function crypt(string $var)
    {
        return password_hash($var,PASSWORD_DEFAULT);
    }

    public static function trim(string $var)
    {
        return trim($var);
    }

    /**
     * @param string $subject
     * @return mixed
     */
    public static function parse(string $subject)
    {
        if(parse_str($subject,$result))
        {
            return $result;
        }
    }


    public static function splitStrIntoArray(string $subject,int $length=1)
    {
        return str_split($subject,$length);
    }

    public static function strToArray(string $subject,string $separator)
    {
        return explode($separator,$subject);
    }




}