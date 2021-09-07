<?php


namespace Tinkle\Library\Installer;


use Tinkle\interfaces\LibraryInterface;
use Tinkle\Request;
use Tinkle\Response;
use Tinkle\Router;
use Tinkle\Tinkle;

class Installer
{


    public static Installer $installer;


    /**
     * THIS CLASS HAVE DUTY FOR INSTALL OUR SYSTEM ON VIA WEB
     * LIKE CLI MIGRATION.. NOW WE HAVE POWER TO INSTALL OUR APPLICATION
     * CHOOSE OUR DB, LOAD OUR TABLE FROM MIGRATION AND SETUP IN MYSQL
     */


    /**
     * Installer constructor.
     * @param Request $request
     * @param Response $response
     */
    public function __construct(Request $request,Response $response)
    {
        self::$installer = $this;

    }




    public function home ()
    {
        echo "Installer Wrong Side Approch";

    }


    public function check()
    {

    }


    public function install()
    {

    }

    public function reset()
    {

    }

    public function delete()
    {

    }





}