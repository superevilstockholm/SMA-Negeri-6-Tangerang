<?php

use Illuminate\Support\Facades\Route;

// Auth Controller
use App\Http\Controllers\AuthController;

// Master Data Controllers
use App\Http\Controllers\MasterData\VisionController;
use App\Http\Controllers\MasterData\MissionController;
use App\Http\Controllers\MasterData\ContactController;
use App\Http\Controllers\MasterData\SchoolHistoryController;

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

Route::get('contact-us', [ContactController::class, 'contactUsView'])->name('contact-us-view');
Route::post('contact-us', [ContactController::class, 'contactUsAttempt'])->middleware('turnstile')->name('contact-us-attempt');

// Guest
Route::middleware('guest')->group(function () {
    // Auth
    Route::get('/login', [AuthController::class, 'loginView'])->name('login-view');
    Route::post('/login', [AuthController::class, 'loginAttempt'])->middleware('turnstile')->name('login-attempt');
});

// Protected
Route::middleware('auth')->group(function () {
    // Auth
    Route::post('/logout', [AuthController::class, 'logoutAttempt'])->name('logout-attempt');

    // Dashboard
    Route::prefix('/dashboard')->name('dashboard.')->group(function () {
        // Admin
        Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
            Route::get('/', function () {
                return view('pages.dashboard.admin.index', ['meta' => ['sidebarItems' => adminSidebarItems()]]);
            })->name('index');
            // Master Data
            Route::prefix('master-data')->name('master-data.')->group(function () {
                Route::resource('visions', VisionController::class)->parameters([
                    'visions' => 'vision',
                ]);
                Route::resource('missions', MissionController::class)->parameters([
                    'missions' => 'mission',
                ]);
                Route::resource('school-histories', SchoolHistoryController::class)->parameters([
                    'school-histories' => 'schoolHistory',
                ]);
                Route::resource('contacts', ContactController::class)->parameters([
                    'contacts' => 'contact',
                ])->only(['index', 'show', 'destroy']);
            });
        });

        // Teacher
        Route::middleware('role:teacher')->prefix('teacher')->name('teacher.')->group(function () {
            Route::get('/', function () {
                return view('pages.dashboard.teacher.index', ['meta' => ['sidebarItems' => teacherSidebarItems()]]);
            })->name('index');
        });
    });
});
