<?php

namespace App\Models\Auth;

use Tinkle\Database\Access\Traits\Authenticate;
use Tinkle\interfaces\AuthGuardInterface;
use Tinkle\Model;

/**
 * Class Users
 * @package tinkle\app\models
 * @author : krishanu.info@gmail.com
 * @version : 1.0
 */

class Users extends Model implements AuthGuardInterface
{
    use Authenticate;

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

    public function rules(): array
    {
        return [
            'email'=> 'required|min:6|max:25|email',
            'password'=> 'required|min:6|max:35|password',
            'passwordConfirm' => 'required|min:6|max:35|password|same:password',
        ];
    }


    public function setCredential(): array
    {
        return ['email','password','passwordConfirm',];
    }
}