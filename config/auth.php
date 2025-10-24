<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Authentication Defaults
    |--------------------------------------------------------------------------
    */
    'defaults' => [
        // 👇 Default guard is still 'web' (admin panel or generic pages)
        // But you can switch to 'user' if your site is user-first.
        'guard' => env('AUTH_GUARD', 'web'),
        'passwords' => env('AUTH_PASSWORD_BROKER', 'users'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Authentication Guards
    |--------------------------------------------------------------------------
    */
    'guards' => [
        // 🔹 Default Laravel web guard (generic pages)
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],

        // 🔹 Frontend / Resident user guard
        'user' => [
            'driver' => 'session',
            'provider' => 'users', // ✅ still uses 'users' provider
        ],

        // 🔹 Admin guard
        'admin' => [
            'driver' => 'session',
            'provider' => 'admins',
        ],

        // 🔹 Officer guard
        'officer' => [
            'driver' => 'session',
            'provider' => 'officers',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | User Providers
    |--------------------------------------------------------------------------
    */
    'providers' => [
        // 👤 User provider (Residents or App Users)
        'users' => [
            'driver' => 'eloquent',
            'model' => App\Models\User::class,
        ],

        // 👨‍💼 Admin provider
        'admins' => [
            'driver' => 'eloquent',
            'model' => App\Models\Admin::class,
        ],

        // 🧑‍💼 Officer provider
        'officers' => [
            'driver' => 'eloquent',
            'model' => App\Models\OfficerUser::class,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Resetting Passwords
    |--------------------------------------------------------------------------
    */
    'passwords' => [
        'users' => [
            'provider' => 'users',
            'table' => 'password_resets',
            'expire' => 60,
            'throttle' => 60,
        ],

        'admins' => [
            'provider' => 'admins',
            'table' => 'password_resets',
            'expire' => 60,
            'throttle' => 60,
        ],

        'officers' => [
            'provider' => 'officers',
            'table' => 'officer_password_reset_tokens',
            'expire' => 60,
            'throttle' => 60,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Password Confirmation Timeout
    |--------------------------------------------------------------------------
    */
    'password_timeout' => 10800,

];
