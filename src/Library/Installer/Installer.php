<?php


namespace tinkle\framework\Library\Installer;


use tinkle\framework\interfaces\LibraryInterface;
use tinkle\framework\Request;
use tinkle\framework\Response;
use tinkle\framework\Router;
use tinkle\framework\Tinkle;

class Installer implements LibraryInterface
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