<?php


namespace Tinkle\Database\Tinker;




use Tinkle\Database\Database;
use Tinkle\Tinkle;

class Tinker
{

    protected Database $db;

    /**
     * Tinkler constructor.
     */
    public function __construct()
    {
        $this->db = Tinkle::$app->db->getConnect();
    }


}