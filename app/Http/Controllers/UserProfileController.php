<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Media;
use Illuminate\Http\Request;

class UserProfileController extends Controller
{
    public function show($id)
    {
        $user = User::findOrFail($id);
        $favoriteFilms = Media::whereHas('userLibraries', function($query) use ($id) {
            $query->where('user_id', $id)->where('status', 1);
        })->get();

        return view('watch-profil', compact('user', 'favoriteFilms'));
    }
}
