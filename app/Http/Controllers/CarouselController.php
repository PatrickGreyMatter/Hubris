<?php

namespace App\Http\Controllers;

use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


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

    public function getFilmsByDate($order = 'desc', $limit = null)
    {
        $query = Media::orderBy('created_at', $order);

        if ($limit) {
            $query->take($limit);
        }

        $films = $query->get();

        return $films;
    }

    public function getFavoriteFilms()
    {
        $userId = Auth::id();
        $favoriteFilms = Media::whereHas('userLibraries', function($query) use ($userId) {
            $query->where('user_id', $userId)->where('status', 1);
        })->get();

        return $favoriteFilms;
    }

}
