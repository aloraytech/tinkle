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

namespace Tinkle\Database\Migration;

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


    private function getMusk(string $columnName)
    {
        return [
          strtolower($columnName),
          ucfirst($columnName),
          strtolower(self::$table.'.'.$columnName),
          ucfirst(self::$table.'.'.strtolower($columnName)),
          ucfirst(self::$table.'.'.ucfirst($columnName)),
          strtoupper(self::$table.'.'.$columnName)
        ];
    }




    public function id()
    {
        self::$column[self::$table]['id'] = [
          'Field'=>'id',
          'Type'=>'BIGINT',
          'MaskField'=> $this->getMusk('id'),
          'FieldType'=>'bigint(21)',
          'Require'=>true,
          'Key'=>'PRI',
          'Default'=> null,
          'Extra'=>'auto_increment',
          'Size'=>21,
          'Ext'=>'int',
          'Pk'=>true,
          'Fk'=>false,
          'Linkable'=>true,
          'LinkTo'=>'',
          'LinkOn'=>'',
          'Link'=>[],
          'Rule'=>'AUTO_INCREMENT PRIMARY KEY',
        ];
        return new ColumnOptions('id',self::$column[self::$table]['id']);
    }

    public function foreign(string $column)
    {
//        ALTER TABLE `posts` ADD FOREIGN KEY (`author_id`) REFERENCES `users`(`id`) ON DELETE CASCADE ON UPDATE CASCADE;
        // CASCADE | RESTRICT

        self::$column[self::$table][$column] = [
            'Field'=>$column,
            'Type'=>'BIGINT',
            'MaskField'=> $this->getMusk($column),
            'FieldType'=>'bigint(21)',
            'Require'=>true,
            'Key'=>'MUL',
            'Default'=> null,
            'Extra'=>'',
            'Size'=>21,
            'Ext'=>'int',
            'Pk'=>false,
            'Fk'=>true,
            'Linkable'=>true,
            'LinkTo'=>'',
            'LinkOn'=>'',
            'Link'=>[],
            'Rule'=>'NOT NULL',
        ];


        self::$column[self::$table][$column]['Detail'] = "ALTER TABLE `".self::$table."` ADD FOREIGN KEY (`$column`)";

        return new ColumnOptions($column,self::$column[self::$table][$column]);

    }

    public function timestamps()
    {
        $column = 'created_at';
        self::$column[self::$table][$column] = [
            'Field'=>$column,
            'Type'=>'TIMESTAMP',
            'MaskField'=> $this->getMusk($column),
            'FieldType'=>'timestamp',
            'Require'=>true,
            'Key'=>'',
            'Default'=> 'current_timestamp()',
            'Extra'=>'on update current_timestamp()',
            'Size'=>'',
            'Ext'=>'string',
            'Pk'=>false,
            'Fk'=>false,
            'Linkable'=>false,
            'LinkTo'=>'',
            'LinkOn'=>'',
            'Link'=>[],
            'Rule'=>'NOT NULL DEFAULT CURRENT_TIMESTAMP',
        ];





        $column2 = 'updated_at';
        self::$column[self::$table][$column2] = [
            'Field'=>$column2,
            'Type'=>'TIMESTAMP',
            'MaskField'=> $this->getMusk($column2),
            'FieldType'=>'timestamp',
            'Require'=>true,
            'Key'=>'',
            'Default'=> 'current_timestamp()',
            'Extra'=>'',
            'Size'=>'',
            'Ext'=>'string',
            'Pk'=>false,
            'Fk'=>false,
            'Linkable'=>false,
            'LinkTo'=>'',
            'LinkOn'=>'',
            'Link'=>[],
            'Rule'=>'NOT NULL ',
        ];

    }



    public function int(string $column)
    {
        self::$column[self::$table][$column] = [
            'Field'=>$column,
            'Type'=>'INT',
            'MaskField'=> $this->getMusk($column),
            'FieldType'=>'int(11)',
            'Require'=>false,
            'Key'=>'',
            'Default'=> null,
            'Extra'=>'',
            'Size'=>11,
            'Ext'=>'int',
            'Pk'=>false,
            'Fk'=>false,
            'Linkable'=>false,
            'LinkTo'=>'',
            'LinkOn'=>'',
            'Link'=>[],
            'Rule'=>'',
        ];
        return new ColumnOptions($column,self::$column[self::$table][$column]);
    }

    public function bigint(string $column)
    {
        self::$column[self::$table][$column] = [
            'Field'=>$column,
            'Type'=>'BIGINT',
            'MaskField'=> $this->getMusk($column),
            'FieldType'=>'bigint(21)',
            'Require'=>false,
            'Key'=>'',
            'Default'=> null,
            'Extra'=>'',
            'Size'=>21,
            'Ext'=>'int',
            'Pk'=>false,
            'Fk'=>false,
            'Linkable'=>false,
            'LinkTo'=>'',
            'LinkOn'=>'',
            'Link'=>[],
            'Rule'=>'',
        ];



        return new ColumnOptions($column,self::$column[self::$table][$column]);
    }

    public function tinyint(string $column)
    {
        self::$column[self::$table][$column] = [
            'Field'=>$column,
            'Type'=>'TINYINT',
            'MaskField'=> $this->getMusk($column),
            'FieldType'=>'tinyint(1)',
            'Require'=>false,
            'Key'=>'',
            'Default'=> null,
            'Extra'=>'',
            'Size'=>1,
            'Ext'=>'int',
            'Pk'=>false,
            'Fk'=>false,
            'Linkable'=>false,
            'LinkTo'=>'',
            'LinkOn'=>'',
            'Link'=>[],
            'Rule'=>'',
        ];


        return new ColumnOptions($column,self::$column[self::$table][$column]);
    }


    public function double(string $column)
    {

        self::$column[self::$table][$column] = [
            'Field'=>$column,
            'Type'=>'DOUBLE',
            'MaskField'=> $this->getMusk($column),
            'FieldType'=>'double(1)',
            'Require'=>false,
            'Key'=>'',
            'Default'=> null,
            'Extra'=>'',
            'Size'=>1,
            'Ext'=>'int',
            'Pk'=>false,
            'Fk'=>false,
            'Linkable'=>false,
            'LinkTo'=>'',
            'LinkOn'=>'',
            'Link'=>[],
            'Rule'=>'',
        ];

        return new ColumnOptions($column,self::$column[self::$table][$column]);
    }


    public function decimal(string $column)
    {

        self::$column[self::$table][$column] = [
            'Field'=>$column,
            'Type'=>'DECIMAL',
            'MaskField'=> $this->getMusk($column),
            'FieldType'=>'decimal(1)',
            'Require'=>false,
            'Key'=>'',
            'Default'=> null,
            'Extra'=>'',
            'Size'=>1,
            'Ext'=>'int',
            'Pk'=>false,
            'Fk'=>false,
            'Linkable'=>false,
            'LinkTo'=>'',
            'LinkOn'=>'',
            'Link'=>[],
            'Rule'=>'',
        ];


        return new ColumnOptions($column,self::$column[self::$table][$column]);
    }


    public function float(string $column)
    {


        self::$column[self::$table][$column] = [
            'Field'=>$column,
            'Type'=>'FLOAT',
            'MaskField'=> $this->getMusk($column),
            'FieldType'=>'float(1)',
            'Require'=>false,
            'Key'=>'',
            'Default'=> null,
            'Extra'=>'',
            'Size'=>1,
            'Ext'=>'float',
            'Pk'=>false,
            'Fk'=>false,
            'Linkable'=>false,
            'LinkTo'=>'',
            'LinkOn'=>'',
            'Link'=>[],
            'Rule'=>'',
        ];


        return new ColumnOptions($column,self::$column[self::$table][$column]);
    }










    public function string(string $column,int $size=255)
    {

        self::$column[self::$table][$column] = [
            'Field'=>$column,
            'Type'=>'VARCHAR',
            'MaskField'=> $this->getMusk($column),
            'FieldType'=>"varchar($size)",
            'Require'=>false,
            'Key'=>'',
            'Default'=> null,
            'Extra'=>'',
            'Size'=>$size,
            'Ext'=>'string',
            'Pk'=>false,
            'Fk'=>false,
            'Linkable'=>false,
            'LinkTo'=>'',
            'LinkOn'=>'',
            'Link'=>[],
            'Rule'=>'',
        ];

        return new ColumnOptions($column,self::$column[self::$table][$column]);
    }

    public function text(string $column)
    {

        $size=1024;
        self::$column[self::$table][$column] = [
            'Field'=>$column,
            'Type'=>'TEXT',
            'MaskField'=> $this->getMusk($column),
            'FieldType'=>"text($size)",
            'Require'=>false,
            'Key'=>'',
            'Default'=> null,
            'Extra'=>'',
            'Size'=>$size,
            'Ext'=>'string',
            'Pk'=>false,
            'Fk'=>false,
            'Linkable'=>false,
            'LinkTo'=>'',
            'LinkOn'=>'',
            'Link'=>[],
            'Rule'=>'',
        ];



        return new ColumnOptions($column,self::$column[self::$table][$column]);
    }

    public function longtext(string $column)
    {

        $size=3096;
        self::$column[self::$table][$column] = [
            'Field'=>$column,
            'Type'=>'LONGTEXT',
            'MaskField'=> $this->getMusk($column),
            'FieldType'=>"longtext($size)",
            'Require'=>false,
            'Key'=>'',
            'Default'=> null,
            'Extra'=>'',
            'Size'=>$size,
            'Ext'=>'string',
            'Pk'=>false,
            'Fk'=>false,
            'Linkable'=>false,
            'LinkTo'=>'',
            'LinkOn'=>'',
            'Link'=>[],
            'Rule'=>'',
        ];


        return new ColumnOptions($column,self::$column[self::$table][$column]);
    }

    public function boolean(string $column)
    {


        $size=1;
        self::$column[self::$table][$column] = [
            'Field'=>$column,
            'Type'=>'BOOLEAN',
            'MaskField'=> $this->getMusk($column),
            'FieldType'=>"boolean($size)",
            'Require'=>false,
            'Key'=>'',
            'Default'=> null,
            'Extra'=>'',
            'Size'=>$size,
            'Ext'=>'bool',
            'Pk'=>false,
            'Fk'=>false,
            'Linkable'=>false,
            'LinkTo'=>'',
            'LinkOn'=>'',
            'Link'=>[],
            'Rule'=>'',
        ];



        return new ColumnOptions($column,self::$column[self::$table][$column]);
    }

    public function status(string $column='status')
    {
        return $this->boolean($column);
    }


    public function json(string $column)
    {

        $size=255;
        self::$column[self::$table][$column] = [
            'Field'=>$column,
            'Type'=>'JSON',
            'MaskField'=> $this->getMusk($column),
            'FieldType'=>"json($size)",
            'Require'=>false,
            'Key'=>'',
            'Default'=> null,
            'Extra'=>'',
            'Size'=>$size,
            'Ext'=>'bool',
            'Pk'=>false,
            'Fk'=>false,
            'Linkable'=>false,
            'LinkTo'=>'',
            'LinkOn'=>'',
            'Link'=>[],
            'Rule'=>'',
        ];



        return new ColumnOptions($column,self::$column[self::$table][$column]);
    }


    public function blob(string $column)
    {
        self::$column[self::$table][$column] = [
            'Field'=>$column,
            'Type'=>'BLOB',
            'MaskField'=> $this->getMusk($column),
            'FieldType'=>'blob',
            'Require'=>false,
            'Key'=>'',
            'Default'=> null,
            'Extra'=>'',
            'Size'=>'',
            'Ext'=>'binary',
            'Pk'=>false,
            'Fk'=>false,
            'Linkable'=>false,
            'LinkTo'=>'',
            'LinkOn'=>'',
            'Link'=>[],
            'Rule'=>'',
        ];


        return new ColumnOptions($column,self::$column[self::$table][$column]);
    }




}