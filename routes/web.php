<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\MediaController;
use Illuminate\Support\Facades\Auth;

// Authentication routes
Auth::routes();

// Route for the home page pointing to WelcomeController
Route::get('/', [WelcomeController::class, 'home']);

// Route for the profile page
Route::get('/profil', [ProfilController::class, 'index'])->name('profil');

// Route for storing films (media)
Route::post('/profil/store', [MediaController::class, 'store'])->name('films.store');



