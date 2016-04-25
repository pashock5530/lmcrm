<?php

/***************    Site routes  **********************************/
Route::get('/', ['as' => 'home', 'uses' => 'Frontend\HomeController@index']);
Route::get('home', 'Frontend\HomeController@index');
/*
Route::get('about', 'PagesController@about');
Route::get('contact', 'PagesController@contact');
Route::get('articles', 'ArticlesController@index');
Route::get('article/{slug}', 'ArticlesController@show');
Route::get('video/{id}', 'VideoController@show');
Route::get('photo/{id}', 'PhotoController@show');
*/
# Authentication
Route::get('/auth/login', ['as' => 'login', 'middleware' => 'guest', 'uses' => 'Auth\SessionsController@create']);
Route::get('/auth/logout', ['as' => 'logout', 'uses' => 'Auth\SessionsController@destroy']);
Route::any('/auth/store', ['as' => 'auth.store', 'uses' => 'Auth\SessionsController@store']);
Route::any('/auth/create', ['as' => 'auth.create', 'uses' => 'Auth\SessionsController@create']);
Route::any('/auth/destroy', ['as' => 'auth.destroy', 'uses' => 'Auth\SessionsController@destroy']);
//Route::resource('/auth', 'Auth\SessionsController', ['only' => ['create', 'store', 'destroy']]);

# Registration
/*
Route::group(['middleware' => 'guest'], function () {
    Route::get('/auth/register', ['as' => 'registration.form', 'uses' => 'RegistrationController@create']);
    Route::post('/auth/register', ['as' => 'registration.store', 'uses' => 'RegistrationController@store']);
});
*/
# Forgotten Password
/*
Route::group(['middleware' => 'guest'], function () {
    Route::get('forgot_password', 'Auth\PasswordController@getEmail');
    Route::post('forgot_password', 'Auth\PasswordController@postEmail');
    Route::get('reset_password/{token}', 'Auth\PasswordController@getReset');
    Route::post('reset_password/{token}', 'Auth\PasswordController@postReset');
});
*/
/*
# Standard User Routes
Route::group(['middleware' => ['auth','standardUser']], function()
{
    Route::get('userProtected', 'StandardUser\StandardUserController@getUserProtected');
    Route::resource('profiles', 'StandardUser\UsersController', ['only' => ['show', 'edit', 'update']]);
});
*/

?>