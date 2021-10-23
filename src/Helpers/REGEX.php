<?php

namespace Tinkle\Helpers;

class REGEX
{


    public const MATCH_NUMBER = '/^(\w+|\d+)$/';
    public const MATCH_WORD = '/^(\w+|\d+)$/';
    public const MATCH_ALPHA_NUMERIC = '/^(\w+|\d+)$/';
    public const MATCH_DATE = '/^[0-9]{1,2}[-/][0-9]{1,2}[-/][0-9]{4}$/';
    public const MATCH_MONEY = '^[0-9.,]*(([.,][-])|([.,][0-9]{2}))?$';
    public const MATCH_EMAIL = '/^(?!(?:(?:\\x22?\\x5C[\\x00-\\x7E]\\x22?)|(?:\\x22?[^\\x5C\\x22]\\x22?)){255,})(?!(?:(?:\\x22?\\x5C[\\x00-\\x7E]\\x22?)|(?:\\x22?[^\\x5C\\x22]\\x22?)){65,}@)(?:(?:[\\x21\\x23-\\x27\\x2A\\x2B\\x2D\\x2F-\\x39\\x3D\\x3F\\x5E-\\x7E]+)|(?:\\x22(?:[\\x01-\\x08\\x0B\\x0C\\x0E-\\x1F\\x21\\x23-\\x5B\\x5D-\\x7F]|(?:\\x5C[\\x00-\\x7F]))*\\x22))(?:\\.(?:(?:[\\x21\\x23-\\x27\\x2A\\x2B\\x2D\\x2F-\\x39\\x3D\\x3F\\x5E-\\x7E]+)|(?:\\x22(?:[\\x01-\\x08\\x0B\\x0C\\x0E-\\x1F\\x21\\x23-\\x5B\\x5D-\\x7F]|(?:\\x5C[\\x00-\\x7F]))*\\x22)))*@(?:(?:(?!.*[^.]{64,})(?:(?:(?:xn--)?[a-z0-9]+(?:-+[a-z0-9]+)*\\.){1,126}){1,}(?:(?:[a-z][a-z0-9]*)|(?:(?:xn--)[a-z0-9]+))(?:-+[a-z0-9]+)*)|(?:\\[(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){7})|(?:(?!(?:.*[a-f0-9][:\\]]){7,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?)))|(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){5}:)|(?:(?!(?:.*[a-f0-9]:){5,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3}:)?)))?(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))(?:\\.(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))){3}))\\]))$/iD';
    public const MATCH_MOBILE = '/^[-]?[0-9]+[.]?[0-9]+$/';
    public const MATCH_NUMERIC = self::MATCH_NUMBER;




    public   function verify(string $subject,$patternType){
        if ((preg_match($patternType, $subject) === 1)) {
            return true;
        } else {
            return false;
        }
    }


    public  function findMatch(string $subject,$type)
    {
        if(preg_match_all($type,$subject,$matches))
        {
            return $matches[0][0];
        }else{
            return [];
        }
    }

    public  function replaceWith(string $subject, string $replace,$type)
    {
        if(preg_replace($type,$replace,$subject))
        {
            return $subject;
        }else{
            return null;
        }
    }













}