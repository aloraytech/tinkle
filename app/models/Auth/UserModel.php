<?php

namespace tinkle\app\models;

use tinkle\framework\Model;

class UserModel extends Model
{


     public function tableName(): string
     {
            return "users";
     }


    public function labels(): array
    {
        // TODO: Implement labels() method.
    }


    public function attributes(): array
    {
        // TODO: Implement attributes() method.
    }


    public function primaryKey(): string
    {
        // TODO: Implement primaryKey() method.
    }
}
