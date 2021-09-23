<?php

namespace App\Sport_Models;

use Illuminate\Database\Eloquent\Model;
use DB;
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
            ->where('comment_approved', 1)

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
            'image/jpg',
            'image/gif',
            'image/png',
            'image/bmp',
            'image/tiff',
            'image/x-icon'
        );
            if ($this->post_type == 'attachment') {

            return $this
                ->where('post_parent', $this->ID)
                ->where('post_type', 'attachment')
                ->whereIn('post_mime_type', $image_mime_types)
                ->first()->guid ?? '';
        } else {

            $post_id =  DB::connection('mysql_sport')->table('spwp_postmeta')
                ->where('post_id', $this->ID)
                ->where('meta_key', '_thumbnail_id')
                ->first()
                ->meta_value ?? '';


            return $this
                ->where('ID', $post_id)
                ->first()->guid ?? '';
        }
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
