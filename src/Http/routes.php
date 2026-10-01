<?php

use Illuminate\Support\Facades\Route;

Route::group([
    'namespace' => 'Chadvangaalen\Seat\Cavalry\Http\Controllers',
    'prefix' => 'cavalry',
    'middleware' => ['web', 'auth', 'can:cavalry.view'],
], function () {
    Route::get('/', [
        'as' => 'cavalry::overview',
        'uses' => 'CavalryController@index',
    ]);

    Route::get('/corporation/{corporation}', [
        'as' => 'cavalry::corporation',
        'uses' => 'CavalryController@show',
    ]);
});
