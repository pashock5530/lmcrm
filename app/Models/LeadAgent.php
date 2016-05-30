<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeadAgent extends Model {

    protected $table="lead_agent";


    public function lead(){
        return $this->hasMany('App\Models\Lead','id', 'lead_id');
    }

    public function agent(){
        return $this->hasMany('App\Models\Agent','id', 'agent_id');
    }

}
