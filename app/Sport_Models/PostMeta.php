<?php

namespace App\Sport_Models;

use Illuminate\Database\Eloquent\Model;

class PostMeta extends Model
{
    public $timestamps = false;
    protected $connection = 'mysql_sport';

    protected $primaryKey = 'meta_id';
    protected $table = 'spwp_postmeta';
}
