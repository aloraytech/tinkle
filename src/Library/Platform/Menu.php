<?php


namespace Tinkle\Library\Platform;


class Menu
{


    public const FOR_FRONT='frontend';
    public const FOR_BACK='backend';
    public const TYPE_BUTTON='btn';
    public const TYPE_LIST='li';
    public const TYPE_UL='ul';

    public static Menu $menu;
    protected static string $type='';
    private static string $icon;


    /**
     * Menu constructor.
     */
    public function __construct()
    {
        self::$menu=$this;
    }


    public static function make(string $name,string $for='backend')
    {
        return self::$menu;
    }

    public function button(string $type)
    {
        self::$type = $type;
        return self::$menu;
    }

    public function icon(string $icon)
    {
        self::$icon = $icon;
        return self::$menu;
    }

    public function list(array $menu)
    {

    }





}