<?php

namespace App\Sport_Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    public $timestamps = false;
    protected $connection = 'mysql_sport';

    protected $primaryKey = 'ID';
    protected $table = 'spwp_posts';

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

    public function scopePublish()
    {
        return $this->where(['post_status' => 'publish', 'post_type' => 'post']);
    }
}
