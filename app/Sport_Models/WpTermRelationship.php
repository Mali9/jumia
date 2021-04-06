<?php

namespace App\Sport_Models;

use Illuminate\Database\Eloquent\Model;

class WpTermRelationship extends Model
{
    protected $connection = 'mysql_sport';

    public $timestamps = false;
    protected $table = 'spwp_term_relationships';


    /**
     * Get the post that owns the WpTermRelationship
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function post()
    {
        return $this->belongsTo(Post::class, 'object_id')
            ->select('ID', 'post_date', 'post_content', 'post_title', 'post_name');
    }
}
