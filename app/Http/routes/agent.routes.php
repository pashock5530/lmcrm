<?php

Route::group(['prefix' => 'agent', /*'middleware' => ['auth', 'agent']*/ ], function() {
    Route::get('/', ['as' => 'agent.index', 'uses' => 'Agent\AgentController@index']);

    Route::get('lead', ['as' => 'agent.lead.index', 'uses' => 'Agent\LeadController@index']);
    Route::get('lead/create', ['as' => 'agent.lead.create', 'uses' => 'Agent\LeadController@create']);
    Route::post('lead/store',['as'=>'agent.lead.store', 'uses' => 'Agent\LeadController@store']);
    #Route::get('lead/{id}/edit',['as'=>'agent.lead.edit', 'uses' => 'Agent\LeadController@edit']);
    #Route::match(['put','post'],'lead/{id}',['as'=>'agent.lead.update', 'uses' => 'Agent\LeadController@update']);
    //Route::resource('lead','Agent\LeadController@create');
});
?>