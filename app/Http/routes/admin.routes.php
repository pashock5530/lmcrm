<?php

/***************    Admin routes  **********************************/
Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'admin'] ], function() {
# Admin Dashboard
    Route::get('dashboard', ['as' => 'admin.index', 'uses' => 'Admin\DashboardController@index']);
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
    Route::get('/', ['as' => 'admin.user.index', 'uses' => 'Admin\UserController@index']);
    //Route::resource('/','Admin\UserController');
    Route::get('user/data', 'Admin\UserController@data');

    Route::get('user/create',['as'=>'admin.user.create', 'uses' => 'Admin\UserController@create']);
    Route::get('user/{id}/edit',['as'=>'admin.user.edit', 'uses' => 'Admin\UserController@edit']);
    Route::get('user/{id}/delete', ['as'=>'admin.user.delete', 'uses' => 'Admin\UserController@delete']);
    //Route::resource('user', 'Admin\UserController');

    Route::get('agent', ['as' => 'admin.agent.index', 'uses' => 'Admin\AgentController@index']);
    Route::get('agent/data', 'Admin\AgentController@data');
    Route::get('agent/create',['as'=>'admin.agent.create', 'uses' => 'Admin\AgentController@create']);
    Route::post('agent/store',['as'=>'admin.agent.store', 'uses' => 'Admin\AgentController@store']);
    Route::get('agent/{id}/edit',['as'=>'admin.agent.edit', 'uses' => 'Admin\AgentController@edit']);
    Route::match(['put','post'],'agent/{id}',['as'=>'admin.agent.update', 'uses' => 'Admin\AgentController@update']);
    Route::get('agent/{id}/destroy', ['as'=>'admin.agent.delete', 'uses' => 'Admin\AgentController@destroy']);
    //Route::resource('agent', 'Admin\AgentController');

//Route::get('characteristics/data', 'Admin\CharacteristicsController@data');
    Route::get('characteristics/index', ['as' => 'admin.characteristics.index', 'uses' => 'Admin\CharacteristicsController@index']);
    Route::get('characteristics/create', ['as' => 'admin.characteristics.create', 'uses' => 'Admin\CharacteristicsController@create']);
    Route::get('characteristics/{id}/edit', ['as' => 'admin.characteristics.edit', 'uses' => 'Admin\CharacteristicsController@edit']);
    Route::any('characteristics/{id}/update', ['as' => 'admin.characteristics.update', 'uses' => 'Admin\CharacteristicsController@update']);
    Route::get('characteristics/form/{id}/conf', ['as' => 'admin.chrct.form', 'uses' => 'Admin\CharacteristicsController@get_config']);
//Route::post('characteristics/form/conf', ['as'=>'admin.chrct.form', 'uses'=> 'Admin\CharacteristicsController@save_config']);
    Route::get('characteristics/{id}/delete', ['as' => 'admin.characteristics.delete', 'uses' => 'Admin\CharacteristicsController@destroy']);
    //Route::resource('characteristics', 'Admin\CharacteristicsController');

});
?>