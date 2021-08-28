<?php


namespace App\Controllers;


use Tinkle\Controller;
use Tinkle\interfaces\ControllerInterface;

class TestController extends Controller implements ControllerInterface
{
    private $id;


    /**
     * TestController constructor.
     * @param $id
     */
    public function __construct($id)
    {
        $this->id = $id;
        echo "Test Controller Constructed <br>";
    }

    public function load()
    {
        echo "load Loaded";
    }

    public function loadit($id)
    {
        echo "Load it : ".$id;
    }

    public function getId()
    {
        return $this->id;
    }

}