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

Route::get('posts', 'Api\PostController@get');
Route::post('posts', 'Api\PostController@create');
Route::get('posts/{id}', 'Api\PostController@read');

Route::post('/users', 'Api\UserController@create');
Route::post('/users/login', 'Api\UserController@login');