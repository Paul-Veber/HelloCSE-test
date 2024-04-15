<?php

use App\Http\Controllers\AdminProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [AdminProfileController::class, 'edit'])
        ->name('profile.edit');
    Route::patch('/profile', [AdminProfileController::class, 'update'])
        ->name('profile.update');
    Route::delete('/profile', [AdminProfileController::class, 'destroy'])
        ->name('profile.destroy');
});

Route::prefix('profile')->group(function () {
    Route::get('create', function () {
        return Inertia::render('Profile/Create');
    })->middleware('auth')
        ->name('profile.create');
    Route::get('update/{id}', function (int $id) {
        return Inertia::render('Profile/Update', ['id' => $id]);
    })->name('profile.update');
});

require __DIR__ . '/auth.php';
require __DIR__ . '/api/profile.php';
