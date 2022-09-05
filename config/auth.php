<?php

return [


    'defaults' => [
        'guard' => 'web',
        'passwords' => 'users',
    ],



    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],

        'api' => [
            'driver' => 'token',
            'provider' => 'users',
            'hash' => false,
        ],

        // doctor guard
        'lawyer' => [
            'driver' => 'session',
            'provider' => 'lawyers',
        ],

        // legaloffices guard
        'legal' => [
            'driver' => 'session',
            'provider' => 'legaloffices',
        ],

        // admin guard
        'admin' => [
            'driver' => 'session',
            'provider' => 'admins',
        ],


    ],



    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => App\User::class,
        ],

        'admins' => [
            'driver' => 'eloquent',
            'model' => App\Admin::class,
        ],

        'lawyers' => [
            'driver' => 'eloquent',
            'model' => App\Lawyer::class,
        ],

        'legaloffices' => [
            'driver' => 'eloquent',
            'model' => App\Legaloffice::class,
        ],





        // 'users' => [
        //     'driver' => 'database',
        //     'table' => 'users',
        // ],
    ],


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
        'lawyers' => [
            'provider' => 'lawyers',
            'table' => 'password_resets',
            'expire' => 60,
            'throttle' => 60,
        ],

        'throttle' => 60,
    ],
    'legaloffices' => [
        'provider' => 'legaloffices',
        'table' => 'password_resets',
        'expire' => 60,
        'throttle' => 60,
    ],



    

    /*
    |--------------------------------------------------------------------------
    | Password Confirmation Timeout
    |--------------------------------------------------------------------------
    |
    | Here you may define the amount of seconds before a password confirmation
    | times out and the user is prompted to re-enter their password via the
    | confirmation screen. By default, the timeout lasts for three hours.
    |
    */

    'password_timeout' => 10800,

];
