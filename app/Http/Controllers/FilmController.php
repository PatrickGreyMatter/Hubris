<?php

namespace App\Http\Controllers;

use App\Models\Media;
use Illuminate\Http\Request;

class FilmController extends Controller
{
    public function show($slug)
    {
        $film = Media::where('slug', $slug)->firstOrFail();
        return view('welcome', compact('film'));
    }
}
