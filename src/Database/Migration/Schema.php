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
                    if($value['type']!='TIMESTAMP')
                    {
                        if(!empty($value['rule']))
                        {
                            $buildArray[$table][$key]['query']
                                = ' `'.$key.'` '. $value['type'] .'('.$value['size'].') '.$value['rule'].'' ;

                                $QUERY []=' `'.$key.'` '. $value['type'] .'('.$value['size'].') '.$value['rule'].'' ;

                        }


                    }else{
                        if($value['type']==='TIMESTAMP')
                        {

                            $buildArray[$table][$key]['query']
                                = ' `'.$key.'` '. $value['type'] .' '.$value['rule'].',' ;
                            $QUERY2 .=' ,`'.$key.'` '. $value['type'] .' '.$value['rule'].'' ;
                        }

                    }

                    if(!empty($value['detail']))
                    {
                        $buildArray[$table][$key]['query2']
                            =$value['detail'].',' ;
                        $QUERY3 .=$value['detail'] ;
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