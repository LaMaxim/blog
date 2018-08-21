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

    Route::get('/', 'HomeController@index')->name('home');
    Route::get('/post/view/{post}', 'PostController@show')->name('post.show');

    Route::group(['middleware' => 'auth'], function () {
        Route::post('/post', 'PostController@store')->name('post.store');
        Route::get('/post/create', 'PostController@create')->name('post.create');
        Route::put('/post/{post}', 'PostController@update')->name('post.update');
        Route::get('/post/edit/{post}', 'PostController@edit')->name('post.edit');
        Route::delete('/post/{post}', 'PostController@destroy')->name('post.destroy');
        Route::post('/post/create-comment', 'PostController@createComment');
        Route::post('/post/edit-comment', 'PostController@editComment');
        Route::delete('/post/delete-comment/{id}', 'PostController@deleteComment');
    });

    Auth::routes();


