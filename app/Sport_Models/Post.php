<?php

namespace App\Sport_Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    public $timestamps = false;
    protected $connection = 'mysql_sport';

    protected $primaryKey = 'ID';
    protected $table = 'spwp_posts';

    protected $appends = ['views', 'featured_image'];



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
        return $this->hasMany(Comment::class, 'comment_post_ID')
            ->where('comment_parent', 0)
            ->with('like_counter')
            ->with('dislike_counter')
            ->withCount('replies');
    }



    public function getViewsAttribute()
    {
        return $this->view->meta_value ?? '';
    }

    public function getFeaturedImageAttribute()
    {
        $image_mime_types = array(
            'image/jpeg',
            'image/gif',
            'image/png',
            'image/bmp',
            'image/tiff',
            'image/x-icon'
        );
        return $this
            ->where('post_parent', $this->ID)
            ->where('post_type', 'attachment')
            ->whereIn('post_mime_type', $image_mime_types)
            ->first()->guid ?? '';
    }

    public function scopePublish()
    {
        return $this->where(['post_status' => 'publish', 'post_type' => 'post']);
    }
    public function author()
    {
        return $this->belongsTo(User::class, 'post_author', 'ID')->select(['ID', 'display_name']);
    }
}
