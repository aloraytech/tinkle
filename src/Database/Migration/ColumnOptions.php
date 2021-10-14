<?php
/*
 * Package : ColumnOptions.php
 * Project : tinkle
 * Created : 26/09/21, 5:07 AM
 * Last Modified : 26/09/21, 5:07 AM
 * Author : Krishanu Bhattacharya
 * Email :krishanu.info@gmail.com
 * Copyright (c) 2021.
 *
 *
 */

namespace Tinkle\Database\Migration;

class ColumnOptions
{

    public static array $column=[];
    public static string $columnName='';
    public static string $table='';

    public function __construct(string $columnName,array $columnSetting)
    {
        self::$table = Column::$table;
        self::$column = $columnSetting;
        self::$columnName = $columnName;
    }


    public static function getOptions(): array
    {
       // echo self::$columnName;
        return [self::$columnName,self::$column];
    }


    public function nullable()
    {
        self::$column['Require'] = false;
        self::$column['Rule'] = self::$column['Rule']. 'NULL';
        Column::update(self::$columnName,self::$column);
        return $this;
    }


    public function required()
    {
        self::$column['Require'] = true;
        self::$column['Rule'] = self::$column['Rule']. 'NOT NULL';
        Column::update(self::$columnName,self::$column);
        return $this;
    }

    public function unsigned()
    {
        self::$column['Rule'] = 'UNSIGNED '.self::$column['Rule'];
        Column::update(self::$columnName,self::$column);
        return $this;
    }


    public function size(int $size)
    {
        self::$column['Size'] = $size;
        Column::update(self::$columnName,self::$column);
        return $this;
    }


    public function reference(string $reference_table,string $reference_id)
    {
        $reference_table = strtolower($reference_table);
        $reference_id = strtolower($reference_id);
        self::$column['Detail'] = self::$column['Detail']. " REFERENCES `$reference_table`(`$reference_id`) ON DELETE CASCADE ON UPDATE CASCADE;";
        self::$column['LinkTo'] = $reference_table;
        self::$column['LinkOn']= $reference_id;
        Column::update(self::$columnName,self::$column);
        return $this;
    }




}