<?php
use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => config('unilogin.api_base_path'),
    'namespace' => 'Tecnomanu\UniLogin\Http\Controllers'
], function (){
    Route::post('unilogin', 'UniLoginController@sendMagicLink');
    Route::get('unilogin/callback', 'UniLoginController@handleCallback');

    Route::group(['middleware' => 'unilogin.session'], function () {
        Route::get('unilogin/polling', 'UniLoginController@handlePolling');
    });
});

