<?php

return [
    /*
    |--------------------------------------------------------------------------
    | UniLogin Configuration
    |--------------------------------------------------------------------------
    |
    | This file is for configuring your UniLogin package.
    | You can set your configurations here.
    |
    */

    'secret' => env('UNILOGIN_SECRET', ''), // Secrete to create tokens
    'token_lifetime' => env('UNILOGIN_TOKEN_LIFETIME', 900), // Lifetime of the magic link token in seconds (900 = 15min)
    'callback_url' => env('UNILOGIN_CALLBACK_URL', ''), // URL where the application should redirect after a successful login
    'api_base_path' => env('UNILOGIN_API_BASE_PATH', ''), // Base path of api login routes
];
