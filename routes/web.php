<?php
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//FUNDAVICA
Route::group(['prefix' => '/'], function() {

    Route::get('/', 'FundavicaController@home');

    Route::get('posts/{page}', 'FundavicaController@post');

    Route::post('posts/index/search', 'FundavicaController@search');

    Route::get('gallery', 'FundavicaController@album');

    Route::get('contact', 'FundavicaController@contact');

    Route::post('contact', 'FundavicaController@opinion');

    Route::get('donations', 'FundavicaController@donations');

    Route::post('donations', 'DonationController@add');

    Route::get('404', 'FundavicaController@notFoundPost');
});

Auth::routes();

Route::get('post/manage', 'PostController@manage')->middleware('isAdmin');

Route::get('post/manage/writer', 'PostController@writer')->middleware('isWriter');

Route::get('user/manage', 'UserController@manage')->middleware('isAdmin');

Route::get('donation/manage', 'DonationController@manage')->middleware('isAdmin');

Route::get('account/manage', 'AccountController@manage')->middleware('isAdmin');

Route::group(['prefix' => 'user'], function() {

    Route::get('profile', 'UserController@profile')->middleware('auth');

    Route::get('edit', 'UserController@edit')->middleware('auth');

    Route::post('edit', 'UpdateEmailController@update')->middleware('auth');

    Route::get('update/email/{email}/{token}', 'UpdateEmailController@validateEmail');

    Route::post('update/password', 'Auth\ResetPasswordController@requestReset');

    Route::get('update/password/{token}', 'Auth\ResetPasswordController@resetView');

    Route::post('password/reset', 'Auth\ResetPasswordController@resetPassword');

    Route::get('admin/{id}', 'UserController@admin')->middleware('isAdmin');

    Route::get('writer/{id}', 'UserController@writer')->middleware('isAdmin');

    Route::get('normal/{id}', 'UserController@normal')->middleware('isAdmin');

    Route::get('delete', 'UserController@delete')->middleware('auth');
});


Route::group(['prefix' => 'account'], function() {
    
    Route::post('new', 'AccountController@add')->middleware('isAdmin'); 

    Route::get('hide/{id}', 'AccountController@hide')->middleware('isAdmin');

    Route::get('show/{id}', 'AccountController@show')->middleware('isAdmin');

    Route::get('delete/{id}', 'AccountController@delete')->middleware('isAdmin');
});

Route::group(['prefix' => 'post'], function(){

    Route::get('{id}', 'PostController@post')->where('id', '[0-9]+')->middleware('IsPost');

    Route::get('new', 'PostController@add')->middleware('can:create,App\Post');

    Route::post('new', 'PostController@added')->middleware('can:create,App\Post');

    Route::get('edit/{post}', 'PostController@edit')->where('post', '[0-9]+')->middleware('auth');

    Route::post('edit/{post}', 'PostController@edited')->where('post', '[0-9]+')->middleware('can:update,post');

    Route::get('hide/{id}', 'PostController@hide')->where('id', '[0-9]+')->middleware('can:hide,App\Post');

    Route::get('show/{id}', 'PostController@show')->where('id', '[0-9]+')->middleware('can:show,App\Post');

    Route::get('delete/{post}', 'PostController@delete')->where('post', '[0-9]+')->middleware('can:delete,post');

});

Route::group(['prefix' => 'comment'], function() {
    
    Route::post('new/{post}', 'PostController@comment')->where('post', '[0-9]+')->middleware('auth');

    Route::post('edit/{post}/{comment}', 'PostController@editComment')
        ->where([
            'post' => '[0-9]+',
            'comment' => '[0-9]+'
        ])
        ->middleware('can:update,comment');

    Route::get('hide/{post}/{comment}', 'PostController@hideComment')
        ->where([
            'post' => '[0-9]+',
            'comment' => '[0-9]+'
        ])
        ->middleware('isAdmin');

    Route::get('show/{post}/{comment}', 'PostController@showComment')
        ->where([
            'post' => '[0-9]+',
            'comment' => '[0-9]+'
        ])
        ->middleware('isAdmin');

    Route::get('delete/{post}/{comment}', 'PostController@deleteComment')
        ->where([
            'post' => '[0-9]+',
            'comment' => '[0-9]+'
        ])
        ->middleware('can:delete,post,comment');
});

Route::group(['prefix' => 'donations'], function() {

    Route::get('validate/{id}', 'DonationController@valid')->middleware('isAdmin');

    Route::get('reject/{id}', 'DonationController@reject')->middleware('isAdmin');

    Route::get('delete/{id}', 'DonationController@delete')->middleware('isAdmin');
});
