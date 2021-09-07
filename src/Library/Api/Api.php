<?php


namespace Tinkle\Library\Api;


class Api
{


    public static function google(){ return new GoogleApi();}

    public static function youtube() { return new YoutubeApi();}

    public static function facebook() {return new FacebookApi();}

    public static function twitter() {return new TwitterApi();}




}