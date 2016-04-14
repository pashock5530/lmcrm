<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CharacteristicOptions extends Model
{
    protected $table = 'characteristic_options';

    protected $fillable = ['characteristic_id', 'name','value', 'icon','position' ];

    public function characteristic() {
        return $this->belongsTo('App\Models\CharacteristicOptions','id','characteristic_id');
    }
}