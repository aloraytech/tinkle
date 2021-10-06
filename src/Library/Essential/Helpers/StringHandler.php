<?php


namespace Tinkle\Library\Essential\Helpers;


class StringHandler
{

    const ADD_UPPER_SLASH = 'A..Z';
    const ADD_LOWER_SLASH = 'a..z';
    public static StringHandler $str;

    public function __construct()
    {
        self::$str=$this;
    }


    public function random(int $length,bool $strOnly=true)
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


    public function replace(string $subject,string $search,string $replace)
    {
        return str_replace($search,$replace,$subject);
    }

    public function upper(string $var)
    {
        return strtoupper($var);
    }

    public function lower(string $var)
    {
        return strtolower($var);
    }

    public function count(string $var)
    {
        return str_word_count($var);
    }


    public function reverse(string $var)
    {
        return strrev($var);
    }

    public function getPosition(string $subject,string $find)
    {
        return strpos($subject,$find);
    }

    public function addSlash(string $var)
    {
        return addslashes($var);
    }

    public function addSlashOn(string $subject, $type)
    {
        return addcslashes($subject,$type);
    }

    public function addSlashOnRange(string $subject,string $start_range,string $end_range)
    {
        return addcslashes($subject,"$start_range..$end_range");
    }

    public function splitString(string $subject,int $startChar_position,string $with)
    {
        return chunk_split($subject,$startChar_position,$with);
    }

    public function crypt(string $var)
    {
        return password_hash($var,PASSWORD_DEFAULT);
    }

    public function trim(string $var)
    {
        return trim($var);
    }

    /**
     * @param string $subject
     * @return mixed
     */
    public function parse(string $subject)
    {
        if(parse_str($subject,$result))
        {
            return $result;
        }
    }


    public function splitStrIntoArray(string $subject,int $length=1)
    {
        return str_split($subject,$length);
    }

    public function strToArray(string $subject,string $separator)
    {
        return explode($separator,$subject);
    }





}