<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Taxonomy extends Model
{
    public $timestamps = false;
    protected $primaryKey = 'term_taxonomy_id';

    protected $table = 'wp_term_taxonomy';
}
