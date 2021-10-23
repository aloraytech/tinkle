<?php

namespace App\Provider;


use Tinkle\Library\Auth\AuthService;

class AuthProvider extends AuthService
{

    /**
     * @return array
     * Why Use?
     * Set up a guard system which protect your users as many types from different model or tables
     * How To ? return ['users','admins','clients'];
     */
    public function setGuards(): array
    {
        return ['web','admins'];
    }

    /**
     * @return array
     * Why Use ?
     * Provide required model for your guards
     * How To ? return [
     *              'users'=>'App\Models\Auth\Users',
     *              'admins'=> 'App\Models\Admin\Admins',
     *          ];
     */
    public function setGuardModel(): array
    {
        return [
            'web'=>'App\Models\Auth\Users',
            'admins'=> 'App\Models\Admin\Admins',
        ];
    }

    /**
     * @return int
     * Why Use ?
     * Set how long auth token live for take part any next action
     * How To ? return 60;
     */
    public function setExpire(): int
    {
        return 60;
    }

    /**
     * @return int
     * Password Confirmation Timeout
     * define the amount of seconds before a password confirmation
     * times out and the user is prompted to re-enter their password via the
     * confirmation screen. By default, the timeout lasts for three hours.
     */
    public function setTimeout(): int
    {
        return 10800;
    }
}