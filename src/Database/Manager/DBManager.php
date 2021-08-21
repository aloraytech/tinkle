<?php


namespace tinkle\framework\Database\Manager;




use tinkle\framework\Database\Database;
use tinkle\framework\Tinkle;

/**
 * Class DBManager
 * @package tinkle\framework\Database\Manager
 */
abstract class DBManager
{

    public string $table;
    public array $label;
    public const RULE_REQUIRED = 'required';
    public const RULE_EMAIL = 'email';
    public const RULE_MIN = 'min';
    public const RULE_MAX = 'max';
    public const RULE_MATCH = 'match';
    public const RULE_UNIQUE = 'unique';
    public array $errors = [];



    abstract public function tableName():string;
    abstract public function attributes():array;
    abstract public function labels():array;
    abstract public function primaryKey():string;


    /**
     * @param array $data
     */
    public function loadData(array $data)
    {
        foreach ($data as $key => $value){
            if(property_exists($this, $key)){
                $this->{$key} = $value;
            }
        }
    }


    /**
     * @param $attribute
     * @return mixed
     */
    public function getLabel($attribute)
    {
        return $this->labels()[$attribute] ?? $attribute;
    }









    public function validate()
    {
        foreach ($this->rules() as $attribute => $rules) {
            $value = $this->{$attribute};

            foreach ($rules as $rule){
                $ruleName = $rule;

                if(!is_string($ruleName)) {
                    $ruleName = $rule[0];
                }
                /**
                 * Assign Rules For Check And Sanetize Form Fields Or Attribute Params
                 * /////////////////////////////////////////////////////////////////
                 * */

                // Required Fields
                if($ruleName === self::RULE_REQUIRED && !$value){
                    $this->addErrorForRule($attribute, self::RULE_REQUIRED);
                }
                // Email Validation
                if($ruleName === self::RULE_EMAIL && !filter_var($value,FILTER_VALIDATE_EMAIL)){
                    $this->addErrorForRule($attribute, self::RULE_EMAIL);
                }

                // Minimum Character Rule Set
                if($ruleName === self::RULE_MIN && strlen($value) < $rule['min']){
                    $this->addErrorForRule($attribute, self::RULE_MIN,$rule);
                }

                // Maximum Character Rule Set
                if($ruleName === self::RULE_MAX && strlen($value) > $rule['max']){
                    $this->addErrorForRule($attribute, self::RULE_MAX,$rule);
                }


                // Match Character Rule Set
                if($ruleName === self::RULE_MATCH && $value !== $this->{$rule['match']}){
                    //Display Label Name In Error
                    $rule['match'] = $this->getLabel($rule['match']);
                    $this->addErrorForRule($attribute, self::RULE_MATCH,$rule);
                }

                // Unique Identifier For Specific Table Rule Set (eg: User Email Exist)
                if($ruleName === self::RULE_UNIQUE){

                    $className = $rule['class'];
                    $uniqueAttr = $rule['attribute'] ?? $attribute;
                    $tableName = $className::tableName();
                    $statement = Tinkle::$app->db->prepare("SELECT * FROM $tableName WHERE $uniqueAttr = :attr ");
                    $statement->bindValue(":attr",$value);

                    $statement->execute();
                    $record = $statement->fetchObject();
                    if($record){
                        $this->addErrorForRule($attribute, self::RULE_UNIQUE,['field'=>$this->getlabel($attribute)]);
                    }


                }


            }
        }
        return empty($this->errors);
    }



    public function addError(string $attribute, string $message)
    {
        $this->errors[$attribute][] = $message;
    }



    private function addErrorForRule(string $attribute, string $rule,$params=[])
    {
        $message = $this->errorMessages()[$rule] ?? '';
        foreach($params as $key => $value){
            $message = str_replace("{{$key}}",$value,$message);
        }
        $this->errors[$attribute][] = $message;
    }


    public function errorMessages()
    {
        return [
            self::RULE_REQUIRED =>'This field is required',
            self::RULE_EMAIL => 'This field must be valid email address',
            self::RULE_MIN => 'Min length of this field must be {min}',
            self::RULE_MAX => 'Min length of this field must be {max}',
            self::RULE_MATCH => 'This field must be the same as {match}',
            self::RULE_UNIQUE => 'Record with this {field} already exists',
        ];
    }



    public function hasError($attribute)
    {
        return $this->errors[$attribute] ?? false;
    }

    public function getFirstError($attribute)
    {
        return $this->errors[$attribute][0] ?? false;
    }





}