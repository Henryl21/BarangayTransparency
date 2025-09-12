<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExpenditureController;
use App\Http\Controllers\User\ResolutionController;
use App\Http\Controllers\User\Auth\LoginController as UserLoginController;
use App\Http\Controllers\User\Auth\RegisterController as UserRegisterController;
use App\Http\Controllers\User\UserDashboardController;
use App\Http\Controllers\Admin\AdminDashboardController;

// Welcome page
Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| USER ROUTES
|--------------------------------------------------------------------------
*/
Route::prefix('user')->name('user.')->group(function () {
    // Login Routes
    Route::get('/login', [UserLoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [UserLoginController::class, 'login']);
    Route::post('/logout', [UserLoginController::class, 'logout'])->name('logout');

    // Register Routes
    Route::get('/register', [UserRegisterController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [UserRegisterController::class, 'register']);

    // Dashboard
    Route::get('/dashboard', [UserDashboardController::class, 'index'])
    ->middleware('auth:user') // 👈 must use user guard
    ->name('dashboard');

    // User-specific routes (requires login)
    Route::middleware('auth')->group(function () {
        Route::resource('resolutions', ResolutionController::class);
    });
});



/*
|--------------------------------------------------------------------------
| PROFILE ROUTES (for normal authenticated users)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| EXTRA ROUTE FILES
|--------------------------------------------------------------------------
*/
require __DIR__ . '/auth.php';
require __DIR__ . '/admin.php';
require __DIR__ . '/user.php';
