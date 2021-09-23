<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserLikeDislike extends Model
{
    public $timestamps = false;
    protected $table = 'user_likes_dislikes';
}
