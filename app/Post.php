<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    public $timestamps = false;

    protected $primaryKey = 'ID';
    protected $table = 'wp_posts';
}
