<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\FilmSubmissionController;
use App\Http\Controllers\RoleRequestController;
use App\Http\Controllers\FilmSubmissionManagementController;
use Illuminate\Support\Facades\Auth;

// Routes accessibles par tous (invités et utilisateurs authentifiés)
Route::middleware(['web'])->group(function () {
    Auth::routes();
    Route::get('/', [WelcomeController::class, 'home'])->name('home');
});

// Routes accessibles uniquement par les utilisateurs authentifiés
Route::middleware(['auth'])->group(function () {
    Route::get('/profil', [ProfilController::class, 'index'])->name('profil');
    Route::post('/films/store', [FilmSubmissionController::class, 'store'])->name('films.store');
    Route::post('/role-request', [RoleRequestController::class, 'store'])->name('role.request');
});

// Routes accessibles uniquement par les administrateurs
Route::middleware(['auth', 'admin'])->group(function () {
    Route::put('/role-approve/{id}', [RoleRequestController::class, 'approve'])->name('role.approve');
    Route::put('/films-approve/{id}', [FilmSubmissionManagementController::class, 'approve'])->name('films.approve');
    Route::put('/films/{id}/update', [FilmSubmissionManagementController::class, 'update'])->name('films.update');
});

// Routes accessibles uniquement par les contributeurs
Route::middleware(['auth', 'contributor'])->group(function () {
    // Ajoutez ici les routes spécifiques aux contributeurs
});

// Routes accessibles uniquement par les utilisateurs simples
Route::middleware(['auth', 'user'])->group(function () {
    // Ajoutez ici les routes spécifiques aux utilisateurs simples
});

