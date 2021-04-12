<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use Notifiable, HasApiTokens;

    protected $hidden = ['password', 'remember_token', 'type'];
    protected $fillable = [

        'device_token'
    ];

    protected $connection = 'mysql';
    public function AauthAcessToken()
    {
        return $this->hasMany('\App\OauthAccessToken');
    }
}
