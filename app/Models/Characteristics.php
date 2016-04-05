<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Characteristics extends Model
{
    protected $table = 'characteristics';
    protected $fillable = ['_type', 'label','requiered', 'position' ];

    public function options() {
        return $this->hasMany('App\Models\CharacteristicOptions','characteristic_id','id');
    }

    public function group() {
        return $this->belongsTo('App\Models\CharacteristicGroup','id','group_id');
    }
}