<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CharacteristicOptions extends Model
{
    protected $table = 'characteristic_options';

    protected $fillable = ['characteristic_id','ctype','_type', 'name','value', 'icon','position' ];

    public function characteristic() {
        return $this->belongsTo('App\Models\Characteristics','id','characteristic_id');
    }

    public function leadAttr() {
        return $this->belongsTo('App\Models\CharacteristicLead','id','characteristic_id');
    }
}