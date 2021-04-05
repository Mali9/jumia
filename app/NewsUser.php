<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class NewsUser extends Authenticatable
{
    use Notifiable, HasApiTokens;
    protected $connection = 'mysql_new';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $timestamps = false;

    protected $primaryKey = 'ID';
    protected $table = 'wp_users';
    protected $fillable = [
        'ID', 'user_email', 'user_pass'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'user_pass',
    ];
    public function AauthAcessToken()
    {
        return $this->hasMany('\App\OauthAccessToken');
    }
}
