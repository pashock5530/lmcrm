<?php

Route::group(['prefix' => 'agent', 'middleware' => ['auth', 'agent'] ], function() {
    Route::get('/lead', ['as' => 'agent.lead.create', 'uses' => 'Agent\LeadController@create']);

});
?>