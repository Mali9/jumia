<?php

namespace App\Sport_Models;

use Illuminate\Database\Eloquent\Model;

class WpLikeDislikeCounters extends Model
{
    protected $connection = 'mysql_sport';

    public $timestamps = false;
    protected $table = 'spwp_like_dislike_counters';
}
