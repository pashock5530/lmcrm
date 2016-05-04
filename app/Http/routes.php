<?php
Route::group(['prefix' => 'admin'], function() {
    Route::get('characteristics/data', 'Admin\CharacteristicsController@data');
    Route::get('agent/data', 'Admin\AgentController@data');
    Route::get('user/data', 'Admin\UserController@data');
});
//
Route::group(['prefix' => LaravelLocalization::setLocale(),'middleware' => [ 'web','localeSessionRedirect','localizationRedirect', 'localize' ]], function() {
    include('routes/front.routes.php');

    include('routes/admin.routes.php');
});