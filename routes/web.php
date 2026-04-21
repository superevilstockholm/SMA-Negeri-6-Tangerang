<?php

use Illuminate\Support\Facades\Route;

// Auth Controller
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return view('pages.index');
})->name('index');

Route::get('/about', function () {
    return view('pages.about');
})->name('about');

Route::get('teacher-and-staff', function () {
    return view('pages.teacher-and-staff');
})->name('teacher-and-staff');

Route::get('extracurricular', function () {
    return view('pages.extracurricular');
})->name('extracurricular');

Route::get('contact-us', function () {
    return view('pages.contact-us');
})->name('contact-us');

// Guest
Route::middleware('guest')->group(function () {
    // Auth
    Route::get('/login', [AuthController::class, 'login_view'])->name('login_view');
    Route::post('/login', [AuthController::class, 'login_attempt'])->name('login_attempt');
});

// Protected
Route::middleware('auth')->group(function () {
    // Auth
    Route::post('/logout', [AuthController::class, 'logout_attempt'])->name('logout_attempt');

    // Dashboard
    Route::prefix('/dashboard')->name('dashboard.')->group(function () {
        // Admin
        Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
            Route::get('/', function () {
                return view('pages.dashboard.admin.index', ['meta' => ['sidebarItems' => adminSidebarItems()]]);
            })->name('index');
        });

        // Teacher
        Route::middleware('role:teacher')->prefix('teacher')->name('teacher.')->group(function () {
            Route::get('/', function () {
                return view('pages.dashboard.teacher.index', ['meta' => ['sidebarItems' => teacherSidebarItems()]]);
            })->name('index');
        });
    });
});
