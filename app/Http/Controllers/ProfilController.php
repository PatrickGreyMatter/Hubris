<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RoleRequest;
use App\Models\FilmSubmission;
use App\Models\Tag;
use App\Models\Director;
use Illuminate\Support\Facades\Auth;

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
    
        return view('profil', [
            'roleRequests' => $roleRequests,
            'filmSubmissions' => $filmSubmissions,
            'tags' => $tags,
            'directors' => $directors,
        ]);
    }
    
}
