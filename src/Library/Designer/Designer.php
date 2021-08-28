<?php


namespace Tinkle\Library\Designer;




use Tinkle\Database\Manager\DBManager;
use Tinkle\Library\Designer\Div\Div;
use Tinkle\Library\Designer\Form\Form;
use Tinkle\Library\Designer\Nav\Nav;

class Designer
{

    private static object $model;
    private static array $designData;
    public static Designer $design;

    //Definations For Bootstrap Only
    const COLOR_PRIMARY = 'primary';
    const COLOR_SECONDARY = 'secondary';
    const COLOR_SUCCESS = 'success';
    const COLOR_DANGER = 'danger';
    const COLOR_WARNING = 'warning';
    const COLOR_INFO = 'info';
    const COLOR_LIGHT = 'light';
    const COLOR_DARK = 'dark';
    const TEXT_DISPLAY = 'display-';
    const BTN_OUTLINE = 'btn-outline-';
    const BTN = 'btn-';
    const BADGE = 'badge-';
    const TEXT = 'text-';
    const BACKGROUND = 'bg-';
    const TEXT_CENTER = '';
    const TEXT_RIGHT = '';
    const TEXT_LEFT = '';



    /**
     * Designer constructor.
     */
    public function __construct()
    {
        self::$design = $this;

    }





    public function div()
    {
        return new Div();
    }

    public function form()
    {
        return new Form();
    }

    public function heading(string $text)
    {
        echo "<h1>$text</h1>";
    }

    public function navbar()
    {
        return new Nav();
    }



}