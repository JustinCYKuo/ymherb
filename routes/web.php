<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HerbhomeController;

Route::get('/', function () {
    return view('auth.login');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::resource('/herbhome', HerbhomeController::class)->names('herbhome');
    // Route::get('/herbhome', function () {
    //     return view('dashboard');
    // })->name('dashboard');
});

// Route::resource('/herbhome', HerbhomeController::class)->names('herbhome');