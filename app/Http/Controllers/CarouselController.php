<?php

namespace App\Http\Controllers;

use App\Models\Media;
use Illuminate\Http\Request;

class CarouselController extends Controller
{
    public function getFilmsByTag($tagName)
    {
        $films = Media::whereHas('tags', function($query) use ($tagName) {
            $query->where('name', $tagName);
        })->get();

        return $films;
    }

    public function getFilmsByTags(array $tagNames)
    {
        $films = Media::whereHas('tags', function($query) use ($tagNames) {
            $query->whereIn('name', $tagNames);
        })->get();

        return $films;
    }

    public function getFilmsByDirector($directorName)
    {
        $films = Media::whereHas('director', function($query) use ($directorName) {
            $query->where('name', $directorName);
        })->get();

        return $films;
    }

    public function getFilmsByDate($order = 'desc')
    {
        $films = Media::orderBy('created_at', $order)->get();

        return $films;
    }
}
