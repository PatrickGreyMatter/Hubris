<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\RoleRequestController;
use App\Http\Controllers\FilmSubmissionController;
use Illuminate\Support\Facades\Auth;

// Authentication routes
Route::middleware(['web'])->group(function () {
    Auth::routes();
    Route::get('/', [WelcomeController::class, 'home'])->name('home');
    Route::get('/profil', [ProfilController::class, 'index'])->name('profil');
    Route::post('/films/store', [MediaController::class, 'store'])->name('films.store');
    Route::post('/role-request', [RoleRequestController::class, 'store'])->name('role.request');
    Route::put('/role-approve/{id}', [RoleRequestController::class, 'approve'])->name('role.approve');
    Route::put('/films-approve/{id}', [FilmSubmissionController::class, 'approve'])->name('films.approve');
});
