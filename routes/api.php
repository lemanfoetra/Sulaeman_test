<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::prefix('users')->group(function () {
    Route::get('/', 'API\UserController@users');
    Route::post('/signup', 'API\UserController@signup');
    Route::post('/sigin', 'API\UserController@sigin');
});


Route::prefix('shopping')->group(function () {
    Route::get('/', 'API\ShoppingController@index');
    Route::get('/{id}', 'API\ShoppingController@product');
    Route::post('/', 'API\ShoppingController@submit');
    Route::post('/{id}', 'API\ShoppingController@update');
    Route::delete('/{id}', 'API\ShoppingController@delete');
});