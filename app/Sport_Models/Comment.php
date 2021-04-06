<?php

namespace App\Sport_Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    public $timestamps = false;
    protected $connection = 'mysql_sport';

    protected $primaryKey = 'comment_ID';
    protected $table = 'spwp_comments';

    public function replies()
    {
        return $this->hasMany(Comment::class, 'comment_parent');
    }
    public function scopePublish()
    {
        return $this->where(['comment_approved' => 1, 'comment_type' => 'comment']);
    }
}
