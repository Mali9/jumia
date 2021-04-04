<?php

namespace App\Sport_Models;

use Illuminate\Database\Eloquent\Model;

class Taxonomy extends Model
{
    public $timestamps = false;
    protected $primaryKey = 'term_taxonomy_id';
    protected $connection = 'mysql_sport';

    protected $table = 'spwp_term_taxonomy';

    /**
     * Get all of the comments for the Taxonomy
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
}
