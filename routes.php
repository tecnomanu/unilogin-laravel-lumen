<?php
use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => config('unilogin.api_base_path'),
    'namespace' => 'Tecnomanu\UniLogin\Http\Controllers'
], function (){

    Route::post('unilogin', 'MagicLinkController@send');

    Route::group(['middleware' => 'unilogin.polling'], function () {
        Route::get('unilogin/polling', 'SessionController@handlePolling');
    });

    Route::group(['middleware' => 'unilogin.callback'], function(){
        Route::get('unilogin/callback', 'CallbackController@handleCallback');
    });

    Route::get('unilogin/error', 'CallbackController@errorLogin');
    Route::get('unilogin/invalid-session', 'CallbackController@invalidSession');
    
    Route::group(['middleware' => 'unilogin.accept'], function(){
        Route::get('unilogin/success', 'CallbackController@successLogin');
    });
});

