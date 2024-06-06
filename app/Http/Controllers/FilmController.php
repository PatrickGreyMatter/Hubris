<?php

namespace App\Http\Controllers;

use App\Models\Media;
use Illuminate\Http\Request;

class FilmController extends Controller
{
    public function show($slug)
    {
        $film = Media::with(['comments' => function ($query) {
            $query->whereNull('parent_id')->with('replies');
        }])->where('slug', $slug)->firstOrFail();
        
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

    public function destroy($id)
    {
        $film = Media::findOrFail($id);

        // Ensure paths are relative to the public directory
        $thumbnailPath = public_path('presentations/images/' . basename($film->thumbnail));
        $videoUrlPath = public_path('presentations/medias/' . basename($film->video_url));

        // Delete the associated files
        if (file_exists($thumbnailPath)) {
            unlink($thumbnailPath);
        }

        if (file_exists($videoUrlPath)) {
            unlink($videoUrlPath);
        }

        // Delete the film from the database
        $film->delete();

        return redirect()->route('home')->with('success', 'Film deleted successfully.');
    }
}



