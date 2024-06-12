<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RoleRequest;
use App\Models\FilmSubmission;
use App\Models\Tag;
use App\Models\Director;
use App\Models\Media;
use App\Models\User;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfilController extends Controller
{
    public function index()
    {
        $roleRequests = [];
        $filmSubmissions = [];
        $tags = Tag::all();
        $directors = Director::all();

        if (Auth::user()->role == 'admin') {
            $roleRequests = RoleRequest::all();
            $filmSubmissions = FilmSubmission::all();
        }

        // Fetch user's favorite films
        $userId = Auth::id();
        $favoriteFilms = Media::whereHas('userLibraries', function($query) use ($userId) {
            $query->where('user_id', $userId)->where('status', 1);
        })->get();

        return view('profil', [
            'roleRequests' => $roleRequests,
            'filmSubmissions' => $filmSubmissions,
            'tags' => $tags,
            'directors' => $directors,
            'favoriteFilms' => $favoriteFilms,
        ]);
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'public_description' => 'nullable|string',
        ]);

        $user->name = $request->input('name');
        $user->public_description = $request->input('public_description');

        if ($request->hasFile('profile_picture')) {
            // Delete old profile picture if it exists
            if ($user->profile_picture) {
                Storage::delete('public/' . $user->profile_picture);
            }

            // Store new profile picture
            $path = $request->file('profile_picture')->store('profile_pictures', 'public');
            $user->profile_picture = $path;
        }

        $user->save(); // Ensure that this method is correct and the user is correctly imported

        return redirect()->route('profile')->with('status', 'Profil mis à jour avec succès!');
    }

    public function watch($id)
    {
        $user = User::findOrFail($id);
        $favoriteFilms = Media::whereHas('userLibraries', function($query) use ($id) {
            $query->where('user_id', $id)->where('status', 1);
        })->get();
        $userComments = Comment::where('user_id', $id)->with('media')->get();

        return view('watch-profil', [
            'user' => $user,
            'favoriteFilms' => $favoriteFilms,
            'userComments' => $userComments,
        ]);
    }
}
