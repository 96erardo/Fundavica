<?php

use Illuminate\Http\Request;

// Publicaciones
Route::get('/posts', 'Api\PostController@get');
Route::get('/posts/{id}', 'Api\PostController@read');
Route::post('/posts', 'Api\PostController@create');

// Comentarios
Route::get('/posts/{post}/comments', 'Api\CommentController@get');
Route::post('/posts/{post}/comments/{response?}', 'Api\CommentController@create');
Route::get('/posts/{post}/comments/{comment}', 'Api\CommentController@read');
Route::put('/posts/{post}/comments/{comment}', 'Api\CommentController@update');
Route::delete('/posts/{post}/comments/{comment}', 'Api\CommentController@delete');

// Usuarios
Route::get('/users', 'Api\UserController@get');
Route::post('/users', 'Api\UserController@create');
Route::get('/users/{id}', 'Api\UserController@read');
Route::put('/users/{id}', 'Api\UserController@update');
Route::delete('/users/{id}', 'Api\UserController@delete');
Route::post('/users/login', 'Api\UserController@login');
