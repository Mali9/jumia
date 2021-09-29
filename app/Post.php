<?php

namespace App;

use App\Sport_Models\User;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $connection = 'mysql_new';

    public $timestamps = false;

    protected $primaryKey = 'ID';
    protected $table = 'wp_posts';

    protected $appends = ['views', 'featured_image','ago'];



    /**
     * Get the user associated with the Post
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function view()
    {
        return $this->hasOne(PostMeta::class, 'post_id')->where('meta_key', 'views');
    }

    // public function comments_closed()
    // {
    //     return $this->hasOne(PostMeta::class, 'post_id')->where('meta_key', 'comments_closed');
    // }


    /**
     * Get all of the comments for the Post
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments()
    {
        return $this->hasMany(Comment::class, 'comment_post_ID')
            ->where('comment_parent', 0)
            ->where('comment_approved', 1)
            ->with('like_counter')
            ->with('dislike_counter')
            ->withCount('replies');
    }

    /**
     * Get the like_counter a
     * the Post
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */


    public function getViewsAttribute()
    {
        return $this->view->meta_value ?? '';
    }
    public function getCommentsClosedAttribute()
    {
        return $this->comments_closed->meta_value ?? '';
    }

    public function getFeaturedImageAttribute()
    {
        $image_mime_types = array(
            'image/jpeg',
            'image/jpg',
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
        return $this->belongsTo(NewsUser::class, 'post_author', 'ID');
    }
    public function getAgoAttribute()
    {
        \Carbon\Carbon::setLocale('ar');
        return \Carbon\Carbon::createFromTimeStamp(strtotime($this->post_date))->diffForHumans();
    }
}
