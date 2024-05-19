<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'slug', 'description', 'type', 'director_id', 'length', 'year', 'thumbnail', 'video_url'
    ];

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'media_tags');
    }

    public function director()
    {
        return $this->belongsTo(Director::class);
    }
}