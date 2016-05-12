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

    //Route::get('sphere/data', 'Admin\sphereController@data');
    Route::get('sphere/index', ['as' => 'admin.sphere.index', 'uses' => 'Admin\SphereController@index']);
    Route::get('sphere/create', ['as' => 'admin.sphere.create', 'uses' => 'Admin\SphereController@create']);
    Route::get('sphere/{id}/edit', ['as' => 'admin.sphere.edit', 'uses' => 'Admin\SphereController@edit']);
    Route::any('sphere/{id}/update', ['as' => 'admin.sphere.update', 'uses' => 'Admin\SphereController@update']);
    Route::get('sphere/form/{id}/conf', ['as' => 'admin.attr.form', 'uses' => 'Admin\SphereController@get_config']);
    //Route::post('sphere/form/conf', ['as'=>'admin.chrct.form', 'uses'=> 'Admin\SphereController@save_config']);
    Route::get('sphere/{id}/delete', ['as' => 'admin.sphere.delete', 'uses' => 'Admin\SphereController@destroy']);
    //Route::resource('sphere', 'Admin\SphereController');

});
?>