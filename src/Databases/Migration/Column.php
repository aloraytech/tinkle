<?php
/*
 * Package : Table.php
 * Project : tinkle
 * Created : 26/09/21, 4:40 AM
 * Last Modified : 26/09/21, 4:40 AM
 * Author : Krishanu Bhattacharya
 * Email :krishanu.info@gmail.com
 * Copyright (c) 2021.
 *
 *
 */

namespace Tinkle\Databases\Migration;

class Column
{

    public static string $table='';
    public static array $column=[];

    /**
     * @param string $table
     */
    public function __construct(string $table)
    {
        self::$table = $table;
        self::$column =[];
    }

    public static function get()
    {
        return self::$column;
    }


    public static function update(string $column,array $config)
    {
        if(isset(self::$column[self::$table][$column]))
        {
            self::$column[self::$table][$column] = $config;
        }


    }




    public function id()
    {
        self::$column[self::$table]['id']['type'] = 'BIGINT';
        self::$column[self::$table]['id']['size'] = 21;
        self::$column[self::$table]['id']['rule'] = 'AUTO_INCREMENT PRIMARY KEY';
        return new ColumnOptions('id',self::$column[self::$table]['id']);
    }

    public function foreign(string $column)
    {
//        ALTER TABLE `posts` ADD FOREIGN KEY (`author_id`) REFERENCES `users`(`id`) ON DELETE CASCADE ON UPDATE CASCADE;
        // CASCADE | RESTRICT

        self::$column[self::$table][$column]['type'] = 'BIGINT';
        self::$column[self::$table][$column]['size'] = '21';
        self::$column[self::$table][$column]['rule'] = "NOT NULL";
        self::$column[self::$table][$column]['detail'] = "ALTER TABLE `".self::$table."` ADD FOREIGN KEY (`$column`)";

        return new ColumnOptions($column,self::$column[self::$table][$column]);

    }

    public function timestamps()
    {
        self::$column[self::$table]['created_at']['type'] = 'TIMESTAMP';
        self::$column[self::$table]['created_at']['size'] = '';
        self::$column[self::$table]['created_at']['rule'] = 'NOT NULL';

        self::$column[self::$table]['updated_at']['type'] = 'TIMESTAMP';
        self::$column[self::$table]['updated_at']['size'] = '';
        self::$column[self::$table]['updated_at']['rule'] = 'NOT NULL DEFAULT CURRENT_TIMESTAMP';

    }



    public function int(string $column)
    {
        self::$column[self::$table][$column]['type'] = 'INT';
        self::$column[self::$table][$column]['size'] = '11';
        self::$column[self::$table][$column]['rule'] = '';

        return new ColumnOptions($column,self::$column[self::$table][$column]);
    }

    public function bigint(string $column)
    {
        self::$column[self::$table][$column]['type'] = 'BIGINT';
        self::$column[self::$table][$column]['size'] = '21';
        self::$column[self::$table][$column]['rule'] = '';

        return new ColumnOptions($column,self::$column[self::$table][$column]);
    }

    public function tinyint(string $column)
    {
        self::$column[self::$table][$column]['type'] = 'TINYINT';
        self::$column[self::$table][$column]['size'] = '1';
        self::$column[self::$table][$column]['rule'] = '';

        return new ColumnOptions($column,self::$column[self::$table][$column]);
    }


    public function double(string $column)
    {
        self::$column[self::$table][$column]['type'] = 'DOUBLE';
        self::$column[self::$table][$column]['size'] = '1';
        self::$column[self::$table][$column]['rule'] = '';

        return new ColumnOptions($column,self::$column[self::$table][$column]);
    }


    public function decimal(string $column)
    {
        self::$column[self::$table][$column]['type'] = 'DECIMAL';
        self::$column[self::$table][$column]['size'] = '1';
        self::$column[self::$table][$column]['rule'] = '';

        return new ColumnOptions($column,self::$column[self::$table][$column]);
    }


    public function float(string $column)
    {
        self::$column[self::$table][$column]['type'] = 'FLOAT';
        self::$column[self::$table][$column]['size'] = '1';
        self::$column[self::$table][$column]['rule'] = '';

        return new ColumnOptions($column,self::$column[self::$table][$column]);
    }










    public function string(string $column)
    {
        self::$column[self::$table][$column]['type'] = 'VARCHAR';
        self::$column[self::$table][$column]['size'] = 255;
        self::$column[self::$table][$column]['rule'] = '';

        return new ColumnOptions($column,self::$column[self::$table][$column]);
    }

    public function text(string $column)
    {
        self::$column[self::$table][$column]['type'] = 'TEXT';
        self::$column[self::$table][$column]['size'] = 512;
        self::$column[self::$table][$column]['rule'] = '';

        return new ColumnOptions($column,self::$column[self::$table][$column]);
    }

    public function longtext(string $column)
    {
        self::$column[self::$table][$column]['type'] = 'LONGTEXT';
        self::$column[self::$table][$column]['size'] = 512;
        self::$column[self::$table][$column]['rule'] = '';

        return new ColumnOptions($column,self::$column[self::$table][$column]);
    }

    public function boolean(string $column)
    {
        self::$column[self::$table][$column]['type'] = 'BOOLEAN';
        self::$column[self::$table][$column]['size'] = '';
        self::$column[self::$table][$column]['rule'] = '';

        return new ColumnOptions($column,self::$column[self::$table][$column]);
    }

    public function status(string $column='status')
    {
        return $this->boolean($column);
    }


    public function json(string $column)
    {
        self::$column[self::$table][$column]['type'] = 'JSON';
        self::$column[self::$table][$column]['size'] = '255';
        self::$column[self::$table][$column]['rule'] = '';

        return new ColumnOptions($column,self::$column[self::$table][$column]);
    }


    public function blob(string $column)
    {
        self::$column[self::$table][$column]['type'] = 'BLOB';
        self::$column[self::$table][$column]['size'] = '';
        self::$column[self::$table][$column]['rule'] = '';

        return new ColumnOptions($column,self::$column[self::$table][$column]);
    }




}