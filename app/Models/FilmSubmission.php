<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FilmSubmission extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'description', 'length', 'year', 'thumbnail', 'video_url', 'status', 'user_id', 'director_id'
    ];

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'film_submission_tag', 'film_submission_id', 'tag_id');
    }

    public function director()
    {
        return $this->belongsTo(Director::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}


