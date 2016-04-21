<?php
Route::group(['prefix' => 'admin'], function() {
    Route::get('characteristics/data', 'Admin\CharacteristicsController@data');
});
//
Route::group(['prefix' => LaravelLocalization::setLocale(),'middleware' => [ 'web','localeSessionRedirect','localizationRedirect', 'localize' ]], function() {
    include_once('routes/front.routes.php');

    include_once('routes/admin.routes.php');
});