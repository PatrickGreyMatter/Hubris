<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Media;

class WelcomeController extends Controller
{
    // Method to display the homepage
    public function home()
    {
        // Fetch all films from the Media model
        $films = Media::all(); 
        // Pass the films to the view
        return view('welcome', compact('films'));
    }
}
