<?php

use Illuminate\Http\Request;

// Publicaciones
Route::get('/posts', 'Api\PostController@get');
Route::get('/posts/{id}', 'Api\PostController@read');
Route::post('/posts', 'Api\PostController@create');

// Comentarios
Route::get('/posts/{post}/comments', 'Api\CommentController@get');
Route::get('/posts/{post}/comments/{comment}', 'Api\CommentController@read');
Route::post('/posts/{post}/comments/{response?}', 'Api\CommentController@create');

// Usuarios
Route::post('/users', 'Api\UserController@create');
Route::post('/users/login', 'Api\UserController@login');
