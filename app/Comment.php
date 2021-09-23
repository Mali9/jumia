<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $connection = 'mysql_new';

    public $timestamps = false;

    protected $primaryKey = 'comment_ID';
    protected $table = 'wp_comments';

    public $appends = ['image', 'app_image'];

    public function getImageAttribute()
    {
        $email = $this->comment_author_email;

        $s = 80;
        $d = 'mp';
        $r = 'g';
        $url = 'https://www.gravatar.com/avatar/';
        $url .= md5(strtolower(trim($email)));
        $url .= "?s=$s&d=$d&r=$r";
        return $url;
    }

    public function getAppImageAttribute()
    {
        return $this->user->image ?? '';
    }

    public function replies()
    {
        return $this->hasMany(Comment::class, 'comment_parent');
    }
    public function scopePublish()
    {
        return $this->where(['comment_approved' => 1, 'comment_type' => 'comment']);
    }

    public function like_counter()
    {
        return $this->hasOne(WpLikeDislikeCounters::class, 'post_id', 'comment_ID')
            ->where('ul_key', 'c_like')->select('post_id', 'ul_value');
    }

    public function dislike_counter()
    {
        return $this->hasOne(WpLikeDislikeCounters::class, 'post_id', 'comment_ID')->where('ul_key', 'c_dislike')->select('post_id', 'ul_value');
    }

    /**
     * Get the user that owns the Comment
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
