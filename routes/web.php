<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\User\Auth\LoginController as UserLoginController;
use App\Http\Controllers\User\Auth\RegisterController as UserRegisterController;
use App\Http\Controllers\User\UserDashboardController;
use App\Http\Controllers\User\ResolutionController;
use App\Http\Controllers\User\FeedbackController;
use App\Http\Controllers\User\ProfileController as UserProfileController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Officer\OfficerController;
use App\Http\Controllers\Auth\OfficerForgotPasswordController;
use App\Http\Controllers\Auth\OfficerResetPasswordController;
use App\Http\Controllers\Auth\UserResetPasswordController;
use App\Http\Controllers\Auth\UserForgotPasswordController;

/*
|--------------------------------------------------------------------------
| Welcome Page
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| USER ROUTES (Custom Guard: user)
|--------------------------------------------------------------------------
*/
Route::prefix('user')->name('user.')->group(function () {

    // Authentication
    Route::get('/login', [UserLoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [UserLoginController::class, 'login'])->name('login.attempt');
    Route::post('/logout', [UserLoginController::class, 'logout'])->name('logout');

    // Forgot & Reset Password
    Route::get('forgot-password', [UserForgotPasswordController::class, 'showForgotPasswordForm'])
        ->name('forgot.password');
    Route::post('forgot-password', [UserForgotPasswordController::class, 'sendResetLink'])
        ->name('forgot.password.send');
    Route::get('reset-password', [UserForgotPasswordController::class, 'showResetForm'])
        ->name('reset.password.form');
    Route::post('reset-password', [UserForgotPasswordController::class, 'resetPassword'])
        ->name('reset.password.submit');

    // Registration
    Route::get('/register', [UserRegisterController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [UserRegisterController::class, 'register'])->name('register.store');

    // Dashboard
    Route::get('/dashboard', [UserDashboardController::class, 'index'])
        ->middleware('auth:user')
        ->name('dashboard');

    // Authenticated-only routes
    Route::middleware('auth:user')->group(function () {
        // Resolutions
        Route::resource('resolutions', ResolutionController::class);

        // Feedback
        Route::get('/feedback', [FeedbackController::class, 'index'])->name('feedback.index');
        Route::get('/feedback/create', [FeedbackController::class, 'create'])->name('feedback.create');
        Route::post('/feedback', [FeedbackController::class, 'store'])->name('feedback.store');
        Route::delete('/feedback/{id}', [FeedbackController::class, 'destroy'])->name('feedback.destroy');

        // Profile
        Route::get('/profile', [UserProfileController::class, 'show'])->name('profile.show');
        Route::get('/profile/edit', [UserProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [UserProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [UserProfileController::class, 'destroy'])->name('profile.destroy');
    });
});

/*
|--------------------------------------------------------------------------
| DEFAULT LARAVEL BREEZE ROUTES (auth:web)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| ADMIN FORGOT / RESET PASSWORD ROUTES
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/forgot-password', [ForgotPasswordController::class, 'showForgotPasswordForm'])->name('forgot.password');
    Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLink'])->name('forgot.password.send');
    Route::get('/reset-password', [ResetPasswordController::class, 'showResetPasswordForm'])->name('reset.password');
    Route::post('/reset-password', [ResetPasswordController::class, 'resetPassword'])->name('reset.password.update');
});

/*
|--------------------------------------------------------------------------
| OFFICER FORGOT / RESET PASSWORD ROUTES
|--------------------------------------------------------------------------
*/
Route::prefix('officer')->name('officer.')->group(function () {
    Route::get('/forgot-password', [OfficerForgotPasswordController::class, 'showForgotPasswordForm'])->name('forgot.password');
    Route::post('/forgot-password', [OfficerForgotPasswordController::class, 'sendResetLink'])->name('forgot.password.send');
    Route::get('/reset-password/{token}', [OfficerForgotPasswordController::class, 'showResetForm'])->name('reset.password');
    Route::post('/reset-password', [OfficerForgotPasswordController::class, 'resetPassword'])->name('reset.password.submit');
});

/*
|--------------------------------------------------------------------------
| CAPTCHA REFRESH ROUTE
|--------------------------------------------------------------------------
*/
Route::get('/reload-captcha', function () {
    return response()->json(['captcha' => captcha_img('flat')]);
});

/*
|--------------------------------------------------------------------------
| EXTRA ROUTES
|--------------------------------------------------------------------------
*/
require __DIR__ . '/auth.php';
require __DIR__ . '/admin.php';
