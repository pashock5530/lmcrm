<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeadPhone extends Model {

    protected $table="lead_phone";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'phone'
    ];


    public function lead(){
        return $this->hasMany('App\Models\Lead','phone_id', 'id');
    }
}
