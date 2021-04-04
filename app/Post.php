<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $connection = 'mysql_new';

    public $timestamps = false;

    protected $primaryKey = 'ID';
    protected $table = 'wp_posts';

    protected $appends = ['views'];



    /**
     * Get the user associated with the Post
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function view()
    {
        return $this->hasOne(PostMeta::class, 'post_id')->where('meta_key', 'views');
    }


    /**
     * Get all of the comments for the Post
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments()
    {
        return $this->hasMany(Comment::class, 'comment_post_ID');
    }


    public function getViewsAttribute()
    {
        return $this->view->meta_value ?? '';
    }
}
