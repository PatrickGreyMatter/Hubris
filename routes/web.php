<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/profil', [App\Http\Controllers\ProfilController::class, 'index'])->name('profil');
Route::post('/profil/store', [App\Http\Controllers\MediaController::class, 'store'])->name('films.store');

