<?php
/*
 * Package : Schema.php
 * Project : tinkle
 * Created : 26/09/21, 4:39 AM
 * Last Modified : 26/09/21, 4:39 AM
 * Author : Krishanu Bhattacharya
 * Email :krishanu.info@gmail.com
 * Copyright (c) 2021.
 *
 *
 */

namespace Tinkle\Database\Migration;


use Tinkle\Tinkle;

class Schema
{
    public static string $tableName='';
    public static array|string $tableDetails=[];

    public function __construct()
    {
        self::$tableDetails = [];
    }


    public static function create(string $tableName,\Closure $callback)
    {
        self::$tableName = $tableName;
        return $callback(new Column($tableName));


    }


    public static function alter(string $tableName,\Closure $callback)
    {
        self::$tableName = $tableName;
        return $callback(new Column($tableName));
    }


    public static function dropIfExist(string $tableName)
    {
        return "DROP IF EXIST $tableName";
    }



    public static function hasTable(string $table)
    {

    }

    public static function hasColumn(string $table,string $column){}


    public function getColumnDetail()
    {
        return Column::get();
    }


    public function getQuery(int $type=1)
    {
        self::$tableDetails = Column::get();
       // dd(self::$tableDetails,'yellow','red');
        if($type ===1)
        {
            $query = $this->getUPQuery(self::$tableDetails);
           return $query;
        }elseif ($type ===2)
        {
           return '';
        }elseif ($type ===3)
        {
            return '';
        }else{
            return '';
        }




    }


    private function getUPQuery(array $tableArray)
    {
        $buildArray=[];
        $QUERY =[];
        $QUERY2 ='';
        $QUERY3 ='';
        $tableName = '';
        foreach ($tableArray as $table => $columnDetail)
        {
            $tableName = $table;
            if(is_array($columnDetail))
            {
                foreach ($columnDetail as $key => $value)
                {
                    if($value['Type']!='TIMESTAMP')
                    {
                        if(!empty($value['Rule']))
                        {
                            $buildArray[$table][$key]['query']
                                = ' `'.$key.'` '. $value['Type'] .'('.$value['Size'].') '.$value['Rule'].'' ;

                                $QUERY []=' `'.$key.'` '. $value['Type'] .'('.$value['Size'].') '.$value['Rule'].'' ;

                        }


                    }else{
                        if($value['Type']==='TIMESTAMP')
                        {

                            $buildArray[$table][$key]['query']
                                = ' `'.$key.'` '. $value['Type'] .' '.$value['Rule'].',' ;
                            $QUERY2 .=' ,`'.$key.'` '. $value['Type'] .' '.$value['Rule'].'' ;
                        }

                    }

                    if(!empty($value['Detail']))
                    {
                        $buildArray[$table][$key]['query2']
                            =$value['Detail'].',' ;
                        $QUERY3 .=$value['Detail'] ;
                    }

                }
            }
        }



        if(!empty($QUERY3))
        {
            $buildArray['query']= "CREATE TABLE IF NOT EXISTS `$tableName`(" . implode(',',$QUERY) .$QUERY2. ") ENGINE = InnoDB;".$QUERY3;
        }else{
            $buildArray['query']= "CREATE TABLE IF NOT EXISTS `$tableName`(" . implode(',',$QUERY) .$QUERY2. ") ENGINE = InnoDB;";
        }



        return $buildArray['query'];

    }



    public function getAlterQuery()
    {

    }




























}