<?php

use Illuminate\Support\Facades\Route;

// Auth Controller
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return view('pages.index');
})->name('index');

// Guest
Route::middleware('guest')->group(function () {
    // Auth
    Route::get('/login', [AuthController::class, 'login_view'])->name('login_view');
    Route::post('/login', [AuthController::class, 'login_attempt'])->name('login_attempt');
});

// Protected
Route::middleware('auth')->group(function () {
    // Auth
    Route::post('logout', [AuthController::class, 'logout_attempt'])->name('logout_attempt');

    // Dashboard
    Route::prefix('dashboard')->name('dashboard.')->group(function () {
        // Admin
        Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
            Route::get('/', fn () => 'Hello this is admin dashboard page!')->name('index');
        });

        // Teacher
        Route::middleware('role:teacher')->prefix('teacher')->name('teacher.')->group(function () {
            Route::get('/', fn () => 'Hello this is teacher dashboard page!')->name('index');
        });
    });
});
