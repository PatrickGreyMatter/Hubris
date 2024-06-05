<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserLibrary;
use App\Models\Media;
use Illuminate\Support\Facades\Auth;

class NotesAndFavoritesController extends Controller
{
    public function addToFavorites($media_id)
    {
        $user = Auth::user();
        $film = Media::find($media_id);

        // Check if the media is already in favorites
        $existingFavorite = UserLibrary::where('user_id', $user->id)->where('media_id', $media_id)->first();

        if (!$existingFavorite) {
            // Add to favorites
            UserLibrary::create([
                'user_id' => $user->id,
                'media_id' => $media_id,
                'status' => 1
            ]);

            $message = 'Vous avez bien ajouté le film : ' . $film->title . ' à votre librairie. Vous pouvez la consulter sur votre profil !';
        } else {
            $message = 'Le film : ' . $film->title . ' est déjà dans votre librairie.';
        }

        return redirect()->back()->with('success', $message);
    }
}
