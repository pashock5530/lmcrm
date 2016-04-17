<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CharacteristicLead extends Model
{
    protected $table = 'characteristic_lead';
    protected $fillable = ['_type', 'label','required', 'position' ];

    public function options() {
        return $this->hasMany('App\Models\CharacteristicOptions','characteristic_id','id')->where('ctype','=','lead')->orderBy('position');
    }

    public function group() {
        return $this->belongsTo('App\Models\CharacteristicGroup','id','group_id');
    }

}