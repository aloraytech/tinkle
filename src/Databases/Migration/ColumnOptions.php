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

namespace Tinkle\Databases\Migration;

class ColumnOptions
{

    public static array $column=[];
    public static string $columnName='';
    public static string $table='';

    public function __construct(string $columnName,array $column)
    {
        self::$table = Column::$table;
        self::$column = $column;
        self::$columnName = $columnName;
    }


    public static function getOptions(): array
    {
       // echo self::$columnName;
        return [self::$columnName,self::$column];
    }


    public function nullable()
    {
        self::$column['rule'] = self::$column['rule']. 'NULL';
        Column::update(self::$columnName,self::$column);
        return $this;
    }


    public function required()
    {
        self::$column['rule'] = self::$column['rule']. 'NOT NULL';
        Column::update(self::$columnName,self::$column);
        return $this;
    }

    public function unsigned()
    {
        self::$column['rule'] = 'UNSIGNED '.self::$column['rule'];
        Column::update(self::$columnName,self::$column);
        return $this;
    }


    public function size(int $size)
    {
        self::$column['size'] = $size;
        Column::update(self::$columnName,self::$column);
        return $this;
    }


    public function reference(string $reference_table,string $reference_id)
    {
        $reference_table = strtolower($reference_table);
        $reference_id = strtolower($reference_id);
        self::$column['detail'] = self::$column['detail']. " REFERENCES `$reference_table`(`$reference_id`) ON DELETE CASCADE ON UPDATE CASCADE;";
        self::$column['for'] = $reference_table;
        self::$column['on']= $reference_id;
        Column::update(self::$columnName,self::$column);
        return $this;
    }




}