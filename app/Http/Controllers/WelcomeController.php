<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Media;
use App\Http\Controllers\CarouselController;

class WelcomeController extends Controller
{
    // Method to display the homepage
    public function home()
    {
        $carouselController = new CarouselController();
        
        // Fetch different categories of films
        $americanfilms = $carouselController->getFilmsByTag('Americain');
        $horrorFilms = $carouselController->getFilmsByTag('Horreur');
        $dramaFilms = $carouselController->getFilmsByTag('Drama');
        $thrillerFilms = $carouselController->getFilmsByTag('Thriller');
        $comedyFilms = $carouselController->getFilmsByTag('Comedie');
        $frenchFilms = $carouselController->getFilmsByTag('Francais');
        $sfFilms = $carouselController->getFilmsByTag('SF');

        // Fetch latest films
        $latestFilms = $carouselController->getFilmsByDate('desc');
        
        // Pass the films to the view
        return view('welcome', compact('americanfilms', 'horrorFilms', 'dramaFilms', 'sfFilms', 'frenchFilms', 'thrillerFilms', 'comedyFilms', 'latestFilms'));
    }
}
