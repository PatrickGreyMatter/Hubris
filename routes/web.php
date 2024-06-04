<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\FilmSubmissionController;
use App\Http\Controllers\RoleRequestController;
use App\Http\Controllers\FilmSubmissionManagementController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;


Route::middleware(['web'])->group(function () {
    Auth::routes();
    Route::get('/', [WelcomeController::class, 'home'])->name('home');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/profil', [ProfilController::class, 'index'])->name('profil');
    Route::post('/films/store', [FilmSubmissionController::class, 'store'])->name('films.store');
    Route::post('/role-request', [RoleRequestController::class, 'store'])->name('role.request');
});

Route::middleware(['auth', 'admin', 'verified'])->group(function () {
    Route::put('/role-approve/{id}', [RoleRequestController::class, 'approve'])->name('role.approve');
    Route::put('/films-approve/{id}', [FilmSubmissionManagementController::class, 'approve'])->name('films.approve');
    Route::put('/films/{id}/update', [FilmSubmissionManagementController::class, 'update'])->name('films.update');
});

Route::middleware(['auth', 'contributor', 'verified'])->group(function () {
    // Add contributor-specific routes here
});

Route::middleware(['auth', 'user', 'verified'])->group(function () {
    // Add user-specific routes here
});






Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
 
    return redirect('/profil');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
 
    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');