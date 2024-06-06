<?php

namespace App\Http\Controllers;

use App\Models\Media;
use Illuminate\Http\Request;

class FilmController extends Controller
{
    public function show($slug)
    {
        $film = Media::where('slug', $slug)->firstOrFail();
        return view('film', compact('film'));
    }

    public function getFilmsByTag($tagName)
    {
        $films = Media::whereHas('tags', function($query) use ($tagName) {
            $query->where('name', $tagName);
        })->get();
        $query = $tagName;

        return view('searchedFilms', compact('films', 'query'));
    }
}
