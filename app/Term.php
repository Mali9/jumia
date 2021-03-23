<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Term extends Model
{
    public $timestamps = false;
    protected $primaryKey = 'term_id';

    protected $table = 'wp_terms';
    /**
     * Get all of the comments for the Term
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function type()
    {
        return $this->belongsTo(Taxonomy::class, 'term_id');
    }
}
