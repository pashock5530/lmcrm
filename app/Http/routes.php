<?php

Route::group(['prefix' => LaravelLocalization::setLocale(),'middleware' => [ 'localeSessionRedirect', 'localizationRedirect' ]], function() {
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
    Route::group(['middleware' => 'guest'], function () {
        Route::get('/auth/register', ['as' => 'registration.form', 'uses' => 'RegistrationController@create']);
        Route::post('/auth/register', ['as' => 'registration.store', 'uses' => 'RegistrationController@store']);
    });
# Forgotten Password
    Route::group(['middleware' => 'guest'], function () {
        Route::get('forgot_password', 'Auth\PasswordController@getEmail');
        Route::post('forgot_password', 'Auth\PasswordController@postEmail');
        Route::get('reset_password/{token}', 'Auth\PasswordController@getReset');
        Route::post('reset_password/{token}', 'Auth\PasswordController@postReset');
    });
    /*
    # Standard User Routes
    Route::group(['middleware' => ['auth','standardUser']], function()
    {
        Route::get('userProtected', 'StandardUser\StandardUserController@getUserProtected');
        Route::resource('profiles', 'StandardUser\UsersController', ['only' => ['show', 'edit', 'update']]);
    });
    */
});
/***************    Admin routes  **********************************/
Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'admin'] ], function() {

    # Admin Dashboard
    Route::get('dashboard', 'Admin\DashboardController@index');
/*

    # Article category
    Route::get('articlecategory/data', 'Admin\ArticleCategoriesController@data');
    Route::get('articlecategory/{articlecategory}/show', 'Admin\ArticleCategoriesController@show');
    Route::get('articlecategory/{articlecategory}/edit', 'Admin\ArticleCategoriesController@edit');
    Route::get('articlecategory/{articlecategory}/delete', 'Admin\ArticleCategoriesController@delete');
    Route::get('articlecategory/reorder', 'ArticleCategoriesController@getReorder');
    Route::resource('articlecategory', 'Admin\ArticleCategoriesController');

    # Articles
    Route::get('article/data', 'Admin\ArticleController@data');
    Route::get('article/{article}/show', 'Admin\ArticleController@show');
    Route::get('article/{article}/edit', 'Admin\ArticleController@edit');
    Route::get('article/{article}/delete', 'Admin\ArticleController@delete');
    Route::get('article/reorder', 'Admin\ArticleController@getReorder');
    Route::resource('article', 'Admin\ArticleController');

*/
    # Users
    Route::get('/', 'Admin\UserController@index');
    Route::get('user/data', 'Admin\UserController@data');
    Route::get('user/{user}/show', 'Admin\UserController@show');
    Route::get('user/{user}/edit', 'Admin\UserController@edit');
    Route::get('user/{user}/delete', 'Admin\UserController@delete');
    Route::resource('user', 'Admin\UserController');

    Route::get('characteristics/data', 'Admin\CharacteristicsController@data');
    Route::get('characteristics/form/{id}/conf', ['as'=>'admin.chrct.form', 'uses'=> 'Admin\CharacteristicsController@get_config']);
    //Route::post('characteristics/form/conf', ['as'=>'admin.chrct.form', 'uses'=> 'Admin\CharacteristicsController@save_config']);
    Route::get('characteristics/{id}/delete', ['as'=>'admin.characteristics.delete', 'uses'=> 'Admin\CharacteristicsController@destroy']);
    Route::resource('characteristics','Admin\CharacteristicsController');
});
