<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Hash Driver
    |--------------------------------------------------------------------------
    |
    | Here you may specify which hashing driver you want to use for your
    | application. By default, bcrypt is used.
    |
    */

    'driver' => 'bcrypt',

    /*
    |--------------------------------------------------------------------------
    | Bcrypt Options
    |--------------------------------------------------------------------------
    |
    | These options will be passed to the bcrypt hashing function when
    | hashing passwords.
    |
    */

    'bcrypt' => [
        'rounds' => 10,
    ],

];
