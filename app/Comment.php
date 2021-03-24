<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    public $timestamps = false;

    protected $primaryKey = 'comment_ID';
    protected $table = 'wp_comments';

    
}
