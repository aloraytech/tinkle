<?php

namespace App\Models;

use Tinkle\interfaces\ModelInterface;
use Tinkle\Model;
use Tinkle\Tinkle;
use Tinkle\UserHandler;

class UsersModel extends UserHandler implements ModelInterface
{

    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_DELETED = 2;

    public int $id = 0;
    public string $username = '';
    public string $image = '';
    public string $email = '';
    public int $status = self::STATUS_INACTIVE;
    public string $password = '';
    public string $passwordConfirm = '';

     public function tableName(): string
     {
            return "users";
     }


    public function labels(): array
    {
        return [
            'username' => 'First name',
            'email' => 'Email Address',
            'password' => 'Password',
            'passwordConfirm' => 'Password Confirm',
            'image' => 'Profile Picture',
        ];
    }


    public function attributes(): array
    {
        return ['username', 'email', 'password', 'image'];
    }


    public function primaryKey(): string
    {
        return 'id';
    }


    public function getDisplayName(): string
    {
        return $this->username;
    }



    public function register()
    {
        return $this->save();
    }

    public function rules()
    {
        return [
            'username' => [self::RULE_REQUIRED],
            'email' => [self::RULE_REQUIRED, self::RULE_EMAIL, [
                self::RULE_UNIQUE, 'class' => self::class
            ]],
            'password' => [self::RULE_REQUIRED, [self::RULE_MIN, 'min' => 8]],
            'passwordConfirm' => [[self::RULE_MATCH, 'match' => 'password']],
        ];
    }

    public function save()
    {
        $this->password = password_hash($this->password, PASSWORD_DEFAULT);

        return parent::save();
    }

    public function login()
    {

        $user = Model::findOne(['email' => $this->email]);
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
