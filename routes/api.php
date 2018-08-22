<?php

use Illuminate\Http\Request;

// Publicaciones
Route::get('/posts', 'Api\PostController@get');
Route::post('/posts', 'Api\PostController@create');
Route::get('/posts/{id}', 'Api\PostController@read');
Route::put('/posts/{id}', 'Api\PostController@update');
Route::delete('/posts/{id}', 'Api\PostController@delete');

// Comentarios
Route::get('/posts/{post}/comments', 'Api\CommentController@get');
Route::get('/posts/{post}/comment/{comment}', 'Api\CommentController@read');
Route::get('/posts/{post}/comments/{comment}', 'Api\CommentController@responses');
Route::post('/posts/{post}/comments/{response?}', 'Api\CommentController@create');
Route::put('/posts/{post}/comments/{comment}', 'Api\CommentController@update');
Route::delete('/posts/{post}/comments/{comment}', 'Api\CommentController@delete');

// Usuarios
Route::get('/users', 'Api\UserController@get');
Route::post('/users', 'Api\UserController@create');
Route::get('/users/{id}', 'Api\UserController@read');
Route::put('/users/{id}', 'Api\UserController@update');
Route::delete('/users/{id}', 'Api\UserController@delete');
Route::post('/users/login', 'Api\UserController@login');
Route::post('/users/logout', 'Api\UserController@logout');
