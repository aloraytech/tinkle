<?php

namespace Tinkle\Library\Console;

use Tinkle\Library\Console\Application\Controllers\DB;

class ConsoleHandler
{


    public static function dbMigrate()
    {
        $db = new DB();
        return $db->migrate();
    }

    public static function dbDropMigration()
    {
        $db = new DB();
        return $db->dropMigration();
    }

    public static function dbReset(string $table_name='')
    {
        $db = new DB();
        return $db->reset($table_name);
    }

    public static function dbRefresh(string $table_name='')
    {
        $db = new DB();
        return $db->refresh($table_name);
    }

    public static function dbSeed()
    {
        $db = new DB();
        return $db->seed();
    }

    public static function dbRefreshSeed()
    {
        $db = new DB();
        return $db->refreshSeed();
    }












}