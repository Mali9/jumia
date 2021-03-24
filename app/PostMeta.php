<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PostMeta extends Model
{
    public $timestamps = false;

    protected $primaryKey = 'meta_id';
    protected $table = 'wp_postmeta';
}
