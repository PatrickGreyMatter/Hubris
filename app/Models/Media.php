<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'slug', 'description', 'type', 'director_id', 'length', 'year', 'thumbnail', 'video_url', 'average_rating'
    ];

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'media_tags');
    }

    public function director()
    {
        return $this->belongsTo(Director::class);
    }

    public function userLibraries()
    {
        return $this->hasMany(UserLibrary::class, 'media_id', 'id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class)->whereNull('parent_id');
    }
}
