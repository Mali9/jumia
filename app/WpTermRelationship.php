<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WpTermRelationship extends Model
{
    public $timestamps = false;
    protected $table = 'wp_term_relationships';
    protected $connection = 'mysql_new';


    /**
     * Get the post that owns the WpTermRelationship
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function post()
    {
        return $this->belongsTo(Post::class, 'object_id')

            ->select('ID', 'post_author', 'post_date', 'post_content', 'post_title', 'post_name')
            ->with('author')
            ->with('comments');
    }
}
