<?php

use Illuminate\Support\Facades\Route;
use Liamtseva\PGFKEduSystem\Http\Controllers\DashboardController;

Route::view('/', 'welcome');

Route::get('dashboard', [DashboardController::class, 'index'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';
