<?php


namespace Tinkle\Database\Migrations;

/**
 * Class Rule
 * @package Tinkle\Database\Migrations
 */
class Rule
{
    /**
     * @var string
     */
    public string $rule;

    /**
     * Rule constructor.
     * @param string $rule
     */
    public function __construct(string $rule)
    {
        $this->rule = $rule;
    }

    public function primaryKey()
    {
        $this->rule = $this->rule." PRIMARY KEY";
        return $this;
    }





    /**
     * @return $this
     */
    public function autoIncrement()
    {
        $this->rule = $this->rule." AUTO_INCREMENT";
        return $this;
    }

    /**
     * @return $this
     */
    public function nullable()
    {
         $this->rule =  $this->rule." NULL";
         return $this;
    }


    /**
     * @return $this
     */
    public function require()
    {
        $this->rule =  $this->rule." NOT NULL";
        return $this;
    }


    /**
     * @param string $value
     * @return $this
     */
    public function default(string $value='')
    {
        if(!empty($value))
        {
            $this->rule =  $this->rule." DEFAULT $value";
        }else{
            $this->rule =  $this->rule." DEFAULT";
        }
        return $this;
    }


    /**
     * @return $this
     */
    public function current()
    {
        $this->rule =  $this->rule." CURRENT_TIMESTAMP";
        return $this;
    }


    /**
     * @return string
     */
    public function finish()
    {
        return $this->__toString();
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->rule;
    }


}