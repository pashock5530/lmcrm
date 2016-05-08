<?php

Route::group(['prefix' => 'agent', /*'middleware' => ['auth', 'agent']*/ ], function() {
    Route::get('/', ['as' => 'agent.index', 'uses' => 'Agent\AgentController@index']);

    Route::get('lead', ['as' => 'agent.lead.index', 'uses' => 'Agent\LeadController@index']);
    Route::get('lead/create', ['as' => 'agent.lead.create', 'uses' => 'Agent\LeadController@create']);
    Route::post('lead/store',['as'=>'agent.lead.store', 'uses' => 'Agent\LeadController@store']);
    #Route::get('lead/{id}/edit',['as'=>'agent.lead.edit', 'uses' => 'Agent\LeadController@edit']);
    #Route::match(['put','post'],'lead/{id}',['as'=>'agent.lead.update', 'uses' => 'Agent\LeadController@update']);
    //Route::resource('lead','Agent\LeadController@create');

    Route::get('sphere', ['as' => 'agent.sphere.index', 'uses' => 'Agent\SphereController@index']);
    Route::get('sphere/create', ['as' => 'agent.sphere.create', 'uses' => 'Agent\SphereController@create']);
    Route::post('sphere/store',['as'=>'agent.sphere.store', 'uses' => 'Agent\SphereController@store']);
    Route::get('sphere/{id}/edit',['as'=>'agent.sphere.edit', 'uses' => 'Agent\SphereController@edit']);
    Route::match(['put','post'],'sphere/{id}',['as'=>'agent.sphere.update', 'uses' => 'Agent\SphereController@update']);
    //Route::resource('customer/filter','Agent\CustomerFilterController@create');
});
?>