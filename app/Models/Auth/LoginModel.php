<?php

namespace App\Models\Auth;

use tinkle\app\models\UsersModel;
use Tinkle\Model;
use Tinkle\Tinkle;

class LoginModel extends Model
{
    public string $email = '';
    public string $password = '';

     public function tableName(): string
     {
            return "users";
     }


    public function labels(): array
    {
        return [
            'email' => 'Your Email address',
            'password' => 'Password'
        ];
    }


    public function attributes(): array
    {
        return ['email', 'password'];
    }


    public function primaryKey(): string
    {
        return 'id';
    }

    public function rules()
    {
        return [
            'email' => [self::RULE_REQUIRED],
            'password' => [self::RULE_REQUIRED],
        ];
    }

    public function login()
    {
        $user = UsersModel::findOne(['email' => $this->email]);
        if (!$user) {
            $this->addError('email', 'User does not exist with this email address');
            return false;
        }
        if (!password_verify($this->password, $user->password)) {
            $this->addError('password', 'Password is incorrect');
            return false;
        }

        return Tinkle::$app->login($user);
    }

}
