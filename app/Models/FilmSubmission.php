<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FilmSubmission extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'description', 'tags', 'length', 'year', 'thumbnail', 'video_url', 'status', 'user_id', 'director_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function director()
    {
        return $this->belongsTo(Director::class);
    }
}

