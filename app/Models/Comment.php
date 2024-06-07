<?php

// app/Models/Comment.php

// app/Models/Comment.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = ['user_id', 'media_id', 'parent_id', 'content', 'vote_count'];

    public function replies()
    {
        return $this->hasMany(Comment::class, 'parent_id');
    }

    public function media()
    {
        return $this->belongsTo(Media::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function children()
{
    return $this->hasMany(Comment::class, 'parent_id');
}
}

