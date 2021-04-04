<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WpLikeDislikeCounters extends Model
{
    public $timestamps = false;
    protected $table = 'wp_like_dislike_counters';
    protected $connection = 'mysql_new';

}
